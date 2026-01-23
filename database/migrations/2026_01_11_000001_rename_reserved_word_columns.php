<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Migration: Rename reserved word columns for MySQL 8.4 compatibility
 *
 * MySQL 8.4 reserves these words: KEY, ORDER, DEFAULT, CONDITION, GROUP
 * This migration renames affected columns to avoid conflicts.
 *
 * @see https://dev.mysql.com/doc/refman/8.4/en/keywords.html
 */
return new class extends Migration
{
    public function up(): void
    {
        // Rename 'key' to 'module_key' in modules table
        Schema::table('modules', function (Blueprint $table) {
            $table->renameColumn('key', 'module_key');
        });

        // Rename 'order' to 'sort_order' and 'default' to 'default_value' in module_fields table
        Schema::table('module_fields', function (Blueprint $table) {
            $table->renameColumn('order', 'sort_order');
            $table->renameColumn('default', 'default_value');
        });

        // Rename 'condition' to 'item_condition' in sales_return_items table
        Schema::table('sales_return_items', function (Blueprint $table) {
            $table->renameColumn('condition', 'item_condition');
        });

        // Rename 'condition' to 'item_condition' in purchase_return_items table
        Schema::table('purchase_return_items', function (Blueprint $table) {
            $table->renameColumn('condition', 'item_condition');
        });

        // Rename 'key' to 'template_key' in report_templates table
        Schema::table('report_templates', function (Blueprint $table) {
            $table->renameColumn('key', 'template_key');
        });

        // Rename 'key' to 'widget_key' in dashboard_widgets table
        Schema::table('dashboard_widgets', function (Blueprint $table) {
            $table->renameColumn('key', 'widget_key');
        });

        // Rename 'key' to 'setting_key' and 'group' to 'setting_group' in system_settings table
        // Also need to drop and recreate the index on 'group'
        Schema::table('system_settings', function (Blueprint $table) {
            $table->dropIndex('idx_sysset_group');
        });

        Schema::table('system_settings', function (Blueprint $table) {
            $table->renameColumn('key', 'setting_key');
            $table->renameColumn('group', 'setting_group');
        });

        Schema::table('system_settings', function (Blueprint $table) {
            $table->index('setting_group', 'idx_sysset_setting_group');
        });
    }

    public function down(): void
    {
        // Revert system_settings changes
        Schema::table('system_settings', function (Blueprint $table) {
            $table->dropIndex('idx_sysset_setting_group');
        });

        Schema::table('system_settings', function (Blueprint $table) {
            $table->renameColumn('setting_key', 'key');
            $table->renameColumn('setting_group', 'group');
        });

        Schema::table('system_settings', function (Blueprint $table) {
            $table->index('group', 'idx_sysset_group');
        });

        // Revert dashboard_widgets changes
        Schema::table('dashboard_widgets', function (Blueprint $table) {
            $table->renameColumn('widget_key', 'key');
        });

        // Revert report_templates changes
        Schema::table('report_templates', function (Blueprint $table) {
            $table->renameColumn('template_key', 'key');
        });

        // Revert purchase_return_items changes
        Schema::table('purchase_return_items', function (Blueprint $table) {
            $table->renameColumn('item_condition', 'condition');
        });

        // Revert sales_return_items changes
        Schema::table('sales_return_items', function (Blueprint $table) {
            $table->renameColumn('item_condition', 'condition');
        });

        // Revert module_fields changes
        Schema::table('module_fields', function (Blueprint $table) {
            $table->renameColumn('sort_order', 'order');
            $table->renameColumn('default_value', 'default');
        });

        // Revert modules changes
        Schema::table('modules', function (Blueprint $table) {
            $table->renameColumn('module_key', 'key');
        });
    }
};
