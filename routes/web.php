<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AttributeController;
use App\Http\Controllers\BrandController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\HomePageSliderController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\SellerPaymentMethodController;
use App\Http\Controllers\StaticPageController;
use App\Http\Controllers\StoreFrontController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\UserProfileController;
use App\Http\Controllers\VerificationController;
use Illuminate\Support\Facades\Route;


// =========================================================================
//                       STOREFRONT (PUBLIC) ROUTES
// =========================================================================
// These routes are for the main storefront, accessible by all users.
Route::controller(StoreFrontController::class)->group(function () {
    // Home Page Route
    Route::get('/', 'index')->name('home');  // Displays the main landing page.

    // Product Details Page Route
    Route::get('product/{slug}', 'show_product')->name('show.product'); // Displays details of a specific product.

    // Shop Page Route
    Route::get('/shop', 'show_shop')->name('show.shop');  // Displays a list of products (shop page).

    // =========================================================================
    //                  Authentication Routes (Guest Only)
    // =========================================================================
    // These routes are for user authentication and are accessible only by guests (non-logged-in users).
    Route::middleware('guest')->group(function () {
        // Login Page Route
        Route::get('/login', 'show_login')->name('buyer.login'); // Displays the login form.
        Route::post('/login', 'login')->name('buyer.login.post'); // Handles user login submission.

        // Register Page Route
        Route::get('/register', 'show_register')->name('buyer.register'); // Displays the registration form.
        Route::post('/register', 'register')->name('buyer.register.post'); // Handles user registration submission.
    });

    // =========================================================================
    //           User Account and Order Routes (Authenticated Buyers)
    // =========================================================================
    // These routes are accessible only to authenticated users with the 'buyer' role.
    Route::middleware('auth', 'buyer')->group(function () {
        // User Account Edit Route
        Route::get('/account', 'edit_user')->name('buyer.account.edit'); // Displays the user account edit form.
        Route::put('/account', 'update_user')->name('buyer.account.update'); // Handles the update of user account information.

        // Order Routes
        Route::get('/orders', 'indexOrders')->name('buyer.orders.index'); // Displays a list of the buyer's orders.
        Route::get('/orders/{order}', 'showOrder')->name('buyer.orders.show'); // Displays details for a specific order of the buyer.
        Route::post('mark-delivered', 'mark_complete')->name('buyer.mark.delivered'); // Handles marking an order as delivered by buyer.
    });

    // =========================================================================
    //                   Category Display Routes
    // =========================================================================
    // These routes are for displaying categories and are accessible by all users.
    Route::get('/all-categories', 'show_all_categories')->name('show.all.categories'); // Displays a list of all product categories.
    Route::get('/category-single/{slug}', 'show_single_category')->name('show.single.categories'); // Displays a specific category.

    // =========================================================================
    //                     Seller Portfolio Routes
    // =========================================================================
    // These routes display seller portfolio to the public
    Route::get('/seller-porfolio/{slug}', 'show_seller_portfolio')->name('show.seller.portfolio'); // Displays a specific seller's portfolio.

    // Become Seller Route
    Route::get('become-seller', 'become_seller')->name('become.seller'); // Display a page for a user to request becoming a seller.
});

// =========================================================================
//                      STATIC PAGES ROUTES
// =========================================================================
// These routes are for displaying static content pages such as terms, FAQs, etc.
Route::controller(StaticPageController::class)->group(function () {
    Route::get('/terms-and-conditions', 'terms')->name('terms');  // Terms & Conditions page.
    Route::get('/faqs', 'faqs')->name('faqs');  // Frequently Asked Questions page.
    Route::get('/about-us', 'about')->name('about'); // About Us page.
    Route::get('/contact-us', 'contact')->name('contact'); // Contact Us page.
});

