# Laravel Ajax CRUD
```php
public function store(BlogRequest $request)
{
try 
{
    $file = $request->file('blog_image');
    $fileName = time().'.'.$file->getClientOriginalExtension();
    $destinationPath = public_path('admin/images/blogs');
    if (!is_dir($destinationPath)) {
	mkdir($destinationPath, 0777, true);
    }
    $file->move($destinationPath,$fileName);
    $blog_image = '/admin/images/blogs/'.$fileName;

    $blog = Blog::create([
	'title' => $request->title,
	'description' => $request->description,
	'image' => $blog_image,
    ]);
    return ['status'=>true, 'message'=>'New blog added successfully!'];
} 
catch (\Exception $e) 
{
   return ['status'=>true, 'message'=>$e->getMessage()];
}
}
```
# Request
```php

public function rules()
    {
        switch (request()->method()){
            case 'POST' :
                return [
                    'blog_image' => 'required|mimes:jpeg,png,jpg,gif,svg',
                    'title' => 'required',
                    'description' => 'required',
                ];
                break;
            case 'PUT' :
                return [
                    'title' => 'required',
                    'description' => 'required',
                ];
                break;
            default :
                return [];
        }
    }

    public function messages()
    {
        return [
            'blog_image.required' => 'Select image',
            'title.required' => 'Title is required',
            'description.required' => 'Description is required',
        ];
    }

```
# Display message
```html
<div>
    <div class="add-blog-success alert alert-success  alert-dismissible" style="display: none;">
    <a href="#" class="close" data-dismiss="alert" aria-label="close" style="color: black;">&times;</a>
</div>
```
# Html
```html
<div class="form-group">
<label class="col-sm-2"></label>
<div class="col-sm-10">
<img alt="Event Image" style="width: 250px; height: 163px;" 
class="img-md file-img1 model-add-image" src="{{asset('public/admin/')}}/images/404-Not-Found.jpg">
<p class="text-muted"></p>
<input type="file" id="fileElem" name="blog_image" class="file1" multiple accept="image/*" 
 style="display:none" onchange="handleFile(this.files)">
<button type="button" id="fileSelect" class="btn btn-primary mar-ver btn-img-file">Blog Image..</button>
<div id="image-error" class="btn-img-file validation-error"></div>
</div>

</div>

```
# Image Preview code on form
```js

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
```
# insert
```js
    #store
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
# Edit and update
```js
<script type="text/javascript">
$('body').on('click',".edit_blog",function()
{
    var id = $(this).attr("data-id");
    var base_url = "edit-blog/"+id;
    //alert(cert_id);
    $.ajax({
        url: base_url,
        data: { id : id },
        success: function(data){
          console.log('success');
            var result = jQuery.parseJSON(data);
            $('.edit-blog-page').css('display','block');
            $('.list-blog-page').css('display','none');
            $('#blog_id').val(result.id);
            $('#blog_old_image').val(result.image);
            $('.blog-img').attr('src', '{{asset("public/")}}'+result.image);
            $('#blog-title').val(result.title);
            $('#blog-description').val(result.description);

        }
    });
});
</script>
<script type="text/javascript">
  $('#edit-blog-submit').submit(function(e) {
      e.preventDefault();
    var blog_id   = $("#blog_id").val();
      var data = new FormData($("#edit-blog-submit")[0]);
      $.ajax({
        method : 'POST',
        url : "update-blog/"+blog_id,
        data: data,
        contentType:false,
        cache: false,
        processData:false,
        success: function (response) {
            if(response.status)
            {
                $('.edit-blog-success').show();
                setTimeout(function() {
                    window.location = "{{route('blog.index')}}";
                }, 3000);
            }
            if(response.status == false)
            {
                $('.edit-blog-success').html(response.message);
            }
            else
            {
                $('.edit-blog-success').html(response.message);
            }

        },
        error: function (errors) {
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
