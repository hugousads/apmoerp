# APMO ERP v65 — Bug Audit Report

- Date: **2026-01-22**
- Stack: **Laravel ^12.0 / Livewire ^4.0.1 / PHP ^8.2**

Scope: static audit للكود (Models/Services/Livewire/Controllers/Blade/Migrations) لاستخراج bugs (Security/Logic/Finance/Data integrity). لا تشغيل runtime ولا DB.

## Summary

- Total findings: **274**

- By severity:

  - CRITICAL: **31**
  - HIGH: **186**
  - MEDIUM: **57**

## CRITICAL

### CRITICAL-001 — Security/IDOR

- **File:** `app/Models/AdjustmentItem.php`
- **Issue:** Branch-expected table `adjustment_items` has no `branch_id` column in its migration (tenant isolation risk)

- **Evidence:** Model indicates branch usage but migration doesn't define branch_id.

- **Recommended fix:** Add branch_id FK+indexes+scoped uniques OR reclassify as global/user-owned and enforce policies.


### CRITICAL-002 — Security/IDOR

- **File:** `app/Models/AlertRecipient.php`
- **Issue:** Branch-expected table `alert_recipients` has no `branch_id` column in its migration (tenant isolation risk)

- **Evidence:** Model indicates branch usage but migration doesn't define branch_id.

- **Recommended fix:** Add branch_id FK+indexes+scoped uniques OR reclassify as global/user-owned and enforce policies.


### CRITICAL-003 — Security/IDOR

- **File:** `app/Models/BomItem.php`
- **Issue:** Branch-expected table `bom_items` has no `branch_id` column in its migration (tenant isolation risk)

- **Evidence:** Model indicates branch usage but migration doesn't define branch_id.

- **Recommended fix:** Add branch_id FK+indexes+scoped uniques OR reclassify as global/user-owned and enforce policies.


### CRITICAL-004 — Security/IDOR

- **File:** `app/Models/BomOperation.php`
- **Issue:** Branch-expected table `bom_operations` has no `branch_id` column in its migration (tenant isolation risk)

- **Evidence:** Model indicates branch usage but migration doesn't define branch_id.

- **Recommended fix:** Add branch_id FK+indexes+scoped uniques OR reclassify as global/user-owned and enforce policies.


### CRITICAL-005 — Security/IDOR

- **File:** `app/Models/Branch.php`
- **Issue:** Branch-expected table `branches` has no `branch_id` column in its migration (tenant isolation risk)

- **Evidence:** Model indicates branch usage but migration doesn't define branch_id.

- **Recommended fix:** Add branch_id FK+indexes+scoped uniques OR reclassify as global/user-owned and enforce policies.


### CRITICAL-006 — Security/IDOR

- **File:** `app/Models/DashboardWidget.php`
- **Issue:** Branch-expected table `dashboard_widgets` has no `branch_id` column in its migration (tenant isolation risk)

- **Evidence:** Model indicates branch usage but migration doesn't define branch_id.

- **Recommended fix:** Add branch_id FK+indexes+scoped uniques OR reclassify as global/user-owned and enforce policies.


### CRITICAL-007 — Security/IDOR

- **File:** `app/Models/EmployeeShift.php`
- **Issue:** Branch-expected table `employee_shifts` has no `branch_id` column in its migration (tenant isolation risk)

- **Evidence:** Model indicates branch usage but migration doesn't define branch_id.

- **Recommended fix:** Add branch_id FK+indexes+scoped uniques OR reclassify as global/user-owned and enforce policies.


### CRITICAL-008 — Security/IDOR

- **File:** `app/Models/GRNItem.php`
- **Issue:** Branch-expected table `grn_items` has no `branch_id` column in its migration (tenant isolation risk)

- **Evidence:** Model indicates branch usage but migration doesn't define branch_id.

- **Recommended fix:** Add branch_id FK+indexes+scoped uniques OR reclassify as global/user-owned and enforce policies.


### CRITICAL-009 — Security/IDOR

- **File:** `app/Models/LeaveRequest.php`
- **Issue:** Branch-expected table `leave_requests` has no `branch_id` column in its migration (tenant isolation risk)

- **Evidence:** Model indicates branch usage but migration doesn't define branch_id.

- **Recommended fix:** Add branch_id FK+indexes+scoped uniques OR reclassify as global/user-owned and enforce policies.


### CRITICAL-010 — Security/IDOR

- **File:** `app/Models/ManufacturingTransaction.php`
- **Issue:** Branch-expected table `manufacturing_transactions` has no `branch_id` column in its migration (tenant isolation risk)

- **Evidence:** Model indicates branch usage but migration doesn't define branch_id.

- **Recommended fix:** Add branch_id FK+indexes+scoped uniques OR reclassify as global/user-owned and enforce policies.


### CRITICAL-011 — Security/IDOR

- **File:** `app/Models/ProductStoreMapping.php`
- **Issue:** Branch-expected table `product_store_mappings` has no `branch_id` column in its migration (tenant isolation risk)

- **Evidence:** Model indicates branch usage but migration doesn't define branch_id.

- **Recommended fix:** Add branch_id FK+indexes+scoped uniques OR reclassify as global/user-owned and enforce policies.


### CRITICAL-012 — Security/IDOR

- **File:** `app/Models/ProductionOrderItem.php`
- **Issue:** Branch-expected table `production_order_items` has no `branch_id` column in its migration (tenant isolation risk)

- **Evidence:** Model indicates branch usage but migration doesn't define branch_id.

- **Recommended fix:** Add branch_id FK+indexes+scoped uniques OR reclassify as global/user-owned and enforce policies.


### CRITICAL-013 — Security/IDOR

- **File:** `app/Models/ProductionOrderOperation.php`
- **Issue:** Branch-expected table `production_order_operations` has no `branch_id` column in its migration (tenant isolation risk)

- **Evidence:** Model indicates branch usage but migration doesn't define branch_id.

- **Recommended fix:** Add branch_id FK+indexes+scoped uniques OR reclassify as global/user-owned and enforce policies.


### CRITICAL-014 — Security/IDOR

- **File:** `app/Models/PurchaseItem.php`
- **Issue:** Branch-expected table `purchase_items` has no `branch_id` column in its migration (tenant isolation risk)

- **Evidence:** Model indicates branch usage but migration doesn't define branch_id.

- **Recommended fix:** Add branch_id FK+indexes+scoped uniques OR reclassify as global/user-owned and enforce policies.


### CRITICAL-015 — Security/IDOR

- **File:** `app/Models/PurchaseRequisitionItem.php`
- **Issue:** Branch-expected table `purchase_requisition_items` has no `branch_id` column in its migration (tenant isolation risk)

- **Evidence:** Model indicates branch usage but migration doesn't define branch_id.

- **Recommended fix:** Add branch_id FK+indexes+scoped uniques OR reclassify as global/user-owned and enforce policies.


### CRITICAL-016 — Security/IDOR

- **File:** `app/Models/RentalInvoice.php`
- **Issue:** Branch-expected table `rental_invoices` has no `branch_id` column in its migration (tenant isolation risk)

- **Evidence:** Model indicates branch usage but migration doesn't define branch_id.

- **Recommended fix:** Add branch_id FK+indexes+scoped uniques OR reclassify as global/user-owned and enforce policies.


### CRITICAL-017 — Security/IDOR

- **File:** `app/Models/RentalPeriod.php`
- **Issue:** Branch-expected table `rental_periods` has no `branch_id` column in its migration (tenant isolation risk)

- **Evidence:** Model indicates branch usage but migration doesn't define branch_id.

- **Recommended fix:** Add branch_id FK+indexes+scoped uniques OR reclassify as global/user-owned and enforce policies.


### CRITICAL-018 — Security/IDOR

- **File:** `app/Models/SaleItem.php`
- **Issue:** Branch-expected table `sale_items` has no `branch_id` column in its migration (tenant isolation risk)

- **Evidence:** Model indicates branch usage but migration doesn't define branch_id.

- **Recommended fix:** Add branch_id FK+indexes+scoped uniques OR reclassify as global/user-owned and enforce policies.


### CRITICAL-019 — Security/IDOR

- **File:** `app/Models/SearchHistory.php`
- **Issue:** Branch-expected table `search_history` has no `branch_id` column in its migration (tenant isolation risk)

- **Evidence:** Model indicates branch usage but migration doesn't define branch_id.

- **Recommended fix:** Add branch_id FK+indexes+scoped uniques OR reclassify as global/user-owned and enforce policies.


### CRITICAL-020 — Security/IDOR

- **File:** `app/Models/StockMovement.php`
- **Issue:** Branch-expected table `stock_movements` has no `branch_id` column in its migration (tenant isolation risk)

- **Evidence:** Model indicates branch usage but migration doesn't define branch_id.

- **Recommended fix:** Add branch_id FK+indexes+scoped uniques OR reclassify as global/user-owned and enforce policies.


### CRITICAL-021 — Security/IDOR

- **File:** `app/Models/StoreIntegration.php`
- **Issue:** Branch-expected table `store_integrations` has no `branch_id` column in its migration (tenant isolation risk)

- **Evidence:** Model indicates branch usage but migration doesn't define branch_id.

- **Recommended fix:** Add branch_id FK+indexes+scoped uniques OR reclassify as global/user-owned and enforce policies.


### CRITICAL-022 — Security/IDOR

- **File:** `app/Models/StoreSyncLog.php`
- **Issue:** Branch-expected table `store_sync_logs` has no `branch_id` column in its migration (tenant isolation risk)

- **Evidence:** Model indicates branch usage but migration doesn't define branch_id.

- **Recommended fix:** Add branch_id FK+indexes+scoped uniques OR reclassify as global/user-owned and enforce policies.


### CRITICAL-023 — Security/IDOR

- **File:** `app/Models/StoreToken.php`
- **Issue:** Branch-expected table `store_tokens` has no `branch_id` column in its migration (tenant isolation risk)

- **Evidence:** Model indicates branch usage but migration doesn't define branch_id.

- **Recommended fix:** Add branch_id FK+indexes+scoped uniques OR reclassify as global/user-owned and enforce policies.


### CRITICAL-024 — Security/IDOR

- **File:** `app/Models/SupplierQuotationItem.php`
- **Issue:** Branch-expected table `supplier_quotation_items` has no `branch_id` column in its migration (tenant isolation risk)

- **Evidence:** Model indicates branch usage but migration doesn't define branch_id.

- **Recommended fix:** Add branch_id FK+indexes+scoped uniques OR reclassify as global/user-owned and enforce policies.


### CRITICAL-025 — Security/IDOR

- **File:** `app/Models/TicketSLAPolicy.php`
- **Issue:** Branch-expected table `ticket_sla_policies` has no `branch_id` column in its migration (tenant isolation risk)

- **Evidence:** Model indicates branch usage but migration doesn't define branch_id.

- **Recommended fix:** Add branch_id FK+indexes+scoped uniques OR reclassify as global/user-owned and enforce policies.


### CRITICAL-026 — Security/IDOR

- **File:** `app/Models/TransferItem.php`
- **Issue:** Branch-expected table `transfer_items` has no `branch_id` column in its migration (tenant isolation risk)

- **Evidence:** Model indicates branch usage but migration doesn't define branch_id.

- **Recommended fix:** Add branch_id FK+indexes+scoped uniques OR reclassify as global/user-owned and enforce policies.


### CRITICAL-027 — Security/IDOR

- **File:** `app/Models/UserDashboardWidget.php`
- **Issue:** Branch-expected table `user_dashboard_widgets` has no `branch_id` column in its migration (tenant isolation risk)

- **Evidence:** Model indicates branch usage but migration doesn't define branch_id.

- **Recommended fix:** Add branch_id FK+indexes+scoped uniques OR reclassify as global/user-owned and enforce policies.


### CRITICAL-028 — Security/IDOR

- **File:** `app/Models/VehicleContract.php`
- **Issue:** Branch-expected table `vehicle_contracts` has no `branch_id` column in its migration (tenant isolation risk)

- **Evidence:** Model indicates branch usage but migration doesn't define branch_id.

- **Recommended fix:** Add branch_id FK+indexes+scoped uniques OR reclassify as global/user-owned and enforce policies.


### CRITICAL-029 — Security/IDOR

- **File:** `app/Models/VehiclePayment.php`
- **Issue:** Branch-expected table `vehicle_payments` has no `branch_id` column in its migration (tenant isolation risk)

- **Evidence:** Model indicates branch usage but migration doesn't define branch_id.

- **Recommended fix:** Add branch_id FK+indexes+scoped uniques OR reclassify as global/user-owned and enforce policies.


### CRITICAL-030 — Security/IDOR

- **File:** `app/Models/Warranty.php`
- **Issue:** Branch-expected table `warranties` has no `branch_id` column in its migration (tenant isolation risk)

- **Evidence:** Model indicates branch usage but migration doesn't define branch_id.

- **Recommended fix:** Add branch_id FK+indexes+scoped uniques OR reclassify as global/user-owned and enforce policies.


### CRITICAL-031 — Security/IDOR

- **File:** `app/Models/WorkflowRule.php`
- **Issue:** Branch-expected table `workflow_rules` has no `branch_id` column in its migration (tenant isolation risk)

- **Evidence:** Model indicates branch usage but migration doesn't define branch_id.

- **Recommended fix:** Add branch_id FK+indexes+scoped uniques OR reclassify as global/user-owned and enforce policies.


## HIGH

### HIGH-001 — Data Integrity/Transactions

- **File:** `app/Livewire/Admin/Modules/Form.php`
- **Issue:** Multi-write method `save` likely needs DB::transaction (found 5 write ops)

- **Evidence:** Heuristic: multiple writes without transaction markers.

- **Recommended fix:** Wrap in DB::transaction; keep accounting/stock updates atomic.


### HIGH-002 — Data Integrity/Transactions

- **File:** `app/Observers/ModuleObserver.php`
- **Issue:** Multi-write method `deleted` likely needs DB::transaction (found 4 write ops)

- **Evidence:** Heuristic: multiple writes without transaction markers.

- **Recommended fix:** Wrap in DB::transaction; keep accounting/stock updates atomic.


### HIGH-003 — Data Integrity/Transactions

- **File:** `app/Observers/ProductObserver.php`
- **Issue:** Multi-write method `deleteMediaFiles` likely needs DB::transaction (found 4 write ops)

- **Evidence:** Heuristic: multiple writes without transaction markers.

- **Recommended fix:** Wrap in DB::transaction; keep accounting/stock updates atomic.


### HIGH-004 — Data Integrity/Transactions

- **File:** `app/Services/AccountingService.php`
- **Issue:** Multi-write method `postAutoGeneratedEntry` likely needs DB::transaction (found 3 write ops)

- **Evidence:** Heuristic: multiple writes without transaction markers.

- **Recommended fix:** Wrap in DB::transaction; keep accounting/stock updates atomic.


### HIGH-005 — Security/IDOR

- **File:** `app/Livewire/Admin/ActivityLogShow.php`
- **Issue:** Possible IDOR: `mount` uses findOrFail without obvious authorize() or branch filter

- **Evidence:** Heuristic: findOrFail present; no authorize or branch filter in same method.

- **Recommended fix:** Add policy/authorize OR enforce branch-scoped query path.


### HIGH-006 — Security/IDOR

- **File:** `app/Livewire/Admin/Branches/Compare.php`
- **Issue:** Possible IDOR: `compare` uses findOrFail without obvious authorize() or branch filter

- **Evidence:** Heuristic: findOrFail present; no authorize or branch filter in same method.

- **Recommended fix:** Add policy/authorize OR enforce branch-scoped query path.


### HIGH-007 — Security/IDOR

- **File:** `app/Livewire/Admin/Branches/Form.php`
- **Issue:** Possible IDOR: `save` uses findOrFail without obvious authorize() or branch filter

- **Evidence:** Heuristic: findOrFail present; no authorize or branch filter in same method.

- **Recommended fix:** Add policy/authorize OR enforce branch-scoped query path.


### HIGH-008 — Security/IDOR

- **File:** `app/Livewire/Admin/Categories/Form.php`
- **Issue:** Possible IDOR: `loadCategory` uses findOrFail without obvious authorize() or branch filter

- **Evidence:** Heuristic: findOrFail present; no authorize or branch filter in same method.

- **Recommended fix:** Add policy/authorize OR enforce branch-scoped query path.


### HIGH-009 — Security/IDOR

- **File:** `app/Livewire/Admin/Categories/Form.php`
- **Issue:** Possible IDOR: `save` uses findOrFail without obvious authorize() or branch filter

- **Evidence:** Heuristic: findOrFail present; no authorize or branch filter in same method.

- **Recommended fix:** Add policy/authorize OR enforce branch-scoped query path.


### HIGH-010 — Security/IDOR

- **File:** `app/Livewire/Admin/Currency/Form.php`
- **Issue:** Possible IDOR: `loadCurrency` uses findOrFail without obvious authorize() or branch filter

- **Evidence:** Heuristic: findOrFail present; no authorize or branch filter in same method.

- **Recommended fix:** Add policy/authorize OR enforce branch-scoped query path.


### HIGH-011 — Security/IDOR

- **File:** `app/Livewire/Admin/Currency/Form.php`
- **Issue:** Possible IDOR: `save` uses findOrFail without obvious authorize() or branch filter

- **Evidence:** Heuristic: findOrFail present; no authorize or branch filter in same method.

- **Recommended fix:** Add policy/authorize OR enforce branch-scoped query path.


### HIGH-012 — Security/IDOR

- **File:** `app/Livewire/Admin/CurrencyRate/Form.php`
- **Issue:** Possible IDOR: `loadRate` uses findOrFail without obvious authorize() or branch filter

- **Evidence:** Heuristic: findOrFail present; no authorize or branch filter in same method.

- **Recommended fix:** Add policy/authorize OR enforce branch-scoped query path.


### HIGH-013 — Security/IDOR

- **File:** `app/Livewire/Admin/Installments/Index.php`
- **Issue:** Possible IDOR: `openPaymentModal` uses findOrFail without obvious authorize() or branch filter

- **Evidence:** Heuristic: findOrFail present; no authorize or branch filter in same method.

- **Recommended fix:** Add policy/authorize OR enforce branch-scoped query path.


### HIGH-014 — Security/IDOR

- **File:** `app/Livewire/Admin/Installments/Index.php`
- **Issue:** Possible IDOR: `recordPayment` uses findOrFail without obvious authorize() or branch filter

- **Evidence:** Heuristic: findOrFail present; no authorize or branch filter in same method.

- **Recommended fix:** Add policy/authorize OR enforce branch-scoped query path.


### HIGH-015 — Security/IDOR

- **File:** `app/Livewire/Admin/Loyalty/Index.php`
- **Issue:** Possible IDOR: `adjustPoints` uses findOrFail without obvious authorize() or branch filter

- **Evidence:** Heuristic: findOrFail present; no authorize or branch filter in same method.

- **Recommended fix:** Add policy/authorize OR enforce branch-scoped query path.


### HIGH-016 — Security/IDOR

- **File:** `app/Livewire/Admin/MediaLibrary.php`
- **Issue:** Possible IDOR: `viewImage` uses findOrFail without obvious authorize() or branch filter

- **Evidence:** Heuristic: findOrFail present; no authorize or branch filter in same method.

- **Recommended fix:** Add policy/authorize OR enforce branch-scoped query path.


### HIGH-017 — Security/IDOR

- **File:** `app/Livewire/Admin/MediaLibrary.php`
- **Issue:** Possible IDOR: `delete` uses findOrFail without obvious authorize() or branch filter

- **Evidence:** Heuristic: findOrFail present; no authorize or branch filter in same method.

- **Recommended fix:** Add policy/authorize OR enforce branch-scoped query path.


### HIGH-018 — Security/IDOR

- **File:** `app/Livewire/Admin/Modules/Fields/Form.php`
- **Issue:** Possible IDOR: `loadField` uses findOrFail without obvious authorize() or branch filter

- **Evidence:** Heuristic: findOrFail present; no authorize or branch filter in same method.

- **Recommended fix:** Add policy/authorize OR enforce branch-scoped query path.


### HIGH-019 — Security/IDOR

