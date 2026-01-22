# APmo ERP v60 — تقرير تدقيق تفصيلي + خطة System‑Wide (بدون تطبيق كود)

> **ملاحظة منهجية:** هذا التقرير مبني على **Static/Pattern audit** على Snapshot `apmoerp60.zip` (Laravel 12 + Livewire 4).
> لا يمكن اعتبار كل بند “Confirmed Runtime Bug” إلا بعد كتابة/تشغيل اختبارات أو مراجعة تدفق التشغيل فعليًا. لكن البنود المصنفة CRITICAL/HIGH هنا هي **نقاط انهيار Tenancy/Authorization/Consistency** غالبًا حتى قبل runtime.

## 0) بصمة المشروع (Tech Stack)
| Item | Value |
|---|---|
| PHP | ^8.2 |
| Laravel | ^12.0 |
| Livewire | ^4.0.1 |
| Auth | Sanctum + Spatie Permission |
| Finance | bcmath (ext-bcmath) + helpers |
| Exports | PhpSpreadsheet + DOMPDF |

### Packages (composer require)
| Package | Constraint |
|---|---|
| barryvdh/laravel-dompdf | ^3.1 |
| ext-bcmath | * |
| jenssegers/agent | ^2.6 |
| laravel/framework | ^12.0 |
| laravel/sanctum | ^4.2 |
| laravel/tinker | ^2.10.1 |
| livewire/livewire | ^4.0.1 |
| php | ^8.2 |
| phpoffice/phpspreadsheet | ^2.1 |
| pragmarx/google2fa | ^9.0 |
| simplesoftwareio/simple-qrcode | ^4.2 |
| spatie/laravel-activitylog | ^4.10 |
| spatie/laravel-permission | ^6.23 |

## 1) خريطة النظام (System Map)
### 1.1 نقاط الدخول (Entry Points)
- `routes/web.php` (واجهة ERP الأساسية + admin + POS)
- `routes/api.php` (تكاملات/متجر/Webhooks/…)
- Livewire modules: `app/Livewire/*`

### 1.2 تقسيم الـ Modules (من `app/Livewire/`)
| Module | Notes |
|---|---|
| Accounting | Livewire namespace folder |
| Admin | Livewire namespace folder |
| Auth | Livewire namespace folder |
| Banking | Livewire namespace folder |
| Components | Livewire namespace folder |
| Concerns | Livewire namespace folder |
| Customers | Livewire namespace folder |
| Dashboard | Livewire namespace folder |
| Documents | Livewire namespace folder |
| Expenses | Livewire namespace folder |
| FixedAssets | Livewire namespace folder |
| Helpdesk | Livewire namespace folder |
| Hrm | Livewire namespace folder |
| Income | Livewire namespace folder |
| Inventory | Livewire namespace folder |
| Manufacturing | Livewire namespace folder |
| Notifications | Livewire namespace folder |
| Pos | Livewire namespace folder |
| Profile | Livewire namespace folder |
| Projects | Livewire namespace folder |
| Purchases | Livewire namespace folder |
| Rental | Livewire namespace folder |
| Reports | Livewire namespace folder |
| Sales | Livewire namespace folder |
| Shared | Livewire namespace folder |
| Suppliers | Livewire namespace folder |
| Warehouse | Livewire namespace folder |

### 1.3 Route Groups (نظرة عامة)
| Route group/prefix (rough) | count(get routes) |
|---|---|
| root | 225 |
| reports | 2 |
| app | 1 |

### 1.4 Event-driven side effects (Cycles hooks)
| Event | Queued/Listener(s) |
|---|---|
| ContractDueSoon | SendDueReminder::class |
| ContractOverdue | ApplyLateFee::class, WriteAuditTrail::class |
| PurchaseReceived | UpdateStockOnPurchase::class |
| SaleCompleted | UpdateStockOnSale::class |
| StockBelowThreshold | ProposePurchaseOrder::class |
| UserDisabled | InvalidateUserSessions::class |
| Login | LogSuccessfulLogin::class |
| Failed | LogFailedLogin::class |
| Logout | LogSuccessfulLogout::class |

### 1.5 Services (Business orchestration surface)
- Folder: `app/Services/` (**125** ملفات)
- ملفات محورية يجب تثبيت Invariants فيها:
| Key service file | Purpose (expected) |
|---|---|
| app/Services/BranchContextManager.php | تحديد branch context (explicit/session/request) |
| app/Services/BranchAccessService.php | تحقق صلاحية المستخدم على الفرع |
| app/Services/AccountingService.php | إنشاء/ترحيل قيود اليومية وCOGS |
| app/Services/InventoryService.php | مستويات المخزون + التحويلات + التعديلات |
| app/Services/StockService.php | adjustStock (low-level) |
| app/Services/POSService.php | Checkout + جلسات POS + قيود مالية |
| app/Services/BankingService.php | Bank tx + reconciliation + balances |
| app/Services/ManufacturingService.php | BOM + Production orders |
| app/Services/Store/StoreSyncService.php | Sync/Integration (خطر high على tenancy) |

---

# 2) Cycles تشغيل ERP (كيف السيستم “يتماسك”)
الهدف هنا: كل Cycle له **مصادر truth** + **Invariants** + **نقاط كتابة متعددة** يجب أن تكون Transactional + Authorised + Branch-scoped.

## 2.1 Sales Cycle (ERP Sales vs POS)
**UI سطحية:** `app/Livewire/Sales/*` + routes تحت `Route::prefix('app/sales')`.

**النماذج الأساسية (Models):** `app/Models/Sale.php`, `SaleItem.php`, `SalePayment.php`, `SalesReturn.php`.

**Side effects:**
- `SaleCompleted` event ⇒ `UpdateStockOnSale` listener (`app/Listeners/UpdateStockOnSale.php`) لإنشاء `StockMovement` (خصم مخزون) **queued**.

**Invariants يجب تثبيتها/اختبارها:**
1. Branch isolation: كل Sale/SaleItem/SalePayment/StockMovement لازم branch-safe (عبر scoping أو عبر مرجعية warehouse->branch).
2. Stock movements idempotency: listener بالفعل يعمل check قبل create — لازم Test يضمن عدم التكرار عند retry.
3. Financial precision: totals تستخدم bcmath/decimal helpers — لازم Unit tests على rounding/line totals.

**POS Cycle:**
- `app/Services/POSService.php::checkout()` يعمل داخل `DB::transaction()` ويشير لاستخدام `AccountingService` + bcround/decimal_float.
- ده هو المكان الطبيعي لربط: بيع ⇒ مخزون ⇒ قيد ⇒ بنك.

## 2.2 Purchases Cycle (Requisition → Quotation → Purchase/Receive → Payments)
**UI:** `app/Livewire/Purchases/*` + routes تحت `app/purchases`.
**Models:** `Purchase.php`, `PurchaseItem.php`, `PurchaseRequisition*`, `SupplierQuotation*`, `PurchasePayment.php`, `PurchaseReturn*`.
**Side effects:** `PurchaseReceived` event ⇒ `UpdateStockOnPurchase` listener (`app/Listeners/UpdateStockOnPurchase.php`) لإضافة المخزون.
**Invariants:**
- Receive يجب أن يكون Transactional (header + items + movements).
- لا يسمح باستقبال على Warehouse من فرع آخر.
- أي Return/Refund يجب أن يخلق reversal stock + reversal accounting (إن كان النظام يدعم).

## 2.3 Inventory/Warehouse Cycle (Adjustments + Transfers + Thresholds)
**UI:** `app/Livewire/Inventory/*`, `app/Livewire/Warehouse/*`.
**Models:** `StockMovement.php`, `Transfer*`, `StockTransfer*`, `Adjustment*`, `Warehouse.php`, `Product.php`.
**Side effects:** `StockBelowThreshold` ⇒ `ProposePurchaseOrder` listener.
**Invariants:**
- التحويلات/التعديلات: لا multi-write خارج transaction.
- منع negative stock إلا لو config يسمح (راجع enforcement في StockService/InventoryService).
- اتساق stock_quantity cached مقابل stock_movements (راجع تحذيرات Product + command).

## 2.4 Manufacturing Cycle (BOM → Production Order → Issue materials → Record production)
**UI:** `app/Livewire/Manufacturing/*`.
**Models:** `BillOfMaterial.php`, `BomItem.php`, `ProductionOrder*`.
**Service:** `app/Services/ManufacturingService.php` (يوفّر create/release/issue/record/complete/cancel).
**Invariants:**
- Issue materials: stock out (raw materials).
- Record production: stock in (finished goods).
- كل خطوة لازم تتأكد من branch/warehouse + transaction + idempotency.

## 2.5 Banking/Accounting Cycle (Transactions + Journal Entries)
**Services:** `app/Services/BankingService.php`, `app/Services/AccountingService.php`.
**Invariants:**
- أي عملية مالية يجب أن تكون: (validate balance) + (journal balanced) + (bank tx recorded) **atomic**.
- منع double-posting: كل reference_type/reference_id يجب يكون unique منطقيًا.

## 2.6 Rental / HRM / Projects / Helpdesk (مختصر)
- Rental: `app/Livewire/Rental/*` + Models: `Rental*` (Contracts/Invoices/Payments).
- HRM: `app/Livewire/Hrm/*` + Models: `HREmployee`, shifts/attendance/leave…
- Projects: `app/Livewire/Projects/*` + Models: `Project*` (⚠️ Project غير scoped في v60 — انظر Bugs).
- Helpdesk: `app/Livewire/Helpdesk/*` + Models: `Ticket*` (⚠️ Ticket غير scoped في v60).

---

# 3) سجل المخاطر / Bugs (مرتب حسب الخطورة) — مع المسارات

## 3.1 CRITICAL — Tenancy/Branch: Models فيها `branch_id` لكن **بدون scoping**
- **Count:** 18
| Model file | Class line |
|---|---|
| app/Models/AuditLog.php | 14 |
| app/Models/BranchModule.php | 11 |
| app/Models/ChartOfAccount.php | 15 |
| app/Models/CreditNote.php | 12 |
| app/Models/DebitNote.php | 17 |
| app/Models/LeaveHoliday.php | 16 |
| app/Models/Media.php | 20 |
| app/Models/ModuleField.php | 19 |
| app/Models/ModulePolicy.php | 19 |
| app/Models/ModuleSetting.php | 18 |
| app/Models/Project.php | 15 |
| app/Models/PurchaseReturn.php | 19 |
| app/Models/PurchaseReturnItem.php | 15 |
| app/Models/ReturnRefund.php | 10 |
| app/Models/SalesReturn.php | 12 |
| app/Models/StockTransfer.php | 12 |
| app/Models/SupplierPerformanceMetric.php | 16 |
| app/Models/Ticket.php | 18 |

**ملاحظة داعمة (Refactor residue):** import لـ `HasBranch` بدون استخدام trait داخل class.
| Model file | Class line |
|---|---|
| app/Models/AuditLog.php | 14 |
| app/Models/CreditNote.php | 12 |
| app/Models/DebitNote.php | 17 |
| app/Models/LeaveHoliday.php | 16 |
| app/Models/Media.php | 20 |
| app/Models/ModuleField.php | 19 |
| app/Models/ModulePolicy.php | 19 |
| app/Models/ModuleSetting.php | 18 |
| app/Models/Project.php | 15 |
| app/Models/PurchaseReturn.php | 19 |
| app/Models/PurchaseReturnItem.php | 15 |
| app/Models/ReturnRefund.php | 10 |
| app/Models/SalesReturn.php | 12 |
| app/Models/StockTransfer.php | 12 |
| app/Models/SupplierPerformanceMetric.php | 16 |
| app/Models/Ticket.php | 18 |

**لماذا Critical؟** أي `find() / findOrFail() / route-model binding` على هذه النماذج قد يقرأ/يعدل بيانات فرع آخر (IDOR/Leak).

## 3.2 CRITICAL — Tenancy/Validation: `exists:` على جداول Branch-owned بدون شرط branch
- **Count:** 25 (من إجمالي exists: 154)
| Table | count |
|---|---|
| customers | 7 |
| products | 5 |
| warehouses | 3 |
| modules | 3 |
| suppliers | 3 |
| accounts | 2 |
| bank_accounts | 1 |
| purchase_requisitions | 1 |

