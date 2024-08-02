<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Galileo Design</title>
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
              <a href="#" class="flex items-center px-4 py-2 text-sm font-medium text-[#141C24] hover:bg-[#E4E9F1] rounded-lg">Profile</a>
            </li>
            <li class="mb-4">
              <a href="#" class="flex items-center px-4 py-2 text-sm font-medium text-[#141C24] bg-[#E4E9F1] rounded-lg">Classes</a>
            </li>
          </ul>
        </nav>
        <button class="logout-btn w-full mt-8 py-2 bg-[#F4C753] text-[#141C24] text-sm font-bold rounded-lg">Logout</button>
      </div>

      <!-- Main content -->
      <div class="flex-1 p-6" id="main-content">
        <h1 class="text-4xl font-bold text-[#141C24] mb-6">Classes</h1>
        <div class="space-y-4" id="class-list">
          <!-- Class items will be appended here by JavaScript -->
        </div>
      </div>
    </div>
    <script src="/js/educator.js"></script>
  </body>
</html>
