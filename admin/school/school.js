document.addEventListener('DOMContentLoaded', () => {
  const addSchoolButton = document.getElementById('addSchoolButton');
  const schoolFormContainer = document.getElementById('schoolFormContainer');
  const cancelButton = document.querySelector('.cancel-button');
  const form = document.getElementById('schoolForm');
  const tableBody = document.querySelector('#schoolTable tbody');

  addSchoolButton.addEventListener('click', function(event) {
      event.preventDefault();
      schoolFormContainer.style.display = 'block';
      addSchoolButton.classList.add('disabled');
      addSchoolButton.style.pointerEvents = 'none';
  });

  cancelButton.addEventListener('click', function(event) {
      event.preventDefault();
      schoolFormContainer.style.display = 'none';
      addSchoolButton.classList.remove('disabled');
      addSchoolButton.style.pointerEvents = 'auto';
  });

  form.addEventListener('submit', function(event) {
      event.preventDefault();

      const id = document.getElementById('id').value;
      const name = document.getElementById('name').value;
      const region = document.getElementById('region').value;
      const town = document.getElementById('town').value;
      const owner = document.getElementById('owner').value;
      const contact = document.getElementById('contact').value;
      const email = document.getElementById('email').value;

      const row = tableBody.insertRow();
      row.innerHTML = `
          <td>${id}</td>
          <td>${name}</td>
          <td>${region}</td>
          <td>${town}</td>
          <td>${owner}</td>
          <td>${contact}</td>
          <td>${email}</td>
      `;

      tableBody.appendChild(row);
      form.reset();
      schoolFormContainer.style.display = 'none';
      addSchoolButton.classList.remove('disabled');
      addSchoolButton.style.pointerEvents = 'auto';
  });
});
