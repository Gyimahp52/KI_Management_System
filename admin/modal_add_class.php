<div class="modal fade" id="addClassModal" tabindex="-1" role="dialog" aria-labelledby="addClassModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <form id="classForm" action="db_config.php" method="POST" novalidate>
        <input type="hidden" name="action" value="create_class">
        <input type="hidden" id="schoolIdForClass" name="schoolId">
        <div class="modal-header">
          <h5 class="modal-title" id="addClassModalLabel">Add Class</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <div class="form-group">
            <label for="className">Class Name</label>
            <input type="text" class="form-control" id="className" name="className" placeholder="Enter Class Name" required />
            <div class="invalid-feedback">Class Name is required.</div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary">Add Class</button>
        </div>
      </form>
    </div>
  </div>
</div>
