<!DOCTYPE html>
<html lang="en">

<head>
    <title>@yield('title') | Light Able Laravel 11 Admin & Dashboard Template</title>
    <!-- [Meta] -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta
  name="description"
  content="Light Able admin and dashboard template offer a variety of UI elements and pages, ensuring your admin panel is both fast and effective."
/>
<meta name="author" content="phoenixcoded" />

    <!-- [Favicon] icon -->
    <link rel="icon" href="{{ URL::asset('build/images/favicon.svg') }}" type="image/x-icon">

    @yield('css')

    @include('layouts.head-css')

    @yield('css-bottom')
</head>

<body class="component-page" data-pc-preset="preset-1" data-pc-sidebar-theme="light" data-pc-sidebar-caption="true" data-pc-direction="ltr" data-pc-theme="light">
    
    @include('layouts.loader')
    @include('layouts.component-header')

    <section class="component-block">
    <div class="container">
      <div class="row">
        <div class="col-xl-3">
            @include('layouts.component-menu-list')
        </div>
        <div class="col-xl-9">
            <div class="row">
                @include('layouts.breadcrumb-component')
            </div>
            <!-- [ Main Content ] start -->
            @yield('content')
            <!-- [ Main Content ] end -->
        </div>
        </div>
    </div>
  </section>
  <!-- [ Main Content ] end -->


    @include('layouts.footerjs')
    @include('layouts.component-footer')
    @include('layouts.customizer')

    @yield('scripts')

  </body>
  <!-- [Body] end -->
</html>