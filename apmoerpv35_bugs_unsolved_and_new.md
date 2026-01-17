# APMO ERP — Bug Delta Report (v35 vs v34 baseline)

This report contains **only**:
1) **Old bugs** from the **v34 baseline report** that are **still present** in v35
2) **New bugs** detected in v35 (not present in v34 baseline report)

## Summary
- Baseline bugs (from v34 report, filtered): **847**
- Old bugs fixed in v35: **2**
- Old bugs NOT solved yet: **845**
- New bugs found in v35: **106**

---

## A) Old bugs NOT solved yet (still present in v35)

### A.1 — A.3 — High — Security/SQL — Raw SQL with variable interpolation
- Baseline ID (v34): `A.3`
- File: `app/Console/Commands/CheckDatabaseIntegrity.php`
- Evidence: `                DB::statement($fix);`

### A.2 — A.2 — High — Security/SQL — Raw SQL with variable interpolation
- Baseline ID (v34): `A.2`
- File: `app/Console/Commands/CheckDatabaseIntegrity.php`
- Evidence: `            $query->whereRaw($where);`

### A.3 — A.1 — High — Security/SQL — Raw SQL with variable interpolation
- Baseline ID (v34): `A.1`
- File: `app/Console/Commands/CheckDatabaseIntegrity.php`
- Evidence: `            ->select($column, DB::raw('COUNT(*) as count'))`

### A.4 — B.1 — High — Security/SQL — Raw SQL function called with variable input (injection surface)
- Baseline ID (v34): `B.1`
- File: `app/Console/Commands/CheckDatabaseIntegrity.php`
- Evidence: `$query->whereRaw($where);`

### A.5 — B.2 — High — Security/SQL — DB::statement/unprepared called with variable SQL
- Baseline ID (v34): `B.2`
- File: `app/Console/Commands/CheckDatabaseIntegrity.php`
- Evidence: `DB::statement($fix);`

### A.6 — A.4 — High — Security/SQL — Raw SQL with variable interpolation
- Baseline ID (v34): `A.4`
- File: `app/Http/Controllers/Admin/ReportsController.php`
- Evidence: `        $data = $query->selectRaw('`

### A.7 — A.5 — High — Security/SQL — Raw SQL with variable interpolation
- Baseline ID (v34): `A.5`
- File: `app/Http/Controllers/Api/StoreIntegrationController.php`
- Evidence: `            ->selectRaw($stockExpr.' as current_stock');`

### A.8 — B.3 — High — Security/SQL — Raw SQL function called with variable input (injection surface)
- Baseline ID (v34): `B.3`
- File: `app/Http/Controllers/Api/StoreIntegrationController.php`
- Evidence: `->selectRaw($stockExpr.' as current_stock');`

### A.9 — A.6 — High — Security/SQL — Raw SQL with variable interpolation
- Baseline ID (v34): `A.6`
- File: `app/Http/Controllers/Api/V1/InventoryController.php`
- Evidence: `            $query->havingRaw('current_quantity <= products.min_stock');`

### A.10 — A.7 — High — Security/SQL — Raw SQL with variable interpolation
- Baseline ID (v34): `A.7`
- File: `app/Http/Controllers/Api/V1/InventoryController.php`
- Evidence: `        return (float) ($query->selectRaw('SUM(quantity) as balance')`

### A.11 — A.8 — High — Security/SQL — Raw SQL with variable interpolation
- Baseline ID (v34): `A.8`
- File: `app/Livewire/Admin/Branch/Reports.php`
- Evidence: `            'due_amount' => (clone $query)->selectRaw('SUM(total_amount - paid_amount) as due')->value('due') ?? 0,`

### A.12 — A.9 — High — Security/SQL — Raw SQL with variable interpolation
- Baseline ID (v34): `A.9`
- File: `app/Livewire/Admin/Branch/Reports.php`
- Evidence: `            'total_value' => (clone $query)->sum(DB::raw('COALESCE(default_price, 0) * COALESCE(stock_quantity, 0)')),`

### A.13 — A.13 — High — Security/SQL — Raw SQL with variable interpolation
- Baseline ID (v34): `A.13`
- File: `app/Livewire/Concerns/LoadsDashboardData.php`
- Evidence: `                ->orderByRaw($stockExpr)`

### A.14 — A.11 — High — Security/SQL — Raw SQL with variable interpolation
- Baseline ID (v34): `A.11`
- File: `app/Livewire/Concerns/LoadsDashboardData.php`
- Evidence: `                ->selectRaw("{$stockExpr} as current_quantity")`

### A.15 — A.12 — High — Security/SQL — Raw SQL with variable interpolation
- Baseline ID (v34): `A.12`
- File: `app/Livewire/Concerns/LoadsDashboardData.php`
- Evidence: `                ->whereRaw("{$stockExpr} <= products.min_stock")`

### A.16 — A.10 — High — Security/SQL — Raw SQL with variable interpolation
- Baseline ID (v34): `A.10`
- File: `app/Livewire/Concerns/LoadsDashboardData.php`
- Evidence: `            ->whereRaw("{$stockExpr} <= min_stock")`

### A.17 — B.4 — High — Security/SQL — Raw SQL function called with variable input (injection surface)
- Baseline ID (v34): `B.4`
- File: `app/Livewire/Concerns/LoadsDashboardData.php`
- Evidence: `->orderByRaw($stockExpr)`

### A.18 — A.14 — High — Security/SQL — Raw SQL with variable interpolation
- Baseline ID (v34): `A.14`
- File: `app/Livewire/Dashboard/CustomizableDashboard.php`
- Evidence: `            $totalValue = (clone $productsQuery)->sum(\Illuminate\Support\Facades\DB::raw('COALESCE(default_price, 0) * COALESCE(stock_quantity, 0)'));`

### A.19 — A.15 — High — Security/SQL — Raw SQL with variable interpolation
- Baseline ID (v34): `A.15`
- File: `app/Livewire/Helpdesk/Dashboard.php`
- Evidence: `        $ticketsByPriority = Ticket::select('priority_id', DB::raw('count(*) as count'))`

### A.20 — A.17 — High — Security/SQL — Raw SQL with variable interpolation
- Baseline ID (v34): `A.17`
- File: `app/Livewire/Inventory/StockAlerts.php`
- Evidence: `            $query->whereRaw('COALESCE(stock_calc.total_stock, 0) <= 0');`

### A.21 — A.16 — High — Security/SQL — Raw SQL with variable interpolation
- Baseline ID (v34): `A.16`
- File: `app/Livewire/Inventory/StockAlerts.php`
- Evidence: `            $query->whereRaw('COALESCE(stock_calc.total_stock, 0) <= products.min_stock AND COALESCE(stock_calc.total_stock, 0) > 0');`

### A.22 — A.18 — High — Security/SQL — Raw SQL with variable interpolation
- Baseline ID (v34): `A.18`
- File: `app/Livewire/Reports/SalesAnalytics.php`
- Evidence: `            ->selectRaw("{$dateFormat} as period")`

### A.23 — A.19 — High — Security/SQL — Raw SQL with variable interpolation
- Baseline ID (v34): `A.19`
- File: `app/Livewire/Reports/SalesAnalytics.php`
- Evidence: `            ->selectRaw("{$hourExpr} as hour")`

### A.24 — A.20 — High — Security/SQL — Raw SQL with variable interpolation
- Baseline ID (v34): `A.20`
- File: `app/Livewire/Warehouse/Index.php`
- Evidence: `            $totalValue = (clone $stockMovementQuery)->selectRaw('SUM(quantity * COALESCE(unit_cost, 0)) as value')->value('value') ?? 0;`

### A.25 — A.21 — High — Security/SQL — Raw SQL with variable interpolation
- Baseline ID (v34): `A.21`
- File: `app/Livewire/Warehouse/Movements/Index.php`
- Evidence: `            'total_value' => (clone $baseQuery)->selectRaw('SUM(quantity * COALESCE(unit_cost, 0)) as value')->value('value') ?? 0,`

### A.26 — A.22 — High — Security/SQL — Raw SQL with variable interpolation
- Baseline ID (v34): `A.22`
- File: `app/Models/Product.php`
- Evidence: `            ->whereRaw("({$stockSubquery}) <= stock_alert_threshold");`

### A.27 — A.23 — High — Security/SQL — Raw SQL with variable interpolation
- Baseline ID (v34): `A.23`
- File: `app/Models/Product.php`
- Evidence: `        return $query->whereRaw("({$stockSubquery}) <= 0");`

### A.28 — A.24 — High — Security/SQL — Raw SQL with variable interpolation
- Baseline ID (v34): `A.24`
- File: `app/Models/Product.php`
- Evidence: `        return $query->whereRaw("({$stockSubquery}) > 0");`

### A.29 — A.25 — High — Security/SQL — Raw SQL with variable interpolation
- Baseline ID (v34): `A.25`
- File: `app/Models/Project.php`
- Evidence: `        return $query->whereRaw('actual_cost > budget');`

### A.30 — A.27 — High — Security/SQL — Raw SQL with variable interpolation
- Baseline ID (v34): `A.27`
- File: `app/Models/SearchIndex.php`
- Evidence: `                $q->whereRaw('LOWER(title) LIKE ?', [$searchTerm])`

### A.31 — A.26 — High — Security/SQL — Raw SQL with variable interpolation
- Baseline ID (v34): `A.26`
- File: `app/Models/SearchIndex.php`
- Evidence: `            $builder->whereRaw(`

### A.32 — A.29 — High — Security/SQL — Raw SQL with variable interpolation
- Baseline ID (v34): `A.29`
- File: `app/Services/Analytics/InventoryTurnoverService.php`
- Evidence: `        $avgInventoryValue = $inventoryQuery->sum(DB::raw('COALESCE(stock_quantity, 0) * COALESCE(cost, 0)'));`

### A.33 — A.28 — High — Security/SQL — Raw SQL with variable interpolation
- Baseline ID (v34): `A.28`
- File: `app/Services/Analytics/InventoryTurnoverService.php`
- Evidence: `        $cogs = $cogsQuery->sum(DB::raw('sale_items.quantity * COALESCE(products.cost, 0)'));`

### A.34 — A.30 — High — Security/SQL — Raw SQL with variable interpolation
- Baseline ID (v34): `A.30`
- File: `app/Services/Analytics/ProfitMarginAnalysisService.php`
- Evidence: `                DB::raw("DATE_FORMAT(sales.created_at, '{$dateFormat}') as period"),`

### A.35 — A.31 — High — Security/SQL — Raw SQL with variable interpolation
- Baseline ID (v34): `A.31`
- File: `app/Services/Analytics/ProfitMarginAnalysisService.php`
- Evidence: `            ->groupBy(DB::raw("DATE_FORMAT(sales.created_at, '{$dateFormat}')"))`

### A.36 — B.10 — High — Security/SQL — DB::raw called with variable/concatenation (injection surface)
- Baseline ID (v34): `B.10`
- File: `app/Services/Analytics/ProfitMarginAnalysisService.php`
- Evidence: `->groupBy(DB::raw("DATE_FORMAT(sales.created_at, '{$dateFormat}')"))`

### A.37 — B.9 — High — Security/SQL — DB::raw called with variable/concatenation (injection surface)
- Baseline ID (v34): `B.9`
- File: `app/Services/Analytics/ProfitMarginAnalysisService.php`
- Evidence: `DB::raw("DATE_FORMAT(sales.created_at, '{$dateFormat}') as period"),`

### A.38 — A.32 — High — Security/SQL — Raw SQL with variable interpolation
- Baseline ID (v34): `A.32`
- File: `app/Services/Analytics/SalesForecastingService.php`
- Evidence: `                DB::raw("DATE_FORMAT(created_at, '{$dateFormat}') as period"),`

### A.39 — A.33 — High — Security/SQL — Raw SQL with variable interpolation
- Baseline ID (v34): `A.33`
- File: `app/Services/Analytics/SalesForecastingService.php`
- Evidence: `            ->groupBy(DB::raw("DATE_FORMAT(created_at, '{$dateFormat}')"))`

### A.40 — B.12 — High — Security/SQL — DB::raw called with variable/concatenation (injection surface)
- Baseline ID (v34): `B.12`
- File: `app/Services/Analytics/SalesForecastingService.php`
- Evidence: `->groupBy(DB::raw("DATE_FORMAT(created_at, '{$dateFormat}')"))`

### A.41 — B.14 — High — Security/SQL — DB::raw called with variable/concatenation (injection surface)
- Baseline ID (v34): `B.14`
- File: `app/Services/Analytics/SalesForecastingService.php`
- Evidence: `->groupBy(DB::raw("DATE_FORMAT(sales.created_at, '%Y-%m-%d')"))`

### A.42 — B.11 — High — Security/SQL — DB::raw called with variable/concatenation (injection surface)
- Baseline ID (v34): `B.11`
- File: `app/Services/Analytics/SalesForecastingService.php`
- Evidence: `DB::raw("DATE_FORMAT(created_at, '{$dateFormat}') as period"),`

### A.43 — B.13 — High — Security/SQL — DB::raw called with variable/concatenation (injection surface)
- Baseline ID (v34): `B.13`
- File: `app/Services/Analytics/SalesForecastingService.php`
- Evidence: `DB::raw("DATE_FORMAT(sales.created_at, '%Y-%m-%d') as period"),`

### A.44 — A.34 — High — Security/SQL — Raw SQL with variable interpolation
- Baseline ID (v34): `A.34`
- File: `app/Services/AutomatedAlertService.php`
- Evidence: `            ->whereRaw("({$stockSubquery}) > 0")`

### A.45 — A.35 — High — Security/SQL — Raw SQL with variable interpolation
- Baseline ID (v34): `A.35`
- File: `app/Services/Performance/QueryOptimizationService.php`
- Evidence: `            DB::statement($optimizeStatement);`

### A.46 — B.15 — High — Security/SQL — DB::statement/unprepared called with variable SQL
- Baseline ID (v34): `B.15`
- File: `app/Services/Performance/QueryOptimizationService.php`
- Evidence: `DB::statement($optimizeStatement);`

### A.47 — A.36 — High — Security/SQL — Raw SQL with variable interpolation
- Baseline ID (v34): `A.36`
- File: `app/Services/PurchaseReturnService.php`
- Evidence: `        return $query->select('condition', DB::raw('COUNT(*) as count'), DB::raw('SUM(qty_returned) as total_qty'))`

### A.48 — A.37 — High — Security/SQL — Raw SQL with variable interpolation
- Baseline ID (v34): `A.37`
- File: `app/Services/QueryPerformanceService.php`
- Evidence: `            $explain = DB::select('EXPLAIN FORMAT=JSON '.$sql);`

### A.49 — A.38 — High — Security/SQL — Raw SQL with variable interpolation
- Baseline ID (v34): `A.38`
- File: `app/Services/RentalService.php`
- Evidence: `        $stats = $query->selectRaw('`

### A.50 — A.40 — High — Security/SQL — Raw SQL with variable interpolation
- Baseline ID (v34): `A.40`
- File: `app/Services/Reports/CustomerSegmentationService.php`
- Evidence: `            ->selectRaw("{$datediffExpr} as days_since_purchase")`

### A.51 — A.39 — High — Security/SQL — Raw SQL with variable interpolation
- Baseline ID (v34): `A.39`
- File: `app/Services/Reports/CustomerSegmentationService.php`
- Evidence: `            ->selectRaw("{$datediffExpr} as recency_days")`

### A.52 — A.41 — High — Security/SQL — Raw SQL with variable interpolation
- Baseline ID (v34): `A.41`
- File: `app/Services/Reports/SlowMovingStockService.php`
- Evidence: `            ->havingRaw('COALESCE(days_since_sale, 999) > ?', [$days])`

### A.53 — A.42 — High — Security/SQL — Raw SQL with variable interpolation
- Baseline ID (v34): `A.42`
- File: `app/Services/ScheduledReportService.php`
- Evidence: `                    DB::raw("{$dateExpr} as date"),`

### A.54 — A.45 — High — Security/SQL — Raw SQL with variable interpolation
- Baseline ID (v34): `A.45`
- File: `app/Services/ScheduledReportService.php`
- Evidence: `                $query->selectRaw('COALESCE((SELECT SUM(quantity) FROM stock_movements sm INNER JOIN warehouses w ON sm.warehouse_id = w.id WHERE sm.product_id = products.id AND w.branch_id = ?), 0) as quantity', [$branchId]);`

### A.55 — A.46 — High — Security/SQL — Raw SQL with variable interpolation
- Baseline ID (v34): `A.46`
- File: `app/Services/ScheduledReportService.php`
- Evidence: `                $query->selectRaw('COALESCE((SELECT SUM(quantity) FROM stock_movements sm INNER JOIN warehouses w ON sm.warehouse_id = w.id WHERE sm.product_id = products.id AND w.branch_id = products.branch_id), 0) as quantity');`

### A.56 — A.44 — High — Security/SQL — Raw SQL with variable interpolation
- Baseline ID (v34): `A.44`
- File: `app/Services/ScheduledReportService.php`
- Evidence: `                $query->whereRaw("({$stockSubquery}) <= COALESCE(products.reorder_point, 0)");`

### A.57 — A.43 — High — Security/SQL — Raw SQL with variable interpolation
- Baseline ID (v34): `A.43`
- File: `app/Services/ScheduledReportService.php`
- Evidence: `            return $query->groupBy(DB::raw($dateExpr))`

### A.58 — B.16 — High — Security/SQL — DB::raw called with variable/concatenation (injection surface)
- Baseline ID (v34): `B.16`
- File: `app/Services/ScheduledReportService.php`
- Evidence: `DB::raw("{$dateExpr} as date"),`

### A.59 — B.17 — High — Security/SQL — DB::raw called with variable/concatenation (injection surface)
- Baseline ID (v34): `B.17`
- File: `app/Services/ScheduledReportService.php`
- Evidence: `return $query->groupBy(DB::raw($dateExpr))`

### A.60 — A.47 — High — Security/SQL — Raw SQL with variable interpolation
- Baseline ID (v34): `A.47`
- File: `app/Services/SmartNotificationsService.php`
- Evidence: `                ->selectRaw("{$stockExpr} as current_quantity")`

### A.61 — A.48 — High — Security/SQL — Raw SQL with variable interpolation
- Baseline ID (v34): `A.48`
- File: `app/Services/SmartNotificationsService.php`
- Evidence: `                ->whereRaw("{$stockExpr} <= products.min_stock")`

### A.62 — A.49 — High — Security/SQL — Raw SQL with variable interpolation
- Baseline ID (v34): `A.49`
- File: `app/Services/StockReorderService.php`
- Evidence: `            ->whereRaw("({$stockSubquery}) <= reorder_point")`

### A.63 — A.50 — High — Security/SQL — Raw SQL with variable interpolation
- Baseline ID (v34): `A.50`
- File: `app/Services/StockReorderService.php`
- Evidence: `            ->whereRaw("({$stockSubquery}) <= stock_alert_threshold")`

### A.64 — A.51 — High — Security/SQL — Raw SQL with variable interpolation
- Baseline ID (v34): `A.51`
- File: `app/Services/StockReorderService.php`
- Evidence: `            ->whereRaw("({$stockSubquery}) > COALESCE(reorder_point, 0)")`

### A.65 — A.52 — High — Security/SQL — Raw SQL with variable interpolation
- Baseline ID (v34): `A.52`
- File: `app/Services/StockService.php`
- Evidence: `        return (float) $query->selectRaw('COALESCE(SUM(quantity), 0) as stock')`

### A.66 — A.53 — High — Security/SQL — Raw SQL with variable interpolation
- Baseline ID (v34): `A.53`
- File: `app/Services/StockService.php`
- Evidence: `        return (float) ($query->selectRaw('SUM(quantity * COALESCE(unit_cost, 0)) as value')`

### A.67 — A.56 — High — Security/SQL — Raw SQL with variable interpolation
- Baseline ID (v34): `A.56`
- File: `app/Services/WorkflowAutomationService.php`
- Evidence: `            ->orderByRaw("(COALESCE(reorder_point, min_stock, 0) - ({$stockSubquery})) DESC")`

### A.68 — A.55 — High — Security/SQL — Raw SQL with variable interpolation
- Baseline ID (v34): `A.55`
- File: `app/Services/WorkflowAutomationService.php`
- Evidence: `            ->selectRaw("*, ({$stockSubquery}) as calculated_stock")`

### A.69 — A.54 — High — Security/SQL — Raw SQL with variable interpolation
- Baseline ID (v34): `A.54`
- File: `app/Services/WorkflowAutomationService.php`
- Evidence: `            ->whereRaw("({$stockSubquery}) <= COALESCE(reorder_point, min_stock, 0)")`

### A.70 — A.57 — High — Security/XSS — Unescaped Blade output (XSS risk)
- Baseline ID (v34): `A.57`
- File: `resources/views/components/icon.blade.php`
- Evidence: `    {!! sanitize_svg_icon($iconPath) !!}`

### A.71 — A.58 — High — Security/XSS — Unescaped Blade output (XSS risk)
- Baseline ID (v34): `A.58`
- File: `resources/views/components/ui/card.blade.php`
- Evidence: `            {!! $actions !!}`

### A.72 — A.59 — High — Security/XSS — Unescaped Blade output (XSS risk)
- Baseline ID (v34): `A.59`
- File: `resources/views/components/ui/form/input.blade.php`
- Evidence: `            @if($wireModel) {!! $wireDirective !!} @endif`

### A.73 — A.61 — High — Security/SQL — Raw SQL with variable interpolation
- Baseline ID (v34): `A.61`
- File: `resources/views/livewire/admin/dashboard.blade.php`
- Evidence: `            ? $contractModel::selectRaw('status, COUNT(*) as total')`

### A.74 — A.60 — High — Security/SQL — Raw SQL with variable interpolation
- Baseline ID (v34): `A.60`
- File: `resources/views/livewire/admin/dashboard.blade.php`
- Evidence: `            ? $saleModel::selectRaw('DATE(created_at) as day, SUM(total_amount) as total')`

### A.75 — A.62 — High — Security/XSS — Unescaped Blade output (XSS risk)
- Baseline ID (v34): `A.62`
- File: `resources/views/livewire/auth/two-factor-setup.blade.php`
- Evidence: `                        {!! $qrCodeSvg !!}`

### A.76 — A.63 — High — Security/XSS — Unescaped Blade output (XSS risk)
- Baseline ID (v34): `A.63`
- File: `resources/views/livewire/shared/dynamic-form.blade.php`
- Evidence: `                                <span class="text-slate-400">{!! sanitize_svg_icon($icon) !!}</span>`

### A.77 — A.64 — High — Security/XSS — Unescaped Blade output (XSS risk)
- Baseline ID (v34): `A.64`
- File: `resources/views/livewire/shared/dynamic-table.blade.php`
- Evidence: `                                                        {!! sanitize_svg_icon($actionIcon) !!}`

### A.78 — B.18 — Medium — Perf/Security — Loads full file into memory (Storage::get / file_get_contents)
- Baseline ID (v34): `B.18`
- File: `app/Console/Commands/AuditViewButtons.php`
- Evidence: `$content = file_get_contents($filePath);`

### A.79 — A.65 — Medium — Finance/Precision — Float cast for totals
- Baseline ID (v34): `A.65`
- File: `app/Http/Controllers/Admin/Reports/InventoryReportsExportController.php`
- Evidence: `            $stock = (float) ($stockData[$product->id] ?? 0);`

### A.80 — A.66 — Medium — Finance/Precision — Money/amount cast to float (rounding drift risk)
- Baseline ID (v34): `A.66`
- File: `app/Http/Controllers/Admin/ReportsController.php`
- Evidence: `        $inflows = (float) (clone $query)->where('type', 'deposit')->sum('amount');`

### A.81 — A.67 — Medium — Finance/Precision — Money/amount cast to float (rounding drift risk)
- Baseline ID (v34): `A.67`
- File: `app/Http/Controllers/Admin/ReportsController.php`
- Evidence: `        $outflows = (float) (clone $query)->where('type', 'withdrawal')->sum('amount');`

### A.82 — B.22 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- Baseline ID (v34): `B.22`
- File: `app/Http/Controllers/Admin/ReportsController.php`
- Evidence: `$inflows = (float) (clone $query)->where('type', 'deposit')->sum('amount');`

### A.83 — B.23 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- Baseline ID (v34): `B.23`
- File: `app/Http/Controllers/Admin/ReportsController.php`
- Evidence: `$outflows = (float) (clone $query)->where('type', 'withdrawal')->sum('amount');`

### A.84 — B.20 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- Baseline ID (v34): `B.20`
- File: `app/Http/Controllers/Admin/ReportsController.php`
- Evidence: `'cost_of_goods' => (float) $totalPurchases,`

### A.85 — B.21 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- Baseline ID (v34): `B.21`
- File: `app/Http/Controllers/Admin/ReportsController.php`
- Evidence: `'expenses' => (float) $totalExpenses,`

### A.86 — B.19 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- Baseline ID (v34): `B.19`
- File: `app/Http/Controllers/Admin/ReportsController.php`
- Evidence: `'revenue' => (float) $totalSales,`

### A.87 — A.68 — Medium — Finance/Precision — Float cast for totals
- Baseline ID (v34): `A.68`
- File: `app/Http/Controllers/Api/StoreIntegrationController.php`
- Evidence: `                    'current_stock' => (float) ($product->current_stock ?? 0),`

### A.88 — B.25 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- Baseline ID (v34): `B.25`
- File: `app/Http/Controllers/Api/StoreIntegrationController.php`
- Evidence: `$qty = (float) $item['qty'];`

### A.89 — B.24 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- Baseline ID (v34): `B.24`
- File: `app/Http/Controllers/Api/StoreIntegrationController.php`
- Evidence: `$qty = (float) $row['qty'];`

### A.90 — B.29 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- Baseline ID (v34): `B.29`
- File: `app/Http/Controllers/Api/V1/InventoryController.php`
- Evidence: `$actualQty = abs((float) $item['qty']);`

### A.91 — B.27 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- Baseline ID (v34): `B.27`
- File: `app/Http/Controllers/Api/V1/InventoryController.php`
- Evidence: `$actualQty = abs((float) $validated['qty']);`

### A.92 — B.28 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- Baseline ID (v34): `B.28`
- File: `app/Http/Controllers/Api/V1/InventoryController.php`
- Evidence: `$newQuantity = (float) $item['qty'];`

### A.93 — B.26 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- Baseline ID (v34): `B.26`
- File: `app/Http/Controllers/Api/V1/InventoryController.php`
- Evidence: `$newQuantity = (float) $validated['qty'];`

### A.94 — B.30 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- Baseline ID (v34): `B.30`
- File: `app/Http/Controllers/Api/V1/InventoryController.php`
- Evidence: `return (float) ($query->selectRaw('SUM(quantity) as balance')`

### A.95 — A.70 — Medium — Finance/Precision — Money/amount cast to float (rounding drift risk)
- Baseline ID (v34): `A.70`
- File: `app/Http/Controllers/Api/V1/OrdersController.php`
- Evidence: `                    $lineDiscount = max(0, (float) ($item['discount'] ?? 0));`

### A.96 — A.69 — Medium — Finance/Precision — Money/amount cast to float (rounding drift risk)
- Baseline ID (v34): `A.69`
- File: `app/Http/Controllers/Api/V1/OrdersController.php`
- Evidence: `                    $lineSubtotal = (float) $item['price'] * (float) $item['quantity'];`

### A.97 — A.71 — Medium — Finance/Precision — Money/amount cast to float (rounding drift risk)
- Baseline ID (v34): `A.71`
- File: `app/Http/Controllers/Api/V1/OrdersController.php`
- Evidence: `                $orderDiscount = max(0, (float) ($validated['discount'] ?? 0));`

### A.98 — A.73 — Medium — Finance/Precision — Float cast for totals
- Baseline ID (v34): `A.73`
- File: `app/Http/Controllers/Api/V1/OrdersController.php`
- Evidence: `                $shipping = max(0, (float) ($validated['shipping'] ?? 0));`

### A.99 — A.72 — Medium — Finance/Precision — Money/amount cast to float (rounding drift risk)
- Baseline ID (v34): `A.72`
- File: `app/Http/Controllers/Api/V1/OrdersController.php`
- Evidence: `                $tax = max(0, (float) ($validated['tax'] ?? 0));`

### A.100 — B.32 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- Baseline ID (v34): `B.32`
- File: `app/Http/Controllers/Api/V1/OrdersController.php`
- Evidence: `$lineDiscount = max(0, (float) ($item['discount'] ?? 0));`

