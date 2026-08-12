<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
    <meta name="description" content="SPI POLINEMA — Sistem Pengawasan Internal Politeknik Negeri Malang">
    <title>@yield('title') — SPI POLINEMA</title>

    <!-- General CSS Libraries -->
    <link rel="stylesheet" href="{{ asset('library/bootstrap/dist/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- Select2 -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

    <!-- SweetAlert2 -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">

    <!-- Inter Font -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">

    @stack('style')

    <!-- Stisla Template CSS (base) -->
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('css/components.css') }}">

    <!-- SPI Enterprise Design System -->
    <link rel="stylesheet" href="{{ asset('css/sispi-theme.css') }}">
    <link rel="stylesheet" href="{{ asset('css/spi-dashboard.css') }}">
</head>

<body>
    <div id="app">
        <div class="main-wrapper">
            @includeWhen(!($isWelcomePage ?? false), 'components.header')
            @includeWhen(!($isWelcomePage ?? false), 'components.sidebar')
            @yield('main')
            @include('components.footer')
        </div>
    </div>

    <!-- Core JS Libraries -->
    <script src="{{ asset('library/jquery/dist/jquery.min.js') }}"></script>
    <script src="{{ asset('library/popper.js/dist/umd/popper.js') }}"></script>
    <script src="{{ asset('library/tooltip.js/dist/umd/tooltip.js') }}"></script>
    <script src="{{ asset('library/bootstrap/dist/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('library/jquery.nicescroll/dist/jquery.nicescroll.min.js') }}"></script>
    <script src="{{ asset('library/moment/min/moment.min.js') }}"></script>

    <!-- Select2 + SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <!-- XLSX -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.18.5/xlsx.full.min.js"></script>

    <!-- Stisla Template JS -->
    <script src="{{ asset('js/stisla.js') }}"></script>
    <script src="{{ asset('js/scripts.js') }}"></script>
    <script src="{{ asset('js/custom.js') }}"></script>

    @stack('scripts')

    <!-- GSAP 3 CDN -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.5/gsap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.5/ScrollTrigger.min.js"></script>

    <!-- SPI GSAP Micro-Animations -->
    <script src="{{ asset('js/spi-gsap-init.js') }}"></script>

    <!-- Custom Dropdown Menu Handler for Stisla-style sidebar dropdown -->
    <script>
        $(document).ready(function() {
            // Handle dropdown menu with clickable parent link
            $('.sidebar-menu .dropdown > .has-dropdown').each(function() {
                var $this = $(this);
                var $parent = $this.parent('li.dropdown');
                var $dropdownMenu = $parent.find('.dropdown-menu');

                $this.off('click');

                $this.on('click', function(e) {
                    e.preventDefault();

                    if ($parent.hasClass('active')) {
                        var href = $this.attr('href');
                        if (href && href !== '#') {
                            window.location.href = href;
                        }
                    } else {
                        $('.sidebar-menu .dropdown').not($parent).removeClass('active');
                        $('.sidebar-menu .dropdown .dropdown-menu').not($dropdownMenu).slideUp(200);
                        $parent.addClass('active');
                        $dropdownMenu.slideDown(200);
                    }
                });
            });
        });
    </script>

</body>

</html>
