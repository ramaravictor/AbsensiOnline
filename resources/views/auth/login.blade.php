<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1" name="viewport" />
    <title>Absensi Online</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&display=swap" rel="stylesheet" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet" />
    <style>
        body {
            font-family: 'Inter', sans-serif;
        }
    </style>
</head>

<body class="bg-[#0057a3] min-h-screen flex items-center justify-center">
    <div id="welcome-page" class="flex flex-col items-center space-y-3">
        <div class="border-2 border-[#1a8cff] p-6 rounded-sm">
            <img alt="Official emblem of Dinas Lingkungan Hidup Kabupaten Bantul with green, yellow, blue and red colors"
                class="block" height="96"
                src="https://storage.googleapis.com/a1aa/image/1bd47741-61d4-4c53-6209-e3b8575de602.jpg"
                width="96" />
        </div>
        <p class="text-white text-sm font-semibold text-center leading-tight">
            Absensi Online
            <br />
            Dinas Lingkungan Hidup Kabupaten Bantul
        </p>
    </div>

    <div id="login-page" class="hidden bg-[#0f4a8a] min-h-screen flex items-center justify-center w-full h-full">
        <div class="flex flex-col items-center space-y-4 w-72">
            <img alt="Official emblem logo of Dinas Lingkungan Hidup Kabupaten Bantul with yellow and green colors"
                class="w-20 h-20" height="80"
                src="https://storage.googleapis.com/a1aa/image/637fe203-61cb-4f09-badb-d85526d743cd.jpg"
                width="80" />
            <h1 class="text-white text-center text-sm font-semibold">Absensi Online</h1>
            <p class="text-white text-center text-xs font-normal">Dinas Lingkungan Hidup Kabupaten Bantul</p>
            <form class="w-full flex flex-col space-y-3 mt-2" method="POST" action="{{ route('login') }}">
                @csrf
                <input class="rounded-md px-3 py-2 text-sm focus:outline-none" placeholder="NIP" type="text"
                    name="nip" value="{{ old('nip') }}" required autofocus autocomplete="username"
                    {{-- Browser akan mengenali ini sebagai field username utama --}} />
                {{-- Menampilkan error validasi untuk NIP --}}
                @error('nip')
                    <span class="text-red-500 text-xs mt-1">{{ $message }}</span>
                @enderror

                <input class="rounded-md px-3 py-2 text-sm focus:outline-none" placeholder="Password" type="password"
                    name="password" required autocomplete="current-password" />
                @error('password')
                    <span class="text-red-500 text-xs mt-1">{{ $message }}</span>
                @enderror


                <label class="flex items-center space-x-2 text-white text-xs font-normal">
                    <input class="w-3 h-3" type="checkbox" name="remember" /> <span>Ingat saya / Remember</span>
                </label>

                <button
                    class="bg-[#f28c00] rounded-full py-2 text-white text-sm font-semibold hover:bg-[#e07a00] transition"
                    type="submit">
                    LOGIN
                </button>
            </form>
            <p class="text-center text-xs mt-4">
                <span class="text-gray-300">Belum punya akun?</span>
                <a href="{{ route('register') }}" class="text-[#f28c00] hover:text-[#e07a00] font-semibold">Registrasi
                    di sini</a>
            </p>
        </div>
    </div>

    <script>
        // After 3 seconds, hide welcome page and show login page
        setTimeout(() => {
            document.getElementById('welcome-page').classList.add('hidden');
            document.getElementById('login-page').classList.remove('hidden');
            // Change body background color for login page
            document.body.classList.remove('bg-[#0057a3]');
            document.body.classList.add('bg-[#0f4a8a]');
            // Adjust body flex and sizing for login page
            document.body.classList.add('min-h-screen', 'flex', 'items-center', 'justify-center');
        }, 3000);
    </script>
</body>

</html>
