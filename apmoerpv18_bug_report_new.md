# apmoerpv18 — Bug Report (New + Still-Unfixed only)

**Scan scope:** Codebase deep scan (DB/migrations/seeders ignored).
**Comparison baseline:** apmoerpv17.

## Summary
- **New bugs in v18:** 0
- **Still-unfixed bugs from v17:** 7

> No new unique bugs were detected vs v17 in this scan pass. All findings below are still-unfixed.

## Still-unfixed (from v17)

### 1. [CRITICAL] STOCK_QUANTITY_DIRECT_WRITE

- **File:** `app/Http/Controllers/Api/V1/InventoryController.php`
- **Line:** 253
- **Problem:** Direct write/update to `products.stock_quantity` (risk: source-of-truth conflict vs stock_movements, multi-warehouse/branch inconsistencies).
- **Evidence:** `$freshProduct->forceFill(['stock_quantity' => $calculated])->save();`

**Impact (ERP):**
- Data inconsistency / cross-branch leakage / incorrect inventory, or 500 errors in production.

**Recommended fix:**
- Stop writing `products.stock_quantity` directly from API endpoints.
- Make `stock_movements` the single source of truth and compute stock by `branch_id + warehouse_id + product_id`.
- If you must cache, update cached stock via a single service method with transaction + row locks.

### 2. [CRITICAL] STOCK_QUANTITY_DIRECT_WRITE

- **File:** `app/Http/Controllers/Api/V1/ProductsController.php`
- **Line:** 218
- **Problem:** Direct write/update to `products.stock_quantity` (risk: source-of-truth conflict vs stock_movements, multi-warehouse/branch inconsistencies).
- **Evidence:** `$product->stock_quantity = $quantity;`

**Impact (ERP):**
- Data inconsistency / cross-branch leakage / incorrect inventory, or 500 errors in production.

**Recommended fix:**
- Stop writing `products.stock_quantity` directly from API endpoints.
- Make `stock_movements` the single source of truth and compute stock by `branch_id + warehouse_id + product_id`.
- If you must cache, update cached stock via a single service method with transaction + row locks.

### 3. [CRITICAL] STOCK_QUANTITY_DIRECT_WRITE

- **File:** `app/Http/Controllers/Api/V1/ProductsController.php`
- **Line:** 304
- **Problem:** Direct write/update to `products.stock_quantity` (risk: source-of-truth conflict vs stock_movements, multi-warehouse/branch inconsistencies).
- **Evidence:** `$product->stock_quantity = $newQuantity;`

**Impact (ERP):**
- Data inconsistency / cross-branch leakage / incorrect inventory, or 500 errors in production.

**Recommended fix:**
- Stop writing `products.stock_quantity` directly from API endpoints.
- Make `stock_movements` the single source of truth and compute stock by `branch_id + warehouse_id + product_id`.
- If you must cache, update cached stock via a single service method with transaction + row locks.

### 4. [CRITICAL] WAREHOUSE_STATUS_ACCESSOR_QUERY

- **File:** `app/Livewire/Inventory/Serials/Form.php`
- **Line:** 120
- **Problem:** Filters warehouses by `status='active'` in query; if `status` is an accessor (not DB column) this causes SQL error/wrong results.
- **Evidence:** `$batches = []; if ($this->product_id) { $batches = InventoryBatch::where('branch_id', $branchId) ->where('product_id', $this->product_id) ->where('status', 'active') ->orderBy('batch_number') ->get();`

**Impact (ERP):**
- Data inconsistency / cross-branch leakage / incorrect inventory, or 500 errors in production.

**Recommended fix:**
- Replace `where('status','active')` with the real DB column (e.g. `is_active = true`) **or** change the schema to include `status` as a column.
- If `status` is computed (accessor), you cannot filter in SQL; filter in PHP **after** query (only for small sets), or store a real column.

### 5. [CRITICAL] WAREHOUSE_STATUS_ACCESSOR_QUERY

- **File:** `app/Livewire/Warehouse/Adjustments/Form.php`
- **Line:** 175
- **Problem:** Filters warehouses by `status='active'` in query; if `status` is an accessor (not DB column) this causes SQL error/wrong results.
- **Evidence:** `->where('is_active', true) ->orderBy('name') ->get(); $products = Product::when($user->branch_id, fn ($q) => $q->where('branch_id', $user->branch_id)) ->where('status', 'active') ->orderBy('name') ->g`

**Impact (ERP):**
- Data inconsistency / cross-branch leakage / incorrect inventory, or 500 errors in production.

**Recommended fix:**
- Replace `where('status','active')` with the real DB column (e.g. `is_active = true`) **or** change the schema to include `status` as a column.
- If `status` is computed (accessor), you cannot filter in SQL; filter in PHP **after** query (only for small sets), or store a real column.

### 6. [CRITICAL] WAREHOUSE_STATUS_ACCESSOR_QUERY

- **File:** `app/Livewire/Warehouse/Transfers/Form.php`
- **Line:** 150
- **Problem:** Filters warehouses by `status='active'` in query; if `status` is an accessor (not DB column) this causes SQL error/wrong results.
- **Evidence:** `->where('is_active', true) ->orderBy('name') ->get(); $products = Product::when($user->branch_id, fn ($q) => $q->where('branch_id', $user->branch_id)) ->where('status', 'active') ->orderBy('name') ->g`

**Impact (ERP):**
- Data inconsistency / cross-branch leakage / incorrect inventory, or 500 errors in production.

**Recommended fix:**
- Replace `where('status','active')` with the real DB column (e.g. `is_active = true`) **or** change the schema to include `status` as a column.
- If `status` is computed (accessor), you cannot filter in SQL; filter in PHP **after** query (only for small sets), or store a real column.

### 7. [CRITICAL] BRANCHSCOPE_CONSOLE_BYPASS

- **File:** `app/Models/Scopes/BranchScope.php`
- **Line:** 68
- **Problem:** BranchScope checks runningInConsole(); if it bypasses scoping, queued jobs/commands may run cross-branch.
- **Evidence:** `tions, seeders, etc.) // CRITICAL: Queue workers and scheduled tasks MUST apply branch scope if (app()->runningInConsole() && ! app()->runningUnitTests() && $this->isSafeConsoleCommand()) { return; } `

**Impact (ERP):**
- Data inconsistency / cross-branch leakage / incorrect inventory, or 500 errors in production.

**Recommended fix:**
- Do **not** bypass BranchScope for queue workers/scheduler.
- If you need exceptions for migrations/seeders, whitelist only those commands explicitly.
- For jobs, pass `branch_id` and set branch context before queries.

