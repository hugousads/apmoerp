# apmoerp v34 — Bug Delta Report (Old Unsolved + New)

This report includes **only**: (1) bugs from the **v33 report** that are **still present** in v34, and (2) **new** bugs found in v34.

## Summary
- Baseline bugs (from v33 report): **349**
- Old bugs fixed in v34: **2**
- Old bugs still not solved: **347**
- New bugs found in v34: **504**

### Old bugs still not solved — by severity
- High: 64
- Medium: 283

### New bugs — by severity
- High: 17
- Medium: 487

### Dependency check
- laravel/framework: `^12.0`
- livewire/livewire: `^4.0.1`

---

## A) Old bugs NOT solved yet (still present in v34)

### A.1 — High — Security/SQL — Raw SQL with variable interpolation
- Baseline ID (v33): `A.1`
- Baseline ID (v32): `A.5`
- File: `app/Console/Commands/CheckDatabaseIntegrity.php`
- Line (v34): `232`
- Evidence: `            ->select($column, DB::raw('COUNT(*) as count'))`

### A.2 — High — Security/SQL — Raw SQL with variable interpolation
- Baseline ID (v33): `A.2`
- Baseline ID (v32): `A.6`
- File: `app/Console/Commands/CheckDatabaseIntegrity.php`
- Line (v34): `237`
- Evidence: `            $query->whereRaw($where);`

### A.3 — High — Security/SQL — Raw SQL with variable interpolation
- Baseline ID (v33): `A.3`
- Baseline ID (v32): `A.7`
- File: `app/Console/Commands/CheckDatabaseIntegrity.php`
- Line (v34): `348`
- Evidence: `                DB::statement($fix);`

### A.4 — High — Security/SQL — Raw SQL with variable interpolation
- Baseline ID (v33): `A.4`
- Baseline ID (v32): `A.8`
- File: `app/Http/Controllers/Admin/ReportsController.php`
- Line (v34): `126`
- Evidence: `        $data = $query->selectRaw('`

### A.5 — High — Security/SQL — Raw SQL with variable interpolation
- Baseline ID (v33): `A.5`
- Baseline ID (v32): `A.9`
- File: `app/Http/Controllers/Api/StoreIntegrationController.php`
- Line (v34): `75`
- Evidence: `            ->selectRaw($stockExpr.' as current_stock');`

### A.6 — High — Security/SQL — Raw SQL with variable interpolation
- Baseline ID (v33): `A.7`
- Baseline ID (v32): `A.11`
- File: `app/Http/Controllers/Api/V1/InventoryController.php`
- Line (v34): `71`
- Evidence: `            $query->havingRaw('current_quantity <= products.min_stock');`

### A.7 — High — Security/SQL — Raw SQL with variable interpolation
- Baseline ID (v33): `A.8`
- Baseline ID (v32): `A.12`
- File: `app/Http/Controllers/Api/V1/InventoryController.php`
- Line (v34): `332`
- Evidence: `        return (float) ($query->selectRaw('SUM(quantity) as balance')`

### A.8 — High — Security/SQL — Raw SQL with variable interpolation
- Baseline ID (v33): `A.9`
- Baseline ID (v32): `A.14`
- File: `app/Livewire/Admin/Branch/Reports.php`
- Line (v34): `86`
- Evidence: `            'due_amount' => (clone $query)->selectRaw('SUM(total_amount - paid_amount) as due')->value('due') ?? 0,`

### A.9 — High — Security/SQL — Raw SQL with variable interpolation
- Baseline ID (v33): `A.10`
- Baseline ID (v32): `A.15`
- File: `app/Livewire/Admin/Branch/Reports.php`
- Line (v34): `99`
- Evidence: `            'total_value' => (clone $query)->sum(DB::raw('COALESCE(default_price, 0) * COALESCE(stock_quantity, 0)')),`

### A.10 — High — Security/SQL — Raw SQL with variable interpolation
- Baseline ID (v33): `A.11`
- Baseline ID (v32): `A.16`
- File: `app/Livewire/Concerns/LoadsDashboardData.php`
- Line (v34): `147`
- Evidence: `            ->whereRaw("{$stockExpr} <= min_stock")`

### A.11 — High — Security/SQL — Raw SQL with variable interpolation
- Baseline ID (v33): `A.12`
- Baseline ID (v32): `A.17`
- File: `app/Livewire/Concerns/LoadsDashboardData.php`
- Line (v34): `285`
- Evidence: `                ->selectRaw("{$stockExpr} as current_quantity")`

### A.12 — High — Security/SQL — Raw SQL with variable interpolation
- Baseline ID (v33): `A.13`
- Baseline ID (v32): `A.18`
- File: `app/Livewire/Concerns/LoadsDashboardData.php`
- Line (v34): `287`
- Evidence: `                ->whereRaw("{$stockExpr} <= products.min_stock")`

### A.13 — High — Security/SQL — Raw SQL with variable interpolation
- Baseline ID (v33): `A.14`
- Baseline ID (v32): `A.19`
- File: `app/Livewire/Concerns/LoadsDashboardData.php`
- Line (v34): `290`
- Evidence: `                ->orderByRaw($stockExpr)`

### A.14 — High — Security/SQL — Raw SQL with variable interpolation
- Baseline ID (v33): `A.15`
- Baseline ID (v32): `A.20`
- File: `app/Livewire/Dashboard/CustomizableDashboard.php`
- Line (v34): `249`
- Evidence: `            $totalValue = (clone $productsQuery)->sum(\Illuminate\Support\Facades\DB::raw('COALESCE(default_price, 0) * COALESCE(stock_quantity, 0)'));`

### A.15 — High — Security/SQL — Raw SQL with variable interpolation
- Baseline ID (v33): `A.16`
- Baseline ID (v32): `A.21`
- File: `app/Livewire/Helpdesk/Dashboard.php`
- Line (v34): `76`
- Evidence: `        $ticketsByPriority = Ticket::select('priority_id', DB::raw('count(*) as count'))`

### A.16 — High — Security/SQL — Raw SQL with variable interpolation
- Baseline ID (v33): `A.17`
- Baseline ID (v32): `A.22`
- File: `app/Livewire/Inventory/StockAlerts.php`
- Line (v34): `61`
- Evidence: `            $query->whereRaw('COALESCE(stock_calc.total_stock, 0) <= products.min_stock AND COALESCE(stock_calc.total_stock, 0) > 0');`

### A.17 — High — Security/SQL — Raw SQL with variable interpolation
- Baseline ID (v33): `A.18`
- Baseline ID (v32): `A.23`
- File: `app/Livewire/Inventory/StockAlerts.php`
- Line (v34): `63`
- Evidence: `            $query->whereRaw('COALESCE(stock_calc.total_stock, 0) <= 0');`

### A.18 — High — Security/SQL — Raw SQL with variable interpolation
- Baseline ID (v33): `A.19`
- Baseline ID (v32): `A.24`
- File: `app/Livewire/Reports/SalesAnalytics.php`
- Line (v34): `204`
- Evidence: `            ->selectRaw("{$dateFormat} as period")`

### A.19 — High — Security/SQL — Raw SQL with variable interpolation
- Baseline ID (v33): `A.20`
- Baseline ID (v32): `A.25`
- File: `app/Livewire/Reports/SalesAnalytics.php`
- Line (v34): `328`
- Evidence: `            ->selectRaw("{$hourExpr} as hour")`

### A.20 — High — Security/SQL — Raw SQL with variable interpolation
- Baseline ID (v33): `A.21`
- Baseline ID (v32): `A.26`
- File: `app/Livewire/Warehouse/Index.php`
- Line (v34): `99`
- Evidence: `            $totalValue = (clone $stockMovementQuery)->selectRaw('SUM(quantity * COALESCE(unit_cost, 0)) as value')->value('value') ?? 0;`

### A.21 — High — Security/SQL — Raw SQL with variable interpolation
- Baseline ID (v33): `A.22`
- Baseline ID (v32): `A.27`
- File: `app/Livewire/Warehouse/Movements/Index.php`
- Line (v34): `90`
- Evidence: `            'total_value' => (clone $baseQuery)->selectRaw('SUM(quantity * COALESCE(unit_cost, 0)) as value')->value('value') ?? 0,`

### A.22 — High — Security/SQL — Raw SQL with variable interpolation
- Baseline ID (v33): `A.23`
- Baseline ID (v32): `A.28`
- File: `app/Models/Product.php`
- Line (v34): `283`
- Evidence: `            ->whereRaw("({$stockSubquery}) <= stock_alert_threshold");`

### A.23 — High — Security/SQL — Raw SQL with variable interpolation
- Baseline ID (v33): `A.24`
- Baseline ID (v32): `A.29`
- File: `app/Models/Product.php`
- Line (v34): `299`
- Evidence: `        return $query->whereRaw("({$stockSubquery}) <= 0");`

### A.24 — High — Security/SQL — Raw SQL with variable interpolation
- Baseline ID (v33): `A.25`
- Baseline ID (v32): `A.30`
- File: `app/Models/Product.php`
- Line (v34): `315`
- Evidence: `        return $query->whereRaw("({$stockSubquery}) > 0");`

### A.25 — High — Security/SQL — Raw SQL with variable interpolation
- Baseline ID (v33): `A.26`
- Baseline ID (v32): `A.31`
- File: `app/Models/Project.php`
- Line (v34): `170`
- Evidence: `        return $query->whereRaw('actual_cost > budget');`

### A.26 — High — Security/SQL — Raw SQL with variable interpolation
- Baseline ID (v33): `A.27`
- Baseline ID (v32): `A.32`
- File: `app/Models/SearchIndex.php`
- Line (v34): `76`
- Evidence: `            $builder->whereRaw(`

### A.27 — High — Security/SQL — Raw SQL with variable interpolation
- Baseline ID (v33): `A.28`
- Baseline ID (v32): `A.33`
- File: `app/Models/SearchIndex.php`
- Line (v34): `85`
- Evidence: `                $q->whereRaw('LOWER(title) LIKE ?', [$searchTerm])`

### A.28 — High — Security/SQL — Raw SQL with variable interpolation
- Baseline ID (v33): `A.29`
- Baseline ID (v32): `A.34`
- File: `app/Services/Analytics/InventoryTurnoverService.php`
- Line (v34): `38`
- Evidence: `        $cogs = $cogsQuery->sum(DB::raw('sale_items.quantity * COALESCE(products.cost, 0)'));`

### A.29 — High — Security/SQL — Raw SQL with variable interpolation
- Baseline ID (v33): `A.30`
- Baseline ID (v32): `A.35`
- File: `app/Services/Analytics/InventoryTurnoverService.php`
- Line (v34): `48`
- Evidence: `        $avgInventoryValue = $inventoryQuery->sum(DB::raw('COALESCE(stock_quantity, 0) * COALESCE(cost, 0)'));`

### A.30 — High — Security/SQL — Raw SQL with variable interpolation
- Baseline ID (v33): `A.31`
- Baseline ID (v32): `A.36`
- File: `app/Services/Analytics/ProfitMarginAnalysisService.php`
- Line (v34): `145`
- Evidence: `                DB::raw("DATE_FORMAT(sales.created_at, '{$dateFormat}') as period"),`

### A.31 — High — Security/SQL — Raw SQL with variable interpolation
- Baseline ID (v33): `A.32`
- Baseline ID (v32): `A.37`
- File: `app/Services/Analytics/ProfitMarginAnalysisService.php`
- Line (v34): `152`
- Evidence: `            ->groupBy(DB::raw("DATE_FORMAT(sales.created_at, '{$dateFormat}')"))`

### A.32 — High — Security/SQL — Raw SQL with variable interpolation
- Baseline ID (v33): `A.33`
- Baseline ID (v32): `A.38`
- File: `app/Services/Analytics/SalesForecastingService.php`
- Line (v34): `66`
- Evidence: `                DB::raw("DATE_FORMAT(created_at, '{$dateFormat}') as period"),`

### A.33 — High — Security/SQL — Raw SQL with variable interpolation
- Baseline ID (v33): `A.34`
- Baseline ID (v32): `A.39`
- File: `app/Services/Analytics/SalesForecastingService.php`
- Line (v34): `73`
- Evidence: `            ->groupBy(DB::raw("DATE_FORMAT(created_at, '{$dateFormat}')"))`

### A.34 — High — Security/SQL — Raw SQL with variable interpolation
- Baseline ID (v33): `A.35`
- Baseline ID (v32): `A.40`
- File: `app/Services/AutomatedAlertService.php`
- Line (v34): `220`
- Evidence: `            ->whereRaw("({$stockSubquery}) > 0")`

### A.35 — High — Security/SQL — Raw SQL with variable interpolation
- Baseline ID (v33): `A.36`
- Baseline ID (v32): `A.41`
- File: `app/Services/Performance/QueryOptimizationService.php`
- Line (v34): `179`
- Evidence: `            DB::statement($optimizeStatement);`

### A.36 — High — Security/SQL — Raw SQL with variable interpolation
- Baseline ID (v33): `A.37`
- Baseline ID (v32): `A.42`
- File: `app/Services/PurchaseReturnService.php`
- Line (v34): `459`
- Evidence: `        return $query->select('condition', DB::raw('COUNT(*) as count'), DB::raw('SUM(qty_returned) as total_qty'))`

### A.37 — High — Security/SQL — Raw SQL with variable interpolation
- Baseline ID (v33): `A.38`
- Baseline ID (v32): `B.1`
- File: `app/Services/QueryPerformanceService.php`
- Line (v34): `216`
- Evidence: `            $explain = DB::select('EXPLAIN FORMAT=JSON '.$sql);`

### A.38 — High — Security/SQL — Raw SQL with variable interpolation
- Baseline ID (v33): `A.39`
- Baseline ID (v32): `A.43`
- File: `app/Services/RentalService.php`
- Line (v34): `376`
- Evidence: `        $stats = $query->selectRaw('`

### A.39 — High — Security/SQL — Raw SQL with variable interpolation
- Baseline ID (v33): `A.40`
- Baseline ID (v32): `A.44`
- File: `app/Services/Reports/CustomerSegmentationService.php`
- Line (v34): `27`
- Evidence: `            ->selectRaw("{$datediffExpr} as recency_days")`

### A.40 — High — Security/SQL — Raw SQL with variable interpolation
- Baseline ID (v33): `A.41`
- Baseline ID (v32): `A.45`
- File: `app/Services/Reports/CustomerSegmentationService.php`
- Line (v34): `158`
- Evidence: `            ->selectRaw("{$datediffExpr} as days_since_purchase")`

### A.41 — High — Security/SQL — Raw SQL with variable interpolation
- Baseline ID (v33): `A.42`
- Baseline ID (v32): `A.46`
- File: `app/Services/Reports/SlowMovingStockService.php`
- Line (v34): `44`
- Evidence: `            ->havingRaw('COALESCE(days_since_sale, 999) > ?', [$days])`

### A.42 — High — Security/SQL — Raw SQL with variable interpolation
- Baseline ID (v33): `A.43`
- Baseline ID (v32): `A.47`
- File: `app/Services/ScheduledReportService.php`
- Line (v34): `77`
- Evidence: `                    DB::raw("{$dateExpr} as date"),`

### A.43 — High — Security/SQL — Raw SQL with variable interpolation
- Baseline ID (v33): `A.44`
- Baseline ID (v32): `A.48`
- File: `app/Services/ScheduledReportService.php`
- Line (v34): `95`
- Evidence: `            return $query->groupBy(DB::raw($dateExpr))`

### A.44 — High — Security/SQL — Raw SQL with variable interpolation
- Baseline ID (v33): `A.45`
- Baseline ID (v32): `A.49`
- File: `app/Services/ScheduledReportService.php`
- Line (v34): `127`
- Evidence: `                $query->whereRaw("({$stockSubquery}) <= COALESCE(products.reorder_point, 0)");`

### A.45 — High — Security/SQL — Raw SQL with variable interpolation
- Baseline ID (v33): `A.46`
- Baseline ID (v32): `A.50`
- File: `app/Services/ScheduledReportService.php`
- Line (v34): `231`
- Evidence: `                $query->selectRaw('COALESCE((SELECT SUM(quantity) FROM stock_movements sm INNER JOIN warehouses w ON sm.warehouse_id = w.id WHERE sm.product_id = products.id AND w.branch_id = ?), 0) as quantity', [$branchId]);`

### A.46 — High — Security/SQL — Raw SQL with variable interpolation
- Baseline ID (v33): `A.47`
- Baseline ID (v32): `A.51`
- File: `app/Services/ScheduledReportService.php`
- Line (v34): `236`
- Evidence: `                $query->selectRaw('COALESCE((SELECT SUM(quantity) FROM stock_movements sm INNER JOIN warehouses w ON sm.warehouse_id = w.id WHERE sm.product_id = products.id AND w.branch_id = products.branch_id), 0) as quantity');`

### A.47 — High — Security/SQL — Raw SQL with variable interpolation
- Baseline ID (v33): `A.48`
- Baseline ID (v32): `A.52`
- File: `app/Services/SmartNotificationsService.php`
- Line (v34): `42`
- Evidence: `                ->selectRaw("{$stockExpr} as current_quantity")`

### A.48 — High — Security/SQL — Raw SQL with variable interpolation
- Baseline ID (v33): `A.49`
- Baseline ID (v32): `A.53`
- File: `app/Services/SmartNotificationsService.php`
- Line (v34): `43`
- Evidence: `                ->whereRaw("{$stockExpr} <= products.min_stock")`

### A.49 — High — Security/SQL — Raw SQL with variable interpolation
- Baseline ID (v33): `A.50`
- Baseline ID (v32): `A.54`
- File: `app/Services/StockReorderService.php`
- Line (v34): `40`
- Evidence: `            ->whereRaw("({$stockSubquery}) <= reorder_point")`

### A.50 — High — Security/SQL — Raw SQL with variable interpolation
- Baseline ID (v33): `A.51`
- Baseline ID (v32): `A.55`
- File: `app/Services/StockReorderService.php`
- Line (v34): `65`
- Evidence: `            ->whereRaw("({$stockSubquery}) <= stock_alert_threshold")`

### A.51 — High — Security/SQL — Raw SQL with variable interpolation
- Baseline ID (v33): `A.52`
- Baseline ID (v32): `A.56`
- File: `app/Services/StockReorderService.php`
- Line (v34): `66`
- Evidence: `            ->whereRaw("({$stockSubquery}) > COALESCE(reorder_point, 0)")`

### A.52 — High — Security/SQL — Raw SQL with variable interpolation
- Baseline ID (v33): `A.53`
- Baseline ID (v32): `A.57`
- File: `app/Services/StockService.php`
- Line (v34): `31`
- Evidence: `        return (float) $query->selectRaw('COALESCE(SUM(quantity), 0) as stock')`

### A.53 — High — Security/SQL — Raw SQL with variable interpolation
- Baseline ID (v33): `A.54`
- Baseline ID (v32): `A.58`
- File: `app/Services/StockService.php`
- Line (v34): `101`
- Evidence: `        return (float) ($query->selectRaw('SUM(quantity * COALESCE(unit_cost, 0)) as value')`

### A.54 — High — Security/SQL — Raw SQL with variable interpolation
- Baseline ID (v33): `A.55`
- Baseline ID (v32): `A.59`
- File: `app/Services/WorkflowAutomationService.php`
- Line (v34): `27`
- Evidence: `            ->whereRaw("({$stockSubquery}) <= COALESCE(reorder_point, min_stock, 0)")`

### A.55 — High — Security/SQL — Raw SQL with variable interpolation
- Baseline ID (v33): `A.56`
- Baseline ID (v32): `A.60`
- File: `app/Services/WorkflowAutomationService.php`
- Line (v34): `169`
- Evidence: `            ->selectRaw("*, ({$stockSubquery}) as calculated_stock")`

### A.56 — High — Security/SQL — Raw SQL with variable interpolation
- Baseline ID (v33): `A.57`
- Baseline ID (v32): `A.61`
- File: `app/Services/WorkflowAutomationService.php`
- Line (v34): `170`
- Evidence: `            ->orderByRaw("(COALESCE(reorder_point, min_stock, 0) - ({$stockSubquery})) DESC")`

### A.57 — High — Security/XSS — Unescaped Blade output (XSS risk)
- Baseline ID (v33): `A.58`
- Baseline ID (v32): `B.4`
- File: `resources/views/components/icon.blade.php`
- Line (v34): `37`
- Evidence: `    {!! sanitize_svg_icon($iconPath) !!}`

### A.58 — High — Security/XSS — Unescaped Blade output (XSS risk)
- Baseline ID (v33): `A.59`
- Baseline ID (v32): `B.10`
- File: `resources/views/components/ui/card.blade.php`
- Line (v34): `39`
- Evidence: `            {!! $actions !!}`

### A.59 — High — Security/XSS — Unescaped Blade output (XSS risk)
- Baseline ID (v33): `A.60`
- Baseline ID (v32): `B.14`
- File: `resources/views/components/ui/form/input.blade.php`
- Line (v34): `61`
- Evidence: `            @if($wireModel) {!! $wireDirective !!} @endif`

### A.60 — High — Security/SQL — Raw SQL with variable interpolation
- Baseline ID (v33): `A.61`
- Baseline ID (v32): `A.62`
- File: `resources/views/livewire/admin/dashboard.blade.php`
- Line (v34): `42`
- Evidence: `            ? $saleModel::selectRaw('DATE(created_at) as day, SUM(total_amount) as total')`

### A.61 — High — Security/SQL — Raw SQL with variable interpolation
- Baseline ID (v33): `A.62`
- Baseline ID (v32): `A.63`
- File: `resources/views/livewire/admin/dashboard.blade.php`
- Line (v34): `55`
- Evidence: `            ? $contractModel::selectRaw('status, COUNT(*) as total')`

### A.62 — High — Security/XSS — Unescaped Blade output (XSS risk)
- Baseline ID (v33): `A.63`
- Baseline ID (v32): `B.17`
- File: `resources/views/livewire/auth/two-factor-setup.blade.php`
- Line (v34): `54`
- Evidence: `                        {!! $qrCodeSvg !!}`

### A.63 — High — Security/XSS — Unescaped Blade output (XSS risk)
- Baseline ID (v33): `A.64`
- Baseline ID (v32): `B.18`
- File: `resources/views/livewire/shared/dynamic-form.blade.php`
- Line (v34): `39`
- Evidence: `                                <span class="text-slate-400">{!! sanitize_svg_icon($icon) !!}</span>`

### A.64 — High — Security/XSS — Unescaped Blade output (XSS risk)
- Baseline ID (v33): `A.65`
- Baseline ID (v32): `B.19`
- File: `resources/views/livewire/shared/dynamic-table.blade.php`
- Line (v34): `260`
- Evidence: `                                                        {!! sanitize_svg_icon($actionIcon) !!}`

### A.65 — Medium — Finance/Precision — Float cast for totals
- Baseline ID (v33): `B.1`
- File: `app/Http/Controllers/Admin/Reports/InventoryReportsExportController.php`
- Line (v34): `83`
- Evidence: `            $stock = (float) ($stockData[$product->id] ?? 0);`

### A.66 — Medium — Finance/Precision — Money/amount cast to float (rounding drift risk)
- Baseline ID (v33): `A.67`
- Baseline ID (v32): `B.20`
- File: `app/Http/Controllers/Admin/ReportsController.php`
- Line (v34): `249`
- Evidence: `        $inflows = (float) (clone $query)->where('type', 'deposit')->sum('amount');`

### A.67 — Medium — Finance/Precision — Money/amount cast to float (rounding drift risk)
- Baseline ID (v33): `A.68`
- Baseline ID (v32): `B.21`
- File: `app/Http/Controllers/Admin/ReportsController.php`
- Line (v34): `252`
- Evidence: `        $outflows = (float) (clone $query)->where('type', 'withdrawal')->sum('amount');`

### A.68 — Medium — Finance/Precision — Float cast for totals
- Baseline ID (v33): `B.2`
- File: `app/Http/Controllers/Api/StoreIntegrationController.php`
- Line (v34): `92`
- Evidence: `                    'current_stock' => (float) ($product->current_stock ?? 0),`

### A.69 — Medium — Finance/Precision — Money/amount cast to float (rounding drift risk)
- Baseline ID (v33): `A.69`
- Baseline ID (v32): `B.22`
- File: `app/Http/Controllers/Api/V1/OrdersController.php`
- Line (v34): `205`
- Evidence: `                    $lineSubtotal = (float) $item['price'] * (float) $item['quantity'];`

### A.70 — Medium — Finance/Precision — Money/amount cast to float (rounding drift risk)
- Baseline ID (v33): `A.70`
- Baseline ID (v32): `B.23`
- File: `app/Http/Controllers/Api/V1/OrdersController.php`
- Line (v34): `206`
- Evidence: `                    $lineDiscount = max(0, (float) ($item['discount'] ?? 0));`

### A.71 — Medium — Finance/Precision — Money/amount cast to float (rounding drift risk)
- Baseline ID (v33): `A.71`
- Baseline ID (v32): `B.24`
- File: `app/Http/Controllers/Api/V1/OrdersController.php`
- Line (v34): `223`
- Evidence: `                $orderDiscount = max(0, (float) ($validated['discount'] ?? 0));`

### A.72 — Medium — Finance/Precision — Money/amount cast to float (rounding drift risk)
- Baseline ID (v33): `A.72`
- Baseline ID (v32): `B.25`
- File: `app/Http/Controllers/Api/V1/OrdersController.php`
- Line (v34): `225`
- Evidence: `                $tax = max(0, (float) ($validated['tax'] ?? 0));`

### A.73 — Medium — Finance/Precision — Float cast for totals
- Baseline ID (v33): `B.3`
- File: `app/Http/Controllers/Api/V1/OrdersController.php`
- Line (v34): `226`
- Evidence: `                $shipping = max(0, (float) ($validated['shipping'] ?? 0));`

