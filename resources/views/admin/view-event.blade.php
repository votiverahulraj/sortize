@extends('admin.layouts.layout')

@section('content')
        <!-- partial -->
        <div class="main-panel">
          <div class="content-wrapper">
            <div class="row">
              <div class="col-md-12 grid-margin stretch-card">
               <?php
                 $start_date=$end_date=$event_name=$event_type=$address=$ticket_price=$ticket_quantity=$event_days=$start_time=$end_time=$duration=$gap=$event_limit=$description=$date_time=$media=$price="";
                  $event_id="";
                
                  if(!empty($eventdetails))
                  {
                    $event_id=$eventdetails->id;
                    $event_name=$eventdetails->event_name;
                    $event_type=$eventdetails->event_type;
                    $address=$eventdetails->address;
                    $price=$eventdetails->price;
                    $ticket_price=$eventdetails->ticket_price;
                    $ticket_quantity=$eventdetails->ticket_quantity;
                    $event_days=$eventdetails->event_days;
                    $start_time=$eventdetails->start_time;
                    $end_time=$eventdetails->end_time;
                    $duration=$eventdetails->duration;
                    $gap=$eventdetails->gap;
                    $event_limit=$eventdetails->event_limit;
                    $description=$eventdetails->description;
                    $date_time=$eventdetails->date_time;
                    $media=$eventdetails->media;
                     $start_date=$eventdetails->start_date;
                    $end_date=$eventdetails->end_date;
                   
                  }
                ?>
                <div class="card">
                  <div class="card-body">
                      <a href="{{route('admin.event-list')}}" class="btn btn-outline-info btn-fw" style="float: right;">Event List</a>
                      <h4 class="card-title">Event Management</h4>
                      <!--p class="card-description"> Add / Update Blog  </p-->

                    <!-- Nav tabs -->
                    <ul class="nav nav-tabs" id="myTab" role="tablist">
                      <li class="nav-item" role="presentation">
                        <button class="nav-link active" id="home-tab" data-bs-toggle="tab" data-bs-target="#home" type="button" role="tab" aria-controls="home" aria-selected="true">Events</button>
                      </li>
                      <li class="nav-item" role="presentation">
                        <button class="nav-link" id="messages-tab" data-bs-toggle="tab" data-bs-target="#messages" type="button" role="tab" aria-controls="messages" aria-selected="false">Booking</button>
                      </li>
                     
                    </ul>

                    <div class="tab-content">
                       @if($event_limit == '0')
                      <div class="tab-pane active" id="home" role="tabpanel" aria-labelledby="home-tab">
                          <div class="row">
                            <div class="form-group col-md-6">
                              <input type="hidden" name="event_id" value="{{$event_id}}">
                              <label for="exampleInputUsername1"><strong>Event Name : </strong> {{$event_name}}</label>
                            </div>
                            @php
                          $eventTypeLabels = [
                              0 => 'Sports',
                              1 => 'Music',
                              2 => 'Arts',
                              3 => 'Conferences',
                              4 => 'Fashion shows',
                              5 => 'Festivals',
                          ];
                      @endphp
                            <div class="form-group col-md-6">
                             <label for="exampleInputUsername1">
                              <strong>Event Type :</strong>
                              {{ $eventTypeLabels[$event_type] ?? 'N/A' }}
                          </label>
                            </div>
                            <div class="form-group col-md-6">
                              <label for="exampleInputEmail1"><strong>Select Date & Time : </strong>{{$date_time}}</label>
                            </div>

                             <div class="form-group col-md-6">
                              <label for="exampleInputEmail1"><strong>Select Address: </strong>{{$address}}</label>
                            </div>
                            <div class="form-group col-md-6">
                              <label for="exampleInputEmail1"><strong>Ticket Price : </strong> $ {{$price}}</label>
                            </div> 
                        <!-- @php
                            $days = is_string($event_days) ? json_decode($event_days, true) : $event_days;
                            $days = is_array($days) ? $days : [];
                        @endphp
                        <div class="form-group col-md-6">
                        <label for="exampleInputEmail1">
                            <strong>Select Event Days :</strong> {{ implode(', ', $days) }}
                        </label>
                        </div> -->
                            <div class="form-group col-md-6">
                              <label for="exampleInputEmail1"><strong>No. of Tickets : </strong> {{$ticket_quantity}}</label>
                              
                            </div>
                           <!--  <div class="form-group col-md-6">
                              <label for="exampleInputEmail1"><strong>Price per Ticket (₹) : </strong> $ {{$ticket_price}}</label>
                            </div> -->

                            <div class="form-group col-md-6">
                              <label for="exampleInputEmail1"><strong>Start Date: </strong>{{$start_date}}</label>
                            </div>
                            <div class="form-group col-md-6">
                              <label for="exampleInputEmail1"><strong>End Date : </strong> {{$end_date}}</label>
                            </div>
                             <div class="form-group col-md-6">
                              <label for="exampleInputEmail1"><strong>Start Time: </strong>{{$start_time}}</label>
                            </div>
                            <div class="form-group col-md-6">
                              <label for="exampleInputEmail1"><strong>End Time : </strong> {{$end_time}}</label>
                            </div>
                            <!-- <div class="form-group col-md-6">
                              <label for="exampleInputEmail1"><strong>Event Duration : </strong> {{$duration}} Minute</label>
                              
                            </div>
                            <div class="form-group col-md-6">
                              <label for="exampleInputEmail1"><strong>Gap Between Events (in minutes, optional) : </strong> {{$gap}}</label>
                              
                            </div> -->
                           <!--  <div class="form-group col-md-6">
                              <label for="exampleInputEmail1">
                              <strong>Limit Events per Day:</strong>
                              {{ $event_limit == 0 ? 'Only one event per day' : 'Multiple events per day' }}
                          </label>
                              
                            </div> -->

                            <!-- <div class="form-group col-md-6">
                              <label for="exampleInputEmail1"><strong>Attach Media : </strong></label>
                              @if(!empty($media))
                              <img src="{{ asset('public/' . $media)}}" style="max-width: 100px;max-height: 100px;">
                              @endif
                              
                            </div> -->
                            <div class="form-group col-md-6">
                              <label for="exampleInputEmail1"><strong>Photos : </strong></label>
                            @if (!$eventgallery->isEmpty())
    <div class="mt-2">
    
        @foreach ($eventgallery as $gallery)
            <img src="{{ asset('public/' . $gallery->event_media) }}" alt="Media" class="img-thumbnail m-2" style="max-width: 150px;">
        @endforeach
    </div>
