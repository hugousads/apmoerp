# APMO ERP — Very Important Bugs (v36)

Contains **High/Critical** severity bugs only, from:
- Old bugs still present in v36 (from v35 baseline)
- New bugs detected in v36

## Summary
- Very important bugs total: **65**
- Breakdown: Security/SQL: 59, Security/XSS: 6

---

### V.1 — High — Security/SQL — Raw SQL with variable interpolation (Old)
- File: `app/Console/Commands/CheckDatabaseIntegrity.php`
- Previous baseline ID: `A.3`
- Evidence: `DB::statement($fix);`

### V.2 — High — Security/SQL — Raw SQL with variable interpolation (Old)
- File: `app/Console/Commands/CheckDatabaseIntegrity.php`
- Previous baseline ID: `A.2`
- Evidence: `$query->whereRaw($where);`

### V.3 — High — Security/SQL — Raw SQL with variable interpolation (Old)
- File: `app/Console/Commands/CheckDatabaseIntegrity.php`
- Previous baseline ID: `A.1`
- Evidence: `->select($column, DB::raw('COUNT(*) as count'))`

### V.4 — High — Security/SQL — Raw SQL with variable interpolation (Old)
- File: `app/Http/Controllers/Admin/ReportsController.php`
- Previous baseline ID: `A.4`
- Evidence: `$data = $query->selectRaw('`

### V.5 — High — Security/SQL — Raw SQL with variable interpolation (Old)
- File: `app/Http/Controllers/Api/StoreIntegrationController.php`
- Previous baseline ID: `A.5`
- Evidence: `->selectRaw($stockExpr.' as current_stock');`

### V.6 — High — Security/SQL — Raw SQL with variable interpolation (Old)
- File: `app/Http/Controllers/Api/V1/InventoryController.php`
- Previous baseline ID: `A.6`
- Evidence: `$query->havingRaw('current_quantity <= products.min_stock');`

### V.7 — High — Security/SQL — Raw SQL with variable interpolation (Old)
- File: `app/Http/Controllers/Api/V1/InventoryController.php`
- Previous baseline ID: `A.7`
- Evidence: `return (float) ($query->selectRaw('SUM(quantity) as balance')`

### V.8 — High — Security/SQL — Raw SQL with variable interpolation (Old)
- File: `app/Livewire/Admin/Branch/Reports.php`
- Previous baseline ID: `A.8`
- Evidence: `'due_amount' => (clone $query)->selectRaw('SUM(total_amount - paid_amount) as due')->value('due') ?? 0,`

### V.9 — High — Security/SQL — Raw SQL with variable interpolation (Old)
- File: `app/Livewire/Concerns/LoadsDashboardData.php`
- Previous baseline ID: `A.13`
- Evidence: `->orderByRaw($stockExpr)`

### V.10 — High — Security/SQL — Raw SQL with variable interpolation (Old)
- File: `app/Livewire/Concerns/LoadsDashboardData.php`
- Previous baseline ID: `A.11`
- Evidence: `->selectRaw("{$stockExpr} as current_quantity")`

### V.11 — High — Security/SQL — Raw SQL with variable interpolation (Old)
- File: `app/Livewire/Concerns/LoadsDashboardData.php`
- Previous baseline ID: `A.12`
- Evidence: `->whereRaw("{$stockExpr} <= products.min_stock")`

### V.12 — High — Security/SQL — Raw SQL with variable interpolation (Old)
- File: `app/Livewire/Concerns/LoadsDashboardData.php`
- Previous baseline ID: `A.10`
- Evidence: `->whereRaw("{$stockExpr} <= min_stock")`

### V.13 — High — Security/SQL — Raw SQL with variable interpolation (Old)
- File: `app/Livewire/Dashboard/CustomizableDashboard.php`
- Previous baseline ID: `A.14`
- Evidence: `$totalValue = (clone $productsQuery)->sum(\Illuminate\Support\Facades\DB::raw('COALESCE(default_price, 0) * COALESCE(stock_quantity, 0)'));`

### V.14 — High — Security/SQL — Raw SQL with variable interpolation (Old)
- File: `app/Livewire/Helpdesk/Dashboard.php`
- Previous baseline ID: `A.15`
- Evidence: `$ticketsByPriority = Ticket::select('priority_id', DB::raw('count(*) as count'))`

### V.15 — High — Security/SQL — Raw SQL with variable interpolation (Old)
- File: `app/Livewire/Inventory/StockAlerts.php`
- Previous baseline ID: `A.17`
- Evidence: `$query->whereRaw('COALESCE(stock_calc.total_stock, 0) <= 0');`

