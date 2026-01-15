# APMO ERP v22 – New & Unfixed Bugs Report

**Project ZIP:** `apmoerpv22.zip`  
**Frameworks:** Laravel **v12.0.11**, Livewire **v4.0.0-beta.5** (from `composer.lock`)  

> ✅ هذا التقرير يحتوي **فقط** على الـ **Bugs الجديدة** التي تم اكتشافها في هذه النسخة، **وأي Bugs ما زالت موجودة ولم يتم إصلاحها**.  
> ❌ لم أدرج المشاكل التي تم إصلاحها بالفعل.

---

## Severity Legend
- **CRITICAL**: توقف النظام/ميزة أساسية، أو فساد بيانات مالي/مخزون، أو تسريب بيانات فروع.
- **HIGH**: خلل كبير يسبب نتائج خاطئة/سلوك غير آمن/أخطاء تشغيل متكررة.
- **MEDIUM**: خلل وظيفي/منطقي مهم لكنه لا يوقف النظام بالكامل.
- **LOW**: سلوك غير متوقع/تحسينات أو حالات حافة.

---

## CRITICAL Bugs

### V22-CRIT-01 — Store Token & Webhooks شبه معطّلين بسبب BranchScope (Fail-Closed)
**Category:** Multi-Branch / API Integration / System Break

**Files & Evidence**
- `app/Models/Scopes/BranchScope.php` (Fail-closed عند عدم وجود User وعدم وجود Explicit Branch Context) — مثلًا **L97-L134**.
- `app/Models/Store.php` يملك `branch_id` (وبالتالي سيخضع للـ BranchScope) — **L26-L37**.
- `app/Http/Middleware/AuthenticateStoreToken.php` يقوم بتحميل الـ Store عبر العلاقة: `$storeToken->store` — **L41**.
- `app/Http/Controllers/Api/V1/WebhooksController.php` يقوم بتحميل الـ Store عبر `Store::...->first()` — **L28, L67, L161**.
- `routes/api.php` مجموعة Routes الخاصة بالـ store token/webhooks لا تستخدم `api-core` ولا `api-branch` (لا يوجد `SetBranchContext` ولا `ClearBranchContext`) — **L48-L118**.

**Problem**
- الـ `BranchScope` مصمم ليعمل **fail-closed** عندما لا يوجد مستخدم (auth user) ولا يوجد Explicit Branch Context.
- طلبات **Store Token** و **Webhooks** غالبًا تكون بدون مستخدم (auth user) وبالتالي:
  - تحميل `Store` سيفشل (يرجع `null`) داخل `AuthenticateStoreToken`.
  - تحميل `Store` سيفشل داخل `WebhooksController`.
  - نتيجة ذلك: **403/404** أو عمليات Integrations لا تعمل أساسًا.

**Impact**
- فشل كامل أو شبه كامل لأي تكامل Store/Woo/Shopify يعتمد على هذه الـ endpoints.

**Suggested Fix**
- في `AuthenticateStoreToken`:
  1) تحميل الـ Store بـ `withoutGlobalScopes()` (أو على الأقل بدون BranchScope) عند جلبه من الـ token.
  2) بعد معرفة `branch_id` للـ Store: استدعاء `BranchContextManager::setBranchContext($store->branch_id)` + وضع `request()->attributes->set('branch_id', ...)`.
  3) إضافة `ClearBranchContext` لمجموعة store-token routes (أو إضافتها داخل نفس middleware كـ terminable behavior).
- في `WebhooksController`: تحميل الـ Store بـ `withoutGlobalScopes()` أولًا ثم ضبط BranchContext.

---

### V22-CRIT-02 — Webhooks/Store Sync يقوم بعمل Inventory Adjust بدون Warehouse وبالتالي **سيفشل دائمًا**
**Category:** Inventory / Integration

