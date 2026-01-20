# APMO ERP v43 — Old (Unsolved) + New Bugs

## Summary
- **Compared versions:** `v42` → `v43`
- **Laravel:** `^12.0`
- **Livewire:** `^4.0.1`
- **Baseline bugs (from v42 report):** `729`
- **Old bugs fixed in v43:** `597`
- **Old bugs still present:** `132`
- **New bugs detected in v43 (by scan):** `0`

### Notes
- Static heuristic scan (no runtime tests).
- `database/` ignored as requested.
- Old-bug status: considered fixed only if old evidence is not present after whitespace normalization.

---

## Old bugs not solved yet (still present in v43)

### 1. [HIGH] selectRaw contains interpolated variable (SQL injection risk)
- **Rule ID:** `SELECT_RAW_INTERPOLATION`
- **File:** `app/Livewire/Concerns/LoadsDashboardData.php`
- **Line:** `317`
- **Evidence:** `->selectRaw("{$stockExpr} as current_quantity")`
- **Why it matters:** selectRaw contains interpolated variable (SQL injection risk)

### 2. [HIGH] selectRaw contains interpolated variable (SQL injection risk)
- **Rule ID:** `SELECT_RAW_INTERPOLATION`
- **File:** `app/Livewire/Reports/SalesAnalytics.php`
- **Line:** `248`
- **Evidence:** `->selectRaw("{$dateFormat} as period")`
- **Why it matters:** selectRaw contains interpolated variable (SQL injection risk)

### 3. [HIGH] selectRaw contains interpolated variable (SQL injection risk)
- **Rule ID:** `SELECT_RAW_INTERPOLATION`
- **File:** `app/Livewire/Reports/SalesAnalytics.php`
- **Line:** `414`
- **Evidence:** `->selectRaw("{$hourExpr} as hour")`
- **Why it matters:** selectRaw contains interpolated variable (SQL injection risk)

### 4. [HIGH] selectRaw contains interpolated variable (SQL injection risk)
- **Rule ID:** `SELECT_RAW_INTERPOLATION`
- **File:** `app/Services/Reports/CustomerSegmentationService.php`
- **Line:** `50`
- **Evidence:** `->selectRaw("{$datediffExpr} as recency_days")`
- **Why it matters:** selectRaw contains interpolated variable (SQL injection risk)

### 5. [HIGH] selectRaw contains interpolated variable (SQL injection risk)
- **Rule ID:** `SELECT_RAW_INTERPOLATION`
- **File:** `app/Services/Reports/CustomerSegmentationService.php`
- **Line:** `181`
- **Evidence:** `->selectRaw("{$datediffExpr} as days_since_purchase")`
- **Why it matters:** selectRaw contains interpolated variable (SQL injection risk)

### 6. [HIGH] selectRaw contains interpolated variable (SQL injection risk)
- **Rule ID:** `SELECT_RAW_INTERPOLATION`
- **File:** `app/Services/Reports/SlowMovingStockService.php`
- **Line:** `57`
- **Evidence:** `->selectRaw("{$daysDiffExpr} as days_since_sale")`
- **Why it matters:** selectRaw contains interpolated variable (SQL injection risk)

### 7. [HIGH] selectRaw contains interpolated variable (SQL injection risk)
- **Rule ID:** `SELECT_RAW_INTERPOLATION`
- **File:** `app/Services/SmartNotificationsService.php`
- **Line:** `60`
- **Evidence:** `->selectRaw("{$stockExpr} as current_quantity")`
- **Why it matters:** selectRaw contains interpolated variable (SQL injection risk)

### 8. [HIGH] selectRaw contains interpolated variable (SQL injection risk)
- **Rule ID:** `SELECT_RAW_INTERPOLATION`
- **File:** `app/Services/WorkflowAutomationService.php`
- **Line:** `198`
- **Evidence:** `->selectRaw("*, ({$stockSubquery}) as calculated_stock")`
- **Why it matters:** selectRaw contains interpolated variable (SQL injection risk)

### 9. [HIGH] DB::raw() argument is variable (must be strict whitelist)
- **Rule ID:** `SQL_DBRAW_VAR`
- **File:** `app/Services/Analytics/ProfitMarginAnalysisService.php`
- **Line:** `210`
- **Evidence:** `->groupBy(DB::raw($periodExpr))`
- **Why it matters:** DB::raw() argument is variable (must be strict whitelist)

### 10. [HIGH] DB::raw() argument is variable (must be strict whitelist)
- **Rule ID:** `SQL_DBRAW_VAR`
- **File:** `app/Services/Analytics/SalesForecastingService.php`
- **Line:** `117`
- **Evidence:** `->groupBy(DB::raw($periodExpr))`
- **Why it matters:** DB::raw() argument is variable (must be strict whitelist)

### 11. [HIGH] DB::raw() argument is variable (must be strict whitelist)
- **Rule ID:** `SQL_DBRAW_VAR`
- **File:** `app/Services/Analytics/SalesForecastingService.php`
- **Line:** `293`
- **Evidence:** `->groupBy(DB::raw($dateExpr))`
- **Why it matters:** DB::raw() argument is variable (must be strict whitelist)

### 12. [HIGH] DB::raw() argument is variable (must be strict whitelist)
- **Rule ID:** `SQL_DBRAW_VAR`
- **File:** `app/Services/ScheduledReportService.php`
- **Line:** `120`
- **Evidence:** `return $query->groupBy(DB::raw($dateExpr))`
- **Why it matters:** DB::raw() argument is variable (must be strict whitelist)

### 13. [HIGH] Raw SQL expression comes from variable (must be strict whitelist)
- **Rule ID:** `SQL_RAW_EXPR_VAR`
- **File:** `app/Http/Controllers/Api/StoreIntegrationController.php`
- **Line:** `99`
- **Evidence:** `->selectRaw($stockExpr.' as current_stock');`
- **Why it matters:** Raw SQL expression comes from variable (must be strict whitelist)

### 14. [HIGH] Raw SQL expression comes from variable (must be strict whitelist)
- **Rule ID:** `SQL_RAW_EXPR_VAR`
- **File:** `app/Livewire/Concerns/LoadsDashboardData.php`
- **Line:** `322`
- **Evidence:** `->orderByRaw($stockExpr)`
- **Why it matters:** Raw SQL expression comes from variable (must be strict whitelist)

### 15. [HIGH] Raw SQL string contains PHP variable (possible SQL injection / unsafe expression)
- **Rule ID:** `SQL_RAW_INTERPOLATION`
- **File:** `app/Livewire/Concerns/LoadsDashboardData.php`
- **Line:** `169`
- **Evidence:** `->whereRaw("{$stockExpr} <= min_stock")`
- **Why it matters:** Raw SQL string contains PHP variable (SQL injection risk)