**الفهرس الكامل:**
| File | Line | Table | Column | Rule snippet |
|---|---|---|---|---|
| app/Livewire/Accounting/Accounts/Form.php | 75 | accounts | id | 'form.parent_id' => ['nullable', 'exists:accounts,id'], |
| app/Livewire/Accounting/JournalEntries/Form.php | 105 | accounts | id | 'lines.*.account_id' => ['required', 'exists:accounts,id'], |
| app/Livewire/Banking/Reconciliation.php | 120 | bank_accounts | id | 'accountId' => 'required\|exists:bank_accounts,id', |
| app/Http/Controllers/Api/V1/POSController.php | 44 | customers | id | 'customer_id' => 'nullable\|integer\|exists:customers,id', |
| app/Http/Controllers/Branch/Motorcycle/ContractController.php | 30 | customers | id | 'customer_id' => ['required', 'exists:customers,id'], |
| app/Livewire/Admin/ApiDocumentation.php | 165 | customers | id | 'customer_id' => 'nullable\|exists:customers,id', |
| app/Livewire/Helpdesk/TicketForm.php | 152 | customers | id | 'customer_id' => 'nullable\|exists:customers,id', |
| app/Livewire/Helpdesk/TicketForm.php | 171 | customers | id | 'customer_id' => 'nullable\|exists:customers,id', |
| app/Livewire/Helpdesk/Tickets/Form.php | 56 | customers | id | 'customer_id' => ['nullable', 'exists:customers,id'], |
| app/Livewire/Sales/Form.php | 105 | customers | id | 'exists:customers,id', |
| app/Livewire/Admin/ApiDocumentation.php | 70 | modules | id | 'module_id' => 'required\|exists:modules,id', |
| app/Livewire/Admin/Modules/ProductFields/Form.php | 136 | modules | id | 'moduleId' => 'required\|integer\|exists:modules,id', |
| app/Livewire/Inventory/Products/Form.php | 264 | modules | id | 'form.module_id' => ['nullable', 'integer', 'exists:modules,id'], |
| app/Http/Controllers/Api/V1/POSController.php | 35 | products | id | 'items.*.product_id' => 'required\|integer\|exists:products,id', |
| app/Livewire/Admin/ApiDocumentation.php | 116 | products | id | 'product_id' => 'required\|exists:products,id', |
| app/Livewire/Admin/ApiDocumentation.php | 129 | products | id | 'items.*.product_id' => 'required\|exists:products,id', |
| app/Livewire/Admin/ApiDocumentation.php | 168 | products | id | 'items.*.product_id' => 'required\|exists:products,id', |
| app/Livewire/Purchases/Quotations/Form.php | 61 | products | id | 'items.*.product_id' => 'required\|exists:products,id', |
| app/Livewire/Purchases/Quotations/Form.php | 50 | purchase_requisitions | id | 'requisition_id' => 'required\|exists:purchase_requisitions,id', |
| app/Livewire/FixedAssets/Form.php | 76 | suppliers | id | 'supplier_id' => 'nullable\|exists:suppliers,id', |
| app/Livewire/Purchases/Form.php | 94 | suppliers | id | 'exists:suppliers,id', |
| app/Livewire/Purchases/Quotations/Form.php | 51 | suppliers | id | 'supplier_id' => 'required\|exists:suppliers,id', |
| app/Http/Controllers/Api/V1/POSController.php | 45 | warehouses | id | 'warehouse_id' => 'nullable\|integer\|exists:warehouses,id', |
| app/Livewire/Purchases/Form.php | 106 | warehouses | id | 'exists:warehouses,id', |
| app/Livewire/Sales/Form.php | 117 | warehouses | id | 'exists:warehouses,id', |

**Fix pattern (System-wide):** استبدال `exists:table,id` بـ `Rule::exists(table, id)->where('branch_id', currentBranchId())` أو lookup scoped.

## 3.3 HIGH — Authorization Baseline: Livewire mutation methods “flagged” بدون authorize داخل الميثود
- **Count:** 78
| Livewire module | count |
|---|---|
| Admin | 24 |
| Components | 7 |
| Inventory | 7 |
| Purchases | 7 |
| Profile | 5 |
| Rental | 4 |
| Hrm | 3 |
| Manufacturing | 3 |
| CommandPalette.php | 2 |
| Expenses | 2 |
| Income | 2 |
| Reports | 2 |
| Sales | 2 |
| Shared | 2 |
| Auth | 1 |
| Banking | 1 |
| Customers | 1 |
| Dashboard | 1 |
| Documents | 1 |
| Helpdesk | 1 |

**الفهرس الكامل:**
| File | Line | Method |
|---|---|---|
| app/Livewire/Admin/Branch/Employees.php | 68 | toggleStatus |
| app/Livewire/Admin/Branch/Settings.php | 72 | save |
| app/Livewire/Admin/Branches/Form.php | 179 | save |
| app/Livewire/Admin/BulkImport.php | 141 | loadGoogleSheet |
| app/Livewire/Admin/BulkImport.php | 308 | runImport |
| app/Livewire/Admin/Categories/Form.php | 85 | save |
| app/Livewire/Admin/Currency/Form.php | 81 | save |
| app/Livewire/Admin/MediaLibrary.php | 142 | delete |
| app/Livewire/Admin/Modules/Form.php | 109 | save |
| app/Livewire/Admin/Modules/ManagementCenter.php | 157 | toggleModuleForBranch |
| app/Livewire/Admin/Modules/ManagementCenter.php | 190 | toggleModuleActive |
| app/Livewire/Admin/Modules/ProductFields.php | 122 | reorder |
| app/Livewire/Admin/Modules/ProductFields/Form.php | 157 | save |
| app/Livewire/Admin/Reports/ReportTemplatesManager.php | 206 | delete |
| app/Livewire/Admin/Reports/ScheduledReportsManager.php | 253 | delete |
| app/Livewire/Admin/Roles/Form.php | 201 | save |
| app/Livewire/Admin/Settings/SystemSettings.php | 104 | save |
| app/Livewire/Admin/Settings/UnifiedSettings.php | 440 | saveSecurity |
| app/Livewire/Admin/Settings/UnifiedSettings.php | 631 | restoreDefaults |
| app/Livewire/Admin/Settings/UserPreferences.php | 41 | save |
| app/Livewire/Admin/Settings/UserPreferences.php | 81 | resetToDefaults |
| app/Livewire/Admin/Store/Form.php | 135 | save |
| app/Livewire/Admin/UnitsOfMeasure/Form.php | 107 | save |
| app/Livewire/Admin/Users/Form.php | 151 | save |
| app/Livewire/Auth/Login.php | 55 | login |
| app/Livewire/Banking/Reconciliation.php | 298 | complete |
| app/Livewire/CommandPalette.php | 68 | saveRecentSearch |
| app/Livewire/CommandPalette.php | 106 | clearRecentSearches |
| app/Livewire/Components/DashboardWidgets.php | 134 | toggleWidget |
| app/Livewire/Components/NotesAttachments.php | 99 | saveNote |
| app/Livewire/Components/NotesAttachments.php | 147 | deleteNote |
| app/Livewire/Components/NotesAttachments.php | 159 | togglePin |
| app/Livewire/Components/NotesAttachments.php | 182 | uploadFiles |
| app/Livewire/Components/NotesAttachments.php | 264 | deleteAttachment |
| app/Livewire/Components/NotificationsCenter.php | 71 | markAllAsRead |
| app/Livewire/Customers/Form.php | 103 | save |
| app/Livewire/Dashboard/CustomizableDashboard.php | 456 | saveUserPreferences |
| app/Livewire/Documents/Tags/Index.php | 24 | delete |
| app/Livewire/Expenses/Categories/Form.php | 62 | save |
| app/Livewire/Expenses/Form.php | 108 | save |
| app/Livewire/Helpdesk/Tickets/Form.php | 101 | save |
| app/Livewire/Hrm/Employees/Form.php | 154 | save |
| app/Livewire/Hrm/Payroll/Run.php | 47 | runPayroll |
| app/Livewire/Hrm/SelfService/MyLeaves.php | 113 | cancelRequest |
| app/Livewire/Income/Categories/Form.php | 61 | save |
| app/Livewire/Income/Form.php | 128 | save |
| app/Livewire/Inventory/Batches/Form.php | 74 | save |
| app/Livewire/Inventory/ProductCompatibility.php | 247 | toggleVerified |
| app/Livewire/Inventory/ProductStoreMappings.php | 108 | delete |
| app/Livewire/Inventory/ProductStoreMappings/Form.php | 122 | save |
| app/Livewire/Inventory/Serials/Form.php | 77 | save |
| app/Livewire/Inventory/Services/Form.php | 163 | save |
| app/Livewire/Inventory/VehicleModels.php | 44 | toggleActive |
| app/Livewire/Manufacturing/BillsOfMaterials/Form.php | 80 | save |
| app/Livewire/Manufacturing/ProductionOrders/Form.php | 85 | save |
| app/Livewire/Manufacturing/WorkCenters/Form.php | 126 | save |
| app/Livewire/Profile/Edit.php | 50 | updateProfile |
| app/Livewire/Profile/Edit.php | 67 | updatePassword |
| app/Livewire/Profile/Edit.php | 88 | handleFileUploaded |
| app/Livewire/Profile/Edit.php | 118 | updateAvatar |
| app/Livewire/Profile/Edit.php | 144 | removeAvatar |
| app/Livewire/Purchases/Form.php | 281 | save |
| app/Livewire/Purchases/GRN/Form.php | 134 | saveGRNItems |
| app/Livewire/Purchases/GRN/Form.php | 191 | saveGRNRecord |
| app/Livewire/Purchases/Requisitions/Form.php | 155 | save |
| app/Livewire/Purchases/Requisitions/Form.php | 206 | submit |
| app/Livewire/Purchases/Returns/Index.php | 108 | processReturn |
| app/Livewire/Purchases/Returns/Index.php | 233 | deleteReturn |
| app/Livewire/Rental/Contracts/Form.php | 284 | removeExistingFile |
| app/Livewire/Rental/Contracts/Form.php | 313 | save |
| app/Livewire/Rental/Reports/Dashboard.php | 140 | notifyExpiringContracts |
| app/Livewire/Rental/Units/Form.php | 135 | save |
| app/Livewire/Reports/ScheduledReports.php | 61 | delete |
| app/Livewire/Reports/ScheduledReports/Form.php | 79 | save |
| app/Livewire/Sales/Form.php | 354 | save |
| app/Livewire/Sales/Returns/Index.php | 194 | deleteReturn |
| app/Livewire/Shared/OnboardingGuide.php | 351 | saveProgress |
| app/Livewire/Shared/OnboardingGuide.php | 391 | resetOnboarding |

**ملحوظة:** وجود `->middleware('can:...')` على route مفيد، لكنه ليس كافيًا لحماية mutation methods داخل Livewire لو حصل استدعاء مباشر/غير متوقع أو تغيّر UI.

## 3.4 HIGH — Tenancy bypass surface: استخدام `withoutGlobalScopes()` / `withoutGlobalScope()`
- **Count:** 19
| File | Line | Snippet |
|---|---|---|
| app/Http/Controllers/Api/V1/WebhooksController.php | 30 | $store = Store::withoutGlobalScopes()->with('integration')->find($storeId); |
| app/Http/Controllers/Api/V1/WebhooksController.php | 83 | $store = Store::withoutGlobalScopes()->with('integration')->find($storeId); |
| app/Http/Controllers/Api/V1/WebhooksController.php | 191 | $store = Store::withoutGlobalScopes()->with('integration')->find($storeId); |
| app/Http/Controllers/Api/V1/WebhooksController.php | 327 | $warehouse = \App\Models\Warehouse::withoutGlobalScopes() |
| app/Http/Controllers/Api/V1/WebhooksController.php | 338 | $warehouse = \App\Models\Warehouse::withoutGlobalScopes() |
| app/Http/Middleware/AuthenticateStoreToken.php | 58 | $storeToken = StoreToken::withoutGlobalScopes()->where('token', $token)->first(); |
| app/Http/Middleware/AuthenticateStoreToken.php | 76 | $store = Store::withoutGlobalScopes() |
| app/Jobs/ClosePosDayJob.php | 33 | $activeBranches = Branch::withoutGlobalScopes() |
| app/Listeners/ProposePurchaseOrder.php | 36 | // V23-CRIT-04 FIX: Use withoutGlobalScopes() to bypass BranchScope |
| app/Listeners/ProposePurchaseOrder.php | 39 | ->withoutGlobalScopes() |
| app/Listeners/SendDueReminder.php | 26 | // V23-CRIT-04 FIX: Use withoutGlobalScopes() to bypass BranchScope when loading tenant |
| app/Listeners/SendDueReminder.php | 29 | ->withoutGlobalScopes() |
| app/Services/BranchContextManager.php | 146 | // IMPORTANT: We use withoutGlobalScopes() to prevent recursion |
| app/Services/BranchContextManager.php | 153 | $query->withoutGlobalScopes(); |
| app/Services/Store/StoreSyncService.php | 929 | $warehouse = \App\Models\Warehouse::withoutGlobalScopes() |
| app/Services/Store/StoreSyncService.php | 940 | $warehouse = \App\Models\Warehouse::withoutGlobalScopes() |
| app/Services/Store/StoreSyncService.php | 966 | $user = User::withoutGlobalScopes() |
| app/Services/Store/StoreSyncService.php | 1002 | $product = Product::withoutGlobalScopes()->find($productId); |
| app/Traits/HasBranch.php | 64 | return $query->withoutGlobalScope(BranchScope::class); |

**لماذا خطر؟** هذه calls تلغي BranchScope/أي global scope. لازم يكون معها: (token-bound branch/store) + explicit where(branch_id=...) + auditing + tests.

## 3.5 MEDIUM — XSS surface: Blade raw output `{!! !!}`
- **Count:** 2
| Blade file | Line | Expression |
|---|---|---|
| resources/views/components/ui/card.blade.php | 50 | {!! $actions !!} |
| resources/views/components/ui/form/input.blade.php | 83 | @if($validWireModel && $validWireModifier) {!! $wireDirective !!} @endif |

