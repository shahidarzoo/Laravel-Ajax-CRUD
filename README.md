# Laravel Ajax Crud Aan Footer View Count
VIEWS
```php

<div class="col-sm-5">
        <div class="dataTables_info" id="example1_info" role="status" aria-live="polite">
          Showing {{($employee->currentpage()-1)*$employee->perpage()+1}} to {{$employee->currentpage()*$employee->perpage()}}
    of  {{$employee->total()}} entries
        </div>
    </div>

```
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
# Insert
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
# Seeder
```php
<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
	
    public function run()
    {
		
    	$user = \DB::table('users')->insert([
            'name' => 'Super Admin',
            'email' =>'admin@gmail.com',
            'password' => bcrypt('123456'),
        ]);

        //profile
        \DB::table('contacts')->insert([
            'phone' => '7493274932',
            'email' => 'abc@gmail.com',
            'address' => 'Hunza',
            'location' => 'Hunza',
            'country' => 'Pakistan',
            'latitude' => '759375349',
            'longitude' => '7239749327',
        ]);
        //project
        \DB::table('abouts')->insert([
            'title' => 'Saleem',
            'description' => 'lorum ipsum doller',
            'image' => '/admin/images/team/1538723992.jpg',
            'location' => 'Hunza',
        ]);
        \DB::table('services')->insert([
            'title' => 'tour',
            'service_image' => '/admin/images/service/service_1.jpg',
            'description' => 'lorum ipsum doller',
        ]);
        \DB::table('team_members')->insert([
            'name' => 'Saleem',
            'profile_pic' => '/admin/images/team/1538723992.jpg',
            'designation' => 'Developer',
            'phone_no' => '122233445',
            'bio' => 'Null',
        ]);
    }
	
}



```
# Pass data to bootstrap model
```php
<a href="#" onclick="editClassTimeTable('{{$timetable->id}}','{{$timetable->description}}','{{$timetable->type}}','{{$timetable->teacher_id}}','{{$timetable->subject_id}}','{{$timetable->date}}','{{$timetable->day}}','{{$timetable->start_time}}','{{$timetable->end_time}}')" data-target="#update-class-timetable" data-toggle="modal" class="btn btn-icon demo-pli-pen-5 icon-lg add-tooltip" data-original-title="Edit Post" data-container="body"></a>

```
# js function editClassTimeTable()
```js
function editClassTimeTable(id, description, type, teacher_id, subject_id, date, day, start_time, end_time)
  {
    $("#id").val(id);
    $("#description").val(description);
    $('#type').val(type).change();
    $('#subject_id').val(subject_id).change();
    $('#teacher_id').val(teacher_id).change();
    $('#edit-class-time-table').val(date);
    $('#class-timetable-day').val(day).change();
    $('.class_start_time').val(start_time);
    $('.class_end_time').val(end_time);
}
```

### Update with model in ajax
```js
<!DOCTYPE html>
<html>
<head>
    <title>Ajax</title>
     <meta charset="utf-8">
     <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
</head>
<body>
<div class="container">
    <div class="row">
        <div id="student-list" style="margin-top: 20px;">
            
        </div>
        <div id="models"></div>
    </div>
</div>

<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
<script type="text/javascript">
    $(function() {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.get('{{url("student")}}', function(data){
            $('#student-list').empty().append(data);
        });
        $('#student-list').on('click','#add-student', function(){
            $.get('{{route("student.create")}}', function(data){
            $('#models').empty().append(data);
            $('#basicExampleModal').modal('show');
        });
        });

         $('#student-list').on('click','#std-edit', function(){
            var id = $(this).data('task');
            $.get('{{url("student/edit")}}/'+id, function(data){
            $('#models').empty().append(data);
            $('#editExampleModal').modal('show');
        });
        });

         $('#student-list').on('click','#std-delete', function(){
            var id = $(this).data('task');
            $.get('{{url("student/destroy")}}/'+id, function(data){
            $('#student-list').empty().append(data);
        });
        });

        $('#models').on('submit', '#stdForm', function(e){
            e.preventDefault();
            var formData = $(this).serialize();
            $.post('{{route("student.store")}}',formData, function(data, xhrStatus, xhr){
                $('#student-list').empty().append(data);
                $('#basicExampleModal').modal('hide');
            })
        });
        $('#models').on('submit', '#editStudent', function(e){
            e.preventDefault();
            var formData = $(this).serialize();
            $.post('{{route("student.update")}}',formData, function(data, xhrStatus, xhr){
                $('#student-list').empty().append(data);
                $('#editExampleModal').modal('hide');
            })
        });
    });
</script>
</body>
</html>
```
### View
```html

<div class="panel panel-primary">
    <div class="panel-heading clearfix">
        <h4 class="panel-title pull-left" style="padding-top: 7.5px;">Student</h4>
        <div class="btn-group pull-right">
            <a href="#" class="btn btn-default btn-sm" data-toggle="modal" data-target="#basicExampleModal" id="add-student">Add Student</a>
        </div>
           
        </div>
        <div>
             <ul class="list-group">
                @if($students->all())
                <table class="table table-striped table-bordered">
                    <tr>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Phone</th>
                        <th>Action</th>
                    </tr>
                    @foreach($students as $student)
                    <tr>
                        <td>{{$student->name}}</td>
                        <td>{{$student->email}}</td>
                        <td>{{$student->phone}}</td>
                        <td>
                            <p class="btn btn-success btn-xs" id="std-edit" data-task="{{$student->id}}">Edit</p>
                            <p class="btn btn-danger btn-xs" id="std-delete" data-task="{{$student->id}}">Delete</p>
                        </td>
                    </tr>
                    @endforeach
                </table>
                @else
                <li class="list-group-item">Record Not found</li>
                @endif
            </ul>
        </div>
    </div>
</div>
```
### Add Model from
```html
<!-- Modal -->
<div class="modal fade" id="basicExampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Student Model</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
       

        <form method="post" action="{{route('student.store')}}" id="stdForm">
          @csrf
            <div class="form-group">
              <label>Name</label>
              <input type="text" name="name" id="name" class="form-control" placeholder="Name">
              
            </div>
             <div class="form-group">
              <label>Email</label>
              <input type="text" name="email" id="email" class="form-control" placeholder="Email">
              
            </div>
             <div class="form-group">
              <label>Phone</label>
              <input type="text" name="phone" id="phone" class="form-control" placeholder="Phone">
              
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
              <input type="submit" class="btn btn-primary" value="Save Data">
            </div>
      </form>
    </div>
  </div>
</div>
```
 ### Edit Model form
 ```html
 <!-- Modal -->
<div class="modal fade" id="editExampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Student Model</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
       

        <form method="post" action="{{route('student.update')}}" id="editStudent">
          @csrf
          <input type="hidden" name="id" value="{{$student->id}}">
            <div class="form-group">
              <label>Name</label>
              <input type="text" name="name" class="form-control" placeholder="Name" value="{{$student->name}}">
              
            </div>
             <div class="form-group">
              <label>Email</label>
              <input type="text" name="email" class="form-control" placeholder="Email" value="{{$student->email}}">
              
            </div>
             <div class="form-group">
              <label>Phone</label>
              <input type="text" name="phone" class="form-control" placeholder="Phone" value="{{$student->phone}}">
            </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary">Save changes</button>
        </div>
      </form>
    </div>
  </div>
</div>
 ```
