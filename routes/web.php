<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AttributeController;
use App\Http\Controllers\BrandController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\SellerPaymentMethodController;
use App\Http\Controllers\StoreFrontController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\UserProfileController;
use App\Http\Controllers\VerificationController;
use App\Models\SellerPaymentMethod;
use Illuminate\Support\Facades\Route;


Route::controller(StoreFrontController::class)->group(function () {
    Route::get('/', 'index')->name('home');
    Route::get('product/{slug}', 'show_product')->name('show.product');
    Route::get('/shop', 'show_shop')->name('show.shop');


    Route::get('/login', 'show_login')->name('buyer.login');
    Route::post('/login', 'login')->name('buyer.login.post');
    Route::get('/register', 'show_register')->name('buyer.register');
    Route::post('/register', 'register')->name('buyer.register.post');

    Route::get('/account', 'edit_user')->name('buyer.account.edit');
    Route::put('/account', 'update_user')->name('buyer.account.update');

    Route::get('/orders', 'indexOrders')->name('buyer.orders.index');
    Route::get('/orders/{order}', 'showOrder')->name('buyer.orders.show');

    Route::post('mark-delivered', 'mark_complete')->name('buyer.mark.delivered');
});

Route::get('profile/{slug}', [UserProfileController::class, 'index'])->name('user.profile');
Route::put('/profile', [UserProfileController::class, 'update'])->name('profile.update');

Route::prefix('payment-methods')->name('payment_methods.')->group(function () {
    Route::get('/', [SellerPaymentMethodController::class, 'index'])->name('index');
    Route::post('/', [SellerPaymentMethodController::class, 'store'])->name('store');
    Route::delete('{id}', [SellerPaymentMethodController::class, 'destroy'])->name('destroy');
});

Route::middleware(['auth'])->group(function () {
    Route::get('cart', [OrderController::class, 'showCart'])->name('cart.show');
    Route::post('cart/add/{product}', [OrderController::class, 'addToCart'])->name('cart.add');
    Route::post('cart/update', [OrderController::class, 'updateCart'])->name('cart.update');
    Route::post('cart/remove', [OrderController::class, 'removeCart'])->name('cart.remove');
    Route::delete('cart/empty', [OrderController::class, 'emptyCart'])->name('cart.empty');
    Route::post('order', [OrderController::class, 'store'])->name('order.store');
    Route::get('/order/success', [OrderController::class, 'success'])->name('order.success');


    Route::get('/seller/all-orders', [OrderController::class, 'get_seller_order'])->name('seller.all.orders');
    Route::get('/seller/pending-orders', [OrderController::class, 'get_seller_pending_order'])->name('seller.pending.orders');
    Route::get('/seller/completed-orders', [OrderController::class, 'get_seller_completed_order'])->name('seller.completed.orders');
    Route::get('/seller/dispatched-orders', [OrderController::class, 'get_seller_dispatched_order'])->name('seller.dispatched.orders');
    Route::post('/orders/{order}/payment-received', [OrderController::class, 'markPaymentReceived'])->name('orders.payment.received');
    Route::post('/orders/{order}/dispatch', [OrderController::class, 'dispatchOrder'])->name('orders.dispatch');

    Route::get('/admin/all-orders', [OrderController::class, 'get_admin_order'])->name('admin.all.orders');
    Route::post('/orders/{id}/update-status', [OrderController::class, 'updateStatus'])->name('orders.status.update');
});

Route::controller(AdminController::class)->group(function () {
    Route::get('/all-sellers', 'all_sellers')->name('admin.show.sellers');
    Route::get('/all-products', 'all_products')->name('admin.show.all.products');
    Route::get('/pending-products', 'pending_products')->name('admin.show.pending.products');
    Route::get('/approved-products', 'approved_products')->name('admin.show.approved.products');
    Route::get('/rejected-products', 'rejected_products')->name('admin.show.rejected.products');
    Route::post('/approve-product/{id}', 'approve_product')->name('admin.approve.product');
    Route::post('/reject-product/{id}', 'reject_product')->name('admin.reject.product');
});

Route::controller(UserController::class)->group(function () {
    Route::get('portal', 'index')->name('portal');
    Route::get('seller/register', 'get_register_page')->name('register.seller');
    Route::post('seller/register', 'register_seller')->name('store.seller');
    Route::post('portal', 'login')->name('login');
    Route::post('/logout', 'logout')->name('logout');
});