### V.16 — High — Security/SQL — Raw SQL with variable interpolation (Old)
- File: `app/Livewire/Inventory/StockAlerts.php`
- Previous baseline ID: `A.16`
- Evidence: `$query->whereRaw('COALESCE(stock_calc.total_stock, 0) <= products.min_stock AND COALESCE(stock_calc.total_stock, 0) > 0');`

### V.17 — High — Security/SQL — Raw SQL with variable interpolation (Old)
- File: `app/Livewire/Reports/SalesAnalytics.php`
- Previous baseline ID: `A.18`
- Evidence: `->selectRaw("{$dateFormat} as period")`

### V.18 — High — Security/SQL — Raw SQL with variable interpolation (Old)
- File: `app/Livewire/Reports/SalesAnalytics.php`
- Previous baseline ID: `A.19`
- Evidence: `->selectRaw("{$hourExpr} as hour")`

### V.19 — High — Security/SQL — Raw SQL with variable interpolation (Old)
- File: `app/Livewire/Warehouse/Index.php`
- Previous baseline ID: `A.20`
- Evidence: `$totalValue = (clone $stockMovementQuery)->selectRaw('SUM(quantity * COALESCE(unit_cost, 0)) as value')->value('value') ?? 0;`

### V.20 — High — Security/SQL — Raw SQL with variable interpolation (Old)
- File: `app/Livewire/Warehouse/Movements/Index.php`
- Previous baseline ID: `A.21`
- Evidence: `'total_value' => (clone $baseQuery)->selectRaw('SUM(quantity * COALESCE(unit_cost, 0)) as value')->value('value') ?? 0,`

### V.21 — High — Security/SQL — Raw SQL with variable interpolation (Old)
- File: `app/Models/Product.php`
- Previous baseline ID: `A.22`
- Evidence: `->whereRaw("({$stockSubquery}) <= stock_alert_threshold");`

### V.22 — High — Security/SQL — Raw SQL with variable interpolation (Old)
- File: `app/Models/Product.php`
- Previous baseline ID: `A.23`
- Evidence: `return $query->whereRaw("({$stockSubquery}) <= 0");`

### V.23 — High — Security/SQL — Raw SQL with variable interpolation (Old)
- File: `app/Models/Product.php`
- Previous baseline ID: `A.24`
- Evidence: `return $query->whereRaw("({$stockSubquery}) > 0");`

### V.24 — High — Security/SQL — Raw SQL with variable interpolation (Old)
- File: `app/Models/Project.php`
- Previous baseline ID: `A.25`
- Evidence: `return $query->whereRaw('actual_cost > budget');`

### V.25 — High — Security/SQL — Raw SQL with variable interpolation (Old)
- File: `app/Models/SearchIndex.php`
- Previous baseline ID: `A.27`
- Evidence: `$q->whereRaw('LOWER(title) LIKE ?', [$searchTerm])`

### V.26 — High — Security/SQL — Raw SQL with variable interpolation (Old)
- File: `app/Models/SearchIndex.php`
- Previous baseline ID: `A.26`
- Evidence: `$builder->whereRaw(`

### V.27 — High — Security/SQL — Raw SQL with variable interpolation (Old)
- File: `app/Services/Analytics/InventoryTurnoverService.php`
- Previous baseline ID: `A.29`
- Evidence: `$avgInventoryValue = $inventoryQuery->sum(DB::raw('COALESCE(stock_quantity, 0) * COALESCE(cost, 0)'));`

### V.28 — High — Security/SQL — DB::raw constructed from variable expression (needs whitelist/binding) (New)
- File: `app/Services/Analytics/ProfitMarginAnalysisService.php`
- Line (v36): `167`
- Evidence: `DB::raw("{$periodExpr} as period"),`

### V.29 — High — Security/SQL — DB::raw constructed from variable expression (needs whitelist/binding) (New)
- File: `app/Services/Analytics/ProfitMarginAnalysisService.php`
- Line (v36): `175`
- Evidence: `->groupBy(DB::raw($periodExpr))`

### V.30 — High — Security/SQL — DB::raw constructed from variable expression (needs whitelist/binding) (New)
- File: `app/Services/Analytics/SalesForecastingService.php`
- Line (v36): `77`
- Evidence: `DB::raw("{$periodExpr} as period"),`

### V.31 — High — Security/SQL — DB::raw constructed from variable expression (needs whitelist/binding) (New)
- File: `app/Services/Analytics/SalesForecastingService.php`
- Line (v36): `85`
- Evidence: `->groupBy(DB::raw($periodExpr))`

### V.32 — High — Security/SQL — DB::raw constructed from variable expression (needs whitelist/binding) (New)
- File: `app/Services/Analytics/SalesForecastingService.php`
- Line (v36): `247`
- Evidence: `DB::raw("{$dateExpr} as period"),`