- **File:** `app/Livewire/Admin/Modules/Index.php`
- **Issue:** Possible IDOR: `getModuleHealth` uses findOrFail without obvious authorize() or branch filter

- **Evidence:** Heuristic: findOrFail present; no authorize or branch filter in same method.

- **Recommended fix:** Add policy/authorize OR enforce branch-scoped query path.


### HIGH-020 — Security/IDOR

- **File:** `app/Livewire/Admin/Modules/ModuleManager.php`
- **Issue:** Possible IDOR: `toggleModuleStatus` uses findOrFail without obvious authorize() or branch filter

- **Evidence:** Heuristic: findOrFail present; no authorize or branch filter in same method.

- **Recommended fix:** Add policy/authorize OR enforce branch-scoped query path.


### HIGH-021 — Security/IDOR

- **File:** `app/Livewire/Admin/Modules/ModuleManager.php`
- **Issue:** Possible IDOR: `deleteModule` uses findOrFail without obvious authorize() or branch filter

- **Evidence:** Heuristic: findOrFail present; no authorize or branch filter in same method.

- **Recommended fix:** Add policy/authorize OR enforce branch-scoped query path.


### HIGH-022 — Security/IDOR

- **File:** `app/Livewire/Admin/Modules/ProductFields/Form.php`
- **Issue:** Possible IDOR: `mount` uses findOrFail without obvious authorize() or branch filter

- **Evidence:** Heuristic: findOrFail present; no authorize or branch filter in same method.

- **Recommended fix:** Add policy/authorize OR enforce branch-scoped query path.


### HIGH-023 — Security/IDOR

- **File:** `app/Livewire/Admin/Modules/ProductFields/Form.php`
- **Issue:** Possible IDOR: `loadField` uses findOrFail without obvious authorize() or branch filter

- **Evidence:** Heuristic: findOrFail present; no authorize or branch filter in same method.

- **Recommended fix:** Add policy/authorize OR enforce branch-scoped query path.


### HIGH-024 — Security/IDOR

- **File:** `app/Livewire/Admin/Modules/RentalPeriods/Form.php`
- **Issue:** Possible IDOR: `loadPeriod` uses findOrFail without obvious authorize() or branch filter

- **Evidence:** Heuristic: findOrFail present; no authorize or branch filter in same method.

- **Recommended fix:** Add policy/authorize OR enforce branch-scoped query path.


### HIGH-025 — Security/IDOR

- **File:** `app/Livewire/Admin/Reports/ReportTemplatesManager.php`
- **Issue:** Possible IDOR: `edit` uses findOrFail without obvious authorize() or branch filter

- **Evidence:** Heuristic: findOrFail present; no authorize or branch filter in same method.

- **Recommended fix:** Add policy/authorize OR enforce branch-scoped query path.


### HIGH-026 — Security/IDOR

- **File:** `app/Livewire/Admin/Reports/ScheduledReportsManager.php`
- **Issue:** Possible IDOR: `edit` uses findOrFail without obvious authorize() or branch filter

- **Evidence:** Heuristic: findOrFail present; no authorize or branch filter in same method.

- **Recommended fix:** Add policy/authorize OR enforce branch-scoped query path.


### HIGH-027 — Security/IDOR

- **File:** `app/Livewire/Admin/Roles/Index.php`
- **Issue:** Possible IDOR: `compareRoles` uses findOrFail without obvious authorize() or branch filter

- **Evidence:** Heuristic: findOrFail present; no authorize or branch filter in same method.

- **Recommended fix:** Add policy/authorize OR enforce branch-scoped query path.


### HIGH-028 — Security/IDOR

- **File:** `app/Livewire/Admin/Stock/LowStockAlerts.php`
- **Issue:** Possible IDOR: `acknowledgeAlert` uses findOrFail without obvious authorize() or branch filter

- **Evidence:** Heuristic: findOrFail present; no authorize or branch filter in same method.

- **Recommended fix:** Add policy/authorize OR enforce branch-scoped query path.


### HIGH-029 — Security/IDOR

- **File:** `app/Livewire/Admin/Stock/LowStockAlerts.php`
- **Issue:** Possible IDOR: `resolveAlert` uses findOrFail without obvious authorize() or branch filter

- **Evidence:** Heuristic: findOrFail present; no authorize or branch filter in same method.

- **Recommended fix:** Add policy/authorize OR enforce branch-scoped query path.


### HIGH-030 — Security/IDOR

- **File:** `app/Livewire/Admin/Store/Form.php`
- **Issue:** Possible IDOR: `loadStore` uses findOrFail without obvious authorize() or branch filter

- **Evidence:** Heuristic: findOrFail present; no authorize or branch filter in same method.

- **Recommended fix:** Add policy/authorize OR enforce branch-scoped query path.


### HIGH-031 — Security/IDOR

- **File:** `app/Livewire/Admin/Store/Form.php`
- **Issue:** Possible IDOR: `save` uses findOrFail without obvious authorize() or branch filter

- **Evidence:** Heuristic: findOrFail present; no authorize or branch filter in same method.

- **Recommended fix:** Add policy/authorize OR enforce branch-scoped query path.


### HIGH-032 — Security/IDOR

- **File:** `app/Livewire/Admin/Store/OrdersDashboard.php`
- **Issue:** Possible IDOR: `viewOrder` uses findOrFail without obvious authorize() or branch filter

- **Evidence:** Heuristic: findOrFail present; no authorize or branch filter in same method.

- **Recommended fix:** Add policy/authorize OR enforce branch-scoped query path.


### HIGH-033 — Security/IDOR

- **File:** `app/Livewire/Admin/UnitsOfMeasure/Form.php`
- **Issue:** Possible IDOR: `loadUnit` uses findOrFail without obvious authorize() or branch filter

- **Evidence:** Heuristic: findOrFail present; no authorize or branch filter in same method.

- **Recommended fix:** Add policy/authorize OR enforce branch-scoped query path.


### HIGH-034 — Security/IDOR

- **File:** `app/Livewire/Admin/UnitsOfMeasure/Form.php`
- **Issue:** Possible IDOR: `save` uses findOrFail without obvious authorize() or branch filter

- **Evidence:** Heuristic: findOrFail present; no authorize or branch filter in same method.

- **Recommended fix:** Add policy/authorize OR enforce branch-scoped query path.


### HIGH-035 — Security/IDOR

- **File:** `app/Livewire/Admin/Users/Form.php`
- **Issue:** Possible IDOR: `mount` uses findOrFail without obvious authorize() or branch filter

- **Evidence:** Heuristic: findOrFail present; no authorize or branch filter in same method.

- **Recommended fix:** Add policy/authorize OR enforce branch-scoped query path.


### HIGH-036 — Security/IDOR

- **File:** `app/Livewire/Admin/Users/Form.php`
- **Issue:** Possible IDOR: `save` uses findOrFail without obvious authorize() or branch filter

- **Evidence:** Heuristic: findOrFail present; no authorize or branch filter in same method.

- **Recommended fix:** Add policy/authorize OR enforce branch-scoped query path.


### HIGH-037 — Security/IDOR

- **File:** `app/Livewire/Components/NotesAttachments.php`
- **Issue:** Possible IDOR: `saveNote` uses findOrFail without obvious authorize() or branch filter

- **Evidence:** Heuristic: findOrFail present; no authorize or branch filter in same method.

- **Recommended fix:** Add policy/authorize OR enforce branch-scoped query path.


### HIGH-038 — Security/IDOR

- **File:** `app/Livewire/Components/NotesAttachments.php`
- **Issue:** Possible IDOR: `editNote` uses findOrFail without obvious authorize() or branch filter

- **Evidence:** Heuristic: findOrFail present; no authorize or branch filter in same method.

- **Recommended fix:** Add policy/authorize OR enforce branch-scoped query path.


### HIGH-039 — Security/IDOR

- **File:** `app/Livewire/Components/NotesAttachments.php`
- **Issue:** Possible IDOR: `deleteNote` uses findOrFail without obvious authorize() or branch filter

- **Evidence:** Heuristic: findOrFail present; no authorize or branch filter in same method.

- **Recommended fix:** Add policy/authorize OR enforce branch-scoped query path.


### HIGH-040 — Security/IDOR

- **File:** `app/Livewire/Components/NotesAttachments.php`
- **Issue:** Possible IDOR: `togglePin` uses findOrFail without obvious authorize() or branch filter

- **Evidence:** Heuristic: findOrFail present; no authorize or branch filter in same method.

- **Recommended fix:** Add policy/authorize OR enforce branch-scoped query path.


### HIGH-041 — Security/IDOR

- **File:** `app/Livewire/Components/NotesAttachments.php`
- **Issue:** Possible IDOR: `deleteAttachment` uses findOrFail without obvious authorize() or branch filter

- **Evidence:** Heuristic: findOrFail present; no authorize or branch filter in same method.

- **Recommended fix:** Add policy/authorize OR enforce branch-scoped query path.


### HIGH-042 — Security/IDOR

- **File:** `app/Livewire/Documents/Tags/Form.php`
- **Issue:** Possible IDOR: `loadTag` uses findOrFail without obvious authorize() or branch filter

- **Evidence:** Heuristic: findOrFail present; no authorize or branch filter in same method.

- **Recommended fix:** Add policy/authorize OR enforce branch-scoped query path.


### HIGH-043 — Security/IDOR

- **File:** `app/Livewire/Helpdesk/Categories/Form.php`
- **Issue:** Possible IDOR: `loadCategory` uses findOrFail without obvious authorize() or branch filter

- **Evidence:** Heuristic: findOrFail present; no authorize or branch filter in same method.

- **Recommended fix:** Add policy/authorize OR enforce branch-scoped query path.


### HIGH-044 — Security/IDOR

- **File:** `app/Livewire/Helpdesk/Index.php`
- **Issue:** Possible IDOR: `sortBy` uses findOrFail without obvious authorize() or branch filter

- **Evidence:** Heuristic: findOrFail present; no authorize or branch filter in same method.

- **Recommended fix:** Add policy/authorize OR enforce branch-scoped query path.


### HIGH-045 — Security/IDOR

- **File:** `app/Livewire/Helpdesk/Priorities/Form.php`
- **Issue:** Possible IDOR: `loadPriority` uses findOrFail without obvious authorize() or branch filter

- **Evidence:** Heuristic: findOrFail present; no authorize or branch filter in same method.

- **Recommended fix:** Add policy/authorize OR enforce branch-scoped query path.


### HIGH-046 — Security/IDOR

- **File:** `app/Livewire/Helpdesk/SLAPolicies/Form.php`
- **Issue:** Possible IDOR: `loadPolicy` uses findOrFail without obvious authorize() or branch filter

- **Evidence:** Heuristic: findOrFail present; no authorize or branch filter in same method.

- **Recommended fix:** Add policy/authorize OR enforce branch-scoped query path.


### HIGH-047 — Security/IDOR

- **File:** `app/Livewire/Hrm/Employees/Form.php`
- **Issue:** Possible IDOR: `save` uses findOrFail without obvious authorize() or branch filter

- **Evidence:** Heuristic: findOrFail present; no authorize or branch filter in same method.

- **Recommended fix:** Add policy/authorize OR enforce branch-scoped query path.


### HIGH-048 — Security/IDOR

- **File:** `app/Livewire/Hrm/Shifts/Form.php`
- **Issue:** Possible IDOR: `loadShift` uses findOrFail without obvious authorize() or branch filter

- **Evidence:** Heuristic: findOrFail present; no authorize or branch filter in same method.

- **Recommended fix:** Add policy/authorize OR enforce branch-scoped query path.


### HIGH-049 — Security/IDOR

- **File:** `app/Livewire/Inventory/ProductStoreMappings.php`
- **Issue:** Possible IDOR: `mount` uses findOrFail without obvious authorize() or branch filter

- **Evidence:** Heuristic: findOrFail present; no authorize or branch filter in same method.

- **Recommended fix:** Add policy/authorize OR enforce branch-scoped query path.


### HIGH-050 — Security/IDOR

- **File:** `app/Livewire/Inventory/ProductStoreMappings.php`
- **Issue:** Possible IDOR: `delete` uses findOrFail without obvious authorize() or branch filter

- **Evidence:** Heuristic: findOrFail present; no authorize or branch filter in same method.

- **Recommended fix:** Add policy/authorize OR enforce branch-scoped query path.


### HIGH-051 — Security/IDOR

- **File:** `app/Livewire/Inventory/ProductStoreMappings/Form.php`
- **Issue:** Possible IDOR: `mount` uses findOrFail without obvious authorize() or branch filter

- **Evidence:** Heuristic: findOrFail present; no authorize or branch filter in same method.

- **Recommended fix:** Add policy/authorize OR enforce branch-scoped query path.


### HIGH-052 — Security/IDOR

- **File:** `app/Livewire/Inventory/ProductStoreMappings/Form.php`
- **Issue:** Possible IDOR: `loadMapping` uses findOrFail without obvious authorize() or branch filter

- **Evidence:** Heuristic: findOrFail present; no authorize or branch filter in same method.

- **Recommended fix:** Add policy/authorize OR enforce branch-scoped query path.


### HIGH-053 — Security/IDOR

- **File:** `app/Livewire/Inventory/ProductStoreMappings/Form.php`
- **Issue:** Possible IDOR: `save` uses findOrFail without obvious authorize() or branch filter

- **Evidence:** Heuristic: findOrFail present; no authorize or branch filter in same method.

- **Recommended fix:** Add policy/authorize OR enforce branch-scoped query path.


### HIGH-054 — Security/IDOR

- **File:** `app/Livewire/Purchases/GRN/Form.php`
- **Issue:** Possible IDOR: `loadPOItems` uses findOrFail without obvious authorize() or branch filter

- **Evidence:** Heuristic: findOrFail present; no authorize or branch filter in same method.

- **Recommended fix:** Add policy/authorize OR enforce branch-scoped query path.


### HIGH-055 — Security/IDOR

- **File:** `app/Livewire/Rental/Contracts/Form.php`
- **Issue:** Possible IDOR: `save` uses findOrFail without obvious authorize() or branch filter

- **Evidence:** Heuristic: findOrFail present; no authorize or branch filter in same method.

- **Recommended fix:** Add policy/authorize OR enforce branch-scoped query path.


### HIGH-056 — Security/IDOR

- **File:** `app/Livewire/Rental/Properties/Form.php`
- **Issue:** Possible IDOR: `loadProperty` uses findOrFail without obvious authorize() or branch filter

- **Evidence:** Heuristic: findOrFail present; no authorize or branch filter in same method.

- **Recommended fix:** Add policy/authorize OR enforce branch-scoped query path.


### HIGH-057 — Security/IDOR

- **File:** `app/Livewire/Rental/Tenants/Form.php`
- **Issue:** Possible IDOR: `loadTenant` uses findOrFail without obvious authorize() or branch filter

- **Evidence:** Heuristic: findOrFail present; no authorize or branch filter in same method.

- **Recommended fix:** Add policy/authorize OR enforce branch-scoped query path.


### HIGH-058 — Security/IDOR

- **File:** `app/Livewire/Rental/Units/Form.php`
- **Issue:** Possible IDOR: `save` uses findOrFail without obvious authorize() or branch filter

- **Evidence:** Heuristic: findOrFail present; no authorize or branch filter in same method.

- **Recommended fix:** Add policy/authorize OR enforce branch-scoped query path.


### HIGH-059 — Security/IDOR

- **File:** `app/Livewire/Warehouse/Locations/Form.php`
- **Issue:** Possible IDOR: `loadWarehouse` uses findOrFail without obvious authorize() or branch filter

- **Evidence:** Heuristic: findOrFail present; no authorize or branch filter in same method.

- **Recommended fix:** Add policy/authorize OR enforce branch-scoped query path.


### HIGH-060 — Security/IDOR

- **File:** `app/Livewire/Warehouse/Warehouses/Form.php`
- **Issue:** Possible IDOR: `loadWarehouse` uses findOrFail without obvious authorize() or branch filter

- **Evidence:** Heuristic: findOrFail present; no authorize or branch filter in same method.

- **Recommended fix:** Add policy/authorize OR enforce branch-scoped query path.


### HIGH-061 — Security/IDOR

- **File:** `app/Providers/RouteServiceProvider.php`
- **Issue:** Possible IDOR: `boot` uses findOrFail without obvious authorize() or branch filter

- **Evidence:** Heuristic: findOrFail present; no authorize or branch filter in same method.

- **Recommended fix:** Add policy/authorize OR enforce branch-scoped query path.


### HIGH-062 — Security/IDOR

- **File:** `app/Repositories/Contracts/BaseRepositoryInterface.php`
- **Issue:** Possible IDOR: `findOrFail` uses findOrFail without obvious authorize() or branch filter

- **Evidence:** Heuristic: findOrFail present; no authorize or branch filter in same method.

- **Recommended fix:** Add policy/authorize OR enforce branch-scoped query path.


### HIGH-063 — Security/IDOR

- **File:** `app/Repositories/EloquentBaseRepository.php`
- **Issue:** Possible IDOR: `findOrFail` uses findOrFail without obvious authorize() or branch filter

- **Evidence:** Heuristic: findOrFail present; no authorize or branch filter in same method.

- **Recommended fix:** Add policy/authorize OR enforce branch-scoped query path.


### HIGH-064 — Security/IDOR

- **File:** `app/Services/AttachmentAuthorizationService.php`
- **Issue:** Possible IDOR: `authorizeForModel` uses findOrFail without obvious authorize() or branch filter

- **Evidence:** Heuristic: findOrFail present; no authorize or branch filter in same method.

- **Recommended fix:** Add policy/authorize OR enforce branch-scoped query path.


### HIGH-065 — Security/IDOR

- **File:** `app/Services/AuthService.php`
- **Issue:** Possible IDOR: `enableImpersonation` uses findOrFail without obvious authorize() or branch filter

- **Evidence:** Heuristic: findOrFail present; no authorize or branch filter in same method.

- **Recommended fix:** Add policy/authorize OR enforce branch-scoped query path.


### HIGH-066 — Security/IDOR

- **File:** `app/Services/BankingService.php`
- **Issue:** Possible IDOR: `recordTransaction` uses findOrFail without obvious authorize() or branch filter

- **Evidence:** Heuristic: findOrFail present; no authorize or branch filter in same method.

- **Recommended fix:** Add policy/authorize OR enforce branch-scoped query path.


### HIGH-067 — Security/IDOR

- **File:** `app/Services/BankingService.php`
- **Issue:** Possible IDOR: `startReconciliation` uses findOrFail without obvious authorize() or branch filter

- **Evidence:** Heuristic: findOrFail present; no authorize or branch filter in same method.

- **Recommended fix:** Add policy/authorize OR enforce branch-scoped query path.


### HIGH-068 — Security/IDOR

- **File:** `app/Services/BankingService.php`
- **Issue:** Possible IDOR: `calculateBookBalanceAt` uses findOrFail without obvious authorize() or branch filter

- **Evidence:** Heuristic: findOrFail present; no authorize or branch filter in same method.

- **Recommended fix:** Add policy/authorize OR enforce branch-scoped query path.


### HIGH-069 — Security/IDOR

- **File:** `app/Services/BankingService.php`
- **Issue:** Possible IDOR: `getAccountBalance` uses findOrFail without obvious authorize() or branch filter

- **Evidence:** Heuristic: findOrFail present; no authorize or branch filter in same method.

- **Recommended fix:** Add policy/authorize OR enforce branch-scoped query path.


### HIGH-070 — Security/IDOR

- **File:** `app/Services/BranchAccessService.php`
- **Issue:** Possible IDOR: `getBranchModules` uses findOrFail without obvious authorize() or branch filter

- **Evidence:** Heuristic: findOrFail present; no authorize or branch filter in same method.

- **Recommended fix:** Add policy/authorize OR enforce branch-scoped query path.


### HIGH-071 — Security/IDOR

- **File:** `app/Services/BranchAccessService.php`
- **Issue:** Possible IDOR: `enableModuleForBranch` uses findOrFail without obvious authorize() or branch filter

- **Evidence:** Heuristic: findOrFail present; no authorize or branch filter in same method.

