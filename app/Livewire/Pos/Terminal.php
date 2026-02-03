<?php

declare(strict_types=1);

namespace App\Livewire\Pos;

use App\Models\Branch;
use App\Models\Currency;
use App\Services\BranchContextManager;
use App\Services\CurrencyService;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('layouts.app')]
class Terminal extends Component
{
    public int $branchId;

    public string $branchName = '';

    /**
     * Indicates the authenticated user can view/switch all branches.
     */
    public bool $canViewAllBranches = false;

    protected CurrencyService $currencyService;

    protected array $rateCache = [];

    public function boot(CurrencyService $currencyService): void
    {
        $this->currencyService = $currencyService;
    }

    public function mount(): void
    {
        $user = Auth::user();
        if (! $user || ! $user->can('pos.use')) {
            abort(403);
        }

        $this->canViewAllBranches = BranchContextManager::canViewAllBranches($user);

        // IMPORTANT: POS is a write-heavy module. It must never operate in an "All Branches" context.
        // Always resolve the effective branch from the current branch context (Branch Switcher).
        $this->branchId = (int) (current_branch_id() ?? 0);

        if ($this->branchId === 0) {
            // Non-privileged users MUST have a branch assignment.
            if (! $this->canViewAllBranches) {
                abort(403, __('You must be assigned to a branch to use the POS terminal.'));
            }

            // Privileged users: tell them to select a branch first.
            abort(403, __('Please select a branch from the branch switcher before using the POS terminal.'));
        }

        $branch = Branch::find($this->branchId);
        $this->branchName = $branch?->name ?? __('Branch not found');
    }

    public function render()
    {
        $currencies = Currency::active()->ordered()->get();
        $baseCurrencyModel = $currencies->firstWhere('is_base', true);
        $baseCurrency = $baseCurrencyModel?->code ?? 'EGP';

        $currencyData = [];
        $currencySymbols = [];
        $currencyRates = [$baseCurrency => 1.0];
        $targetCurrencies = $currencies->where('is_base', false)->pluck('code')->all();
        $this->rateCache = $this->rateCache ?: $this->currencyService->getRatesFor($baseCurrency, $targetCurrencies);

        foreach ($currencies as $currency) {
            $currencyData[$currency->code] = [
                'name' => $currency->name,
                'name_ar' => $currency->name_ar,
                'symbol' => $currency->symbol,
                'is_base' => $currency->is_base,
            ];
            $currencySymbols[$currency->code] = $currency->symbol;

            if (! $currency->is_base) {
                $rate = $this->rateCache[$currency->code] ?? null;
                $currencyRates[$currency->code] = $rate ?? 1.0;
            }
        }

        return view('livewire.pos.terminal', [
            'branchId' => $this->branchId,
            'branchName' => $this->branchName,
            'currencies' => $currencies,
            'currencyData' => $currencyData,
            'currencySymbols' => $currencySymbols,
            'currencyRates' => $currencyRates,
            'baseCurrency' => $baseCurrency,
        ]);
    }
}