**Files & Evidence**
- `app/Services/InventoryService.php` دالة `adjust()` تشترط Warehouse: ترمي Exception لو `warehouseId` غير موجود — **L71-L78**.
- `app/Http/Controllers/Api/V1/WebhooksController.php` يستدعي `InventoryService::adjust(..., null, ...)` — **L248-L255**.
- `app/Services/Store/StoreSyncService.php` يستدعي `InventoryService::adjust(..., null, ...)` — **L233-L240**.

**Problem**
- `InventoryService::adjust()` يرفض التعديل بدون Warehouse.
- الـ Webhook handlers يمررون `warehouseId = null` دائمًا.

**Impact**
- أي Webhook للتحديث على المخزون سيفشل (Exception) وبالتالي:
  - المخزون لن يتزامن.
  - قد يحدث تراكم retries / فشل الـ job / logging بدون إصلاح.

**Suggested Fix**
- لازم تحديد warehouse مناسب:
  - إما `default_warehouse_id` للفرع (Branch setting) أو warehouse خاص بالـ Store.
  - أو إرسال warehouse_id ضمن payload للـ webhook.
- بديل: تحديث `InventoryService::adjust` لدعم تعديل "على مستوى الفرع" عبر اختيار Warehouse افتراضي داخليًا (لكن هذا قرار تصميم).

---

### V22-CRIT-03 — Dashboard: بيانات فواتير الإيجار Due **غير مرتبطة بالفرع** (تسريب بيانات بين الفروع)
**Category:** Multi-Branch / Data Leakage

**File & Evidence**
- `app/Services/Dashboard/DashboardDataService.php` دالة `generateRentInvoicesDueData(?int $branchId)` لا تستخدم `$branchId` وتستعمل `DB::table('rental_invoices')` بدون أي فلترة على الفرع — **L259-L290**.

**Problem**
- الـ Dashboard سيعرض فواتير إيجار مستحقة عبر **كل الفروع** لأي مستخدم فرع.

**Impact**
- تسريب بيانات مالية حساسة بين الفروع + تقارير Dashboard خاطئة.

**Suggested Fix**
- إذا `rental_invoices` لا تحتوي `branch_id`: لازم join على `rental_contracts`/`properties` للوصول للفرع.
- أو إضافة `branch_id` للفواتير وتعبئتها.

---

## HIGH Bugs

### V22-HIGH-01 — ProductsController: بعض Endpoints الخاصة بالـ Store Token تتطلب Auth User بالخطأ
**Category:** API / Integration

**File & Evidence**
- `app/Http/Controllers/Api/V1/ProductsController.php`
  - `show()` يتحقق من `auth()->user()` ويُرجع 401 — **L110-L128**.
  - `destroy()` كذلك — **L346-L361**.

**Problem**
- Routes `store.token` هدفها أن تعمل بدون User session (تعمل بـ token).
- `index()` لا يطلب auth user بينما `show/destroy` تطلبه → عدم اتساق يؤدي لتعطيل endpoints.

**Impact**
- المتجر يستطيع جلب قائمة منتجات لكن لا يستطيع جلب تفاصيل منتج / حذف منتج حسب هذا الكود.

**Suggested Fix**
- إزالة شرط `auth()->user()` من مسارات store.token، والاعتماد على store token فقط.
- لو تريد مسار POS فقط، افصل routes/controller أو ضع middleware مختلف.

---

### V22-HIGH-02 — ProductsController: تحقق Unique SKU غير Scoped بالفرع
**Category:** Multi-Branch / Data Integrity

**File & Evidence**
- `app/Http/Controllers/Api/V1/ProductsController.php` في `update()`:
  - `unique:products,sku,{$id}` — **L269**.

**Problem**
- في نظام متعدد الفروع غالبًا SKU قد يتكرر بين الفروع.
- هذا الـ validation يمنع تحديث/إنشاء SKU حتى لو التعارض في فرع آخر.

**Impact**
- أخطاء تشغيل غير مبررة للمستخدمين + تعطيل إدارة المنتجات.

**Suggested Fix**
- استخدام `Rule::unique('products','sku')->ignore($id)->where('branch_id', $store->branch_id)` (أو حسب التصميم: allow global uniqueness).

