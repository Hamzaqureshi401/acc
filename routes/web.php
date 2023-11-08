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
Route::get('/', \App\Http\Livewire\Login::class)->name('login')->middleware('install');
Route::get('/forgetpassword', \App\Http\Livewire\ForgetPassword::class)->name('forget-password');
Route::get('/resetpassword/{token}', \App\Http\Livewire\ResetPassword::class)->name('reset-password');
Route::group(['prefix' => 'admin/', 'middleware' => ['admin','install']], function () {
    Route::get('/dashboard', \App\Http\Livewire\Admin\Home::class)->name('admin.dashboard');
    Route::get('/pos', \App\Http\Livewire\Admin\Orders\PosScreen::class)->name('admin.pos');
    
    Route::group(['prefix' => 'inventory/'], function () {
        Route::get('/products', \App\Http\Livewire\Admin\Products\ViewProducts::class)->name('admin.view_products');
        Route::get('/products/{id}/addons', \App\Http\Livewire\Admin\Products\Addons::class)->name('admin.addons');
        Route::get('/products/add', \App\Http\Livewire\Admin\Products\AddProducts::class)->name('admin.add_products');
        Route::get('/products/edit/{id}', \App\Http\Livewire\Admin\Products\EditProducts::class)->name('admin.edit_product');
        Route::get('/category', \App\Http\Livewire\Admin\ProductCategory\ProductCategory::class)->name('admin.product_category');
        Route::get('/supplier', \App\Http\Livewire\Admin\Supplier\Supplier::class)->name('admin.supplier');
    });

    Route::group(['prefix' => 'orders/'], function () {
        Route::get('/', \App\Http\Livewire\Admin\Orders\Orders::class)->name('admin.orders');
        Route::get('/view/{id}', \App\Http\Livewire\Admin\Orders\ViewOrder::class)->name('admin.view_order');
        Route::get('/print/{order}/{printer}', \App\Http\Livewire\Admin\Orders\PrintOrder::class)->name('admin.print_order');
        Route::get('/status-screen', \App\Http\Livewire\Admin\Orders\OrderStatusScreen::class)->name('admin.order_status_screen');
    });
    
    Route::group(['prefix' => 'staffs/'], function () {
        Route::get('/', \App\Http\Livewire\Admin\Staff\ViewStaffs::class)->name('admin.staffs');
        Route::get('/create', \App\Http\Livewire\Admin\Staff\CreateStaff::class)->name('admin.create_staff');
        Route::get('/edit/{id}', \App\Http\Livewire\Admin\Staff\EditStaff::class)->name('admin.edit_staff');
    });

    Route::group(['prefix' => 'settings/'], function () {
        Route::get('/app', \App\Http\Livewire\Admin\Settings\AppSettings::class)->name('admin.app_settings');
        Route::get('/mail', \App\Http\Livewire\Admin\Settings\MailSettings::class)->name('admin.mail_settings');
        Route::get('/account', \App\Http\Livewire\Admin\Settings\AccountSettings::class)->name('admin.account_settings');
    });
    Route::group(['prefix' => 'reports/'], function () {
        Route::get('/sales', \App\Http\Livewire\Admin\Reports\SalesReport::class)->name('admin.sales_report');
        Route::get('/day-wise', \App\Http\Livewire\Admin\Reports\DaywiseSalesReport::class)->name('admin.daywise_report');
        Route::get('/item-sales', \App\Http\Livewire\Admin\Reports\ItemSalesReport::class)->name('admin.item_sales_report');
        Route::get('/customer', \App\Http\Livewire\Admin\Reports\CustomerReport::class)->name('admin.customer_report');
        Route::get('/stock', \App\Http\Livewire\Admin\Reports\StockReport::class)->name('admin.stock');
        Route::get('/low_stock', \App\Http\Livewire\Admin\Reports\LowStockReport::class)->name('admin.low_stock');
        
        Route::get('/client-report', \App\Http\Livewire\Admin\Reports\ClientReport::class)->name('client.report');

        Route::get('/appointment-report', \App\Http\Livewire\Admin\Reports\AppointmentReports::class)->name('appointment.report');
        
        Route::get('/invoice-payment-pending-report', \App\Http\Livewire\Admin\Reports\InvoicePaymentPendingReport::class)->name('invoice.payment.pending.report');
        Route::get('/quotation-report', \App\Http\Livewire\Admin\Reports\QuotationReport::class)->name('quotation.report');

        //  Route::get('/client-details/{id}', \App\Http\Livewire\Admin\Reports\ClientReport::class)->name('admin.low_stock');



    });
    Route::group(['prefix' => 'translations/'], function () {
        Route::get('/', \App\Http\Livewire\Admin\Translation\Translations::class)->name('admin.translations');
        Route::get('/add', \App\Http\Livewire\Admin\Translation\AddTranslations::class)->name('admin.add_translation');
        Route::get('/edit/{id}', \App\Http\Livewire\Admin\Translation\EditTranslations::class)->name('admin.edit_translation');
    });
    Route::group(['prefix' => 'leads/'], function () {
        Route::get('/', \App\Http\Livewire\Admin\Leads\Leads::class)->name('admin.leads');
        Route::get('/wpform-leads', \App\Http\Livewire\Admin\Leads\WPFormLeads::class)->name('admin.wpformleads');
        Route::get('/quote-leads', \App\Http\Livewire\Admin\Leads\QuoteLeads::class)->name('admin.quote_leads');
        Route::get('/product-leads', \App\Http\Livewire\Admin\Leads\ProductLeads::class)->name('admin.product_leads');
    });

    Route::group(['prefix' => 'quotations/'], function () {
        Route::get('/view', \App\Http\Livewire\Admin\Quotations\ViewQuotations::class)->name('admin.view_quotations');
        Route::get('/add', \App\Http\Livewire\Admin\Quotations\AddQuotations::class)->name('admin.add_quotation');
        Route::get('/edit/{id}', \App\Http\Livewire\Admin\Quotations\EditQuotations::class)->name('admin.edit_quotation');
        Route::get('/print/{quotation}/{printer}', \App\Http\Livewire\Admin\Quotations\PrintQuotations::class)->name('admin.print_quotation');
    });

    Route::group(['prefix' => 'invoices/'], function () {
        Route::get('/view', \App\Http\Livewire\Admin\Invoices\ViewInvoices::class)->name('admin.view_invoices');
        Route::get('/add', \App\Http\Livewire\Admin\Invoices\AddInvoices::class)->name('admin.add_invoice');
        Route::get('/edit/{id}', \App\Http\Livewire\Admin\Invoices\EditInvoices::class)->name('admin.edit_invoice');
        Route::get('/print/{invoice}/{printer}/{per}/{no}', \App\Http\Livewire\Admin\Invoices\PrintInvoices::class)->name('admin.print_invoice');
    });

    Route::get('/tables', \App\Http\Livewire\Admin\Tables\Tables::class)->name('admin.tables');
    Route::get('/clients', \App\Http\Livewire\Admin\Customers\Customers::class)->name('admin.customers');
    Route::get('/stock', \App\Http\Livewire\Admin\Inventory\StockReportDateWise::class)->name('admin.inventory');
    Route::get('/services', \App\Http\Livewire\Admin\Services\Services::class)->name('admin.services');
    Route::get('/appointments', \App\Http\Livewire\Admin\Appointments\Appointments::class)->name('admin.appointments');
    Route::get('/calender', \App\Http\Livewire\Admin\Appointments\Calender::class)->name('admin.calender');
});


Route::group(['prefix' => 'install/'], function () {
    Route::get('/', \App\Http\Livewire\Installer\Installer::class)->name('install');
});