### A.101 — B.31 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- Baseline ID (v34): `B.31`
- File: `app/Http/Controllers/Api/V1/OrdersController.php`
- Evidence: `$lineSubtotal = (float) $item['price'] * (float) $item['quantity'];`

### A.102 — B.33 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- Baseline ID (v34): `B.33`
- File: `app/Http/Controllers/Api/V1/OrdersController.php`
- Evidence: `$orderDiscount = max(0, (float) ($validated['discount'] ?? 0));`

### A.103 — B.35 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- Baseline ID (v34): `B.35`
- File: `app/Http/Controllers/Api/V1/OrdersController.php`
- Evidence: `$shipping = max(0, (float) ($validated['shipping'] ?? 0));`

### A.104 — B.34 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- Baseline ID (v34): `B.34`
- File: `app/Http/Controllers/Api/V1/OrdersController.php`
- Evidence: `$tax = max(0, (float) ($validated['tax'] ?? 0));`

### A.105 — A.74 — Medium — Finance/Precision — Float cast for totals
- Baseline ID (v34): `A.74`
- File: `app/Http/Controllers/Api/V1/POSController.php`
- Evidence: `                (float) ($request->input('opening_cash') ?? 0)`

### A.106 — A.75 — Medium — Finance/Precision — Money/amount cast to float (rounding drift risk)
- Baseline ID (v34): `A.75`
- File: `app/Http/Controllers/Api/V1/ProductsController.php`
- Evidence: `                'price' => (float) $product->default_price,`

### A.107 — B.39 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- Baseline ID (v34): `B.39`
- File: `app/Http/Controllers/Api/V1/ProductsController.php`
- Evidence: `$newQuantity = (float) $validated['quantity'];`

### A.108 — B.38 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- Baseline ID (v34): `B.38`
- File: `app/Http/Controllers/Api/V1/ProductsController.php`
- Evidence: `$quantity = (float) $validated['quantity'];`

### A.109 — B.36 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- Baseline ID (v34): `B.36`
- File: `app/Http/Controllers/Api/V1/ProductsController.php`
- Evidence: `'price' => (float) $product->default_price,`

### A.110 — B.37 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- Baseline ID (v34): `B.37`
- File: `app/Http/Controllers/Api/V1/ProductsController.php`
- Evidence: `'sale_price' => (float) $product->default_price, // Frontend fallback`

### A.111 — A.76 — Medium — Logic/Files — Local disk URL generation may fail
- Baseline ID (v34): `A.76`
- File: `app/Http/Controllers/Branch/ProductController.php`
- Evidence: `            'url' => Storage::disk('local')->url($path),`

### A.112 — A.77 — Medium — Finance/Precision — Money/amount cast to float (rounding drift risk)
- Baseline ID (v34): `A.77`
- File: `app/Http/Controllers/Branch/PurchaseController.php`
- Evidence: `        return $this->ok($this->purchases->pay($purchase, (float) $data['amount']), __('Paid'));`

### A.113 — B.40 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- Baseline ID (v34): `B.40`
- File: `app/Http/Controllers/Branch/PurchaseController.php`
- Evidence: `return $this->ok($this->purchases->pay($purchase, (float) $data['amount']), __('Paid'));`

### A.114 — A.81 — Medium — Finance/Precision — Money/amount cast to float (rounding drift risk)
- Baseline ID (v34): `A.81`
- File: `app/Http/Controllers/Branch/Purchases/ExportImportController.php`
- Evidence: `                        'discount_amount' => (float) ($rowData['discount'] ?? 0),`

### A.115 — A.82 — Medium — Finance/Precision — Money/amount cast to float (rounding drift risk)
- Baseline ID (v34): `A.82`
- File: `app/Http/Controllers/Branch/Purchases/ExportImportController.php`
- Evidence: `                        'paid_amount' => (float) ($rowData['paid'] ?? 0),`

### A.116 — A.79 — Medium — Finance/Precision — Money/amount cast to float (rounding drift risk)
- Baseline ID (v34): `A.79`
- File: `app/Http/Controllers/Branch/Purchases/ExportImportController.php`
- Evidence: `                        'subtotal' => (float) ($rowData['subtotal'] ?? $rowData['total']),`

### A.117 — A.80 — Medium — Finance/Precision — Money/amount cast to float (rounding drift risk)
- Baseline ID (v34): `A.80`
- File: `app/Http/Controllers/Branch/Purchases/ExportImportController.php`
- Evidence: `                        'tax_amount' => (float) ($rowData['tax'] ?? 0),`

### A.118 — A.78 — Medium — Finance/Precision — Money/amount cast to float (rounding drift risk)
- Baseline ID (v34): `A.78`
- File: `app/Http/Controllers/Branch/Purchases/ExportImportController.php`
- Evidence: `                        'total_amount' => (float) $rowData['total'],`

### A.119 — B.44 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- Baseline ID (v34): `B.44`
- File: `app/Http/Controllers/Branch/Purchases/ExportImportController.php`
- Evidence: `'discount_amount' => (float) ($rowData['discount'] ?? 0),`

### A.120 — B.45 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- Baseline ID (v34): `B.45`
- File: `app/Http/Controllers/Branch/Purchases/ExportImportController.php`
- Evidence: `'paid_amount' => (float) ($rowData['paid'] ?? 0),`

### A.121 — B.42 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- Baseline ID (v34): `B.42`
- File: `app/Http/Controllers/Branch/Purchases/ExportImportController.php`
- Evidence: `'subtotal' => (float) ($rowData['subtotal'] ?? $rowData['total']),`

### A.122 — B.43 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- Baseline ID (v34): `B.43`
- File: `app/Http/Controllers/Branch/Purchases/ExportImportController.php`
- Evidence: `'tax_amount' => (float) ($rowData['tax'] ?? 0),`

### A.123 — B.41 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- Baseline ID (v34): `B.41`
- File: `app/Http/Controllers/Branch/Purchases/ExportImportController.php`
- Evidence: `'total_amount' => (float) $rowData['total'],`

### A.124 — A.83 — Medium — Finance/Precision — Money/amount cast to float (rounding drift risk)
- Baseline ID (v34): `A.83`
- File: `app/Http/Controllers/Branch/Rental/InvoiceController.php`
- Evidence: `                (float) $data['amount'],`

### A.125 — B.46 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- Baseline ID (v34): `B.46`
- File: `app/Http/Controllers/Branch/Rental/InvoiceController.php`
- Evidence: `(float) $data['amount'],`

### A.126 — A.87 — Medium — Finance/Precision — Money/amount cast to float (rounding drift risk)
- Baseline ID (v34): `A.87`
- File: `app/Http/Controllers/Branch/Sales/ExportImportController.php`
- Evidence: `                        'discount_amount' => (float) ($rowData['discount'] ?? 0),`

### A.127 — A.88 — Medium — Finance/Precision — Money/amount cast to float (rounding drift risk)
- Baseline ID (v34): `A.88`
- File: `app/Http/Controllers/Branch/Sales/ExportImportController.php`
- Evidence: `                        'paid_amount' => (float) ($rowData['paid'] ?? 0),`

### A.128 — A.85 — Medium — Finance/Precision — Money/amount cast to float (rounding drift risk)
- Baseline ID (v34): `A.85`
- File: `app/Http/Controllers/Branch/Sales/ExportImportController.php`
- Evidence: `                        'subtotal' => (float) ($rowData['subtotal'] ?? $rowData['total']),`

### A.129 — A.86 — Medium — Finance/Precision — Money/amount cast to float (rounding drift risk)
- Baseline ID (v34): `A.86`
- File: `app/Http/Controllers/Branch/Sales/ExportImportController.php`
- Evidence: `                        'tax_amount' => (float) ($rowData['tax'] ?? 0),`

### A.130 — A.84 — Medium — Finance/Precision — Money/amount cast to float (rounding drift risk)
- Baseline ID (v34): `A.84`
- File: `app/Http/Controllers/Branch/Sales/ExportImportController.php`
- Evidence: `                        'total_amount' => (float) $rowData['total'],`

### A.131 — B.50 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- Baseline ID (v34): `B.50`
- File: `app/Http/Controllers/Branch/Sales/ExportImportController.php`
- Evidence: `'discount_amount' => (float) ($rowData['discount'] ?? 0),`

### A.132 — B.51 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- Baseline ID (v34): `B.51`
- File: `app/Http/Controllers/Branch/Sales/ExportImportController.php`
- Evidence: `'paid_amount' => (float) ($rowData['paid'] ?? 0),`

### A.133 — B.48 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- Baseline ID (v34): `B.48`
- File: `app/Http/Controllers/Branch/Sales/ExportImportController.php`
- Evidence: `'subtotal' => (float) ($rowData['subtotal'] ?? $rowData['total']),`

### A.134 — B.49 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- Baseline ID (v34): `B.49`
- File: `app/Http/Controllers/Branch/Sales/ExportImportController.php`
- Evidence: `'tax_amount' => (float) ($rowData['tax'] ?? 0),`

### A.135 — B.47 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- Baseline ID (v34): `B.47`
- File: `app/Http/Controllers/Branch/Sales/ExportImportController.php`
- Evidence: `'total_amount' => (float) $rowData['total'],`

### A.136 — B.52 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- Baseline ID (v34): `B.52`
- File: `app/Http/Controllers/Branch/StockController.php`
- Evidence: `$m = $this->inv->adjust($product->id, (float) $data['qty'], $warehouseId, $data['note'] ?? null);`

### A.137 — B.53 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- Baseline ID (v34): `B.53`
- File: `app/Http/Controllers/Branch/StockController.php`
- Evidence: `$res = $this->inv->transfer($product->id, (float) $data['qty'], $data['from_warehouse'], $data['to_warehouse']);`

### A.138 — A.89 — Medium — Perf/Security — Loads entire file into memory (Storage::get)
- Baseline ID (v34): `A.89`
- File: `app/Http/Controllers/Files/UploadController.php`
- Evidence: `        $content = $storage->get($path);`

### A.139 — A.90 — Medium — Security/Auth — Token accepted via query/body (leak risk)
- Baseline ID (v34): `A.90`
- File: `app/Http/Middleware/AuthenticateStoreToken.php`
- Evidence: `        return $request->query('api_token') ?? $request->input('api_token');`

### A.140 — B.54 — Medium — Security/Auth — api_token accepted from query/body (leakage risk)
- Baseline ID (v34): `B.54`
- File: `app/Http/Middleware/AuthenticateStoreToken.php`
- Evidence: `return $request->query('api_token') ?? $request->input('api_token');`

### A.141 — A.91 — Medium — Finance/Precision — Money/amount cast to float (rounding drift risk)
- Baseline ID (v34): `A.91`
- File: `app/Http/Middleware/EnforceDiscountLimit.php`
- Evidence: `            $disc = (float) ($row['discount'] ?? 0);`

### A.142 — A.92 — Medium — Finance/Precision — Float cast for totals
- Baseline ID (v34): `A.92`
- File: `app/Http/Middleware/EnforceDiscountLimit.php`
- Evidence: `        $invDisc = (float) ($payload['invoice_discount'] ?? 0);`

### A.143 — A.94 — Medium — Finance/Precision — Money/amount cast to float (rounding drift risk)
- Baseline ID (v34): `A.94`
- File: `app/Http/Middleware/EnforceDiscountLimit.php`
- Evidence: `        return (float) (config('erp.discount.max_invoice', 20));`

### A.144 — A.93 — Medium — Finance/Precision — Money/amount cast to float (rounding drift risk)
- Baseline ID (v34): `A.93`
- File: `app/Http/Middleware/EnforceDiscountLimit.php`
- Evidence: `        return (float) (config('erp.discount.max_line', 15)); // sensible default`

### A.145 — B.55 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- Baseline ID (v34): `B.55`
- File: `app/Http/Middleware/EnforceDiscountLimit.php`
- Evidence: `$disc = (float) ($row['discount'] ?? 0);`

### A.146 — B.56 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- Baseline ID (v34): `B.56`
- File: `app/Http/Middleware/EnforceDiscountLimit.php`
- Evidence: `$invDisc = (float) ($payload['invoice_discount'] ?? 0);`

### A.147 — B.59 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- Baseline ID (v34): `B.59`
- File: `app/Http/Middleware/EnforceDiscountLimit.php`
- Evidence: `return (float) $user->max_invoice_discount;`

### A.148 — B.57 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- Baseline ID (v34): `B.57`
- File: `app/Http/Middleware/EnforceDiscountLimit.php`
- Evidence: `return (float) $user->max_line_discount;`

### A.149 — B.60 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- Baseline ID (v34): `B.60`
- File: `app/Http/Middleware/EnforceDiscountLimit.php`
- Evidence: `return (float) (config('erp.discount.max_invoice', 20));`

### A.150 — B.58 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- Baseline ID (v34): `B.58`
- File: `app/Http/Middleware/EnforceDiscountLimit.php`
- Evidence: `return (float) (config('erp.discount.max_line', 15)); // sensible default`

### A.151 — A.97 — Medium — Finance/Precision — Money/amount cast to float (rounding drift risk)
- Baseline ID (v34): `A.97`
- File: `app/Http/Resources/CustomerResource.php`
- Evidence: `                (float) ($this->balance ?? 0.0)`

### A.152 — A.95 — Medium — Finance/Precision — Float cast for totals
- Baseline ID (v34): `A.95`
- File: `app/Http/Resources/CustomerResource.php`
- Evidence: `                (float) ($this->credit_limit ?? 0.0)`

### A.153 — A.96 — Medium — Finance/Precision — Float cast for totals
- Baseline ID (v34): `A.96`
- File: `app/Http/Resources/CustomerResource.php`
- Evidence: `                (float) ($this->discount_percentage ?? 0.0)`

### A.154 — A.98 — Medium — Finance/Precision — Float cast for totals
- Baseline ID (v34): `A.98`
- File: `app/Http/Resources/CustomerResource.php`
- Evidence: `                (float) ($this->total_purchases ?? 0.0)`

### A.155 — B.63 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- Baseline ID (v34): `B.63`
- File: `app/Http/Resources/CustomerResource.php`
- Evidence: `(float) ($this->balance ?? 0.0)`

### A.156 — B.61 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- Baseline ID (v34): `B.61`
- File: `app/Http/Resources/CustomerResource.php`
- Evidence: `(float) ($this->credit_limit ?? 0.0)`

### A.157 — B.62 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- Baseline ID (v34): `B.62`
- File: `app/Http/Resources/CustomerResource.php`
- Evidence: `(float) ($this->discount_percentage ?? 0.0)`

### A.158 — B.64 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- Baseline ID (v34): `B.64`
- File: `app/Http/Resources/CustomerResource.php`
- Evidence: `(float) ($this->total_purchases ?? 0.0)`

### A.159 — A.99 — Medium — Finance/Precision — Money/amount cast to float (rounding drift risk)
- Baseline ID (v34): `A.99`
- File: `app/Http/Resources/OrderItemResource.php`
- Evidence: `            'discount' => (float) $this->discount,`

### A.160 — A.100 — Medium — Finance/Precision — Money/amount cast to float (rounding drift risk)
- Baseline ID (v34): `A.100`
- File: `app/Http/Resources/OrderItemResource.php`
- Evidence: `            'tax' => (float) ($this->tax ?? 0),`

### A.161 — A.101 — Medium — Finance/Precision — Money/amount cast to float (rounding drift risk)
- Baseline ID (v34): `A.101`
- File: `app/Http/Resources/OrderItemResource.php`
- Evidence: `            'total' => (float) $this->line_total,`

### A.162 — B.66 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- Baseline ID (v34): `B.66`
- File: `app/Http/Resources/OrderItemResource.php`
- Evidence: `'discount' => (float) $this->discount,`

### A.163 — B.67 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- Baseline ID (v34): `B.67`
- File: `app/Http/Resources/OrderItemResource.php`
- Evidence: `'tax' => (float) ($this->tax ?? 0),`

### A.164 — B.68 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- Baseline ID (v34): `B.68`
- File: `app/Http/Resources/OrderItemResource.php`
- Evidence: `'total' => (float) $this->line_total,`

### A.165 — B.65 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- Baseline ID (v34): `B.65`
- File: `app/Http/Resources/OrderItemResource.php`
- Evidence: `'unit_price' => (float) $this->unit_price,`

### A.166 — A.102 — Medium — Finance/Precision — Money/amount cast to float (rounding drift risk)
- Baseline ID (v34): `A.102`
- File: `app/Http/Resources/OrderResource.php`
- Evidence: `            'discount' => (float) $this->discount,`

### A.167 — A.105 — Medium — Finance/Precision — Float cast for totals
- Baseline ID (v34): `A.105`
- File: `app/Http/Resources/OrderResource.php`
- Evidence: `            'paid_amount' => (float) ($this->paid_total ?? 0),`

### A.168 — A.103 — Medium — Finance/Precision — Money/amount cast to float (rounding drift risk)
- Baseline ID (v34): `A.103`
- File: `app/Http/Resources/OrderResource.php`
- Evidence: `            'tax' => (float) $this->tax,`

### A.169 — A.104 — Medium — Finance/Precision — Money/amount cast to float (rounding drift risk)
- Baseline ID (v34): `A.104`
- File: `app/Http/Resources/OrderResource.php`
- Evidence: `            'total' => (float) $this->grand_total,`

### A.170 — A.107 — Medium — Finance/Precision — Float cast for totals
- Baseline ID (v34): `A.107`
- File: `app/Http/Resources/OrderResource.php`
- Evidence: `        $grandTotal = (float) ($this->grand_total ?? 0);`

### A.171 — A.106 — Medium — Finance/Precision — Float cast for totals
- Baseline ID (v34): `A.106`
- File: `app/Http/Resources/OrderResource.php`
- Evidence: `        $paidTotal = (float) ($this->paid_total ?? 0);`

### A.172 — B.76 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- Baseline ID (v34): `B.76`
- File: `app/Http/Resources/OrderResource.php`
- Evidence: `$grandTotal = (float) ($this->grand_total ?? 0);`

### A.173 — B.75 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- Baseline ID (v34): `B.75`
- File: `app/Http/Resources/OrderResource.php`
- Evidence: `$paidTotal = (float) ($this->paid_total ?? 0);`

### A.174 — B.70 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- Baseline ID (v34): `B.70`
- File: `app/Http/Resources/OrderResource.php`
- Evidence: `'discount' => (float) $this->discount,`

### A.175 — B.74 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- Baseline ID (v34): `B.74`
- File: `app/Http/Resources/OrderResource.php`
- Evidence: `'due_amount' => (float) $this->due_total,`

### A.176 — B.73 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- Baseline ID (v34): `B.73`
- File: `app/Http/Resources/OrderResource.php`
- Evidence: `'paid_amount' => (float) ($this->paid_total ?? 0),`

### A.177 — B.69 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- Baseline ID (v34): `B.69`
- File: `app/Http/Resources/OrderResource.php`
- Evidence: `'subtotal' => (float) $this->sub_total,`

### A.178 — B.71 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- Baseline ID (v34): `B.71`
- File: `app/Http/Resources/OrderResource.php`
- Evidence: `'tax' => (float) $this->tax,`

### A.179 — B.72 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- Baseline ID (v34): `B.72`
- File: `app/Http/Resources/OrderResource.php`
- Evidence: `'total' => (float) $this->grand_total,`

### A.180 — A.109 — Medium — Finance/Precision — Money/amount cast to float (rounding drift risk)
- Baseline ID (v34): `A.109`
- File: `app/Http/Resources/ProductResource.php`
- Evidence: `            'cost' => $this->when(self::$canViewCost, (float) $this->cost),`

### A.181 — A.108 — Medium — Finance/Precision — Money/amount cast to float (rounding drift risk)
- Baseline ID (v34): `A.108`
- File: `app/Http/Resources/ProductResource.php`
- Evidence: `            'price' => (float) $this->default_price,`

### A.182 — B.78 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- Baseline ID (v34): `B.78`
- File: `app/Http/Resources/ProductResource.php`
- Evidence: `'cost' => $this->when(self::$canViewCost, (float) $this->cost),`

### A.183 — B.77 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- Baseline ID (v34): `B.77`
- File: `app/Http/Resources/ProductResource.php`
- Evidence: `'price' => (float) $this->default_price,`

### A.184 — B.79 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- Baseline ID (v34): `B.79`
- File: `app/Http/Resources/ProductResource.php`
- Evidence: `'reorder_qty' => $this->reorder_qty ? (float) $this->reorder_qty : 0.0,`

### A.185 — A.112 — Medium — Finance/Precision — Float cast for totals
- Baseline ID (v34): `A.112`
- File: `app/Http/Resources/PurchaseResource.php`
- Evidence: `            'discount_total' => (float) ($this->discount_total ?? 0.0),`

### A.186 — A.116 — Medium — Finance/Precision — Float cast for totals
- Baseline ID (v34): `A.116`
- File: `app/Http/Resources/PurchaseResource.php`
- Evidence: `            'due_total' => (float) ($this->due_total ?? 0.0),`

### A.187 — A.114 — Medium — Finance/Precision — Float cast for totals
- Baseline ID (v34): `A.114`
- File: `app/Http/Resources/PurchaseResource.php`
- Evidence: `            'grand_total' => (float) ($this->grand_total ?? 0.0),`

### A.188 — A.115 — Medium — Finance/Precision — Float cast for totals
- Baseline ID (v34): `A.115`
- File: `app/Http/Resources/PurchaseResource.php`
- Evidence: `            'paid_total' => (float) ($this->paid_total ?? 0.0),`

### A.189 — A.113 — Medium — Finance/Precision — Float cast for totals
- Baseline ID (v34): `A.113`
- File: `app/Http/Resources/PurchaseResource.php`
- Evidence: `            'shipping_total' => (float) ($this->shipping_total ?? 0.0),`

### A.190 — A.110 — Medium — Finance/Precision — Float cast for totals
- Baseline ID (v34): `A.110`
- File: `app/Http/Resources/PurchaseResource.php`
- Evidence: `            'sub_total' => (float) ($this->sub_total ?? 0.0),`

### A.191 — A.111 — Medium — Finance/Precision — Float cast for totals
- Baseline ID (v34): `A.111`
- File: `app/Http/Resources/PurchaseResource.php`
- Evidence: `            'tax_total' => (float) ($this->tax_total ?? 0.0),`

### A.192 — B.82 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- Baseline ID (v34): `B.82`
- File: `app/Http/Resources/PurchaseResource.php`
- Evidence: `'discount_total' => (float) ($this->discount_total ?? 0.0),`

### A.193 — B.86 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- Baseline ID (v34): `B.86`
- File: `app/Http/Resources/PurchaseResource.php`
- Evidence: `'due_total' => (float) ($this->due_total ?? 0.0),`

### A.194 — B.84 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- Baseline ID (v34): `B.84`
- File: `app/Http/Resources/PurchaseResource.php`
- Evidence: `'grand_total' => (float) ($this->grand_total ?? 0.0),`

### A.195 — B.85 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- Baseline ID (v34): `B.85`
- File: `app/Http/Resources/PurchaseResource.php`
- Evidence: `'paid_total' => (float) ($this->paid_total ?? 0.0),`

### A.196 — B.83 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- Baseline ID (v34): `B.83`
- File: `app/Http/Resources/PurchaseResource.php`
- Evidence: `'shipping_total' => (float) ($this->shipping_total ?? 0.0),`

### A.197 — B.80 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- Baseline ID (v34): `B.80`
- File: `app/Http/Resources/PurchaseResource.php`
- Evidence: `'sub_total' => (float) ($this->sub_total ?? 0.0),`

### A.198 — B.81 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- Baseline ID (v34): `B.81`
- File: `app/Http/Resources/PurchaseResource.php`
- Evidence: `'tax_total' => (float) ($this->tax_total ?? 0.0),`

### A.199 — A.119 — Medium — Finance/Precision — Float cast for totals
- Baseline ID (v34): `A.119`
- File: `app/Http/Resources/SaleResource.php`
- Evidence: `            'discount_total' => (float) ($this->discount_total ?? 0.0),`

### A.200 — A.123 — Medium — Finance/Precision — Float cast for totals
- Baseline ID (v34): `A.123`
- File: `app/Http/Resources/SaleResource.php`
- Evidence: `            'due_total' => (float) ($this->due_total ?? 0.0),`

### A.201 — A.121 — Medium — Finance/Precision — Float cast for totals
- Baseline ID (v34): `A.121`
- File: `app/Http/Resources/SaleResource.php`
- Evidence: `            'grand_total' => (float) ($this->grand_total ?? 0.0),`

### A.202 — A.122 — Medium — Finance/Precision — Float cast for totals
- Baseline ID (v34): `A.122`
- File: `app/Http/Resources/SaleResource.php`
- Evidence: `            'paid_total' => (float) ($this->paid_total ?? 0.0),`

### A.203 — A.120 — Medium — Finance/Precision — Float cast for totals
- Baseline ID (v34): `A.120`
- File: `app/Http/Resources/SaleResource.php`
- Evidence: `            'shipping_total' => (float) ($this->shipping_total ?? 0.0),`

### A.204 — A.117 — Medium — Finance/Precision — Float cast for totals
- Baseline ID (v34): `A.117`
- File: `app/Http/Resources/SaleResource.php`
- Evidence: `            'sub_total' => (float) ($this->sub_total ?? 0.0),`

### A.205 — A.118 — Medium — Finance/Precision — Float cast for totals
- Baseline ID (v34): `A.118`
- File: `app/Http/Resources/SaleResource.php`
- Evidence: `            'tax_total' => (float) ($this->tax_total ?? 0.0),`

### A.206 — B.87 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- Baseline ID (v34): `B.87`
- File: `app/Http/Resources/SaleResource.php`
- Evidence: `'discount_amount' => $this->discount_amount ? (float) $this->discount_amount : null,`

### A.207 — B.90 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- Baseline ID (v34): `B.90`
- File: `app/Http/Resources/SaleResource.php`
- Evidence: `'discount_total' => (float) ($this->discount_total ?? 0.0),`

### A.208 — B.94 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- Baseline ID (v34): `B.94`
- File: `app/Http/Resources/SaleResource.php`
- Evidence: `'due_total' => (float) ($this->due_total ?? 0.0),`

### A.209 — B.92 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- Baseline ID (v34): `B.92`
- File: `app/Http/Resources/SaleResource.php`
- Evidence: `'grand_total' => (float) ($this->grand_total ?? 0.0),`

### A.210 — B.93 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- Baseline ID (v34): `B.93`
- File: `app/Http/Resources/SaleResource.php`
- Evidence: `'paid_total' => (float) ($this->paid_total ?? 0.0),`

### A.211 — B.91 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- Baseline ID (v34): `B.91`
- File: `app/Http/Resources/SaleResource.php`
- Evidence: `'shipping_total' => (float) ($this->shipping_total ?? 0.0),`

### A.212 — B.88 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- Baseline ID (v34): `B.88`
- File: `app/Http/Resources/SaleResource.php`
- Evidence: `'sub_total' => (float) ($this->sub_total ?? 0.0),`

### A.213 — B.89 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- Baseline ID (v34): `B.89`
- File: `app/Http/Resources/SaleResource.php`
- Evidence: `'tax_total' => (float) ($this->tax_total ?? 0.0),`

### A.214 — A.124 — Medium — Finance/Precision — Float cast for totals
- Baseline ID (v34): `A.124`
- File: `app/Http/Resources/SupplierResource.php`
- Evidence: `                (float) ($this->minimum_order_value ?? 0.0)`

### A.215 — B.96 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- Baseline ID (v34): `B.96`
- File: `app/Http/Resources/SupplierResource.php`
- Evidence: `(float) ($this->minimum_order_value ?? 0.0)`

### A.216 — B.97 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- Baseline ID (v34): `B.97`
- File: `app/Http/Resources/SupplierResource.php`
- Evidence: `fn () => (float) $this->purchases->sum('total_amount')`

### A.217 — B.95 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- Baseline ID (v34): `B.95`
- File: `app/Http/Resources/SupplierResource.php`
- Evidence: `return $value ? (float) $value : null;`

### A.218 — A.125 — Medium — Finance/Precision — Money/amount cast to float (rounding drift risk)
- Baseline ID (v34): `A.125`
- File: `app/Jobs/ClosePosDayJob.php`
- Evidence: `            $paid = (float) $paidString;`

### A.219 — B.98 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- Baseline ID (v34): `B.98`
- File: `app/Jobs/ClosePosDayJob.php`
- Evidence: `$paid = (float) $paidString;`

