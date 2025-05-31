<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1" name="viewport" />
    <title>
        Login Admin
    </title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&amp;display=swap" rel="stylesheet" />
    <style>
        body {
            font-family: 'Inter', sans-serif;
        }
    </style>
</head>

<body class="bg-[#0561bf] min-h-screen flex items-center justify-center">
    <main class="flex flex-col items-center space-y-6 w-full max-w-xs px-4">
        <img alt="Yellow and green emblem with star on top, umbrella, waves, and leaves" class="w-20 h-24 object-contain"
            decoding="async" height="100" loading="lazy"
            src="https://storage.googleapis.com/a1aa/image/64dc0eea-658f-4b13-790f-7ec209771411.jpg" width="80" />
        <h1 class="text-white font-semibold text-sm">
            Login sebagai Admin
        </h1>
        <form class="w-full flex flex-col space-y-3" method="POST" action="{{ url('/login-admin') }}">
            @csrf
            <input class="w-full rounded-md text-xs px-3 py-2 focus:outline-none" placeholder="Username" type="text"
                name="username" required />
            <input class="w-full rounded-md text-xs px-3 py-2 focus:outline-none" placeholder="Password" type="password"
                name="password" required />
            <label class="flex items-center space-x-2 text-white text-[9px] font-normal">
                <input class="w-3 h-3" type="checkbox" name="remember" />
                <span>Ingat Username / Password</span>
            </label>
            <button class="bg-[#f18700] text-white text-[10px] font-semibold rounded-full py-2 mt-2 w-full"
                type="submit">
                LOGIN
            </button>
        </form>
    </main>
</body>

</html>
