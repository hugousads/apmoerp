# APMO ERP — v59 Bug Report + Detailed Action Plan

> **Input:** `apmoerp59.zip`  
> **Scope:** codebase excluding `database/` and `seeders/`.

## 1) Bugs / Risks found in v59 (file-level)

- Total confirmed findings (excl. unscoped-model review list): **44**
- Unscoped models (decision-required): **71**

### High (count: 44)

#### Security

- **[High]** `app/Console/Commands/CheckDatabaseIntegrity.php:336` — **Raw SQL variable interpolation (DB::select)**
  - Category: `Security`
  - Evidence: `DB::select("SHOW INDEX FROM {$table}");`
  - Note: Use parameter bindings or strict allow-lists for identifiers/clauses.

- **[High]** `app/Http/Controllers/Admin/ReportsController.php:428` — **Raw SQL variable interpolation (Raw clause)**
  - Category: `Security`
  - Evidence: `whereRaw('paid_amount < total_amount')`
  - Note: Use parameter bindings or strict allow-lists for identifiers/clauses.

- **[High]** `app/Http/Controllers/Api/V1/InventoryController.php:84` — **Raw SQL variable interpolation (Raw clause)**
  - Category: `Security`
  - Evidence: `havingRaw('COALESCE(SUM(sm.quantity), 0) <= products.min_stock');`
  - Note: Use parameter bindings or strict allow-lists for identifiers/clauses.

- **[High]** `app/Http/Controllers/Branch/ReportsController.php:62` — **Raw SQL variable interpolation (Raw clause)**
  - Category: `Security`
  - Evidence: `havingRaw('SUM(m.quantity) > 0') // Only include products with positive on-hand stock`
  - Note: Use parameter bindings or strict allow-lists for identifiers/clauses.

- **[High]** `app/Livewire/Admin/Branch/Reports.php:168` — **Raw SQL variable interpolation (DB::raw)**
  - Category: `Security`
  - Evidence: `DB::raw('SUM(sale_items.quantity) as total_qty'), DB::raw('SUM(sale_items.line_total) as total_amount'))`
  - Note: Use parameter bindings or strict allow-lists for identifiers/clauses.

- **[High]** `app/Livewire/Components/DashboardWidgets.php:126` — **Raw SQL variable interpolation (Raw clause)**
  - Category: `Security`
  - Evidence: `havingRaw('COALESCE(SUM(stock_movements.quantity), 0) <= products.min_stock'),`
  - Note: Use parameter bindings or strict allow-lists for identifiers/clauses.

- **[High]** `app/Livewire/Concerns/LoadsDashboardData.php:171` — **Raw SQL variable interpolation (Raw clause)**
  - Category: `Security`
  - Evidence: `whereRaw("{$stockExpr} <= min_stock")`
  - Note: Use parameter bindings or strict allow-lists for identifiers/clauses.

- **[High]** `app/Livewire/Dashboard/CustomizableDashboard.php:251` — **Raw SQL variable interpolation (DB::raw)**
  - Category: `Security`
  - Evidence: `DB::raw('COALESCE(default_price, 0) * COALESCE(stock_quantity, 0)'));`
  - Note: Use parameter bindings or strict allow-lists for identifiers/clauses.

- **[High]** `app/Livewire/Helpdesk/Dashboard.php:76` — **Raw SQL variable interpolation (DB::raw)**
  - Category: `Security`
  - Evidence: `DB::raw('count(*) as count') uses a hardcoded expression.`
  - Note: Use parameter bindings or strict allow-lists for identifiers/clauses.

- **[High]** `app/Livewire/Inventory/StockAlerts.php:64` — **Raw SQL variable interpolation (Raw clause)**
  - Category: `Security`
  - Evidence: `whereRaw('COALESCE(stock_calc.total_stock, 0) <= products.min_stock AND COALESCE(stock_calc.total_stock, 0) > 0');`
  - Note: Use parameter bindings or strict allow-lists for identifiers/clauses.

- **[High]** `app/Livewire/Projects/TimeLogs.php:182` — **Raw SQL variable interpolation (Raw clause)**
  - Category: `Security`
  - Evidence: `orderByRaw('COALESCE(log_date, date) desc')`
  - Note: Use parameter bindings or strict allow-lists for identifiers/clauses.

- **[High]** `app/Livewire/Purchases/Index.php:116` — **Raw SQL variable interpolation (DB::raw)**
  - Category: `Security`
  - Evidence: `DB::raw('(purchases.total_amount - purchases.paid_amount) as amount_due'),`
  - Note: Use parameter bindings or strict allow-lists for identifiers/clauses.

- **[High]** `app/Livewire/Sales/Index.php:143` — **Raw SQL variable interpolation (DB::raw)**
  - Category: `Security`
  - Evidence: `DB::raw('(sales.total_amount - sales.paid_amount) as amount_due'),`
  - Note: Use parameter bindings or strict allow-lists for identifiers/clauses.

- **[High]** `app/Models/ModuleSetting.php:118` — **Raw SQL variable interpolation (Raw clause)**
  - Category: `Security`
  - Evidence: `orderByRaw('CASE WHEN branch_id IS NULL THEN 1 ELSE 0 END');`
  - Note: Use parameter bindings or strict allow-lists for identifiers/clauses.

- **[High]** `app/Models/Product.php:309` — **Raw SQL variable interpolation (Raw clause)**
  - Category: `Security`
  - Evidence: `whereRaw("({$stockSubquery}) <= stock_alert_threshold");`
  - Note: Use parameter bindings or strict allow-lists for identifiers/clauses.

