<?php

use App\Models\Listing;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ListingController;

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

// For guest middleware, edit route service provideo to point to homepage

// Using Controllers
Route::get('/', [ListingController::class, 'index']);

// Show Create New Listing
Route::post('/listings', [ListingController::class, 'store'])
    ->middleware('auth');

// Show Create Form
Route::get('/listings/create', [ListingController::class, 'create'])
    ->middleware('auth');

// Manage Listings
Route::get('/listings/manage', [ListingController::class, 'manage'])
    ->middleware('auth');

// Show Listing
Route::get('/listings/{listing}', [ListingController::class, 'show']);

// Show Edit form
Route::get('/listings/{listing}/edit', [ListingController::class, 'edit'])
    ->middleware('auth');

// Put to update
Route::put('/listings/{listing}', [ListingController::class, 'update'])
    ->middleware('auth');

// Delete
Route::delete('/listings/{listing}', [ListingController::class, 'destroy'])
    ->middleware('auth');





// Show User Registration Form
Route::get('/register', [UserController::class, 'create'])
    ->middleware('guest');

// Create new user
Route::post('/users', [UserController::class, 'store'])
    ->middleware('guest');

// Log User Out
Route::post('/logout', [UserController::class, 'logout'])
    ->middleware('auth');

// Show Login Form
Route::get('/login', [UserController::class, 'login'])
    ->name('login');

// log user in
Route::post('/users/authenticate', [UserController::class, 'authenticate']);




// Common Resource Routes
// index - Show all Listings
// show - Show Single Listing
// create - Show Form to Create New Listing
// store - Store new Listing
// edit - Show Form to edit listing
// update - Update Listing
// destroy - Delete listing

// // All Listings
// Route::get('/', function () {
//     return view('listings', [
//         'listings' => Listing::all()
//     ]);
// });

// // Single Listing - Using eloquent Models Route-Model Binding
// Route::get('/listings/{listing}', function (Listing $listing) {
//     return view('listing', [
//         'listing' => $listing
//     ]);
// });

// Doing this the normal way
// Route::get('/listings/{id}', function ($id) {
//     $listing = Listing::find($id);

//     if ($listing) {
//         return view('listing', [
//             'listing' => Listing::find($id)
//         ]);
//     } else{
//         abort('404');
//     }
// });
