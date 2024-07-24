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
    const reportAcademicYearSelect = document.getElementById('reportAcademicYear');
    const reportSchoolSelect = document.getElementById('reportSchool');
    const reportClassSelect = document.getElementById('reportClass');
    const reportTermSelect = document.getElementById('reportTerm');
    const studentsList = document.getElementById('students-list');
    const saveScoresButton = document.getElementById('save-scores');
    const loadReportsButton = document.getElementById('loadReports');
    const selectAllCheckbox = document.getElementById('selectAll');
    const downloadSelectedReportsButton = document.getElementById('downloadSelectedReports');

    let schools = [];

    // Fetch schools from the database
    function fetchSchools() {
        fetch('get_schools.php')
            .then(response => response.json())
            .then(data => {
                schools = data;
                populateSchoolDropdown(schoolSelect, data);
                populateSchoolDropdown(reportSchoolSelect, data);
            })
            .catch(error => console.error('Error fetching schools:', error));
    }

    // Populate school dropdown
    function populateSchoolDropdown(selectElement, schools) {
        selectElement.innerHTML = '<option value="">--Select School--</option>';
        schools.forEach(school => {
            const option = document.createElement('option');
            option.value = school.id;
            option.textContent = school.name;
            selectElement.appendChild(option);
        });
    }

    // Fetch classes based on selected school
    function fetchClasses(schoolId, classSelectElement) {
        fetch(`get_classes.php?school_id=${schoolId}`)
            .then(response => response.json())
            .then(data => populateClassDropdown(classSelectElement, data))
            .catch(error => console.error('Error fetching classes:', error));
    }

    // Populate class dropdown
    function populateClassDropdown(classSelectElement, classes) {
        classSelectElement.innerHTML = '<option value="">--Select Class--</option>';
        classes.forEach(cls => {
            const option = document.createElement('option');
            option.value = cls.id;
            option.textContent = cls.name;
            classSelectElement.appendChild(option);
        });
    }

    // Fetch students based on selected class
    function fetchStudents(classId) {
        fetch(`get_students.php?class_id=${classId}`)
            .then(response => response.json())
            .then(data => updateStudentList(data, classId))
            .catch(error => console.error('Error fetching students:', error));
    }

    // Update students list
    function updateStudentList(students, classId) {
        studentsList.innerHTML = '';
        if (students.length > 0) {
            const selectedSchoolId = parseInt(schoolSelect.value);
            const selectedSchool = schools.find(school => school.id === selectedSchoolId);
            const scoreFields = selectedSchool ? selectedSchool.score_fields.split(',') : [];

            const table = document.createElement('table');

            // Create table header
            const thead = document.createElement('thead');
            const headerRow = document.createElement('tr');

            const studentHeader = document.createElement('th');
            studentHeader.textContent = 'Student';
            headerRow.appendChild(studentHeader);

            scoreFields.forEach(field => {
                const th = document.createElement('th');
                th.textContent = field;
                headerRow.appendChild(th);
            });

            thead.appendChild(headerRow);
            table.appendChild(thead);

            // Create table body
            const tbody = document.createElement('tbody');
            students.forEach(student => {
                const row = document.createElement('tr');

                const studentName = document.createElement('td');
                studentName.textContent = student.name;
                row.appendChild(studentName);

                scoreFields.forEach(field => {
                    const td = document.createElement('td');
                    const inputField = document.createElement('input');
                    inputField.type = 'number';
                    inputField.classList.add('input-field');
                    inputField.placeholder = field;
                    inputField.min = 2;
                    inputField.max = 9;
                    inputField.addEventListener('input', validateInput);
                    td.appendChild(inputField);
                    row.appendChild(td);
                });

                tbody.appendChild(row);
            });

            table.appendChild(tbody);
            studentsList.appendChild(table);
        }
    }

    // Validate input fields
    function validateInput(event) {
        const input = event.target;
        if (input.value < 2 || input.value > 9) {
            input.classList.add('invalid');
            showToast('Scores must be between 2 and 9.');
        } else {
            input.classList.remove('invalid');
        }
    }

    // Save scores to local storage
    saveScoresButton.addEventListener('click', () => {
        const rows = document.querySelectorAll('tbody tr');
        const scoresData = [];
        let isValid = true;
        let invalidFields = [];

        rows.forEach(row => {
            const studentName = row.cells[0].textContent;
            const scoreFields = row.querySelectorAll('.input-field');
            const scores = {};

            scoreFields.forEach(field => {
                const value = parseInt(field.value);
                if (value < 2 || value > 9 || isNaN(value)) {
                    isValid = false;
                    invalidFields.push(field);
                }
                scores[field.placeholder] = field.value;
            });

            scoresData.push({ studentName, scores });
        });

        if (isValid) {
            localStorage.setItem('studentScores', JSON.stringify(scoresData));
            showToast('Scores saved successfully!', 'success');
        } else {
            showToast('Please ensure all score fields have values between 2 and 9.', 'error');
            invalidFields.forEach(field => {
                field.classList.add('invalid');
            });
        }
    });

    // Load reports based on selected academic year, school, class, and term
    loadReportsButton.addEventListener('click', () => {
        const selectedAcademicYear = reportAcademicYearSelect.value;
        const selectedSchoolId = parseInt(reportSchoolSelect.value);
        const selectedClassId = parseInt(reportClassSelect.value);
        const selectedTerm = reportTermSelect.value;

        if (selectedAcademicYear && selectedSchoolId && selectedClassId && selectedTerm) {
            fetchStudents(selectedClassId);
        }
    });

    // Select all checkboxes
    selectAllCheckbox.addEventListener('change', () => {
        const checkboxes = document.querySelectorAll('.student-checkbox');
        checkboxes.forEach(checkbox => {
            checkbox.checked = selectAllCheckbox.checked;
        });
    });

    // Download selected reports
    downloadSelectedReportsButton.addEventListener('click', () => {
        const selectedCheckboxes = document.querySelectorAll('.student-checkbox:checked');
        const selectedStudents = Array.from(selectedCheckboxes).map(checkbox => checkbox.value);
        if (selectedStudents.length > 0) {
            showToast('Hold on, report will download soon', 'info');
            setTimeout(() => {
                alert(`Downloading reports for: ${selectedStudents.join(', ')}`);
                // Implement download functionality
            }, 3000);
        } else {
            showToast('No students selected.', 'error');
        }
    });

    function viewReport(name) {
        // Fetch student data based on name (mock data here)
        const student = students.find(stu => stu.name === name);
        const studentClass = classes.find(cls => cls.id === student.classId);
        const studentSchool = schools.find(sch => sch.id === studentClass.schoolId);

        // Load saved scores
        const savedScores = JSON.parse(localStorage.getItem('studentScores')) || [];
        const studentScores = savedScores.find(score => score.studentName === name);

        // Populate the report
        document.getElementById('student-name').textContent = student.name;
        document.getElementById('student-name-info').textContent = student.name;
        document.getElementById('student-school').textContent = studentSchool.name;
        document.getElementById('student-school-info').textContent = studentSchool.name;
        document.getElementById('student-class-info').textContent = studentClass.name;

        // Populate scores in the report
        if (studentScores) {
            studentSchool.score_fields.split(',').forEach((field, index) => {
                document.getElementById(`keq-${index + 1}`).textContent = studentScores.scores[field];
            });
        }

        // Show the report container
        const modal = document.getElementById('report-view');
        modal.style.display = 'flex';

        // Fade out the main container
        document.querySelector('.main-container').classList.add('fade-out');
    }

    window.viewReport = viewReport;

    function closeReport() {
        document.getElementById('report-view').style.display = 'none';
        document.querySelector('.main-container').classList.remove('fade-out');
    }

    window.closeReport = closeReport;

    function deleteReport(name) {
        if (confirm(`Are you sure you want to delete the report for ${name}?`)) {
            alert(`Report for ${name} deleted.`);
            // Implement delete functionality
        }
    }

    window.deleteReport = deleteReport;

    async function downloadReport(name) {
        showToast('Hold on, report will download soon', 'info');
        setTimeout(async () => {
            // Populate the report view for the selected student
            viewReport(name);

            // Wait for the charts to render (you can replace this with a more robust approach if necessary)
            await new Promise(resolve => setTimeout(resolve, 1000));

            const pdf = new jspdf.jsPDF('p', 'pt', 'a4');

            const pages = document.querySelectorAll('.report-container > div[id^="report-page-"]');

            for (const page of pages) {
                await html2canvas(page).then(canvas => {
                    const imgData = canvas.toDataURL('image/png');
                    const imgProps = pdf.getImageProperties(imgData);
                    const pdfWidth = pdf.internal.pageSize.getWidth();
                    const pdfHeight = (imgProps.height * pdfWidth) / imgProps.width;
                    pdf.addImage(imgData, 'PNG', 0, 0, pdfWidth, pdfHeight);
                    pdf.addPage();
                });
            }

            // Remove the last blank page
            pdf.deletePage(pdf.getNumberOfPages());

            pdf.save(`${name}_report.pdf`);

            // Close the report view
            closeReport();
        }, 3000);
    }

    window.downloadReport = downloadReport;

    function sendWhatsApp(name) {
        showToast(`Sending report via WhatsApp for ${name}`, 'info');
        // Implement WhatsApp functionality
    }

    window.sendWhatsApp = sendWhatsApp;

    function openTab(tabName) {
        const tabContent = document.querySelectorAll(".tab-content");
        tabContent.forEach(tab => {
            tab.style.display = "none";
        });
        document.getElementById(tabName).style.display = "block";
        document.querySelector(`.tab-button.active`).classList.remove("active");
        document.querySelector(`.tab-button[onclick="openTab('${tabName}')"]`).classList.add("active");
    }

    window.openTab = openTab;

    function showToast(message, type) {
        const toast = document.getElementById("toast");
        toast.textContent = message;
        toast.className = `toast show ${type}`;
        setTimeout(() => {
            toast.className = toast.className.replace("show", "");
        }, 3000);
    }

    // Fetch initial data
    fetchSchools();
});