## 3.6 MEDIUM — SQL review backlog: whereRaw/orderByRaw/DB::select/statement hits
- **Count:** 54
| File | Line | Snippet |
|---|---|---|
| app/Console/Commands/CheckDatabaseIntegrity.php | 253 | ->whereRaw('ABS(COALESCE(products.stock_quantity, 0) - COALESCE(sm.calculated_stock, 0)) > 0.0001') |
| app/Console/Commands/CheckDatabaseIntegrity.php | 336 | $indexes = DB::select("SHOW INDEX FROM {$table}"); |
| app/Console/Commands/CheckDatabaseIntegrity.php | 432 | DB::statement($fix); |
| app/Http/Controllers/Admin/ReportsController.php | 428 | ->whereRaw('paid_amount < total_amount') |
| app/Http/Controllers/Admin/ReportsController.php | 437 | ->whereRaw('paid_amount < total_amount') |
| app/Livewire/Concerns/LoadsDashboardData.php | 24 | * This trait uses selectRaw(), whereRaw(), and orderByRaw() with variable interpolation. |
| app/Livewire/Concerns/LoadsDashboardData.php | 171 | ->whereRaw("{$stockExpr} <= min_stock") |
| app/Livewire/Concerns/LoadsDashboardData.php | 326 | ->whereRaw("{$stockExpr} <= products.min_stock") |
| app/Livewire/Concerns/LoadsDashboardData.php | 329 | ->orderByRaw($stockExpr) |
| app/Livewire/Hrm/Employees/Index.php | 141 | ->whereRaw("COALESCE(position, '') != ''") |
| app/Livewire/Inventory/StockAlerts.php | 64 | $query->whereRaw('COALESCE(stock_calc.total_stock, 0) <= products.min_stock AND COALESCE(stock_calc.total_stock, 0) > 0'); |
| app/Livewire/Inventory/StockAlerts.php | 66 | $query->whereRaw('COALESCE(stock_calc.total_stock, 0) <= 0'); |
| app/Livewire/Projects/TimeLogs.php | 182 | ->orderByRaw('COALESCE(log_date, date) desc') |
| app/Models/ModuleSetting.php | 118 | })->orderByRaw('CASE WHEN branch_id IS NULL THEN 1 ELSE 0 END'); |
| app/Models/Product.php | 24 | * This model uses whereRaw() in query scopes (scopeLowStock, scopeOutOfStock, scopeInStock) |
| app/Models/Product.php | 309 | ->whereRaw("({$stockSubquery}) <= stock_alert_threshold"); |
| app/Models/Product.php | 332 | return $query->whereRaw("({$stockSubquery}) <= 0"); |
| app/Models/Product.php | 355 | return $query->whereRaw("({$stockSubquery}) > 0"); |
| app/Models/Project.php | 175 | return $query->whereRaw('actual_cost > budget'); |
| app/Models/SearchIndex.php | 57 | * through the second argument to whereRaw(), preventing SQL injection. |
| app/Models/SearchIndex.php | 80 | $builder->whereRaw( |
| app/Models/SearchIndex.php | 89 | $q->whereRaw('LOWER(title) LIKE ?', [$searchTerm]) |
| app/Services/Analytics/AdvancedAnalyticsService.php | 564 | ->whereRaw('COALESCE(stock_quantity, 0) <= min_stock') |
| app/Services/AutomatedAlertService.php | 171 | ->whereRaw('balance >= (credit_limit * 0.8)') // 80% of credit limit |
| app/Services/AutomatedAlertService.php | 239 | ->whereRaw("({$stockSubquery}) > 0") |
| app/Services/Dashboard/DashboardDataService.php | 244 | ->whereRaw('COALESCE(stock.current_stock, 0) <= products.stock_alert_threshold') |
| app/Services/Dashboard/DashboardDataService.php | 246 | ->orderByRaw('COALESCE(stock.current_stock, 0) ASC') |
| app/Services/Dashboard/DashboardDataService.php | 268 | ->whereRaw('COALESCE(stock.current_stock, 0) <= products.stock_alert_threshold') |
| app/Services/DatabaseCompatibilityService.php | 22 | * This service generates SQL expressions used in selectRaw(), whereRaw(), orderByRaw(), and groupBy(). |
| app/Services/Performance/QueryOptimizationService.php | 119 | $existingIndexes = DB::select("SHOW INDEXES FROM {$wrappedTable}"); |
| app/Services/Performance/QueryOptimizationService.php | 123 | $columns = DB::select("SHOW COLUMNS FROM {$wrappedTable}"); |
| app/Services/Performance/QueryOptimizationService.php | 187 | DB::statement($optimizeStatement); |
| app/Services/Performance/QueryOptimizationService.php | 224 | $explainResults = DB::select("{$keyword} {$trimmedQuery}"); |
| app/Services/QueryPerformanceService.php | 104 | $tables = DB::select(' |
| app/Services/QueryPerformanceService.php | 119 | $indexUsage = DB::select(' |
| app/Services/QueryPerformanceService.php | 216 | $explain = DB::select('EXPLAIN FORMAT=JSON '.$sql); |
| app/Services/Reports/CashFlowForecastService.php | 76 | ->whereRaw('(total_amount - paid_amount) > 0') |
| app/Services/Reports/CashFlowForecastService.php | 97 | ->whereRaw('(total_amount - paid_amount) > 0') |
| app/Services/ScheduledReportService.php | 20 | * This service uses selectRaw(), groupBy(), and whereRaw() with variable interpolation. |
| app/Services/ScheduledReportService.php | 161 | $query->whereRaw("({$stockSubquery}) <= COALESCE(products.reorder_point, 0)"); |
| app/Services/SmartNotificationsService.php | 25 | * This service uses selectRaw() and whereRaw() with variable interpolation. |
| app/Services/SmartNotificationsService.php | 63 | ->whereRaw("{$stockExpr} <= products.min_stock") |
| app/Services/SmartNotificationsService.php | 177 | ->whereRaw('(total_amount - paid_amount) > 0') |
| app/Services/SmartNotificationsService.php | 253 | ->whereRaw('(total_amount - paid_amount) > 0') |
| app/Services/StockAlertService.php | 147 | ->whereRaw('current_stock <= alert_threshold * 0.25') |
| app/Services/StockReorderService.php | 28 | * This service uses whereRaw() with variable interpolation. |
| app/Services/StockReorderService.php | 64 | ->whereRaw("({$stockSubquery}) <= reorder_point") |
| app/Services/StockReorderService.php | 97 | ->whereRaw("({$stockSubquery}) <= stock_alert_threshold") |
| app/Services/StockReorderService.php | 98 | ->whereRaw("({$stockSubquery}) > COALESCE(reorder_point, 0)") |
| app/Services/StockService.php | 17 | * This service generates SQL expressions used in selectRaw(), whereRaw(), orderByRaw(), and groupBy(). |
| app/Services/WorkflowAutomationService.php | 18 | * This service uses whereRaw(), selectRaw(), and orderByRaw() with variable interpolation. |
| app/Services/WorkflowAutomationService.php | 54 | ->whereRaw("({$stockSubquery}) <= COALESCE(reorder_point, min_stock, 0)") |
| app/Services/WorkflowAutomationService.php | 201 | ->whereRaw("({$stockSubquery}) <= COALESCE(reorder_point, min_stock, 0)") |
| app/Services/WorkflowAutomationService.php | 204 | ->orderByRaw("(COALESCE(reorder_point, min_stock, 0) - ({$stockSubquery})) DESC") |

**تصنيف:** ليس كله SQLi مؤكدة؛ لكنه backlog مراجعة. القاعدة: أي interpolated expr لازم يكون allow-listed أو bindings.

## 3.7 FINANCE — `bcround()` policy risk (spec غير مقفول باختبارات)
- **Location:** `app/Helpers/helpers.php` (function `bcround`)

**لقطة (أهم الأسطر):**
```php
468:         $offset = '0.' . str_repeat('0', $precision) . '5';
469: 
470:         // Add offset to absolute value. bcadd truncates toward zero at the given precision,
471:         // which effectively implements half-up rounding.
472:         // Need extra precision during addition to avoid premature truncation
473:         $sumPrecision = $precision + 1;
474:         $sum = bcadd($absValue, $offset, $sumPrecision);
475:         
476:         // Now truncate to the target precision using bcadd with '0'
477:         $rounded = bcadd($sum, '0', $precision);
478: 
479:         // Normalize result to avoid "-0.00" display issue
480:         // If the rounded value is zero, return positive zero
481:         if (bccomp($rounded, '0', $precision) === 0) {
482:             return bcadd('0', '0', $precision); // Ensures proper format like "0.00"
483:         }
484: 
485:         // Restore sign if the original value was negative
486:         return $isNegative ? '-' . $rounded : $rounded;
487:     }
```

**ماذا نعمل؟** حتى لو المنطق الحالي صحيح (Half-up away from zero)، لازم نقفل policy بـ Unit tests على حالات موجبة/سالبة/half-ties + use-cases المالية.

## 3.8 CONSISTENCY — إشارات “cached stock vs stock_movements” (قابلية تعارض)
- **STILL- references count:** 55 (مش كله bug، لكنه signals عن مناطق حساسة)
**أهم نقطتين تؤثر على اتساق ERP:**
- `app/Models/Product.php` يحذر أن بعض methods تحدث cached `stock_quantity` فقط.
- `app/Console/Commands/CheckDatabaseIntegrity.php` يحاول اكتشاف inconsistencies/negative stock من stock_movements.

**الفهرس الكامل لإشارات STILL- (للمراجعة):**
| File | Line | Tag line |
|---|---|---|
| app/Console/Commands/CheckDatabaseIntegrity.php | 180 | // STILL-V14-CRITICAL-01 FIX: Check for negative stock using stock_movements as source of truth |
| app/Console/Commands/CheckDatabaseIntegrity.php | 184 | // STILL-V14-CRITICAL-01 FIX: Check for stock inconsistency between |
| app/Console/Commands/CheckDatabaseIntegrity.php | 212 | * STILL-V14-CRITICAL-01 FIX: Check for negative stock using stock_movements table |
| app/Console/Commands/CheckDatabaseIntegrity.php | 238 | * STILL-V14-CRITICAL-01 FIX: Check for stock inconsistency between cached value |
| app/Http/Controllers/Admin/Reports/InventoryReportsExportController.php | 46 | // STILL-V14-CRITICAL-01 FIX: Get stock from stock_movements via StockService (source of truth) |
| app/Http/Controllers/Admin/Reports/InventoryReportsExportController.php | 82 | // STILL-V14-CRITICAL-01 FIX: Use stock from stock_movements (source of truth) |
| app/Http/Controllers/Admin/ReportsController.php | 368 | * STILL-V14-HIGH-01 FIX: Use bank transactions for accurate cashflow |
| app/Http/Controllers/Admin/ReportsController.php | 377 | // STILL-V14-HIGH-01 FIX: Use bank_transactions for accurate cashflow |
| app/Http/Controllers/Api/V1/OrdersController.php | 168 | // STILL-V7-HIGH-U05 FIX: Idempotency - use external_reference instead of reference_number |
| app/Http/Controllers/Api/V1/OrdersController.php | 256 | // STILL-V7-HIGH-U05 FIX: Use external_reference for external IDs (aligns with StoreSyncService) |
| app/Http/Controllers/Api/V1/OrdersController.php | 348 | // STILL-V7-HIGH-U05 FIX: Use external_reference instead of reference_number |
| app/Http/Controllers/Branch/ReportsController.php | 128 | // STILL-V14-HIGH-01 FIX: Compute cashflow from bank transactions instead of sales/purchases paid_amount |
| app/Listeners/UpdateStockOnPurchase.php | 37 | // STILL-V8-HIGH-U06 FIX: Use purchase_item as reference for uniqueness |
| app/Listeners/UpdateStockOnPurchase.php | 57 | // STILL-V8-HIGH-U06 FIX: Use purchase_item as reference_type for proper line-item uniqueness |
| app/Listeners/UpdateStockOnSale.php | 77 | // STILL-V8-HIGH-U06 FIX: Use sale_item as reference for uniqueness |
| app/Listeners/UpdateStockOnSale.php | 97 | // STILL-V8-HIGH-U06 FIX: Use sale_item as reference_type for proper line-item uniqueness |
| app/Livewire/Warehouse/Locations/Index.php | 71 | // STILL-V11-CRITICAL-01 FIX: Map status filter to is_active column |
| app/Models/Product.php | 475 | * STILL-V11-HIGH-02 WARNING: This method ONLY updates the cached stock_quantity field. |
| app/Models/Product.php | 499 | * STILL-V11-HIGH-02 WARNING: This method ONLY updates the cached stock_quantity field. |
| app/Models/Product.php | 507 | * STILL-V9-CRITICAL-01 FIX: Remove clamping to 0 to preserve negative stock visibility |
| app/Models/Sale.php | 204 | // STILL-MEDIUM-09 FIX: Only count completed/posted payments, exclude pending/failed/cancelled |
| app/Models/Scopes/BranchScope.php | 91 | // STILL-V9-HIGH-04 FIX: Fail closed for console contexts (queue workers/scheduled jobs) without user |
| app/Observers/FinancialTransactionObserver.php | 48 | * STILL-HIGH-08 FIX: Use wasChanged() instead of isDirty() after model is saved |
| app/Observers/FinancialTransactionObserver.php | 52 | // STILL-HIGH-08 FIX: Use wasChanged() in updated event - isDirty is unreliable after save |
| app/Observers/FinancialTransactionObserver.php | 117 | * STILL-HIGH-08 FIX: Add restored handler to recalculate payment status when soft-deleted records are restored |
| app/Services/AccountingService.php | 168 | // STILL-V7-CRITICAL-U03 FIX: Credit: Shipping Income (if applicable) |
| app/Services/AccountingService.php | 258 | // STILL-V7-CRITICAL-U03 FIX: Debit: Shipping Expense (if applicable) |
| app/Services/AutomatedAlertService.php | 38 | * STILL-V9-CRITICAL-01 FIX: Use StockService for stock calculations instead of stock_quantity |
| app/Services/AutomatedAlertService.php | 52 | // STILL-V9-CRITICAL-01 FIX: Use StockService instead of stock_quantity |
| app/Services/AutomatedAlertService.php | 77 | * STILL-V9-CRITICAL-01 FIX: Accept current stock as parameter instead of reading from product model |
| app/Services/AutomatedAlertService.php | 218 | * STILL-V9-CRITICAL-01 FIX: Use StockService for stock calculations instead of stock_quantity |
| app/Services/AutomatedAlertService.php | 238 | // STILL-V9-CRITICAL-01 FIX: Use stock_movements as source of truth |
| app/Services/AutomatedAlertService.php | 247 | // STILL-V9-CRITICAL-01 FIX: Calculate current stock from stock_movements via helper method |
| app/Services/BankingService.php | 137 | * STILL-V7-MEDIUM-N08 FIX: Return string for precision, convert to float only at display layer |
| app/Services/BankingService.php | 267 | * STILL-V7-MEDIUM-N08 FIX: Return string for precision in reports |
| app/Services/BankingService.php | 325 | // STILL-V7-MEDIUM-N08 FIX: getAccountBalance now returns string for precision |
| app/Services/BranchContextManager.php | 45 | * STILL-V9-HIGH-04 FIX: Explicitly set branch ID for console/queue contexts |
| app/Services/BranchContextManager.php | 228 | * STILL-V9-HIGH-04 FIX: Get the explicitly set branch ID for console/queue contexts |
| app/Services/BranchContextManager.php | 239 | * STILL-V9-HIGH-04 FIX: Set an explicit branch context for console/queue contexts |
| app/Services/BranchContextManager.php | 264 | * STILL-V9-HIGH-04 FIX: Clear the explicit branch context |
| app/Services/Contracts/PurchaseServiceInterface.php | 18 | * STILL-V7-HIGH-U08 FIX: Updated signature to include payment method and notes |
| app/Services/Dashboard/DashboardDataService.php | 220 | * STILL-V7-CRITICAL-U02 FIX: Calculate stock from stock_movements instead of products.stock_quantity |
| app/Services/FinancialReportService.php | 276 | * STILL-V8-HIGH-N06 FIX: Calculate outstanding from payment tables instead of paid_amount field |
| app/Services/FinancialReportService.php | 304 | // STILL-V8-HIGH-N06 FIX: Calculate paid amount from SalePayment ledger |
| app/Services/FinancialReportService.php | 310 | // STILL-V8-HIGH-N06 FIX: Get refund total from pre-fetched data |
| app/Services/FinancialReportService.php | 360 | * STILL-V8-HIGH-N06 FIX: Calculate outstanding from payment tables instead of paid_amount field |
| app/Services/FinancialReportService.php | 378 | // STILL-V8-HIGH-N06 FIX: Calculate paid amount from PurchasePayment ledger |
| app/Services/PurchaseService.php | 204 | * STILL-V7-HIGH-U08 FIX: Pay method with proper payment entity creation |
| app/Services/PurchaseService.php | 228 | // STILL-V7-HIGH-U08 FIX: Create PurchasePayment record for audit trail |
| app/Services/SaleService.php | 217 | // STILL-V7-CRITICAL-U04 FIX: Create a RefundPayment record instead of directly mutating paid_amount |
| app/Services/SaleService.php | 338 | * STILL-V7-HIGH-U07 FIX: Void sale with proper stock and accounting reversal |
| app/Services/SaleService.php | 394 | // STILL-V7-HIGH-U07 FIX: Reverse accounting entries if journal entry exists |
| app/Services/StockService.php | 99 | * STILL-V14-CRITICAL-01 FIX: Add branch-scoped bulk stock calculation |
| app/Services/StockService.php | 295 | * STILL-V7-HIGH-N07 FIX: Uses SELECT FOR UPDATE locking to prevent race conditions |
| app/Services/StockService.php | 343 | // STILL-V7-HIGH-N07 FIX: Lock the rows for this product+warehouse combination |

---

# 4) الخطة الأفضل (System‑Wide) — لمنع Bugs جديدة ومنع Regression

الفكرة: بدل ما نصلّح كل شاشة بشكل يدوي، نقفل 5 محاور Baseline + Guardrails تمنع أي developer يكرر نفس النوع من الخطأ.

## Phase 0 — تعريف Invariants كـ “قوانين”
**القرارات التي سنعتمدها تلقائيًا بناء على الكود الحالي:**
1. **Branch = Tenant** افتراضيًا: أي model فيه `branch_id` يعتبر Branch-owned إلا لو تم توثيق استثناء صريح.
2. أي mutation (create/update/delete/approve/submit) يجب أن يكون: `authorize` + `branch-safe` + `transaction-safe` عند multi-write.
3. Side effects (stock/accounting) إما داخل transaction أو queued after commit (والمشروع يبدو مهيأ لذلك عبر `queue.after_commit=true`).

## Phase 1 — إغلاق Tenancy بالكامل (أعلى عائد/أعلى خطورة)
### 1.1 Model scoping enforcement
- **Target files:**
  - `app/Models/BaseModel.php` (يحمل HasBranch)
  - `app/Traits/HasBranch.php` + `app/Models/Scopes/BranchScope.php`
  - **الموديلات الـ 18 غير scoped** (Appendix في الأعلى)

**التنفيذ المقترح (بدون كسر):**
1) تحويل كل موديل من الـ 18 ليكون `extends BaseModel` أو `use HasBranch` (قرار واحد موحد).
2) إضافة **Unit test حارس** يفشل إذا ظهر Model جديد فيه `branch_id` بدون HasBranch/BaseModel.

### 1.2 Audit نقاط إلغاء الـ scope (`withoutGlobalScopes`)
- **Target files (أهمها):**
  - `app/Http/Controllers/Api/V1/WebhooksController.php`
  - `app/Services/Store/StoreSyncService.php`
**قواعد إصلاح/تحصين:**
1) أي بدون scope لازم يقيّد بـ `where('branch_id', resolvedBranchId)` أو يمر عبر `BranchAccessService`/token mapping.
2) إضافة logging/audit لكل عملية cross-scope + Tests تمنع قراءة/كتابة خارج الفرع.