---

### V22-HIGH-03 — OrdersController: `exists` validations غير Scoped → ممكن ربط Order ببيانات فرع آخر
**Category:** Multi-Branch / Data Integrity

**File & Evidence**
- `app/Http/Controllers/Api/V1/OrdersController.php` في `store()`:
  - `customer_id => exists:customers,id` — **L68**
  - `items.*.product_id => exists:products,id` — **L74**
  - `warehouse_id => exists:warehouses,id` — **L81**

**Problem**
- `exists` validation لا يطبق BranchScope.
- يمكن إرسال IDs لعميل/منتج/مخزن من فرع آخر، ويقبلها validation.

**Impact**
- بيانات Orders/Sales قد تشير لكيانات من فروع أخرى → علاقات مكسورة وتقارير خاطئة.

**Suggested Fix**
- استخدام `Rule::exists(...)->where('branch_id', $branchId)` للـ customers/products/warehouses.

---

### V22-HIGH-04 — OrdersController: حساب المدفوعات يعتمد فقط على status=completed
**Category:** Finance / Logic

**File & Evidence**
- `app/Http/Controllers/Api/V1/OrdersController.php` في `updateStatus()`:
  - `$order->payments->where('status', 'completed')->sum('amount')` — **L301-L304**.

**Problem**
- نظام المدفوعات في أماكن أخرى قد يعتبر حالات أخرى مثل `posted`/`paid` (ويوجد accessor في `Sale` مثل `total_paid`).
- هذا قد يجعل `payment_status` خاطئ (مثلاً يظل unpaid رغم وجود مدفوعات).

**Impact**
- أخطاء مالية وتقارير Payment Status غير دقيقة.

**Suggested Fix**
- اعتماد `Sale::total_paid` أو توحيد حالات الدفع المعتمدة في مكان واحد.

---

### V22-HIGH-05 — Purchases Livewire Form: منطق الخصم Discount خاطئ + لا يتم حفظه
**Category:** Finance / Critical Logic

**File & Evidence**
- `app/Livewire/Purchases/Form.php`
  - يتم طرح `discount` كـ **قيمة** وليس كنسبة (percent) — **L255-L268**.
  - عند إنشاء PurchaseItem يتم تثبيت `discount_percent => 0` دائمًا — **L363-L366**.

**Problem**
- `PurchaseItem` يحتوي `discount_percent` (نسبة) وليس `discount_amount`.
- الـ UI يحسب الخصم لكنه لا يكتبه في DB، وبالتالي totals في DB قد تختلف.

**Impact**
- أخطاء في إجمالي الفاتورة، الضريبة، التقارير، وأي حسابات مالية لاحقة.

**Suggested Fix**
- توحيد مفهوم الخصم (Percent vs Amount):
  - لو Percent: احسب `discountAmount = lineSubtotal * discount/100`.
  - خزّن `discount_percent` = قيمة المستخدم.
  - تأكد أن line_total و header totals تُحسب بنفس المنطق.

---

### V22-HIGH-06 — Sales Livewire Form: Totals تعتمد على float بينما line_total تُحسب بـ BCMath
**Category:** Finance / Precision

**File & Evidence**
- `app/Livewire/Sales/Form.php`
  - `getSubTotalProperty/getTaxTotalProperty/getGrandTotalProperty` تستخدم floats — **L286-L329**.
  - داخل `save()` يتم حساب `line_total` بـ BCMath بينما header totals تأتي من getters float — **L379-L416**.

**Problem**
- اختلاف أسلوب الحساب قد ينتج:
  - total_amount لا يساوي مجموع line_totals.
  - فروقات كسور تؤثر على حالة الدفع، الذمم، القيود.

**Impact**
- أخطاء مالية دقيقة لكنها مؤثرة (خصوصًا مع ضريبة/خصومات متعددة).

