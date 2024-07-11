<div class="modal fade" id="addStudentModal" tabindex="-1" role="dialog" aria-labelledby="addStudentModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <form id="studentForm" action="db_config.php" method="POST" enctype="multipart/form-data" novalidate>
        <input type="hidden" name="action" value="create_student">
        <input type="hidden" id="classIdForStudent" name="classId">
        <div class="modal-header">
          <h5 class="modal-title" id="addStudentModalLabel">Add Student</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <div class="form-group">
            <label for="passportPicture">Passport Picture</label>
            <input type="file" class="form-control-file" id="passportPicture" name="passportPicture" />
          </div>
          <div class="form-row">
            <div class="form-group col-md-6">
              <label for="firstName">First Name</label>
              <input type="text" class="form-control" id="firstName" name="firstName" placeholder="Enter First Name" required />
              <div class="invalid-feedback">First Name is required.</div>
            </div>
            <div class="form-group col-md-6">
              <label for="lastName">Last Name</label>
              <input type="text" class="form-control" id="lastName" name="lastName" placeholder="Enter Last Name" required />
              <div class="invalid-feedback">Last Name is required.</div>
            </div>
          </div>
          <div class="form-row">
            <div class="form-group col-md-6">
              <label for="dateOfBirth">Date of Birth</label>
              <input type="date" class="form-control" id="dateOfBirth" name="dateOfBirth" required />
              <div class="invalid-feedback">Date of Birth is required.</div>
            </div>
            <div class="form-group col-md-6">
              <label for="gender">Gender</label>
              <select class="form-control" id="gender" name="gender" required>
                <option value="">Select Gender</option>
                <option value="Male">Male</option>
                <option value="Female">Female</option>
              </select>
              <div class="invalid-feedback">Gender is required.</div>
            </div>
          </div>
          <div class="form-row">
            <div class="form-group col-md-6">
              <label for="hand">Hand</label>
              <input type="text" class="form-control" id="hand" name="hand" placeholder="Enter Hand" required />
              <div class="invalid-feedback">Hand is required.</div>
            </div>
            <div class="form-group col-md-6">
              <label for="foot">Foot</label>
              <input type="text" class="form-control" id="foot" name="foot" placeholder="Enter Foot" required />
              <div class="invalid-feedback">Foot is required.</div>
            </div>
          </div>
          <div class="form-row">
            <div class="form-group col-md-6">
              <label for="eyeSight">Eye Sight</label>
              <input type="text" class="form-control" id="eyeSight" name="eyeSight" placeholder="Enter Eye Sight" required />
              <div class="invalid-feedback">Eye Sight is required.</div>
            </div>
            <div class="form-group col-md-3">
              <label for="height">Height (cm)</label>
              <input type="number" class="form-control" id="height" name="height" placeholder="Enter Height" required />
              <div class="invalid-feedback">Height is required.</div>
            </div>
            <div class="form-group col-md-3">
              <label for="weight">Weight (kg)</label>
              <input type="number" class="form-control" id="weight" name="weight" placeholder="Enter Weight" required />
              <div class="invalid-feedback">Weight is required.</div>
            </div>
          </div>
          <div class="form-row">
            <div class="form-group col-md-6">
              <label for="guardianName">Guardian's Name</label>
              <input type="text" class="form-control" id="guardianName" name="guardianName" placeholder="Enter Guardian's Name" required />
              <div class="invalid-feedback">Guardian's Name is required.</div>
            </div>
            <div class="form-group col-md-6">
              <label for="guardianPhoneNumber">Guardian's Phone Number</label>
              <input type="text" class="form-control" id="guardianPhoneNumber" name="guardianPhoneNumber" placeholder="Enter Guardian's Phone Number" required />
              <div class="invalid-feedback">Guardian's Phone Number is required.</div>
            </div>
          </div>
          <div class="form-row">
            <div class="form-group col-md-6">
              <label for="guardianWhatsAppNumber">Guardian's WhatsApp Number</label>
              <input type="text" class="form-control" id="guardianWhatsAppNumber" name="guardianWhatsAppNumber" placeholder="Enter Guardian's WhatsApp Number" />
            </div>
            <div class="form-group col-md-6">
              <label for="guardianEmailAddress">Guardian's Email Address</label>
              <input type="email" class="form-control" id="guardianEmailAddress" name="guardianEmailAddress" placeholder="Enter Guardian's Email Address" />
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary">Add Student</button>
        </div>
      </form>
    </div>
  </div>
</div>
