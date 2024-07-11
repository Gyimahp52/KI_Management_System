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

    const academicYearSelect = document.getElementById('academicYear');
    const schoolSelect = document.getElementById('school');
    const classSelect = document.getElementById('class');
    const termSelect = document.getElementById('term');
    const reportAcademicYearSelect = document.getElementById('reportAcademicYear');
    const reportSchoolSelect = document.getElementById('reportSchool');
    const reportClassSelect = document.getElementById('reportClass');
    const reportTermSelect = document.getElementById('reportTerm');
    const studentsList = document.getElementById('students-list');
    const saveScoresButton = document.getElementById('save-scores');
    const loadReportsButton = document.getElementById('loadReports');
    const selectAllCheckbox = document.getElementById('selectAll');
    const downloadSelectedReportsButton = document.getElementById('downloadSelectedReports');

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
    function populateSchoolDropdown(selectElement) {
        selectElement.innerHTML = '<option value="">--Select School--</option>';
        schools.forEach(school => {
            const option = document.createElement('option');
            option.value = school.id;
            option.textContent = school.name;
            selectElement.appendChild(option);
        });
    }
    populateSchoolDropdown(schoolSelect);
    populateSchoolDropdown(reportSchoolSelect);

    // Populate class dropdown based on selected school
    function populateClassDropdown(schoolSelectElement, classSelectElement) {
        classSelectElement.innerHTML = '<option value="">--Select Class--</option>';
        const selectedSchoolId = parseInt(schoolSelectElement.value);
        const filteredClasses = classes.filter(cls => cls.schoolId === selectedSchoolId);
        filteredClasses.forEach(cls => {
            const option = document.createElement('option');
            option.value = cls.id;
            option.textContent = cls.name;
            classSelectElement.appendChild(option);
        });
    }

    schoolSelect.addEventListener('change', () => {
        populateClassDropdown(schoolSelect, classSelect);
    });

    reportSchoolSelect.addEventListener('change', () => {
        populateClassDropdown(reportSchoolSelect, reportClassSelect);
    });

    // Populate students list based on selected academic year, class, and term
    academicYearSelect.addEventListener('change', updateStudentList);
    classSelect.addEventListener('change', updateStudentList);
    termSelect.addEventListener('change', updateStudentList);

    function updateStudentList() {
        studentsList.innerHTML = '';
        const selectedClassId = parseInt(classSelect.value);
        const selectedSchoolId = parseInt(schoolSelect.value);
        const selectedTerm = termSelect.value;
        const selectedAcademicYear = academicYearSelect.value;
        if (selectedClassId && selectedSchoolId && selectedTerm && selectedAcademicYear) {
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

    // Load reports based on selected academic year, school, class, and term
    loadReportsButton.addEventListener('click', () => {
        const selectedAcademicYear = reportAcademicYearSelect.value;
        const selectedSchoolId = parseInt(reportSchoolSelect.value);
        const selectedClassId = parseInt(reportClassSelect.value);
        const selectedTerm = reportTermSelect.value;

        if (selectedAcademicYear && selectedSchoolId && selectedClassId && selectedTerm) {
            const filteredStudents = students.filter(stu => stu.classId === selectedClassId);
            const selectedSchool = schools.find(school => school.id === selectedSchoolId);

            if (filteredStudents.length > 0 && selectedSchool) {
                const studentList = document.getElementById("studentList");
                studentList.innerHTML = ""; // Clear existing data

                filteredStudents.forEach(student => {
                    const row = document.createElement("tr");

                    const checkboxCell = document.createElement("td");
                    const checkbox = document.createElement("input");
                    checkbox.type = "checkbox";
                    checkbox.classList.add("student-checkbox");
                    checkbox.value = student.name;
                    checkboxCell.appendChild(checkbox);
                    row.appendChild(checkboxCell);

                    const nameCell = document.createElement("td");
                    nameCell.textContent = student.name;
                    row.appendChild(nameCell);

                    const classCell = document.createElement("td");
                    classCell.textContent = selectedSchool.name;
                    row.appendChild(classCell);

                    const termCell = document.createElement("td");
                    termCell.textContent = selectedTerm;
                    row.appendChild(termCell);

                    const reportCell = document.createElement("td");
                    const viewButton = document.createElement("button");
                    viewButton.classList.add("action-button", "view-button");
                    viewButton.textContent = "View";
                    viewButton.addEventListener("click", () => viewReport(student.name));
                    reportCell.appendChild(viewButton);
                    row.appendChild(reportCell);

                    const actionsCell = document.createElement("td");
                    actionsCell.innerHTML = `
                        <button class="action-button delete-button" onclick="deleteReport('${student.name}')">Delete</button>
                        <button class="action-button download-button" onclick="downloadReport('${student.name}')">Download</button>
                        <button class="action-button whatsapp-button" onclick="sendWhatsApp('${student.name}')"><i class="fa fa-whatsapp whatsapp-icon"></i> WhatsApp</button>
                    `;
                    row.appendChild(actionsCell);

                    studentList.appendChild(row);
                });
            }
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
            alert(`Downloading reports for: ${selectedStudents.join(', ')}`);
            // Implement download functionality
        } else {
            alert('No students selected.');
        }
    });

    function viewReport(name) {
        // Fetch student data based on name (mock data here)
        const student = students.find(stu => stu.name === name);
        const studentClass = classes.find(cls => cls.id === student.classId);
        const studentSchool = schools.find(sch => sch.id === studentClass.schoolId);

        // Populate the report
        document.getElementById('student-name').textContent = student.name;
        document.getElementById('student-name-info').textContent = student.name;
        document.getElementById('student-school').textContent = studentSchool.name;
        document.getElementById('student-school-info').textContent = studentSchool.name;
        document.getElementById('student-class-info').textContent = studentClass.name;

        // Show the report container
        document.getElementById('report-view').style.display = 'block';

        // Re-initialize the charts
        new Chart(document.getElementById('keqBarChart').getContext('2d'), {
            type: 'bar',
            data: {
                labels: ['Decision Making', 'Teamwork', 'Determination', 'Problem-solving', 'No Failure', 'Curiosity', 'Optimism', 'Self-confidence', 'Honesty', 'Experience', 'Kindness'],
                datasets: [
                    {
                        label: 'Base',
                        backgroundColor: '#50C878',
                        data: [50, 50, 50, 50, 50, 50, 50, 50, 50, 50, 50]
                    },
                    {
                        label: 'Improvement',
                        backgroundColor: '#0EB7F7',
                        data: [8, 9, 9, 4, 8, 5, 7, 9, 9, 5, 7]
                    },
                    {
                        label: 'Target',
                        backgroundColor: '#F7A60E',
                        data: [42, 41, 41, 46, 42, 45, 43, 41, 41, 45, 43]
                    }
                ]
            },
            options: {
                responsive: true,
                plugins: {
                    title: {
                        display: true,
                        text: 'Kinesthetic Emotional Intelligence Quotient (KEQ)',
                        color: 'white',
                        font: {
                            size: 18,
                            weight: 'bold'
                        },
                        padding: {
                            top: 10,
                            bottom: 30
                        }
                    },
                    legend: {
                        display: true,
                        position: 'bottom',
                        labels: {
                            color: 'white',
                            font: {
                                weight: 'bold'
                            }
                        }
                    },
                    tooltip: {
                        mode: 'index',
                        intersect: false,
                        callbacks: {
                            label: function(context) {
                                let label = context.dataset.label || '';
                                if (label) {
                                    label += ': ';
                                }
                                if (context.parsed.y !== null) {
                                    label += context.parsed.y;
                                }
                                return label;
                            }
                        }
                    }
                },
                scales: {
                    x: {
                        stacked: true,
                        ticks: {
                            color: 'white',
                            font: {
                                weight: 'bold'
                            }
                        }
                    },
                    y: {
                        stacked: true,
                        beginAtZero: true,
                        ticks: {
                            color: 'white',
                            font: {
                                weight: 'bold'
                            },
                            callback: function(value, index, ticks) {
                                return value + '%';
                            }
                        },
                        max: 100
                    }
                }
            }
        });

        new Chart(document.getElementById('selPieChart').getContext('2d'), {
            type: 'pie',
            data: {
                labels: ['Self Awareness', 'Self Management', 'Social Awareness', 'Relationship Skills', 'Responsible Decision Making'],
                datasets: [{
                    data: [18, 18, 10, 18, 18],
                    backgroundColor: [
                        '#FF6384',
                        '#36A2EB',
                        '#FFCE56',
                        '#4BC0C0',
                        '#9966FF'
                    ]
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    title: {
                        display: true,
                        text: 'Competencies Chart',
                        color: 'white',
                        font: {
                            size: 30,
                            weight: 'bold'
                        },
                        padding: {
                            top: 10,
                            bottom: 30
                        }
                    },
                    legend: {
                        display: true,
                        position: 'bottom',
                        labels: {
                            color: 'white',
                            font: {
                                weight: 'bold'
                            }
                        }
                    },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                const label = context.label || '';
                                const value = context.raw;
                                const total = context.chart._metasets[context.datasetIndex].total;
                                const percentage = ((value / total) * 100).toFixed(2);
                                return `${label}: ${value} (${percentage}%)`;
                            }
                        }
                    }
                }
            }
        });

        new Chart(document.getElementById('csBarChart').getContext('2d'), {
            type: 'bar',
            data: {
                labels: ['First Month', 'Second Month', 'Third Month'],
                datasets: [
                    {
                        label: 'Heart (SH)',
                        backgroundColor: '#FF6384',
                        data: [9, 9, 7]
                    },
                    {
                        label: 'Mind (SM)',
                        backgroundColor: '#36A2EB',
                        data: [8, 4, 9]
                    },
                    {
                        label: 'Will (SW)',
                        backgroundColor: '#FFCE56',
                        data: [9, 8, 5]
                    }
                ]
            },
            options: {
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    }

    window.viewReport = viewReport;

    function deleteReport(name) {
        if (confirm(`Are you sure you want to delete the report for ${name}?`)) {
            alert(`Report for ${name} deleted.`);
            // Implement delete functionality
        }
    }

    window.deleteReport = deleteReport;

    function downloadReport(name) {
        alert(`Downloading report for ${name}`);
        // Implement download functionality
    }

    window.downloadReport = downloadReport;

    function sendWhatsApp(name) {
        alert(`Sending report via WhatsApp for ${name}`);
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
});
