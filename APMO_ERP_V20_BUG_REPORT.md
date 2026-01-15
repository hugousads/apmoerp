# APMO ERP v20 — Bug Report (Laravel v12.44.0, Livewire v4.0.0-beta.5)

تاريخ توليد التقرير: **2026-01-15 15:05:07**  
الملف الذي تم فحصه: **apmoerpv20.zip** (بعد فك الضغط داخل: `/mnt/data/apmoerpv20`)

> **ملاحظة عن النطاق**: تم فحص ملفات المشروع (PHP/Blade/config/routes …).  
> حسب طلبك: **تجاهلت تقييم قاعدة البيانات (migrations/seeders) كمنطق/بيانات**، لكن احتجت أحيانًا قراءة بعض الملفات لاستنتاج سلوك الـ code.  
> **لم يتم تشغيل المشروع** (لا يوجد vendor/تشغيل tests)، وبالتالي التركيز هنا على bugs التي تظهر من مراجعة الكود وتحليل الترابط بين الملفات.

---

## 1) Versions / Dependencies (مؤكد من composer.lock)

- Laravel Framework: **v12.44.0**
- Livewire: **v4.0.0-beta.5**
- المشروع يعتمد على Livewire 4 **Beta** (beta.5) → هذا يزيد احتمالية تغييرات breaking لاحقًا (مش مشكلة بحد ذاته، لكنه risk).

---

## 2) Executive Summary (ملخص تنفيذي)

أكبر المشاكل المتبقية في v20 (بحسب الفحص):

1) **Scheduled / Console commands كثيرة لن تعمل فعليًا** في بيئة production بسبب `BranchScope` (fail-closed في console بدون BranchContext).  
2) **تعديل Sales/Purchases عبر Livewire Form يقوم بحذف Items/Payments وإعادة إنشائها** بدون عكس حركات المخزون/القيود/السجلات السابقة → خطر كبير جدًا على **المخزون والحسابات**.  
3) **عدم ترابط واضح بين Modules**: Sales & Purchases (Livewire UI) لا تمر على Accounting/Banking services → الـ ERP غير مترابط بالكامل (ledger/cashflow قد لا يعكس الواقع).  
4) **Store Token API**: بعض endpoints غير قابلة للاستخدام بسبب اعتمادها على `auth()->user()` (بينما store token لا ينشئ user auth)، بالإضافة لتعارض استخدام `Authorization: Bearer` للـ store token مع Sanctum.

---

## 3) Detailed Bugs (تفاصيل الباجز)

> التنسيق:  
> **ID / Severity** — *ملف* (سطر/أسطر تقريبية)  
> **المشكلة** → **التأثير** → **اقتراح إصلاح**

---

### CRIT-01 — Console/Scheduler commands لا تعمل بسبب BranchScope (Fail-Closed)

**ملفات:**
- `app/Models/Scopes/BranchScope.php` (تقريبًا سطور **91–114**, **105–112**)  
- `routes/console.php` (schedule) سطور **48**, **64**, **69–74**
- Commands متأثرة (بدون ضبط BranchContext):
  - `app/Console/Commands/CheckLowStockCommand.php` (حوالي **31–33**)
  - `app/Console/Commands/SmartNotificationsCheck.php` (حوالي **29–50**)
  - `app/Console/Commands/SendPaymentRemindersCommand.php` (حوالي **32–37**)
  - `app/Console/Commands/ExpireRentalContracts.php` (حوالي **38–43**)

**المشكلة:**
- `BranchScope` في وضع console بدون user وبدون `BranchContextManager::setBranchContext()` يقوم بـ **fail-closed**:
  - يضيف شرطين مستحيلين (`whereNull(id)` + `whereNotNull(id)`) → أي Query على موديلات فيها `branch_id` سترجع **0 rows**.

**التأثير:**
- أوامر Scheduler المذكورة في `routes/console.php` ستعمل ظاهريًا، لكن **لن تجد بيانات** وبالتالي:
  - فحص Low Stock لن يرسل تنبيهات.
  - Smart notifications لن ترسل شيئًا.
  - Expire rental contracts لن تنتهي.
  - Payment reminders لن تجد overdue sales.

**اقتراح إصلاح:**
- خيار A (أفضل): داخل كل command يعمل على بيانات branch-scoped:
  - إذا `--branch` موجود → **استدعاء** `BranchContextManager::setBranchContext($branchId)` قبل أي Eloquent query، و `clearBranchContext()` في finally.
  - إذا `--branch` غير موجود → iterate على كل الفروع:
    1) `Branch::active()->pluck('id')`
    2) set/clear لكل branch.
