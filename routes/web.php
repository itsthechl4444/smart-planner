<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Auth;

// Import Controllers
use App\Http\Controllers\Auth\PasswordResetLinkController;
use App\Http\Controllers\Auth\NewPasswordController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
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


// Authentication Routes...
Auth::routes();


// Onboarding and Welcome Routes
Route::get('/', function () {
    return view('onboarding');
})->name('onboarding');

Route::get('/welcome', function () {
    return view('welcome');
})->name('welcome');

// Authentication Routes
Route::get('login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('login', [LoginController::class, 'login']);
Route::get('register', [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('register', [RegisterController::class, 'register']);
Route::post('logout', [LoginController::class, 'logout'])->name('logout');

// Password Reset Routes
Route::get('password/reset', [PasswordResetLinkController::class, 'create'])->name('password.request');
Route::post('password/reset', [NewPasswordController::class, 'store'])->name('password.update');

// Dashboard Route
Route::get('/dashboard', [DashboardController::class, 'index'])
    ->name('dashboard')
    ->middleware('auth');

// Protected Routes
Route::middleware(['auth'])->group(function () {
    // Task Management
    Route::get('/taskmanagement', [TaskManagementController::class, 'index'])->name('taskmanagement.index');
    Route::resource('tasks', TaskController::class);
    Route::post('/tasks/{task}/complete', [TaskController::class, 'markAsCompleted'])->name('tasks.markAsCompleted');
});

    // Label Routes
    Route::resource('labels', LabelController::class);

    // Project Routes
    Route::resource('projects', ProjectController::class);

 
   
        // Task Creation Routes
        Route::get('/projects/{project}/tasks/create', [ProjectTaskController::class, 'create'])->name('projecttasks.create');
        Route::post('/projects/{project}/tasks', [ProjectTaskController::class, 'store'])->name('projecttasks.store');
        Route::get('/projects/{project}/tasks/{task}', [ProjectTaskController::class, 'show'])->name('projecttasks.show');

    // Members Route
    Route::get('/projects/{project}/members', [ProjectController::class, 'members'])->name('projects.members');


    Route::middleware(['auth'])->group(function () {
        // Notifications Routes
        Route::get('/notifications', [NotificationController::class, 'index'])->name('notifications.index');
        Route::post('/notifications/{id}/read', [NotificationController::class, 'markAsRead'])->name('notifications.markAsRead');
    
        // Collaborations Routes
        Route::post('/projects/{project}/invite', [CollaborationController::class, 'invite'])->name('collaborations.invite');
        Route::post('/projects/{project}/accept', [CollaborationController::class, 'acceptInvitation'])->name('collaborations.accept');
        Route::post('/projects/{project}/decline', [CollaborationController::class, 'declineInvitation'])->name('collaborations.decline');
        Route::delete('/projects/{project}/remove/{collaborator}', [CollaborationController::class, 'remove'])->name('collaborations.remove');
    });




    // Finance Management
    Route::get('/financemanagement', [FinanceManagementController::class, 'index'])->name('financemanagement.index');

// Calendar view
Route::get('/calendar', [CalendarController::class, 'index'])->name('calendar.index');

// Event fetching routes
Route::get('/calendar/tasks', [CalendarController::class, 'fetchTasks'])->name('calendar.fetchTasks');
Route::get('/calendar/expenses', [CalendarController::class, 'fetchExpenses'])->name('calendar.fetchExpenses');
Route::get('/calendar/savings', [CalendarController::class, 'fetchSavings'])->name('calendar.fetchSavings');
Route::get('/calendar/debts', [CalendarController::class, 'fetchDebts'])->name('calendar.fetchDebts');

    // Tips and Reports
    Route::get('/tips', [TipsController::class, 'index'])->name('tips');
    Route::get('/reports', [ReportsController::class, 'index'])->name('reports');
    Route::get('/task-reports', [ReportsController::class, 'getTaskReports'])->name('reports.task');
    Route::get('/expense-reports', [ReportsController::class, 'getExpenseReports'])->name('reports.expense');
    Route::get('/income-reports', [ReportsController::class, 'getIncomeReports'])->name('reports.income');
    Route::get('/budget-progress-reports', [ReportsController::class, 'getBudgetProgressReports'])->name('reports.budget_progress');

    
Route::middleware(['auth'])->group(function () {
    Route::get('/notifications', [NotificationController::class, 'index'])->name('notifications.index');
    Route::post('/notifications/{id}/read', [NotificationController::class, 'markAsRead'])->name('notifications.markAsRead');
});

    // Account Management
    Route::resource('accounts', AccountController::class);
    Route::resource('expenses', ExpenseController::class);
    Route::resource('debts', DebtController::class);
    Route::resource('incomes', IncomeController::class);
    Route::resource('budgets', BudgetController::class);
    Route::resource('savings', SavingsController::class);
    Route::post('savings/{saving}/add-amount', [SavingsController::class, 'addAmount'])->name('savings.addAmount');

    // Task Statistics
    Route::get('/tasks/statistics', [TaskController::class, 'getTaskStatistics'])->name('tasks.statistics');

    // Events
    Route::get('/events/create', [EventController::class, 'create'])->name('events.create');

    // Profile Management Routes
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile.index');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::put('/profile/password', [ProfileController::class, 'updatePassword'])->name('profile.password.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');