### 16. [HIGH] Raw SQL string contains PHP variable (possible SQL injection / unsafe expression)
- **Rule ID:** `SQL_RAW_INTERPOLATION`
- **File:** `app/Livewire/Concerns/LoadsDashboardData.php`
- **Line:** `317`
- **Evidence:** `->selectRaw("{$stockExpr} as current_quantity")`
- **Why it matters:** Raw SQL string contains PHP variable (SQL injection risk)

### 17. [HIGH] Raw SQL string contains PHP variable (possible SQL injection / unsafe expression)
- **Rule ID:** `SQL_RAW_INTERPOLATION`
- **File:** `app/Livewire/Concerns/LoadsDashboardData.php`
- **Line:** `319`
- **Evidence:** `->whereRaw("{$stockExpr} <= products.min_stock")`
- **Why it matters:** Raw SQL string contains PHP variable (SQL injection risk)

### 18. [HIGH] Raw SQL string contains PHP variable (possible SQL injection / unsafe expression)
- **Rule ID:** `SQL_RAW_INTERPOLATION`
- **File:** `app/Livewire/Reports/SalesAnalytics.php`
- **Line:** `248`
- **Evidence:** `->selectRaw("{$dateFormat} as period")`
- **Why it matters:** Raw SQL string contains PHP variable (SQL injection risk)

### 19. [HIGH] Raw SQL string contains PHP variable (possible SQL injection / unsafe expression)
- **Rule ID:** `SQL_RAW_INTERPOLATION`
- **File:** `app/Livewire/Reports/SalesAnalytics.php`
- **Line:** `414`
- **Evidence:** `->selectRaw("{$hourExpr} as hour")`
- **Why it matters:** Raw SQL string contains PHP variable (SQL injection risk)

### 20. [HIGH] Raw SQL string contains PHP variable (possible SQL injection / unsafe expression)
- **Rule ID:** `SQL_RAW_INTERPOLATION`
- **File:** `app/Models/Product.php`
- **Line:** `306`
- **Evidence:** `->whereRaw("({$stockSubquery}) <= stock_alert_threshold");`
- **Why it matters:** Raw SQL string contains PHP variable (SQL injection risk)

### 21. [HIGH] Raw SQL string contains PHP variable (possible SQL injection / unsafe expression)
- **Rule ID:** `SQL_RAW_INTERPOLATION`
- **File:** `app/Models/Product.php`
- **Line:** `326`
- **Evidence:** `return $query->whereRaw("({$stockSubquery}) <= 0");`
- **Why it matters:** Raw SQL string contains PHP variable (SQL injection risk)

### 22. [HIGH] Raw SQL string contains PHP variable (possible SQL injection / unsafe expression)
- **Rule ID:** `SQL_RAW_INTERPOLATION`
- **File:** `app/Models/Product.php`
- **Line:** `346`
- **Evidence:** `return $query->whereRaw("({$stockSubquery}) > 0");`
- **Why it matters:** Raw SQL string contains PHP variable (SQL injection risk)

### 23. [HIGH] Raw SQL string contains PHP variable (possible SQL injection / unsafe expression)
- **Rule ID:** `SQL_RAW_INTERPOLATION`
- **File:** `app/Services/AutomatedAlertService.php`
- **Line:** `236`
- **Evidence:** `->whereRaw("({$stockSubquery}) > 0")`
- **Why it matters:** Raw SQL string contains PHP variable (SQL injection risk)

### 24. [HIGH] Raw SQL string contains PHP variable (possible SQL injection / unsafe expression)
- **Rule ID:** `SQL_RAW_INTERPOLATION`
- **File:** `app/Services/Reports/CustomerSegmentationService.php`
- **Line:** `50`
- **Evidence:** `->selectRaw("{$datediffExpr} as recency_days")`
- **Why it matters:** Raw SQL string contains PHP variable (SQL injection risk)

### 25. [HIGH] Raw SQL string contains PHP variable (possible SQL injection / unsafe expression)
- **Rule ID:** `SQL_RAW_INTERPOLATION`
- **File:** `app/Services/Reports/CustomerSegmentationService.php`
- **Line:** `181`
- **Evidence:** `->selectRaw("{$datediffExpr} as days_since_purchase")`
- **Why it matters:** Raw SQL string contains PHP variable (SQL injection risk)

### 26. [HIGH] Raw SQL string contains PHP variable (possible SQL injection / unsafe expression)
- **Rule ID:** `SQL_RAW_INTERPOLATION`
- **File:** `app/Services/Reports/SlowMovingStockService.php`
- **Line:** `57`
- **Evidence:** `->selectRaw("{$daysDiffExpr} as days_since_sale")`
- **Why it matters:** Raw SQL string contains PHP variable (SQL injection risk)

### 27. [HIGH] Raw SQL string contains PHP variable (possible SQL injection / unsafe expression)
- **Rule ID:** `SQL_RAW_INTERPOLATION`
- **File:** `app/Services/ScheduledReportService.php`
- **Line:** `154`
- **Evidence:** `$query->whereRaw("({$stockSubquery}) <= COALESCE(products.reorder_point, 0)");`
- **Why it matters:** Raw SQL string contains PHP variable (SQL injection risk)

### 28. [HIGH] Raw SQL string contains PHP variable (possible SQL injection / unsafe expression)
- **Rule ID:** `SQL_RAW_INTERPOLATION`
- **File:** `app/Services/ScheduledReportService.php`
- **Line:** `154`
- **Evidence:** `$query->whereRaw("({$stockSubquery}) <= COALESCE(products.reorder_point, 0)");`
- **Why it matters:** Raw SQL string contains PHP variable (SQL injection risk)

### 29. [HIGH] Raw SQL string contains PHP variable (possible SQL injection / unsafe expression)
- **Rule ID:** `SQL_RAW_INTERPOLATION`
- **File:** `app/Services/SmartNotificationsService.php`
- **Line:** `60`
- **Evidence:** `->selectRaw("{$stockExpr} as current_quantity")`
- **Why it matters:** Raw SQL string contains PHP variable (SQL injection risk)

### 30. [HIGH] Raw SQL string contains PHP variable (possible SQL injection / unsafe expression)
- **Rule ID:** `SQL_RAW_INTERPOLATION`
- **File:** `app/Services/SmartNotificationsService.php`
- **Line:** `61`
- **Evidence:** `->whereRaw("{$stockExpr} <= products.min_stock")`
- **Why it matters:** Raw SQL string contains PHP variable (SQL injection risk)

### 31. [HIGH] Raw SQL string contains PHP variable (possible SQL injection / unsafe expression)
- **Rule ID:** `SQL_RAW_INTERPOLATION`
- **File:** `app/Services/StockReorderService.php`
- **Line:** `61`
- **Evidence:** `->whereRaw("({$stockSubquery}) <= reorder_point")`
- **Why it matters:** Raw SQL string contains PHP variable (SQL injection risk)