Route::controller(VerificationController::class)->group(function () {
    Route::get('verification', 'index')->name('verification');
    Route::post('verification', 'store')->name('verifications.store');
    Route::post('approve-user', 'approve_user')->name('verification.approve');
    Route::post('reject-user', 'reject_user')->name('verification.reject');
});



Route::controller(CategoryController::class)->group(function () {
    Route::get('category', 'index')->name('category');
    Route::post('category', 'add')->name('category.add');
    Route::get('edit-category/{slug}', 'edit')->name('category.edit');
    Route::put('/category/{categoryId}', 'update')->name('category.update');
    Route::delete('/category/{categoryId}', 'delete')->name('category.delete');
    Route::post('update-category-brands', 'updateBrand')->name('category.update.brand');
    Route::delete('/category/{categoryId}/brand/{brandId}', 'removeBrand')->name('category.remove.brand');
});

Route::controller(BrandController::class)->group(function () {
    Route::get('brands', 'index')->name('brand.index');
    Route::post('brands', 'add')->name('brand.add');
    Route::get('brands/{slug}/edit', 'edit')->name('brand.edit');
    Route::put('brands/{brandId}', 'update')->name('brand.update');
    Route::delete('brands/{brandId}', 'delete')->name('brand.delete');
});


Route::prefix('attributes')->name('attribute.')->controller(AttributeController::class)->group(function () {
    // Index page for listing all attributes
    Route::get('/', 'index')->name('index');

    // Create a new attribute
    Route::get('create', 'create')->name('create');
    Route::post('/', 'store')->name('store');

    // Edit an attribute
    Route::get('{id}/edit', 'edit')->name('edit');
    Route::put('{id}', 'update')->name('update');

    // Delete an attribute
    Route::delete('{id}', 'destroy')->name('destroy');

    // Manage attribute values
    Route::get('{attributeId}/values', 'manageValues')->name('manageValues');
    Route::post('{attributeId}/values', 'storeValues')->name('storeValues');
    Route::put('{attributeId}/values/{valueId}', 'updateValue')->name('updateValue');
    Route::delete('{attributeId}/values/{valueId}', 'destroyValue')->name('destroyValue');

    // Assign attribute to category
    Route::get('{attributeId}/assign', 'assignCategory')->name('assignCategory');
    Route::post('{attributeId}/assign', 'storeCategoryAssignment')->name('storeCategoryAssignment');
});

Route::controller(ProductController::class)->group(function () {
    Route::get('products', 'index')->name('product.index');
    Route::get('seller/approved-products', 'approved_products')->name('seller.approved.products');
    Route::get('seller/pending-products', 'pending_products')->name('seller.pending.products');
    Route::get('seller/rejected-products', 'reject_products')->name('seller.rejected.products');


    Route::get('brands/{categoryId}', 'getBrands')->name('product.getBrands');
    Route::get('/attributes-values/{categoryId}', 'getAttributesAndValues')->name('product.getAttributesAndValues');
    Route::delete('/product/{id}', 'destroy')->name('product.destroy');
    Route::get('/categoryget/{slug}', 'findCategoryBySlug')->name('category.findBySlug');

    // New Product Routes
    Route::get('add-new-product', 'show_add_new_product_page')->name('product.add.new');
    Route::post('add-new-product', 'store')->name('product.add.new.store');
    Route::get('/product/{id}/edit', 'edit')->name('product.edit');
    Route::put('/product/{id}', 'update')->name('product.update');


    // Used Products Routes
    Route::get('add-used-product', 'show_add_used_product_page')->name('product.add.used');
    Route::post('add-used-product', 'store_used')->name('product.add.used.store');
    Route::get('/product/{id}/edit-used', 'edit_used')->name('product.used.edit');
    Route::put('/used-product/{id}', 'update_used')->name('product.used.update');


    // Complete Pc Routes
    Route::get('add-complete-pc', 'show_add_complete_pc_product_page')->name('product.add.completepc');
    Route::post('add-complete-pc', 'store_complete_pc')->name('product.add.complete.pc');
    Route::get('/product/{id}/edit-complete-pc', 'edit_complete_pc')->name('product.complete.pc.edit');
});
