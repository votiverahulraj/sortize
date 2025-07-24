<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Sortiz Enterprise</title>
    <!-- plugins:css -->
    <link rel="stylesheet" href="{{ url('/public') }}/admin_assets/vendors/feather/feather.css">
    <link rel="stylesheet" href="{{ url('/public') }}/admin_assets/vendors/ti-icons/css/themify-icons.css">
    <link rel="stylesheet" href="{{ url('/public') }}/admin_assets/vendors/css/vendor.bundle.base.css">
    <link rel="stylesheet" href="{{ url('/public') }}/admin_assets/vendors/font-awesome/css/font-awesome.min.css">
    <link rel="stylesheet" href="{{ url('/public') }}/admin_assets/vendors/mdi/css/materialdesignicons.min.css">
    <link rel="stylesheet" href="{{ url('/public') }}/admin_assets/vendors/select2/select2.min.css">
    <link rel="stylesheet"
        href="{{ url('/public') }}/admin_assets/vendors/select2-bootstrap-theme/select2-bootstrap.min.css">
    <!-- endinject -->
    <!-- Plugin css for this page -->
    <!-- End plugin css for this page -->
    <!-- inject:css -->
    <link rel="stylesheet" href="{{ url('/public') }}/admin_assets/css/style.css">

    <!-- endinject -->
    <link rel="shortcut icon" href="{{ url('/public') }}/admin_assets/images/fav.png" />

    <style>
    .reg_form {
        margin-top: 20px;
    }

    .regis_block .brand-logo img {
        width: 270px !important;
    }

    .reg_wrapper {
        display: flex;
        gap: 20px;
        width: 100%;
        justify-content: center;
    }

    .regis_block .brand-logo {
        text-align: center;
    }

    .reg_wrapper select.form-control {
        color: #333;
    }

    .reg_wrapper .form-group {
        margin-bottom: 15px !important;
    }

    .error {
        color: red;
        font-size: 14px;
    }
    </style>
</head>