### A.220 — A.126 — Medium — Finance/Precision — Money/amount cast to float (rounding drift risk)
- Baseline ID (v34): `A.126`
- File: `app/Listeners/ApplyLateFee.php`
- Evidence: `        $invoice->amount = (float) $newAmount;`

### A.221 — B.99 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- Baseline ID (v34): `B.99`
- File: `app/Listeners/ApplyLateFee.php`
- Evidence: `$invoice->amount = (float) $newAmount;`

### A.222 — B.100 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- Baseline ID (v34): `B.100`
- File: `app/Listeners/UpdateStockOnPurchase.php`
- Evidence: `$itemQty = (float) $item->quantity;`

### A.223 — B.101 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- Baseline ID (v34): `B.101`
- File: `app/Listeners/UpdateStockOnSale.php`
- Evidence: `$baseQuantity = (float) $item->quantity * (float) $conversionFactor;`

### A.224 — A.127 — Medium — Finance/Precision — Money/amount cast to float (rounding drift risk)
- Baseline ID (v34): `A.127`
- File: `app/Livewire/Accounting/JournalEntries/Form.php`
- Evidence: `                        'amount' => number_format((float) ltrim($difference, '-'), 2),`

### A.225 — B.102 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- Baseline ID (v34): `B.102`
- File: `app/Livewire/Accounting/JournalEntries/Form.php`
- Evidence: `'amount' => number_format((float) ltrim($difference, '-'), 2),`

### A.226 — B.103 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- Baseline ID (v34): `B.103`
- File: `app/Livewire/Admin/CurrencyRate/Form.php`
- Evidence: `$this->rate = (float) $rate->rate;`

### A.227 — B.104 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- Baseline ID (v34): `B.104`
- File: `app/Livewire/Admin/Installments/Index.php`
- Evidence: `$this->paymentAmount = (float) $payment->remaining_amount;`

### A.228 — B.106 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- Baseline ID (v34): `B.106`
- File: `app/Livewire/Admin/Loyalty/Index.php`
- Evidence: `$this->amount_per_point = (float) $settings->amount_per_point;`

### A.229 — B.105 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- Baseline ID (v34): `B.105`
- File: `app/Livewire/Admin/Loyalty/Index.php`
- Evidence: `$this->points_per_amount = (float) $settings->points_per_amount;`

### A.230 — B.107 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- Baseline ID (v34): `B.107`
- File: `app/Livewire/Admin/Loyalty/Index.php`
- Evidence: `$this->redemption_rate = (float) $settings->redemption_rate;`

### A.231 — B.108 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- Baseline ID (v34): `B.108`
- File: `app/Livewire/Admin/Modules/RentalPeriods/Form.php`
- Evidence: `$this->price_multiplier = (float) $period->price_multiplier;`

### A.232 — B.109 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- Baseline ID (v34): `B.109`
- File: `app/Livewire/Admin/Reports/InventoryChartsDashboard.php`
- Evidence: `$totalStock = (float) $products->sum('current_stock');`

### A.233 — B.110 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- Baseline ID (v34): `B.110`
- File: `app/Livewire/Admin/Reports/InventoryChartsDashboard.php`
- Evidence: `$values[] = (float) $product->current_stock;`

### A.234 — B.113 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- Baseline ID (v34): `B.113`
- File: `app/Livewire/Admin/Reports/PosChartsDashboard.php`
- Evidence: `$branchValues[] = (float) $items->sum('grand_total');`

### A.235 — B.112 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- Baseline ID (v34): `B.112`
- File: `app/Livewire/Admin/Reports/PosChartsDashboard.php`
- Evidence: `$dayValues[] = (float) $items->sum('grand_total');`

### A.236 — B.111 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- Baseline ID (v34): `B.111`
- File: `app/Livewire/Admin/Reports/PosChartsDashboard.php`
- Evidence: `$totalRevenue = (float) $sales->sum('grand_total');`

### A.237 — A.128 — Medium — Finance/Precision — Float cast for totals
- Baseline ID (v34): `A.128`
- File: `app/Livewire/Admin/Settings/PurchasesSettings.php`
- Evidence: `        $this->purchase_approval_threshold = (float) ($settings['purchases.approval_threshold'] ?? 10000);`

### A.238 — A.133 — Medium — Finance/Precision — Float cast for totals
- Baseline ID (v34): `A.133`
- File: `app/Livewire/Admin/Settings/UnifiedSettings.php`
- Evidence: `        $this->hrm_health_insurance_deduction = (float) ($settings['hrm.health_insurance_deduction'] ?? 0.0);`

### A.239 — A.131 — Medium — Finance/Precision — Float cast for totals
- Baseline ID (v34): `A.131`
- File: `app/Livewire/Admin/Settings/UnifiedSettings.php`
- Evidence: `        $this->hrm_housing_allowance_value = (float) ($settings['hrm.housing_allowance_value'] ?? 0.0);`

### A.240 — A.132 — Medium — Finance/Precision — Float cast for totals
- Baseline ID (v34): `A.132`
- File: `app/Livewire/Admin/Settings/UnifiedSettings.php`
- Evidence: `        $this->hrm_meal_allowance = (float) ($settings['hrm.meal_allowance'] ?? 0.0);`

### A.241 — A.130 — Medium — Finance/Precision — Float cast for totals
- Baseline ID (v34): `A.130`
- File: `app/Livewire/Admin/Settings/UnifiedSettings.php`
- Evidence: `        $this->hrm_transport_allowance_value = (float) ($settings['hrm.transport_allowance_value'] ?? 10.0);`

### A.242 — A.129 — Medium — Finance/Precision — Float cast for totals
- Baseline ID (v34): `A.129`
- File: `app/Livewire/Admin/Settings/UnifiedSettings.php`
- Evidence: `        $this->hrm_working_hours_per_day = (float) ($settings['hrm.working_hours_per_day'] ?? 8.0);`

### A.243 — A.134 — Medium — Finance/Precision — Float cast for totals
- Baseline ID (v34): `A.134`
- File: `app/Livewire/Admin/Settings/UnifiedSettings.php`
- Evidence: `        $this->rental_penalty_value = (float) ($settings['rental.penalty_value'] ?? 5.0);`

### A.244 — B.115 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- Baseline ID (v34): `B.115`
- File: `app/Livewire/Admin/Settings/UnifiedSettings.php`
- Evidence: `$this->hrm_housing_allowance_value = (float) ($settings['hrm.housing_allowance_value'] ?? 0.0);`

### A.245 — B.114 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- Baseline ID (v34): `B.114`
- File: `app/Livewire/Admin/Settings/UnifiedSettings.php`
- Evidence: `$this->hrm_transport_allowance_value = (float) ($settings['hrm.transport_allowance_value'] ?? 10.0);`

### A.246 — B.116 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- Baseline ID (v34): `B.116`
- File: `app/Livewire/Admin/Settings/UnifiedSettings.php`
- Evidence: `$this->rental_penalty_value = (float) ($settings['rental.penalty_value'] ?? 5.0);`

### A.247 — A.137 — Medium — Finance/Precision — Money/amount cast to float (rounding drift risk)
- Baseline ID (v34): `A.137`
- File: `app/Livewire/Admin/Store/OrdersDashboard.php`
- Evidence: `            $dayValues[] = (float) $items->sum('total');`

### A.248 — A.136 — Medium — Finance/Precision — Money/amount cast to float (rounding drift risk)
- Baseline ID (v34): `A.136`
- File: `app/Livewire/Admin/Store/OrdersDashboard.php`
- Evidence: `            $sources[$source]['revenue'] += (float) $order->total;`

### A.249 — A.135 — Medium — Finance/Precision — Money/amount cast to float (rounding drift risk)
- Baseline ID (v34): `A.135`
- File: `app/Livewire/Admin/Store/OrdersDashboard.php`
- Evidence: `        $totalRevenue = (float) $ordersForStats->sum('total');`

### A.250 — B.122 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- Baseline ID (v34): `B.122`
- File: `app/Livewire/Admin/Store/OrdersDashboard.php`
- Evidence: `$dayValues[] = (float) $items->sum('total');`

### A.251 — B.121 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- Baseline ID (v34): `B.121`
- File: `app/Livewire/Admin/Store/OrdersDashboard.php`
- Evidence: `$sources[$source]['revenue'] += (float) $order->total;`

### A.252 — B.118 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- Baseline ID (v34): `B.118`
- File: `app/Livewire/Admin/Store/OrdersDashboard.php`
- Evidence: `$totalDiscount = (float) $ordersForStats->sum('discount_total');`

### A.253 — B.117 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- Baseline ID (v34): `B.117`
- File: `app/Livewire/Admin/Store/OrdersDashboard.php`
- Evidence: `$totalRevenue = (float) $ordersForStats->sum('total');`

### A.254 — B.119 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- Baseline ID (v34): `B.119`
- File: `app/Livewire/Admin/Store/OrdersDashboard.php`
- Evidence: `$totalShipping = (float) $ordersForStats->sum('shipping_total');`

### A.255 — B.120 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- Baseline ID (v34): `B.120`
- File: `app/Livewire/Admin/Store/OrdersDashboard.php`
- Evidence: `$totalTax = (float) $ordersForStats->sum('tax_total');`

### A.256 — A.138 — Medium — Finance/Precision — Money/amount cast to float (rounding drift risk)
- Baseline ID (v34): `A.138`
- File: `app/Livewire/Banking/Reconciliation.php`
- Evidence: `                'amount' => number_format((float) $this->difference, 2),`

### A.257 — B.123 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- Baseline ID (v34): `B.123`
- File: `app/Livewire/Banking/Reconciliation.php`
- Evidence: `'amount' => number_format((float) $this->difference, 2),`

### A.258 — A.139 — Medium — Finance/Precision — Float cast for totals
- Baseline ID (v34): `A.139`
- File: `app/Livewire/Concerns/LoadsDashboardData.php`
- Evidence: `            $data[] = (float) ($salesByDate[$dateKey] ?? 0);`

### A.259 — A.140 — Medium — Finance/Precision — Float cast for totals
- Baseline ID (v34): `A.140`
- File: `app/Livewire/Customers/Form.php`
- Evidence: `            $this->credit_limit = (float) ($customer->credit_limit ?? 0);`

### A.260 — A.141 — Medium — Finance/Precision — Float cast for totals
- Baseline ID (v34): `A.141`
- File: `app/Livewire/Customers/Form.php`
- Evidence: `            $this->discount_percentage = (float) ($customer->discount_percentage ?? 0);`

### A.261 — B.124 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- Baseline ID (v34): `B.124`
- File: `app/Livewire/Customers/Form.php`
- Evidence: `$this->credit_limit = (float) ($customer->credit_limit ?? 0);`

### A.262 — B.125 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- Baseline ID (v34): `B.125`
- File: `app/Livewire/Customers/Form.php`
- Evidence: `$this->discount_percentage = (float) ($customer->discount_percentage ?? 0);`

### A.263 — A.142 — Medium — Finance/Precision — Float cast for totals
- Baseline ID (v34): `A.142`
- File: `app/Livewire/Hrm/Employees/Form.php`
- Evidence: `            $this->form['salary'] = (float) ($employeeModel->salary ?? 0);`

### A.264 — B.126 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- Baseline ID (v34): `B.126`
- File: `app/Livewire/Hrm/Reports/Dashboard.php`
- Evidence: `'total_net' => (float) $group->sum('net'),`

### A.265 — A.143 — Medium — Finance/Precision — Money/amount cast to float (rounding drift risk)
- Baseline ID (v34): `A.143`
- File: `app/Livewire/Income/Form.php`
- Evidence: `            $this->amount = (float) $income->amount;`

### A.266 — B.127 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- Baseline ID (v34): `B.127`
- File: `app/Livewire/Income/Form.php`
- Evidence: `$this->amount = (float) $income->amount;`

### A.267 — A.145 — Medium — Finance/Precision — Money/amount cast to float (rounding drift risk)
- Baseline ID (v34): `A.145`
- File: `app/Livewire/Inventory/Products/Form.php`
- Evidence: `            $this->form['cost'] = (float) ($p->standard_cost ?? $p->cost ?? 0);`

### A.268 — A.146 — Medium — Finance/Precision — Float cast for totals
- Baseline ID (v34): `A.146`
- File: `app/Livewire/Inventory/Products/Form.php`
- Evidence: `            $this->form['min_stock'] = (float) ($p->min_stock ?? 0);`

### A.269 — A.144 — Medium — Finance/Precision — Money/amount cast to float (rounding drift risk)
- Baseline ID (v34): `A.144`
- File: `app/Livewire/Inventory/Products/Form.php`
- Evidence: `            $this->form['price'] = (float) ($p->default_price ?? $p->price ?? 0);`

### A.270 — A.147 — Medium — Finance/Precision — Float cast for totals
- Baseline ID (v34): `A.147`
- File: `app/Livewire/Inventory/Products/Form.php`
- Evidence: `            $this->form['reorder_point'] = (float) ($p->reorder_point ?? 0);`

### A.271 — B.129 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- Baseline ID (v34): `B.129`
- File: `app/Livewire/Inventory/Products/Form.php`
- Evidence: `$this->form['cost'] = (float) ($p->standard_cost ?? $p->cost ?? 0);`

### A.272 — B.128 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- Baseline ID (v34): `B.128`
- File: `app/Livewire/Inventory/Products/Form.php`
- Evidence: `$this->form['price'] = (float) ($p->default_price ?? $p->price ?? 0);`

### A.273 — A.148 — Medium — Finance/Precision — Money/amount cast to float (rounding drift risk)
- Baseline ID (v34): `A.148`
- File: `app/Livewire/Inventory/Services/Form.php`
- Evidence: `        $this->cost = (float) ($product->cost ?: $product->standard_cost);`

### A.274 — B.131 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- Baseline ID (v34): `B.131`
- File: `app/Livewire/Inventory/Services/Form.php`
- Evidence: `$this->cost = (float) ($product->cost ?: $product->standard_cost);`

### A.275 — B.130 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- Baseline ID (v34): `B.130`
- File: `app/Livewire/Inventory/Services/Form.php`
- Evidence: `$this->defaultPrice = (float) $product->default_price;`

### A.276 — B.132 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- Baseline ID (v34): `B.132`
- File: `app/Livewire/Inventory/Services/Form.php`
- Evidence: `$this->defaultPrice = (float) bcround($calculated, 2);`

### A.277 — B.133 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- Baseline ID (v34): `B.133`
- File: `app/Livewire/Manufacturing/BillsOfMaterials/Form.php`
- Evidence: `$this->quantity = (float) $this->bom->quantity;`

### A.278 — B.134 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- Baseline ID (v34): `B.134`
- File: `app/Livewire/Manufacturing/ProductionOrders/Form.php`
- Evidence: `$this->quantity_planned = (float) $this->productionOrder->quantity_planned;`

### A.279 — B.135 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- Baseline ID (v34): `B.135`
- File: `app/Livewire/Manufacturing/WorkCenters/Form.php`
- Evidence: `$this->cost_per_hour = (float) $this->workCenter->cost_per_hour;`

### A.280 — A.150 — Medium — Finance/Precision — Float cast for totals
- Baseline ID (v34): `A.150`
- File: `app/Livewire/Projects/TimeLogs.php`
- Evidence: `            'billable_hours' => (float) ($stats->billable_hours ?? 0),`

### A.281 — A.151 — Medium — Finance/Precision — Float cast for totals
- Baseline ID (v34): `A.151`
- File: `app/Livewire/Projects/TimeLogs.php`
- Evidence: `            'non_billable_hours' => (float) ($stats->non_billable_hours ?? 0),`

### A.282 — A.152 — Medium — Finance/Precision — Float cast for totals
- Baseline ID (v34): `A.152`
- File: `app/Livewire/Projects/TimeLogs.php`
- Evidence: `            'total_cost' => (float) ($stats->total_cost ?? 0),`

### A.283 — A.149 — Medium — Finance/Precision — Float cast for totals
- Baseline ID (v34): `A.149`
- File: `app/Livewire/Projects/TimeLogs.php`
- Evidence: `            'total_hours' => (float) ($stats->total_hours ?? 0),`

### A.284 — B.137 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- Baseline ID (v34): `B.137`
- File: `app/Livewire/Projects/TimeLogs.php`
- Evidence: `'total_cost' => (float) ($stats->total_cost ?? 0),`

### A.285 — B.136 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- Baseline ID (v34): `B.136`
- File: `app/Livewire/Projects/TimeLogs.php`
- Evidence: `'total_hours' => (float) ($stats->total_hours ?? 0),`

### A.286 — A.158 — Medium — Finance/Precision — Money/amount cast to float (rounding drift risk)
- Baseline ID (v34): `A.158`
- File: `app/Livewire/Purchases/Form.php`
- Evidence: `                            $discountAmount = max(0, (float) ($item['discount'] ?? 0));`

### A.287 — A.155 — Medium — Finance/Precision — Money/amount cast to float (rounding drift risk)
- Baseline ID (v34): `A.155`
- File: `app/Livewire/Purchases/Form.php`
- Evidence: `                'discount' => (float) ($item->discount ?? 0),`

### A.288 — A.156 — Medium — Finance/Precision — Float cast for totals
- Baseline ID (v34): `A.156`
- File: `app/Livewire/Purchases/Form.php`
- Evidence: `                'tax_rate' => (float) ($item->tax_rate ?? 0),`

### A.289 — A.157 — Medium — Finance/Precision — Money/amount cast to float (rounding drift risk)
- Baseline ID (v34): `A.157`
- File: `app/Livewire/Purchases/Form.php`
- Evidence: `                'unit_cost' => (float) ($product->cost ?? 0),`

### A.290 — A.153 — Medium — Finance/Precision — Float cast for totals
- Baseline ID (v34): `A.153`
- File: `app/Livewire/Purchases/Form.php`
- Evidence: `            $this->discount_total = (float) ($purchase->discount_total ?? 0);`

### A.291 — A.154 — Medium — Finance/Precision — Float cast for totals
- Baseline ID (v34): `A.154`
- File: `app/Livewire/Purchases/Form.php`
- Evidence: `            $this->shipping_total = (float) ($purchase->shipping_total ?? 0);`

### A.292 — B.145 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- Baseline ID (v34): `B.145`
- File: `app/Livewire/Purchases/Form.php`
- Evidence: `$discountAmount = max(0, (float) ($item['discount'] ?? 0));`

### A.293 — B.138 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- Baseline ID (v34): `B.138`
- File: `app/Livewire/Purchases/Form.php`
- Evidence: `$this->discount_total = (float) ($purchase->discount_total ?? 0);`

### A.294 — B.139 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- Baseline ID (v34): `B.139`
- File: `app/Livewire/Purchases/Form.php`
- Evidence: `$this->shipping_total = (float) ($purchase->shipping_total ?? 0);`

### A.295 — B.142 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- Baseline ID (v34): `B.142`
- File: `app/Livewire/Purchases/Form.php`
- Evidence: `'discount' => (float) ($item->discount ?? 0),`

### A.296 — B.140 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- Baseline ID (v34): `B.140`
- File: `app/Livewire/Purchases/Form.php`
- Evidence: `'qty' => (float) $item->qty,`

### A.297 — B.143 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- Baseline ID (v34): `B.143`
- File: `app/Livewire/Purchases/Form.php`
- Evidence: `'tax_rate' => (float) ($item->tax_rate ?? 0),`

### A.298 — B.141 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- Baseline ID (v34): `B.141`
- File: `app/Livewire/Purchases/Form.php`
- Evidence: `'unit_cost' => (float) $item->unit_cost,`

### A.299 — B.144 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- Baseline ID (v34): `B.144`
- File: `app/Livewire/Purchases/Form.php`
- Evidence: `'unit_cost' => (float) ($product->cost ?? 0),`

### A.300 — A.159 — Medium — Finance/Precision — Money/amount cast to float (rounding drift risk)
- Baseline ID (v34): `A.159`
- File: `app/Livewire/Purchases/Returns/Index.php`
- Evidence: `            'cost' => (float) $item->unit_cost,`

### A.301 — B.148 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- Baseline ID (v34): `B.148`
- File: `app/Livewire/Purchases/Returns/Index.php`
- Evidence: `$qty = min((float) $it['qty'], (float) $pi->qty);`

### A.302 — B.149 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- Baseline ID (v34): `B.149`
- File: `app/Livewire/Purchases/Returns/Index.php`
- Evidence: `$unitCost = (float) $pi->unit_cost;`

### A.303 — B.147 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- Baseline ID (v34): `B.147`
- File: `app/Livewire/Purchases/Returns/Index.php`
- Evidence: `'cost' => (float) $item->unit_cost,`

### A.304 — B.146 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- Baseline ID (v34): `B.146`
- File: `app/Livewire/Purchases/Returns/Index.php`
- Evidence: `'max_qty' => (float) $item->qty,`

### A.305 — A.160 — Medium — Finance/Precision — BCMath result cast to float
- Baseline ID (v34): `A.160`
- File: `app/Livewire/Rental/Reports/Dashboard.php`
- Evidence: `        $occupancyRate = $total > 0 ? (float) bcdiv(bcmul((string) $occupied, '100', 4), (string) $total, 1) : 0;`

### A.306 — B.150 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- Baseline ID (v34): `B.150`
- File: `app/Livewire/Rental/Reports/Dashboard.php`
- Evidence: `$occupancyRate = $total > 0 ? (float) bcdiv(bcmul((string) $occupied, '100', 4), (string) $total, 1) : 0;`

### A.307 — A.162 — Medium — Finance/Precision — BCMath result cast to float
- Baseline ID (v34): `A.162`
- File: `app/Livewire/Reports/SalesAnalytics.php`
- Evidence: `            $salesGrowth = (float) bcdiv(bcmul($diff, '100', 6), (string) $prevTotalSales, 1);`

### A.308 — A.164 — Medium — Finance/Precision — Money/amount cast to float (rounding drift risk)
- Baseline ID (v34): `A.164`
- File: `app/Livewire/Reports/SalesAnalytics.php`
- Evidence: `            'totals' => $results->pluck('total')->map(fn ($v) => (float) $v)->toArray(),`

### A.309 — A.161 — Medium — Finance/Precision — BCMath result cast to float
- Baseline ID (v34): `A.161`
- File: `app/Livewire/Reports/SalesAnalytics.php`
- Evidence: `        $avgOrderValue = $totalOrders > 0 ? (float) bcdiv((string) $totalSales, (string) $totalOrders, 2) : 0;`

### A.310 — A.163 — Medium — Finance/Precision — BCMath result cast to float
- Baseline ID (v34): `A.163`
- File: `app/Livewire/Reports/SalesAnalytics.php`
- Evidence: `        $completionRate = $totalOrders > 0 ? (float) bcdiv(bcmul((string) $completedOrders, '100', 4), (string) $totalOrders, 1) : 0;`

### A.311 — B.151 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- Baseline ID (v34): `B.151`
- File: `app/Livewire/Reports/SalesAnalytics.php`
- Evidence: `$avgOrderValue = $totalOrders > 0 ? (float) bcdiv((string) $totalSales, (string) $totalOrders, 2) : 0;`

### A.312 — B.153 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- Baseline ID (v34): `B.153`
- File: `app/Livewire/Reports/SalesAnalytics.php`
- Evidence: `$completionRate = $totalOrders > 0 ? (float) bcdiv(bcmul((string) $completedOrders, '100', 4), (string) $totalOrders, 1) : 0;`

### A.313 — B.152 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- Baseline ID (v34): `B.152`
- File: `app/Livewire/Reports/SalesAnalytics.php`
- Evidence: `$salesGrowth = (float) bcdiv(bcmul($diff, '100', 6), (string) $prevTotalSales, 1);`

### A.314 — B.154 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- Baseline ID (v34): `B.154`
- File: `app/Livewire/Reports/SalesAnalytics.php`
- Evidence: `'revenue' => (float) $p->total_revenue,`

### A.315 — B.157 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- Baseline ID (v34): `B.157`
- File: `app/Livewire/Reports/SalesAnalytics.php`
- Evidence: `'revenues' => $results->pluck('total_revenue')->map(fn ($v) => (float) $v)->toArray(),`

### A.316 — B.155 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- Baseline ID (v34): `B.155`
- File: `app/Livewire/Reports/SalesAnalytics.php`
- Evidence: `'total_spent' => (float) $c->total_spent,`

### A.317 — B.156 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- Baseline ID (v34): `B.156`
- File: `app/Livewire/Reports/SalesAnalytics.php`
- Evidence: `'totals' => $results->pluck('total')->map(fn ($v) => (float) $v)->toArray(),`

### A.318 — A.174 — Medium — Finance/Precision — BCMath result cast to float
- Baseline ID (v34): `A.174`
- File: `app/Livewire/Sales/Form.php`
- Evidence: `                                'discount_amount' => (float) bcdiv($discountAmount, '1', BCMATH_STORAGE_SCALE),`

### A.319 — A.176 — Medium — Finance/Precision — BCMath result cast to float
- Baseline ID (v34): `A.176`
- File: `app/Livewire/Sales/Form.php`
- Evidence: `                                'line_total' => (float) bcdiv($lineTotal, '1', BCMATH_STORAGE_SCALE),`

### A.320 — A.175 — Medium — Finance/Precision — BCMath result cast to float
- Baseline ID (v34): `A.175`
- File: `app/Livewire/Sales/Form.php`
- Evidence: `                                'tax_amount' => (float) bcdiv($taxAmount, '1', BCMATH_STORAGE_SCALE),`

### A.321 — A.173 — Medium — Finance/Precision — Float cast for totals
- Baseline ID (v34): `A.173`
- File: `app/Livewire/Sales/Form.php`
- Evidence: `                            $validatedPrice = (float) ($product->default_price ?? 0);`

### A.322 — A.169 — Medium — Finance/Precision — Money/amount cast to float (rounding drift risk)
- Baseline ID (v34): `A.169`
- File: `app/Livewire/Sales/Form.php`
- Evidence: `                $this->payment_amount = (float) ($firstPayment->amount ?? 0);`

### A.323 — A.167 — Medium — Finance/Precision — Money/amount cast to float (rounding drift risk)
- Baseline ID (v34): `A.167`
- File: `app/Livewire/Sales/Form.php`
- Evidence: `                'discount' => (float) ($item->discount ?? 0),`

### A.324 — A.168 — Medium — Finance/Precision — Float cast for totals
- Baseline ID (v34): `A.168`
- File: `app/Livewire/Sales/Form.php`
- Evidence: `                'tax_rate' => (float) ($item->tax_rate ?? 0),`

### A.325 — A.170 — Medium — Finance/Precision — Float cast for totals
- Baseline ID (v34): `A.170`
- File: `app/Livewire/Sales/Form.php`
- Evidence: `                'unit_price' => (float) ($product->default_price ?? 0),`

### A.326 — A.165 — Medium — Finance/Precision — Float cast for totals
- Baseline ID (v34): `A.165`
- File: `app/Livewire/Sales/Form.php`
- Evidence: `            $this->discount_total = (float) ($sale->discount_total ?? 0);`

### A.327 — A.166 — Medium — Finance/Precision — Float cast for totals
- Baseline ID (v34): `A.166`
- File: `app/Livewire/Sales/Form.php`
- Evidence: `            $this->shipping_total = (float) ($sale->shipping_total ?? 0);`

### A.328 — A.172 — Medium — Finance/Precision — BCMath result cast to float
- Baseline ID (v34): `A.172`
- File: `app/Livewire/Sales/Form.php`
- Evidence: `        return (float) bcdiv($result, '1', BCMATH_STORAGE_SCALE);`

### A.329 — A.171 — Medium — Finance/Precision — BCMath result cast to float
- Baseline ID (v34): `A.171`
- File: `app/Livewire/Sales/Form.php`
- Evidence: `        return (float) bcdiv($total, '1', BCMATH_STORAGE_SCALE);`

### A.330 — B.158 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- Baseline ID (v34): `B.158`
- File: `app/Livewire/Sales/Form.php`
- Evidence: `$this->discount_total = (float) ($sale->discount_total ?? 0);`

### A.331 — B.164 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- Baseline ID (v34): `B.164`
- File: `app/Livewire/Sales/Form.php`
- Evidence: `$this->payment_amount = (float) ($firstPayment->amount ?? 0);`

### A.332 — B.159 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- Baseline ID (v34): `B.159`
- File: `app/Livewire/Sales/Form.php`
- Evidence: `$this->shipping_total = (float) ($sale->shipping_total ?? 0);`

### A.333 — B.168 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- Baseline ID (v34): `B.168`
- File: `app/Livewire/Sales/Form.php`
- Evidence: `$validatedPrice = (float) $item['unit_price'];`

