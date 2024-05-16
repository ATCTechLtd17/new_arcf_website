<?php

use App\Http\Controllers\AgentController;
use App\Http\Controllers\AuthAccountController;
use App\Http\Controllers\BankController;
use App\Http\Controllers\CashAtBankController;
use App\Http\Controllers\ChartOfAccountController;
use App\Http\Controllers\CustomerAdvanceController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DrawerCashController;
use App\Http\Controllers\ExpenseController;
use App\Http\Controllers\IncomeVsExpenseController;
use App\Http\Controllers\InvestmentController;
use App\Http\Controllers\InvestorController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\SupplierDepositController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth', 'disablePreventBack'])->group(function (){
    //auth
    Route::get('/', [DashboardController::class, 'dashboard'])->name('dashboard');
    Route::post('/logout', [AuthAccountController::class, 'logout'])->name('logout');
    Route::get('/dashboard', [DashboardController::class, 'dashboard'])->name('dashboard');
    Route::get('profile', [AuthAccountController::class, 'profile'])->name('profile');

    //agents
    Route::resource('/agents', AgentController::class);
    //suppliers
    Route::resource('/suppliers', SupplierController::class);
    //supplier deposit
    Route::resource('/supplier-deposits', SupplierDepositController::class);
    Route::get('/supplier-deposits-report', [SupplierDepositController::class, 'report'])->name('supplier-deposits-report');
    Route::get('/supplier-deposits/{id}/print', [SupplierDepositController::class, 'print'])->name('supplier-deposits.print');
    //services
    Route::resource('/services', ServiceController::class);
    //chart of accounts
    Route::resource('/chart-of-accounts', ChartOfAccountController::class);
    //banks
    Route::resource('/banks', BankController::class);
    //invoices
    Route::resource('/invoices', InvoiceController::class);
    Route::get('invoices/{id}/print', [InvoiceController::class, 'print'])->name('invoices.print');
    Route::get('invoices/{id}/details', [InvoiceController::class, 'details'])->name('invoices.details');
    //invoice due collections
    Route::get('/invoices-due-collections', [InvoiceController::class, 'dueCollection'])->name('invoices.due-collections');
    //invoices due payment
    Route::post('invoices/{id}/due-payment', [InvoiceController::class, 'storeDuePayment'])->name('invoices.due-payment');
    //due payments report
    Route::get('/invoices-due-payments-report', [InvoiceController::class, 'duePaymentReport'])->name('invoices-due-payments-report');
    //invoices invoices.collect-to-bank
    Route::get('/invoices/{id}/collect-to-bank', [InvoiceController::class, 'collectToBank'])->name('invoices.collect-to-bank');
    //invoices invoices.collect-to-bank store
    Route::post('invoices/{id}/collect-to-bank', [InvoiceController::class, 'storeCollectToBank'])->name('invoices.collect-to-bank.store');

    //expenses
    Route::resource('/expenses', ExpenseController::class);
    Route::get('expenses/{id}/print', [ExpenseController::class, 'print'])->name('expenses.print');
    //expenses-reports
    Route::get('expenses-details-report', [ExpenseController::class, 'detailsReport'])->name('expenses.details.report');
    //customers
    Route::resource('/customers', CustomerController::class);
    //investors
    Route::resource('/investors', InvestorController::class);
    //investments
    Route::resource('/investments', InvestmentController::class);
    //investment to deposits
    Route::get('/investment-to-deposit', [InvestmentController::class, 'deposit'])->name('investment-to-deposit');
    //incomeVsExpense
    Route::get('income-vs-expense', [IncomeVsExpenseController::class, 'index'])->name('income-vs-expense.index');
    Route::get('income-vs-expense-print', [IncomeVsExpenseController::class, 'printReports'])->name('income-vs-expense-print');
    //cash-at-banks
    Route::resource('/cash-at-banks', CashAtBankController::class);
    //cash-at-bank to deposits
    Route::get('/cash-at-bank-to-deposits', [CashAtBankController::class, 'deposit'])->name('cash-at-bank-to-deposits');
    //drawer-cash-to-cash-at-bank
    Route::get('/drawer-cash-to-cash-at-bank', [CashAtBankController::class, 'drawerCashToBank'])->name('drawer-cash-to-cash-at-bank');
    //cash-at-bank to drawer cash
    Route::get('/cash-at-bank-to-drawer-cash', [CashAtBankController::class, 'drawer'])->name('cash-at-bank-to-drawer-cash');
    //drawer-cashes
    Route::resource('/drawer-cashes', DrawerCashController::class);
    //drawer-cash-to-supplier-deposits
    Route::get('/drawer-cash-to-supplier-deposits', [DrawerCashController::class, 'supplierDeposit'])->name('drawer-cash-to-supplier-deposits');
    //customer-advances
    Route::resource('/customer-advances', CustomerAdvanceController::class);
    Route::get('/customer-advance/{id}/print', [CustomerAdvanceController::class, 'print'])->name('customer-advances.print');
    Route::get('/customer-advances-details', [CustomerAdvanceController::class, 'details'])->name('customer-advances.details');

    Route::get('manage-user', [AgentController::class, 'manageUser'])->name('manage.user');
    Route::get('add-nominee', [AgentController::class, 'addNominee'])->name('addnominee');
    Route::get('/nominee-details/edit/{id}', [AgentController::class, 'nomineeDetialsEdit'])->name('nomineedetails.edit');
    Route::post('/nominee-details/update/{id}', [AgentController::class, 'nomineeDetialsUpdate'])->name('nomineedetails.update');
    Route::get('passport-service-application', [AgentController::class, 'passportServiceApplication'])->name('passport.service.application');
    Route::get('investment-application', [AgentController::class, 'investmentApplication'])->name('investment.application');
    Route::get('investment-application-details-list', [AgentController::class, 'investmentApplicationDetailsList'])->name('investment.application.details.list');
    Route::get('document-upload', [AgentController::class, 'documentUpload'])->name('document-upload');
});
