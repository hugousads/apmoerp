# APMO ERP — Bug Report (v7)

- **Archive scanned:** `apmoerpv7.zip`
- **Baseline for comparison:** `apmoerpv6_bug_report_new.md`
- **Date:** 2026-01-13
- **Framework versions (composer.json):** Laravel `^12.0`, Livewire `^4.0.0-beta`, PHP `^8.2`
- **Scope:** Full code scan (App / Routes / Resources / Config). **Database + seeders ignored** as requested.

> This report contains **ONLY**:
> 1) **New bugs found in v7**, and
> 2) **Bugs that were already reported before but are still not fixed**.
> 
> Anything already fixed is intentionally omitted.

---

## Summary

- **Critical:** 6
- **High:** 10
- **Medium:** 3

---

## Unfixed bugs from previous report (still present)

### V7-CRITICAL-U01 — Branch isolation is disabled when there is no authenticated user
**File**: `app/Models/Scopes/BranchScope.php` (L88–L94)

**What’s wrong**
- The global branch scope returns early when there’s **no authenticated user**:
  - This means **no branch filter** is applied in jobs/queue workers/CLI contexts (and any request context without auth).

**Impact**
- **Cross-branch / cross-tenant data exposure** and “wrong branch” reads/writes in background tasks.

**Fix recommendation**
- Fail closed for non-console contexts (or require an explicit branch context).
- For jobs/queue: set a branch context explicitly (e.g., middleware that sets current branch/user), or enforce branch_id on job payload and apply a scope from that.

---

### V7-CRITICAL-U02 — Stock “source of truth” is inconsistent (products.stock_quantity vs stock_movements)
**Example file**: `app/Services/Dashboard/DashboardDataService.php` (L196–L224)

**What’s wrong**
- Dashboard low-stock uses `products.stock_quantity` directly.
- Core stock movement flows (sales/purchases/transfers) primarily record stock via `stock_movements` (and do **not** reliably keep `products.stock_quantity` in sync).

**Impact**
- Low-stock alerts, dashboards, and any logic that depends on `products.stock_quantity` can be **wrong**.
- ERP consistency issue: inventory numbers differ depending on which screen/endpoint you use.

**Fix recommendation**
- Choose **one** source of truth:
  - Either remove/stop using `products.stock_quantity` and always compute from movements, **or**
  - Maintain a consistent denormalized quantity (per warehouse and/or per branch) updated transactionally with every stock movement.

---

### V7-CRITICAL-U03 — Accounting journal entries can be unbalanced (shipping/discount/partials not handled consistently)
**Files**:
- `app/Services/AccountingService.php`
  - Sale JE: (L205–L277)
  - Purchase JE: (L280–L339)

**What’s wrong**
- **Sales**: revenue + tax + discount are posted, but **shipping_amount** is not represented.
- **Purchases**: debits are built from subtotal + tax, but credit uses `total_amount` (which can include shipping/discount), causing imbalance.

**Impact**
- **Wrong financial statements** (trial balance can drift).
- Downstream reports become unreliable.

**Fix recommendation**
- Include shipping/discount accounts consistently:
  - Sales: add a credit (shipping income) or debit (shipping expense) line depending on business rules.
  - Purchases: include discount/shipping lines so total debits == total credits.
- Also ensure these entries are validated before posting (see V7-CRITICAL-N01).

---

### V7-CRITICAL-U04 — Sale return mutates `paid_amount` without creating a refund/payment record
**File**: `app/Services/SaleService.php` (L65–L78)

**What’s wrong**
- On return, it does:
  - `$sale->paid_amount = bcsub($sale->paid_amount, $returnAmount, 2);`
  - without creating a corresponding **refund transaction** (SalePayment refund / ledger entry / cash movement).

**Impact**
- Audit trail is broken; cash/bank is not tracked.
- `paid_amount` can desync from actual payments (and from `SalePayment` records).

**Fix recommendation**
- Represent refunds as first-class records (e.g., `SalePayment` with negative amount or dedicated Refund model) and derive paid totals from those.

---

### V7-HIGH-U05 — External order ID is inconsistent across integrations (API uses reference_number; store sync uses external_reference)
**Files**:
- API lookup uses `reference_number`: `app/Http/Controllers/Api/V1/OrdersController.php` (L296–L306)
- Store sync writes `external_reference`: `app/Services/Store/StoreSyncService.php` (L337–L344)

**What’s wrong**
- Orders created by store sync may not be retrievable by the API “byExternalId” endpoint.
- Duplicate prevention/idempotency becomes unreliable (same external order can be created twice under different columns).

**Impact**
- Duplicate orders, broken sync, wrong financial totals.

**Fix recommendation**
- Standardize on **one** external ID field (or enforce a canonical mapping) and ensure all integration points read/write the same field.

---