### A.334 — B.167 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- Baseline ID (v34): `B.167`
- File: `app/Livewire/Sales/Form.php`
- Evidence: `$validatedPrice = (float) ($product->default_price ?? 0);`

### A.335 — B.162 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- Baseline ID (v34): `B.162`
- File: `app/Livewire/Sales/Form.php`
- Evidence: `'discount' => (float) ($item->discount ?? 0),`

### A.336 — B.169 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- Baseline ID (v34): `B.169`
- File: `app/Livewire/Sales/Form.php`
- Evidence: `'discount_amount' => (float) bcdiv($discountAmount, '1', BCMATH_STORAGE_SCALE),`

### A.337 — B.171 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- Baseline ID (v34): `B.171`
- File: `app/Livewire/Sales/Form.php`
- Evidence: `'line_total' => (float) bcdiv($lineTotal, '1', BCMATH_STORAGE_SCALE),`

### A.338 — B.160 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- Baseline ID (v34): `B.160`
- File: `app/Livewire/Sales/Form.php`
- Evidence: `'qty' => (float) $item->qty,`

### A.339 — B.170 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- Baseline ID (v34): `B.170`
- File: `app/Livewire/Sales/Form.php`
- Evidence: `'tax_amount' => (float) bcdiv($taxAmount, '1', BCMATH_STORAGE_SCALE),`

### A.340 — B.163 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- Baseline ID (v34): `B.163`
- File: `app/Livewire/Sales/Form.php`
- Evidence: `'tax_rate' => (float) ($item->tax_rate ?? 0),`

### A.341 — B.161 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- Baseline ID (v34): `B.161`
- File: `app/Livewire/Sales/Form.php`
- Evidence: `'unit_price' => (float) $item->unit_price,`

### A.342 — B.165 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- Baseline ID (v34): `B.165`
- File: `app/Livewire/Sales/Form.php`
- Evidence: `'unit_price' => (float) ($product->default_price ?? 0),`

### A.343 — B.166 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- Baseline ID (v34): `B.166`
- File: `app/Livewire/Sales/Form.php`
- Evidence: `return (float) bcdiv($total, '1', BCMATH_STORAGE_SCALE);`

### A.344 — A.177 — Medium — Finance/Precision — Money/amount cast to float (rounding drift risk)
- Baseline ID (v34): `A.177`
- File: `app/Livewire/Sales/Returns/Index.php`
- Evidence: `            'price' => (float) $item->unit_price,`

### A.345 — B.172 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- Baseline ID (v34): `B.172`
- File: `app/Livewire/Sales/Returns/Index.php`
- Evidence: `'max_qty' => (float) $item->qty,`

### A.346 — B.173 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- Baseline ID (v34): `B.173`
- File: `app/Livewire/Sales/Returns/Index.php`
- Evidence: `'price' => (float) $item->unit_price,`

### A.347 — B.174 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- Baseline ID (v34): `B.174`
- File: `app/Livewire/Sales/Returns/Index.php`
- Evidence: `'qty' => min((float) $item['qty'], (float) $item['max_qty']),`

### A.348 — B.175 — Medium — Perf/Security — Loads full file into memory (Storage::get / file_get_contents)
- Baseline ID (v34): `B.175`
- File: `app/Livewire/Shared/DynamicForm.php`
- Evidence: `$content = file_get_contents($file->getRealPath());`

### A.349 — A.180 — Medium — Finance/Precision — Float cast for totals
- Baseline ID (v34): `A.180`
- File: `app/Livewire/Suppliers/Form.php`
- Evidence: `            $this->delivery_rating = (float) ($supplier->delivery_rating ?? 0);`

### A.350 — A.178 — Medium — Finance/Precision — Float cast for totals
- Baseline ID (v34): `A.178`
- File: `app/Livewire/Suppliers/Form.php`
- Evidence: `            $this->minimum_order_value = (float) ($supplier->minimum_order_value ?? 0);`

### A.351 — A.179 — Medium — Finance/Precision — Float cast for totals
- Baseline ID (v34): `A.179`
- File: `app/Livewire/Suppliers/Form.php`
- Evidence: `            $this->quality_rating = (float) ($supplier->quality_rating ?? 0);`

### A.352 — A.181 — Medium — Finance/Precision — Float cast for totals
- Baseline ID (v34): `A.181`
- File: `app/Livewire/Suppliers/Form.php`
- Evidence: `            $this->service_rating = (float) ($supplier->service_rating ?? 0);`

### A.353 — B.176 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- Baseline ID (v34): `B.176`
- File: `app/Livewire/Suppliers/Form.php`
- Evidence: `$this->minimum_order_value = (float) ($supplier->minimum_order_value ?? 0);`

### A.354 — B.178 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- Baseline ID (v34): `B.178`
- File: `app/Livewire/Warehouse/Adjustments/Form.php`
- Evidence: `'direction' => (float) $item['qty'] >= 0 ? 'in' : 'out',`

### A.355 — B.177 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- Baseline ID (v34): `B.177`
- File: `app/Livewire/Warehouse/Adjustments/Form.php`
- Evidence: `'qty' => abs((float) $item['qty']),`

### A.356 — B.179 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- Baseline ID (v34): `B.179`
- File: `app/Livewire/Warehouse/Transfers/Index.php`
- Evidence: `$qty = (float) $item->quantity;`

### A.357 — A.182 — Medium — Finance/Precision — Money/amount cast to float (rounding drift risk)
- Baseline ID (v34): `A.182`
- File: `app/Models/BankTransaction.php`
- Evidence: `        $amount = (float) $this->amount;`

### A.358 — B.180 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- Baseline ID (v34): `B.180`
- File: `app/Models/BankTransaction.php`
- Evidence: `$amount = (float) $this->amount;`

### A.359 — A.186 — Medium — Finance/Precision — Float cast for totals
- Baseline ID (v34): `A.186`
- File: `app/Models/BillOfMaterial.php`
- Evidence: `            $costPerHour = (float) ($operation->workCenter->cost_per_hour ?? 0);`

### A.360 — A.185 — Medium — Finance/Precision — Float cast for totals
- Baseline ID (v34): `A.185`
- File: `app/Models/BillOfMaterial.php`
- Evidence: `            $durationHours = (float) ($operation->duration_minutes ?? 0) / 60;`

### A.361 — A.183 — Medium — Finance/Precision — Float cast for totals
- Baseline ID (v34): `A.183`
- File: `app/Models/BillOfMaterial.php`
- Evidence: `            $scrapFactor = 1 + ((float) ($item->scrap_percentage ?? 0) / 100);`

### A.362 — A.187 — Medium — Finance/Precision — Float cast for totals
- Baseline ID (v34): `A.187`
- File: `app/Models/BillOfMaterial.php`
- Evidence: `            return $durationHours * $costPerHour + (float) ($operation->labor_cost ?? 0);`

### A.363 — A.184 — Medium — Finance/Precision — Float cast for totals
- Baseline ID (v34): `A.184`
- File: `app/Models/BillOfMaterial.php`
- Evidence: `        $yieldFactor = (float) ($this->yield_percentage ?? 100) / 100;`

### A.364 — B.182 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- Baseline ID (v34): `B.182`
- File: `app/Models/BillOfMaterial.php`
- Evidence: `$costPerHour = (float) ($operation->workCenter->cost_per_hour ?? 0);`

### A.365 — B.181 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- Baseline ID (v34): `B.181`
- File: `app/Models/BillOfMaterial.php`
- Evidence: `$itemQuantity = (float) $item->quantity;`

### A.366 — B.183 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- Baseline ID (v34): `B.183`
- File: `app/Models/BillOfMaterial.php`
- Evidence: `return $durationHours * $costPerHour + (float) ($operation->labor_cost ?? 0);`

### A.367 — A.188 — Medium — Finance/Precision — Float cast for totals
- Baseline ID (v34): `A.188`
- File: `app/Models/BomItem.php`
- Evidence: `        $scrapFactor = 1 + ((float) ($this->scrap_percentage ?? 0) / 100);`

### A.368 — B.184 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- Baseline ID (v34): `B.184`
- File: `app/Models/BomItem.php`
- Evidence: `$baseQuantity = (float) $this->quantity;`

### A.369 — B.186 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- Baseline ID (v34): `B.186`
- File: `app/Models/BomOperation.php`
- Evidence: `$laborCost = (float) $this->labor_cost;`

### A.370 — B.185 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- Baseline ID (v34): `B.185`
- File: `app/Models/BomOperation.php`
- Evidence: `$workCenterCost = $timeHours * (float) $this->workCenter->cost_per_hour;`

### A.371 — B.187 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- Baseline ID (v34): `B.187`
- File: `app/Models/CurrencyRate.php`
- Evidence: `$rateValue = (float) $rate->rate;`

### A.372 — A.189 — Medium — Finance/Precision — Float cast for totals
- Baseline ID (v34): `A.189`
- File: `app/Models/FixedAsset.php`
- Evidence: `        $currentValue = (float) ($this->current_value ?? 0);`

### A.373 — A.191 — Medium — Finance/Precision — Float cast for totals
- Baseline ID (v34): `A.191`
- File: `app/Models/FixedAsset.php`
- Evidence: `        $purchaseCost = (float) ($this->purchase_cost ?? 0);`

### A.374 — A.190 — Medium — Finance/Precision — Float cast for totals
- Baseline ID (v34): `A.190`
- File: `app/Models/FixedAsset.php`
- Evidence: `        $salvageValue = (float) ($this->salvage_value ?? 0);`

### A.375 — B.188 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- Baseline ID (v34): `B.188`
- File: `app/Models/FixedAsset.php`
- Evidence: `$currentValue = (float) ($this->current_value ?? 0);`

### A.376 — B.190 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- Baseline ID (v34): `B.190`
- File: `app/Models/FixedAsset.php`
- Evidence: `$purchaseCost = (float) ($this->purchase_cost ?? 0);`

### A.377 — B.189 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- Baseline ID (v34): `B.189`
- File: `app/Models/FixedAsset.php`
- Evidence: `$salvageValue = (float) ($this->salvage_value ?? 0);`

### A.378 — A.192 — Medium — Finance/Precision — Float cast for totals
- Baseline ID (v34): `A.192`
- File: `app/Models/GRNItem.php`
- Evidence: `        $expectedQty = (float) ($this->expected_quantity ?? 0);`

### A.379 — B.191 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- Baseline ID (v34): `B.191`
- File: `app/Models/GRNItem.php`
- Evidence: `$expectedQty = (float) ($this->expected_quantity ?? 0);`

### A.380 — B.192 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- Baseline ID (v34): `B.192`
- File: `app/Models/GRNItem.php`
- Evidence: `return (abs($expectedQty - (float) $acceptedQty) / $expectedQty) * 100;`

### A.381 — B.194 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- Baseline ID (v34): `B.194`
- File: `app/Models/GoodsReceivedNote.php`
- Evidence: `return (float) $this->items->sum('accepted_quantity');`

### A.382 — B.193 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- Baseline ID (v34): `B.193`
- File: `app/Models/GoodsReceivedNote.php`
- Evidence: `return (float) $this->items->sum('received_quantity');`

### A.383 — B.195 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- Baseline ID (v34): `B.195`
- File: `app/Models/GoodsReceivedNote.php`
- Evidence: `return (float) $this->items->sum('rejected_quantity');`

### A.384 — A.194 — Medium — Finance/Precision — Float cast for totals
- Baseline ID (v34): `A.194`
- File: `app/Models/InstallmentPayment.php`
- Evidence: `        $amountPaid = (float) ($this->amount_paid ?? 0);`

### A.385 — A.195 — Medium — Finance/Precision — Money/amount cast to float (rounding drift risk)
- Baseline ID (v34): `A.195`
- File: `app/Models/InstallmentPayment.php`
- Evidence: `        $newAmountPaid = min($amountPaid + $amount, (float) $this->amount_due);`

### A.386 — A.196 — Medium — Finance/Precision — Money/amount cast to float (rounding drift risk)
- Baseline ID (v34): `A.196`
- File: `app/Models/InstallmentPayment.php`
- Evidence: `        $newStatus = $newAmountPaid >= (float) $this->amount_due ? 'paid' : 'partial';`

### A.387 — A.193 — Medium — Finance/Precision — Float cast for totals
- Baseline ID (v34): `A.193`
- File: `app/Models/InstallmentPayment.php`
- Evidence: `        return max(0, (float) $this->amount_due - (float) ($this->amount_paid ?? 0));`

### A.388 — B.197 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- Baseline ID (v34): `B.197`
- File: `app/Models/InstallmentPayment.php`
- Evidence: `$amountPaid = (float) ($this->amount_paid ?? 0);`

### A.389 — B.198 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- Baseline ID (v34): `B.198`
- File: `app/Models/InstallmentPayment.php`
- Evidence: `$newAmountPaid = min($amountPaid + $amount, (float) $this->amount_due);`

### A.390 — B.199 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- Baseline ID (v34): `B.199`
- File: `app/Models/InstallmentPayment.php`
- Evidence: `$newStatus = $newAmountPaid >= (float) $this->amount_due ? 'paid' : 'partial';`

### A.391 — B.196 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- Baseline ID (v34): `B.196`
- File: `app/Models/InstallmentPayment.php`
- Evidence: `return max(0, (float) $this->amount_due - (float) ($this->amount_paid ?? 0));`

### A.392 — B.200 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- Baseline ID (v34): `B.200`
- File: `app/Models/InstallmentPlan.php`
- Evidence: `return (float) $this->payments()->sum('amount_paid');`

### A.393 — B.201 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- Baseline ID (v34): `B.201`
- File: `app/Models/InstallmentPlan.php`
- Evidence: `return max(0, (float) $this->total_amount - (float) $this->down_payment - $this->paid_amount);`

### A.394 — A.198 — Medium — Finance/Precision — Float cast for totals
- Baseline ID (v34): `A.198`
- File: `app/Models/JournalEntry.php`
- Evidence: `        return (float) ($this->attributes['total_credit'] ?? $this->lines()->sum('credit'));`

### A.395 — A.197 — Medium — Finance/Precision — Float cast for totals
- Baseline ID (v34): `A.197`
- File: `app/Models/JournalEntry.php`
- Evidence: `        return (float) ($this->attributes['total_debit'] ?? $this->lines()->sum('debit'));`

### A.396 — B.203 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- Baseline ID (v34): `B.203`
- File: `app/Models/JournalEntry.php`
- Evidence: `return (float) ($this->attributes['total_credit'] ?? $this->lines()->sum('credit'));`

### A.397 — B.202 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- Baseline ID (v34): `B.202`
- File: `app/Models/JournalEntry.php`
- Evidence: `return (float) ($this->attributes['total_debit'] ?? $this->lines()->sum('debit'));`

### A.398 — B.204 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- Baseline ID (v34): `B.204`
- File: `app/Models/ModuleSetting.php`
- Evidence: `'float', 'decimal' => (float) $this->setting_value,`

### A.399 — B.205 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- Baseline ID (v34): `B.205`
- File: `app/Models/ProductFieldValue.php`
- Evidence: `'decimal' => (float) $this->value,`

### A.400 — A.199 — Medium — Finance/Precision — Float cast for totals
- Baseline ID (v34): `A.199`
- File: `app/Models/ProductionOrder.php`
- Evidence: `        $plannedQty = (float) ($this->planned_quantity ?? 0);`

### A.401 — A.200 — Medium — Finance/Precision — Float cast for totals
- Baseline ID (v34): `A.200`
- File: `app/Models/ProductionOrder.php`
- Evidence: `        return ((float) ($this->produced_quantity ?? 0) / $plannedQty) * 100;`

### A.402 — B.206 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- Baseline ID (v34): `B.206`
- File: `app/Models/ProductionOrder.php`
- Evidence: `$plannedQty = (float) ($this->planned_quantity ?? 0);`

### A.403 — B.207 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- Baseline ID (v34): `B.207`
- File: `app/Models/ProductionOrder.php`
- Evidence: `return ((float) ($this->produced_quantity ?? 0) / $plannedQty) * 100;`

### A.404 — B.208 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- Baseline ID (v34): `B.208`
- File: `app/Models/ProductionOrder.php`
- Evidence: `return (float) $this->planned_quantity - (float) $this->produced_quantity - (float) $this->rejected_quantity;`

### A.405 — A.201 — Medium — Finance/Precision — Float cast for totals
- Baseline ID (v34): `A.201`
- File: `app/Models/Project.php`
- Evidence: `        return (float) ($timeLogsCost + $expensesCost);`

### A.406 — B.209 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- Baseline ID (v34): `B.209`
- File: `app/Models/Project.php`
- Evidence: `return (float) ($timeLogsCost + $expensesCost);`

### A.407 — A.202 — Medium — Finance/Precision — Float cast for totals
- Baseline ID (v34): `A.202`
- File: `app/Models/ProjectTimeLog.php`
- Evidence: `        return (float) ($this->hours * $this->hourly_rate);`

### A.408 — B.210 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- Baseline ID (v34): `B.210`
- File: `app/Models/ProjectTimeLog.php`
- Evidence: `return (float) ($this->hours * $this->hourly_rate);`

### A.409 — B.213 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- Baseline ID (v34): `B.213`
- File: `app/Models/Purchase.php`
- Evidence: `$paidAmount = (float) $this->paid_amount;`

### A.410 — B.214 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- Baseline ID (v34): `B.214`
- File: `app/Models/Purchase.php`
- Evidence: `$totalAmount = (float) $this->total_amount;`

### A.411 — B.211 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- Baseline ID (v34): `B.211`
- File: `app/Models/Purchase.php`
- Evidence: `return (float) $this->paid_amount;`

### A.412 — B.212 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- Baseline ID (v34): `B.212`
- File: `app/Models/Purchase.php`
- Evidence: `return max(0, (float) $this->total_amount - (float) $this->paid_amount);`

### A.413 — B.216 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- Baseline ID (v34): `B.216`
- File: `app/Models/Sale.php`
- Evidence: `$totalAmount = (float) $this->total_amount;`

### A.414 — B.215 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- Baseline ID (v34): `B.215`
- File: `app/Models/Sale.php`
- Evidence: `return max(0, (float) $this->total_amount - $this->total_paid);`

### A.415 — A.203 — Medium — Finance/Precision — BCMath result cast to float
- Baseline ID (v34): `A.203`
- File: `app/Models/StockTransferItem.php`
- Evidence: `        return (float) bcsub((string)$this->qty_shipped, (string)$this->qty_received, 3);`

### A.416 — B.217 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- Baseline ID (v34): `B.217`
- File: `app/Models/StockTransferItem.php`
- Evidence: `return (float) bcsub((string)$this->qty_shipped, (string)$this->qty_received, 3);`

### A.417 — A.204 — Medium — Finance/Precision — Float cast for totals
- Baseline ID (v34): `A.204`
- File: `app/Models/Supplier.php`
- Evidence: `        return (float) ($this->rating ?? 0);`

### A.418 — B.218 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- Baseline ID (v34): `B.218`
- File: `app/Models/SystemSetting.php`
- Evidence: `'float', 'decimal' => is_numeric($value) ? (float) $value : $default,`

### A.419 — B.219 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- Baseline ID (v34): `B.219`
- File: `app/Models/Traits/CommonQueryScopes.php`
- Evidence: `return number_format((float) $value, 2);`

### A.420 — B.220 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- Baseline ID (v34): `B.220`
- File: `app/Models/UnitOfMeasure.php`
- Evidence: `$baseValue = $value * (float) $this->conversion_factor;`

### A.421 — B.221 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- Baseline ID (v34): `B.221`
- File: `app/Observers/FinancialTransactionObserver.php`
- Evidence: `$customer->addBalance((float) $model->total_amount);`

### A.422 — B.222 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- Baseline ID (v34): `B.222`
- File: `app/Observers/FinancialTransactionObserver.php`
- Evidence: `$customer->subtractBalance((float) $model->total_amount);`

### A.423 — B.223 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- Baseline ID (v34): `B.223`
- File: `app/Observers/FinancialTransactionObserver.php`
- Evidence: `$supplier->addBalance((float) $model->total_amount);`

### A.424 — B.224 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- Baseline ID (v34): `B.224`
- File: `app/Observers/FinancialTransactionObserver.php`
- Evidence: `$supplier->subtractBalance((float) $model->total_amount);`

### A.425 — A.205 — Medium — Finance/Precision — Money/amount cast to float (rounding drift risk)
- Baseline ID (v34): `A.205`
- File: `app/Observers/ProductObserver.php`
- Evidence: `            $product->cost = round((float) $product->cost, 2);`

### A.426 — B.227 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- Baseline ID (v34): `B.227`
- File: `app/Observers/ProductObserver.php`
- Evidence: `$product->cost = round((float) $product->cost, 2);`

### A.427 — B.225 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- Baseline ID (v34): `B.225`
- File: `app/Observers/ProductObserver.php`
- Evidence: `$product->default_price = round((float) $product->default_price, 2);`

### A.428 — B.226 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- Baseline ID (v34): `B.226`
- File: `app/Observers/ProductObserver.php`
- Evidence: `$product->standard_cost = round((float) $product->standard_cost, 2);`

### A.429 — A.207 — Medium — Finance/Precision — Float cast for totals
- Baseline ID (v34): `A.207`
- File: `app/Repositories/StockMovementRepository.php`
- Evidence: `            $qty = abs((float) ($data['qty'] ?? $data['quantity'] ?? 0));`

### A.430 — A.206 — Medium — Finance/Precision — Float cast for totals
- Baseline ID (v34): `A.206`
- File: `app/Repositories/StockMovementRepository.php`
- Evidence: `        $in = (float) (clone $baseQuery)->where('quantity', '>', 0)->sum('quantity');`

### A.431 — B.228 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- Baseline ID (v34): `B.228`
- File: `app/Repositories/StockMovementRepository.php`
- Evidence: `$in = (float) (clone $baseQuery)->where('quantity', '>', 0)->sum('quantity');`

### A.432 — B.229 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- Baseline ID (v34): `B.229`
- File: `app/Repositories/StockMovementRepository.php`
- Evidence: `$out = (float) abs((clone $baseQuery)->where('quantity', '<', 0)->sum('quantity'));`

### A.433 — B.232 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- Baseline ID (v34): `B.232`
- File: `app/Repositories/StockMovementRepository.php`
- Evidence: `$qty = abs((float) ($data['qty'] ?? $data['quantity'] ?? 0));`

### A.434 — B.233 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- Baseline ID (v34): `B.233`
- File: `app/Repositories/StockMovementRepository.php`
- Evidence: `$totalStock = (float) StockMovement::where('product_id', $productId)`

### A.435 — B.230 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- Baseline ID (v34): `B.230`
- File: `app/Repositories/StockMovementRepository.php`
- Evidence: `return (float) $baseQuery->sum('quantity');`

### A.436 — B.231 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- Baseline ID (v34): `B.231`
- File: `app/Repositories/StockMovementRepository.php`
- Evidence: `return (float) $group->sum('quantity');`

### A.437 — B.234 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- Baseline ID (v34): `B.234`
- File: `app/Rules/ValidDiscount.php`
- Evidence: `$num = (float) $value;`

### A.438 — A.208 — Medium — Finance/Precision — Money/amount cast to float (rounding drift risk)
- Baseline ID (v34): `A.208`
- File: `app/Rules/ValidDiscountPercentage.php`
- Evidence: `        $discount = (float) $value;`

### A.439 — B.235 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- Baseline ID (v34): `B.235`
- File: `app/Rules/ValidDiscountPercentage.php`
- Evidence: `$discount = (float) $value;`

### A.440 — A.209 — Medium — Finance/Precision — Money/amount cast to float (rounding drift risk)
- Baseline ID (v34): `A.209`
- File: `app/Rules/ValidPriceOverride.php`
- Evidence: `        $price = (float) $value;`

### A.441 — B.236 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- Baseline ID (v34): `B.236`
- File: `app/Rules/ValidPriceOverride.php`
- Evidence: `$price = (float) $value;`

### A.442 — B.237 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- Baseline ID (v34): `B.237`
- File: `app/Rules/ValidStockQuantity.php`
- Evidence: `$quantity = (float) $value;`

### A.443 — A.210 — Medium — Finance/Precision — Float cast for totals
- Baseline ID (v34): `A.210`
- File: `app/Services/AccountingService.php`
- Evidence: `        return (float) ($result ?? 0);`

### A.444 — B.239 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- Baseline ID (v34): `B.239`
- File: `app/Services/AccountingService.php`
- Evidence: `$totalCost = (float) bcround($totalCost, 2);`

### A.445 — B.238 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- Baseline ID (v34): `B.238`
- File: `app/Services/AccountingService.php`
- Evidence: `'debit' => (float) $unpaidAmount,`

### A.446 — B.240 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- Baseline ID (v34): `B.240`
- File: `app/Services/Analytics/SalesForecastingService.php`
- Evidence: `'avg_order_value' => (float) $row->avg_order_value,`

### A.447 — A.212 — Medium — Finance/Precision — BCMath result cast to float
- Baseline ID (v34): `A.212`
- File: `app/Services/AutomatedAlertService.php`
- Evidence: `            $availableCredit = (float) bcsub((string) $customer->credit_limit, (string) $customer->balance, 2);`

### A.448 — A.213 — Medium — Finance/Precision — BCMath result cast to float
- Baseline ID (v34): `A.213`
- File: `app/Services/AutomatedAlertService.php`
- Evidence: `            $estimatedLoss = (float) bcmul((string) $currentStock, (string) $unitCost, 2);`

### A.449 — A.211 — Medium — Finance/Precision — BCMath result cast to float
- Baseline ID (v34): `A.211`
- File: `app/Services/AutomatedAlertService.php`
- Evidence: `            $utilization = (float) bcmul(`

### A.450 — B.241 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- Baseline ID (v34): `B.241`
- File: `app/Services/AutomatedAlertService.php`
- Evidence: `$availableCredit = (float) bcsub((string) $customer->credit_limit, (string) $customer->balance, 2);`

### A.451 — B.242 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- Baseline ID (v34): `B.242`
- File: `app/Services/AutomatedAlertService.php`
- Evidence: `$estimatedLoss = (float) bcmul((string) $currentStock, (string) $unitCost, 2);`

### A.452 — B.244 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- Baseline ID (v34): `B.244`
- File: `app/Services/BankingService.php`
- Evidence: `(float) $availableBalance,`

### A.453 — B.243 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- Baseline ID (v34): `B.243`
- File: `app/Services/BankingService.php`
- Evidence: `return (float) $this->getAccountBalance($accountId);`

### A.454 — B.252 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- Baseline ID (v34): `B.252`
- File: `app/Services/CostingService.php`
- Evidence: `$batch->quantity = (float) $combinedQty;`

### A.455 — B.253 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- Baseline ID (v34): `B.253`
- File: `app/Services/CostingService.php`
- Evidence: `$batch->unit_cost = (float) $weightedAvgCost;`

### A.456 — B.247 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- Baseline ID (v34): `B.247`
- File: `app/Services/CostingService.php`
- Evidence: `$unitCost = (float) $product->standard_cost;`

### A.457 — B.261 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- Baseline ID (v34): `B.261`
- File: `app/Services/CostingService.php`
- Evidence: `'in_transit' => (float) $transitValue,`

### A.458 — B.260 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- Baseline ID (v34): `B.260`
- File: `app/Services/CostingService.php`
- Evidence: `'in_warehouses' => (float) $warehouseValue,`

### A.459 — B.248 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- Baseline ID (v34): `B.248`
- File: `app/Services/CostingService.php`
- Evidence: `'quantity' => (float) $batchQty,`

### A.460 — B.250 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- Baseline ID (v34): `B.250`
- File: `app/Services/CostingService.php`
- Evidence: `'total_cost' => (float) bcround($batchCost, 2),`

### A.461 — B.246 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- Baseline ID (v34): `B.246`
- File: `app/Services/CostingService.php`
- Evidence: `'total_cost' => (float) bcround($totalCost, 2),`

### A.462 — B.259 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- Baseline ID (v34): `B.259`
- File: `app/Services/CostingService.php`
- Evidence: `'total_quantity' => (float) $totalQuantity,`

### A.463 — B.258 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- Baseline ID (v34): `B.258`
- File: `app/Services/CostingService.php`
- Evidence: `'total_value' => (float) $totalValue,`

### A.464 — B.257 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- Baseline ID (v34): `B.257`
- File: `app/Services/CostingService.php`
- Evidence: `'transit_quantity' => (float) $transitQuantity,`

### A.465 — B.256 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- Baseline ID (v34): `B.256`
- File: `app/Services/CostingService.php`
- Evidence: `'transit_value' => (float) $transitValue,`