// =========================================================================
//                       ADMIN SECTION ROUTES
// =========================================================================
// These routes are for administrative tasks and are restricted to admin users.
Route::middleware('auth', 'admin')->group(function () {
    // =========================================================================
    //                Admin Pages Management Routes
    // =========================================================================
    // These routes are for editing and managing static pages by admin users.

    Route::resource('sliders', HomePageSliderController::class)->names([
        'index' => 'slider.index',
        'create' => 'slider.create',
        'store' => 'slider.store',
        'edit' => 'slider.edit',
        'update' => 'slider.update',
        'destroy' => 'slider.destroy',
    ]);
    Route::prefix('/admin/pages')->name('admin.')->group(function () {

        // Admin Controller Routes
        Route::controller(AdminController::class)->group(function () {
            // Terms Management Route
            Route::get('/terms', 'termsEdit')->name('terms.edit'); // Displays the form to edit terms and conditions.
            Route::put('/terms', 'termsUpdate')->name('terms.update'); // Handles the update of terms and conditions.

            // About Us Management Route
            Route::get('/about', 'aboutEdit')->name('about.edit'); // Displays the form to edit about us page.
            Route::put('/about', 'aboutUpdate')->name('about.update'); // Handles the update of the about us page.

            // Contact Us Management Route
            Route::get('/contact', 'contactEdit')->name('contact.edit'); // Displays the form to edit contact us page.
            Route::put('/contact', 'contactUpdate')->name('contact.update'); // Handles the update of the contact us page.


        });


        // =========================================================================
        //                  Admin FAQs Management Routes
        // =========================================================================
        // These routes are for managing FAQs by admin users.
        Route::get('/faqs', [AdminController::class, 'faqsIndex'])->name('faqs.index');
        Route::get('/faqs/create', [AdminController::class, 'faqsCreate'])->name('faqs.create');
        Route::post('/faqs', [AdminController::class, 'faqsStore'])->name('faqs.store');
        Route::get('/faqs/{faq}/edit', [AdminController::class, 'faqsEdit'])->name('faqs.edit');
        Route::put('/faqs/{faq}', [AdminController::class, 'faqsUpdate'])->name('faqs.update');
        Route::delete('/faqs/{faq}', [AdminController::class, 'faqsDestroy'])->name('faqs.destroy');
    });
});


// =========================================================================
//         PROFILE AND PAYMENT METHODS ROUTES (ADMIN & SELLER)
// =========================================================================
// These routes are for user profiles and payment methods, accessible by admin and seller users.
Route::middleware(['auth', 'adminOrSeller'])->group(function () {
    // User Profile Routes
    Route::prefix('profile')->group(function () {
        Route::get('/{slug}', [UserProfileController::class, 'index'])->name('user.profile'); // Displays a user's profile.
        Route::put('/', [UserProfileController::class, 'update'])->name('profile.update'); // Handles updating a user's profile.
    });

    // Payment Methods Routes
    Route::prefix('payment-methods')->name('payment_methods.')->controller(SellerPaymentMethodController::class)->group(function () {
        Route::get('/', 'index')->name('index'); // Displays available payment methods.
        Route::post('/', 'store')->name('store'); // Handles the storage of a new payment method.
        Route::delete('{id}', 'destroy')->name('destroy'); // Handles the deletion of a payment method.
    });
});

// =========================================================================
//                       CART MANAGEMENT ROUTES
// =========================================================================
// These routes are for managing the shopping cart.
Route::prefix('cart')->name('cart.')->controller(OrderController::class)->group(function () {
    Route::get('/', 'showCart')->name('show'); // Displays the current shopping cart.
    Route::middleware(['notAdminOrBuyer'])->post('/add/{product}', 'addToCart')->name('add');  // Handles adding a product to the cart (restricted for admin and buyer)
});

// =========================================================================
//                      AUTHENTICATED USER ROUTES
// =========================================================================
// These routes are accessible to all authenticated users.
Route::middleware(['auth'])->group(function () {
    // =========================================================================
    //                      Cart Management Routes
    // =========================================================================
    // These routes are for updating and managing the shopping cart.
    Route::prefix('cart')->name('cart.')->controller(OrderController::class)->group(function () {
        Route::post('/update', 'updateCart')->name('update'); // Updates the quantities of items in the cart.
        Route::post('/remove', 'removeCart')->name('remove'); // Removes an item from the cart.
        Route::delete('/empty', 'emptyCart')->name('empty'); // Empties the entire shopping cart.
    });

    // =========================================================================
    //                        General Order Routes
    // =========================================================================
    // These routes are for placing and viewing orders.
    Route::post('/order', [OrderController::class, 'store'])->name('order.store'); // Handles creation of new order.
    Route::get('/order/success', [OrderController::class, 'success'])->name('order.success'); // Displays success message after order completion.

    // =========================================================================
    //                    Seller Specific Order Routes
    // =========================================================================
    // These routes are specific to sellers and are used for managing their orders.
    Route::middleware(['seller'])->group(function () {
        Route::prefix('seller')->name('seller.')->controller(OrderController::class)->group(function () {
            Route::get('/all-orders', 'get_seller_order')->name('all.orders'); // Displays all orders of the seller.
            Route::get('/pending-orders', 'get_seller_pending_order')->name('pending.orders'); // Displays all pending orders of the seller.
            Route::get('/completed-orders', 'get_seller_completed_order')->name('completed.orders'); // Displays all completed orders of the seller.
            Route::get('/dispatched-orders', 'get_seller_dispatched_order')->name('dispatched.orders'); // Displays all dispatched orders of the seller.
        });

        // Order Status Update Routes
        Route::controller(OrderController::class)->group(function () {
            Route::post('/orders/{order}/payment-received', 'markPaymentReceived')->name('orders.payment.received'); // Handles marking payment received for an order.
            Route::post('/orders/{order}/dispatch', 'dispatchOrder')->name('orders.dispatch'); // Handles dispatching an order.
        });
    });

    // =========================================================================
    //                    Admin Specific Order Routes
    // =========================================================================
    // These routes are specific to admin and used for managing orders.
    Route::middleware(['admin'])->group(function () {
        Route::prefix('/admin')->name('admin.')->controller(OrderController::class)->group(function () {
            Route::get('/all-orders', 'get_admin_order')->name('all.orders'); // Displays all orders for admin.
        });

        // Admin Order Status Update Route
        Route::post('/orders/{id}/update-status', [OrderController::class, 'updateStatus'])->name('orders.status.update'); // Handles updating the status of an order.
    });
});

