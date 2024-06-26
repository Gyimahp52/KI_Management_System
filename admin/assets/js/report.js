document.addEventListener("DOMContentLoaded", () => {
    const tabs = document.querySelectorAll(".tab-button");
    tabs.forEach(tab => {
        tab.addEventListener("click", () => {
            document.querySelector(".tab-button.active").classList.remove("active");
            tab.classList.add("active");

            document.querySelector(".tab-content.active").classList.remove("active");
            document.getElementById(tab.textContent.toLowerCase().replace(" ", "")).classList.add("active");
        });
    });

    const schoolSelect = document.getElementById('school');
    const classSelect = document.getElementById('class');
    const termSelect = document.getElementById('term');
    const studentsList = document.getElementById('students-list');
    const saveScoresButton = document.getElementById('save-scores');

    // Mock data for schools, classes, and students
    const schools = [
        { id: 1, name: 'Glory', scoreFields: ['Math', 'English', 'Science'] },
        { id: 2, name: 'School B', scoreFields: ['History', 'Geography', 'Biology'] },
        { id: 3, name: 'School C', scoreFields: ['Physics', 'Chemistry', 'Math'] }
    ];

    const classes = [
        { id: 1, schoolId: 1, name: 'Class 1A' },
        { id: 2, schoolId: 1, name: 'Class 1B' },
        { id: 3, schoolId: 2, name: 'Class 2A' },
        { id: 4, schoolId: 3, name: 'Class 3A' }
    ];

    const students = [
        { id: 1, classId: 1, name: 'Student 1' },
        { id: 2, classId: 1, name: 'Student 2' },
        { id: 3, classId: 2, name: 'Student 3' },
        { id: 4, classId: 3, name: 'Student 4' },
        { id: 5, classId: 4, name: 'Student 5' }
    ];

    // Populate school dropdown
    schools.forEach(school => {
        const option = document.createElement('option');
        option.value = school.id;
        option.textContent = school.name;
        schoolSelect.appendChild(option);
    });

    // Populate class dropdown based on selected school
    schoolSelect.addEventListener('change', () => {
        classSelect.innerHTML = '<option value="">--Select Class--</option>';
        studentsList.innerHTML = '';
        const selectedSchoolId = parseInt(schoolSelect.value);
        const filteredClasses = classes.filter(cls => cls.schoolId === selectedSchoolId);
        filteredClasses.forEach(cls => {
            const option = document.createElement('option');
            option.value = cls.id;
            option.textContent = cls.name;
            classSelect.appendChild(option);
        });
    });

    // Populate students list based on selected class and term
    classSelect.addEventListener('change', updateStudentList);
    termSelect.addEventListener('change', updateStudentList);

    function updateStudentList() {
        studentsList.innerHTML = '';
        const selectedClassId = parseInt(classSelect.value);
        const selectedSchoolId = parseInt(schoolSelect.value);
        const selectedTerm = termSelect.value;
        if (selectedClassId && selectedSchoolId && selectedTerm) {
            const filteredStudents = students.filter(stu => stu.classId === selectedClassId);
            const selectedSchool = schools.find(school => school.id === selectedSchoolId);

            if (filteredStudents.length > 0 && selectedSchool) {
                const table = document.createElement('table');

                // Create table header
                const thead = document.createElement('thead');
                const headerRow = document.createElement('tr');

                const studentHeader = document.createElement('th');
                studentHeader.textContent = 'Student';
                headerRow.appendChild(studentHeader);

                selectedSchool.scoreFields.forEach(field => {
                    const th = document.createElement('th');
                    th.textContent = field;
                    headerRow.appendChild(th);
                });

                thead.appendChild(headerRow);
                table.appendChild(thead);

                // Create table body
                const tbody = document.createElement('tbody');
                filteredStudents.forEach(student => {
                    const row = document.createElement('tr');

                    const studentName = document.createElement('td');
                    studentName.textContent = student.name;
                    row.appendChild(studentName);

                    selectedSchool.scoreFields.forEach(field => {
                        const td = document.createElement('td');
                        const inputField = document.createElement('input');
                        inputField.type = 'text';
                        inputField.classList.add('input-field');
                        inputField.placeholder = field;
                        inputField.pattern = "\\d*"; // Allow only numbers
                        td.appendChild(inputField);
                        row.appendChild(td);
                    });

                    tbody.appendChild(row);
                });

                table.appendChild(tbody);
                studentsList.appendChild(table);
            }
        }
    }

    // Save scores (mock function)
    saveScoresButton.addEventListener('click', () => {
        const rows = document.querySelectorAll('tbody tr');
        const scoresData = [];

        rows.forEach(row => {
            const studentName = row.cells[0].textContent;
            const scoreFields = row.querySelectorAll('.input-field');
            const scores = {};

            scoreFields.forEach(field => {
                scores[field.placeholder] = field.value;
            });

            scoresData.push({ studentName, scores });
        });

        console.log('Scores saved:', scoresData);
        alert('Scores saved successfully!');
    });
});

function exportData(format) {
    alert(`Exporting data as ${format}`);
    // Implement export functionality
}

function openTab(tabName) {
    const tabContent = document.querySelectorAll(".tab-content");
    tabContent.forEach(tab => {
        tab.style.display = "none";
    });
    document.getElementById(tabName).style.display = "block";
}

function generateReports() {
    const studentList = document.getElementById("studentList");
    studentList.innerHTML = ""; // Clear existing data

    // Dummy data for demonstration
    const students = [
        { name: "John Doe", class: "5A", term: "Term 1" },
        { name: "Jane Smith", class: "5A", term: "Term 1" }
    ];

    students.forEach(student => {
        const row = document.createElement("tr");

        const nameCell = document.createElement("td");
        nameCell.textContent = student.name;
        row.appendChild(nameCell);

        const classCell = document.createElement("td");
        classCell.textContent = student.class;
        row.appendChild(classCell);

        const termCell = document.createElement("td");
        termCell.textContent = student.term;
        row.appendChild(termCell);

        const reportCell = document.createElement("td");
        reportCell.innerHTML = '<a href="#">Generated Report</a>';
        row.appendChild(reportCell);

        const actionsCell = document.createElement("td");
        actionsCell.innerHTML = `
            <button onclick="viewReport('${student.name}')">View</button>
            <button onclick="downloadReport('${student.name}')">Download</button>
            <button onclick="sendWhatsApp('${student.name}')">Send via WhatsApp</button>
        `;
        row.appendChild(actionsCell);

        studentList.appendChild(row);
    });
}

function viewReport(name) {
    alert(`Viewing report for ${name}`);
    // Implement view functionality
}

function downloadReport(name) {
    alert(`Downloading report for ${name}`);
    // Implement download functionality
}

function sendWhatsApp(name) {
    alert(`Sending report via WhatsApp for ${name}`);
    // Implement WhatsApp functionality
}
