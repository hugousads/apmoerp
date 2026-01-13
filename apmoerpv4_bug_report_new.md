# APMO ERP (v4) — New + Still-Unfixed Bug Report

**Scan target:** `apmoerpv4.zip` (extracted)  
**Scope:** Full project code review (focused on `/app`), **database + seeders ignored** as requested.  
**Compared against:** previous report `apmoerpv3_bug_report_new.md` (fixed items are intentionally not repeated here).

---

## Dependency snapshot (from composer.json)

- **Laravel:** `laravel/framework ^12.0`
- **Livewire:** `livewire/livewire ^4.0.0-beta` (range, not pinned to a specific beta)
- **Filament:** `filament/filament ^3.2`

> Note: `^4.0.0-beta` can float to newer betas; if you depend on exact Livewire beta behavior, consider pinning a specific beta tag to avoid surprise breaking changes.

---

## ✅ Still-unfixed from the previous report (v3)

These issues were present in the previous report and **still exist** in v4.

### STILL-UNFIXED-01 — External order ID field is inconsistent across entry points (duplicates / broken idempotency)

**Files**
- `app/Http/Controllers/Api/V1/OrdersController.php` (idempotency + lookup)
- `app/Services/Store/StoreSyncService.php` (Shopify/Woo/Laravel store sync idempotency)

**What’s happening**
- API orders controller stores and searches external id in **`sales.reference_number`** (see lines ~135–145 and ~291–296).
- Store sync service stores and searches external id in **`sales.external_reference`** (see lines ~317–321 and ~360–361).

**Why this is a bug**
- Same external order can be ingested via different channels and produce **duplicate sales** because each channel checks a different “external id” field.
- Retrieval endpoints can fail depending on which field was populated.

**Evidence**
- OrdersController uses `reference_number`:
  - `where('reference_number', $validated['external_id'])` (line 139)  
  - `where('reference_number', $externalId)` (line 295)
- StoreSyncService uses `external_reference`:
  - `Sale::where('external_reference', $externalId)` (line 318)

**Impact**
- Duplicate orders, wrong financial totals, duplicated stock deductions, broken “idempotent sync”.

**Fix direction**
- Pick ONE canonical external-id column for all integrations (recommended: `external_reference`) and make API+sync consistent.
- If you must keep `reference_number` for human invoice numbering, keep it separate from external IDs.

---

### STILL-UNFIXED-02 — Inventory has 2 “sources of truth”: `products.stock_quantity` vs `stock_movements`

**Files**
- `app/Services/Dashboard/DashboardDataService.php` (low stock widget uses `products.stock_quantity`)
- `app/Repositories/StockMovementRepository.php` (creates movements but does not update `products.stock_quantity`)
- `app/Listeners/UpdateStockOnSale.php`, `app/Listeners/UpdateStockOnPurchase.php` (record movements only)

**What’s happening**
- Stock changes are recorded in `stock_movements`.
- Some parts of the system (dashboard/alerts and potentially other UI) still use `products.stock_quantity`.

**Why this is a bug**
- Unless every stock change also updates `products.stock_quantity`, alerts and reports can be **wrong** (false low-stock / false safe-stock).

**Evidence**
- Dashboard uses `stock_quantity` for low-stock decisions:
  - `->select(... 'stock_quantity', 'stock_alert_threshold')` + `whereRaw('COALESCE(stock_quantity, 0) <= stock_alert_threshold')` (`DashboardDataService.php` lines 198–204)
- StockMovementRepository does **not** update product stock:
  - creates `stock_movements` and returns (`StockMovementRepository.php` lines 112–156), but never touches `products.stock_quantity`.

**Impact**
- Inventory KPIs/alerts can drift over time.
- ERP “truth” differs depending on which screen you look at.

**Fix direction**
- Decide on ONE source:
  - either compute stock from `stock_movements` everywhere, **or**
  - maintain `products.stock_quantity` consistently (via observer/service after every movement) and treat `stock_movements` as history.

---

## 🆕 New bugs found in v4 (and/or not reported previously)

### CRITICAL-01 — Missing trait `App\Models\Traits\HasBranch` (fatal error when these models are loaded)

