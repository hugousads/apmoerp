# APMO ERP v12 — Bug Report (New + Still-Unfixed)

Scan target: **apmoerpv12.zip** (code-level review). **Database migrations/seeders ignored** per request.

This report contains **ONLY**:
- **New bugs found in v12**, and
- **Bugs previously reported (v11 and earlier) that are still present in v12**


---

## Summary

- **New in v12:** 1
- **Still unfixed:** 4


---

## NEW-V12-CRITICAL-01 — CRITICAL

**Title:** Customer “status” is queried as a DB column, but it’s an accessor (Customer has is_active/is_blocked)

**Location:** `app/Services/AutomatedAlertService.php:154–160`


**What’s wrong**

`Customer` defines `getStatusAttribute()` as a backward-compat accessor that returns `'active'|'inactive'|'blocked'` based on `is_active`/`is_blocked`.
However `AutomatedAlertService` runs:
- `Customer::query()->where('status', 'active') ...`
That will produce SQL like `... WHERE status = 'active'` which will fail if the `customers` table has no `status` column (very likely, given the model fields).

**Impact**

- **Runtime SQL error** when generating credit-utilization alerts.
- Even if a `status` column exists historically, logic becomes inconsistent with the current canonical fields (`is_active`, `is_blocked`).

**Fix direction**

Replace the filter with explicit fields, e.g.:
- `->where('is_active', true)->where('is_blocked', false)`
Or (if you need “not blocked”) handle that explicitly.
Also consider indexing `is_active`/`is_blocked` if alerts run often.


---

## STILL-V11-CRITICAL-01 — CRITICAL

**Title:** Warehouse list filter uses `where('status', ...)` on Warehouse model where `status` is an accessor

**Location:** `app/Livewire/Warehouse/Locations/Index.php:71–77`


**What’s wrong**

`Warehouse` model uses `is_active` as the stored field and exposes `status` via `getStatusAttribute()` (backward compat).
In this Livewire component:
- `->when($this->statusFilter, fn ($q) => $q->where('status', $this->statusFilter))`
So filtering by status will query a non-existent `warehouses.status` column.

**Impact**

- **SQL error** when using the status filter in UI.
- Warehouse list becomes unreliable and can block warehouse management screens.

**Fix direction**

Map UI filter to the real column:
- If filter values are `active/inactive`: translate to `where('is_active', true/false)`
- If you need `blocked` concept, add a real column or handle separately.


---

## STILL-V11-CRITICAL-02 — CRITICAL

**Title:** Inventory API recalculates and stores `products.stock_quantity` using branch total (warehouse dropped)

**Location:** `app/Http/Controllers/Api/V1/InventoryController.php:108–155 and 227–250`


**What’s wrong**

The controller correctly resolves `warehouse_id`, and uses it for:
- `$oldQuantity = calculateCurrentStock(product, $warehouseId, branchId)`
- Creating a stock_movement with the correct `warehouse_id`

But when it persists `products.stock_quantity`, it recalculates using:
- `$calculated = calculateCurrentStock($product->id, null, $product->branch_id);`
i.e. **warehouse_id is set to null**, so the stored `stock_quantity` becomes the **sum across the whole branch**, not the selected warehouse.

**Impact**

- Wrong warehouse-level stock numbers for any flows that rely on `products.stock_quantity`.
- In a multi-warehouse ERP, this can break reorder logic, low-stock alerts, and any warehouse-specific availability checks.
- Creates inconsistencies with `stock_movements` per-warehouse truth.

**Fix direction**

Decide what `products.stock_quantity` represents:
- If it should be **branch total**: do not update it from a single-warehouse adjustment endpoint (or document it and never show it as warehouse stock).
- If it should be **warehouse-specific**: you must not store it on `products` (needs a per-warehouse stock table/materialized view).
At minimum, stop writing misleading values: either remove the write, or write a branch-total only in branch-total operations.


---

## STILL-V11-HIGH-01 — HIGH

**Title:** StockMovementRepository computes stock_before/after via SUM without adequate locking (race condition)

**Location:** `app/Repositories/StockMovementRepository.php:156–166`


**What’s wrong**

Inside `create()`, it calculates:
- `$currentStock = StockMovement::where(product_id)->where(warehouse_id)->sum('quantity')`
then sets `stock_before` and `stock_after` and inserts the new movement.

Even inside a DB transaction, without a locking strategy, concurrent inserts can interleave and both compute the same `currentStock`.

**Impact**

- `stock_before` / `stock_after` can be wrong under concurrency (POS bursts, imports, API sync).
- Downstream auditing (stock history, reconciliation, costing) becomes untrustworthy.

**Fix direction**

Options:
- Maintain a per-(product_id,warehouse_id) stock ledger row and lock that row (`SELECT ... FOR UPDATE`) before updating.
- Or lock the relevant movements set using a deterministic locking strategy (less ideal).
- Or compute before/after after insert using windowed queries when reporting (avoid storing derived values).


---

## STILL-V11-HIGH-02 — HIGH

**Title:** Product addStock/subtractStock still writes `stock_quantity` directly (can drift from stock_movements truth)

**Location:** `app/Models/Product.php:430–474`


**What’s wrong**

`getAvailableQuantity()` now uses `StockService::getStock()` (derived from `stock_movements`), but:
- `addStock()` increments `stock_quantity`
- `subtractStock()` decrements `stock_quantity`

If any code path still calls these methods without also creating corresponding `stock_movements`, your system will diverge: reports using `stock_quantity` differ from movements-based calculations.

**Impact**

- KPIs / low-stock widgets that rely on `products.stock_quantity` can be wrong.
  (Example: `KPIDashboardService` counts low/out-of-stock using `stock_quantity`.)
- ERP “single source of truth” breaks: auditing, reconciliation, and purchasing decisions become unreliable.

**Fix direction**

Either:
- Remove these mutators entirely and enforce **only** `stock_movements` creation as the way to change stock, OR
- Update `stock_quantity` **only** as a derived/cached value in the same transaction as movement insertion (and never by itself).


---
