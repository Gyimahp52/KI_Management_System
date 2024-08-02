document.addEventListener('DOMContentLoaded', function() {
  const mainContent = document.getElementById('main-content');
  const classList = document.getElementById('class-list');
  const classDetails = document.getElementById('class-details');
  const notificationModal = document.getElementById('notification-modal');
  const notificationMessage = document.getElementById('notification-message');
  const closeNotification = document.getElementById('close-notification');
  const profileBtn = document.getElementById('profile-btn');
  const classesBtn = document.getElementById('classes-btn');
  const photosBtn = document.getElementById('photos-btn');
  const logoutBtn = document.getElementById('logout-btn');
  const logoutModal = document.getElementById('logout-modal');
  const confirmLogout = document.getElementById('confirm-logout');
  const cancelLogout = document.getElementById('cancel-logout');
  const uploadModal = document.getElementById('upload-modal');
  const uploadInput = document.getElementById('upload-input');
  const uploadButton = document.getElementById('upload-button');
  const cancelUpload = document.getElementById('cancel-upload');
  const previewModal = document.getElementById('preview-modal');
  const previewImage = document.getElementById('preview-image');
  const closePreview = document.getElementById('close-preview');
  const backButton = document.getElementById('back-button');
  const submitScoresButton = document.getElementById('submit-scores-button');

  closeNotification.addEventListener('click', () => {
    notificationModal.classList.add('hidden');
  });

  profileBtn.addEventListener('click', showProfile);
  classesBtn.addEventListener('click', showClasses);
  photosBtn.addEventListener('click', showPhotos);
  logoutBtn.addEventListener('click', () => {
    logoutModal.classList.remove('hidden');
  });
  cancelLogout.addEventListener('click', () => {
    logoutModal.classList.add('hidden');
  });
  confirmLogout.addEventListener('click', () => {
    alert('Logged out successfully!');
    // Implement the actual logout logic here, e.g., redirect to login page
    logoutModal.classList.add('hidden');
  });

  document.querySelectorAll('.class-item').forEach(item => {
    item.addEventListener('click', () => {
      showClassDetails(item.getAttribute('data-class'));
    });
  });

  backButton.addEventListener('click', () => {
    classDetails.classList.add('hidden');
    classList.classList.remove('hidden');
  });

  submitScoresButton.addEventListener('click', () => {
    const inputs = document.querySelectorAll('.score-input');
    let allValid = true;

    inputs.forEach(input => {
      const value = input.value;
      if (value === '' || value < 2 || value > 10) {
        allValid = false;
        input.classList.add('error');
      } else {
        input.classList.remove('error');
      }
    });

    if (!allValid) {
      notificationMessage.textContent = 'Please fill in all the scores with valid numbers between 2 and 10.';
      notificationModal.classList.remove('hidden');
      return;
    }

    inputs.forEach(input => {
      input.setAttribute('readonly', true);
    });

    document.getElementById('success-message').style.display = 'block';
    setTimeout(() => {
      document.getElementById('success-message').style.display = 'none';
      inputs.forEach(input => {
        input.removeAttribute('readonly');
      });
    }, 2000);
  });

  document.querySelectorAll('.score-input').forEach(input => {
    input.addEventListener('input', () => {
      const value = input.value;
      if (value < 2 || value > 10) {
        input.classList.add('error');
        input.value = ''; // Clear the invalid value
        notificationMessage.textContent = 'Scores must be between 2 and 10.';
        notificationModal.classList.remove('hidden');
      } else {
        input.classList.remove('error');
        notificationModal.classList.add('hidden');
      }
    });
  });

  function showClasses() {
    classList.classList.remove('hidden');
    classDetails.classList.add('hidden');
  }

  function showClassDetails(className) {
    document.getElementById('class-title').textContent = `Class ${className} - ${getGrade(className)}`;
    classList.classList.add('hidden');
    classDetails.classList.remove('hidden');
  }

  function getGrade(className) {
    switch (className) {
      case '1A':
        return '1st Grade';
      case '2A':
        return '2nd Grade';
      // Add more cases for other class names
      default:
        return '';
    }
  }

  function showProfile() {
    mainContent.innerHTML = `
      <div class="profile-section">
        <h1 class="text-4xl font-bold text-[#141C24] mb-2">Welcome, Jane Williams</h1>
        <p class="text-sm text-[#3F5374] mb-6">You are an educator in Acme School</p>
        <div class="item">
          <img src="https://cdn.usegalileo.ai/stability/9745ab4a-5458-4603-9998-dc8c9d3bf8a0.png" alt="Profile" class="icon rounded-full">
          <div>
            <p class="text-lg font-medium">Name</p>
            <p class="text-sm text-[#3F5374]">jane@acme.com</p>
          </div>
        </div>
        <div class="item">
          <img src="https://img.icons8.com/ios-filled/50/000000/new-post.png" alt="Email" class="icon">
          <div>
            <p class="text-lg font-medium">Email</p>
            <p class="text-sm text-[#3F5374]">jane@acme.com</p>
          </div>
        </div>
        <div class="item">
          <img src="https://img.icons8.com/ios-filled/50/000000/place-marker.png" alt="Location" class="icon">
          <div>
            <p class="text-lg font-medium">Location</p>
            <p class="text-sm text-[#3F5374]">123 Main St.</p>
          </div>
        </div>
        <div class="item" id="change-password">
          <img src="https://img.icons8.com/ios-filled/50/000000/lock-2.png" alt="Change Password" class="icon">
          <div>
            <p class="text-lg font-medium">Change Password</p>
          </div>
        </div>
        <button class="mt-8 px-4 py-2 bg-[#E4E9F1] text-[#141C24] font-medium rounded-lg">Sign Out</button>
      </div>
    `;

    document.getElementById('change-password').addEventListener('click', showChangePassword);
  }

  function showChangePassword() {
    mainContent.innerHTML = `
      <div class="profile-section">
        <h1 class="text-4xl font-bold text-[#141C24] mb-2">Welcome, Jane Williams</h1>
        <p class="text-sm text-[#3F5374] mb-6">You are an educator in Acme School</p>
        <div class="item">
          <img src="https://cdn.usegalileo.ai/stability/9745ab4a-5458-4603-9998-dc8c9d3bf8a0.png" alt="Profile" class="icon rounded-full">
          <div>
            <p class="text-lg font-medium">Name</p>
            <p class="text-sm text-[#3F5374]">jane@acme.com</p>
          </div>
        </div>
        <div class="item">
          <img src="https://img.icons8.com/ios-filled/50/000000/new-post.png" alt="Email" class="icon">
          <div>
            <p class="text-lg font-medium">Email</p>
            <p class="text-sm text-[#3F5374]">jane@acme.com</p>
          </div>
        </div>
        <div class="item">
          <img src="https://img.icons8.com/ios-filled/50/000000/place-marker.png" alt="Location" class="icon">
          <div>
            <p class="text-lg font-medium">Location</p>
            <p class="text-sm text-[#3F5374]">123 Main St.</p>
          </div>
        </div>
        <div class="item">
          <img src="https://img.icons8.com/ios-filled/50/000000/lock-2.png" alt="Change Password" class="icon">
          <div>
            <p class="text-lg font-medium">Change Password</p>
          </div>
        </div>
        <div class="mt-4">
          <label class="block text-left">Current Password</label>
          <input type="password" id="current-password" class="w-full mt-2 p-2 border rounded" />
          <div id="current-password-error" class="error-message"></div>
        </div>
        <div class="mt-4">
          <label class="block text-left">New Password</label>
          <input type="password" id="new-password" class="w-full mt-2 p-2 border rounded" />
          <div id="new-password-error" class="error-message"></div>
        </div>
        <div class="mt-4">
          <label class="block text-left">Confirm New Password</label>
          <input type="password" id="confirm-password" class="w-full mt-2 p-2 border rounded" />
          <div id="confirm-password-error" class="error-message"></div>
        </div>
        <button class="mt-8 px-4 py-2 bg-[#F4C753] text-[#141C24] font-medium rounded-lg" id="update-password-button">Update Password</button>
      </div>
    `;

    document.getElementById('update-password-button').addEventListener('click', updatePassword);
  }

  function updatePassword() {
    const currentPassword = document.getElementById('current-password').value;
    const newPassword = document.getElementById('new-password').value;
    const confirmPassword = document.getElementById('confirm-password').value;

    let valid = true;

    // Clear previous errors
    document.getElementById('current-password-error').textContent = '';
    document.getElementById('new-password-error').textContent = '';
    document.getElementById('confirm-password-error').textContent = '';

    // Validate current password
    if (!currentPassword) {
      document.getElementById('current-password-error').textContent = 'Current password is required.';
      valid = false;
    }

    // Validate new password
    if (!newPassword) {
      document.getElementById('new-password-error').textContent = 'New password is required.';
      valid = false;
    } else if (newPassword.length < 6) {
      document.getElementById('new-password-error').textContent = 'New password must be at least 6 characters.';
      valid = false;
    }

    // Validate confirm password
    if (!confirmPassword) {
      document.getElementById('confirm-password-error').textContent = 'Please confirm your new password.';
      valid = false;
    } else if (newPassword !== confirmPassword) {
      document.getElementById('confirm-password-error').textContent = 'Passwords do not match.';
      valid = false;
    }

    if (valid) {
      // Perform the password update operation here
      alert('Password updated successfully!');
      // Optionally, redirect or show a success message
    }
  }

  function showPhotos() {
    mainContent.innerHTML = `
      <div class="photos-page">
        <h1 class="text-4xl font-bold text-[#141C24] mb-6">Photos</h1>
        <div class="selectors mb-6">
          <select id="class-selector" class="p-2 rounded-lg border border-gray-300">
            <option>Choose...</option>
            <option value="1A">1A</option>
            <option value="2A">2A</option>
            <!-- Add more class options as needed -->
          </select>
          <select id="student-selector" class="p-2 rounded-lg border border-gray-300">
            <option>Choose...</option>
          </select>
        </div>
        <div class="photos-grid" id="photos-grid">
          <div class="photo-item">
            <img src="https://cdn.usegalileo.ai/stability/9745ab4a-5458-4603-9998-dc8c9d3bf8a0.png" alt="Sample Photo" class="cursor-pointer" />
            <button class="delete-btn">×</button>
          </div>
          <!-- Add more photo items here as needed -->
        </div>
        <button class="upload-btn mt-6 px-4 py-2 bg-[#E4E9F1] text-[#141C24] font-medium rounded-lg" id="upload-new-photo">Upload new photo</button>
      </div>
    `;

    const classSelector = document.getElementById('class-selector');
    const studentSelector = document.getElementById('student-selector');
    const photosGrid = document.getElementById('photos-grid');
    const uploadNewPhoto = document.getElementById('upload-new-photo');

    classSelector.addEventListener('change', function() {
      const selectedClass = classSelector.value;
      if (selectedClass === '1A') {
        studentSelector.innerHTML = `
          <option>Choose...</option>
          <option value="Alex">Alex</option>
          <option value="Bella">Bella</option>
          <!-- Add more students for class 1A as needed -->
        `;
      } else if (selectedClass === '2A') {
        studentSelector.innerHTML = `
          <option>Choose...</option>
          <option value="Chris">Chris</option>
          <option value="Diana">Diana</option>
          <!-- Add more students for class 2A as needed -->
        `;
      } else {
        studentSelector.innerHTML = '<option>Choose...</option>';
      }
    });

    uploadNewPhoto.addEventListener('click', () => {
      uploadModal.classList.remove('hidden');
    });

    cancelUpload.addEventListener('click', () => {
      uploadModal.classList.add('hidden');
    });

    uploadButton.addEventListener('click', () => {
      const file = uploadInput.files[0];
      if (file) {
        const reader = new FileReader();
        reader.onload = function(event) {
          const img = document.createElement('img');
          img.src = event.target.result;
          img.alt = 'Uploaded Photo';
          img.classList.add('cursor-pointer');

          const photoItem = document.createElement('div');
          photoItem.classList.add('photo-item');
          photoItem.appendChild(img);

          const deleteButton = document.createElement('button');
          deleteButton.textContent = '×';
          deleteButton.addEventListener('click', () => {
            photoItem.remove();
          });

          img.addEventListener('click', () => {
            previewImage.src = img.src;
            previewModal.classList.remove('hidden');
          });

          photoItem.appendChild(deleteButton);
          photosGrid.appendChild(photoItem);

          uploadModal.classList.add('hidden');
        };
        reader.readAsDataURL(file);
      }
    });

    closePreview.addEventListener('click', () => {
      previewModal.classList.add('hidden');
    });
  }

  // Initialize the class list view
  showClasses();
});