- **Recommended fix:** Add policy/authorize OR enforce branch-scoped query path.


### HIGH-072 — Security/IDOR

- **File:** `app/Services/BranchAccessService.php`
- **Issue:** Possible IDOR: `disableModuleForBranch` uses findOrFail without obvious authorize() or branch filter

- **Evidence:** Heuristic: findOrFail present; no authorize or branch filter in same method.

- **Recommended fix:** Add policy/authorize OR enforce branch-scoped query path.


### HIGH-073 — Security/IDOR

- **File:** `app/Services/BranchAccessService.php`
- **Issue:** Possible IDOR: `updateBranchModuleSettings` uses findOrFail without obvious authorize() or branch filter

- **Evidence:** Heuristic: findOrFail present; no authorize or branch filter in same method.

- **Recommended fix:** Add policy/authorize OR enforce branch-scoped query path.


### HIGH-074 — Security/IDOR

- **File:** `app/Services/BranchAccessService.php`
- **Issue:** Possible IDOR: `assignUserToBranch` uses findOrFail without obvious authorize() or branch filter

- **Evidence:** Heuristic: findOrFail present; no authorize or branch filter in same method.

- **Recommended fix:** Add policy/authorize OR enforce branch-scoped query path.


### HIGH-075 — Security/IDOR

- **File:** `app/Services/BranchAccessService.php`
- **Issue:** Possible IDOR: `getUsersInBranch` uses findOrFail without obvious authorize() or branch filter

- **Evidence:** Heuristic: findOrFail present; no authorize or branch filter in same method.

- **Recommended fix:** Add policy/authorize OR enforce branch-scoped query path.


### HIGH-076 — Security/IDOR

- **File:** `app/Services/CurrencyService.php`
- **Issue:** Possible IDOR: `deactivateRate` uses findOrFail without obvious authorize() or branch filter

- **Evidence:** Heuristic: findOrFail present; no authorize or branch filter in same method.

- **Recommended fix:** Add policy/authorize OR enforce branch-scoped query path.


### HIGH-077 — Security/IDOR

- **File:** `app/Services/Dashboard/DashboardDataService.php`
- **Issue:** Possible IDOR: `getWidgetData` uses findOrFail without obvious authorize() or branch filter

- **Evidence:** Heuristic: findOrFail present; no authorize or branch filter in same method.

- **Recommended fix:** Add policy/authorize OR enforce branch-scoped query path.


### HIGH-078 — Security/IDOR

- **File:** `app/Services/Dashboard/DashboardWidgetService.php`
- **Issue:** Possible IDOR: `addWidget` uses findOrFail without obvious authorize() or branch filter

- **Evidence:** Heuristic: findOrFail present; no authorize or branch filter in same method.

- **Recommended fix:** Add policy/authorize OR enforce branch-scoped query path.


### HIGH-079 — Security/IDOR

- **File:** `app/Services/Dashboard/DashboardWidgetService.php`
- **Issue:** Possible IDOR: `removeWidget` uses findOrFail without obvious authorize() or branch filter

- **Evidence:** Heuristic: findOrFail present; no authorize or branch filter in same method.

- **Recommended fix:** Add policy/authorize OR enforce branch-scoped query path.


### HIGH-080 — Security/IDOR

- **File:** `app/Services/Dashboard/DashboardWidgetService.php`
- **Issue:** Possible IDOR: `updateWidget` uses findOrFail without obvious authorize() or branch filter

- **Evidence:** Heuristic: findOrFail present; no authorize or branch filter in same method.

- **Recommended fix:** Add policy/authorize OR enforce branch-scoped query path.


### HIGH-081 — Security/IDOR

- **File:** `app/Services/Dashboard/DashboardWidgetService.php`
- **Issue:** Possible IDOR: `toggleWidget` uses findOrFail without obvious authorize() or branch filter

- **Evidence:** Heuristic: findOrFail present; no authorize or branch filter in same method.

- **Recommended fix:** Add policy/authorize OR enforce branch-scoped query path.


### HIGH-082 — Security/IDOR

- **File:** `app/Services/Dashboard/DashboardWidgetService.php`
- **Issue:** Possible IDOR: `resetToDefault` uses findOrFail without obvious authorize() or branch filter

- **Evidence:** Heuristic: findOrFail present; no authorize or branch filter in same method.

- **Recommended fix:** Add policy/authorize OR enforce branch-scoped query path.


### HIGH-083 — Security/IDOR

- **File:** `app/Services/DocumentService.php`
- **Issue:** Possible IDOR: `shareDocument` uses findOrFail without obvious authorize() or branch filter

- **Evidence:** Heuristic: findOrFail present; no authorize or branch filter in same method.

- **Recommended fix:** Add policy/authorize OR enforce branch-scoped query path.


### HIGH-084 — Security/IDOR

- **File:** `app/Services/FinancialReportService.php`
- **Issue:** Possible IDOR: `getAccountStatement` uses findOrFail without obvious authorize() or branch filter

- **Evidence:** Heuristic: findOrFail present; no authorize or branch filter in same method.

- **Recommended fix:** Add policy/authorize OR enforce branch-scoped query path.


### HIGH-085 — Security/IDOR

- **File:** `app/Services/FinancialReportService.php`
- **Issue:** Possible IDOR: `getAccountBalance` uses findOrFail without obvious authorize() or branch filter

- **Evidence:** Heuristic: findOrFail present; no authorize or branch filter in same method.

- **Recommended fix:** Add policy/authorize OR enforce branch-scoped query path.


### HIGH-086 — Security/IDOR

- **File:** `app/Services/HRMService.php`
- **Issue:** Possible IDOR: `logAttendance` uses findOrFail without obvious authorize() or branch filter

- **Evidence:** Heuristic: findOrFail present; no authorize or branch filter in same method.

- **Recommended fix:** Add policy/authorize OR enforce branch-scoped query path.


### HIGH-087 — Security/IDOR

- **File:** `app/Services/HRMService.php`
- **Issue:** Possible IDOR: `approveAttendance` uses findOrFail without obvious authorize() or branch filter

- **Evidence:** Heuristic: findOrFail present; no authorize or branch filter in same method.

- **Recommended fix:** Add policy/authorize OR enforce branch-scoped query path.


### HIGH-088 — Security/IDOR

- **File:** `app/Services/HelpdeskService.php`
- **Issue:** Possible IDOR: `assignTicket` uses findOrFail without obvious authorize() or branch filter

- **Evidence:** Heuristic: findOrFail present; no authorize or branch filter in same method.

- **Recommended fix:** Add policy/authorize OR enforce branch-scoped query path.


### HIGH-089 — Security/IDOR

- **File:** `app/Services/LeaveManagementService.php`
- **Issue:** Possible IDOR: `approveEncashment` uses findOrFail without obvious authorize() or branch filter

- **Evidence:** Heuristic: findOrFail present; no authorize or branch filter in same method.

- **Recommended fix:** Add policy/authorize OR enforce branch-scoped query path.


### HIGH-090 — Security/IDOR

- **File:** `app/Services/LeaveManagementService.php`
- **Issue:** Possible IDOR: `approveLeaveRequest` uses findOrFail without obvious authorize() or branch filter

- **Evidence:** Heuristic: findOrFail present; no authorize or branch filter in same method.

- **Recommended fix:** Add policy/authorize OR enforce branch-scoped query path.


### HIGH-091 — Security/IDOR

- **File:** `app/Services/ManufacturingService.php`
- **Issue:** Possible IDOR: `createProductionOrder` uses findOrFail without obvious authorize() or branch filter

- **Evidence:** Heuristic: findOrFail present; no authorize or branch filter in same method.

- **Recommended fix:** Add policy/authorize OR enforce branch-scoped query path.


### HIGH-092 — Security/IDOR

- **File:** `app/Services/ModuleProductService.php`
- **Issue:** Possible IDOR: `updateField` uses findOrFail without obvious authorize() or branch filter

- **Evidence:** Heuristic: findOrFail present; no authorize or branch filter in same method.

- **Recommended fix:** Add policy/authorize OR enforce branch-scoped query path.


### HIGH-093 — Security/IDOR

- **File:** `app/Services/ModuleProductService.php`
- **Issue:** Possible IDOR: `deleteField` uses findOrFail without obvious authorize() or branch filter

- **Evidence:** Heuristic: findOrFail present; no authorize or branch filter in same method.

- **Recommended fix:** Add policy/authorize OR enforce branch-scoped query path.


### HIGH-094 — Security/IDOR

- **File:** `app/Services/ModuleProductService.php`
- **Issue:** Possible IDOR: `createProduct` uses findOrFail without obvious authorize() or branch filter

- **Evidence:** Heuristic: findOrFail present; no authorize or branch filter in same method.

- **Recommended fix:** Add policy/authorize OR enforce branch-scoped query path.


### HIGH-095 — Security/IDOR

- **File:** `app/Services/ModuleProductService.php`
- **Issue:** Possible IDOR: `updateProduct` uses findOrFail without obvious authorize() or branch filter

- **Evidence:** Heuristic: findOrFail present; no authorize or branch filter in same method.

- **Recommended fix:** Add policy/authorize OR enforce branch-scoped query path.


### HIGH-096 — Security/IDOR

- **File:** `app/Services/ModuleProductService.php`
- **Issue:** Possible IDOR: `getModulePricingInfo` uses findOrFail without obvious authorize() or branch filter

- **Evidence:** Heuristic: findOrFail present; no authorize or branch filter in same method.

- **Recommended fix:** Add policy/authorize OR enforce branch-scoped query path.


### HIGH-097 — Security/IDOR

- **File:** `app/Services/MotorcycleService.php`
- **Issue:** Possible IDOR: `deliverContract` uses findOrFail without obvious authorize() or branch filter

- **Evidence:** Heuristic: findOrFail present; no authorize or branch filter in same method.

- **Recommended fix:** Add policy/authorize OR enforce branch-scoped query path.


### HIGH-098 — Security/IDOR

- **File:** `app/Services/PayslipService.php`
- **Issue:** Possible IDOR: `calculatePayroll` uses findOrFail without obvious authorize() or branch filter

- **Evidence:** Heuristic: findOrFail present; no authorize or branch filter in same method.

- **Recommended fix:** Add policy/authorize OR enforce branch-scoped query path.


### HIGH-099 — Security/IDOR

- **File:** `app/Services/PurchaseReturnService.php`
- **Issue:** Possible IDOR: `createReturn` uses findOrFail without obvious authorize() or branch filter

- **Evidence:** Heuristic: findOrFail present; no authorize or branch filter in same method.

- **Recommended fix:** Add policy/authorize OR enforce branch-scoped query path.


### HIGH-100 — Security/IDOR

- **File:** `app/Services/PurchaseReturnService.php`
- **Issue:** Possible IDOR: `approveReturn` uses findOrFail without obvious authorize() or branch filter

- **Evidence:** Heuristic: findOrFail present; no authorize or branch filter in same method.

- **Recommended fix:** Add policy/authorize OR enforce branch-scoped query path.


### HIGH-101 — Security/IDOR

- **File:** `app/Services/PurchaseReturnService.php`
- **Issue:** Possible IDOR: `completeReturn` uses findOrFail without obvious authorize() or branch filter

- **Evidence:** Heuristic: findOrFail present; no authorize or branch filter in same method.

- **Recommended fix:** Add policy/authorize OR enforce branch-scoped query path.


### HIGH-102 — Security/IDOR

- **File:** `app/Services/PurchaseReturnService.php`
- **Issue:** Possible IDOR: `rejectReturn` uses findOrFail without obvious authorize() or branch filter

- **Evidence:** Heuristic: findOrFail present; no authorize or branch filter in same method.

- **Recommended fix:** Add policy/authorize OR enforce branch-scoped query path.


### HIGH-103 — Security/IDOR

- **File:** `app/Services/PurchaseReturnService.php`
- **Issue:** Possible IDOR: `cancelReturn` uses findOrFail without obvious authorize() or branch filter

- **Evidence:** Heuristic: findOrFail present; no authorize or branch filter in same method.

- **Recommended fix:** Add policy/authorize OR enforce branch-scoped query path.


### HIGH-104 — Security/IDOR

- **File:** `app/Services/RentalService.php`
- **Issue:** Possible IDOR: `setUnitStatus` uses findOrFail without obvious authorize() or branch filter

- **Evidence:** Heuristic: findOrFail present; no authorize or branch filter in same method.

- **Recommended fix:** Add policy/authorize OR enforce branch-scoped query path.


### HIGH-105 — Security/IDOR

- **File:** `app/Services/ReportService.php`
- **Issue:** Possible IDOR: `getModuleReport` uses findOrFail without obvious authorize() or branch filter

- **Evidence:** Heuristic: findOrFail present; no authorize or branch filter in same method.

- **Recommended fix:** Add policy/authorize OR enforce branch-scoped query path.


### HIGH-106 — Security/IDOR

- **File:** `app/Services/SalesReturnService.php`
- **Issue:** Possible IDOR: `createReturn` uses findOrFail without obvious authorize() or branch filter

- **Evidence:** Heuristic: findOrFail present; no authorize or branch filter in same method.

- **Recommended fix:** Add policy/authorize OR enforce branch-scoped query path.


### HIGH-107 — Security/IDOR

- **File:** `app/Services/SalesReturnService.php`
- **Issue:** Possible IDOR: `approveReturn` uses findOrFail without obvious authorize() or branch filter

- **Evidence:** Heuristic: findOrFail present; no authorize or branch filter in same method.

- **Recommended fix:** Add policy/authorize OR enforce branch-scoped query path.


### HIGH-108 — Security/IDOR

- **File:** `app/Services/SalesReturnService.php`
- **Issue:** Possible IDOR: `processRefund` uses findOrFail without obvious authorize() or branch filter

- **Evidence:** Heuristic: findOrFail present; no authorize or branch filter in same method.

- **Recommended fix:** Add policy/authorize OR enforce branch-scoped query path.


### HIGH-109 — Security/IDOR

- **File:** `app/Services/SalesReturnService.php`
- **Issue:** Possible IDOR: `rejectReturn` uses findOrFail without obvious authorize() or branch filter

- **Evidence:** Heuristic: findOrFail present; no authorize or branch filter in same method.

- **Recommended fix:** Add policy/authorize OR enforce branch-scoped query path.


### HIGH-110 — Security/IDOR

- **File:** `app/Services/SparePartsService.php`
- **Issue:** Possible IDOR: `updateVehicleModel` uses findOrFail without obvious authorize() or branch filter

- **Evidence:** Heuristic: findOrFail present; no authorize or branch filter in same method.

- **Recommended fix:** Add policy/authorize OR enforce branch-scoped query path.


### HIGH-111 — Security/IDOR

- **File:** `app/Services/SparePartsService.php`
- **Issue:** Possible IDOR: `deleteVehicleModel` uses findOrFail without obvious authorize() or branch filter

- **Evidence:** Heuristic: findOrFail present; no authorize or branch filter in same method.

- **Recommended fix:** Add policy/authorize OR enforce branch-scoped query path.


### HIGH-112 — Security/IDOR

- **File:** `app/Services/StockTransferService.php`
- **Issue:** Possible IDOR: `approveTransfer` uses findOrFail without obvious authorize() or branch filter

- **Evidence:** Heuristic: findOrFail present; no authorize or branch filter in same method.

- **Recommended fix:** Add policy/authorize OR enforce branch-scoped query path.


### HIGH-113 — Security/IDOR

- **File:** `app/Services/StockTransferService.php`
- **Issue:** Possible IDOR: `shipTransfer` uses findOrFail without obvious authorize() or branch filter

- **Evidence:** Heuristic: findOrFail present; no authorize or branch filter in same method.

- **Recommended fix:** Add policy/authorize OR enforce branch-scoped query path.


### HIGH-114 — Security/IDOR

- **File:** `app/Services/StockTransferService.php`
- **Issue:** Possible IDOR: `receiveTransfer` uses findOrFail without obvious authorize() or branch filter

- **Evidence:** Heuristic: findOrFail present; no authorize or branch filter in same method.

- **Recommended fix:** Add policy/authorize OR enforce branch-scoped query path.


### HIGH-115 — Security/IDOR

- **File:** `app/Services/StockTransferService.php`
- **Issue:** Possible IDOR: `rejectTransfer` uses findOrFail without obvious authorize() or branch filter

- **Evidence:** Heuristic: findOrFail present; no authorize or branch filter in same method.

- **Recommended fix:** Add policy/authorize OR enforce branch-scoped query path.


### HIGH-116 — Security/IDOR

- **File:** `app/Services/StockTransferService.php`
- **Issue:** Possible IDOR: `cancelTransfer` uses findOrFail without obvious authorize() or branch filter

- **Evidence:** Heuristic: findOrFail present; no authorize or branch filter in same method.

- **Recommended fix:** Add policy/authorize OR enforce branch-scoped query path.


### HIGH-117 — Security/Scoping

- **File:** `app/Models/AssetMaintenanceLog.php`
- **Issue:** Model `AssetMaintenanceLog` extends `Model` (not BaseModel) and does not use HasBranch (possible missing BranchScope)

- **Evidence:** Inferred table: `asset_maintenance_logs`.

- **Recommended fix:** If branch-owned: move to BaseModel or add HasBranch; ensure schema has branch_id. If global: document and lock down authorization.


### HIGH-118 — Security/Scoping

- **File:** `app/Models/AuditLog.php`
- **Issue:** Model `AuditLog` extends `Model` (not BaseModel) and does not use HasBranch (possible missing BranchScope)

- **Evidence:** Inferred table: `audit_logs`.

- **Recommended fix:** If branch-owned: move to BaseModel or add HasBranch; ensure schema has branch_id. If global: document and lock down authorization.


### HIGH-119 — Security/Scoping

- **File:** `app/Models/CreditNote.php`
- **Issue:** Model `CreditNote` extends `Model` (not BaseModel) and does not use HasBranch (possible missing BranchScope)

- **Evidence:** Inferred table: `credit_notes`.

- **Recommended fix:** If branch-owned: move to BaseModel or add HasBranch; ensure schema has branch_id. If global: document and lock down authorization.


### HIGH-120 — Security/Scoping

- **File:** `app/Models/CreditNoteApplication.php`
- **Issue:** Model `CreditNoteApplication` extends `Model` (not BaseModel) and does not use HasBranch (possible missing BranchScope)

- **Evidence:** Inferred table: `credit_note_applications`.

- **Recommended fix:** If branch-owned: move to BaseModel or add HasBranch; ensure schema has branch_id. If global: document and lock down authorization.


### HIGH-121 — Security/Scoping

- **File:** `app/Models/Currency.php`
- **Issue:** Model `Currency` extends `Model` (not BaseModel) and does not use HasBranch (possible missing BranchScope)

- **Evidence:** Inferred table: `currencies`.

- **Recommended fix:** If branch-owned: move to BaseModel or add HasBranch; ensure schema has branch_id. If global: document and lock down authorization.


### HIGH-122 — Security/Scoping

- **File:** `app/Models/CurrencyRate.php`
- **Issue:** Model `CurrencyRate` extends `Model` (not BaseModel) and does not use HasBranch (possible missing BranchScope)

- **Evidence:** Inferred table: `currency_rates`.

- **Recommended fix:** If branch-owned: move to BaseModel or add HasBranch; ensure schema has branch_id. If global: document and lock down authorization.


### HIGH-123 — Security/Scoping

- **File:** `app/Models/DebitNote.php`
- **Issue:** Model `DebitNote` extends `Model` (not BaseModel) and does not use HasBranch (possible missing BranchScope)

- **Evidence:** Inferred table: `debit_notes`.

- **Recommended fix:** If branch-owned: move to BaseModel or add HasBranch; ensure schema has branch_id. If global: document and lock down authorization.


### HIGH-124 — Security/Scoping

- **File:** `app/Models/DocumentActivity.php`
- **Issue:** Model `DocumentActivity` extends `Model` (not BaseModel) and does not use HasBranch (possible missing BranchScope)

- **Evidence:** Inferred table: `document_activities`.

- **Recommended fix:** If branch-owned: move to BaseModel or add HasBranch; ensure schema has branch_id. If global: document and lock down authorization.


### HIGH-125 — Security/Scoping

