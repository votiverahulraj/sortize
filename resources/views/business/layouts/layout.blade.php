<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Sortiz Interprise</title>

    <!-- Favicon -->
    <link rel="shortcut icon" href="{{ url('/public') }}/admin_assets/images/fav.png" />

    <!-- ================== Local Vendor CSS ================== -->
    <link rel="stylesheet" href="{{ url('/public') }}/admin_assets/vendors/feather/feather.css">
    <link rel="stylesheet" href="{{ url('/public') }}/admin_assets/vendors/ti-icons/css/themify-icons.css">
    <link rel="stylesheet" href="{{ url('/public') }}/admin_assets/vendors/css/vendor.bundle.base.css">
    <link rel="stylesheet" href="{{ url('/public') }}/admin_assets/vendors/font-awesome/css/font-awesome.min.css">
    <link rel="stylesheet" href="{{ url('/public') }}/admin_assets/vendors/mdi/css/materialdesignicons.min.css">
    <link rel="stylesheet" href="{{ url('/public') }}/admin_assets/vendors/select2/select2.min.css">
    <link rel="stylesheet" href="{{ url('/public') }}/admin_assets/vendors/select2-bootstrap-theme/select2-bootstrap.min.css">
    <link rel="stylesheet" href="{{ url('/public') }}/admin_assets/css/style.css">
    <link rel="stylesheet" href="{{ url('/public') }}/admin_assets/css/dashboard-all.css">

    <!-- ================== CDN CSS ================== -->

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.3/css/bootstrap.min.css">

    <!-- DataTables Core CSS (v2.3.2) -->
    <link rel="stylesheet" href="https://cdn.datatables.net/2.3.2/css/dataTables.bootstrap5.min.css">

    <!-- Buttons Extension CSS (v2.4.1) -->
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.1/css/buttons.bootstrap5.min.css">

    <!-- Select Extension CSS (v1.7.0) -->
    <link rel="stylesheet" href="https://cdn.datatables.net/select/1.7.0/css/select.dataTables.min.css">

    <!-- DateRangePicker -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
</head>