### A.74 — Medium — Finance/Precision — Float cast for totals
- Baseline ID (v33): `B.4`
- File: `app/Http/Controllers/Api/V1/POSController.php`
- Line (v34): `181`
- Evidence: `                (float) ($request->input('opening_cash') ?? 0)`

### A.75 — Medium — Finance/Precision — Money/amount cast to float (rounding drift risk)
- Baseline ID (v33): `A.73`
- Baseline ID (v32): `B.26`
- File: `app/Http/Controllers/Api/V1/ProductsController.php`
- Line (v34): `77`
- Evidence: `                'price' => (float) $product->default_price,`

### A.76 — Medium — Logic/Files — Local disk URL generation may fail
- Baseline ID (v33): `A.74`
- Baseline ID (v32): `A.100`
- File: `app/Http/Controllers/Branch/ProductController.php`
- Line (v34): `156`
- Evidence: `            'url' => Storage::disk('local')->url($path),`

### A.77 — Medium — Finance/Precision — Money/amount cast to float (rounding drift risk)
- Baseline ID (v33): `A.75`
- Baseline ID (v32): `B.27`
- File: `app/Http/Controllers/Branch/PurchaseController.php`
- Line (v34): `103`
- Evidence: `        return $this->ok($this->purchases->pay($purchase, (float) $data['amount']), __('Paid'));`

### A.78 — Medium — Finance/Precision — Money/amount cast to float (rounding drift risk)
- Baseline ID (v33): `A.76`
- Baseline ID (v32): `B.28`
- File: `app/Http/Controllers/Branch/Purchases/ExportImportController.php`
- Line (v34): `159`
- Evidence: `                        'total_amount' => (float) $rowData['total'],`

### A.79 — Medium — Finance/Precision — Money/amount cast to float (rounding drift risk)
- Baseline ID (v33): `A.77`
- Baseline ID (v32): `B.29`
- File: `app/Http/Controllers/Branch/Purchases/ExportImportController.php`
- Line (v34): `160`
- Evidence: `                        'subtotal' => (float) ($rowData['subtotal'] ?? $rowData['total']),`

### A.80 — Medium — Finance/Precision — Money/amount cast to float (rounding drift risk)
- Baseline ID (v33): `A.78`
- Baseline ID (v32): `B.30`
- File: `app/Http/Controllers/Branch/Purchases/ExportImportController.php`
- Line (v34): `161`
- Evidence: `                        'tax_amount' => (float) ($rowData['tax'] ?? 0),`

### A.81 — Medium — Finance/Precision — Money/amount cast to float (rounding drift risk)
- Baseline ID (v33): `A.79`
- Baseline ID (v32): `B.31`
- File: `app/Http/Controllers/Branch/Purchases/ExportImportController.php`
- Line (v34): `162`
- Evidence: `                        'discount_amount' => (float) ($rowData['discount'] ?? 0),`

### A.82 — Medium — Finance/Precision — Money/amount cast to float (rounding drift risk)
- Baseline ID (v33): `A.80`
- Baseline ID (v32): `B.32`
- File: `app/Http/Controllers/Branch/Purchases/ExportImportController.php`
- Line (v34): `163`
- Evidence: `                        'paid_amount' => (float) ($rowData['paid'] ?? 0),`

### A.83 — Medium — Finance/Precision — Money/amount cast to float (rounding drift risk)
- Baseline ID (v33): `A.81`
- Baseline ID (v32): `B.33`
- File: `app/Http/Controllers/Branch/Rental/InvoiceController.php`
- Line (v34): `51`
- Evidence: `                (float) $data['amount'],`

### A.84 — Medium — Finance/Precision — Money/amount cast to float (rounding drift risk)
- Baseline ID (v33): `A.82`
- Baseline ID (v32): `B.34`
- File: `app/Http/Controllers/Branch/Sales/ExportImportController.php`
- Line (v34): `159`
- Evidence: `                        'total_amount' => (float) $rowData['total'],`

### A.85 — Medium — Finance/Precision — Money/amount cast to float (rounding drift risk)
- Baseline ID (v33): `A.83`
- Baseline ID (v32): `B.35`
- File: `app/Http/Controllers/Branch/Sales/ExportImportController.php`
- Line (v34): `160`
- Evidence: `                        'subtotal' => (float) ($rowData['subtotal'] ?? $rowData['total']),`

### A.86 — Medium — Finance/Precision — Money/amount cast to float (rounding drift risk)
- Baseline ID (v33): `A.84`
- Baseline ID (v32): `B.36`
- File: `app/Http/Controllers/Branch/Sales/ExportImportController.php`
- Line (v34): `161`
- Evidence: `                        'tax_amount' => (float) ($rowData['tax'] ?? 0),`

### A.87 — Medium — Finance/Precision — Money/amount cast to float (rounding drift risk)
- Baseline ID (v33): `A.85`
- Baseline ID (v32): `B.37`
- File: `app/Http/Controllers/Branch/Sales/ExportImportController.php`
- Line (v34): `162`
- Evidence: `                        'discount_amount' => (float) ($rowData['discount'] ?? 0),`

### A.88 — Medium — Finance/Precision — Money/amount cast to float (rounding drift risk)
- Baseline ID (v33): `A.86`
- Baseline ID (v32): `B.38`
- File: `app/Http/Controllers/Branch/Sales/ExportImportController.php`
- Line (v34): `163`
- Evidence: `                        'paid_amount' => (float) ($rowData['paid'] ?? 0),`

### A.89 — Medium — Perf/Security — Loads entire file into memory (Storage::get)
- Baseline ID (v33): `A.87`
- Baseline ID (v32): `A.102`
- File: `app/Http/Controllers/Files/UploadController.php`
- Line (v34): `41`
- Evidence: `        $content = $storage->get($path);`

### A.90 — Medium — Security/Auth — Token accepted via query/body (leak risk)
- Baseline ID (v33): `A.88`
- Baseline ID (v32): `A.104`
- File: `app/Http/Middleware/AuthenticateStoreToken.php`
- Line (v34): `109`
- Evidence: `        return $request->query('api_token') ?? $request->input('api_token');`

### A.91 — Medium — Finance/Precision — Money/amount cast to float (rounding drift risk)
- Baseline ID (v33): `A.89`
- Baseline ID (v32): `B.39`
- File: `app/Http/Middleware/EnforceDiscountLimit.php`
- Line (v34): `43`
- Evidence: `            $disc = (float) ($row['discount'] ?? 0);`

### A.92 — Medium — Finance/Precision — Float cast for totals
- Baseline ID (v33): `B.5`
- File: `app/Http/Middleware/EnforceDiscountLimit.php`
- Line (v34): `50`
- Evidence: `        $invDisc = (float) ($payload['invoice_discount'] ?? 0);`

### A.93 — Medium — Finance/Precision — Money/amount cast to float (rounding drift risk)
- Baseline ID (v33): `A.90`
- Baseline ID (v32): `B.40`
- File: `app/Http/Middleware/EnforceDiscountLimit.php`
- Line (v34): `80`
- Evidence: `        return (float) (config('erp.discount.max_line', 15)); // sensible default`

### A.94 — Medium — Finance/Precision — Money/amount cast to float (rounding drift risk)
- Baseline ID (v33): `A.91`
- Baseline ID (v32): `B.41`
- File: `app/Http/Middleware/EnforceDiscountLimit.php`
- Line (v34): `89`
- Evidence: `        return (float) (config('erp.discount.max_invoice', 20));`

### A.95 — Medium — Finance/Precision — Float cast for totals
- Baseline ID (v33): `B.6`
- File: `app/Http/Resources/CustomerResource.php`
- Line (v34): `26`
- Evidence: `                (float) ($this->credit_limit ?? 0.0)`

### A.96 — Medium — Finance/Precision — Float cast for totals
- Baseline ID (v33): `B.7`
- File: `app/Http/Resources/CustomerResource.php`
- Line (v34): `30`
- Evidence: `                (float) ($this->discount_percentage ?? 0.0)`

### A.97 — Medium — Finance/Precision — Money/amount cast to float (rounding drift risk)
- Baseline ID (v33): `A.92`
- Baseline ID (v32): `B.42`
- File: `app/Http/Resources/CustomerResource.php`
- Line (v34): `38`
- Evidence: `                (float) ($this->balance ?? 0.0)`

### A.98 — Medium — Finance/Precision — Float cast for totals
- Baseline ID (v33): `B.8`
- File: `app/Http/Resources/CustomerResource.php`
- Line (v34): `50`
- Evidence: `                (float) ($this->total_purchases ?? 0.0)`

### A.99 — Medium — Finance/Precision — Money/amount cast to float (rounding drift risk)
- Baseline ID (v33): `A.93`
- Baseline ID (v32): `B.43`
- File: `app/Http/Resources/OrderItemResource.php`
- Line (v34): `20`
- Evidence: `            'discount' => (float) $this->discount,`

### A.100 — Medium — Finance/Precision — Money/amount cast to float (rounding drift risk)
- Baseline ID (v33): `A.94`
- Baseline ID (v32): `B.44`
- File: `app/Http/Resources/OrderItemResource.php`
- Line (v34): `21`
- Evidence: `            'tax' => (float) ($this->tax ?? 0),`

### A.101 — Medium — Finance/Precision — Money/amount cast to float (rounding drift risk)
- Baseline ID (v33): `A.95`
- Baseline ID (v32): `B.45`
- File: `app/Http/Resources/OrderItemResource.php`
- Line (v34): `22`
- Evidence: `            'total' => (float) $this->line_total,`

### A.102 — Medium — Finance/Precision — Money/amount cast to float (rounding drift risk)
- Baseline ID (v33): `A.96`
- Baseline ID (v32): `B.46`
- File: `app/Http/Resources/OrderResource.php`
- Line (v34): `24`
- Evidence: `            'discount' => (float) $this->discount,`

### A.103 — Medium — Finance/Precision — Money/amount cast to float (rounding drift risk)
- Baseline ID (v33): `A.97`
- Baseline ID (v32): `B.47`
- File: `app/Http/Resources/OrderResource.php`
- Line (v34): `25`
- Evidence: `            'tax' => (float) $this->tax,`

### A.104 — Medium — Finance/Precision — Money/amount cast to float (rounding drift risk)
- Baseline ID (v33): `A.98`
- Baseline ID (v32): `B.48`
- File: `app/Http/Resources/OrderResource.php`
- Line (v34): `26`
- Evidence: `            'total' => (float) $this->grand_total,`

### A.105 — Medium — Finance/Precision — Float cast for totals
- Baseline ID (v33): `B.9`
- File: `app/Http/Resources/OrderResource.php`
- Line (v34): `27`
- Evidence: `            'paid_amount' => (float) ($this->paid_total ?? 0),`

### A.106 — Medium — Finance/Precision — Float cast for totals
- Baseline ID (v33): `B.10`
- File: `app/Http/Resources/OrderResource.php`
- Line (v34): `51`
- Evidence: `        $paidTotal = (float) ($this->paid_total ?? 0);`

### A.107 — Medium — Finance/Precision — Float cast for totals
- Baseline ID (v33): `B.11`
- File: `app/Http/Resources/OrderResource.php`
- Line (v34): `52`
- Evidence: `        $grandTotal = (float) ($this->grand_total ?? 0);`

### A.108 — Medium — Finance/Precision — Money/amount cast to float (rounding drift risk)
- Baseline ID (v33): `A.99`
- Baseline ID (v32): `B.49`
- File: `app/Http/Resources/ProductResource.php`
- Line (v34): `47`
- Evidence: `            'price' => (float) $this->default_price,`

### A.109 — Medium — Finance/Precision — Money/amount cast to float (rounding drift risk)
- Baseline ID (v33): `A.100`
- Baseline ID (v32): `B.50`
- File: `app/Http/Resources/ProductResource.php`
- Line (v34): `48`
- Evidence: `            'cost' => $this->when(self::$canViewCost, (float) $this->cost),`

### A.110 — Medium — Finance/Precision — Float cast for totals
- Baseline ID (v33): `B.12`
- File: `app/Http/Resources/PurchaseResource.php`
- Line (v34): `25`
- Evidence: `            'sub_total' => (float) ($this->sub_total ?? 0.0),`

### A.111 — Medium — Finance/Precision — Float cast for totals
- Baseline ID (v33): `B.13`
- File: `app/Http/Resources/PurchaseResource.php`
- Line (v34): `26`
- Evidence: `            'tax_total' => (float) ($this->tax_total ?? 0.0),`

### A.112 — Medium — Finance/Precision — Float cast for totals
- Baseline ID (v33): `B.14`
- File: `app/Http/Resources/PurchaseResource.php`
- Line (v34): `27`
- Evidence: `            'discount_total' => (float) ($this->discount_total ?? 0.0),`

### A.113 — Medium — Finance/Precision — Float cast for totals
- Baseline ID (v33): `B.15`
- File: `app/Http/Resources/PurchaseResource.php`
- Line (v34): `28`
- Evidence: `            'shipping_total' => (float) ($this->shipping_total ?? 0.0),`

### A.114 — Medium — Finance/Precision — Float cast for totals
- Baseline ID (v33): `B.16`
- File: `app/Http/Resources/PurchaseResource.php`
- Line (v34): `29`
- Evidence: `            'grand_total' => (float) ($this->grand_total ?? 0.0),`

### A.115 — Medium — Finance/Precision — Float cast for totals
- Baseline ID (v33): `B.17`
- File: `app/Http/Resources/PurchaseResource.php`
- Line (v34): `30`
- Evidence: `            'paid_total' => (float) ($this->paid_total ?? 0.0),`

### A.116 — Medium — Finance/Precision — Float cast for totals
- Baseline ID (v33): `B.18`
- File: `app/Http/Resources/PurchaseResource.php`
- Line (v34): `31`
- Evidence: `            'due_total' => (float) ($this->due_total ?? 0.0),`

### A.117 — Medium — Finance/Precision — Float cast for totals
- Baseline ID (v33): `B.19`
- File: `app/Http/Resources/SaleResource.php`
- Line (v34): `31`
- Evidence: `            'sub_total' => (float) ($this->sub_total ?? 0.0),`

### A.118 — Medium — Finance/Precision — Float cast for totals
- Baseline ID (v33): `B.20`
- File: `app/Http/Resources/SaleResource.php`
- Line (v34): `32`
- Evidence: `            'tax_total' => (float) ($this->tax_total ?? 0.0),`

### A.119 — Medium — Finance/Precision — Float cast for totals
- Baseline ID (v33): `B.21`
- File: `app/Http/Resources/SaleResource.php`
- Line (v34): `33`
- Evidence: `            'discount_total' => (float) ($this->discount_total ?? 0.0),`

### A.120 — Medium — Finance/Precision — Float cast for totals
- Baseline ID (v33): `B.22`
- File: `app/Http/Resources/SaleResource.php`
- Line (v34): `34`
- Evidence: `            'shipping_total' => (float) ($this->shipping_total ?? 0.0),`

### A.121 — Medium — Finance/Precision — Float cast for totals
- Baseline ID (v33): `B.23`
- File: `app/Http/Resources/SaleResource.php`
- Line (v34): `35`
- Evidence: `            'grand_total' => (float) ($this->grand_total ?? 0.0),`

### A.122 — Medium — Finance/Precision — Float cast for totals
- Baseline ID (v33): `B.24`
- File: `app/Http/Resources/SaleResource.php`
- Line (v34): `36`
- Evidence: `            'paid_total' => (float) ($this->paid_total ?? 0.0),`

### A.123 — Medium — Finance/Precision — Float cast for totals
- Baseline ID (v33): `B.25`
- File: `app/Http/Resources/SaleResource.php`
- Line (v34): `37`
- Evidence: `            'due_total' => (float) ($this->due_total ?? 0.0),`

### A.124 — Medium — Finance/Precision — Float cast for totals
- Baseline ID (v33): `B.26`
- File: `app/Http/Resources/SupplierResource.php`
- Line (v34): `37`
- Evidence: `                (float) ($this->minimum_order_value ?? 0.0)`

### A.125 — Medium — Finance/Precision — Money/amount cast to float (rounding drift risk)
- Baseline ID (v33): `A.101`
- Baseline ID (v32): `B.51`
- File: `app/Jobs/ClosePosDayJob.php`
- Line (v34): `72`
- Evidence: `            $paid = (float) $paidString;`

### A.126 — Medium — Finance/Precision — Money/amount cast to float (rounding drift risk)
- Baseline ID (v33): `A.102`
- Baseline ID (v32): `B.52`
- File: `app/Listeners/ApplyLateFee.php`
- Line (v34): `43`
- Evidence: `        $invoice->amount = (float) $newAmount;`

### A.127 — Medium — Finance/Precision — Money/amount cast to float (rounding drift risk)
- Baseline ID (v33): `A.103`
- Baseline ID (v32): `B.53`
- File: `app/Livewire/Accounting/JournalEntries/Form.php`
- Line (v34): `144`
- Evidence: `                        'amount' => number_format((float) ltrim($difference, '-'), 2),`

### A.128 — Medium — Finance/Precision — Float cast for totals
- Baseline ID (v33): `B.27`
- File: `app/Livewire/Admin/Settings/PurchasesSettings.php`
- Line (v34): `58`
- Evidence: `        $this->purchase_approval_threshold = (float) ($settings['purchases.approval_threshold'] ?? 10000);`

### A.129 — Medium — Finance/Precision — Float cast for totals
- Baseline ID (v33): `B.28`
- File: `app/Livewire/Admin/Settings/UnifiedSettings.php`
- Line (v34): `256`
- Evidence: `        $this->hrm_working_hours_per_day = (float) ($settings['hrm.working_hours_per_day'] ?? 8.0);`

### A.130 — Medium — Finance/Precision — Float cast for totals
- Baseline ID (v33): `B.29`
- File: `app/Livewire/Admin/Settings/UnifiedSettings.php`
- Line (v34): `259`
- Evidence: `        $this->hrm_transport_allowance_value = (float) ($settings['hrm.transport_allowance_value'] ?? 10.0);`

### A.131 — Medium — Finance/Precision — Float cast for totals
- Baseline ID (v33): `B.30`
- File: `app/Livewire/Admin/Settings/UnifiedSettings.php`
- Line (v34): `261`
- Evidence: `        $this->hrm_housing_allowance_value = (float) ($settings['hrm.housing_allowance_value'] ?? 0.0);`

### A.132 — Medium — Finance/Precision — Float cast for totals
- Baseline ID (v33): `B.31`
- File: `app/Livewire/Admin/Settings/UnifiedSettings.php`
- Line (v34): `262`
- Evidence: `        $this->hrm_meal_allowance = (float) ($settings['hrm.meal_allowance'] ?? 0.0);`

### A.133 — Medium — Finance/Precision — Float cast for totals
- Baseline ID (v33): `B.32`
- File: `app/Livewire/Admin/Settings/UnifiedSettings.php`
- Line (v34): `263`
- Evidence: `        $this->hrm_health_insurance_deduction = (float) ($settings['hrm.health_insurance_deduction'] ?? 0.0);`

### A.134 — Medium — Finance/Precision — Float cast for totals
- Baseline ID (v33): `B.33`
- File: `app/Livewire/Admin/Settings/UnifiedSettings.php`
- Line (v34): `268`
- Evidence: `        $this->rental_penalty_value = (float) ($settings['rental.penalty_value'] ?? 5.0);`

### A.135 — Medium — Finance/Precision — Money/amount cast to float (rounding drift risk)
- Baseline ID (v33): `A.104`
- Baseline ID (v32): `B.54`
- File: `app/Livewire/Admin/Store/OrdersDashboard.php`
- Line (v34): `67`
- Evidence: `        $totalRevenue = (float) $ordersForStats->sum('total');`

### A.136 — Medium — Finance/Precision — Money/amount cast to float (rounding drift risk)
- Baseline ID (v33): `A.105`
- Baseline ID (v32): `B.55`
- File: `app/Livewire/Admin/Store/OrdersDashboard.php`
- Line (v34): `84`
- Evidence: `            $sources[$source]['revenue'] += (float) $order->total;`

### A.137 — Medium — Finance/Precision — Money/amount cast to float (rounding drift risk)
- Baseline ID (v33): `A.106`
- Baseline ID (v32): `B.56`
- File: `app/Livewire/Admin/Store/OrdersDashboard.php`
- Line (v34): `139`
- Evidence: `            $dayValues[] = (float) $items->sum('total');`

### A.138 — Medium — Finance/Precision — Money/amount cast to float (rounding drift risk)
- Baseline ID (v33): `A.107`
- Baseline ID (v32): `B.57`
- File: `app/Livewire/Banking/Reconciliation.php`
- Line (v34): `304`
- Evidence: `                'amount' => number_format((float) $this->difference, 2),`

### A.139 — Medium — Finance/Precision — Float cast for totals
- Baseline ID (v33): `B.34`
- File: `app/Livewire/Concerns/LoadsDashboardData.php`
- Line (v34): `206`
- Evidence: `            $data[] = (float) ($salesByDate[$dateKey] ?? 0);`

### A.140 — Medium — Finance/Precision — Float cast for totals
- Baseline ID (v33): `B.35`
- File: `app/Livewire/Customers/Form.php`
- Line (v34): `89`
- Evidence: `            $this->credit_limit = (float) ($customer->credit_limit ?? 0);`

### A.141 — Medium — Finance/Precision — Float cast for totals
- Baseline ID (v33): `B.36`
- File: `app/Livewire/Customers/Form.php`
- Line (v34): `90`
- Evidence: `            $this->discount_percentage = (float) ($customer->discount_percentage ?? 0);`

### A.142 — Medium — Finance/Precision — Float cast for totals
- Baseline ID (v33): `B.37`
- File: `app/Livewire/Hrm/Employees/Form.php`
- Line (v34): `93`
- Evidence: `            $this->form['salary'] = (float) ($employeeModel->salary ?? 0);`

### A.143 — Medium — Finance/Precision — Money/amount cast to float (rounding drift risk)
- Baseline ID (v33): `A.108`
- Baseline ID (v32): `B.58`
- File: `app/Livewire/Income/Form.php`
- Line (v34): `102`
- Evidence: `            $this->amount = (float) $income->amount;`

### A.144 — Medium — Finance/Precision — Money/amount cast to float (rounding drift risk)
- Baseline ID (v33): `A.109`
- Baseline ID (v32): `B.59`
- File: `app/Livewire/Inventory/Products/Form.php`
- Line (v34): `132`
- Evidence: `            $this->form['price'] = (float) ($p->default_price ?? $p->price ?? 0);`

### A.145 — Medium — Finance/Precision — Money/amount cast to float (rounding drift risk)
- Baseline ID (v33): `A.110`
- Baseline ID (v32): `B.60`
- File: `app/Livewire/Inventory/Products/Form.php`
- Line (v34): `133`
- Evidence: `            $this->form['cost'] = (float) ($p->standard_cost ?? $p->cost ?? 0);`

### A.146 — Medium — Finance/Precision — Float cast for totals
- Baseline ID (v33): `B.38`
- File: `app/Livewire/Inventory/Products/Form.php`
- Line (v34): `142`
- Evidence: `            $this->form['min_stock'] = (float) ($p->min_stock ?? 0);`

### A.147 — Medium — Finance/Precision — Float cast for totals
- Baseline ID (v33): `B.39`
- File: `app/Livewire/Inventory/Products/Form.php`
- Line (v34): `144`
- Evidence: `            $this->form['reorder_point'] = (float) ($p->reorder_point ?? 0);`

### A.148 — Medium — Finance/Precision — Money/amount cast to float (rounding drift risk)
- Baseline ID (v33): `A.111`
- Baseline ID (v32): `B.61`
- File: `app/Livewire/Inventory/Services/Form.php`
- Line (v34): `137`
- Evidence: `        $this->cost = (float) ($product->cost ?: $product->standard_cost);`

### A.149 — Medium — Finance/Precision — Float cast for totals
- Baseline ID (v33): `B.40`
- File: `app/Livewire/Projects/TimeLogs.php`
- Line (v34): `206`
- Evidence: `            'total_hours' => (float) ($stats->total_hours ?? 0),`

### A.150 — Medium — Finance/Precision — Float cast for totals
- Baseline ID (v33): `B.41`
- File: `app/Livewire/Projects/TimeLogs.php`
- Line (v34): `207`
- Evidence: `            'billable_hours' => (float) ($stats->billable_hours ?? 0),`

### A.151 — Medium — Finance/Precision — Float cast for totals
- Baseline ID (v33): `B.42`
- File: `app/Livewire/Projects/TimeLogs.php`
- Line (v34): `208`
- Evidence: `            'non_billable_hours' => (float) ($stats->non_billable_hours ?? 0),`

### A.152 — Medium — Finance/Precision — Float cast for totals
- Baseline ID (v33): `B.43`
- File: `app/Livewire/Projects/TimeLogs.php`
- Line (v34): `209`
- Evidence: `            'total_cost' => (float) ($stats->total_cost ?? 0),`

### A.153 — Medium — Finance/Precision — Float cast for totals
- Baseline ID (v33): `B.44`
- File: `app/Livewire/Purchases/Form.php`
- Line (v34): `163`
- Evidence: `            $this->discount_total = (float) ($purchase->discount_total ?? 0);`

### A.154 — Medium — Finance/Precision — Float cast for totals
- Baseline ID (v33): `B.45`
- File: `app/Livewire/Purchases/Form.php`
- Line (v34): `164`
- Evidence: `            $this->shipping_total = (float) ($purchase->shipping_total ?? 0);`

### A.155 — Medium — Finance/Precision — Money/amount cast to float (rounding drift risk)
- Baseline ID (v33): `A.112`
- Baseline ID (v32): `B.62`
- File: `app/Livewire/Purchases/Form.php`
- Line (v34): `173`
- Evidence: `                'discount' => (float) ($item->discount ?? 0),`

