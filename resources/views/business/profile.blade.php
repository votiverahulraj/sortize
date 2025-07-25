@extends('business.layouts.layout')

@section('content')
    <style>
        .error {
            color: red;
            font-size: 14px;
        }
    </style>
    <!-- partial -->
    <div class="main-panel">
        <div class="content-wrapper">
            <div class="row">
                <div id="responseMessage"></div>
                <div class="col-md-12 grid-margin stretch-card">
                    <?php
                    $company_type = $first_name = $last_name = $email = $contact_number = $c_name = $Website_link = $city_id = $user_id = $password = '';
                    
                    if ($userDetail) {
                        $user_id = $userDetail->id;
                        $company_type = $userDetail->company_type;
                        $first_name = $userDetail->first_name;
                        $last_name = $userDetail->last_name;
                        $email = $userDetail->email;
                        $contact_number = $userDetail->contact_number;
                        $c_name = $userDetail->c_name;
                        $Website_link = $userDetail->Website_link;
                        $city_id = $userDetail->city_id;
                        $password = $userDetail->password;
                        $is_verified = $userDetail->is_verified;
                    }
                    
                    ?>
                    <div class="card">
                        <div class="card-body">
                            <a href="{{ route('admin.interpriseList') }}" class="btn btn-outline-info btn-fw"
                                style="float: right;">Back</a>
                            <h4 class="card-title">Interprise Management</h4>

                            <div class="tab-content">
                                <div class="tab-pane active" id="home" role="tabpanel" aria-labelledby="home-tab">
                                    <form class="forms-sample" action="{{ route('admin.addInerprise') }}" method="POST"
                                        id="interprise" enctype="multipart/form-data">
                                        {!! csrf_field() !!}
                                        <div class="row">
                                            @php
                                                $selectedCompanyType = old(
                                                    'company_type',
                                                    $userDetail->company_type ?? ($company_type ?? ''),
                                                );
                                            @endphp

                                            <div class="row">
                                                <div class="form-group col-md-2">

                                                    <img id="profilePreview"
                                                        src="http://localhost/sortize/public/admin_assets/images/faces/face28.jpg"
                                                        alt="Profile Picture" width="100" class="mb-2">


                                                    <!-- File input -->
                                                    <input type="file" class="form-control form-control-sm"
                                                        name="profile_picture" id="profile_picture" accept="image/*"
                                                        onchange="previewProfilePicture(event)">

                                                    @error('profile_picture')
                                                        <small class="text-danger">{{ $message }}</small>
                                                    @enderror
                                                </div>
                                            </div>

                                            <div class="form-group col-md-6">
                                                <label style="width: 250px;" class="mb-0 mr-2">First Name</label>
                                                <input type="hidden" name="user_id" value="{{ $user_id }}">
                                                <input type="text" class="form-control form-control-sm"
                                                    autocomplete="off" name="first_name" id="first_name"
                                                    value="{{ $first_name == '' ? old('first_name') : $first_name }}">
                                                @error('first_name')
                                                    <small class="text-danger">{{ $message }}</small>
                                                @enderror
                                            </div>

                                            <!-- Last Name -->
                                            <div class="form-group col-md-6">
                                                <label style="width: 250px;" class="mb-0 mr-2">Last Name</label>
                                                <input type="text" class="form-control form-control-sm" name="last_name"
                                                    autocomplete="off" id="last_name"
                                                    value="{{ $last_name == '' ? old('last_name') : $last_name }}">
                                                @error('last_name')
                                                    <small class="text-danger">{{ $message }}</small>
                                                @enderror
                                            </div>

                                            <!-- Email -->
                                            <div class="form-group col-md-6">
                                                <label style="width: 250px;" class="mb-0 mr-2">Email Address</label>
                                                <input type="email" class="form-control form-control-sm" name="email"
                                                    autocomplete="off" id="email"
                                                    value="{{ $email == '' ? old('email') : $email }}">
                                                @error('email')
                                                    <small class="text-danger">{{ $message }}</small>
                                                @enderror
                                            </div>

                                            <!-- Contact Number -->
                                            <div class="form-group col-md-6">
                                                <label style="width: 250px;" class="mb-0 mr-2">Contact Number</label>
                                                <input type="number" class="form-control form-control-sm"
                                                    name="contact_number" id="contact_number"
                                                    value="{{ $contact_number == '' ? old('contact_number') : $contact_number }}">
                                                @error('contact_number')
                                                    <small class="text-danger">{{ $message }}</small>
                                                @enderror
                                            </div>

                                            <!-- Password -->
                                            @if ($user_id == '')
                                                <div class="form-group col-md-6">
                                                    <label style="width: 250px;" class="mb-0 mr-2">Password</label>
                                                    <input type="password" class="form-control form-control-sm"
                                                        name="password" id="password">
                                                    @error('password')
                                                        <small class="text-danger">{{ $message }}</small>
                                                    @enderror
                                                </div>

                                                <!--  Confirm Password -->
                                                <div class="form-group col-md-6">
                                                    <label style="width: 250px;" class="mb-0 mr-2">Confirm Password</label>
                                                    <input type="password" class="form-control form-control-sm"
                                                        name="password_confirmation" id="password_confirmation">
                                                </div>
                                            @endif

                                            <!-- Website Link -->
                                            <div class="form-group col-md-6">
                                                <label style="width: 250px;" class="mb-0 mr-2">Website Link
                                                    (Optional)</label>
                                                <input type="text" class="form-control form-control-sm"
                                                    name="Website_link" value="{{ $Website_link }}">
                                            </div>

                                            <!-- City -->
                                            <div class="form-group col-md-6">
                                                <label style="width: 250px;" class="mb-0 mr-2">City (Activity
                                                    Location)</label>
                                                <input type="text" class="form-control form-control-sm" name="city_id"
                                                    id="city_id" value="{{ $city_id }}">
                                            </div>
                                        </div>
                                        <input type="hidden" name="user_time" value="" id="user_timezone">
                                        <button type="submit" class="btn btn-primary me-2">Save</button>
                                    </form>
                                </div>


                                <div class="tab-pane" id="messages" role="tabpanel" aria-labelledby="messages-tab">
                                    Thired</div>
                                <div class="tab-pane" id="settings" role="tabpanel" aria-labelledby="settings-tab">
                                    Fourth</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- content-wrapper ends -->
    </div>
    <!-- main-panel ends -->
@endsection

@push('scripts')
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

        function previewProfilePicture(event) {
            const reader = new FileReader();
            reader.onload = function() {
                const output = document.getElementById('profilePreview');
                output.src = reader.result;
            };
            reader.readAsDataURL(event.target.files[0]);
        }
    </script>
@endpush
