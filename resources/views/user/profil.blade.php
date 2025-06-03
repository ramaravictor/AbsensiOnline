<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1" name="viewport" />
    <title>
        Profile Page
    </title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&amp;display=swap" rel="stylesheet" />
    <style>
        body {
            font-family: 'Inter', sans-serif;
        }
    </style>
</head>

<body class="bg-white font-sans">
    <!-- Navbar -->
    <nav class="bg-blue-700 flex items-center justify-between px-6 py-3 shadow-md relative">
        <div>
            <a href="/user/profil" class="text-white text-[17px] font-normal leading-[20px] underline">
                {{ Auth::user()->name }}
            </a>
            <div class="text-white text-[11px] font-normal leading-[13px] mt-[2px]">
                {{ Auth::user()->nip }}
            </div>
        </div>
        <div class="flex items-center space-x-8 text-white text-[14px] font-semibold leading-[16px] relative">
            <a href="/user/home" class="hover:underline">Home</a>
            <a href="/user/profil" class="border-b-2 border-white pb-[2px]">Profile</a>
            <a href="/user/history" class="hover:underline">Riwayat</a>
            <button id="userBtn" aria-label="User menu" class="focus:outline-none">
                <i class="fas fa-user-circle text-[24px]"></i>
            </button>
            <!-- Dropdown panel -->
            <div id="userDropdown"
                class="hidden absolute right-0 top-full mt-1 w-48 bg-gray-200 rounded shadow-lg text-gray-800 z-50">
                <div class="px-4 py-3 border-b border-gray-300">
                    <p class="font-semibold text-sm">{{ Auth::user()->name }}</p>
                    <p class="text-xs truncate">{{ Auth::user()->email }}</p>
                </div>
                <form method="POST" action="{{ route('logout') }}" class="w-full">
                    @csrf
                    <button type="submit"
                        class="w-full flex items-center justify-center gap-2 text-red-600 text-sm font-semibold py-2 hover:bg-red-100">
                        <i class="fas fa-power-off"></i> LOGOUT
                    </button>
                </form>
            </div>
    </nav>
    <!-- Card -->
    <main class="flex justify-center mt-10 px-4">
        <section class="w-full max-w-3xl rounded-lg shadow-md border border-gray-200 overflow-hidden">
            <!-- Green header -->
            <div class="bg-[#0D8B2E] p-8 rounded-t-lg flex flex-col items-center">
                @php
                    $name = Auth::user()->name ?? 'User';
                    $avatarUrl =
                        'https://ui-avatars.com/api/?name=' .
                        urlencode($name) .
                        '&background=random&size=80&rounded=true';
                @endphp

                <img alt="Avatar of {{ $name }}" class="w-20 h-20 rounded-full mb-4 sm:mb-0" height="80"
                    width="80" src="{{ Auth::user()->avatar_url ?? $avatarUrl }}" />

                <p class="text-white text-center text-lg mt-5 font-normal leading-tight">
                    {{ Auth::user()->name }}
                </p>
                <p class="text-white text-[10px] font-normal leading-tight tracking-widest mt-3">
                    {{ Auth::user()->nip }}
                </p>
                <p
                    class="text-white text-[10px] font-normal leading-tight tracking-widest mt-2 text-center max-w-[300px]">
                    {{ Auth::user()->jabatan }}
                </p>
            </div>
            <!-- White content area -->
            <div class="bg-white p-8">
                <div class="bg-gray-100 rounded-lg p-6 text-[12px] text-gray-700 leading-tight relative">
                    <div class="absolute left-0 top-0 bottom-0 w-2.5 bg-[#0D4DA1] rounded-l-md">
                    </div>
                    <div class="flex justify-between">
                        <div class="pl-6">
                            <p class="font-semibold mb-1">
                                Data Pegawai
                            </p>
                            <p class="mb-1">
                                Instansi
                            </p>
                            <p class="mb-1">
                                Kantor
                            </p>
                            <p class="mb-1">
                                Eselon
                            </p>
                            <p class="mb-1">
                                Pangkat / Gol
                            </p>
                        </div>
                        <div class="text-right pr-6">
                            <p class="mb-1">
                                Pemerintah Provinsi Lombok Barat
                            </p>
                            <p class="mb-1">
                                Dinas Lingkungan Hidup
                            </p>
                            <p class="mb-1">
                            </p>
                            <p class="mb-1">
                                - - -
                            </p>
                            <p class="mb-1">
                                Pembina Tk. I / IV - a
                            </p>
                        </div>
                    </div>
                    <div class="absolute right-0 top-0 bottom-0 w-2.5 bg-[#0D4DA1] rounded-r-md">
                    </div>
                </div>
            </div>
        </section>
    </main>
    <!-- Bottom right red circular button -->
    <button aria-label="Red circular button with arrow icon" onclick="window.location.href='/'"
        class="fixed bottom-6 right-6 w-14 h-14 rounded-full border-2 border-red-600 flex items-center justify-center text-red-600 hover:bg-red-50"
        type="button">
        <i class="fas fa-arrow-circle-right text-2xl"></i>
    </button>

    <script>
        const userBtn = document.getElementById('userBtn');
        const userDropdown = document.getElementById('userDropdown');

        userBtn.addEventListener('click', (e) => {
            e.stopPropagation();
            userDropdown.classList.toggle('hidden');
        });

        document.addEventListener('click', () => {
            if (!userDropdown.classList.contains('hidden')) {
                userDropdown.classList.add('hidden');
            }
        });
    </script>
</body>

</html>
