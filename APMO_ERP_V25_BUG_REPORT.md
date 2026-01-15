# APMO ERP V25 – Bug Report (New + Still-Unfixed)

> **Scope**: Static code review after extracting `apmoerpv25.zip` (ignoring DB data + seeders as requested).  
> **Frameworks (from `composer.lock`)**: `laravel/framework v12.44.0`, `livewire/livewire v4.0.0-beta.5`.

---

## Executive summary

The biggest remaining risks I found in **V25** are around **inventory/financial integrity** and **workflow completeness**:

- **Warehouse Transfers** are still not integrated with inventory movements (stock doesn’t move between warehouses when a transfer is approved/completed).
- **Sales Returns** (API + UI via `SaleService::handleReturn`) create a header record and change sale status, but **do not persist item-level returns**, **do not adjust stock**, and can even mark a sale returned with **0 refund** if invalid items are submitted.
- **Purchase Returns** (Livewire) still mark a purchase as returned and create a `ReturnNote`, but **do not restock/adjust inventory**, and there’s no item-level return tracking.
- **Bank Reconciliation** logic/UI became inconsistent: “difference” is calculated from system balance, but the UI talks about matched transactions; matching transactions does **not** affect the shown difference.
- **Store sync** logic creates “completed” sales without `warehouse_id` and without dispatching `SaleCompleted`, so inventory/accounting integrations won’t run.

---

## Critical bugs

### V25-CRIT-01 — Warehouse Transfers do not create stock movements (Inventory never moves)
**Type**: Inventory + ERP core logic  
**Impact**: Stock levels per warehouse will be wrong. ERP transfer workflow becomes accounting-only (or just status-only) with no real inventory movement.

**Evidence**:
- `app/Livewire/Warehouse/Transfers/Index.php` — approving a transfer only updates status:
  - `approve()` updates status to `completed` directly (no ship/receive, no stock movements).  
  - Lines **47–62**.  
  - See: `Transfer::findOrFail($id); $transfer->update(['status' => 'completed']);`
  - `nl -ba app/Livewire/Warehouse/Transfers/Index.php | sed -n '43,66p'`
- `app/Models/Transfer.php` — `ship()`/`receive()` only set timestamps/status; no stock changes.  
  - Lines **88–118**.

**Why it’s a bug**:
- Transfer completion should at minimum create **two** movements per item:
  - `transfer_out` from `from_warehouse_id`
  - `transfer_in` to `to_warehouse_id`

**Suggested fix**:
- Introduce a **TransferService** that, on transition to shipped/received (or completed), creates stock movements via `StockMovementRepository`.
- Update `approve()` to call service methods (ship/receive), not direct status updates.

---

### V25-CRIT-02 — Purchase Returns (Livewire) mark Purchase as returned without inventory adjustments or item-level tracking
**Type**: Inventory + finance/ERP workflow  
**Impact**: Purchase return workflow creates accounting “signals” but stock remains unchanged. No audit trail per returned SKU/qty.

**Evidence**:
- `app/Livewire/Purchases/Returns/Index.php`
  - `processReturn()`:
    - Creates `ReturnNote` (header only) and sets `Purchase::status = 'returned'`.
    - Does **not** create return items table rows.
    - Does **not** create stock movements (no deduction from warehouse).
    - Lines **81–173**.

- `app/Models/ReturnNote.php`
  - Model is a header-only return document (no relation for items).
  - Lines **23–78** show fillable fields; there is **no** return-items relation/model used here.

**Why it’s a bug**:
- ERP returns must record *which items* were returned + quantities + costs, and must reverse inventory (and often accounting entries) accordingly.

**Suggested fix**:
- Either:
  1) Replace `ReturnNote` usage with the existing structured models (`PurchaseReturn`, `PurchaseReturnItem`, `DebitNote`), OR
  2) Add a `return_note_items` table + model and write inventory movements on approval/completion.

---

