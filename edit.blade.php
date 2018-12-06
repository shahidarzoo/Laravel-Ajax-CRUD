<!-- Modal -->
<div class="modal fade" id="editExampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" data-backdrop="true">
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







