<?php

declare(strict_types=1);

namespace App\Http\Requests;

use App\Http\Requests\Traits\HasMultilingualValidation;
use App\Rules\BranchScopedExists;
use Illuminate\Foundation\Http\FormRequest;

class UnitStoreRequest extends FormRequest
{
    use HasMultilingualValidation;

    public function authorize(): bool
    {
        return $this->user()?->can('rental.units.create') ?? false;
    }

    public function rules(): array
    {
        return [
            // V57-CRITICAL-03 FIX: Use BranchScopedExists to prevent cross-branch property references
            'property_id' => ['required', new BranchScopedExists('properties')],
            'code' => $this->flexibleCode(required: true, max: 100),
            'status' => ['sometimes', 'string'],
        ];
    }
}
