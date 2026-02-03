# ما تم إنجازه في هذه الدفعة

> هذه الدفعة تركّز على إصلاح جذري لمشكلة **سياق الفرع (Branch Context)** وتداخل البيانات + تحسين الكاش + تحسينات سريعة في بعض الموديولات، مع تحديث متطلبات Livewire إلى 4.1.0.

## 1) تحديث Livewire إلى 4.1.0
- تم تعديل `composer.json` لتصبح الحزمة:
  - `livewire/livewire`: **^4.1.0**
- **مهم:** تم حذف `composer.lock` لأن بيئة الإصلاح لا تحتوي على Composer لتحديث lock file.
  - بعد فك المشروع: شغّل:
    - `composer install`
    - أو `composer update livewire/livewire` (إذا لديك lock file محلي وتريد تحديثه فقط)

## 2) إصلاح احترام صلاحية `branches.view-all` ومعالجة "All Branches"
### تم تعديل
- `app/Services/BranchContextManager.php`
  - إضافة دالة `canViewAllBranches()` التي تعتبر المستخدم "View-All" إذا:
    - Super Admin
    - أو لديه صلاحية `branches.view-all` (وأيضًا alias `access-all-branches` إن وُجد)
  - تحديث `getAccessibleBranchIds()` بحيث:
    - تُرجع `null` كمؤشر **ALL BRANCHES** (بدل قائمة IDs) للمستخدمين الذين يستطيعون رؤية كل الفروع.
    - وتستمر في إرجاع قائمة IDs للمستخدمين العاديين.

- `app/Models/Scopes/BranchScope.php`
  - إضافة `DashboardWidget` لقائمة الاستثناءات من الـ Branch Scope (لأنه Catalog عالمي).

## 3) منع تداخل البيانات والكاش بين الفروع
### تم تعديل
- `app/Helpers/helpers.php`
  - إضافة helper جديد: `branch_context_cache_key()`
    - يُرجع `all` عندما يكون السياق "كل الفروع".
    - يُرجع رقم الفرع كسلسلة عند اختيار فرع محدد.

- `app/Livewire/Shared/GlobalSearch.php`
  - تحديث الفلترة لتستخدم **سياق الفرع الحالي** عبر `current_branch_id()` بدل الاعتماد على `auth()->user()->branch_id`.
  - تحديث Cache Key ليشمل سياق الفرع عبر `branch_context_cache_key()` لتجنب ظهور نتائج فرع قديم بعد التبديل.

- `app/Livewire/Concerns/WithLazyLoading.php`
  - تحديث مفاتيح الكاش لتستخدم سياق الفرع الحالي بدل `user->branch_id`.

- `app/Livewire/Components/DashboardWidgets.php`
  - تحديث Cache Keys + الفلاتر لتتبع سياق الفرع الحالي (ومراعاة All Branches للمستخدمين View-All).

- `app/Livewire/Warehouse/Index.php`
  - تحديث Cache Keys + فلاتر الاستعلامات لتتبع سياق الفرع الحالي بدل user->branch_id.

## 4) إصلاح فلترة مزدوجة في Activity Timeline
- `app/Livewire/Components/ActivityTimeline.php`
  - إزالة فلترة يدوية كانت تتعارض مع BranchScope وتكسر "All Branches".
  - الاعتماد على BranchScope في `AuditLog` فقط.

## 5) إصلاح Pivot `branch_user` وإضافة العمود المفقود
### تمت إضافة
- Migration جديد:
  - `database/migrations/2026_01_28_000001_add_is_active_to_branch_user_table.php`
    - إضافة `is_active` (default true)
    - إضافة `activated_at` (اختياري)

### تم تعديل
- `app/Models/User.php` و `app/Models/Branch.php`
  - تحديث علاقة `branches/users` لإضافة `withPivot(['is_active','activated_at'])->withTimestamps()`

## 6) Seeders ناقصة تم إضافتها
### تمت إضافة
- `database/seeders/BranchAdminsSeeder.php`
  - يملأ جدول `branch_admins` تلقائيًا (خصوصًا للمستخدم seed: `branch.admin@ghanem-erp.com`).

- `database/seeders/DashboardWidgetsSeeder.php`
  - يضيف Catalog مبدئي لـ `dashboard_widgets`.

### تم تعديل
- `database/seeders/DatabaseSeeder.php`
  - إضافة `BranchAdminsSeeder` و `DashboardWidgetsSeeder` إلى ترتيب التنفيذ.

## 7) UI: تحديث آمن وفوري بعد تبديل الفرع
- `resources/views/livewire/shared/branch-switcher.blade.php`
  - عند حدث `branch-switched` يتم تنفيذ `window.location.reload()` لضمان:
    - إعادة بناء sidebar
    - إعادة mount للـ Livewire components
    - عدم بقاء بيانات من الفرع السابق في الواجهة

---

## ملاحظات تشغيل سريعة بعد فك المشروع
1) تثبيت باكدجات PHP:
- `composer install`

2) تشغيل migrations:
- `php artisan migrate`

3) تشغيل seeders (اختياري للبيانات التجريبية):
- `php artisan db:seed`

---

# Step 2 — تدقيق عميق وإصلاحات Multi-Branch