<body>

      <div class="container-scroller">
        <!-- partial:partials/_navbar.html -->
        <nav class="navbar col-lg-12 col-12 p-0 fixed-top d-flex flex-row">
            <div class="text-center navbar-brand-wrapper d-flex align-items-center justify-content-start">
                <a class="navbar-brand brand-logo me-5" href="index.html"><img
                        src="{{ url('/public') }}/admin_assets/images/Sortiz.png" class="me-2" alt="logo" /></a>
                <a class="navbar-brand brand-logo-mini" href="index.html"><img
                        src="{{ url('/public') }}/admin_assets/images/fav.png" alt="logo" /></a>

            </div>
            <div class="navbar-menu-wrapper d-flex align-items-center justify-content-end">
                <button class="navbar-toggler navbar-toggler align-self-center" type="button" data-toggle="minimize">
                    <span class="icon-menu"></span>
                </button>
                <ul class="navbar-nav navbar-nav-right">
                    <li class="nav-item dropdown">
                        <a class="nav-link count-indicator dropdown-toggle" id="notificationDropdown" href="#"
                            data-bs-toggle="dropdown">
                            <i class="icon-bell mx-0"></i>
                            <span class="count"></span>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right navbar-dropdown preview-list"
                            aria-labelledby="notificationDropdown">
                            <p class="mb-0 font-weight-normal float-left dropdown-header">Notifications</p>
                            <a class="dropdown-item preview-item">
                                <div class="preview-thumbnail">
                                    <div class="preview-icon bg-success">
                                        <i class="ti-info-alt mx-0"></i>
                                    </div>
                                </div>
                                <div class="preview-item-content">
                                    <h6 class="preview-subject font-weight-normal">Application Error</h6>
                                    <p class="font-weight-light small-text mb-0 text-muted"> Just now </p>
                                </div>
                            </a>
                            <a class="dropdown-item preview-item">
                                <div class="preview-thumbnail">
                                    <div class="preview-icon bg-warning">
                                        <i class="ti-settings mx-0"></i>
                                    </div>
                                </div>
                                <div class="preview-item-content">
                                    <h6 class="preview-subject font-weight-normal">Settings</h6>
                                    <p class="font-weight-light small-text mb-0 text-muted"> Private message </p>
                                </div>
                            </a>
                            <a class="dropdown-item preview-item">
                                <div class="preview-thumbnail">
                                    <div class="preview-icon bg-info">
                                        <i class="ti-user mx-0"></i>
                                    </div>
                                </div>
                                <div class="preview-item-content">
                                    <h6 class="preview-subject font-weight-normal">New user registration</h6>
                                    <p class="font-weight-light small-text mb-0 text-muted"> 2 days ago </p>
                                </div>
                            </a>
                        </div>
                    </li>
                    <li class="nav-item nav-profile dropdown">
                        <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown"
                            id="profileDropdown">
                            <img src="{{ url('/public') }}/admin_assets/images/faces/face28.jpg" alt="profile" />
                        </a>
                        <div class="dropdown-menu dropdown-menu-right navbar-dropdown"
                            aria-labelledby="profileDropdown">
                            <a class="dropdown-item">
                                <i class="ti-settings text-primary"></i> Settings </a>
                            <a class="dropdown-item" href="{{ route('interprise.logout') }}">
                                <i class="ti-power-off text-primary"></i> Logout </a>
                        </div>
                    </li>

                </ul>

                <button class="navbar-toggler navbar-toggler-right d-lg-none align-self-center add-open-close"
                    type="button">
                    <span class="icon-menu"></span>
                </button>

            </div>
        </nav>
        <!-- partial -->
        <div class="container-fluid page-body-wrapper">
            <!-- partial:partials/_sidebar.html -->
            @include('business.layouts.sidebar')
            <!-- partial -->
            @yield('content')
            <!-- main-panel ends -->
        </div>
        <!-- page-body-wrapper ends -->
    </div>

    <!-- ================== CDN JS ================== -->

    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!-- DataTables Core JS (v2.3.2) -->
    <script src="https://cdn.datatables.net/2.3.2/js/dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/2.3.2/js/dataTables.bootstrap5.min.js"></script>

    <!-- Buttons Extension JS (v2.4.1) -->
    <script src="https://cdn.datatables.net/buttons/2.4.1/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.bootstrap5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.print.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/vfs_fonts.js"></script>

    <!-- Select Extension JS (v1.7.0) -->
    <script src="https://cdn.datatables.net/select/1.7.0/js/dataTables.select.min.js"></script>

    <!-- ================== Local Vendor JS ================== -->
    <script src="{{ url('/public') }}/admin_assets/vendors/js/vendor.bundle.base.js"></script>
    <script src="{{ url('/public') }}/admin_assets/vendors/chart.js/chart.umd.js"></script>
    <script src="{{ url('/public') }}/admin_assets/vendors/select2/select2.min.js"></script>

    <!-- ================== Custom Scripts ================== -->
    <script src="{{ url('/public') }}/admin_assets/js/off-canvas.js"></script>
    <script src="{{ url('/public') }}/admin_assets/js/template.js"></script>
    <script src="{{ url('/public') }}/admin_assets/js/settings.js"></script>
    <script src="{{ url('/public') }}/admin_assets/js/todolist.js"></script>
    <script src="{{ url('/public') }}/admin_assets/js/jquery.cookie.js" type="text/javascript"></script>
    <script src="{{ url('/public') }}/admin_assets/js/dashboard.js"></script>
    <script src="{{ url('/public') }}/admin_assets/js/select2.js"></script>

    <!-- Sidebar Toggle -->
    <script>
        $('.add-open-close').on('click', function () {
            $('#sidebar').toggleClass('active');
        });

        $(document).on('click', function (e) {
            const sidebar = $('#sidebar');
            const toggleButton = $('.add-open-close');

            if (!sidebar.is(e.target) && sidebar.has(e.target).length === 0 &&
                !toggleButton.is(e.target) && toggleButton.has(e.target).length === 0) {
                sidebar.removeClass('active');
            }
        });
    </script>

    <!-- DataTable Initialization -->
    <script>
        $(document).ready(function () {
            $('#eventtable').DataTable({
                dom: 'Bfrtip',
                buttons: ['copy', 'csv', 'excel', 'pdf', 'print'],
                select: true
            });
        });
    </script>

    <!-- Blade Stack Scripts -->
    @stack('scripts')
</body>

</html>
