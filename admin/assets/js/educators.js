const passportPicture = document.querySelector('.passport-picture');
const fileInput = document.querySelector('#passport');
const tableBody = document.querySelector('tbody');


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

const form = document.querySelector('form');
form.addEventListener('submit', (e) => {
  e.preventDefault();

  const name = document.querySelector('#name').value;
  const phone = document.querySelector('#phone').value;
  const school = document.querySelector('#school').value;

  const row = document.insertRow();
  row.innerHTML = `
    <td>${name}</td>
    <td>${phone}</td>
    <td>${school}</td>
  `;

  tableBody.appendChild(row);
  form.reset(); //reset form 
  passportPicture.reset(); // reset the photo area
  
});