**Affected files (all import the trait at line 5)**
- `app/Models/CreditNote.php` (line 5)
- `app/Models/DebitNote.php` (line 5)
- `app/Models/LeaveHoliday.php` (line 5)
- `app/Models/PurchaseReturn.php` (line 5)
- `app/Models/PurchaseReturnItem.php` (line 5)
- `app/Models/ReturnRefund.php` (line 5)
- `app/Models/SalesReturn.php` (line 5)
- `app/Models/StockTransfer.php` (line 5)
- `app/Models/SupplierPerformanceMetric.php` (line 5)

**What’s happening**
These models contain:

```php
use App\Models\Traits\HasBranch;
```

…but there is **no** file/trait at `app/Models/Traits/HasBranch.php`.

The actual trait that exists in this project is:
- `app/Traits/HasBranch.php` (namespace `App\Traits\HasBranch`)

**Impact**
Any code path that touches these models will crash with something like:
> Trait "App\Models\Traits\HasBranch" not found

**Fix direction**
- Replace imports to `use App\Traits\HasBranch;`, or
- Add a small alias trait at `app/Models/Traits/HasBranch.php` that `use`s `App\Traits\HasBranch`.

---

### CRITICAL-02 — Missing trait `App\Services\Traits\HandlesServiceOperations` (fatal error)

**Files**
- `app/Services/SalesReturnService.php` (line 11)
- `app/Services/StockTransferService.php` (line 9)

**What’s happening**
Both files use:

```php
use App\Services\Traits\HandlesServiceOperations;
```

…but there is **no** `app/Services/Traits/HandlesServiceOperations.php` in the project.

(There *is* `app/Traits/HandlesServiceErrors.php`, which looks like the intended trait.)

**Impact**
Any attempt to load these services will fatal error.

**Fix direction**
- Point to the correct existing trait (likely `App\Traits\HandlesServiceErrors`), or implement the missing trait.

---

### CRITICAL-03 — Stock Transfer module will crash: undefined StockMovement constants + undefined StockService method

**Files**
- `app/Services/StockTransferService.php`
- `app/Models/StockMovement.php`

**What’s happening (multiple independent runtime breakers)**
1) `StockTransferService` uses undefined constants:
- `StockMovement::TYPE_TRANSFER_OUT` (line 210)
- `StockMovement::TYPE_TRANSFER_IN` (line 309)
- `StockMovement::TYPE_ADJUSTMENT` (lines 321, 411)

…but `StockMovement` model defines **no** `TYPE_*` constants.

2) `StockTransferService` calls:
- `$this->stockService->adjustStock(...)` (lines 206, 305, 317, 407)

…but `app/Services/StockService.php` has **no** `adjustStock()` method.

**Impact**
The inter-branch transfer flow cannot run at all (will throw errors).

**Fix direction**
- Add the missing constants to `StockMovement` (or remove usage and rely on string movement types),
- Replace `StockService` dependency with the actual service that performs adjustments (your `InventoryService` already has `adjust()` and `transfer()`),
- Or implement `adjustStock()` properly.

---

### CRITICAL-04 — Sales return flow is not inventory-safe, and refund math is effectively undone

**Files**
- `app/Services/SaleService.php` (return handler)
- `app/Observers/FinancialTransactionObserver.php` (forces `updatePaymentStatus()` on every update)
- `app/Models/Sale.php` (`updatePaymentStatus()` sums payments and overwrites `paid_amount`)
- `app/Services/SalesReturnService.php` (separate return service is currently unusable; see CRITICAL-02)

**What’s happening**
- The actual wired return endpoint uses `SaleService::handleReturn()` which:
  - creates a `ReturnNote`,
  - sets sale status to `returned`,
  - tries to reduce `paid_amount` by the refund (lines 90–97),
  - **does not** create any refund payment record,
  - **does not** create any stock-in movement (restock),
  - **does not** create accounting reversal/credit note.

- Then `FinancialTransactionObserver::updated()` calls `$sale->updatePaymentStatus()` for ANY sale update (lines 54–59).
- `Sale::updatePaymentStatus()` recalculates `paid_amount` from `$this->payments()->sum('amount')` and then saves quietly (lines 227–243).
  - Since the return flow did **not** create a negative/refund payment, the sum stays the same → the attempted manual `paid_amount` reduction is undone.