## Phase 2 — Branch-aware Validation (سد ثغرة الـ exists)
**هدف:** لا يوجد في المشروع `exists:table,id` على branch-owned بدون `where(branch_id)`.

**Design:**
- إنشاء helper/Rule موحد:
  - مثلًا `App\Rules\ExistsInBranch` أو macro `Rule::existsInBranch($table)`.
- تعديل الـ 25 occurrence حسب الفهرس (Section 3.2).
- إضافة test/CI check يمنع رجوع pattern.

## Phase 3 — Livewire Authorization Baseline
**هدف:** كل mutation method تحتوي authorize داخليًا (حتى لو route middleware موجود).

**Design options (نختار الأفضل للمشروع ككل):**
1) **Policy-first** لكل Resource (أفضل على المدى الطويل):
   - `SalePolicy`, `PurchasePolicy`, `StockTransferPolicy`, ...
   - كل method: `$this->authorize('update', $model)` أو `$this->authorize('create', Model::class)`
2) Permission-first (Spatie) مع abilities ثابتة + mapping لكل شاشة.

**اختياريًا (أفضل Hybrid):**
- Policy تحسم ownership/branch، وPermission تحسم “هل هذا الدور مسموح أصلًا”.

**Guardrail:** Test/Static check يفشل إذا method فيها `save/delete/update/destroy` بدون `authorize` (يمكن إعادة استخدام نفس pattern scanner في CI).

## Phase 4 — Transactional Integrity (ERP Correctness)
**هدف:** أي flow يكتب أكثر من جدول/أكثر من record مرتبط ⇒ `DB::transaction()`.

**نمط موجود بالفعل كنموذج:**
- `app/Livewire/Sales/Form.php::save()` يستخدم `DB::transaction` + handleOperation pattern.
- `app/Services/POSService.php::checkout()` داخل transaction.

**ما نفعله:**
1) تحديد كل عمليات multi-write داخل Livewire/Controllers/Services (خصوصًا Purchases/Inventory/Manufacturing/Banking).
2) توحيد wrapper مثل `handleOperation()` / `handleServiceOperation()` بحيث:
   - يطبّق `authorize` + `branchId` + `transaction` + logging + consistent error handling.

## Phase 5 — Security Hardening (XSS + Raw SQL + Exec)
### 5.1 XSS
- `resources/views/components/ui/card.blade.php:{!! $actions !!}` ⇒ لازم whitelist HTML أو render slots بدل raw string.
- `resources/views/components/ui/form/input.blade.php` ⇒ `$wireDirective` لازم يبقى generated safe (no user input) أو يتحول لـ attribute builder.

### 5.2 Raw SQL
- كل `$expr` داخل whereRaw/orderByRaw: إما allow-list ثابت أو bindings.
- حط Tests على queries الحرجة (dashboards/reports) عشان أي refactor ما يكسر correctness.

### 5.3 OS commands (Backup/Diagnostics)
- `app/Jobs/BackupDatabaseJob.php`, `app/Services/BackupService.php`, `app/Services/DiagnosticsService.php`
  - تأكيد أن كل args ليست من user input أو يتم escape عبر Symfony Process.

## Phase 6 — Tests + CI لمنع Regression (المهم عندك)
### 6.1 حزمة اختبارات “حراس النظام” (Guard tests)
1) **Branch scope guard:** يفشل إذا وجد Model فيه `branch_id` بدون HasBranch/BaseModel.
2) **Validation guard:** يفشل إذا وجد `exists:branch_owned_table,id` بدون Rule scoped.
3) **Livewire guard:** يفشل إذا وجد mutation method بدون authorize (نفس scanner).
4) **Integration guard:** أي `withoutGlobalScopes` لازم يكون محصور في integration layer + يمر بمحددات branch/store.

### 6.2 اختبارات correctness للـ Cycles (Feature/Integration)
- Sales/POS: بيع في Branch A لا يخصم مخزون Branch B ولا يخلق movement لبضاعة من فرع آخر.
- Purchases: receive يضيف مخزون correct + يمنع duplicate movement.
- Transfers: atomic (header/items/movements) + rollback يترك النظام متسق.
- Accounting: journal balanced + reversal works.

### 6.3 CI/Quality gates
- `phpunit` + coverage على الحراس.
- `laravel pint` للتنسيق.
- (اختياري) `phpstan/larastan` لقفل nulls/return types.

## Phase 7 — Release/Change Cycle (عشان أي تغيير ميعملش bug)
**Workflow مقترح لكل تغيير:**
1) تحديد cycle affected (Sales/Purchases/Inventory/...)
2) تحديث/إضافة tests قبل التعديل أو معه.
3) تشغيل Guard tests + module tests + smoke.
4) Code review checklist:
   - Branch context واضح؟
   - authorize داخل mutation؟
   - multi-write داخل transaction؟
   - أي exists على branch-owned scoped؟
   - أي raw SQL interpolated allow-listed/bound؟

---

# 5) Appendix — فهارس مفيدة للتنفيذ

## A) قائمة الموديلات غير scoped (18)
| Model file | Class line |
|---|---|
| app/Models/AuditLog.php | 14 |
| app/Models/BranchModule.php | 11 |
| app/Models/ChartOfAccount.php | 15 |
| app/Models/CreditNote.php | 12 |
| app/Models/DebitNote.php | 17 |
| app/Models/LeaveHoliday.php | 16 |
| app/Models/Media.php | 20 |
| app/Models/ModuleField.php | 19 |
| app/Models/ModulePolicy.php | 19 |
| app/Models/ModuleSetting.php | 18 |
| app/Models/Project.php | 15 |
| app/Models/PurchaseReturn.php | 19 |
| app/Models/PurchaseReturnItem.php | 15 |
| app/Models/ReturnRefund.php | 10 |
| app/Models/SalesReturn.php | 12 |
| app/Models/StockTransfer.php | 12 |
| app/Models/SupplierPerformanceMetric.php | 16 |
| app/Models/Ticket.php | 18 |