### 32. [HIGH] Raw SQL string contains PHP variable (possible SQL injection / unsafe expression)
- **Rule ID:** `SQL_RAW_INTERPOLATION`
- **File:** `app/Services/StockReorderService.php`
- **Line:** `91`
- **Evidence:** `->whereRaw("({$stockSubquery}) <= stock_alert_threshold")`
- **Why it matters:** Raw SQL string contains PHP variable (SQL injection risk)

### 33. [HIGH] Raw SQL string contains PHP variable (possible SQL injection / unsafe expression)
- **Rule ID:** `SQL_RAW_INTERPOLATION`
- **File:** `app/Services/StockReorderService.php`
- **Line:** `92`
- **Evidence:** `->whereRaw("({$stockSubquery}) > COALESCE(reorder_point, 0)")`
- **Why it matters:** Raw SQL string contains PHP variable (SQL injection risk)

### 34. [HIGH] Raw SQL string contains PHP variable (possible SQL injection / unsafe expression)
- **Rule ID:** `SQL_RAW_INTERPOLATION`
- **File:** `app/Services/WorkflowAutomationService.php`
- **Line:** `51`
- **Evidence:** `->whereRaw("({$stockSubquery}) <= COALESCE(reorder_point, min_stock, 0)")`
- **Why it matters:** Raw SQL string contains PHP variable (SQL injection risk)

### 35. [HIGH] Raw SQL string contains PHP variable (possible SQL injection / unsafe expression)
- **Rule ID:** `SQL_RAW_INTERPOLATION`
- **File:** `app/Services/WorkflowAutomationService.php`
- **Line:** `198`
- **Evidence:** `->selectRaw("*, ({$stockSubquery}) as calculated_stock")`
- **Why it matters:** Raw SQL string contains PHP variable (SQL injection risk)

### 36. [HIGH] Raw SQL string contains PHP variable (possible SQL injection / unsafe expression)
- **Rule ID:** `SQL_RAW_INTERPOLATION`
- **File:** `app/Services/WorkflowAutomationService.php`
- **Line:** `199`
- **Evidence:** `->orderByRaw("(COALESCE(reorder_point, min_stock, 0) - ({$stockSubquery})) DESC")`
- **Why it matters:** Raw SQL string contains PHP variable (SQL injection risk)

### 37. [HIGH] API token accepted from query/body (leak risk)
- **Rule ID:** `TOKEN_IN_QUERY`
- **File:** `app/Http/Middleware/AuthenticateStoreToken.php`
- **Line:** `203`
- **Evidence:** `$queryToken = $request->query('api_token');`
- **Why it matters:** API token accepted from query/body (leak risk)

### 38. [HIGH] API token accepted from query/body (leak risk)
- **Rule ID:** `TOKEN_IN_QUERY`
- **File:** `app/Http/Middleware/AuthenticateStoreToken.php`
- **Line:** `209`
- **Evidence:** `$bodyToken = $request->input('api_token');`
- **Why it matters:** API token accepted from query/body (leak risk)

### 39. [MEDIUM] Unescaped Blade output ({!! !!}) may cause XSS if input is not trusted
- **Rule ID:** `BLADE_UNESCAPED`
- **File:** `resources/views/components/form/input.blade.php`
- **Line:** `4`
- **Evidence:** `This component uses {!! !!} for the $icon prop. This is safe because:`
- **Why it matters:** Blade outputs unescaped content via {!! !!} (XSS risk)

### 40. [MEDIUM] Unescaped Blade output ({!! !!}) may cause XSS if input is not trusted
- **Rule ID:** `BLADE_UNESCAPED`
- **File:** `resources/views/components/form/input.blade.php`
- **Line:** `10`
- **Evidence:** `Static analysis tools may flag {!! !!} as XSS risks. This is a false positive`
- **Why it matters:** Blade outputs unescaped content via {!! !!} (XSS risk)

### 41. [MEDIUM] Unescaped Blade output ({!! !!}) may cause XSS if input is not trusted
- **Rule ID:** `BLADE_UNESCAPED`
- **File:** `resources/views/components/form/input.blade.php`
- **Line:** `76`
- **Evidence:** `{!! sanitize_svg_icon($icon) !!}`
- **Why it matters:** Blade outputs unescaped content via {!! !!} (XSS risk)

### 42. [MEDIUM] Unescaped Blade output ({!! !!}) may cause XSS if input is not trusted
- **Rule ID:** `BLADE_UNESCAPED`
- **File:** `resources/views/components/icon.blade.php`
- **Line:** `44`
- **Evidence:** `{!! sanitize_svg_icon($iconPath) !!}`
- **Why it matters:** Blade outputs unescaped content via {!! !!} (XSS risk)

### 43. [MEDIUM] Unescaped Blade output ({!! !!}) may cause XSS if input is not trusted
- **Rule ID:** `BLADE_UNESCAPED`
- **File:** `resources/views/components/ui/button.blade.php`
- **Line:** `5`
- **Evidence:** `This component uses {!! !!} to render SVG icons. This is safe because:`
- **Why it matters:** Blade outputs unescaped content via {!! !!} (XSS risk)

### 44. [MEDIUM] Unescaped Blade output ({!! !!}) may cause XSS if input is not trusted
- **Rule ID:** `BLADE_UNESCAPED`
- **File:** `resources/views/components/ui/button.blade.php`
- **Line:** `11`
- **Evidence:** `Static analysis tools may flag {!! !!} as XSS risks. This is a false positive`
- **Why it matters:** Blade outputs unescaped content via {!! !!} (XSS risk)

### 45. [MEDIUM] Unescaped Blade output ({!! !!}) may cause XSS if input is not trusted
- **Rule ID:** `BLADE_UNESCAPED`
- **File:** `resources/views/components/ui/button.blade.php`
- **Line:** `56`
- **Evidence:** `{!! sanitize_svg_icon($icon) !!}`
- **Why it matters:** Blade outputs unescaped content via {!! !!} (XSS risk)

### 46. [MEDIUM] Unescaped Blade output ({!! !!}) may cause XSS if input is not trusted
- **Rule ID:** `BLADE_UNESCAPED`
- **File:** `resources/views/components/ui/card.blade.php`
- **Line:** `3`
- **Evidence:** `SECURITY NOTE: This component uses {!! !!} for two types of content:`
- **Why it matters:** Blade outputs unescaped content via {!! !!} (XSS risk)

### 47. [MEDIUM] Unescaped Blade output ({!! !!}) may cause XSS if input is not trusted
- **Rule ID:** `BLADE_UNESCAPED`
- **File:** `resources/views/components/ui/card.blade.php`
- **Line:** `27`
- **Evidence:** `{!! sanitize_svg_icon($icon) !!}`
- **Why it matters:** Blade outputs unescaped content via {!! !!} (XSS risk)