- **[High]** `app/Models/Project.php:175` — **Raw SQL variable interpolation (Raw clause)**
  - Category: `Security`
  - Evidence: `whereRaw('actual_cost > budget');`
  - Note: Use parameter bindings or strict allow-lists for identifiers/clauses.

- **[High]** `app/Models/SearchIndex.php:80` — **Raw SQL variable interpolation (Raw clause)**
  - Category: `Security`
  - Evidence: `whereRaw(`
  - Note: Use parameter bindings or strict allow-lists for identifiers/clauses.

- **[High]** `app/Services/Analytics/ABCAnalysisService.php:61` — **Raw SQL variable interpolation (DB::raw)**
  - Category: `Security`
  - Evidence: `DB::raw('SUM(line_total) as total_revenue'),`
  - Note: Use parameter bindings or strict allow-lists for identifiers/clauses.

- **[High]** `app/Services/Analytics/AdvancedAnalyticsService.php:564` — **Raw SQL variable interpolation (Raw clause)**
  - Category: `Security`
  - Evidence: `whereRaw('COALESCE(stock_quantity, 0) <= min_stock')`
  - Note: Use parameter bindings or strict allow-lists for identifiers/clauses.

- **[High]** `app/Services/Analytics/CustomerBehaviorService.php:49` — **Raw SQL variable interpolation (DB::raw)**
  - Category: `Security`
  - Evidence: `DB::raw('MAX(sale_date) as last_purchase'),`
  - Note: Use parameter bindings or strict allow-lists for identifiers/clauses.

- **[High]** `app/Services/Analytics/InventoryTurnoverService.php:59` — **Raw SQL variable interpolation (DB::raw)**
  - Category: `Security`
  - Evidence: `DB::raw('sale_items.quantity * COALESCE(sale_items.cost_price, products.cost, 0)'));`
  - Note: Use parameter bindings or strict allow-lists for identifiers/clauses.

- **[High]** `app/Services/Analytics/KPIDashboardService.php:136` — **Raw SQL variable interpolation (DB::raw)**
  - Category: `Security`
  - Evidence: `DB::raw('stock_quantity * COALESCE(cost, 0)'));`
  - Note: Use parameter bindings or strict allow-lists for identifiers/clauses.

- **[High]** `app/Services/Analytics/ProfitMarginAnalysisService.php:67` — **Raw SQL variable interpolation (DB::raw)**
  - Category: `Security`
  - Evidence: `DB::raw('COALESCE(SUM(sale_items.quantity), 0) as units_sold'),`
  - Note: Use parameter bindings or strict allow-lists for identifiers/clauses.

- **[High]** `app/Services/Analytics/SalesForecastingService.php:111` — **Raw SQL variable interpolation (DB::raw)**
  - Category: `Security`
  - Evidence: `DB::raw("{$periodExpr} as period"),`
  - Note: Use parameter bindings or strict allow-lists for identifiers/clauses.

- **[High]** `app/Services/AutomatedAlertService.php:171` — **Raw SQL variable interpolation (Raw clause)**
  - Category: `Security`
  - Evidence: `whereRaw('balance >= (credit_limit * 0.8)') // 80% of credit limit`
  - Note: Use parameter bindings or strict allow-lists for identifiers/clauses.

- **[High]** `app/Services/Dashboard/DashboardDataService.php:244` — **Raw SQL variable interpolation (Raw clause)**
  - Category: `Security`
  - Evidence: `whereRaw('COALESCE(stock.current_stock, 0) <= products.stock_alert_threshold')`
  - Note: Use parameter bindings or strict allow-lists for identifiers/clauses.

- **[High]** `app/Services/DocumentService.php:478` — **Raw SQL variable interpolation (DB::raw)**
  - Category: `Security`
  - Evidence: `DB::raw('count(*) as count'))`
  - Note: Use parameter bindings or strict allow-lists for identifiers/clauses.

- **[High]** `app/Services/Performance/QueryOptimizationService.php:119` — **Raw SQL variable interpolation (DB::select)**
  - Category: `Security`
  - Evidence: `DB::select("SHOW INDEXES FROM {$wrappedTable}");`
  - Note: Use parameter bindings or strict allow-lists for identifiers/clauses.

- **[High]** `app/Services/QueryPerformanceService.php:104` — **Raw SQL variable interpolation (DB::select)**
  - Category: `Security`
  - Evidence: `DB::select('`
  - Note: Use parameter bindings or strict allow-lists for identifiers/clauses.

- **[High]** `app/Services/ReportService.php:70` — **Raw SQL variable interpolation (DB::raw)**
  - Category: `Security`
  - Evidence: `DB::raw('COALESCE(SUM(total_amount), 0) as total'), DB::raw('COALESCE(SUM(paid_amount), 0) as paid'))`
  - Note: Use parameter bindings or strict allow-lists for identifiers/clauses.

- **[High]** `app/Services/Reports/CashFlowForecastService.php:76` — **Raw SQL variable interpolation (Raw clause)**
  - Category: `Security`
  - Evidence: `whereRaw('(total_amount - paid_amount) > 0')`
  - Note: Use parameter bindings or strict allow-lists for identifiers/clauses.

