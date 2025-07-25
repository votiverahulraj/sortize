<!DOCTYPE html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Sportiz Admin</title>
    <!-- plugins:css -->
    <link rel="stylesheet" href="{{ url('/public') }}/admin_assets/vendors/feather/feather.css">
    <link rel="stylesheet" href="{{ url('/public') }}/admin_assets/vendors/ti-icons/css/themify-icons.css">
    <link rel="stylesheet" href="{{ url('/public') }}/admin_assets/vendors/css/vendor.bundle.base.css">
    <link rel="stylesheet" href="{{ url('/public') }}/admin_assets/vendors/font-awesome/css/font-awesome.min.css">
    <link rel="stylesheet" href="{{ url('/public') }}/admin_assets/vendors/mdi/css/materialdesignicons.min.css">
    <!-- endinject -->
    <!-- Plugin css for this page -->
    <!-- End plugin css for this page -->
    <!-- inject:css -->
    <link rel="stylesheet" href="{{ url('/public') }}/admin_assets/css/style.css">

    <!-- endinject -->
    <link rel="shortcut icon" href="{{ url('/public') }}/admin_assets/images/fav.png" />
  </head>
  <body>
    <div class="container-scroller">
      <div class="container-fluid page-body-wrapper full-page-wrapper">
        <div class="content-wrapper d-flex align-items-center auth px-0">
          <div class="row w-100 mx-0">
            <div class="col-lg-4 mx-auto">
              <div class="auth-form-light text-left py-5 px-4 px-sm-5">
                <div class="brand-logo">
                <img src="{{ url('/public') }}/admin_assets/images/Sortiz.png" alt="logo" style="width: 83%;">
                </div>
           
                <h3 class="font-weight-light">Interprise Login.</h3>
                <form class="pt-3" method="post" action="{{route('interprise.login')}}">
                {!! csrf_field() !!}
                  <div class="form-group">
                    <input type="email" class="form-control form-control-lg" id="exampleInputEmail1" placeholder="Email" name="email">
                  </div>
                  <div class="form-group">
                    <input type="password" class="form-control form-control-lg" id="exampleInputPassword1" placeholder="Password" name="password">
                  </div>
                  <div class="mt-3 d-grid gap-2">
                    <input type="submit" class="btn btn-block btn-primary btn-lg font-weight-medium auth-form-btn" name="submit" value="SIGN IN">
                  </div>
                  <div class="my-2 d-flex justify-content-between align-items-center">
                    <!--div class="form-check">
                      <label class="form-check-label text-muted">
                        <input type="checkbox" class="form-check-input"> Keep me signed in </label>
                    </div-->
                    <a href="#" class="auth-link text-black">Forgot password? test</a>
                    <a href="{{ route('bussiness.signup') }}" class="auth-link text-black">Signup</a>
                  </div>

                 
                </form>
                  @if (Session::has('warning'))
                      <div class="alert alert-warning">
                          {{ Session::get('warning') }}
                      </div>
                  @endif

                  @if (Session::has('message'))
                      <div class="alert alert-danger">
                          {{ Session::get('message') }}
                      </div>
                  @endif
              </div>
            </div>
          </div>
        </div>
        <!-- content-wrapper ends -->
      </div>
      <!-- page-body-wrapper ends -->
    </div>
    <!-- container-scroller -->
    <!-- plugins:js -->
    <script src="{{ url('/public') }}/admin_assets/vendors/js/vendor.bundle.base.js"></script>
    <!-- endinject -->
    <!-- Plugin js for this page -->
    <!-- End plugin js for this page -->
    <!-- inject:js -->
    <script src="{{ url('/public') }}/admin_assets/js/off-canvas.js"></script>
    <script src="{{ url('/public') }}/admin_assets/js/template.js"></script>
    <script src="{{ url('/public') }}/admin_assets/js/settings.js"></script>
    <script src="{{ url('/public') }}/admin_assets/js/todolist.js"></script>
    <!-- endinject -->
  </body>
</html>