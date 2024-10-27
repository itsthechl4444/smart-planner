<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;
use App\Models\Task;
use App\Models\Label;
use App\Models\Project;
use App\Models\ProjectTask;
use App\Models\Account;
use App\Models\Income;
use App\Models\Expense;
use App\Models\Debt;
use App\Models\Budget;
use App\Models\Saving;
use App\Policies\TaskPolicy;
use App\Policies\LabelPolicy;
use App\Policies\ProjectPolicy;
use App\Policies\ProjectTaskPolicy;
use App\Policies\AccountPolicy;
use App\Policies\IncomePolicy;
use App\Policies\ExpensePolicy;
use App\Policies\DebtPolicy;
use App\Policies\BudgetPolicy;
use App\Policies\SavingPolicy;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        Task::class => TaskPolicy::class,
        Label::class => LabelPolicy::class,
        Project::class => ProjectPolicy::class,
        ProjectTask::class => ProjectTaskPolicy::class,
         Account::class => AccountPolicy::class,
          'App\Models\Expense' => 'App\Policies\ExpensePolicy',
            Income::class => IncomePolicy::class,
            Debt::class => DebtPolicy::class,
             Budget::class => BudgetPolicy::class,
             Saving::class => SavingPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot()
    {
        $this->registerPolicies();

        // Additional authorization gates can be defined here
    }
    
}


