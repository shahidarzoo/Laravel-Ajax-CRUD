# Laravel Ajax CRUD

```php
#Routes
Route::resource('/blog', 'Admin\BlogController');
	Route::get('/delete-blog/{id}', 'Admin\BlogController@destroy');
	Route::get('/edit-blog/{id}', 'Admin\BlogController@edit');
	Route::put('/update-blog/{id}', 'Admin\BlogController@update')

```
