<?php

use App\Http\Livewire\AboutComponent;
use App\Http\Livewire\Admin\AdminAddCategoryComponent;
use App\Http\Livewire\Admin\AdminAddCouponsComponent;
use App\Http\Livewire\Admin\AdminAddHomeSliderComponent;
use App\Http\Livewire\Admin\AdminCategoryComponent;
use App\Http\Livewire\Admin\AdminContactComponent;
use App\Http\Livewire\Admin\AdminCouponsComponent;
use App\Http\Livewire\Admin\AdminDashboardComponent;
use App\Http\Livewire\Admin\AdminEditCategoryComponent;
use App\Http\Livewire\Admin\AdminEditCouponsComponent;
use App\Http\Livewire\Admin\AdminEditHomeSliderComponent;
use App\Http\Livewire\Admin\AdminHomeCategoryComponent;
use App\Http\Livewire\Admin\AdminHomeSliderComponent;
use App\Http\Livewire\Admin\AdminOrderDetailsComponent;
use App\Http\Livewire\Admin\AdminOrdersComponent;
use App\Http\Livewire\Admin\AdminSaleComponent;
use App\Http\Livewire\Admin\AdminSettingComponent;
use App\Http\Livewire\Admin\AllSellersComponent;
use App\Http\Livewire\Admin\EditSellerComponent;
use App\Http\Livewire\CartComponent;
use App\Http\Livewire\CatagoryComponent;
use App\Http\Livewire\CheckoutComponent;
use App\Http\Livewire\ContactComponent;
use App\Http\Livewire\Customer\CustomerDashboardComponent;
use App\Http\Livewire\Customer\CustomerOrderDetailsComponent;
use App\Http\Livewire\Customer\CustomerOrdersComponent;
use App\Http\Livewire\Customer\CustomerReviewComponent;
use App\Http\Livewire\DetailsComponent;
use App\Http\Livewire\HomeComponent;
use App\Http\Livewire\RegisterShopComponent;
use App\Http\Livewire\SearchComponent;
use App\Http\Livewire\Seller\SellerAddProductComponent;
use App\Http\Livewire\Seller\SellerDashboardComponent;
use App\Http\Livewire\Seller\SellerEditProductComponent;
use App\Http\Livewire\Seller\SellerOrderComponent;
use App\Http\Livewire\Seller\SellerProductComponent;
use App\Http\Livewire\ShopComponent;
use App\Http\Livewire\ThankyouComponent;
use App\Http\Livewire\WishlistComponent;
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

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/', HomeComponent::class);

Route::get('/shop', ShopComponent::class)->name('shop');

Route::get('/cart', CartComponent::class)->name('product.cart');

Route::get('/checkout', CheckoutComponent::class)->name('checkout');
Route::get('/product/{slug}', DetailsComponent::class)->name('product.details');
Route::get('/product-catagory/{catagory_slug}', CatagoryComponent::class)->name('product.catagory');
Route::get('/search', SearchComponent::class)->name('product.search');

Route::get('/wishlist', WishlistComponent::class)->name('product.wishlist');
Route::get('/thank-you', ThankyouComponent::class)->name('thankyou');
Route::get('/contact-us', ContactComponent::class)->name('contact');
Route::get('/about-us', AboutComponent::class)->name('about');


// Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', function () {
//     return view('dashboard');
// })->name('dashboard');


//For Admin middleware
Route::middleware(['auth:sanctum', 'verified', 'authadmin'])->group(function(){
    Route::get('/admin/dashboard', AdminDashboardComponent::class)->name('admin.dashboard');
    Route::get('/admin/categories', AdminCategoryComponent::class)->name('admin.categories');
    Route::get('/admin/add/category', AdminAddCategoryComponent::class)->name('admin.addcategory');
    Route::get('/admin/category/edit/{category_slug}', AdminEditCategoryComponent::class)->name('admin.editcategory');
    Route::get('/admin/sliders', AdminHomeSliderComponent::class)->name('admin.sliders');
    Route::get('/admin/slider/add', AdminAddHomeSliderComponent::class)->name('admin.addslider');
    Route::get('/admin/slider/edit/{slider_id}', AdminEditHomeSliderComponent::class)->name('admin.editslider');
    Route::get('/admin/sale', AdminSaleComponent::class)->name('admin.sale');
    Route::get('/admin/home-categories', AdminHomeCategoryComponent::class)->name('admin.homecategories');
    Route::get('/admin/sellers', AllSellersComponent::class)->name('admin.sellers');
    Route::get('/admin/seller/edit/{seller_id}', EditSellerComponent::class)->name('admin.editseller');
    Route::get('/admin/coupons', AdminCouponsComponent::class)->name('admin.coupons');
    Route::get('/admin/coupon/add', AdminAddCouponsComponent::class)->name('admin.addcoupon');
    Route::get('/admin/coupon/edit/{coupon_id}', AdminEditCouponsComponent::class)->name('admin.editcoupon');
    Route::get('/admin/orders', AdminOrdersComponent::class)->name('admin.orders');
    Route::get('/admin/orders/{order_id}', AdminOrderDetailsComponent::class)->name('admin.orderdetails');
    Route::get('/admin/contact-us', AdminContactComponent::class)->name('admin.contact');
    Route::get('/admin/settings', AdminSettingComponent::class)->name('admin.settings');
});

//For Seller middleware
Route::middleware(['auth:sanctum', 'verified', 'authseller'])->group(function(){
    Route::get('/seller/dashboard', SellerDashboardComponent::class)->name('seller.dashboard');
    Route::get('/seller/products', SellerProductComponent::class)->name('seller.products');
    Route::get('/seller/product/add', SellerAddProductComponent::class)->name('seller.addproduct');
    Route::get('/seller/product/edit/{product_slug}', SellerEditProductComponent::class)->name('seller.editproduct');
    Route::get('/seller/orders', SellerOrderComponent::class)->name('seller.orders');
    Route::get('/orders/delivered/{suborder}', [SellerOrderComponent::class, 'markDelivered'])->name('order.delivered');
});

//For User or Customer Middleware
Route::middleware(['auth:sanctum', 'verified', 'authcustomer'])->group(function(){
    Route::get('/customer/dashboard', CustomerDashboardComponent::class)->name('customer.dashboard');
    Route::get('/create/shop', RegisterShopComponent::class)->name('create.shop');
    Route::get('/customer/orders', CustomerOrdersComponent::class)->name('customer.orders');
    Route::get('customers/orders/{order_id}', CustomerOrderDetailsComponent::class)->name('customer.orderdetails');
    Route::get('/customer/review/{order_item_id}',CustomerReviewComponent::class)->name('customer.review');
});
