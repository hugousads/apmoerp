# APMO ERP (v27) — Bugs Report (NEW + Still-Unfixed)

> This report intentionally **excludes** issues that appear already fixed in your previous iteration(s). It includes only **newly found bugs** and **bugs that are still present** in this v27 ZIP.

## Environment snapshot

**Composer (from `composer.lock`)**
- `laravel/framework`: `v12.44.0`
- `livewire/livewire`: `v4.0.0-beta.5`

**Important compatibility note**
- Livewire v4 has stable releases after beta.5. If you remain on beta.5, you may hit already-solved framework issues and upgrade gaps.

---

## 1) CRITICAL — Branch stock is calculated globally (cross-branch contamination)

**Category:** Logic / Finance / Multi-branch (ERP consistency)

### Why this is a bug
Many dashboards, alerts, and API responses compute `current_stock` using a **global** sum of all `stock_movements` rows for a product:

- `StockService::getStockCalculationExpression()` returns:
  - `SUM(stock_movements.quantity) WHERE product_id = products.id`
  - **No warehouse/branch filter**.

In a multi-branch ERP, this can cause:
- **Low stock alerts firing incorrectly** for a branch.
- **Inventory charts / KPIs** showing wrong stock values.
- Store API stock endpoint returning wrong stock.

### Evidence (file paths)
- `app/Services/StockService.php`
  - `getStockCalculationExpression()` uses global `SUM(quantity)` (no branch scoping).

**Affected usage examples (non-exhaustive):**
- `app/Livewire/Concerns/LoadsDashboardData.php`
  - `calculateLowStockCount()` uses `getStockCalculationExpression()`
  - inventory chart + low stock widgets rely on this.
- `app/Services/SmartNotificationsService.php`
  - low stock alerts query uses `getStockCalculationExpression()`.
- `app/Http/Controllers/Api/StoreIntegrationController.php`
  - `stock()` endpoint returns `current_stock` via `getStockCalculationExpression()`.

### Fix direction
Use **branch-aware** stock calculation:
- Prefer `StockService::getBranchStockCalculationExpression(products.id, <branch_id>)`
  - This correctly joins `stock_movements` -> `warehouses.branch_id`.
- Also prefer **warehouse-level** expression where needed.

---

## 2) HIGH — Transfers + Returns create stock movements with missing/zero unit_cost (inventory valuation breaks)

**Category:** Finance / Costing / Inventory valuation

### Why this is a bug
The system has costing features (`unit_cost` exists in `stock_movements`, `CostingService` uses `quantity * unit_cost`, etc.).
However:
- Transfer movements are created via `StockService::adjustStock()` which **does not accept / set `unit_cost`**.
- Sales return restocking also uses `StockService::adjustStock()` (again **no `unit_cost`**).
- Transfer items default `unit_cost` to **0** when not supplied.

This leads to:
- **Inventory value = 0** for many movements (because `unit_cost` is NULL/0).
- Incorrect COGS / profitability / inventory valuation reports.

### Evidence (file paths)
- `app/Services/StockService.php`
  - `adjustStock()` creates `StockMovement::create([...])` without `unit_cost`.

- `app/Services/SalesReturnService.php`
  - `restockItems()` calls `stockService->adjustStock(...)` with no cost input.

- `app/Services/StockTransferService.php`
  - `createTransfer()` sets item `unit_cost` default to `0` if not supplied.
  - `shipTransfer()`, `receiveTransfer()`, `cancelTransfer()` all call `stockService->adjustStock()` (no unit_cost)
  - Meanwhile `InventoryTransit` stores `unit_cost`, but `stock_movements` does not.

### Fix direction
- Add `unit_cost` support to `StockService::adjustStock()` **or** stop using `StockService` for financial inventory movements.
- Prefer using repository/service that supports costing + locking consistently (e.g., StockMovementRepository pattern).
- For unit_cost defaults:
  - do **NOT** default to `0`.
  - default to a computed cost (weighted avg / last purchase cost / costing batches), or reject if missing depending on your policy.

---

## 3) CRITICAL — Banking reconciliation “difference” calculation is wrong

**Category:** Finance / Accounting

### Why this is a bug
The reconciliation wizard comments say the difference should be based on matched transactions (or adjusted balance), but the implementation sets:

- `difference = statementBalance - systemBalance`

This ignores what the user actually matched/selected, and can:
- Block completion when it should complete.
- Allow completion when it shouldn’t.
- Mislead the user with wrong “difference” amount.

### Evidence (file path)
- `app/Livewire/Banking/Reconciliation.php`
  - `calculateSummary()` sets `$this->difference = $this->statementBalance - $this->systemBalance;`

### Fix direction
Align the difference formula with the intended reconciliation model:
- If reconciliation is based on “matched transactions total”, use:
  - `difference = statementBalance - matchedTotal`
- If it’s “system balance +/- adjustments”, use:
  - `difference = statementBalance - (systemBalance + adjustments)`

---

## 4) MEDIUM — Purchase return unit_cost precision mismatch (risk of rounding/financial drift)

**Category:** Finance / Precision / Tax

### Why this is a bug
`PurchaseItem` uses higher precision for `unit_price` (decimal:4), but `PurchaseReturnItem` casts `unit_cost` as decimal:2.
This can:
- round costs during returns,
- cause drift between purchase value and return value,
- produce inconsistencies in reports and tax calculations.

### Evidence (file paths)
- `app/Models/PurchaseItem.php`
  - `'unit_price' => 'decimal:4'`
- `app/Models/PurchaseReturnItem.php`
  - `'unit_cost' => 'decimal:2'`

### Fix direction
- Align to 4-decimal precision for unit_cost/line_total/tax_amount where your purchasing module uses 4 decimals.

---

## 5) MEDIUM — Services relying on `auth()->id()` can break in CLI/queue contexts

**Category:** Runtime / Stability

### Why this is a bug
Several services call `auth()->id()` inside transactional logic.
If triggered by:
- queue workers,
- scheduled commands,
- webhooks without auth,
then `auth()->id()` becomes `null` and may violate DB constraints or create bad audit trails.

### Evidence (file paths)
- `app/Services/StockService.php` (`created_by` = `auth()->id()`)
- `app/Services/StockTransferService.php` (`requested_by`, `created_by` = `auth()->id()`)

### Fix direction
- Pass `userId` explicitly into services.
- Or ensure a system user is injected for automated contexts.

---

## Quick checklist of what to retest after fixes

1. Multi-branch: low stock alerts per branch (dashboard + SmartNotifications + API stock endpoint).
2. Transfers and returns: inventory valuation reports (any report using `unit_cost` / costing logic).
3. Bank reconciliation wizard: matched transactions difference and completion rules.
4. Purchase return totals: compare totals before/after rounding changes.
5. Any scheduled tasks: confirm they don’t create null `created_by` records.

