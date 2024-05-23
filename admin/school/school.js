document.addEventListener('DOMContentLoaded', () => {
  const addSchoolButton = document.getElementById('addSchoolButton');
  const schoolFormContainer = document.getElementById('schoolFormContainer');
  const cancelButton = document.querySelector('.cancel-button');
  const SchoolForm = document.getElementById('schoolForm');
  
  const table = document.getElementById('schoolTable');
  const tableBody = table.querySelector('tbody');

  addSchoolButton.addEventListener('click', (event)=> {
      event.preventDefault();
      schoolFormContainer.style.display = 'block';
      table.classList.add('hidden');
      addSchoolButton.classList.add('disabled');
      addSchoolButton.style.pointerEvents = 'none';
  });

  cancelButton.addEventListener('click', (event)=> {
      event.preventDefault();
      schoolFormContainer.style.display = 'none';
      table.classList.remove('hidden');
      addSchoolButton.classList.remove('disabled');
      addSchoolButton.style.pointerEvents = 'auto';
  });

  SchoolForm.addEventListener('submit',(event) =>{
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
          
          <td>${name}</td>
          <td>${region}</td>
          <td>${town}</td>
          <td>${owner}</td>
          <td>${contact}</td>
          <td>${email}</td>
      `;

      tableBody.appendChild(row);
      SchoolForm.reset();
      schoolFormContainer.style.display = 'none';
      table.classList.remove('hidden');
      addSchoolButton.classList.remove('disabled');
      addSchoolButton.style.pointerEvents = 'auto';
  });
});