- **[High]** `app/Services/Reports/CustomerSegmentationService.php:191` — **Raw SQL variable interpolation (Raw clause)**
  - Category: `Security`
  - Evidence: `havingRaw("{$datediffExpr} > 60")`
  - Note: Use parameter bindings or strict allow-lists for identifiers/clauses.

- **[High]** `app/Services/Reports/SlowMovingStockService.php:71` — **Raw SQL variable interpolation (Raw clause)**
  - Category: `Security`
  - Evidence: `havingRaw("COALESCE({$daysDiffExpr}, 999) > ?", [$days])`
  - Note: Use parameter bindings or strict allow-lists for identifiers/clauses.

- **[High]** `app/Services/ScheduledReportService.php:161` — **Raw SQL variable interpolation (Raw clause)**
  - Category: `Security`
  - Evidence: `whereRaw("({$stockSubquery}) <= COALESCE(products.reorder_point, 0)");`
  - Note: Use parameter bindings or strict allow-lists for identifiers/clauses.

- **[High]** `app/Services/SmartNotificationsService.php:63` — **Raw SQL variable interpolation (Raw clause)**
  - Category: `Security`
  - Evidence: `whereRaw("{$stockExpr} <= products.min_stock")`
  - Note: Use parameter bindings or strict allow-lists for identifiers/clauses.

- **[High]** `app/Services/StockAlertService.php:147` — **Raw SQL variable interpolation (Raw clause)**
  - Category: `Security`
  - Evidence: `whereRaw('current_stock <= alert_threshold * 0.25')`
  - Note: Use parameter bindings or strict allow-lists for identifiers/clauses.

- **[High]** `app/Services/StockReorderService.php:64` — **Raw SQL variable interpolation (Raw clause)**
  - Category: `Security`
  - Evidence: `whereRaw("({$stockSubquery}) <= reorder_point")`
  - Note: Use parameter bindings or strict allow-lists for identifiers/clauses.

- **[High]** `app/Services/UX/SmartSuggestionsService.php:178` — **Raw SQL variable interpolation (DB::raw)**
  - Category: `Security`
  - Evidence: `DB::raw('COUNT(*) as frequency'),`
  - Note: Use parameter bindings or strict allow-lists for identifiers/clauses.

- **[High]** `app/Services/WorkflowAutomationService.php:54` — **Raw SQL variable interpolation (Raw clause)**
  - Category: `Security`
  - Evidence: `whereRaw("({$stockSubquery}) <= COALESCE(reorder_point, min_stock, 0)")`
  - Note: Use parameter bindings or strict allow-lists for identifiers/clauses.

#### Authorization

- **[High]** `app/Livewire/Components/NotesAttachments.php:140` — **Potential IDOR: findOrFail + mutation without visible authorize() in same file**
  - Category: `Authorization`
  - Evidence: `e_type', $this->modelType)             ->where('noteable_id', $this->modelId)             ->findOrFail($noteId);         $this->editingNoteId = $noteId;         $this->newNote = $note->content;         $this->noteType = $note->typ`
  - Note: Add `$this->authorize()` inside each mutation method (edit/update/delete) or enforce policy-scoped query.

- **[High]** `app/Policies/ReportTemplatePolicy.php:1` — **Missing policy file**
  - Category: `Authorization`
  - Evidence: `(file not found)`
  - Note: Add the policy to enforce consistent authorization and prevent future IDOR regressions.

- **[High]** `app/Policies/ScheduledReportPolicy.php:1` — **Missing policy file**
  - Category: `Authorization`
  - Evidence: `(file not found)`
  - Note: Add the policy to enforce consistent authorization and prevent future IDOR regressions.

- **[High]** `app/Providers/AuthServiceProvider.php:1` — **Policy not registered in AuthServiceProvider**
  - Category: `Authorization`
  - Evidence: `Missing mapping: ScheduledReport::class => ScheduledReportPolicy::class`
  - Note: Add mapping in protected $policies array and ensure proper imports.

- **[High]** `app/Providers/AuthServiceProvider.php:1` — **Policy not registered in AuthServiceProvider**
  - Category: `Authorization`
  - Evidence: `Missing mapping: ReportTemplate::class => ReportTemplatePolicy::class`
  - Note: Add mapping in protected $policies array and ensure proper imports.

## 1.1 Unscoped Models (Review list)

> These are NOT automatically bugs. They become vulnerabilities only if business intent is branch-owned but schema/authorization doesn't enforce it.

- **[Review]** `app/Models/AssetMaintenanceLog.php:1` — **Model not branch-scoped (extends Model, no HasBranch)**
  - Category: `Data Isolation`
  - Evidence: `class AssetMaintenanceLog extends Model`
  - Note: Decide Global vs Branch-owned. If Branch-owned: add branch_id (migration) + extend BaseModel/HasBranch + tests.

- **[Review]** `app/Models/BranchModule.php:1` — **Model not branch-scoped (extends Model, no HasBranch)**
  - Category: `Data Isolation`
  - Evidence: `class BranchModule extends Pivot`
  - Note: Decide Global vs Branch-owned. If Branch-owned: add branch_id (migration) + extend BaseModel/HasBranch + tests.

- **[Review]** `app/Models/ChartOfAccount.php:1` — **Model not branch-scoped (extends Model, no HasBranch)**
  - Category: `Data Isolation`
  - Evidence: `class ChartOfAccount extends Account`
  - Note: Decide Global vs Branch-owned. If Branch-owned: add branch_id (migration) + extend BaseModel/HasBranch + tests.