### V25-CRIT-03 — Sales Returns via `SaleService::handleReturn()` do not persist items and do not adjust inventory
**Type**: Finance + inventory + data integrity  
**Impact**: Sales can be marked returned without real return record of items; inventory doesn’t increase back; refunds can be wrong; “over-return protection” is ineffective.

**Evidence**:
- `app/Services/SaleService.php`
  - `handleReturn()`:
    - Creates a `ReturnNote` **without any return-line items**.
    - Sets the sale status to `returned` even if **no valid items** are processed.
    - Refund calculation uses **`unit_price` only** (ignores tax/discount allocations).
    - Lines **23–149**.

- “Over-return” check is based on a stock movement reference that is never created anywhere:
  - `getPreviouslyReturnedQuantities()` sums `StockMovement` where `reference_type = 'sale_item_return'`.
  - But there is no code creating stock movements with that reference type.
  - Lines **152–183**.

**Extra critical edge case**:
- If the request includes invalid products / items that don’t match the sale, the loop can skip them, leaving `$refundAmount = '0.00'`, but the code still:
  - creates a return note
  - updates sale status to `returned`

**Suggested fix**:
- Either:
  1) Re-route UI/API returns to the structured `SalesReturnService` (which already supports items), OR
  2) Add `ReturnNoteItem` persistence + stock movements of type `return`.
- Add validation: **at least 1 return item must be processed** or abort.
- Refund amount should be based on `line_total` (or `unit_price - discount + tax`) rather than raw `unit_price`.

---

## High severity bugs

### V25-HIGH-01 — Bank Reconciliation: “difference” calculation ignores matched transactions (UI & logic mismatch)
**Type**: Finance + UX/logic mismatch  
**Impact**: Matching/unmatching transactions won’t change the displayed “difference”, making reconciliation unreliable.

**Evidence**:
- `app/Livewire/Banking/Reconciliation.php`
  - `calculateSummary()` calculates `$matchedTotal` (signed) but **does not use it**.
  - It sets:
    - `$systemBalance = $account->current_balance`
    - `$difference = $statementBalance - $systemBalance`
  - Lines **239–266**.

- `resources/views/livewire/banking/reconciliation.blade.php`
  - UI explicitly describes difference as between statement balance and matched transactions.
  - Matched transactions total is computed using `sum('amount')` (no sign), which is inconsistent for withdrawals.
  - Lines **239–304**.

**Why it’s a bug**:
- In reconciliation, the “difference” should typically depend on what you matched (net of deposits/withdrawals), otherwise the matching step is meaningless.

**Suggested fix**:
- Decide the intended math and make it consistent:
  - If statementBalance is **ending balance**: difference should be `statementBalance - (openingBalance + matchedNet)`.
  - If statementBalance is **net change**: difference should be `statementBalance - matchedNet`.
- Update the UI to match the chosen approach.
- In the blade file, compute matched net with sign (deposit +, withdrawal -), not raw `amount` sum.

---

### V25-HIGH-02 — Bank Reconciliation allows reconciling transactions outside the selected period
**Type**: Finance integrity  
**Impact**: Users (or malformed Livewire payloads) can reconcile transactions not in `[from_date, to_date]`, corrupting period reconciliation.

**Evidence**:
- `app/Livewire/Banking/Reconciliation.php`
  - `complete()` updates `BankTransaction` by IDs + `bank_account_id`, but does **not** enforce date range.
  - Lines **167–195**.

**Suggested fix**:
- When updating reconciled transactions, add date filters:
  - `->whereBetween('transaction_date', [$fromDate, $toDate])`
- Also validate `matchedTransactions` set is a subset of the loaded transactions.

---

### V25-HIGH-03 — Store Sync creates “completed” sales without warehouse_id and without inventory/accounting triggers
**Type**: ERP integration + inventory/finance  
**Impact**:
- Synced orders can be marked `completed` but:
  - won’t decrement stock
  - won’t create journal/stock entries
  - may break when later processes assume `warehouse_id` exists

