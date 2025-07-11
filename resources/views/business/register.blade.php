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
               <div class=" text-center align-items-center">
  <h4 class="font-weight-light">Interprise Register.</h4>
</div>
                <form class="reg_form" method="post" action="{{ route('business.register') }}" enctype="multipart/form-data">
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
		<input type="email" class="form-control form-control-sm" name="email" required>
	  </div>
	  
	   <!-- Password -->
	  <div class="form-group">
		<label style="width: 250px;" class="mb-0 mr-2">Password</label>
		<input type="password" class="form-control form-control-sm" name="password" required>
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
		<input type="password" class="form-control form-control-sm" name="password_confirmation" required>
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
<script src="{{ url('/public') }}/admin_assets/vendors/select2/select2.min.js"></script>
 <script src="{{ url('/public') }}/admin_assets/js/select2.js"></script>
<script>
  $(document).ready(function() {
    $('.js-example-basic-multiple').select2({
      placeholder: "Select services"
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
          $(document).ready(function () {
            $(document).on('change', '#country', function () {
              var cid = this.value; 

           //   alert(cid)  //let cid = $(this).val(); we cal also write this.
              $.ajax({
                url: "{{url('/getstate')}}",
                type: "POST",
                datatype: "json",
                data: {
                  country_id: cid,
                  '_token':'{{csrf_token()}}'
                },
                success: function(result) {
                  $('#state').html('<option value="">Select State</option>');
                  $.each(result.state, function(key, value) {
                    $('#state').append('<option value="' +value.state_id+ '">' +value.state_name+ '</option>');
                  });
                },
                errror: function(xhr) {
                    console.log(xhr.responseText);
                  }
                });
            });

            $('#state').change(function () {
              var sid = this.value;
              $.ajax({
                url: "{{url('/getcity')}}",
                type: "POST",
                datatype: "json",
                data: {
                  state_id: sid,
                  '_token':'{{csrf_token()}}'
                },
                success: function(result) {
                  console.log(result);
                  $('#city').html('<option value="">Select City</option>');
                  $.each(result.city, function(key, value) {
                    $('#city').append('<option value="' +value.city_id+ '">' +value.city_name+ '</option>')
                  });
                },
                errror: function(xhr) {
                    console.log(xhr.responseText);
                  }
              });
            });

            $('#coach_type').change(function () {
              var sid = this.value;
            //  alert(sid)
              $.ajax({
                url: "{{url('/getsubType')}}",
                type: "POST",
                datatype: "json",
                data: {
                  coach_type_id: sid,
                  '_token':'{{csrf_token()}}'
                },
                success: function(result) {
                  console.log(result);
                  $('#coach_subtype').html('<option value="">Select SubType</option>');
                  $.each(result.city, function(key, value) {
                    $('#coach_subtype').append('<option value="' +value.id+ '">' +value.subtype_name+ '</option>')
                  });
                },
                errror: function(xhr) {
                    console.log(xhr.responseText);
                  }
              });
            });
          });
        </script>
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                const bio = document.getElementById('short_bio');
                const counter = document.getElementById('bioCounter');
                const max = 300;

                function updateCounter() {
                    const remaining = max - bio.value.length;
                    counter.textContent = `${remaining} characters remaining`;
                }

                bio.addEventListener('input', updateCounter);
                updateCounter(); // initial update
            });
        </script>
        <script>
          document.addEventListener('DOMContentLoaded', function () {
              const select = document.querySelector('select[name="is_volunteered_coach"]');
              const volCoachDiv = document.getElementById('vol_coach');

              function toggleVolCoach() {
                  if (select.value === '1') {
                      volCoachDiv.style.display = 'block';
                  } else {
                      volCoachDiv.style.display = 'none';
                  }
              }

              // Run on page load
              toggleVolCoach();

              // Run when the select changes
              select.addEventListener('change', toggleVolCoach);
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