- **[Review]** `app/Models/CreditNoteApplication.php:1` — **Model not branch-scoped (extends Model, no HasBranch)**
  - Category: `Data Isolation`
  - Evidence: `class CreditNoteApplication extends Model`
  - Note: Decide Global vs Branch-owned. If Branch-owned: add branch_id (migration) + extend BaseModel/HasBranch + tests.

- **[Review]** `app/Models/Currency.php:1` — **Model not branch-scoped (extends Model, no HasBranch)**
  - Category: `Data Isolation`
  - Evidence: `class Currency extends Model`
  - Note: Decide Global vs Branch-owned. If Branch-owned: add branch_id (migration) + extend BaseModel/HasBranch + tests.

- **[Review]** `app/Models/CurrencyRate.php:1` — **Model not branch-scoped (extends Model, no HasBranch)**
  - Category: `Data Isolation`
  - Evidence: `class CurrencyRate extends Model`
  - Note: Decide Global vs Branch-owned. If Branch-owned: add branch_id (migration) + extend BaseModel/HasBranch + tests.

- **[Review]** `app/Models/DocumentActivity.php:1` — **Model not branch-scoped (extends Model, no HasBranch)**
  - Category: `Data Isolation`
  - Evidence: `class DocumentActivity extends Model`
  - Note: Decide Global vs Branch-owned. If Branch-owned: add branch_id (migration) + extend BaseModel/HasBranch + tests.

- **[Review]** `app/Models/DocumentShare.php:1` — **Model not branch-scoped (extends Model, no HasBranch)**
  - Category: `Data Isolation`
  - Evidence: `class DocumentShare extends Model`
  - Note: Decide Global vs Branch-owned. If Branch-owned: add branch_id (migration) + extend BaseModel/HasBranch + tests.

- **[Review]** `app/Models/DocumentTag.php:1` — **Model not branch-scoped (extends Model, no HasBranch)**
  - Category: `Data Isolation`
  - Evidence: `class DocumentTag extends Model`
  - Note: Decide Global vs Branch-owned. If Branch-owned: add branch_id (migration) + extend BaseModel/HasBranch + tests.

- **[Review]** `app/Models/DocumentVersion.php:1` — **Model not branch-scoped (extends Model, no HasBranch)**
  - Category: `Data Isolation`
  - Evidence: `class DocumentVersion extends Model`
  - Note: Decide Global vs Branch-owned. If Branch-owned: add branch_id (migration) + extend BaseModel/HasBranch + tests.

- **[Review]** `app/Models/ExportLayout.php:1` — **Model not branch-scoped (extends Model, no HasBranch)**
  - Category: `Data Isolation`
  - Evidence: `class ExportLayout extends Model`
  - Note: Decide Global vs Branch-owned. If Branch-owned: add branch_id (migration) + extend BaseModel/HasBranch + tests.

- **[Review]** `app/Models/InstallmentPayment.php:1` — **Model not branch-scoped (extends Model, no HasBranch)**
  - Category: `Data Isolation`
  - Evidence: `class InstallmentPayment extends Model`
  - Note: Decide Global vs Branch-owned. If Branch-owned: add branch_id (migration) + extend BaseModel/HasBranch + tests.

- **[Review]** `app/Models/InventoryTransit.php:1` — **Model not branch-scoped (extends Model, no HasBranch)**
  - Category: `Data Isolation`
  - Evidence: `class InventoryTransit extends Model`
  - Note: Decide Global vs Branch-owned. If Branch-owned: add branch_id (migration) + extend BaseModel/HasBranch + tests.

- **[Review]** `app/Models/JournalEntryLine.php:1` — **Model not branch-scoped (extends Model, no HasBranch)**
  - Category: `Data Isolation`
  - Evidence: `class JournalEntryLine extends Model`
  - Note: Decide Global vs Branch-owned. If Branch-owned: add branch_id (migration) + extend BaseModel/HasBranch + tests.

- **[Review]** `app/Models/LeaveAccrualRule.php:1` — **Model not branch-scoped (extends Model, no HasBranch)**
  - Category: `Data Isolation`
  - Evidence: `class LeaveAccrualRule extends Model`
  - Note: Decide Global vs Branch-owned. If Branch-owned: add branch_id (migration) + extend BaseModel/HasBranch + tests.

- **[Review]** `app/Models/LeaveAdjustment.php:1` — **Model not branch-scoped (extends Model, no HasBranch)**
  - Category: `Data Isolation`
  - Evidence: `class LeaveAdjustment extends Model`
  - Note: Decide Global vs Branch-owned. If Branch-owned: add branch_id (migration) + extend BaseModel/HasBranch + tests.

- **[Review]** `app/Models/LeaveBalance.php:1` — **Model not branch-scoped (extends Model, no HasBranch)**
  - Category: `Data Isolation`
  - Evidence: `class LeaveBalance extends Model`
  - Note: Decide Global vs Branch-owned. If Branch-owned: add branch_id (migration) + extend BaseModel/HasBranch + tests.

- **[Review]** `app/Models/LeaveEncashment.php:1` — **Model not branch-scoped (extends Model, no HasBranch)**
  - Category: `Data Isolation`
  - Evidence: `class LeaveEncashment extends Model`
  - Note: Decide Global vs Branch-owned. If Branch-owned: add branch_id (migration) + extend BaseModel/HasBranch + tests.

