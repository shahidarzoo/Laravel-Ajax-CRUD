# Laravel Ajax CRUD

```php
#Routes
	Route::resource('/blog', 'Admin\BlogController');
	Route::get('/delete-blog/{id}', 'Admin\BlogController@destroy');
	Route::get('/edit-blog/{id}', 'Admin\BlogController@edit');
	Route::put('/update-blog/{id}', 'Admin\BlogController@update')

```
```js
<script type="text/javascript">
    //image upload
     var fileSelect = document.getElementById("fileSelect"),
      fileElem = document.getElementById("fileElem"),
      fileList = document.getElementById("fileList");

      fileSelect.addEventListener("click", function (e) {
          if (fileElem) {
            fileElem.click();
        }
              e.preventDefault(); // prevent navigation to "#"
          }, false);



      function handleFile(files) {
       var preview = document.querySelector('.file-img1');
       var file    = document.querySelector('.file1').files[0];
       var reader  = new FileReader();

       reader.addEventListener("load", function () {
        preview.src = reader.result;
    }, false);

       if (file) {
        reader.readAsDataURL(file);
    }
}

    //store
    $('#create-blog-submit').submit(function(e) {
    e.preventDefault();
      var data = new FormData($("#create-blog-submit")[0]);
      $.ajax({
        method : 'POST',
        url : "{{route('blog.store')}}",
        data: data,
        contentType:false,
        cache: false,
        processData:false,
        success: function (response) {
            if(response.status)
            {
                $('.add-blog-success').show();
                setTimeout(function() {
                    window.location = "{{route('blog.index')}}";
                }, 3000);
            }
            if(response.status == false)
            {
                $('.add-blog-success').html(response.message);
            }
            else
            {
                $('.add-blog-success').html(response.message);
            }

        },
        error: function (errors) {
           //console.log(errors);
           var er = $.parseJSON(errors.responseText);
           var errors_list = '';
           $('#image-error').html(er.errors.blog_image);
           $('#title-error').html(er.errors.title);
           $('#description-error').html(er.errors.description);
           $.each(er.errors, function (fields, messages) {

               $.each(messages, function (index, msg) {
                   errors_list += '<li>' + msg + '</li>';
               })
           });
           console.log(errors_list);
          $('.alert-danger').html(errors_list);
           setTimeout(function() {
                $('#image-error').html('');
                $('#title-error').html('');
                $('#description-error').html('');
            }, 3000);
       }
   });
  });
</script>
```
