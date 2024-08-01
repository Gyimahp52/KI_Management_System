<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Educator's Dashboard</title>
  <link rel="stylesheet" href="/css/educator.css" />
  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Lexend:wght@400;500;700;900&family=Noto+Sans:wght@400;500;700;900&display=swap" />
  <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
</head>
<body class="bg-[#F8F9FB] font-sans">
  <div class="flex min-h-screen">
    <!-- Sidebar -->
    <div class="sidebar w-64 bg-white p-4">
      <div class="flex flex-col items-center">
        <div class="profile-pic w-24 h-24 bg-cover bg-center rounded-full mb-4"></div>
        <h1 class="text-xl font-bold text-[#141C24]">Prince Gyimah</h1>
        <p class="text-sm text-[#3F5374]">KI Coach</p>
      </div>
      <nav class="mt-8">
        <ul>
          <li class="mb-4">
            <a href="#" id="profile-btn" class="flex items-center px-4 py-2 text-sm font-medium text-[#141C24] hover:bg-[#E4E9F1] rounded-lg">Profile</a>
          </li>
          <li class="mb-4">
            <a href="#" id="classes-btn" class="flex items-center px-4 py-2 text-sm font-medium text-[#141C24] hover:bg-[#E4E9F1] rounded-lg">Classes</a>
          </li>
          <li class="mb-4">
            <a href="#" id="photos-btn" class="flex items-center px-4 py-2 text-sm font-medium text-[#141C24] hover:bg-[#E4E9F1] rounded-lg">Photos</a>
          </li>
        </ul>
      </nav>
      <button class="logout-btn w-full mt-8 py-2 bg-[#F4C753] text-[#141C24] text-sm font-bold rounded-lg" id="logout-btn">Logout</button>
    </div>

    <!-- Main content -->
    <div class="flex-1 p-6" id="main-content">
      <h1 class="text-4xl font-bold text-[#141C24] mb-6">Classes</h1>
      <div class="space-y-4" id="class-list">
        <div class="class-item flex items-center gap-4 bg-white p-4 rounded-lg shadow hover:bg-[#E4E9F1]" data-class="1A">
          <div class="p-3 bg-[#E4E9F1] rounded-lg">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 256 256">
              <path d="M240,208H224V96a16,16,0,0,0-16-16H144V32a16,16,0,0,0-24.88-13.32L39.12,72A16,16,0,0,0,32,85.34V208H16a8,8,0,0,0,0,16H240a8,8,0,0,0,0-16ZM208,96V208H144V96ZM48,85.34,128,32V208H48ZM112,112v16a8,8,0,0,1-16,0V112a8,8,0,1,1,16,0Zm-32,0v16a8,8,0,0,1-16,0V112a8,8,0,1,1,16,0Zm0,56v16a8,8,0,0,1-16,0V168a8,8,0,1,1,16,0Zm32,0v16a8,8,0,0,1-16,0V168a8,8,0,0,1,16,0Z"></path>
            </svg>
          </div>
          <div>
            <p class="text-lg font-medium text-[#141C24]">1A</p>
            <p class="text-sm text-[#3F5374]">1st Grade, 30 students</p>
          </div>
        </div>
        <div class="class-item flex items-center gap-4 bg-white p-4 rounded-lg shadow hover:bg-[#E4E9F1]" data-class="2A">
          <div class="p-3 bg-[#E4E9F1] rounded-lg">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 256 256">
              <path d="M240,208H224V96a16,16,0,0,0-16-16H144V32a16,16,0,0,0-24.88-13.32L39.12,72A16,16,0,0,0,32,85.34V208H16a8,8,0,0,0,0,16H240a8,8,0,0,0,0-16ZM208,96V208H144V96ZM48,85.34,128,32V208H48ZM112,112v16a8,8,0,0,1-16,0V112a8,8,0,1,1,16,0Zm-32,0v16a8,8,0,0,1-16,0V112a8,8,0,1,1,16,0Zm0,56v16a8,8,0,0,1-16,0V168a8,8,0,1,1,16,0Zm32,0v16a8,8,0,0,1-16,0V168a8,8,0,0,1,16,0Z"></path>
            </svg>
          </div>
          <div>
            <p class="text-lg font-medium text-[#141C24]">2A</p>
            <p class="text-sm text-[#3F5374]">2nd Grade, 25 students</p>
          </div>
        </div>
        <!-- Add more classes here as needed -->
      </div>

      <!-- Student Scores Table (hidden initially) -->
      <div id="class-details" class="hidden">
        <h1 class="text-4xl font-bold text-[#141C24] mb-6" id="class-title">Class 1A - 1st Grade</h1>
        <div class="success-message" id="success-message">Scores submitted successfully!</div>
        <div class="mb-4">
          <button class="mr-4 px-4 py-2 bg-[#E4E9F1] text-[#141C24] font-medium rounded-lg" id="back-button">Back</button>
          <button class="px-4 py-2 bg-[#F4C753] text-[#141C24] font-bold rounded-lg" id="submit-scores-button">Submit Scores</button>
        </div>
        <table class="w-full bg-white rounded-lg shadow overflow-hidden">
          <thead class="bg-[#E4E9F1]">
            <tr>
              <th class="p-4 text-left">#</th>
              <th class="p-4 text-left">Student Name</th>
              <th class="p-4 text-left">Math</th>
              <th class="p-4 text-left">Science</th>
              <th class="p-4 text-left">English</th>
              <th class="p-4 text-left">History</th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td class="p-4">1</td>
              <td class="p-4">Alex</td>
              <td class="p-4"><input type="number" class="score-input w-full bg-transparent border-none focus:outline-none" min="2" max="10" placeholder="Enter score" /></td>
              <td class="p-4"><input type="number" class="score-input w-full bg-transparent border-none focus:outline-none" min="2" max="10" placeholder="Enter score" /></td>
              <td class="p-4"><input type="number" class="score-input w-full bg-transparent border-none focus:outline-none" min="2" max="10" placeholder="Enter score" /></td>
              <td class="p-4"><input type="number" class="score-input w-full bg-transparent border-none focus:outline-none" min="2" max="10" placeholder="Enter score" /></td>
            </tr>
            <tr>
              <td class="p-4">2</td>
              <td class="p-4">Bella</td>
              <td class="p-4"><input type="number" class="score-input w-full bg-transparent border-none focus:outline-none" min="2" max="10" placeholder="Enter score" /></td>
              <td class="p-4"><input type="number" class="score-input w-full bg-transparent border-none focus:outline-none" min="2" max="10" placeholder="Enter score" /></td>
              <td class="p-4"><input type="number" class="score-input w-full bg-transparent border-none focus:outline-none" min="2" max="10" placeholder="Enter score" /></td>
              <td class="p-4"><input type="number" class="score-input w-full bg-transparent border-none focus:outline-none" min="2" max="10" placeholder="Enter score" /></td>
            </tr>
            <tr>
              <td class="p-4">3</td>
              <td class="p-4">Chris</td>
              <td class="p-4"><input type="number" class="score-input w-full bg-transparent border-none focus:outline-none" min="2" max="10" placeholder="Enter score" /></td>
              <td class="p-4"><input type="number" class="score-input w-full bg-transparent border-none focus:outline-none" min="2" max="10" placeholder="Enter score" /></td>
              <td class="p-4"><input type="number" class="score-input w-full bg-transparent border-none focus:outline-none" min="2" max="10" placeholder="Enter score" /></td>
              <td class="p-4"><input type="number" class="score-input w-full bg-transparent border-none focus:outline-none" min="2" max="10" placeholder="Enter score" /></td>
            </tr>
            <tr>
              <td class="p-4">4</td>
              <td class="p-4">Diana</td>
              <td class="p-4"><input type="number" class="score-input w-full bg-transparent border-none focus:outline-none" min="2" max="10" placeholder="Enter score" /></td>
              <td class="p-4"><input type="number" class="score-input w-full bg-transparent border-none focus:outline-none" min="2" max="10" placeholder="Enter score" /></td>
              <td class="p-4"><input type="number" class="score-input w-full bg-transparent border-none focus:outline-none" min="2" max="10" placeholder="Enter score" /></td>
              <td class="p-4"><input type="number" class="score-input w-full bg-transparent border-none focus:outline-none" min="2" max="10" placeholder="Enter score" /></td>
            </tr>
            <tr>
              <td class="p-4">5</td>
              <td class="p-4">Ethan</td>
              <td class="p-4"><input type="number" class="score-input w-full bg-transparent border-none focus:outline-none" min="2" max="10" placeholder="Enter score" /></td>
              <td class="p-4"><input type="number" class="score-input w-full bg-transparent border-none focus:outline-none" min="2" max="10" placeholder="Enter score" /></td>
              <td class="p-4"><input type="number" class="score-input w-full bg-transparent border-none focus:outline-none" min="2" max="10" placeholder="Enter score" /></td>
              <td class="p-4"><input type="number" class="score-input w-full bg-transparent border-none focus:outline-none" min="2" max="10" placeholder="Enter score" /></td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
  </div>

  <!-- Notification Modal -->
  <div id="notification-modal" class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 hidden">
    <div class="bg-white p-6 rounded-lg shadow-lg text-center">
      <h2 class="text-2xl font-bold mb-4">KI Education</h2>
      <p id="notification-message" class="mb-4">Please fill in all the scores.</p>
      <button id="close-notification" class="px-4 py-2 bg-[#F4C753] text-[#141C24] font-bold rounded-lg">Close</button>
    </div>
  </div>

  <!-- Logout Confirmation Modal -->
  <div id="logout-modal" class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 hidden">
    <div class="bg-white p-6 rounded-lg shadow-lg text-center">
      <h2 class="text-2xl font-bold mb-4">Logout Confirmation</h2>
      <p class="mb-4">Are you sure you want to logout?</p>
      <button id="confirm-logout" class="px-4 py-2 bg-[#F4C753] text-[#141C24] font-bold rounded-lg mr-4">Yes</button>
      <button id="cancel-logout" class="px-4 py-2 bg-gray-300 text-[#141C24] font-bold rounded-lg">No</button>
    </div>
  </div>

  <!-- Photo Upload Modal -->
  <div id="upload-modal" class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 hidden">
    <div class="bg-white p-6 rounded-lg shadow-lg text-center">
      <h2 class="text-2xl font-bold mb-4">Upload Photo</h2>
      <input type="file" id="upload-input" accept="image/*" class="mb-4" />
      <button id="upload-button" class="px-4 py-2 bg-[#F4C753] text-[#141C24] font-bold rounded-lg mr-4">Upload</button>
      <button id="cancel-upload" class="px-4 py-2 bg-gray-300 text-[#141C24] font-bold rounded-lg">Cancel</button>
    </div>
  </div>

  <!-- Image Preview Modal -->
  <div id="preview-modal" class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 hidden">
    <div class="bg-white p-6 rounded-lg shadow-lg text-center relative">
      <img id="preview-image" src="" alt="Preview" class="mb-4 max-w-xs max-h-96" />
      <button id="close-preview" class="absolute top-2 right-2 bg-[#F4C753] text-[#141C24] font-bold rounded-full w-8 h-8">×</button>
    </div>
  </div>

  <script src="/js/educator.js"></script>
</body>
</html>
