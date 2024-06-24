document.addEventListener('DOMContentLoaded', function() {
    const themes = [];
    const schools = ['School A', 'School B', 'School C']; // Replace with dynamic data
    const assignments = [];
    let isEditing = false;
    let currentEditIndex = -1;

    function renderThemes() {
        const themeContainer = document.getElementById('themes');
        themeContainer.innerHTML = '';
        themes.forEach(theme => {
            const checkbox = document.createElement('input');
            checkbox.type = 'checkbox';
            checkbox.id = theme;
            checkbox.value = theme;
            checkbox.addEventListener('change', handleCheckboxChange);
            const label = document.createElement('label');
            label.htmlFor = theme;
            label.appendChild(document.createTextNode(theme));
            themeContainer.appendChild(checkbox);
            themeContainer.appendChild(label);
            themeContainer.appendChild(document.createElement('br'));
        });
    }

    function renderSchools() {
        const schoolSelect = document.getElementById('schools');
        const selectedTerm = document.getElementById('terms').value;
        schoolSelect.innerHTML = '';
        schools.forEach(school => {
            const option = document.createElement('option');
            option.value = school;
            option.appendChild(document.createTextNode(school));
            if (assignments.some(assignment => assignment.school === school && assignment.term === selectedTerm)) {
                option.disabled = true;
            }
            schoolSelect.appendChild(option);
        });
    }

    function renderAssignments() {
        const tableBody = document.querySelector('#assignedTable tbody');
        tableBody.innerHTML = '';
        assignments.forEach((assignment, index) => {
            const row = document.createElement('tr');
            const schoolCell = document.createElement('td');
            const termCell = document.createElement('td');
            const themesCell = document.createElement('td');
            const actionsCell = document.createElement('td');
            const viewLink = document.createElement('a');
            const editLink = document.createElement('a');
            
            schoolCell.appendChild(document.createTextNode(assignment.school));
            termCell.appendChild(document.createTextNode(`Term ${assignment.term}`));
            viewLink.href = "#";
            viewLink.appendChild(document.createTextNode('View SEL Themes'));
            viewLink.addEventListener('click', function() {
                alert(`SEL Themes for ${assignment.school} (Term ${assignment.term}):\n${assignment.themes.join(', ')}`);
            });

            editLink.href = "#";
            editLink.appendChild(document.createTextNode('Edit'));
            editLink.style.marginLeft = '10px';
            editLink.addEventListener('click', function() {
                populateFormForEditing(index);
            });

            themesCell.appendChild(viewLink);
            actionsCell.appendChild(editLink);
            row.appendChild(schoolCell);
            row.appendChild(termCell);
            row.appendChild(themesCell);
            row.appendChild(actionsCell);
            tableBody.appendChild(row);
        });
    }

    function populateFormForEditing(index) {
        const assignment = assignments[index];
        document.getElementById('schools').value = assignment.school;
        document.getElementById('terms').value = assignment.term;
        const themeCheckboxes = document.querySelectorAll('#themes input');
        themeCheckboxes.forEach(cb => {
            cb.checked = assignment.themes.includes(cb.value);
        });

        isEditing = true;
        currentEditIndex = index;
        document.getElementById('assignButton').textContent = 'Update';
        document.getElementById('assignButton').disabled = false;
    }

    function handleAssignmentSubmit(event) {
        event.preventDefault();
        const selectedSchool = document.getElementById('schools').value;
        const selectedTerm = document.getElementById('terms').value;
        const selectedThemes = Array.from(document.querySelectorAll('#themes input:checked')).map(cb => cb.value);

        if (selectedSchool && selectedTerm && selectedThemes.length > 0) {
            if (isEditing) {
                assignments[currentEditIndex] = {
                    school: selectedSchool,
                    term: selectedTerm,
                    themes: selectedThemes
                };
                showToast('Updated SEL Themes assignment');
                isEditing = false;
                currentEditIndex = -1;
                document.getElementById('assignButton').textContent = 'Assign SEL Themes';
            } else {
                assignments.push({
                    school: selectedSchool,
                    term: selectedTerm,
                    themes: selectedThemes
                });
                showToast('Assigned SEL Themes to school');
            }
            renderAssignments();
            document.getElementById('assignForm').reset();
            document.getElementById('assignButton').disabled = true;
            document.getElementById('deleteThemes').disabled = true;
            renderSchools();
        }
    }

    function handleCheckboxChange() {
        const selectedThemes = Array.from(document.querySelectorAll('#themes input:checked')).map(cb => cb.value);
        document.getElementById('assignButton').disabled = selectedThemes.length === 0;
        document.getElementById('deleteThemes').disabled = selectedThemes.length === 0;
    }

    function showToast(message) {
        const toast = document.getElementById('toast');
        toast.textContent = message;
        toast.className = 'toast show';
        setTimeout(() => {
            toast.className = toast.className.replace('show', '');
        }, 3000);
    }

    document.getElementById('themeForm').addEventListener('submit', function(event) {
        event.preventDefault();
        const themeName = document.getElementById('themeName').value;
        if (themeName) {
            themes.push(themeName);
            renderThemes();
            document.getElementById('themeForm').reset();
            showToast('Created new SEL Theme');
        }
    });

    document.getElementById('assignForm').addEventListener('submit', handleAssignmentSubmit);

    document.getElementById('deleteThemes').addEventListener('click', function() {
        const selectedThemes = Array.from(document.querySelectorAll('#themes input:checked')).map(cb => cb.value);
        selectedThemes.forEach(theme => {
            const index = themes.indexOf(theme);
            if (index > -1) {
                themes.splice(index, 1);
            }
        });
        renderThemes();
        document.getElementById('assignButton').disabled = true;
        document.getElementById('deleteThemes').disabled = true;
        showToast('Deleted selected SEL Themes');
    });

    document.getElementById('terms').addEventListener('change', renderSchools);

    renderSchools();
    renderThemes();
});