- **File:** `app/Models/DocumentShare.php`
- **Issue:** Model `DocumentShare` extends `Model` (not BaseModel) and does not use HasBranch (possible missing BranchScope)

- **Evidence:** Inferred table: `document_shares`.

- **Recommended fix:** If branch-owned: move to BaseModel or add HasBranch; ensure schema has branch_id. If global: document and lock down authorization.


### HIGH-126 — Security/Scoping

- **File:** `app/Models/DocumentTag.php`
- **Issue:** Model `DocumentTag` extends `Model` (not BaseModel) and does not use HasBranch (possible missing BranchScope)

- **Evidence:** Inferred table: `document_tags`.

- **Recommended fix:** If branch-owned: move to BaseModel or add HasBranch; ensure schema has branch_id. If global: document and lock down authorization.


### HIGH-127 — Security/Scoping

- **File:** `app/Models/DocumentVersion.php`
- **Issue:** Model `DocumentVersion` extends `Model` (not BaseModel) and does not use HasBranch (possible missing BranchScope)

- **Evidence:** Inferred table: `document_versions`.

- **Recommended fix:** If branch-owned: move to BaseModel or add HasBranch; ensure schema has branch_id. If global: document and lock down authorization.


### HIGH-128 — Security/Scoping

- **File:** `app/Models/ExportLayout.php`
- **Issue:** Model `ExportLayout` extends `Model` (not BaseModel) and does not use HasBranch (possible missing BranchScope)

- **Evidence:** Inferred table: `export_layouts`.

- **Recommended fix:** If branch-owned: move to BaseModel or add HasBranch; ensure schema has branch_id. If global: document and lock down authorization.


### HIGH-129 — Security/Scoping

- **File:** `app/Models/InstallmentPayment.php`
- **Issue:** Model `InstallmentPayment` extends `Model` (not BaseModel) and does not use HasBranch (possible missing BranchScope)

- **Evidence:** Inferred table: `installment_payments`.

- **Recommended fix:** If branch-owned: move to BaseModel or add HasBranch; ensure schema has branch_id. If global: document and lock down authorization.


### HIGH-130 — Security/Scoping

- **File:** `app/Models/InventoryTransit.php`
- **Issue:** Model `InventoryTransit` extends `Model` (not BaseModel) and does not use HasBranch (possible missing BranchScope)

- **Evidence:** Inferred table: `inventory_transits`.

- **Recommended fix:** If branch-owned: move to BaseModel or add HasBranch; ensure schema has branch_id. If global: document and lock down authorization.


### HIGH-131 — Security/Scoping

- **File:** `app/Models/JournalEntryLine.php`
- **Issue:** Model `JournalEntryLine` extends `Model` (not BaseModel) and does not use HasBranch (possible missing BranchScope)

- **Evidence:** Inferred table: `journal_entry_lines`.

- **Recommended fix:** If branch-owned: move to BaseModel or add HasBranch; ensure schema has branch_id. If global: document and lock down authorization.


### HIGH-132 — Security/Scoping

- **File:** `app/Models/LeaveAccrualRule.php`
- **Issue:** Model `LeaveAccrualRule` extends `Model` (not BaseModel) and does not use HasBranch (possible missing BranchScope)

- **Evidence:** Inferred table: `leave_accrual_rules`.

- **Recommended fix:** If branch-owned: move to BaseModel or add HasBranch; ensure schema has branch_id. If global: document and lock down authorization.


### HIGH-133 — Security/Scoping

- **File:** `app/Models/LeaveAdjustment.php`
- **Issue:** Model `LeaveAdjustment` extends `Model` (not BaseModel) and does not use HasBranch (possible missing BranchScope)

- **Evidence:** Inferred table: `leave_adjustments`.

- **Recommended fix:** If branch-owned: move to BaseModel or add HasBranch; ensure schema has branch_id. If global: document and lock down authorization.


### HIGH-134 — Security/Scoping

- **File:** `app/Models/LeaveBalance.php`
- **Issue:** Model `LeaveBalance` extends `Model` (not BaseModel) and does not use HasBranch (possible missing BranchScope)

- **Evidence:** Inferred table: `leave_balances`.

- **Recommended fix:** If branch-owned: move to BaseModel or add HasBranch; ensure schema has branch_id. If global: document and lock down authorization.


### HIGH-135 — Security/Scoping

- **File:** `app/Models/LeaveEncashment.php`
- **Issue:** Model `LeaveEncashment` extends `Model` (not BaseModel) and does not use HasBranch (possible missing BranchScope)

- **Evidence:** Inferred table: `leave_encashments`.

- **Recommended fix:** If branch-owned: move to BaseModel or add HasBranch; ensure schema has branch_id. If global: document and lock down authorization.


### HIGH-136 — Security/Scoping

- **File:** `app/Models/LeaveHoliday.php`
- **Issue:** Model `LeaveHoliday` extends `Model` (not BaseModel) and does not use HasBranch (possible missing BranchScope)

- **Evidence:** Inferred table: `leave_holidaies`.

- **Recommended fix:** If branch-owned: move to BaseModel or add HasBranch; ensure schema has branch_id. If global: document and lock down authorization.


### HIGH-137 — Security/Scoping

- **File:** `app/Models/LeaveRequestApproval.php`
- **Issue:** Model `LeaveRequestApproval` extends `Model` (not BaseModel) and does not use HasBranch (possible missing BranchScope)

- **Evidence:** Inferred table: `leave_request_approvals`.

- **Recommended fix:** If branch-owned: move to BaseModel or add HasBranch; ensure schema has branch_id. If global: document and lock down authorization.


### HIGH-138 — Security/Scoping

- **File:** `app/Models/LeaveType.php`
- **Issue:** Model `LeaveType` extends `Model` (not BaseModel) and does not use HasBranch (possible missing BranchScope)

- **Evidence:** Inferred table: `leave_types`.

- **Recommended fix:** If branch-owned: move to BaseModel or add HasBranch; ensure schema has branch_id. If global: document and lock down authorization.


### HIGH-139 — Security/Scoping

- **File:** `app/Models/LoginActivity.php`
- **Issue:** Model `LoginActivity` extends `Model` (not BaseModel) and does not use HasBranch (possible missing BranchScope)

- **Evidence:** Inferred table: `login_activities`.

- **Recommended fix:** If branch-owned: move to BaseModel or add HasBranch; ensure schema has branch_id. If global: document and lock down authorization.


### HIGH-140 — Security/Scoping

- **File:** `app/Models/Media.php`
- **Issue:** Model `Media` extends `Model` (not BaseModel) and does not use HasBranch (possible missing BranchScope)

- **Evidence:** Inferred table: `media`.

- **Recommended fix:** If branch-owned: move to BaseModel or add HasBranch; ensure schema has branch_id. If global: document and lock down authorization.


### HIGH-141 — Security/Scoping

- **File:** `app/Models/Module.php`
- **Issue:** Model `Module` extends `Model` (not BaseModel) and does not use HasBranch (possible missing BranchScope)

- **Evidence:** Inferred table: `modules`.

- **Recommended fix:** If branch-owned: move to BaseModel or add HasBranch; ensure schema has branch_id. If global: document and lock down authorization.


### HIGH-142 — Security/Scoping

- **File:** `app/Models/ModuleCustomField.php`
- **Issue:** Model `ModuleCustomField` extends `Model` (not BaseModel) and does not use HasBranch (possible missing BranchScope)

- **Evidence:** Inferred table: `module_custom_fields`.

- **Recommended fix:** If branch-owned: move to BaseModel or add HasBranch; ensure schema has branch_id. If global: document and lock down authorization.


### HIGH-143 — Security/Scoping

- **File:** `app/Models/ModuleField.php`
- **Issue:** Model `ModuleField` extends `Model` (not BaseModel) and does not use HasBranch (possible missing BranchScope)

- **Evidence:** Inferred table: `module_fields`.

- **Recommended fix:** If branch-owned: move to BaseModel or add HasBranch; ensure schema has branch_id. If global: document and lock down authorization.


### HIGH-144 — Security/Scoping

- **File:** `app/Models/ModuleNavigation.php`
- **Issue:** Model `ModuleNavigation` extends `Model` (not BaseModel) and does not use HasBranch (possible missing BranchScope)

- **Evidence:** Inferred table: `module_navigation`.

- **Recommended fix:** If branch-owned: move to BaseModel or add HasBranch; ensure schema has branch_id. If global: document and lock down authorization.


### HIGH-145 — Security/Scoping

- **File:** `app/Models/ModuleOperation.php`
- **Issue:** Model `ModuleOperation` extends `Model` (not BaseModel) and does not use HasBranch (possible missing BranchScope)

- **Evidence:** Inferred table: `module_operations`.

- **Recommended fix:** If branch-owned: move to BaseModel or add HasBranch; ensure schema has branch_id. If global: document and lock down authorization.


### HIGH-146 — Security/Scoping

- **File:** `app/Models/ModulePolicy.php`
- **Issue:** Model `ModulePolicy` extends `Model` (not BaseModel) and does not use HasBranch (possible missing BranchScope)

- **Evidence:** Inferred table: `module_policies`.

- **Recommended fix:** If branch-owned: move to BaseModel or add HasBranch; ensure schema has branch_id. If global: document and lock down authorization.


### HIGH-147 — Security/Scoping

- **File:** `app/Models/ModuleProductField.php`
- **Issue:** Model `ModuleProductField` extends `Model` (not BaseModel) and does not use HasBranch (possible missing BranchScope)

- **Evidence:** Inferred table: `module_product_fields`.

- **Recommended fix:** If branch-owned: move to BaseModel or add HasBranch; ensure schema has branch_id. If global: document and lock down authorization.


### HIGH-148 — Security/Scoping

- **File:** `app/Models/ModuleSetting.php`
- **Issue:** Model `ModuleSetting` extends `Model` (not BaseModel) and does not use HasBranch (possible missing BranchScope)

- **Evidence:** Inferred table: `module_settings`.

- **Recommended fix:** If branch-owned: move to BaseModel or add HasBranch; ensure schema has branch_id. If global: document and lock down authorization.


### HIGH-149 — Security/Scoping

- **File:** `app/Models/Notification.php`
- **Issue:** Model `Notification` extends `Model` (not BaseModel) and does not use HasBranch (possible missing BranchScope)

- **Evidence:** Inferred table: `notifications`.

- **Recommended fix:** If branch-owned: move to BaseModel or add HasBranch; ensure schema has branch_id. If global: document and lock down authorization.


### HIGH-150 — Security/Scoping

- **File:** `app/Models/ProductCompatibility.php`
- **Issue:** Model `ProductCompatibility` extends `Model` (not BaseModel) and does not use HasBranch (possible missing BranchScope)

- **Evidence:** Inferred table: `product_compatibilities`.

- **Recommended fix:** If branch-owned: move to BaseModel or add HasBranch; ensure schema has branch_id. If global: document and lock down authorization.


### HIGH-151 — Security/Scoping

- **File:** `app/Models/ProductFieldValue.php`
- **Issue:** Model `ProductFieldValue` extends `Model` (not BaseModel) and does not use HasBranch (possible missing BranchScope)

- **Evidence:** Inferred table: `product_field_values`.

- **Recommended fix:** If branch-owned: move to BaseModel or add HasBranch; ensure schema has branch_id. If global: document and lock down authorization.


### HIGH-152 — Security/Scoping

- **File:** `app/Models/ProductVariation.php`
- **Issue:** Model `ProductVariation` extends `Model` (not BaseModel) and does not use HasBranch (possible missing BranchScope)

- **Evidence:** Inferred table: `product_variations`.

- **Recommended fix:** If branch-owned: move to BaseModel or add HasBranch; ensure schema has branch_id. If global: document and lock down authorization.


### HIGH-153 — Security/Scoping

- **File:** `app/Models/Project.php`
- **Issue:** Model `Project` extends `Model` (not BaseModel) and does not use HasBranch (possible missing BranchScope)

- **Evidence:** Inferred table: `projects`.

- **Recommended fix:** If branch-owned: move to BaseModel or add HasBranch; ensure schema has branch_id. If global: document and lock down authorization.


### HIGH-154 — Security/Scoping

- **File:** `app/Models/ProjectExpense.php`
- **Issue:** Model `ProjectExpense` extends `Model` (not BaseModel) and does not use HasBranch (possible missing BranchScope)

- **Evidence:** Inferred table: `project_expenses`.

- **Recommended fix:** If branch-owned: move to BaseModel or add HasBranch; ensure schema has branch_id. If global: document and lock down authorization.


### HIGH-155 — Security/Scoping

- **File:** `app/Models/ProjectMilestone.php`
- **Issue:** Model `ProjectMilestone` extends `Model` (not BaseModel) and does not use HasBranch (possible missing BranchScope)

- **Evidence:** Inferred table: `project_milestones`.

- **Recommended fix:** If branch-owned: move to BaseModel or add HasBranch; ensure schema has branch_id. If global: document and lock down authorization.


### HIGH-156 — Security/Scoping

- **File:** `app/Models/ProjectTask.php`
- **Issue:** Model `ProjectTask` extends `Model` (not BaseModel) and does not use HasBranch (possible missing BranchScope)

- **Evidence:** Inferred table: `project_tasks`.

- **Recommended fix:** If branch-owned: move to BaseModel or add HasBranch; ensure schema has branch_id. If global: document and lock down authorization.


### HIGH-157 — Security/Scoping

- **File:** `app/Models/ProjectTimeLog.php`
- **Issue:** Model `ProjectTimeLog` extends `Model` (not BaseModel) and does not use HasBranch (possible missing BranchScope)

- **Evidence:** Inferred table: `project_time_logs`.

- **Recommended fix:** If branch-owned: move to BaseModel or add HasBranch; ensure schema has branch_id. If global: document and lock down authorization.


### HIGH-158 — Security/Scoping

- **File:** `app/Models/PurchasePayment.php`
- **Issue:** Model `PurchasePayment` extends `Model` (not BaseModel) and does not use HasBranch (possible missing BranchScope)

- **Evidence:** Inferred table: `purchase_payments`.

- **Recommended fix:** If branch-owned: move to BaseModel or add HasBranch; ensure schema has branch_id. If global: document and lock down authorization.


### HIGH-159 — Security/Scoping

- **File:** `app/Models/PurchaseReturn.php`
- **Issue:** Model `PurchaseReturn` extends `Model` (not BaseModel) and does not use HasBranch (possible missing BranchScope)

- **Evidence:** Inferred table: `purchase_returns`.

- **Recommended fix:** If branch-owned: move to BaseModel or add HasBranch; ensure schema has branch_id. If global: document and lock down authorization.


### HIGH-160 — Security/Scoping

- **File:** `app/Models/PurchaseReturnItem.php`
- **Issue:** Model `PurchaseReturnItem` extends `Model` (not BaseModel) and does not use HasBranch (possible missing BranchScope)

- **Evidence:** Inferred table: `purchase_return_items`.

- **Recommended fix:** If branch-owned: move to BaseModel or add HasBranch; ensure schema has branch_id. If global: document and lock down authorization.


### HIGH-161 — Security/Scoping

- **File:** `app/Models/ReportDefinition.php`
- **Issue:** Model `ReportDefinition` extends `Model` (not BaseModel) and does not use HasBranch (possible missing BranchScope)

- **Evidence:** Inferred table: `report_definitions`.

- **Recommended fix:** If branch-owned: move to BaseModel or add HasBranch; ensure schema has branch_id. If global: document and lock down authorization.


### HIGH-162 — Security/Scoping

- **File:** `app/Models/ReportTemplate.php`
- **Issue:** Model `ReportTemplate` extends `Model` (not BaseModel) and does not use HasBranch (possible missing BranchScope)

- **Evidence:** Inferred table: `report_templates`.

- **Recommended fix:** If branch-owned: move to BaseModel or add HasBranch; ensure schema has branch_id. If global: document and lock down authorization.


### HIGH-163 — Security/Scoping

- **File:** `app/Models/ReturnRefund.php`
- **Issue:** Model `ReturnRefund` extends `Model` (not BaseModel) and does not use HasBranch (possible missing BranchScope)

- **Evidence:** Inferred table: `return_refunds`.

- **Recommended fix:** If branch-owned: move to BaseModel or add HasBranch; ensure schema has branch_id. If global: document and lock down authorization.


### HIGH-164 — Security/Scoping

- **File:** `app/Models/SalePayment.php`
- **Issue:** Model `SalePayment` extends `Model` (not BaseModel) and does not use HasBranch (possible missing BranchScope)

- **Evidence:** Inferred table: `sale_payments`.

- **Recommended fix:** If branch-owned: move to BaseModel or add HasBranch; ensure schema has branch_id. If global: document and lock down authorization.


### HIGH-165 — Security/Scoping

- **File:** `app/Models/SalesReturn.php`
- **Issue:** Model `SalesReturn` extends `Model` (not BaseModel) and does not use HasBranch (possible missing BranchScope)

- **Evidence:** Inferred table: `sales_returns`.

- **Recommended fix:** If branch-owned: move to BaseModel or add HasBranch; ensure schema has branch_id. If global: document and lock down authorization.


### HIGH-166 — Security/Scoping

- **File:** `app/Models/SavedReportView.php`
- **Issue:** Model `SavedReportView` extends `Model` (not BaseModel) and does not use HasBranch (possible missing BranchScope)

- **Evidence:** Inferred table: `saved_report_views`.

- **Recommended fix:** If branch-owned: move to BaseModel or add HasBranch; ensure schema has branch_id. If global: document and lock down authorization.


### HIGH-167 — Security/Scoping

- **File:** `app/Models/ScheduledReport.php`
- **Issue:** Model `ScheduledReport` extends `Model` (not BaseModel) and does not use HasBranch (possible missing BranchScope)

- **Evidence:** Inferred table: `scheduled_reports`.

- **Recommended fix:** If branch-owned: move to BaseModel or add HasBranch; ensure schema has branch_id. If global: document and lock down authorization.


### HIGH-168 — Security/Scoping

- **File:** `app/Models/StockTransfer.php`
- **Issue:** Model `StockTransfer` extends `Model` (not BaseModel) and does not use HasBranch (possible missing BranchScope)

- **Evidence:** Inferred table: `stock_transfers`.

- **Recommended fix:** If branch-owned: move to BaseModel or add HasBranch; ensure schema has branch_id. If global: document and lock down authorization.


### HIGH-169 — Security/Scoping

- **File:** `app/Models/StockTransferApproval.php`
- **Issue:** Model `StockTransferApproval` extends `Model` (not BaseModel) and does not use HasBranch (possible missing BranchScope)

- **Evidence:** Inferred table: `stock_transfer_approvals`.

- **Recommended fix:** If branch-owned: move to BaseModel or add HasBranch; ensure schema has branch_id. If global: document and lock down authorization.


### HIGH-170 — Security/Scoping

- **File:** `app/Models/StockTransferDocument.php`
- **Issue:** Model `StockTransferDocument` extends `Model` (not BaseModel) and does not use HasBranch (possible missing BranchScope)

- **Evidence:** Inferred table: `stock_transfer_documents`.

- **Recommended fix:** If branch-owned: move to BaseModel or add HasBranch; ensure schema has branch_id. If global: document and lock down authorization.


### HIGH-171 — Security/Scoping

- **File:** `app/Models/StockTransferHistory.php`
- **Issue:** Model `StockTransferHistory` extends `Model` (not BaseModel) and does not use HasBranch (possible missing BranchScope)

- **Evidence:** Inferred table: `stock_transfer_history`.

- **Recommended fix:** If branch-owned: move to BaseModel or add HasBranch; ensure schema has branch_id. If global: document and lock down authorization.


### HIGH-172 — Security/Scoping

- **File:** `app/Models/StockTransferItem.php`
- **Issue:** Model `StockTransferItem` extends `Model` (not BaseModel) and does not use HasBranch (possible missing BranchScope)

- **Evidence:** Inferred table: `stock_transfer_items`.

- **Recommended fix:** If branch-owned: move to BaseModel or add HasBranch; ensure schema has branch_id. If global: document and lock down authorization.


### HIGH-173 — Security/Scoping

