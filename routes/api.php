<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

use App\Http\Controllers\Line\LineApiController;
use App\Http\Controllers\API\TestController;

use App\Http\Controllers\API\AnnounceController;
use App\Http\Controllers\API\ProductController;
use App\Http\Controllers\API\OrderController;


Route::get('bob/line', [LineApiController::class, 'alive'])->name('line.alive');
Route::post('bob/line', [LineApiController::class, 'bob'])->name('line.bob');


Route::get('test/category', [TestController::class, 'category'])->name('test.category');
Route::get('test/cart', [TestController::class, 'cart'])->name('test.cart');
Route::get('test/message', [TestController::class, 'message'])->name('test.message');
Route::get('test/notification', [TestController::class, 'notification'])->name('test.notification');
Route::get('test/product', [TestController::class, 'product'])->name('test.product');
Route::get('test/search', [TestController::class, 'search'])->name('test.search');
Route::get('test/popular', [TestController::class, 'popular'])->name('test.popular');
Route::get('test/news', [TestController::class, 'news'])->name('test.news');

//公告
Route::get('news/list', [AnnounceController::class, 'newsList'])->name('api.news.list');
Route::get('news/detail/{id}', [AnnounceController::class, 'newsDetail'])->name('api.news.detail');
//產品
Route::get('products/list', [ProductController::class, 'partList'])->name('api.parts.list');
Route::get('products/detail/{id}', [ProductController::class, 'partDetail'])->name('api.parts.detail');
Route::get('products/categories', [ProductController::class, 'categoriesList'])->name('api.categoriesList.list');
//訂單
Route::get('orders/list', [OrderController::class, 'orderList'])->name('api.orders.list');
Route::get('orders/detail/{id}', [OrderController::class, 'orderDetail'])->name('api.orders.detail');
//詢價
Route::get('inquiry/list', [OrderController::class, 'inquiryList'])->name('api.inquiry.list');
Route::get('inquiry/detail/{id}', [OrderController::class, 'inquiryDetail'])->name('api.inquiry.detail');


use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\FirebaseAuthController;
use App\Http\Controllers\API\EmployeeController;


use App\Http\Controllers\Task\InboxController;
use App\Http\Controllers\Task\HealthController;
use App\Http\Controllers\Task\OrganizationController;
use App\Http\Controllers\Task\TaskController;


// Public route to create inbox message (no authentication)
Route::post('/inbox', [InboxController::class, 'createInbox']);

// Protected routes (authentication required)
Route::middleware('auth:api')->prefix('v1')->group(function () {
    Route::get('/inbox/{userId}', [InboxController::class, 'getUserInbox']);
    Route::get('/inbox/{inboxId}/comments', [InboxController::class, 'getUserInboxComment']);
    Route::post('/inbox/{inboxId}/comments', [InboxController::class, 'createUserInboxComment']);
});

Route::post('/firebaselogin', [FirebaseAuthController::class, 'login']);
Route::post('/employeelogin', [EmployeeController::class, 'transfer']);

Route::middleware('auth:api')->prefix('v1')->group(function () {
    /*Route::put('/user/token', [FirebaseAuthController::class, 'updateUserToken']);
    Route::get('/user', [FirebaseAuthController::class, 'getUserInformation']);
    Route::put('/user', [FirebaseAuthController::class, 'updateUserInformation']);*/
    Route::get('/user', [AuthController::class, 'user']);
});

Route::post('register', [AuthController::class, 'register']);
Route::post('login', [AuthController::class, 'login']);
Route::middleware('auth:api')->get('user', [AuthController::class, 'user']);

Route::get('/health', [HealthController::class, 'checkHealth']);

Route::middleware('auth:api')->prefix('v1')->group(function () {
    Route::post('/organizations', [OrganizationController::class, 'createOrganization']);
    Route::get('/organizations', [OrganizationController::class, 'getOrganizations']);
    Route::get('/organizations/{id}', [OrganizationController::class, 'getOrganizationById']);
    Route::put('/user/team', [OrganizationController::class, 'updateUserTeam']);
    Route::post('/members/invite', [OrganizationController::class, 'inviteMembers']);
    Route::get('/organizations/{organizationId}/members', [OrganizationController::class, 'listMembers']);
});

Route::middleware('auth:api')->prefix('v1')->group(function () {
    // Create a new task
    Route::post('/tasks', [TaskController::class, 'createTask']);
    // Get tasks by organization ID
    Route::get('/tasks/organization/{organizationId}', [TaskController::class, 'getTasks']);
    // Update task by ID
    Route::put('/tasks/{id}', [TaskController::class, 'updateTask']);
    // Get task status count by user ID
    Route::get('/tasks/status/{userId}', [TaskController::class, 'getTaskStatusCount']);
});
