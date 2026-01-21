<?php

declare(strict_types=1);

namespace App\Http\Requests;

use App\Rules\BranchScopedExists;
use Illuminate\Foundation\Http\FormRequest;

class StockAdjustRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->can('stock.adjust') ?? false;
    }

    public function rules(): array
    {
        $branchId = $this->user()?->branch_id;

        return [
            // V58-CRITICAL-02 FIX: Use BranchScopedExists for branch-aware validation
            'product_id' => ['required', 'integer', new BranchScopedExists('products', 'id', $branchId)],
            'qty' => ['required', 'numeric', 'not_in:0'],
            'warehouse_id' => ['nullable', 'integer', new BranchScopedExists('warehouses', 'id', $branchId, allowNull: true)],
            'note' => ['nullable', 'string', 'max:255'],
        ];
    }
}