### 48. [MEDIUM] Blade outputs unescaped variable (XSS risk)
- **Rule ID:** `BLADE_UNESCAPED`
- **File:** `resources/views/components/ui/card.blade.php`
- **Line:** `50`
- **Evidence:** `{!! $actions !!}`
- **Why it matters:** Blade outputs unescaped content via {!! !!} (XSS risk)

### 49. [MEDIUM] Unescaped Blade output ({!! !!}) may cause XSS if input is not trusted
- **Rule ID:** `BLADE_UNESCAPED`
- **File:** `resources/views/components/ui/empty-state.blade.php`
- **Line:** `5`
- **Evidence:** `This component uses {!! !!} for SVG icons. This is safe because:`
- **Why it matters:** Blade outputs unescaped content via {!! !!} (XSS risk)

### 50. [MEDIUM] Unescaped Blade output ({!! !!}) may cause XSS if input is not trusted
- **Rule ID:** `BLADE_UNESCAPED`
- **File:** `resources/views/components/ui/empty-state.blade.php`
- **Line:** `10`
- **Evidence:** `Static analysis tools may flag {!! !!} as XSS risks. This is a false positive`
- **Why it matters:** Blade outputs unescaped content via {!! !!} (XSS risk)

### 51. [MEDIUM] Unescaped Blade output ({!! !!}) may cause XSS if input is not trusted
- **Rule ID:** `BLADE_UNESCAPED`
- **File:** `resources/views/components/ui/empty-state.blade.php`
- **Line:** `43`
- **Evidence:** `{!! sanitize_svg_icon($displayIcon) !!}`
- **Why it matters:** Blade outputs unescaped content via {!! !!} (XSS risk)

### 52. [MEDIUM] Unescaped Blade output ({!! !!}) may cause XSS if input is not trusted
- **Rule ID:** `BLADE_UNESCAPED`
- **File:** `resources/views/components/ui/form/input.blade.php`
- **Line:** `3`
- **Evidence:** `SECURITY NOTE: This component uses {!! !!} for:`
- **Why it matters:** Blade outputs unescaped content via {!! !!} (XSS risk)

### 53. [MEDIUM] Unescaped Blade output ({!! !!}) may cause XSS if input is not trusted
- **Rule ID:** `BLADE_UNESCAPED`
- **File:** `resources/views/components/ui/form/input.blade.php`
- **Line:** `60`
- **Evidence:** `{!! sanitize_svg_icon($icon) !!}`
- **Why it matters:** Blade outputs unescaped content via {!! !!} (XSS risk)

### 54. [MEDIUM] Blade outputs unescaped variable (XSS risk)
- **Rule ID:** `BLADE_UNESCAPED`
- **File:** `resources/views/components/ui/form/input.blade.php`
- **Line:** `72`
- **Evidence:** `@if($wireModel) {!! $wireDirective !!} @endif`
- **Why it matters:** Blade outputs unescaped content via {!! !!} (XSS risk)

### 55. [MEDIUM] Unescaped Blade output ({!! !!}) may cause XSS if input is not trusted
- **Rule ID:** `BLADE_UNESCAPED`
- **File:** `resources/views/components/ui/page-header.blade.php`
- **Line:** `5`
- **Evidence:** `This component uses {!! !!} for the $icon prop. This is safe because:`
- **Why it matters:** Blade outputs unescaped content via {!! !!} (XSS risk)

### 56. [MEDIUM] Unescaped Blade output ({!! !!}) may cause XSS if input is not trusted
- **Rule ID:** `BLADE_UNESCAPED`
- **File:** `resources/views/components/ui/page-header.blade.php`
- **Line:** `11`
- **Evidence:** `Static analysis tools may flag {!! !!} as XSS risks. This is a false positive`
- **Why it matters:** Blade outputs unescaped content via {!! !!} (XSS risk)

### 57. [MEDIUM] Unescaped Blade output ({!! !!}) may cause XSS if input is not trusted
- **Rule ID:** `BLADE_UNESCAPED`
- **File:** `resources/views/components/ui/page-header.blade.php`
- **Line:** `57`
- **Evidence:** `{!! sanitize_svg_icon($icon) !!}`
- **Why it matters:** Blade outputs unescaped content via {!! !!} (XSS risk)

### 58. [MEDIUM] Blade outputs unescaped variable (XSS risk)
- **Rule ID:** `BLADE_UNESCAPED`
- **File:** `resources/views/livewire/auth/two-factor-setup.blade.php`
- **Line:** `4`
- **Evidence:** `This view uses {!! $qrCodeSvg !!} to render a QR code image. This is safe because:`
- **Why it matters:** Blade outputs unescaped content via {!! !!} (XSS risk)

### 59. [MEDIUM] Blade outputs unescaped variable (XSS risk)
- **Rule ID:** `BLADE_UNESCAPED`
- **File:** `resources/views/livewire/auth/two-factor-setup.blade.php`
- **Line:** `4`
- **Evidence:** `This view uses {!! $qrCodeSvg !!} to render a QR code image. This is safe because:`
- **Why it matters:** Blade outputs unescaped content via {!! !!} (XSS risk)

### 60. [MEDIUM] Unescaped Blade output ({!! !!}) may cause XSS if input is not trusted
- **Rule ID:** `BLADE_UNESCAPED`
- **File:** `resources/views/livewire/auth/two-factor-setup.blade.php`
- **Line:** `9`
- **Evidence:** `Static analysis tools may flag {!! !!} as XSS risks. This is a false positive`
- **Why it matters:** Blade outputs unescaped content via {!! !!} (XSS risk)

### 61. [MEDIUM] Unescaped Blade output ({!! !!}) may cause XSS if input is not trusted
- **Rule ID:** `BLADE_UNESCAPED`
- **File:** `resources/views/livewire/shared/dynamic-form.blade.php`
- **Line:** `5`
- **Evidence:** `This component uses {!! !!} for the $icon field from form schema. This is safe because:`
- **Why it matters:** Blade outputs unescaped content via {!! !!} (XSS risk)

### 62. [MEDIUM] Unescaped Blade output ({!! !!}) may cause XSS if input is not trusted
- **Rule ID:** `BLADE_UNESCAPED`
- **File:** `resources/views/livewire/shared/dynamic-form.blade.php`
- **Line:** `11`
- **Evidence:** `Static analysis tools may flag {!! !!} as XSS risks. This is a false positive`
- **Why it matters:** Blade outputs unescaped content via {!! !!} (XSS risk)

### 63. [MEDIUM] Unescaped Blade output ({!! !!}) may cause XSS if input is not trusted
- **Rule ID:** `BLADE_UNESCAPED`
- **File:** `resources/views/livewire/shared/dynamic-form.blade.php`
- **Line:** `52`
- **Evidence:** `<span class="text-slate-400">{!! sanitize_svg_icon($icon) !!}</span>`
- **Why it matters:** Blade outputs unescaped content via {!! !!} (XSS risk)