### V7-HIGH-U06 — Stock movement “duplicate guard” is too coarse and can skip legitimate movements
**Files**:
- `app/Listeners/UpdateStockOnSale.php` (L42–L67)
- `app/Listeners/UpdateStockOnPurchase.php` (L41–L62)

**What’s wrong**
- Duplicate detection checks only `(reference_type, reference_id, product_id, quantity<0/ >0)`.
- If the same product appears multiple times (different units, partial processing, replays), valid movements can be skipped.

**Impact**
- Inventory becomes incorrect (missing movements).

**Fix recommendation**
- Add a true idempotency key per line item (e.g., `sale_item_id` / `purchase_item_id`) or store a unique UUID per movement.

---

### V7-HIGH-U07 — Voiding a sale doesn’t reverse stock and doesn’t reverse accounting
**File**: `app/Services/SaleService.php` (L153–L166)

**What’s wrong**
- `voidSale()` only flips status to `void` and doesn’t:
  - reverse stock movements
  - reverse journal entries
  - handle payments/refunds

**Impact**
- Inventory and accounting remain as if the sale happened.

**Fix recommendation**
- Implement a proper void workflow:
  - create reversing stock movements
  - reverse/void related journal entries
  - handle payment reversal/refund and audit logs

---

### V7-HIGH-U08 — Purchase payments are not recorded as payment entities (only mutates paid_amount)
**File**: `app/Services/PurchaseService.php` (L154–L181)

**What’s wrong**
- `payPurchase()` updates `paid_amount` and `payment_status` but does not create a `PurchasePayment` record.

**Impact**
- No audit trail; reports can’t reconcile payments; accounting integration is incomplete.

**Fix recommendation**
- Create a `PurchasePayment` record per payment and compute paid totals from payments.

---

### V7-HIGH-U09 — Orders API can attach a customer from another branch
**File**: `app/Http/Controllers/Api/V1/OrdersController.php` (L71–L90)

**What’s wrong**
- Validation allows: `customer_id => exists:customers,id` with **no branch constraint**.

**Impact**
- Cross-branch data mixing/leakage (order in branch A linked to customer in branch B).

**Fix recommendation**
- Validate customer branch:
  - `Rule::exists('customers','id')->where('branch_id',$branchId)` (for store branch), or enforce via scoped query.

---

### V7-MEDIUM-U10 — Line tax uses truncation, not rounding (financial compliance risk)
**File**: `app/Services/POSService.php` (L179–L187)

**What’s wrong**
- Tax is calculated then “rounded” using `bcdiv(x, '1', 2)` which **truncates** rather than rounding half-up.

**Impact**
- Systematic under-collection of tax by fractions; reconciliation issues.

**Fix recommendation**
- Implement a `bcround()` helper (half-up) and apply it at the required precision.

---

## New bugs found in v7

### V7-CRITICAL-N01 — Auto-generated journal entries are marked “posted” but bypass posting logic (balances not updated + no validation)
**File**: `app/Services/AccountingService.php`

**Where**
- Sale JE: `generateSaleJournalEntry()` (L205–L227)
- Purchase JE: `generatePurchaseJournalEntry()` (L280–L309)
- COGS JE: `recordCogsEntry()` (L604–L665)
- Generic `createEntry()` (L353–L417)

**What’s wrong**
- These methods create `JournalEntry` with `status = 'posted'` directly.
- They **do not** call `postJournalEntry()` which is the method that:
  - validates the entry is balanced
  - updates `Account.balance`
  - sets `posted_at`, `approved_by`, etc.

**Impact**
- Accounts can show wrong balances.
- “Posted” entries may be unbalanced and still treated as finalized.

**Fix recommendation**
- Create entries as `draft` via `createJournalEntry()` then call `postJournalEntry()`.
- Or extract a shared internal method to apply balance updates + validations before setting posted.

---

### V7-HIGH-N02 — `JournalEntry::is_auto_generated` accessor overrides the DB column and returns a wrong value
**File**: `app/Models/JournalEntry.php` (L123–L132)

**What’s wrong**
- There is a DB column `is_auto_generated`.
- But the accessor:
  - `getIsAutoGeneratedAttribute(): bool { return $this->type === 'auto'; }`
  overrides it.
- In v7, auto-generated entries are created with `is_auto_generated = true` but **type is not set**, so reading `$entry->is_auto_generated` becomes **false**.

**Impact**
- UI/business logic cannot reliably distinguish manual vs auto entries.
- Any permission/reversal logic keyed on `is_auto_generated` becomes incorrect.

**Fix recommendation**
- Remove the accessor, or make it:
  - `return (bool) ($this->attributes['is_auto_generated'] ?? false);`
  and keep `type` as a separate legacy field if needed.

---

### V7-CRITICAL-N03 — SalesReturn approval creates a credit note even for cash refunds (auto_apply always true)
**File**: `app/Services/SalesReturnService.php`

