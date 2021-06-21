<?php

use Illuminate\Support\Facades\Route;

Route::get('/', 'HomeController@index');

Auth::routes();
Route::prefix('admin')->group(function () {
    Route::get('movies/poster/{id}', 'MovieController@posterEdit')->name('poster');
    Route::post('movies/poster/{id}', 'MovieController@posterStore');
    Route::resources(['movies' => 'MovieController', 'auditorium' => 'AuditoriumController', 'screening' => 'ScreeningController']);
    Route::resource('tickets', 'TicketController')->except(['edit', 'update', 'delete']);
    Route::get('tickets/edit/{screening_id}/{seat_id}', 'TicketController@edit')->name('tickets.edit');
    Route::patch('tickets/edit/{screening_id}/{seat_id}', 'TicketController@update')->name('tickets.update');
    Route::delete('tickets/edit/{screening_id}/{seat_id}', 'TicketController@destroy');
    Route::post('tickets/seats', 'TicketController@seats')->name('seats');
});
Route::get('admin/success', 'AdminController@success');

Route::get('/home', 'HomeController@index')->name('home');

Route::get('/movie/{id}', 'HomeController@show')->name('movie.show'); //to show movie details to user

Route::get('/admin', 'AdminController@index');

Route::get('/reserve/{sid}', 'ReserveController@index')->name('reserve.index');
Route::post('/reserve/{sid}/store', 'ReserveController@store');
Route::get('/reserve/{sid}/success/{seat}', 'ReserveController@success');

Route::get('/profile/{id}/edit','ProfileController@index')->name('profile.edit');
Route::get('/profile/{id}/pict','ProfileController@editPict')->name('profile.pict');
Route::post('/profile/{id}/pict','ProfileController@updatePict')->name('profile.pictUp');
Route::patch('/profile/{id}','ProfileController@update')->name('profile.update');

//Route::get('/{sort}', 'HomeController@sort')->name('home.sort')->middleware();
Route::get('/history/{user}', 'HistoryController@index');
Route::get('/sort/{by}', 'HomeController@sort')->name('home.sort');
Route::get('/home/{mid}/{time}', 'HomeController@reserve')->name('home.reserve');




//Route::get('/admin/movie', ['uses' => 'AdminController@movie', 'as' => 'admin.movie']);
//Route::get('/admin/movie/create', 'AdminController@movieCreate');
//Route::patch('/admin/movie/store', 'AdminController@movieInsert');
//Route::get('/admin/movie/edit/{mid}', 'AdminController@movieEdit');
//Route::get('/admin/movie/edit/poster/{mid}', 'AdminController@movieEditPoster');
//Route::patch('/admin/movie/edit/poster/{mid}', 'AdminController@movieEditPosterInsert');
//Route::post('/admin/movie/editdetail/{mid}', 'AdminController@movieUpdate');
//Route::get('/admin/movie/delete/{mid}', 'AdminController@movieDestroy');

//Route::get('/admin/movie/success', 'AdminController@movieSuccess');

//Route::get('/admin/screening', ['uses' => 'AdminController@screening', 'as' => 'admin.screening']);
//Route::get('/admin/screening/create', 'AdminController@screeningCreate');
//Route::patch('/admin/screening/store', 'AdminController@screeningInsert');
//Route::get('/admin/screening/edit/{sid}', 'AdminController@screeningEdit');
//Route::post('/admin/screening/editdetail/{sid}', 'AdminController@screeningUpdate');
//Route::get('/admin/screening/delete/{sid}', 'AdminController@screeningDestroy');
//Route::get('/admin/screening/success', 'AdminController@screeningSuccess');

//Route::get('/admin/screening/ticket', ['uses' => 'AdminController@ticketTable', 'as' => 'admin.ticket']);
//Route::get('/admin/screening/ticket/create', 'AdminController@ticketCreate');
//Route::patch('/admin/screening/ticket/store', 'AdminController@ticketInsert');
//Route::get('/admin/screening/ticket/edit/{screening_id}/{seat_id}', 'AdminController@ticketEdit');
//Route::post('/admin/screening/ticket/update/{screening_id}/{seat_id}', 'AdminController@ticketUpdate');
//Route::get('/admin/screening/ticket/delete/{screening_id}/{seat_id}', 'AdminController@ticketDestroy');
//Route::post('/admin/screening/ticket/seats', ['uses' => 'AdminController@ticketSeat', 'as' => 'admin.checkseat']);


//Route::get('/admin/facility', ['uses' => 'AdminController@facility', 'as' => 'admin.facility']);
//Route::get('/admin/facility/create', 'AdminController@facilityCreate');
//Route::patch('/admin/facility/store', 'AdminController@facilityInsert');
//Route::get('/admin/facility/delete/{sid}', 'AdminController@facilityDestroy');
//Route::get('/admin/facility/success', 'AdminController@facilitySuccess');

Route::get('/admin/statistics', 'AdminController@statistics');