### A.156 — Medium — Finance/Precision — Float cast for totals
- Baseline ID (v33): `B.46`
- File: `app/Livewire/Purchases/Form.php`
- Line (v34): `174`
- Evidence: `                'tax_rate' => (float) ($item->tax_rate ?? 0),`

### A.157 — Medium — Finance/Precision — Money/amount cast to float (rounding drift risk)
- Baseline ID (v33): `A.113`
- Baseline ID (v32): `B.63`
- File: `app/Livewire/Purchases/Form.php`
- Line (v34): `239`
- Evidence: `                'unit_cost' => (float) ($product->cost ?? 0),`

### A.158 — Medium — Finance/Precision — Money/amount cast to float (rounding drift risk)
- Baseline ID (v33): `A.114`
- Baseline ID (v32): `B.64`
- File: `app/Livewire/Purchases/Form.php`
- Line (v34): `357`
- Evidence: `                            $discountAmount = max(0, (float) ($item['discount'] ?? 0));`

### A.159 — Medium — Finance/Precision — Money/amount cast to float (rounding drift risk)
- Baseline ID (v33): `A.115`
- Baseline ID (v32): `B.65`
- File: `app/Livewire/Purchases/Returns/Index.php`
- Line (v34): `104`
- Evidence: `            'cost' => (float) $item->unit_cost,`

### A.160 — Medium — Finance/Precision — BCMath result cast to float
- Baseline ID (v33): `A.116`
- Baseline ID (v32): `A.64`
- File: `app/Livewire/Rental/Reports/Dashboard.php`
- Line (v34): `69`
- Evidence: `        $occupancyRate = $total > 0 ? (float) bcdiv(bcmul((string) $occupied, '100', 4), (string) $total, 1) : 0;`

### A.161 — Medium — Finance/Precision — BCMath result cast to float
- Baseline ID (v33): `A.117`
- Baseline ID (v32): `A.65`
- File: `app/Livewire/Reports/SalesAnalytics.php`
- Line (v34): `152`
- Evidence: `        $avgOrderValue = $totalOrders > 0 ? (float) bcdiv((string) $totalSales, (string) $totalOrders, 2) : 0;`

### A.162 — Medium — Finance/Precision — BCMath result cast to float
- Baseline ID (v33): `A.118`
- Baseline ID (v32): `A.66`
- File: `app/Livewire/Reports/SalesAnalytics.php`
- Line (v34): `171`
- Evidence: `            $salesGrowth = (float) bcdiv(bcmul($diff, '100', 6), (string) $prevTotalSales, 1);`

### A.163 — Medium — Finance/Precision — BCMath result cast to float
- Baseline ID (v33): `A.119`
- Baseline ID (v32): `A.67`
- File: `app/Livewire/Reports/SalesAnalytics.php`
- Line (v34): `176`
- Evidence: `        $completionRate = $totalOrders > 0 ? (float) bcdiv(bcmul((string) $completedOrders, '100', 4), (string) $totalOrders, 1) : 0;`

### A.164 — Medium — Finance/Precision — Money/amount cast to float (rounding drift risk)
- Baseline ID (v33): `A.120`
- Baseline ID (v32): `B.66`
- File: `app/Livewire/Reports/SalesAnalytics.php`
- Line (v34): `319`
- Evidence: `            'totals' => $results->pluck('total')->map(fn ($v) => (float) $v)->toArray(),`

### A.165 — Medium — Finance/Precision — Float cast for totals
- Baseline ID (v33): `B.47`
- File: `app/Livewire/Sales/Form.php`
- Line (v34): `185`
- Evidence: `            $this->discount_total = (float) ($sale->discount_total ?? 0);`

### A.166 — Medium — Finance/Precision — Float cast for totals
- Baseline ID (v33): `B.48`
- File: `app/Livewire/Sales/Form.php`
- Line (v34): `186`
- Evidence: `            $this->shipping_total = (float) ($sale->shipping_total ?? 0);`

### A.167 — Medium — Finance/Precision — Money/amount cast to float (rounding drift risk)
- Baseline ID (v33): `A.121`
- Baseline ID (v32): `B.67`
- File: `app/Livewire/Sales/Form.php`
- Line (v34): `195`
- Evidence: `                'discount' => (float) ($item->discount ?? 0),`

### A.168 — Medium — Finance/Precision — Float cast for totals
- Baseline ID (v33): `B.49`
- File: `app/Livewire/Sales/Form.php`
- Line (v34): `196`
- Evidence: `                'tax_rate' => (float) ($item->tax_rate ?? 0),`

### A.169 — Medium — Finance/Precision — Money/amount cast to float (rounding drift risk)
- Baseline ID (v33): `A.122`
- Baseline ID (v32): `B.68`
- File: `app/Livewire/Sales/Form.php`
- Line (v34): `202`
- Evidence: `                $this->payment_amount = (float) ($firstPayment->amount ?? 0);`

### A.170 — Medium — Finance/Precision — Float cast for totals
- Baseline ID (v33): `B.50`
- File: `app/Livewire/Sales/Form.php`
- Line (v34): `268`
- Evidence: `                'unit_price' => (float) ($product->default_price ?? 0),`

### A.171 — Medium — Finance/Precision — BCMath result cast to float
- Baseline ID (v33): `A.123`
- Baseline ID (v32): `A.68`
- File: `app/Livewire/Sales/Form.php`
- Line (v34): `300`
- Evidence: `        return (float) bcdiv($total, '1', BCMATH_STORAGE_SCALE);`

### A.172 — Medium — Finance/Precision — BCMath result cast to float
- Baseline ID (v33): `A.124`
- Baseline ID (v32): `A.69`
- File: `app/Livewire/Sales/Form.php`
- Line (v34): `340`
- Evidence: `        return (float) bcdiv($result, '1', BCMATH_STORAGE_SCALE);`

### A.173 — Medium — Finance/Precision — Float cast for totals
- Baseline ID (v33): `B.51`
- File: `app/Livewire/Sales/Form.php`
- Line (v34): `446`
- Evidence: `                            $validatedPrice = (float) ($product->default_price ?? 0);`

### A.174 — Medium — Finance/Precision — BCMath result cast to float
- Baseline ID (v33): `A.125`
- Baseline ID (v32): `A.70`
- File: `app/Livewire/Sales/Form.php`
- Line (v34): `476`
- Evidence: `                                'discount_amount' => (float) bcdiv($discountAmount, '1', BCMATH_STORAGE_SCALE),`

### A.175 — Medium — Finance/Precision — BCMath result cast to float
- Baseline ID (v33): `A.126`
- Baseline ID (v32): `A.71`
- File: `app/Livewire/Sales/Form.php`
- Line (v34): `478`
- Evidence: `                                'tax_amount' => (float) bcdiv($taxAmount, '1', BCMATH_STORAGE_SCALE),`

### A.176 — Medium — Finance/Precision — BCMath result cast to float
- Baseline ID (v33): `A.127`
- Baseline ID (v32): `A.72`
- File: `app/Livewire/Sales/Form.php`
- Line (v34): `479`
- Evidence: `                                'line_total' => (float) bcdiv($lineTotal, '1', BCMATH_STORAGE_SCALE),`

### A.177 — Medium — Finance/Precision — Money/amount cast to float (rounding drift risk)
- Baseline ID (v33): `A.128`
- Baseline ID (v32): `B.69`
- File: `app/Livewire/Sales/Returns/Index.php`
- Line (v34): `116`
- Evidence: `            'price' => (float) $item->unit_price,`

### A.178 — Medium — Finance/Precision — Float cast for totals
- Baseline ID (v33): `B.52`
- File: `app/Livewire/Suppliers/Form.php`
- Line (v34): `115`
- Evidence: `            $this->minimum_order_value = (float) ($supplier->minimum_order_value ?? 0);`

### A.179 — Medium — Finance/Precision — Float cast for totals
- Baseline ID (v33): `B.53`
- File: `app/Livewire/Suppliers/Form.php`
- Line (v34): `117`
- Evidence: `            $this->quality_rating = (float) ($supplier->quality_rating ?? 0);`

### A.180 — Medium — Finance/Precision — Float cast for totals
- Baseline ID (v33): `B.54`
- File: `app/Livewire/Suppliers/Form.php`
- Line (v34): `118`
- Evidence: `            $this->delivery_rating = (float) ($supplier->delivery_rating ?? 0);`

### A.181 — Medium — Finance/Precision — Float cast for totals
- Baseline ID (v33): `B.55`
- File: `app/Livewire/Suppliers/Form.php`
- Line (v34): `119`
- Evidence: `            $this->service_rating = (float) ($supplier->service_rating ?? 0);`

### A.182 — Medium — Finance/Precision — Money/amount cast to float (rounding drift risk)
- Baseline ID (v33): `A.129`
- Baseline ID (v32): `B.70`
- File: `app/Models/BankTransaction.php`
- Line (v34): `107`
- Evidence: `        $amount = (float) $this->amount;`

### A.183 — Medium — Finance/Precision — Float cast for totals
- Baseline ID (v33): `B.56`
- File: `app/Models/BillOfMaterial.php`
- Line (v34): `124`
- Evidence: `            $scrapFactor = 1 + ((float) ($item->scrap_percentage ?? 0) / 100);`

### A.184 — Medium — Finance/Precision — Float cast for totals
- Baseline ID (v33): `B.57`
- File: `app/Models/BillOfMaterial.php`
- Line (v34): `130`
- Evidence: `        $yieldFactor = (float) ($this->yield_percentage ?? 100) / 100;`

### A.185 — Medium — Finance/Precision — Float cast for totals
- Baseline ID (v33): `B.58`
- File: `app/Models/BillOfMaterial.php`
- Line (v34): `145`
- Evidence: `            $durationHours = (float) ($operation->duration_minutes ?? 0) / 60;`

### A.186 — Medium — Finance/Precision — Float cast for totals
- Baseline ID (v33): `B.59`
- File: `app/Models/BillOfMaterial.php`
- Line (v34): `146`
- Evidence: `            $costPerHour = (float) ($operation->workCenter->cost_per_hour ?? 0);`

### A.187 — Medium — Finance/Precision — Float cast for totals
- Baseline ID (v33): `B.60`
- File: `app/Models/BillOfMaterial.php`
- Line (v34): `148`
- Evidence: `            return $durationHours * $costPerHour + (float) ($operation->labor_cost ?? 0);`

### A.188 — Medium — Finance/Precision — Float cast for totals
- Baseline ID (v33): `B.61`
- File: `app/Models/BomItem.php`
- Line (v34): `70`
- Evidence: `        $scrapFactor = 1 + ((float) ($this->scrap_percentage ?? 0) / 100);`

### A.189 — Medium — Finance/Precision — Float cast for totals
- Baseline ID (v33): `B.62`
- File: `app/Models/FixedAsset.php`
- Line (v34): `156`
- Evidence: `        $currentValue = (float) ($this->current_value ?? 0);`

### A.190 — Medium — Finance/Precision — Float cast for totals
- Baseline ID (v33): `B.63`
- File: `app/Models/FixedAsset.php`
- Line (v34): `157`
- Evidence: `        $salvageValue = (float) ($this->salvage_value ?? 0);`

### A.191 — Medium — Finance/Precision — Float cast for totals
- Baseline ID (v33): `B.64`
- File: `app/Models/FixedAsset.php`
- Line (v34): `175`
- Evidence: `        $purchaseCost = (float) ($this->purchase_cost ?? 0);`

### A.192 — Medium — Finance/Precision — Float cast for totals
- Baseline ID (v33): `B.65`
- File: `app/Models/GRNItem.php`
- Line (v34): `85`
- Evidence: `        $expectedQty = (float) ($this->expected_quantity ?? 0);`

### A.193 — Medium — Finance/Precision — Float cast for totals
- Baseline ID (v33): `B.66`
- File: `app/Models/InstallmentPayment.php`
- Line (v34): `45`
- Evidence: `        return max(0, (float) $this->amount_due - (float) ($this->amount_paid ?? 0));`

### A.194 — Medium — Finance/Precision — Float cast for totals
- Baseline ID (v33): `B.67`
- File: `app/Models/InstallmentPayment.php`
- Line (v34): `60`
- Evidence: `        $amountPaid = (float) ($this->amount_paid ?? 0);`

### A.195 — Medium — Finance/Precision — Money/amount cast to float (rounding drift risk)
- Baseline ID (v33): `A.130`
- Baseline ID (v32): `B.71`
- File: `app/Models/InstallmentPayment.php`
- Line (v34): `61`
- Evidence: `        $newAmountPaid = min($amountPaid + $amount, (float) $this->amount_due);`

### A.196 — Medium — Finance/Precision — Money/amount cast to float (rounding drift risk)
- Baseline ID (v33): `A.131`
- Baseline ID (v32): `B.72`
- File: `app/Models/InstallmentPayment.php`
- Line (v34): `62`
- Evidence: `        $newStatus = $newAmountPaid >= (float) $this->amount_due ? 'paid' : 'partial';`

### A.197 — Medium — Finance/Precision — Float cast for totals
- Baseline ID (v33): `B.68`
- File: `app/Models/JournalEntry.php`
- Line (v34): `101`
- Evidence: `        return (float) ($this->attributes['total_debit'] ?? $this->lines()->sum('debit'));`

### A.198 — Medium — Finance/Precision — Float cast for totals
- Baseline ID (v33): `B.69`
- File: `app/Models/JournalEntry.php`
- Line (v34): `106`
- Evidence: `        return (float) ($this->attributes['total_credit'] ?? $this->lines()->sum('credit'));`

### A.199 — Medium — Finance/Precision — Float cast for totals
- Baseline ID (v33): `B.70`
- File: `app/Models/ProductionOrder.php`
- Line (v34): `175`
- Evidence: `        $plannedQty = (float) ($this->planned_quantity ?? 0);`

### A.200 — Medium — Finance/Precision — Float cast for totals
- Baseline ID (v33): `B.71`
- File: `app/Models/ProductionOrder.php`
- Line (v34): `181`
- Evidence: `        return ((float) ($this->produced_quantity ?? 0) / $plannedQty) * 100;`

### A.201 — Medium — Finance/Precision — Float cast for totals
- Baseline ID (v33): `B.72`
- File: `app/Models/Project.php`
- Line (v34): `208`
- Evidence: `        return (float) ($timeLogsCost + $expensesCost);`

### A.202 — Medium — Finance/Precision — Float cast for totals
- Baseline ID (v33): `B.73`
- File: `app/Models/ProjectTimeLog.php`
- Line (v34): `110`
- Evidence: `        return (float) ($this->hours * $this->hourly_rate);`

### A.203 — Medium — Finance/Precision — BCMath result cast to float
- Baseline ID (v33): `A.132`
- Baseline ID (v32): `A.73`
- File: `app/Models/StockTransferItem.php`
- Line (v34): `74`
- Evidence: `        return (float) bcsub((string)$this->qty_shipped, (string)$this->qty_received, 3);`

### A.204 — Medium — Finance/Precision — Float cast for totals
- Baseline ID (v33): `B.74`
- File: `app/Models/Supplier.php`
- Line (v34): `129`
- Evidence: `        return (float) ($this->rating ?? 0);`

### A.205 — Medium — Finance/Precision — Money/amount cast to float (rounding drift risk)
- Baseline ID (v33): `A.133`
- Baseline ID (v32): `B.73`
- File: `app/Observers/ProductObserver.php`
- Line (v34): `31`
- Evidence: `            $product->cost = round((float) $product->cost, 2);`

### A.206 — Medium — Finance/Precision — Float cast for totals
- Baseline ID (v33): `B.75`
- File: `app/Repositories/StockMovementRepository.php`
- Line (v34): `74`
- Evidence: `        $in = (float) (clone $baseQuery)->where('quantity', '>', 0)->sum('quantity');`

### A.207 — Medium — Finance/Precision — Float cast for totals
- Baseline ID (v33): `B.76`
- File: `app/Repositories/StockMovementRepository.php`
- Line (v34): `138`
- Evidence: `            $qty = abs((float) ($data['qty'] ?? $data['quantity'] ?? 0));`

### A.208 — Medium — Finance/Precision — Money/amount cast to float (rounding drift risk)
- Baseline ID (v33): `A.134`
- Baseline ID (v32): `B.75`
- File: `app/Rules/ValidDiscountPercentage.php`
- Line (v34): `29`
- Evidence: `        $discount = (float) $value;`

### A.209 — Medium — Finance/Precision — Money/amount cast to float (rounding drift risk)
- Baseline ID (v33): `A.135`
- Baseline ID (v32): `B.76`
- File: `app/Rules/ValidPriceOverride.php`
- Line (v34): `25`
- Evidence: `        $price = (float) $value;`

### A.210 — Medium — Finance/Precision — Float cast for totals
- Baseline ID (v33): `B.77`
- File: `app/Services/AccountingService.php`
- Line (v34): `610`
- Evidence: `        return (float) ($result ?? 0);`

### A.211 — Medium — Finance/Precision — BCMath result cast to float
- Baseline ID (v33): `A.136`
- Baseline ID (v32): `A.74`
- File: `app/Services/AutomatedAlertService.php`
- Line (v34): `173`
- Evidence: `            $utilization = (float) bcmul(`

### A.212 — Medium — Finance/Precision — BCMath result cast to float
- Baseline ID (v33): `A.137`
- Baseline ID (v32): `A.75`
- File: `app/Services/AutomatedAlertService.php`
- Line (v34): `183`
- Evidence: `            $availableCredit = (float) bcsub((string) $customer->credit_limit, (string) $customer->balance, 2);`

### A.213 — Medium — Finance/Precision — BCMath result cast to float
- Baseline ID (v33): `A.138`
- Baseline ID (v32): `A.76`
- File: `app/Services/AutomatedAlertService.php`
- Line (v34): `234`
- Evidence: `            $estimatedLoss = (float) bcmul((string) $currentStock, (string) $unitCost, 2);`

### A.214 — Medium — Finance/Precision — BCMath result cast to float
- Baseline ID (v33): `A.139`
- Baseline ID (v32): `A.77`
- File: `app/Services/CurrencyExchangeService.php`
- Line (v34): `55`
- Evidence: `        return (float) bcmul((string) $amount, (string) $rate, 4);`

### A.215 — Medium — Finance/Precision — BCMath result cast to float
- Baseline ID (v33): `A.140`
- Baseline ID (v32): `A.78`
- File: `app/Services/CurrencyService.php`
- Line (v34): `128`
- Evidence: `        return (float) bcmul((string) $amount, (string) $rate, 2);`

### A.216 — Medium — Finance/Precision — Money/amount cast to float (rounding drift risk)
- Baseline ID (v33): `A.141`
- Baseline ID (v32): `B.77`
- File: `app/Services/DataValidationService.php`
- Line (v34): `115`
- Evidence: `        $amount = (float) $amount;`

### A.217 — Medium — Perf/Security — Loads entire file into memory (Storage::get)
- Baseline ID (v33): `A.142`
- Baseline ID (v32): `A.103`
- File: `app/Services/DiagnosticsService.php`
- Line (v34): `178`
- Evidence: `            $retrieved = Storage::disk($disk)->get($filename);`

### A.218 — Medium — Finance/Precision — Money/amount cast to float (rounding drift risk)
- Baseline ID (v33): `A.143`
- Baseline ID (v32): `B.78`
- File: `app/Services/DiscountService.php`
- Line (v34): `93`
- Evidence: `        return (float) config('pos.discount.max_amount', 1000);`

### A.219 — Medium — Finance/Precision — Money/amount cast to float (rounding drift risk)
- Baseline ID (v33): `A.144`
- Baseline ID (v32): `B.79`
- File: `app/Services/DiscountService.php`
- Line (v34): `103`
- Evidence: `            : (float) config('pos.discount.max_amount', 1000);`

### A.220 — Medium — Finance/Precision — Money/amount cast to float (rounding drift risk)
- Baseline ID (v33): `A.145`
- Baseline ID (v32): `B.80`
- File: `app/Services/DiscountService.php`
- Line (v34): `157`
- Evidence: `            $value = (float) ($discount['value'] ?? 0);`

### A.221 — Medium — Finance/Precision — Money/amount cast to float (rounding drift risk)
- Baseline ID (v33): `A.146`
- Baseline ID (v32): `B.81`
- File: `app/Services/FinancialReportService.php`
- Line (v34): `148`
- Evidence: `                'total' => (float) bcround((string) $totalRevenue, 2),`

### A.222 — Medium — Finance/Precision — Money/amount cast to float (rounding drift risk)
- Baseline ID (v33): `A.147`
- Baseline ID (v32): `B.82`
- File: `app/Services/FinancialReportService.php`
- Line (v34): `153`
- Evidence: `                'total' => (float) bcround((string) $totalExpenses, 2),`

### A.223 — Medium — Finance/Precision — Money/amount cast to float (rounding drift risk)
- Baseline ID (v33): `A.148`
- Baseline ID (v32): `B.83`
- File: `app/Services/FinancialReportService.php`
- Line (v34): `253`
- Evidence: `                'total' => (float) bcround((string) $totalAssets, 2),`

### A.224 — Medium — Finance/Precision — Money/amount cast to float (rounding drift risk)
- Baseline ID (v33): `A.149`
- Baseline ID (v32): `B.84`
- File: `app/Services/FinancialReportService.php`
- Line (v34): `258`
- Evidence: `                'total' => (float) bcround((string) $totalLiabilities, 2),`

### A.225 — Medium — Finance/Precision — Money/amount cast to float (rounding drift risk)
- Baseline ID (v33): `A.150`
- Baseline ID (v32): `B.85`
- File: `app/Services/FinancialReportService.php`
- Line (v34): `263`
- Evidence: `                'total' => (float) bcround((string) $totalEquity, 2),`

### A.226 — Medium — Finance/Precision — Float cast for totals
- Baseline ID (v33): `B.78`
- File: `app/Services/HRMService.php`
- Line (v34): `112`
- Evidence: `                        $housingAllowance = (float) ($extra['housing_allowance'] ?? 0);`

### A.227 — Medium — Finance/Precision — Float cast for totals
- Baseline ID (v33): `B.79`
- File: `app/Services/HRMService.php`
- Line (v34): `113`
- Evidence: `                        $transportAllowance = (float) ($extra['transport_allowance'] ?? 0);`

### A.228 — Medium — Finance/Precision — Float cast for totals
- Baseline ID (v33): `B.80`
- File: `app/Services/HRMService.php`
- Line (v34): `114`
- Evidence: `                        $otherAllowance = (float) ($extra['other_allowance'] ?? 0);`

### A.229 — Medium — Finance/Precision — Float cast for totals
- Baseline ID (v33): `B.81`
- File: `app/Services/HRMService.php`
- Line (v34): `121`
- Evidence: `                        $loanDeduction = (float) ($extra['loan_deduction'] ?? 0);`

### A.230 — Medium — Finance/Precision — BCMath result cast to float
- Baseline ID (v33): `A.151`
- Baseline ID (v32): `A.79`
- File: `app/Services/HRMService.php`
- Line (v34): `236`
- Evidence: `            return (float) bcmul((string) $dailyRate, (string) $absenceDays, 2);`

### A.231 — Medium — Finance/Precision — BCMath result cast to float
- Baseline ID (v33): `A.152`
- Baseline ID (v32): `A.80`
- File: `app/Services/HelpdeskService.php`
- Line (v34): `294`
- Evidence: `        return (float) bcdiv((string) $totalMinutes, (string) $tickets->count(), 2);`

### A.232 — Medium — Finance/Precision — Float cast for totals
- Baseline ID (v33): `B.82`
- File: `app/Services/ImportService.php`
- Line (v34): `567`
- Evidence: `            'default_price' => (float) ($data['default_price'] ?? 0),`

### A.233 — Medium — Finance/Precision — Money/amount cast to float (rounding drift risk)
- Baseline ID (v33): `A.153`
- Baseline ID (v32): `B.86`
- File: `app/Services/ImportService.php`
- Line (v34): `568`
- Evidence: `            'cost' => (float) ($data['cost'] ?? 0),`

### A.234 — Medium — Finance/Precision — Float cast for totals
- Baseline ID (v33): `B.83`
- File: `app/Services/ImportService.php`
- Line (v34): `587`
- Evidence: `            'credit_limit' => (float) ($data['credit_limit'] ?? 0),`

### A.235 — Medium — Finance/Precision — Money/amount cast to float (rounding drift risk)
- Baseline ID (v33): `A.154`
- Baseline ID (v32): `B.87`
- File: `app/Services/InstallmentService.php`
- Line (v34): `103`
- Evidence: `                            'amount_due' => max(0, (float) $amount),`

### A.236 — Medium — Finance/Precision — Float cast for totals
- Baseline ID (v33): `B.84`
- File: `app/Services/InventoryService.php`
- Line (v34): `48`
- Evidence: `                    return (float) ($perWarehouse->get($warehouseId, 0.0));`

### A.237 — Medium — Finance/Precision — BCMath result cast to float
- Baseline ID (v33): `A.155`
- Baseline ID (v32): `A.81`
- File: `app/Services/LoyaltyService.php`
- Line (v34): `208`
- Evidence: `        return (float) bcmul((string) $points, (string) $settings->redemption_rate, 2);`

### A.238 — Medium — Finance/Precision — Float cast for totals
- Baseline ID (v33): `B.85`
- File: `app/Services/POSService.php`
- Line (v34): `112`
- Evidence: `                    $qty = (float) ($it['qty'] ?? 1);`

### A.239 — Medium — Finance/Precision — Money/amount cast to float (rounding drift risk)
- Baseline ID (v33): `A.156`
- Baseline ID (v32): `B.88`
- File: `app/Services/POSService.php`
- Line (v34): `128`
- Evidence: `                    $price = isset($it['price']) ? (float) $it['price'] : (float) ($product->default_price ?? 0);`