- **File:** `app/Models/SupplierPerformanceMetric.php`
- **Issue:** Model `SupplierPerformanceMetric` extends `Model` (not BaseModel) and does not use HasBranch (possible missing BranchScope)

- **Evidence:** Inferred table: `supplier_performance_metrics`.

- **Recommended fix:** If branch-owned: move to BaseModel or add HasBranch; ensure schema has branch_id. If global: document and lock down authorization.


### HIGH-174 — Security/Scoping

- **File:** `app/Models/SystemSetting.php`
- **Issue:** Model `SystemSetting` extends `Model` (not BaseModel) and does not use HasBranch (possible missing BranchScope)

- **Evidence:** Inferred table: `system_settings`.

- **Recommended fix:** If branch-owned: move to BaseModel or add HasBranch; ensure schema has branch_id. If global: document and lock down authorization.


### HIGH-175 — Security/Scoping

- **File:** `app/Models/Ticket.php`
- **Issue:** Model `Ticket` extends `Model` (not BaseModel) and does not use HasBranch (possible missing BranchScope)

- **Evidence:** Inferred table: `tickets`.

- **Recommended fix:** If branch-owned: move to BaseModel or add HasBranch; ensure schema has branch_id. If global: document and lock down authorization.


### HIGH-176 — Security/Scoping

- **File:** `app/Models/TicketCategory.php`
- **Issue:** Model `TicketCategory` extends `Model` (not BaseModel) and does not use HasBranch (possible missing BranchScope)

- **Evidence:** Inferred table: `ticket_categories`.

- **Recommended fix:** If branch-owned: move to BaseModel or add HasBranch; ensure schema has branch_id. If global: document and lock down authorization.


### HIGH-177 — Security/Scoping

- **File:** `app/Models/TicketPriority.php`
- **Issue:** Model `TicketPriority` extends `Model` (not BaseModel) and does not use HasBranch (possible missing BranchScope)

- **Evidence:** Inferred table: `ticket_priorities`.

- **Recommended fix:** If branch-owned: move to BaseModel or add HasBranch; ensure schema has branch_id. If global: document and lock down authorization.


### HIGH-178 — Security/Scoping

- **File:** `app/Models/TicketReply.php`
- **Issue:** Model `TicketReply` extends `Model` (not BaseModel) and does not use HasBranch (possible missing BranchScope)

- **Evidence:** Inferred table: `ticket_replies`.

- **Recommended fix:** If branch-owned: move to BaseModel or add HasBranch; ensure schema has branch_id. If global: document and lock down authorization.


### HIGH-179 — Security/Scoping

- **File:** `app/Models/UnitOfMeasure.php`
- **Issue:** Model `UnitOfMeasure` extends `Model` (not BaseModel) and does not use HasBranch (possible missing BranchScope)

- **Evidence:** Inferred table: `units_of_measure`.

- **Recommended fix:** If branch-owned: move to BaseModel or add HasBranch; ensure schema has branch_id. If global: document and lock down authorization.


### HIGH-180 — Security/Scoping

- **File:** `app/Models/UserFavorite.php`
- **Issue:** Model `UserFavorite` extends `Model` (not BaseModel) and does not use HasBranch (possible missing BranchScope)

- **Evidence:** Inferred table: `user_favorites`.

- **Recommended fix:** If branch-owned: move to BaseModel or add HasBranch; ensure schema has branch_id. If global: document and lock down authorization.


### HIGH-181 — Security/Scoping

- **File:** `app/Models/UserPreference.php`
- **Issue:** Model `UserPreference` extends `Model` (not BaseModel) and does not use HasBranch (possible missing BranchScope)

- **Evidence:** Inferred table: `user_preferences`.

- **Recommended fix:** If branch-owned: move to BaseModel or add HasBranch; ensure schema has branch_id. If global: document and lock down authorization.


### HIGH-182 — Security/Scoping

- **File:** `app/Models/UserSession.php`
- **Issue:** Model `UserSession` extends `Model` (not BaseModel) and does not use HasBranch (possible missing BranchScope)

- **Evidence:** Inferred table: `user_sessions`.

- **Recommended fix:** If branch-owned: move to BaseModel or add HasBranch; ensure schema has branch_id. If global: document and lock down authorization.


### HIGH-183 — Security/Scoping

- **File:** `app/Models/VehicleModel.php`
- **Issue:** Model `VehicleModel` extends `Model` (not BaseModel) and does not use HasBranch (possible missing BranchScope)

- **Evidence:** Inferred table: `vehicle_models`.

- **Recommended fix:** If branch-owned: move to BaseModel or add HasBranch; ensure schema has branch_id. If global: document and lock down authorization.


### HIGH-184 — Security/Scoping

- **File:** `app/Models/WorkflowApproval.php`
- **Issue:** Model `WorkflowApproval` extends `Model` (not BaseModel) and does not use HasBranch (possible missing BranchScope)

- **Evidence:** Inferred table: `workflow_approvals`.

- **Recommended fix:** If branch-owned: move to BaseModel or add HasBranch; ensure schema has branch_id. If global: document and lock down authorization.


### HIGH-185 — Security/Scoping

- **File:** `app/Models/WorkflowAuditLog.php`
- **Issue:** Model `WorkflowAuditLog` extends `Model` (not BaseModel) and does not use HasBranch (possible missing BranchScope)

- **Evidence:** Inferred table: `workflow_audit_logs`.

- **Recommended fix:** If branch-owned: move to BaseModel or add HasBranch; ensure schema has branch_id. If global: document and lock down authorization.


### HIGH-186 — Security/Scoping

- **File:** `app/Models/WorkflowNotification.php`
- **Issue:** Model `WorkflowNotification` extends `Model` (not BaseModel) and does not use HasBranch (possible missing BranchScope)

- **Evidence:** Inferred table: `workflow_notifications`.

- **Recommended fix:** If branch-owned: move to BaseModel or add HasBranch; ensure schema has branch_id. If global: document and lock down authorization.


## MEDIUM

### MEDIUM-001 — Code Quality/Security

- **File:** `app/Models/AuditLog.php`
- **Issue:** Model `AuditLog` imports HasBranch but doesn't `use HasBranch;` (inconsistent scoping)

- **Evidence:** Table: `audit_logs`.

- **Recommended fix:** Align by adding `use HasBranch;` or removing import/branch_id mentions.


### MEDIUM-002 — Code Quality/Security

- **File:** `app/Models/CreditNote.php`
- **Issue:** Model `CreditNote` imports HasBranch but doesn't `use HasBranch;` (inconsistent scoping)

- **Evidence:** Table: `credit_notes`.

- **Recommended fix:** Align by adding `use HasBranch;` or removing import/branch_id mentions.


### MEDIUM-003 — Code Quality/Security

- **File:** `app/Models/DebitNote.php`
- **Issue:** Model `DebitNote` imports HasBranch but doesn't `use HasBranch;` (inconsistent scoping)

- **Evidence:** Table: `debit_notes`.

- **Recommended fix:** Align by adding `use HasBranch;` or removing import/branch_id mentions.


### MEDIUM-004 — Code Quality/Security

- **File:** `app/Models/LeaveHoliday.php`
- **Issue:** Model `LeaveHoliday` imports HasBranch but doesn't `use HasBranch;` (inconsistent scoping)

- **Evidence:** Table: `leave_holidaies`.

- **Recommended fix:** Align by adding `use HasBranch;` or removing import/branch_id mentions.


### MEDIUM-005 — Code Quality/Security

- **File:** `app/Models/Media.php`
- **Issue:** Model `Media` imports HasBranch but doesn't `use HasBranch;` (inconsistent scoping)

- **Evidence:** Table: `media`.

- **Recommended fix:** Align by adding `use HasBranch;` or removing import/branch_id mentions.


### MEDIUM-006 — Code Quality/Security

- **File:** `app/Models/ModuleField.php`
- **Issue:** Model `ModuleField` imports HasBranch but doesn't `use HasBranch;` (inconsistent scoping)

- **Evidence:** Table: `module_fields`.

- **Recommended fix:** Align by adding `use HasBranch;` or removing import/branch_id mentions.


### MEDIUM-007 — Code Quality/Security

- **File:** `app/Models/ModulePolicy.php`
- **Issue:** Model `ModulePolicy` imports HasBranch but doesn't `use HasBranch;` (inconsistent scoping)

- **Evidence:** Table: `module_policies`.

- **Recommended fix:** Align by adding `use HasBranch;` or removing import/branch_id mentions.


### MEDIUM-008 — Code Quality/Security

- **File:** `app/Models/ModuleSetting.php`
- **Issue:** Model `ModuleSetting` imports HasBranch but doesn't `use HasBranch;` (inconsistent scoping)

- **Evidence:** Table: `module_settings`.

- **Recommended fix:** Align by adding `use HasBranch;` or removing import/branch_id mentions.


### MEDIUM-009 — Code Quality/Security

- **File:** `app/Models/Project.php`
- **Issue:** Model `Project` imports HasBranch but doesn't `use HasBranch;` (inconsistent scoping)

- **Evidence:** Table: `projects`.

- **Recommended fix:** Align by adding `use HasBranch;` or removing import/branch_id mentions.


### MEDIUM-010 — Code Quality/Security

- **File:** `app/Models/PurchaseReturn.php`
- **Issue:** Model `PurchaseReturn` imports HasBranch but doesn't `use HasBranch;` (inconsistent scoping)

- **Evidence:** Table: `purchase_returns`.

- **Recommended fix:** Align by adding `use HasBranch;` or removing import/branch_id mentions.


### MEDIUM-011 — Code Quality/Security

- **File:** `app/Models/PurchaseReturnItem.php`
- **Issue:** Model `PurchaseReturnItem` imports HasBranch but doesn't `use HasBranch;` (inconsistent scoping)

- **Evidence:** Table: `purchase_return_items`.

- **Recommended fix:** Align by adding `use HasBranch;` or removing import/branch_id mentions.


### MEDIUM-012 — Code Quality/Security

- **File:** `app/Models/ReturnRefund.php`
- **Issue:** Model `ReturnRefund` imports HasBranch but doesn't `use HasBranch;` (inconsistent scoping)

- **Evidence:** Table: `return_refunds`.

- **Recommended fix:** Align by adding `use HasBranch;` or removing import/branch_id mentions.


### MEDIUM-013 — Code Quality/Security

- **File:** `app/Models/SalesReturn.php`
- **Issue:** Model `SalesReturn` imports HasBranch but doesn't `use HasBranch;` (inconsistent scoping)

- **Evidence:** Table: `sales_returns`.

- **Recommended fix:** Align by adding `use HasBranch;` or removing import/branch_id mentions.


### MEDIUM-014 — Code Quality/Security

- **File:** `app/Models/StockTransfer.php`
- **Issue:** Model `StockTransfer` imports HasBranch but doesn't `use HasBranch;` (inconsistent scoping)

- **Evidence:** Table: `stock_transfers`.

- **Recommended fix:** Align by adding `use HasBranch;` or removing import/branch_id mentions.


### MEDIUM-015 — Code Quality/Security

- **File:** `app/Models/SupplierPerformanceMetric.php`
- **Issue:** Model `SupplierPerformanceMetric` imports HasBranch but doesn't `use HasBranch;` (inconsistent scoping)

- **Evidence:** Table: `supplier_performance_metrics`.

- **Recommended fix:** Align by adding `use HasBranch;` or removing import/branch_id mentions.


### MEDIUM-016 — Code Quality/Security

- **File:** `app/Models/Ticket.php`
- **Issue:** Model `Ticket` imports HasBranch but doesn't `use HasBranch;` (inconsistent scoping)

- **Evidence:** Table: `tickets`.

- **Recommended fix:** Align by adding `use HasBranch;` or removing import/branch_id mentions.


### MEDIUM-017 — Security/Mass Assignment

- **File:** `app/Http/Controllers/Admin/ModuleFieldController.php`
- **Issue:** Potential unsafe mass assignment using $request->all()

- **Evidence:** Found create/update with $request->all().

- **Recommended fix:** Use validated data only; review $fillable.


### MEDIUM-018 — Security/XSS

- **File:** `resources/views/components/form/input.blade.php`
- **Issue:** Blade contains unescaped output `{!! ... !!}` (XSS risk if user-controlled)

- **Evidence:** Found `{!!` in blade.

- **Recommended fix:** Prefer escaped output `{{ }}` or sanitize.


### MEDIUM-019 — Security/XSS

- **File:** `resources/views/components/icon.blade.php`
- **Issue:** Blade contains unescaped output `{!! ... !!}` (XSS risk if user-controlled)

- **Evidence:** Found `{!!` in blade.

- **Recommended fix:** Prefer escaped output `{{ }}` or sanitize.


### MEDIUM-020 — Security/XSS

- **File:** `resources/views/components/ui/button.blade.php`
- **Issue:** Blade contains unescaped output `{!! ... !!}` (XSS risk if user-controlled)

- **Evidence:** Found `{!!` in blade.

- **Recommended fix:** Prefer escaped output `{{ }}` or sanitize.


### MEDIUM-021 — Security/XSS

- **File:** `resources/views/components/ui/card.blade.php`
- **Issue:** Blade contains unescaped output `{!! ... !!}` (XSS risk if user-controlled)

- **Evidence:** Found `{!!` in blade.

- **Recommended fix:** Prefer escaped output `{{ }}` or sanitize.


### MEDIUM-022 — Security/XSS

- **File:** `resources/views/components/ui/empty-state.blade.php`
- **Issue:** Blade contains unescaped output `{!! ... !!}` (XSS risk if user-controlled)

- **Evidence:** Found `{!!` in blade.

- **Recommended fix:** Prefer escaped output `{{ }}` or sanitize.


### MEDIUM-023 — Security/XSS

- **File:** `resources/views/components/ui/form/input.blade.php`
- **Issue:** Blade contains unescaped output `{!! ... !!}` (XSS risk if user-controlled)

- **Evidence:** Found `{!!` in blade.

- **Recommended fix:** Prefer escaped output `{{ }}` or sanitize.


### MEDIUM-024 — Security/XSS

- **File:** `resources/views/components/ui/page-header.blade.php`
- **Issue:** Blade contains unescaped output `{!! ... !!}` (XSS risk if user-controlled)

- **Evidence:** Found `{!!` in blade.

- **Recommended fix:** Prefer escaped output `{{ }}` or sanitize.


### MEDIUM-025 — Security/XSS

- **File:** `resources/views/livewire/auth/two-factor-setup.blade.php`
- **Issue:** Blade contains unescaped output `{!! ... !!}` (XSS risk if user-controlled)

- **Evidence:** Found `{!!` in blade.

- **Recommended fix:** Prefer escaped output `{{ }}` or sanitize.


### MEDIUM-026 — Security/XSS

- **File:** `resources/views/livewire/shared/dynamic-form.blade.php`
- **Issue:** Blade contains unescaped output `{!! ... !!}` (XSS risk if user-controlled)

- **Evidence:** Found `{!!` in blade.

- **Recommended fix:** Prefer escaped output `{{ }}` or sanitize.


### MEDIUM-027 — Security/XSS

- **File:** `resources/views/livewire/shared/dynamic-table.blade.php`
- **Issue:** Blade contains unescaped output `{!! ... !!}` (XSS risk if user-controlled)

- **Evidence:** Found `{!!` in blade.

- **Recommended fix:** Prefer escaped output `{{ }}` or sanitize.


### MEDIUM-028 — Validation

- **File:** `app/Livewire/Admin/Analytics/AdvancedDashboard.php`
- **Issue:** Livewire component has mutating action without obvious validation

- **Evidence:** Heuristic: mutating methods but no validate()/validateOnly() in file.

- **Recommended fix:** Add validation rules and validate before writes.


### MEDIUM-029 — Validation

- **File:** `app/Livewire/Admin/Branch/Reports.php`
- **Issue:** Livewire component has mutating action without obvious validation

- **Evidence:** Heuristic: mutating methods but no validate()/validateOnly() in file.

- **Recommended fix:** Add validation rules and validate before writes.


### MEDIUM-030 — Validation

- **File:** `app/Livewire/Admin/Branches/Modules.php`
- **Issue:** Livewire component has mutating action without obvious validation

- **Evidence:** Heuristic: mutating methods but no validate()/validateOnly() in file.

- **Recommended fix:** Add validation rules and validate before writes.


### MEDIUM-031 — Validation

- **File:** `app/Livewire/Admin/Categories/Index.php`
- **Issue:** Livewire component has mutating action without obvious validation

- **Evidence:** Heuristic: mutating methods but no validate()/validateOnly() in file.

- **Recommended fix:** Add validation rules and validate before writes.


### MEDIUM-032 — Validation

- **File:** `app/Livewire/Admin/Modules/Fields.php`
- **Issue:** Livewire component has mutating action without obvious validation

- **Evidence:** Heuristic: mutating methods but no validate()/validateOnly() in file.

- **Recommended fix:** Add validation rules and validate before writes.


### MEDIUM-033 — Validation

- **File:** `app/Livewire/Admin/Modules/ProductFields.php`
- **Issue:** Livewire component has mutating action without obvious validation

- **Evidence:** Heuristic: mutating methods but no validate()/validateOnly() in file.

- **Recommended fix:** Add validation rules and validate before writes.


### MEDIUM-034 — Validation

- **File:** `app/Livewire/Admin/Reports/Index.php`
- **Issue:** Livewire component has mutating action without obvious validation

- **Evidence:** Heuristic: mutating methods but no validate()/validateOnly() in file.

- **Recommended fix:** Add validation rules and validate before writes.


### MEDIUM-035 — Validation

- **File:** `app/Livewire/Admin/Settings/AdvancedSettings.php`
- **Issue:** Livewire component has mutating action without obvious validation

- **Evidence:** Heuristic: mutating methods but no validate()/validateOnly() in file.

- **Recommended fix:** Add validation rules and validate before writes.


### MEDIUM-036 — Validation

- **File:** `app/Livewire/Admin/Settings/SystemSettings.php`
- **Issue:** Livewire component has mutating action without obvious validation

- **Evidence:** Heuristic: mutating methods but no validate()/validateOnly() in file.

- **Recommended fix:** Add validation rules and validate before writes.


### MEDIUM-037 — Validation

- **File:** `app/Livewire/Admin/UnitsOfMeasure/Index.php`
- **Issue:** Livewire component has mutating action without obvious validation

- **Evidence:** Heuristic: mutating methods but no validate()/validateOnly() in file.

- **Recommended fix:** Add validation rules and validate before writes.


### MEDIUM-038 — Validation

- **File:** `app/Livewire/CommandPalette.php`
- **Issue:** Livewire component has mutating action without obvious validation

- **Evidence:** Heuristic: mutating methods but no validate()/validateOnly() in file.

- **Recommended fix:** Add validation rules and validate before writes.


### MEDIUM-039 — Validation

- **File:** `app/Livewire/Components/GlobalSearch.php`
- **Issue:** Livewire component has mutating action without obvious validation

- **Evidence:** Heuristic: mutating methods but no validate()/validateOnly() in file.

- **Recommended fix:** Add validation rules and validate before writes.


### MEDIUM-040 — Validation

- **File:** `app/Livewire/Concerns/WithLivewire4Forms.php`
- **Issue:** Livewire component has mutating action without obvious validation

- **Evidence:** Heuristic: mutating methods but no validate()/validateOnly() in file.

- **Recommended fix:** Add validation rules and validate before writes.


### MEDIUM-041 — Validation

- **File:** `app/Livewire/Dashboard/CustomizableDashboard.php`
- **Issue:** Livewire component has mutating action without obvious validation

- **Evidence:** Heuristic: mutating methods but no validate()/validateOnly() in file.

- **Recommended fix:** Add validation rules and validate before writes.


### MEDIUM-042 — Validation

- **File:** `app/Livewire/Expenses/Categories/Index.php`
- **Issue:** Livewire component has mutating action without obvious validation

- **Evidence:** Heuristic: mutating methods but no validate()/validateOnly() in file.

- **Recommended fix:** Add validation rules and validate before writes.


### MEDIUM-043 — Validation

- **File:** `app/Livewire/Hrm/Reports/Dashboard.php`
- **Issue:** Livewire component has mutating action without obvious validation

