<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>{{ $title ?? 'CristalGrade' }}</title>
    @vite('resources/css/app.css')
</head>
<body class="antialiased bg-gray-50 text-gray-800">
    @yield('content')
</body>
</html>
