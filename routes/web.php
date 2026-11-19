<?php

use App\Models\AdminProfile;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Testing\Fluent\Concerns\Has;
use Mockery\Generator\StringManipulation\Pass\Pass;


Route::redirect('/dashboard', '/dashboard');


// Profile
Route::get('/profile', function(){
    $profile = User::firstOrCreate(
        ['id' => 1],
        [
            'name' => 'Admin User',
            'email' => 'admin@test.com',
            'password' => Hash::make('password123'),
            'phone' => '+60 12-345 6789',
            'role' => 'Admin',
            'status' => 'Active',
        ]
    );

    return view('profile', compact('profile'));
})->name('admin.profile');

Route::post('/profile', function(Request $request){
    $user = User::firstOrFail();

    $data = $request->validate([
        'name' => ['required', 'string', 'max:100'],
        'email' => ['required', 'email', 'max:150', 'unique:users,email,' . $user->id],
        'phone' => ['required', 'string', 'max:30'],
        'role' => ['required', 'string', 'max:50'],
        'status' => ['required', 'in:Active,Inactive'],
    ]);

    $user->update($data);

    return redirect()->route('admin.profile')->with('success', 'Profile updated successfully.');
})->name('admin.profile.update');

Route::post('/profile/password', function(Request $request){
    $request->validate([
        'current_password' => ['required', 'current_password'],
        'new_password' => ['required', 'string', 'min:8', 'confirmed'],
    ]);

    $request->user()->update([
        'password' => Hash::make($request->new_password),
    ]);

    return redirect()->route('admin.profile')->with('success', 'Password changed successfully.');
})->name('admin.profile.password');


Route::view('/', 'dashboard')->name('dashboard');

Route::get('/user-management', fn () => view()->exists('user-management') ? view('user-management') : view('dashboard'))->name('admin.users');
Route::get('/booking-management', fn () => view()->exists('booking-management') ? view('booking-management') : view('dashboard'))->name('admin.bookings');
Route::get('/payment-management', fn () => view()->exists('payment-management') ? view('payment-management') : view('dashboard'))->name('admin.payments');
Route::get('/list-rental-management', fn () => view()->exists('list-rental-management') ? view('list-rental-management') : view('dashboard'))->name('admin.rentals');
Route::get('/lot-management', fn () => view()->exists('lot-management') ? view('lot-management') : view('dashboard'))->name('admin.lots');
Route::get('/reviews-management', fn () => view()->exists('reviews-management') ? view('reviews-management') : view('dashboard'))->name('admin.reviews');

/*
Route::middleware('auth')->group(function () {
    
});
*/