### A.466 — B.245 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- Baseline ID (v34): `B.245`
- File: `app/Services/CostingService.php`
- Evidence: `'unit_cost' => (float) $avgCost,`

### A.467 — B.249 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- Baseline ID (v34): `B.249`
- File: `app/Services/CostingService.php`
- Evidence: `'unit_cost' => (float) $batch->unit_cost,`

### A.468 — B.251 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- Baseline ID (v34): `B.251`
- File: `app/Services/CostingService.php`
- Evidence: `'unit_cost' => (float) $unitCost,`

### A.469 — B.255 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- Baseline ID (v34): `B.255`
- File: `app/Services/CostingService.php`
- Evidence: `'warehouse_quantity' => (float) $warehouseQuantity,`

### A.470 — B.254 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- Baseline ID (v34): `B.254`
- File: `app/Services/CostingService.php`
- Evidence: `'warehouse_value' => (float) $warehouseValue,`

### A.471 — B.262 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- Baseline ID (v34): `B.262`
- File: `app/Services/CostingService.php`
- Evidence: `if ((float) $totalStock <= self::STOCK_ZERO_TOLERANCE) {`

### A.472 — A.214 — Medium — Finance/Precision — BCMath result cast to float
- Baseline ID (v34): `A.214`
- File: `app/Services/CurrencyExchangeService.php`
- Evidence: `        return (float) bcmul((string) $amount, (string) $rate, 4);`

### A.473 — B.265 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- Baseline ID (v34): `B.265`
- File: `app/Services/CurrencyExchangeService.php`
- Evidence: `'rate' => (float) $r->rate,`

### A.474 — B.264 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- Baseline ID (v34): `B.264`
- File: `app/Services/CurrencyExchangeService.php`
- Evidence: `return $rate ? (float) $rate->rate : null;`

### A.475 — B.263 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- Baseline ID (v34): `B.263`
- File: `app/Services/CurrencyExchangeService.php`
- Evidence: `return (float) bcmul((string) $amount, (string) $rate, 4);`

### A.476 — A.215 — Medium — Finance/Precision — BCMath result cast to float
- Baseline ID (v34): `A.215`
- File: `app/Services/CurrencyService.php`
- Evidence: `        return (float) bcmul((string) $amount, (string) $rate, 2);`

### A.477 — B.266 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- Baseline ID (v34): `B.266`
- File: `app/Services/CurrencyService.php`
- Evidence: `return (float) bcmul((string) $amount, (string) $rate, 2);`

### A.478 — A.216 — Medium — Finance/Precision — Money/amount cast to float (rounding drift risk)
- Baseline ID (v34): `A.216`
- File: `app/Services/DataValidationService.php`
- Evidence: `        $amount = (float) $amount;`

### A.479 — B.267 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- Baseline ID (v34): `B.267`
- File: `app/Services/DataValidationService.php`
- Evidence: `$amount = (float) $amount;`

### A.480 — A.217 — Medium — Perf/Security — Loads entire file into memory (Storage::get)
- Baseline ID (v34): `A.217`
- File: `app/Services/DiagnosticsService.php`
- Evidence: `            $retrieved = Storage::disk($disk)->get($filename);`

### A.481 — A.220 — Medium — Finance/Precision — Money/amount cast to float (rounding drift risk)
- Baseline ID (v34): `A.220`
- File: `app/Services/DiscountService.php`
- Evidence: `            $value = (float) ($discount['value'] ?? 0);`

### A.482 — A.219 — Medium — Finance/Precision — Money/amount cast to float (rounding drift risk)
- Baseline ID (v34): `A.219`
- File: `app/Services/DiscountService.php`
- Evidence: `            : (float) config('pos.discount.max_amount', 1000);`

### A.483 — A.218 — Medium — Finance/Precision — Money/amount cast to float (rounding drift risk)
- Baseline ID (v34): `A.218`
- File: `app/Services/DiscountService.php`
- Evidence: `        return (float) config('pos.discount.max_amount', 1000);`

### A.484 — B.274 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- Baseline ID (v34): `B.274`
- File: `app/Services/DiscountService.php`
- Evidence: `$maxDiscountPercent = (float) config('sales.max_combined_discount_percent', 80);`

### A.485 — B.273 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- Baseline ID (v34): `B.273`
- File: `app/Services/DiscountService.php`
- Evidence: `$value = (float) ($discount['value'] ?? 0);`

### A.486 — B.272 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- Baseline ID (v34): `B.272`
- File: `app/Services/DiscountService.php`
- Evidence: `: (float) config('pos.discount.max_amount', 1000);`

### A.487 — B.271 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- Baseline ID (v34): `B.271`
- File: `app/Services/DiscountService.php`
- Evidence: `? (float) config('sales.max_invoice_discount_percent', 30)`

### A.488 — B.268 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- Baseline ID (v34): `B.268`
- File: `app/Services/DiscountService.php`
- Evidence: `return (float) bcround($discTotal, 2);`

### A.489 — B.270 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- Baseline ID (v34): `B.270`
- File: `app/Services/DiscountService.php`
- Evidence: `return (float) config('pos.discount.max_amount', 1000);`

### A.490 — B.269 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- Baseline ID (v34): `B.269`
- File: `app/Services/DiscountService.php`
- Evidence: `return (float) config('sales.max_line_discount_percent',`

### A.491 — A.223 — Medium — Finance/Precision — Money/amount cast to float (rounding drift risk)
- Baseline ID (v34): `A.223`
- File: `app/Services/FinancialReportService.php`
- Evidence: `                'total' => (float) bcround((string) $totalAssets, 2),`

### A.492 — A.225 — Medium — Finance/Precision — Money/amount cast to float (rounding drift risk)
- Baseline ID (v34): `A.225`
- File: `app/Services/FinancialReportService.php`
- Evidence: `                'total' => (float) bcround((string) $totalEquity, 2),`

### A.493 — A.222 — Medium — Finance/Precision — Money/amount cast to float (rounding drift risk)
- Baseline ID (v34): `A.222`
- File: `app/Services/FinancialReportService.php`
- Evidence: `                'total' => (float) bcround((string) $totalExpenses, 2),`

### A.494 — A.224 — Medium — Finance/Precision — Money/amount cast to float (rounding drift risk)
- Baseline ID (v34): `A.224`
- File: `app/Services/FinancialReportService.php`
- Evidence: `                'total' => (float) bcround((string) $totalLiabilities, 2),`

### A.495 — A.221 — Medium — Finance/Precision — Money/amount cast to float (rounding drift risk)
- Baseline ID (v34): `A.221`
- File: `app/Services/FinancialReportService.php`
- Evidence: `                'total' => (float) bcround((string) $totalRevenue, 2),`

### A.496 — B.286 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- Baseline ID (v34): `B.286`
- File: `app/Services/FinancialReportService.php`
- Evidence: `$credit = (float) $line->credit;`

### A.497 — B.285 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- Baseline ID (v34): `B.285`
- File: `app/Services/FinancialReportService.php`
- Evidence: `$debit = (float) $line->debit;`

### A.498 — B.284 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- Baseline ID (v34): `B.284`
- File: `app/Services/FinancialReportService.php`
- Evidence: `$outstandingAmount = (float) $purchase->total_amount - (float) $totalPaid;`

### A.499 — B.283 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- Baseline ID (v34): `B.283`
- File: `app/Services/FinancialReportService.php`
- Evidence: `$outstandingAmount = (float) $sale->total_amount - (float) $totalPaid + (float) $totalRefunded;`

### A.500 — B.291 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- Baseline ID (v34): `B.291`
- File: `app/Services/FinancialReportService.php`
- Evidence: `$totalCredit = (float) $query->sum('credit');`

### A.501 — B.290 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- Baseline ID (v34): `B.290`
- File: `app/Services/FinancialReportService.php`
- Evidence: `$totalDebit = (float) $query->sum('debit');`

### A.502 — B.289 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- Baseline ID (v34): `B.289`
- File: `app/Services/FinancialReportService.php`
- Evidence: `'ending_balance' => (float) bcround((string) $runningBalance, 2),`

### A.503 — B.279 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- Baseline ID (v34): `B.279`
- File: `app/Services/FinancialReportService.php`
- Evidence: `'total' => (float) bcround((string) $totalAssets, 2),`

### A.504 — B.281 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- Baseline ID (v34): `B.281`
- File: `app/Services/FinancialReportService.php`
- Evidence: `'total' => (float) bcround((string) $totalEquity, 2),`

### A.505 — B.278 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- Baseline ID (v34): `B.278`
- File: `app/Services/FinancialReportService.php`
- Evidence: `'total' => (float) bcround((string) $totalExpenses, 2),`

### A.506 — B.280 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- Baseline ID (v34): `B.280`
- File: `app/Services/FinancialReportService.php`
- Evidence: `'total' => (float) bcround((string) $totalLiabilities, 2),`

### A.507 — B.277 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- Baseline ID (v34): `B.277`
- File: `app/Services/FinancialReportService.php`
- Evidence: `'total' => (float) bcround((string) $totalRevenue, 2),`

### A.508 — B.276 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- Baseline ID (v34): `B.276`
- File: `app/Services/FinancialReportService.php`
- Evidence: `'total_credit' => (float) bcround($totalCreditStr, 2),`

### A.509 — B.288 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- Baseline ID (v34): `B.288`
- File: `app/Services/FinancialReportService.php`
- Evidence: `'total_credit' => (float) bcround((string) $totalCredit, 2),`

### A.510 — B.275 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- Baseline ID (v34): `B.275`
- File: `app/Services/FinancialReportService.php`
- Evidence: `'total_debit' => (float) bcround($totalDebitStr, 2),`

### A.511 — B.287 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- Baseline ID (v34): `B.287`
- File: `app/Services/FinancialReportService.php`
- Evidence: `'total_debit' => (float) bcround((string) $totalDebit, 2),`

### A.512 — B.282 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- Baseline ID (v34): `B.282`
- File: `app/Services/FinancialReportService.php`
- Evidence: `'total_liabilities_and_equity' => (float) $totalLiabilitiesAndEquity,`

### A.513 — A.226 — Medium — Finance/Precision — Float cast for totals
- Baseline ID (v34): `A.226`
- File: `app/Services/HRMService.php`
- Evidence: `                        $housingAllowance = (float) ($extra['housing_allowance'] ?? 0);`

### A.514 — A.229 — Medium — Finance/Precision — Float cast for totals
- Baseline ID (v34): `A.229`
- File: `app/Services/HRMService.php`
- Evidence: `                        $loanDeduction = (float) ($extra['loan_deduction'] ?? 0);`

### A.515 — A.228 — Medium — Finance/Precision — Float cast for totals
- Baseline ID (v34): `A.228`
- File: `app/Services/HRMService.php`
- Evidence: `                        $otherAllowance = (float) ($extra['other_allowance'] ?? 0);`

### A.516 — A.227 — Medium — Finance/Precision — Float cast for totals
- Baseline ID (v34): `A.227`
- File: `app/Services/HRMService.php`
- Evidence: `                        $transportAllowance = (float) ($extra['transport_allowance'] ?? 0);`

### A.517 — A.230 — Medium — Finance/Precision — BCMath result cast to float
- Baseline ID (v34): `A.230`
- File: `app/Services/HRMService.php`
- Evidence: `            return (float) bcmul((string) $dailyRate, (string) $absenceDays, 2);`

### A.518 — B.293 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- Baseline ID (v34): `B.293`
- File: `app/Services/HRMService.php`
- Evidence: `$dailyRate = (float) $emp->salary / 30;`

### A.519 — B.294 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- Baseline ID (v34): `B.294`
- File: `app/Services/HRMService.php`
- Evidence: `return (float) bcmul((string) $dailyRate, (string) $absenceDays, 2);`

### A.520 — B.292 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- Baseline ID (v34): `B.292`
- File: `app/Services/HRMService.php`
- Evidence: `return (float) bcround($monthlyTax, 2);`

### A.521 — A.231 — Medium — Finance/Precision — BCMath result cast to float
- Baseline ID (v34): `A.231`
- File: `app/Services/HelpdeskService.php`
- Evidence: `        return (float) bcdiv((string) $totalMinutes, (string) $tickets->count(), 2);`

### A.522 — B.295 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- Baseline ID (v34): `B.295`
- File: `app/Services/HelpdeskService.php`
- Evidence: `return (float) bcdiv((string) $totalMinutes, (string) $tickets->count(), 2);`

### A.523 — B.298 — Medium — Perf/Security — Loads full file into memory (Storage::get / file_get_contents)
- Baseline ID (v34): `B.298`
- File: `app/Services/ImageOptimizationService.php`
- Evidence: `Storage::disk($disk)->put($path, file_get_contents($file->getRealPath()));`

### A.524 — B.296 — Medium — Perf/Security — Loads full file into memory (Storage::get / file_get_contents)
- Baseline ID (v34): `B.296`
- File: `app/Services/ImageOptimizationService.php`
- Evidence: `Storage::disk($disk)->put($path, file_get_contents($tempPath));`

### A.525 — B.297 — Medium — Perf/Security — Loads full file into memory (Storage::get / file_get_contents)
- Baseline ID (v34): `B.297`
- File: `app/Services/ImageOptimizationService.php`
- Evidence: `Storage::disk($disk)->put($thumbnailPath, file_get_contents($tempPath));`

### A.526 — A.233 — Medium — Finance/Precision — Money/amount cast to float (rounding drift risk)
- Baseline ID (v34): `A.233`
- File: `app/Services/ImportService.php`
- Evidence: `            'cost' => (float) ($data['cost'] ?? 0),`

### A.527 — A.234 — Medium — Finance/Precision — Float cast for totals
- Baseline ID (v34): `A.234`
- File: `app/Services/ImportService.php`
- Evidence: `            'credit_limit' => (float) ($data['credit_limit'] ?? 0),`

### A.528 — A.232 — Medium — Finance/Precision — Float cast for totals
- Baseline ID (v34): `A.232`
- File: `app/Services/ImportService.php`
- Evidence: `            'default_price' => (float) ($data['default_price'] ?? 0),`

### A.529 — B.300 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- Baseline ID (v34): `B.300`
- File: `app/Services/ImportService.php`
- Evidence: `'cost' => (float) ($data['cost'] ?? 0),`

### A.530 — B.301 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- Baseline ID (v34): `B.301`
- File: `app/Services/ImportService.php`
- Evidence: `'credit_limit' => (float) ($data['credit_limit'] ?? 0),`

### A.531 — B.299 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- Baseline ID (v34): `B.299`
- File: `app/Services/ImportService.php`
- Evidence: `'default_price' => (float) ($data['default_price'] ?? 0),`

### A.532 — A.235 — Medium — Finance/Precision — Money/amount cast to float (rounding drift risk)
- Baseline ID (v34): `A.235`
- File: `app/Services/InstallmentService.php`
- Evidence: `                            'amount_due' => max(0, (float) $amount),`

### A.533 — B.306 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- Baseline ID (v34): `B.306`
- File: `app/Services/InstallmentService.php`
- Evidence: `$planRemainingAmount = max(0, (float) $planRemainingAmount);`

### A.534 — B.304 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- Baseline ID (v34): `B.304`
- File: `app/Services/InstallmentService.php`
- Evidence: `$remainingAmount = (float) $payment->remaining_amount;`

### A.535 — B.302 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- Baseline ID (v34): `B.302`
- File: `app/Services/InstallmentService.php`
- Evidence: `$totalAmount = (float) $sale->grand_total;`

### A.536 — B.303 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- Baseline ID (v34): `B.303`
- File: `app/Services/InstallmentService.php`
- Evidence: `'amount_due' => max(0, (float) $amount),`

### A.537 — B.305 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- Baseline ID (v34): `B.305`
- File: `app/Services/InstallmentService.php`
- Evidence: `'amount_paid' => (float) $newAmountPaid,`

### A.538 — A.236 — Medium — Finance/Precision — Float cast for totals
- Baseline ID (v34): `A.236`
- File: `app/Services/InventoryService.php`
- Evidence: `                    return (float) ($perWarehouse->get($warehouseId, 0.0));`

### A.539 — B.307 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- Baseline ID (v34): `B.307`
- File: `app/Services/InventoryService.php`
- Evidence: `$qty = (float) $data['qty'];`

### A.540 — B.308 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- Baseline ID (v34): `B.308`
- File: `app/Services/InventoryService.php`
- Evidence: `return (float) $query->sum('quantity');`

### A.541 — A.237 — Medium — Finance/Precision — BCMath result cast to float
- Baseline ID (v34): `A.237`
- File: `app/Services/LoyaltyService.php`
- Evidence: `        return (float) bcmul((string) $points, (string) $settings->redemption_rate, 2);`

### A.542 — B.309 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- Baseline ID (v34): `B.309`
- File: `app/Services/LoyaltyService.php`
- Evidence: `return (float) bcmul((string) $points, (string) $settings->redemption_rate, 2);`

### A.543 — A.245 — Medium — Finance/Precision — Money/amount cast to float (rounding drift risk)
- Baseline ID (v34): `A.245`
- File: `app/Services/POSService.php`
- Evidence: `                            'paid' => (float) $paidAmountString,`

### A.544 — A.243 — Medium — Finance/Precision — Money/amount cast to float (rounding drift risk)
- Baseline ID (v34): `A.243`
- File: `app/Services/POSService.php`
- Evidence: `                        $amount = (float) ($payment['amount'] ?? 0);`

### A.545 — A.244 — Medium — Finance/Precision — Money/amount cast to float (rounding drift risk)
- Baseline ID (v34): `A.244`
- File: `app/Services/POSService.php`
- Evidence: `                        'amount' => (float) bcround($grandTotal, 2),`

### A.546 — A.242 — Medium — Finance/Precision — Money/amount cast to float (rounding drift risk)
- Baseline ID (v34): `A.242`
- File: `app/Services/POSService.php`
- Evidence: `                    $itemDiscountPercent = (float) ($it['discount'] ?? 0);`

### A.547 — A.239 — Medium — Finance/Precision — Money/amount cast to float (rounding drift risk)
- Baseline ID (v34): `A.239`
- File: `app/Services/POSService.php`
- Evidence: `                    $price = isset($it['price']) ? (float) $it['price'] : (float) ($product->default_price ?? 0);`

### A.548 — A.238 — Medium — Finance/Precision — Float cast for totals
- Baseline ID (v34): `A.238`
- File: `app/Services/POSService.php`
- Evidence: `                    $qty = (float) ($it['qty'] ?? 1);`

### A.549 — A.241 — Medium — Finance/Precision — Money/amount cast to float (rounding drift risk)
- Baseline ID (v34): `A.241`
- File: `app/Services/POSService.php`
- Evidence: `                    (new ValidPriceOverride((float) $product->cost, 0.0))->validate('price', $price, function ($m) {`

### A.550 — A.240 — Medium — Finance/Precision — Money/amount cast to float (rounding drift risk)
- Baseline ID (v34): `A.240`
- File: `app/Services/POSService.php`
- Evidence: `                    if ($user && ! $user->can_modify_price && abs($price - (float) ($product->default_price ?? 0)) > 0.001) {`

### A.551 — B.322 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- Baseline ID (v34): `B.322`
- File: `app/Services/POSService.php`
- Evidence: `$amount = (float) ($payment['amount'] ?? 0);`

### A.552 — B.315 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- Baseline ID (v34): `B.315`
- File: `app/Services/POSService.php`
- Evidence: `$itemDiscountPercent = (float) ($it['discount'] ?? 0);`

### A.553 — B.310 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- Baseline ID (v34): `B.310`
- File: `app/Services/POSService.php`
- Evidence: `$previousDailyDiscount = (float) Sale::where('created_by', $user->id)`

### A.554 — B.312 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- Baseline ID (v34): `B.312`
- File: `app/Services/POSService.php`
- Evidence: `$price = isset($it['price']) ? (float) $it['price'] : (float) ($product->default_price ?? 0);`

### A.555 — B.311 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- Baseline ID (v34): `B.311`
- File: `app/Services/POSService.php`
- Evidence: `$qty = (float) ($it['qty'] ?? 1);`

### A.556 — B.319 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- Baseline ID (v34): `B.319`
- File: `app/Services/POSService.php`
- Evidence: `$sale->discount_amount = (float) bcround((string) $discountTotal, 2);`

### A.557 — B.324 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- Baseline ID (v34): `B.324`
- File: `app/Services/POSService.php`
- Evidence: `$sale->paid_amount = (float) bcround($paidTotal, 2);`

### A.558 — B.318 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- Baseline ID (v34): `B.318`
- File: `app/Services/POSService.php`
- Evidence: `$sale->subtotal = (float) bcround((string) $subtotal, 2);`

### A.559 — B.320 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- Baseline ID (v34): `B.320`
- File: `app/Services/POSService.php`
- Evidence: `$sale->tax_amount = (float) bcround((string) $taxTotal, 2);`

### A.560 — B.321 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- Baseline ID (v34): `B.321`
- File: `app/Services/POSService.php`
- Evidence: `$sale->total_amount = (float) bcround($grandTotal, 2);`

### A.561 — B.316 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- Baseline ID (v34): `B.316`
- File: `app/Services/POSService.php`
- Evidence: `$systemMaxDiscount = (float) setting('pos.max_discount_percent', 100);`

### A.562 — B.325 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- Baseline ID (v34): `B.325`
- File: `app/Services/POSService.php`
- Evidence: `$totalSales = (float) $salesQuery->sum('total_amount');`

### A.563 — B.323 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- Baseline ID (v34): `B.323`
- File: `app/Services/POSService.php`
- Evidence: `'amount' => (float) bcround($grandTotal, 2),`

### A.564 — B.326 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- Baseline ID (v34): `B.326`
- File: `app/Services/POSService.php`
- Evidence: `'gross' => (float) $totalAmountString,`

### A.565 — B.317 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- Baseline ID (v34): `B.317`
- File: `app/Services/POSService.php`
- Evidence: `'line_total' => (float) bcround($lineTotal, 2),`

### A.566 — B.327 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- Baseline ID (v34): `B.327`
- File: `app/Services/POSService.php`
- Evidence: `'paid' => (float) $paidAmountString,`

### A.567 — B.329 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- Baseline ID (v34): `B.329`
- File: `app/Services/POSService.php`
- Evidence: `'paid_amount' => (float) $paidAmountString,`

### A.568 — B.328 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- Baseline ID (v34): `B.328`
- File: `app/Services/POSService.php`
- Evidence: `'total_amount' => (float) $totalAmountString,`

### A.569 — B.314 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- Baseline ID (v34): `B.314`
- File: `app/Services/POSService.php`
- Evidence: `(new ValidPriceOverride((float) $product->cost, 0.0))->validate('price', $price, function ($m) {`

### A.570 — B.313 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- Baseline ID (v34): `B.313`
- File: `app/Services/POSService.php`
- Evidence: `if ($user && ! $user->can_modify_price && abs($price - (float) ($product->default_price ?? 0)) > 0.001) {`

### A.571 — A.249 — Medium — Finance/Precision — Float cast for totals
- Baseline ID (v34): `A.249`
- File: `app/Services/PayslipService.php`
- Evidence: `            $limit = (float) ($bracket['limit'] ?? PHP_FLOAT_MAX);`

### A.572 — A.250 — Medium — Finance/Precision — Float cast for totals
- Baseline ID (v34): `A.250`
- File: `app/Services/PayslipService.php`
- Evidence: `            $rate = (float) ($bracket['rate'] ?? 0);`

### A.573 — A.246 — Medium — Finance/Precision — Money/amount cast to float (rounding drift risk)
- Baseline ID (v34): `A.246`
- File: `app/Services/PayslipService.php`
- Evidence: `            'total' => (float) $total,`

### A.574 — A.248 — Medium — Finance/Precision — Float cast for totals
- Baseline ID (v34): `A.248`
- File: `app/Services/PayslipService.php`
- Evidence: `        $siMaxSalary = (float) ($siConfig['max_salary'] ?? 12600);`

### A.575 — A.247 — Medium — Finance/Precision — Float cast for totals
- Baseline ID (v34): `A.247`
- File: `app/Services/PayslipService.php`
- Evidence: `        $siRate = (float) ($siConfig['rate'] ?? 0.14);`

### A.576 — B.333 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- Baseline ID (v34): `B.333`
- File: `app/Services/PayslipService.php`
- Evidence: `$allowances['housing'] = (float) $housingAmount;`

### A.577 — B.331 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- Baseline ID (v34): `B.331`
- File: `app/Services/PayslipService.php`
- Evidence: `$allowances['transport'] = (float) $transportAmount;`

### A.578 — B.332 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- Baseline ID (v34): `B.332`
- File: `app/Services/PayslipService.php`
- Evidence: `$housingValue = (float) setting('hrm.housing_allowance_value', 0);`

### A.579 — B.336 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- Baseline ID (v34): `B.336`
- File: `app/Services/PayslipService.php`
- Evidence: `$rate = (float) ($bracket['rate'] ?? 0);`

### A.580 — B.335 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- Baseline ID (v34): `B.335`
- File: `app/Services/PayslipService.php`
- Evidence: `$siRate = (float) ($siConfig['rate'] ?? 0.14);`

### A.581 — B.330 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- Baseline ID (v34): `B.330`
- File: `app/Services/PayslipService.php`
- Evidence: `$transportValue = (float) setting('hrm.transport_allowance_value', 10);`

### A.582 — B.334 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- Baseline ID (v34): `B.334`
- File: `app/Services/PayslipService.php`
- Evidence: `'total' => (float) $total,`

### A.583 — A.252 — Medium — Finance/Precision — BCMath result cast to float
- Baseline ID (v34): `A.252`
- File: `app/Services/PricingService.php`
- Evidence: `                            return (float) bcdiv((string) $p, '1', 4);`

### A.584 — A.256 — Medium — Finance/Precision — Money/amount cast to float (rounding drift risk)
- Baseline ID (v34): `A.256`
- File: `app/Services/PricingService.php`
- Evidence: `                    'discount' => (float) bcround((string) $discount, 2),`

### A.585 — A.257 — Medium — Finance/Precision — Money/amount cast to float (rounding drift risk)
- Baseline ID (v34): `A.257`
- File: `app/Services/PricingService.php`
- Evidence: `                    'tax' => (float) bcround((string) $taxAmount, 2),`

### A.586 — A.258 — Medium — Finance/Precision — Money/amount cast to float (rounding drift risk)
- Baseline ID (v34): `A.258`
- File: `app/Services/PricingService.php`
- Evidence: `                    'total' => (float) bcround((string) $total, 2),`

### A.587 — A.251 — Medium — Finance/Precision — BCMath result cast to float
- Baseline ID (v34): `A.251`
- File: `app/Services/PricingService.php`
- Evidence: `                    return (float) bcdiv((string) $override, '1', 4);`

### A.588 — A.255 — Medium — Finance/Precision — Money/amount cast to float (rounding drift risk)
- Baseline ID (v34): `A.255`
- File: `app/Services/PricingService.php`
- Evidence: `                $discVal = (float) Arr::get($line, 'discount', 0);`

### A.589 — A.254 — Medium — Finance/Precision — Money/amount cast to float (rounding drift risk)
- Baseline ID (v34): `A.254`
- File: `app/Services/PricingService.php`
- Evidence: `                $price = max(0.0, (float) Arr::get($line, 'price', 0));`

### A.590 — A.253 — Medium — Finance/Precision — BCMath result cast to float
- Baseline ID (v34): `A.253`
- File: `app/Services/PricingService.php`
- Evidence: `                return (float) bcdiv((string) $base, '1', 4);`

### A.591 — B.339 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- Baseline ID (v34): `B.339`
- File: `app/Services/PricingService.php`
- Evidence: `$discVal = (float) Arr::get($line, 'discount', 0);`

### A.592 — B.338 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- Baseline ID (v34): `B.338`
- File: `app/Services/PricingService.php`
- Evidence: `$price = max(0.0, (float) Arr::get($line, 'price', 0));`

### A.593 — B.337 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- Baseline ID (v34): `B.337`
- File: `app/Services/PricingService.php`
- Evidence: `$qty = max(0.0, (float) Arr::get($line, 'qty', 1));`

### A.594 — B.341 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- Baseline ID (v34): `B.341`
- File: `app/Services/PricingService.php`
- Evidence: `'discount' => (float) bcround((string) $discount, 2),`

### A.595 — B.340 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- Baseline ID (v34): `B.340`
- File: `app/Services/PricingService.php`
- Evidence: `'subtotal' => (float) bcround((string) $subtotal, 2),`

