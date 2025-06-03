<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1" name="viewport" />
    <title>Edit Pengguna - {{ $user->name }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet" />
    <style>
        body {
            font-family: 'Inter', sans-serif;
        }

        aside::-webkit-scrollbar {
            width: 6px;
        }

        aside::-webkit-scrollbar-thumb {
            background-color: rgba(255, 255, 255, 0.3);
            border-radius: 3px;
        }
    </style>
</head>

<body class="bg-gray-200 font-sans">
    <div class="flex min-h-screen">
        <!-- Sidebar -->
        <aside class="bg-[#0a4aa0] w-48 flex-shrink-0 flex flex-col justify-between py-6 px-5 relative shadow-lg">
            <div>
                <img alt="Emblem Logo" class="mb-10 h-16 w-auto mx-auto"
                    src="https://storage.googleapis.com/a1aa/image/b91d97f7-43d5-4edf-1673-f1a9e16a31fa.jpg" />
                <nav class="flex flex-col space-y-3 text-white text-sm font-semibold">
                    <a class="py-2 px-3 rounded-md hover:bg-blue-700 transition-colors {{ request()->routeIs('admin.dashboard') ? 'bg-blue-700 opacity-100' : 'opacity-70 hover:opacity-100' }}"
                        href="{{ route('admin.dashboard') }}">
                        <i class="fas fa-tachometer-alt mr-2"></i>Dashboard
                    </a>
                    <a class="py-2 px-3 rounded-md hover:bg-blue-700 transition-colors {{ request()->routeIs('admin.rekap') ? 'bg-blue-700 opacity-100' : 'opacity-70 hover:opacity-100' }}"
                        href="{{ route('admin.rekap') }}">
                        <i class="fas fa-calendar-alt mr-2"></i>Rekap Absensi
                    </a>
                    <a class="py-2 px-3 rounded-md hover:bg-blue-700 transition-colors {{ request()->routeIs('admin.karyawan*') ? 'bg-blue-700 opacity-100' : 'opacity-70 hover:opacity-100' }}"
                        href="{{ route('admin.karyawan') }}">
                        <i class="fas fa-users mr-2"></i>Data Pengguna
                    </a>
                </nav>
            </div>
            <div class="mt-auto">
                <a href="{{ route('admin.profil') }}"
                    class="block bg-gray-200 hover:bg-gray-300 rounded-lg px-3 py-2 text-center w-full text-gray-700">
                    <p class="font-bold text-xs truncate">{{ Auth::user()->name ?? 'Admin' }}</p>
                    <p class="text-xs font-normal">Admin</p>
                </a>
            </div>
        </aside>

        <!-- Main content -->
        <main class="flex-1 p-6 overflow-y-auto">
            <h1 class="text-black font-bold text-xl mb-6">Edit Pengguna: {{ $user->name }}</h1>

            <section class="bg-white rounded-md shadow-lg p-6 max-w-2xl mx-auto">
                @if (session('success'))
                    <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-4" role="alert">
                        <p>{{ session('success') }}</p>
                    </div>
                @endif
                @if (session('error'))
                    <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-4" role="alert">
                        <p>{{ session('error') }}</p>
                    </div>
                @endif

                <form method="POST" action="{{ route('admin.karyawan.update', $user->id) }}">
                    @csrf
                    @method('PUT')

                    <!-- Nama Lengkap -->
                    <div class="mb-4">
                        <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Nama Lengkap</label>
                        <input type="text" name="name" id="name" value="{{ old('name', $user->name) }}"
                            required
                            class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 px-3 py-2">
                        @error('name')
                            <span class="text-red-500 text-xs mt-1">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- NIP -->
                    <div class="mb-4">
                        <label for="nip" class="block text-sm font-medium text-gray-700 mb-1">NIP</label>
                        <input type="text" name="nip" id="nip" value="{{ old('nip', $user->nip) }}"
                            required
                            class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 px-3 py-2">
                        @error('nip')
                            <span class="text-red-500 text-xs mt-1">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Email -->
                    <div class="mb-4">
                        <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                        <input type="email" name="email" id="email" value="{{ old('email', $user->email) }}"
                            required
                            class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 px-3 py-2">
                        @error('email')
                            <span class="text-red-500 text-xs mt-1">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Jabatan -->
                    <div class="mb-4">
                        <label for="jabatan" class="block text-sm font-medium text-gray-700 mb-1">Jabatan</label>
                        <input type="text" name="jabatan" id="jabatan"
                            value="{{ old('jabatan', $user->jabatan) }}"
                            class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 px-3 py-2">
                        @error('jabatan')
                            <span class="text-red-500 text-xs mt-1">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Role -->
                    <div class="mb-4">
                        <label for="role" class="block text-sm font-medium text-gray-700 mb-1">Role</label>
                        <select name="role" id="role" required
                            class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 px-3 py-2">
                            @if (isset($roles)) {{-- Pastikan $roles dikirim dari controller --}}
                                @foreach ($roles as $roleValue)
                                    <option value="{{ $roleValue }}"
                                        {{ old('role', $user->role) == $roleValue ? 'selected' : '' }}>
                                        {{ ucfirst($roleValue) }}
                                    </option>
                                @endforeach
                            @else
                                {{-- Fallback jika $roles tidak ada --}}
                                <option value="employee"
                                    {{ old('role', $user->role) == 'employee' ? 'selected' : '' }}>Employee</option>
                                <option value="admin" {{ old('role', $user->role) == 'admin' ? 'selected' : '' }}>
                                    Admin</option>
                            @endif
                        </select>
                        @error('role')
                            <span class="text-red-500 text-xs mt-1">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Jadwal Kerja Mulai -->
                    <div class="mb-4">
                        <label for="jadwal_kerja_mulai" class="block text-sm font-medium text-gray-700 mb-1">Jadwal
                            Kerja Mulai (JJ:MM)</label>
                        <input type="time" name="jadwal_kerja_mulai" id="jadwal_kerja_mulai"
                            value="{{ old('jadwal_kerja_mulai', $user->jadwal_kerja_mulai ? \Carbon\Carbon::parse($user->jadwal_kerja_mulai)->format('H:i') : '') }}"
                            class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 px-3 py-2">
                        @error('jadwal_kerja_mulai')
                            <span class="text-red-500 text-xs mt-1">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Jadwal Kerja Selesai -->
                    <div class="mb-4">
                        <label for="jadwal_kerja_selesai" class="block text-sm font-medium text-gray-700 mb-1">Jadwal
                            Kerja Selesai (JJ:MM)</label>
                        <input type="time" name="jadwal_kerja_selesai" id="jadwal_kerja_selesai"
                            value="{{ old('jadwal_kerja_selesai', $user->jadwal_kerja_selesai ? \Carbon\Carbon::parse($user->jadwal_kerja_selesai)->format('H:i') : '') }}"
                            class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 px-3 py-2">
                        @error('jadwal_kerja_selesai')
                            <span class="text-red-500 text-xs mt-1">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Password Baru (Opsional) -->
                    <div class="mb-4">
                        <label for="password" class="block text-sm font-medium text-gray-700 mb-1">Password Baru
                            (Kosongkan jika tidak ingin diubah)</label>
                        <input type="password" name="password" id="password"
                            class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 px-3 py-2">
                        @error('password')
                            <span class="text-red-500 text-xs mt-1">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Konfirmasi Password Baru -->
                    <div class="mb-6">
                        <label for="password_confirmation"
                            class="block text-sm font-medium text-gray-700 mb-1">Konfirmasi Password Baru</label>
                        <input type="password" name="password_confirmation" id="password_confirmation"
                            class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 px-3 py-2">
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
