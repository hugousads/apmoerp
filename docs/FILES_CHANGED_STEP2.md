# FILES_CHANGED_STEP2

هذه قائمة **بالملفات التي تم تعديلها/إنشاؤها** أثناء تنفيذ Step 2 (مقارنةً بالنسخة التي كانت داخل `apmoerp79_fixed_livewire_4.1.0_branch_context.zip`).

> الهدف من الملف: تسهيل المراجعة السريعة (Code Review) + معرفة أين تم لمس الكود.

---

## Controllers
- `app/Http/Controllers/Branch/Purchases/ExportImportController.php`
  - فرض اختيار فرع قبل الاستيراد (`current_branch_id()`)
  - تعيين `branch_id` للسجلات المستوردة بناءً على الـ branch context.
- `app/Http/Controllers/Branch/Sales/ExportImportController.php`
  - نفس الإصلاح: منع الاستيراد بدون branch + تعيين `branch_id`.

## Middleware
- `app/Http/Middleware/SetUserBranchContext.php`
  - تدعيم صلاحية التبديل/عرض جميع الفروع مع alias (مثل `access-all-branches`) وضبط الـ request context.

## Livewire — Shared
- `app/Livewire/Shared/BranchSwitcher.php`
  - استخدام `BranchContextManager` لتحديد الصلاحيات.
  - تحسين `getSelectedBranchModulesProperty` ليُرجع Union للموديولات عند وضع **All Branches**.

## Livewire — Auth / Dashboard / Profile (Layout Attribute Fix)
- `app/Livewire/Auth/ForgotPassword.php`
- `app/Livewire/Auth/Login.php`
- `app/Livewire/Auth/ResetPassword.php`
- `app/Livewire/Dashboard/Index.php`
- `app/Livewire/Profile/Edit.php`
  - نقل `#[Layout(...)]` من Property إلى Class (متوافق Livewire 4).

## Livewire — Admin
- `app/Livewire/Admin/Branches/Modules.php`
- `app/Livewire/Admin/Modules/ProductFields.php`
- `app/Livewire/Admin/Settings/BranchSettings.php`
- `app/Livewire/Admin/Settings/SystemSettings.php`
- `app/Livewire/Admin/Settings/TranslationManager.php`
- `app/Livewire/Admin/Users/Form.php`
  - إصلاح مواضع Layout Attribute.
- `app/Livewire/Admin/BulkImport.php`
  - منع الاستيراد بدون اختيار فرع، وتمرير `branch_id` من الـ branch context.

## Livewire — Banking
- `app/Livewire/Banking/Accounts/Form.php`
  - استخدام branch context في إنشاء/تعديل حساب بنكي.
  - منع الإنشاء في وضع All Branches بدون اختيار فرع.
  - تصحيح return type (`save(): void`).
- `app/Livewire/Banking/Accounts/Index.php`
  - إزالة فلترة `auth()->user()->branch_id` والاعتماد على BranchScope.
  - إضافة allow-list للـ sorting.
- `app/Livewire/Banking/Reconciliation.php`
  - إزالة فلترة الفرع الثابتة واعتماد branch context.

## Livewire — Accounting
- `app/Livewire/Accounting/Accounts/Form.php`
  - إضافة `effectiveBranchId` (تعديل: فرع الحساب / إنشاء: الفرع الحالي).
  - منع الإنشاء عند عدم اختيار فرع (All Branches).
  - تقييد parent accounts لنفس الفرع.

## Livewire — Fixed Assets
- `app/Livewire/FixedAssets/Form.php`
  - استخدام الفرع الفعلي (أصل/السياق) في الحفظ والـ dropdowns.
  - تقييد Supplier validation بنفس الفرع.
- `app/Livewire/FixedAssets/Index.php`
  - إزالة فلترة الفرع الثابتة والاعتماد على BranchScope.

## Livewire — Inventory
- `app/Livewire/Inventory/Batches/Form.php`
- `app/Livewire/Inventory/Batches/Index.php`
- `app/Livewire/Inventory/Serials/Form.php`
- `app/Livewire/Inventory/Serials/Index.php`
  - استخدام branch context بدلاً من `auth()->user()->branch_id`.
  - منع الإنشاء بدون اختيار فرع.
  - إضافة allow-list للـ sorting.

## Livewire — Purchases
- `app/Livewire/Purchases/ApprovalPanel.php`
  - تمرير `branchId` للـ workflow من `purchase->branch_id`.
- `app/Livewire/Purchases/Requisitions/Form.php`
  - احترام branch context.
  - إصلاح type mismatch (`save/submit(): void`) وتحديث الـ queries.
- `app/Livewire/Purchases/Requisitions/Index.php`
  - إزالة فلترة الفرع الثابتة + allow-list للـ sorting.

## Livewire — POS
- `app/Livewire/Pos/Terminal.php`
  - ربط الـ POS بالفرع الحالي (`current_branch_id`) ومنع العمل في وضع All Branches.
  - إصلاح Layout Attribute.

## Livewire — Reports
- `app/Livewire/Reports/SalesAnalytics.php`
  - إصلاح Layout Attribute.
  - إزالة فلترة الفرع الثابتة واعتماد BranchScope.
  - إضافة فلترة manual فقط لـ DB::table(...) باستخدام `current_branch_id()`.

## Livewire — Documents / Helpdesk
- `app/Livewire/Documents/Form.php`
  - إصلاح return type mismatch (`save(): void`).
  - احترام صلاحية view-all في التحقق من الفرع.
  - منع إنشاء Document بدون اختيار فرع (All Branches).
- `app/Livewire/Helpdesk/TicketForm.php`
  - إصلاح return type: إرجاع redirect في نهاية `save()`.
  - استخدام branch context للـ customers/agents والـ validation.

## Services
- `app/Services/BranchContextManager.php`
  - تعديل `getCurrentBranchId()` لتعود `null` في وضع All Branches للمستخدمين الذين لديهم view-all (fail-closed للإنشاء).
- `app/Services/DocumentService.php`
  - السماح للمستخدم الذي لديه view-all بإدارة مشاركة المستندات خارج فرعه الأساسي (مع الحفاظ على منع مشاركة المستند مع مستخدم من فرع آخر).
- `app/Services/ExportService.php`
  - إصلاح مسار التصدير ليستخدم disk محلي يدعم `path()`.
  - إصلاح تجهيز الصفوف: استخدام `toArray()` بدلاً من `(array)$model`.

## Docs
- `docs/IMPLEMENTED.md`
  - إضافة تقرير Step 2.
- `docs/ROADMAP.md`
  - تحديث قائمة الأعمال المتبقية.
- `docs/FILES_CHANGED_STEP2.md`
  - (هذا الملف) قائمة الملفات المعدلة.
