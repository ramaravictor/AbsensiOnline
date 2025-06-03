<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1" name="viewport" />
    <title>Data Pengguna</title> {{-- Mengganti judul agar lebih umum --}}
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet" />
    <style>
        /* ... (style pagination Anda tetap sama) ... */
        .pagination nav {
            display: flex;
            justify-content: flex-end;
        }

        .pagination span[aria-current="page"] span,
        .pagination a {
            padding: 0.5rem 0.75rem;
            margin-left: 0.25rem;
            border-radius: 0.25rem;
        }

        .pagination span[aria-current="page"] span {
            background-color: #0a5eb7;
            color: white;
            border: 1px solid #0a5eb7;
        }

        .pagination a {
            background-color: white;
            color: #0a5eb7;
            border: 1px solid #ddd;
        }

        .pagination a:hover {
            background-color: #f0f0f0;
        }

        .pagination span[aria-disabled="true"] span {
            color: #ccc;
            border: 1px solid #ddd;
            background-color: white;
        }
    </style>
</head>

<body class="bg-gray-300 font-sans">
    <div class="flex min-h-screen">
        <aside class="bg-[#0a5eb7] w-36 flex flex-col items-center py-8 space-y-8 shadow-lg relative">
            {{-- ... (Isi Sidebar tetap sama, pastikan link menggunakan route() helper) ... --}}
            <img alt="Official emblem with star, mountain, river, and green leaves" class="mb-6" height="72"
                src="https://storage.googleapis.com/a1aa/image/de472ba4-1a91-4e3b-d205-ecee86752dbb.jpg"
                width="72" />
            <nav class="flex flex-col space-y-6 text-white text-sm font-semibold text-center">
                <a class="hover:underline" href="{{ route('admin.dashboard') }}">Dashboard</a>
                <a class="hover:underline" href="{{ route('admin.rekap') }}">Rekap Absensi</a>
                <a class="opacity-100 border-l-2 border-white pl-2" href="{{ route('admin.karyawan') }}">Data
                    Pengguna</a> {{-- Mengganti nama menu --}}
            </nav>
            <button onclick="window.location.href='{{ route('admin.profil') }}'"
                class="absolute bottom-6 bg-gray-300 rounded-lg px-4 py-2 text-center w-28"
                style="font-size: 12px; font-weight: 700;">
                <p class="font-bold">{{ Auth::user()->name }}</p>
                <p class="text-xs font-normal">Admin</p>
            </button>
        </aside>

        <main class="flex-1 p-6">
            <h1 class="text-black font-bold text-lg mb-6">Edit Pengguna: {{ $user->name }}</h1>

            <section class="bg-white rounded-md shadow-lg p-6 max-w-2xl mx-auto">
                <form method="POST" action="{{ route('admin.karyawan.update', $user->id) }}">
                    @csrf
                    @method('PUT') {{-- Method spoofing untuk request PUT --}}

                    <div class="mb-4">
                        <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Nama Lengkap</label>
                        <input type="text" name="name" id="name" value="{{ old('name', $user->name) }}"
                            required
                            class="w-full rounded-md border border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 px-3 py-2">
                        @error('name')
                            <span class="text-red-500 text-xs">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="nip" class="block text-sm font-medium text-gray-700 mb-1">NIP</label>
                        <input type="text" name="nip" id="nip" value="{{ old('nip', $user->nip) }}"
                            required
                            class="w-full rounded-md border border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 px-3 py-2">
                        @error('nip')
                            <span class="text-red-500 text-xs">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                        <input type="email" name="email" id="email" value="{{ old('email', $user->email) }}"
                            required
                            class="w-full rounded-md border border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 px-3 py-2">
                        @error('email')
                            <span class="text-red-500 text-xs">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="jabatan" class="block text-sm font-medium text-gray-700 mb-1">Jabatan</label>
                        <input type="text" name="jabatan" id="jabatan"
                            value="{{ old('jabatan', $user->jabatan) }}"
                            class="w-full rounded-md border border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 px-3 py-2">
                        @error('jabatan')
                            <span class="text-red-500 text-xs">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="role" class="block text-sm font-medium text-gray-700 mb-1">Role</label>
                        <select name="role" id="role" required
                            class="w-full rounded-md border border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 px-3 py-2">
                            @foreach ($roles as $roleValue)
                                <option value="{{ $roleValue }}"
                                    {{ old('role', $user->role) == $roleValue ? 'selected' : '' }}>
                                    {{ ucfirst($roleValue) }}
                                </option>
                            @endforeach
                        </select>
                        @error('role')
                            <span class="text-red-500 text-xs">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="jadwal_kerja_mulai" class="block text-sm font-medium text-gray-700 mb-1">Jadwal
                            Kerja Mulai (JJ:MM)</label>
                        <input type="time" name="jadwal_kerja_mulai" id="jadwal_kerja_mulai"
                            value="{{ old('jadwal_kerja_mulai', $user->jadwal_kerja_mulai ? \Carbon\Carbon::parse($user->jadwal_kerja_mulai)->format('H:i') : '') }}"
                            class="w-full rounded-md border border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 px-3 py-2">
                        @error('jadwal_kerja_mulai')
                            <span class="text-red-500 text-xs">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="jadwal_kerja_selesai" class="block text-sm font-medium text-gray-700 mb-1">Jadwal
                            Kerja Selesai (JJ:MM)</label>
                        <input type="time" name="jadwal_kerja_selesai" id="jadwal_kerja_selesai"
                            value="{{ old('jadwal_kerja_selesai', $user->jadwal_kerja_selesai ? \Carbon\Carbon::parse($user->jadwal_kerja_selesai)->format('H:i') : '') }}"
                            class="w-full rounded-md border border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 px-3 py-2">
                        @error('jadwal_kerja_selesai')
                            <span class="text-red-500 text-xs">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="password" class="block text-sm font-medium text-gray-700 mb-1">Password Baru
                            (Kosongkan jika tidak ingin diubah)</label>
                        <input type="password" name="password" id="password"
                            class="w-full rounded-md border border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 px-3 py-2">
                        @error('password')
                            <span class="text-red-500 text-xs">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="mb-6">
                        <label for="password_confirmation"
                            class="block text-sm font-medium text-gray-700 mb-1">Konfirmasi Password Baru</label>
                        <input type="password" name="password_confirmation" id="password_confirmation"
                            class="w-full rounded-md border border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 px-3 py-2">
                    </div>

                    <div class="flex items-center justify-end space-x-3">
                        <a href="{{ route('admin.karyawan') }}"
                            class="bg-gray-200 text-gray-700 px-4 py-2 rounded-md hover:bg-gray-300 text-sm font-medium">
                            Batal
                        </a>
                        <button type="submit"
                            class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700 text-sm font-medium">
                            Update Pengguna
                        </button>
                    </div>
                </form>
            </section>
        </main>
    </div>
</body>

</html>
