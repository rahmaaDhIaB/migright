<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="robots" content="noindex">
    <link rel="apple-touch-icon" sizes="76x76" href="{{ asset('assets/icon.png') }}">
    <link rel="icon" type="image/png" href="{{ asset('assets/icon.png') }}">
    <link rel="stylesheet" href="https://cdn.ckeditor.com/ckeditor5/43.0.0/ckeditor5.css" />

    <link rel="stylesheet"
          href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-tagsinput/0.8.0/bootstrap-tagsinput.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css"
          integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA=="
          crossorigin="anonymous" referrerpolicy="no-referrer"/>
    <title>Migright</title>
    <link rel="icon" href="{!! asset('assets/icon.png')!!}"/>

    {{--        <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet" />--}}
    @vite([
                'resources/sass/app.scss',
                'resources/scss/app.scss',
                'resources/css/app.css',
                'resources/js/app.js'
            ])
    @yield('css')
</head>

<body class="g-sidenav-show  bg-gray-100">
@auth()
    @include('layout.sidebar')
@endauth
<main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg ">
    <!-- Navbar -->
    @auth()
        <nav
            class="navbar navbar-main navbar-expand-lg px-0 mx-4 border-radius-xl shadow-none position-sticky mt-4 top-1 z-index-sticky active "
            id="navbarBlur" data-class="bg-transparent" data-scroll="true">

            <div class="container-fluid py-1 px-3">

                {{--Bread crumb--}}

                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb bg-transparent mb-0 pb-0 pt-1 px-0 me-sm-6 me-5">
                        <li class="breadcrumb-item text-sm"><a class="opacity-5 text-dark"
                                                               href="javascript:">{{__('Dashboard')}}</a>
                        </li>
                        <li class="breadcrumb-item text-sm text-dark active" aria-current="page">@yield('title')</li>
                    </ol>
                </nav>
                {{--**********--}}

                @include('layout.navbar')

            </div>
        </nav>
    @endauth
    <!-- End Navbar -->
    <div class="container-fluid py-4">

        {{-- ALERTS --}}
        @if ($errors->any())
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <span class="alert-text">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
            </span>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif
        @if(Session::has('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <span class="alert-icon"><i class="fa fa-info-circle"></i></span>
                <span class="alert-text">{{ Session::get('success') }}</span>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif
        @if(Session::has('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <span class="alert-icon"><i class="fa fa-info-circle"></i></span>
                <span class="alert-text">{{ Session::get('error') }}</span>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif
        {{-- END ALERTS --}}

        @yield('content')

    </div>
    @include('layout.footer')
</main>

<script>
    var win = navigator.platform.indexOf('Win') > -1;
    if (win && document.querySelector('#sidenav-scrollbar')) {
        var options = {
            damping: '0.5'
        }
        Scrollbar.init(document.querySelector('#sidenav-scrollbar'), options);
    }
</script>
@stack('js')
@yield('js')
{{--<script src="{{asset('js/sweetalert.min.js')}}"></script>--}}
<script type="module">
    $(document).ready(function () {
        $('th').addClass('text-uppercase text-secondary text-xs font-weight-bolder');
        $('.dataTables_info').hide()
        $('table').removeClass('table-bordered table-striped')
        $("body").tooltip({selector: '[data-toggle=tooltip]'});
    });
</script>
<script type="importmap">
    {
        "imports": {
            "ckeditor5": "https://cdn.ckeditor.com/ckeditor5/43.0.0/ckeditor5.js",
            "ckeditor5/": "https://cdn.ckeditor.com/ckeditor5/43.0.0/"
        }
    }
</script>

</body>
@stack('modals')
</html>