### A.240 — Medium — Finance/Precision — Money/amount cast to float (rounding drift risk)
- Baseline ID (v33): `A.157`
- Baseline ID (v32): `B.89`
- File: `app/Services/POSService.php`
- Line (v34): `145`
- Evidence: `                    if ($user && ! $user->can_modify_price && abs($price - (float) ($product->default_price ?? 0)) > 0.001) {`

### A.241 — Medium — Finance/Precision — Money/amount cast to float (rounding drift risk)
- Baseline ID (v33): `A.158`
- Baseline ID (v32): `B.90`
- File: `app/Services/POSService.php`
- Line (v34): `149`
- Evidence: `                    (new ValidPriceOverride((float) $product->cost, 0.0))->validate('price', $price, function ($m) {`

### A.242 — Medium — Finance/Precision — Money/amount cast to float (rounding drift risk)
- Baseline ID (v33): `A.159`
- Baseline ID (v32): `B.91`
- File: `app/Services/POSService.php`
- Line (v34): `153`
- Evidence: `                    $itemDiscountPercent = (float) ($it['discount'] ?? 0);`

### A.243 — Medium — Finance/Precision — Money/amount cast to float (rounding drift risk)
- Baseline ID (v33): `A.160`
- Baseline ID (v32): `B.92`
- File: `app/Services/POSService.php`
- Line (v34): `232`
- Evidence: `                        $amount = (float) ($payment['amount'] ?? 0);`

### A.244 — Medium — Finance/Precision — Money/amount cast to float (rounding drift risk)
- Baseline ID (v33): `A.161`
- Baseline ID (v32): `B.93`
- File: `app/Services/POSService.php`
- Line (v34): `259`
- Evidence: `                        'amount' => (float) bcround($grandTotal, 2),`

### A.245 — Medium — Finance/Precision — Money/amount cast to float (rounding drift risk)
- Baseline ID (v33): `A.162`
- Baseline ID (v32): `B.94`
- File: `app/Services/POSService.php`
- Line (v34): `487`
- Evidence: `                            'paid' => (float) $paidAmountString,`

### A.246 — Medium — Finance/Precision — Money/amount cast to float (rounding drift risk)
- Baseline ID (v33): `A.163`
- Baseline ID (v32): `B.95`
- File: `app/Services/PayslipService.php`
- Line (v34): `112`
- Evidence: `            'total' => (float) $total,`

### A.247 — Medium — Finance/Precision — Float cast for totals
- Baseline ID (v33): `B.86`
- File: `app/Services/PayslipService.php`
- Line (v34): `126`
- Evidence: `        $siRate = (float) ($siConfig['rate'] ?? 0.14);`

### A.248 — Medium — Finance/Precision — Float cast for totals
- Baseline ID (v33): `B.87`
- File: `app/Services/PayslipService.php`
- Line (v34): `127`
- Evidence: `        $siMaxSalary = (float) ($siConfig['max_salary'] ?? 12600);`

### A.249 — Medium — Finance/Precision — Float cast for totals
- Baseline ID (v33): `B.88`
- File: `app/Services/PayslipService.php`
- Line (v34): `142`
- Evidence: `            $limit = (float) ($bracket['limit'] ?? PHP_FLOAT_MAX);`

### A.250 — Medium — Finance/Precision — Float cast for totals
- Baseline ID (v33): `B.89`
- File: `app/Services/PayslipService.php`
- Line (v34): `143`
- Evidence: `            $rate = (float) ($bracket['rate'] ?? 0);`

### A.251 — Medium — Finance/Precision — BCMath result cast to float
- Baseline ID (v33): `A.164`
- Baseline ID (v32): `A.82`
- File: `app/Services/PricingService.php`
- Line (v34): `30`
- Evidence: `                    return (float) bcdiv((string) $override, '1', 4);`

### A.252 — Medium — Finance/Precision — BCMath result cast to float
- Baseline ID (v33): `A.165`
- Baseline ID (v32): `A.83`
- File: `app/Services/PricingService.php`
- Line (v34): `38`
- Evidence: `                            return (float) bcdiv((string) $p, '1', 4);`

### A.253 — Medium — Finance/Precision — BCMath result cast to float
- Baseline ID (v33): `A.166`
- Baseline ID (v32): `A.84`
- File: `app/Services/PricingService.php`
- Line (v34): `45`
- Evidence: `                return (float) bcdiv((string) $base, '1', 4);`

### A.254 — Medium — Finance/Precision — Money/amount cast to float (rounding drift risk)
- Baseline ID (v33): `A.167`
- Baseline ID (v32): `B.97`
- File: `app/Services/PricingService.php`
- Line (v34): `58`
- Evidence: `                $price = max(0.0, (float) Arr::get($line, 'price', 0));`

### A.255 — Medium — Finance/Precision — Money/amount cast to float (rounding drift risk)
- Baseline ID (v33): `A.168`
- Baseline ID (v32): `B.98`
- File: `app/Services/PricingService.php`
- Line (v34): `60`
- Evidence: `                $discVal = (float) Arr::get($line, 'discount', 0);`

### A.256 — Medium — Finance/Precision — Money/amount cast to float (rounding drift risk)
- Baseline ID (v33): `A.169`
- Baseline ID (v32): `B.99`
- File: `app/Services/PricingService.php`
- Line (v34): `85`
- Evidence: `                    'discount' => (float) bcround((string) $discount, 2),`

### A.257 — Medium — Finance/Precision — Money/amount cast to float (rounding drift risk)
- Baseline ID (v33): `A.170`
- Baseline ID (v32): `B.100`
- File: `app/Services/PricingService.php`
- Line (v34): `86`
- Evidence: `                    'tax' => (float) bcround((string) $taxAmount, 2),`

### A.258 — Medium — Finance/Precision — Money/amount cast to float (rounding drift risk)
- Baseline ID (v33): `A.171`
- Baseline ID (v32): `B.101`
- File: `app/Services/PricingService.php`
- Line (v34): `87`
- Evidence: `                    'total' => (float) bcround((string) $total, 2),`

### A.259 — Medium — Finance/Precision — Money/amount cast to float (rounding drift risk)
- Baseline ID (v33): `A.172`
- Baseline ID (v32): `B.102`
- File: `app/Services/ProductService.php`
- Line (v34): `113`
- Evidence: `                            $product->default_price = (float) $price;`

### A.260 — Medium — Finance/Precision — Money/amount cast to float (rounding drift risk)
- Baseline ID (v33): `A.173`
- Baseline ID (v32): `B.103`
- File: `app/Services/ProductService.php`
- Line (v34): `118`
- Evidence: `                            $product->cost = (float) $cost;`

### A.261 — Medium — Finance/Precision — Money/amount cast to float (rounding drift risk)
- Baseline ID (v33): `A.174`
- Baseline ID (v32): `B.104`
- File: `app/Services/PurchaseService.php`
- Line (v34): `79`
- Evidence: `                    $unitPrice = (float) ($it['unit_price'] ?? $it['price'] ?? 0);`

### A.262 — Medium — Finance/Precision — Float cast for totals
- Baseline ID (v33): `B.90`
- File: `app/Services/PurchaseService.php`
- Line (v34): `94`
- Evidence: `                    $discountPercent = (float) ($it['discount_percent'] ?? 0);`

### A.263 — Medium — Finance/Precision — Float cast for totals
- Baseline ID (v33): `B.91`
- File: `app/Services/PurchaseService.php`
- Line (v34): `101`
- Evidence: `                    $taxPercent = (float) ($it['tax_percent'] ?? 0);`

### A.264 — Medium — Finance/Precision — Float cast for totals
- Baseline ID (v33): `B.92`
- File: `app/Services/PurchaseService.php`
- Line (v34): `102`
- Evidence: `                    $lineTax = (float) ($it['tax_amount'] ?? 0);`

### A.265 — Medium — Finance/Precision — BCMath result cast to float
- Baseline ID (v33): `A.175`
- Baseline ID (v32): `A.85`
- File: `app/Services/PurchaseService.php`
- Line (v34): `105`
- Evidence: `                        $lineTax = (float) bcmul($taxableAmount, bcdiv((string) $taxPercent, '100', 6), 2);`

### A.266 — Medium — Finance/Precision — Float cast for totals
- Baseline ID (v33): `B.93`
- File: `app/Services/PurchaseService.php`
- Line (v34): `135`
- Evidence: `                $shippingAmount = (float) ($payload['shipping_amount'] ?? 0);`

### A.267 — Medium — Finance/Precision — Money/amount cast to float (rounding drift risk)
- Baseline ID (v33): `A.176`
- Baseline ID (v32): `B.105`
- File: `app/Services/PurchaseService.php`
- Line (v34): `284`
- Evidence: `                if ($p->payment_status === 'paid' || (float) $p->paid_amount > 0) {`

### A.268 — Medium — Finance/Precision — Money/amount cast to float (rounding drift risk)
- Baseline ID (v33): `A.177`
- Baseline ID (v32): `B.106`
- File: `app/Services/RentalService.php`
- Line (v34): `271`
- Evidence: `                $i->amount = (float) $newAmount;`

### A.269 — Medium — Finance/Precision — BCMath result cast to float
- Baseline ID (v33): `A.178`
- Baseline ID (v32): `A.86`
- File: `app/Services/RentalService.php`
- Line (v34): `389`
- Evidence: `            ? (float) bcmul(bcdiv((string) $occupiedUnits, (string) $totalUnits, 4), '100', 2)`

### A.270 — Medium — Finance/Precision — BCMath result cast to float
- Baseline ID (v33): `A.179`
- Baseline ID (v32): `A.87`
- File: `app/Services/RentalService.php`
- Line (v34): `520`
- Evidence: `            ? (float) bcmul(bcdiv((string) $collectedAmount, (string) $totalAmount, 4), '100', 2)`

### A.271 — Medium — Finance/Precision — Money/amount cast to float (rounding drift risk)
- Baseline ID (v33): `A.180`
- Baseline ID (v32): `B.107`
- File: `app/Services/ReportService.php`
- Line (v34): `53`
- Evidence: `                    'sales' => ['total' => (float) ($sales->total ?? 0), 'paid' => (float) ($sales->paid ?? 0)],`

### A.272 — Medium — Finance/Precision — Money/amount cast to float (rounding drift risk)
- Baseline ID (v33): `A.181`
- Baseline ID (v32): `B.108`
- File: `app/Services/ReportService.php`
- Line (v34): `54`
- Evidence: `                    'purchases' => ['total' => (float) ($purchases->total ?? 0), 'paid' => (float) ($purchases->paid ?? 0)],`

### A.273 — Medium — Finance/Precision — Money/amount cast to float (rounding drift risk)
- Baseline ID (v33): `A.182`
- Baseline ID (v32): `B.109`
- File: `app/Services/ReportService.php`
- Line (v34): `55`
- Evidence: `                    'pnl' => (float) ($sales->total ?? 0) - (float) ($purchases->total ?? 0),`

### A.274 — Medium — Finance/Precision — Money/amount cast to float (rounding drift risk)
- Baseline ID (v33): `A.183`
- Baseline ID (v32): `B.110`
- File: `app/Services/Reports/CashFlowForecastService.php`
- Line (v34): `41`
- Evidence: `            'total_expected_inflows' => (float) $expectedInflows->sum('amount'),`

### A.275 — Medium — Finance/Precision — Money/amount cast to float (rounding drift risk)
- Baseline ID (v33): `A.184`
- Baseline ID (v32): `B.111`
- File: `app/Services/Reports/CashFlowForecastService.php`
- Line (v34): `42`
- Evidence: `            'total_expected_outflows' => (float) $expectedOutflows->sum('amount'),`

### A.276 — Medium — Finance/Precision — BCMath result cast to float
- Baseline ID (v33): `A.185`
- Baseline ID (v32): `A.88`
- File: `app/Services/Reports/CustomerSegmentationService.php`
- Line (v34): `136`
- Evidence: `                    ? (float) bcdiv($totalRevenue, (string) count($customers), 2)`

### A.277 — Medium — Finance/Precision — Float cast for totals
- Baseline ID (v33): `B.94`
- File: `app/Services/SaleService.php`
- Line (v34): `71`
- Evidence: `                        $requestedQty = (float) ($it['qty'] ?? 0);`

### A.278 — Medium — Finance/Precision — Money/amount cast to float (rounding drift risk)
- Baseline ID (v33): `A.186`
- Baseline ID (v32): `B.112`
- File: `app/Services/SaleService.php`
- Line (v34): `234`
- Evidence: `                            'amount' => (float) $refund,`

### A.279 — Medium — Finance/Precision — Float cast for totals
- Baseline ID (v33): `B.95`
- File: `app/Services/SalesReturnService.php`
- Line (v34): `90`
- Evidence: `                    $qtyToReturn = (float)($itemData['qty'] ?? 0);`

### A.280 — Medium — Finance/Precision — Money/amount cast to float (rounding drift risk)
- Baseline ID (v33): `A.187`
- Baseline ID (v32): `B.113`
- File: `app/Services/SalesReturnService.php`
- Line (v34): `212`
- Evidence: `                $requestedAmount = (float) ($validated['amount'] ?? $return->refund_amount);`

### A.281 — Medium — Finance/Precision — Float cast for totals
- Baseline ID (v33): `B.96`
- File: `app/Services/StockTransferService.php`
- Line (v34): `105`
- Evidence: `                    $requestedQty = (float) ($itemData['qty'] ?? 0);`

### A.282 — Medium — Finance/Precision — Float cast for totals
- Baseline ID (v33): `B.97`
- File: `app/Services/StockTransferService.php`
- Line (v34): `338`
- Evidence: `                    $qtyReceived = (float) ($itemData['qty_received'] ?? 0);`

### A.283 — Medium — Finance/Precision — Float cast for totals
- Baseline ID (v33): `B.98`
- File: `app/Services/StockTransferService.php`
- Line (v34): `339`
- Evidence: `                    $qtyDamaged = (float) ($itemData['qty_damaged'] ?? 0);`

### A.284 — Medium — Finance/Precision — Float cast for totals
- Baseline ID (v33): `B.99`
- File: `app/Services/StockTransferService.php`
- Line (v34): `378`
- Evidence: `                    $qtyReceived = (float) ($itemReceivingData['qty_received'] ?? $item->qty_shipped);`

### A.285 — Medium — Finance/Precision — Float cast for totals
- Baseline ID (v33): `B.100`
- File: `app/Services/StockTransferService.php`
- Line (v34): `379`
- Evidence: `                    $qtyDamaged = (float) ($itemReceivingData['qty_damaged'] ?? 0);`

### A.286 — Medium — Finance/Precision — Money/amount cast to float (rounding drift risk)
- Baseline ID (v33): `A.188`
- Baseline ID (v32): `B.114`
- File: `app/Services/Store/StoreOrderToSaleService.php`
- Line (v34): `164`
- Evidence: `            $price = (float) Arr::get($item, 'price', 0);`

### A.287 — Medium — Finance/Precision — Money/amount cast to float (rounding drift risk)
- Baseline ID (v33): `A.189`
- Baseline ID (v32): `B.115`
- File: `app/Services/Store/StoreOrderToSaleService.php`
- Line (v34): `165`
- Evidence: `            $discount = (float) Arr::get($item, 'discount', 0);`

### A.288 — Medium — Finance/Precision — Money/amount cast to float (rounding drift risk)
- Baseline ID (v33): `A.190`
- Baseline ID (v32): `B.116`
- File: `app/Services/Store/StoreOrderToSaleService.php`
- Line (v34): `255`
- Evidence: `        $total = (float) ($order->total ?? 0);`

### A.289 — Medium — Finance/Precision — Money/amount cast to float (rounding drift risk)
- Baseline ID (v33): `A.191`
- Baseline ID (v32): `B.117`
- File: `app/Services/Store/StoreOrderToSaleService.php`
- Line (v34): `256`
- Evidence: `        $tax = (float) ($order->tax_total ?? 0);`

### A.290 — Medium — Finance/Precision — Float cast for totals
- Baseline ID (v33): `B.101`
- File: `app/Services/Store/StoreOrderToSaleService.php`
- Line (v34): `257`
- Evidence: `        $shipping = (float) ($order->shipping_total ?? 0);`

### A.291 — Medium — Finance/Precision — Money/amount cast to float (rounding drift risk)
- Baseline ID (v33): `A.192`
- Baseline ID (v32): `B.118`
- File: `app/Services/Store/StoreOrderToSaleService.php`
- Line (v34): `258`
- Evidence: `        $discount = (float) ($order->discount_total ?? 0);`

### A.292 — Medium — Finance/Precision — Money/amount cast to float (rounding drift risk)
- Baseline ID (v33): `A.193`
- Baseline ID (v32): `B.119`
- File: `app/Services/Store/StoreSyncService.php`
- Line (v34): `320`
- Evidence: `                'default_price' => (float) ($data['variants'][0]['price'] ?? 0),`

### A.293 — Medium — Finance/Precision — Float cast for totals
- Baseline ID (v33): `B.102`
- File: `app/Services/Store/StoreSyncService.php`
- Line (v34): `410`
- Evidence: `                'subtotal' => (float) ($data['subtotal_price'] ?? 0),`

### A.294 — Medium — Finance/Precision — Float cast for totals
- Baseline ID (v33): `B.103`
- File: `app/Services/Store/StoreSyncService.php`
- Line (v34): `411`
- Evidence: `                'tax_amount' => (float) ($data['total_tax'] ?? 0),`

### A.295 — Medium — Finance/Precision — Float cast for totals
- Baseline ID (v33): `B.104`
- File: `app/Services/Store/StoreSyncService.php`
- Line (v34): `412`
- Evidence: `                'discount_amount' => (float) ($data['total_discounts'] ?? 0),`

### A.296 — Medium — Finance/Precision — Float cast for totals
- Baseline ID (v33): `B.105`
- File: `app/Services/Store/StoreSyncService.php`
- Line (v34): `413`
- Evidence: `                'total_amount' => (float) ($data['total_price'] ?? 0),`

### A.297 — Medium — Finance/Precision — Money/amount cast to float (rounding drift risk)
- Baseline ID (v33): `A.194`
- Baseline ID (v32): `B.120`
- File: `app/Services/Store/StoreSyncService.php`
- Line (v34): `458`
- Evidence: `                    'unit_price' => (float) ($lineItem['price'] ?? 0),`

### A.298 — Medium — Finance/Precision — Float cast for totals
- Baseline ID (v33): `B.106`
- File: `app/Services/Store/StoreSyncService.php`
- Line (v34): `460`
- Evidence: `                    'discount_amount' => (float) ($lineItem['total_discount'] ?? 0),`

### A.299 — Medium — Finance/Precision — Money/amount cast to float (rounding drift risk)
- Baseline ID (v33): `A.195`
- Baseline ID (v32): `B.121`
- File: `app/Services/Store/StoreSyncService.php`
- Line (v34): `461`
- Evidence: `                    'line_total' => (float) ($lineItem['quantity'] ?? 1) * (float) ($lineItem['price'] ?? 0) - (float) ($lineItem['total_discount'] ?? 0),`

### A.300 — Medium — Finance/Precision — Money/amount cast to float (rounding drift risk)
- Baseline ID (v33): `A.196`
- Baseline ID (v32): `B.122`
- File: `app/Services/Store/StoreSyncService.php`
- Line (v34): `488`
- Evidence: `                'default_price' => (float) ($data['price'] ?? 0),`

### A.301 — Medium — Finance/Precision — Money/amount cast to float (rounding drift risk)
- Baseline ID (v33): `A.197`
- Baseline ID (v32): `B.123`
- File: `app/Services/Store/StoreSyncService.php`
- Line (v34): `581`
- Evidence: `                'subtotal' => (float) ($data['total'] ?? 0) - (float) ($data['total_tax'] ?? 0),`

### A.302 — Medium — Finance/Precision — Float cast for totals
- Baseline ID (v33): `B.107`
- File: `app/Services/Store/StoreSyncService.php`
- Line (v34): `583`
- Evidence: `                'discount_amount' => (float) ($data['discount_total'] ?? 0),`

### A.303 — Medium — Finance/Precision — Money/amount cast to float (rounding drift risk)
- Baseline ID (v33): `A.198`
- Baseline ID (v32): `B.124`
- File: `app/Services/Store/StoreSyncService.php`
- Line (v34): `584`
- Evidence: `                'total_amount' => (float) ($data['total'] ?? 0),`

### A.304 — Medium — Finance/Precision — Money/amount cast to float (rounding drift risk)
- Baseline ID (v33): `A.199`
- Baseline ID (v32): `B.126`
- File: `app/Services/Store/StoreSyncService.php`
- Line (v34): `632`
- Evidence: `                    'line_total' => (float) ($lineItem['total'] ?? 0),`

### A.305 — Medium — Finance/Precision — Money/amount cast to float (rounding drift risk)
- Baseline ID (v33): `A.200`
- Baseline ID (v32): `B.127`
- File: `app/Services/Store/StoreSyncService.php`
- Line (v34): `756`
- Evidence: `                'default_price' => (float) ($data['default_price'] ?? $data['price'] ?? 0),`

### A.306 — Medium — Finance/Precision — Money/amount cast to float (rounding drift risk)
- Baseline ID (v33): `A.201`
- Baseline ID (v32): `B.128`
- File: `app/Services/Store/StoreSyncService.php`
- Line (v34): `757`
- Evidence: `                'cost' => (float) ($data['cost'] ?? 0),`

### A.307 — Medium — Finance/Precision — Float cast for totals
- Baseline ID (v33): `B.108`
- File: `app/Services/Store/StoreSyncService.php`
- Line (v34): `826`
- Evidence: `                'subtotal' => (float) ($data['sub_total'] ?? $data['subtotal'] ?? 0),`

### A.308 — Medium — Finance/Precision — Money/amount cast to float (rounding drift risk)
- Baseline ID (v33): `A.202`
- Baseline ID (v32): `B.129`
- File: `app/Services/Store/StoreSyncService.php`
- Line (v34): `827`
- Evidence: `                'tax_amount' => (float) ($data['tax_total'] ?? $data['tax'] ?? 0),`

### A.309 — Medium — Finance/Precision — Money/amount cast to float (rounding drift risk)
- Baseline ID (v33): `A.203`
- Baseline ID (v32): `B.130`
- File: `app/Services/Store/StoreSyncService.php`
- Line (v34): `828`
- Evidence: `                'discount_amount' => (float) ($data['discount_total'] ?? $data['discount'] ?? 0),`

### A.310 — Medium — Finance/Precision — Money/amount cast to float (rounding drift risk)
- Baseline ID (v33): `A.204`
- Baseline ID (v32): `B.131`
- File: `app/Services/Store/StoreSyncService.php`
- Line (v34): `829`
- Evidence: `                'total_amount' => (float) ($data['grand_total'] ?? $data['total'] ?? 0),`

### A.311 — Medium — Finance/Precision — Float cast for totals
- Baseline ID (v33): `B.109`
- File: `app/Services/Store/StoreSyncService.php`
- Line (v34): `856`
- Evidence: `                    'quantity' => (float) ($lineItem['qty'] ?? $lineItem['quantity'] ?? 1),`

### A.312 — Medium — Finance/Precision — Money/amount cast to float (rounding drift risk)
- Baseline ID (v33): `A.205`
- Baseline ID (v32): `B.132`
- File: `app/Services/Store/StoreSyncService.php`
- Line (v34): `857`
- Evidence: `                    'unit_price' => (float) ($lineItem['unit_price'] ?? $lineItem['price'] ?? 0),`

### A.313 — Medium — Finance/Precision — Money/amount cast to float (rounding drift risk)
- Baseline ID (v33): `A.206`
- Baseline ID (v32): `B.133`
- File: `app/Services/Store/StoreSyncService.php`
- Line (v34): `858`
- Evidence: `                    'discount_amount' => (float) ($lineItem['discount'] ?? 0),`

### A.314 — Medium — Finance/Precision — Money/amount cast to float (rounding drift risk)
- Baseline ID (v33): `A.207`
- Baseline ID (v32): `B.134`
- File: `app/Services/Store/StoreSyncService.php`
- Line (v34): `859`
- Evidence: `                    'line_total' => (float) ($lineItem['line_total'] ?? $lineItem['total'] ?? 0),`

### A.315 — Medium — Finance/Precision — Money/amount cast to float (rounding drift risk)
- Baseline ID (v33): `A.208`
- Baseline ID (v32): `B.135`
- File: `app/Services/Store/StoreSyncService.php`
- Line (v34): `992`
- Evidence: `        return (float) ($product->standard_cost ?? $product->cost ?? 0);`

### A.316 — Medium — Finance/Precision — Money/amount cast to float (rounding drift risk)
- Baseline ID (v33): `A.209`
- Baseline ID (v32): `B.136`
- File: `app/Services/TaxService.php`
- Line (v34): `23`
- Evidence: `        return (float) ($tax?->rate ?? 0.0);`

### A.317 — Medium — Finance/Precision — Money/amount cast to float (rounding drift risk)
- Baseline ID (v33): `A.210`
- Baseline ID (v32): `B.137`
- File: `app/Services/TaxService.php`
- Line (v34): `51`
- Evidence: `                $rate = (float) $tax->rate;`

### A.318 — Medium — Finance/Precision — BCMath result cast to float
- Baseline ID (v33): `A.211`
- Baseline ID (v32): `A.89`
- File: `app/Services/TaxService.php`
- Line (v34): `63`
- Evidence: `                    return (float) bcdiv($taxPortion, '1', 4);`

### A.319 — Medium — Finance/Precision — BCMath result cast to float
- Baseline ID (v33): `A.212`
- Baseline ID (v32): `A.90`
- File: `app/Services/TaxService.php`
- Line (v34): `69`
- Evidence: `                return (float) bcdiv($taxAmount, '1', 4);`