### 64. [MEDIUM] Unescaped Blade output ({!! !!}) may cause XSS if input is not trusted
- **Rule ID:** `BLADE_UNESCAPED`
- **File:** `resources/views/livewire/shared/dynamic-table.blade.php`
- **Line:** `5`
- **Evidence:** `This component uses {!! !!} for action icons. This is safe because:`
- **Why it matters:** Blade outputs unescaped content via {!! !!} (XSS risk)

### 65. [MEDIUM] Unescaped Blade output ({!! !!}) may cause XSS if input is not trusted
- **Rule ID:** `BLADE_UNESCAPED`
- **File:** `resources/views/livewire/shared/dynamic-table.blade.php`
- **Line:** `11`
- **Evidence:** `Static analysis tools may flag {!! !!} as XSS risks. This is a false positive`
- **Why it matters:** Blade outputs unescaped content via {!! !!} (XSS risk)

### 66. [MEDIUM] Unescaped Blade output ({!! !!}) may cause XSS if input is not trusted
- **Rule ID:** `BLADE_UNESCAPED`
- **File:** `resources/views/livewire/shared/dynamic-table.blade.php`
- **Line:** `273`
- **Evidence:** `{!! sanitize_svg_icon($actionIcon) !!}`
- **Why it matters:** Blade outputs unescaped content via {!! !!} (XSS risk)

### 67. [MEDIUM] Float/double cast in finance/qty context (rounding drift)
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `app/ValueObjects/Money.php`
- **Line:** `73`
- **Evidence:** `return number_format((float) $this->amount, $decimals).' '.$this->currency;`
- **Why it matters:** Float cast used (precision risk for finance)

### 68. [MEDIUM] Float/double cast in finance/qty context (rounding drift)
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `app/ValueObjects/Money.php`
- **Line:** `81`
- **Evidence:** `return (float) $this->amount;`
- **Why it matters:** Float cast used (precision risk for finance)

### 69. [MEDIUM] Float/double cast in finance/qty context (rounding drift)
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `resources/views/livewire/admin/dashboard.blade.php`
- **Line:** `59`
- **Evidence:** `'data' => $salesSeries->pluck('total')->map(fn ($v) => (float) $v)->toArray(),`
- **Why it matters:** Float cast used (precision risk for finance)

### 70. [MEDIUM] Float/double cast in finance/qty context (rounding drift)
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `resources/views/livewire/hrm/employees/index.blade.php`
- **Line:** `198`
- **Evidence:** `{{ number_format((float) $employee->salary, 2) }}`
- **Why it matters:** Float cast used (precision risk for finance)

### 71. [MEDIUM] Float/double cast in finance/qty context (rounding drift)
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `resources/views/livewire/hrm/payroll/index.blade.php`
- **Line:** `86`
- **Evidence:** `{{ number_format((float) $row->basic, 2) }}`
- **Why it matters:** Float cast used (precision risk for finance)

### 72. [MEDIUM] Float/double cast in finance/qty context (rounding drift)
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `resources/views/livewire/hrm/payroll/index.blade.php`
- **Line:** `89`
- **Evidence:** `{{ number_format((float) $row->allowances, 2) }}`
- **Why it matters:** Float cast used (precision risk for finance)

### 73. [MEDIUM] Float/double cast in finance/qty context (rounding drift)
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `resources/views/livewire/hrm/payroll/index.blade.php`
- **Line:** `92`
- **Evidence:** `{{ number_format((float) $row->deductions, 2) }}`
- **Why it matters:** Float cast used (precision risk for finance)

### 74. [MEDIUM] Float/double cast in finance/qty context (rounding drift)
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `resources/views/livewire/hrm/payroll/index.blade.php`
- **Line:** `95`
- **Evidence:** `{{ number_format((float) $row->net, 2) }}`
- **Why it matters:** Float cast used (precision risk for finance)

### 75. [MEDIUM] Float/double cast in finance/qty context (rounding drift)
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `resources/views/livewire/manufacturing/bills-of-materials/index.blade.php`
- **Line:** `146`
- **Evidence:** `<td>{{ number_format((float)$bom->quantity, 2) }}</td>`
- **Why it matters:** Float cast used (precision risk for finance)

### 76. [MEDIUM] Float/double cast in finance/qty context (rounding drift)
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `resources/views/livewire/manufacturing/production-orders/index.blade.php`
- **Line:** `151`
- **Evidence:** `<td>{{ number_format((float)$order->quantity_planned, 2) }}</td>`
- **Why it matters:** Float cast used (precision risk for finance)

### 77. [MEDIUM] Float/double cast in finance/qty context (rounding drift)
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `resources/views/livewire/manufacturing/production-orders/index.blade.php`
- **Line:** `152`
- **Evidence:** `<td>{{ number_format((float)$order->quantity_produced, 2) }}</td>`
- **Why it matters:** Float cast used (precision risk for finance)

### 78. [MEDIUM] Float/double cast in finance/qty context (rounding drift)
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `resources/views/livewire/manufacturing/work-centers/index.blade.php`
- **Line:** `147`
- **Evidence:** `<td>{{ number_format((float)$workCenter->capacity_per_hour, 2) }}</td>`
- **Why it matters:** Float cast used (precision risk for finance)

### 79. [MEDIUM] Float/double cast in finance/qty context (rounding drift)
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `resources/views/livewire/manufacturing/work-centers/index.blade.php`
- **Line:** `148`
- **Evidence:** `<td>{{ number_format((float)$workCenter->cost_per_hour, 2) }}</td>`
- **Why it matters:** Float cast used (precision risk for finance)

### 80. [MEDIUM] Float/double cast in finance/qty context (rounding drift)
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `resources/views/livewire/purchases/returns/index.blade.php`
- **Line:** `62`
- **Evidence:** `<td class="font-mono text-orange-600">{{ number_format((float)$return->total, 2) }}</td>`
- **Why it matters:** Float cast used (precision risk for finance)

### 81. [MEDIUM] Float/double cast in finance/qty context (rounding drift)
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `resources/views/livewire/purchases/returns/index.blade.php`
- **Line:** `111`
- **Evidence:** `{{ number_format((float)$purchase->grand_total, 2) }}`
- **Why it matters:** Float cast used (precision risk for finance)

### 82. [MEDIUM] Float/double cast in finance/qty context (rounding drift)
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `resources/views/livewire/purchases/returns/index.blade.php`
- **Line:** `120`
- **Evidence:** `<p class="text-sm"><strong>{{ __('Total') }}:</strong> {{ number_format((float)$selectedPurchase->grand_total, 2) }}</p>`
- **Why it matters:** Float cast used (precision risk for finance)