<body>

    <div class="container-scroller">
        <div class="container-fluid page-body-wrapper full-page-wrapper">
            <div class="content-wrapper d-flex align-items-center auth px-0">
                <div class="row w-100 mx-0">
                    <div class="col-lg-6 mx-auto">
                        <div class="auth-form-light text-left py-3 px-4 px-sm-5 regis_block">
                            <div class="brand-logo">
                                <img src="{{ url('/public') }}/admin_assets/images/Sortiz.png" alt="logo"
                                    style="width: 83%;">
                            </div>
                            <div id="responseMessage"></div>
                            <div class=" text-center align-items-center">
                                <h4 class="font-weight-light">Interprise Register.</h4>
                            </div>
                            <form class="reg_form" action="{{ route('bussiness.store') }}" id="registrationForm" enctype="multipart/form-data">
                                {!! csrf_field() !!}

                                <div class="reg_wrapper">
                                    <div class="left_col">

                                        <!-- First Name -->
                                        <div class="form-group">
                                            <label class="mb-0 mr-2" style="width: 250px;">First Name</label>
                                            <input type="text" class="form-control form-control-sm" name="first_name">
                                            @error("first_name")
                                                <small class="text-danger">{{ $message }}</small>
                                            @enderror
                                        </div>

                                        <!-- Type of Company -->
                                        <div class="form-group">
                                            <label class="mb-0 mr-2" style="width: 250px;">Type of Company</label>
                                            <select name="company_type" class="form-control form-control-sm"
                                                id="companyType">
                                                <option value="">-- Select Type --</option>
                                                <option value="1">Individual</option>
                                                <option value="2">Legal Entity</option>
                                            </select>
                                            @error("company_type")
                                                <small class="text-danger">{{ $message }}</small>
                                            @enderror
                                        </div>

                                        <!-- Email -->
                                        <div class="form-group">
                                            <label class="mb-0 mr-2" style="width: 250px;">Email Address</label>
                                            <input type="email" class="form-control form-control-sm" name="email"
                                                id="email" >
                                                @error("email")
                                                <small class="text-danger">{{ $message }}</small>
                                            @enderror
                                        </div>

                                        <!-- Password -->
                                        <div class="form-group">
                                            <label class="mb-0 mr-2" style="width: 250px;">Password</label>
                                            <input type="password" class="form-control form-control-sm" name="password"
                                                id="password" >
                                                @error("password")
                                                <small class="text-danger">{{ $message }}</small>
                                            @enderror
                                        </div>

                                        <!-- Website Link -->
                                        <div class="form-group">
                                            <label class="mb-0 mr-2" style="width: 250px;">Website Link
                                                (Optional)</label>
                                            <input type="text" class="form-control form-control-sm" name="Website_link">
                                        </div>

                                    </div>

                                    <div class="rgt_col">

                                        <!-- Last Name -->
                                        <div class="form-group">
                                            <label class="mb-0 mr-2" style="width: 250px;">Last Name</label>
                                            <input type="text" class="form-control form-control-sm" name="last_name"
                                                >
                                                @error("first_name")
                                                <small class="text-danger">{{ $message }}</small>
                                            @enderror
                                        </div>

                                        <!-- Commercial Name -->
                                        <div class="form-group position-relative" style="min-height: 70px;">
                                            <div id="commercialNameField"
                                                style="display: none; position: absolute; top: 0; left: 0; right: 0;">
                                                <label class="mb-0 mr-2" style="width: 250px;">Commercial Name (Legal
                                                    Entity)</label>
                                                <input type="text" class="form-control form-control-sm" name="c_name">
                                            </div>
                                        </div>

                                        <!-- Contact Number -->
                                        <div class="form-group">
                                            <label class="mb-0 mr-2" style="width: 250px;">Contact Number</label>
                                            <input type="number" class="form-control form-control-sm"
                                                name="contact_number">
                                                @error("contact_number")
                                                <small class="text-danger">{{ $message }}</small>
                                            @enderror
                                        </div>

                                        <!-- Confirm Password -->
                                        <div class="form-group">
                                            <label class="mb-0 mr-2" style="width: 250px;">Confirm Password</label>
                                            <input type="password" class="form-control form-control-sm"
                                                name="password_confirmation" id="password_confirmation">
                                        </div>

                                        <div class="form-group">
                                            <label class="mb-0 mr-2" style="width: 250px;">City (Activity
                                                Location)</label>
                                            <input type="text" class="form-control form-control-sm" name="city_id">
                                        </div>

                                    </div>
                                </div>

                                <div class="form-group text-center">
                                    <div class="form-check d-inline-flex align-items-center justify-content-center">
                                        <input type="checkbox" onchange="enableSubmit(this)" class="form-check-input" style="margin-right: -20px;"
                                            name="status" id="terms" >
                                        <label class="form-check-label mb-0" for="terms">
                                            <strong>I agree to the <a href="#" target="">Terms and
                                                    Conditions</a></strong>
                                        </label>
                                    </div>
                                    <label id="terms-error" class="error text-danger small mt-1 d-block"
                                        for="terms"></label>
                                </div>


                                <!-- Hidden Fields -->
                                <input type="hidden" name="user_id" value="">
                                <input type="hidden" name="user_time" value="" id="user_timezone">

                                <!-- Submit Button -->
                                <div class="form-group text-center">
                                    <button type="submit" id="submitBtn" class="btn btn-primary" disabled>Register</button>
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
    <!-- Select2 CSS (in <head>) -->

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.21.0/jquery.validate.min.js" integrity="sha512-KFHXdr2oObHKI9w4Hv1XPKc898mE4kgYx58oqsc/JqqdLMDI4YjOLzom+EMlW8HFUd0QfjfAvxSL6sEq/a42fQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <!-- Now set $j after both are loaded -->
    <script>
    var $j = jQuery.noConflict();
    </script>
    <script>

        function enableSubmit(elem){
            if($j(elem).is(':checked')){
                $('#submitBtn').prop('disabled', false);
            }else{
                $('#submitBtn').prop('disabled', true);
            }
        }
    $j(document).ready(function() {
        $j('#registrationForm').validate({
            rules: {
                first_name: {
                    required: true,
                    minlength: 2
                },
                last_name: {
                    required: true,
                    minlength: 2
                },
                email: {
                    required: true,
                    email: true
                },
                password: {
                    required: true,
                    minlength: 6
                },
                password_confirmation: {
                    required: true,
                    minlength: 6,
                    equalTo: "#password"
                },
                city_id: {
                    required: true
                },
                terms: {
                    required: true
                }
            },
            messages: {
                first_name: "Enter first name",
                last_name: "Enter last name",
                email: {
                    required: "Email is required",
                    email: "Enter a valid email"
                },
                password: {
                    required: "Password required",
                    minlength: "Min 6 characters"
                },
                password_confirmation: {
                    required: "Please confirm your password",
                    minlength: "Min 6 characters",
                    equalTo: "Passwords do not match"
                },
                city_id: "Select city",
                status: "You must agree to the terms and conditions"
            },
            errorClass: "error",
            errorPlacement: function(error, element) {
                // Custom error placement for checkbox
                if (element.attr("type") === "checkbox" && element.attr("name") === "status") {
                    error.appendTo('#terms-error');
                } else {
                    error.insertAfter(element);
                }
            },
            submitHandler: function(form) {
                console.log("Validation passed, submitting form");
                var formData = new FormData(form);
                var email = $j('#email').val();
                formData.append('email', email);
                $j.ajax({
                    url: "{{ route('bussiness.store') }}",
                    type: "POST",
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        if (response.success) {
                            $j('#responseMessage')
                                .html('<div class="alert alert-success">' + response
                                    .message + '</div>');
                            window.location.href = response.redirect;
                        } else {
                            $j('#responseMessage')
                                .html('<div class="alert alert-danger">' + response
                                    .message + '</div>');
                        }
                    },
                    error: function(xhr) {
                        let res = xhr.responseJSON;
                        if (res && res.errors) {
                            let messages = Object.values(res.errors).map(e => e[0])
                                .join("<br>");
                            $j('#responseMessage')
                                .html('<div class="alert alert-danger">' + messages +
                                    '</div>');
                        } else {
                            $j('#responseMessage')
                                .html(
                                    '<div class="alert alert-danger">An unexpected error occurred.</div>'
                                    );
                        }
                    }
                });
                return false;
            }
        });
    });
    </script>


    <script>
    document.addEventListener("DOMContentLoaded", function() {
        const userTimezone = Intl.DateTimeFormat().resolvedOptions().timeZone;
        document.getElementById("user_timezone").value = userTimezone;
    });

    document.getElementById('companyType').addEventListener('change', function() {
        var value = this.value;
        var commercialField = document.getElementById('commercialNameField');

        if (value === '2') {
            commercialField.style.display = 'block';
        } else {
            commercialField.style.display = 'none';
        }
    });
    </script>

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