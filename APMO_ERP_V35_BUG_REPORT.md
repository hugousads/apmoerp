# APMO ERP (v35) — Bug Report (New + Remaining Only)

**Generated:** 2026-01-17  
**Scope:** Full project scan (excluding DB/seeders), with regression-check against v34 report.  

## Stack verification (Laravel 12 + Livewire 4)
- **Laravel Framework:** `laravel/framework v12.44.0` (from `composer.lock`)
- **Livewire:** `livewire/livewire v4.0.1` (from `composer.lock`) ✅ *(ترقية Livewire إلى v4.0.1)*

---

## ملخص سريع (أهم ما ستجده في التقرير)
1) **تقارير/تحليلات المبيعات ما زالت في أماكن كثيرة تستخدم `created_at` بدل `sale_date`** + وفي نفس الوقت لا تستبعد حالات مثل `draft/cancelled/void/refunded` → يؤدي إلى أرقام مالية غير صحيحة وعدم اتساق مع `ReportService` الذي تم إصلاحه ليعتمد على `sale_date`.
2) **ScheduledReportService (تقرير Orders) فيه مشاكل حرجة:** لا يفلتر بالـ `branch_id` حتى لو تم تمريره، ولا يستبعد الحالات غير الإيرادية، ويستخدم `created_at` → قد يسبب **تسريب بيانات بين الفروع** + نتائج تقارير خاطئة.
3) **خدمات تحليل الربحية/الدوران (Profit/Turnover) تحسب التكلفة باستخدام `products.cost` الحالي** بدل `sale_items.cost_price` (تكلفة وقت البيع) → الربح والهامش سيتغيران “تاريخيًا” عند تعديل تكلفة المنتج لاحقًا.
4) **مشاكل توافق قواعد بيانات:** وجود `DATE_FORMAT()` (MySQL-only) داخل خدمات Analytics قد يكسر التشغيل على PostgreSQL/SQLite رغم وجود DatabaseCompatibilityService بالمشروع.
5) **Bug قديم ما زال قائم:** اختلاف طريقة احتساب قيمة المخزون (تضمين in-transit في CostingService) مقارنة بتقارير/شاشات أخرى لا تضمّن in-transit → عدم تطابق أرقام المخزون.

---

## Regression check vs v34 report
**نتيجة المراجعة:** كل بنود v34 التي كانت في `APMO_ERP_V34_BUG_REPORT.md` تم إصلاحها في v35 **ما عدا** البنود التالية (ما زالت موجودة):
- **V34-MED-03 (Still):** اختلاف قيمة المخزون بسبب تضمين in-transit في `CostingService` بينما أغلب الشاشات/التقارير الأخرى لا تضمّنه.
- **V34-MED-04 (Still):** استخدام `abort()/abort_if()` داخل طبقة Services (يفضل Exceptions + handling على مستوى Controller/Livewire).

> ملاحظة: لم يتم إعادة سرد البنود التي تم إصلاحها بالفعل داخل قائمة الـ Bugs أدناه التزامًا بطلبك.

---

# Bugs (New + Remaining)

## V35-CRIT-01 — Orders scheduled report ignores branch scoping + wrong date basis + weak status/deleted filtering
**Type:** Security/ERP consistency + Finance correctness  
**File:** `app/Services/ScheduledReportService.php`  
**Lines:** 177–206  

### Problem
`fetchOrdersReportData()`:
- لا يطبّق `branch_id` حتى لو موجود في `$filters` → خطر **Cross-branch data leakage** في نظام متعدد الفروع.
- يستخدم `sales.created_at` للفترة بدل `sale_date` (المشروع أصلًا ثبّت في تقارير أخرى أن الصحيح ماليًا هو `sale_date`).
- لا يستبعد الحالات غير الإيرادية مثل `draft/cancelled/void/refunded` بشكل افتراضي.
- لا يفلتر `deleted_at` (Soft deletes) على `sales`.

### Evidence
- `sales.created_at` + no branch filter + no deleted/status exclusions: `app/Services/ScheduledReportService.php` (177–206).

### Impact
- تقرير Orders المُجدول قد يعرض/يرسل بيانات لفروع أخرى بالخطأ.
- تقارير مالية خاطئة بسبب إدخال معاملات ملغية/مسودات أو اعتماد تاريخ إنشاء بدل تاريخ العملية.

### Suggested fix
- تطبيق: `->where('sales.branch_id', (int)$filters['branch_id'])` عند توفره.
- استبدال التصفية إلى `whereDate('sale_date', ...)` أو اعتماد `DatabaseCompatibilityService`.
- استبعاد statuses غير الإيرادية افتراضيًا (matching `fetchSalesReportData()` في نفس الملف).
- إضافة `->whereNull('sales.deleted_at')`.

---

## V35-HIGH-02 — Reporting/Analytics still use `created_at` instead of `sale_date` + inconsistent status filtering
**Type:** Finance/Logic correctness (ERP period accuracy)  