**Suggested Fix**
- اعتماد BCMath (أو Money Value Object) في **كل** حسابات totals.
- أو حساب header totals من مجموع line_totals المخزنة (المحسوبة بنفس الأسلوب).

---

### V22-HIGH-07 — Sale Returns: اختيار أول SaleItem فقط لنفس المنتج + عدم تتبع المرتجعات السابقة
**Category:** Finance / Inventory / Logic

**File & Evidence**
- `app/Services/SaleService.php` في `handleReturn()`:
  - `firstWhere('product_id', ...)` — **L76-L78**.
  - كاب للكمية على `min(returnQty, originalQty)` فقط بدون اعتبار مرتجعات سابقة — **L80-L88**.
  - تعيين `sale->status = 'returned'` حتى لو جزئي — **L107-L114**.

**Problem**
- إذا نفس المنتج موجود في أكثر من سطر (أسعار/دفعات مختلفة) سيتم اختيار أول سطر فقط.
- يمكن عمل أكثر من Return على نفس المنتج وتجاوز الكمية الأصلية لأن الكود لا يخصم المرتجعات السابقة.

**Impact**
- Refund خاطئ + مخزون خاطئ + فساد بيانات على المدى الطويل.

**Suggested Fix**
- ربط return بـ `sale_item_id` بدل `product_id` فقط.
- تتبع الكمية المرتجعة سابقًا لكل سطر.
- دعم partial return بدون تغيير sale status إلى returned كليًا.

---

### V22-HIGH-08 — Inventory/Stock Quantity: جزء كبير من النظام يعتمد على `products.stock_quantity` رغم أنه غير مُحدّث مع sales/purchases
**Category:** Inventory / Reporting / Finance

**Evidence**
- لا يوجد أي تحديث لـ `products.stock_quantity` داخل listeners الخاصة بالبيع/الشراء (`UpdateStockOnSale/UpdateStockOnPurchase`)؛ يتم إنشاء stock_movements فقط.
- بينما عدة خدمات/تقارير تعتمد على `stock_quantity` مثل:
  - `app/Services/Analytics/InventoryTurnoverService.php` — يستخدم `stock_quantity` في حسابات turnover — **L41-L52, L89-L99**.
  - `app/Livewire/Dashboard/CustomizableDashboard.php` — يحسب قيمة المخزون من `stock_quantity` — **L245-L255**.
  - `app/Services/Analytics/KPIDashboardService.php` — Low stock/out of stock/value — **L107-L127**.

**Problem**
- يوجد "مصدر حقيقة" للمخزون (`stock_movements`) لكن `stock_quantity` يبدو كـ cache.
- هذا الـ cache لا يتم تحديثه في أغلب التدفقات المهمة (Sales/Purchases).

**Impact**
- تقارير Analytics/Turnover/Inventory Value و KPIs ستكون **خاطئة** أو متذبذبة.

**Suggested Fix**
- خيار 1 (الأفضل): إزالة الاعتماد على `stock_quantity` بالكامل واستخدام `StockService`/subqueries محسوبة من stock_movements.
- خيار 2: تحديث `stock_quantity` بشكل موحد عند أي stock movement (event/listener) + job لإعادة التزامن الدوري.

---

## MEDIUM Bugs

### V22-MED-01 — ScheduledReportService: توليد PDF/Excel غير حقيقي (امتداد PDF/XLSX لكن المحتوى HTML/CSV)
**Category:** Reporting

**File & Evidence**
- `app/Services/ScheduledReportService.php`
  - `generatePdf()` يرجع HTML string — **L318-L354**.
  - `generateExcel()` يرجع CSV string — **L372-L387**.
  - بينما `getMimeType()` يرجع `application/pdf` و `application/vnd.openxmlformats...` — **L440-L447**.

**Impact**
- المرفقات التي تصل عبر البريد ستكون غير قابلة للفتح كـ PDF/XLSX (ملف PDF يحتوي HTML، وxlsx يحتوي CSV).

**Suggested Fix**
- استخدام Dompdf/Snappy للـ PDF.
- استخدام Laravel Excel (Maatwebsite) أو إنشاء CSV لكن بامتداد `.csv` و mime type صحيح.

