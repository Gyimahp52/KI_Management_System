document.addEventListener('DOMContentLoaded', () => {
  const addEducatorButton = document.getElementById('addEducatorButton');
  const formContainer = document.querySelector('.form-container');
  const table = document.querySelector('table');
  const cancelButton = document.getElementById('cancelButton');
  const popupFormContainer = document.getElementById('popupFormContainer');
  const cancelPopupButton = document.getElementById('cancelPopupButton');
  const tableBody = document.querySelector('tbody');

  addEducatorButton.addEventListener('click', (e) => {
      e.preventDefault();
      formContainer.classList.remove('d-none');
      table.style.opacity = '0.3';
      addEducatorButton.classList.add('disabled');
      addEducatorButton.style.pointerEvents = 'none';
  });

  cancelButton.addEventListener('click', () => {
      formContainer.classList.add('d-none');
      table.style.opacity = '1';
      addEducatorButton.classList.remove('disabled');
      addEducatorButton.style.pointerEvents = 'auto';
  });

  const passportPicture = document.querySelector('.passport-picture');
  const fileInput = document.querySelector('#passport');

  passportPicture.addEventListener('click', () => {
      fileInput.click();
  });

  fileInput.addEventListener('change', (e) => {
      const file = e.target.files[0];
      const reader = new FileReader();
      reader.onload = () => {
          passportPicture.style.backgroundImage = `url(${reader.result})`;
      }
      if (file) {
          reader.readAsDataURL(file);
      }
  });

  const form = document.querySelector('#educatorForm');
  form.addEventListener('submit', (e) => {
      e.preventDefault();
      const name = document.querySelector('#name').value;
      const phone = document.querySelector('#phone').value;
      const school = document.querySelector('#school').value;
      const row = tableBody.insertRow();
      row.innerHTML = `
          <td>${name}</td>
          <td>${phone}</td>
          <td>${school}</td>
          <td><button class="edit-button btn btn-warning">Edit</button></td>
      `;
      tableBody.appendChild(row);
      form.reset();
      passportPicture.style.backgroundImage = 'none';
      formContainer.classList.add('d-none');
      table.style.opacity = '1';
      addEducatorButton.classList.remove('disabled');
      addEducatorButton.style.pointerEvents = 'auto';

      // Show toast
      showToast(`Educator ${name} is added`);

      // Add edit button functionality
      const editButton = row.querySelector('.edit-button');
      editButton.addEventListener('click', () => {
          showPopupForm(row.rowIndex);
      });
  });

  function showPopupForm(rowIndex) {
      const row = tableBody.rows[rowIndex - 1];
      const cells = row.cells;
      document.getElementById('editIndex').value = rowIndex;
      document.getElementById('namePopup').value = cells[0].innerText;
      document.getElementById('phonePopup').value = cells[1].innerText;
      document.getElementById('schoolPopup').value = cells[2].innerText;
      popupFormContainer.classList.remove('d-none');
      table.style.opacity = '0.3';
  }

  cancelPopupButton.addEventListener('click', () => {
      popupFormContainer.classList.add('d-none');
      table.style.opacity = '1';
  });

  const editForm = document.querySelector('#editEducatorForm');
  editForm.addEventListener('submit', (e) => {
      e.preventDefault();
      const rowIndex = document.getElementById('editIndex').value;
      const row = tableBody.rows[rowIndex - 1];
      row.cells[0].innerText = document.getElementById('namePopup').value;
      row.cells[1].innerText = document.getElementById('phonePopup').value;
      row.cells[2].innerText = document.getElementById('schoolPopup').value;
      popupFormContainer.classList.add('d-none');
      table.style.opacity = '1';
  });

  function showToast(message) {
      const toast = document.getElementById('toast');
      toast.textContent = message;
      toast.className = 'toast show';
      setTimeout(() => {
          toast.className = toast.className.replace('show', '');
      }, 3000);
  }
});
