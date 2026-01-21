<?php

declare(strict_types=1);

namespace App\Http\Requests;

use App\Rules\BranchScopedExists;
use Illuminate\Foundation\Http\FormRequest;

class BankTransactionRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()->can('banking.create');
    }

    public function rules(): array
    {
        $branchId = $this->user()?->branch_id;

        return [
            // V58-CRITICAL-02 FIX: Use BranchScopedExists for branch-aware validation
            'bank_account_id' => ['required', new BranchScopedExists('bank_accounts', 'id', $branchId)],
            'transaction_date' => ['required', 'date'],
            'type' => ['required', 'in:deposit,withdrawal,transfer'],
            'amount' => ['required', 'numeric', 'min:0.01'],
            'reference_number' => ['nullable', 'string', 'max:100'],
            'description' => ['nullable', 'string'],
            'category' => ['nullable', 'string', 'max:100'],
            'to_account_id' => ['nullable', 'required_if:type,transfer', new BranchScopedExists('bank_accounts', 'id', $branchId, allowNull: true)],
            'status' => ['required', 'in:pending,completed,cancelled'],
        ];
    }

    protected function prepareForValidation(): void
    {
        $type = $this->input('type') ?? $this->input('transaction_type');

        if ($type !== null) {
            $this->merge(['type' => $type]);
        }

        if (! $this->has('status')) {
            $this->merge([
                'status' => 'completed',
            ]);
        }
    }
}
