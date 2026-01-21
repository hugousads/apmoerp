<?php

declare(strict_types=1);

namespace App\Http\Requests;

use App\Rules\BranchScopedExists;
use Illuminate\Foundation\Http\FormRequest;

class TicketStoreRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()->can('helpdesk.create');
    }

    public function rules(): array
    {
        $branchId = $this->user()?->branch_id;

        return [
            'subject' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string'],
            // V58-CRITICAL-02 FIX: Use BranchScopedExists for branch-aware validation
            'customer_id' => ['nullable', new BranchScopedExists('customers', 'id', $branchId, allowNull: true)],
            'category_id' => ['nullable', 'exists:ticket_categories,id'],
            'priority' => ['nullable', 'exists:ticket_priorities,id'],
            'assigned_to' => ['nullable', 'exists:users,id'],
            'sla_policy_id' => ['nullable', 'exists:ticket_sla_policies,id'],
            'due_date' => ['nullable', 'date', 'after:now'],
            'tags' => ['nullable', 'array'],
            'tags.*' => ['string', 'max:50'],
            'branch_id' => ['nullable', 'exists:branches,id'],
        ];
    }

    public function messages(): array
    {
        return [
            'subject.required' => __('Ticket subject is required'),
            'description.required' => __('Ticket description is required'),
            'customer_id.exists' => __('Selected customer does not exist'),
            'category_id.exists' => __('Selected category does not exist'),
            'priority.exists' => __('Selected priority does not exist'),
            'assigned_to.exists' => __('Selected agent does not exist'),
            'due_date.after' => __('Due date must be in the future'),
        ];
    }

    protected function prepareForValidation(): void
    {
        // Set created_by
        $this->merge([
            'created_by' => $this->user()->id,
        ]);

        // Set branch_id if not provided
        if (! $this->has('branch_id') && $this->user()->branch_id) {
            $this->merge([
                'branch_id' => $this->user()->branch_id,
            ]);
        }

        // Set default status
        if (! $this->has('status')) {
            $this->merge([
                'status' => 'new',
            ]);
        }
    }
}
