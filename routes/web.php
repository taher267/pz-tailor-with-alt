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

Route::get('/', function () {
    return view('welcome');
})->name('welcome');

Route::middleware(['auth:sanctum',config('jetstream.auth_session'),'verified'])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
});

//Admin Routes
Route::group(['prefix'=>'admin','middleware'=>['isAdmin','auth:sanctum',config('jetstream.auth_session'),'verified']],function () {
    Route::get('/dashboard', App\Http\Livewire\Admin\AdminDashboardComponent::class)->name('admin.dashboard');
});

// //Manage Routes
Route::group(['prefix'=>'manage','middleware'=>['isManage','auth:sanctum',config('jetstream.auth_session'),'verified']],function () {
    Route::get('/dashboard', App\Http\Livewire\Manage\ManageDashboardComponent::class)->name('manage.dashboard');
    Route::get('/customers', App\Http\Livewire\Customer\AllCustomers::class)->name('customers');
    Route::get('/customers/new', App\Http\Livewire\Customer\NewCustomer::class)->name('customers.new');
    Route::get('/customers/edit/{id}', App\Http\Livewire\Customer\EditCustomer::class)->name('customers.edit');
    //Order
    Route::get('/orders', App\Http\Livewire\Customer\AllOrders::class)->name('orders');
    Route::get('/orders/new/{order_number}', App\Http\Livewire\Customer\NewOrder::class)->name('order.new');
    Route::get('/orders/new/{order_number}/add-item/{order_management_id}', App\Http\Livewire\Customer\NewOrder::class)->name('order.new.additem');
    Route::get('/orders/{order_number}/order-items/{order_management_id}', App\Http\Livewire\Customer\CustomerOrderItems::class)->name('customer.order.items');
    Route::get('/orders/{order_number}/order-upper-item/{order_management_id}/edit/{item_id}', App\Http\Livewire\Customer\CustomerUpperClothItemEdit::class)->name('customer.order.editupperitem');
    Route::get('/orders/{order_number}/order-lower-item/{order_management_id}/edit/{item_id}', App\Http\Livewire\Customer\CustomerLowerClothItemEdit::class)->name('customer.order.editloweritem');
    Route::get('/specific-orders', App\Http\Livewire\Customer\SpecificOrders::class)->name('specific.orders');

});