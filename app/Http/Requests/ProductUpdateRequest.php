<?php

declare(strict_types=1);

namespace App\Http\Requests;

use App\Http\Requests\Traits\HasMultilingualValidation;
use App\Rules\BranchScopedExists;
use Illuminate\Foundation\Http\FormRequest;

class ProductUpdateRequest extends FormRequest
{
    use HasMultilingualValidation;

    public function authorize(): bool
    {
        return $this->user()?->can('products.update') ?? false;
    }

    public function rules(): array
    {
        $product = $this->route('product'); // Model binding

        return [
            'name' => $this->multilingualString(required: false, max: 255), // 'sometimes' handled automatically
            'sku' => ['sometimes', 'string', 'max:100', 'unique:products,sku,'.$product?->id],
            'barcode' => ['sometimes', 'string', 'max:100', 'unique:products,barcode,'.$product?->id],
            'default_price' => ['sometimes', 'numeric', 'min:0'],
            'cost' => ['sometimes', 'numeric', 'min:0'],
            'description' => $this->unicodeText(required: false),
            // V57-CRITICAL-03 FIX: Use BranchScopedExists to prevent cross-branch references
            'category_id' => ['nullable', new BranchScopedExists('product_categories', 'id', null, true)],
            'tax_id' => ['nullable', new BranchScopedExists('taxes', 'id', null, true)],
            // Inventory tracking fields
            'min_stock' => ['sometimes', 'numeric', 'min:0'],
            'max_stock' => ['sometimes', 'numeric', 'min:0'],
            'reorder_point' => ['sometimes', 'numeric', 'min:0'],
            'lead_time_days' => ['sometimes', 'numeric', 'min:0', 'max:9999.9'],
            'location_code' => $this->flexibleCode(required: false, max: 191),
        ];
    }
}