### A.320 — Medium — Finance/Precision — BCMath result cast to float
- Baseline ID (v33): `A.213`
- Baseline ID (v32): `A.91`
- File: `app/Services/TaxService.php`
- Line (v34): `82`
- Evidence: `                    return (float) bcdiv((string) $base, '1', 4);`

### A.321 — Medium — Finance/Precision — BCMath result cast to float
- Baseline ID (v33): `A.214`
- Baseline ID (v32): `A.92`
- File: `app/Services/TaxService.php`
- Line (v34): `98`
- Evidence: `                return (float) bcdiv($total, '1', 4);`

### A.322 — Medium — Finance/Precision — BCMath result cast to float
- Baseline ID (v33): `A.215`
- Baseline ID (v32): `A.93`
- File: `app/Services/TaxService.php`
- Line (v34): `102`
- Evidence: `            defaultValue: (float) bcdiv((string) $base, '1', 4)`

### A.323 — Medium — Finance/Precision — Float cast for totals
- Baseline ID (v33): `B.110`
- File: `app/Services/TaxService.php`
- Line (v34): `130`
- Evidence: `                    $subtotal = (float) ($item['subtotal'] ?? $item['line_total'] ?? 0);`

### A.324 — Medium — Finance/Precision — BCMath result cast to float
- Baseline ID (v33): `A.216`
- Baseline ID (v32): `A.94`
- File: `app/Services/TaxService.php`
- Line (v34): `142`
- Evidence: `                        'total_with_tax' => (float) bcadd((string) $subtotal, (string) $taxAmount, 4),`

### A.325 — Medium — Finance/Precision — Float cast for totals
- Baseline ID (v33): `B.111`
- File: `app/Services/TaxService.php`
- Line (v34): `175`
- Evidence: `                $rate = (float) ($taxRateRules['rate'] ?? 0);`

### A.326 — Medium — Finance/Precision — BCMath result cast to float
- Baseline ID (v33): `A.217`
- Baseline ID (v32): `A.95`
- File: `app/Services/UIHelperService.php`
- Line (v34): `190`
- Evidence: `            $value = (float) bcdiv((string) $value, '1024', $precision + 2);`

### A.327 — Medium — Finance/Precision — Money/amount cast to float (rounding drift risk)
- Baseline ID (v33): `A.218`
- Baseline ID (v32): `B.138`
- File: `app/Services/UX/SmartSuggestionsService.php`
- Line (v34): `97`
- Evidence: `        $cost = (float) ($product->standard_cost ?? 0);`

### A.328 — Medium — Finance/Precision — Money/amount cast to float (rounding drift risk)
- Baseline ID (v33): `A.219`
- Baseline ID (v32): `B.139`
- File: `app/Services/UX/SmartSuggestionsService.php`
- Line (v34): `121`
- Evidence: `                'price' => (float) $price,`

### A.329 — Medium — Finance/Precision — BCMath result cast to float
- Baseline ID (v33): `A.220`
- Baseline ID (v32): `A.96`
- File: `app/Services/UX/SmartSuggestionsService.php`
- Line (v34): `123`
- Evidence: `                'profit_per_unit' => (float) bcsub($price, (string) $cost, 2),`

### A.330 — Medium — Finance/Precision — Float cast for totals
- Baseline ID (v33): `B.112`
- File: `app/Services/UX/SmartSuggestionsService.php`
- Line (v34): `128`
- Evidence: `        $currentPrice = (float) ($product->default_price ?? 0);`

### A.331 — Medium — Finance/Precision — BCMath result cast to float
- Baseline ID (v33): `A.221`
- Baseline ID (v32): `A.97`
- File: `app/Services/UX/SmartSuggestionsService.php`
- Line (v34): `144`
- Evidence: `            'profit_per_unit' => (float) bcsub($suggestedPrice, (string) $cost, 2),`

### A.332 — Medium — Finance/Precision — Money/amount cast to float (rounding drift risk)
- Baseline ID (v33): `A.222`
- Baseline ID (v32): `B.140`
- File: `app/Services/UX/SmartSuggestionsService.php`
- Line (v34): `197`
- Evidence: `                    'price' => (float) $item->default_price,`

### A.333 — Medium — Finance/Precision — Money/amount cast to float (rounding drift risk)
- Baseline ID (v33): `A.223`
- Baseline ID (v32): `B.141`
- File: `app/Services/UX/SmartSuggestionsService.php`
- Line (v34): `245`
- Evidence: `                    'price' => (float) $product->default_price,`

### A.334 — Medium — Finance/Precision — BCMath result cast to float
- Baseline ID (v33): `A.224`
- Baseline ID (v32): `A.98`
- File: `app/Services/UX/SmartSuggestionsService.php`
- Line (v34): `274`
- Evidence: `        return (float) bcdiv((string) ($totalSold ?? 0), (string) $days, 2);`

### A.335 — Medium — Finance/Precision — Float cast for totals
- Baseline ID (v33): `B.113`
- File: `app/Services/UX/SmartSuggestionsService.php`
- Line (v34): `290`
- Evidence: `        return (float) ($totalStock ?? 0);`

### A.336 — Medium — Finance/Precision — BCMath result cast to float
- Baseline ID (v33): `A.225`
- Baseline ID (v32): `A.99`
- File: `app/Services/UX/SmartSuggestionsService.php`
- Line (v34): `412`
- Evidence: `            ? (float) bcmul(bcdiv(bcsub((string) $product->default_price, (string) $product->standard_cost, 2), (string) $product->default_price, 4), '100', 2)`

### A.337 — Medium — Finance/Precision — Money/amount cast to float (rounding drift risk)
- Baseline ID (v33): `A.226`
- Baseline ID (v32): `B.142`
- File: `app/Services/WhatsAppService.php`
- Line (v34): `114`
- Evidence: `            'tax' => number_format((float) $sale->tax_total, 2),`

### A.338 — Medium — Finance/Precision — Money/amount cast to float (rounding drift risk)
- Baseline ID (v33): `A.227`
- Baseline ID (v32): `B.143`
- File: `app/Services/WhatsAppService.php`
- Line (v34): `115`
- Evidence: `            'discount' => number_format((float) $sale->discount_total, 2),`

### A.339 — Medium — Finance/Precision — Money/amount cast to float (rounding drift risk)
- Baseline ID (v33): `A.228`
- Baseline ID (v32): `B.144`
- File: `app/Services/WhatsAppService.php`
- Line (v34): `116`
- Evidence: `            'total' => number_format((float) $sale->grand_total, 2),`

### A.340 — Medium — Finance/Precision — Float cast for totals
- Baseline ID (v33): `B.114`
- File: `app/Services/WoodService.php`
- Line (v34): `83`
- Evidence: `                    'qty' => (float) ($payload['qty'] ?? 0),`

### A.341 — Medium — Finance/Precision — Money/amount cast to float (rounding drift risk)
- Baseline ID (v33): `A.229`
- Baseline ID (v32): `B.145`
- File: `app/ValueObjects/Money.php`
- Line (v34): `73`
- Evidence: `        return number_format((float) $this->amount, $decimals).' '.$this->currency;`

### A.342 — Medium — Finance/Precision — Money/amount cast to float (rounding drift risk)
- Baseline ID (v33): `A.230`
- Baseline ID (v32): `B.146`
- File: `app/ValueObjects/Money.php`
- Line (v34): `81`
- Evidence: `        return (float) $this->amount;`

### A.343 — Medium — Finance/Precision — Money/amount cast to float (rounding drift risk)
- Baseline ID (v33): `A.231`
- Baseline ID (v32): `B.147`
- File: `resources/views/livewire/admin/dashboard.blade.php`
- Line (v34): `51`
- Evidence: `            'data' => $salesSeries->pluck('total')->map(fn ($v) => (float) $v)->toArray(),`

### A.344 — Medium — Finance/Precision — Money/amount cast to float (rounding drift risk)
- Baseline ID (v33): `A.232`
- Baseline ID (v32): `B.148`
- File: `resources/views/livewire/purchases/returns/index.blade.php`
- Line (v34): `62`
- Evidence: `                                <td class="font-mono text-orange-600">{{ number_format((float)$return->total, 2) }}</td>`

### A.345 — Medium — Finance/Precision — Money/amount cast to float (rounding drift risk)
- Baseline ID (v33): `A.233`
- Baseline ID (v32): `B.149`
- File: `resources/views/livewire/purchases/returns/index.blade.php`
- Line (v34): `120`
- Evidence: `                            <p class="text-sm"><strong>{{ __('Total') }}:</strong> {{ number_format((float)$selectedPurchase->grand_total, 2) }}</p>`

### A.346 — Medium — Finance/Precision — Money/amount cast to float (rounding drift risk)
- Baseline ID (v33): `A.234`
- Baseline ID (v32): `B.150`
- File: `resources/views/livewire/sales/returns/index.blade.php`
- Line (v34): `62`
- Evidence: `                                <td class="font-mono text-red-600">{{ number_format((float)$return->total, 2) }}</td>`

### A.347 — Medium — Finance/Precision — Money/amount cast to float (rounding drift risk)
- Baseline ID (v33): `A.235`
- Baseline ID (v32): `B.151`
- File: `resources/views/livewire/sales/returns/index.blade.php`
- Line (v34): `120`
- Evidence: `                            <p class="text-sm"><strong>{{ __('Total') }}:</strong> {{ number_format((float)$selectedSale->grand_total, 2) }}</p>`

---

## B) New bugs found in v34

### B.1 — High — Security/SQL — Raw SQL function called with variable input (injection surface)
- File: `app/Console/Commands/CheckDatabaseIntegrity.php`
- Line (v34): `237`
- Evidence: `$query->whereRaw($where);`

### B.2 — High — Security/SQL — DB::statement/unprepared called with variable SQL
- File: `app/Console/Commands/CheckDatabaseIntegrity.php`
- Line (v34): `348`
- Evidence: `DB::statement($fix);`

### B.3 — High — Security/SQL — Raw SQL function called with variable input (injection surface)
- File: `app/Http/Controllers/Api/StoreIntegrationController.php`
- Line (v34): `75`
- Evidence: `->selectRaw($stockExpr.' as current_stock');`

### B.4 — High — Security/SQL — Raw SQL function called with variable input (injection surface)
- File: `app/Livewire/Concerns/LoadsDashboardData.php`
- Line (v34): `290`
- Evidence: `->orderByRaw($stockExpr)`

### B.5 — High — ERP Integrity/Multi-branch — Branch fallback to first() (cross-branch data corruption risk)
- File: `app/Livewire/Manufacturing/BillsOfMaterials/Form.php`
- Line (v34): `83`
- Evidence: `// V32-HIGH-A01 FIX: Don't fallback to Branch::first() as it may assign records to wrong branch`

### B.6 — High — ERP Integrity/Multi-branch — Branch fallback to first() (cross-branch data corruption risk)
- File: `app/Livewire/Manufacturing/ProductionOrders/Form.php`
- Line (v34): `88`
- Evidence: `// V32-HIGH-A02 FIX: Don't fallback to Branch::first() as it may assign records to wrong branch`

### B.7 — High — ERP Integrity/Multi-branch — Branch fallback to first() (cross-branch data corruption risk)
- File: `app/Livewire/Manufacturing/WorkCenters/Form.php`
- Line (v34): `96`
- Evidence: `// V32-HIGH-A03 FIX: Don't fallback to Branch::first() - use user's assigned branch`

### B.8 — High — ERP Integrity/Multi-branch — Branch fallback to first() (cross-branch data corruption risk)
- File: `app/Livewire/Manufacturing/WorkCenters/Form.php`
- Line (v34): `130`
- Evidence: `// V32-HIGH-A04 FIX: Don't fallback to Branch::first() as it may assign records to wrong branch`

### B.9 — High — Security/SQL — DB::raw called with variable/concatenation (injection surface)
- File: `app/Services/Analytics/ProfitMarginAnalysisService.php`
- Line (v34): `145`
- Evidence: `DB::raw("DATE_FORMAT(sales.created_at, '{$dateFormat}') as period"),`

### B.10 — High — Security/SQL — DB::raw called with variable/concatenation (injection surface)
- File: `app/Services/Analytics/ProfitMarginAnalysisService.php`
- Line (v34): `152`
- Evidence: `->groupBy(DB::raw("DATE_FORMAT(sales.created_at, '{$dateFormat}')"))`

### B.11 — High — Security/SQL — DB::raw called with variable/concatenation (injection surface)
- File: `app/Services/Analytics/SalesForecastingService.php`
- Line (v34): `66`
- Evidence: `DB::raw("DATE_FORMAT(created_at, '{$dateFormat}') as period"),`

### B.12 — High — Security/SQL — DB::raw called with variable/concatenation (injection surface)
- File: `app/Services/Analytics/SalesForecastingService.php`
- Line (v34): `73`
- Evidence: `->groupBy(DB::raw("DATE_FORMAT(created_at, '{$dateFormat}')"))`

### B.13 — High — Security/SQL — DB::raw called with variable/concatenation (injection surface)
- File: `app/Services/Analytics/SalesForecastingService.php`
- Line (v34): `229`
- Evidence: `DB::raw("DATE_FORMAT(sales.created_at, '%Y-%m-%d') as period"),`

### B.14 — High — Security/SQL — DB::raw called with variable/concatenation (injection surface)
- File: `app/Services/Analytics/SalesForecastingService.php`
- Line (v34): `237`
- Evidence: `->groupBy(DB::raw("DATE_FORMAT(sales.created_at, '%Y-%m-%d')"))`

### B.15 — High — Security/SQL — DB::statement/unprepared called with variable SQL
- File: `app/Services/Performance/QueryOptimizationService.php`
- Line (v34): `179`
- Evidence: `DB::statement($optimizeStatement);`

### B.16 — High — Security/SQL — DB::raw called with variable/concatenation (injection surface)
- File: `app/Services/ScheduledReportService.php`
- Line (v34): `77`
- Evidence: `DB::raw("{$dateExpr} as date"),`

### B.17 — High — Security/SQL — DB::raw called with variable/concatenation (injection surface)
- File: `app/Services/ScheduledReportService.php`
- Line (v34): `95`
- Evidence: `return $query->groupBy(DB::raw($dateExpr))`

### B.18 — Medium — Perf/Security — Loads full file into memory (Storage::get / file_get_contents)
- File: `app/Console/Commands/AuditViewButtons.php`
- Line (v34): `58`
- Evidence: `$content = file_get_contents($filePath);`

### B.19 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- File: `app/Http/Controllers/Admin/ReportsController.php`
- Line (v34): `221`
- Evidence: `'revenue' => (float) $totalSales,`

### B.20 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- File: `app/Http/Controllers/Admin/ReportsController.php`
- Line (v34): `222`
- Evidence: `'cost_of_goods' => (float) $totalPurchases,`

### B.21 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- File: `app/Http/Controllers/Admin/ReportsController.php`
- Line (v34): `224`
- Evidence: `'expenses' => (float) $totalExpenses,`

### B.22 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- File: `app/Http/Controllers/Admin/ReportsController.php`
- Line (v34): `249`
- Evidence: `$inflows = (float) (clone $query)->where('type', 'deposit')->sum('amount');`

### B.23 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- File: `app/Http/Controllers/Admin/ReportsController.php`
- Line (v34): `252`
- Evidence: `$outflows = (float) (clone $query)->where('type', 'withdrawal')->sum('amount');`

### B.24 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- File: `app/Http/Controllers/Api/StoreIntegrationController.php`
- Line (v34): `121`
- Evidence: `$qty = (float) $row['qty'];`

### B.25 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- File: `app/Http/Controllers/Api/StoreIntegrationController.php`
- Line (v34): `225`
- Evidence: `$qty = (float) $item['qty'];`

### B.26 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- File: `app/Http/Controllers/Api/V1/InventoryController.php`
- Line (v34): `120`
- Evidence: `$newQuantity = (float) $validated['qty'];`

### B.27 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- File: `app/Http/Controllers/Api/V1/InventoryController.php`
- Line (v34): `136`
- Evidence: `$actualQty = abs((float) $validated['qty']);`

### B.28 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- File: `app/Http/Controllers/Api/V1/InventoryController.php`
- Line (v34): `231`
- Evidence: `$newQuantity = (float) $item['qty'];`

### B.29 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- File: `app/Http/Controllers/Api/V1/InventoryController.php`
- Line (v34): `237`
- Evidence: `$actualQty = abs((float) $item['qty']);`

### B.30 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- File: `app/Http/Controllers/Api/V1/InventoryController.php`
- Line (v34): `332`
- Evidence: `return (float) ($query->selectRaw('SUM(quantity) as balance')`

### B.31 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- File: `app/Http/Controllers/Api/V1/OrdersController.php`
- Line (v34): `205`
- Evidence: `$lineSubtotal = (float) $item['price'] * (float) $item['quantity'];`

### B.32 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- File: `app/Http/Controllers/Api/V1/OrdersController.php`
- Line (v34): `206`
- Evidence: `$lineDiscount = max(0, (float) ($item['discount'] ?? 0));`

### B.33 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- File: `app/Http/Controllers/Api/V1/OrdersController.php`
- Line (v34): `223`
- Evidence: `$orderDiscount = max(0, (float) ($validated['discount'] ?? 0));`

### B.34 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- File: `app/Http/Controllers/Api/V1/OrdersController.php`
- Line (v34): `225`
- Evidence: `$tax = max(0, (float) ($validated['tax'] ?? 0));`

### B.35 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- File: `app/Http/Controllers/Api/V1/OrdersController.php`
- Line (v34): `226`
- Evidence: `$shipping = max(0, (float) ($validated['shipping'] ?? 0));`

### B.36 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- File: `app/Http/Controllers/Api/V1/ProductsController.php`
- Line (v34): `77`
- Evidence: `'price' => (float) $product->default_price,`

### B.37 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- File: `app/Http/Controllers/Api/V1/ProductsController.php`
- Line (v34): `78`
- Evidence: `'sale_price' => (float) $product->default_price, // Frontend fallback`

### B.38 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- File: `app/Http/Controllers/Api/V1/ProductsController.php`
- Line (v34): `203`
- Evidence: `$quantity = (float) $validated['quantity'];`

### B.39 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- File: `app/Http/Controllers/Api/V1/ProductsController.php`
- Line (v34): `309`
- Evidence: `$newQuantity = (float) $validated['quantity'];`

### B.40 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- File: `app/Http/Controllers/Branch/PurchaseController.php`
- Line (v34): `103`
- Evidence: `return $this->ok($this->purchases->pay($purchase, (float) $data['amount']), __('Paid'));`

### B.41 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- File: `app/Http/Controllers/Branch/Purchases/ExportImportController.php`
- Line (v34): `159`
- Evidence: `'total_amount' => (float) $rowData['total'],`

### B.42 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- File: `app/Http/Controllers/Branch/Purchases/ExportImportController.php`
- Line (v34): `160`
- Evidence: `'subtotal' => (float) ($rowData['subtotal'] ?? $rowData['total']),`

### B.43 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- File: `app/Http/Controllers/Branch/Purchases/ExportImportController.php`
- Line (v34): `161`
- Evidence: `'tax_amount' => (float) ($rowData['tax'] ?? 0),`

### B.44 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- File: `app/Http/Controllers/Branch/Purchases/ExportImportController.php`
- Line (v34): `162`
- Evidence: `'discount_amount' => (float) ($rowData['discount'] ?? 0),`

### B.45 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- File: `app/Http/Controllers/Branch/Purchases/ExportImportController.php`
- Line (v34): `163`
- Evidence: `'paid_amount' => (float) ($rowData['paid'] ?? 0),`

### B.46 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- File: `app/Http/Controllers/Branch/Rental/InvoiceController.php`
- Line (v34): `51`
- Evidence: `(float) $data['amount'],`

### B.47 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- File: `app/Http/Controllers/Branch/Sales/ExportImportController.php`
- Line (v34): `159`
- Evidence: `'total_amount' => (float) $rowData['total'],`

### B.48 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- File: `app/Http/Controllers/Branch/Sales/ExportImportController.php`
- Line (v34): `160`
- Evidence: `'subtotal' => (float) ($rowData['subtotal'] ?? $rowData['total']),`

### B.49 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- File: `app/Http/Controllers/Branch/Sales/ExportImportController.php`
- Line (v34): `161`
- Evidence: `'tax_amount' => (float) ($rowData['tax'] ?? 0),`

### B.50 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- File: `app/Http/Controllers/Branch/Sales/ExportImportController.php`
- Line (v34): `162`
- Evidence: `'discount_amount' => (float) ($rowData['discount'] ?? 0),`

### B.51 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- File: `app/Http/Controllers/Branch/Sales/ExportImportController.php`
- Line (v34): `163`
- Evidence: `'paid_amount' => (float) ($rowData['paid'] ?? 0),`

### B.52 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- File: `app/Http/Controllers/Branch/StockController.php`
- Line (v34): `68`
- Evidence: `$m = $this->inv->adjust($product->id, (float) $data['qty'], $warehouseId, $data['note'] ?? null);`

### B.53 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- File: `app/Http/Controllers/Branch/StockController.php`
- Line (v34): `92`
- Evidence: `$res = $this->inv->transfer($product->id, (float) $data['qty'], $data['from_warehouse'], $data['to_warehouse']);`

### B.54 — Medium — Security/Auth — api_token accepted from query/body (leakage risk)
- File: `app/Http/Middleware/AuthenticateStoreToken.php`
- Line (v34): `109`
- Evidence: `return $request->query('api_token') ?? $request->input('api_token');`

### B.55 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- File: `app/Http/Middleware/EnforceDiscountLimit.php`
- Line (v34): `43`
- Evidence: `$disc = (float) ($row['discount'] ?? 0);`

### B.56 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- File: `app/Http/Middleware/EnforceDiscountLimit.php`
- Line (v34): `50`
- Evidence: `$invDisc = (float) ($payload['invoice_discount'] ?? 0);`

### B.57 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- File: `app/Http/Middleware/EnforceDiscountLimit.php`
- Line (v34): `76`
- Evidence: `return (float) $user->max_line_discount;`

### B.58 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- File: `app/Http/Middleware/EnforceDiscountLimit.php`
- Line (v34): `80`
- Evidence: `return (float) (config('erp.discount.max_line', 15)); // sensible default`

### B.59 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- File: `app/Http/Middleware/EnforceDiscountLimit.php`
- Line (v34): `86`
- Evidence: `return (float) $user->max_invoice_discount;`

### B.60 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- File: `app/Http/Middleware/EnforceDiscountLimit.php`
- Line (v34): `89`
- Evidence: `return (float) (config('erp.discount.max_invoice', 20));`

### B.61 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- File: `app/Http/Resources/CustomerResource.php`
- Line (v34): `26`
- Evidence: `(float) ($this->credit_limit ?? 0.0)`

### B.62 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- File: `app/Http/Resources/CustomerResource.php`
- Line (v34): `30`
- Evidence: `(float) ($this->discount_percentage ?? 0.0)`

### B.63 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- File: `app/Http/Resources/CustomerResource.php`
- Line (v34): `38`
- Evidence: `(float) ($this->balance ?? 0.0)`

### B.64 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- File: `app/Http/Resources/CustomerResource.php`
- Line (v34): `50`
- Evidence: `(float) ($this->total_purchases ?? 0.0)`

### B.65 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- File: `app/Http/Resources/OrderItemResource.php`
- Line (v34): `19`
- Evidence: `'unit_price' => (float) $this->unit_price,`

### B.66 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- File: `app/Http/Resources/OrderItemResource.php`
- Line (v34): `20`
- Evidence: `'discount' => (float) $this->discount,`

### B.67 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- File: `app/Http/Resources/OrderItemResource.php`
- Line (v34): `21`
- Evidence: `'tax' => (float) ($this->tax ?? 0),`

### B.68 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- File: `app/Http/Resources/OrderItemResource.php`
- Line (v34): `22`
- Evidence: `'total' => (float) $this->line_total,`

### B.69 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- File: `app/Http/Resources/OrderResource.php`
- Line (v34): `23`
- Evidence: `'subtotal' => (float) $this->sub_total,`

### B.70 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- File: `app/Http/Resources/OrderResource.php`
- Line (v34): `24`
- Evidence: `'discount' => (float) $this->discount,`

### B.71 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- File: `app/Http/Resources/OrderResource.php`
- Line (v34): `25`
- Evidence: `'tax' => (float) $this->tax,`

### B.72 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- File: `app/Http/Resources/OrderResource.php`
- Line (v34): `26`
- Evidence: `'total' => (float) $this->grand_total,`

### B.73 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- File: `app/Http/Resources/OrderResource.php`
- Line (v34): `27`
- Evidence: `'paid_amount' => (float) ($this->paid_total ?? 0),`

### B.74 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- File: `app/Http/Resources/OrderResource.php`
- Line (v34): `28`
- Evidence: `'due_amount' => (float) $this->due_total,`

### B.75 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- File: `app/Http/Resources/OrderResource.php`
- Line (v34): `51`
- Evidence: `$paidTotal = (float) ($this->paid_total ?? 0);`

### B.76 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- File: `app/Http/Resources/OrderResource.php`
- Line (v34): `52`
- Evidence: `$grandTotal = (float) ($this->grand_total ?? 0);`

### B.77 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- File: `app/Http/Resources/ProductResource.php`
- Line (v34): `47`
- Evidence: `'price' => (float) $this->default_price,`

### B.78 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- File: `app/Http/Resources/ProductResource.php`
- Line (v34): `48`
- Evidence: `'cost' => $this->when(self::$canViewCost, (float) $this->cost),`