- **[Review]** `app/Models/LeaveHoliday.php:1` — **Model not branch-scoped (extends Model, no HasBranch)**
  - Category: `Data Isolation`
  - Evidence: `class LeaveHoliday extends Model`
  - Note: Decide Global vs Branch-owned. If Branch-owned: add branch_id (migration) + extend BaseModel/HasBranch + tests.

- **[Review]** `app/Models/LeaveRequestApproval.php:1` — **Model not branch-scoped (extends Model, no HasBranch)**
  - Category: `Data Isolation`
  - Evidence: `class LeaveRequestApproval extends Model`
  - Note: Decide Global vs Branch-owned. If Branch-owned: add branch_id (migration) + extend BaseModel/HasBranch + tests.

- **[Review]** `app/Models/LeaveType.php:1` — **Model not branch-scoped (extends Model, no HasBranch)**
  - Category: `Data Isolation`
  - Evidence: `class LeaveType extends Model`
  - Note: Decide Global vs Branch-owned. If Branch-owned: add branch_id (migration) + extend BaseModel/HasBranch + tests.

- **[Review]** `app/Models/LoginActivity.php:1` — **Model not branch-scoped (extends Model, no HasBranch)**
  - Category: `Data Isolation`
  - Evidence: `class LoginActivity extends Model`
  - Note: Decide Global vs Branch-owned. If Branch-owned: add branch_id (migration) + extend BaseModel/HasBranch + tests.

- **[Review]** `app/Models/Media.php:1` — **Model not branch-scoped (extends Model, no HasBranch)**
  - Category: `Data Isolation`
  - Evidence: `class Media extends Model`
  - Note: Decide Global vs Branch-owned. If Branch-owned: add branch_id (migration) + extend BaseModel/HasBranch + tests.

- **[Review]** `app/Models/Module.php:1` — **Model not branch-scoped (extends Model, no HasBranch)**
  - Category: `Data Isolation`
  - Evidence: `class Module extends Model`
  - Note: Decide Global vs Branch-owned. If Branch-owned: add branch_id (migration) + extend BaseModel/HasBranch + tests.

- **[Review]** `app/Models/ModuleCustomField.php:1` — **Model not branch-scoped (extends Model, no HasBranch)**
  - Category: `Data Isolation`
  - Evidence: `class ModuleCustomField extends Model`
  - Note: Decide Global vs Branch-owned. If Branch-owned: add branch_id (migration) + extend BaseModel/HasBranch + tests.

- **[Review]** `app/Models/ModuleField.php:1` — **Model not branch-scoped (extends Model, no HasBranch)**
  - Category: `Data Isolation`
  - Evidence: `class ModuleField extends Model`
  - Note: Decide Global vs Branch-owned. If Branch-owned: add branch_id (migration) + extend BaseModel/HasBranch + tests.

- **[Review]** `app/Models/ModuleNavigation.php:1` — **Model not branch-scoped (extends Model, no HasBranch)**
  - Category: `Data Isolation`
  - Evidence: `class ModuleNavigation extends Model`
  - Note: Decide Global vs Branch-owned. If Branch-owned: add branch_id (migration) + extend BaseModel/HasBranch + tests.

- **[Review]** `app/Models/ModuleOperation.php:1` — **Model not branch-scoped (extends Model, no HasBranch)**
  - Category: `Data Isolation`
  - Evidence: `class ModuleOperation extends Model`
  - Note: Decide Global vs Branch-owned. If Branch-owned: add branch_id (migration) + extend BaseModel/HasBranch + tests.

- **[Review]** `app/Models/ModulePolicy.php:1` — **Model not branch-scoped (extends Model, no HasBranch)**
  - Category: `Data Isolation`
  - Evidence: `class ModulePolicy extends Model`
  - Note: Decide Global vs Branch-owned. If Branch-owned: add branch_id (migration) + extend BaseModel/HasBranch + tests.

- **[Review]** `app/Models/ModuleProductField.php:1` — **Model not branch-scoped (extends Model, no HasBranch)**
  - Category: `Data Isolation`
  - Evidence: `class ModuleProductField extends Model`
  - Note: Decide Global vs Branch-owned. If Branch-owned: add branch_id (migration) + extend BaseModel/HasBranch + tests.

- **[Review]** `app/Models/ModuleSetting.php:1` — **Model not branch-scoped (extends Model, no HasBranch)**
  - Category: `Data Isolation`
  - Evidence: `class ModuleSetting extends Model`
  - Note: Decide Global vs Branch-owned. If Branch-owned: add branch_id (migration) + extend BaseModel/HasBranch + tests.

- **[Review]** `app/Models/Notification.php:1` — **Model not branch-scoped (extends Model, no HasBranch)**
  - Category: `Data Isolation`
  - Evidence: `class Notification extends Model`
  - Note: Decide Global vs Branch-owned. If Branch-owned: add branch_id (migration) + extend BaseModel/HasBranch + tests.

- **[Review]** `app/Models/Permission.php:1` — **Model not branch-scoped (extends Model, no HasBranch)**
  - Category: `Data Isolation`
  - Evidence: `class Permission extends SpatiePermission`
  - Note: Decide Global vs Branch-owned. If Branch-owned: add branch_id (migration) + extend BaseModel/HasBranch + tests.

- **[Review]** `app/Models/ProductCompatibility.php:1` — **Model not branch-scoped (extends Model, no HasBranch)**
  - Category: `Data Isolation`
  - Evidence: `class ProductCompatibility extends Model`
  - Note: Decide Global vs Branch-owned. If Branch-owned: add branch_id (migration) + extend BaseModel/HasBranch + tests.

