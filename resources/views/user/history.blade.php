<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Attendance History</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link
    rel="stylesheet"
    href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css"
  />
  <style>
    /* Custom scrollbar for the container if needed */
    /* No scroll visible in screenshot, so no scrollbar styling */
  </style>
</head>
<body class="bg-white font-sans">
  <!-- Navbar -->
  <nav class="bg-blue-700 flex items-center justify-between px-6 py-3 shadow-md relative">
    <div>
      <a href="/user/profil" class="text-white text-[17px] font-normal leading-[20px] underline">
        Prof. Munir, M.Kom
      </a>
      <div class="text-white text-[11px] font-normal leading-[13px] mt-[2px]">
        19740516 199705 1 001
      </div>
    </div>
    <div class="flex items-center space-x-8 text-white text-[14px] font-semibold leading-[16px] relative">
      <a href="/user/home" class="hover:underline">Home</a>
      <a href="/user/profil" class="hover:underline">Profile</a>
      <a href="/user/history" class="border-b-2 border-white pb-[2px]">Riwayat</a>
      <div class="relative">
        <button id="userBtn" aria-label="User menu" class="focus:outline-none">
          <i class="fas fa-user-circle text-[24px]"></i>
        </button>
        <!-- Dropdown panel -->
        <div id="userDropdown" class="hidden absolute right-0 top-full mt-1 w-48 bg-gray-200 rounded shadow-lg text-gray-800 z-50">
            <div class="px-4 py-3 border-b border-gray-300">
              <p class="font-semibold text-sm">Prof. Munir, M.Kom</p>
              <p class="text-xs truncate">@username.absen.co</p>
            </div>
            <button onclick="window.location.href='/'" class="w-full flex items-center justify-center gap-2 text-red-600 text-sm font-semibold py-2 hover:bg-red-100" type="button">
              <i class="fas fa-power-off"></i> LOGOUT
            </button>
          </div>
  </nav>

  <!-- Main container -->
  <main class="flex justify-center mt-10 px-4">
    <section
      class="w-full max-w-[800px] border border-gray-300 rounded-lg shadow-md p-4 relative"
      style="min-height: 600px;"
    >
      <!-- Dropdown -->
      <select
        aria-label="Select month"
        class="border border-gray-400 rounded text-[10px] font-semibold leading-[12px] px-2 py-1 mb-6"
      >
        <option>November</option>
      </select>

      <!-- Attendance items container -->
      <div class="space-y-6">
        <!-- Item 1 -->
        <article
          class="bg-[#E5E5E5] rounded-md p-4 relative flex justify-between border-l-4 border-[#0B57A4]"
          style="box-shadow: 0 1px 2px rgb(0 0 0 / 0.1);"
        >
          <div class="flex flex-col max-w-[70%]">
            <span class="text-[11px] font-semibold leading-[13px] text-[#4B4B4B] mb-1">
              01 November 2021
            </span>
            <span class="text-[12px] font-extrabold leading-[14px] text-[#B80000] mb-1">
              Terlambat Absen
            </span>
            <span class="text-[9px] font-bold leading-[11px] text-[#B80000]">
              Waktu Hadir : 07:18:34
            </span>
            <span class="text-[9px] font-bold leading-[11px] text-[#B80000]">
              Terlambat : 00:33:10
            </span>
          </div>
          <div class="flex flex-col text-[9px] font-semibold leading-[11px] text-[#4B4B4B] text-right max-w-[30%]">
            <span>Waktu Pulang : 17:53:20</span>
            <span>Cepat Pulang : 00:00:00</span>
          </div>
          <div
            class="absolute top-4 right-0 h-[60px] w-[4px] bg-[#0B57A4] rounded-r"
            style="box-shadow: 1px 0 0 #0B57A4 inset;"
          ></div>
        </article>

        <!-- Item 2 -->
        <article
          class="bg-[#E5E5E5] rounded-md p-4 relative flex justify-between border-l-4 border-[#0B57A4]"
          style="box-shadow: 0 1px 2px rgb(0 0 0 / 0.1);"
        >
          <div class="flex flex-col max-w-[70%]">
            <span class="text-[11px] font-semibold leading-[13px] text-[#4B4B4B] mb-1">
              02 November 2021
            </span>
            <span class="text-[12px] font-extrabold leading-[14px] text-[#008000] mb-1">
              Berhasil mengambil absen
            </span>
            <span class="text-[9px] font-bold leading-[11px] text-[#008000]">
              Waktu Hadir : 07:18:34
            </span>
            <span class="text-[9px] font-bold leading-[11px] text-[#008000]">
              Terlambat : 00:01:29
            </span>
          </div>
          <div class="flex flex-col text-[9px] font-semibold leading-[11px] text-[#4B4B4B] text-right max-w-[30%]">
            <span>Waktu Pulang : 17:53:20</span>
            <span>Cepat Pulang : 00:00:00</span>
          </div>
          <div
            class="absolute top-4 right-0 h-[60px] w-[4px] bg-[#0B57A4] rounded-r"
            style="box-shadow: 1px 0 0 #0B57A4 inset;"
          ></div>
        </article>

        <!-- Item 3 -->
        <article
          class="bg-[#E5E5E5] rounded-md p-4 relative flex justify-between border-l-4 border-[#0B57A4]"
          style="box-shadow: 0 1px 2px rgb(0 0 0 / 0.1);"
        >
          <div class="flex flex-col max-w-[70%]">
            <span class="text-[11px] font-semibold leading-[13px] text-[#4B4B4B] mb-1">
              03 November 2021
            </span>
            <span class="text-[12px] font-extrabold leading-[14px] text-[#008000] mb-1">
              Berhasil mengambil absen
            </span>
            <span class="text-[9px] font-bold leading-[11px] text-[#008000]">
              Waktu Hadir : 07:18:34
            </span>
            <span class="text-[9px] font-bold leading-[11px] text-[#008000]">
              Terlambat : 00:00:00
            </span>
          </div>
          <div class="flex flex-col text-[9px] font-semibold leading-[11px] text-[#4B4B4B] text-right max-w-[30%]">
            <span class="text-[#B80000]">Waktu Pulang : 17:53:20</span>
            <span class="text-[#B80000] font-bold text-[9px] leading-[11px]">
              Cepat Pulang : 00:12:34
            </span>
          </div>
          <div
            class="absolute top-4 right-0 h-[60px] w-[4px] bg-[#0B57A4] rounded-r"
            style="box-shadow: 1px 0 0 #0B57A4 inset;"
          ></div>
        </article>
      </div>
    </section>
  </main>

  <script>
    const userBtn = document.getElementById('userBtn');
    const userDropdown = document.getElementById('userDropdown');

    userBtn.addEventListener('click', () => {
      if (userDropdown.classList.contains('hidden')) {
        userDropdown.classList.remove('hidden');
      } else {
        userDropdown.classList.add('hidden');
      }
    });

    // Close dropdown if clicked outside
    document.addEventListener('click', (e) => {
      if (!userBtn.contains(e.target) && !userDropdown.contains(e.target)) {
        userDropdown.classList.add('hidden');
      }
    });
  </script>
</body>
</html>