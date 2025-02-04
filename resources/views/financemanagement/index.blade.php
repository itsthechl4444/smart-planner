<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Meta and Title -->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Finance Management</title>

    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- External Stylesheets -->
    <link rel="stylesheet" href="{{ asset('css/financemanagement.css') }}">
    <link rel="stylesheet" href="{{ asset('css/sidebar.css') }}">

    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.10.3/font/bootstrap-icons.min.css">

    <!-- Material Icons -->
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons+Outlined" rel="stylesheet">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>
<body>
    <!-- Header -->
    <header class="header" role="banner">
        <!-- Toggle Sidebar Button -->
        <button class="menu-icon btn btn-link" id="menu-icon" aria-label="Toggle Sidebar" title="Toggle Sidebar" data-bs-toggle="tooltip" data-bs-placement="bottom">
            <i class="bi bi-list"></i>
        </button>
        <div class="title">Finance Management</div>
    </header>

    @include('partials.sidebar')

    <!-- Main Content -->
    <main class="main-content">
        <!-- Container for Smart Insights (new smart features messages) -->
        <div id="finance-insights" class="mb-4" aria-live="polite"></div>

        <!-- Global Search Bar -->
        <div class="global-search">
            <div class="task-search">
                <i class="bi bi-search search-icon" aria-hidden="true"></i>
                <input type="text" id="finance-search-input" placeholder="Search Finance Records..." aria-label="Search Finance Records" />
                <!-- Clear Search Button -->
                <button type="button" class="btn btn-link clear-search" id="clear-search" aria-label="Clear Search" title="Clear Search" data-bs-toggle="tooltip" data-bs-placement="right">
                    <i class="bi bi-x-circle-fill" aria-hidden="true"></i>
                </button>
            </div>
        </div>

        <!-- Search Results Section -->
        <div id="search-results" class="search-results tab-content" style="display: none;">
            <h2>Search Results</h2>
            <div class="search-cards"></div>
            <div class="nothing-here" id="no-search-results" style="display: none;">
                <img src="{{ asset('images/empty.svg') }}" alt="No results found" class="no-data-illustration" data-bs-toggle="tooltip" data-bs-placement="top" title="No results match your search.">
                <p>No records match your search.</p>
            </div>
        </div>

        <!-- Tabs Section -->
        <div class="tabs" role="tablist">
            <button class="tab-link active" onclick="openTab(event, 'accounts')" role="tab" aria-selected="true" aria-controls="accounts" aria-label="Accounts" title="View Accounts" data-bs-toggle="tooltip" data-bs-placement="top">
                <span class="material-icons-outlined tab-icon" aria-hidden="true">account_balance</span>
                Accounts
            </button>
            <button class="tab-link" onclick="openTab(event, 'income')" role="tab" aria-selected="false" aria-controls="income" aria-label="Income" title="View Income" data-bs-toggle="tooltip" data-bs-placement="top">
                <span class="material-icons-outlined tab-icon" aria-hidden="true">attach_money</span>
                Income
            </button>
            <button class="tab-link" onclick="openTab(event, 'expenses')" role="tab" aria-selected="false" aria-controls="expenses" aria-label="Expenses" title="View Expenses" data-bs-toggle="tooltip" data-bs-placement="top">
                <span class="material-icons-outlined tab-icon" aria-hidden="true">money_off</span>
                Expenses
            </button>
            <button class="tab-link" onclick="openTab(event, 'debts')" role="tab" aria-selected="false" aria-controls="debts" aria-label="Debts" title="View Debts" data-bs-toggle="tooltip" data-bs-placement="top">
                <span class="material-icons-outlined tab-icon" aria-hidden="true">credit_card</span>
                Debts
            </button>
            <button class="tab-link" onclick="openTab(event, 'savings')" role="tab" aria-selected="false" aria-controls="savings" aria-label="Savings" title="View Savings" data-bs-toggle="tooltip" data-bs-placement="top">
                <span class="material-icons-outlined tab-icon" aria-hidden="true">savings</span>
                Savings
            </button>
            <button class="tab-link" onclick="openTab(event, 'budgets')" role="tab" aria-selected="false" aria-controls="budgets" aria-label="Budgets" title="View Budgets" data-bs-toggle="tooltip" data-bs-placement="top">
                <span class="material-icons-outlined tab-icon" aria-hidden="true">bar_chart</span>
                Budgets
            </button>
        </div>

        <!-- Accounts Section -->
        <div id="accounts" class="tab-content active" role="tabpanel" aria-labelledby="accounts">
            <!-- Minimal Desktop "New Account" -->
            <div class="new-item desktop-only" data-bs-toggle="modal" data-bs-target="#createAccountModal"
                 role="button" tabindex="0" aria-label="Add New Account" title="Add New Account">
                <span class="material-icons-outlined">add</span> New Account
            </div>

            <div class="account-cards">
                @if ($accounts->isEmpty())
                    <div class="nothing-here" id="no-accounts-message" style="display: flex;" data-bs-toggle="tooltip" data-bs-placement="top" title="No accounts have been created yet.">
                        <img src="{{ asset('images/accounts.png') }}" alt="No accounts yet" class="no-data-illustration">
                        <p>No accounts yet.</p>
                    </div>
                @else
                    @foreach($accounts as $account)
                        <div class="card account-card"
                            data-account-id="{{ $account->id }}"
                            data-account-url="{{ route('accounts.show', $account->id) }}"
                            role="button"
                            tabindex="0"
                            aria-label="View Account: {{ $account->name }}"
                            title="View Account: {{ $account->name }}" data-bs-toggle="tooltip" data-bs-placement="top">
                            <div class="card-content">
                                <div class="account-info">
                                    <span class="card-title">{{ $account->name }}</span>
                                    <p>Balance: {{ number_format($account->balance, 2) }} {{ $account->currency }}</p>
                                </div>
                            </div>
                        </div>
                    @endforeach
                    <div class="view-all-link" id="view-all-accounts-link" style="display: block;">
                        <a href="{{ route('accounts.index') }}" aria-label="View All Accounts" title="View All Accounts" data-bs-toggle="tooltip" data-bs-placement="top">View All Accounts</a>
                    </div>
                @endif
            </div>
        </div>

        <!-- Income Section -->
        <div id="income" class="tab-content" style="display: none;" role="tabpanel" aria-labelledby="income">
            <!-- Minimal Desktop "New Income" -->
            <div class="new-item desktop-only" data-bs-toggle="modal" data-bs-target="#createIncomeModal"
                 role="button" tabindex="0" aria-label="Add New Income" title="Add New Income">
                <span class="material-icons-outlined">add</span> New Income
            </div>

            <div class="income-cards">
                @if ($incomes->isEmpty())
                    <div class="nothing-here" id="no-income-message" style="display: flex;" data-bs-toggle="tooltip" data-bs-placement="top" title="No income records have been added yet.">
                        <img src="{{ asset('images/incomes.png') }}" alt="No income records yet" class="no-data-illustration">
                        <p>No income records yet.</p>
                    </div>
                @else
                    @foreach($incomes as $income)
                        <div class="card income-card"
                            data-income-id="{{ $income->id }}"
                            data-income-url="{{ route('incomes.show', $income->id) }}"
                            role="button"
                            tabindex="0"
                            aria-label="View Income: {{ $income->source_name }}"
                            title="View Income: {{ $income->source_name }}" data-bs-toggle="tooltip" data-bs-placement="top">
                            <div class="card-content">
                                <div class="income-info">
                                    <span class="card-title">{{ $income->source_name }}</span>
                                    <p>Amount: {{ number_format($income->amount, 2) }}</p>
                                    <p>Date: {{ \Carbon\Carbon::parse($income->date)->format('Y-m-d') }}</p>
                                </div>
                            </div>
                        </div>
                    @endforeach
                    <div class="view-all-link" id="view-all-income-link" style="display: block;">
                        <a href="{{ route('incomes.index') }}" aria-label="View All Income" title="View All Income" data-bs-toggle="tooltip" data-bs-placement="top">View All Income</a>
                    </div>
                @endif
            </div>
        </div>

        <!-- Expenses Section -->
        <div id="expenses" class="tab-content" style="display: none;" role="tabpanel" aria-labelledby="expenses">
            <!-- Minimal Desktop "New Expense" -->
            <div class="new-item desktop-only" data-bs-toggle="modal" data-bs-target="#createExpenseModal"
                 role="button" tabindex="0" aria-label="Add New Expense" title="Add New Expense">
                <span class="material-icons-outlined">add</span> New Expense
            </div>

            <div class="expense-cards">
                @if ($expenses->isEmpty())
                    <div class="nothing-here" id="no-expenses-message" style="display: flex;" data-bs-toggle="tooltip" data-bs-placement="top" title="No expense records have been added yet.">
                        <img src="{{ asset('images/expenses.png') }}" alt="No expenses yet" class="no-data-illustration">
                        <p>No expense records yet.</p>
                    </div>
                @else
                    @foreach($expenses as $expense)
                        <div class="card expense-card"
                            data-expense-id="{{ $expense->id }}"
                            data-expense-url="{{ route('expenses.show', $expense->id) }}"
                            role="button"
                            tabindex="0"
                            aria-label="View Expense: {{ $expense->name }}"
                            title="View Expense: {{ $expense->name }}" data-bs-toggle="tooltip" data-bs-placement="top">
                            <div class="card-content">
                                <div class="expense-info">
                                    <span class="card-title">{{ $expense->name }}</span>
                                    <p>Amount: {{ number_format($expense->amount, 2) }}</p>
                                    <p>Date: {{ \Carbon\Carbon::parse($expense->date)->format('Y-m-d') }}</p>
                                </div>
                            </div>
                        </div>
                    @endforeach
                    <div class="view-all-link" id="view-all-expenses-link" style="display: block;">
                        <a href="{{ route('expenses.index') }}" aria-label="View All Expenses" title="View All Expenses" data-bs-toggle="tooltip" data-bs-placement="top">View All Expenses</a>
                    </div>
                @endif
            </div>
        </div>

        <!-- Debts Section -->
        <div id="debts" class="tab-content" style="display: none;" role="tabpanel" aria-labelledby="debts">
            <!-- Minimal Desktop "New Debt" -->
            <div class="new-item desktop-only" data-bs-toggle="modal" data-bs-target="#createDebtModal"
                 role="button" tabindex="0" aria-label="Add New Debt" title="Add New Debt">
                <span class="material-icons-outlined">add</span> New Debt
            </div>

            <div class="debt-cards">
                @if ($debts->isEmpty())
                    <div class="nothing-here" id="no-debts-message" style="display: flex;" data-bs-toggle="tooltip" data-bs-placement="top" title="No debt records have been added yet.">
                        <img src="{{ asset('images/debts.png') }}" alt="No debt records yet" class="no-data-illustration">
                        <p>No debt records yet.</p>
                    </div>
                @else
                    @foreach($debts as $debt)
                        <div class="card debt-card"
                            data-debt-id="{{ $debt->id }}"
                            data-debt-url="{{ route('debts.show', $debt->id) }}"
                            role="button"
                            tabindex="0"
                            aria-label="View Debt: {{ $debt->name }}"
                            title="View Debt: {{ $debt->name }}" data-bs-toggle="tooltip" data-bs-placement="top">
                            <div class="card-content">
                                <div class="debt-info">
                                    <span class="card-title">{{ $debt->name }}</span>
                                    <p>Amount: {{ number_format($debt->amount, 2) }}</p>
                                    <p>Due Date: {{ \Carbon\Carbon::parse($debt->due_date)->format('Y-m-d') }}</p>
                                </div>
                            </div>
                        </div>
                    @endforeach
                    <div class="view-all-link" id="view-all-debts-link" style="display: block;">
                        <a href="{{ route('debts.index') }}" aria-label="View All Debts" title="View All Debts" data-bs-toggle="tooltip" data-bs-placement="top">View All Debts</a>
                    </div>
                @endif
            </div>
        </div>

        <!-- Savings Section -->
        <div id="savings" class="tab-content" style="display: none;" role="tabpanel" aria-labelledby="savings">
            <!-- Minimal Desktop "New Saving" -->
            <div class="new-item desktop-only" data-bs-toggle="modal" data-bs-target="#createSavingModal"
                 role="button" tabindex="0" aria-label="Add New Saving" title="Add New Saving">
                <span class="material-icons-outlined">add</span> New Saving
            </div>

            <div class="saving-cards">
                @if ($savings->isEmpty())
                    <div class="nothing-here" id="no-savings-message" style="display: flex;" data-bs-toggle="tooltip" data-bs-placement="top" title="No savings records have been added yet.">
                        <img src="{{ asset('images/savings.png') }}" alt="No savings records yet" class="no-data-illustration">
                        <p>No savings records yet.</p>
                    </div>
                @else
                    @foreach($savings as $saving)
                        <div class="card saving-card"
                            data-saving-id="{{ $saving->id }}"
                            data-saving-url="{{ route('savings.show', $saving->id) }}"
                            role="button"
                            tabindex="0"
                            aria-label="View Saving: {{ $saving->name }}"
                            title="View Saving: {{ $saving->name }}" data-bs-toggle="tooltip" data-bs-placement="top">
                            <div class="card-content">
                                <div class="saving-info">
                                    <span class="card-title">{{ $saving->name }}</span>
                                    <p>Desired Amount: {{ number_format($saving->desired_amount, 2) }} {{ $saving->currency }}</p>
                                    <p>Amount Saved: {{ number_format($saving->total_saved, 2) }} {{ $saving->currency }}</p>
                                    <p>Desired Date:
                                        @if($saving->desired_date)
                                            {{ \Carbon\Carbon::parse($saving->desired_date)->format('Y-m-d') }}
                                        @else
                                            Not Set
                                        @endif
                                    </p>
                                </div>
                            </div>
                        </div>
                    @endforeach
                    <div class="view-all-link" id="view-all-savings-link" style="display: block;">
                        <a href="{{ route('savings.index') }}" aria-label="View All Savings" title="View All Savings" data-bs-toggle="tooltip" data-bs-placement="top">View All Savings</a>
                    </div>
                @endif
            </div>
        </div>

        <!-- Budgets Section -->
        <div id="budgets" class="tab-content" style="display: none;" role="tabpanel" aria-labelledby="budgets">
            <!-- Minimal Desktop "New Budget" -->
            <div class="new-item desktop-only" data-bs-toggle="modal" data-bs-target="#createBudgetModal"
                 role="button" tabindex="0" aria-label="Add New Budget" title="Add New Budget">
                <span class="material-icons-outlined">add</span> New Budget
            </div>

            <div class="budget-cards">
                @if ($budgets->isEmpty())
                    <div class="nothing-here" id="no-budgets-message" style="display: flex;" data-bs-toggle="tooltip" data-bs-placement="top" title="No budget records have been added yet.">
                        <img src="{{ asset('images/budgets.png') }}" alt="No budget records yet" class="no-data-illustration">
                        <p>No budget records yet.</p>
                    </div>
                @else
                    @foreach($budgets as $budget)
                        <div class="card budget-card"
                            data-budget-id="{{ $budget->id }}"
                            data-budget-url="{{ route('budgets.show', $budget->id) }}"
                            role="button"
                            tabindex="0"
                            aria-label="View Budget: {{ $budget->name }}"
                            title="View Budget: {{ $budget->name }}" data-bs-toggle="tooltip" data-bs-placement="top">
                            <div class="card-content">
                                <div class="budget-info">
                                    <span class="card-title">{{ $budget->name }}</span>
                                    <p>Amount: {{ number_format($budget->amount, 2) }}</p>
                                    <p>Remaining: {{ number_format($budget->amount - $budget->spent, 2) }}</p>
                                </div>
                            </div>
                        </div>
                    @endforeach
                    <div class="view-all-link" id="view-all-budgets-link" style="display: block;">
                        <a href="{{ route('budgets.index') }}" aria-label="View All Budgets" title="View All Budgets" data-bs-toggle="tooltip" data-bs-placement="top">View All Budgets</a>
                    </div>
                @endif
            </div>
            <div class="bottom-space"></div>
        </div>
    </main>

    <!-- Floating Action Button (Mobile-Only) -->
    <div class="fab" id="fab" role="button" aria-label="Add New" title="Add New" tabindex="0" data-bs-toggle="tooltip" data-bs-placement="left">
        <i class="bi bi-plus" aria-hidden="true"></i>
    </div>
    <div class="fab-options" id="fab-options">
        <button type="button" class="fab-option" data-bs-toggle="modal" data-bs-target="#createAccountModal" role="button" aria-label="Create New Account" title="Create New Account" data-bs-toggle="tooltip" data-bs-placement="left">
            <i class="bi bi-wallet" aria-hidden="true"></i> New Account
        </button>
        <button type="button" class="fab-option" data-bs-toggle="modal" data-bs-target="#createIncomeModal" role="button" aria-label="Create New Income" title="Create New Income" data-bs-toggle="tooltip" data-bs-placement="left">
            <i class="bi bi-cash-stack" aria-hidden="true"></i> New Income
        </button>
        <button type="button" class="fab-option" data-bs-toggle="modal" data-bs-target="#createExpenseModal" role="button" aria-label="Create New Expense" title="Create New Expense" data-bs-toggle="tooltip" data-bs-placement="left">
            <i class="bi bi-receipt" aria-hidden="true"></i> New Expense
        </button>
        <button type="button" class="fab-option" data-bs-toggle="modal" data-bs-target="#createDebtModal" role="button" aria-label="Create New Debt" title="Create New Debt" data-bs-toggle="tooltip" data-bs-placement="left">
            <i class="bi bi-credit-card" aria-hidden="true"></i> New Debt
        </button>
        <button type="button" class="fab-option" data-bs-toggle="modal" data-bs-target="#createSavingModal" role="button" aria-label="Create New Saving" title="Create New Saving" data-bs-toggle="tooltip" data-bs-placement="left">
            <i class="bi bi-piggy-bank" aria-hidden="true"></i> New Saving
        </button>
        <button type="button" class="fab-option" data-bs-toggle="modal" data-bs-target="#createBudgetModal" role="button" aria-label="Create New Budget" title="Create New Budget" data-bs-toggle="tooltip" data-bs-placement="left">
            <i class="bi bi-bar-chart" aria-hidden="true"></i> New Budget
        </button>
    </div>

    <!-- Bottom Navbar -->
    <nav class="bottom-navbar" role="navigation" aria-label="Bottom Navigation">
        <a href="{{ route('dashboard') }}" class="navbar-item" aria-label="Dashboard" title="Dashboard" data-bs-toggle="tooltip" data-bs-placement="top">
            <i class="bi bi-house-door" aria-hidden="true"></i>
        </a>
        <a href="{{ route('taskmanagement.index') }}" class="navbar-item" aria-label="Task Management" title="Task Management" data-bs-toggle="tooltip" data-bs-placement="top">
            <i class="bi bi-list-task" aria-hidden="true"></i>
        </a>
        <a href="{{ route('financemanagement.index') }}" class="navbar-item active" aria-label="Finance Management" title="Finance Management" data-bs-toggle="tooltip" data-bs-placement="top">
            <i class="bi bi-currency-dollar" aria-hidden="true"></i>
        </a>
        <a href="{{ route('calendar.index') }}" class="navbar-item" aria-label="Calendar" title="Calendar" data-bs-toggle="tooltip" data-bs-placement="top">
            <i class="bi bi-calendar" aria-hidden="true"></i>
        </a>
        <a href="{{ route('notifications.index') }}" class="navbar-item" aria-label="Notifications" title="Notifications" data-bs-toggle="tooltip" data-bs-placement="top">
            <i class="bi bi-bell" aria-hidden="true"></i>
        </a>
        <a href="{{ route('tips') }}" class="navbar-item" aria-label="Tips & Best Practices" title="Tips & Best Practices" data-bs-toggle="tooltip" data-bs-placement="top">
            <i class="bi bi-lightbulb" aria-hidden="true"></i>
        </a>
        <a href="{{ route('reports') }}" class="navbar-item" aria-label="Reports" title="Reports" data-bs-toggle="tooltip" data-bs-placement="top">
            <i class="bi bi-bar-chart" aria-hidden="true"></i>
        </a>
    </nav>

    <!-- CREATE MODALS (Unchanged) -->

    <!-- Create Account Modal -->
    <div class="modal fade" id="createAccountModal" tabindex="-1" aria-labelledby="createAccountModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="createAccountModalLabel">Create New Account</h5>
                </div>
                <div class="modal-body">
                    <form id="create-account-form" action="{{ route('accounts.store') }}" method="POST">
                        @csrf
                        <div class="form-group mb-3">
                            <label for="account-name" class="form-label">Account Name</label>
                            <input type="text" class="form-control" id="account-name" name="name" value="{{ old('name') }}" placeholder="Enter Account Name" required autofocus aria-required="true">
                            @error('name')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group mb-3">
                            <label for="account-description" class="form-label">Description</label>
                            <textarea class="form-control" id="account-description" name="description" placeholder="Enter Description">{{ old('description') }}</textarea>
                            @error('description')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group mb-3">
                            <label for="account-balance" class="form-label">Balance</label>
                            <input type="number" class="form-control" id="account-balance" name="balance" step="0.01" placeholder="Enter Balance" required aria-required="true" value="{{ old('balance') }}">
                            @error('balance')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group mb-3">
                            <label for="account-currency" class="form-label">Currency</label>
                            <select class="form-control" id="account-currency" name="currency" required aria-required="true">
                                @foreach($currencies as $currency)
                                    <option value="{{ $currency }}" {{ old('currency') == $currency ? 'selected' : '' }}>{{ $currency }}</option>
                                @endforeach
                            </select>
                            @error('currency')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="icon-button" data-bs-dismiss="modal" aria-label="Cancel" title="Cancel">
                        <span class="material-icons-outlined">close</span>
                    </button>
                    <button type="submit" form="create-account-form" class="icon-button" aria-label="Save Account" title="Save Account">
                        <span class="material-icons-outlined">send</span>
                    </button>
                </div>
            </div>
        </div>
    </div>
    <!-- End of Create Account Modal -->

    <!-- Create Income Modal -->
    <div class="modal fade" id="createIncomeModal" tabindex="-1" aria-labelledby="createIncomeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="createIncomeModalLabel">Create New Income</h5>
                </div>
                <div class="modal-body">
                    <form id="create-income-form" action="{{ route('incomes.store') }}" method="POST">
                        @csrf
                        <div class="form-group mb-3">
                            <label for="income-source-name" class="form-label">Source Name</label>
                            <input type="text" class="form-control" id="income-source-name" name="source_name" value="{{ old('source_name') }}" placeholder="Enter Source Name" required autofocus aria-required="true">
                            @error('source_name')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group mb-3">
                            <label for="income-description" class="form-label">Description</label>
                            <textarea class="form-control" id="income-description" name="description" placeholder="Enter Description">{{ old('description') }}</textarea>
                            @error('description')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group mb-3">
                            <label for="income-amount" class="form-label">Amount</label>
                            <input type="number" class="form-control" id="income-amount" name="amount" step="0.01" placeholder="Enter Amount" required aria-required="true" value="{{ old('amount') }}">
                            @error('amount')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group mb-3">
                            <label for="income-date" class="form-label">Date</label>
                            <input type="date" class="form-control" id="income-date" name="date" value="{{ old('date') }}" required aria-required="true">
                            @error('date')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="icon-button" data-bs-dismiss="modal" aria-label="Cancel" title="Cancel">
                        <span class="material-icons-outlined">close</span>
                    </button>
                    <button type="submit" form="create-income-form" class="icon-button" aria-label="Save Income" title="Save Income">
                        <span class="material-icons-outlined">send</span>
                    </button>
                </div>
            </div>
        </div>
    </div>
    <!-- End of Create Income Modal -->

    <!-- Create Expense Modal -->
    <div class="modal fade" id="createExpenseModal" tabindex="-1" aria-labelledby="createExpenseModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="createExpenseModalLabel">Create New Expense</h5>
                </div>
                <div class="modal-body">
                    <form id="create-expense-form" action="{{ route('expenses.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group mb-3">
                            <label for="expense-name" class="form-label">Expense Name</label>
                            <input type="text" class="form-control" id="expense-name" name="name" value="{{ old('name') }}" placeholder="Enter Expense Name" required autofocus aria-required="true">
                            @error('name')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group mb-3">
                            <label for="expense-description" class="form-label">Description</label>
                            <textarea class="form-control" id="expense-description" name="description" placeholder="Enter Description">{{ old('description') }}</textarea>
                            @error('description')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group mb-3">
                            <label for="expense-amount" class="form-label">Amount</label>
                            <input type="number" class="form-control" id="expense-amount" name="amount" step="0.01" placeholder="Enter Amount" required aria-required="true" value="{{ old('amount') }}">
                            @error('amount')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group mb-3">
                            <label for="expense-category" class="form-label">Category</label>
                            <select class="form-control" id="expense-category" name="category" required aria-required="true">
                                <option value="" disabled selected>Select Category</option>
                                @foreach ($categories as $category)
                                    <option value="{{ $category }}" {{ old('category') == $category ? 'selected' : '' }}>{{ $category }}</option>
                                @endforeach
                            </select>
                            @error('category')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group mb-3">
                            <label for="expense-date" class="form-label">Date</label>
                            <input type="date" class="form-control" id="expense-date" name="date" value="{{ old('date') }}" required aria-required="true">
                            @error('date')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group mb-3">
                            <label for="expense-currency" class="form-label">Currency</label>
                            <select class="form-control" id="expense-currency" name="currency" required aria-required="true">
                                <option value="" disabled selected>Select Currency</option>
                                @foreach ($currencies as $currency)
                                    <option value="{{ $currency }}" {{ old('currency') == $currency ? 'selected' : '' }}>{{ $currency }}</option>
                                @endforeach
                            </select>
                            @error('currency')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group mb-3">
                            <label for="expense-payment-method" class="form-label">Payment Method</label>
                            <select class="form-control" id="expense-payment-method" name="payment_method" required aria-required="true">
                                <option value="" disabled selected>Select Payment Method</option>
                                @foreach ($paymentMethods as $paymentMethod)
                                    <option value="{{ $paymentMethod }}" {{ old('payment_method') == $paymentMethod ? 'selected' : '' }}>{{ $paymentMethod }}</option>
                                @endforeach
                            </select>
                            @error('payment_method')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group mb-3">
                            <label for="expense-notes" class="form-label">Notes</label>
                            <textarea class="form-control" id="expense-notes" name="notes" placeholder="Enter Notes">{{ old('notes') }}</textarea>
                            @error('notes')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group mb-3">
                            <label for="expense-attachment" class="form-label">Attachment</label>
                            <input type="file" class="form-control" id="expense-attachment" name="attachment" accept="image/*,application/pdf">
                            @error('attachment')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                            <img id="expense-attachment-preview" src="#" alt="Attachment Preview" style="display: none; max-width: 100%; height: auto; margin-top: 10px;">
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="icon-button" data-bs-dismiss="modal" aria-label="Cancel" title="Cancel" data-bs-toggle="tooltip" data-bs-placement="left">
                        <span class="material-icons-outlined">close</span>
                    </button>
                    <button type="submit" form="create-expense-form" class="icon-button" aria-label="Save Expense" title="Save Expense" data-bs-toggle="tooltip" data-bs-placement="left">
                        <span class="material-icons-outlined">send</span>
                    </button>
                </div>
            </div>
        </div>
    </div>
    <!-- End of Create Expense Modal -->

    <!-- Create Debt Modal -->
    <div class="modal fade" id="createDebtModal" tabindex="-1" aria-labelledby="createDebtModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="createDebtModalLabel">Create New Debt</h5>
                </div>
                <div class="modal-body">
                    <form id="create-debt-form" action="{{ route('debts.store') }}" method="POST">
                        @csrf
                        <div class="form-group mb-3">
                            <label for="debt-name" class="form-label">Debt Name</label>
                            <input type="text" class="form-control" id="debt-name" name="name" value="{{ old('name') }}" placeholder="Enter Debt Name" required autofocus aria-required="true">
                            @error('name')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group mb-3">
                            <label for="debt-description" class="form-label">Description</label>
                            <textarea class="form-control" id="debt-description" name="description" placeholder="Enter Description">{{ old('description') }}</textarea>
                            @error('description')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group mb-3">
                            <label for="debt-amount" class="form-label">Amount</label>
                            <input type="number" class="form-control" id="debt-amount" name="amount" step="0.01" placeholder="Enter Amount" required aria-required="true" value="{{ old('amount') }}">
                            @error('amount')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group mb-3">
                            <label for="debt-currency" class="form-label">Currency</label>
                            <select class="form-control" id="debt-currency" name="currency" required aria-required="true">
                                @foreach($currencies as $currency)
                                    <option value="{{ $currency }}" {{ old('currency') == $currency ? 'selected' : '' }}>{{ $currency }}</option>
                                @endforeach
                            </select>
                            @error('currency')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group mb-3">
                            <label for="debt-type" class="form-label">Type</label>
                            <select class="form-control" id="debt-type" name="type" required aria-required="true">
                                <option value="borrowed" {{ old('type') == 'borrowed' ? 'selected' : '' }}>Borrowed</option>
                                <option value="lent" {{ old('type') == 'lent' ? 'selected' : '' }}>Lent</option>
                            </select>
                            @error('type')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group mb-3">
                            <label for="debt-due-date" class="form-label">Due Date</label>
                            <input type="date" class="form-control" id="debt-due-date" name="due_date" value="{{ old('due_date') }}" required aria-required="true">
                            @error('due_date')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group form-check mb-3">
                            <input type="hidden" name="reminder" value="0">
                            <input type="checkbox" class="form-check-input" id="debt-reminder" name="reminder" value="1" {{ old('reminder') ? 'checked' : '' }}>
                            <label class="form-check-label" for="debt-reminder">Set Reminder</label>
                            @error('reminder')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="icon-button" data-bs-dismiss="modal" aria-label="Cancel" title="Cancel" data-bs-toggle="tooltip" data-bs-placement="left">
                        <span class="material-icons-outlined">close</span>
                    </button>
                    <button type="submit" form="create-debt-form" class="icon-button" aria-label="Save Debt" title="Save Debt" data-bs-toggle="tooltip" data-bs-placement="left">
                        <span class="material-icons-outlined">send</span>
                    </button>
                </div>
            </div>
        </div>
    </div>
    <!-- End of Create Debt Modal -->

    <!-- Create Saving Modal -->
    <div class="modal fade" id="createSavingModal" tabindex="-1" aria-labelledby="createSavingModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="createSavingModalLabel">Create New Saving</h5>
                </div>
                <div class="modal-body">
                    <form id="create-saving-form" action="{{ route('savings.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group mb-3">
                            <label for="saving-name" class="form-label">Name of the Saving</label>
                            <input type="text" class="form-control" id="saving-name" name="name" placeholder="Enter Saving Name" required autofocus aria-required="true" value="{{ old('name') }}">
                            @error('name')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group mb-3">
                            <label for="saving-description" class="form-label">Description</label>
                            <textarea class="form-control" id="saving-description" name="description" placeholder="Enter Description">{{ old('description') }}</textarea>
                            @error('description')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group mb-3">
                            <label for="saving-desired-amount" class="form-label">Desired Amount</label>
                            <input type="number" class="form-control" id="saving-desired-amount" name="desired_amount" placeholder="Enter Desired Amount" required aria-required="true" value="{{ old('desired_amount') }}">
                            @error('desired_amount')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group mb-3">
                            <label for="saving-desired-date" class="form-label">Desired Date</label>
                            <input type="date" class="form-control" id="saving-desired-date" name="desired_date" required aria-required="true" value="{{ old('desired_date') }}">
                            @error('desired_date')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group mb-3">
                            <label for="saving-notes" class="form-label">Notes</label>
                            <textarea class="form-control" id="saving-notes" name="notes" placeholder="Enter Notes">{{ old('notes') }}</textarea>
                            @error('notes')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group mb-3">
                            <label for="saving-attachment" class="form-label">Attachment</label>
                            <input type="file" class="form-control" id="saving-attachment" name="attachment">
                            @error('attachment')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                            <img id="saving-attachment-preview" src="#" alt="Attachment Preview" style="display: none; max-width: 100%; height: auto; margin-top: 10px;">
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="icon-button" data-bs-dismiss="modal" aria-label="Cancel" title="Cancel" data-bs-toggle="tooltip" data-bs-placement="left">
                        <span class="material-icons-outlined">close</span>
                    </button>
                    <button type="submit" form="create-saving-form" class="icon-button" aria-label="Save Saving" title="Save Saving" data-bs-toggle="tooltip" data-bs-placement="left">
                        <span class="material-icons-outlined">send</span>
                    </button>
                </div>
            </div>
        </div>
    </div>
    <!-- End of Create Saving Modal -->

    <!-- Create Budget Modal -->
    <div class="modal fade" id="createBudgetModal" tabindex="-1" aria-labelledby="createBudgetModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="createBudgetModalLabel">Create New Budget</h5>
                </div>
                <div class="modal-body">
                    <form id="create-budget-form" action="{{ route('budgets.store') }}" method="POST">
                        @csrf
                        <div class="form-group mb-3">
                            <label for="budget-name" class="form-label">Budget Name</label>
                            <input type="text" class="form-control" id="budget-name" name="name" value="{{ old('name') }}" placeholder="Enter Budget Name" required autofocus aria-required="true">
                            @error('name')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group mb-3">
                            <label for="budget-description" class="form-label">Description</label>
                            <textarea class="form-control" id="budget-description" name="description" placeholder="Enter Description">{{ old('description') }}</textarea>
                            @error('description')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group mb-3">
                            <label for="budget-amount" class="form-label">Amount</label>
                            <input type="number" class="form-control" id="budget-amount" name="amount" step="0.01" placeholder="Enter Amount" required aria-required="true" value="{{ old('amount') }}">
                            @error('amount')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group mb-3">
                            <label for="budget-category" class="form-label">Category</label>
                            <select class="form-control" id="budget-category" name="category" required aria-required="true">
                                <option value="" disabled selected>Select Category</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category }}" {{ old('category') == $category ? 'selected' : '' }}>{{ $category }}</option>
                                @endforeach
                            </select>
                            @error('category')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group mb-3">
                            <label for="budget-date" class="form-label">Date</label>
                            <input type="date" class="form-control" id="budget-date" name="date" value="{{ old('date') }}" required aria-required="true">
                            @error('date')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group mb-3">
                            <label for="budget-period" class="form-label">Period</label>
                            <select class="form-control" id="budget-period" name="period" required aria-required="true">
                                <option value="" disabled selected>Select Period</option>
                                @foreach($periods as $value => $label)
                                    <option value="{{ $value }}" {{ old('period') == $value ? 'selected' : '' }}>{{ $label }}</option>
                                @endforeach
                            </select>
                            @error('period')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group mb-3">
                            <label for="budget-currency" class="form-label">Currency</label>
                            <select class="form-control" id="budget-currency" name="currency" required aria-required="true">
                                <option value="" disabled selected>Select Currency</option>
                                @foreach($currencies as $currency)
                                    <option value="{{ $currency }}" {{ old('currency') == $currency ? 'selected' : '' }}>{{ $currency }}</option>
                                @endforeach
                            </select>
                            @error('currency')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group mb-3">
                            <label for="budget-account_id" class="form-label">Account</label>
                            <select class="form-control" id="budget-account_id" name="account_id">
                                <option value="" selected>None</option>
                                @foreach($accounts as $account)
                                    <option value="{{ $account->id }}" {{ old('account_id') == $account->id ? 'selected' : '' }}>{{ $account->name }}</option>
                                @endforeach
                            </select>
                            @error('account_id')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group form-check mb-3">
                            <input type="hidden" name="overspending_reminder" value="0">
                            <input type="checkbox" class="form-check-input" id="overspending_reminder" name="overspending_reminder" value="1" {{ old('overspending_reminder') ? 'checked' : '' }}>
                            <label class="form-check-label" for="overspending_reminder">Set Reminder for Overspending</label>
                            @error('overspending_reminder')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="icon-button" data-bs-dismiss="modal" aria-label="Cancel" title="Cancel" data-bs-toggle="tooltip" data-bs-placement="left">
                        <span class="material-icons-outlined">close</span>
                    </button>
                    <button type="submit" form="create-budget-form" class="icon-button" aria-label="Save Budget" title="Save Budget" data-bs-toggle="tooltip" data-bs-placement="left">
                        <span class="material-icons-outlined">send</span>
                    </button>
                </div>
            </div>
        </div>
    </div>
    <!-- End of Create Budget Modal -->

    <!-- Scripts -->
    <script src="{{ asset('js/sidebar.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Add Smart Features Script -->
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            // Initialize tooltips
            const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
            const tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
                return new bootstrap.Tooltip(tooltipTriggerEl)
            })

            const fab = document.getElementById('fab');
            const fabOptions = document.getElementById('fab-options');

            fab.addEventListener('click', (e) => {
                e.stopPropagation();
                fabOptions.classList.toggle('show');
            });

            document.addEventListener('click', (e) => {
                if (!fab.contains(e.target) && !fabOptions.contains(e.target)) {
                    fabOptions.classList.remove('show');
                }
            });

            fabOptions.addEventListener('click', (e) => {
                e.stopPropagation();
            });

            // Event listeners for cards
            ['account', 'income', 'expense', 'debt', 'saving', 'budget'].forEach(type => {
                const cards = document.querySelectorAll(`.${type}-card`);
                cards.forEach(card => {
                    card.addEventListener('click', () => {
                        const url = card.getAttribute(`data-${type}-url`);
                        if (url) {
                            window.location.href = url;
                        } else {
                            console.error(`${type.charAt(0).toUpperCase() + type.slice(1)} URL not found for this card.`);
                        }
                    });
                    card.addEventListener('keypress', (e) => {
                        if (e.key === 'Enter' || e.key === ' ') {
                            e.preventDefault();
                            card.click();
                        }
                    });
                });
            });

            // Search functionality
            const searchInput = document.getElementById('finance-search-input');
            const clearSearch = document.getElementById('clear-search');
            const searchResults = document.getElementById('search-results');
            const searchCardsContainer = searchResults.querySelector('.search-cards');
            const noSearchResults = document.getElementById('no-search-results');
            const tabsDiv = document.querySelector('.tabs');

            function debounce(func, delay) {
                let debounceTimer;
                return function() {
                    const context = this;
                    const args = arguments;
                    clearTimeout(debounceTimer);
                    debounceTimer = setTimeout(() => func.apply(context, args), delay);
                }
            }

            searchInput.addEventListener('input', debounce(function() {
                const query = this.value.toLowerCase().trim();

                if (query.length === 0) {
                    searchResults.style.display = 'none';
                    searchCardsContainer.innerHTML = '';
                    noSearchResults.style.display = 'none';
                    tabsDiv.style.display = 'flex';
                    const activeTab = document.querySelector('.tab-content.active');
                    if (activeTab) {
                        activeTab.style.display = 'block';
                    }
                    return;
                }

                tabsDiv.style.display = 'none';
                const tabContents = document.getElementsByClassName('tab-content');
                for (let i = 0; i < tabContents.length; i++) {
                    tabContents[i].style.display = 'none';
                }

                searchCardsContainer.innerHTML = '';
                noSearchResults.style.display = 'none';

                ['account', 'income', 'expense', 'debt', 'saving', 'budget'].forEach(type => {
                    const cards = document.querySelectorAll(`.${type}-card`);
                    cards.forEach(card => {
                        const cardTitleElement = card.querySelector('.card-title');
                        const cardTitle = cardTitleElement ? cardTitleElement.textContent.toLowerCase() : '';
                        let cardContentText = '';

                        switch(type) {
                            case 'account':
                                const accountBalance = card.querySelector('.account-info p');
                                cardContentText = accountBalance ? accountBalance.textContent.toLowerCase() : '';
                                break;
                            case 'income':
                                const incomeAmount = card.querySelector('.income-info p');
                                const incomeDate = card.querySelector('.income-info p:nth-child(3)');
                                cardContentText = (incomeAmount ? incomeAmount.textContent.toLowerCase() : '') + ' ' +
                                                  (incomeDate ? incomeDate.textContent.toLowerCase() : '');
                                break;
                            case 'expense':
                                const expenseAmount = card.querySelector('.expense-info p');
                                const expenseDate = card.querySelector('.expense-info p:nth-child(3)');
                                cardContentText = (expenseAmount ? expenseAmount.textContent.toLowerCase() : '') + ' ' +
                                                  (expenseDate ? expenseDate.textContent.toLowerCase() : '');
                                break;
                            case 'debt':
                                const debtAmount = card.querySelector('.debt-info p');
                                const debtDueDate = card.querySelector('.debt-info p:nth-child(3)');
                                cardContentText = (debtAmount ? debtAmount.textContent.toLowerCase() : '') + ' ' +
                                                  (debtDueDate ? debtDueDate.textContent.toLowerCase() : '');
                                break;
                            case 'saving':
                                const savingDesiredAmount = card.querySelector('.saving-info p');
                                const savingAmountSaved = card.querySelector('.saving-info p:nth-child(3)');
                                const savingDesiredDate = card.querySelector('.saving-info p:nth-child(4)');
                                cardContentText = (savingDesiredAmount ? savingDesiredAmount.textContent.toLowerCase() : '') + ' ' +
                                                  (savingAmountSaved ? savingAmountSaved.textContent.toLowerCase() : '') + ' ' +
                                                  (savingDesiredDate ? savingDesiredDate.textContent.toLowerCase() : '');
                                break;
                            case 'budget':
                                const budgetAmount = card.querySelector('.budget-info p');
                                const budgetRemaining = card.querySelector('.budget-info p:nth-child(3)');
                                cardContentText = (budgetAmount ? budgetAmount.textContent.toLowerCase() : '') + ' ' +
                                                  (budgetRemaining ? budgetRemaining.textContent.toLowerCase() : '');
                                break;
                            default:
                                break;
                        }

                        if (cardTitle.includes(query) || cardContentText.includes(query)) {
                            const clonedCard = card.cloneNode(true);
                            clonedCard.querySelectorAll('*').forEach(element => {
                                const newEl = element.cloneNode(true);
                                element.parentNode.replaceChild(newEl, element);
                            });
                            searchCardsContainer.appendChild(clonedCard);
                        }
                    });
                });

                const totalResults = searchCardsContainer.querySelectorAll('.card').length;
                if (totalResults === 0) {
                    noSearchResults.style.display = 'flex';
                } else {
                    noSearchResults.style.display = 'none';
                }

                searchResults.style.display = 'block';
            }, 300));

            clearSearch.addEventListener('click', () => {
                searchInput.value = '';
                searchInput.dispatchEvent(new Event('input'));
            });

            window.openTab = function(evt, tabName) {
                evt.preventDefault();
                const tabContents = document.getElementsByClassName('tab-content');
                for (let i = 0; i < tabContents.length; i++) {
                    tabContents[i].classList.remove('active');
                    tabContents[i].style.display = 'none';
                }

                const tabLinks = document.getElementsByClassName('tab-link');
                for (let i = 0; i < tabLinks.length; i++) {
                    tabLinks[i].classList.remove('active');
                }

                const currentTab = document.getElementById(tabName);
                currentTab.classList.add('active');
                currentTab.style.display = 'block';
                evt.currentTarget.classList.add('active');
            }

            function readURL(input, previewId) {
                if (input.files && input.files[0]) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        const preview = document.getElementById(previewId);
                        preview.src = e.target.result;
                        preview.style.display = 'block';
                    }
                    reader.readAsDataURL(input.files[0]);
                }
            }

            document.getElementById('expense-attachment').addEventListener('change', function() {
                readURL(this, 'expense-attachment-preview');
            });

            document.getElementById('saving-attachment').addEventListener('change', function() {
                readURL(this, 'saving-attachment-preview');
            });

            document.addEventListener('click', function () {
                tooltipList.forEach(function (tooltipInstance) {
                    tooltipInstance.hide();
                });
            });

            document.querySelectorAll('[data-bs-toggle="tooltip"]').forEach(function (element) {
                element.addEventListener('click', function (e) {
                    e.stopPropagation();
                    const tooltip = bootstrap.Tooltip.getInstance(element);
                    if (tooltip) {
                        tooltip.hide();
                    }
                });
            });


            /* =======================================
               SMART FEATURES IMPLEMENTATION
            ======================================= */

            const insightsContainer = document.getElementById('finance-insights');

            const incomes = @json($incomes);
            const expenses = @json($expenses);
            const budgets = @json($budgets);
            const savings = @json($savings);
            const debts = @json($debts);
            const accounts = @json($accounts);

            function showInsight(message) {
                const alertDiv = document.createElement('div');
                alertDiv.classList.add('alert', 'alert-secondary', 'alert-dismissible', 'fade', 'show', 'mb-3');
                alertDiv.setAttribute('role', 'alert');
                alertDiv.innerHTML = `
                    ${message}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                `;
                insightsContainer.appendChild(alertDiv);
            }

            function sumBy(array, field) {
                return array.reduce((acc, obj) => acc + (parseFloat(obj[field]) || 0), 0);
            }

            function thisMonthAndLastMonthData(records, dateField, amountField) {
                const now = new Date();
                const thisMonth = now.getMonth();
                const thisYear = now.getFullYear();

                const lastMonth = thisMonth === 0 ? 11 : thisMonth - 1;
                const lastMonthYear = thisMonth === 0 ? thisYear - 1 : thisYear;

                let thisMonthTotal = 0;
                let lastMonthTotal = 0;

                records.forEach(r => {
                    const d = new Date(r[dateField]);
                    if (d.getFullYear() === thisYear && d.getMonth() === thisMonth) {
                        thisMonthTotal += parseFloat(r[amountField]) || 0;
                    } else if (d.getFullYear() === lastMonthYear && d.getMonth() === lastMonth) {
                        lastMonthTotal += parseFloat(r[amountField]) || 0;
                    }
                });

                return { thisMonthTotal, lastMonthTotal };
            }

            // 1. Smart Spending Alerts
            if (budgets.length > 0 && expenses.length > 0) {
                const categorySpend = {};
                expenses.forEach(e => {
                    categorySpend[e.category] = (categorySpend[e.category] || 0) + parseFloat(e.amount);
                });
                const today = new Date();
                const dayOfMonth = today.getDate();
                const daysInMonth = new Date(today.getFullYear(), today.getMonth()+1, 0).getDate();
                const monthProgress = dayOfMonth / daysInMonth;

                budgets.forEach(b => {
                    const cat = b.category;
                    const spent = categorySpend[cat] || 0;
                    if (spent > b.amount * 0.8 && monthProgress < 0.5) {
                        showInsight(`You’ve spent <strong>${spent.toFixed(2)}</strong> in <strong>${cat}</strong> already, which is 80% of your <strong>${b.amount.toFixed(2)}</strong> budget, and the month is not half over. Consider cutting back.`);
                    }
                });
            }

            // 2. Predictive Forecasts
            function monthlyTotals(records, dateField, amountField) {
                const byMonth = {};
                records.forEach(r => {
                    const d = new Date(r[dateField]);
                    const key = `${d.getFullYear()}-${d.getMonth()}`;
                    byMonth[key] = (byMonth[key] || 0) + parseFloat(r[amountField]) || 0;
                });
                const keys = Object.keys(byMonth).sort();
                const last3 = keys.slice(-3);
                if (last3.length === 3) {
                    const sum3 = last3.reduce((acc, k) => acc + byMonth[k], 0);
                    return sum3 / 3;
                }
                return null;
            }

            const avgMonthlyIncome = monthlyTotals(incomes, 'date', 'amount');
            const avgMonthlyExpense = monthlyTotals(expenses, 'date', 'amount');
            if (avgMonthlyIncome && avgMonthlyExpense) {
                showInsight(`Based on recent months, next month you might expect around <strong>${avgMonthlyIncome.toFixed(2)}</strong> in income and <strong>${avgMonthlyExpense.toFixed(2)}</strong> in expenses.`);
            }

            // 3. Category-Based Budget Recommendations
            if (expenses.length > 0) {
                const categoryTotals = {};
                expenses.forEach(e => {
                    categoryTotals[e.category] = (categoryTotals[e.category] || 0) + parseFloat(e.amount);
                });
                const budgetCategories = budgets.map(b => b.category);
                for (const cat in categoryTotals) {
                    if (categoryTotals[cat] > 0 && !budgetCategories.includes(cat)) {
                        showInsight(`Consider setting a budget for <strong>${cat}</strong>: You've spent about <strong>${categoryTotals[cat].toFixed(2)}</strong> in total recently. A budget around this amount might help.`);
                    }
                }
            }

            // 4. Savings Goal Progress Tips
            savings.forEach(sv => {
                if (sv.desired_amount > 0 && sv.desired_date) {
                    const desired = sv.desired_amount;
                    const saved = sv.total_saved;
                    const now = new Date();
                    const endDate = new Date(sv.desired_date);
                    const totalDays = (endDate - now)/(1000*60*60*24);
                    const progress = (saved / desired) * 100;

                    if (progress < 100 && totalDays > 0 && sv.created_at) {
                        const created = new Date(sv.created_at);
                        const totalGoalDays = (endDate - created)/(1000*60*60*24);
                        if (totalGoalDays > 0) {
                            const expectedProgress = (1 - (totalDays/totalGoalDays))*100;
                            if (progress < expectedProgress) {
                                showInsight(`For <strong>"${sv.name}"</strong> savings goal, you're at <strong>${progress.toFixed(1)}%</strong>, but should be around <strong>${expectedProgress.toFixed(1)}%</strong> by now. Consider saving a bit more!`);
                            } else {
                                showInsight(`Great job! For <strong>"${sv.name}"</strong> you're on track with <strong>${progress.toFixed(1)}%</strong> saved. Keep it up!`);
                            }
                        }
                    } else if (progress >= 100) {
                        showInsight(`Congratulations! You've reached your savings goal <strong>"${sv.name}"</strong>!`);
                    }
                }
            });

            // 5. Unusual Transaction Alerts
            if (expenses.length > 0) {
                const categoryExpenses = {};
                expenses.forEach(e => {
                    const cat = e.category || 'Other';
                    categoryExpenses[cat] = categoryExpenses[cat] || [];
                    categoryExpenses[cat].push(parseFloat(e.amount));
                });

                for (const cat in categoryExpenses) {
                    const amounts = categoryExpenses[cat];
                    const avg = amounts.reduce((a,b)=>a+b,0)/amounts.length;
                    const unusual = amounts.find(a => a > avg*3 && avg > 0);
                    if (unusual) {
                        showInsight(`Unusual expense detected in <strong>${cat}</strong>: You spent <strong>${unusual.toFixed(2)}</strong>, much higher than your average <strong>${avg.toFixed(2)}</strong>. Consider reviewing this expense.`);
                    }
                }
            }

            // 6. Debt Reduction Suggestions
            const nowDate = new Date();
            debts.forEach(d => {
                if (d.due_date) {
                    const due = new Date(d.due_date);
                    const diffDays = (due - nowDate)/(1000*60*60*24);
                    if (diffDays < 7 && d.amount > 0) {
                        showInsight(`Your debt <strong>"${d.name}"</strong> is due soon. Paying some amount now could help avoid late fees or interest.`);
                    }
                }
            });

            // 7. Income vs. Expense Insights
            const { thisMonthTotal: thisMonthIncome, lastMonthTotal: lastMonthIncome } = thisMonthAndLastMonthData(incomes, 'date', 'amount');
            const { thisMonthTotal: thisMonthExpense, lastMonthTotal: lastMonthExpense } = thisMonthAndLastMonthData(expenses, 'date', 'amount');

            if (thisMonthIncome !== undefined && thisMonthExpense !== undefined) {
                if (thisMonthExpense > thisMonthIncome) {
                    showInsight(`This month, expenses exceed your income. Consider revisiting budgets or seeking more savings.`);
                } else {
                    showInsight(`Good job! You spent less than you earned this month, improving your financial health.`);
                }

                if (lastMonthExpense > 0) {
                    const expenseChange = ((thisMonthExpense - lastMonthExpense)/lastMonthExpense)*100;
                    if (expenseChange > 0) {
                        showInsight(`Your expenses increased by <strong>${expenseChange.toFixed(1)}%</strong> compared to last month. Keep an eye on categories where spending rose.`);
                    } else if (expenseChange < 0) {
                        showInsight(`You spent <strong>${Math.abs(expenseChange).toFixed(1)}%</strong> less than last month. Nice improvement!`);
                    }
                }
            }

        });
    </script>
</body>
</html>