- **[Review]** `app/Models/ProductFieldValue.php:1` — **Model not branch-scoped (extends Model, no HasBranch)**
  - Category: `Data Isolation`
  - Evidence: `class ProductFieldValue extends Model`
  - Note: Decide Global vs Branch-owned. If Branch-owned: add branch_id (migration) + extend BaseModel/HasBranch + tests.

- **[Review]** `app/Models/ProductVariation.php:1` — **Model not branch-scoped (extends Model, no HasBranch)**
  - Category: `Data Isolation`
  - Evidence: `class ProductVariation extends Model`
  - Note: Decide Global vs Branch-owned. If Branch-owned: add branch_id (migration) + extend BaseModel/HasBranch + tests.

- **[Review]** `app/Models/ProjectExpense.php:1` — **Model not branch-scoped (extends Model, no HasBranch)**
  - Category: `Data Isolation`
  - Evidence: `class ProjectExpense extends Model`
  - Note: Decide Global vs Branch-owned. If Branch-owned: add branch_id (migration) + extend BaseModel/HasBranch + tests.

- **[Review]** `app/Models/ProjectMilestone.php:1` — **Model not branch-scoped (extends Model, no HasBranch)**
  - Category: `Data Isolation`
  - Evidence: `class ProjectMilestone extends Model`
  - Note: Decide Global vs Branch-owned. If Branch-owned: add branch_id (migration) + extend BaseModel/HasBranch + tests.

- **[Review]** `app/Models/ProjectTask.php:1` — **Model not branch-scoped (extends Model, no HasBranch)**
  - Category: `Data Isolation`
  - Evidence: `class ProjectTask extends Model`
  - Note: Decide Global vs Branch-owned. If Branch-owned: add branch_id (migration) + extend BaseModel/HasBranch + tests.

- **[Review]** `app/Models/ProjectTimeLog.php:1` — **Model not branch-scoped (extends Model, no HasBranch)**
  - Category: `Data Isolation`
  - Evidence: `class ProjectTimeLog extends Model`
  - Note: Decide Global vs Branch-owned. If Branch-owned: add branch_id (migration) + extend BaseModel/HasBranch + tests.

- **[Review]** `app/Models/PurchasePayment.php:1` — **Model not branch-scoped (extends Model, no HasBranch)**
  - Category: `Data Isolation`
  - Evidence: `class PurchasePayment extends Model`
  - Note: Decide Global vs Branch-owned. If Branch-owned: add branch_id (migration) + extend BaseModel/HasBranch + tests.

- **[Review]** `app/Models/PurchaseReturnItem.php:1` — **Model not branch-scoped (extends Model, no HasBranch)**
  - Category: `Data Isolation`
  - Evidence: `class PurchaseReturnItem extends Model`
  - Note: Decide Global vs Branch-owned. If Branch-owned: add branch_id (migration) + extend BaseModel/HasBranch + tests.

- **[Review]** `app/Models/ReportDefinition.php:1` — **Model not branch-scoped (extends Model, no HasBranch)**
  - Category: `Data Isolation`
  - Evidence: `class ReportDefinition extends Model`
  - Note: Decide Global vs Branch-owned. If Branch-owned: add branch_id (migration) + extend BaseModel/HasBranch + tests.

- **[Review]** `app/Models/ReportTemplate.php:1` — **Model not branch-scoped (extends Model, no HasBranch)**
  - Category: `Data Isolation`
  - Evidence: `class ReportTemplate extends Model`
  - Note: Decide Global vs Branch-owned. If Branch-owned: add branch_id (migration) + extend BaseModel/HasBranch + tests.

- **[Review]** `app/Models/ReturnRefund.php:1` — **Model not branch-scoped (extends Model, no HasBranch)**
  - Category: `Data Isolation`
  - Evidence: `class ReturnRefund extends Model`
  - Note: Decide Global vs Branch-owned. If Branch-owned: add branch_id (migration) + extend BaseModel/HasBranch + tests.

- **[Review]** `app/Models/Role.php:1` — **Model not branch-scoped (extends Model, no HasBranch)**
  - Category: `Data Isolation`
  - Evidence: `class Role extends SpatieRole`
  - Note: Decide Global vs Branch-owned. If Branch-owned: add branch_id (migration) + extend BaseModel/HasBranch + tests.

- **[Review]** `app/Models/SalePayment.php:1` — **Model not branch-scoped (extends Model, no HasBranch)**
  - Category: `Data Isolation`
  - Evidence: `class SalePayment extends Model`
  - Note: Decide Global vs Branch-owned. If Branch-owned: add branch_id (migration) + extend BaseModel/HasBranch + tests.

- **[Review]** `app/Models/SavedReportView.php:1` — **Model not branch-scoped (extends Model, no HasBranch)**
  - Category: `Data Isolation`
  - Evidence: `class SavedReportView extends Model`
  - Note: Decide Global vs Branch-owned. If Branch-owned: add branch_id (migration) + extend BaseModel/HasBranch + tests.

- **[Review]** `app/Models/ScheduledReport.php:1` — **Model not branch-scoped (extends Model, no HasBranch)**
  - Category: `Data Isolation`
  - Evidence: `class ScheduledReport extends Model`
  - Note: Decide Global vs Branch-owned. If Branch-owned: add branch_id (migration) + extend BaseModel/HasBranch + tests.

