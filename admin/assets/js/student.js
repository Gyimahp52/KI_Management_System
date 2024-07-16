document.addEventListener('DOMContentLoaded', () => {
    const addStudentButton = document.getElementById('addSchoolButton');
    // const studentFormContainer = document.getElementById('studentFormContainer');
    const studentForm = document.getElementById('student-form');
    const cancelButton = document.querySelector('.cancel-button');
    const table = document.getElementById('studentTable');
    // const tableBody = table.querySelector('tbody');

    addStudentButton.addEventListener('click', (e) => {
        e.preventDefault();
        studentFormContainer.style.display = 'block';
        table.classList.add('hidden');
        addSchoolButton.classList.add('disabled');
        addSchoolButton.style.pointerEvents = 'none';
    });

    cancelButton.addEventListener('click', (e) => {
        studentFormContainer.style.display = 'none';
        table.classList.remove('hidden');
        addSchoolButton.classList.remove('disabled');
        addSchoolButton.style.pointerEvents = 'auto';
    });

    // studentForm.addEventListener('submit', (e) => {
    //     e.preventDefault();

    //     const firstName = document.getElementById('first-name').value;
    //     const lastName = document.getElementById('last-name').value;
    //     const dob = document.getElementById('dob').value;
    //     const gender = document.getElementById('gender').value;
    //     const height = document.getElementById('height').value;
    //     const weight = document.getElementById('weight').value;
    //     const guardianName = document.getElementById('guardian-name').value;
    //     const guardianPhone = document.getElementById('guardian-phone').value;
    //     const guardianEmail = document.getElementById('guardian-email').value;
    //     const school = document.getElementById('school').value;
    //     const className = document.getElementById('class').value;

    //     const newRow = document.createElement('tr');
    //     newRow.innerHTML = `
    //         <td>${firstName}</td>
    //         <td>${lastName}</td>
    //         <td>${dob}</td>

    //         <td>${school}</td>
    //         <td>${className}</td>
    //     `;
    //     tableBody.appendChild(newRow);

    //     studentForm.reset();
    //     studentFormContainer.style.display = 'none';
    //     table.classList.remove('hidden');
    //     addSchoolButton.classList.remove('disabled');
    //     addSchoolButton.style.pointerEvents = 'auto';
    // });
});
