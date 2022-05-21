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

Route::get('/mytest', App\Http\Livewire\MyTest::class)->name('mytest');

Route::middleware(['auth:sanctum',config('jetstream.auth_session'),'verified'])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
});

//Admin Routes
Route::group(['prefix'=>'admin','middleware'=>['isAdmin','auth:sanctum',config('jetstream.auth_session'),'verified']],function () {
    Route::get('/dashboard', App\Http\Livewire\Admin\AdminDashboardComponent::class)->name('admin.dashboard');
    Route::get('/products', App\Http\Livewire\Admin\AdminProducts::class)->name('admin.products');
    Route::get('/product-design-group', App\Http\Livewire\Admin\AdminProductDesignGroup::class)->name('admin.product.design.group');
    Route::get('/product-design-items', App\Http\Livewire\Admin\AdminProductDesignItem::class)->name('admin.product.design.items');
});

// //Manage Routes
Route::group(['prefix'=>'manage','middleware'=>['isManage','auth:sanctum',config('jetstream.auth_session'),'verified']],function () {
    Route::get('/dashboard', App\Http\Livewire\Manage\ManageDashboardComponent::class)->name('manage.dashboard');
    Route::get('/customers', App\Http\Livewire\Customer\AllCustomers::class)->name('customers');
    Route::get('/customers/new', App\Http\Livewire\Customer\NewCustomer::class)->name('customers.new');
    Route::get('/customers/edit/{id}', App\Http\Livewire\Customer\EditCustomer::class)->name('customers.edit');
    Route::get('/customers/orders/{order_number}', App\Http\Livewire\Customer\SingleCustomerOrders::class)->name('customers.orders');
    //Order
    Route::get('/orders/{status}', App\Http\Livewire\Customer\CustomerOrders::class)->name('orders');
    Route::get('/orders-items', App\Http\Livewire\Customer\AllOrdersItems::class)->name('orders.items');
    Route::get('/orders/new/{order_number}', App\Http\Livewire\Customer\NewOrder::class)->name('order.new');
    Route::get('/orders/unaccomplished', App\Http\Livewire\Customer\IncompleteOrder::class)->name('orders.unaccomplished');
    Route::get('/orders/add-new-item/{order_management_id}', App\Http\Livewire\Customer\NewOrder::class)->name('order.new.additem');
    Route::get('/orders/{order_number}/order-items/{order_management_id}', App\Http\Livewire\Customer\CustomerOrderItems::class)->name('customer.order.items');
    
    Route::get('/orders/order-upper-item/edit/{item_id}', App\Http\Livewire\Customer\CustomerUpperClothItemEdit::class)->name('customer.order.editupperitem');

    Route::get('/orders/order-lower-item/edit/{item_id}', App\Http\Livewire\Customer\CustomerLowerClothItemEdit::class)->name('customer.order.editloweritem');
    
    // Route::get('/specific-orders/{status}', App\Http\Livewire\Customer\SpecificOrders::class)->name('specific.orders');


});