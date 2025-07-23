@extends('admin.layouts.layout')

@section('content')
        <!-- partial -->
        <div class="main-panel">
          <div class="content-wrapper">
            <div class="row">
              <div class="col-md-12 grid-margin stretch-card">
                <?php
                    $company_type = $first_name = $last_name = $email = $contact_number = $c_name = $Website_link = $city_id = $user_id = '';
                   
                    if ($user_detail) {
                        $user_id = $user_detail->id;
                        $company_type = $user_detail->company_type;
                        $first_name = $user_detail->first_name;
                        $last_name = $user_detail->last_name;
                        $email = $user_detail->email;
                        $contact_number = $user_detail->contact_number;
                        $c_name = $user_detail->c_name;
                        $Website_link = $user_detail->Website_link;
                        $city_id = $user_detail->city_id;
                        $is_verified = $user_detail->is_verified;
                    }
                   
                    ?>
                <div class="card">
                  <div class="card-body">
                      <a href="{{route('admin.interpriseList')}}" class="btn btn-outline-info btn-fw" style="float: right;">Interprise List</a>
                      <h4 class="card-title">Interprise Management</h4>
                      <!--p class="card-description"> Add / Update Blog  </p-->

                    <!-- Nav tabs -->
                    <ul class="nav nav-tabs" id="myTab" role="tablist">
                      <li class="nav-item" role="presentation">
                        <button class="nav-link active" id="home-tab" data-bs-toggle="tab" data-bs-target="#home" type="button" role="tab" aria-controls="home" aria-selected="true">Basic Profile</button>
                      </li>
                     <!--  <li class="nav-item" role="presentation">
                        <button class="nav-link" id="profile-tab" data-bs-toggle="tab" data-bs-target="#profile" type="button" role="tab" aria-controls="profile" aria-selected="false" {{$user_id==''?'disabled':''}}>Professional Profile</button>
                      </li> -->
                      <li class="nav-item" role="presentation">
                        <button class="nav-link" id="messages-tab" data-bs-toggle="tab" data-bs-target="#messages" type="button" role="tab" aria-controls="messages" aria-selected="false">Event List</button>
                      </li>
                      <li class="nav-item" role="presentation">
                        <button class="nav-link" id="settings-tab" data-bs-toggle="tab" data-bs-target="#settings" type="button" role="tab" aria-controls="settings" aria-selected="false">Subscription</button>
                      </li>
                    </ul>

                    <!-- Tab panes -->
                    <div class="tab-content">
                      <div class="tab-pane active" id="home" role="tabpanel" aria-labelledby="home-tab">
                          <div class="row">
                            <div class="form-group col-md-6">
                             
                              <label for="exampleInputUsername1"><strong>Type of Company : </strong> {{$company_type == '2' ? 'Legal Entity' : 'Individual'}}</label>
                            </div>
                            @if($company_type == '2')
                            <div class="form-group col-md-6">
                              <label for="exampleInputUsername1"><strong>Commercial Name (Legal Entity) : </strong>{{$c_name}}</label>
                            </div>
                            @endif
                            <div class="form-group col-md-6">
                              <input type="hidden" name="user_id" value="{{$user_id}}">
                              <label for="exampleInputUsername1"><strong>First Name : </strong> {{$first_name}}</label>
                            </div>
                            <div class="form-group col-md-6">
                              <label for="exampleInputUsername1"><strong>Second Name : </strong>{{$last_name}}</label>
                            </div>
                            <div class="form-group col-md-6">
                              <label for="exampleInputEmail1"><strong>Email address : </strong>{{$email}}</label>
                            </div>

                              <div class="form-group col-md-6">
                              <label for="exampleInputEmail1"><strong>Contact Number: </strong>{{$contact_number}}</label>
                            </div>
                            
                            <div class="form-group col-md-6">
                              <label for="exampleInputEmail1"><strong>City : </strong> {{$city_id}}</label>
                              
                            </div>
                             <div class="form-group col-md-6">
                              <label for="exampleInputEmail1"><strong>Website link : </strong> {{$Website_link}}</label>
                              
                            </div>
                           
                          </div>
                      </div>
                      
                      <div class="tab-pane" id="messages" role="tabpanel" aria-labelledby="messages-tab">
                        <div class="table-responsive">
                          <table class="table table-striped" id="example">
                            <thead>
                              <tr>
                                <th> <input type="checkbox" name="ids[]" value="" class="selectBox"> </th>
                                <th> Sr no </th>
                                <th> First name </th>
                                <th> Last name </th>
                                <th> Email </th>
                                <th> Contact Number</th>
                                <th> Enquiry </th>
                                <th> Status </th>
                                <th> Action</th>
                              </tr>
                            </thead>
                            <tbody>
                            
                            <tr>
                              <td><input type="checkbox" name="ids[]" value="" class="selectBox"></td>
                              <td></td>
                              <td>  </td>
                              <td> </td>
                              <td>  </td>
                              <td>  </td>
                              <td>  </td>
                               <td>
                              </td>
                                <td>  
                            
                              </td>
                            </tr>
                          
                            </tbody>
                          </table>
                        </div>
                      </div>

                      <div class="tab-pane" id="settings" role="tabpanel" aria-labelledby="settings-tab">
                        <div class="table-responsive">
                          <table class="table table-striped" id="example">
                            <thead>
                              <tr>
                                <th> Sr no </th>
                                <th> Plan name </th>
                                <th> Amount </th>
                                <th> Plan Duration </th>
                                <th> Start Date </th>
                                <th> End Date</th>
                              </tr>
                            </thead>
                            <tbody>
                              
                            </tbody>
                          </table>
                        </div>
                      </div>
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
            var triggerTabList = [].slice.call(document.querySelectorAll('#myTab a'))
            triggerTabList.forEach(function (triggerEl) {
              var tabTrigger = new bootstrap.Tab(triggerEl)

              triggerEl.addEventListener('click', function (event) {
                event.preventDefault()
                tabTrigger.show()
              })
            })

              $(document).ready(function () {
            $(document).on('change','.enquiry_status',function(){
              var status=$(this).val();
              var user_id=$(this).attr('user');
              $.ajax({
                url: "{{url('/admin/enquiry_status')}}",
                type: "POST",
                datatype: "json",
                data: {
                  status: status,
                  user:user_id,
                  '_token':'{{csrf_token()}}'
                },
                success: function(result) {
                  Swal.fire({
                    title: "Success!",
                    text: "Status updated!",
                    icon: "success"
                  });
                },
                errror: function(xhr) {
                    console.log(xhr.responseText);
                  }
                });
            });

            $(document).on('click','.del_user',function(){
              const button = $(this);

              const swalWithBootstrapButtons = Swal.mixin({
                customClass: {
                  confirmButton: "btn btn-success",
                  cancelButton: "btn btn-danger"
                },
                buttonsStyling: false
              });
              swalWithBootstrapButtons.fire({
                title: "Are you sure?",
                text: "You won't be able to revert this!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonText: "Yes, delete it!",
                cancelButtonText: "No, cancel!",
                reverseButtons: true
              }).then((result) => {
                if (result.isConfirmed) {

                  var user_id=$(this).attr('user_id');
                  $.ajax({
                    url: "{{url('/admin/delete_user')}}",
                    type: "POST",
                    datatype: "json",
                    data: {
                      user:user_id,
                      '_token':'{{csrf_token()}}'
                    },
                    success: function(result) {
                      
                      swalWithBootstrapButtons.fire({
                        title: "Deleted!",
                        text: "User has been deleted.",
                        icon: "success"
                      });
                      button.closest('tr').remove();
                    },
                    errror: function(xhr) {
                        console.log(xhr.responseText);
                      }
                    });
                } else if (
                  /* Read more about handling dismissals below */
                  result.dismiss === Swal.DismissReason.cancel
                ) {
                  swalWithBootstrapButtons.fire({
                    title: "Cancelled",
                    text: "Your user is safe :)",
                    icon: "error"
                  });
                }
              });
            });
          });
          </script>
        @endpush