- خيار B: تحديث `BranchScope::isSafeConsoleCommand()` ليعتبر هذه الأوامر “safe” (لكن هذا يقلل حماية fail-closed).

---

### CRIT-02 — Sales Livewire Form: تعديل الفاتورة يمسح Items و Payments ثم يعيد إنشائها (بدون عكس تأثيرات قديمة)

**ملف:**
- `app/Livewire/Sales/Form.php`
  - حذف items: سطر **365**
  - حذف payments: سطر **366**
  - إنشاء sale: سطر **369**
  - إنشاء payment: سطر **422**
  - dispatch event للمخزون: سطر **438**

**المشكلة:**
- عند editMode:
  - `$sale->items()->delete();`
  - `$sale->payments()->delete();`
  - ثم إعادة إنشاء items/payments من الصفر.
- لو كانت الفاتورة “posted/completed” وتم توليد **Stock Movements** (listener: UpdateStockOnSale) أو تم احتساب أرصدة/تقارير بناء على المدفوعات:
  - حذف sale_items لا يعني حذف stock_movements (reference polymorphic غالبًا بدون FK).
  - إعادة dispatch لـ `SaleCompleted` بعد التعديل قد ينتج **خصم مخزون مرة ثانية** (double count) أو ترك حركات قديمة orphaned.

**التأثير (Finance/Inventory Critical):**
- **مخزون**: ممكن يتخصم مرتين أو يصبح غير متطابق مع الواقع.
- **مدفوعات**: أي تاريخ مدفوعات متعدد/جزئي سيتم مسحه واستبداله بدفعة واحدة فقط (لو أدخلت payment_amount).
- **Audit trail**: فقدان سجل تعديلات/مدفوعات.

**اقتراح إصلاح:**
- منع تعديل أي Sale بعد اعتمادها/ترحيلها (posted) أو بعد وجود payments/stock movements، أو جعل التعديل يعمل عبر:
  - “Credit Note / Return / Adjustment” بدل delete & recreate.
- إذا التعديل مسموح:
  - اعمل diff بين items القديمة والجديدة:
    - Reverse movements القديمة (أو generate adjustment movements).
  - لا تحذف payments؛ استخدم append/payments module أو allow تعديل/إلغاء دفعة منفصلة.
  - اجعل أي event/queue يعتمد على after_commit (تم ضبطه في config) لكن ما زال لازم يمنع double dispatch.

---

### CRIT-03 — Purchases Livewire Form: نفس مشكلة Sales (حذف items + إعادة dispatch للمخزون)

**ملف:**
- `app/Livewire/Purchases/Form.php`
  - حذف items: سطر **330**
  - إنشاء purchase: سطر **333**
  - dispatch `PurchaseReceived`: سطر **362**

**المشكلة/التأثير:**
- نفس منطق Sales: عند تعديل Purchase مستلمة/received سيتم:
  - حذف purchase_items، ثم إعادة إنشائها.
  - ثم dispatch event يضيف مخزون مرة ثانية.
- يؤدي إلى **زيادة مخزون وهمية** (double count) و orphaned stock movements.

**اقتراح إصلاح:**
- نفس توصيات CRIT-02: منع تعديل بعد الاستلام، أو تعديل عبر “Adjustment / Return / Debit Note”، أو عكس المخزون القديم قبل تطبيق الجديد.

---

### CRIT-04 — ترابط ERP: Sales/Purchases UI لا تخلق قيود Accounting ولا Bank Transactions

**دلائل (ملفات):**
- `app/Services/AccountingService.php` (يوجد وظائف لإنشاء journal entries)
- `app/Services/POSService.php` يستدعي `AccountingService::generateSaleJournalEntry()` (سطر ~ **310**)
- لكن:
  - `app/Livewire/Sales/Form.php` لا يستدعي AccountingService أو أي financial posting service.
  - `app/Livewire/Purchases/Form.php` لا يستدعي AccountingService.
- `app/Services/BankingService.php` **غير مستخدم** (لا يوجد references له في المشروع).
- Cashflow يعتمد على `bank_transactions`:
  - `app/Http/Controllers/Branch/ReportsController.php` سطور **85–103**
  - لكن لا يوجد flow واضح لإنشاء `bank_transactions` تلقائيًا من SalesPayments/PurchasePayments.

**المشكلة:**
- الـ UI يكتب Sales/Purchases/Payments لكن:
  - لا يولد قيود محاسبية (ledger).
  - لا يولد bank transactions.
- بالتالي Modules (Sales/Inventory/Accounting/Banking/Reports) غير مترابطة كما هو متوقع في ERP.

