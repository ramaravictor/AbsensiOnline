<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1" name="viewport" />
    <title>Data Pengguna</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet" />
    <style>
        body {
            font-family: 'Inter', sans-serif;
        }

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
            <h1 class="text-black font-bold text-xl mb-6">
                Data Seluruh Pengguna
            </h1>
            <section class="bg-white rounded-md shadow-md p-4">
                <div class="flex flex-col sm:flex-row justify-between items-center mb-4">
                    <div class="w-full sm:w-auto mb-2 sm:mb-0">
                        {{-- Tombol Tambah Pengguna bisa ditambahkan di sini jika perlu --}}
                        {{-- <a href="{{ route('admin.karyawan.create') }}" class="bg-green-500 hover:bg-green-600 text-white font-semibold py-2 px-4 rounded text-sm">
                            <i class="fas fa-plus mr-1"></i> Tambah Pengguna
                        </a> --}}
                    </div>
                    <form method="GET" action="{{ route('admin.karyawan') }}"
                        class="flex items-center w-full sm:w-auto">
                        <input
                            class="rounded-l-md px-3 py-2 text-sm border border-gray-300 focus:outline-none focus:ring-1 focus:ring-blue-500 focus:border-blue-500 w-full"
                            placeholder="Cari Nama, NIP, Email..." type="search" name="search_pengguna"
                            value="{{ request('search_pengguna') }}" />
                        <button type="submit"
                            class="bg-blue-600 hover:bg-blue-700 text-white px-3 py-2 rounded-r-md text-sm focus:outline-none">
                            <i class="fas fa-search"></i>
                        </button>
                        @if (request('search_pengguna'))
                            <a href="{{ route('admin.karyawan') }}" class="text-blue-600 text-xs ml-2 hover:underline"
                                title="Hapus Filter">
                                Reset
                            </a>
                        @endif
                    </form>
                </div>
                @if (session('success'))
                    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4"
                        role="alert">
                        <strong class="font-bold">Sukses!</strong>
                        <span class="block sm:inline">{{ session('success') }}</span>
                    </div>
                @endif
                @if (session('error'))
                    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4"
                        role="alert">
                        <strong class="font-bold">Error!</strong>
                        <span class="block sm:inline">{{ session('error') }}</span>
                    </div>
                @endif
                <div class="overflow-x-auto">
                    <table class="w-full border-collapse border border-gray-300 text-xs table-auto">
                        <thead class="bg-gray-100 text-center text-gray-600 sticky top-0 z-10">
                            <tr>
                                <th class="border border-gray-300 px-3 py-2 w-10">No</th>
                                <th class="border border-gray-300 px-3 py-2 w-32">NIP</th>
                                <th class="border border-gray-300 px-3 py-2 ">Nama</th>
                                <th class="border border-gray-300 px-3 py-2 w-32">Jabatan</th>
                                <th class="border border-gray-300 px-3 py-2 w-24">Role</th>
                                <th class="border border-gray-300 px-3 py-2 w-32">Jadwal Kerja</th>
                                <th class="border border-gray-300 px-3 py-2 ">Email</th>
                                <th class="border border-gray-300 px-3 py-2 w-32">Action</th>
                            </tr>
                        </thead>
                        <tbody class="text-gray-700">
                            @forelse ($users as $user)
                                <tr
                                    class="text-center {{ $loop->even ? 'bg-gray-50' : 'bg-white' }} hover:bg-gray-100">
                                    <td class="border border-gray-300 px-3 py-2">
                                        {{ $loop->iteration + ($users->currentPage() - 1) * $users->perPage() }}
                                    </td>
                                    <td class="border border-gray-300 px-3 py-2">{{ $user->nip }}</td>
                                    <td class="border border-gray-300 px-3 py-2 text-left">{{ $user->name }}</td>
                                    <td class="border border-gray-300 px-3 py-2">
                                        {{ $user->jabatan ?? '-' }}
                                    </td>
                                    <td class="border border-gray-300 px-3 py-2">
                                        <span
                                            class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full
                                        {{ $user->role === 'admin' ? 'bg-red-100 text-red-800' : 'bg-green-100 text-green-800' }}">
                                            {{ Str::ucfirst($user->role) }}
                                        </span>
                                    </td>
                                    <td class="border border-gray-300 px-3 py-2">
                                        @if ($user->jadwal_kerja_mulai && $user->jadwal_kerja_selesai)
                                            {{ \Carbon\Carbon::parse($user->jadwal_kerja_mulai)->format('H:i') }} -
                                            {{ \Carbon\Carbon::parse($user->jadwal_kerja_selesai)->format('H:i') }}
                                        @else
                                            -
                                        @endif
                                    </td>
                                    <td class="border border-gray-300 px-3 py-2 text-left">{{ $user->email }}</td>
                                    <td class="border border-gray-300 px-3 py-2">
                                        <div class="flex space-x-1">
                                            <a href="{{ route('admin.karyawan.edit', $user->id) }}"
                                                class="bg-yellow-500 text-white text-xs rounded px-3 py-1.5 hover:bg-yellow-600 inline-flex items-center">
                                                <i class="fas fa-edit mr-1"></i> Edit
                                            </a>
                                            <form action="{{ route('admin.karyawan.destroy', $user->id) }}"
                                                method="POST"
                                                onsubmit="return confirm('Apakah Anda yakin ingin menghapus pengguna {{ $user->name }}?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                    class="bg-red-500 text-white text-xs rounded px-3 py-1.5 hover:bg-red-600 inline-flex items-center">
                                                    <i class="fas fa-trash mr-1"></i> Hapus
                                                </button>
                                            </form>
                                        </div>
                                    </td>

                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8"
                                        class="text-center border border-gray-300 px-2 py-10 text-gray-500">
                                        Tidak ada data pengguna yang ditemukan.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                @if (isset($users) && $users->hasPages())
                    <div class="mt-4 pagination">
                        {{ $users->links() }}
                    </div>
                @endif
            </section>
        </main>
    </div>
</body>

</html>