### Problem
بعد إصلاح `ReportService` ليعتمد على `sale_date`، ما زالت صفحات/خدمات تحليلات متعددة تستخدم `created_at` في التصفية والتجميع، وغالبًا بدون استبعاد statuses غير الإيرادية.
هذا يخلق **عدم اتساق** بين شاشة التقارير المالية الأساسية وبين شاشات التحليلات/التقارير الأخرى.

### Affected locations (examples)
1) **Branch reports:** `app/Livewire/Admin/Branch/Reports.php`
- `getSalesStats()` يستخدم `created_at` (75–88).
- `getTopProducts()` يعتمد `sales.created_at` ولا يفلتر statuses ولا `sales.deleted_at` (131–144).
- `getDailySales()` يعتمد `created_at` + `DATE(created_at)` (150–159).

2) **Sales analytics dashboard:** `app/Livewire/Reports/SalesAnalytics.php`
- `scopedQuery()` + trend + summary use `created_at` (122–207).
- Top products/customers/categories/payment breakdown تعتمد `sales.created_at`، ولا يوجد status filter واضح في أغلب الـ queries (234–379).
- بعض joins على `sales` لا تضيف `sales.deleted_at` filter (مثل topProducts/topCustomers/categoryPerformance).

3) **Analytics services:**
- `app/Services/Analytics/InventoryTurnoverService.php` يعتمد `sales.created_at` (23–39) وداخل subqueries (72–84, 122–129) + status filter فقط `!= cancelled`.
- `app/Services/Analytics/ProfitMarginAnalysisService.php` يعتمد `sales.created_at` + status filter فقط `!= cancelled` (29–46).
- `app/Services/Analytics/SalesForecastingService.php` يعتمد `created_at/sales.created_at` + status filter فقط `!= cancelled` (64–75, 224–239).
- `app/Services/StockReorderService.php` يعتمد `sales.created_at` + status filter فقط `!= cancelled` (118–134).

### Impact
- أرقام مبيعات/ربحية/اتجاهات تختلف عن شاشة التقارير الأساسية (لأن المصدر الزمني مختلف).
- إدخال معاملات غير نهائية أو ملغية في التحليلات.

### Suggested fix
- توحيد معيار التاريخ: استخدام `sale_date` في جميع التحليلات/التقارير المالية.
- توحيد معيار statuses: استبعاد `draft/cancelled/void/refunded` (أو على الأقل نفس القائمة في كل التقارير).
- في queries التي تستخدم JOINs على `sales` عبر Query Builder/joins: أضف `whereNull('sales.deleted_at')`.

---

## V35-HIGH-03 — Profit/COGS calculations use `products.cost` (current) instead of `sale_items.cost_price` (historical)
**Type:** Finance correctness (profit/margin integrity)  

### Problem
في خدمات التحليل، يتم احتساب التكلفة باستخدام `products.cost` (تكلفة المنتج الحالية) وليس `sale_items.cost_price` (تكلفة وقت البيع). بما أن النظام يسجل `cost_price` على مستوى SaleItem، فاستعمال تكلفة المنتج الحالية يؤدي إلى **تحريف تاريخي** للربحية عند تغيير تكلفة المنتج لاحقًا.

### Evidence
- `app/Services/Analytics/ProfitMarginAnalysisService.php`:
  - يستخدم `SUM(sale_items.quantity * COALESCE(products.cost, 0))` (38–42) بدل الاعتماد على `sale_items.cost_price`.
- `app/Services/Analytics/InventoryTurnoverService.php`:
  - COGS uses `products.cost` (28–39) + داخل subquery (72–84).

### Impact
- تقارير الربح والهامش تصبح غير موثوقة، خصوصًا عند تعديل التكلفة بعد فترة.
- قرارات تسعير/شراء خاطئة اعتمادًا على أرقام margin غير دقيقة.

### Suggested fix
- استخدام `sale_items.cost_price` (مع fallback إلى `products.cost` فقط عند null):
  - مثال: `SUM(sale_items.quantity * COALESCE(sale_items.cost_price, products.cost, 0))`.
- ضمان أن cost_price يتم تعبئته عند إنشاء sale items (يبدو أنه موجود في `POSService` و `SaleService`).

---

## V35-HIGH-04 — MySQL-specific SQL (`DATE_FORMAT`) inside Analytics breaks cross-DB compatibility
**Type:** Compatibility/Runtime bug  

### Problem
رغم وجود `DatabaseCompatibilityService` بالمشروع، يوجد استخدام مباشر لـ `DATE_FORMAT()` في خدمات تحليلات. `DATE_FORMAT` **غير مدعوم** في PostgreSQL/SQLite بالشكل نفسه.

### Evidence
- `app/Services/Analytics/SalesForecastingService.php`:
  - `DATE_FORMAT(created_at, ...)` (66–74)
  - `DATE_FORMAT(sales.created_at, '%Y-%m-%d')` (229–238)
- `app/Services/Analytics/ProfitMarginAnalysisService.php`:
  - `DATE_FORMAT(sales.created_at, ...)` (145–153)

