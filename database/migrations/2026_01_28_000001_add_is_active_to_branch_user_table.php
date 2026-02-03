<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

/**
 * Add is_active to branch_user pivot
 *
 * Bugfix:
 * - branch_user pivot was used with wherePivot('is_active', true) in multiple places
 *   but the column did not exist.
 *
 * Notes:
 * - Default true so existing assignments remain valid.
 * - activated_at is optional metadata (useful for audit/UI) and is safe to ignore.
 */
return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasTable('branch_user')) {
            return;
        }

        if (Schema::hasColumn('branch_user', 'is_active')) {
            return;
        }

        Schema::table('branch_user', function (Blueprint $table): void {
            $table->boolean('is_active')->default(true)->after('user_id');
            $table->timestamp('activated_at')->nullable()->after('is_active');
            $table->index('is_active', 'idx_brusr_is_active');
        });

        // Backfill activated_at for existing rows (best-effort)
        try {
            DB::table('branch_user')
                ->whereNull('activated_at')
                ->update(['activated_at' => now()]);
        } catch (Throwable) {
            // Ignore for DBs that don't support now() casting or during limited migration contexts.
        }
    }

    public function down(): void
    {
        if (! Schema::hasTable('branch_user')) {
            return;
        }

        if (! Schema::hasColumn('branch_user', 'is_active')) {
            return;
        }

        Schema::table('branch_user', function (Blueprint $table): void {
            $table->dropIndex('idx_brusr_is_active');
            $table->dropColumn(['activated_at', 'is_active']);
        });
    }
};
