# APMO ERP — V34 Bug Report (NEW + STILL PRESENT)

**Project version reviewed:** `apmoerpv34.zip`  
**Review date:** 2026-01-17  

## Framework / packages verification
- **Laravel:** `laravel/framework v12.44.0` (from `composer.lock`)
- **Livewire:** `livewire/livewire v4.0.1` (from `composer.lock`) ✅ *(this is the Livewire v4.0.1 upgrade / latest in this project build)*

## Scope
- Deep static review of the project source code (controllers / services / models / livewire components).
- Database schema & seeders were not executed (per your instructions).

---

## Regression check (previous V32 report)
I re-checked the **highest-risk items** from the last available report (`APMO_ERP_V32_BUG_REPORT.md`) and confirmed they are **fixed in V34** (so they are **not** repeated as bugs below). Examples:
- Stock cache update + race-condition fixes exist in `app/Services/StockService.php` (transaction + lock anchor + cache refresh).
- Cross-branch warehouse validation exists in `app/Repositories/StockMovementRepository.php`.
- Document numbering locking is wrapped in transactions (e.g., `app/Models/SalesReturn.php`).
- Branch P&L uses business dates (`sale_date` / `purchase_date`) in `app/Http/Controllers/Branch/ReportsController.php`.

---

# Bugs found in V34 (new findings / still present)

> Format: **ID / Severity** → Location (file:line) → Problem → Impact → Fix suggestion

---

## V34-CRIT-01 — Finance totals & reporting date logic is inconsistent (created_at vs business date)
**Severity:** Critical (finance correctness)

**Locations**
- `app/Services/ReportService.php:30–56` (financeSummary)
- `app/Services/ReportService.php:186–223` (getSalesReportData)
- `app/Services/ReportService.php:229–256` (getPurchasesReportData)

**Problem**
- These report paths compute sales/purchases totals using **`created_at`** instead of **business dates** (`sale_date` / `purchase_date`).
- They also don’t enforce a consistent **status policy** (e.g., can include draft/cancelled/refunded rows depending on data).

**Evidence (code)**
- Uses `whereDate('created_at', '>=', $from)` and `whereDate('created_at', '<=', $to)` in financeSummary (`ReportService.php:37–49`).
- Sales & purchases report generation uses `applyDateFilters(..., 'sales.created_at')` / `applyDateFilters(..., 'purchases.created_at')` (`ReportService.php:204–246`).

**Impact**
- Month/period totals can be materially wrong for backdated invoices.
- Admin/branch dashboards can disagree with branch P&L (which already uses business dates).

**Fix suggestion**
- Use `sales.sale_date` and `purchases.purchase_date` consistently for financial periods.
- Apply a clear status filter (e.g., exclude `draft`, exclude `cancelled`, decide how to treat `refunded` / `returned`).
- Make the reporting policy consistent across controllers/services.

---

## V34-CRIT-02 — Analytics/KPI uses sales.created_at (and partial status filtering)
**Severity:** Critical (executive dashboard correctness)

**Locations (examples)**
- `app/Services/Analytics/KPIDashboardService.php:297–325` (top products + daily sales trend)
- (Similar patterns exist across analytics & forecasting services that use `sales.created_at` for time windows.)

**Problem**
- KPI dashboards and analytics windows use `sales.created_at` (not `sale_date`) when grouping and filtering by date.
- Status exclusion is often only `!= cancelled` (does not consistently exclude `draft`, `returned`, etc.).

**Impact**
- KPI dashboards can diverge from accounting reports.
- Backdated/post-dated invoices distort trends (daily/weekly/monthly charts become incorrect).

**Fix suggestion**
- Switch KPI date windows and groupings to `sale_date`.
- Standardize which statuses count as “real revenue” and apply consistently.

---

## V34-HIGH-01 — Sales return can over-return via duplicated sale_item_id in request
**Severity:** High (finance + stock integrity)

**Location**
- `app/Services/SalesReturnService.php:40–54` (validation)
- `app/Services/SalesReturnService.php:85–113` (looping items)

**Problem**
- Validation does **not** enforce `items.*.sale_item_id` as **distinct**.
- Quantity validation checks each line independently (`qtyToReturn > maxQty`), but if the same `sale_item_id` is repeated across multiple lines, the **sum** can exceed the allowed returnable qty.

**Impact**
- Customer can return/credit more than originally sold.
- Stock movements + credit notes can be inflated → financial loss and broken audit trail.

**Fix suggestion**
- Add `distinct` validation rule to `items.*.sale_item_id`.
- Or aggregate the payload by `sale_item_id` first and validate the **total qty per item** against the max returnable.

---

## V34-HIGH-02 — Approving a sales return can crash if warehouse_id is null
**Severity:** High (runtime crash + workflow blocker)

**Locations**
- Return creation allows nullable warehouse: `app/Services/SalesReturnService.php:40–43`, assignment at `:69–82`.
- Restock assumes warehouse exists: `app/Services/SalesReturnService.php:351–355`.