### Impact
- تشغيل التحليلات أو صفحات تعتمد عليها سيفشل على قواعد بيانات غير MySQL.

### Suggested fix
- استبدال `DATE_FORMAT(...)` إلى expressions من `DatabaseCompatibilityService` (month/week/date truncation) أو استخدام `dbCompat`/`dbService` الموجودة في المشروع.

---

## V35-MED-05 — Inventory “total value” uses selling price (`default_price`) instead of cost
**Type:** Finance reporting bug  
**File:** `app/Livewire/Admin/Branch/Reports.php`  
**Lines:** 93–107  

### Problem
`getInventoryStats()` يحسب `total_value` كالتالي:
- `default_price * stock_quantity` (line 99)
وهذا يمثل **قيمة بيع محتملة** وليس قيمة المخزون كأصل (عادة تُحسب بالتكلفة `cost` أو weighted avg).

### Impact
- لو اعتبر المستخدم هذا الرقم “قيمة المخزون” ماليًا سيصبح مضللًا.

### Suggested fix
- لو الهدف “Inventory asset value”: استخدم `cost * on_hand_quantity` (preferably from batches/stock_movements).
- لو الهدف “Potential sales value”: غيّر اسم الحقل/الLabel لتوضيح المعنى.

---

## V35-MED-06 — Some joined analytics queries on `sales` don’t exclude soft-deleted rows
**Type:** Logic correctness / data consistency  

### Problem
في بعض الاستعلامات التي تعتمد joins على `sales` عبر Query Builder/joins، لا يتم إضافة `whereNull('sales.deleted_at')` (على عكس `loadPaymentBreakdown()` الذي أضافها). هذا قد يسبب إدخال مبيعات محذوفة منطقيًا ضمن التحليلات.

### Evidence (examples)
- `app/Livewire/Admin/Branch/Reports.php` → `getTopProducts()` join على `sales` بدون `sales.deleted_at` (131–144).
- `app/Livewire/Reports/SalesAnalytics.php` → `loadTopProducts()/loadTopCustomers()/loadCategoryPerformance()` joins على `sales` بدون `sales.deleted_at` (234–379).

### Suggested fix
- إضافة `->whereNull('sales.deleted_at')` حيثما يوجد join على `sales`.

---

## V35-MED-07 — Raw SQL string interpolation in subqueries (harder to maintain; binding/compat issues)
**Type:** Maintainability/Compatibility risk  

### Problem
`InventoryTurnoverService` يبني subqueries بـ `DB::raw('(... '.$startDate->toDateTimeString().' ...)')`.
رغم أن `$startDate` مصدره Carbon (ليس input مباشر غالبًا)، إلا أن هذا الأسلوب:
- يقلل الأمان الدفاعي (no bindings)
- أصعب في التعديل
- قد يسبب مشاكل بين قواعد البيانات المختلفة

### Evidence
- `app/Services/Analytics/InventoryTurnoverService.php` (72–84, 122–129)

### Suggested fix
- استخدام Query Builder كامل أو bindings بدل string concatenation.

---

# Remaining from v34 (still not fixed)

## V34-MED-03 (Still) — Inventory valuation includes in-transit in one place but not elsewhere
**Type:** Finance reconciliation bug  

### Problem
`CostingService::getTotalInventoryValue()` يجمع قيمة المخزون في المستودعات + قيمة المخزون in-transit (259–330). لكن تقارير/شاشات أخرى تعتمد على `stock_quantity` أو `stock_movements` بدون in-transit → **عدم تطابق**.

### Evidence
- `app/Services/CostingService.php` (259–330) يضيف `InventoryTransit` إلى `total_value`.

### Suggested fix
- توحيد تعريف “inventory value” عبر النظام (إما تضمين in-transit دائمًا أو توفير خيار/Toggle واضح).
- تحديث كل التقارير/الشاشات لتستخدم نفس المصدر (batches/transit + movements) أو توضيح الفرق في UI.

---

## V34-MED-04 (Still) — `abort()/abort_if()` inside Services layer
**Type:** Architecture/Runtime behavior bug  

### Problem
وجود `abort_if()` داخل services يجعل:
- الاختبار أصعب
- إعادة الاستخدام في CLI/Queue/APIs غير متوقعة
- التعامل مع الأخطاء يصبح HTTP-coupled

### Evidence (examples)
- `app/Services/SalesReturnService.php` يحتوي `abort_if()` في عدة نقاط (مثل 64, 94, 146, 207, 223, 284...).
- توجد حالات أخرى في Services متعددة (بحث عام: `app/Services/*`).

### Suggested fix
- استبدال `abort_if()` بـ Exceptions (DomainException/ValidationException) ثم handling على مستوى Controller/Livewire.

---

## Notes
- لم يتم إدراج أي Bugs تم إصلاحها من تقارير الإصدارات السابقة.
- إذا تحب، أقدر أعمل “Consistency pass” إضافي يطابق كل صفحات التقارير/التحليلات على معيار واحد (sale_date + statuses + soft deletes + branch scoping) ويطلع لك Checklist للتعديل.