### A.596 — B.342 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- Baseline ID (v34): `B.342`
- File: `app/Services/PricingService.php`
- Evidence: `'tax' => (float) bcround((string) $taxAmount, 2),`

### A.597 — B.343 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- Baseline ID (v34): `B.343`
- File: `app/Services/PricingService.php`
- Evidence: `'total' => (float) bcround((string) $total, 2),`

### A.598 — A.260 — Medium — Finance/Precision — Money/amount cast to float (rounding drift risk)
- Baseline ID (v34): `A.260`
- File: `app/Services/ProductService.php`
- Evidence: `                            $product->cost = (float) $cost;`

### A.599 — A.259 — Medium — Finance/Precision — Money/amount cast to float (rounding drift risk)
- Baseline ID (v34): `A.259`
- File: `app/Services/ProductService.php`
- Evidence: `                            $product->default_price = (float) $price;`

### A.600 — B.345 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- Baseline ID (v34): `B.345`
- File: `app/Services/ProductService.php`
- Evidence: `$product->cost = (float) $cost;`

### A.601 — B.344 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- Baseline ID (v34): `B.344`
- File: `app/Services/ProductService.php`
- Evidence: `$product->default_price = (float) $price;`

### A.602 — B.347 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- Baseline ID (v34): `B.347`
- File: `app/Services/PurchaseReturnService.php`
- Evidence: `$purchaseQty = (float) $purchaseItem->quantity;`

### A.603 — B.346 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- Baseline ID (v34): `B.346`
- File: `app/Services/PurchaseReturnService.php`
- Evidence: `$qtyReturned = (float) $itemData['qty_returned'];`

### A.604 — B.349 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- Baseline ID (v34): `B.349`
- File: `app/Services/PurchaseReturnService.php`
- Evidence: `'qty' => (float) $item->qty_returned,`

### A.605 — B.350 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- Baseline ID (v34): `B.350`
- File: `app/Services/PurchaseReturnService.php`
- Evidence: `'unit_cost' => (float) $item->unit_cost,`

### A.606 — B.348 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- Baseline ID (v34): `B.348`
- File: `app/Services/PurchaseReturnService.php`
- Evidence: `if ((float) $item->qty_returned <= 0) {`

### A.607 — A.265 — Medium — Finance/Precision — BCMath result cast to float
- Baseline ID (v34): `A.265`
- File: `app/Services/PurchaseService.php`
- Evidence: `                        $lineTax = (float) bcmul($taxableAmount, bcdiv((string) $taxPercent, '100', 6), 2);`

### A.608 — A.262 — Medium — Finance/Precision — Float cast for totals
- Baseline ID (v34): `A.262`
- File: `app/Services/PurchaseService.php`
- Evidence: `                    $discountPercent = (float) ($it['discount_percent'] ?? 0);`

### A.609 — A.264 — Medium — Finance/Precision — Float cast for totals
- Baseline ID (v34): `A.264`
- File: `app/Services/PurchaseService.php`
- Evidence: `                    $lineTax = (float) ($it['tax_amount'] ?? 0);`

### A.610 — A.263 — Medium — Finance/Precision — Float cast for totals
- Baseline ID (v34): `A.263`
- File: `app/Services/PurchaseService.php`
- Evidence: `                    $taxPercent = (float) ($it['tax_percent'] ?? 0);`

### A.611 — A.261 — Medium — Finance/Precision — Money/amount cast to float (rounding drift risk)
- Baseline ID (v34): `A.261`
- File: `app/Services/PurchaseService.php`
- Evidence: `                    $unitPrice = (float) ($it['unit_price'] ?? $it['price'] ?? 0);`

### A.612 — A.266 — Medium — Finance/Precision — Float cast for totals
- Baseline ID (v34): `A.266`
- File: `app/Services/PurchaseService.php`
- Evidence: `                $shippingAmount = (float) ($payload['shipping_amount'] ?? 0);`

### A.613 — A.267 — Medium — Finance/Precision — Money/amount cast to float (rounding drift risk)
- Baseline ID (v34): `A.267`
- File: `app/Services/PurchaseService.php`
- Evidence: `                if ($p->payment_status === 'paid' || (float) $p->paid_amount > 0) {`

### A.614 — B.353 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- Baseline ID (v34): `B.353`
- File: `app/Services/PurchaseService.php`
- Evidence: `$discountPercent = (float) ($it['discount_percent'] ?? 0);`

### A.615 — B.355 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- Baseline ID (v34): `B.355`
- File: `app/Services/PurchaseService.php`
- Evidence: `$lineTax = (float) ($it['tax_amount'] ?? 0);`

### A.616 — B.356 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- Baseline ID (v34): `B.356`
- File: `app/Services/PurchaseService.php`
- Evidence: `$lineTax = (float) bcmul($taxableAmount, bcdiv((string) $taxPercent, '100', 6), 2);`

### A.617 — B.361 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- Baseline ID (v34): `B.361`
- File: `app/Services/PurchaseService.php`
- Evidence: `$p->discount_amount = (float) bcround($totalDiscount, 2);`

### A.618 — B.364 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- Baseline ID (v34): `B.364`
- File: `app/Services/PurchaseService.php`
- Evidence: `$p->paid_amount = (float) $newPaidAmount;`

### A.619 — B.359 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- Baseline ID (v34): `B.359`
- File: `app/Services/PurchaseService.php`
- Evidence: `$p->subtotal = (float) bcround($subtotal, 2);`

### A.620 — B.360 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- Baseline ID (v34): `B.360`
- File: `app/Services/PurchaseService.php`
- Evidence: `$p->tax_amount = (float) bcround($totalTax, 2);`

### A.621 — B.362 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- Baseline ID (v34): `B.362`
- File: `app/Services/PurchaseService.php`
- Evidence: `$p->total_amount = (float) bcround(`

### A.622 — B.351 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- Baseline ID (v34): `B.351`
- File: `app/Services/PurchaseService.php`
- Evidence: `$qty = (float) $it['qty'];`

### A.623 — B.363 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- Baseline ID (v34): `B.363`
- File: `app/Services/PurchaseService.php`
- Evidence: `$remainingDue = max(0, (float) $p->total_amount - (float) $p->paid_amount);`

### A.624 — B.358 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- Baseline ID (v34): `B.358`
- File: `app/Services/PurchaseService.php`
- Evidence: `$shippingAmount = (float) ($payload['shipping_amount'] ?? 0);`

### A.625 — B.354 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- Baseline ID (v34): `B.354`
- File: `app/Services/PurchaseService.php`
- Evidence: `$taxPercent = (float) ($it['tax_percent'] ?? 0);`

### A.626 — B.352 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- Baseline ID (v34): `B.352`
- File: `app/Services/PurchaseService.php`
- Evidence: `$unitPrice = (float) ($it['unit_price'] ?? $it['price'] ?? 0);`

### A.627 — B.357 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- Baseline ID (v34): `B.357`
- File: `app/Services/PurchaseService.php`
- Evidence: `'line_total' => (float) $lineTotal,`

### A.628 — B.367 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- Baseline ID (v34): `B.367`
- File: `app/Services/PurchaseService.php`
- Evidence: `if ($p->payment_status === 'paid' || (float) $p->paid_amount > 0) {`

### A.629 — B.365 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- Baseline ID (v34): `B.365`
- File: `app/Services/PurchaseService.php`
- Evidence: `if ((float) $p->paid_amount >= (float) $p->total_amount) {`

### A.630 — B.366 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- Baseline ID (v34): `B.366`
- File: `app/Services/PurchaseService.php`
- Evidence: `} elseif ((float) $p->paid_amount > 0) {`

### A.631 — A.268 — Medium — Finance/Precision — Money/amount cast to float (rounding drift risk)
- Baseline ID (v34): `A.268`
- File: `app/Services/RentalService.php`
- Evidence: `                $i->amount = (float) $newAmount;`

### A.632 — A.270 — Medium — Finance/Precision — BCMath result cast to float
- Baseline ID (v34): `A.270`
- File: `app/Services/RentalService.php`
- Evidence: `            ? (float) bcmul(bcdiv((string) $collectedAmount, (string) $totalAmount, 4), '100', 2)`

### A.633 — A.269 — Medium — Finance/Precision — BCMath result cast to float
- Baseline ID (v34): `A.269`
- File: `app/Services/RentalService.php`
- Evidence: `            ? (float) bcmul(bcdiv((string) $occupiedUnits, (string) $totalUnits, 4), '100', 2)`

### A.634 — B.369 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- Baseline ID (v34): `B.369`
- File: `app/Services/RentalService.php`
- Evidence: `$i->amount = (float) $newAmount;`

### A.635 — B.368 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- Baseline ID (v34): `B.368`
- File: `app/Services/RentalService.php`
- Evidence: `$i->paid_total = (float) $newPaidTotal;`

### A.636 — B.371 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- Baseline ID (v34): `B.371`
- File: `app/Services/RentalService.php`
- Evidence: `? (float) bcmul(bcdiv((string) $collectedAmount, (string) $totalAmount, 4), '100', 2)`

### A.637 — B.370 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- Baseline ID (v34): `B.370`
- File: `app/Services/RentalService.php`
- Evidence: `? (float) bcmul(bcdiv((string) $occupiedUnits, (string) $totalUnits, 4), '100', 2)`

### A.638 — A.273 — Medium — Finance/Precision — Money/amount cast to float (rounding drift risk)
- Baseline ID (v34): `A.273`
- File: `app/Services/ReportService.php`
- Evidence: `                    'pnl' => (float) ($sales->total ?? 0) - (float) ($purchases->total ?? 0),`

### A.639 — A.272 — Medium — Finance/Precision — Money/amount cast to float (rounding drift risk)
- Baseline ID (v34): `A.272`
- File: `app/Services/ReportService.php`
- Evidence: `                    'purchases' => ['total' => (float) ($purchases->total ?? 0), 'paid' => (float) ($purchases->paid ?? 0)],`

### A.640 — A.271 — Medium — Finance/Precision — Money/amount cast to float (rounding drift risk)
- Baseline ID (v34): `A.271`
- File: `app/Services/ReportService.php`
- Evidence: `                    'sales' => ['total' => (float) ($sales->total ?? 0), 'paid' => (float) ($sales->paid ?? 0)],`

### A.641 — B.374 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- Baseline ID (v34): `B.374`
- File: `app/Services/ReportService.php`
- Evidence: `'pnl' => (float) ($sales->total ?? 0) - (float) ($purchases->total ?? 0),`

### A.642 — B.373 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- Baseline ID (v34): `B.373`
- File: `app/Services/ReportService.php`
- Evidence: `'purchases' => ['total' => (float) ($purchases->total ?? 0), 'paid' => (float) ($purchases->paid ?? 0)],`

### A.643 — B.372 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- Baseline ID (v34): `B.372`
- File: `app/Services/ReportService.php`
- Evidence: `'sales' => ['total' => (float) ($sales->total ?? 0), 'paid' => (float) ($sales->paid ?? 0)],`

### A.644 — A.274 — Medium — Finance/Precision — Money/amount cast to float (rounding drift risk)
- Baseline ID (v34): `A.274`
- File: `app/Services/Reports/CashFlowForecastService.php`
- Evidence: `            'total_expected_inflows' => (float) $expectedInflows->sum('amount'),`

### A.645 — A.275 — Medium — Finance/Precision — Money/amount cast to float (rounding drift risk)
- Baseline ID (v34): `A.275`
- File: `app/Services/Reports/CashFlowForecastService.php`
- Evidence: `            'total_expected_outflows' => (float) $expectedOutflows->sum('amount'),`

### A.646 — B.378 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- Baseline ID (v34): `B.378`
- File: `app/Services/Reports/CashFlowForecastService.php`
- Evidence: `'ending_balance' => (float) $runningBalance,`

### A.647 — B.377 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- Baseline ID (v34): `B.377`
- File: `app/Services/Reports/CashFlowForecastService.php`
- Evidence: `'ending_cash_forecast' => (float) $dailyForecast->last()['ending_balance'],`

### A.648 — B.375 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- Baseline ID (v34): `B.375`
- File: `app/Services/Reports/CashFlowForecastService.php`
- Evidence: `'total_expected_inflows' => (float) $expectedInflows->sum('amount'),`

### A.649 — B.376 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- Baseline ID (v34): `B.376`
- File: `app/Services/Reports/CashFlowForecastService.php`
- Evidence: `'total_expected_outflows' => (float) $expectedOutflows->sum('amount'),`

### A.650 — A.276 — Medium — Finance/Precision — BCMath result cast to float
- Baseline ID (v34): `A.276`
- File: `app/Services/Reports/CustomerSegmentationService.php`
- Evidence: `                    ? (float) bcdiv($totalRevenue, (string) count($customers), 2)`

### A.651 — B.379 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- Baseline ID (v34): `B.379`
- File: `app/Services/Reports/CustomerSegmentationService.php`
- Evidence: `'total_revenue' => (float) $totalRevenue,`

### A.652 — B.380 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- Baseline ID (v34): `B.380`
- File: `app/Services/Reports/CustomerSegmentationService.php`
- Evidence: `? (float) bcdiv($totalRevenue, (string) count($customers), 2)`

### A.653 — B.382 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- Baseline ID (v34): `B.382`
- File: `app/Services/Reports/SlowMovingStockService.php`
- Evidence: `'daily_sales_rate' => (float) $dailyRate,`

### A.654 — B.381 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- Baseline ID (v34): `B.381`
- File: `app/Services/Reports/SlowMovingStockService.php`
- Evidence: `'stock_value' => (float) $stockValue,`

### A.655 — B.384 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- Baseline ID (v34): `B.384`
- File: `app/Services/Reports/SlowMovingStockService.php`
- Evidence: `'total_potential_loss' => (float) $products->sum(function ($product) {`

### A.656 — B.383 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- Baseline ID (v34): `B.383`
- File: `app/Services/Reports/SlowMovingStockService.php`
- Evidence: `'total_stock_value' => (float) $products->sum(function ($product) {`

### A.657 — A.278 — Medium — Finance/Precision — Money/amount cast to float (rounding drift risk)
- Baseline ID (v34): `A.278`
- File: `app/Services/SaleService.php`
- Evidence: `                            'amount' => (float) $refund,`

### A.658 — A.277 — Medium — Finance/Precision — Float cast for totals
- Baseline ID (v34): `A.277`
- File: `app/Services/SaleService.php`
- Evidence: `                        $requestedQty = (float) ($it['qty'] ?? 0);`

### A.659 — B.386 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- Baseline ID (v34): `B.386`
- File: `app/Services/SaleService.php`
- Evidence: `$availableToReturn = max(0, (float) $si->quantity - $alreadyReturned);`

### A.660 — B.390 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- Baseline ID (v34): `B.390`
- File: `app/Services/SaleService.php`
- Evidence: `$currentReturnMap[$saleItemId] = ($currentReturnMap[$saleItemId] ?? 0) + (float) $item['qty'];`

### A.661 — B.385 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- Baseline ID (v34): `B.385`
- File: `app/Services/SaleService.php`
- Evidence: `$requestedQty = (float) ($it['qty'] ?? 0);`

### A.662 — B.389 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- Baseline ID (v34): `B.389`
- File: `app/Services/SaleService.php`
- Evidence: `$returned[$itemId] = abs((float) $returnedQty);`

### A.663 — B.391 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- Baseline ID (v34): `B.391`
- File: `app/Services/SaleService.php`
- Evidence: `$soldQty = (float) $saleItem->quantity;`

### A.664 — B.388 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- Baseline ID (v34): `B.388`
- File: `app/Services/SaleService.php`
- Evidence: `'amount' => (float) $refund,`

### A.665 — B.387 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- Baseline ID (v34): `B.387`
- File: `app/Services/SaleService.php`
- Evidence: `'total_amount' => (float) $refund,`

### A.666 — A.280 — Medium — Finance/Precision — Money/amount cast to float (rounding drift risk)
- Baseline ID (v34): `A.280`
- File: `app/Services/SalesReturnService.php`
- Evidence: `                $requestedAmount = (float) ($validated['amount'] ?? $return->refund_amount);`

### A.667 — B.394 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- Baseline ID (v34): `B.394`
- File: `app/Services/SalesReturnService.php`
- Evidence: `$remainingRefundable = (float) $return->refund_amount - (float) $alreadyRefunded;`

### A.668 — B.393 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- Baseline ID (v34): `B.393`
- File: `app/Services/SalesReturnService.php`
- Evidence: `$requestedAmount = (float) ($validated['amount'] ?? $return->refund_amount);`

### A.669 — B.395 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- Baseline ID (v34): `B.395`
- File: `app/Services/SmartNotificationsService.php`
- Evidence: `$dueTotal = max(0, (float) $invoice->total_amount - (float) $invoice->paid_amount);`

### A.670 — B.401 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- Baseline ID (v34): `B.401`
- File: `app/Services/StockReorderService.php`
- Evidence: `'total_estimated_cost' => (float) bcround((string) $totalEstimatedCost, 2),`

### A.671 — B.400 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- Baseline ID (v34): `B.400`
- File: `app/Services/StockReorderService.php`
- Evidence: `return $totalSold ? ((float) $totalSold / $days) : 0;`

### A.672 — B.398 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- Baseline ID (v34): `B.398`
- File: `app/Services/StockReorderService.php`
- Evidence: `return (float) $product->maximum_order_quantity;`

### A.673 — B.397 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- Baseline ID (v34): `B.397`
- File: `app/Services/StockReorderService.php`
- Evidence: `return (float) $product->minimum_order_quantity;`

### A.674 — B.396 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- Baseline ID (v34): `B.396`
- File: `app/Services/StockReorderService.php`
- Evidence: `return (float) $product->reorder_qty;`

### A.675 — B.399 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- Baseline ID (v34): `B.399`
- File: `app/Services/StockReorderService.php`
- Evidence: `return (float) bcround((string) $optimalQty, 2);`

### A.676 — B.404 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- Baseline ID (v34): `B.404`
- File: `app/Services/StockService.php`
- Evidence: `$totalStock = (float) StockMovement::where('product_id', $productId)`

### A.677 — B.402 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- Baseline ID (v34): `B.402`
- File: `app/Services/StockService.php`
- Evidence: `return (float) $query->selectRaw('COALESCE(SUM(quantity), 0) as stock')`

### A.678 — B.403 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- Baseline ID (v34): `B.403`
- File: `app/Services/StockService.php`
- Evidence: `return (float) ($query->selectRaw('SUM(quantity * COALESCE(unit_cost, 0)) as value')`

### A.679 — A.283 — Medium — Finance/Precision — Float cast for totals
- Baseline ID (v34): `A.283`
- File: `app/Services/StockTransferService.php`
- Evidence: `                    $qtyDamaged = (float) ($itemData['qty_damaged'] ?? 0);`

### A.680 — A.285 — Medium — Finance/Precision — Float cast for totals
- Baseline ID (v34): `A.285`
- File: `app/Services/StockTransferService.php`
- Evidence: `                    $qtyDamaged = (float) ($itemReceivingData['qty_damaged'] ?? 0);`

### A.681 — A.282 — Medium — Finance/Precision — Float cast for totals
- Baseline ID (v34): `A.282`
- File: `app/Services/StockTransferService.php`
- Evidence: `                    $qtyReceived = (float) ($itemData['qty_received'] ?? 0);`

### A.682 — A.284 — Medium — Finance/Precision — Float cast for totals
- Baseline ID (v34): `A.284`
- File: `app/Services/StockTransferService.php`
- Evidence: `                    $qtyReceived = (float) ($itemReceivingData['qty_received'] ?? $item->qty_shipped);`

### A.683 — A.281 — Medium — Finance/Precision — Float cast for totals
- Baseline ID (v34): `A.281`
- File: `app/Services/StockTransferService.php`
- Evidence: `                    $requestedQty = (float) ($itemData['qty'] ?? 0);`

### A.684 — B.406 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- Baseline ID (v34): `B.406`
- File: `app/Services/StockTransferService.php`
- Evidence: `$itemQuantities[(int) $itemId] = (float) $itemData['qty_shipped'];`

### A.685 — B.408 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- Baseline ID (v34): `B.408`
- File: `app/Services/StockTransferService.php`
- Evidence: `$qtyDamaged = (float) ($itemData['qty_damaged'] ?? 0);`

### A.686 — B.410 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- Baseline ID (v34): `B.410`
- File: `app/Services/StockTransferService.php`
- Evidence: `$qtyDamaged = (float) ($itemReceivingData['qty_damaged'] ?? 0);`

### A.687 — B.407 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- Baseline ID (v34): `B.407`
- File: `app/Services/StockTransferService.php`
- Evidence: `$qtyReceived = (float) ($itemData['qty_received'] ?? 0);`

### A.688 — B.409 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- Baseline ID (v34): `B.409`
- File: `app/Services/StockTransferService.php`
- Evidence: `$qtyReceived = (float) ($itemReceivingData['qty_received'] ?? $item->qty_shipped);`

### A.689 — B.405 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- Baseline ID (v34): `B.405`
- File: `app/Services/StockTransferService.php`
- Evidence: `$requestedQty = (float) ($itemData['qty'] ?? 0);`

### A.690 — A.287 — Medium — Finance/Precision — Money/amount cast to float (rounding drift risk)
- Baseline ID (v34): `A.287`
- File: `app/Services/Store/StoreOrderToSaleService.php`
- Evidence: `            $discount = (float) Arr::get($item, 'discount', 0);`

### A.691 — A.286 — Medium — Finance/Precision — Money/amount cast to float (rounding drift risk)
- Baseline ID (v34): `A.286`
- File: `app/Services/Store/StoreOrderToSaleService.php`
- Evidence: `            $price = (float) Arr::get($item, 'price', 0);`

### A.692 — A.291 — Medium — Finance/Precision — Money/amount cast to float (rounding drift risk)
- Baseline ID (v34): `A.291`
- File: `app/Services/Store/StoreOrderToSaleService.php`
- Evidence: `        $discount = (float) ($order->discount_total ?? 0);`

### A.693 — A.290 — Medium — Finance/Precision — Float cast for totals
- Baseline ID (v34): `A.290`
- File: `app/Services/Store/StoreOrderToSaleService.php`
- Evidence: `        $shipping = (float) ($order->shipping_total ?? 0);`

### A.694 — A.289 — Medium — Finance/Precision — Money/amount cast to float (rounding drift risk)
- Baseline ID (v34): `A.289`
- File: `app/Services/Store/StoreOrderToSaleService.php`
- Evidence: `        $tax = (float) ($order->tax_total ?? 0);`

### A.695 — A.288 — Medium — Finance/Precision — Money/amount cast to float (rounding drift risk)
- Baseline ID (v34): `A.288`
- File: `app/Services/Store/StoreOrderToSaleService.php`
- Evidence: `        $total = (float) ($order->total ?? 0);`

### A.696 — B.417 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- Baseline ID (v34): `B.417`
- File: `app/Services/Store/StoreOrderToSaleService.php`
- Evidence: `$discount = (float) ($order->discount_total ?? 0);`

### A.697 — B.413 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- Baseline ID (v34): `B.413`
- File: `app/Services/Store/StoreOrderToSaleService.php`
- Evidence: `$discount = (float) Arr::get($item, 'discount', 0);`

### A.698 — B.412 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- Baseline ID (v34): `B.412`
- File: `app/Services/Store/StoreOrderToSaleService.php`
- Evidence: `$price = (float) Arr::get($item, 'price', 0);`

### A.699 — B.411 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- Baseline ID (v34): `B.411`
- File: `app/Services/Store/StoreOrderToSaleService.php`
- Evidence: `$qty = (float) Arr::get($item, 'qty', 0);`

### A.700 — B.416 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- Baseline ID (v34): `B.416`
- File: `app/Services/Store/StoreOrderToSaleService.php`
- Evidence: `$shipping = (float) ($order->shipping_total ?? 0);`

### A.701 — B.415 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- Baseline ID (v34): `B.415`
- File: `app/Services/Store/StoreOrderToSaleService.php`
- Evidence: `$tax = (float) ($order->tax_total ?? 0);`

### A.702 — B.414 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- Baseline ID (v34): `B.414`
- File: `app/Services/Store/StoreOrderToSaleService.php`
- Evidence: `$total = (float) ($order->total ?? 0);`

### A.703 — A.313 — Medium — Finance/Precision — Money/amount cast to float (rounding drift risk)
- Baseline ID (v34): `A.313`
- File: `app/Services/Store/StoreSyncService.php`
- Evidence: `                    'discount_amount' => (float) ($lineItem['discount'] ?? 0),`

### A.704 — A.298 — Medium — Finance/Precision — Float cast for totals
- Baseline ID (v34): `A.298`
- File: `app/Services/Store/StoreSyncService.php`
- Evidence: `                    'discount_amount' => (float) ($lineItem['total_discount'] ?? 0),`

### A.705 — A.314 — Medium — Finance/Precision — Money/amount cast to float (rounding drift risk)
- Baseline ID (v34): `A.314`
- File: `app/Services/Store/StoreSyncService.php`
- Evidence: `                    'line_total' => (float) ($lineItem['line_total'] ?? $lineItem['total'] ?? 0),`

### A.706 — A.299 — Medium — Finance/Precision — Money/amount cast to float (rounding drift risk)
- Baseline ID (v34): `A.299`
- File: `app/Services/Store/StoreSyncService.php`
- Evidence: `                    'line_total' => (float) ($lineItem['quantity'] ?? 1) * (float) ($lineItem['price'] ?? 0) - (float) ($lineItem['total_discount'] ?? 0),`

### A.707 — A.304 — Medium — Finance/Precision — Money/amount cast to float (rounding drift risk)
- Baseline ID (v34): `A.304`
- File: `app/Services/Store/StoreSyncService.php`
- Evidence: `                    'line_total' => (float) ($lineItem['total'] ?? 0),`

### A.708 — A.311 — Medium — Finance/Precision — Float cast for totals
- Baseline ID (v34): `A.311`
- File: `app/Services/Store/StoreSyncService.php`
- Evidence: `                    'quantity' => (float) ($lineItem['qty'] ?? $lineItem['quantity'] ?? 1),`

### A.709 — A.297 — Medium — Finance/Precision — Money/amount cast to float (rounding drift risk)
- Baseline ID (v34): `A.297`
- File: `app/Services/Store/StoreSyncService.php`
- Evidence: `                    'unit_price' => (float) ($lineItem['price'] ?? 0),`

### A.710 — A.312 — Medium — Finance/Precision — Money/amount cast to float (rounding drift risk)
- Baseline ID (v34): `A.312`
- File: `app/Services/Store/StoreSyncService.php`
- Evidence: `                    'unit_price' => (float) ($lineItem['unit_price'] ?? $lineItem['price'] ?? 0),`

### A.711 — A.306 — Medium — Finance/Precision — Money/amount cast to float (rounding drift risk)
- Baseline ID (v34): `A.306`
- File: `app/Services/Store/StoreSyncService.php`
- Evidence: `                'cost' => (float) ($data['cost'] ?? 0),`

### A.712 — A.305 — Medium — Finance/Precision — Money/amount cast to float (rounding drift risk)
- Baseline ID (v34): `A.305`
- File: `app/Services/Store/StoreSyncService.php`
- Evidence: `                'default_price' => (float) ($data['default_price'] ?? $data['price'] ?? 0),`

### A.713 — A.300 — Medium — Finance/Precision — Money/amount cast to float (rounding drift risk)
- Baseline ID (v34): `A.300`
- File: `app/Services/Store/StoreSyncService.php`
- Evidence: `                'default_price' => (float) ($data['price'] ?? 0),`

### A.714 — A.292 — Medium — Finance/Precision — Money/amount cast to float (rounding drift risk)
- Baseline ID (v34): `A.292`
- File: `app/Services/Store/StoreSyncService.php`
- Evidence: `                'default_price' => (float) ($data['variants'][0]['price'] ?? 0),`

### A.715 — A.309 — Medium — Finance/Precision — Money/amount cast to float (rounding drift risk)
- Baseline ID (v34): `A.309`
- File: `app/Services/Store/StoreSyncService.php`
- Evidence: `                'discount_amount' => (float) ($data['discount_total'] ?? $data['discount'] ?? 0),`

### A.716 — A.302 — Medium — Finance/Precision — Float cast for totals
- Baseline ID (v34): `A.302`
- File: `app/Services/Store/StoreSyncService.php`
- Evidence: `                'discount_amount' => (float) ($data['discount_total'] ?? 0),`

### A.717 — A.295 — Medium — Finance/Precision — Float cast for totals
- Baseline ID (v34): `A.295`
- File: `app/Services/Store/StoreSyncService.php`
- Evidence: `                'discount_amount' => (float) ($data['total_discounts'] ?? 0),`

