<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\ContactsController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ImagesController;
use App\Http\Controllers\OrganizationsController;
use App\Http\Controllers\ReportsController;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\PromptController;
use App\Http\Controllers\WriteController;
use App\Http\Controllers\KeywordFliterController;

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

// Auth

Route::get('login', [LoginController::class, 'showLoginForm'])
    ->name('login')
    ->middleware('guest');

Route::post('login', [LoginController::class, 'login'])
    ->name('login.attempt')
    ->middleware('guest');

Route::post('logout', [LoginController::class, 'logout'])
    ->name('logout');

//keyword filter

Route::get('/keyword_filter', [KeywordFliterController::class, 'index'])
    ->name('keyword_filter')
    ->middleware('auth');

Route::post('/keyword_filter', [KeywordFliterController::class, 'store'])
    ->name('keyword_filter.store')
    ->middleware('auth');
// Dashboard

Route::get('/', [DashboardController::class, 'index'])
    ->name('dashboard')
    ->middleware('auth');

// setting
Route::get('/setting', [SettingController::class, 'index'])
    ->name('setting')
    ->middleware('auth'); 

Route::post('setting', [SettingController::class, 'store'])
    ->name('setting.store')
    ->middleware('auth');

Route::put('setting', [SettingController::class, 'update'])
    ->name('setting.update')
    ->middleware('auth');

// write
Route::get('/write', [WriteController::class, 'index'])
    ->name('write')
    ->middleware('auth'); 

// write
Route::get('/write/create', [WriteController::class, 'create'])
    ->name('write.create')
    ->middleware('auth'); 

Route::post('/write/create', [WriteController::class, 'store'])
    ->name('write.create')
    ->middleware('auth'); 
// chat
Route::get('/chat', [ChatController::class, 'index'])
    ->name('chat')
    ->middleware('auth'); 

Route::post('/chat', [ChatController::class, 'store'])
    ->name('chat')
    ->middleware('auth'); 

//prompt
Route::get('/prompt', [PromptController::class, 'index'])
    ->name('prompt')
    ->middleware('auth'); 

Route::get('prompt/create', [PromptController::class, 'create'])
    ->name('prompt.create')
    ->middleware('auth');

Route::post('/prompt', [PromptController::class, 'store'])
    ->name('prompt.store')
    ->middleware('auth'); 

Route::get('/prompt/{prompt}/edit', [PromptController::class, 'edit'])
    ->name('prompt.edit')
    ->middleware('auth'); 

Route::put('/prompt/{prompt}/update', [PromptController::class, 'update'])
    ->name('prompt.update')
    ->middleware('auth'); 

Route::delete('/prompt/{prompt}', [PromptController::class, 'delete'])
    ->name('prompt.delete')
    ->middleware('auth'); 
// Users

Route::get('users', [UsersController::class, 'index'])
    ->name('users')
    ->middleware('remember', 'auth');

Route::get('users/create', [UsersController::class, 'create'])
    ->name('users.create')
    ->middleware('auth');

Route::post('users', [UsersController::class, 'store'])
    ->name('users.store')
    ->middleware('auth');

Route::get('users/{user}/edit', [UsersController::class, 'edit'])
    ->name('users.edit')
    ->middleware('auth');

Route::put('users/{user}', [UsersController::class, 'update'])
    ->name('users.update')
    ->middleware('auth');

Route::delete('users/{user}', [UsersController::class, 'destroy'])
    ->name('users.destroy')
    ->middleware('auth');

Route::put('users/{user}/restore', [UsersController::class, 'restore'])
    ->name('users.restore')
    ->middleware('auth');

// Organizations

Route::get('organizations', [OrganizationsController::class, 'index'])
    ->name('organizations')
    ->middleware('remember', 'auth');

Route::get('organizations/create', [OrganizationsController::class, 'create'])
    ->name('organizations.create')
    ->middleware('auth');

Route::post('organizations', [OrganizationsController::class, 'store'])
    ->name('organizations.store')
    ->middleware('auth');

Route::get('organizations/{organization}/edit', [OrganizationsController::class, 'edit'])
    ->name('organizations.edit')
    ->middleware('auth');

Route::put('organizations/{organization}', [OrganizationsController::class, 'update'])
    ->name('organizations.update')
    ->middleware('auth');

Route::delete('organizations/{organization}', [OrganizationsController::class, 'destroy'])
    ->name('organizations.destroy')
    ->middleware('auth');

Route::put('organizations/{organization}/restore', [OrganizationsController::class, 'restore'])
    ->name('organizations.restore')
    ->middleware('auth');

// Contacts

Route::get('contacts', [ContactsController::class, 'index'])
    ->name('contacts')
    ->middleware('remember', 'auth');

Route::get('contacts/create', [ContactsController::class, 'create'])
    ->name('contacts.create')
    ->middleware('auth');

Route::post('contacts', [ContactsController::class, 'store'])
    ->name('contacts.store')
    ->middleware('auth');

Route::get('contacts/{contact}/edit', [ContactsController::class, 'edit'])
    ->name('contacts.edit')
    ->middleware('auth');

Route::put('contacts/{contact}', [ContactsController::class, 'update'])
    ->name('contacts.update')
    ->middleware('auth');

Route::delete('contacts/{contact}', [ContactsController::class, 'destroy'])
    ->name('contacts.destroy')
    ->middleware('auth');

Route::put('contacts/{contact}/restore', [ContactsController::class, 'restore'])
    ->name('contacts.restore')
    ->middleware('auth');

// Reports

Route::get('reports', [ReportsController::class, 'index'])
    ->name('reports')
    ->middleware('auth');

// Images

Route::get('/img/{path}', [ImagesController::class, 'show'])->where('path', '.*');

// 500 error

Route::get('500', function () {
    // Force debug mode for this endpoint in the demo environment
    if (App::environment('demo')) {
        Config::set('app.debug', true);
    }

    echo $fail;
});
