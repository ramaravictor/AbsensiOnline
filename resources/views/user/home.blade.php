<html lang="en">
<head>
  <meta charset="utf-8" />
  <meta content="width=device-width, initial-scale=1" name="viewport" />
  <title>Profile Page with Welcome Popup</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link
    href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css"
    rel="stylesheet"
  />
  <script>
    // Show the welcome popup on page load
    window.addEventListener("DOMContentLoaded", () => {
      document.getElementById("welcomePopup").classList.remove("hidden");

      // Dropdown toggle for user icon next to History
      const userBtn = document.getElementById("userBtn");
      const userDropdown = document.getElementById("userDropdown");

      userBtn.addEventListener("click", (e) => {
        e.stopPropagation();
        userDropdown.classList.toggle("hidden");
      });

      // Close dropdown if clicked outside
      document.addEventListener("click", () => {
        if (!userDropdown.classList.contains("hidden")) {
          userDropdown.classList.add("hidden");
        }
      });

      // Add event listener for "Lanjut" button to close modal and redirect
      const continueBtn = document.getElementById("continueBtn");
      continueBtn.addEventListener("click", () => {
        closeAbsenModal();
      });

      // Add event listener for "Kembali" button to close modal without redirect
      const backBtn = document.getElementById("backBtn");
      backBtn.addEventListener("click", () => {
        closeAbsenModalWithoutRedirect();
      });

      // Start realtime clock update
      updateTime();
      setInterval(updateTime, 1000);
    });

    // Close the welcome popup
    function closeWelcomePopup() {
      document.getElementById("welcomePopup").classList.add("hidden");
    }

    function openAbsenModal() {
      document.getElementById("absenModal").classList.remove("hidden");
      resetModal();
    }
    function closeAbsenModal() {
      document.getElementById("absenModal").classList.add("hidden");
      // Redirect to absen page after closing modal on "Lanjut"
      window.location.href = "/user/absen";
    }
    // Close modal without redirect (for "Kembali" button)
    function closeAbsenModalWithoutRedirect() {
      document.getElementById("absenModal").classList.add("hidden");
    }
    function resetModal() {
      document.getElementById("absenType").value = "";
      document.getElementById("absenHadirOptions").classList.add("hidden");
      document.getElementById("absenPulangOptions").classList.add("hidden");
      clearSelection();
      document.getElementById("actionButtons").classList.add("hidden");
    }
    function clearSelection() {
      const buttons = document.querySelectorAll(
        "#absenHadirOptions button, #absenPulangOptions button"
      );
      buttons.forEach((btn) => {
        btn.classList.remove("bg-green-600", "text-white", "shadow-lg", "scale-105");
        btn.classList.add("bg-gray-200", "text-gray-700", "shadow-none", "scale-100");
        btn.setAttribute("aria-pressed", "false");
      });
    }
    function onAbsenTypeChange() {
      clearSelection();
      document.getElementById("actionButtons").classList.add("hidden");
      const val = document.getElementById("absenType").value;
      if (val === "hadir") {
        document.getElementById("absenHadirOptions").classList.remove("hidden");
        document.getElementById("absenPulangOptions").classList.add("hidden");
      } else if (val === "pulang") {
        document.getElementById("absenPulangOptions").classList.remove("hidden");
        document.getElementById("absenHadirOptions").classList.add("hidden");
      } else {
        document.getElementById("absenHadirOptions").classList.add("hidden");
        document.getElementById("absenPulangOptions").classList.add("hidden");
      }
    }
    function selectOption(button) {
      const parent = button.parentElement;
      const buttons = parent.querySelectorAll("button");
      buttons.forEach((btn) => {
        btn.classList.remove("bg-green-600", "text-white", "shadow-lg", "scale-105");
        btn.classList.add("bg-gray-200", "text-gray-700", "shadow-none", "scale-100");
        btn.setAttribute("aria-pressed", "false");
      });
      button.classList.add("bg-green-600", "text-white", "shadow-lg", "scale-105");
      button.classList.remove("bg-gray-200", "text-gray-700", "shadow-none", "scale-100");
      button.setAttribute("aria-pressed", "true");
      document.getElementById("actionButtons").classList.remove("hidden");
    }

    // Update the current time every second
    function updateTime() {
      const now = new Date();
      const hours = now.getHours().toString().padStart(2, "0");
      const minutes = now.getMinutes().toString().padStart(2, "0");
      const seconds = now.getSeconds().toString().padStart(2, "0");
      const timeString = `${hours}:${minutes}:${seconds}`;
      const timeElement = document.getElementById("currentTime");
      if (timeElement) {
        timeElement.textContent = timeString;
      }
    }
  </script>
