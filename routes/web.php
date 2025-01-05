<?php

use App\Http\Controllers\AttributeController;
use App\Http\Controllers\BrandController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\VerificationController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('dashboard.admin.dashboard');
});


/*
*
Admin And Seller Authetication Routes
*
*/

Route::controller(UserController::class)->group(function () {
    Route::get('portal', 'index')->name('portal');
    Route::get('register', 'get_register_page')->name('register.seller');
    Route::post('register', 'register_seller')->name('store.seller');
    Route::post('portal', 'login')->name('login');
    Route::post('/logout', 'logout')->name('logout');
});

Route::controller(VerificationController::class)->group(function () {
    Route::get('verification', 'index')->name('verification');
    Route::post('verification', 'store')->name('verifications.store');
    Route::post('approve-user', 'approve_user')->name('verification.approve');
    Route::post('reject-user', 'reject_user')->name('verification.reject');
});


Route::controller(ProductController::class)->group(function () {
    Route::get('add-product', 'index_seller')->name('product.seller');
    Route::get('add-new-product', 'add_new_product')->name('product.new');
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




// Ajax Calls
Route::get('/brands/{categoryId}', [ProductController::class, 'fetchBrands']);
Route::get('/category/{categoryId}/attributes', [ProductController::class, 'getAttributesForCategory']);