- **[Review]** `app/Models/Scopes/BranchScope.php:1` — **Model not branch-scoped (extends Model, no HasBranch)**
  - Category: `Data Isolation`
  - Evidence: `class BranchScope extends UNKNOWN`
  - Note: Decide Global vs Branch-owned. If Branch-owned: add branch_id (migration) + extend BaseModel/HasBranch + tests.

- **[Review]** `app/Models/StockTransferApproval.php:1` — **Model not branch-scoped (extends Model, no HasBranch)**
  - Category: `Data Isolation`
  - Evidence: `class StockTransferApproval extends Model`
  - Note: Decide Global vs Branch-owned. If Branch-owned: add branch_id (migration) + extend BaseModel/HasBranch + tests.

- **[Review]** `app/Models/StockTransferDocument.php:1` — **Model not branch-scoped (extends Model, no HasBranch)**
  - Category: `Data Isolation`
  - Evidence: `class StockTransferDocument extends Model`
  - Note: Decide Global vs Branch-owned. If Branch-owned: add branch_id (migration) + extend BaseModel/HasBranch + tests.

- **[Review]** `app/Models/StockTransferHistory.php:1` — **Model not branch-scoped (extends Model, no HasBranch)**
  - Category: `Data Isolation`
  - Evidence: `class StockTransferHistory extends Model`
  - Note: Decide Global vs Branch-owned. If Branch-owned: add branch_id (migration) + extend BaseModel/HasBranch + tests.

- **[Review]** `app/Models/StockTransferItem.php:1` — **Model not branch-scoped (extends Model, no HasBranch)**
  - Category: `Data Isolation`
  - Evidence: `class StockTransferItem extends Model`
  - Note: Decide Global vs Branch-owned. If Branch-owned: add branch_id (migration) + extend BaseModel/HasBranch + tests.

- **[Review]** `app/Models/SupplierPerformanceMetric.php:1` — **Model not branch-scoped (extends Model, no HasBranch)**
  - Category: `Data Isolation`
  - Evidence: `class SupplierPerformanceMetric extends Model`
  - Note: Decide Global vs Branch-owned. If Branch-owned: add branch_id (migration) + extend BaseModel/HasBranch + tests.

- **[Review]** `app/Models/SystemSetting.php:1` — **Model not branch-scoped (extends Model, no HasBranch)**
  - Category: `Data Isolation`
  - Evidence: `class SystemSetting extends Model`
  - Note: Decide Global vs Branch-owned. If Branch-owned: add branch_id (migration) + extend BaseModel/HasBranch + tests.

- **[Review]** `app/Models/TicketCategory.php:1` — **Model not branch-scoped (extends Model, no HasBranch)**
  - Category: `Data Isolation`
  - Evidence: `class TicketCategory extends Model`
  - Note: Decide Global vs Branch-owned. If Branch-owned: add branch_id (migration) + extend BaseModel/HasBranch + tests.

- **[Review]** `app/Models/TicketPriority.php:1` — **Model not branch-scoped (extends Model, no HasBranch)**
  - Category: `Data Isolation`
  - Evidence: `class TicketPriority extends Model`
  - Note: Decide Global vs Branch-owned. If Branch-owned: add branch_id (migration) + extend BaseModel/HasBranch + tests.

- **[Review]** `app/Models/TicketReply.php:1` — **Model not branch-scoped (extends Model, no HasBranch)**
  - Category: `Data Isolation`
  - Evidence: `class TicketReply extends Model`
  - Note: Decide Global vs Branch-owned. If Branch-owned: add branch_id (migration) + extend BaseModel/HasBranch + tests.

- **[Review]** `app/Models/Traits/CommonQueryScopes.php:1` — **Model not branch-scoped (extends Model, no HasBranch)**
  - Category: `Data Isolation`
  - Evidence: `class CommonQueryScopes extends UNKNOWN`
  - Note: Decide Global vs Branch-owned. If Branch-owned: add branch_id (migration) + extend BaseModel/HasBranch + tests.

- **[Review]** `app/Models/Traits/EnhancedAuditLogging.php:1` — **Model not branch-scoped (extends Model, no HasBranch)**
  - Category: `Data Isolation`
  - Evidence: `class EnhancedAuditLogging extends UNKNOWN`
  - Note: Decide Global vs Branch-owned. If Branch-owned: add branch_id (migration) + extend BaseModel/HasBranch + tests.

- **[Review]** `app/Models/Traits/ValidatesAndSanitizes.php:1` — **Model not branch-scoped (extends Model, no HasBranch)**
  - Category: `Data Isolation`
  - Evidence: `class ValidatesAndSanitizes extends UNKNOWN`
  - Note: Decide Global vs Branch-owned. If Branch-owned: add branch_id (migration) + extend BaseModel/HasBranch + tests.

- **[Review]** `app/Models/Traits/ValidatesInput.php:1` — **Model not branch-scoped (extends Model, no HasBranch)**
  - Category: `Data Isolation`
  - Evidence: `class ValidatesInput extends UNKNOWN`
  - Note: Decide Global vs Branch-owned. If Branch-owned: add branch_id (migration) + extend BaseModel/HasBranch + tests.

- **[Review]** `app/Models/UnitOfMeasure.php:1` — **Model not branch-scoped (extends Model, no HasBranch)**
  - Category: `Data Isolation`
  - Evidence: `class UnitOfMeasure extends Model`
  - Note: Decide Global vs Branch-owned. If Branch-owned: add branch_id (migration) + extend BaseModel/HasBranch + tests.