### A.718 — A.307 — Medium — Finance/Precision — Float cast for totals
- Baseline ID (v34): `A.307`
- File: `app/Services/Store/StoreSyncService.php`
- Evidence: `                'subtotal' => (float) ($data['sub_total'] ?? $data['subtotal'] ?? 0),`

### A.719 — A.293 — Medium — Finance/Precision — Float cast for totals
- Baseline ID (v34): `A.293`
- File: `app/Services/Store/StoreSyncService.php`
- Evidence: `                'subtotal' => (float) ($data['subtotal_price'] ?? 0),`

### A.720 — A.301 — Medium — Finance/Precision — Money/amount cast to float (rounding drift risk)
- Baseline ID (v34): `A.301`
- File: `app/Services/Store/StoreSyncService.php`
- Evidence: `                'subtotal' => (float) ($data['total'] ?? 0) - (float) ($data['total_tax'] ?? 0),`

### A.721 — A.308 — Medium — Finance/Precision — Money/amount cast to float (rounding drift risk)
- Baseline ID (v34): `A.308`
- File: `app/Services/Store/StoreSyncService.php`
- Evidence: `                'tax_amount' => (float) ($data['tax_total'] ?? $data['tax'] ?? 0),`

### A.722 — A.294 — Medium — Finance/Precision — Float cast for totals
- Baseline ID (v34): `A.294`
- File: `app/Services/Store/StoreSyncService.php`
- Evidence: `                'tax_amount' => (float) ($data['total_tax'] ?? 0),`

### A.723 — A.310 — Medium — Finance/Precision — Money/amount cast to float (rounding drift risk)
- Baseline ID (v34): `A.310`
- File: `app/Services/Store/StoreSyncService.php`
- Evidence: `                'total_amount' => (float) ($data['grand_total'] ?? $data['total'] ?? 0),`

### A.724 — A.303 — Medium — Finance/Precision — Money/amount cast to float (rounding drift risk)
- Baseline ID (v34): `A.303`
- File: `app/Services/Store/StoreSyncService.php`
- Evidence: `                'total_amount' => (float) ($data['total'] ?? 0),`

### A.725 — A.296 — Medium — Finance/Precision — Float cast for totals
- Baseline ID (v34): `A.296`
- File: `app/Services/Store/StoreSyncService.php`
- Evidence: `                'total_amount' => (float) ($data['total_price'] ?? 0),`

### A.726 — A.315 — Medium — Finance/Precision — Money/amount cast to float (rounding drift risk)
- Baseline ID (v34): `A.315`
- File: `app/Services/Store/StoreSyncService.php`
- Evidence: `        return (float) ($product->standard_cost ?? $product->cost ?? 0);`

### A.727 — B.432 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- Baseline ID (v34): `B.432`
- File: `app/Services/Store/StoreSyncService.php`
- Evidence: `'cost' => (float) ($data['cost'] ?? 0),`

### A.728 — B.431 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- Baseline ID (v34): `B.431`
- File: `app/Services/Store/StoreSyncService.php`
- Evidence: `'default_price' => (float) ($data['default_price'] ?? $data['price'] ?? 0),`

### A.729 — B.426 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- Baseline ID (v34): `B.426`
- File: `app/Services/Store/StoreSyncService.php`
- Evidence: `'default_price' => (float) ($data['price'] ?? 0),`

### A.730 — B.418 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- Baseline ID (v34): `B.418`
- File: `app/Services/Store/StoreSyncService.php`
- Evidence: `'default_price' => (float) ($data['variants'][0]['price'] ?? 0),`

### A.731 — B.435 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- Baseline ID (v34): `B.435`
- File: `app/Services/Store/StoreSyncService.php`
- Evidence: `'discount_amount' => (float) ($data['discount_total'] ?? $data['discount'] ?? 0),`

### A.732 — B.428 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- Baseline ID (v34): `B.428`
- File: `app/Services/Store/StoreSyncService.php`
- Evidence: `'discount_amount' => (float) ($data['discount_total'] ?? 0),`

### A.733 — B.421 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- Baseline ID (v34): `B.421`
- File: `app/Services/Store/StoreSyncService.php`
- Evidence: `'discount_amount' => (float) ($data['total_discounts'] ?? 0),`

### A.734 — B.439 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- Baseline ID (v34): `B.439`
- File: `app/Services/Store/StoreSyncService.php`
- Evidence: `'discount_amount' => (float) ($lineItem['discount'] ?? 0),`

### A.735 — B.424 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- Baseline ID (v34): `B.424`
- File: `app/Services/Store/StoreSyncService.php`
- Evidence: `'discount_amount' => (float) ($lineItem['total_discount'] ?? 0),`

### A.736 — B.440 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- Baseline ID (v34): `B.440`
- File: `app/Services/Store/StoreSyncService.php`
- Evidence: `'line_total' => (float) ($lineItem['line_total'] ?? $lineItem['total'] ?? 0),`

### A.737 — B.425 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- Baseline ID (v34): `B.425`
- File: `app/Services/Store/StoreSyncService.php`
- Evidence: `'line_total' => (float) ($lineItem['quantity'] ?? 1) * (float) ($lineItem['price'] ?? 0) - (float) ($lineItem['total_discount'] ?? 0),`

### A.738 — B.430 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- Baseline ID (v34): `B.430`
- File: `app/Services/Store/StoreSyncService.php`
- Evidence: `'line_total' => (float) ($lineItem['total'] ?? 0),`

### A.739 — B.437 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- Baseline ID (v34): `B.437`
- File: `app/Services/Store/StoreSyncService.php`
- Evidence: `'quantity' => (float) ($lineItem['qty'] ?? $lineItem['quantity'] ?? 1),`

### A.740 — B.433 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- Baseline ID (v34): `B.433`
- File: `app/Services/Store/StoreSyncService.php`
- Evidence: `'subtotal' => (float) ($data['sub_total'] ?? $data['subtotal'] ?? 0),`

### A.741 — B.419 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- Baseline ID (v34): `B.419`
- File: `app/Services/Store/StoreSyncService.php`
- Evidence: `'subtotal' => (float) ($data['subtotal_price'] ?? 0),`

### A.742 — B.427 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- Baseline ID (v34): `B.427`
- File: `app/Services/Store/StoreSyncService.php`
- Evidence: `'subtotal' => (float) ($data['total'] ?? 0) - (float) ($data['total_tax'] ?? 0),`

### A.743 — B.434 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- Baseline ID (v34): `B.434`
- File: `app/Services/Store/StoreSyncService.php`
- Evidence: `'tax_amount' => (float) ($data['tax_total'] ?? $data['tax'] ?? 0),`

### A.744 — B.420 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- Baseline ID (v34): `B.420`
- File: `app/Services/Store/StoreSyncService.php`
- Evidence: `'tax_amount' => (float) ($data['total_tax'] ?? 0),`

### A.745 — B.436 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- Baseline ID (v34): `B.436`
- File: `app/Services/Store/StoreSyncService.php`
- Evidence: `'total_amount' => (float) ($data['grand_total'] ?? $data['total'] ?? 0),`

### A.746 — B.429 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- Baseline ID (v34): `B.429`
- File: `app/Services/Store/StoreSyncService.php`
- Evidence: `'total_amount' => (float) ($data['total'] ?? 0),`

### A.747 — B.422 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- Baseline ID (v34): `B.422`
- File: `app/Services/Store/StoreSyncService.php`
- Evidence: `'total_amount' => (float) ($data['total_price'] ?? 0),`

### A.748 — B.423 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- Baseline ID (v34): `B.423`
- File: `app/Services/Store/StoreSyncService.php`
- Evidence: `'unit_price' => (float) ($lineItem['price'] ?? 0),`

### A.749 — B.438 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- Baseline ID (v34): `B.438`
- File: `app/Services/Store/StoreSyncService.php`
- Evidence: `'unit_price' => (float) ($lineItem['unit_price'] ?? $lineItem['price'] ?? 0),`

### A.750 — B.441 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- Baseline ID (v34): `B.441`
- File: `app/Services/Store/StoreSyncService.php`
- Evidence: `return (float) ($product->standard_cost ?? $product->cost ?? 0);`

### A.751 — A.324 — Medium — Finance/Precision — BCMath result cast to float
- Baseline ID (v34): `A.324`
- File: `app/Services/TaxService.php`
- Evidence: `                        'total_with_tax' => (float) bcadd((string) $subtotal, (string) $taxAmount, 4),`

### A.752 — A.323 — Medium — Finance/Precision — Float cast for totals
- Baseline ID (v34): `A.323`
- File: `app/Services/TaxService.php`
- Evidence: `                    $subtotal = (float) ($item['subtotal'] ?? $item['line_total'] ?? 0);`

### A.753 — A.318 — Medium — Finance/Precision — BCMath result cast to float
- Baseline ID (v34): `A.318`
- File: `app/Services/TaxService.php`
- Evidence: `                    return (float) bcdiv($taxPortion, '1', 4);`

### A.754 — A.320 — Medium — Finance/Precision — BCMath result cast to float
- Baseline ID (v34): `A.320`
- File: `app/Services/TaxService.php`
- Evidence: `                    return (float) bcdiv((string) $base, '1', 4);`

### A.755 — A.317 — Medium — Finance/Precision — Money/amount cast to float (rounding drift risk)
- Baseline ID (v34): `A.317`
- File: `app/Services/TaxService.php`
- Evidence: `                $rate = (float) $tax->rate;`

### A.756 — A.325 — Medium — Finance/Precision — Float cast for totals
- Baseline ID (v34): `A.325`
- File: `app/Services/TaxService.php`
- Evidence: `                $rate = (float) ($taxRateRules['rate'] ?? 0);`

### A.757 — A.319 — Medium — Finance/Precision — BCMath result cast to float
- Baseline ID (v34): `A.319`
- File: `app/Services/TaxService.php`
- Evidence: `                return (float) bcdiv($taxAmount, '1', 4);`

### A.758 — A.321 — Medium — Finance/Precision — BCMath result cast to float
- Baseline ID (v34): `A.321`
- File: `app/Services/TaxService.php`
- Evidence: `                return (float) bcdiv($total, '1', 4);`

### A.759 — A.322 — Medium — Finance/Precision — BCMath result cast to float
- Baseline ID (v34): `A.322`
- File: `app/Services/TaxService.php`
- Evidence: `            defaultValue: (float) bcdiv((string) $base, '1', 4)`

### A.760 — A.316 — Medium — Finance/Precision — Money/amount cast to float (rounding drift risk)
- Baseline ID (v34): `A.316`
- File: `app/Services/TaxService.php`
- Evidence: `        return (float) ($tax?->rate ?? 0.0);`

### A.761 — B.444 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- Baseline ID (v34): `B.444`
- File: `app/Services/TaxService.php`
- Evidence: `$rate = (float) $tax->rate;`

### A.762 — B.452 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- Baseline ID (v34): `B.452`
- File: `app/Services/TaxService.php`
- Evidence: `$rate = (float) ($taxRateRules['rate'] ?? 0);`

### A.763 — B.449 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- Baseline ID (v34): `B.449`
- File: `app/Services/TaxService.php`
- Evidence: `$subtotal = (float) ($item['subtotal'] ?? $item['line_total'] ?? 0);`

### A.764 — B.451 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- Baseline ID (v34): `B.451`
- File: `app/Services/TaxService.php`
- Evidence: `'total_tax' => (float) bcround($totalTax, 2),`

### A.765 — B.450 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- Baseline ID (v34): `B.450`
- File: `app/Services/TaxService.php`
- Evidence: `'total_with_tax' => (float) bcadd((string) $subtotal, (string) $taxAmount, 4),`

### A.766 — B.448 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- Baseline ID (v34): `B.448`
- File: `app/Services/TaxService.php`
- Evidence: `defaultValue: (float) bcdiv((string) $base, '1', 4)`

### A.767 — B.442 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- Baseline ID (v34): `B.442`
- File: `app/Services/TaxService.php`
- Evidence: `return (float) ($tax?->rate ?? 0.0);`

### A.768 — B.446 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- Baseline ID (v34): `B.446`
- File: `app/Services/TaxService.php`
- Evidence: `return (float) bcdiv($taxAmount, '1', 4);`

### A.769 — B.445 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- Baseline ID (v34): `B.445`
- File: `app/Services/TaxService.php`
- Evidence: `return (float) bcdiv($taxPortion, '1', 4);`

### A.770 — B.447 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- Baseline ID (v34): `B.447`
- File: `app/Services/TaxService.php`
- Evidence: `return (float) bcdiv($total, '1', 4);`

### A.771 — B.443 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- Baseline ID (v34): `B.443`
- File: `app/Services/TaxService.php`
- Evidence: `return (float) bcround($taxAmount, 2);`

### A.772 — A.326 — Medium — Finance/Precision — BCMath result cast to float
- Baseline ID (v34): `A.326`
- File: `app/Services/UIHelperService.php`
- Evidence: `            $value = (float) bcdiv((string) $value, '1024', $precision + 2);`

### A.773 — B.453 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- Baseline ID (v34): `B.453`
- File: `app/Services/UIHelperService.php`
- Evidence: `$value = (float) bcdiv((string) $value, '1024', $precision + 2);`

### A.774 — A.332 — Medium — Finance/Precision — Money/amount cast to float (rounding drift risk)
- Baseline ID (v34): `A.332`
- File: `app/Services/UX/SmartSuggestionsService.php`
- Evidence: `                    'price' => (float) $item->default_price,`

### A.775 — A.333 — Medium — Finance/Precision — Money/amount cast to float (rounding drift risk)
- Baseline ID (v34): `A.333`
- File: `app/Services/UX/SmartSuggestionsService.php`
- Evidence: `                    'price' => (float) $product->default_price,`

### A.776 — A.328 — Medium — Finance/Precision — Money/amount cast to float (rounding drift risk)
- Baseline ID (v34): `A.328`
- File: `app/Services/UX/SmartSuggestionsService.php`
- Evidence: `                'price' => (float) $price,`

### A.777 — A.329 — Medium — Finance/Precision — BCMath result cast to float
- Baseline ID (v34): `A.329`
- File: `app/Services/UX/SmartSuggestionsService.php`
- Evidence: `                'profit_per_unit' => (float) bcsub($price, (string) $cost, 2),`

### A.778 — A.331 — Medium — Finance/Precision — BCMath result cast to float
- Baseline ID (v34): `A.331`
- File: `app/Services/UX/SmartSuggestionsService.php`
- Evidence: `            'profit_per_unit' => (float) bcsub($suggestedPrice, (string) $cost, 2),`

### A.779 — A.336 — Medium — Finance/Precision — BCMath result cast to float
- Baseline ID (v34): `A.336`
- File: `app/Services/UX/SmartSuggestionsService.php`
- Evidence: `            ? (float) bcmul(bcdiv(bcsub((string) $product->default_price, (string) $product->standard_cost, 2), (string) $product->default_price, 4), '100', 2)`

### A.780 — A.327 — Medium — Finance/Precision — Money/amount cast to float (rounding drift risk)
- Baseline ID (v34): `A.327`
- File: `app/Services/UX/SmartSuggestionsService.php`
- Evidence: `        $cost = (float) ($product->standard_cost ?? 0);`

### A.781 — A.330 — Medium — Finance/Precision — Float cast for totals
- Baseline ID (v34): `A.330`
- File: `app/Services/UX/SmartSuggestionsService.php`
- Evidence: `        $currentPrice = (float) ($product->default_price ?? 0);`

### A.782 — A.335 — Medium — Finance/Precision — Float cast for totals
- Baseline ID (v34): `A.335`
- File: `app/Services/UX/SmartSuggestionsService.php`
- Evidence: `        return (float) ($totalStock ?? 0);`

### A.783 — A.334 — Medium — Finance/Precision — BCMath result cast to float
- Baseline ID (v34): `A.334`
- File: `app/Services/UX/SmartSuggestionsService.php`
- Evidence: `        return (float) bcdiv((string) ($totalSold ?? 0), (string) $days, 2);`

### A.784 — B.456 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- Baseline ID (v34): `B.456`
- File: `app/Services/UX/SmartSuggestionsService.php`
- Evidence: `$cost = (float) ($product->standard_cost ?? 0);`

### A.785 — B.459 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- Baseline ID (v34): `B.459`
- File: `app/Services/UX/SmartSuggestionsService.php`
- Evidence: `$currentPrice = (float) ($product->default_price ?? 0);`

### A.786 — B.454 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- Baseline ID (v34): `B.454`
- File: `app/Services/UX/SmartSuggestionsService.php`
- Evidence: `$suggestedQty = max((float) $eoq, (float) $product->minimum_order_quantity ?? 1);`

### A.787 — B.464 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- Baseline ID (v34): `B.464`
- File: `app/Services/UX/SmartSuggestionsService.php`
- Evidence: `'avg_quantity' => (float) $item->avg_quantity,`

### A.788 — B.465 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- Baseline ID (v34): `B.465`
- File: `app/Services/UX/SmartSuggestionsService.php`
- Evidence: `'individual_total' => (float) $totalPrice,`

### A.789 — B.463 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- Baseline ID (v34): `B.463`
- File: `app/Services/UX/SmartSuggestionsService.php`
- Evidence: `'price' => (float) $item->default_price,`

### A.790 — B.457 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- Baseline ID (v34): `B.457`
- File: `app/Services/UX/SmartSuggestionsService.php`
- Evidence: `'price' => (float) $price,`

### A.791 — B.467 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- Baseline ID (v34): `B.467`
- File: `app/Services/UX/SmartSuggestionsService.php`
- Evidence: `'price' => (float) $product->default_price,`

### A.792 — B.458 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- Baseline ID (v34): `B.458`
- File: `app/Services/UX/SmartSuggestionsService.php`
- Evidence: `'profit_per_unit' => (float) bcsub($price, (string) $cost, 2),`

### A.793 — B.461 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- Baseline ID (v34): `B.461`
- File: `app/Services/UX/SmartSuggestionsService.php`
- Evidence: `'profit_per_unit' => (float) bcsub($suggestedPrice, (string) $cost, 2),`

### A.794 — B.462 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- Baseline ID (v34): `B.462`
- File: `app/Services/UX/SmartSuggestionsService.php`
- Evidence: `'recommendation' => $this->generatePricingRecommendation((float) $suggestedPrice, $currentPrice, (float) $currentMargin),`

### A.795 — B.455 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- Baseline ID (v34): `B.455`
- File: `app/Services/UX/SmartSuggestionsService.php`
- Evidence: `'recommendation' => $this->generateReorderRecommendation($urgency, (float) $daysOfStock, $suggestedQty),`

### A.796 — B.466 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- Baseline ID (v34): `B.466`
- File: `app/Services/UX/SmartSuggestionsService.php`
- Evidence: `'suggested_bundle_price' => (float) $suggestedBundlePrice,`

### A.797 — B.460 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- Baseline ID (v34): `B.460`
- File: `app/Services/UX/SmartSuggestionsService.php`
- Evidence: `'suggested_price' => (float) $suggestedPrice,`

### A.798 — B.470 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- Baseline ID (v34): `B.470`
- File: `app/Services/UX/SmartSuggestionsService.php`
- Evidence: `? (float) bcmul(bcdiv(bcsub((string) $product->default_price, (string) $product->standard_cost, 2), (string) $product->default_price, 4), '100', 2)`

### A.799 — B.469 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- Baseline ID (v34): `B.469`
- File: `app/Services/UX/SmartSuggestionsService.php`
- Evidence: `return (float) ($totalStock ?? 0);`

### A.800 — B.468 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- Baseline ID (v34): `B.468`
- File: `app/Services/UX/SmartSuggestionsService.php`
- Evidence: `return (float) bcdiv((string) ($totalSold ?? 0), (string) $days, 2);`

### A.801 — A.338 — Medium — Finance/Precision — Money/amount cast to float (rounding drift risk)
- Baseline ID (v34): `A.338`
- File: `app/Services/WhatsAppService.php`
- Evidence: `            'discount' => number_format((float) $sale->discount_total, 2),`

### A.802 — A.337 — Medium — Finance/Precision — Money/amount cast to float (rounding drift risk)
- Baseline ID (v34): `A.337`
- File: `app/Services/WhatsAppService.php`
- Evidence: `            'tax' => number_format((float) $sale->tax_total, 2),`

### A.803 — A.339 — Medium — Finance/Precision — Money/amount cast to float (rounding drift risk)
- Baseline ID (v34): `A.339`
- File: `app/Services/WhatsAppService.php`
- Evidence: `            'total' => number_format((float) $sale->grand_total, 2),`

### A.804 — B.474 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- Baseline ID (v34): `B.474`
- File: `app/Services/WhatsAppService.php`
- Evidence: `'discount' => number_format((float) $sale->discount_total, 2),`

### A.805 — B.472 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- Baseline ID (v34): `B.472`
- File: `app/Services/WhatsAppService.php`
- Evidence: `'subtotal' => number_format((float) $sale->sub_total, 2),`

### A.806 — B.473 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- Baseline ID (v34): `B.473`
- File: `app/Services/WhatsAppService.php`
- Evidence: `'tax' => number_format((float) $sale->tax_total, 2),`

### A.807 — B.475 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- Baseline ID (v34): `B.475`
- File: `app/Services/WhatsAppService.php`
- Evidence: `'total' => number_format((float) $sale->grand_total, 2),`

### A.808 — B.471 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- Baseline ID (v34): `B.471`
- File: `app/Services/WhatsAppService.php`
- Evidence: `return "• {$item->product->name} x{$item->qty} = ".number_format((float) $item->line_total, 2);`

### A.809 — A.340 — Medium — Finance/Precision — Float cast for totals
- Baseline ID (v34): `A.340`
- File: `app/Services/WoodService.php`
- Evidence: `                    'qty' => (float) ($payload['qty'] ?? 0),`

### A.810 — B.477 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- Baseline ID (v34): `B.477`
- File: `app/Services/WoodService.php`
- Evidence: `$eff = $this->efficiency((float) $row->input_qty, (float) $row->output_qty);`

### A.811 — B.476 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- Baseline ID (v34): `B.476`
- File: `app/Services/WoodService.php`
- Evidence: `'efficiency' => $this->efficiency((float) $payload['input_qty'], (float) $payload['output_qty']),`

### A.812 — B.478 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- Baseline ID (v34): `B.478`
- File: `app/Services/WoodService.php`
- Evidence: `'qty' => (float) ($payload['qty'] ?? 0),`

### A.813 — A.342 — Medium — Finance/Precision — Money/amount cast to float (rounding drift risk)
- Baseline ID (v34): `A.342`
- File: `app/ValueObjects/Money.php`
- Evidence: `        return (float) $this->amount;`

### A.814 — A.341 — Medium — Finance/Precision — Money/amount cast to float (rounding drift risk)
- Baseline ID (v34): `A.341`
- File: `app/ValueObjects/Money.php`
- Evidence: `        return number_format((float) $this->amount, $decimals).' '.$this->currency;`

### A.815 — B.480 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- Baseline ID (v34): `B.480`
- File: `app/ValueObjects/Money.php`
- Evidence: `return (float) $this->amount;`

### A.816 — B.479 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- Baseline ID (v34): `B.479`
- File: `app/ValueObjects/Money.php`
- Evidence: `return number_format((float) $this->amount, $decimals).' '.$this->currency;`

### A.817 — B.481 — Medium — Security/XSS — Blade unescaped output ({!! !!})
- Baseline ID (v34): `B.481`
- File: `resources/views/components/form/input.blade.php`
- Evidence: `{!! sanitize_svg_icon($icon) !!}`

### A.818 — B.482 — Medium — Security/XSS — Blade unescaped output ({!! !!})
- Baseline ID (v34): `B.482`
- File: `resources/views/components/icon.blade.php`
- Evidence: `{!! sanitize_svg_icon($iconPath) !!}`

### A.819 — B.483 — Medium — Security/XSS — Blade unescaped output ({!! !!})
- Baseline ID (v34): `B.483`
- File: `resources/views/components/ui/button.blade.php`
- Evidence: `{!! sanitize_svg_icon($icon) !!}`

### A.820 — B.485 — Medium — Security/XSS — Blade unescaped output ({!! !!})
- Baseline ID (v34): `B.485`
- File: `resources/views/components/ui/card.blade.php`
- Evidence: `{!! $actions !!}`

### A.821 — B.484 — Medium — Security/XSS — Blade unescaped output ({!! !!})
- Baseline ID (v34): `B.484`
- File: `resources/views/components/ui/card.blade.php`
- Evidence: `{!! sanitize_svg_icon($icon) !!}`

### A.822 — B.486 — Medium — Security/XSS — Blade unescaped output ({!! !!})
- Baseline ID (v34): `B.486`
- File: `resources/views/components/ui/empty-state.blade.php`
- Evidence: `{!! sanitize_svg_icon($displayIcon) !!}`

### A.823 — B.488 — Medium — Security/XSS — Blade unescaped output ({!! !!})
- Baseline ID (v34): `B.488`
- File: `resources/views/components/ui/form/input.blade.php`
- Evidence: `@if($wireModel) {!! $wireDirective !!} @endif`

### A.824 — B.487 — Medium — Security/XSS — Blade unescaped output ({!! !!})
- Baseline ID (v34): `B.487`
- File: `resources/views/components/ui/form/input.blade.php`
- Evidence: `{!! sanitize_svg_icon($icon) !!}`

### A.825 — B.489 — Medium — Security/XSS — Blade unescaped output ({!! !!})
- Baseline ID (v34): `B.489`
- File: `resources/views/components/ui/page-header.blade.php`
- Evidence: `{!! sanitize_svg_icon($icon) !!}`

### A.826 — A.343 — Medium — Finance/Precision — Money/amount cast to float (rounding drift risk)
- Baseline ID (v34): `A.343`
- File: `resources/views/livewire/admin/dashboard.blade.php`
- Evidence: `            'data' => $salesSeries->pluck('total')->map(fn ($v) => (float) $v)->toArray(),`

### A.827 — B.490 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- Baseline ID (v34): `B.490`
- File: `resources/views/livewire/admin/dashboard.blade.php`
- Evidence: `'data' => $salesSeries->pluck('total')->map(fn ($v) => (float) $v)->toArray(),`

### A.828 — B.491 — Medium — Security/XSS — Blade unescaped output ({!! !!})
- Baseline ID (v34): `B.491`
- File: `resources/views/livewire/auth/two-factor-setup.blade.php`
- Evidence: `{!! $qrCodeSvg !!}`

### A.829 — B.492 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- Baseline ID (v34): `B.492`
- File: `resources/views/livewire/manufacturing/bills-of-materials/index.blade.php`
- Evidence: `<td>{{ number_format((float)$bom->quantity, 2) }}</td>`

### A.830 — B.493 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- Baseline ID (v34): `B.493`
- File: `resources/views/livewire/manufacturing/production-orders/index.blade.php`
- Evidence: `<td>{{ number_format((float)$order->quantity_planned, 2) }}</td>`

### A.831 — B.494 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- Baseline ID (v34): `B.494`
- File: `resources/views/livewire/manufacturing/production-orders/index.blade.php`
- Evidence: `<td>{{ number_format((float)$order->quantity_produced, 2) }}</td>`

### A.832 — B.495 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- Baseline ID (v34): `B.495`
- File: `resources/views/livewire/manufacturing/work-centers/index.blade.php`
- Evidence: `<td>{{ number_format((float)$workCenter->cost_per_hour, 2) }}</td>`

### A.833 — A.344 — Medium — Finance/Precision — Money/amount cast to float (rounding drift risk)
- Baseline ID (v34): `A.344`
- File: `resources/views/livewire/purchases/returns/index.blade.php`
- Evidence: `                                <td class="font-mono text-orange-600">{{ number_format((float)$return->total, 2) }}</td>`

### A.834 — A.345 — Medium — Finance/Precision — Money/amount cast to float (rounding drift risk)
- Baseline ID (v34): `A.345`
- File: `resources/views/livewire/purchases/returns/index.blade.php`
- Evidence: `                            <p class="text-sm"><strong>{{ __('Total') }}:</strong> {{ number_format((float)$selectedPurchase->grand_total, 2) }}</p>`

### A.835 — B.498 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- Baseline ID (v34): `B.498`
- File: `resources/views/livewire/purchases/returns/index.blade.php`
- Evidence: `<p class="text-sm"><strong>{{ __('Total') }}:</strong> {{ number_format((float)$selectedPurchase->grand_total, 2) }}</p>`