**Problem**
- `warehouse_id` is allowed to be null during return creation.
- On approval, `restockItems()` calls `StockService::adjustStock(... warehouseId: $return->warehouse_id, ...)` where the method signature requires `int $warehouseId`.

**Impact**
- If the original sale has `warehouse_id = NULL` and the request did not provide one, approval hits a **TypeError** (fatal) and return approval becomes impossible.

**Fix suggestion**
- Enforce warehouse_id is always present for returns that restock.
- Or: if warehouse_id is null, either (a) prevent approval with a clear validation error, or (b) resolve a default warehouse for the branch, or (c) skip restock safely.

---

## V34-HIGH-03 — Stock movements for sales return restocking have no reference linkage
**Severity:** High (audit / traceability)

**Location**
- `app/Services/SalesReturnService.php:351–362`

**Problem**
- The stock adjustment created for a return uses `referenceId: null` and `referenceType: null`.

**Impact**
- Inventory ledger cannot be reliably tied back to the originating sales return record.
- Harder to audit, debug discrepancies, or reverse actions.

**Fix suggestion**
- Pass `referenceId: $return->id` and `referenceType: SalesReturn::class`.
- Optionally also store the `sales_return_item_id` in notes or reference metadata.

---

## V34-HIGH-04 — Sales/Purchases listing + export use created_at instead of business date
**Severity:** High (reporting correctness / user-facing)

**Locations**
- `app/Livewire/Sales/Index.php:28–54, 99–101, 127–134`
- `app/Livewire/Purchases/Index.php:28–54, 101–103, 119–132`

**Problem**
- Date filters and exported “posted_at” fields are based on `created_at`.
- In an ERP, users usually expect filters and exports to use invoice dates (`sale_date` / `purchase_date`).

**Impact**
- Users filtering for “January invoices” will get wrong results if invoices were entered later.
- Exported reports mismatch the finance report screens that correctly use business dates.

**Fix suggestion**
- Replace filters to use `sale_date` / `purchase_date`.
- Add these columns to `allowedSortColumns()` and make them the default `sortField`.
- Export should include business date and optionally system created time as a separate column.

---

## V34-MED-01 — Inventory report summary “total_value” is miscomputed
**Severity:** Medium (report correctness)

**Location**
- `app/Services/ReportService.php:171–177`

**Problem**
- `total_value` is computed as `sum(default_price) * 1` (it does not incorporate stock quantity, cost, or valuation method).

**Impact**
- Misleading summary; not a real “inventory value”.

**Fix suggestion**
- Either rename the metric to reflect what it is (e.g., “sum_of_default_prices”),
- or calculate actual inventory value (e.g., `stock_qty * unit_cost` or use `CostingService::getTotalInventoryValue`).

---

## V34-MED-02 — Aggregate report date boundary bug + created_at usage
**Severity:** Medium (report correctness)

**Location**
- `app/Services/ReportService.php:396–410`

**Problem**
- `$dateFrom` / `$dateTo` can be strings from filters, but `whereBetween('created_at', [$dateFrom, $dateTo])` will behave as datetime boundaries.
- If the filter provides dates without times (e.g., `2026-01-01`), results may exclude records later on the end date depending on DB casting.
- Also relies on `created_at` rather than business dates.

**Fix suggestion**
- Parse filter dates into Carbon and apply `startOfDay()` / `endOfDay()`.
- Use business date columns where appropriate.

---

## V34-MED-03 — Inventory valuation includes in-transit stock but stock totals/queries do not
**Severity:** Medium (reconciliation mismatch)

**Locations**
- Inventory value includes transit: `app/Services/CostingService.php:259–340`
- Stock calculations use stock_movements only: `app/Services/StockService.php:20–33` and expressions at `:152–162`

**Problem**
- Financial valuation includes `InventoryTransit` (“ghost inventory” fix), but stock quantity calculations and many inventory listings rely only on `stock_movements`.

**Impact**
- During transfers, quantity-based reports and value-based reports can disagree.

**Fix suggestion**
- Decide a clear definition for:
  - “Available stock” (exclude transit)
  - “Total owned stock” (include transit)
- Then implement both consistently (separate fields/queries/UI labels), and ensure reports pick the correct one.

---

## V34-MED-04 — Service layer uses abort()/abort_if() (HTTP-specific) inside services
**Severity:** Medium (architecture / runtime stability)

**Locations (examples)**
- `app/Services/SalesReturnService.php:62–66, 92–96, 144–148` (and similar patterns in other services)

**Problem**
- `abort()` throws HTTP exceptions from deep service logic.

**Impact**
- If services are invoked from CLI/queue/jobs, the behavior becomes inconsistent/harder to catch, and can produce unexpected error rendering.

**Fix suggestion**
- Throw domain exceptions (`DomainException`, `ValidationException`) from services.
- Let controllers/handlers convert them to HTTP responses.

---

## Notes
- I intentionally did **not** include previously fixed issues from the V32 report in the bug list above.
- If you want, I can generate a **patch plan** (ordered by severity) and a **test checklist** for finance/inventory flows.