### 83. [MEDIUM] Float/double cast in finance/qty context (rounding drift)
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `resources/views/livewire/rental/contracts/index.blade.php`
- **Line:** `96`
- **Evidence:** `{{ number_format((float) $row->rent, 2) }}`
- **Why it matters:** Float cast used (precision risk for finance)

### 84. [MEDIUM] Float/double cast in finance/qty context (rounding drift)
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `resources/views/livewire/rental/units/index.blade.php`
- **Line:** `84`
- **Evidence:** `{{ number_format((float) $unit->rent, 2) }}`
- **Why it matters:** Float cast used (precision risk for finance)

### 85. [MEDIUM] Float/double cast in finance/qty context (rounding drift)
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `resources/views/livewire/rental/units/index.blade.php`
- **Line:** `87`
- **Evidence:** `{{ number_format((float) $unit->deposit, 2) }}`
- **Why it matters:** Float cast used (precision risk for finance)

### 86. [MEDIUM] Float/double cast in finance/qty context (rounding drift)
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `resources/views/livewire/sales/returns/index.blade.php`
- **Line:** `62`
- **Evidence:** `<td class="font-mono text-red-600">{{ number_format((float)$return->total, 2) }}</td>`
- **Why it matters:** Float cast used (precision risk for finance)

### 87. [MEDIUM] Float/double cast in finance/qty context (rounding drift)
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `resources/views/livewire/sales/returns/index.blade.php`
- **Line:** `111`
- **Evidence:** `{{ number_format((float)$sale->grand_total, 2) }}`
- **Why it matters:** Float cast used (precision risk for finance)

### 88. [MEDIUM] Float/double cast in finance/qty context (rounding drift)
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `resources/views/livewire/sales/returns/index.blade.php`
- **Line:** `120`
- **Evidence:** `<p class="text-sm"><strong>{{ __('Total') }}:</strong> {{ number_format((float)$selectedSale->grand_total, 2) }}</p>`
- **Why it matters:** Float cast used (precision risk for finance)

### 89. [MEDIUM] Float/double cast in finance/qty context (rounding drift)
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `resources/views/livewire/shared/dynamic-table.blade.php`
- **Line:** `226`
- **Evidence:** `<span class="font-medium">{{ $currency }}{{ number_format((float)$value, 2) }}</span>`
- **Why it matters:** Float cast used (precision risk for finance)

### 90. [MEDIUM] Float cast/format used for money/qty (rounding drift risk)
- **Rule ID:** `FLOAT_FINANCE`
- **File:** `app/ValueObjects/Money.php`
- **Line:** `73`
- **Evidence:** `return number_format((float) $this->amount, $decimals).' '.$this->currency;`
- **Why it matters:** Float usage in finance-related calculation can cause rounding drift

### 91. [MEDIUM] Float cast/format used for money/qty (rounding drift risk)
- **Rule ID:** `FLOAT_FINANCE`
- **File:** `app/ValueObjects/Money.php`
- **Line:** `81`
- **Evidence:** `return (float) $this->amount;`
- **Why it matters:** Float usage in finance-related calculation can cause rounding drift

### 92. [MEDIUM] Float cast/format used for money/qty (rounding drift risk)
- **Rule ID:** `FLOAT_FINANCE`
- **File:** `resources/views/livewire/admin/dashboard.blade.php`
- **Line:** `59`
- **Evidence:** `'data' => $salesSeries->pluck('total')->map(fn ($v) => (float) $v)->toArray(),`
- **Why it matters:** Float usage in finance-related calculation can cause rounding drift

### 93. [MEDIUM] Float cast/format used for money/qty (rounding drift risk)
- **Rule ID:** `FLOAT_FINANCE`
- **File:** `resources/views/livewire/hrm/payroll/index.blade.php`
- **Line:** `95`
- **Evidence:** `{{ number_format((float) $row->net, 2) }}`
- **Why it matters:** Float usage in finance-related calculation can cause rounding drift

### 94. [MEDIUM] Float cast/format used for money/qty (rounding drift risk)
- **Rule ID:** `FLOAT_FINANCE`
- **File:** `resources/views/livewire/manufacturing/bills-of-materials/index.blade.php`
- **Line:** `146`
- **Evidence:** `<td>{{ number_format((float)$bom->quantity, 2) }}</td>`
- **Why it matters:** Float usage in finance-related calculation can cause rounding drift

### 95. [MEDIUM] Float cast/format used for money/qty (rounding drift risk)
- **Rule ID:** `FLOAT_FINANCE`
- **File:** `resources/views/livewire/purchases/returns/index.blade.php`
- **Line:** `62`
- **Evidence:** `<td class="font-mono text-orange-600">{{ number_format((float)$return->total, 2) }}</td>`
- **Why it matters:** Float usage in finance-related calculation can cause rounding drift

### 96. [MEDIUM] Float cast/format used for money/qty (rounding drift risk)
- **Rule ID:** `FLOAT_FINANCE`
- **File:** `resources/views/livewire/purchases/returns/index.blade.php`
- **Line:** `120`
- **Evidence:** `<p class="text-sm"><strong>{{ __('Total') }}:</strong> {{ number_format((float)$selectedPurchase->grand_total, 2) }}</p>`
- **Why it matters:** Float usage in finance-related calculation can cause rounding drift

### 97. [MEDIUM] Float cast/format used for money/qty (rounding drift risk)
- **Rule ID:** `FLOAT_FINANCE`
- **File:** `resources/views/livewire/sales/returns/index.blade.php`
- **Line:** `62`
- **Evidence:** `<td class="font-mono text-red-600">{{ number_format((float)$return->total, 2) }}</td>`
- **Why it matters:** Float usage in finance-related calculation can cause rounding drift

### 98. [MEDIUM] Float cast/format used for money/qty (rounding drift risk)
- **Rule ID:** `FLOAT_FINANCE`
- **File:** `resources/views/livewire/sales/returns/index.blade.php`
- **Line:** `120`
- **Evidence:** `<p class="text-sm"><strong>{{ __('Total') }}:</strong> {{ number_format((float)$selectedSale->grand_total, 2) }}</p>`
- **Why it matters:** Float usage in finance-related calculation can cause rounding drift

### 99. [MEDIUM] number_format((float)...) used for money (rounding drift)
- **Rule ID:** `NUMBER_FORMAT_FLOAT`
- **File:** `app/ValueObjects/Money.php`
- **Line:** `73`
- **Evidence:** `return number_format((float) $this->amount, $decimals).' '.$this->currency;`
- **Why it matters:** number_format((float)...) used for money (rounding drift)

### 100. [MEDIUM] number_format((float)...) used for money (rounding drift)
- **Rule ID:** `NUMBER_FORMAT_FLOAT`
- **File:** `resources/views/livewire/hrm/employees/index.blade.php`
- **Line:** `198`
- **Evidence:** `{{ number_format((float) $employee->salary, 2) }}`
- **Why it matters:** number_format((float)...) used for money (rounding drift)