### B.79 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- File: `app/Http/Resources/ProductResource.php`
- Line (v34): `53`
- Evidence: `'reorder_qty' => $this->reorder_qty ? (float) $this->reorder_qty : 0.0,`

### B.80 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- File: `app/Http/Resources/PurchaseResource.php`
- Line (v34): `25`
- Evidence: `'sub_total' => (float) ($this->sub_total ?? 0.0),`

### B.81 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- File: `app/Http/Resources/PurchaseResource.php`
- Line (v34): `26`
- Evidence: `'tax_total' => (float) ($this->tax_total ?? 0.0),`

### B.82 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- File: `app/Http/Resources/PurchaseResource.php`
- Line (v34): `27`
- Evidence: `'discount_total' => (float) ($this->discount_total ?? 0.0),`

### B.83 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- File: `app/Http/Resources/PurchaseResource.php`
- Line (v34): `28`
- Evidence: `'shipping_total' => (float) ($this->shipping_total ?? 0.0),`

### B.84 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- File: `app/Http/Resources/PurchaseResource.php`
- Line (v34): `29`
- Evidence: `'grand_total' => (float) ($this->grand_total ?? 0.0),`

### B.85 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- File: `app/Http/Resources/PurchaseResource.php`
- Line (v34): `30`
- Evidence: `'paid_total' => (float) ($this->paid_total ?? 0.0),`

### B.86 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- File: `app/Http/Resources/PurchaseResource.php`
- Line (v34): `31`
- Evidence: `'due_total' => (float) ($this->due_total ?? 0.0),`

### B.87 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- File: `app/Http/Resources/SaleResource.php`
- Line (v34): `30`
- Evidence: `'discount_amount' => $this->discount_amount ? (float) $this->discount_amount : null,`

### B.88 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- File: `app/Http/Resources/SaleResource.php`
- Line (v34): `31`
- Evidence: `'sub_total' => (float) ($this->sub_total ?? 0.0),`

### B.89 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- File: `app/Http/Resources/SaleResource.php`
- Line (v34): `32`
- Evidence: `'tax_total' => (float) ($this->tax_total ?? 0.0),`

### B.90 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- File: `app/Http/Resources/SaleResource.php`
- Line (v34): `33`
- Evidence: `'discount_total' => (float) ($this->discount_total ?? 0.0),`

### B.91 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- File: `app/Http/Resources/SaleResource.php`
- Line (v34): `34`
- Evidence: `'shipping_total' => (float) ($this->shipping_total ?? 0.0),`

### B.92 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- File: `app/Http/Resources/SaleResource.php`
- Line (v34): `35`
- Evidence: `'grand_total' => (float) ($this->grand_total ?? 0.0),`

### B.93 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- File: `app/Http/Resources/SaleResource.php`
- Line (v34): `36`
- Evidence: `'paid_total' => (float) ($this->paid_total ?? 0.0),`

### B.94 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- File: `app/Http/Resources/SaleResource.php`
- Line (v34): `37`
- Evidence: `'due_total' => (float) ($this->due_total ?? 0.0),`

### B.95 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- File: `app/Http/Resources/SupplierResource.php`
- Line (v34): `18`
- Evidence: `return $value ? (float) $value : null;`

### B.96 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- File: `app/Http/Resources/SupplierResource.php`
- Line (v34): `37`
- Evidence: `(float) ($this->minimum_order_value ?? 0.0)`

### B.97 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- File: `app/Http/Resources/SupplierResource.php`
- Line (v34): `54`
- Evidence: `fn () => (float) $this->purchases->sum('total_amount')`

### B.98 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- File: `app/Jobs/ClosePosDayJob.php`
- Line (v34): `72`
- Evidence: `$paid = (float) $paidString;`

### B.99 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- File: `app/Listeners/ApplyLateFee.php`
- Line (v34): `43`
- Evidence: `$invoice->amount = (float) $newAmount;`

### B.100 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- File: `app/Listeners/UpdateStockOnPurchase.php`
- Line (v34): `27`
- Evidence: `$itemQty = (float) $item->quantity;`

### B.101 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- File: `app/Listeners/UpdateStockOnSale.php`
- Line (v34): `49`
- Evidence: `$baseQuantity = (float) $item->quantity * (float) $conversionFactor;`

### B.102 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- File: `app/Livewire/Accounting/JournalEntries/Form.php`
- Line (v34): `144`
- Evidence: `'amount' => number_format((float) ltrim($difference, '-'), 2),`

### B.103 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- File: `app/Livewire/Admin/CurrencyRate/Form.php`
- Line (v34): `51`
- Evidence: `$this->rate = (float) $rate->rate;`

### B.104 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- File: `app/Livewire/Admin/Installments/Index.php`
- Line (v34): `45`
- Evidence: `$this->paymentAmount = (float) $payment->remaining_amount;`

### B.105 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- File: `app/Livewire/Admin/Loyalty/Index.php`
- Line (v34): `59`
- Evidence: `$this->points_per_amount = (float) $settings->points_per_amount;`

### B.106 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- File: `app/Livewire/Admin/Loyalty/Index.php`
- Line (v34): `60`
- Evidence: `$this->amount_per_point = (float) $settings->amount_per_point;`

### B.107 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- File: `app/Livewire/Admin/Loyalty/Index.php`
- Line (v34): `61`
- Evidence: `$this->redemption_rate = (float) $settings->redemption_rate;`

### B.108 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- File: `app/Livewire/Admin/Modules/RentalPeriods/Form.php`
- Line (v34): `73`
- Evidence: `$this->price_multiplier = (float) $period->price_multiplier;`

### B.109 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- File: `app/Livewire/Admin/Reports/InventoryChartsDashboard.php`
- Line (v34): `37`
- Evidence: `$totalStock = (float) $products->sum('current_stock');`

### B.110 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- File: `app/Livewire/Admin/Reports/InventoryChartsDashboard.php`
- Line (v34): `46`
- Evidence: `$values[] = (float) $product->current_stock;`

### B.111 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- File: `app/Livewire/Admin/Reports/PosChartsDashboard.php`
- Line (v34): `49`
- Evidence: `$totalRevenue = (float) $sales->sum('grand_total');`

### B.112 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- File: `app/Livewire/Admin/Reports/PosChartsDashboard.php`
- Line (v34): `65`
- Evidence: `$dayValues[] = (float) $items->sum('grand_total');`

### B.113 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- File: `app/Livewire/Admin/Reports/PosChartsDashboard.php`
- Line (v34): `75`
- Evidence: `$branchValues[] = (float) $items->sum('grand_total');`

### B.114 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- File: `app/Livewire/Admin/Settings/UnifiedSettings.php`
- Line (v34): `259`
- Evidence: `$this->hrm_transport_allowance_value = (float) ($settings['hrm.transport_allowance_value'] ?? 10.0);`

### B.115 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- File: `app/Livewire/Admin/Settings/UnifiedSettings.php`
- Line (v34): `261`
- Evidence: `$this->hrm_housing_allowance_value = (float) ($settings['hrm.housing_allowance_value'] ?? 0.0);`

### B.116 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- File: `app/Livewire/Admin/Settings/UnifiedSettings.php`
- Line (v34): `268`
- Evidence: `$this->rental_penalty_value = (float) ($settings['rental.penalty_value'] ?? 5.0);`

### B.117 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- File: `app/Livewire/Admin/Store/OrdersDashboard.php`
- Line (v34): `67`
- Evidence: `$totalRevenue = (float) $ordersForStats->sum('total');`

### B.118 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- File: `app/Livewire/Admin/Store/OrdersDashboard.php`
- Line (v34): `68`
- Evidence: `$totalDiscount = (float) $ordersForStats->sum('discount_total');`

### B.119 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- File: `app/Livewire/Admin/Store/OrdersDashboard.php`
- Line (v34): `69`
- Evidence: `$totalShipping = (float) $ordersForStats->sum('shipping_total');`

### B.120 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- File: `app/Livewire/Admin/Store/OrdersDashboard.php`
- Line (v34): `70`
- Evidence: `$totalTax = (float) $ordersForStats->sum('tax_total');`

### B.121 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- File: `app/Livewire/Admin/Store/OrdersDashboard.php`
- Line (v34): `84`
- Evidence: `$sources[$source]['revenue'] += (float) $order->total;`

### B.122 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- File: `app/Livewire/Admin/Store/OrdersDashboard.php`
- Line (v34): `139`
- Evidence: `$dayValues[] = (float) $items->sum('total');`

### B.123 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- File: `app/Livewire/Banking/Reconciliation.php`
- Line (v34): `304`
- Evidence: `'amount' => number_format((float) $this->difference, 2),`

### B.124 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- File: `app/Livewire/Customers/Form.php`
- Line (v34): `89`
- Evidence: `$this->credit_limit = (float) ($customer->credit_limit ?? 0);`

### B.125 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- File: `app/Livewire/Customers/Form.php`
- Line (v34): `90`
- Evidence: `$this->discount_percentage = (float) ($customer->discount_percentage ?? 0);`

### B.126 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- File: `app/Livewire/Hrm/Reports/Dashboard.php`
- Line (v34): `126`
- Evidence: `'total_net' => (float) $group->sum('net'),`

### B.127 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- File: `app/Livewire/Income/Form.php`
- Line (v34): `102`
- Evidence: `$this->amount = (float) $income->amount;`

### B.128 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- File: `app/Livewire/Inventory/Products/Form.php`
- Line (v34): `132`
- Evidence: `$this->form['price'] = (float) ($p->default_price ?? $p->price ?? 0);`

### B.129 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- File: `app/Livewire/Inventory/Products/Form.php`
- Line (v34): `133`
- Evidence: `$this->form['cost'] = (float) ($p->standard_cost ?? $p->cost ?? 0);`

### B.130 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- File: `app/Livewire/Inventory/Services/Form.php`
- Line (v34): `136`
- Evidence: `$this->defaultPrice = (float) $product->default_price;`

### B.131 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- File: `app/Livewire/Inventory/Services/Form.php`
- Line (v34): `137`
- Evidence: `$this->cost = (float) ($product->cost ?: $product->standard_cost);`

### B.132 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- File: `app/Livewire/Inventory/Services/Form.php`
- Line (v34): `234`
- Evidence: `$this->defaultPrice = (float) bcround($calculated, 2);`

### B.133 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- File: `app/Livewire/Manufacturing/BillsOfMaterials/Form.php`
- Line (v34): `70`
- Evidence: `$this->quantity = (float) $this->bom->quantity;`

### B.134 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- File: `app/Livewire/Manufacturing/ProductionOrders/Form.php`
- Line (v34): `73`
- Evidence: `$this->quantity_planned = (float) $this->productionOrder->quantity_planned;`

### B.135 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- File: `app/Livewire/Manufacturing/WorkCenters/Form.php`
- Line (v34): `78`
- Evidence: `$this->cost_per_hour = (float) $this->workCenter->cost_per_hour;`

### B.136 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- File: `app/Livewire/Projects/TimeLogs.php`
- Line (v34): `206`
- Evidence: `'total_hours' => (float) ($stats->total_hours ?? 0),`

### B.137 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- File: `app/Livewire/Projects/TimeLogs.php`
- Line (v34): `209`
- Evidence: `'total_cost' => (float) ($stats->total_cost ?? 0),`

### B.138 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- File: `app/Livewire/Purchases/Form.php`
- Line (v34): `163`
- Evidence: `$this->discount_total = (float) ($purchase->discount_total ?? 0);`

### B.139 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- File: `app/Livewire/Purchases/Form.php`
- Line (v34): `164`
- Evidence: `$this->shipping_total = (float) ($purchase->shipping_total ?? 0);`

### B.140 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- File: `app/Livewire/Purchases/Form.php`
- Line (v34): `171`
- Evidence: `'qty' => (float) $item->qty,`

### B.141 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- File: `app/Livewire/Purchases/Form.php`
- Line (v34): `172`
- Evidence: `'unit_cost' => (float) $item->unit_cost,`

### B.142 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- File: `app/Livewire/Purchases/Form.php`
- Line (v34): `173`
- Evidence: `'discount' => (float) ($item->discount ?? 0),`

### B.143 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- File: `app/Livewire/Purchases/Form.php`
- Line (v34): `174`
- Evidence: `'tax_rate' => (float) ($item->tax_rate ?? 0),`

### B.144 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- File: `app/Livewire/Purchases/Form.php`
- Line (v34): `239`
- Evidence: `'unit_cost' => (float) ($product->cost ?? 0),`

### B.145 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- File: `app/Livewire/Purchases/Form.php`
- Line (v34): `357`
- Evidence: `$discountAmount = max(0, (float) ($item['discount'] ?? 0));`

### B.146 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- File: `app/Livewire/Purchases/Returns/Index.php`
- Line (v34): `102`
- Evidence: `'max_qty' => (float) $item->qty,`

### B.147 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- File: `app/Livewire/Purchases/Returns/Index.php`
- Line (v34): `104`
- Evidence: `'cost' => (float) $item->unit_cost,`

### B.148 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- File: `app/Livewire/Purchases/Returns/Index.php`
- Line (v34): `160`
- Evidence: `$qty = min((float) $it['qty'], (float) $pi->qty);`

### B.149 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- File: `app/Livewire/Purchases/Returns/Index.php`
- Line (v34): `162`
- Evidence: `$unitCost = (float) $pi->unit_cost;`

### B.150 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- File: `app/Livewire/Rental/Reports/Dashboard.php`
- Line (v34): `69`
- Evidence: `$occupancyRate = $total > 0 ? (float) bcdiv(bcmul((string) $occupied, '100', 4), (string) $total, 1) : 0;`

### B.151 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- File: `app/Livewire/Reports/SalesAnalytics.php`
- Line (v34): `152`
- Evidence: `$avgOrderValue = $totalOrders > 0 ? (float) bcdiv((string) $totalSales, (string) $totalOrders, 2) : 0;`

### B.152 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- File: `app/Livewire/Reports/SalesAnalytics.php`
- Line (v34): `171`
- Evidence: `$salesGrowth = (float) bcdiv(bcmul($diff, '100', 6), (string) $prevTotalSales, 1);`

### B.153 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- File: `app/Livewire/Reports/SalesAnalytics.php`
- Line (v34): `176`
- Evidence: `$completionRate = $totalOrders > 0 ? (float) bcdiv(bcmul((string) $completedOrders, '100', 4), (string) $totalOrders, 1) : 0;`

### B.154 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- File: `app/Livewire/Reports/SalesAnalytics.php`
- Line (v34): `262`
- Evidence: `'revenue' => (float) $p->total_revenue,`

### B.155 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- File: `app/Livewire/Reports/SalesAnalytics.php`
- Line (v34): `295`
- Evidence: `'total_spent' => (float) $c->total_spent,`

### B.156 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- File: `app/Livewire/Reports/SalesAnalytics.php`
- Line (v34): `319`
- Evidence: `'totals' => $results->pluck('total')->map(fn ($v) => (float) $v)->toArray(),`

### B.157 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- File: `app/Livewire/Reports/SalesAnalytics.php`
- Line (v34): `377`
- Evidence: `'revenues' => $results->pluck('total_revenue')->map(fn ($v) => (float) $v)->toArray(),`

### B.158 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- File: `app/Livewire/Sales/Form.php`
- Line (v34): `185`
- Evidence: `$this->discount_total = (float) ($sale->discount_total ?? 0);`

### B.159 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- File: `app/Livewire/Sales/Form.php`
- Line (v34): `186`
- Evidence: `$this->shipping_total = (float) ($sale->shipping_total ?? 0);`

### B.160 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- File: `app/Livewire/Sales/Form.php`
- Line (v34): `193`
- Evidence: `'qty' => (float) $item->qty,`

### B.161 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- File: `app/Livewire/Sales/Form.php`
- Line (v34): `194`
- Evidence: `'unit_price' => (float) $item->unit_price,`

### B.162 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- File: `app/Livewire/Sales/Form.php`
- Line (v34): `195`
- Evidence: `'discount' => (float) ($item->discount ?? 0),`

### B.163 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- File: `app/Livewire/Sales/Form.php`
- Line (v34): `196`
- Evidence: `'tax_rate' => (float) ($item->tax_rate ?? 0),`

### B.164 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- File: `app/Livewire/Sales/Form.php`
- Line (v34): `202`
- Evidence: `$this->payment_amount = (float) ($firstPayment->amount ?? 0);`

### B.165 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- File: `app/Livewire/Sales/Form.php`
- Line (v34): `268`
- Evidence: `'unit_price' => (float) ($product->default_price ?? 0),`

### B.166 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- File: `app/Livewire/Sales/Form.php`
- Line (v34): `300`
- Evidence: `return (float) bcdiv($total, '1', BCMATH_STORAGE_SCALE);`

### B.167 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- File: `app/Livewire/Sales/Form.php`
- Line (v34): `446`
- Evidence: `$validatedPrice = (float) ($product->default_price ?? 0);`

### B.168 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- File: `app/Livewire/Sales/Form.php`
- Line (v34): `456`
- Evidence: `$validatedPrice = (float) $item['unit_price'];`

### B.169 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- File: `app/Livewire/Sales/Form.php`
- Line (v34): `476`
- Evidence: `'discount_amount' => (float) bcdiv($discountAmount, '1', BCMATH_STORAGE_SCALE),`

### B.170 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- File: `app/Livewire/Sales/Form.php`
- Line (v34): `478`
- Evidence: `'tax_amount' => (float) bcdiv($taxAmount, '1', BCMATH_STORAGE_SCALE),`

### B.171 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- File: `app/Livewire/Sales/Form.php`
- Line (v34): `479`
- Evidence: `'line_total' => (float) bcdiv($lineTotal, '1', BCMATH_STORAGE_SCALE),`

### B.172 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- File: `app/Livewire/Sales/Returns/Index.php`
- Line (v34): `114`
- Evidence: `'max_qty' => (float) $item->qty,`

### B.173 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- File: `app/Livewire/Sales/Returns/Index.php`
- Line (v34): `116`
- Evidence: `'price' => (float) $item->unit_price,`

### B.174 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- File: `app/Livewire/Sales/Returns/Index.php`
- Line (v34): `153`
- Evidence: `'qty' => min((float) $item['qty'], (float) $item['max_qty']),`

### B.175 — Medium — Perf/Security — Loads full file into memory (Storage::get / file_get_contents)
- File: `app/Livewire/Shared/DynamicForm.php`
- Line (v34): `203`
- Evidence: `$content = file_get_contents($file->getRealPath());`

### B.176 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- File: `app/Livewire/Suppliers/Form.php`
- Line (v34): `115`
- Evidence: `$this->minimum_order_value = (float) ($supplier->minimum_order_value ?? 0);`

### B.177 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- File: `app/Livewire/Warehouse/Adjustments/Form.php`
- Line (v34): `160`
- Evidence: `'qty' => abs((float) $item['qty']),`

### B.178 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- File: `app/Livewire/Warehouse/Adjustments/Form.php`
- Line (v34): `161`
- Evidence: `'direction' => (float) $item['qty'] >= 0 ? 'in' : 'out',`

### B.179 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- File: `app/Livewire/Warehouse/Transfers/Index.php`
- Line (v34): `91`
- Evidence: `$qty = (float) $item->quantity;`

### B.180 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- File: `app/Models/BankTransaction.php`
- Line (v34): `107`
- Evidence: `$amount = (float) $this->amount;`

### B.181 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- File: `app/Models/BillOfMaterial.php`
- Line (v34): `123`
- Evidence: `$itemQuantity = (float) $item->quantity;`

### B.182 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- File: `app/Models/BillOfMaterial.php`
- Line (v34): `146`
- Evidence: `$costPerHour = (float) ($operation->workCenter->cost_per_hour ?? 0);`

### B.183 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- File: `app/Models/BillOfMaterial.php`
- Line (v34): `148`
- Evidence: `return $durationHours * $costPerHour + (float) ($operation->labor_cost ?? 0);`

### B.184 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- File: `app/Models/BomItem.php`
- Line (v34): `69`
- Evidence: `$baseQuantity = (float) $this->quantity;`

### B.185 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- File: `app/Models/BomOperation.php`
- Line (v34): `67`
- Evidence: `$workCenterCost = $timeHours * (float) $this->workCenter->cost_per_hour;`

### B.186 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- File: `app/Models/BomOperation.php`
- Line (v34): `68`
- Evidence: `$laborCost = (float) $this->labor_cost;`

### B.187 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- File: `app/Models/CurrencyRate.php`
- Line (v34): `91`
- Evidence: `$rateValue = (float) $rate->rate;`

### B.188 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- File: `app/Models/FixedAsset.php`
- Line (v34): `156`
- Evidence: `$currentValue = (float) ($this->current_value ?? 0);`

### B.189 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- File: `app/Models/FixedAsset.php`
- Line (v34): `157`
- Evidence: `$salvageValue = (float) ($this->salvage_value ?? 0);`

### B.190 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- File: `app/Models/FixedAsset.php`
- Line (v34): `175`
- Evidence: `$purchaseCost = (float) ($this->purchase_cost ?? 0);`

### B.191 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- File: `app/Models/GRNItem.php`
- Line (v34): `85`
- Evidence: `$expectedQty = (float) ($this->expected_quantity ?? 0);`

### B.192 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- File: `app/Models/GRNItem.php`
- Line (v34): `93`
- Evidence: `return (abs($expectedQty - (float) $acceptedQty) / $expectedQty) * 100;`

### B.193 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- File: `app/Models/GoodsReceivedNote.php`
- Line (v34): `162`
- Evidence: `return (float) $this->items->sum('received_quantity');`

### B.194 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- File: `app/Models/GoodsReceivedNote.php`
- Line (v34): `167`
- Evidence: `return (float) $this->items->sum('accepted_quantity');`

### B.195 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- File: `app/Models/GoodsReceivedNote.php`
- Line (v34): `172`
- Evidence: `return (float) $this->items->sum('rejected_quantity');`

### B.196 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- File: `app/Models/InstallmentPayment.php`
- Line (v34): `45`
- Evidence: `return max(0, (float) $this->amount_due - (float) ($this->amount_paid ?? 0));`

### B.197 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- File: `app/Models/InstallmentPayment.php`
- Line (v34): `60`
- Evidence: `$amountPaid = (float) ($this->amount_paid ?? 0);`

### B.198 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- File: `app/Models/InstallmentPayment.php`
- Line (v34): `61`
- Evidence: `$newAmountPaid = min($amountPaid + $amount, (float) $this->amount_due);`

### B.199 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- File: `app/Models/InstallmentPayment.php`
- Line (v34): `62`
- Evidence: `$newStatus = $newAmountPaid >= (float) $this->amount_due ? 'paid' : 'partial';`

### B.200 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- File: `app/Models/InstallmentPlan.php`
- Line (v34): `71`
- Evidence: `return (float) $this->payments()->sum('amount_paid');`

### B.201 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- File: `app/Models/InstallmentPlan.php`
- Line (v34): `76`
- Evidence: `return max(0, (float) $this->total_amount - (float) $this->down_payment - $this->paid_amount);`

### B.202 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- File: `app/Models/JournalEntry.php`
- Line (v34): `101`
- Evidence: `return (float) ($this->attributes['total_debit'] ?? $this->lines()->sum('debit'));`

### B.203 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- File: `app/Models/JournalEntry.php`
- Line (v34): `106`
- Evidence: `return (float) ($this->attributes['total_credit'] ?? $this->lines()->sum('credit'));`

### B.204 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- File: `app/Models/ModuleSetting.php`
- Line (v34): `53`
- Evidence: `'float', 'decimal' => (float) $this->setting_value,`

### B.205 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- File: `app/Models/ProductFieldValue.php`
- Line (v34): `39`
- Evidence: `'decimal' => (float) $this->value,`

### B.206 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- File: `app/Models/ProductionOrder.php`
- Line (v34): `175`
- Evidence: `$plannedQty = (float) ($this->planned_quantity ?? 0);`

### B.207 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- File: `app/Models/ProductionOrder.php`
- Line (v34): `181`
- Evidence: `return ((float) ($this->produced_quantity ?? 0) / $plannedQty) * 100;`

### B.208 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- File: `app/Models/ProductionOrder.php`
- Line (v34): `189`
- Evidence: `return (float) $this->planned_quantity - (float) $this->produced_quantity - (float) $this->rejected_quantity;`

### B.209 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- File: `app/Models/Project.php`
- Line (v34): `208`
- Evidence: `return (float) ($timeLogsCost + $expensesCost);`

### B.210 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- File: `app/Models/ProjectTimeLog.php`
- Line (v34): `110`
- Evidence: `return (float) ($this->hours * $this->hourly_rate);`

### B.211 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- File: `app/Models/Purchase.php`
- Line (v34): `189`
- Evidence: `return (float) $this->paid_amount;`

### B.212 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- File: `app/Models/Purchase.php`
- Line (v34): `194`
- Evidence: `return max(0, (float) $this->total_amount - (float) $this->paid_amount);`

### B.213 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- File: `app/Models/Purchase.php`
- Line (v34): `229`
- Evidence: `$paidAmount = (float) $this->paid_amount;`

### B.214 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- File: `app/Models/Purchase.php`
- Line (v34): `230`
- Evidence: `$totalAmount = (float) $this->total_amount;`

### B.215 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- File: `app/Models/Sale.php`
- Line (v34): `212`
- Evidence: `return max(0, (float) $this->total_amount - $this->total_paid);`

### B.216 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- File: `app/Models/Sale.php`
- Line (v34): `235`
- Evidence: `$totalAmount = (float) $this->total_amount;`

### B.217 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- File: `app/Models/StockTransferItem.php`
- Line (v34): `74`
- Evidence: `return (float) bcsub((string)$this->qty_shipped, (string)$this->qty_received, 3);`

### B.218 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- File: `app/Models/SystemSetting.php`
- Line (v34): `103`
- Evidence: `'float', 'decimal' => is_numeric($value) ? (float) $value : $default,`

