<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;

// Import Controllers
use App\Http\Controllers\Auth\PasswordResetLinkController;
use App\Http\Controllers\Auth\VerificationController;
use App\Http\Controllers\Auth\NewPasswordController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\OnboardingController;
use App\Http\Controllers\WelcomeController;
use App\Http\Controllers\TaskManagementController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\LabelController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\ProjectTaskController;
use App\Http\Controllers\CollaborationController;
use App\Http\Controllers\FinanceManagementController;
use App\Http\Controllers\FinancialReminderController;
use App\Http\Controllers\CalendarController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\TipsController;
use App\Http\Controllers\ReportsController;
use App\Http\Controllers\AccountController;
use App\Http\Controllers\ExpenseController;
use App\Http\Controllers\DebtController;
use App\Http\Controllers\IncomeController;
use App\Http\Controllers\BudgetController;
use App\Http\Controllers\SavingsController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\PasswordController;
use App\Http\Controllers\ArticleController;
use App\Http\Controllers\VideoController;
use App\Http\Controllers\EbookController;
use App\Http\Controllers\FaqController;

// ============================================
// AUTHENTICATION ROUTES
// ============================================
// Only name the GET route "login". For the POST route, either remove the name or give it a different name.
Route::get('login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('login', [LoginController::class, 'login']); // removed ->name('login')
Route::post('logout', [LoginController::class, 'logout'])->name('logout');

// Registration Routes
Route::get('register', [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('register', [RegisterController::class, 'register']);

// Password Reset Routes
Route::get('password/reset', [PasswordResetLinkController::class, 'create'])->name('password.request');
Route::post('password/email', [PasswordResetLinkController::class, 'store'])->name('password.email');
Route::get('password/reset/{token}', [NewPasswordController::class, 'create'])->name('password.reset');
Route::post('password/reset', [NewPasswordController::class, 'store'])->name('password.update');

// Email Verification Routes
Route::get('/email/verify-email', [VerificationController::class, 'show'])
    ->middleware('auth')
    ->name('verification.notice');

Route::get('/email/verify-email/{id}/{hash}', [VerificationController::class, 'verify'])
    ->middleware(['signed'])
    ->name('verification.verify');

Route::post('/email/resend', [VerificationController::class, 'resend'])
    ->middleware(['throttle:6,1'])
    ->name('verification.resend');

// ============================================
// PROTECTED ROUTES (DASHBOARD)
// ============================================
Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::get('/onboarding', [OnboardingController::class, 'showOnboarding'])->name('onboarding');
Route::get('/welcome', [WelcomeController::class, 'index'])->name('welcome');

// Root -> Redirect
Route::get('/', function () {
    return redirect()->route('onboarding');
});

// ============================================
// TASK MANAGEMENT
// ============================================
Route::get('/taskmanagement', [TaskManagementController::class, 'index'])->name('taskmanagement.index');
Route::resource('tasks', TaskController::class);
Route::post('/tasks/{task}/complete', [TaskController::class, 'markAsCompleted'])->name('tasks.markAsCompleted');
Route::patch('/tasks/{task}/status', [TaskController::class, 'updateStatus'])->name('tasks.updateStatus')->middleware('auth');

// LABEL ROUTES
Route::resource('labels', LabelController::class);

// ============================================
// PROJECT ROUTES
// ============================================
// Resource route for projects
Route::resource('projects', ProjectController::class);

// Nested project tasks
Route::prefix('projects/{project}')->group(function () {
    Route::resource('tasks', ProjectTaskController::class)->names([
        'index'   => 'projecttasks.index',
        'create'  => 'projecttasks.create',
        'store'   => 'projecttasks.store',
        'show'    => 'projecttasks.show',
        'edit'    => 'projecttasks.edit',
        'update'  => 'projecttasks.update',
        'destroy' => 'projecttasks.destroy',
    ]);

    // AJAX route for updating project task status
    Route::patch('/tasks/{task}/status', [ProjectTaskController::class, 'updateStatus'])
        ->name('projecttasks.updateStatus')
        ->middleware('auth');

    // Mark project task as completed
    Route::post('/tasks/{task}/mark-as-completed', [ProjectTaskController::class, 'markAsCompleted'])
        ->name('projecttasks.markAsCompleted');
});

// Project members route
Route::get('/projects/{project}/members', [ProjectController::class, 'members'])->name('projects.members');

// ============================================
// COLLABORATION ROUTES (NESTED)
// ============================================
Route::prefix('projects/{project}')->group(function () {
    Route::post('collaborations/invite', [CollaborationController::class, 'invite'])->name('collaborations.invite');
    Route::delete('collaborations/{user}', [CollaborationController::class, 'remove'])->name('collaborations.remove');
    Route::match(['get', 'post'], 'collaborations/accept/{user}', [CollaborationController::class, 'acceptInvitation'])->name('collaborations.accept');
    Route::match(['get', 'post'], 'collaborations/decline/{user}', [CollaborationController::class, 'declineInvitation'])->name('collaborations.decline');
});

// ============================================
// NOTIFICATIONS
// ============================================
Route::get('/notifications', [NotificationController::class, 'index'])->name('notifications.index');
Route::get('/notifications/show/{id}', [NotificationController::class, 'show'])->name('notifications.show');
Route::post('/notifications/mark-all-as-read', [NotificationController::class, 'markAllAsRead'])->name('notifications.markAllAsRead');
Route::delete('/notifications/delete/{id}', [NotificationController::class, 'delete'])->name('notifications.delete');
Route::post('/notifications/mark-as-read/{id}', [NotificationController::class, 'markAsRead'])->name('notifications.markAsRead');

// ============================================
// FINANCE MANAGEMENT
// ============================================
Route::get('/financemanagement', [FinanceManagementController::class, 'index'])->name('financemanagement.index');
Route::get('/budgets/{id}', [BudgetController::class, 'show'])->name('budget.show');
Route::resource('savings', SavingsController::class)->only(['show', 'index', 'create', 'store', 'edit', 'update', 'destroy']);

// CALENDAR
Route::get('/calendar', [CalendarController::class, 'index'])->name('calendar.index');
Route::get('/calendar/tasks', [CalendarController::class, 'fetchTasks'])->name('calendar.tasks');
Route::get('/calendar/debts', [CalendarController::class, 'fetchDebts'])->name('calendar.debts');
Route::get('/calendar/expenses', [CalendarController::class, 'fetchExpenses'])->name('calendar.expenses');
Route::get('/calendar/savings', [CalendarController::class, 'fetchSavings'])->name('calendar.savings');
Route::get('/calendar/{date}', [CalendarController::class, 'showDay'])->name('calendar.showDay');

// FINANCIAL REMINDERS
Route::post('/financial_reminders', [FinancialReminderController::class, 'store'])->name('financial_reminders.store');
Route::get('/financial_reminders/{id}', [FinancialReminderController::class, 'show'])->name('financial_reminders.show');
Route::delete('/financial_reminders/{id}', [FinancialReminderController::class, 'destroy'])->name('financial_reminders.destroy');

// TIPS AND REPORTS
Route::get('/tips', [TipsController::class, 'index'])->name('tips');
Route::get('/reports', [ReportsController::class, 'index'])->name('reports');
Route::get('/task-reports', [ReportsController::class, 'getTaskReports'])->name('reports.task');
Route::get('/expense-reports', [ReportsController::class, 'getExpenseReports'])->name('reports.expense');
Route::get('/income-reports', [ReportsController::class, 'getIncomeReports'])->name('reports.income');
Route::get('/budget-progress-reports', [ReportsController::class, 'getBudgetProgressReports'])->name('reports.budget_progress');
Route::get('/reports/download-pdf', [ReportsController::class, 'downloadPdf'])->name('reports.downloadPdf');

// ============================================
// ACCOUNT & FINANCIAL RESOURCE ROUTES
// ============================================
Route::resource('accounts', AccountController::class);
Route::resource('expenses', ExpenseController::class);
Route::resource('debts', DebtController::class);
Route::resource('incomes', IncomeController::class);
Route::resource('budgets', BudgetController::class);
Route::resource('savings', SavingsController::class);
Route::post('savings/{saving}/add-amount', [SavingsController::class, 'addAmount'])->name('savings.addAmount');

// ============================================
// TASK STATISTICS
// ============================================
Route::get('/tasks/statistics', [TaskController::class, 'getTaskStatistics'])->name('tasks.statistics');

// EVENTS
Route::get('/events/create', [EventController::class, 'create'])->name('events.create');

// PROFILE MANAGEMENT
Route::get('/profile', [ProfileController::class, 'index'])->name('profile.index');
Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
Route::put('/profile/password', [ProfileController::class, 'updatePassword'])->name('profile.password.update');
Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