## B) قائمة Livewire mutation methods flagged (78)
| File | Line | Method |
|---|---|---|
| app/Livewire/Admin/Branch/Employees.php | 68 | toggleStatus |
| app/Livewire/Admin/Branch/Settings.php | 72 | save |
| app/Livewire/Admin/Branches/Form.php | 179 | save |
| app/Livewire/Admin/BulkImport.php | 141 | loadGoogleSheet |
| app/Livewire/Admin/BulkImport.php | 308 | runImport |
| app/Livewire/Admin/Categories/Form.php | 85 | save |
| app/Livewire/Admin/Currency/Form.php | 81 | save |
| app/Livewire/Admin/MediaLibrary.php | 142 | delete |
| app/Livewire/Admin/Modules/Form.php | 109 | save |
| app/Livewire/Admin/Modules/ManagementCenter.php | 157 | toggleModuleForBranch |
| app/Livewire/Admin/Modules/ManagementCenter.php | 190 | toggleModuleActive |
| app/Livewire/Admin/Modules/ProductFields.php | 122 | reorder |
| app/Livewire/Admin/Modules/ProductFields/Form.php | 157 | save |
| app/Livewire/Admin/Reports/ReportTemplatesManager.php | 206 | delete |
| app/Livewire/Admin/Reports/ScheduledReportsManager.php | 253 | delete |
| app/Livewire/Admin/Roles/Form.php | 201 | save |
| app/Livewire/Admin/Settings/SystemSettings.php | 104 | save |
| app/Livewire/Admin/Settings/UnifiedSettings.php | 440 | saveSecurity |
| app/Livewire/Admin/Settings/UnifiedSettings.php | 631 | restoreDefaults |
| app/Livewire/Admin/Settings/UserPreferences.php | 41 | save |
| app/Livewire/Admin/Settings/UserPreferences.php | 81 | resetToDefaults |
| app/Livewire/Admin/Store/Form.php | 135 | save |
| app/Livewire/Admin/UnitsOfMeasure/Form.php | 107 | save |
| app/Livewire/Admin/Users/Form.php | 151 | save |
| app/Livewire/Auth/Login.php | 55 | login |
| app/Livewire/Banking/Reconciliation.php | 298 | complete |
| app/Livewire/CommandPalette.php | 68 | saveRecentSearch |
| app/Livewire/CommandPalette.php | 106 | clearRecentSearches |
| app/Livewire/Components/DashboardWidgets.php | 134 | toggleWidget |
| app/Livewire/Components/NotesAttachments.php | 99 | saveNote |
| app/Livewire/Components/NotesAttachments.php | 147 | deleteNote |
| app/Livewire/Components/NotesAttachments.php | 159 | togglePin |
| app/Livewire/Components/NotesAttachments.php | 182 | uploadFiles |
| app/Livewire/Components/NotesAttachments.php | 264 | deleteAttachment |
| app/Livewire/Components/NotificationsCenter.php | 71 | markAllAsRead |
| app/Livewire/Customers/Form.php | 103 | save |
| app/Livewire/Dashboard/CustomizableDashboard.php | 456 | saveUserPreferences |
| app/Livewire/Documents/Tags/Index.php | 24 | delete |
| app/Livewire/Expenses/Categories/Form.php | 62 | save |
| app/Livewire/Expenses/Form.php | 108 | save |
| app/Livewire/Helpdesk/Tickets/Form.php | 101 | save |
| app/Livewire/Hrm/Employees/Form.php | 154 | save |
| app/Livewire/Hrm/Payroll/Run.php | 47 | runPayroll |
| app/Livewire/Hrm/SelfService/MyLeaves.php | 113 | cancelRequest |
| app/Livewire/Income/Categories/Form.php | 61 | save |
| app/Livewire/Income/Form.php | 128 | save |
| app/Livewire/Inventory/Batches/Form.php | 74 | save |
| app/Livewire/Inventory/ProductCompatibility.php | 247 | toggleVerified |
| app/Livewire/Inventory/ProductStoreMappings.php | 108 | delete |
| app/Livewire/Inventory/ProductStoreMappings/Form.php | 122 | save |
| app/Livewire/Inventory/Serials/Form.php | 77 | save |
| app/Livewire/Inventory/Services/Form.php | 163 | save |
| app/Livewire/Inventory/VehicleModels.php | 44 | toggleActive |
| app/Livewire/Manufacturing/BillsOfMaterials/Form.php | 80 | save |
| app/Livewire/Manufacturing/ProductionOrders/Form.php | 85 | save |
| app/Livewire/Manufacturing/WorkCenters/Form.php | 126 | save |
| app/Livewire/Profile/Edit.php | 50 | updateProfile |
| app/Livewire/Profile/Edit.php | 67 | updatePassword |
| app/Livewire/Profile/Edit.php | 88 | handleFileUploaded |
| app/Livewire/Profile/Edit.php | 118 | updateAvatar |
| app/Livewire/Profile/Edit.php | 144 | removeAvatar |
| app/Livewire/Purchases/Form.php | 281 | save |
| app/Livewire/Purchases/GRN/Form.php | 134 | saveGRNItems |
| app/Livewire/Purchases/GRN/Form.php | 191 | saveGRNRecord |
| app/Livewire/Purchases/Requisitions/Form.php | 155 | save |
| app/Livewire/Purchases/Requisitions/Form.php | 206 | submit |
| app/Livewire/Purchases/Returns/Index.php | 108 | processReturn |
| app/Livewire/Purchases/Returns/Index.php | 233 | deleteReturn |
| app/Livewire/Rental/Contracts/Form.php | 284 | removeExistingFile |
| app/Livewire/Rental/Contracts/Form.php | 313 | save |
| app/Livewire/Rental/Reports/Dashboard.php | 140 | notifyExpiringContracts |
| app/Livewire/Rental/Units/Form.php | 135 | save |
| app/Livewire/Reports/ScheduledReports.php | 61 | delete |
| app/Livewire/Reports/ScheduledReports/Form.php | 79 | save |
| app/Livewire/Sales/Form.php | 354 | save |
| app/Livewire/Sales/Returns/Index.php | 194 | deleteReturn |
| app/Livewire/Shared/OnboardingGuide.php | 351 | saveProgress |
| app/Livewire/Shared/OnboardingGuide.php | 391 | resetOnboarding |

## C) قائمة `exists:` على branch-owned بدون branch where (25)
| File | Line | Table | Column |
|---|---|---|---|
| app/Livewire/Accounting/Accounts/Form.php | 75 | accounts | id |
| app/Livewire/Accounting/JournalEntries/Form.php | 105 | accounts | id |
| app/Livewire/Banking/Reconciliation.php | 120 | bank_accounts | id |
| app/Http/Controllers/Api/V1/POSController.php | 44 | customers | id |
| app/Http/Controllers/Branch/Motorcycle/ContractController.php | 30 | customers | id |
| app/Livewire/Admin/ApiDocumentation.php | 165 | customers | id |
| app/Livewire/Helpdesk/TicketForm.php | 152 | customers | id |
| app/Livewire/Helpdesk/TicketForm.php | 171 | customers | id |
| app/Livewire/Helpdesk/Tickets/Form.php | 56 | customers | id |
| app/Livewire/Sales/Form.php | 105 | customers | id |
| app/Livewire/Admin/ApiDocumentation.php | 70 | modules | id |
| app/Livewire/Admin/Modules/ProductFields/Form.php | 136 | modules | id |
| app/Livewire/Inventory/Products/Form.php | 264 | modules | id |
| app/Http/Controllers/Api/V1/POSController.php | 35 | products | id |
| app/Livewire/Admin/ApiDocumentation.php | 116 | products | id |
| app/Livewire/Admin/ApiDocumentation.php | 129 | products | id |
| app/Livewire/Admin/ApiDocumentation.php | 168 | products | id |
| app/Livewire/Purchases/Quotations/Form.php | 61 | products | id |
| app/Livewire/Purchases/Quotations/Form.php | 50 | purchase_requisitions | id |
| app/Livewire/FixedAssets/Form.php | 76 | suppliers | id |
| app/Livewire/Purchases/Form.php | 94 | suppliers | id |
| app/Livewire/Purchases/Quotations/Form.php | 51 | suppliers | id |
| app/Http/Controllers/Api/V1/POSController.php | 45 | warehouses | id |
| app/Livewire/Purchases/Form.php | 106 | warehouses | id |
| app/Livewire/Sales/Form.php | 117 | warehouses | id |

## D) قائمة Scope bypass (`withoutGlobalScopes`) (19 )
| File | Line | Snippet |
|---|---|---|
| app/Http/Controllers/Api/V1/WebhooksController.php | 30 | $store = Store::withoutGlobalScopes()->with('integration')->find($storeId); |
| app/Http/Controllers/Api/V1/WebhooksController.php | 83 | $store = Store::withoutGlobalScopes()->with('integration')->find($storeId); |
| app/Http/Controllers/Api/V1/WebhooksController.php | 191 | $store = Store::withoutGlobalScopes()->with('integration')->find($storeId); |
| app/Http/Controllers/Api/V1/WebhooksController.php | 327 | $warehouse = \App\Models\Warehouse::withoutGlobalScopes() |
| app/Http/Controllers/Api/V1/WebhooksController.php | 338 | $warehouse = \App\Models\Warehouse::withoutGlobalScopes() |
| app/Http/Middleware/AuthenticateStoreToken.php | 58 | $storeToken = StoreToken::withoutGlobalScopes()->where('token', $token)->first(); |
| app/Http/Middleware/AuthenticateStoreToken.php | 76 | $store = Store::withoutGlobalScopes() |
| app/Jobs/ClosePosDayJob.php | 33 | $activeBranches = Branch::withoutGlobalScopes() |
| app/Listeners/ProposePurchaseOrder.php | 36 | // V23-CRIT-04 FIX: Use withoutGlobalScopes() to bypass BranchScope |
| app/Listeners/ProposePurchaseOrder.php | 39 | ->withoutGlobalScopes() |
| app/Listeners/SendDueReminder.php | 26 | // V23-CRIT-04 FIX: Use withoutGlobalScopes() to bypass BranchScope when loading tenant |
| app/Listeners/SendDueReminder.php | 29 | ->withoutGlobalScopes() |
| app/Services/BranchContextManager.php | 146 | // IMPORTANT: We use withoutGlobalScopes() to prevent recursion |
| app/Services/BranchContextManager.php | 153 | $query->withoutGlobalScopes(); |
| app/Services/Store/StoreSyncService.php | 929 | $warehouse = \App\Models\Warehouse::withoutGlobalScopes() |
| app/Services/Store/StoreSyncService.php | 940 | $warehouse = \App\Models\Warehouse::withoutGlobalScopes() |
| app/Services/Store/StoreSyncService.php | 966 | $user = User::withoutGlobalScopes() |
| app/Services/Store/StoreSyncService.php | 1002 | $product = Product::withoutGlobalScopes()->find($productId); |
| app/Traits/HasBranch.php | 64 | return $query->withoutGlobalScope(BranchScope::class); |

## E) XSS raw blade (2 )
| Blade file | Line | Expression |
|---|---|---|
| resources/views/components/ui/card.blade.php | 50 | {!! $actions !!} |
| resources/views/components/ui/form/input.blade.php | 83 | @if($validWireModel && $validWireModifier) {!! $wireDirective !!} @endif |