### V.33 — High — Security/SQL — DB::raw constructed from variable expression (needs whitelist/binding) (New)
- File: `app/Services/Analytics/SalesForecastingService.php`
- Line (v36): `256`
- Evidence: `->groupBy(DB::raw($dateExpr))`

### V.34 — High — Security/SQL — Raw SQL with variable interpolation (Old)
- File: `app/Services/AutomatedAlertService.php`
- Previous baseline ID: `A.34`
- Evidence: `->whereRaw("({$stockSubquery}) > 0")`

### V.35 — High — Security/SQL — Raw SQL with variable interpolation (Old)
- File: `app/Services/Performance/QueryOptimizationService.php`
- Previous baseline ID: `A.35`
- Evidence: `DB::statement($optimizeStatement);`

### V.36 — High — Security/SQL — Raw SQL with variable interpolation (Old)
- File: `app/Services/PurchaseReturnService.php`
- Previous baseline ID: `A.36`
- Evidence: `return $query->select('condition', DB::raw('COUNT(*) as count'), DB::raw('SUM(qty_returned) as total_qty'))`

### V.37 — High — Security/SQL — Raw SQL with variable interpolation (Old)
- File: `app/Services/QueryPerformanceService.php`
- Previous baseline ID: `A.37`
- Evidence: `$explain = DB::select('EXPLAIN FORMAT=JSON '.$sql);`

### V.38 — High — Security/SQL — Raw SQL with variable interpolation (Old)
- File: `app/Services/RentalService.php`
- Previous baseline ID: `A.38`
- Evidence: `$stats = $query->selectRaw('`

### V.39 — High — Security/SQL — Raw SQL with variable interpolation (Old)
- File: `app/Services/Reports/CustomerSegmentationService.php`
- Previous baseline ID: `A.40`
- Evidence: `->selectRaw("{$datediffExpr} as days_since_purchase")`

### V.40 — High — Security/SQL — Raw SQL with variable interpolation (Old)
- File: `app/Services/Reports/CustomerSegmentationService.php`
- Previous baseline ID: `A.39`
- Evidence: `->selectRaw("{$datediffExpr} as recency_days")`

### V.41 — High — Security/SQL — Raw SQL with variable interpolation (Old)
- File: `app/Services/Reports/SlowMovingStockService.php`
- Previous baseline ID: `A.41`
- Evidence: `->havingRaw('COALESCE(days_since_sale, 999) > ?', [$days])`

### V.42 — High — Security/SQL — Raw SQL contains interpolated variable inside string (Old)
- File: `app/Services/Reports/SlowMovingStockService.php`
- Previous baseline ID: `B.2`
- Evidence: `->selectRaw("{$daysDiffExpr} as days_since_sale")`

### V.43 — High — Security/SQL — Raw SQL with variable interpolation (Old)
- File: `app/Services/ScheduledReportService.php`
- Previous baseline ID: `A.42`
- Evidence: `DB::raw("{$dateExpr} as date"),`

### V.44 — High — Security/SQL — Raw SQL with variable interpolation (Old)
- File: `app/Services/ScheduledReportService.php`
- Previous baseline ID: `A.45`
- Evidence: `$query->selectRaw('COALESCE((SELECT SUM(quantity) FROM stock_movements sm INNER JOIN warehouses w ON sm.warehouse_id = w.id WHERE sm.product_id = products.id AND w.branch_id = ?), 0) as quantity', [$branchId]);`

### V.45 — High — Security/SQL — Raw SQL with variable interpolation (Old)
- File: `app/Services/ScheduledReportService.php`
- Previous baseline ID: `A.46`
- Evidence: `$query->selectRaw('COALESCE((SELECT SUM(quantity) FROM stock_movements sm INNER JOIN warehouses w ON sm.warehouse_id = w.id WHERE sm.product_id = products.id AND w.branch_id = products.branch_id), 0) as quantity');`

### V.46 — High — Security/SQL — Raw SQL with variable interpolation (Old)
- File: `app/Services/ScheduledReportService.php`
- Previous baseline ID: `A.44`
- Evidence: `$query->whereRaw("({$stockSubquery}) <= COALESCE(products.reorder_point, 0)");`

### V.47 — High — Security/SQL — Raw SQL with variable interpolation (Old)
- File: `app/Services/ScheduledReportService.php`
- Previous baseline ID: `A.43`
- Evidence: `return $query->groupBy(DB::raw($dateExpr))`

### V.48 — High — Security/SQL — Raw SQL with variable interpolation (Old)
- File: `app/Services/SmartNotificationsService.php`
- Previous baseline ID: `A.47`
- Evidence: `->selectRaw("{$stockExpr} as current_quantity")`

