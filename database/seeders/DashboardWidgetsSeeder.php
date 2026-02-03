<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\DashboardWidget;
use Illuminate\Database\Seeder;

/**
 * DashboardWidgetsSeeder
 *
 * Seeds a minimal, opinionated widget catalog for the database-driven
 * dashboard widget system (dashboard_widgets table).
 *
 * This is separate from the hardcoded CustomizableDashboard widgets,
 * but is required for the Widget Catalog / Widget Service layer.
 */
class DashboardWidgetsSeeder extends Seeder
{
    public function run(): void
    {
        $widgets = [
            // Sales
            [
                'widget_key' => 'sales_today',
                'name' => "Today's Sales",
                'name_ar' => 'مبيعات اليوم',
                'description' => 'Total sales for today.',
                'component' => 'dashboard.widgets.sales-today',
                'icon' => '💰',
                'category' => 'sales',
                'default_settings' => [],
                'configurable_options' => [],
                'default_width' => 3,
                'default_height' => 2,
                'min_width' => 2,
                'min_height' => 2,
                'requires_permission' => true,
                'permission_key' => 'sales.view',
                'is_active' => true,
                'sort_order' => 10,
            ],
            [
                'widget_key' => 'sales_this_week',
                'name' => 'Sales This Week',
                'name_ar' => 'مبيعات هذا الأسبوع',
                'description' => 'Total sales for the current week.',
                'component' => 'dashboard.widgets.sales-week',
                'icon' => '📈',
                'category' => 'sales',
                'default_settings' => [],
                'configurable_options' => [],
                'default_width' => 3,
                'default_height' => 2,
                'min_width' => 2,
                'min_height' => 2,
                'requires_permission' => true,
                'permission_key' => 'sales.view',
                'is_active' => true,
                'sort_order' => 20,
            ],
            [
                'widget_key' => 'sales_this_month',
                'name' => 'Sales This Month',
                'name_ar' => 'مبيعات هذا الشهر',
                'description' => 'Total sales for the current month.',
                'component' => 'dashboard.widgets.sales-month',
                'icon' => '🗓️',
                'category' => 'sales',
                'default_settings' => [],
                'configurable_options' => [],
                'default_width' => 3,
                'default_height' => 2,
                'min_width' => 2,
                'min_height' => 2,
                'requires_permission' => true,
                'permission_key' => 'sales.view',
                'is_active' => true,
                'sort_order' => 30,
            ],
            [
                'widget_key' => 'revenue_month',
                'name' => 'Monthly Revenue',
                'name_ar' => 'إيراد الشهر',
                'description' => 'Revenue (completed) for the current month.',
                'component' => 'dashboard.widgets.revenue-month',
                'icon' => '🏦',
                'category' => 'sales',
                'default_settings' => [],
                'configurable_options' => [],
                'default_width' => 3,
                'default_height' => 2,
                'min_width' => 2,
                'min_height' => 2,
                'requires_permission' => true,
                'permission_key' => 'sales.view',
                'is_active' => true,
                'sort_order' => 40,
            ],

            // Inventory
            [
                'widget_key' => 'total_products',
                'name' => 'Total Products',
                'name_ar' => 'إجمالي المنتجات',
                'description' => 'Total number of products.',
                'component' => 'dashboard.widgets.total-products',
                'icon' => '📦',
                'category' => 'inventory',
                'default_settings' => [],
                'configurable_options' => [],
                'default_width' => 3,
                'default_height' => 2,
                'min_width' => 2,
                'min_height' => 2,
                'requires_permission' => true,
                'permission_key' => 'inventory.products.view',
                'is_active' => true,
                'sort_order' => 50,
            ],
            [
                'widget_key' => 'low_stock',
                'name' => 'Low Stock Alerts',
                'name_ar' => 'تنبيهات نقص المخزون',
                'description' => 'Count of products at or below minimum stock.',
                'component' => 'dashboard.widgets.low-stock',
                'icon' => '⚠️',
                'category' => 'inventory',
                'default_settings' => [],
                'configurable_options' => [],
                'default_width' => 3,
                'default_height' => 2,
                'min_width' => 2,
                'min_height' => 2,
                'requires_permission' => true,
                'permission_key' => 'inventory.products.view',
                'is_active' => true,
                'sort_order' => 60,
            ],

            // Customers
            [
                'widget_key' => 'total_customers',
                'name' => 'Total Customers',
                'name_ar' => 'إجمالي العملاء',
                'description' => 'Total number of customers.',
                'component' => 'dashboard.widgets.total-customers',
                'icon' => '👥',
                'category' => 'customers',
                'default_settings' => [],
                'configurable_options' => [],
                'default_width' => 3,
                'default_height' => 2,
                'min_width' => 2,
                'min_height' => 2,
                'requires_permission' => true,
                'permission_key' => 'customers.view',
                'is_active' => true,
                'sort_order' => 70,
            ],

            // Orders
            [
                'widget_key' => 'pending_orders',
                'name' => 'Pending Orders',
                'name_ar' => 'الطلبات المعلقة',
                'description' => 'Count of pending sales orders.',
                'component' => 'dashboard.widgets.pending-orders',
                'icon' => '🧾',
                'category' => 'sales',
                'default_settings' => [],
                'configurable_options' => [],
                'default_width' => 3,
                'default_height' => 2,
                'min_width' => 2,
                'min_height' => 2,
                'requires_permission' => true,
                'permission_key' => 'sales.view',
                'is_active' => true,
                'sort_order' => 80,
            ],
        ];

        foreach ($widgets as $data) {
            DashboardWidget::updateOrCreate(
                ['widget_key' => $data['widget_key']],
                $data
            );
        }
    }
}