**التأثير:**
- التقارير المالية (PnL/Cashflow) والدفاتر قد تكون **غير صحيحة** أو صفرية.
- صعوبة audit وتوافق الحسابات.

**اقتراح إصلاح:**
- فرض مسار واحد لعمليات البيع/الشراء:
  - Controllers/Livewire يجب أن تستخدم Service layer موحد (SaleService/PurchaseService/AccountingService/BankingService).
- أو استخدام Observers/Domain Events لإنتاج:
  - Journal entries عند تغيير status إلى posted.
  - BankTransaction عند تسجيل Payment (أو على الأقل عند close POS session).

---

### CRIT-05 — Store Token API: بعض endpoints غير قابلة للاستخدام + تعارض Bearer token

**ملف:**
- `app/Http/Controllers/Api/V1/ProductsController.php`
  - `show()` يطلب `auth()->user()` (سطر **135–137**) → سيرجع 401 دائمًا مع store.token فقط.
  - `destroy()` يطلب `auth()->user()` (سطر **343–345**) → غير قابل للاستخدام مع store token.
  - إنشاء/تعديل stock movements يسجل `created_by => auth()->id()` (سطور **216**, **326**) → سيكون null غالبًا.
- `app/Http/Middleware/AuthenticateStoreToken.php`:
  - يعتمد على `Authorization: Bearer <token>` للـ store token (سطر ~ **78–85**).

**المشكلة:**
- routes في `routes/api.php` تحمي endpoints بـ `store.token:*` فقط (بدون sanctum)، وبالتالي:
  - لا يوجد `auth()->user()` من الأساس.
- بالإضافة: استخدام Bearer للـ store token يجعل من الصعب (أو مستحيل) الجمع بين Sanctum Bearer و store token في نفس الطلب.

**التأثير:**
- `GET /api/v1/products/<built-in function id>` و `DELETE /api/v1/products/<built-in function id>` عمليًا **dead endpoints**.
- أي policy/authorize يعتمد على user سيمنع store integration.
- created_by/updated_by قد تصبح null → خطر DB error أو فقدان trace.

**اقتراح إصلاح:**
- إما:
  1) إزالة شرط `auth()->user()` من endpoints الخاصة بالـ store token + استخدام store abilities بدل policies، أو
  2) تغيير طريقة إرسال store token (مثلاً header مختلف مثل `X-Store-Token`) حتى يمكن استعمال Sanctum Bearer في Authorization بدون تعارض.
- لو تريد audit: خزّن `store_token_id` أو `store_id` بدلاً من created_by.

---

### HIGH-01 — Payment Reminder Notification يحتوي link غير صحيح (/invoices)

**ملف:**
- `app/Notifications/PaymentReminderNotification.php` (سطر **40**)

**المشكلة:**
- `->action('View Invoice', url('/invoices/'.$this->alert->id))`
- لا يوجد route واضح `/invoices/<built-in function id>` في المشروع (والـ ERP يستخدم sales routes مثل `app.sales.show`).

**التأثير:**
- المستخدم سيستلم Email لكن الرابط غالبًا **404**.

**اقتراح إصلاح:**
- استخدم route name صحيح:
  - مثل `route('app.sales.show', ['sale' => $saleId])`
- لو النظام multi-branch ويحتاج branch param في المسار، ضف branch context في الرابط.

---

### HIGH-02 — SmartNotificationsService: منطق Overdue Invoices غير متناسق + توزيع المستخدمين بالـ branch_id فقط

**ملف:**
- `app/Services/SmartNotificationsService.php`
  - فلترة overdue على `status='pending'`: سطور **150**, **224**
  - `getUsersForNotification()` يفلتر بالعمود `branch_id` فقط: سطر **283**

**المشكلة:**
- overdue invoices تُحسب بالاعتماد على `Sale.status='pending'`، بينما أجزاء أخرى (AutomatedAlertService) تعتمد على `payment_status` (unpaid/partial) وهو غالبًا أدق.
- `getUsersForNotification()` لا يستخدم pivot relation `user->branches()` → المستخدم الذي لديه صلاحية على branch عبر pivot لن يستلم إشعارات إذا `user.branch_id` مختلف/فارغ.

**التأثير:**
- إشعارات متأخرة قد لا تُرسل لفواتير فعليًا unpaid لكنها status=completed.
- إشعارات قد لا تصل لمن يجب.

**اقتراح إصلاح:**
- اعتماد معيار واحد: `payment_status` + `due_date` بدل الاعتماد على status.
- استخدم BranchAccessService / pivot:
  - `whereHas('branches', fn($q)=>$q->whereKey($branchId))` أو منطق الصلاحيات الموجود في `EnsureBranchAccess`.

