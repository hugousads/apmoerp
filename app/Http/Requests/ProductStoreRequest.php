<?php

declare(strict_types=1);

namespace App\Http\Requests;

use App\Http\Requests\Traits\HasMultilingualValidation;
use App\Rules\BranchScopedExists;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProductStoreRequest extends FormRequest
{
    use HasMultilingualValidation;

    public function authorize(): bool
    {
        return $this->user()?->can('products.create') ?? false;
    }

    public function rules(): array
    {
        return [
            'name' => $this->multilingualString(required: true, max: 255),
            'sku' => [
                'nullable',
                'string',
                'max:100',
                Rule::unique('products', 'sku')->whereNull('deleted_at'),
            ],
            'barcode' => [
                'nullable',
                'string',
                'max:100',
                Rule::unique('products', 'barcode')->whereNull('deleted_at'),
            ],
            'default_price' => ['required', 'numeric', 'min:0'],
            'cost' => ['nullable', 'numeric', 'min:0'],
            'description' => $this->unicodeText(required: false),
            // V57-CRITICAL-03 FIX: Use BranchScopedExists to prevent cross-branch references
            'category_id' => ['nullable', new BranchScopedExists('product_categories', 'id', null, true)],
            'tax_id' => ['nullable', new BranchScopedExists('taxes', 'id', null, true)],
            // Inventory tracking fields
            'min_stock' => ['nullable', 'numeric', 'min:0'],
            'max_stock' => ['nullable', 'numeric', 'min:0'],
            'reorder_point' => ['nullable', 'numeric', 'min:0'],
            'lead_time_days' => ['nullable', 'numeric', 'min:0', 'max:9999.9'],
            'location_code' => $this->flexibleCode(required: false, max: 191),
        ];
    }
}