---

### V22-MED-02 — HasBranch::isAccessibleByUser قد يُرجع false خطأ بسبب relationLoaded
**Category:** Multi-Branch / Authorization

**File & Evidence**
- `app/Traits/HasBranch.php`
  - `isAccessibleByUser()` لا يتحقق من pivot branches إلا إذا كانت العلاقة محمّلة مسبقًا — **L172-L182**.

**Impact**
- أي استدعاء لهذه الدالة بدون `->load('branches')` قد يعطي نتيجة خاطئة (رفض وصول صحيح).

**Suggested Fix**
- إزالة شرط `relationLoaded` والاعتماد على query pivot مباشرة عند الحاجة.

---

### V22-MED-03 — HasBranch auto-assign للـ branch_id مرتبط بوجود `branch_id` داخل fillable
**Category:** Multi-Branch / Data Consistency

**File & Evidence**
- `app/Traits/HasBranch.php` في `bootHasBranch()` — **L35-L48**.

**Problem**
- لو model لديه `branch_id` في الجدول لكن `branch_id` غير موجود في fillable (محمي)، لن يتم تعيين branch_id تلقائيًا.

**Impact**
- Records قد تُحفظ بـ `branch_id = null` وتصبح "غير مرئية" بسبب BranchScope أو تسبب فساد بيانات.

**Suggested Fix**
- الاعتماد على Schema column check بدل fillable، أو تعيين branch_id عبر `forceFill` عند الإنشاء.

---

### V22-MED-04 — Analytics Service فيها أجزاء Placeholder (نتائج فارغة دائمًا)
**Category:** Analytics / Feature Incomplete

**File & Evidence**
- `app/Services/Analytics/AdvancedAnalyticsService.php`
  - عدة دوال ترجع `[]` مباشرة (مثل `getPreviousPeriodSales/getProductMetrics/getCustomerInsights/...`) — **L391-L436**.
- `app/Livewire/Admin/Analytics/AdvancedDashboard.php` يعتمد عليها — يظهر في استخدام الخدمة.

**Impact**
- Dashboard/Analytics قد تعرض أرقام 0 أو أقسام فارغة رغم وجود بيانات.

**Suggested Fix**
- تنفيذ الدوال أو إخفاء الأقسام غير المكتملة من الـ UI لتجنب نتائج مضللة.

---

### V22-MED-05 — ClosePosDayJob: إذا تم تشغيله بدون branchId سيعطي نتائج صفر بسبب BranchScope
**Category:** Jobs / Multi-Branch

**File & Evidence**
- `app/Jobs/ClosePosDayJob.php`
  - `__construct(?int $branchId = null)` — **L19-L24**
  - في `handle()` يتم عمل query على `Sale::query()` بدون ضبط BranchContext إذا كانت branchId = null — **L38-L71**

**Impact**
- لو تم dispatch للـ job بدون branchId → سيغلق اليوم بأرقام صفر أو لن يعمل كما هو متوقع.

**Suggested Fix**
- اجعل branchId إلزامي، أو نفّذ loop على الفروع النشطة داخل job.

---

## Notes
- لم يتم تضمين الـ DB seeds/data في التقييم (حسب طلبك).  
- بعض البنود أعلاه تتعلق بتصميم متعدد الفروع: إذا كان قرارك أن بعض الكيانات "Global" (مش مرتبطة بفرع) فالأفضل توضيح ذلك رسميًا في الـ schema والمنطق (بدل الاعتماد على `branch_id = null` بشكل غير موحّد).


---

## Additional Findings (Deep Scan Additions)

### V22-CRIT-09 — Stock movements are queued + may throw exceptions after the Sale/Purchase is already committed
**Category:** Inventory / Critical ERP Consistency

**Files & Evidence**
- `app/Listeners/UpdateStockOnSale.php`
  - Listener is queued: `implements ShouldQueue` — **L14**.
  - Throws on insufficient stock — **L51-L72**.