## F) Raw SQL hits (54 )
| File | Line | Snippet |
|---|---|---|
| app/Console/Commands/CheckDatabaseIntegrity.php | 253 | ->whereRaw('ABS(COALESCE(products.stock_quantity, 0) - COALESCE(sm.calculated_stock, 0)) > 0.0001') |
| app/Console/Commands/CheckDatabaseIntegrity.php | 336 | $indexes = DB::select("SHOW INDEX FROM {$table}"); |
| app/Console/Commands/CheckDatabaseIntegrity.php | 432 | DB::statement($fix); |
| app/Http/Controllers/Admin/ReportsController.php | 428 | ->whereRaw('paid_amount < total_amount') |
| app/Http/Controllers/Admin/ReportsController.php | 437 | ->whereRaw('paid_amount < total_amount') |
| app/Livewire/Concerns/LoadsDashboardData.php | 24 | * This trait uses selectRaw(), whereRaw(), and orderByRaw() with variable interpolation. |
| app/Livewire/Concerns/LoadsDashboardData.php | 171 | ->whereRaw("{$stockExpr} <= min_stock") |
| app/Livewire/Concerns/LoadsDashboardData.php | 326 | ->whereRaw("{$stockExpr} <= products.min_stock") |
| app/Livewire/Concerns/LoadsDashboardData.php | 329 | ->orderByRaw($stockExpr) |
| app/Livewire/Hrm/Employees/Index.php | 141 | ->whereRaw("COALESCE(position, '') != ''") |
| app/Livewire/Inventory/StockAlerts.php | 64 | $query->whereRaw('COALESCE(stock_calc.total_stock, 0) <= products.min_stock AND COALESCE(stock_calc.total_stock, 0) > 0'); |
| app/Livewire/Inventory/StockAlerts.php | 66 | $query->whereRaw('COALESCE(stock_calc.total_stock, 0) <= 0'); |
| app/Livewire/Projects/TimeLogs.php | 182 | ->orderByRaw('COALESCE(log_date, date) desc') |
| app/Models/ModuleSetting.php | 118 | })->orderByRaw('CASE WHEN branch_id IS NULL THEN 1 ELSE 0 END'); |
| app/Models/Product.php | 24 | * This model uses whereRaw() in query scopes (scopeLowStock, scopeOutOfStock, scopeInStock) |
| app/Models/Product.php | 309 | ->whereRaw("({$stockSubquery}) <= stock_alert_threshold"); |
| app/Models/Product.php | 332 | return $query->whereRaw("({$stockSubquery}) <= 0"); |
| app/Models/Product.php | 355 | return $query->whereRaw("({$stockSubquery}) > 0"); |
| app/Models/Project.php | 175 | return $query->whereRaw('actual_cost > budget'); |
| app/Models/SearchIndex.php | 57 | * through the second argument to whereRaw(), preventing SQL injection. |
| app/Models/SearchIndex.php | 80 | $builder->whereRaw( |
| app/Models/SearchIndex.php | 89 | $q->whereRaw('LOWER(title) LIKE ?', [$searchTerm]) |
| app/Services/Analytics/AdvancedAnalyticsService.php | 564 | ->whereRaw('COALESCE(stock_quantity, 0) <= min_stock') |
| app/Services/AutomatedAlertService.php | 171 | ->whereRaw('balance >= (credit_limit * 0.8)') // 80% of credit limit |
| app/Services/AutomatedAlertService.php | 239 | ->whereRaw("({$stockSubquery}) > 0") |
| app/Services/Dashboard/DashboardDataService.php | 244 | ->whereRaw('COALESCE(stock.current_stock, 0) <= products.stock_alert_threshold') |
| app/Services/Dashboard/DashboardDataService.php | 246 | ->orderByRaw('COALESCE(stock.current_stock, 0) ASC') |
| app/Services/Dashboard/DashboardDataService.php | 268 | ->whereRaw('COALESCE(stock.current_stock, 0) <= products.stock_alert_threshold') |
| app/Services/DatabaseCompatibilityService.php | 22 | * This service generates SQL expressions used in selectRaw(), whereRaw(), orderByRaw(), and groupBy(). |
| app/Services/Performance/QueryOptimizationService.php | 119 | $existingIndexes = DB::select("SHOW INDEXES FROM {$wrappedTable}"); |
| app/Services/Performance/QueryOptimizationService.php | 123 | $columns = DB::select("SHOW COLUMNS FROM {$wrappedTable}"); |
| app/Services/Performance/QueryOptimizationService.php | 187 | DB::statement($optimizeStatement); |
| app/Services/Performance/QueryOptimizationService.php | 224 | $explainResults = DB::select("{$keyword} {$trimmedQuery}"); |
| app/Services/QueryPerformanceService.php | 104 | $tables = DB::select(' |
| app/Services/QueryPerformanceService.php | 119 | $indexUsage = DB::select(' |
| app/Services/QueryPerformanceService.php | 216 | $explain = DB::select('EXPLAIN FORMAT=JSON '.$sql); |
| app/Services/Reports/CashFlowForecastService.php | 76 | ->whereRaw('(total_amount - paid_amount) > 0') |
| app/Services/Reports/CashFlowForecastService.php | 97 | ->whereRaw('(total_amount - paid_amount) > 0') |
| app/Services/ScheduledReportService.php | 20 | * This service uses selectRaw(), groupBy(), and whereRaw() with variable interpolation. |
| app/Services/ScheduledReportService.php | 161 | $query->whereRaw("({$stockSubquery}) <= COALESCE(products.reorder_point, 0)"); |
| app/Services/SmartNotificationsService.php | 25 | * This service uses selectRaw() and whereRaw() with variable interpolation. |
| app/Services/SmartNotificationsService.php | 63 | ->whereRaw("{$stockExpr} <= products.min_stock") |
| app/Services/SmartNotificationsService.php | 177 | ->whereRaw('(total_amount - paid_amount) > 0') |
| app/Services/SmartNotificationsService.php | 253 | ->whereRaw('(total_amount - paid_amount) > 0') |
| app/Services/StockAlertService.php | 147 | ->whereRaw('current_stock <= alert_threshold * 0.25') |
| app/Services/StockReorderService.php | 28 | * This service uses whereRaw() with variable interpolation. |
| app/Services/StockReorderService.php | 64 | ->whereRaw("({$stockSubquery}) <= reorder_point") |
| app/Services/StockReorderService.php | 97 | ->whereRaw("({$stockSubquery}) <= stock_alert_threshold") |
| app/Services/StockReorderService.php | 98 | ->whereRaw("({$stockSubquery}) > COALESCE(reorder_point, 0)") |
| app/Services/StockService.php | 17 | * This service generates SQL expressions used in selectRaw(), whereRaw(), orderByRaw(), and groupBy(). |
| app/Services/WorkflowAutomationService.php | 18 | * This service uses whereRaw(), selectRaw(), and orderByRaw() with variable interpolation. |
| app/Services/WorkflowAutomationService.php | 54 | ->whereRaw("({$stockSubquery}) <= COALESCE(reorder_point, min_stock, 0)") |
| app/Services/WorkflowAutomationService.php | 201 | ->whereRaw("({$stockSubquery}) <= COALESCE(reorder_point, min_stock, 0)") |
| app/Services/WorkflowAutomationService.php | 204 | ->orderByRaw("(COALESCE(reorder_point, min_stock, 0) - ({$stockSubquery})) DESC") |


and
# APMO ERP v60 — تقرير شامل + خطة عمل (بدون تطبيق تغييرات)

- Date: **2026-01-22**
- Stack: **Laravel ^12.0 / Livewire ^4.0.1 / PHP ^8.2**

هذا التقرير مبني على فحص الكود داخل `apmoerp60.zip` (Services + Models + Livewire + Blade + Routes) بهدف تحديد **المخاطر/البق** وتقديم **Roadmap تنفيذ آمن** يقلل احتمال إدخال Bugs عند أي تغيير.

## 0) خريطة سريعة للمشروع (Architecture/Modules)

### Routes (تشير لتعدد الفروع/الدومينات)

- `routes/api.php`
- `routes/api/admin.php`
- `routes/api/auth.php`
- `routes/api/branch/common.php`
- `routes/api/branch/hrm.php`
- `routes/api/branch/motorcycle.php`
- `routes/api/branch/rental.php`
- `routes/api/branch/spares.php`
- `routes/api/branch/wood.php`
- `routes/api/files.php`
- `routes/api/notifications.php`
- `routes/channels.php`
- `routes/console.php`
- `routes/web.php`

### Livewire modules (حسب عدد الملفات)

- **app/Livewire/Admin**: 65 file(s)
- **app/Livewire/Inventory**: 16 file(s)
- **app/Livewire/Helpdesk**: 13 file(s)
- **app/Livewire/Purchases**: 13 file(s)
- **app/Livewire/Hrm**: 11 file(s)
- **app/Livewire/Rental**: 9 file(s)
- **app/Livewire/Warehouse**: 9 file(s)
- **app/Livewire/Concerns**: 8 file(s)
- **app/Livewire/Manufacturing**: 8 file(s)
- **app/Livewire/Shared**: 8 file(s)
- **app/Livewire/Components**: 7 file(s)
- **app/Livewire/Projects**: 7 file(s)

### Services modules (حسب عدد الملفات)

- **app/Services/Contracts**: 25 file(s)
- **app/Services/Analytics**: 7 file(s)
- **app/Services/Store**: 5 file(s)
- **app/Services/Sms**: 4 file(s)
- **app/Services/Reports**: 3 file(s)
- **app/Services/UX**: 3 file(s)
- **app/Services/Dashboard**: 2 file(s)
- **app/Services/AccountingService.php**: 1 file(s)
- **app/Services/AttachmentAuthorizationService.php**: 1 file(s)
- **app/Services/AuthService.php**: 1 file(s)
- **app/Services/AutomatedAlertService.php**: 1 file(s)
- **app/Services/BackupService.php**: 1 file(s)

### Controllers modules (حسب عدد الملفات)

- **app/Http/Controllers/Branch**: 30 file(s)
- **app/Http/Controllers/Admin**: 18 file(s)
- **app/Http/Controllers/Api**: 9 file(s)
- **app/Http/Controllers/Controller.php**: 1 file(s)
- **app/Http/Controllers/NotificationController.php**: 1 file(s)
- **app/Http/Controllers/Attachments**: 1 file(s)
- **app/Http/Controllers/Auth**: 1 file(s)
- **app/Http/Controllers/Documents**: 1 file(s)
- **app/Http/Controllers/Files**: 1 file(s)
- **app/Http/Controllers/Internal**: 1 file(s)
- **app/Http/Controllers/Portal**: 1 file(s)

## 1) الضمانات الموجودة حاليًا (System Safeguards)

### 1.1 BranchScope (Fail-Closed + Console Safe)

الـ `BranchScope` في v60 **متشدد**: يفلتر على `branch_id`، وبيعمل **fail-closed** لو مفيش user/branch context، وكمان بيدعم Super Admin bypass.

**ملف:** `app/Models/Scopes/BranchScope.php`

```text
064:     public function apply(Builder $builder, Model $model): void
065:     {
066:         // Skip scope only for safe console commands (migrations, seeders, etc.)
067:         // CRITICAL: Queue workers and scheduled tasks MUST apply branch scope
068:         if (app()->runningInConsole() && ! app()->runningUnitTests() && $this->isSafeConsoleCommand()) {
069:             return;
070:         }
071: 
072:         // CRITICAL: Prevent infinite recursion during authentication
073:         // When auth is being resolved, don't apply scope
074:         if (BranchContextManager::isResolvingAuth()) {
075:             return;
076:         }
077: 
078:         // Skip if the model doesn't have a branch_id column
079:         if (! $this->hasBranchIdColumn($model)) {
080:             return;
081:         }
082: 
083:         // Skip for models that should never be scoped by branch
084:         if ($this->shouldExcludeModel($model)) {
085:             return;
086:         }
087: 
088:         // Get current user safely through BranchContextManager
089:         $user = BranchContextManager::getCurrentUser();
090: 
091:         // STILL-V9-HIGH-04 FIX: Fail closed for console contexts (queue workers/scheduled jobs) without user
092:         // Queue workers and scheduled tasks run in console mode but MUST have branch context
093:         // to prevent cross-branch operations. If no user/branch context is set, fail closed.
094:         if (! $user) {
095:             // Check if a branch context was explicitly set via BranchContextManager
096:             $explicitBranchId = BranchContextManager::getExplicitBranchId();
097: 
098:             if ($explicitBranchId !== null) {
099:                 // An explicit branch context was set (e.g., from a job payload)
100:                 $table = $model->getTable();
101:                 $builder->where("{$table}.branch_id", $explicitBranchId);
102:                 return;
103:             }
104: 
105:             // V7-CRITICAL-U01 FIX: Fail closed for both web and console contexts when no user
106:             // Previously, console mode without user returned without applying any filter
107:             // Now: return empty result set for ALL contexts without authentication/branch context
108:             // This prevents queue workers and scheduled jobs from operating across all branches
109:             if (! app()->runningUnitTests()) {
110:                 // Return empty result set by adding an impossible condition
111:                 $table = $model->getTable();
112:                 $builder->whereNull("{$table}.id")->whereNotNull("{$table}.id");
113:             }
114:             return;
115:         }
116: 
117:         // Skip scope for Super Admins (they can see all branches)
118:         if (BranchContextManager::isSuperAdmin($user)) {
119:             return;
120:         }
121: 
122:         // V8-CRITICAL-N01 FIX: Get accessible branch IDs from context manager
123:         // null means Super Admin (all branches) - should have already returned above, but handle defensively
124:         // [] means no access - apply impossible condition
125:         // [ids...] means specific branches - apply filter
126:         $accessibleBranchIds = BranchContextManager::getAccessibleBranchIds();
127: 
128:         // Apply the branch filter
129:         $table = $model->getTable();
130: 
131:         // V8-CRITICAL-N01 FIX: null = Super Admin, don't filter (defensive check, should be handled above)
132:         if ($accessibleBranchIds === null) {
133:             return;
134:         }
135: 
136:         if (count($accessibleBranchIds) === 1) {
137:             $builder->where("{$table}.branch_id", $accessibleBranchIds[0]);
138:         } elseif (count($accessibleBranchIds) > 1) {
139:             $builder->whereIn("{$table}.branch_id", $accessibleBranchIds);
140:         } else {
141:             // V8-CRITICAL-N01 FIX: Empty array [] now clearly means "no access" - return empty result set
142:             // Using a condition that's always false in a database-agnostic way
143:             $builder->whereNull("{$table}.id")->whereNotNull("{$table}.id");
144:         }
145:     }
```

**ملاحظة تصميمية:** ده سلوك ممتاز لـ ERP multi-branch لأنه يمنع أي “cross-branch” queries بالخطأ (خصوصًا في jobs/console).

### 1.2 Policies / Gate

في v60 السيستم بيسجل Policies بشكل صريح داخل `AuthServiceProvider` + Gate::before للسوبر أدمن.

**ملف:** `app/Providers/AuthServiceProvider.php`

```text
045:     protected $policies = [
046:         Branch::class => BranchPolicy::class,
047:         Product::class => ProductPolicy::class,
048:         Purchase::class => PurchasePolicy::class,
049:         Sale::class => SalePolicy::class,
050:         Vehicle::class => VehiclePolicy::class,
051:         Notification::class => NotificationPolicy::class,
052:         Ticket::class => TicketPolicy::class,
053: 
054:         // Rental domain mapped to a generic policy handling multiple models
055:         RentalContract::class => RentalPolicy::class,
056:         RentalInvoice::class => RentalPolicy::class,
057:         Property::class => RentalPolicy::class,
058:         RentalUnit::class => RentalPolicy::class,
059:         Tenant::class => RentalPolicy::class,
060: 
061:         // Manufacturing domain mapped to a generic policy handling multiple models
062:         BillOfMaterial::class => ManufacturingPolicy::class,
063:         ProductionOrder::class => ManufacturingPolicy::class,
064:         WorkCenter::class => ManufacturingPolicy::class,
065: 
066:         // V58-AUTH-01: Reporting domain policies for scheduled reports and templates
067:         ScheduledReport::class => ScheduledReportPolicy::class,
068:         ReportTemplate::class => ReportTemplatePolicy::class,
069:     ];
```

مرجعية: تسجيل الـ Policies في Laravel يتم عبر `$policies` ثم `registerPolicies()` (أو auto-discovery حسب التسمية/المكان). citeturn0search11turn0search6

### 1.3 BranchScopedExists rule

وجود `app/Rules/BranchScopedExists.php` مهم جدًا لتقفيل ثغرة `exists:` على جداول branch-owned (تمنع تمرير IDs من فرع تاني). استخدام `Rule::exists()->where(...)` هو النمط الرسمي لتخصيص exists. citeturn1search11turn1search8


## 2) Bugs / Risks مؤكدة أو عالية الاحتمال (مع المسارات)

### 2.1 CRITICAL — Models مستوردة HasBranch لكن غير مفعّلة (Branch Leak / IDOR)

دي أخطر نقطة في v60 لأن الكود **يوحي** إن الموديلات لازم تكون branch-scoped، لكن الـ trait مش مستخدم داخل class، وبالتالي BranchScope لن يشتغل.

- `app/Models/AuditLog.php:14` — **AuditLog** (HasBranch imported but `use HasBranch;` missing)
- `app/Models/CreditNote.php:12` — **CreditNote** (HasBranch imported but `use HasBranch;` missing)
- `app/Models/DebitNote.php:17` — **DebitNote** (HasBranch imported but `use HasBranch;` missing)
- `app/Models/LeaveHoliday.php:16` — **LeaveHoliday** (HasBranch imported but `use HasBranch;` missing)
- `app/Models/Media.php:20` — **Media** (HasBranch imported but `use HasBranch;` missing)
- `app/Models/ModuleField.php:19` — **ModuleField** (HasBranch imported but `use HasBranch;` missing)
- `app/Models/ModulePolicy.php:19` — **ModulePolicy** (HasBranch imported but `use HasBranch;` missing)
- `app/Models/ModuleSetting.php:18` — **ModuleSetting** (HasBranch imported but `use HasBranch;` missing)
- `app/Models/Project.php:15` — **Project** (HasBranch imported but `use HasBranch;` missing)
- `app/Models/PurchaseReturn.php:19` — **PurchaseReturn** (HasBranch imported but `use HasBranch;` missing)
- `app/Models/PurchaseReturnItem.php:15` — **PurchaseReturnItem** (HasBranch imported but `use HasBranch;` missing)
- `app/Models/ReturnRefund.php:10` — **ReturnRefund** (HasBranch imported but `use HasBranch;` missing)
- `app/Models/SalesReturn.php:12` — **SalesReturn** (HasBranch imported but `use HasBranch;` missing)
- `app/Models/StockTransfer.php:12` — **StockTransfer** (HasBranch imported but `use HasBranch;` missing)
- `app/Models/SupplierPerformanceMetric.php:16` — **SupplierPerformanceMetric** (HasBranch imported but `use HasBranch;` missing)
- `app/Models/Ticket.php:18` — **Ticket** (HasBranch imported but `use HasBranch;` missing)

**الإجراء الصحيح المقترح:**
- تفعيل `use HasBranch;` داخل الـ class (أو تحويل الموديل لـ `BaseModel`) **طالما الجدول فعليًا branch-owned وفيه branch_id**.
- إضافة test يمنع قراءة/تعديل record من Branch B داخل Session لفرع A.


### 2.2 HIGH — `exists:` validations على جداول Branch-owned بدون شرط branch

تم رصد **50** occurrence في Controllers/Requests تستخدم `exists:table,id` على جداول branch-owned بدون تقييد branch.

**الفكرة:** validation يعدّي ID من فرع آخر، وبعدها يحصل access أو ربط خاطئ حتى لو عندك Scopes في بعض الأماكن.

**العلاج الأفضل:** استبدالها بـ `BranchScopedExists` أو `Rule::exists(...)->where('branch_id', current_branch_id)`.

- `app/Livewire/Accounting/Accounts/Form.php:75` — table=`accounts` — `'form.parent_id' => ['nullable', 'exists:accounts,id'],`
- `app/Livewire/Accounting/JournalEntries/Form.php:105` — table=`accounts` — `'lines.*.account_id' => ['required', 'exists:accounts,id'],`
- `app/Livewire/Banking/Reconciliation.php:120` — table=`bank_accounts` — `'accountId' => 'required|exists:bank_accounts,id',`
- `app/Http/Controllers/Api/V1/POSController.php:44` — table=`customers` — `'customer_id' => 'nullable|integer|exists:customers,id',`
- `app/Http/Controllers/Branch/Motorcycle/ContractController.php:30` — table=`customers` — `'customer_id' => ['required', 'exists:customers,id'],`
- `app/Livewire/Admin/ApiDocumentation.php:165` — table=`customers` — `'customer_id' => 'nullable|exists:customers,id',`
- `app/Livewire/Helpdesk/TicketForm.php:152` — table=`customers` — `'customer_id' => 'nullable|exists:customers,id',`
- `app/Livewire/Helpdesk/TicketForm.php:171` — table=`customers` — `'customer_id' => 'nullable|exists:customers,id',`
- `app/Livewire/Helpdesk/Tickets/Form.php:56` — table=`customers` — `'customer_id' => ['nullable', 'exists:customers,id'],`
- `app/Livewire/Sales/Form.php:105` — table=`customers` — `'exists:customers,id',`
- `app/Services/PurchaseReturnService.php:46` — table=`goods_received_notes` — `'grn_id' => 'nullable|integer|exists:goods_received_notes,id',`
- `app/Http/Controllers/Branch/HRM/AttendanceController.php:44` — table=`hr_employees` — `'employee_id' => ['required', 'exists:hr_employees,id'],`
- `app/Http/Controllers/Branch/HRM/AttendanceController.php:65` — table=`hr_employees` — `'employee_id' => ['required', 'exists:hr_employees,id'],`
- `app/Http/Controllers/Branch/HRM/EmployeeController.php:38` — table=`hr_employees` — `'employee_id' => ['required', 'exists:hr_employees,id'],`
- `app/Http/Controllers/Branch/HRM/ReportsController.php:16` — table=`hr_employees` — `'employee_id' => 'nullable|integer|exists:hr_employees,id',`
- `app/Http/Controllers/Branch/HRM/ReportsController.php:105` — table=`hr_employees` — `'employee_id' => 'nullable|integer|exists:hr_employees,id',`
- `app/Http/Requests/AttendanceRequest.php:22` — table=`hr_employees` — `'employee_id' => ['required', 'exists:hr_employees,id'],`
- `app/Http/Requests/LeaveRequestFormRequest.php:22` — table=`hr_employees` — `'employee_id' => ['required', 'exists:hr_employees,id'],`
- `app/Http/Requests/PayrollRunRequest.php:24` — table=`hr_employees` — `'employee_ids.*' => ['exists:hr_employees,id'],`
- `app/Http/Controllers/Api/V1/ProductsController.php:191` — table=`product_categories` — `'category_id' => 'nullable|exists:product_categories,id',`
- `app/Http/Controllers/Api/V1/ProductsController.php:290` — table=`product_categories` — `'category_id' => 'nullable|exists:product_categories,id',`
- `app/Http/Controllers/Branch/ProductController.php:79` — table=`product_categories` — `'category_id' => 'nullable|exists:product_categories,id',`
- `app/Http/Controllers/Branch/ProductController.php:108` — table=`product_categories` — `'category_id' => 'nullable|exists:product_categories,id',`
- `app/Http/Requests/ProductStoreRequest.php:39` — table=`product_categories` — `'category_id' => ['nullable', 'exists:product_categories,id'],`
- `app/Http/Requests/ProductUpdateRequest.php:30` — table=`product_categories` — `'category_id' => ['nullable', 'exists:product_categories,id'],`
- `app/Livewire/Admin/ApiDocumentation.php:69` — table=`product_categories` — `'category_id' => 'nullable|exists:product_categories,id',`
- `app/Livewire/Admin/Categories/Form.php:73` — table=`product_categories` — `'exists:product_categories,id',`
- `app/Http/Controllers/Api/V1/POSController.php:35` — table=`products` — `'items.*.product_id' => 'required|integer|exists:products,id',`
- `app/Livewire/Admin/ApiDocumentation.php:116` — table=`products` — `'product_id' => 'required|exists:products,id',`
- `app/Livewire/Admin/ApiDocumentation.php:129` — table=`products` — `'items.*.product_id' => 'required|exists:products,id',`
- `app/Livewire/Admin/ApiDocumentation.php:168` — table=`products` — `'items.*.product_id' => 'required|exists:products,id',`
- `app/Livewire/Purchases/Quotations/Form.php:61` — table=`products` — `'items.*.product_id' => 'required|exists:products,id',`
- `app/Http/Requests/UnitStoreRequest.php:22` — table=`properties` — `'property_id' => ['required', 'exists:properties,id'],`
- `app/Livewire/Purchases/Quotations/Form.php:50` — table=`purchase_requisitions` — `'requisition_id' => 'required|exists:purchase_requisitions,id',`
- `app/Http/Requests/ContractStoreRequest.php:20` — table=`rental_units` — `$unitValidation = ['required', 'exists:rental_units,id'];`
- `app/Livewire/FixedAssets/Form.php:76` — table=`suppliers` — `'supplier_id' => 'nullable|exists:suppliers,id',`
- `app/Livewire/Purchases/Form.php:94` — table=`suppliers` — `'exists:suppliers,id',`
- `app/Livewire/Purchases/Quotations/Form.php:51` — table=`suppliers` — `'supplier_id' => 'required|exists:suppliers,id',`
- `app/Http/Controllers/Api/V1/POSController.php:40` — table=`taxes` — `'items.*.tax_id' => 'nullable|integer|exists:taxes,id',`
- `app/Http/Controllers/Branch/ProductController.php:80` — table=`taxes` — `'tax_id' => 'nullable|exists:taxes,id',`
- … (المتبقي: 10 occurrence)

مرجعية: Laravel يسمح بإضافة شروط WHERE على exists عبر `Rule::exists()->where(...)`. citeturn1search11turn1search8

### 2.3 HIGH — Livewire mutation methods بدون authorize داخل الميثود

- Backlog مراجعة: **85** method(s) فيها عمليات كتابة (save/update/delete/create/DB write) بدون `authorize()` داخل نفس الميثود.

ده مش لازم معناه Bug 100% (ممكن الـ permission middleware مغطي)، لكن **الـ baseline الآمن** في Livewire هو إن أي action mutating يعمل authorize جوه.


#### 2.3.a Highest risk (id param + findOrFail + mutate + no authorize)

- `app/Livewire/Admin/MediaLibrary.php:142` — `delete(int $id)`
- `app/Livewire/Documents/Tags/Index.php:24` — `delete(int $id)`
- `app/Livewire/Inventory/ProductStoreMappings.php:108` — `delete(int $id)`
- `app/Livewire/Inventory/VehicleModels.php:44` — `toggleActive(int $id)`

**الإجراء الصحيح المقترح:**
- قاعدة سيستم: أي method بتاخد `$id` وتعمل `findOrFail` لازم بعدها `authorize('update/delete', $model)` أو query scoped.
- لو المورد Global: يبقى authorization permission-based واضح.


### 2.4 MEDIUM — Blade unescaped output `{!! !!}`

- تم رصد **17** occurrence.
- أغلبها يستخدم `sanitize_svg_icon(...)` (ده مقبول لو sanitize فعليًا قوي).
- الحالة الأخطر: output مباشر لمتغير زي `$actions`.

- **HOTSPOT** `resources/views/components/ui/card.blade.php:50` — `{!! $actions !!}`

**الإجراء الصحيح المقترح:**
- منع `{!! $var !!}` إلا لو var sanitized/whitelisted.
- توحيد sanitizer function + tests.


### 2.5 MEDIUM/HIGH — Raw SQL ديناميكي (Expression interpolation)

تم رصد **17** أماكن فيها `{${...}}` أو `{$...}` داخل raw SQL (يعني تعبير SQL بيتركب ديناميكيًا).

- `app/Console/Commands/CheckDatabaseIntegrity.php:336` — DB::select — `DB::select("SHOW INDEX FROM {$table}");`
- `app/Livewire/Components/DashboardWidgets.php:126` — Raw clause — `havingRaw('COALESCE(SUM(stock_movements.quantity), 0) <= products.min_stock'),`
- `app/Livewire/Concerns/LoadsDashboardData.php:171` — Raw clause — `whereRaw("{$stockExpr} <= min_stock")`
- `app/Livewire/Dashboard/CustomizableDashboard.php:251` — DB::raw — `DB::raw('COALESCE(default_price, 0) * COALESCE(stock_quantity, 0)'));`
- `app/Livewire/Purchases/Index.php:116` — DB::raw — `DB::raw('(purchases.total_amount - purchases.paid_amount) as amount_due'),`
- `app/Models/Product.php:309` — Raw clause — `whereRaw("({$stockSubquery}) <= stock_alert_threshold");`
- `app/Models/SearchIndex.php:80` — Raw clause — `whereRaw(`
- `app/Services/Analytics/ProfitMarginAnalysisService.php:67` — DB::raw — `DB::raw('COALESCE(SUM(sale_items.quantity), 0) as units_sold'),`
- `app/Services/Analytics/SalesForecastingService.php:111` — DB::raw — `DB::raw("{$periodExpr} as period"),`
- `app/Services/AutomatedAlertService.php:171` — Raw clause — `whereRaw('balance >= (credit_limit * 0.8)') // 80% of credit limit`
- `app/Services/Performance/QueryOptimizationService.php:119` — DB::select — `DB::select("SHOW INDEXES FROM {$wrappedTable}");`
- `app/Services/Reports/CustomerSegmentationService.php:191` — Raw clause — `havingRaw("{$datediffExpr} > 60")`
- `app/Services/Reports/SlowMovingStockService.php:71` — Raw clause — `havingRaw("COALESCE({$daysDiffExpr}, 999) > ?", [$days])`
- `app/Services/ScheduledReportService.php:161` — Raw clause — `whereRaw("({$stockSubquery}) <= COALESCE(products.reorder_point, 0)");`
- `app/Services/SmartNotificationsService.php:63` — Raw clause — `whereRaw("{$stockExpr} <= products.min_stock")`
- `app/Services/StockReorderService.php:64` — Raw clause — `whereRaw("({$stockSubquery}) <= reorder_point")`
- `app/Services/WorkflowAutomationService.php:54` — Raw clause — `whereRaw("({$stockSubquery}) <= COALESCE(reorder_point, min_stock, 0)")`

**التفسير:** مش بالضرورة SQLi لو التعبير مبني من allow-list داخلي، لكن لازم يكون فيه “proof”:
- المتغيرات اللي بتدخل في SQL تكون *غير قادمة من user input*.
- أي قيمة user-provided تكون parameterized bindings.
- أسماء الجداول/الأعمدة يتم allow-list/quote.


### 2.6 INFO — Finance rounding (bcround)

الملف `app/Helpers/helpers.php` يحتوي تنفيذ `bcround()` مكتوب عليه صراحة إنه fix لـ rounding السالب “away from zero”.

- **ملف:** `app/Helpers/helpers.php` (حول السطور ~434)

**الإجراء المقترح:** إضافة Unit tests للأرقام السالبة/الموجبة وحدود 0.005… لضمان عدم رجوع Bug.


## 3) “الأفضل” لمشروع ERP متعدد الفروع: سياسة قرارات (Decision Framework)

### 3.1 قاعدة Tenant افتراضية

- أي Model/جدول فيه `branch_id` ⇒ **Branch-owned** ⇒ لازم scope + authorize.
- أي Model بدون `branch_id` ⇒ إما **Global reference** (Permissions قوية) أو **User-owned** (ownership policy).

ده بيقلل انك “تخمن” كل مرة، وبيمنع إدخال Bugs عند التوسع.


### 3.2 أين نضع الـ Authorization؟

**Recommendation:**
- Controllers: `authorizeResource` / `authorize()` per action.
- Livewire: authorize داخل كل mutation method (مش بس في mount/render).
- Services: لا تعتمد على auth داخل service؛ الخدمات تتلقى Context (branch/user) صريحًا وتُستدعى من layer authorized.

مرجعية policies/registration: citeturn0search11turn0search6

### 3.3 Transactions كقاعدة Integrity

أي عملية ERP multi-write (Header + Items + Movements + Ledger) لازم تكون `DB::transaction()`.

Laravel يضمن rollback تلقائيًا لو exception داخل transaction closure. citeturn1search4

**نمط موصى به:** transaction في Service layer (أقرب للـ domain operation) بدل Controller.


## 4) خطة تنفيذ كاملة على شكل 5 مراحل + Cycles تمنع إدخال Bugs

### المرحلة 1 — Tenancy/Branch Baseline (الأعلى أولوية)

هدفها: قفل أي cross-branch access.
- إصلاح موديلات HasBranch imported-not-used (القائمة أعلاه).
- تحويل كل `exists:` على branch-owned لـ BranchScopedExists/Rule::exists(where branch_id).
- إضافة Feature tests: Branch A لا يقدر يقرأ/يعدل record من Branch B حتى لو عرف الـ ID.


### المرحلة 2 — Authorization Baseline (Controllers + Livewire)

هدفها: لا يوجد mutation بدون authorize.
- معالجة الـ 4 high-risk Livewire methods المذكورين.
- ثم مراجعة باقي backlog (methods) بتصنيفها:
  - Self-owned (مسموح بشرط ownership)
  - Admin-only (perm gate)
  - Branch-owned (policy)
- إضافة automated test: محاولة call للـ Livewire action بدون صلاحية ⇒ 403.


### المرحلة 3 — Consistency/Transactions + Financial invariants

هدفها: منع partial commits.
- حصر كل العمليات multi-write في Services/Controllers/Livewire.
- enforce transactions.
- إضافة tests rollback (throw mid-way ويجب عدم حفظ أي جزء).


### المرحلة 4 — Security hygiene (XSS + Raw SQL)

هدفها: تقليل surface area.
- إزالة/تقييد `{!! $actions !!}` أو ضمان whitelist/escape.
- مراجعة raw SQL الديناميكي (القائمة أعلاه) وإضافة allow-list/quoting.
- إضافة security tests بسيطة (XSS payload لا يظهر unescaped).


### المرحلة 5 — Regression Suite + CI/CD Cycles

هدفها: أي تغيير مايرجعش Bug.

**CI Pipeline مقترح (كل PR):**
1) `composer test` (Unit + Feature)
2) `php artisan test --parallel`
3) Static analysis (Larastan/PHPStan)
4) Lint/format (Pint)
5) Security checks (dependency audit)
6) Optional: Dusk/Browser tests لسيناريوهات ERP الأساسية.

