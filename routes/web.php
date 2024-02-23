<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
use App\Http\Controllers\{
    Controller,
    LoginController,
    DashboardController,
    UsersController,
    SettingsController,
    MembersController,
    MinistriesController,
    ExpensesController,
    ServicesController,
    TransactionsController
};

//Login
Route::get('/', [LoginController::class, 'login'])->name('login');


// Logout
Route::get('/logout', [LoginController::class, 'logout'])->name('logout');


// Auth login
Route::post('/authenticate', [LoginController::class, 'authenticate'])->name('authenticate');


Route::middleware(['auth'])->group(function () {

    // Universal Routes
    Route::post('/add', [Controller::class, 'add'])->name('add');
    Route::post('/edit', [Controller::class, 'edit'])->name('edit');
    Route::post('/activate', [Controller::class, 'activate'])->name('activate');
    Route::post('/deactivate', [Controller::class, 'deactivate'])->name('deactivate');
    Route::post('/delete', [Controller::class, 'delete'])->name('delete');

    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'dashboard'])->name('dashboard');
    Route::get('/get_monthly_offerings_report', [DashboardController::class, 'getMonthlyOfferingsReport'])->name('get_monthly_offerings_report');
    Route::get('/get_expenses_report', [DashboardController::class, 'getExpensesReport'])->name('get_expenses_report');
    Route::get('/get_ministries_report', [DashboardController::class, 'getMinistriesReport'])->name('get_ministries_report');
    Route::get('/get_activity_logs', [DashboardController::class, 'getActivityLogs'])->name('get_activity_logs');
    
    // Users
    Route::get('/users', [UsersController::class, 'users'])->name('users');
    Route::get('/get_users', [UsersController::class, 'getUsers'])->name('get_users');
    Route::post('/reset_pass', [UsersController::class, 'resetPassword'])->name('reset_pass');
    Route::post('/add_user', [UsersController::class, 'addUser'])->name('add_user');

    // Members
    Route::get('/members', [MembersController::class, 'members'])->name('members');
    Route::get('/get_members', [MembersController::class, 'getMembers'])->name('get_members');
    Route::post('/add_member', [MembersController::class, 'addMember'])->name('add_member');
    Route::post('/add_transaction', [MembersController::class, 'addTransaction'])->name('add_transaction');
    Route::get('/view_member/{id}', [MembersController::class, 'viewMember'])->name('view_member');
    Route::post('/set_member_firstfruit', [MembersController::class, 'setMemberFirstfruit'])->name('set_member_firstfruit');
    Route::get('/get_member_offering_summary/{id}', [MembersController::class, 'viewMemberOfferingSummary'])->name('get_member_offering_summary');

    //Transactions
    Route::get('/transactions', [TransactionsController::class, 'transactions'])->name('transactions');
    Route::get('/get_transactions', [TransactionsController::class, 'getTransactions'])->name('get_transactions');
    Route::post('/edit_transaction', [TransactionsController::class, 'editTransaction'])->name('edit_transaction');
    Route::get('/get_transaction_offerings/{id}', [TransactionsController::class, 'getTransactionOfferings'])->name('get_transaction_offerings');
    Route::get('/export_transaction/{id}', [TransactionsController::class, 'exportTransaction'])->name('export_transaction');
    Route::get('/generate_summary_reports/{date}/{service}/{sort}', [TransactionsController::class, 'export_users_from_view'])->name('generate_summary_reports');
    // Route::get('/generate_summary_reports/{date}/{service}/{sort}', [TransactionsController::class, 'generateSummaryReports'])->name('generate_summary_reports');

    
   
    // Ministries
    Route::get('/ministries', [MinistriesController::class, 'ministries'])->name('ministries');
    Route::get('/get_ministries', [MinistriesController::class, 'getMinistries'])->name('get_ministries');

    // Services
    Route::get('/services', [ServicesController::class, 'services'])->name('services');
    Route::get('/get_services', [ServicesController::class, 'getServices'])->name('get_services');


    // Expenses
    Route::get('/expenses', [ExpensesController::class, 'expenses'])->name('expenses');
    Route::get('/get_expenses', [ExpensesController::class, 'getExpenses'])->name('get_expenses');
    Route::post('/add_expense', [ExpensesController::class, 'addExpense'])->name('add_expense');

    // Settings
    Route::get('/settings', [SettingsController::class, 'settings'])->name('settings');
    Route::post('/change_pass', [SettingsController::class, 'changePassword'])->name('change_pass');
    Route::get('/check_password', [SettingsController::class, 'checkPassword'])->name('check_password');

    // Validations
    Route::get('/check_unique_email',         [UsersController::class, 'checkUniqueEmail']);
    Route::get('/check_unique_email_edit',    [UsersController::class, 'checkUniqueEmailEdit']);

    Route::get('/check_unique_member_name',         [MembersController::class, 'checkUniqueMemberName']);
    Route::get('/check_unique_member_name_edit',    [MembersController::class, 'checkUniqueMemberNameEdit']);

    Route::get('/check_unique_service_name',         [ServicesController::class, 'checkUniqueServiceName']);
    Route::get('/check_unique_service_name_edit',    [ServicesController::class, 'checkUniqueServiceNameEdit']);
});
