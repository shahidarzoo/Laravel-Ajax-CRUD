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