**Release Cycle مقترح:**
- Stage 1: Deploy على staging ببيانات متعددة الفروع (branch A/B) + smoke tests.
- Stage 2: UAT على flows الحساسة (Sales/Purchases/Inventory/Accounting).
- Stage 3: Production deploy + مراقبة logs/failed jobs/queue + rollback plan.


## 5) قائمة الـ “Cycles” العملية لكل تغيير (عشان ما يعملش bug)

### Cycle لكل تغيير على Business flow
1) تعريف الـ Invariants (مثال: stock movement لازم يساوي sum(items)).
2) كتابة/تعديل tests قبل أو مع التغيير.
3) تطبيق التغيير (وراء feature flag لو مخاطرة عالية).
4) تشغيل CI + اختبار staging بفرعين على الأقل.
5) Release + monitoring + post-release checklist.

### Cycle لأي تغيير على Tenancy/Branch
- إضافة test IDOR cross-branch دائمًا.
- إضافة/تحديث BranchScopedExists + policy.
- مراجعة أي usage لـ `findOrFail($id)` على branch-owned.


---
## Appendix A — قوائم مختصرة جاهزة للتنفيذ

### A1) Models تحتاج تفعيل HasBranch (import موجود لكن trait مش مستخدم) — count: 16

- `app/Models/AuditLog.php:14` — AuditLog
- `app/Models/CreditNote.php:12` — CreditNote
- `app/Models/DebitNote.php:17` — DebitNote
- `app/Models/LeaveHoliday.php:16` — LeaveHoliday
- `app/Models/Media.php:20` — Media
- `app/Models/ModuleField.php:19` — ModuleField
- `app/Models/ModulePolicy.php:19` — ModulePolicy
- `app/Models/ModuleSetting.php:18` — ModuleSetting
- `app/Models/Project.php:15` — Project
- `app/Models/PurchaseReturn.php:19` — PurchaseReturn
- `app/Models/PurchaseReturnItem.php:15` — PurchaseReturnItem
- `app/Models/ReturnRefund.php:10` — ReturnRefund
- `app/Models/SalesReturn.php:12` — SalesReturn
- `app/Models/StockTransfer.php:12` — StockTransfer
- `app/Models/SupplierPerformanceMetric.php:16` — SupplierPerformanceMetric
- `app/Models/Ticket.php:18` — Ticket