**Where**
- Approval logic: (L176–L190)
- Credit note creation: (L286–L320)

**What’s wrong**
- Condition:
  - `if ($return->refund_method !== 'cash' || $return->refund_amount > 0)`
  will be true for **most normal returns**, including cash refunds.
- Credit note is created with:
  - `status = 'approved'`
  - `auto_apply = true`

**Impact**
- Customer can receive **both** a cash refund path and a credit note.
- Ledger/customer balance can be overstated or duplicated.

**Fix recommendation**
- Only create a credit note when `refund_method === 'store_credit'` (or equivalent).
- For cash refunds: skip credit note and record only a refund transaction + accounting entry.

---

### V7-HIGH-N04 — Warehouse search scope can bypass branch isolation due to ungrouped OR
**File**: `app/Models/Warehouse.php` (L94–L98)

**What’s wrong**
- `scopeSearch()` builds:
  - `where(name like ...)` **OR** `where(code like ...)`
  without grouping.
- With the global branch scope, SQL becomes:
  - `(branch_id = X AND name like ...) OR code like ...`
  which can match warehouses from other branches.

**Impact**
- Cross-branch data leak via search.

**Fix recommendation**
- Group the OR conditions:
  - `->where(fn($q) => $q->where(...)->orWhere(...))`

---

### V7-HIGH-N05 — Orders API updateStatus computes payment_status from `paid_amount` instead of actual payments
**File**: `app/Http/Controllers/Api/V1/OrdersController.php` (L284–L290)

**What’s wrong**
- Payment status is derived from `paid_amount`, while the `Sale` model already supports payment records (`SalePayment`) and computed totals (`total_paid`, `remaining_amount`).

**Impact**
- Payment status can become wrong (especially if `paid_amount` is stale or manually edited).

**Fix recommendation**
- Use the computed amounts:
  - `$order->updatePaymentStatus()`
  - or derive from `$order->total_paid` and `$order->total_amount`.

---

### V7-HIGH-N06 — AR/AP aging reports use `paid_amount` fields and ignore payment records
**File**: `app/Services/FinancialReportService.php`

**Where**
- AR aging uses `paid_amount`: (L271–L314)
- AP aging uses `paid_amount`: (L330–L349)

**What’s wrong**
- Reports filter and compute outstanding by `paid_amount < total_amount`.
- If real payments are stored as rows (SalePayment / PurchasePayment), these reports can be wrong.

**Impact**
- Incorrect receivables/payables aging (high financial risk).

**Fix recommendation**
- Use computed totals from payment tables:
  - AR: `total_amount - total_paid`
  - AP: `total_amount - total_paid` (from PurchasePayment)

---

### V7-HIGH-N07 — StockMovement “stock_before/after” is not fully concurrency-safe
**Files**:
- `app/Repositories/StockMovementRepository.php` (L137–L152)
- `app/Services/StockService.php` (L145–L163)

**What’s wrong**
- Repository locks only the *latest row* then re-sums in a separate query.
- `StockService::adjustStock()` computes current stock without any locking.

**Impact**
- Under concurrent adjustments/sales/purchases, recorded `stock_before/stock_after` can be wrong.
- Inventory audit trail becomes unreliable.

**Fix recommendation**
- Use a single locked aggregation strategy (e.g., lock a per (product,warehouse) inventory row) or enforce serialization via database constraints/locking.
- Ensure all stock-changing operations go through one concurrency-safe code path.

---

### V7-MEDIUM-N08 — Bank account balance math uses floats on decimal-casted fields
**File**: `app/Services/BankingService.php` (L23–L34)

**What’s wrong**
- `current_balance` is a decimal-casted attribute.
- The code uses:
  - `$bankAccount->current_balance += $transaction->getSignedAmount();`
  which coerces strings/decimals into float and introduces precision loss.

**Impact**
- Bank balances can drift by cents over time.

**Fix recommendation**
- Use bcmath:
  - `$bankAccount->current_balance = (float) bcadd((string)$bankAccount->current_balance, (string)$signed, 4);`
  or keep values as strings and cast only at output.

---

### V7-MEDIUM-N09 — FinancialTransactionObserver exists but is not registered (and also references $model->code)
**Files**:
- Observer exists: `app/Observers/FinancialTransactionObserver.php` (L31–L75)
- Not registered in: `app/Providers/AppServiceProvider.php` (L66–L79)

**What’s wrong**
- If you intended automatic customer/supplier balance maintenance, it currently never runs.
- It also logs `$model->code`, while some models (e.g., `Sale`) may not have a `code` attribute — this can throw in local/dev when `preventAccessingMissingAttributes()` is enabled.

**Impact**
- Customer/Supplier balance features can be incorrect or non-functional.

**Fix recommendation**
- Register observers explicitly (Sale::observe / Purchase::observe).
- Replace `$model->code` with a guaranteed identifier (e.g., `reference_number` or `id`).