**Impact**
- Return may mark the sale as returned but:
  - stock is not replenished,
  - refunds are not represented consistently,
  - payment status/paid amount becomes inconsistent,
  - financial reports become wrong.

**Fix direction**
- Decide the canonical “return” implementation:
  - Either wire `SalesReturnService` (after fixing CRITICAL-02/03/01) **or**
  - Enhance `SaleService::handleReturn()` to:
    - create refund `SalePayment` record (negative amount or refund type),
    - create stock-in movements for returned items,
    - create credit note / accounting reversal entries.
- Ensure observer logic doesn’t overwrite manual adjustments unintentionally.

---

### CRITICAL-05 — Accounting journal entries can be unbalanced (shipping/other charges ignored) and no balance validation is enforced

**Files**
- `app/Services/AccountingService.php`

**What’s happening**
- `generateSaleJournalEntry()` credits revenue for `subtotal` and credits tax payable for `tax_amount`, and debits discount.  
  But it **does not** account for `shipping_amount` (and any other charges that may be in `total_amount`).
- `generatePurchaseJournalEntry()` debits inventory for `subtotal` and tax recoverable for `tax_amount`, and credits cash/AP for `total_amount`.  
  It **does not** account for purchase-level discount/shipping/other charges.

Also: the service has a `validateBalancedEntry()` helper, but `generateSaleJournalEntry()` / `generatePurchaseJournalEntry()` do not enforce balance checks before saving entries.

**Why this is a bug**
If `total_amount` includes shipping/other charges (or discounts are stored separately), the journal entry can become **unbalanced** or mis-posted.

**Impact**
- Financial statements will be wrong.
- Trial balance can drift.
- Downstream “auditable accounting” becomes unreliable.

**Fix direction**
- Add explicit lines for shipping income/expense and other charges, and enforce balanced validation before persisting.
- Decide accounting treatment for discounts (contra-revenue vs expense) consistently.

---

### CRITICAL-06 — POS checkout allows `warehouse_id = null` and does not enforce branch-consistent product/warehouse selection

**Files**
- `app/Services/POSService.php`
- `app/Http/Requests/PosCheckoutRequest.php`
- `app/Listeners/UpdateStockOnSale.php`

**What’s happening**
- `PosCheckoutRequest` allows `warehouse_id` nullable.
- `POSService` uses `$warehouseId = $payload['warehouse_id'] ?? null;` and continues calculations (line 71).
- Stock validation uses `StockService::getCurrentStock(product_id, $warehouseId)` (line 162).  
  If `$warehouseId` is null, stock is calculated across **all warehouses**.
- Sale is created with `warehouse_id` possibly null (line 184).
- Stock movement listener `UpdateStockOnSale` uses `$sale->warehouse_id` and will record movements with a possibly null warehouse_id (line 31 and line 70 onward).

Additionally:
- Products are loaded by IDs without an explicit `branch_id = $branchId` constraint (POSService lines 81–85).  
  It relies on BranchScope (which is bypassed for certain roles).

**Impact**
- Sales may deduct stock “globally” across warehouses instead of a specific warehouse.
- Possible creation of stock movements with null warehouse_id.
- Risk of cross-branch entity mixing (especially for roles that bypass BranchScope).

**Fix direction**
- Require warehouse_id for stock-tracked products, or resolve a default warehouse for the branch (like OrdersController does).
- Explicitly validate product belongs to branch and warehouse belongs to branch (don’t rely only on global scopes).

---



### HIGH-00 — Purchase receiving can create stock movements with `warehouse_id = null` (and product/branch integrity is not enforced)

**Files**
- `app/Http/Requests/PurchaseStoreRequest.php` (warehouse_id is nullable)
- `app/Services/PurchaseService.php` (creates purchases with nullable warehouse; loads product without branch constraint)
- `app/Listeners/UpdateStockOnPurchase.php` (uses `$purchase->warehouse_id` directly)