### A.836 — B.496 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- Baseline ID (v34): `B.496`
- File: `resources/views/livewire/purchases/returns/index.blade.php`
- Evidence: `<td class="font-mono text-orange-600">{{ number_format((float)$return->total, 2) }}</td>`

### A.837 — B.497 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- Baseline ID (v34): `B.497`
- File: `resources/views/livewire/purchases/returns/index.blade.php`
- Evidence: `{{ number_format((float)$purchase->grand_total, 2) }}`

### A.838 — A.346 — Medium — Finance/Precision — Money/amount cast to float (rounding drift risk)
- Baseline ID (v34): `A.346`
- File: `resources/views/livewire/sales/returns/index.blade.php`
- Evidence: `                                <td class="font-mono text-red-600">{{ number_format((float)$return->total, 2) }}</td>`

### A.839 — A.347 — Medium — Finance/Precision — Money/amount cast to float (rounding drift risk)
- Baseline ID (v34): `A.347`
- File: `resources/views/livewire/sales/returns/index.blade.php`
- Evidence: `                            <p class="text-sm"><strong>{{ __('Total') }}:</strong> {{ number_format((float)$selectedSale->grand_total, 2) }}</p>`

### A.840 — B.501 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- Baseline ID (v34): `B.501`
- File: `resources/views/livewire/sales/returns/index.blade.php`
- Evidence: `<p class="text-sm"><strong>{{ __('Total') }}:</strong> {{ number_format((float)$selectedSale->grand_total, 2) }}</p>`

### A.841 — B.499 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- Baseline ID (v34): `B.499`
- File: `resources/views/livewire/sales/returns/index.blade.php`
- Evidence: `<td class="font-mono text-red-600">{{ number_format((float)$return->total, 2) }}</td>`

### A.842 — B.500 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- Baseline ID (v34): `B.500`
- File: `resources/views/livewire/sales/returns/index.blade.php`
- Evidence: `{{ number_format((float)$sale->grand_total, 2) }}`

### A.843 — B.502 — Medium — Security/XSS — Blade unescaped output ({!! !!})
- Baseline ID (v34): `B.502`
- File: `resources/views/livewire/shared/dynamic-form.blade.php`
- Evidence: `<span class="text-slate-400">{!! sanitize_svg_icon($icon) !!}</span>`

### A.844 — B.503 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- Baseline ID (v34): `B.503`
- File: `resources/views/livewire/shared/dynamic-table.blade.php`
- Evidence: `<span class="font-medium">{{ $currency }}{{ number_format((float)$value, 2) }}</span>`

### A.845 — B.504 — Medium — Security/XSS — Blade unescaped output ({!! !!})
- Baseline ID (v34): `B.504`
- File: `resources/views/livewire/shared/dynamic-table.blade.php`
- Evidence: `{!! sanitize_svg_icon($actionIcon) !!}`

---

## B) New bugs detected in v35

### B.1 — High — Security/SQL — Raw SQL contains interpolated variable inside string
- File: `app/Http/Controllers/Branch/ReportsController.php`
- Line (v35): `54`
- Evidence: `->selectRaw("{$dateExpr} as first_inbound")`

### B.2 — High — Security/SQL — Raw SQL contains interpolated variable inside string
- File: `app/Services/Reports/SlowMovingStockService.php`
- Line (v35): `33`
- Evidence: `->selectRaw("{$daysDiffExpr} as days_since_sale")`

### B.3 — Medium — Finance/Precision — Potential financial precision bug (float usage)
- File: `app/Helpers/helpers.php`
- Line (v35): `107`
- Evidence: `$formatted = number_format((float) $normalized, $scale, '.', ',');`

### B.4 — Medium — Finance/Precision — Potential financial precision bug (float usage)
- File: `app/Helpers/helpers.php`
- Line (v35): `118`
- Evidence: `return number_format((float) $normalized, $decimals, '.', ',').'%';`

### B.5 — Medium — Finance/Precision — Potential financial precision bug (float usage)
- File: `app/Http/Controllers/Admin/ReportsController.php`
- Line (v35): `223`
- Evidence: `'gross_profit' => (float) $grossProfit,`

### B.6 — Medium — Finance/Precision — Potential financial precision bug (float usage)
- File: `app/Http/Controllers/Admin/ReportsController.php`
- Line (v35): `225`
- Evidence: `'net_profit' => (float) $netProfit,`

### B.7 — Medium — Finance/Precision — Potential financial precision bug (float usage)
- File: `app/Http/Controllers/Admin/ReportsController.php`
- Line (v35): `333`
- Evidence: `$agingFloat = array_map(fn ($v) => (float) $v, $aging);`

### B.8 — Medium — Finance/Precision — Potential financial precision bug (float usage)
- File: `app/Http/Controllers/Api/V1/POSController.php`
- Line (v35): `218`
- Evidence: `(float) $request->input('closing_cash'),`

### B.9 — Medium — Finance/Precision — Potential financial precision bug (float usage)
- File: `app/Http/Controllers/Branch/Rental/InvoiceController.php`
- Line (v35): `68`
- Evidence: `return $this->ok($this->rental->applyPenalty($invoice->id, (float) $data['penalty'], $branch->id), __('Penalty applied'));`

### B.10 — Medium — Finance/Precision — Potential financial precision bug (float usage)
- File: `app/Http/Resources/ProductResource.php`
- Line (v35): `50`
- Evidence: `'min_stock' => $this->min_stock ? (float) $this->min_stock : 0.0,`

### B.11 — Medium — Finance/Precision — Potential financial precision bug (float usage)
- File: `app/Http/Resources/ProductResource.php`
- Line (v35): `51`
- Evidence: `'max_stock' => $this->max_stock ? (float) $this->max_stock : null,`

### B.12 — Medium — Finance/Precision — Potential financial precision bug (float usage)
- File: `app/Http/Resources/ProductResource.php`
- Line (v35): `52`
- Evidence: `'reorder_point' => $this->reorder_point ? (float) $this->reorder_point : 0.0,`

### B.13 — Medium — Finance/Precision — Potential financial precision bug (float usage)
- File: `app/Http/Resources/ProductResource.php`
- Line (v35): `54`
- Evidence: `'lead_time_days' => $this->lead_time_days ? (float) $this->lead_time_days : null,`

### B.14 — Medium — Finance/Precision — Potential financial precision bug (float usage)
- File: `app/Jobs/ClosePosDayJob.php`
- Line (v35): `71`
- Evidence: `$gross = (float) $grossString;`

### B.15 — Medium — Finance/Precision — Potential financial precision bug (float usage)
- File: `app/Livewire/Admin/Settings/AdvancedSettings.php`
- Line (v35): `184`
- Evidence: `'late_penalty_percent' => (float) $this->settingsService->get('notifications.late_penalty_percent', 5),`

### B.16 — Medium — Finance/Precision — Potential financial precision bug (float usage)
- File: `app/Livewire/Admin/Store/OrdersDashboard.php`
- Line (v35): `121`
- Evidence: `return (float) $s['revenue'];`

### B.17 — Medium — Finance/Precision — Potential financial precision bug (float usage)
- File: `app/Livewire/Admin/UnitsOfMeasure/Form.php`
- Line (v35): `63`
- Evidence: `$this->conversionFactor = (float) $unit->conversion_factor;`

### B.18 — Medium — Finance/Precision — Potential financial precision bug (float usage)
- File: `app/Livewire/Hrm/Employees/Form.php`
- Line (v35): `178`
- Evidence: `$employee->salary = (float) $this->form['salary'];`

### B.19 — Medium — Finance/Precision — Potential financial precision bug (float usage)
- File: `app/Livewire/Hrm/Payroll/Run.php`
- Line (v35): `95`
- Evidence: `$model->basic = (float) $basic;`

### B.20 — Medium — Finance/Precision — Potential financial precision bug (float usage)
- File: `app/Livewire/Hrm/Payroll/Run.php`
- Line (v35): `96`
- Evidence: `$model->allowances = (float) $allowances;`

### B.21 — Medium — Finance/Precision — Potential financial precision bug (float usage)
- File: `app/Livewire/Hrm/Payroll/Run.php`
- Line (v35): `97`
- Evidence: `$model->deductions = (float) $deductions;`

### B.22 — Medium — Finance/Precision — Potential financial precision bug (float usage)
- File: `app/Livewire/Hrm/Payroll/Run.php`
- Line (v35): `98`
- Evidence: `$model->net = (float) $net;`

### B.23 — Medium — Finance/Precision — Potential financial precision bug (float usage)
- File: `app/Livewire/Inventory/ProductHistory.php`
- Line (v35): `114`
- Evidence: `$this->currentStock = (float) $currentStock;`

### B.24 — Medium — Finance/Precision — Potential financial precision bug (float usage)
- File: `app/Livewire/Inventory/Products/Form.php`
- Line (v35): `143`
- Evidence: `$this->form['max_stock'] = $p->max_stock ? (float) $p->max_stock : null;`

### B.25 — Medium — Finance/Precision — Potential financial precision bug (float usage)
- File: `app/Livewire/Inventory/Products/Form.php`
- Line (v35): `145`
- Evidence: `$this->form['lead_time_days'] = $p->lead_time_days ? (float) $p->lead_time_days : null;`

### B.26 — Medium — Finance/Precision — Potential financial precision bug (float usage)
- File: `app/Livewire/Manufacturing/BillsOfMaterials/Form.php`
- Line (v35): `72`
- Evidence: `$this->scrap_percentage = (float) $this->bom->scrap_percentage;`

### B.27 — Medium — Finance/Precision — Potential financial precision bug (float usage)
- File: `app/Livewire/Manufacturing/WorkCenters/Form.php`
- Line (v35): `77`
- Evidence: `$this->capacity_per_hour = $this->workCenter->capacity_per_hour ? (float) $this->workCenter->capacity_per_hour : null;`

### B.28 — Medium — Finance/Precision — Potential financial precision bug (float usage)
- File: `app/Livewire/Rental/Contracts/Form.php`
- Line (v35): `177`
- Evidence: `$this->form['rent'] = (float) $model->rent;`

### B.29 — Medium — Finance/Precision — Potential financial precision bug (float usage)
- File: `app/Livewire/Rental/Contracts/Form.php`
- Line (v35): `178`
- Evidence: `$this->form['deposit'] = (float) $model->deposit;`

### B.30 — Medium — Finance/Precision — Potential financial precision bug (float usage)
- File: `app/Livewire/Rental/Contracts/Form.php`
- Line (v35): `339`
- Evidence: `$contract->rent = (float) $this->form['rent'];`

### B.31 — Medium — Finance/Precision — Potential financial precision bug (float usage)
- File: `app/Livewire/Rental/Contracts/Form.php`
- Line (v35): `340`
- Evidence: `$contract->deposit = (float) $this->form['deposit'];`

### B.32 — Medium — Finance/Precision — Potential financial precision bug (float usage)
- File: `app/Livewire/Rental/Units/Form.php`
- Line (v35): `96`
- Evidence: `$this->form['rent'] = (float) $unitModel->rent;`

### B.33 — Medium — Finance/Precision — Potential financial precision bug (float usage)
- File: `app/Livewire/Rental/Units/Form.php`
- Line (v35): `97`
- Evidence: `$this->form['deposit'] = (float) $unitModel->deposit;`

### B.34 — Medium — Finance/Precision — Potential financial precision bug (float usage)
- File: `app/Livewire/Rental/Units/Form.php`
- Line (v35): `155`
- Evidence: `$unit->rent = (float) $this->form['rent'];`

### B.35 — Medium — Finance/Precision — Potential financial precision bug (float usage)
- File: `app/Livewire/Rental/Units/Form.php`
- Line (v35): `156`
- Evidence: `$unit->deposit = (float) $this->form['deposit'];`

### B.36 — Medium — Finance/Precision — Potential financial precision bug (float usage)
- File: `app/Livewire/Reports/SalesAnalytics.php`
- Line (v35): `229`
- Evidence: `'revenue' => $results->pluck('revenue')->map(fn ($v) => (float) $v)->toArray(),`

### B.37 — Medium — Finance/Precision — Potential financial precision bug (float usage)
- File: `app/Models/BomOperation.php`
- Line (v35): `58`
- Evidence: `return (float) $this->duration_minutes + (float) $this->setup_time_minutes;`

### B.38 — Medium — Finance/Precision — Potential financial precision bug (float usage)
- File: `app/Models/Project.php`
- Line (v35): `195`
- Evidence: `return (float) $this->budget;`

### B.39 — Medium — Finance/Precision — Potential financial precision bug (float usage)
- File: `app/Models/ProjectTask.php`
- Line (v35): `150`
- Evidence: `return (float) $this->timeLogs()->sum('hours');`

### B.40 — Medium — Finance/Precision — Potential financial precision bug (float usage)
- File: `app/Models/ProjectTask.php`
- Line (v35): `156`
- Evidence: `$estimated = (float) $this->estimated_hours;`

### B.41 — Medium — Finance/Precision — Potential financial precision bug (float usage)
- File: `app/Models/Sale.php`
- Line (v35): `205`
- Evidence: `return (float) $this->payments()`

### B.42 — Medium — Security/Auth — api_token used in request/query flow (leak risk)
- File: `app/Models/Traits/EnhancedAuditLogging.php`
- Line (v35): `111`
- Evidence: `'api_token',`

### B.43 — Medium — Finance/Precision — Potential financial precision bug (float usage)
- File: `app/Models/Transfer.php`
- Line (v35): `220`
- Evidence: `return (float) $this->items()`

### B.44 — Medium — Finance/Precision — Potential financial precision bug (float usage)
- File: `app/Models/UnitOfMeasure.php`
- Line (v35): `89`
- Evidence: `$targetFactor = (float) $targetUnit->conversion_factor;`

### B.45 — Medium — Finance/Precision — Potential financial precision bug (float usage)
- File: `app/Repositories/StockMovementRepository.php`
- Line (v35): `190`
- Evidence: `$currentStock = (float) StockMovement::where('product_id', $data['product_id'])`

### B.46 — Medium — Finance/Precision — Potential financial precision bug (float usage)
- File: `app/Services/AccountingService.php`
- Line (v35): `327`
- Evidence: `if (abs((float) $difference) >= 0.01) {`

### B.47 — Medium — Finance/Precision — Potential financial precision bug (float usage)
- File: `app/Services/AccountingService.php`
- Line (v35): `336`
- Evidence: `return abs((float) $difference) < 0.01;`

### B.48 — Medium — Finance/Precision — Potential financial precision bug (float usage)
- File: `app/Services/Analytics/SalesForecastingService.php`
- Line (v35): `83`
- Evidence: `'revenue' => (float) $row->revenue,`

### B.49 — Medium — Finance/Precision — Potential financial precision bug (float usage)
- File: `app/Services/DataValidationService.php`
- Line (v35): `129`
- Evidence: `$percentage = (float) $percentage;`

### B.50 — Medium — Finance/Precision — Potential financial precision bug (float usage)
- File: `app/Services/FinancialReportService.php`
- Line (v35): `73`
- Evidence: `'difference' => (float) $difference,`

### B.51 — Medium — Finance/Precision — Potential financial precision bug (float usage)
- File: `app/Services/FinancialReportService.php`
- Line (v35): `155`
- Evidence: `'net_income' => (float) $netIncome,`

### B.52 — Medium — Finance/Precision — Potential financial precision bug (float usage)
- File: `app/Services/HRMService.php`
- Line (v35): `109`
- Evidence: `$basic = (float) $emp->salary;`

### B.53 — Medium — Finance/Precision — Potential financial precision bug (float usage)
- File: `app/Services/HRMService.php`
- Line (v35): `167`
- Evidence: `return (float) bcround($insurance, 2);`

### B.54 — Medium — Finance/Precision — Potential financial precision bug (float usage)
- File: `app/Services/LeaveManagementService.php`
- Line (v35): `621`
- Evidence: `$daysToDeduct = (float) $leaveRequest->days_count;`

### B.55 — Medium — Finance/Precision — Potential financial precision bug (float usage)
- File: `app/Services/LoyaltyService.php`
- Line (v35): `37`
- Evidence: `$points = (int) floor((float) $pointsDecimal);`

### B.56 — Medium — Finance/Precision — Potential financial precision bug (float usage)
- File: `app/Services/PayslipService.php`
- Line (v35): `102`
- Evidence: `$mealAllowance = (float) setting('hrm.meal_allowance', 0);`

### B.57 — Medium — Finance/Precision — Potential financial precision bug (float usage)
- File: `app/Services/PayslipService.php`
- Line (v35): `106`
- Evidence: `$allowances['meal'] = (float) $mealAllowanceStr;`

### B.58 — Medium — Finance/Precision — Potential financial precision bug (float usage)
- File: `app/Services/PayslipService.php`
- Line (v35): `131`
- Evidence: `$deductions['social_insurance'] = (float) $socialInsurance;`

### B.59 — Medium — Finance/Precision — Potential financial precision bug (float usage)
- File: `app/Services/PayslipService.php`
- Line (v35): `161`
- Evidence: `$healthInsurance = (float) setting('hrm.health_insurance_deduction', 0);`

### B.60 — Medium — Finance/Precision — Potential financial precision bug (float usage)
- File: `app/Services/PayslipService.php`
- Line (v35): `165`
- Evidence: `$deductions['health_insurance'] = (float) $healthInsuranceStr;`

### B.61 — Medium — Finance/Precision — Potential financial precision bug (float usage)
- File: `app/Services/PayslipService.php`
- Line (v35): `227`
- Evidence: `'basic' => (float) bcround((string) $basic, 2),`

### B.62 — Medium — Finance/Precision — Potential financial precision bug (float usage)
- File: `app/Services/PayslipService.php`
- Line (v35): `228`
- Evidence: `'allowances' => (float) bcround((string) $allowances, 2),`

### B.63 — Medium — Finance/Precision — Potential financial precision bug (float usage)
- File: `app/Services/PayslipService.php`
- Line (v35): `230`
- Evidence: `'deductions' => (float) bcround((string) $deductions, 2),`

### B.64 — Medium — Finance/Precision — Potential financial precision bug (float usage)
- File: `app/Services/PayslipService.php`
- Line (v35): `232`
- Evidence: `'gross' => (float) bcround((string) $gross, 2),`

### B.65 — Medium — Finance/Precision — Potential financial precision bug (float usage)
- File: `app/Services/PayslipService.php`
- Line (v35): `233`
- Evidence: `'net' => (float) $net,`

### B.66 — Medium — Finance/Precision — Potential financial precision bug (float usage)
- File: `app/Services/PayslipService.php`
- Line (v35): `259`
- Evidence: `$currentSalary = (float) $employee->salary;`

### B.67 — Medium — Finance/Precision — Potential financial precision bug (float usage)
- File: `app/Services/PayslipService.php`
- Line (v35): `285`
- Evidence: `$salaryAtPeriodStart = (float) $salaryChanges[0]['old_salary'];`

### B.68 — Medium — Finance/Precision — Potential financial precision bug (float usage)
- File: `app/Services/PayslipService.php`
- Line (v35): `301`
- Evidence: `$newSalary = (float) $change['new_salary'];`

### B.69 — Medium — Finance/Precision — Potential financial precision bug (float usage)
- File: `app/Services/PayslipService.php`
- Line (v35): `328`
- Evidence: `return (float) bcround($proRataSalary, 2);`

### B.70 — Medium — Finance/Precision — Potential financial precision bug (float usage)
- File: `app/Services/PayslipService.php`
- Line (v35): `367`
- Evidence: `'old_salary' => (float) $old['basic_salary'],`

### B.71 — Medium — Finance/Precision — Potential financial precision bug (float usage)
- File: `app/Services/PayslipService.php`
- Line (v35): `368`
- Evidence: `'new_salary' => (float) $attributes['basic_salary'],`

### B.72 — Medium — Finance/Precision — Potential financial precision bug (float usage)
- File: `app/Services/QueryPerformanceService.php`
- Line (v35): `271`
- Evidence: `'innodb_flush_method' => 'O_DIRECT to avoid double buffering',`

### B.73 — Medium — Finance/Precision — Potential financial precision bug (float usage)
- File: `app/Services/RentalService.php`
- Line (v35): `133`
- Evidence: `'rent' => (float) $payload['rent'],`

### B.74 — Medium — Finance/Precision — Potential financial precision bug (float usage)
- File: `app/Services/RentalService.php`
- Line (v35): `154`
- Evidence: `$c->rent = (float) $payload['rent'];`

### B.75 — Medium — Finance/Precision — Potential financial precision bug (float usage)
- File: `app/Services/ReportService.php`
- Line (v35): `83`
- Evidence: `return $rows->map(fn ($r) => ['id' => $r->id, 'name' => $r->name, 'gross' => (float) $r->gross])->all();`

### B.76 — Medium — Finance/Precision — Potential financial precision bug (float usage)
- File: `app/Services/ReportService.php`
- Line (v35): `181`
- Evidence: `'total_value' => $items->sum(fn ($p) => ((float) ($p->stock_quantity ?? 0)) * ((float) ($p->cost ?? $p->standard_cost ?? 0))),`

### B.77 — Medium — Finance/Precision — Potential financial precision bug (float usage)
- File: `app/Services/ReportService.php`
- Line (v35): `182`
- Evidence: `'total_cost' => $items->sum(fn ($p) => (float) ($p->standard_cost ?? 0)),`

### B.78 — Medium — Finance/Precision — Potential financial precision bug (float usage)
- File: `app/Services/Reports/CashFlowForecastService.php`
- Line (v35): `39`
- Evidence: `'current_cash' => (float) $currentCash,`

### B.79 — Medium — Finance/Precision — Potential financial precision bug (float usage)
- File: `app/Services/Reports/CashFlowForecastService.php`
- Line (v35): `138`
- Evidence: `'inflows' => (float) $dailyInflowsStr,`

### B.80 — Medium — Finance/Precision — Potential financial precision bug (float usage)
- File: `app/Services/Reports/CashFlowForecastService.php`
- Line (v35): `139`
- Evidence: `'outflows' => (float) $dailyOutflowsStr,`

### B.81 — Medium — Finance/Precision — Potential financial precision bug (float usage)
- File: `app/Services/Reports/CashFlowForecastService.php`
- Line (v35): `140`
- Evidence: `'net_flow' => (float) $netFlow,`

### B.82 — Medium — Finance/Precision — Potential financial precision bug (float usage)
- File: `app/Services/Reports/CustomerSegmentationService.php`
- Line (v35): `179`
- Evidence: `'revenue_at_risk' => (float) $at_risk->sum('lifetime_revenue'),`

### B.83 — Medium — Finance/Precision — Potential financial precision bug (float usage)
- File: `app/Services/Reports/SlowMovingStockService.php`
- Line (v35): `102`
- Evidence: `'potential_loss' => (float) $potentialLoss,`

### B.84 — Medium — Finance/Precision — Potential financial precision bug (float usage)
- File: `app/Services/SalesReturnService.php`
- Line (v35): `92`
- Evidence: `$qtyToReturn = (float) ($itemData['qty'] ?? 0);`

### B.85 — Medium — Finance/Precision — Potential financial precision bug (float usage)
- File: `app/Services/StockReorderService.php`
- Line (v35): `111`
- Evidence: `return $product->reorder_point ? ((float) $product->reorder_point * 2) : 50;`

### B.86 — Medium — Finance/Precision — Potential financial precision bug (float usage)
- File: `app/Services/StockReorderService.php`
- Line (v35): `168`
- Evidence: `'sales_velocity' => (float) bcround((string) $salesVelocity, 2),`

### B.87 — Medium — Finance/Precision — Potential financial precision bug (float usage)
- File: `app/Services/StockService.php`
- Line (v35): `137`
- Evidence: `return (float) DB::table('stock_movements')`

### B.88 — Medium — Finance/Precision — Potential financial precision bug (float usage)
- File: `app/Services/StockService.php`
- Line (v35): `278`
- Evidence: `$stockBefore = (float) DB::table('stock_movements')`

### B.89 — Medium — Finance/Precision — Potential financial precision bug (float usage)
- File: `app/Services/UX/SmartSuggestionsService.php`
- Line (v35): `69`
- Evidence: `$urgency = $this->determineReorderUrgency((float) $currentStock, (float) $reorderPoint, (float) $product->min_stock ?? 0);`

### B.90 — Medium — Finance/Precision — Potential financial precision bug (float usage)
- File: `app/Services/UX/SmartSuggestionsService.php`
- Line (v35): `76`
- Evidence: `'reorder_point' => (float) $reorderPoint,`

### B.91 — Medium — Finance/Precision — Potential financial precision bug (float usage)
- File: `app/Services/UX/SmartSuggestionsService.php`
- Line (v35): `78`
- Evidence: `'sales_velocity' => (float) $salesVelocity,`

### B.92 — Medium — Finance/Precision — Potential financial precision bug (float usage)
- File: `app/Services/UX/SmartSuggestionsService.php`
- Line (v35): `79`
- Evidence: `'days_of_stock_remaining' => (float) $daysOfStock,`

### B.93 — Medium — Finance/Precision — Potential financial precision bug (float usage)
- File: `app/Services/UX/SmartSuggestionsService.php`
- Line (v35): `141`
- Evidence: `'current_margin' => (float) $currentMargin.'%',`

### B.94 — Medium — Finance/Precision — Potential financial precision bug (float usage)
- File: `app/Services/UX/SmartSuggestionsService.php`
- Line (v35): `203`
- Evidence: `'customer_savings' => (float) $savings,`

### B.95 — Medium — Finance/Precision — Potential financial precision bug (float usage)
- File: `app/Services/UX/SmartSuggestionsService.php`
- Line (v35): `246`
- Evidence: `'margin' => (float) $margin,`

### B.96 — Medium — Finance/Precision — Potential financial precision bug (float usage)
- File: `app/Services/WoodService.php`
- Line (v35): `105`
- Evidence: `return (float) bcround($percentage, 2);`

### B.97 — Medium — Finance/Precision — Potential financial precision bug (float usage)
- File: `resources/views/livewire/accounting/journal-entries/form.blade.php`
- Line (v35): `8`
- Evidence: `{{ __('Create double-entry journal entries') }}`

### B.98 — Medium — Finance/Precision — Potential financial precision bug (float usage)
- File: `resources/views/livewire/hrm/employees/index.blade.php`
- Line (v35): `198`
- Evidence: `{{ number_format((float) $employee->salary, 2) }}`

### B.99 — Medium — Finance/Precision — Potential financial precision bug (float usage)
- File: `resources/views/livewire/hrm/payroll/index.blade.php`
- Line (v35): `86`
- Evidence: `{{ number_format((float) $row->basic, 2) }}`

### B.100 — Medium — Finance/Precision — Potential financial precision bug (float usage)
- File: `resources/views/livewire/hrm/payroll/index.blade.php`
- Line (v35): `89`
- Evidence: `{{ number_format((float) $row->allowances, 2) }}`

### B.101 — Medium — Finance/Precision — Potential financial precision bug (float usage)
- File: `resources/views/livewire/hrm/payroll/index.blade.php`
- Line (v35): `92`
- Evidence: `{{ number_format((float) $row->deductions, 2) }}`

### B.102 — Medium — Finance/Precision — Potential financial precision bug (float usage)
- File: `resources/views/livewire/hrm/payroll/index.blade.php`
- Line (v35): `95`
- Evidence: `{{ number_format((float) $row->net, 2) }}`

### B.103 — Medium — Finance/Precision — Potential financial precision bug (float usage)
- File: `resources/views/livewire/manufacturing/work-centers/index.blade.php`
- Line (v35): `147`
- Evidence: `<td>{{ number_format((float)$workCenter->capacity_per_hour, 2) }}</td>`

### B.104 — Medium — Finance/Precision — Potential financial precision bug (float usage)
- File: `resources/views/livewire/rental/contracts/index.blade.php`
- Line (v35): `96`
- Evidence: `{{ number_format((float) $row->rent, 2) }}`

### B.105 — Medium — Finance/Precision — Potential financial precision bug (float usage)
- File: `resources/views/livewire/rental/units/index.blade.php`
- Line (v35): `84`
- Evidence: `{{ number_format((float) $unit->rent, 2) }}`

### B.106 — Medium — Finance/Precision — Potential financial precision bug (float usage)
- File: `resources/views/livewire/rental/units/index.blade.php`
- Line (v35): `87`
- Evidence: `{{ number_format((float) $unit->deposit, 2) }}`

---

### Notes
- Baseline is taken from **v34 MD report** and checked by **evidence-snippet presence** in v35.
- New bugs are detected via **pattern scan** and may require manual review for exploitability/business impact.
- DB/seeders are excluded per request.
