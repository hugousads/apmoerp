# Roadmap — ما لم يتم بعد

هذه القائمة تمثل **الأعمال المتبقية** بعد تطبيق إصلاحات Step 1 + Step 2 (التي موثقة في `docs/IMPLEMENTED.md`).

> ملاحظة: المشروع كبير، وتم تدقيق أقسام حساسة (Branches/Permissions + Banking/Inventory/Purchases/Exports/Reports)، لكن ما زال هناك نقاط تحتاج تدقيق/اختبارات أوسع لضمان عدم وجود تسريبات أو أخطاء منطقية في سيناريوهات متعددة.

---

## 1) اختبارات وتشغيل فعلي (QA)
- [ ] **Smoke tests** أساسية على بيئة تشغيل حقيقية:
  - تسجيل دخول: مستخدم فرع واحد / مستخدم view-all / Super Admin.
  - تغيير الفرع من الـ Branch Switcher ثم التنقل داخل Livewire navigate بدون أخطاء JS.
  - تجربة إنشاء/تعديل/حذف داخل:
    - Sales, Purchases, Inventory, Accounting, HR, Projects, Helpdesk.
- [ ] إضافة **Feature tests** للـ BranchScope + BranchContextManager (خصوصًا All Branches).
- [ ] إضافة **Regression tests** للأخطاء التي ظهرت مثل `Unexpected token '<'` (السبب عادة 500/TypeError).

## 2) تدقيق شامل لباقي Modules على Multi-Branch
> تم إصلاح Modules محددة في Step 2، لكن يُنصح بتدقيق باقي الصفحات التي تقوم بإنشاء بيانات branch-scoped.
- [ ] مراجعة كل Livewire Forms التي تنشئ Models عليها `HasBranch` للتأكد من وجود Guard عند All Branches.
- [ ] مراجعة كل الصفحات التي تستخدم `DB::table()` (بدون Eloquent) للتأكد من تطبيق فلتر branch عند الحاجة.
- [ ] مراجعة **Reports الأخرى** (غير SalesAnalytics) للتأكد أنها تعتمد على branch context وليس user->branch_id.

## 3) تحسينات Export/Import إضافية
- [ ] دعم تخزين ملفات التصدير على S3/remote disks (حاليًا ExportService يفترض disk محلي لأن الكود يعتمد على `path()` و `file_exists()`).
- [ ] تحسين التعامل مع الملفات الكبيرة (Streaming / Chunked reading) خصوصًا في الاستيراد.
- [ ] توحيد أسماء الأعمدة بين جميع الشاشات والـ ExportService بشكل كامل (فقط تم إصلاح الجزء الأكثر حساسية).

## 4) تحسينات UX داخل وضع All Branches
- [ ] تعطيل/إخفاء أزرار "إنشاء" في الصفحات التي تتطلب Branch محدد عندما يكون المستخدم على All Branches.
- [ ] عرض Banner واضح أعلى الصفحة يوضح: "أنت الآن على All Branches — اختر فرع لإجراء عمليات إنشاء".
- [ ] (اختياري) إضافة اختيار فرع داخل بعض النماذج (Admin-only) بدل الاعتماد فقط على الـ Branch Switcher.

## 5) أداء وCaching
- [ ] مراجعة أماكن الـ caching التي قد تعتمد على user->branch_id بدل branch context.
- [ ] إضافة cache keys قياسية باستخدام `branch_context_cache_key()` حيثما يناسب.

## 6) تنظيف وتحسينات عامة
- [ ] توحيد أسلوب الـ Layout Attributes (إما class-level دائمًا أو render-level دائمًا).
- [ ] إزالة/تجميع الـ TODOs القديمة أو تحويلها لTickets واضحة.
