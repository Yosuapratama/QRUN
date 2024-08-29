<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    @stack('mainTitle')
    @stack('title')
    @stack('css')
</head>
<body>
    @yield('contentApp')

    @stack('scriptApp')
</body>
</html>