### 101. [MEDIUM] number_format((float)...) used for money (rounding drift)
- **Rule ID:** `NUMBER_FORMAT_FLOAT`
- **File:** `resources/views/livewire/hrm/payroll/index.blade.php`
- **Line:** `86`
- **Evidence:** `{{ number_format((float) $row->basic, 2) }}`
- **Why it matters:** number_format((float)...) used for money (rounding drift)

### 102. [MEDIUM] number_format((float)...) used for money (rounding drift)
- **Rule ID:** `NUMBER_FORMAT_FLOAT`
- **File:** `resources/views/livewire/hrm/payroll/index.blade.php`
- **Line:** `89`
- **Evidence:** `{{ number_format((float) $row->allowances, 2) }}`
- **Why it matters:** number_format((float)...) used for money (rounding drift)

### 103. [MEDIUM] number_format((float)...) used for money (rounding drift)
- **Rule ID:** `NUMBER_FORMAT_FLOAT`
- **File:** `resources/views/livewire/hrm/payroll/index.blade.php`
- **Line:** `92`
- **Evidence:** `{{ number_format((float) $row->deductions, 2) }}`
- **Why it matters:** number_format((float)...) used for money (rounding drift)

### 104. [MEDIUM] number_format((float)...) used for money (rounding drift)
- **Rule ID:** `NUMBER_FORMAT_FLOAT`
- **File:** `resources/views/livewire/hrm/payroll/index.blade.php`
- **Line:** `95`
- **Evidence:** `{{ number_format((float) $row->net, 2) }}`
- **Why it matters:** number_format((float)...) used for money (rounding drift)

### 105. [MEDIUM] number_format((float)...) used for money (rounding drift)
- **Rule ID:** `NUMBER_FORMAT_FLOAT`
- **File:** `resources/views/livewire/manufacturing/bills-of-materials/index.blade.php`
- **Line:** `146`
- **Evidence:** `<td>{{ number_format((float)$bom->quantity, 2) }}</td>`
- **Why it matters:** number_format((float)...) used for money (rounding drift)

### 106. [MEDIUM] number_format((float)...) used for money (rounding drift)
- **Rule ID:** `NUMBER_FORMAT_FLOAT`
- **File:** `resources/views/livewire/manufacturing/production-orders/index.blade.php`
- **Line:** `151`
- **Evidence:** `<td>{{ number_format((float)$order->quantity_planned, 2) }}</td>`
- **Why it matters:** number_format((float)...) used for money (rounding drift)

### 107. [MEDIUM] number_format((float)...) used for money (rounding drift)
- **Rule ID:** `NUMBER_FORMAT_FLOAT`
- **File:** `resources/views/livewire/manufacturing/production-orders/index.blade.php`
- **Line:** `152`
- **Evidence:** `<td>{{ number_format((float)$order->quantity_produced, 2) }}</td>`
- **Why it matters:** number_format((float)...) used for money (rounding drift)

### 108. [MEDIUM] number_format((float)...) used for money (rounding drift)
- **Rule ID:** `NUMBER_FORMAT_FLOAT`
- **File:** `resources/views/livewire/manufacturing/work-centers/index.blade.php`
- **Line:** `147`
- **Evidence:** `<td>{{ number_format((float)$workCenter->capacity_per_hour, 2) }}</td>`
- **Why it matters:** number_format((float)...) used for money (rounding drift)

### 109. [MEDIUM] number_format((float)...) used for money (rounding drift)
- **Rule ID:** `NUMBER_FORMAT_FLOAT`
- **File:** `resources/views/livewire/manufacturing/work-centers/index.blade.php`
- **Line:** `148`
- **Evidence:** `<td>{{ number_format((float)$workCenter->cost_per_hour, 2) }}</td>`
- **Why it matters:** number_format((float)...) used for money (rounding drift)

### 110. [MEDIUM] number_format((float)...) used for money (rounding drift)
- **Rule ID:** `NUMBER_FORMAT_FLOAT`
- **File:** `resources/views/livewire/purchases/returns/index.blade.php`
- **Line:** `62`
- **Evidence:** `<td class="font-mono text-orange-600">{{ number_format((float)$return->total, 2) }}</td>`
- **Why it matters:** number_format((float)...) used for money (rounding drift)

### 111. [MEDIUM] number_format((float)...) used for money (rounding drift)
- **Rule ID:** `NUMBER_FORMAT_FLOAT`
- **File:** `resources/views/livewire/purchases/returns/index.blade.php`
- **Line:** `111`
- **Evidence:** `{{ number_format((float)$purchase->grand_total, 2) }}`
- **Why it matters:** number_format((float)...) used for money (rounding drift)

### 112. [MEDIUM] number_format((float)...) used for money (rounding drift)
- **Rule ID:** `NUMBER_FORMAT_FLOAT`
- **File:** `resources/views/livewire/purchases/returns/index.blade.php`
- **Line:** `120`
- **Evidence:** `<p class="text-sm"><strong>{{ __('Total') }}:</strong> {{ number_format((float)$selectedPurchase->grand_total, 2) }}</p>`
- **Why it matters:** number_format((float)...) used for money (rounding drift)

### 113. [MEDIUM] number_format((float)...) used for money (rounding drift)
- **Rule ID:** `NUMBER_FORMAT_FLOAT`
- **File:** `resources/views/livewire/rental/contracts/index.blade.php`
- **Line:** `96`
- **Evidence:** `{{ number_format((float) $row->rent, 2) }}`
- **Why it matters:** number_format((float)...) used for money (rounding drift)

### 114. [MEDIUM] number_format((float)...) used for money (rounding drift)
- **Rule ID:** `NUMBER_FORMAT_FLOAT`
- **File:** `resources/views/livewire/rental/units/index.blade.php`
- **Line:** `84`
- **Evidence:** `{{ number_format((float) $unit->rent, 2) }}`
- **Why it matters:** number_format((float)...) used for money (rounding drift)

### 115. [MEDIUM] number_format((float)...) used for money (rounding drift)
- **Rule ID:** `NUMBER_FORMAT_FLOAT`
- **File:** `resources/views/livewire/rental/units/index.blade.php`
- **Line:** `87`
- **Evidence:** `{{ number_format((float) $unit->deposit, 2) }}`
- **Why it matters:** number_format((float)...) used for money (rounding drift)

### 116. [MEDIUM] number_format((float)...) used for money (rounding drift)
- **Rule ID:** `NUMBER_FORMAT_FLOAT`
- **File:** `resources/views/livewire/sales/returns/index.blade.php`
- **Line:** `62`
- **Evidence:** `<td class="font-mono text-red-600">{{ number_format((float)$return->total, 2) }}</td>`
- **Why it matters:** number_format((float)...) used for money (rounding drift)