### B.219 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- File: `app/Models/Traits/CommonQueryScopes.php`
- Line (v34): `192`
- Evidence: `return number_format((float) $value, 2);`

### B.220 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- File: `app/Models/UnitOfMeasure.php`
- Line (v34): `87`
- Evidence: `$baseValue = $value * (float) $this->conversion_factor;`

### B.221 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- File: `app/Observers/FinancialTransactionObserver.php`
- Line (v34): `142`
- Evidence: `$customer->addBalance((float) $model->total_amount);`

### B.222 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- File: `app/Observers/FinancialTransactionObserver.php`
- Line (v34): `144`
- Evidence: `$customer->subtractBalance((float) $model->total_amount);`

### B.223 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- File: `app/Observers/FinancialTransactionObserver.php`
- Line (v34): `151`
- Evidence: `$supplier->addBalance((float) $model->total_amount);`

### B.224 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- File: `app/Observers/FinancialTransactionObserver.php`
- Line (v34): `153`
- Evidence: `$supplier->subtractBalance((float) $model->total_amount);`

### B.225 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- File: `app/Observers/ProductObserver.php`
- Line (v34): `25`
- Evidence: `$product->default_price = round((float) $product->default_price, 2);`

### B.226 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- File: `app/Observers/ProductObserver.php`
- Line (v34): `28`
- Evidence: `$product->standard_cost = round((float) $product->standard_cost, 2);`

### B.227 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- File: `app/Observers/ProductObserver.php`
- Line (v34): `31`
- Evidence: `$product->cost = round((float) $product->cost, 2);`

### B.228 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- File: `app/Repositories/StockMovementRepository.php`
- Line (v34): `74`
- Evidence: `$in = (float) (clone $baseQuery)->where('quantity', '>', 0)->sum('quantity');`

### B.229 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- File: `app/Repositories/StockMovementRepository.php`
- Line (v34): `75`
- Evidence: `$out = (float) abs((clone $baseQuery)->where('quantity', '<', 0)->sum('quantity'));`

### B.230 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- File: `app/Repositories/StockMovementRepository.php`
- Line (v34): `91`
- Evidence: `return (float) $baseQuery->sum('quantity');`

### B.231 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- File: `app/Repositories/StockMovementRepository.php`
- Line (v34): `103`
- Evidence: `return (float) $group->sum('quantity');`

### B.232 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- File: `app/Repositories/StockMovementRepository.php`
- Line (v34): `138`
- Evidence: `$qty = abs((float) ($data['qty'] ?? $data['quantity'] ?? 0));`

### B.233 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- File: `app/Repositories/StockMovementRepository.php`
- Line (v34): `226`
- Evidence: `$totalStock = (float) StockMovement::where('product_id', $productId)`

### B.234 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- File: `app/Rules/ValidDiscount.php`
- Line (v34): `35`
- Evidence: `$num = (float) $value;`

### B.235 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- File: `app/Rules/ValidDiscountPercentage.php`
- Line (v34): `29`
- Evidence: `$discount = (float) $value;`

### B.236 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- File: `app/Rules/ValidPriceOverride.php`
- Line (v34): `25`
- Evidence: `$price = (float) $value;`

### B.237 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- File: `app/Rules/ValidStockQuantity.php`
- Line (v34): `29`
- Evidence: `$quantity = (float) $value;`

### B.238 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- File: `app/Services/AccountingService.php`
- Line (v34): `86`
- Evidence: `'debit' => (float) $unpaidAmount,`

### B.239 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- File: `app/Services/AccountingService.php`
- Line (v34): `712`
- Evidence: `$totalCost = (float) bcround($totalCost, 2);`

### B.240 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- File: `app/Services/Analytics/SalesForecastingService.php`
- Line (v34): `84`
- Evidence: `'avg_order_value' => (float) $row->avg_order_value,`

### B.241 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- File: `app/Services/AutomatedAlertService.php`
- Line (v34): `183`
- Evidence: `$availableCredit = (float) bcsub((string) $customer->credit_limit, (string) $customer->balance, 2);`

### B.242 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- File: `app/Services/AutomatedAlertService.php`
- Line (v34): `234`
- Evidence: `$estimatedLoss = (float) bcmul((string) $currentStock, (string) $unitCost, 2);`

### B.243 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- File: `app/Services/BankingService.php`
- Line (v34): `265`
- Evidence: `return (float) $this->getAccountBalance($accountId);`

### B.244 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- File: `app/Services/BankingService.php`
- Line (v34): `313`
- Evidence: `(float) $availableBalance,`

### B.245 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- File: `app/Services/CostingService.php`
- Line (v34): `108`
- Evidence: `'unit_cost' => (float) $avgCost,`

### B.246 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- File: `app/Services/CostingService.php`
- Line (v34): `110`
- Evidence: `'total_cost' => (float) bcround($totalCost, 2),`

### B.247 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- File: `app/Services/CostingService.php`
- Line (v34): `120`
- Evidence: `$unitCost = (float) $product->standard_cost;`

### B.248 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- File: `app/Services/CostingService.php`
- Line (v34): `153`
- Evidence: `'quantity' => (float) $batchQty,`

### B.249 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- File: `app/Services/CostingService.php`
- Line (v34): `154`
- Evidence: `'unit_cost' => (float) $batch->unit_cost,`

### B.250 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- File: `app/Services/CostingService.php`
- Line (v34): `156`
- Evidence: `'total_cost' => (float) bcround($batchCost, 2),`

### B.251 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- File: `app/Services/CostingService.php`
- Line (v34): `163`
- Evidence: `'unit_cost' => (float) $unitCost,`

### B.252 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- File: `app/Services/CostingService.php`
- Line (v34): `242`
- Evidence: `$batch->quantity = (float) $combinedQty;`

### B.253 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- File: `app/Services/CostingService.php`
- Line (v34): `243`
- Evidence: `$batch->unit_cost = (float) $weightedAvgCost;`

### B.254 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- File: `app/Services/CostingService.php`
- Line (v34): `325`
- Evidence: `'warehouse_value' => (float) $warehouseValue,`

### B.255 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- File: `app/Services/CostingService.php`
- Line (v34): `326`
- Evidence: `'warehouse_quantity' => (float) $warehouseQuantity,`

### B.256 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- File: `app/Services/CostingService.php`
- Line (v34): `327`
- Evidence: `'transit_value' => (float) $transitValue,`

### B.257 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- File: `app/Services/CostingService.php`
- Line (v34): `328`
- Evidence: `'transit_quantity' => (float) $transitQuantity,`

### B.258 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- File: `app/Services/CostingService.php`
- Line (v34): `329`
- Evidence: `'total_value' => (float) $totalValue,`

### B.259 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- File: `app/Services/CostingService.php`
- Line (v34): `330`
- Evidence: `'total_quantity' => (float) $totalQuantity,`

### B.260 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- File: `app/Services/CostingService.php`
- Line (v34): `332`
- Evidence: `'in_warehouses' => (float) $warehouseValue,`

### B.261 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- File: `app/Services/CostingService.php`
- Line (v34): `333`
- Evidence: `'in_transit' => (float) $transitValue,`

### B.262 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- File: `app/Services/CostingService.php`
- Line (v34): `356`
- Evidence: `if ((float) $totalStock <= self::STOCK_ZERO_TOLERANCE) {`

### B.263 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- File: `app/Services/CurrencyExchangeService.php`
- Line (v34): `55`
- Evidence: `return (float) bcmul((string) $amount, (string) $rate, 4);`

### B.264 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- File: `app/Services/CurrencyExchangeService.php`
- Line (v34): `95`
- Evidence: `return $rate ? (float) $rate->rate : null;`

### B.265 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- File: `app/Services/CurrencyExchangeService.php`
- Line (v34): `238`
- Evidence: `'rate' => (float) $r->rate,`

### B.266 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- File: `app/Services/CurrencyService.php`
- Line (v34): `128`
- Evidence: `return (float) bcmul((string) $amount, (string) $rate, 2);`

### B.267 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- File: `app/Services/DataValidationService.php`
- Line (v34): `115`
- Evidence: `$amount = (float) $amount;`

### B.268 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- File: `app/Services/DiscountService.php`
- Line (v34): `73`
- Evidence: `return (float) bcround($discTotal, 2);`

### B.269 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- File: `app/Services/DiscountService.php`
- Line (v34): `88`
- Evidence: `return (float) config('sales.max_line_discount_percent',`

### B.270 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- File: `app/Services/DiscountService.php`
- Line (v34): `93`
- Evidence: `return (float) config('pos.discount.max_amount', 1000);`

### B.271 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- File: `app/Services/DiscountService.php`
- Line (v34): `102`
- Evidence: `? (float) config('sales.max_invoice_discount_percent', 30)`

### B.272 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- File: `app/Services/DiscountService.php`
- Line (v34): `103`
- Evidence: `: (float) config('pos.discount.max_amount', 1000);`

### B.273 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- File: `app/Services/DiscountService.php`
- Line (v34): `157`
- Evidence: `$value = (float) ($discount['value'] ?? 0);`

### B.274 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- File: `app/Services/DiscountService.php`
- Line (v34): `179`
- Evidence: `$maxDiscountPercent = (float) config('sales.max_combined_discount_percent', 80);`

### B.275 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- File: `app/Services/FinancialReportService.php`
- Line (v34): `71`
- Evidence: `'total_debit' => (float) bcround($totalDebitStr, 2),`

### B.276 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- File: `app/Services/FinancialReportService.php`
- Line (v34): `72`
- Evidence: `'total_credit' => (float) bcround($totalCreditStr, 2),`

### B.277 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- File: `app/Services/FinancialReportService.php`
- Line (v34): `148`
- Evidence: `'total' => (float) bcround((string) $totalRevenue, 2),`

### B.278 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- File: `app/Services/FinancialReportService.php`
- Line (v34): `153`
- Evidence: `'total' => (float) bcround((string) $totalExpenses, 2),`

### B.279 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- File: `app/Services/FinancialReportService.php`
- Line (v34): `253`
- Evidence: `'total' => (float) bcround((string) $totalAssets, 2),`

### B.280 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- File: `app/Services/FinancialReportService.php`
- Line (v34): `258`
- Evidence: `'total' => (float) bcround((string) $totalLiabilities, 2),`

### B.281 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- File: `app/Services/FinancialReportService.php`
- Line (v34): `263`
- Evidence: `'total' => (float) bcround((string) $totalEquity, 2),`

### B.282 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- File: `app/Services/FinancialReportService.php`
- Line (v34): `265`
- Evidence: `'total_liabilities_and_equity' => (float) $totalLiabilitiesAndEquity,`

### B.283 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- File: `app/Services/FinancialReportService.php`
- Line (v34): `311`
- Evidence: `$outstandingAmount = (float) $sale->total_amount - (float) $totalPaid + (float) $totalRefunded;`

### B.284 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- File: `app/Services/FinancialReportService.php`
- Line (v34): `380`
- Evidence: `$outstandingAmount = (float) $purchase->total_amount - (float) $totalPaid;`

### B.285 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- File: `app/Services/FinancialReportService.php`
- Line (v34): `453`
- Evidence: `$debit = (float) $line->debit;`

### B.286 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- File: `app/Services/FinancialReportService.php`
- Line (v34): `454`
- Evidence: `$credit = (float) $line->credit;`

### B.287 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- File: `app/Services/FinancialReportService.php`
- Line (v34): `489`
- Evidence: `'total_debit' => (float) bcround((string) $totalDebit, 2),`

### B.288 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- File: `app/Services/FinancialReportService.php`
- Line (v34): `490`
- Evidence: `'total_credit' => (float) bcround((string) $totalCredit, 2),`

### B.289 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- File: `app/Services/FinancialReportService.php`
- Line (v34): `491`
- Evidence: `'ending_balance' => (float) bcround((string) $runningBalance, 2),`

### B.290 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- File: `app/Services/FinancialReportService.php`
- Line (v34): `519`
- Evidence: `$totalDebit = (float) $query->sum('debit');`

### B.291 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- File: `app/Services/FinancialReportService.php`
- Line (v34): `520`
- Evidence: `$totalCredit = (float) $query->sum('credit');`

### B.292 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- File: `app/Services/HRMService.php`
- Line (v34): `209`
- Evidence: `return (float) bcround($monthlyTax, 2);`

### B.293 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- File: `app/Services/HRMService.php`
- Line (v34): `233`
- Evidence: `$dailyRate = (float) $emp->salary / 30;`

### B.294 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- File: `app/Services/HRMService.php`
- Line (v34): `236`
- Evidence: `return (float) bcmul((string) $dailyRate, (string) $absenceDays, 2);`

### B.295 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- File: `app/Services/HelpdeskService.php`
- Line (v34): `294`
- Evidence: `return (float) bcdiv((string) $totalMinutes, (string) $tickets->count(), 2);`

### B.296 — Medium — Perf/Security — Loads full file into memory (Storage::get / file_get_contents)
- File: `app/Services/ImageOptimizationService.php`
- Line (v34): `218`
- Evidence: `Storage::disk($disk)->put($path, file_get_contents($tempPath));`

### B.297 — Medium — Perf/Security — Loads full file into memory (Storage::get / file_get_contents)
- File: `app/Services/ImageOptimizationService.php`
- Line (v34): `308`
- Evidence: `Storage::disk($disk)->put($thumbnailPath, file_get_contents($tempPath));`

### B.298 — Medium — Perf/Security — Loads full file into memory (Storage::get / file_get_contents)
- File: `app/Services/ImageOptimizationService.php`
- Line (v34): `403`
- Evidence: `Storage::disk($disk)->put($path, file_get_contents($file->getRealPath()));`

### B.299 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- File: `app/Services/ImportService.php`
- Line (v34): `567`
- Evidence: `'default_price' => (float) ($data['default_price'] ?? 0),`

### B.300 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- File: `app/Services/ImportService.php`
- Line (v34): `568`
- Evidence: `'cost' => (float) ($data['cost'] ?? 0),`

### B.301 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- File: `app/Services/ImportService.php`
- Line (v34): `587`
- Evidence: `'credit_limit' => (float) ($data['credit_limit'] ?? 0),`

### B.302 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- File: `app/Services/InstallmentService.php`
- Line (v34): `31`
- Evidence: `$totalAmount = (float) $sale->grand_total;`

### B.303 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- File: `app/Services/InstallmentService.php`
- Line (v34): `103`
- Evidence: `'amount_due' => max(0, (float) $amount),`

### B.304 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- File: `app/Services/InstallmentService.php`
- Line (v34): `130`
- Evidence: `$remainingAmount = (float) $payment->remaining_amount;`

### B.305 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- File: `app/Services/InstallmentService.php`
- Line (v34): `146`
- Evidence: `'amount_paid' => (float) $newAmountPaid,`

### B.306 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- File: `app/Services/InstallmentService.php`
- Line (v34): `161`
- Evidence: `$planRemainingAmount = max(0, (float) $planRemainingAmount);`

### B.307 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- File: `app/Services/InventoryService.php`
- Line (v34): `114`
- Evidence: `$qty = (float) $data['qty'];`

### B.308 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- File: `app/Services/InventoryService.php`
- Line (v34): `159`
- Evidence: `return (float) $query->sum('quantity');`

### B.309 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- File: `app/Services/LoyaltyService.php`
- Line (v34): `208`
- Evidence: `return (float) bcmul((string) $points, (string) $settings->redemption_rate, 2);`

### B.310 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- File: `app/Services/POSService.php`
- Line (v34): `97`
- Evidence: `$previousDailyDiscount = (float) Sale::where('created_by', $user->id)`

### B.311 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- File: `app/Services/POSService.php`
- Line (v34): `112`
- Evidence: `$qty = (float) ($it['qty'] ?? 1);`

### B.312 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- File: `app/Services/POSService.php`
- Line (v34): `128`
- Evidence: `$price = isset($it['price']) ? (float) $it['price'] : (float) ($product->default_price ?? 0);`

### B.313 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- File: `app/Services/POSService.php`
- Line (v34): `145`
- Evidence: `if ($user && ! $user->can_modify_price && abs($price - (float) ($product->default_price ?? 0)) > 0.001) {`

### B.314 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- File: `app/Services/POSService.php`
- Line (v34): `149`
- Evidence: `(new ValidPriceOverride((float) $product->cost, 0.0))->validate('price', $price, function ($m) {`

### B.315 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- File: `app/Services/POSService.php`
- Line (v34): `153`
- Evidence: `$itemDiscountPercent = (float) ($it['discount'] ?? 0);`

### B.316 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- File: `app/Services/POSService.php`
- Line (v34): `156`
- Evidence: `$systemMaxDiscount = (float) setting('pos.max_discount_percent', 100);`

### B.317 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- File: `app/Services/POSService.php`
- Line (v34): `214`
- Evidence: `'line_total' => (float) bcround($lineTotal, 2),`

### B.318 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- File: `app/Services/POSService.php`
- Line (v34): `222`
- Evidence: `$sale->subtotal = (float) bcround((string) $subtotal, 2);`

### B.319 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- File: `app/Services/POSService.php`
- Line (v34): `223`
- Evidence: `$sale->discount_amount = (float) bcround((string) $discountTotal, 2);`

### B.320 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- File: `app/Services/POSService.php`
- Line (v34): `224`
- Evidence: `$sale->tax_amount = (float) bcround((string) $taxTotal, 2);`

### B.321 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- File: `app/Services/POSService.php`
- Line (v34): `225`
- Evidence: `$sale->total_amount = (float) bcround($grandTotal, 2);`

### B.322 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- File: `app/Services/POSService.php`
- Line (v34): `232`
- Evidence: `$amount = (float) ($payment['amount'] ?? 0);`

### B.323 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- File: `app/Services/POSService.php`
- Line (v34): `259`
- Evidence: `'amount' => (float) bcround($grandTotal, 2),`

### B.324 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- File: `app/Services/POSService.php`
- Line (v34): `268`
- Evidence: `$sale->paid_amount = (float) bcround($paidTotal, 2);`

### B.325 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- File: `app/Services/POSService.php`
- Line (v34): `345`
- Evidence: `$totalSales = (float) $salesQuery->sum('total_amount');`

### B.326 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- File: `app/Services/POSService.php`
- Line (v34): `486`
- Evidence: `'gross' => (float) $totalAmountString,`

### B.327 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- File: `app/Services/POSService.php`
- Line (v34): `487`
- Evidence: `'paid' => (float) $paidAmountString,`

### B.328 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- File: `app/Services/POSService.php`
- Line (v34): `499`
- Evidence: `'total_amount' => (float) $totalAmountString,`

### B.329 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- File: `app/Services/POSService.php`
- Line (v34): `500`
- Evidence: `'paid_amount' => (float) $paidAmountString,`

### B.330 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- File: `app/Services/PayslipService.php`
- Line (v34): `75`
- Evidence: `$transportValue = (float) setting('hrm.transport_allowance_value', 10);`

### B.331 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- File: `app/Services/PayslipService.php`
- Line (v34): `83`
- Evidence: `$allowances['transport'] = (float) $transportAmount;`

### B.332 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- File: `app/Services/PayslipService.php`
- Line (v34): `89`
- Evidence: `$housingValue = (float) setting('hrm.housing_allowance_value', 0);`

### B.333 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- File: `app/Services/PayslipService.php`
- Line (v34): `97`
- Evidence: `$allowances['housing'] = (float) $housingAmount;`

### B.334 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- File: `app/Services/PayslipService.php`
- Line (v34): `112`
- Evidence: `'total' => (float) $total,`

### B.335 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- File: `app/Services/PayslipService.php`
- Line (v34): `126`
- Evidence: `$siRate = (float) ($siConfig['rate'] ?? 0.14);`

### B.336 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- File: `app/Services/PayslipService.php`
- Line (v34): `143`
- Evidence: `$rate = (float) ($bracket['rate'] ?? 0);`

### B.337 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- File: `app/Services/PricingService.php`
- Line (v34): `57`
- Evidence: `$qty = max(0.0, (float) Arr::get($line, 'qty', 1));`

### B.338 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- File: `app/Services/PricingService.php`
- Line (v34): `58`
- Evidence: `$price = max(0.0, (float) Arr::get($line, 'price', 0));`

### B.339 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- File: `app/Services/PricingService.php`
- Line (v34): `60`
- Evidence: `$discVal = (float) Arr::get($line, 'discount', 0);`

### B.340 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- File: `app/Services/PricingService.php`
- Line (v34): `84`
- Evidence: `'subtotal' => (float) bcround((string) $subtotal, 2),`

### B.341 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- File: `app/Services/PricingService.php`
- Line (v34): `85`
- Evidence: `'discount' => (float) bcround((string) $discount, 2),`

### B.342 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- File: `app/Services/PricingService.php`
- Line (v34): `86`
- Evidence: `'tax' => (float) bcround((string) $taxAmount, 2),`

### B.343 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- File: `app/Services/PricingService.php`
- Line (v34): `87`
- Evidence: `'total' => (float) bcround((string) $total, 2),`

### B.344 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- File: `app/Services/ProductService.php`
- Line (v34): `113`
- Evidence: `$product->default_price = (float) $price;`

### B.345 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- File: `app/Services/ProductService.php`
- Line (v34): `118`
- Evidence: `$product->cost = (float) $cost;`

### B.346 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- File: `app/Services/PurchaseReturnService.php`
- Line (v34): `103`
- Evidence: `$qtyReturned = (float) $itemData['qty_returned'];`

### B.347 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- File: `app/Services/PurchaseReturnService.php`
- Line (v34): `104`
- Evidence: `$purchaseQty = (float) $purchaseItem->quantity;`

### B.348 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- File: `app/Services/PurchaseReturnService.php`
- Line (v34): `313`
- Evidence: `if ((float) $item->qty_returned <= 0) {`

### B.349 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- File: `app/Services/PurchaseReturnService.php`
- Line (v34): `322`
- Evidence: `'qty' => (float) $item->qty_returned,`

### B.350 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- File: `app/Services/PurchaseReturnService.php`
- Line (v34): `328`
- Evidence: `'unit_cost' => (float) $item->unit_cost,`

### B.351 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- File: `app/Services/PurchaseService.php`
- Line (v34): `77`
- Evidence: `$qty = (float) $it['qty'];`

### B.352 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- File: `app/Services/PurchaseService.php`
- Line (v34): `79`
- Evidence: `$unitPrice = (float) ($it['unit_price'] ?? $it['price'] ?? 0);`

### B.353 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- File: `app/Services/PurchaseService.php`
- Line (v34): `94`
- Evidence: `$discountPercent = (float) ($it['discount_percent'] ?? 0);`

### B.354 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- File: `app/Services/PurchaseService.php`
- Line (v34): `101`
- Evidence: `$taxPercent = (float) ($it['tax_percent'] ?? 0);`

### B.355 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- File: `app/Services/PurchaseService.php`
- Line (v34): `102`
- Evidence: `$lineTax = (float) ($it['tax_amount'] ?? 0);`

### B.356 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- File: `app/Services/PurchaseService.php`
- Line (v34): `105`
- Evidence: `$lineTax = (float) bcmul($taxableAmount, bcdiv((string) $taxPercent, '100', 6), 2);`

### B.357 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- File: `app/Services/PurchaseService.php`
- Line (v34): `129`
- Evidence: `'line_total' => (float) $lineTotal,`

### B.358 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- File: `app/Services/PurchaseService.php`
- Line (v34): `135`
- Evidence: `$shippingAmount = (float) ($payload['shipping_amount'] ?? 0);`

### B.359 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- File: `app/Services/PurchaseService.php`
- Line (v34): `138`
- Evidence: `$p->subtotal = (float) bcround($subtotal, 2);`

### B.360 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- File: `app/Services/PurchaseService.php`
- Line (v34): `139`
- Evidence: `$p->tax_amount = (float) bcround($totalTax, 2);`

### B.361 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- File: `app/Services/PurchaseService.php`
- Line (v34): `140`
- Evidence: `$p->discount_amount = (float) bcround($totalDiscount, 2);`

### B.362 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- File: `app/Services/PurchaseService.php`
- Line (v34): `142`
- Evidence: `$p->total_amount = (float) bcround(`

### B.363 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- File: `app/Services/PurchaseService.php`
- Line (v34): `221`
- Evidence: `$remainingDue = max(0, (float) $p->total_amount - (float) $p->paid_amount);`

### B.364 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- File: `app/Services/PurchaseService.php`
- Line (v34): `254`
- Evidence: `$p->paid_amount = (float) $newPaidAmount;`

### B.365 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- File: `app/Services/PurchaseService.php`
- Line (v34): `257`
- Evidence: `if ((float) $p->paid_amount >= (float) $p->total_amount) {`

### B.366 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- File: `app/Services/PurchaseService.php`
- Line (v34): `259`
- Evidence: `} elseif ((float) $p->paid_amount > 0) {`

### B.367 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- File: `app/Services/PurchaseService.php`
- Line (v34): `284`
- Evidence: `if ($p->payment_status === 'paid' || (float) $p->paid_amount > 0) {`

### B.368 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- File: `app/Services/RentalService.php`
- Line (v34): `243`
- Evidence: `$i->paid_total = (float) $newPaidTotal;`

### B.369 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- File: `app/Services/RentalService.php`
- Line (v34): `271`
- Evidence: `$i->amount = (float) $newAmount;`

### B.370 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- File: `app/Services/RentalService.php`
- Line (v34): `389`
- Evidence: `? (float) bcmul(bcdiv((string) $occupiedUnits, (string) $totalUnits, 4), '100', 2)`

### B.371 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- File: `app/Services/RentalService.php`
- Line (v34): `520`
- Evidence: `? (float) bcmul(bcdiv((string) $collectedAmount, (string) $totalAmount, 4), '100', 2)`