### A2) `exists:` risky occurrences — count: 50 (عرض أول 40)

- `app/Livewire/Accounting/Accounts/Form.php:75` — `'form.parent_id' => ['nullable', 'exists:accounts,id'],`
- `app/Livewire/Accounting/JournalEntries/Form.php:105` — `'lines.*.account_id' => ['required', 'exists:accounts,id'],`
- `app/Livewire/Banking/Reconciliation.php:120` — `'accountId' => 'required|exists:bank_accounts,id',`
- `app/Http/Controllers/Api/V1/POSController.php:44` — `'customer_id' => 'nullable|integer|exists:customers,id',`
- `app/Http/Controllers/Branch/Motorcycle/ContractController.php:30` — `'customer_id' => ['required', 'exists:customers,id'],`
- `app/Livewire/Admin/ApiDocumentation.php:165` — `'customer_id' => 'nullable|exists:customers,id',`
- `app/Livewire/Helpdesk/TicketForm.php:152` — `'customer_id' => 'nullable|exists:customers,id',`
- `app/Livewire/Helpdesk/TicketForm.php:171` — `'customer_id' => 'nullable|exists:customers,id',`
- `app/Livewire/Helpdesk/Tickets/Form.php:56` — `'customer_id' => ['nullable', 'exists:customers,id'],`
- `app/Livewire/Sales/Form.php:105` — `'exists:customers,id',`
- `app/Services/PurchaseReturnService.php:46` — `'grn_id' => 'nullable|integer|exists:goods_received_notes,id',`
- `app/Http/Controllers/Branch/HRM/AttendanceController.php:44` — `'employee_id' => ['required', 'exists:hr_employees,id'],`
- `app/Http/Controllers/Branch/HRM/AttendanceController.php:65` — `'employee_id' => ['required', 'exists:hr_employees,id'],`
- `app/Http/Controllers/Branch/HRM/EmployeeController.php:38` — `'employee_id' => ['required', 'exists:hr_employees,id'],`
- `app/Http/Controllers/Branch/HRM/ReportsController.php:16` — `'employee_id' => 'nullable|integer|exists:hr_employees,id',`
- `app/Http/Controllers/Branch/HRM/ReportsController.php:105` — `'employee_id' => 'nullable|integer|exists:hr_employees,id',`
- `app/Http/Requests/AttendanceRequest.php:22` — `'employee_id' => ['required', 'exists:hr_employees,id'],`
- `app/Http/Requests/LeaveRequestFormRequest.php:22` — `'employee_id' => ['required', 'exists:hr_employees,id'],`
- `app/Http/Requests/PayrollRunRequest.php:24` — `'employee_ids.*' => ['exists:hr_employees,id'],`
- `app/Http/Controllers/Api/V1/ProductsController.php:191` — `'category_id' => 'nullable|exists:product_categories,id',`
- `app/Http/Controllers/Api/V1/ProductsController.php:290` — `'category_id' => 'nullable|exists:product_categories,id',`
- `app/Http/Controllers/Branch/ProductController.php:79` — `'category_id' => 'nullable|exists:product_categories,id',`
- `app/Http/Controllers/Branch/ProductController.php:108` — `'category_id' => 'nullable|exists:product_categories,id',`
- `app/Http/Requests/ProductStoreRequest.php:39` — `'category_id' => ['nullable', 'exists:product_categories,id'],`
- `app/Http/Requests/ProductUpdateRequest.php:30` — `'category_id' => ['nullable', 'exists:product_categories,id'],`
- `app/Livewire/Admin/ApiDocumentation.php:69` — `'category_id' => 'nullable|exists:product_categories,id',`
- `app/Livewire/Admin/Categories/Form.php:73` — `'exists:product_categories,id',`
- `app/Http/Controllers/Api/V1/POSController.php:35` — `'items.*.product_id' => 'required|integer|exists:products,id',`
- `app/Livewire/Admin/ApiDocumentation.php:116` — `'product_id' => 'required|exists:products,id',`
- `app/Livewire/Admin/ApiDocumentation.php:129` — `'items.*.product_id' => 'required|exists:products,id',`
- `app/Livewire/Admin/ApiDocumentation.php:168` — `'items.*.product_id' => 'required|exists:products,id',`
- `app/Livewire/Purchases/Quotations/Form.php:61` — `'items.*.product_id' => 'required|exists:products,id',`
- `app/Http/Requests/UnitStoreRequest.php:22` — `'property_id' => ['required', 'exists:properties,id'],`
- `app/Livewire/Purchases/Quotations/Form.php:50` — `'requisition_id' => 'required|exists:purchase_requisitions,id',`
- `app/Http/Requests/ContractStoreRequest.php:20` — `$unitValidation = ['required', 'exists:rental_units,id'];`
- `app/Livewire/FixedAssets/Form.php:76` — `'supplier_id' => 'nullable|exists:suppliers,id',`
- `app/Livewire/Purchases/Form.php:94` — `'exists:suppliers,id',`
- `app/Livewire/Purchases/Quotations/Form.php:51` — `'supplier_id' => 'required|exists:suppliers,id',`
- `app/Http/Controllers/Api/V1/POSController.php:40` — `'items.*.tax_id' => 'nullable|integer|exists:taxes,id',`
- `app/Http/Controllers/Branch/ProductController.php:80` — `'tax_id' => 'nullable|exists:taxes,id',`

### A3) Livewire high-risk IDOR methods — count: 4

- `app/Livewire/Admin/MediaLibrary.php:142` — `delete(int $id)`
- `app/Livewire/Documents/Tags/Index.php:24` — `delete(int $id)`
- `app/Livewire/Inventory/ProductStoreMappings.php:108` — `delete(int $id)`
- `app/Livewire/Inventory/VehicleModels.php:44` — `toggleActive(int $id)`

### A4) Raw SQL dynamic expressions — count: 17

- `app/Console/Commands/CheckDatabaseIntegrity.php:336` — `DB::select("SHOW INDEX FROM {$table}");`
- `app/Livewire/Components/DashboardWidgets.php:126` — `havingRaw('COALESCE(SUM(stock_movements.quantity), 0) <= products.min_stock'),`
- `app/Livewire/Concerns/LoadsDashboardData.php:171` — `whereRaw("{$stockExpr} <= min_stock")`
- `app/Livewire/Dashboard/CustomizableDashboard.php:251` — `DB::raw('COALESCE(default_price, 0) * COALESCE(stock_quantity, 0)'));`
- `app/Livewire/Purchases/Index.php:116` — `DB::raw('(purchases.total_amount - purchases.paid_amount) as amount_due'),`
- `app/Models/Product.php:309` — `whereRaw("({$stockSubquery}) <= stock_alert_threshold");`
- `app/Models/SearchIndex.php:80` — `whereRaw(`
- `app/Services/Analytics/ProfitMarginAnalysisService.php:67` — `DB::raw('COALESCE(SUM(sale_items.quantity), 0) as units_sold'),`
- `app/Services/Analytics/SalesForecastingService.php:111` — `DB::raw("{$periodExpr} as period"),`
- `app/Services/AutomatedAlertService.php:171` — `whereRaw('balance >= (credit_limit * 0.8)') // 80% of credit limit`
- `app/Services/Performance/QueryOptimizationService.php:119` — `DB::select("SHOW INDEXES FROM {$wrappedTable}");`
- `app/Services/Reports/CustomerSegmentationService.php:191` — `havingRaw("{$datediffExpr} > 60")`
- `app/Services/Reports/SlowMovingStockService.php:71` — `havingRaw("COALESCE({$daysDiffExpr}, 999) > ?", [$days])`
- `app/Services/ScheduledReportService.php:161` — `whereRaw("({$stockSubquery}) <= COALESCE(products.reorder_point, 0)");`
- `app/Services/SmartNotificationsService.php:63` — `whereRaw("{$stockExpr} <= products.min_stock")`
- `app/Services/StockReorderService.php:64` — `whereRaw("({$stockSubquery}) <= reorder_point")`
- `app/Services/WorkflowAutomationService.php:54` — `whereRaw("({$stockSubquery}) <= COALESCE(reorder_point, min_stock, 0)")`