- `app/Listeners/UpdateStockOnPurchase.php`
  - Listener is queued: `implements ShouldQueue` — **L14**.
  - Throws on invalid quantity — **L25-L35**.

**Problem**
- لو الـ job فشل (بسبب عدم كفاية المخزون/warehouse null/…)، فالـ **Sale/Purchase already saved** (status = completed/received) بينما stock_movements **لم تُكتب**.
- لا يوجد “تعويض/rollback” أو تغيير status إلى حالة خطأ.

**Impact**
- فساد بيانات: Sale/Purchase مكتملة بدون تأثير على المخزون.
- أخطاء في التقارير والـ KPI والـ COGS لاحقًا.

**Suggested Fix**
- نقل validation (خصوصًا “insufficient stock”) إلى **قبل** تغيير status إلى completed.
- أو تنفيذ stock movements بشكل synchronous داخل نفس transaction الخاصة بـ completion.
- أو Implement تعويض: عند فشل job يتم وضع sale/purchase في status “stock_error” + alert + إمكانية retry.

---

### V22-HIGH-09 — Purchases receiving: استخدام `quantity` بدل `received_quantity` + الـ UI يحفظ `received_quantity = 0`
**Category:** Inventory / Finance

**Files & Evidence**
- `app/Listeners/UpdateStockOnPurchase.php`
  - يستخدم `item->quantity` كمقدار إضافة للمخزون — **L25-L28, L64-L66**.
- `app/Livewire/Purchases/Form.php`
  - عند إنشاء البنود يتم ضبط `received_quantity` دائمًا = 0 — **L366**.

**Problem**
- وجود عمود `received_quantity` يوحي بدعم partial receiving.
- لكن listener يعتمد على `quantity` دائمًا.
- وفي نفس الوقت الـ form لا يملأ `received_quantity` حتى لو تم اختيار status = received.

**Impact**
- في حالة partial receiving (أو أي اختلاف بين ordered vs received) → المخزون سيتسجل خطأ.

**Suggested Fix**
- عند status = received (في الـ form): اضبط `received_quantity = quantity` لكل بند.
- أو في listener: استخدم `received_quantity` إن كان موجودًا/ممتلئًا وإلا fallback إلى `quantity`.

---

### V22-HIGH-10 — Store-token Customers API: unique rules غير branch-scoped + صلاحيات حذف بدون قيود
**Category:** Multi-Branch / Security / Data Integrity

**File & Evidence**
- `app/Http/Controllers/Api/V1/CustomersController.php`
  - `unique:customers,email` و `unique:customers,phone` بدون where(branch_id) — **L92-L99**.
  - إنشاء customer مع `branch_id` من store (قد تكون null لو store غير متاح) — **L122**.
  - `destroy()` لا يحتوي authorization واضح للـ store-token context — **L200-L212**.

**Impact**
- تعارضات بين الفروع.
- خطر حذف بيانات العملاء عبر token (لو token تم تسريبه أو صلاحياته كبيرة).

**Suggested Fix**
- اجعل الـ unique scoped على `branch_id` (إذا العملاء Branch-scoped).
- امنع delete من store-token أو اجعله فقط soft-delete + permission.

---

### V22-HIGH-11 — KPI Dashboard: استخدام `products.is_active` (غير متسق مع باقي الكود الذي يعتمد `status`)
**Category:** Analytics / Runtime Bug

**File & Evidence**
- `app/Services/Analytics/KPIDashboardService.php`
  - `Product::query()->where('is_active', true)` — **L102-L105**.

**Problem**
- في v22 تم تعديل أجزاء أخرى لاستخدام `status` بدل `is_active`.
- هذا الجزء قد يسبب:
  - SQL error لو العمود غير موجود.
  - أو نتائج غير متوقعة لو العمود موجود لكن لا يتم تحديثه.

**Suggested Fix**
- توحيد المنطق: `where('status', 'active')` أو استخدام `Product::active()`.

