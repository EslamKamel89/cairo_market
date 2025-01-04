<?php

use Illuminate\Support\Facades\Route;

Route::view( '/', 'welcome' );


Route::view( '/dashboard', 'dashboard' )
	->middleware( [ 'auth', 'verified', 'roleMiddleware:customer' ] )
	->name( 'dashboard' );
Route::view( '/admin/dashboard', 'admin' )
	->middleware( [ 'auth', 'verified', 'roleMiddleware:admin' ] )
	->name( 'admin' );
Route::view( '/vendor/dashboard', 'vendor' )
	->middleware( [ 'auth', 'verified', 'roleMiddleware:vendor' ] )
	->name( 'vendor' );

Route::view( 'profile', 'profile' )
	->middleware( [ 'auth' ] )
	->name( 'profile' );

require __DIR__ . '/auth.php';