**Evidence**:
- `app/Services/Store/StoreSyncService.php`
  - `syncShopifyOrderToERP()` creates a `Sale` with status mapped from Shopify; `paid` → `completed`.
  - It **does not set** `warehouse_id`, `sale_date`, `created_by`.
  - Lines **325–406**.
  - Same issue exists in `syncWooOrderToERP()`.

**Related risk**:
- Stock update listener assumes `warehouse_id` exists.
  - `app/Listeners/UpdateStockOnSale.php` uses `$sale->warehouse_id` directly (no null guard).

**Suggested fix**:
- Decide a default warehouse per store/branch and set it on Sale.
- Set `sale_date` from order date.
- When status becomes `completed`, either:
  - dispatch `event(new SaleCompleted($sale))`, OR
  - create stock movements directly.

---

### V25-HIGH-04 — Store stock push uses `InventoryService::currentQty()` without branch context (pushes 0 stock)
**Type**: Integration logic  
**Impact**: Stock sync to Shopify/Woo can push wrong quantities (often **0**) when called outside an HTTP request with branch context.

**Evidence**:
- `app/Services/Store/StoreSyncService.php`
  - `pushStockToShopify()` calls: `$this->inventoryService->currentQty($mapping->product->id)`  
    Lines **68–78**.
  - `pushStockToWooCommerce()` same pattern.  
    Lines **153–163**.

- `app/Services/InventoryService.php`
  - `currentQty()` returns **0.0** if called without branch context (`currentBranchId() === null`).
  - Lines **34–43**.

**Suggested fix**:
- Before calling `currentQty()`, set branch context (same pattern used in `handleShopifyInventoryUpdate()`):
  - `request()->attributes->set('branch_id', $store->branch_id)`
- Prefer using an explicit warehouse for store stock calculations.

---

### V25-HIGH-05 — Orders API status transition to `completed` does not dispatch `SaleCompleted` event
**Type**: Inventory + accounting integration gap  
**Impact**: Orders marked completed via API won’t trigger stock decrement and other “sale completed” side effects.

**Evidence**:
- `app/Http/Controllers/Api/V1/OrdersController.php`
  - `updateStatus()` updates `Sale::status` in a transaction but never fires `SaleCompleted`.
  - Lines **270–320**.

**Suggested fix**:
- Detect transition into `completed` and dispatch:
  - `event(new \App\Events\SaleCompleted($order->fresh('items')))`
- Also handle reversal when transitioning to `cancelled/refunded`.

---

### V25-HIGH-06 — PurchaseReturnService completes returns without inventory adjustments (method is placeholder)
**Type**: Inventory + supplier accountability  
**Impact**: Any workflow using `PurchaseReturnService::completeReturn()` will not change stock (returned items remain in warehouse stock).

**Evidence**:
- `app/Services/PurchaseReturnService.php`
  - `completeReturn()` calls `adjustInventoryForReturn($return)`.
  - `adjustInventoryForReturn()` is empty / comment-only.
  - Lines **155–181** and **261–275**.

**Suggested fix**:
- Implement stock deduction using `InventoryService` or `StockMovementRepository` with a movement type like `return` / `purchase_return`.

---

### V25-HIGH-07 — PurchaseReturnService does not validate purchase_item belongs to purchase (data corruption risk)
**Type**: Data integrity + finance  
**Impact**: A return can include `purchase_item_id` from another purchase, generating wrong debit notes and wrong return quantities.

**Evidence**:
- `app/Services/PurchaseReturnService.php`
  - Validation checks `exists:purchase_items,id` but does not ensure linkage to `purchase_id`.
  - Lines **37–60**, and item creation **82–100**.

**Suggested fix**:
- In `createReturn()`, for each item:
  - Load `PurchaseItem` and assert `purchase_item.purchase_id === validated.purchase_id`.
  - Assert `product_id` matches the purchase item’s product.
  - Assert `qty_returned <= purchase_item.quantity`.

