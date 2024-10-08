<!DOCTYPE html>
<html
  lang="tr"
  class="light-style layout-menu-fixed layout-compact"
  dir="ltr"
  data-theme="theme-default"
  data-assets-path="../assets/"
  data-template="vertical-menu-template-free"
  data-style="light">
  <head>
    <meta charset="utf-8" />
    <meta
      name="viewport"
      content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />

    <title>Arina Digital | HR Management</title>

    <meta name="description" content="" />
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link rel="icon" type="image/x-icon" href="https://arinadigital.com/wp-content/uploads/2023/12/favicon.png" />

    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
      href="https://fonts.googleapis.com/css2?family=Public+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&display=swap"
      rel="stylesheet" />
    <link rel="stylesheet" href="{{ asset('theme/assets/vendor/fonts/boxicons.css')}}" />
    <link rel="stylesheet" href="{{ asset('theme/assets/vendor/css/core.css')}}" class="template-customizer-core-css" />
    <link rel="stylesheet" href="{{ asset('theme/assets/vendor/css/theme-default.css')}}" class="template-customizer-theme-css" />
    <link rel="stylesheet" href="{{ asset('theme/assets/css/demo.css')}}" />
    <link rel="stylesheet" href="{{ asset('theme/assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css')}}" />
    <link rel="stylesheet" href="{{ asset('theme/assets/vendor/libs/apex-charts/apex-charts.css')}}" />
    <link rel="stylesheet" href="{{ asset('theme/assets/vendor/css/pages/page-auth.css')}}" />
    <script src="{{ asset('theme/assets/vendor/js/helpers.js')}}"></script>
    <script src="{{ asset('theme/assets/js/config.js')}}"></script>

    <link rel="apple-touch-icon" type="https://arinadigital.com/wp-content/uploads/2023/12/favicon.png" href="icon.57.png">
    <link rel="apple-touch-icon" type="https://arinadigital.com/wp-content/uploads/2023/12/favicon.png" sizes="72x72" href="icon.72.png">
    <link rel="apple-touch-icon" type="https://arinadigital.com/wp-content/uploads/2023/12/favicon.png" sizes="114x114" href="icon.114.png">
    <link rel="icon" type="https://arinadigital.com/wp-content/uploads/2023/12/favicon.png" href="icon.114.png">

  </head>

  @if(auth()->check())
    <body>
      <div class="layout-wrapper layout-content-navbar">
        <div class="layout-container">
          @include('layouts.navigation')

          @yield('content')

          <div class="content-backdrop fade"></div>
          </div>
          <!-- Content wrapper -->
        </div>
        <!-- / Layout page -->
      </div>

      <!-- Overlay -->
      <div class="layout-overlay layout-menu-toggle"></div>
    </div>
    @endif

    <script src="{{ asset('theme/assets/vendor/libs/jquery/jquery.js')}}"></script>
    <script src="{{ asset('theme/assets/vendor/libs/popper/popper.js')}}"></script>
    <script src="{{ asset('theme/assets/vendor/js/bootstrap.js')}}"></script>
    <script src="{{ asset('theme/assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js')}}"></script>
    <script src="{{ asset('theme/assets/vendor/js/menu.js')}}"></script>

    <script src="{{ asset('theme/assets/vendor/libs/apex-charts/apexcharts.js')}}"></script>

    <script src="{{ asset('theme/assets/js/main.js')}}"></script>

    <script src="{{ asset('theme/assets/js/dashboards-analytics.js')}}"></script>

    <script src="{{ asset('theme/assets/js/ui-modals.js')}}"></script>

    <script async defer src="https://buttons.github.io/buttons.js"></script>
  </body>
</html>

