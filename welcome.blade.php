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
            /*$.post('{{route("student.store")}}',formData, function(data, xhrStatus, xhr){
                $('#student-list').empty().append(data);
                $('#basicExampleModal').modal('hide');
            })*/
            $.ajax({
                url: '{{route("student.store")}}',
                type: 'POST',
                data: formData,
            })
            .done(function(data){
               $("#models #add-student-validation").empty().append('<li class="alert alert-success">Successfully Added</li>');
                $('#student-list').empty().append(data);
                setTimeout(function() {
                    $('#basicExampleModal').modal('hide');
                }, 3000);
            })
            .fail(function(error){
                var er = $.parseJSON(error.responseText);
               var errors_list = '';
               $("#models #add-student-validation").empty();
               $.each(er.errors, function (fields, messages) {

                   $.each(messages, function (index, msg) {
                       errors_list += '<li class="alert alert-danger">' + msg + '</li>';
                   })
               });
              $('#add-student-validation').html(errors_list);
            });
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