// =========================================================================
//      ADMIN PRODUCT AND SELLER MANAGEMENT ROUTES
// =========================================================================
// These routes are for product and seller management, accessible only by admins.
Route::middleware(['auth', 'admin'])->group(function () {
    Route::prefix('/admin')->name('admin.')->controller(AdminController::class)->group(function () {
        // All Sellers Route
        Route::get('/all-sellers', 'all_sellers')->name('show.sellers'); // Displays a list of all sellers.
        // All Products Route
        Route::get('/all-products', 'all_products')->name('show.all.products'); // Displays all products.
        // Pending Products Route
        Route::get('/pending-products', 'pending_products')->name('show.pending.products'); // Displays pending products.
        // Approved Products Route
        Route::get('/approved-products', 'approved_products')->name('show.approved.products'); // Displays approved products.
        // Rejected Products Route
        Route::get('/rejected-products', 'rejected_products')->name('show.rejected.products'); // Displays rejected products.

        // Product Approval Route
        Route::post('/approve-product/{id}', 'approve_product')->name('approve.product'); // Handles the approval of a product by admin.
        // Product Rejection Route
        Route::post('/reject-product/{id}', 'reject_product')->name('reject.product'); // Handles the rejection of a product by admin.
    });
});

// =========================================================================
//                     USER AUTHENTICATION ROUTES
// =========================================================================
// These routes are related to user authentication (login, logout, registration)
Route::controller(UserController::class)->group(function () {
    // Portal Route
    Route::get('portal', 'index')->name('portal'); // Displays the user portal

    // Logout Route
    Route::post('/logout', 'logout')->name('logout'); // Handles user logout.

    // =========================================================================
    //          Guest Only Authentication Routes (Seller Registration & Login)
    // =========================================================================
    // These routes are for guest users (not logged in)
    Route::middleware(['guest'])->group(function () {
        // Seller Registration Page
        Route::get('seller/register', 'get_register_page')->name('register.seller'); // Displays the seller registration page.
        // Seller Registration Route
        Route::post('seller/register', 'register_seller')->name('store.seller'); // Handles seller registration.
        // Login route
        Route::post('portal', 'login')->name('login'); // Handles the user login.
    });
});

// =========================================================================
//                      USER VERIFICATION ROUTES
// =========================================================================
// These routes handle user verifications.
Route::middleware(['auth'])->group(function () {
    Route::controller(VerificationController::class)->group(function () {
        // Verification Index Route
        Route::get('verification', 'index')->name('verification'); // Displays the verification index page
        // Verification Store Route
        Route::post('verification', 'store')->name('verifications.store'); // Handles verification requests.
        // Approve User Route
        Route::post('approve-user', 'approve_user')->name('verification.approve'); // Handles approving a user.
        // Reject User Route
        Route::post('reject-user', 'reject_user')->name('verification.reject'); // Handles rejecting a user.
    });
});