### B.372 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- File: `app/Services/ReportService.php`
- Line (v34): `53`
- Evidence: `'sales' => ['total' => (float) ($sales->total ?? 0), 'paid' => (float) ($sales->paid ?? 0)],`

### B.373 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- File: `app/Services/ReportService.php`
- Line (v34): `54`
- Evidence: `'purchases' => ['total' => (float) ($purchases->total ?? 0), 'paid' => (float) ($purchases->paid ?? 0)],`

### B.374 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- File: `app/Services/ReportService.php`
- Line (v34): `55`
- Evidence: `'pnl' => (float) ($sales->total ?? 0) - (float) ($purchases->total ?? 0),`

### B.375 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- File: `app/Services/Reports/CashFlowForecastService.php`
- Line (v34): `41`
- Evidence: `'total_expected_inflows' => (float) $expectedInflows->sum('amount'),`

### B.376 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- File: `app/Services/Reports/CashFlowForecastService.php`
- Line (v34): `42`
- Evidence: `'total_expected_outflows' => (float) $expectedOutflows->sum('amount'),`

### B.377 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- File: `app/Services/Reports/CashFlowForecastService.php`
- Line (v34): `43`
- Evidence: `'ending_cash_forecast' => (float) $dailyForecast->last()['ending_balance'],`

### B.378 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- File: `app/Services/Reports/CashFlowForecastService.php`
- Line (v34): `141`
- Evidence: `'ending_balance' => (float) $runningBalance,`

### B.379 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- File: `app/Services/Reports/CustomerSegmentationService.php`
- Line (v34): `134`
- Evidence: `'total_revenue' => (float) $totalRevenue,`

### B.380 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- File: `app/Services/Reports/CustomerSegmentationService.php`
- Line (v34): `136`
- Evidence: `? (float) bcdiv($totalRevenue, (string) count($customers), 2)`

### B.381 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- File: `app/Services/Reports/SlowMovingStockService.php`
- Line (v34): `58`
- Evidence: `'stock_value' => (float) $stockValue,`

### B.382 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- File: `app/Services/Reports/SlowMovingStockService.php`
- Line (v34): `61`
- Evidence: `'daily_sales_rate' => (float) $dailyRate,`

### B.383 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- File: `app/Services/Reports/SlowMovingStockService.php`
- Line (v34): `69`
- Evidence: `'total_stock_value' => (float) $products->sum(function ($product) {`

### B.384 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- File: `app/Services/Reports/SlowMovingStockService.php`
- Line (v34): `108`
- Evidence: `'total_potential_loss' => (float) $products->sum(function ($product) {`

### B.385 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- File: `app/Services/SaleService.php`
- Line (v34): `71`
- Evidence: `$requestedQty = (float) ($it['qty'] ?? 0);`

### B.386 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- File: `app/Services/SaleService.php`
- Line (v34): `104`
- Evidence: `$availableToReturn = max(0, (float) $si->quantity - $alreadyReturned);`

### B.387 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- File: `app/Services/SaleService.php`
- Line (v34): `173`
- Evidence: `'total_amount' => (float) $refund,`

### B.388 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- File: `app/Services/SaleService.php`
- Line (v34): `234`
- Evidence: `'amount' => (float) $refund,`

### B.389 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- File: `app/Services/SaleService.php`
- Line (v34): `297`
- Evidence: `$returned[$itemId] = abs((float) $returnedQty);`

### B.390 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- File: `app/Services/SaleService.php`
- Line (v34): `317`
- Evidence: `$currentReturnMap[$saleItemId] = ($currentReturnMap[$saleItemId] ?? 0) + (float) $item['qty'];`

### B.391 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- File: `app/Services/SaleService.php`
- Line (v34): `322`
- Evidence: `$soldQty = (float) $saleItem->quantity;`

### B.392 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- File: `app/Services/SalesReturnService.php`
- Line (v34): `90`
- Evidence: `$qtyToReturn = (float)($itemData['qty'] ?? 0);`

### B.393 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- File: `app/Services/SalesReturnService.php`
- Line (v34): `212`
- Evidence: `$requestedAmount = (float) ($validated['amount'] ?? $return->refund_amount);`

### B.394 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- File: `app/Services/SalesReturnService.php`
- Line (v34): `219`
- Evidence: `$remainingRefundable = (float) $return->refund_amount - (float) $alreadyRefunded;`

### B.395 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- File: `app/Services/SmartNotificationsService.php`
- Line (v34): `186`
- Evidence: `$dueTotal = max(0, (float) $invoice->total_amount - (float) $invoice->paid_amount);`

### B.396 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- File: `app/Services/StockReorderService.php`
- Line (v34): `86`
- Evidence: `return (float) $product->reorder_qty;`

### B.397 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- File: `app/Services/StockReorderService.php`
- Line (v34): `98`
- Evidence: `return (float) $product->minimum_order_quantity;`

### B.398 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- File: `app/Services/StockReorderService.php`
- Line (v34): `103`
- Evidence: `return (float) $product->maximum_order_quantity;`

### B.399 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- File: `app/Services/StockReorderService.php`
- Line (v34): `107`
- Evidence: `return (float) bcround((string) $optimalQty, 2);`

### B.400 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- File: `app/Services/StockReorderService.php`
- Line (v34): `133`
- Evidence: `return $totalSold ? ((float) $totalSold / $days) : 0;`

### B.401 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- File: `app/Services/StockReorderService.php`
- Line (v34): `289`
- Evidence: `'total_estimated_cost' => (float) bcround((string) $totalEstimatedCost, 2),`

### B.402 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- File: `app/Services/StockService.php`
- Line (v34): `31`
- Evidence: `return (float) $query->selectRaw('COALESCE(SUM(quantity), 0) as stock')`

### B.403 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- File: `app/Services/StockService.php`
- Line (v34): `101`
- Evidence: `return (float) ($query->selectRaw('SUM(quantity * COALESCE(unit_cost, 0)) as value')`

### B.404 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- File: `app/Services/StockService.php`
- Line (v34): `337`
- Evidence: `$totalStock = (float) StockMovement::where('product_id', $productId)`

### B.405 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- File: `app/Services/StockTransferService.php`
- Line (v34): `105`
- Evidence: `$requestedQty = (float) ($itemData['qty'] ?? 0);`

### B.406 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- File: `app/Services/StockTransferService.php`
- Line (v34): `236`
- Evidence: `$itemQuantities[(int) $itemId] = (float) $itemData['qty_shipped'];`

### B.407 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- File: `app/Services/StockTransferService.php`
- Line (v34): `338`
- Evidence: `$qtyReceived = (float) ($itemData['qty_received'] ?? 0);`

### B.408 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- File: `app/Services/StockTransferService.php`
- Line (v34): `339`
- Evidence: `$qtyDamaged = (float) ($itemData['qty_damaged'] ?? 0);`

### B.409 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- File: `app/Services/StockTransferService.php`
- Line (v34): `378`
- Evidence: `$qtyReceived = (float) ($itemReceivingData['qty_received'] ?? $item->qty_shipped);`

### B.410 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- File: `app/Services/StockTransferService.php`
- Line (v34): `379`
- Evidence: `$qtyDamaged = (float) ($itemReceivingData['qty_damaged'] ?? 0);`

### B.411 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- File: `app/Services/Store/StoreOrderToSaleService.php`
- Line (v34): `158`
- Evidence: `$qty = (float) Arr::get($item, 'qty', 0);`

### B.412 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- File: `app/Services/Store/StoreOrderToSaleService.php`
- Line (v34): `164`
- Evidence: `$price = (float) Arr::get($item, 'price', 0);`

### B.413 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- File: `app/Services/Store/StoreOrderToSaleService.php`
- Line (v34): `165`
- Evidence: `$discount = (float) Arr::get($item, 'discount', 0);`

### B.414 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- File: `app/Services/Store/StoreOrderToSaleService.php`
- Line (v34): `255`
- Evidence: `$total = (float) ($order->total ?? 0);`

### B.415 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- File: `app/Services/Store/StoreOrderToSaleService.php`
- Line (v34): `256`
- Evidence: `$tax = (float) ($order->tax_total ?? 0);`

### B.416 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- File: `app/Services/Store/StoreOrderToSaleService.php`
- Line (v34): `257`
- Evidence: `$shipping = (float) ($order->shipping_total ?? 0);`

### B.417 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- File: `app/Services/Store/StoreOrderToSaleService.php`
- Line (v34): `258`
- Evidence: `$discount = (float) ($order->discount_total ?? 0);`

### B.418 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- File: `app/Services/Store/StoreSyncService.php`
- Line (v34): `320`
- Evidence: `'default_price' => (float) ($data['variants'][0]['price'] ?? 0),`

### B.419 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- File: `app/Services/Store/StoreSyncService.php`
- Line (v34): `410`
- Evidence: `'subtotal' => (float) ($data['subtotal_price'] ?? 0),`

### B.420 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- File: `app/Services/Store/StoreSyncService.php`
- Line (v34): `411`
- Evidence: `'tax_amount' => (float) ($data['total_tax'] ?? 0),`

### B.421 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- File: `app/Services/Store/StoreSyncService.php`
- Line (v34): `412`
- Evidence: `'discount_amount' => (float) ($data['total_discounts'] ?? 0),`

### B.422 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- File: `app/Services/Store/StoreSyncService.php`
- Line (v34): `413`
- Evidence: `'total_amount' => (float) ($data['total_price'] ?? 0),`

### B.423 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- File: `app/Services/Store/StoreSyncService.php`
- Line (v34): `458`
- Evidence: `'unit_price' => (float) ($lineItem['price'] ?? 0),`

### B.424 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- File: `app/Services/Store/StoreSyncService.php`
- Line (v34): `460`
- Evidence: `'discount_amount' => (float) ($lineItem['total_discount'] ?? 0),`

### B.425 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- File: `app/Services/Store/StoreSyncService.php`
- Line (v34): `461`
- Evidence: `'line_total' => (float) ($lineItem['quantity'] ?? 1) * (float) ($lineItem['price'] ?? 0) - (float) ($lineItem['total_discount'] ?? 0),`

### B.426 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- File: `app/Services/Store/StoreSyncService.php`
- Line (v34): `488`
- Evidence: `'default_price' => (float) ($data['price'] ?? 0),`

### B.427 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- File: `app/Services/Store/StoreSyncService.php`
- Line (v34): `581`
- Evidence: `'subtotal' => (float) ($data['total'] ?? 0) - (float) ($data['total_tax'] ?? 0),`

### B.428 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- File: `app/Services/Store/StoreSyncService.php`
- Line (v34): `583`
- Evidence: `'discount_amount' => (float) ($data['discount_total'] ?? 0),`

### B.429 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- File: `app/Services/Store/StoreSyncService.php`
- Line (v34): `584`
- Evidence: `'total_amount' => (float) ($data['total'] ?? 0),`

### B.430 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- File: `app/Services/Store/StoreSyncService.php`
- Line (v34): `632`
- Evidence: `'line_total' => (float) ($lineItem['total'] ?? 0),`

### B.431 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- File: `app/Services/Store/StoreSyncService.php`
- Line (v34): `756`
- Evidence: `'default_price' => (float) ($data['default_price'] ?? $data['price'] ?? 0),`

### B.432 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- File: `app/Services/Store/StoreSyncService.php`
- Line (v34): `757`
- Evidence: `'cost' => (float) ($data['cost'] ?? 0),`

### B.433 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- File: `app/Services/Store/StoreSyncService.php`
- Line (v34): `826`
- Evidence: `'subtotal' => (float) ($data['sub_total'] ?? $data['subtotal'] ?? 0),`

### B.434 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- File: `app/Services/Store/StoreSyncService.php`
- Line (v34): `827`
- Evidence: `'tax_amount' => (float) ($data['tax_total'] ?? $data['tax'] ?? 0),`

### B.435 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- File: `app/Services/Store/StoreSyncService.php`
- Line (v34): `828`
- Evidence: `'discount_amount' => (float) ($data['discount_total'] ?? $data['discount'] ?? 0),`

### B.436 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- File: `app/Services/Store/StoreSyncService.php`
- Line (v34): `829`
- Evidence: `'total_amount' => (float) ($data['grand_total'] ?? $data['total'] ?? 0),`

### B.437 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- File: `app/Services/Store/StoreSyncService.php`
- Line (v34): `856`
- Evidence: `'quantity' => (float) ($lineItem['qty'] ?? $lineItem['quantity'] ?? 1),`

### B.438 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- File: `app/Services/Store/StoreSyncService.php`
- Line (v34): `857`
- Evidence: `'unit_price' => (float) ($lineItem['unit_price'] ?? $lineItem['price'] ?? 0),`

### B.439 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- File: `app/Services/Store/StoreSyncService.php`
- Line (v34): `858`
- Evidence: `'discount_amount' => (float) ($lineItem['discount'] ?? 0),`

### B.440 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- File: `app/Services/Store/StoreSyncService.php`
- Line (v34): `859`
- Evidence: `'line_total' => (float) ($lineItem['line_total'] ?? $lineItem['total'] ?? 0),`

### B.441 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- File: `app/Services/Store/StoreSyncService.php`
- Line (v34): `992`
- Evidence: `return (float) ($product->standard_cost ?? $product->cost ?? 0);`

### B.442 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- File: `app/Services/TaxService.php`
- Line (v34): `23`
- Evidence: `return (float) ($tax?->rate ?? 0.0);`

### B.443 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- File: `app/Services/TaxService.php`
- Line (v34): `35`
- Evidence: `return (float) bcround($taxAmount, 2);`

### B.444 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- File: `app/Services/TaxService.php`
- Line (v34): `51`
- Evidence: `$rate = (float) $tax->rate;`

### B.445 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- File: `app/Services/TaxService.php`
- Line (v34): `63`
- Evidence: `return (float) bcdiv($taxPortion, '1', 4);`

### B.446 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- File: `app/Services/TaxService.php`
- Line (v34): `69`
- Evidence: `return (float) bcdiv($taxAmount, '1', 4);`

### B.447 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- File: `app/Services/TaxService.php`
- Line (v34): `98`
- Evidence: `return (float) bcdiv($total, '1', 4);`

### B.448 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- File: `app/Services/TaxService.php`
- Line (v34): `102`
- Evidence: `defaultValue: (float) bcdiv((string) $base, '1', 4)`

### B.449 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- File: `app/Services/TaxService.php`
- Line (v34): `130`
- Evidence: `$subtotal = (float) ($item['subtotal'] ?? $item['line_total'] ?? 0);`

### B.450 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- File: `app/Services/TaxService.php`
- Line (v34): `142`
- Evidence: `'total_with_tax' => (float) bcadd((string) $subtotal, (string) $taxAmount, 4),`

### B.451 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- File: `app/Services/TaxService.php`
- Line (v34): `151`
- Evidence: `'total_tax' => (float) bcround($totalTax, 2),`

### B.452 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- File: `app/Services/TaxService.php`
- Line (v34): `175`
- Evidence: `$rate = (float) ($taxRateRules['rate'] ?? 0);`

### B.453 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- File: `app/Services/UIHelperService.php`
- Line (v34): `190`
- Evidence: `$value = (float) bcdiv((string) $value, '1024', $precision + 2);`

### B.454 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- File: `app/Services/UX/SmartSuggestionsService.php`
- Line (v34): `61`
- Evidence: `$suggestedQty = max((float) $eoq, (float) $product->minimum_order_quantity ?? 1);`

### B.455 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- File: `app/Services/UX/SmartSuggestionsService.php`
- Line (v34): `83`
- Evidence: `'recommendation' => $this->generateReorderRecommendation($urgency, (float) $daysOfStock, $suggestedQty),`

### B.456 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- File: `app/Services/UX/SmartSuggestionsService.php`
- Line (v34): `97`
- Evidence: `$cost = (float) ($product->standard_cost ?? 0);`

### B.457 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- File: `app/Services/UX/SmartSuggestionsService.php`
- Line (v34): `121`
- Evidence: `'price' => (float) $price,`

### B.458 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- File: `app/Services/UX/SmartSuggestionsService.php`
- Line (v34): `123`
- Evidence: `'profit_per_unit' => (float) bcsub($price, (string) $cost, 2),`

### B.459 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- File: `app/Services/UX/SmartSuggestionsService.php`
- Line (v34): `128`
- Evidence: `$currentPrice = (float) ($product->default_price ?? 0);`

### B.460 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- File: `app/Services/UX/SmartSuggestionsService.php`
- Line (v34): `142`
- Evidence: `'suggested_price' => (float) $suggestedPrice,`

### B.461 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- File: `app/Services/UX/SmartSuggestionsService.php`
- Line (v34): `144`
- Evidence: `'profit_per_unit' => (float) bcsub($suggestedPrice, (string) $cost, 2),`

### B.462 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- File: `app/Services/UX/SmartSuggestionsService.php`
- Line (v34): `147`
- Evidence: `'recommendation' => $this->generatePricingRecommendation((float) $suggestedPrice, $currentPrice, (float) $currentMargin),`

### B.463 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- File: `app/Services/UX/SmartSuggestionsService.php`
- Line (v34): `197`
- Evidence: `'price' => (float) $item->default_price,`

### B.464 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- File: `app/Services/UX/SmartSuggestionsService.php`
- Line (v34): `200`
- Evidence: `'avg_quantity' => (float) $item->avg_quantity,`

### B.465 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- File: `app/Services/UX/SmartSuggestionsService.php`
- Line (v34): `201`
- Evidence: `'individual_total' => (float) $totalPrice,`

### B.466 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- File: `app/Services/UX/SmartSuggestionsService.php`
- Line (v34): `202`
- Evidence: `'suggested_bundle_price' => (float) $suggestedBundlePrice,`

### B.467 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- File: `app/Services/UX/SmartSuggestionsService.php`
- Line (v34): `245`
- Evidence: `'price' => (float) $product->default_price,`

### B.468 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- File: `app/Services/UX/SmartSuggestionsService.php`
- Line (v34): `274`
- Evidence: `return (float) bcdiv((string) ($totalSold ?? 0), (string) $days, 2);`

### B.469 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- File: `app/Services/UX/SmartSuggestionsService.php`
- Line (v34): `290`
- Evidence: `return (float) ($totalStock ?? 0);`

### B.470 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- File: `app/Services/UX/SmartSuggestionsService.php`
- Line (v34): `412`
- Evidence: `? (float) bcmul(bcdiv(bcsub((string) $product->default_price, (string) $product->standard_cost, 2), (string) $product->default_price, 4), '100', 2)`

### B.471 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- File: `app/Services/WhatsAppService.php`
- Line (v34): `106`
- Evidence: `return "• {$item->product->name} x{$item->qty} = ".number_format((float) $item->line_total, 2);`

### B.472 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- File: `app/Services/WhatsAppService.php`
- Line (v34): `113`
- Evidence: `'subtotal' => number_format((float) $sale->sub_total, 2),`

### B.473 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- File: `app/Services/WhatsAppService.php`
- Line (v34): `114`
- Evidence: `'tax' => number_format((float) $sale->tax_total, 2),`

### B.474 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- File: `app/Services/WhatsAppService.php`
- Line (v34): `115`
- Evidence: `'discount' => number_format((float) $sale->discount_total, 2),`

### B.475 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- File: `app/Services/WhatsAppService.php`
- Line (v34): `116`
- Evidence: `'total' => number_format((float) $sale->grand_total, 2),`

### B.476 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- File: `app/Services/WoodService.php`
- Line (v34): `39`
- Evidence: `'efficiency' => $this->efficiency((float) $payload['input_qty'], (float) $payload['output_qty']),`

### B.477 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- File: `app/Services/WoodService.php`
- Line (v34): `56`
- Evidence: `$eff = $this->efficiency((float) $row->input_qty, (float) $row->output_qty);`

### B.478 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- File: `app/Services/WoodService.php`
- Line (v34): `83`
- Evidence: `'qty' => (float) ($payload['qty'] ?? 0),`

### B.479 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- File: `app/ValueObjects/Money.php`
- Line (v34): `73`
- Evidence: `return number_format((float) $this->amount, $decimals).' '.$this->currency;`

### B.480 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- File: `app/ValueObjects/Money.php`
- Line (v34): `81`
- Evidence: `return (float) $this->amount;`

### B.481 — Medium — Security/XSS — Blade unescaped output ({!! !!})
- File: `resources/views/components/form/input.blade.php`
- Line (v34): `64`
- Evidence: `{!! sanitize_svg_icon($icon) !!}`

### B.482 — Medium — Security/XSS — Blade unescaped output ({!! !!})
- File: `resources/views/components/icon.blade.php`
- Line (v34): `37`
- Evidence: `{!! sanitize_svg_icon($iconPath) !!}`

### B.483 — Medium — Security/XSS — Blade unescaped output ({!! !!})
- File: `resources/views/components/ui/button.blade.php`
- Line (v34): `44`
- Evidence: `{!! sanitize_svg_icon($icon) !!}`

### B.484 — Medium — Security/XSS — Blade unescaped output ({!! !!})
- File: `resources/views/components/ui/card.blade.php`
- Line (v34): `17`
- Evidence: `{!! sanitize_svg_icon($icon) !!}`

### B.485 — Medium — Security/XSS — Blade unescaped output ({!! !!})
- File: `resources/views/components/ui/card.blade.php`
- Line (v34): `39`
- Evidence: `{!! $actions !!}`

### B.486 — Medium — Security/XSS — Blade unescaped output ({!! !!})
- File: `resources/views/components/ui/empty-state.blade.php`
- Line (v34): `32`
- Evidence: `{!! sanitize_svg_icon($displayIcon) !!}`

### B.487 — Medium — Security/XSS — Blade unescaped output ({!! !!})
- File: `resources/views/components/ui/form/input.blade.php`
- Line (v34): `50`
- Evidence: `{!! sanitize_svg_icon($icon) !!}`

### B.488 — Medium — Security/XSS — Blade unescaped output ({!! !!})
- File: `resources/views/components/ui/form/input.blade.php`
- Line (v34): `61`
- Evidence: `@if($wireModel) {!! $wireDirective !!} @endif`

### B.489 — Medium — Security/XSS — Blade unescaped output ({!! !!})
- File: `resources/views/components/ui/page-header.blade.php`
- Line (v34): `45`
- Evidence: `{!! sanitize_svg_icon($icon) !!}`

### B.490 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- File: `resources/views/livewire/admin/dashboard.blade.php`
- Line (v34): `51`
- Evidence: `'data' => $salesSeries->pluck('total')->map(fn ($v) => (float) $v)->toArray(),`

### B.491 — Medium — Security/XSS — Blade unescaped output ({!! !!})
- File: `resources/views/livewire/auth/two-factor-setup.blade.php`
- Line (v34): `54`
- Evidence: `{!! $qrCodeSvg !!}`

### B.492 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- File: `resources/views/livewire/manufacturing/bills-of-materials/index.blade.php`
- Line (v34): `146`
- Evidence: `<td>{{ number_format((float)$bom->quantity, 2) }}</td>`

### B.493 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- File: `resources/views/livewire/manufacturing/production-orders/index.blade.php`
- Line (v34): `151`
- Evidence: `<td>{{ number_format((float)$order->quantity_planned, 2) }}</td>`

### B.494 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- File: `resources/views/livewire/manufacturing/production-orders/index.blade.php`
- Line (v34): `152`
- Evidence: `<td>{{ number_format((float)$order->quantity_produced, 2) }}</td>`

### B.495 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- File: `resources/views/livewire/manufacturing/work-centers/index.blade.php`
- Line (v34): `148`
- Evidence: `<td>{{ number_format((float)$workCenter->cost_per_hour, 2) }}</td>`

### B.496 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- File: `resources/views/livewire/purchases/returns/index.blade.php`
- Line (v34): `62`
- Evidence: `<td class="font-mono text-orange-600">{{ number_format((float)$return->total, 2) }}</td>`

### B.497 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- File: `resources/views/livewire/purchases/returns/index.blade.php`
- Line (v34): `111`
- Evidence: `{{ number_format((float)$purchase->grand_total, 2) }}`

### B.498 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- File: `resources/views/livewire/purchases/returns/index.blade.php`
- Line (v34): `120`
- Evidence: `<p class="text-sm"><strong>{{ __('Total') }}:</strong> {{ number_format((float)$selectedPurchase->grand_total, 2) }}</p>`

### B.499 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- File: `resources/views/livewire/sales/returns/index.blade.php`
- Line (v34): `62`
- Evidence: `<td class="font-mono text-red-600">{{ number_format((float)$return->total, 2) }}</td>`

### B.500 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- File: `resources/views/livewire/sales/returns/index.blade.php`
- Line (v34): `111`
- Evidence: `{{ number_format((float)$sale->grand_total, 2) }}`

### B.501 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- File: `resources/views/livewire/sales/returns/index.blade.php`
- Line (v34): `120`
- Evidence: `<p class="text-sm"><strong>{{ __('Total') }}:</strong> {{ number_format((float)$selectedSale->grand_total, 2) }}</p>`

### B.502 — Medium — Security/XSS — Blade unescaped output ({!! !!})
- File: `resources/views/livewire/shared/dynamic-form.blade.php`
- Line (v34): `39`
- Evidence: `<span class="text-slate-400">{!! sanitize_svg_icon($icon) !!}</span>`

### B.503 — Medium — Finance/Precision — Float cast in money/qty context (rounding drift risk)
- File: `resources/views/livewire/shared/dynamic-table.blade.php`
- Line (v34): `214`
- Evidence: `<span class="font-medium">{{ $currency }}{{ number_format((float)$value, 2) }}</span>`

### B.504 — Medium — Security/XSS — Blade unescaped output ({!! !!})
- File: `resources/views/livewire/shared/dynamic-table.blade.php`
- Line (v34): `260`
- Evidence: `{!! sanitize_svg_icon($actionIcon) !!}`