- **Evidence:** Heuristic: mutating methods but no validate()/validateOnly() in file.

- **Recommended fix:** Add validation rules and validate before writes.


### MEDIUM-044 — Validation

- **File:** `app/Livewire/Income/Categories/Index.php`
- **Issue:** Livewire component has mutating action without obvious validation

- **Evidence:** Heuristic: mutating methods but no validate()/validateOnly() in file.

- **Recommended fix:** Add validation rules and validate before writes.


### MEDIUM-045 — Validation

- **File:** `app/Livewire/Inventory/BarcodePrint.php`
- **Issue:** Livewire component has mutating action without obvious validation

- **Evidence:** Heuristic: mutating methods but no validate()/validateOnly() in file.

- **Recommended fix:** Add validation rules and validate before writes.


### MEDIUM-046 — Validation

- **File:** `app/Livewire/Inventory/ProductHistory.php`
- **Issue:** Livewire component has mutating action without obvious validation

- **Evidence:** Heuristic: mutating methods but no validate()/validateOnly() in file.

- **Recommended fix:** Add validation rules and validate before writes.


### MEDIUM-047 — Validation

- **File:** `app/Livewire/Inventory/StockAlerts.php`
- **Issue:** Livewire component has mutating action without obvious validation

- **Evidence:** Heuristic: mutating methods but no validate()/validateOnly() in file.

- **Recommended fix:** Add validation rules and validate before writes.


### MEDIUM-048 — Validation

- **File:** `app/Livewire/Manufacturing/Timeline.php`
- **Issue:** Livewire component has mutating action without obvious validation

- **Evidence:** Heuristic: mutating methods but no validate()/validateOnly() in file.

- **Recommended fix:** Add validation rules and validate before writes.


### MEDIUM-049 — Validation

- **File:** `app/Livewire/Pos/DailyReport.php`
- **Issue:** Livewire component has mutating action without obvious validation

- **Evidence:** Heuristic: mutating methods but no validate()/validateOnly() in file.

- **Recommended fix:** Add validation rules and validate before writes.


### MEDIUM-050 — Validation

- **File:** `app/Livewire/Projects/GanttChart.php`
- **Issue:** Livewire component has mutating action without obvious validation

- **Evidence:** Heuristic: mutating methods but no validate()/validateOnly() in file.

- **Recommended fix:** Add validation rules and validate before writes.


### MEDIUM-051 — Validation

- **File:** `app/Livewire/Purchases/Quotations/Compare.php`
- **Issue:** Livewire component has mutating action without obvious validation

- **Evidence:** Heuristic: mutating methods but no validate()/validateOnly() in file.

- **Recommended fix:** Add validation rules and validate before writes.


### MEDIUM-052 — Validation

- **File:** `app/Livewire/Purchases/Returns/Index.php`
- **Issue:** Livewire component has mutating action without obvious validation

- **Evidence:** Heuristic: mutating methods but no validate()/validateOnly() in file.

- **Recommended fix:** Add validation rules and validate before writes.


### MEDIUM-053 — Validation

- **File:** `app/Livewire/Rental/Reports/Dashboard.php`
- **Issue:** Livewire component has mutating action without obvious validation

- **Evidence:** Heuristic: mutating methods but no validate()/validateOnly() in file.

- **Recommended fix:** Add validation rules and validate before writes.


### MEDIUM-054 — Validation

- **File:** `app/Livewire/Reports/SalesAnalytics.php`
- **Issue:** Livewire component has mutating action without obvious validation

- **Evidence:** Heuristic: mutating methods but no validate()/validateOnly() in file.

- **Recommended fix:** Add validation rules and validate before writes.


### MEDIUM-055 — Validation

- **File:** `app/Livewire/Sales/Returns/Index.php`
- **Issue:** Livewire component has mutating action without obvious validation

- **Evidence:** Heuristic: mutating methods but no validate()/validateOnly() in file.

- **Recommended fix:** Add validation rules and validate before writes.


### MEDIUM-056 — Validation

- **File:** `app/Livewire/Shared/DynamicTable.php`
- **Issue:** Livewire component has mutating action without obvious validation

- **Evidence:** Heuristic: mutating methods but no validate()/validateOnly() in file.

- **Recommended fix:** Add validation rules and validate before writes.


### MEDIUM-057 — Validation

- **File:** `app/Livewire/Shared/SearchInput.php`
- **Issue:** Livewire component has mutating action without obvious validation

- **Evidence:** Heuristic: mutating methods but no validate()/validateOnly() in file.

- **Recommended fix:** Add validation rules and validate before writes.


## Tenancy/Branch metrics

- Models extending `Model` directly (not BaseModel): **70**

- Branch-expected tables missing `branch_id` in migrations: **31**

- Tables with `branch_id` in migrations: **93**

- Tables with `branch_id` FK constrained to branches: **0**

- Tables with scoped unique using branch_id: **60**


# APmo ERP v65 — تقرير Bugs (Static/Pattern + نقاط واضحة)

**Generated:** 2026-01-22 12:38:10 (Africa/Cairo)

## 0) Context
| Metric | Value |
|---|---|
| PHP files scanned (app) | 1262 |
| Blade files scanned | 299 |
| Composer require - laravel/framework | ^12.0 |
| Composer require - livewire/livewire | ^4.0.1 |

## 1) Plan compliance snapshot
| Item | Status | Evidence |
|---|---|---|
| Branch context coherence | ✅ APPLIED | SetUserBranchContext + BranchScope + BranchContextManager |
| Finance rounding (bcround negative handling) | ❌ NOT APPLIED | app/Helpers/helpers.php::bcround |
| Branch scoping for models with branch_id | ❌ NOT APPLIED | remaining: 20 |
| Branch-aware exists validations | ❌ NOT APPLIED | remaining: 11 |
| Livewire authorization baseline | ❌ NOT APPLIED | flagged: 75 |
| Blade XSS raw output | ❌ NOT APPLIED | occurrences: 2 |
| Scope bypass hardened | ❌ NOT APPLIED | hits: 19 |
| Migrations sanity | ❌ NOT APPLIED | migrations: 38 |
| Tests & guardrails | ❌ NOT APPLIED | tests: 0 |

## 2) مقارنة v64 → v65 (مؤشرات)
| Metric | v64 | v65 | Δ |
|---|---|---|---|
| Branch context fixed | 1 | 1 | +0 |
| bcround signed logic detected | 0 | 0 | +0 |
| Unscoped models (branch_id without scoping) | 20 | 20 | +0 |
| Unsafe exists validations (branch-owned) | 11 | 11 | +0 |
| Rule::exists()->where(branch_id) | 4 | 4 | +0 |
| Livewire mutation methods w/o authorize (flagged) | 75 | 75 | +0 |
| Controller mutation methods w/o authorize (flagged) | 54 | 54 | +0 |
| Blade raw output `{!! !!}` | 2 | 2 | +0 |
| Raw SQL hits (review) | 54 | 54 | +0 |
| Scope bypass withoutGlobalScopes hits | 19 | 19 | +0 |
| Mass assignment risky ($request->all()) | 0 | 0 | +0 |
| Dangerous exec/shell usage | 5 | 5 | +0 |
| Upload risky patterns | 18 | 18 | +0 |
| Debug leftovers dd()/dump() | 0 | 0 | +0 |
| Migrations files | 37 | 38 | +1 |
| Migration issues (HIGH/MEDIUM) | 197 | 198 | +1 |
| Tests files | 0 | 0 | +0 |

## 3) ما الذي اتصلح فعليًا في v65؟ (Diff signals)
### 3.1 Models scoping
- لا يوجد دليل على تقليل unscoped models مقارنة بـ v64.

### 3.2 exists validations
- لا يوجد دليل على تقليل unsafe exists مقارنة بـ v64.

### 3.3 Livewire authorization
- لا يوجد دليل على تقليل flagged Livewire methods مقارنة بـ v64.

### 3.4 Blade raw outputs
- لا يوجد دليل أن `{!! !!}` اتحلت مقارنة بـ v64.

---

# 4) Bugs / Risks (مرتبة حسب الخطورة)

## 4.1 CRITICAL — Tenancy: Models فيها `branch_id` بدون scoping
- **Remaining:** 20
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
| app/Models/Scopes/BranchScope.php | 22 |
| app/Models/StockTransfer.php | 12 |
| app/Models/SupplierPerformanceMetric.php | 16 |
| app/Models/Ticket.php | 18 |
| app/Models/Traits/EnhancedAuditLogging.php | 1 |

**Refactor residue:** import `HasBranch` بدون `use HasBranch;`
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

## 4.2 CRITICAL — Tenancy: `exists:` validations على جداول branch-owned بدون شرط branch
- **Remaining:** 11
| Table | count |
|---|---|
| modules | 3 |
| products | 3 |
| customers | 2 |
| warehouses | 2 |
| suppliers | 1 |

**Index (full):**
| File | Line | Table | Column | Rule |
|---|---|---|---|---|
| app/Livewire/Admin/ApiDocumentation.php | 165 | customers | id | 'customer_id' => 'nullable\|exists:customers,id', |
| app/Livewire/Sales/Form.php | 105 | customers | id | 'exists:customers,id', |
| app/Livewire/Admin/ApiDocumentation.php | 70 | modules | id | 'module_id' => 'required\|exists:modules,id', |
| app/Livewire/Admin/Modules/ProductFields/Form.php | 136 | modules | id | 'moduleId' => 'required\|integer\|exists:modules,id', |
| app/Livewire/Inventory/Products/Form.php | 264 | modules | id | 'form.module_id' => ['nullable', 'integer', 'exists:modules,id'], |
| app/Livewire/Admin/ApiDocumentation.php | 116 | products | id | 'product_id' => 'required\|exists:products,id', |
| app/Livewire/Admin/ApiDocumentation.php | 129 | products | id | 'items.*.product_id' => 'required\|exists:products,id', |
| app/Livewire/Admin/ApiDocumentation.php | 168 | products | id | 'items.*.product_id' => 'required\|exists:products,id', |
| app/Livewire/Purchases/Form.php | 94 | suppliers | id | 'exists:suppliers,id', |
| app/Livewire/Purchases/Form.php | 106 | warehouses | id | 'exists:warehouses,id', |
| app/Livewire/Sales/Form.php | 117 | warehouses | id | 'exists:warehouses,id', |

