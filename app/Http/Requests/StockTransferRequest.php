<?php

declare(strict_types=1);

namespace App\Http\Requests;

use App\Rules\BranchScopedExists;
use Illuminate\Foundation\Http\FormRequest;

class StockTransferRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->can('stock.transfer') ?? false;
    }

    public function rules(): array
    {
        $branchId = $this->user()?->branch_id;

        return [
            // V58-CRITICAL-02 FIX: Use BranchScopedExists for branch-aware validation
            'product_id' => ['required', 'integer', new BranchScopedExists('products', 'id', $branchId)],
            'qty' => ['required', 'numeric', 'gt:0'],
            'from_warehouse' => ['required', 'integer', new BranchScopedExists('warehouses', 'id', $branchId)],
            'to_warehouse' => ['required', 'integer', 'different:from_warehouse', new BranchScopedExists('warehouses', 'id', $branchId)],
        ];
    }
}
