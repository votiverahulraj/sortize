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
    <link rel="stylesheet" href="{{ url('/public') }}/admin_assets/vendors/select2-bootstrap-theme/select2-bootstrap.min.css">
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
                <img src="{{ url('/public') }}/admin_assets/images/Sortiz.png" alt="logo" style="width: 83%;">
                </div>
                <div id="responseMessage"></div>
               <div class=" text-center align-items-center">
  <h4 class="font-weight-light">Interprise Register.</h4>
</div>
  <form class="reg_form" id="registrationForm" enctype="multipart/form-data">
  {!! csrf_field() !!}

<div class="reg_wrapper">
	<div class="left_col">
	
	<!-- First Name -->
	  <div class="form-group">
		<label style="width: 250px;" class="mb-0 mr-2">First Name</label>
		<input type="text" class="form-control form-control-sm" name="first_name" required>
	  </div>
	  
	  <!-- Type of Company -->
	  <div 	class="form-group">
		<label style="width: 250px;" class="mb-0 mr-2">Type of Company</label>
		<select name="company_type" class="form-control form-control-sm" id="companyType" required>
		  <option value="">-- Select Type --</option>
		  <option value="1">Individual</option>
		  <option value="2">Legal Entity</option>
		</select>
	  </div>
	  
	  <!-- Email -->
	  <div class="form-group">
		<label style="width: 250px;" class="mb-0 mr-2">Email Address</label>
		<input type="email" class="form-control form-control-sm" name="email" id="email" required>
	  </div>
	  
	   <!-- Password -->
	  <div class="form-group">
		<label style="width: 250px;" class="mb-0 mr-2">Password</label>
		<input type="password" class="form-control form-control-sm" name="password" id="password" required>
	  </div>

	  <!-- Website Link -->
	  <div class="form-group">
		<label style="width: 250px;" class="mb-0 mr-2">Website Link (Optional)</label>
		<input type="text" class="form-control form-control-sm" name="Website_link">
	  </div>
	  
	</div>

	<div class="rgt_col">
	
	<!-- Last Name -->
	  <div class="form-group">
		<label style="width: 250px;" class="mb-0 mr-2">Last Name</label>
		<input type="text" class="form-control form-control-sm" name="last_name" required>
	  </div>
	  
	  <!-- Commercial Name -->
	  <!-- <div class="form-group" id="commercialNameField" style="display: none;">
		<label style="width: 250px;" class="mb-0 mr-2" >Commercial Name (Legal Entity)</label>
		<input type="text" class="form-control form-control-sm" name="c_name">
	  </div> -->

    <div class="form-group  position-relative" style="min-height: 70px;">
  <div id="commercialNameField" style="display: none; position: absolute; top: 0; left: 0; right: 0;">
    <label style="width: 250px;" class="mb-0 mr-2">Commercial Name (Legal Entity)</label>
    <input type="text" class="form-control form-control-sm" name="c_name">
  </div>
</div>
	  
	  <!-- Contact Number -->
	  <div class="form-group">
		<label style="width: 250px;" class="mb-0 mr-2">Contact Number</label>
		<input type="number" class="form-control form-control-sm" name="contact_number" required>
	  </div>
	  
	  <!-- Confirm Password -->
	  <div class="form-group">
		<label style="width: 250px;" class="mb-0 mr-2">Confirm Password</label>
		<input type="password" class="form-control form-control-sm" name="password_confirmation" id="password_confirmation" required>
	  </div>
	 
	  
	 <!-- City -->
	  <div class="form-group">
		<label style="width: 250px;" class="mb-0 mr-2">City (Activity Location)</label>
		<input type="text" class="form-control form-control-sm" name="city_id">
	  </div>
	 
  
	</div>
  </div>

  <!-- Hidden Fields -->
  <input type="hidden" name="user_id" value="">
  <input type="hidden" name="user_time" value="" id="user_timezone">

  <!-- Submit Button -->
 <div class="form-group text-center">
  <button type="submit" class="btn btn-primary">Register</button>
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

  <script src="{{ url('/public') }}/js/jquery.validate.min.js"></script>
<!-- Now set $j after both are loaded -->
<script>
  var $j = jQuery.noConflict();
</script>
<script>
   $j(document).ready(function () {
    $j('#registrationForm').validate({
    rules: {
      first_name: { required: true, minlength: 2 },
      last_name: { required: true, minlength: 2 },
      email: { required: true, email: true },
      password: { required: true, minlength: 6 },
      password_confirmation: { required: true, minlength: 6, equalTo: "#password" },
      city_id: { required: true,  }
      
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
    
    },
      submitHandler: function(form) {
      console.log("Validation passed, submitting form");
      var formData = new FormData(form);
      var email = $j('#email').val();
      formData.append('email', email);
      $j.ajax({
        url: "{{ route('business.register') }}",
        type: "POST",
        data: formData,
        processData: false,
        contentType: false,
        success: function(response) {
          if (response.success) {
            $j('#responseMessage')
              .html('<div class="alert alert-success">' + response.message + '</div>');
              window.location.href = response.redirect;
            form.reset();
          } else {
            $j('#responseMessage')
              .html('<div class="alert alert-danger">' + response.message + '</div>');
          }
          
        },
        error: function(xhr) {
           let res = xhr.responseJSON;
          if (res && res.errors) {
            let messages = Object.values(res.errors).map(e => e[0]).join("<br>");
            $j('#responseMessage')
              .html('<div class="alert alert-danger">' + messages + '</div>');
          } else {
            $j('#responseMessage')
              .html('<div class="alert alert-danger">An unexpected error occurred.</div>');
          }
           errorClass: "error"
        }
       
      });

      return false;
    }
  });
});
</script>

        <script>
          document.addEventListener("DOMContentLoaded", function () {
              const userTimezone = Intl.DateTimeFormat().resolvedOptions().timeZone;
              document.getElementById("user_timezone").value = userTimezone;
          });

           document.getElementById('companyType').addEventListener('change', function () {
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