## 4.3 CRITICAL — Finance correctness: `bcround()` negative rounding policy
- **Signed logic detected (heuristic):** False
- **Location:** `app/Helpers/helpers.php`
```php
434:     function bcround(?string $value, int $precision = 2): string
435:     {
436:         // Handle empty/null values
437:         if ($value === '' || $value === null) {
438:             return '0';
439:         }
440: 
441:         // V58-CRITICAL-01 FIX: Proper "half away from zero" rounding for both positive and negative values.
442:         // This matches PHP's default round() behavior (PHP_ROUND_HALF_UP equivalent for positives,
443:         // but rounds away from zero for negatives).
444:         //
445:         // Algorithm:
446:         // 1. Determine sign and work with absolute value
447:         // 2. Add offset (0.5 * 10^(-precision)) to absolute value
448:         // 3. Truncate using bcadd with target precision (bcmath truncates toward zero)
449:         // 4. Restore sign, handling the "-0.00" edge case
450:         //
451:         // This approach ensures:
452:         // - bcround('1.235', 2) = '1.24' (rounds up)
453:         // - bcround('-1.235', 2) = '-1.24' (rounds away from zero, i.e., more negative)
454:         // - bcround('1.234', 2) = '1.23' (rounds down)
455:         // - bcround('-1.234', 2) = '-1.23' (rounds toward zero)
456:         // - bcround('-0.001', 2) = '0.00' (normalized, no -0.00)
457: 
458:         $isNegative = str_starts_with($value, '-');
459:         $absValue = $isNegative ? ltrim($value, '-') : $value;
460: 
461:         // Validate the absolute value is a valid numeric string
462:         if (! is_numeric($absValue)) {
463:             return '0';
464:         }
465: 
466:         // Calculate offset for half-up rounding: 0.5 * 10^(-precision)
467:         // e.g., for precision=2, offset = '0.005'
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

## 4.4 HIGH — Authorization: Livewire mutation methods بدون `authorize()` داخل الميثود (pattern)
- **Flagged:** 75
| Module | count |
|---|---|
| Admin | 32 |
| Components | 8 |
| Purchases | 6 |
| Profile | 5 |
| Hrm | 4 |
| Inventory | 4 |
| Rental | 4 |
| CommandPalette.php | 2 |
| Reports | 2 |
| Shared | 2 |
| Auth | 1 |
| Dashboard | 1 |
| Expenses | 1 |
| Helpdesk | 1 |
| Income | 1 |
| Sales | 1 |

**Index (full):**
| File | Line | Method |
|---|---|---|
| app/Livewire/Admin/Branch/Employees.php | 68 | toggleStatus |
| app/Livewire/Admin/Branch/Settings.php | 72 | save |
| app/Livewire/Admin/Branches/Form.php | 179 | save |
| app/Livewire/Admin/Branches/Modules.php | 72 | save |
| app/Livewire/Admin/BulkImport.php | 141 | loadGoogleSheet |
| app/Livewire/Admin/BulkImport.php | 308 | runImport |
| app/Livewire/Admin/Categories/Form.php | 87 | save |
| app/Livewire/Admin/Currency/Form.php | 81 | save |
| app/Livewire/Admin/Loyalty/Index.php | 69 | saveSettings |
| app/Livewire/Admin/MediaLibrary.php | 66 | updatedFiles |
| app/Livewire/Admin/MediaLibrary.php | 142 | delete |
| app/Livewire/Admin/Modules/Form.php | 109 | save |
| app/Livewire/Admin/Modules/ManagementCenter.php | 157 | toggleModuleForBranch |
| app/Livewire/Admin/Modules/ManagementCenter.php | 190 | toggleModuleActive |
| app/Livewire/Admin/Modules/ProductFields.php | 122 | reorder |
| app/Livewire/Admin/Modules/ProductFields/Form.php | 157 | save |
| app/Livewire/Admin/Reports/ReportTemplatesManager.php | 206 | delete |
| app/Livewire/Admin/Reports/ScheduledReportsManager.php | 253 | delete |
| app/Livewire/Admin/Roles/Form.php | 201 | save |
| app/Livewire/Admin/Settings/PurchasesSettings.php | 65 | setSetting |
| app/Livewire/Admin/Settings/SystemSettings.php | 104 | save |
| app/Livewire/Admin/Settings/UnifiedSettings.php | 312 | setSetting |
| app/Livewire/Admin/Settings/UnifiedSettings.php | 440 | saveSecurity |
| app/Livewire/Admin/Settings/UnifiedSettings.php | 631 | restoreDefaults |
| app/Livewire/Admin/Settings/UserPreferences.php | 41 | save |
| app/Livewire/Admin/Settings/UserPreferences.php | 81 | resetToDefaults |
| app/Livewire/Admin/Settings/WarehouseSettings.php | 65 | setSetting |
| app/Livewire/Admin/SetupWizard.php | 182 | completeSetup |
| app/Livewire/Admin/SetupWizard.php | 259 | skipSetup |
| app/Livewire/Admin/Store/Form.php | 135 | save |
| app/Livewire/Admin/UnitsOfMeasure/Form.php | 107 | save |
| app/Livewire/Admin/Users/Form.php | 151 | save |
| app/Livewire/Auth/Login.php | 55 | login |
| app/Livewire/CommandPalette.php | 68 | saveRecentSearch |
| app/Livewire/CommandPalette.php | 106 | clearRecentSearches |
| app/Livewire/Components/DashboardWidgets.php | 134 | toggleWidget |
| app/Livewire/Components/MediaPicker.php | 687 | handleMediaUpload |
| app/Livewire/Components/NotesAttachments.php | 100 | saveNote |
| app/Livewire/Components/NotesAttachments.php | 148 | deleteNote |
| app/Livewire/Components/NotesAttachments.php | 160 | togglePin |
| app/Livewire/Components/NotesAttachments.php | 187 | uploadFiles |
| app/Livewire/Components/NotesAttachments.php | 281 | deleteAttachment |
| app/Livewire/Components/NotificationsCenter.php | 71 | markAllAsRead |
| app/Livewire/Dashboard/CustomizableDashboard.php | 456 | saveUserPreferences |
| app/Livewire/Expenses/Categories/Form.php | 62 | save |
| app/Livewire/Helpdesk/Tickets/Form.php | 103 | save |
| app/Livewire/Hrm/Employees/Form.php | 154 | save |
| app/Livewire/Hrm/Payroll/Run.php | 47 | runPayroll |
| app/Livewire/Hrm/SelfService/MyLeaves.php | 77 | submitRequest |
| app/Livewire/Hrm/SelfService/MyLeaves.php | 113 | cancelRequest |
| app/Livewire/Income/Categories/Form.php | 61 | save |
| app/Livewire/Inventory/ProductCompatibility.php | 247 | toggleVerified |
| app/Livewire/Inventory/ProductStoreMappings.php | 108 | delete |
| app/Livewire/Inventory/ProductStoreMappings/Form.php | 122 | save |
| app/Livewire/Inventory/Services/Form.php | 163 | save |
| app/Livewire/Profile/Edit.php | 50 | updateProfile |
| app/Livewire/Profile/Edit.php | 67 | updatePassword |
| app/Livewire/Profile/Edit.php | 88 | handleFileUploaded |
| app/Livewire/Profile/Edit.php | 118 | updateAvatar |
| app/Livewire/Profile/Edit.php | 144 | removeAvatar |
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
| app/Livewire/Sales/Returns/Index.php | 194 | deleteReturn |
| app/Livewire/Shared/OnboardingGuide.php | 351 | saveProgress |
| app/Livewire/Shared/OnboardingGuide.php | 391 | resetOnboarding |

## 4.5 HIGH — Authorization: Controller mutation methods بدون authorize (heuristic)
- **Flagged:** 54
| Controller file | Line | Method |
|---|---|---|
| app/Http/Controllers/Admin/HrmCentral/AttendanceController.php | 33 | store |
| app/Http/Controllers/Admin/HrmCentral/AttendanceController.php | 61 | update |
| app/Http/Controllers/Admin/HrmCentral/AttendanceController.php | 87 | approve |
| app/Http/Controllers/Admin/HrmCentral/EmployeeController.php | 28 | update |
| app/Http/Controllers/Admin/HrmCentral/LeaveController.php | 30 | approve |
| app/Http/Controllers/Admin/HrmCentral/PayrollController.php | 43 | approve |
| app/Http/Controllers/Admin/HrmCentral/PayrollController.php | 54 | pay |
| app/Http/Controllers/Api/V1/CustomersController.php | 64 | store |
| app/Http/Controllers/Api/V1/CustomersController.php | 114 | update |
| app/Http/Controllers/Api/V1/CustomersController.php | 167 | destroy |
| app/Http/Controllers/Api/V1/OrdersController.php | 73 | store |
| app/Http/Controllers/Api/V1/ProductsController.php | 169 | store |
| app/Http/Controllers/Api/V1/ProductsController.php | 264 | update |
| app/Http/Controllers/Api/V1/ProductsController.php | 368 | destroy |
| app/Http/Controllers/Branch/CustomerController.php | 28 | store |
| app/Http/Controllers/Branch/CustomerController.php | 45 | update |
| app/Http/Controllers/Branch/CustomerController.php | 56 | destroy |
| app/Http/Controllers/Branch/HRM/AttendanceController.php | 54 | approve |
| app/Http/Controllers/Branch/HRM/AttendanceController.php | 61 | store |
| app/Http/Controllers/Branch/HRM/AttendanceController.php | 90 | update |
| app/Http/Controllers/Branch/HRM/PayrollController.php | 40 | approve |
| app/Http/Controllers/Branch/HRM/PayrollController.php | 48 | pay |
| app/Http/Controllers/Branch/Motorcycle/ContractController.php | 27 | store |
| app/Http/Controllers/Branch/Motorcycle/ContractController.php | 50 | update |
| app/Http/Controllers/Branch/Motorcycle/VehicleController.php | 25 | store |
| app/Http/Controllers/Branch/Motorcycle/VehicleController.php | 42 | update |
| app/Http/Controllers/Branch/Motorcycle/WarrantyController.php | 27 | store |
| app/Http/Controllers/Branch/Motorcycle/WarrantyController.php | 44 | update |
| app/Http/Controllers/Branch/ProductController.php | 70 | store |
| app/Http/Controllers/Branch/ProductController.php | 99 | update |
| app/Http/Controllers/Branch/PurchaseController.php | 48 | store |
| app/Http/Controllers/Branch/PurchaseController.php | 67 | update |
| app/Http/Controllers/Branch/PurchaseController.php | 78 | approve |
| app/Http/Controllers/Branch/PurchaseController.php | 103 | pay |
| app/Http/Controllers/Branch/PurchaseController.php | 139 | cancel |
| app/Http/Controllers/Branch/Rental/ContractController.php | 28 | store |
| app/Http/Controllers/Branch/Rental/ContractController.php | 43 | update |
| app/Http/Controllers/Branch/Rental/PropertyController.php | 26 | store |
| app/Http/Controllers/Branch/Rental/PropertyController.php | 41 | update |
| app/Http/Controllers/Branch/Rental/TenantController.php | 27 | store |
| app/Http/Controllers/Branch/Rental/TenantController.php | 42 | update |
| app/Http/Controllers/Branch/Rental/UnitController.php | 27 | store |
| app/Http/Controllers/Branch/Rental/UnitController.php | 43 | update |
| app/Http/Controllers/Branch/SaleController.php | 40 | store |
| app/Http/Controllers/Branch/SaleController.php | 54 | update |
| app/Http/Controllers/Branch/SupplierController.php | 28 | store |
| app/Http/Controllers/Branch/SupplierController.php | 45 | update |
| app/Http/Controllers/Branch/SupplierController.php | 56 | destroy |
| app/Http/Controllers/Branch/WarehouseController.php | 26 | store |
| app/Http/Controllers/Branch/WarehouseController.php | 43 | update |
| app/Http/Controllers/Branch/WarehouseController.php | 54 | destroy |
| app/Http/Controllers/Branch/Wood/ConversionController.php | 24 | store |
| app/Http/Controllers/Branch/Wood/WasteController.php | 23 | store |
| app/Http/Controllers/Files/UploadController.php | 21 | store |

## 4.6 HIGH — Tenancy bypass surface: `withoutGlobalScopes()` / `withoutGlobalScope()`
- **Hits:** 19
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

## 4.7 MEDIUM — XSS: Blade raw output `{!! !!}`
- **Occurrences:** 2
| Blade file | Line | Expression |
|---|---|---|
| resources/views/components/ui/card.blade.php | 50 | {!! $actions !!} |
| resources/views/components/ui/form/input.blade.php | 83 | @if($validWireModel && $validWireModifier) {!! $wireDirective !!} @endif |

## 4.8 MEDIUM — Raw SQL backlog (review)
- **Hits:** 54
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

## 4.9 MEDIUM — Mass assignment risk: استخدام `$request->all()` مع create/update/fill
- **Hits:** 0
| File | Line | Snippet |
|---|---|---|
| — | — | — |

## 4.10 MEDIUM — File upload risk patterns (storeAs/originalName/move)
- **Hits:** 18
| File | Line | Snippet |
|---|---|---|
| app/Http/Controllers/Files/UploadController.php | 181 | $path = $uploaded->storeAs($dir, $name, [ |
| app/Http/Controllers/Files/UploadController.php | 192 | 'original_name' => $uploaded->getClientOriginalName(), |
| app/Http/Controllers/Files/UploadController.php | 205 | 'original_name' => $uploaded->getClientOriginalName(), |
| app/Livewire/Admin/MediaLibrary.php | 88 | 'name' => pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME), |
| app/Livewire/Admin/MediaLibrary.php | 89 | 'original_name' => $file->getClientOriginalName(), |
| app/Livewire/Components/MediaPicker.php | 655 | 'original_name' => $this->uploadFile->getClientOriginalName(), |
| app/Livewire/Components/MediaPicker.php | 669 | $this->previewName = $this->uploadFile->getClientOriginalName(); |
| app/Livewire/Components/MediaPicker.php | 696 | 'name' => pathinfo($this->uploadFile->getClientOriginalName(), PATHINFO_FILENAME), |
| app/Livewire/Components/MediaPicker.php | 697 | 'original_name' => $this->uploadFile->getClientOriginalName(), |
| app/Livewire/Components/NotesAttachments.php | 250 | 'original_filename' => $file->getClientOriginalName(), |
| app/Livewire/Rental/Contracts/Form.php | 355 | 'original_name' => $file->getClientOriginalName(), |
| app/Services/DocumentService.php | 95 | 'file_name' => $file->getClientOriginalName(), |
| app/Services/DocumentService.php | 118 | 'file_name' => $file->getClientOriginalName(), |
| app/Services/DocumentService.php | 165 | 'file_name' => $file->getClientOriginalName(), |
| app/Services/DocumentService.php | 178 | 'file_name' => $file->getClientOriginalName(), |
| resources/views/livewire/admin/bulk-import.blade.php | 145 | <span class="text-sm text-emerald-700 dark:text-emerald-300">{{ $importFile->getClientOriginalName() }}</span> |
| resources/views/livewire/components/notes-attachments.blade.php | 208 | {{ $file->getClientOriginalName() }} |
| resources/views/livewire/documents/form.blade.php | 65 | <p class="text-sm font-medium text-slate-700">{{ $file->getClientOriginalName() }}</p> |

## 4.11 LOW — Debug leftovers `dd()`/`dump()`
- **Hits:** 0
| File | Line | Snippet |
|---|---|---|

## 4.12 LOW — استخدام exec/shell (لازم allow-list + escaping + logging)
- **Hits:** 5
| File | Line | Snippet |
|---|---|---|
| app/Jobs/BackupDatabaseJob.php | 108 | exec($cmd, $output, $returnCode); |
| app/Jobs/BackupDatabaseJob.php | 177 | exec($cmd, $output, $returnCode); |
| app/Services/BackupService.php | 238 | exec($command, $output, $returnVar); |
| app/Services/BackupService.php | 293 | exec($command, $output, $returnVar); |
| resources/views/livewire/admin/modules/form.blade.php | 18 | <p class="mt-1">{{ __('Modules are major sections of the ERP system (like Sales, Inventory, HR). Each module can have its own custom fields that appear in forms throughout that section.') }}</p> |

---

# 5) Migrations audit (v65)
| Metric | Value |
|---|---|
| migrations files | 38 |
| issues (HIGH/MEDIUM) | 198 |

## 5.1 Migration issues (index full)
| Severity | File | Line | Issue | Snippet |
|---|---|---|---|---|
| HIGH | database/migrations/2026_01_01_000001_create_branches_table.php | 50 | Drop operation في up() | Schema::dropIfExists('branches'); |
| HIGH | database/migrations/2026_01_01_000002_create_users_table.php | 66 | Drop operation في up() | Schema::dropIfExists('users'); |
| HIGH | database/migrations/2026_01_01_000003_create_permission_tables.php | 143 | Drop operation في up() | Schema::dropIfExists($tableNames['role_has_permissions']); |
| HIGH | database/migrations/2026_01_01_000003_create_permission_tables.php | 144 | Drop operation في up() | Schema::dropIfExists($tableNames['model_has_roles']); |
| HIGH | database/migrations/2026_01_01_000003_create_permission_tables.php | 145 | Drop operation في up() | Schema::dropIfExists($tableNames['model_has_permissions']); |
| HIGH | database/migrations/2026_01_01_000003_create_permission_tables.php | 146 | Drop operation في up() | Schema::dropIfExists($tableNames['roles']); |
| HIGH | database/migrations/2026_01_01_000003_create_permission_tables.php | 147 | Drop operation في up() | Schema::dropIfExists($tableNames['permissions']); |
| HIGH | database/migrations/2026_01_01_000004_create_modules_table.php | 63 | Drop operation في up() | Schema::dropIfExists('modules'); |
| HIGH | database/migrations/2026_01_01_000005_create_branch_pivot_tables.php | 90 | Drop operation في up() | Schema::dropIfExists('branch_admins'); |
| HIGH | database/migrations/2026_01_01_000005_create_branch_pivot_tables.php | 91 | Drop operation في up() | Schema::dropIfExists('branch_modules'); |
| HIGH | database/migrations/2026_01_01_000005_create_branch_pivot_tables.php | 92 | Drop operation في up() | Schema::dropIfExists('branch_user'); |
| HIGH | database/migrations/2026_01_01_000006_create_module_configuration_tables.php | 222 | Drop operation في up() | Schema::dropIfExists('module_product_fields'); |
| HIGH | database/migrations/2026_01_01_000006_create_module_configuration_tables.php | 223 | Drop operation في up() | Schema::dropIfExists('module_policies'); |
| HIGH | database/migrations/2026_01_01_000006_create_module_configuration_tables.php | 224 | Drop operation في up() | Schema::dropIfExists('module_operations'); |
| HIGH | database/migrations/2026_01_01_000006_create_module_configuration_tables.php | 225 | Drop operation في up() | Schema::dropIfExists('module_navigation'); |
| HIGH | database/migrations/2026_01_01_000006_create_module_configuration_tables.php | 226 | Drop operation في up() | Schema::dropIfExists('module_fields'); |
| HIGH | database/migrations/2026_01_01_000006_create_module_configuration_tables.php | 227 | Drop operation في up() | Schema::dropIfExists('module_custom_fields'); |
| HIGH | database/migrations/2026_01_01_000006_create_module_configuration_tables.php | 228 | Drop operation في up() | Schema::dropIfExists('module_settings'); |
| HIGH | database/migrations/2026_01_02_000001_create_currencies_units_tables.php | 99 | Drop operation في up() | Schema::dropIfExists('units_of_measure'); |
| HIGH | database/migrations/2026_01_02_000001_create_currencies_units_tables.php | 100 | Drop operation في up() | Schema::dropIfExists('currency_rates'); |
| HIGH | database/migrations/2026_01_02_000001_create_currencies_units_tables.php | 101 | Drop operation في up() | Schema::dropIfExists('currencies'); |
| HIGH | database/migrations/2026_01_02_000002_create_taxes_table.php | 49 | Drop operation في up() | Schema::dropIfExists('taxes'); |
| HIGH | database/migrations/2026_01_02_000003_create_warehouses_table.php | 56 | Drop operation في up() | Schema::dropIfExists('warehouses'); |
| HIGH | database/migrations/2026_01_02_000004_create_product_categories_price_groups_tables.php | 82 | Drop operation في up() | Schema::dropIfExists('price_groups'); |
| HIGH | database/migrations/2026_01_02_000004_create_product_categories_price_groups_tables.php | 83 | Drop operation في up() | Schema::dropIfExists('product_categories'); |
| HIGH | database/migrations/2026_01_02_000005_create_products_table.php | 250 | Drop operation في up() | Schema::dropIfExists('product_field_values'); |
| HIGH | database/migrations/2026_01_02_000005_create_products_table.php | 251 | Drop operation في up() | Schema::dropIfExists('product_price_tiers'); |
| HIGH | database/migrations/2026_01_02_000005_create_products_table.php | 252 | Drop operation في up() | Schema::dropIfExists('product_variations'); |
| HIGH | database/migrations/2026_01_02_000005_create_products_table.php | 253 | Drop operation في up() | Schema::dropIfExists('products'); |
| HIGH | database/migrations/2026_01_02_000006_create_vehicle_models_compatibilities_tables.php | 62 | Drop operation في up() | Schema::dropIfExists('product_compatibilities'); |
| HIGH | database/migrations/2026_01_02_000006_create_vehicle_models_compatibilities_tables.php | 63 | Drop operation في up() | Schema::dropIfExists('vehicle_models'); |
| HIGH | database/migrations/2026_01_02_000007_create_customers_suppliers_tables.php | 160 | Drop operation في up() | Schema::dropIfExists('suppliers'); |
| HIGH | database/migrations/2026_01_02_000007_create_customers_suppliers_tables.php | 161 | Drop operation في up() | Schema::dropIfExists('customers'); |
| HIGH | database/migrations/2026_01_02_000008_create_stores_tables.php | 157 | Drop operation في up() | Schema::dropIfExists('product_store_mappings'); |
| HIGH | database/migrations/2026_01_02_000008_create_stores_tables.php | 158 | Drop operation في up() | Schema::dropIfExists('store_sync_logs'); |
| HIGH | database/migrations/2026_01_02_000008_create_stores_tables.php | 159 | Drop operation في up() | Schema::dropIfExists('store_orders'); |
| HIGH | database/migrations/2026_01_02_000008_create_stores_tables.php | 160 | Drop operation في up() | Schema::dropIfExists('store_tokens'); |
| HIGH | database/migrations/2026_01_02_000008_create_stores_tables.php | 161 | Drop operation في up() | Schema::dropIfExists('store_integrations'); |
| HIGH | database/migrations/2026_01_02_000008_create_stores_tables.php | 162 | Drop operation في up() | Schema::dropIfExists('stores'); |
| HIGH | database/migrations/2026_01_03_000001_create_accounting_tables.php | 190 | Drop operation في up() | Schema::dropIfExists('journal_entry_lines'); |
| HIGH | database/migrations/2026_01_03_000001_create_accounting_tables.php | 191 | Drop operation في up() | Schema::dropIfExists('journal_entries'); |
| HIGH | database/migrations/2026_01_03_000001_create_accounting_tables.php | 192 | Drop operation في up() | Schema::dropIfExists('account_mappings'); |
| HIGH | database/migrations/2026_01_03_000001_create_accounting_tables.php | 193 | Drop operation في up() | Schema::dropIfExists('accounts'); |
| HIGH | database/migrations/2026_01_03_000001_create_accounting_tables.php | 194 | Drop operation في up() | Schema::dropIfExists('fiscal_periods'); |
| HIGH | database/migrations/2026_01_03_000002_create_banking_tables.php | 182 | Drop operation في up() | Schema::dropIfExists('cashflow_projections'); |
| HIGH | database/migrations/2026_01_03_000002_create_banking_tables.php | 183 | Drop operation في up() | Schema::dropIfExists('bank_transactions'); |
| HIGH | database/migrations/2026_01_03_000002_create_banking_tables.php | 184 | Drop operation في up() | Schema::dropIfExists('bank_reconciliations'); |
| HIGH | database/migrations/2026_01_03_000002_create_banking_tables.php | 185 | Drop operation في up() | Schema::dropIfExists('bank_accounts'); |
| HIGH | database/migrations/2026_01_03_000003_create_expense_income_tables.php | 176 | Drop operation في up() | Schema::dropIfExists('incomes'); |
| HIGH | database/migrations/2026_01_03_000003_create_expense_income_tables.php | 177 | Drop operation في up() | Schema::dropIfExists('expenses'); |
| HIGH | database/migrations/2026_01_03_000003_create_expense_income_tables.php | 178 | Drop operation في up() | Schema::dropIfExists('income_categories'); |
| HIGH | database/migrations/2026_01_03_000003_create_expense_income_tables.php | 179 | Drop operation في up() | Schema::dropIfExists('expense_categories'); |
| HIGH | database/migrations/2026_01_03_000004_create_fixed_assets_tables.php | 156 | Drop operation في up() | Schema::dropIfExists('asset_maintenance_logs'); |
| HIGH | database/migrations/2026_01_03_000004_create_fixed_assets_tables.php | 157 | Drop operation في up() | Schema::dropIfExists('asset_depreciations'); |
| HIGH | database/migrations/2026_01_03_000004_create_fixed_assets_tables.php | 158 | Drop operation في up() | Schema::dropIfExists('fixed_assets'); |
| HIGH | database/migrations/2026_01_04_000001_create_sales_tables.php | 306 | Drop operation في up() | Schema::dropIfExists('deliveries'); |
| HIGH | database/migrations/2026_01_04_000001_create_sales_tables.php | 307 | Drop operation في up() | Schema::dropIfExists('receipts'); |
| HIGH | database/migrations/2026_01_04_000001_create_sales_tables.php | 308 | Drop operation في up() | Schema::dropIfExists('sale_payments'); |
| HIGH | database/migrations/2026_01_04_000001_create_sales_tables.php | 309 | Drop operation في up() | Schema::dropIfExists('sale_items'); |
| HIGH | database/migrations/2026_01_04_000001_create_sales_tables.php | 310 | Drop operation في up() | Schema::dropIfExists('sales'); |
| HIGH | database/migrations/2026_01_04_000001_create_sales_tables.php | 311 | Drop operation في up() | Schema::dropIfExists('pos_sessions'); |
| HIGH | database/migrations/2026_01_04_000002_create_purchases_tables.php | 416 | Drop operation في up() | Schema::dropIfExists('grn_items'); |
| HIGH | database/migrations/2026_01_04_000002_create_purchases_tables.php | 417 | Drop operation في up() | Schema::dropIfExists('goods_received_notes'); |
| HIGH | database/migrations/2026_01_04_000002_create_purchases_tables.php | 418 | Drop operation في up() | Schema::dropIfExists('purchase_payments'); |
| HIGH | database/migrations/2026_01_04_000002_create_purchases_tables.php | 419 | Drop operation في up() | Schema::dropIfExists('purchase_items'); |
| HIGH | database/migrations/2026_01_04_000002_create_purchases_tables.php | 423 | Drop operation في up() | Schema::dropIfExists('purchases'); |
| HIGH | database/migrations/2026_01_04_000002_create_purchases_tables.php | 424 | Drop operation في up() | Schema::dropIfExists('supplier_quotation_items'); |
| HIGH | database/migrations/2026_01_04_000002_create_purchases_tables.php | 425 | Drop operation في up() | Schema::dropIfExists('supplier_quotations'); |
| HIGH | database/migrations/2026_01_04_000002_create_purchases_tables.php | 426 | Drop operation في up() | Schema::dropIfExists('purchase_requisition_items'); |
| HIGH | database/migrations/2026_01_04_000002_create_purchases_tables.php | 427 | Drop operation في up() | Schema::dropIfExists('purchase_requisitions'); |
| HIGH | database/migrations/2026_01_04_000003_create_inventory_tables.php | 485 | Drop operation في up() | Schema::dropIfExists('stock_movements'); |
| HIGH | database/migrations/2026_01_04_000003_create_inventory_tables.php | 486 | Drop operation في up() | Schema::dropIfExists('inventory_transits'); |
| HIGH | database/migrations/2026_01_04_000003_create_inventory_tables.php | 487 | Drop operation في up() | Schema::dropIfExists('stock_transfer_history'); |
| HIGH | database/migrations/2026_01_04_000003_create_inventory_tables.php | 488 | Drop operation في up() | Schema::dropIfExists('stock_transfer_documents'); |
| HIGH | database/migrations/2026_01_04_000003_create_inventory_tables.php | 489 | Drop operation في up() | Schema::dropIfExists('stock_transfer_approvals'); |
| HIGH | database/migrations/2026_01_04_000003_create_inventory_tables.php | 490 | Drop operation في up() | Schema::dropIfExists('stock_transfer_items'); |
| HIGH | database/migrations/2026_01_04_000003_create_inventory_tables.php | 491 | Drop operation في up() | Schema::dropIfExists('stock_transfers'); |
| HIGH | database/migrations/2026_01_04_000003_create_inventory_tables.php | 492 | Drop operation في up() | Schema::dropIfExists('transfer_items'); |
| HIGH | database/migrations/2026_01_04_000003_create_inventory_tables.php | 493 | Drop operation في up() | Schema::dropIfExists('transfers'); |
| HIGH | database/migrations/2026_01_04_000003_create_inventory_tables.php | 494 | Drop operation في up() | Schema::dropIfExists('adjustment_items'); |
| HIGH | database/migrations/2026_01_04_000003_create_inventory_tables.php | 495 | Drop operation في up() | Schema::dropIfExists('stock_adjustments'); |
| HIGH | database/migrations/2026_01_04_000003_create_inventory_tables.php | 496 | Drop operation في up() | Schema::dropIfExists('inventory_serials'); |
| HIGH | database/migrations/2026_01_04_000003_create_inventory_tables.php | 497 | Drop operation في up() | Schema::dropIfExists('inventory_batches'); |
| HIGH | database/migrations/2026_01_04_000004_create_returns_tables.php | 476 | Drop operation في up() | Schema::dropIfExists('debit_notes'); |
| HIGH | database/migrations/2026_01_04_000004_create_returns_tables.php | 477 | Drop operation في up() | Schema::dropIfExists('credit_note_applications'); |
| HIGH | database/migrations/2026_01_04_000004_create_returns_tables.php | 478 | Drop operation في up() | Schema::dropIfExists('credit_notes'); |
| HIGH | database/migrations/2026_01_04_000004_create_returns_tables.php | 479 | Drop operation في up() | Schema::dropIfExists('return_refunds'); |
| HIGH | database/migrations/2026_01_04_000004_create_returns_tables.php | 480 | Drop operation في up() | Schema::dropIfExists('purchase_return_items'); |
| HIGH | database/migrations/2026_01_04_000004_create_returns_tables.php | 481 | Drop operation في up() | Schema::dropIfExists('purchase_returns'); |
| HIGH | database/migrations/2026_01_04_000004_create_returns_tables.php | 482 | Drop operation في up() | Schema::dropIfExists('sales_return_items'); |
| HIGH | database/migrations/2026_01_04_000004_create_returns_tables.php | 483 | Drop operation في up() | Schema::dropIfExists('sales_returns'); |
| HIGH | database/migrations/2026_01_04_000004_create_returns_tables.php | 484 | Drop operation في up() | Schema::dropIfExists('return_notes'); |
| HIGH | database/migrations/2026_01_05_000001_create_hr_payroll_tables.php | 500 | Drop operation في up() | Schema::dropIfExists('payrolls'); |
| HIGH | database/migrations/2026_01_05_000001_create_hr_payroll_tables.php | 501 | Drop operation في up() | Schema::dropIfExists('leave_holidays'); |
| HIGH | database/migrations/2026_01_05_000001_create_hr_payroll_tables.php | 502 | Drop operation في up() | Schema::dropIfExists('leave_encashments'); |
| HIGH | database/migrations/2026_01_05_000001_create_hr_payroll_tables.php | 503 | Drop operation في up() | Schema::dropIfExists('leave_adjustments'); |
| HIGH | database/migrations/2026_01_05_000001_create_hr_payroll_tables.php | 504 | Drop operation في up() | Schema::dropIfExists('leave_request_approvals'); |
| HIGH | database/migrations/2026_01_05_000001_create_hr_payroll_tables.php | 505 | Drop operation في up() | Schema::dropIfExists('leave_requests'); |
| HIGH | database/migrations/2026_01_05_000001_create_hr_payroll_tables.php | 506 | Drop operation في up() | Schema::dropIfExists('leave_accrual_rules'); |
| HIGH | database/migrations/2026_01_05_000001_create_hr_payroll_tables.php | 507 | Drop operation في up() | Schema::dropIfExists('leave_balances'); |
| HIGH | database/migrations/2026_01_05_000001_create_hr_payroll_tables.php | 508 | Drop operation في up() | Schema::dropIfExists('leave_types'); |
| HIGH | database/migrations/2026_01_05_000001_create_hr_payroll_tables.php | 509 | Drop operation في up() | Schema::dropIfExists('attendances'); |
| HIGH | database/migrations/2026_01_05_000001_create_hr_payroll_tables.php | 510 | Drop operation في up() | Schema::dropIfExists('branch_employee'); |
| HIGH | database/migrations/2026_01_05_000001_create_hr_payroll_tables.php | 511 | Drop operation في up() | Schema::dropIfExists('employee_shifts'); |
| HIGH | database/migrations/2026_01_05_000001_create_hr_payroll_tables.php | 512 | Drop operation في up() | Schema::dropIfExists('hr_employees'); |
| HIGH | database/migrations/2026_01_05_000001_create_hr_payroll_tables.php | 513 | Drop operation في up() | Schema::dropIfExists('shifts'); |
| HIGH | database/migrations/2026_01_05_000002_create_rental_tables.php | 237 | Drop operation في up() | Schema::dropIfExists('rental_payments'); |
| HIGH | database/migrations/2026_01_05_000002_create_rental_tables.php | 238 | Drop operation في up() | Schema::dropIfExists('rental_invoices'); |
| HIGH | database/migrations/2026_01_05_000002_create_rental_tables.php | 239 | Drop operation في up() | Schema::dropIfExists('rental_periods'); |
| HIGH | database/migrations/2026_01_05_000002_create_rental_tables.php | 240 | Drop operation في up() | Schema::dropIfExists('rental_contracts'); |
| HIGH | database/migrations/2026_01_05_000002_create_rental_tables.php | 241 | Drop operation في up() | Schema::dropIfExists('tenants'); |
| HIGH | database/migrations/2026_01_05_000002_create_rental_tables.php | 242 | Drop operation في up() | Schema::dropIfExists('rental_units'); |
| HIGH | database/migrations/2026_01_05_000002_create_rental_tables.php | 243 | Drop operation في up() | Schema::dropIfExists('properties'); |
| HIGH | database/migrations/2026_01_05_000003_create_vehicle_tables.php | 117 | Drop operation في up() | Schema::dropIfExists('warranties'); |
| HIGH | database/migrations/2026_01_05_000003_create_vehicle_tables.php | 118 | Drop operation في up() | Schema::dropIfExists('vehicle_payments'); |
| HIGH | database/migrations/2026_01_05_000003_create_vehicle_tables.php | 119 | Drop operation في up() | Schema::dropIfExists('vehicle_contracts'); |
| HIGH | database/migrations/2026_01_05_000003_create_vehicle_tables.php | 120 | Drop operation في up() | Schema::dropIfExists('vehicles'); |
| HIGH | database/migrations/2026_01_05_000004_create_manufacturing_tables.php | 294 | Drop operation في up() | Schema::dropIfExists('manufacturing_transactions'); |
| HIGH | database/migrations/2026_01_05_000004_create_manufacturing_tables.php | 295 | Drop operation في up() | Schema::dropIfExists('production_order_operations'); |
| HIGH | database/migrations/2026_01_05_000004_create_manufacturing_tables.php | 296 | Drop operation في up() | Schema::dropIfExists('production_order_items'); |
| HIGH | database/migrations/2026_01_05_000004_create_manufacturing_tables.php | 297 | Drop operation في up() | Schema::dropIfExists('production_orders'); |
| HIGH | database/migrations/2026_01_05_000004_create_manufacturing_tables.php | 298 | Drop operation في up() | Schema::dropIfExists('bom_operations'); |
| HIGH | database/migrations/2026_01_05_000004_create_manufacturing_tables.php | 299 | Drop operation في up() | Schema::dropIfExists('bom_items'); |
| HIGH | database/migrations/2026_01_05_000004_create_manufacturing_tables.php | 300 | Drop operation في up() | Schema::dropIfExists('bills_of_materials'); |
| HIGH | database/migrations/2026_01_05_000004_create_manufacturing_tables.php | 301 | Drop operation في up() | Schema::dropIfExists('work_centers'); |
| HIGH | database/migrations/2026_01_05_000005_create_project_tables.php | 284 | Drop operation في up() | Schema::dropIfExists('project_time_logs'); |
| HIGH | database/migrations/2026_01_05_000005_create_project_tables.php | 285 | Drop operation في up() | Schema::dropIfExists('project_expenses'); |
| HIGH | database/migrations/2026_01_05_000005_create_project_tables.php | 286 | Drop operation في up() | Schema::dropIfExists('task_dependencies'); |
| HIGH | database/migrations/2026_01_05_000005_create_project_tables.php | 287 | Drop operation في up() | Schema::dropIfExists('project_tasks'); |
| HIGH | database/migrations/2026_01_05_000005_create_project_tables.php | 288 | Drop operation في up() | Schema::dropIfExists('project_milestones'); |
| HIGH | database/migrations/2026_01_05_000005_create_project_tables.php | 289 | Drop operation في up() | Schema::dropIfExists('projects'); |
| HIGH | database/migrations/2026_01_06_000001_create_ticket_tables.php | 230 | Drop operation في up() | Schema::dropIfExists('ticket_replies'); |
| HIGH | database/migrations/2026_01_06_000001_create_ticket_tables.php | 231 | Drop operation في up() | Schema::dropIfExists('tickets'); |
| HIGH | database/migrations/2026_01_06_000001_create_ticket_tables.php | 232 | Drop operation في up() | Schema::dropIfExists('ticket_categories'); |
| HIGH | database/migrations/2026_01_06_000001_create_ticket_tables.php | 233 | Drop operation في up() | Schema::dropIfExists('ticket_sla_policies'); |
| HIGH | database/migrations/2026_01_06_000001_create_ticket_tables.php | 234 | Drop operation في up() | Schema::dropIfExists('ticket_priorities'); |
| HIGH | database/migrations/2026_01_06_000002_create_document_tables.php | 262 | Drop operation في up() | Schema::dropIfExists('notes'); |
| HIGH | database/migrations/2026_01_06_000002_create_document_tables.php | 263 | Drop operation في up() | Schema::dropIfExists('media'); |
| HIGH | database/migrations/2026_01_06_000002_create_document_tables.php | 264 | Drop operation في up() | Schema::dropIfExists('attachments'); |
| HIGH | database/migrations/2026_01_06_000002_create_document_tables.php | 265 | Drop operation في up() | Schema::dropIfExists('document_activities'); |
| HIGH | database/migrations/2026_01_06_000002_create_document_tables.php | 266 | Drop operation في up() | Schema::dropIfExists('document_shares'); |
| HIGH | database/migrations/2026_01_06_000002_create_document_tables.php | 267 | Drop operation في up() | Schema::dropIfExists('document_versions'); |
| HIGH | database/migrations/2026_01_06_000002_create_document_tables.php | 268 | Drop operation في up() | Schema::dropIfExists('document_tag'); |
| HIGH | database/migrations/2026_01_06_000002_create_document_tables.php | 269 | Drop operation في up() | Schema::dropIfExists('documents'); |
| HIGH | database/migrations/2026_01_06_000002_create_document_tables.php | 270 | Drop operation في up() | Schema::dropIfExists('document_tags'); |
| HIGH | database/migrations/2026_01_06_000003_create_workflow_tables.php | 189 | Drop operation في up() | Schema::dropIfExists('workflow_notifications'); |
| HIGH | database/migrations/2026_01_06_000003_create_workflow_tables.php | 190 | Drop operation في up() | Schema::dropIfExists('workflow_audit_logs'); |
| HIGH | database/migrations/2026_01_06_000003_create_workflow_tables.php | 191 | Drop operation في up() | Schema::dropIfExists('workflow_approvals'); |
| HIGH | database/migrations/2026_01_06_000003_create_workflow_tables.php | 192 | Drop operation في up() | Schema::dropIfExists('workflow_instances'); |
| HIGH | database/migrations/2026_01_06_000003_create_workflow_tables.php | 193 | Drop operation في up() | Schema::dropIfExists('workflow_rules'); |
| HIGH | database/migrations/2026_01_06_000003_create_workflow_tables.php | 194 | Drop operation في up() | Schema::dropIfExists('workflow_definitions'); |
| HIGH | database/migrations/2026_01_06_000004_create_alert_tables.php | 224 | Drop operation في up() | Schema::dropIfExists('supplier_performance_metrics'); |
| HIGH | database/migrations/2026_01_06_000004_create_alert_tables.php | 225 | Drop operation في up() | Schema::dropIfExists('low_stock_alerts'); |
| HIGH | database/migrations/2026_01_06_000004_create_alert_tables.php | 226 | Drop operation في up() | Schema::dropIfExists('anomaly_baselines'); |
| HIGH | database/migrations/2026_01_06_000004_create_alert_tables.php | 227 | Drop operation في up() | Schema::dropIfExists('alert_recipients'); |
| HIGH | database/migrations/2026_01_06_000004_create_alert_tables.php | 228 | Drop operation في up() | Schema::dropIfExists('alert_instances'); |
| HIGH | database/migrations/2026_01_06_000004_create_alert_tables.php | 229 | Drop operation في up() | Schema::dropIfExists('alert_rules'); |
| HIGH | database/migrations/2026_01_07_000001_create_reporting_tables.php | 155 | Drop operation في up() | Schema::dropIfExists('export_layouts'); |
| HIGH | database/migrations/2026_01_07_000001_create_reporting_tables.php | 156 | Drop operation في up() | Schema::dropIfExists('saved_report_views'); |
| HIGH | database/migrations/2026_01_07_000001_create_reporting_tables.php | 157 | Drop operation في up() | Schema::dropIfExists('scheduled_reports'); |
| HIGH | database/migrations/2026_01_07_000001_create_reporting_tables.php | 158 | Drop operation في up() | Schema::dropIfExists('report_templates'); |
| HIGH | database/migrations/2026_01_07_000001_create_reporting_tables.php | 159 | Drop operation في up() | Schema::dropIfExists('report_definitions'); |
| HIGH | database/migrations/2026_01_07_000002_create_dashboard_tables.php | 122 | Drop operation في up() | Schema::dropIfExists('widget_data_cache'); |
| HIGH | database/migrations/2026_01_07_000002_create_dashboard_tables.php | 123 | Drop operation في up() | Schema::dropIfExists('user_dashboard_widgets'); |
| HIGH | database/migrations/2026_01_07_000002_create_dashboard_tables.php | 124 | Drop operation في up() | Schema::dropIfExists('user_dashboard_layouts'); |
| HIGH | database/migrations/2026_01_07_000002_create_dashboard_tables.php | 125 | Drop operation في up() | Schema::dropIfExists('dashboard_widgets'); |
| HIGH | database/migrations/2026_01_07_000003_create_user_activity_tables.php | 228 | Drop operation في up() | Schema::dropIfExists('activity_log'); |
| HIGH | database/migrations/2026_01_07_000003_create_user_activity_tables.php | 229 | Drop operation في up() | Schema::dropIfExists('audit_logs'); |
| HIGH | database/migrations/2026_01_07_000003_create_user_activity_tables.php | 230 | Drop operation في up() | Schema::dropIfExists('system_settings'); |
| HIGH | database/migrations/2026_01_07_000003_create_user_activity_tables.php | 231 | Drop operation في up() | Schema::dropIfExists('notifications'); |
| HIGH | database/migrations/2026_01_07_000003_create_user_activity_tables.php | 232 | Drop operation في up() | Schema::dropIfExists('search_index'); |
| HIGH | database/migrations/2026_01_07_000003_create_user_activity_tables.php | 233 | Drop operation في up() | Schema::dropIfExists('search_history'); |
| HIGH | database/migrations/2026_01_07_000003_create_user_activity_tables.php | 234 | Drop operation في up() | Schema::dropIfExists('login_activities'); |
| HIGH | database/migrations/2026_01_07_000003_create_user_activity_tables.php | 235 | Drop operation في up() | Schema::dropIfExists('user_sessions'); |
| HIGH | database/migrations/2026_01_07_000003_create_user_activity_tables.php | 236 | Drop operation في up() | Schema::dropIfExists('user_favorites'); |
| HIGH | database/migrations/2026_01_07_000003_create_user_activity_tables.php | 237 | Drop operation في up() | Schema::dropIfExists('user_preferences'); |
| HIGH | database/migrations/2026_01_07_000004_create_loyalty_installment_tables.php | 130 | Drop operation في up() | Schema::dropIfExists('installment_payments'); |
| HIGH | database/migrations/2026_01_07_000004_create_loyalty_installment_tables.php | 131 | Drop operation في up() | Schema::dropIfExists('installment_plans'); |
| HIGH | database/migrations/2026_01_07_000004_create_loyalty_installment_tables.php | 132 | Drop operation في up() | Schema::dropIfExists('loyalty_transactions'); |
| HIGH | database/migrations/2026_01_07_000004_create_loyalty_installment_tables.php | 133 | Drop operation في up() | Schema::dropIfExists('loyalty_settings'); |
| HIGH | database/migrations/2026_01_08_000001_create_laravel_framework_tables.php | 104 | Drop operation في up() | Schema::dropIfExists('personal_access_tokens'); |
| HIGH | database/migrations/2026_01_08_000001_create_laravel_framework_tables.php | 105 | Drop operation في up() | Schema::dropIfExists('password_reset_tokens'); |
| HIGH | database/migrations/2026_01_08_000001_create_laravel_framework_tables.php | 106 | Drop operation في up() | Schema::dropIfExists('failed_jobs'); |
| HIGH | database/migrations/2026_01_08_000001_create_laravel_framework_tables.php | 107 | Drop operation في up() | Schema::dropIfExists('job_batches'); |
| HIGH | database/migrations/2026_01_08_000001_create_laravel_framework_tables.php | 108 | Drop operation في up() | Schema::dropIfExists('jobs'); |
| HIGH | database/migrations/2026_01_08_000001_create_laravel_framework_tables.php | 109 | Drop operation في up() | Schema::dropIfExists('sessions'); |
| HIGH | database/migrations/2026_01_08_000001_create_laravel_framework_tables.php | 110 | Drop operation في up() | Schema::dropIfExists('cache_locks'); |
| HIGH | database/migrations/2026_01_08_000001_create_laravel_framework_tables.php | 111 | Drop operation في up() | Schema::dropIfExists('cache'); |
| HIGH | database/migrations/2026_01_09_000001_create_missing_tables.php | 306 | Drop operation في up() | $table->dropColumn(['department_id_fk', 'cost_center_id']); |
| HIGH | database/migrations/2026_01_09_000001_create_missing_tables.php | 313 | Drop operation في up() | Schema::dropIfExists('quote_items'); |
| HIGH | database/migrations/2026_01_09_000001_create_missing_tables.php | 314 | Drop operation في up() | Schema::dropIfExists('quotes'); |
| HIGH | database/migrations/2026_01_09_000001_create_missing_tables.php | 315 | Drop operation في up() | Schema::dropIfExists('wood_waste'); |
| HIGH | database/migrations/2026_01_09_000001_create_missing_tables.php | 316 | Drop operation في up() | Schema::dropIfExists('wood_conversions'); |
| HIGH | database/migrations/2026_01_09_000001_create_missing_tables.php | 317 | Drop operation في up() | Schema::dropIfExists('product_compatibility'); |
| HIGH | database/migrations/2026_01_09_000001_create_missing_tables.php | 318 | Drop operation في up() | Schema::dropIfExists('report_schedules'); |
| HIGH | database/migrations/2026_01_09_000001_create_missing_tables.php | 319 | Drop operation في up() | Schema::dropIfExists('cost_centers'); |
| HIGH | database/migrations/2026_01_09_000001_create_missing_tables.php | 320 | Drop operation في up() | Schema::dropIfExists('departments'); |
| HIGH | database/migrations/2026_01_10_000001_add_branch_id_to_branch_aware_tables.php | 92 | Drop operation في up() | $blueprint->dropColumn('branch_id'); |

# 6) Bugs جديدة / Bugs اتصلحت (v64 → v65)

## 6.1 Fixed in v65 (signals)
| Category | Count |
|---|---|
| Unscoped models | 0 |
| Unsafe exists | 0 |
| Livewire unauth methods | 0 |
| Blade raw outputs | 0 |

## 6.2 New in v65 (signals)
| Category | Count |
|---|---|
| Unscoped models | 0 |
| Unsafe exists | 0 |
| Livewire unauth methods | 0 |
| Blade raw outputs | 0 |

---

# 7) DoD (Definition of Done) لمنع Regression
| Axis | DoD |
|---|---|
| Tenancy | 0 models w/ branch_id unscoped + tests تمنع cross-branch by ID |
| Validations | 0 unsafe exists على branch-owned + Rule::exists()->where(branch_id) standard |
| Authorization | 0 Livewire mutation methods بدون authorize + 0 controller mutations بدون policy/gate |
| Finance | bcround policy locked + tests على positive/negative half ties |
| XSS | 0 `{!! !!}` أو sanitization/allow-list صريح + tests/linters |
| SQL | Raw SQL allow-list + parameter binding + tests على inputs |
| Guardrails | CI: phpstan/larastan + pint + phpunit feature tests |