**What’s happening**
- Purchases can be created with `warehouse_id = null` (`PurchaseService.php` line 51).
- When a purchase is marked received, the stock update listener will create stock movements using `$warehouseId = $purchase->warehouse_id` (listener line 23) — meaning movements may be written with a null warehouse.
- Purchase items use `\App\Models\Product::find($it['product_id'])` (PurchaseService line 109) without explicitly enforcing the purchase branch’s product set (it relies on BranchScope / current auth context).

**Impact**
- Stock can become “global/unassigned” to a warehouse, breaking per-warehouse inventory and reporting.
- Cross-branch product mixing is possible (especially for roles that bypass BranchScope), leading to orphaned inventory.

**Fix direction**
- Require/resolve a branch-default warehouse for purchases (same pattern you already used in OrdersController).
- Explicitly enforce `product.branch_id == purchase.branch_id` and `warehouse.branch_id == purchase.branch_id`.

### HIGH-01 — Stock movement “duplicate prevention” is too coarse (per-product) and can silently skip valid movements

**Files**
- `app/Listeners/UpdateStockOnSale.php` (lines 34–44)
- `app/Listeners/UpdateStockOnPurchase.php` (lines 26–40)

**What’s happening**
The listeners prevent duplicates using only:
- reference_type + reference_id + product_id (+ sign of quantity)

If a sale/purchase includes the **same product multiple times** (multiple lines, partial receives, corrections), the second and later movements will be skipped.

**Impact**
- Under-deducted stock on sales
- Under-added stock on purchases
- Inventory becomes incorrect silently (no error, only log)

**Fix direction**
- Either aggregate quantities per product before creating a single movement, or include a more granular unique key (e.g., sale_item_id/purchase_item_id) in movement references.

---

### HIGH-02 — FinancialTransactionObserver has event/SoftDelete edge cases (balance drift, restore mismatch)

**Files**
- `app/Observers/FinancialTransactionObserver.php`

**Issues**
1) Uses `isDirty()` inside `updated()` (lines 68–83)  
   Depending on Eloquent timing, `isDirty()` in `updated` can be unreliable; `wasChanged()` is safer for “after update” checks.

2) No `restored()` handler  
   Soft-deleting a Sale/Purchase adjusts balances in `deleted()`, but restoring won’t re-apply balances.

3) Forces `updatePaymentStatus()` on any update (lines 54–59)  
   This can unintentionally override updates coming from other business flows (example: returns trying to adjust `paid_amount`).

**Impact**
- Customer/Supplier balance can drift over time.
- Restore operation causes incorrect balances.
- Business flows can fight each other.

**Fix direction**
- Use `wasChanged()` in `updated()` logic.
- Add `restored()` handling.
- Avoid recalculating payment status on every update; instead trigger it when payment records change.

---

### MEDIUM-01 — Sales paid amount sums all payments regardless of payment status

**Files**
- `app/Models/Sale.php` (line 200–203)
- `app/Models/SalePayment.php` (has `status` field)

**What’s happening**
`Sale::getTotalPaidAttribute()` sums all related payments:

- `return (float) $this->payments()->sum('amount');` (line 202)

…but `SalePayment` has a `status` field (pending/completed/cancelled), and the sale’s “paid amount” should typically ignore non-completed payments.

**Impact**
- Paid totals and payment_status can be incorrect if pending/cancelled payments exist.
- AR aging, due amounts, and dashboards become wrong.

**Fix direction**
- Sum only completed/posted payments, e.g. `payments()->where('status','completed')->sum('amount')`.

---

### MEDIUM-02 — Sale voiding does not reverse inventory or accounting

**Files**
- `app/Services/SaleService.php` (`voidSale()` logic)
- `app/Listeners/UpdateStockOnSale.php` (only reacts to `SaleCompleted` event)

**What’s happening**
`voidSale()` changes sale status to `void` (SaleService lines ~104–123) but there is no stock reversal movement, no accounting reversal, no customer balance adjustment beyond what observer does.

**Impact**
- Inventory remains deducted for a voided sale.
- Accounting entries (if created) remain posted.
- ERP state becomes inconsistent.

**Fix direction**
- Add a “void” workflow that creates compensating stock movements and accounting entries (or restrict voiding to drafts only).

---

## End of report