### 117. [MEDIUM] number_format((float)...) used for money (rounding drift)
- **Rule ID:** `NUMBER_FORMAT_FLOAT`
- **File:** `resources/views/livewire/sales/returns/index.blade.php`
- **Line:** `111`
- **Evidence:** `{{ number_format((float)$sale->grand_total, 2) }}`
- **Why it matters:** number_format((float)...) used for money (rounding drift)

### 118. [MEDIUM] number_format((float)...) used for money (rounding drift)
- **Rule ID:** `NUMBER_FORMAT_FLOAT`
- **File:** `resources/views/livewire/sales/returns/index.blade.php`
- **Line:** `120`
- **Evidence:** `<p class="text-sm"><strong>{{ __('Total') }}:</strong> {{ number_format((float)$selectedSale->grand_total, 2) }}</p>`
- **Why it matters:** number_format((float)...) used for money (rounding drift)

### 119. [MEDIUM] number_format((float)...) used for money (rounding drift)
- **Rule ID:** `NUMBER_FORMAT_FLOAT`
- **File:** `resources/views/livewire/shared/dynamic-table.blade.php`
- **Line:** `226`
- **Evidence:** `<span class="font-medium">{{ $currency }}{{ number_format((float)$value, 2) }}</span>`
- **Why it matters:** number_format((float)...) used for money (rounding drift)

### 120. [HIGH] orderByRaw contains interpolated variable (SQL injection risk)
- **Rule ID:** `ORDERBY_RAW_INTERPOLATION`
- **File:** `app/Services/WorkflowAutomationService.php`
- **Line:** `199`
- **Evidence:** `->orderByRaw("(COALESCE(reorder_point, min_stock, 0) - ({$stockSubquery})) DESC")`
- **Why it matters:** orderByRaw contains interpolated variable (SQL injection risk)

### 121. [HIGH] DB::raw() argument is variable (must be strict whitelist)
- **Rule ID:** `SQL_DBRAW_VAR`
- **File:** `app/Support/ValidatedSqlExpression.php`
- **Line:** `90`
- **Evidence:** `return DB::raw($this->expression);`
- **Why it matters:** DB::raw() argument is variable (must be strict whitelist)

### 122. [MEDIUM] Float cast used (precision risk for finance)
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `app/Helpers/helpers.php`
- **Line:** `497`
- **Evidence:** `return (float) $rounded;`
- **Why it matters:** Float cast used (precision risk for finance)

### 123. [MEDIUM] Blade outputs unescaped content via {!! !!} (XSS risk)
- **Rule ID:** `BLADE_UNESCAPED`
- **File:** `resources/views/livewire/auth/two-factor-setup.blade.php`
- **Line:** `4`
- **Evidence:** `{!! $qrCodeSvg !!}`
- **Why it matters:** Blade outputs unescaped content via {!! !!} (XSS risk)

### 124. [MEDIUM] Float cast/format used for money/qty (rounding drift risk)
- **Rule ID:** `FLOAT_FINANCE`
- **File:** `resources/views/livewire/manufacturing/production-orders/index.blade.php`
- **Line:** `151`
- **Evidence:** `<td>{{ number_format((float)$order->quantity_planned, 2) }}</td>`
- **Why it matters:** Float usage in finance/qty can cause subtle rounding issues.

### 125. [MEDIUM] Float cast/format used for money/qty (rounding drift risk)
- **Rule ID:** `FLOAT_FINANCE`
- **File:** `resources/views/livewire/manufacturing/production-orders/index.blade.php`
- **Line:** `152`
- **Evidence:** `<td>{{ number_format((float)$order->quantity_produced, 2) }}</td>`
- **Why it matters:** Float usage in finance/qty can cause subtle rounding issues.

### 126. [MEDIUM] Float cast/format used for money/qty (rounding drift risk)
- **Rule ID:** `FLOAT_FINANCE`
- **File:** `resources/views/livewire/manufacturing/work-centers/index.blade.php`
- **Line:** `148`
- **Evidence:** `<td>{{ number_format((float)$workCenter->cost_per_hour, 2) }}</td>`
- **Why it matters:** Float usage in finance/qty can cause subtle rounding issues.

### 127. [MEDIUM] Float cast/format used for money/qty (rounding drift risk)
- **Rule ID:** `FLOAT_FINANCE`
- **File:** `resources/views/livewire/purchases/returns/index.blade.php`
- **Line:** `111`
- **Evidence:** `{{ number_format((float)$purchase->grand_total, 2) }}`
- **Why it matters:** Float usage in finance/qty can cause subtle rounding issues.

### 128. [MEDIUM] Float cast/format used for money/qty (rounding drift risk)
- **Rule ID:** `FLOAT_FINANCE`
- **File:** `resources/views/livewire/sales/returns/index.blade.php`
- **Line:** `111`
- **Evidence:** `{{ number_format((float)$sale->grand_total, 2) }}`
- **Why it matters:** Float usage in finance/qty can cause subtle rounding issues.

### 129. [HIGH] Raw SQL string contains PHP variable (possible SQL injection / unsafe expression)
- **Rule ID:** `SQL_RAW_INTERPOLATION`
- **File:** `app/Services/ScheduledReportService.php`
- **Line:** `100`
- **Evidence:** `DB::raw("{$dateExpr} as date"),`
- **Why it matters:** Interpolated SQL fragments can be exploited unless values are strictly controlled.

### 130. [HIGH] Raw SQL string contains PHP variable (possible SQL injection / unsafe expression)
- **Rule ID:** `SQL_RAW_INTERPOLATION`
- **File:** `app/Services/Analytics/ProfitMarginAnalysisService.php`
- **Line:** `202`
- **Evidence:** `DB::raw("{$periodExpr} as period"),`
- **Why it matters:** Interpolated SQL fragments can be exploited unless values are strictly controlled.

### 131. [HIGH] Raw SQL string contains PHP variable (possible SQL injection / unsafe expression)
- **Rule ID:** `SQL_RAW_INTERPOLATION`
- **File:** `app/Services/Analytics/SalesForecastingService.php`
- **Line:** `109`
- **Evidence:** `DB::raw("{$periodExpr} as period"),`
- **Why it matters:** Interpolated SQL fragments can be exploited unless values are strictly controlled.

### 132. [HIGH] Raw SQL string contains PHP variable (possible SQL injection / unsafe expression)
- **Rule ID:** `SQL_RAW_INTERPOLATION`
- **File:** `app/Services/Analytics/SalesForecastingService.php`
- **Line:** `284`
- **Evidence:** `DB::raw("{$dateExpr} as period"),`
- **Why it matters:** Interpolated SQL fragments can be exploited unless values are strictly controlled.

---

## New bugs detected in v43

_No new bugs detected by the current heuristic scan._