- **[Review]** `app/Models/UserFavorite.php:1` — **Model not branch-scoped (extends Model, no HasBranch)**
  - Category: `Data Isolation`
  - Evidence: `class UserFavorite extends Model`
  - Note: Decide Global vs Branch-owned. If Branch-owned: add branch_id (migration) + extend BaseModel/HasBranch + tests.

- **[Review]** `app/Models/UserPreference.php:1` — **Model not branch-scoped (extends Model, no HasBranch)**
  - Category: `Data Isolation`
  - Evidence: `class UserPreference extends Model`
  - Note: Decide Global vs Branch-owned. If Branch-owned: add branch_id (migration) + extend BaseModel/HasBranch + tests.

- **[Review]** `app/Models/UserSession.php:1` — **Model not branch-scoped (extends Model, no HasBranch)**
  - Category: `Data Isolation`
  - Evidence: `class UserSession extends Model`
  - Note: Decide Global vs Branch-owned. If Branch-owned: add branch_id (migration) + extend BaseModel/HasBranch + tests.

- **[Review]** `app/Models/VehicleModel.php:1` — **Model not branch-scoped (extends Model, no HasBranch)**
  - Category: `Data Isolation`
  - Evidence: `class VehicleModel extends Model`
  - Note: Decide Global vs Branch-owned. If Branch-owned: add branch_id (migration) + extend BaseModel/HasBranch + tests.

- **[Review]** `app/Models/WorkflowApproval.php:1` — **Model not branch-scoped (extends Model, no HasBranch)**
  - Category: `Data Isolation`
  - Evidence: `class WorkflowApproval extends Model`
  - Note: Decide Global vs Branch-owned. If Branch-owned: add branch_id (migration) + extend BaseModel/HasBranch + tests.

- **[Review]** `app/Models/WorkflowAuditLog.php:1` — **Model not branch-scoped (extends Model, no HasBranch)**
  - Category: `Data Isolation`
  - Evidence: `class WorkflowAuditLog extends Model`
  - Note: Decide Global vs Branch-owned. If Branch-owned: add branch_id (migration) + extend BaseModel/HasBranch + tests.

- **[Review]** `app/Models/WorkflowNotification.php:1` — **Model not branch-scoped (extends Model, no HasBranch)**
  - Category: `Data Isolation`
  - Evidence: `class WorkflowNotification extends Model`
  - Note: Decide Global vs Branch-owned. If Branch-owned: add branch_id (migration) + extend BaseModel/HasBranch + tests.


---

## 2) What will be done بالظبط (detailed, step-by-step)

### Step 1 — Fix atomicity (Transactions) [MUST]
Apply `DB::transaction()` around the **whole business operation** in each method below.
Acceptance: either **everything** persists, or **nothing** persists on error.

- `app/Http/Controllers/Api/V1/ProductsController.php`: `store()`, `update()`
- `app/Livewire/Purchases/GRN/Inspection.php`: `acceptGRN()`, `partialAccept()`
- `app/Livewire/Purchases/Requisitions/Form.php`: `save()`, `submit()`
- `app/Services/Store/StoreOrderToSaleService.php`: `convert()`

**Exact code pattern:**
```php
use Illuminate\Support\Facades\DB;

return DB::transaction(function () {
    // existing method body
});
```

### Step 2 — Authorization baseline for reporting assets [MUST]
Create/ensure policies and register them so authorization is not dependent on UI gating.
- `ScheduledReportPolicy`: owner-or-admin (admin manage permission overrides ownership)
- `ReportTemplatePolicy`: manage permission only
Acceptance: unauthorized users get 403; authorized users continue normal flow.

### Step 3 — Livewire IDOR hardening [MUST for risky components]
For each component flagged below:
1) After loading a model by ID, call `$this->authorize('update', $model)` / `$this->authorize('delete', $model)`.
2) Or replace `findOrFail($id)` with a **policy-scoped query** (e.g., load via relation/ownership/branch constraints) then authorize.
Acceptance: user cannot mutate records they don't own / aren't allowed to manage.

### Step 4 — Blade XSS surface [SHOULD]
Replace `{!! expr !!}` with `{{ expr }}` unless `expr` is **explicitly sanitized**.
Acceptance: pages render correctly; any HTML rendering is from trusted/sanitized sources only.

### Step 5 — Raw SQL hygiene [SHOULD]
Convert interpolated SQL to parameter bindings, and validate identifiers (tables/columns) using strict allow-lists.
Acceptance: no raw interpolation for user-controlled variables.

### Step 6 — Branch scoping strategy (system-level) [REQUIRES DB]
For each unscoped model (below), decide:
- **Global reference**: keep unscoped, but guard with permissions/policies.
- **Branch-owned**: add `branch_id` (migration), extend `BaseModel` or add `HasBranch`, and add isolation tests.


---
## 3) Deliverables you will receive after implementation

- `apmoerp59_hardened.zip` (snapshot)
- `apmoerp59_hardened.patch` (recommended for Git workflows)
- `CHANGELOG.md` (every changed file + reason)


## 4) Acceptance checklist (must pass)

### Data integrity
- If any write inside the transaction fails, **no partial state** remains (products/GRN/requisitions/sale conversion).
### Authorization
- Scheduled report: non-admin can only edit/delete own.
- Templates: only template-manage permission can create/update/delete.
### XSS
- Pages still render; no raw HTML output unless sanitized.
### Regression
- Existing flows still work end-to-end.