---

### HIGH-03 — Livewire Sales/Show و Purchases/Show: رفض خاطئ للـ multi-branch users

**ملفات:**
- `app/Livewire/Sales/Show.php` (تقريبًا سطور **24–41**)
- `app/Livewire/Purchases/Show.php` (تقريبًا سطور **24–41**)

**المشكلة:**
- يعتمد على `auth()->user()->branch_id` فقط ويعمل 403 إذا null أو مختلف.
- لا يراعي `user->branches()` pivot ولا منطق `EnsureBranchAccess` المستخدم في API.

**التأثير:**
- مستخدم عنده access لأكثر من فرع (branches pivot) قد يُمنع من عرض مبيعات/مشتريات بشكل خاطئ.

**اقتراح إصلاح:**
- بدل branch_id فقط:
  - استخدم `BranchAccessService::userHasAccessToBranch($user, $sale->branch_id)` أو `branches()->whereKey(...)`.
- (اختياري) إزالة التحقق اليدوي والاكتفاء بـ BranchScope + سياسة/permissions.

---

### MED-01 — تقرير PnL غير صحيح محاسبيًا + لا يستبعد statuses (void/cancelled/returned/refunded)

**ملف:**
- `app/Http/Controllers/Branch/ReportsController.php` (pnl) سطور **60–76**

**المشكلة:**
- يحسب `PNL = sum(sales.total_amount) - sum(purchases.total_amount)` بدون:
  - استبعاد sales/purchases الملغية/المردودة
  - احتساب مصروفات/COGS/ضرائب/خصومات/مرتجعات… إلخ

**التأثير:**
- تقرير PnL قد يكون **مضلل جدًا** خصوصًا في ERP متعدد العمليات.

**اقتراح إصلاح:**
- على الأقل:
  - فلترة status واحتساب net amounts.
- الأفضل:
  - بناء PnL من journal entries أو من financial transactions المعيارية.

---

### MED-02 — Cashflow يعتمد على bank_transactions بينما module إدخال/توليد bank transactions غير واضح/غير مرتبط بالمدفوعات

**ملف:**
- `app/Http/Controllers/Branch/ReportsController.php` (cashflow) سطور **85–103**
- `app/Services/BankingService.php` (لا يوجد استدعاءات له)

**المشكلة/التأثير:**
- لو bank_transactions لا يتم إدخالها أو توليدها، cashflow سيظهر غالبًا **0** حتى لو في SalesPayments موجودة.

**اقتراح إصلاح:**
- ربط إنشاء bank transactions عند تسجيل payment / close session / import.
- أو تعديل cashflow report ليقرأ من payments إلى حين اكتمال module bank transactions.

---

### MED-03 — Income/Form: شرط branch في mount غير متناسق مع save (قد يسبب سلوك غير متوقع للمستخدمين متعددين الفروع)

**ملف:**
- `app/Livewire/Income/Form.php` (حوالي سطر **61–65**)

**المشكلة:**
- mount يمنع access فقط إذا `user.branch_id` موجود ومختلف.
- save يعتمد fallback على `user->branches()->first()`.

**التأثير:**
- سلوك غير متوقع للمستخدمين الذين ليس لديهم `branch_id` أساسي لكن لديهم pivot access.

**اقتراح إصلاح:**
- توحيد منطق تحديد الفرع (BranchContextManager أو BranchAccessService) بين mount/save.

---

## 4) ملاحظات إضافية (Not counted as bugs, لكن Risks)

- الاعتماد على Livewire 4 Beta.5 في نظام ERP production مخاطرة؛ الأفضل pin version أو متابعة stable release قبل deployment.
- يوجد “service layer” غني (AccountingService/BankingService/PurchaseService) لكن جزء كبير من الـ UI لا يستخدمه → ازدواجية منطق وارتفاع احتمال inconsistencies.

---

## 5) Suggested Next Steps (خطة تصحيح سريعة)

1) إصلاح Scheduler/Console أولاً (CRIT-01) — لأنه يؤثر على عمليات يومية.
2) قفل تعديل Sales/Purchases بعد posting أو بناء آلية تعديل صحيحة (CRIT-02/03).
3) تحديد مسار مالي واحد:
   - هل الـ source of truth هو bank_transactions؟ أم payments؟ ثم ربط التقارير به.
4) مراجعة Store Token API auth design (CRIT-05) وتغيير header أو إزالة الاعتماد على auth user.

---

**انتهى التقرير.**
