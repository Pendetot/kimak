<!DOCTYPE html>
<html lang="en">
<head>
    <title>@yield('title') - {{ config('app.name', 'Laravel') }}</title>
    @include('layouts.head-css')
</head>
<body>
    @include('layouts.loader')

    <nav class="pc-sidebar">
        @include('layouts.sidebar')
    </nav>

        @include('layouts.topbar')

    <div class="pc-container">
        <div class="pc-content">
            @yield('content')
        </div>
    </div>

    @include('layouts.footer')
    @include('layouts.footerjs')
</body>
</html>