@endif
                              
 </div>

<!-- @if(isset($eventslot) && count($eventslot))
    <div class="row mb-3">
        <div class="col-md-6">
              <label for="exampleInputEmail1"><strong>Generated Slots: </strong></label> 
            <ul class="list-group">
                @foreach($eventslot as $slot)
                    <li class="list-group-item">
                        {{ $slot->slot_start }} - {{ $slot->slot_end }}
                    </li>
                @endforeach
            </ul>
        </div>
    </div>
@endif -->
                          </div>
                      </div>
            @else
                       <div class="tab-pane active" id="home" role="tabpanel" aria-labelledby="home-tab">
                          <div class="row">
                            <div class="form-group col-md-6">
                              <input type="hidden" name="event_id" value="{{$event_id}}">
                              <label for="exampleInputUsername1"><strong>Event Name : </strong> {{$event_name}}</label>
                            </div>
                            @php
                          $eventTypeLabels = [
                              0 => 'Sports',
                              1 => 'Music',
                              2 => 'Arts',
                              3 => 'Conferences',
                              4 => 'Fashion shows',
                              5 => 'Festivals',
                          ];
                      @endphp
                            <div class="form-group col-md-6">
                             <label for="exampleInputUsername1">
                              <strong>Event Type :</strong>
                              {{ $eventTypeLabels[$event_type] ?? 'N/A' }}
                          </label>
                            </div>
                           <!--  <div class="form-group col-md-6">
                              <label for="exampleInputEmail1"><strong>Select Date & Time : </strong>{{$date_time}}</label>
                            </div> -->

                             <div class="form-group col-md-6">
                              <label for="exampleInputEmail1"><strong>Select Address: </strong>{{$address}}</label>
                            </div>
                            <div class="form-group col-md-6">
                              <label for="exampleInputEmail1"><strong>Ticket Price : </strong> $ {{$price}}</label>
                            </div>
                        @php
                            $days = is_string($event_days) ? json_decode($event_days, true) : $event_days;
                            $days = is_array($days) ? $days : [];
                        @endphp
                        <div class="form-group col-md-6">
                        <label for="exampleInputEmail1">
                            <strong>Select Event Days :</strong> {{ implode(', ', $days) }}
                        </label>
                        </div>
                            <div class="form-group col-md-6">
                              <label for="exampleInputEmail1"><strong>No. of Tickets : </strong> {{$ticket_quantity}}</label>
                              
                            </div>
                            <div class="form-group col-md-6">
                              <label for="exampleInputEmail1"><strong>Start Date: </strong>{{$start_date}}</label>
                            </div>
                            <div class="form-group col-md-6">
                              <label for="exampleInputEmail1"><strong>End Date : </strong> {{$end_date}}</label>
                            </div>
                             <div class="form-group col-md-6">
                              <label for="exampleInputEmail1"><strong>Start Time: </strong>{{$start_time}}</label>
                            </div>
                            <div class="form-group col-md-6">
                              <label for="exampleInputEmail1"><strong>End Time : </strong> {{$end_time}}</label>
                            </div>
                            <div class="form-group col-md-6">
                              <label for="exampleInputEmail1"><strong>Event Duration : </strong> {{$duration}} Minute</label>
                              
                            </div>
                            <div class="form-group col-md-6">
                              <label for="exampleInputEmail1"><strong>Gap Between Events (in minutes, optional) : </strong> {{$gap}}</label>
                              
                            </div>
                            <div class="form-group col-md-6">
                              <label for="exampleInputEmail1">
                              <strong>Limit Events per Day:</strong>
                              {{ $event_limit == 0 ? 'Only one event per day' : 'Multiple events per day' }}
                          </label>
                              
                            </div>

                            <!-- <div class="form-group col-md-6">
                              <label for="exampleInputEmail1"><strong>Attach Media : </strong></label>
                              @if(!empty($media))
                              <img src="{{ asset('public/' . $media)}}" style="max-width: 100px;max-height: 100px;">
                              @endif
                              
                            </div> -->
                            <div class="form-group col-md-6">
                              <label for="exampleInputEmail1"><strong>Photos : </strong></label>
                            @if (!$eventgallery->isEmpty())
    <div class="mt-2">
    
        @foreach ($eventgallery as $gallery)
            <img src="{{ asset('public/' . $gallery->event_media) }}" alt="Media" class="img-thumbnail m-2" style="max-width: 150px;">
        @endforeach
    </div>
@endif
                              
 </div>

@if(isset($eventslot) && count($eventslot))
    <div class="row mb-3">
        <div class="col-md-6">
              <label for="exampleInputEmail1"><strong>Generated Slots: </strong></label> 
            <ul class="list-group">
                @foreach($eventslot as $slot)
                    <li class="list-group-item">
                        {{ $slot->slot_start }} - {{ $slot->slot_end }}
                    </li>
                @endforeach
            </ul>
        </div>
    </div>
@endif
                          </div>
                      </div>
                      @endif
                      
                      
                      
                      <div class="tab-pane" id="profile" role="tabpanel" aria-labelledby="profile-tab">
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
                                <th> Contact Number </th>
                                <th> Enquiry </th>
                                 <th> Status </th>
                                <th> Action</th>
                              </tr>
                            </thead>
                            <tbody>

                            <tr>
                              <td></td>
                              <td></td>
                              <td>  </td>
                              <td>  </td>
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