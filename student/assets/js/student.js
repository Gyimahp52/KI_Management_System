function viewPastReports() {
  document.getElementById("reports-card").style.display = "none";
  document.getElementById("filter-card").style.display = "block";
}

function goBackToReports() {
  document.getElementById("filter-card").style.display = "none";
  document.getElementById("reports-card").style.display = "block";
  document.getElementById("report-container").style.display = "none";
}

function goBackToFilter() {
  document.getElementById("report-container").style.display = "none";
  document.getElementById("filter-card").style.display = "block";
  document.getElementById("report-iframe").src = ""; // Unload report
}

function goBackToFilterV1() {
  document.getElementById("report-container").style.display = "none";
  document.getElementById("filter-card").style.display = "none";
  document.getElementById("reports-card").style.display = "block";
  document.getElementById("report-iframe").src = ""; // Unload report
}

// Fetch and populate academic years when the filter card is shown
document.addEventListener("DOMContentLoaded", function () {
  fetchAcademicYears();
});

function fetchAcademicYears() {
  fetch("fetch_academic_years.php")
    .then((response) => response.json())
    .then((data) => {
      if (data.error) {
        return;
      }
      populateAcademicYears(data);
    })
    .catch((error) => console.error("Error:", error));
}

function populateAcademicYears(academicYears) {
  const academicYearSelect = document.getElementById("academic_year");

  academicYears.forEach((year) => {
    const option = document.createElement("option");
    option.value = year.id;
    option.textContent = year.year_name;
    academicYearSelect.appendChild(option);
  });
}

function fetchTerms() {
  const academicYearId = document.getElementById("academic_year").value;

  if (!academicYearId) return;

  fetch(`fetch_terms.php?academic_year_id=${academicYearId}`)
    .then((response) => response.json())
    .then((data) => {
      if (data.error) {
        return;
      }
      populateTerms(data);
    })
    .catch((error) => console.error("Error:", error));
}

function populateTerms(terms) {
  const termSelect = document.getElementById("term");
  termSelect.innerHTML = '<option value="">Select Term</option>'; // Reset options

  terms.forEach((term) => {
    const option = document.createElement("option");
    option.value = term.id;
    option.textContent = term.term_number; // Adjust based on your actual field names
    termSelect.appendChild(option);
  });
}

//fetch student profile data
$("#profile-btn").click(function () {
  //   console.log("Student profile clicked");

  $.ajax({
    url: "get_profile.php",
    method: "GET",
    dataType: "json",
    success: function (data) {
      //   console.log("Data received successfully:", data);

      // Populate the form with student data
      $("#name").val(data.name);
      $("#dob").val(data.dob);
      $("#gender").val(data.gender);
      $("#hand").val(data.hand);
      $("#foot").val(data.foot);
      $("#eye-sight").val(data.eye_sight);
      $("#medical-condition").val(data.medical_condition);
      $("#height").val(data.height);
      $("#weight").val(data.weight);
      $("#parent-name").val(data.parent_name);
      $("#parent-phone").val(data.parent_phone);
      $("#parent-whatsapp").val(data.parent_whatsapp);
      $("#parent-email").val(data.parent_email);

      // Display current passport picture
      if (data.passport_picture) {
        $("#current-profile-pic").attr("src", data.passport_picture).show();
      } else {
        $("#current-profile-pic").hide();
      }

      // ENHANCED MODAL DISPLAY LOGIC
      // Remove hidden class, add show class, and add animation class
      $("#profile-form-modal").removeClass("hidden").addClass("show");
      setTimeout(function () {
        $(".st-modal-content").addClass("slide-in-left");
      }, 50); // Small delay to ensure the modal is visible first

      //   // Debug information
      //   console.log("Modal should be visible now.");
      //   console.log("Modal classes:", $("#profile-form-modal").attr("class"));
      //   console.log(
      //     "Modal content classes:",
      //     $(".st-modal-content").attr("class")
      //   );

      // Make modal display explicitly visible with inline styles as a fallback
      $("#profile-form-modal").css({
        display: "flex",
        opacity: "1",
        visibility: "visible",
      });
    },
    error: function (xhr, status, error) {
      //   console.error("AJAX Error:", status, error);
    },
  });
});

// Make sure you have a cancel button handler
$(document).on("click", "#cancel-profile", function () {
  closeProfileModal();
});

// Also close the modal if clicking outside the content area
$(document).on("click", "#profile-form-modal", function (e) {
  if (e.target === this) {
    closeProfileModal();
  }
});

// Function to close the modal with animation
function closeProfileModal() {
  $(".st-modal-content").removeClass("slide-in-left");
  setTimeout(function () {
    $("#profile-form-modal").removeClass("show").addClass("hidden");
  }, 300);
}

// Handle form submission via AJAX
$("#profile-form").submit(function (e) {
  e.preventDefault();

  var formData = new FormData(this);

  $.ajax({
    url: "update_profile.php",
    method: "POST",
    data: formData,
    contentType: false,
    processData: false,
    dataType: "json",
    success: function (response) {
      if (response.status === "success") {
        toastr.success(response.message);
        $("#profile-form-modal").removeClass("show");
      } else {
        toastr.error(response.message);
      }
    },
    error: function () {
      toastr.error("There was an error updating the profile.");
    },
  });
});

$(document).ready(function () {
  // Logout button click handler
  // Show confirmation modal when logout button is clicked
  $("#logout-btn").click(function (e) {
    e.preventDefault();
    // Show the Bootstrap modal
    $("#logout-modal").modal("show");
  });

  // Confirm logout action
  $("#confirm-logout").click(function () {
    // Redirect to logout page (or perform AJAX logout)
    window.location.href = "logout.php";
  });
});

// const sidebar = document.getElementById("sidebar");
// const toggleBtn = document.getElementById("toggle-btn");
// const content = document.querySelector(".content");

// toggleBtn.addEventListener("click", () => {
//   if (window.innerWidth <= 768) {
//     sidebar.classList.toggle("show");
//   } else {
//     sidebar.classList.toggle("collapsed");

//     // Delay the margin adjustment slightly
//     setTimeout(() => {
//       content.style.marginLeft = sidebar.classList.contains("collapsed")
//         ? "calc(6.4rem + 20px)"
//         : "270px";
//     }, 10); // Half of the transition time (300ms / 2)
//   }
// });
// window.addEventListener("resize", () => {
//   if (window.innerWidth > 768) {
//     sidebar.classList.remove("show");
//     content.style.marginLeft = sidebar.classList.contains("collapsed")
//       ? "calc(6.4rem + 20px)"
//       : "270px";
//   } else {
//     content.style.marginLeft = "0";
//   }
// });