</head>
<body class="bg-gray-100">
  <div class="min-h-screen flex flex-col">
    <!-- Header -->
    <nav class="bg-blue-700 flex items-center justify-between px-6 py-3 shadow-md relative">
      <div>
        <a href="/user/profil" class="text-white text-[17px] font-normal leading-[20px] underline">
          Prof. Munir, M.Kom
        </a>
        <div class="text-white text-[11px] font-normal leading-[13px] mt-[2px]">
          19740516 189705 1 001
        </div>
      </div>
      <div class="flex items-center space-x-8 text-white text-[14px] font-semibold leading-[16px] relative">
        <a href="/user/home" class="border-b-2 border-white pb-[2px]">Home</a>
        <a href="/user/profil" class="hover:underline">Profile</a>
        <a href="/user/history" class="hover:underline">Riwayat</a>
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
      </div>
    </nav>
    <!-- Main content -->
    <main class="flex-grow flex justify-center items-center p-6">
      <div
        class="bg-white rounded-lg shadow-lg w-full max-w-5xl p-10"
        style="min-height: 600px"
      >
        <div class="flex items-center space-x-6 mb-8">
          <img
            alt="Avatar of a man with short hair wearing a green shirt and red tie"
            class="w-20 h-20 rounded-full"
            height="80"
            src="https://storage.googleapis.com/a1aa/image/f8904036-5036-4fb2-a531-218609c6e27b.jpg"
            width="80"
          />
          <div>
            <div class="text-lg font-semibold text-gray-700">Aditya Arya Pratama</div>
            <div class="text-sm text-gray-400">Login 8:00</div>
          </div>
        </div>
        <div class="grid grid-cols-4 gap-8 text-center mb-8">
          <div class="bg-white rounded-lg shadow-lg p-6 transform transition-transform duration-200">
            <div class="text-green-600 font-bold text-3xl">0</div>
            <div class="text-sm text-gray-500 mt-1">Hadir</div>
          </div>
          <div class="bg-white rounded-lg shadow-lg p-6 transform transition-transform duration-200">
            <div class="text-blue-600 font-bold text-3xl">0</div>
            <div class="text-sm text-gray-500 mt-1">Sakit</div>
          </div>
          <div class="bg-white rounded-lg shadow-lg p-6 transform transition-transform duration-200">
            <div class="text-yellow-500 font-bold text-3xl">0</div>
            <div class="text-sm text-gray-500 mt-1">Izin</div>
          </div>
          <div class="bg-white rounded-lg shadow-lg p-6 transform transition-transform duration-200">
            <div class="text-red-600 font-bold text-3xl">0</div>
            <div class="text-sm text-gray-500 mt-1">Absen</div>
          </div>
        </div>
        <div class="mb-8 rounded overflow-hidden border border-gray-300">
          <img
            alt="Map showing location with a red pin labeled 'MAN 2 SUBANG' and a black arrow pointing left"
            class="w-full"
            style="height: 350px; object-fit: cover;"
            src="https://storage.googleapis.com/a1aa/image/8ac405a7-445c-4c3d-557f-c0d72f1c7294.jpg"
          />
        </div>
        <div
          class="text-center font-mono font-semibold text-2xl mb-8"
          id="currentTime"
          aria-live="polite"
          aria-atomic="true"
        >
          00:00:00
        </div>
        <div class="flex justify-between max-w-md mx-auto">
          <button
            class="bg-orange-600 text-white text-lg font-semibold px-8 py-3 rounded hover:bg-orange-700 transition"
            onclick="openAbsenModal()"
            type="button"
          >
            ABSEN
          </button>
          <button
            class="bg-orange-600 text-white text-lg font-semibold px-8 py-3 rounded hover:bg-orange-700 transition"
            type="button"
            onclick="window.location.href='/user/history'"
          >
            RIWAYAT
          </button>
        </div>
      </div>
    </main>
  </div>

  <!-- Welcome Popup -->
  <div
    id="welcomePopup"
    class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 hidden"
    role="dialog"
    aria-modal="true"
    aria-labelledby="welcomeTitle"
  >
    <div class="bg-white rounded-lg shadow-lg w-full max-w-md p-6 relative">
      <!-- Close button top right -->
      <button
        type="button"
        aria-label="Close welcome popup"
        class="absolute top-3 right-3 text-gray-500 hover:text-gray-700 focus:outline-none"
        onclick="closeWelcomePopup()"
      >
        <i class="fas fa-times fa-lg"></i>
      </button>
      <h2 class="text-lg font-semibold mb-4 text-center" id="welcomeTitle">Selamat Datang!</h2>
      <div class="flex items-center space-x-4 mb-4">
        <img
          alt="Profile image of a man in brown uniform with a black mask"
          class="w-20 h-20 rounded-full flex-shrink-0"
          height="80"
          src="https://storage.googleapis.com/a1aa/image/2661bb6a-dfa3-4353-22c0-d0fe6a7f99fa.jpg"
          width="80"
        />
        <div class="text-xs leading-tight">
          <p class="font-bold text-[13px]">Dimas,S.Kom</p>
          <p class="text-[10px]">19740516 199705 1 001</p>
          <p class="text-[10px]">Kepala Bidang Dinas Lingkungan Hidup Kab. Bantul</p>
        </div>
      </div>
      <hr class="border-gray-400" />
      <p class="text-[10px] font-bold text-center mt-4">
        Dinas Lingkungan Hidup Kabupaten<br />Bantul
      </p>
    </div>
  </div>

  <!-- Absen Modal -->
  <div
    class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 hidden"
    id="absenModal"
    role="dialog"
    aria-modal="true"
    aria-labelledby="absenModalTitle"
  >
    <div class="bg-white rounded-lg shadow-lg w-full max-w-sm p-6 relative">
      <!-- Close button top right -->
      <button
        type="button"
        aria-label="Close absen modal"
        class="absolute top-3 right-3 text-gray-500 hover:text-gray-700 focus:outline-none"
        onclick="closeAbsenModalWithoutRedirect()"
      >
        <i class="fas fa-times fa-lg"></i>
      </button>
      <h2 class="text-lg font-semibold mb-4" id="absenModalTitle">Pilih Jenis Absen</h2>
      <select
        aria-label="Pilih absen hadir atau pulang"
        class="w-full border border-gray-300 rounded px-3 py-2 mb-4 focus:outline-none focus:ring-2 focus:ring-blue-500"
        id="absenType"
        onchange="onAbsenTypeChange()"
      >
        <option value="" selected disabled>-- Pilih Absen --</option>
        <option value="hadir">Absen Hadir</option>
        <option value="pulang">Absen Pulang</option>
      </select>
      <div class="space-y-4 hidden" id="absenHadirOptions" aria-label="Pilihan absen hadir">
        <button
          aria-pressed="false"
          class="w-full bg-white text-green-600 rounded-lg px-3 py-3 font-semibold text-center shadow-lg hover:scale-105 transform transition-transform"
          onclick="selectOption(this)"
          type="button"
        >
          Hadir
        </button>
        <button
          aria-pressed="false"
          class="w-full bg-white text-blue-600 rounded-lg px-3 py-3 font-semibold text-center shadow-lg hover:scale-105 transform transition-transform"
          onclick="selectOption(this)"
          type="button"
        >
          Sakit
        </button>
        <button
          aria-pressed="false"
          class="w-full bg-white text-yellow-500 rounded-lg px-3 py-3 font-semibold text-center shadow-lg hover:scale-105 transform transition-transform"
          onclick="selectOption(this)"
          type="button"
        >
          Izin
        </button>
      </div>
      <div class="space-y-4 hidden" id="absenPulangOptions" aria-label="Pilihan absen pulang">
        <button
          aria-pressed="false"
          class="w-full bg-white text-green-600 rounded-lg px-3 py-3 font-semibold text-center shadow-lg hover:scale-105 transform transition-transform"
          onclick="selectOption(this)"
          type="button"
        >
          Hadir
        </button>
      </div>
      <div class="flex justify-between mt-6 hidden" id="actionButtons">
        <button
          class="bg-gray-300 text-gray-700 font-semibold px-4 py-2 rounded hover:bg-gray-400 transition"
          onclick="resetModal()"
          type="button"
        >
          Kembali
        </button>
        <button
          id="continueBtn"
          class="bg-blue-600 text-white font-semibold px-4 py-2 rounded hover:bg-blue-700 transition"
          type="button"
        >
          Lanjut
        </button>
      </div>
    </div>
  </div>

  <script>
    // Close modal without redirect (for close button and "Kembali" button)
    function closeAbsenModalWithoutRedirect() {
      document.getElementById("absenModal").classList.add("hidden");
    }
  </script>
</body>
</html>