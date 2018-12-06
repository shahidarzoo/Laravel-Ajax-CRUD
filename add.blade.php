<!-- Modal -->
<div class="modal fade" id="basicExampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" data-backdrop="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Student Model</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
       <ul id="add-student-validation" class="list-group list-unstyled">
         
       </ul>

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