### V.49 — High — Security/SQL — Raw SQL with variable interpolation (Old)
- File: `app/Services/SmartNotificationsService.php`
- Previous baseline ID: `A.48`
- Evidence: `->whereRaw("{$stockExpr} <= products.min_stock")`

### V.50 — High — Security/SQL — Raw SQL with variable interpolation (Old)
- File: `app/Services/StockReorderService.php`
- Previous baseline ID: `A.49`
- Evidence: `->whereRaw("({$stockSubquery}) <= reorder_point")`

### V.51 — High — Security/SQL — Raw SQL with variable interpolation (Old)
- File: `app/Services/StockReorderService.php`
- Previous baseline ID: `A.50`
- Evidence: `->whereRaw("({$stockSubquery}) <= stock_alert_threshold")`

### V.52 — High — Security/SQL — Raw SQL with variable interpolation (Old)
- File: `app/Services/StockReorderService.php`
- Previous baseline ID: `A.51`
- Evidence: `->whereRaw("({$stockSubquery}) > COALESCE(reorder_point, 0)")`

### V.53 — High — Security/SQL — Raw SQL with variable interpolation (Old)
- File: `app/Services/StockService.php`
- Previous baseline ID: `A.52`
- Evidence: `return (float) $query->selectRaw('COALESCE(SUM(quantity), 0) as stock')`

### V.54 — High — Security/SQL — Raw SQL with variable interpolation (Old)
- File: `app/Services/StockService.php`
- Previous baseline ID: `A.53`
- Evidence: `return (float) ($query->selectRaw('SUM(quantity * COALESCE(unit_cost, 0)) as value')`

### V.55 — High — Security/SQL — Raw SQL with variable interpolation (Old)
- File: `app/Services/WorkflowAutomationService.php`
- Previous baseline ID: `A.56`
- Evidence: `->orderByRaw("(COALESCE(reorder_point, min_stock, 0) - ({$stockSubquery})) DESC")`

### V.56 — High — Security/SQL — Raw SQL with variable interpolation (Old)
- File: `app/Services/WorkflowAutomationService.php`
- Previous baseline ID: `A.55`
- Evidence: `->selectRaw("*, ({$stockSubquery}) as calculated_stock")`

### V.57 — High — Security/SQL — Raw SQL with variable interpolation (Old)
- File: `app/Services/WorkflowAutomationService.php`
- Previous baseline ID: `A.54`
- Evidence: `->whereRaw("({$stockSubquery}) <= COALESCE(reorder_point, min_stock, 0)")`

### V.58 — High — Security/SQL — Raw SQL with variable interpolation (Old)
- File: `resources/views/livewire/admin/dashboard.blade.php`
- Previous baseline ID: `A.61`
- Evidence: `? $contractModel::selectRaw('status, COUNT(*) as total')`

### V.59 — High — Security/SQL — Raw SQL with variable interpolation (Old)
- File: `resources/views/livewire/admin/dashboard.blade.php`
- Previous baseline ID: `A.60`
- Evidence: `? $saleModel::selectRaw('DATE(created_at) as day, SUM(total_amount) as total')`

### V.60 — High — Security/XSS — Unescaped Blade output (XSS risk) (Old)
- File: `resources/views/components/icon.blade.php`
- Previous baseline ID: `A.57`
- Evidence: `{!! sanitize_svg_icon($iconPath) !!}`

### V.61 — High — Security/XSS — Unescaped Blade output (XSS risk) (Old)
- File: `resources/views/components/ui/card.blade.php`
- Previous baseline ID: `A.58`
- Evidence: `{!! $actions !!}`

### V.62 — High — Security/XSS — Unescaped Blade output (XSS risk) (Old)
- File: `resources/views/components/ui/form/input.blade.php`
- Previous baseline ID: `A.59`
- Evidence: `@if($wireModel) {!! $wireDirective !!} @endif`

### V.63 — High — Security/XSS — Unescaped Blade output (XSS risk) (Old)
- File: `resources/views/livewire/auth/two-factor-setup.blade.php`
- Previous baseline ID: `A.62`
- Evidence: `{!! $qrCodeSvg !!}`

### V.64 — High — Security/XSS — Unescaped Blade output (XSS risk) (Old)
- File: `resources/views/livewire/shared/dynamic-form.blade.php`
- Previous baseline ID: `A.63`
- Evidence: `<span class="text-slate-400">{!! sanitize_svg_icon($icon) !!}</span>`

### V.65 — High — Security/XSS — Unescaped Blade output (XSS risk) (Old)
- File: `resources/views/livewire/shared/dynamic-table.blade.php`
- Previous baseline ID: `A.64`
- Evidence: `{!! sanitize_svg_icon($actionIcon) !!}`
