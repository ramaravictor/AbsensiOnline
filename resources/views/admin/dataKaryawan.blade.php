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
            <h1 class="text-black font-bold text-lg mb-4">
                Data Seluruh Pengguna {{-- Mengganti judul halaman --}}
            </h1>
            <section class="bg-[#0a5eb7] rounded-md p-3 flex flex-col">
                {{-- ... (Tombol Print dan Search tetap sama) ... --}}
                <div class="flex justify-between items-center mb-3">
                    <button aria-label="Print" class="text-white hover:text-gray-300" title="Print"
                        onclick="window.print()">
                        <i class="fas fa-print fa-lg"></i>
                    </button>

                    <form method="GET" action="{{ route('admin.karyawan') }}" class="flex items-center">
                        <input class="rounded-l px-3 py-1 text-sm focus:outline-none"
                            placeholder="Cari Nama, NIP, Email..." type="search" name="search_pengguna"
                            value="{{ request('search_pengguna') }}" {{-- Menampilkan kembali query pencarian --}} />
                        <button type="submit"
                            class="bg-white text-[#0a5eb7] px-3 py-1 rounded-r text-sm hover:bg-gray-200 focus:outline-none">
                            <i class="fas fa-search"></i>
                        </button>
                        @if (request('search_pengguna'))
                            <a href="{{ route('admin.karyawan') }}" class="text-white text-xs ml-2 hover:underline"
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
                <div class="overflow-x-auto bg-white rounded-md shadow-inner max-h-[calc(100vh-250px)] overflow-y-auto">
                    <table class="w-full border-collapse border border-gray-300 text-xs">
                        <thead class="bg-gray-200 text-center text-gray-700 sticky top-0 z-10">
                            <tr>
                                <th class="border border-gray-300 px-2 py-1 w-8">No</th>
                                <th class="border border-gray-300 px-2 py-1 w-36">ID Pengguna (NIP)</th>
                                <th class="border border-gray-300 px-2 py-1 w-auto">Nama</th>
                                <th class="border border-gray-300 px-2 py-1 w-28">Jabatan</th>
                                <th class="border border-gray-300 px-2 py-1 w-28">Role</th> {{-- KOLOM BARU --}}
                                <th class="border border-gray-300 px-2 py-1 w-32">Jadwal Kerja</th>
                                <th class="border border-gray-300 px-2 py-1 w-auto">Email</th>
                                <th class="border border-gray-300 px-2 py-1 w-40">Action</th>
                            </tr>
                        </thead>
                        <tbody class="text-center text-gray-700">
                            @forelse ($users as $user)
                                {{-- Menggunakan $users --}}
                                <tr>
                                    <td class="border border-gray-300 px-2 py-1">
                                        {{ $loop->iteration + ($users->currentPage() - 1) * $users->perPage() }}
                                    </td>
                                    <td class="border border-gray-300 px-2 py-1">{{ $user->nip }}</td>
                                    <td class="border border-gray-300 px-2 py-1 text-left">{{ $user->name }}</td>
                                    <td class="border border-gray-300 px-2 py-1">
                                        {{ $user->jabatan ?? 'Belum Diatur' }}
                                    </td>
                                    <td class="border border-gray-300 px-2 py-1">
                                        {{ Str::ucfirst($user->role) }} {{-- Menampilkan Role --}}
                                    </td>
                                    <td class="border border-gray-300 px-2 py-1">
                                        @if ($user->jadwal_kerja_mulai && $user->jadwal_kerja_selesai)
                                            {{ \Carbon\Carbon::parse($user->jadwal_kerja_mulai)->format('H:i') }} -
                                            {{ \Carbon\Carbon::parse($user->jadwal_kerja_selesai)->format('H:i') }}
                                        @else
                                            Belum Diatur
                                        @endif
                                    </td>
                                    <td class="border border-gray-300 px-2 py-1 text-left">{{ $user->email }}</td>
                                    <td class="border border-gray-300 px-2 py-1 space-x-1">
                                        <a href="{{ route('admin.karyawan.edit', $user->id) }}"
                                            class="bg-yellow-500 text-white text-xs rounded px-3 py-1 hover:bg-yellow-600 inline-block">
                                            Edit
                                        </a>
                                        <form action="{{ route('admin.karyawan.destroy', $user->id) }}" method="POST"
                                            class="inline-block"
                                            onsubmit="return confirm('Apakah Anda yakin ingin menghapus pengguna {{ $user->name }}?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                class="bg-red-500 text-white text-xs rounded px-3 py-1 hover:bg-red-600">
                                                Delete
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    {{-- Sesuaikan colspan menjadi 8 karena ada tambahan kolom Role --}}
                                    <td colspan="8" class="text-center border border-gray-300 px-2 py-3">
                                        Tidak ada data pengguna yang ditemukan.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="mt-4 bg-white px-3 py-2 rounded-b-md text-xs text-gray-700 pagination">
                    {{ $users->links() }} {{-- Menggunakan $users --}}
                </div>
            </section>
        </main>
    </div>
</body>

</html>
