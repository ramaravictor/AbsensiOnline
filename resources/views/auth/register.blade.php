<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1" name="viewport" />
    <title>Registrasi - Absensi Online</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&display=swap" rel="stylesheet" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet" />
    <style>
        body {
            font-family: 'Inter', sans-serif;
        }
    </style>
</head>

<body class="bg-[#0f4a8a] min-h-screen flex flex-col items-center justify-center py-8 px-4">
    <div class="flex flex-col items-center space-y-4 w-full max-w-sm">
        <img alt="Logo Dinas Lingkungan Hidup Kabupaten Bantul" class="w-20 h-20"
            src="https://storage.googleapis.com/a1aa/image/637fe203-61cb-4f09-badb-d85526d743cd.jpg"
            {{-- Ganti dengan URL logo yang sesuai jika berbeda untuk halaman ini --}} />
        <h1 class="text-white text-center text-xl font-semibold">Registrasi Akun Baru</h1>
        <p class="text-white text-center text-sm font-normal">Dinas Lingkungan Hidup Kabupaten Bantul</p>

        <form class="w-full flex flex-col space-y-3 mt-4" method="POST" action="{{ route('register') }}">
            @csrf

            <div>
                <input class="w-full rounded-md px-3 py-2 text-sm focus:outline-none" placeholder="Nama Lengkap"
                    type="text" name="name" value="{{ old('name') }}" required autofocus />
                @error('name')
                    <span class="text-red-400 text-xs mt-1">{{ $message }}</span>
                @enderror
            </div>

            <div>
                <input class="w-full rounded-md px-3 py-2 text-sm focus:outline-none"
                    placeholder="NIP (Nomor Induk Pegawai)" type="text" name="nip" value="{{ old('nip') }}"
                    required />
                @error('nip')
                    <span class="text-red-400 text-xs mt-1">{{ $message }}</span>
                @enderror
            </div>

            <div>
                <input class="w-full rounded-md px-3 py-2 text-sm focus:outline-none" placeholder="Alamat Email"
                    type="email" name="email" value="{{ old('email') }}" required />
                @error('email')
                    <span class="text-red-400 text-xs mt-1">{{ $message }}</span>
                @enderror
            </div>

            <div>
                <input class="w-full rounded-md px-3 py-2 text-sm focus:outline-none" placeholder="Password"
                    type="password" name="password" required />
                @error('password')
                    <span class="text-red-400 text-xs mt-1">{{ $message }}</span>
                @enderror
            </div>

            <div>
                <input class="w-full rounded-md px-3 py-2 text-sm focus:outline-none" placeholder="Konfirmasi Password"
                    type="password" name="password_confirmation" required />
            </div>

            <button
                class="bg-[#f28c00] rounded-full py-2 text-white text-sm font-semibold hover:bg-[#e07a00] transition mt-4"
                type="submit">
                REGISTER
            </button>
        </form>

        <p class="text-center text-xs mt-4">
            <span class="text-gray-300">Sudah punya akun?</span>
            <a href="{{ route('login') }}" class="text-[#f28c00] hover:text-[#e07a00] font-semibold">Login di sini</a>
        </p>
    </div>
</body>

</html>