في هذه المرحلة تم عمل **مراجعة أعمق** للمشروع بهدف منع تسريب بيانات بين الفروع، وحل أخطاء Livewire/JS (مثل `Unexpected token '<'`) الناتجة عن أخطاء سيرفر/TypeErrors.

## 1) إصلاحات Livewire Layout Attributes
تم العثور على عدّة components لديها `#[Layout(...)]` موضوعة على **property** بدل class، وهذا يسبب مشاكل layout/navigation في Livewire 4.

تم نقل الـ `#[Layout(...)]` إلى مستوى الـ **class** في الملفات التالية (أمثلة):
- `app/Livewire/Reports/SalesAnalytics.php`
- `app/Livewire/Pos/Terminal.php`
- `app/Livewire/Dashboard/Index.php`
- `app/Livewire/Auth/Login.php` و `ForgotPassword.php` و `ResetPassword.php`
- `app/Livewire/Profile/Edit.php`
- `app/Livewire/Admin/...` (إعدادات/ترجمات/فروع/مستخدمين)

## 2) BranchContextManager: سلوك أدق مع "All Branches"
تم تعديل `BranchContextManager::getCurrentBranchId()` بحيث:
- إذا المستخدم لديه صلاحية **view-all** ولا يوجد branch محدد (All Branches) ⇒ يرجع `null` بدل الاعتماد على `user->branch_id`.
- هذا يمنع إنشاء بيانات Branch-scoped بالخطأ في الفرع "الافتراضي" للمستخدم.

الملف:
- `app/Services/BranchContextManager.php`

## 3) إصلاحات مالية/منطقية: احترام الـ branch context في Modules حساسة
### Banking
- إصلاح `BankAccount Form/Index/Reconciliation` لكي تعتمد على branch context وتمنع إنشاء حساب بنكي تحت All Branches.
  - `app/Livewire/Banking/Accounts/Form.php`
  - `app/Livewire/Banking/Accounts/Index.php`
  - `app/Livewire/Banking/Reconciliation.php`

### Accounting
- إصلاح إنشاء/تعديل Chart of Accounts ليعتمد على branch context (خصوصًا للمستخدم view-all) ويمنع cross-branch parent accounts.
  - `app/Livewire/Accounting/Accounts/Form.php`

### Fixed Assets
- حفظ `branch_id` باستخدام branch context/asset branch.
- فلترة الموردين والمستخدمين حسب نفس branch asset.
  - `app/Livewire/FixedAssets/Form.php`
  - `app/Livewire/FixedAssets/Index.php`

### Inventory (Batches/Serials)
- نفس المبدأ: استخدام branch context + منع الإنشاء تحت All Branches.
  - `app/Livewire/Inventory/Batches/Form.php`
  - `app/Livewire/Inventory/Batches/Index.php`
  - `app/Livewire/Inventory/Serials/Form.php`
  - `app/Livewire/Inventory/Serials/Index.php`

### Purchases (Requisitions + Approval)
- إصلاح `Purchase Requisition` (rules/save/submit) ليحترم branch context ويزيل `RedirectResponse` type mismatch.
- جعل الـ workflow يرتبط بـ branch الخاص بالشراء.
  - `app/Livewire/Purchases/Requisitions/Form.php`
  - `app/Livewire/Purchases/Requisitions/Index.php`
  - `app/Livewire/Purchases/ApprovalPanel.php`

## 4) POS Terminal: منع العمل على All Branches
الـ POS لازم يكون داخل فرع محدد.
- `app/Livewire/Pos/Terminal.php`

## 5) Documents & Helpdesk: إصلاح TypeErrors + احترام الصلاحيات
### Documents
- إصلاح `save(): RedirectResponse` الذي كان يرجع null (TypeError) وتحويله لـ `void`.
- إضافة guard: إنشاء Document يحتاج branch محدد.
- احترام صلاحية view-all عند فتح/مشاركة مستندات.
  - `app/Livewire/Documents/Form.php`
  - `app/Services/DocumentService.php`

### Helpdesk
- إصلاح `TicketForm` branch logic + فلترة العملاء/الـ agents حسب branch.
  - `app/Livewire/Helpdesk/TicketForm.php`

## 6) Import/Export & Bulk Import
### ExportService
- إصلاح مسار التصدير ليستخدم disk محلي (Local) دائمًا لأن الكود يعتمد على `path()` و `file_exists()`.
- إصلاح `prepareDataRows` بحيث لا يستخدم `(array)$model` ويعتمد على `toArray()`/`data_get()`.
  - `app/Services/ExportService.php`

### Controllers (Sales/Purchases Import)
- منع الاستيراد إذا المستخدم في All Branches.
- ضبط `branch_id` على branch context.
  - `app/Http/Controllers/Branch/Purchases/ExportImportController.php`
  - `app/Http/Controllers/Branch/Sales/ExportImportController.php`

### Bulk Import
- منع الاستيراد في All Branches وإلزام اختيار فرع.
  - `app/Livewire/Admin/BulkImport.php`

## 7) Reports: SalesAnalytics
- إصلاح Layout attribute.
- إزالة hard-coded branch filters والاعتماد على branch context.
- فلترة queries التي تستخدم `DB::table` حسب `current_branch_id()`.
  - `app/Livewire/Reports/SalesAnalytics.php`


