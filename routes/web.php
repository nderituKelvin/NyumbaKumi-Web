<?php

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

	Route::get('/',[
		'as' => 'loginPage',
		function () {
			return view('login');
	}]);
	
	Route::get('register',[
		'as' => 'registerPage',
		function (){
			return view('register');
		}
	]);
	
	Route::get('home', [
		'as' => 'home',
		'uses' => 'UserController@loadHome'
	])->middleware('auth');
	
	Route::post('register', [
		'as' => 'register',
		'uses' => 'UserController@register'
	]);
	
	Route::post('login', [
		'as' => 'login',
		'uses' => 'UserController@login'
	]);

	Route::get('logout', [
		'as' => 'logout',
		'uses' => 'UserController@logout'
	])->middleware('auth');
	
	Route::post('addMember',[
		'as' => 'addMember',
		'uses' => 'UserController@addMember'
	])->middleware('auth');
	
	Route::post('addService',[
		'as' => 'addService',
		'uses' => 'UserController@addService'
	])->middleware('auth');
	
	Route::post('deleteMember', [
		'as' => 'deleteMember',
		'uses' => 'UserController@deleteMember'
	])->middleware('auth');
	
	Route::post('deleteService', [
		'as' => 'deleteService',
		'uses' => 'UserController@deleteService'
	])->middleware('auth');
	
	Route::post('androidTestMessaging', [
		'as' => 'testing',
		'uses' => 'UserController@androidTestMessaging'
	]);
	
	Route::post('android/login', [
		'as' => 'androidlogin',
		'uses' => 'UserController@androidLogin'
	]);
	
	Route::post('android/confirmjoin', [
		'as' => 'androidconfirm',
		'uses' => 'UserController@androidConfirm'
	]);
	
	Route::post('android/sendChat', [
		'as' => 'sendChat',
		'uses' => 'UserController@sendChat'
	]);
	
	Route::post('android/updateChat', [
		'as' => 'updateChat',
		'uses' => 'UserController@updateChat'
	]);
	
	Route::post('admin/sendchat', [
		'as' => 'adminsendchat',
		'uses' => 'UserController@adminSendChat'
	]);
	
	Route::post('admin/requestChats', [
		'as' => 'requestChats',
		'uses' => 'UserCOntroller@requestChats'
	]);
	
	Route::post('android/getServices', [
		'as' => 'androidgetservices',
		'uses' => 'UserCOntroller@androidgetservices'
	]);
	
	Route::get('login', [
		'as' => 'getlogin',
		function(){
			return redirect()->route('loginPage');
		}
	]);