// =========================================================================
//              ADMIN CATEGORY AND BRAND MANAGEMENT ROUTES
// =========================================================================
// These routes are for managing product categories and brands, accessible by admin users.
Route::middleware(['auth', 'admin'])->group(function () {
    // =========================================================================
    //               Category Management Routes
    // =========================================================================
    Route::controller(CategoryController::class)->group(function () {
        // Category Index Route
        Route::get('category', 'index')->name('category'); // Displays category index page.
        // Category Add Route
        Route::post('category', 'add')->name('category.add');  // Handles adding a category.
        // Category Edit Route
        Route::get('edit-category/{slug}', 'edit')->name('category.edit'); // Displays edit page of a specific category.
        // Category Update Route
        Route::put('/category/{categoryId}', 'update')->name('category.update'); // Handles updating a category.
        // Category Delete Route
        Route::delete('/category/{categoryId}', 'delete')->name('category.delete'); // Handles deleting a category.
        // Category Brand Update Route
        Route::post('update-category-brands', 'updateBrand')->name('category.update.brand'); // Handles updating brands for categories.
        // Category Brand Remove Route
        Route::delete('/category/{categoryId}/brand/{brandId}', 'removeBrand')->name('category.remove.brand'); // Removes a brand from category.
    });

    // =========================================================================
    //                  Brand Management Routes
    // =========================================================================
    Route::controller(BrandController::class)->group(function () {
        // Brand Index Route
        Route::get('brands', 'index')->name('brand.index'); // Displays the brands index page.
        // Brand Add Route
        Route::post('brands', 'add')->name('brand.add'); // Handles adding a new brand.
        // Brand Edit Route
        Route::get('brands/{slug}/edit', 'edit')->name('brand.edit'); // Displays edit page for a brand.
        // Brand Update Route
        Route::put('brands/{brandId}', 'update')->name('brand.update'); // Handles updating a brand.
        // Brand Delete Route
        Route::delete('brands/{brandId}', 'delete')->name('brand.delete'); // Handles deleting a brand.
    });

    // =========================================================================
    //               Attribute Management Routes
    // =========================================================================
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
});

// =========================================================================
//          PRODUCT MANAGEMENT ROUTES (ADMIN AND SELLER)
// =========================================================================
// These routes are for product management, accessible by admin and seller users.
Route::middleware(['auth', 'adminOrSeller'])->group(function () {
    Route::controller(ProductController::class)->group(function () {
        // Product Index Route
        Route::get('products', 'index')->name('product.index'); // Displays a list of products.
        // Approved Products By Seller Route
        Route::get('seller/approved-products', 'approved_products')->name('seller.approved.products'); // Displays approved products for a seller.
        // Pending Products By Seller Route
        Route::get('seller/pending-products', 'pending_products')->name('seller.pending.products'); // Displays pending products for a seller.
        // Rejected Products By Seller Route
        Route::get('seller/rejected-products', 'reject_products')->name('seller.rejected.products'); // Displays rejected products for a seller.

        // Get Brands by Category Route
        Route::get('brands/{categoryId}', 'getBrands')->name('product.getBrands'); // Handles fetching brands based on category.
        // Get Attributes and Values Route
        Route::get('/attributes-values/{categoryId}', 'getAttributesAndValues')->name('product.getAttributesAndValues'); // Handles fetching attributes and values based on category.
        // Product Delete Route
        Route::delete('/product/{id}', 'destroy')->name('product.destroy'); // Handles deletion of a product.
        // Find Category by slug
        Route::get('/categoryget/{slug}', 'findCategoryBySlug')->name('category.findBySlug'); // Handles fetching the category by a slug

        // =========================================================================
        //               New Product Management Routes
        // =========================================================================
        // These routes are for managing new products
        Route::get('add-new-product', 'show_add_new_product_page')->name('product.add.new'); // Display the page to add new product.
        Route::post('add-new-product', 'store')->name('product.add.new.store'); // Handle the addition of the new product
        Route::get('/product/{id}/edit', 'edit')->name('product.edit'); // Handle edit of the new product.
        Route::put('/product/{id}', 'update')->name('product.update'); // Handle update new product

        // =========================================================================
        //               Used Product Management Routes
        // =========================================================================
        // These routes are for managing used products
        Route::get('add-used-product', 'show_add_used_product_page')->name('product.add.used'); // Display add used product page
        Route::post('add-used-product', 'store_used')->name('product.add.used.store'); // Handle adding used product
        Route::get('/product/{id}/edit-used', 'edit_used')->name('product.used.edit'); // Displays edit page for a used product
        Route::put('/used-product/{id}', 'update_used')->name('product.used.update'); // Handle update of used product

        // =========================================================================
        //           Complete PC Product Management Routes
        // =========================================================================
        // These routes are for managing complete pc products
        Route::get('add-complete-pc', 'show_add_complete_pc_product_page')->name('product.add.completepc');  // Display add complete pc product page.
        Route::post('add-complete-pc', 'store_complete_pc')->name('product.add.complete.pc'); // Handle adding of complete pc product.
        Route::get('/product/{id}/edit-complete-pc', 'edit_complete_pc')->name('product.complete.pc.edit'); // Display edit page for a complete pc.
    });
});