---



### V25-HIGH-08 — Purchases API can create items referencing products/suppliers outside current branch (validation + service gap)
**Type**: Data integrity + multi-branch safety  
**Impact**: API payload can pass a `product_id`/`supplier_id` from another branch (it exists globally), validation passes, and the Purchase is created. Inside the service, the product lookup can return `null` due to `BranchScope`, yet the code still writes the foreign IDs into `purchase_items`, producing broken relations and potentially breaking receiving/stock updates.

**Evidence**:
- `app/Http/Requests/PurchaseStoreRequest.php`
  - Uses global `exists:*` rules with no branch constraint:
    - `supplier_id: exists:suppliers,id` (line **22**)
    - `items.*.product_id: exists:products,id` (line **25**)
- `app/Services/PurchaseService.php`
  - Retrieves product with `Product::find($it['product_id'])` and does **not** fail when it returns null (lines **115–130**). It still writes `product_id` into `purchase_items`.
  - Similar pattern for supplier minimum checks: `Supplier::find($p->supplier_id)` can be null, yet the purchase keeps the foreign supplier_id (lines **151–161**).

**Suggested fix**:
- Enforce branch-scoped existence:
  - Use `Rule::exists('products', 'id')->where('branch_id', $branchId)` and same for suppliers.
- In `PurchaseService::create()`:
  - Replace `Product::find()` with `Product::where('branch_id', $branchId)->findOrFail()` (throw 422 / ValidationException).
  - For `supplier_id`, also ensure it belongs to the same branch if suppliers are branch-scoped.

### V25-HIGH-09 — Purchases API `handleReturn()` endpoint is a stub (no return workflow)
**Type**: Workflow completeness  
**Impact**: API says “Return handled” but does not create any return document, does not adjust stock, and does not affect supplier accounting.

**Evidence**:
- `app/Http/Controllers/Branch/PurchaseController.php`
  - `handleReturn()` returns success without processing (lines **102–108**).

**Suggested fix**:
- Either remove the endpoint until implemented, or wire it to a real return workflow (e.g., `PurchaseReturnService` + stock movements + debit note).


## Medium severity bugs

### V25-MED-01 — Dashboard widgets use `created_at` instead of business date (`sale_date`)
**Type**: Reporting accuracy (finance/ops)  
**Impact**: Backdated sales or imported sales will be counted in the wrong day/week/month dashboards.

**Evidence**:
- `app/Services/Dashboard/DashboardDataService.php`
  - Sales widgets filter by `created_at` (today/week/month) instead of `sale_date`.
  - Lines **71–132**, and also top products/customers use `sales.created_at` (lines **139–190**).

**Suggested fix**:
- Use `sale_date` consistently for business reports (or clearly separate “Created vs Business date” widgets).

---

### V25-MED-02 — Branch filtering in some Livewire pages may incorrectly restrict super-admin / multi-branch views
**Type**: Authorization / UX / data visibility  
**Impact**: If a super-admin user has `branch_id` set, some pages will unintentionally filter down to that branch only.

**Evidence examples**:
- `app/Livewire/Warehouse/Adjustments/Index.php`
  - Uses `when($user->branch_id, ...)` without `isSuperAdmin()` guard.
  - Lines **55–60** (delete check) and **79–83** (query).
- `app/Livewire/Warehouse/Transfers/Index.php`
  - Same pattern used for listing and approving.
  - Lines **36–62** and **73–95**.

**Suggested fix**:
- Prefer using the global `BranchScope` + explicit policies, or a unified `BranchAccessService` check.
- If super-admins should see all branches, add `if (! $user->isSuperAdmin())` guards before applying branch_id filters.

---

## Notes

- I intentionally **did not include** items clearly marked as fixed in earlier V24 report (e.g., missing `note` column searches, POS close-day date filters, transfer item schema mismatch) unless they are still present.
- If you want, I can also produce a **patch list** (exact code changes) for each bug above.

