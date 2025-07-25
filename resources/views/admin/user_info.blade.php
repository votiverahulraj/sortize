@extends('admin.layouts.layout')

@section('content')

<div class="main-panel">
          <div class="content-wrapper">
            <div class="row">
              <div class="col-md-12 grid-margin stretch-card">
               <?php
                if (isset($bookingInfo)) {
                    $user = $bookingInfo->user;
                    $event = $bookingInfo->event;
                    $slot = $bookingInfo->slot;

                    $username = $user->first_name . ' ' . $user->last_name;
                    $email = $user->email;
                    $contact_number = $user->contact_number;
                    $gender = $user->gender;
                    $country = $user->country->country_name ?? '';
                    $state = $user->state->state_name ?? '';
                    $city = $user->city->city_name ?? '';

                    $event_name = $event->event_name ?? '';
                    $event_address = $event->address ?? '';
                    $event_days = $event->event_days ?? '';
                    $event_start_date = \Carbon\Carbon::parse($event->start_date)->format('d M Y');
                    $event_end_date = \Carbon\Carbon::parse($event->end_date)->format('d M Y');
                    $event_description = $event->description ?? '';

                    $slot_date = \Carbon\Carbon::parse($slot->date)->format('d M Y');
                    $slot_start_time = \Carbon\Carbon::parse($slot->start_time)->format('h:i A');
                    $slot_end_time = \Carbon\Carbon::parse($slot->end_time)->format('h:i A');

                    $ticket_qty = $bookingInfo->ticket_quantity;
                    $total_price = $bookingInfo->total_price;
                    $booked_at = \Carbon\Carbon::parse($bookingInfo->booked_at)->format('d M Y');
                }
                ?>


                <div class="card">
                  <div class="card-body">
                      <a href="{{route('admin.booking-list')}}" class="btn btn-outline-info btn-fw btn-sm" style="float: right;"><i class="fa fa-mail-reply"></i> Back</a>
                      <h4 class="card-title">Booking</h4>

                    <!-- Nav tabs -->
                    <ul class="nav nav-tabs" id="myTab" role="tablist">
                      <li class="nav-item" role="presentation">
                        <button class="nav-link active" id="home-tab" data-bs-toggle="tab" data-bs-target="#home" type="button" role="tab" aria-controls="home" aria-selected="true">Basic Profile</button>
                      </li>

                    </ul>

                    <!-- Tab panes -->
                    <div class="tab-content">
                      <div class="tab-pane active" id="home" role="tabpanel" aria-labelledby="home-tab">
                          <div class="row">
                            <div class="form-group col-md-6">

                              <label for="exampleInputUsername1"><strong>User Name : </strong> {{ $username }} </label>
                            </div>

                            <div class="form-group col-md-6">
                              <input type="hidden" name="user_id" value="">
                              <label for="exampleInputUsername1"><strong>Email : </strong> {{ $email }} </label>
                            </div>

                            <div class="form-group col-md-6">
                              <input type="hidden" name="user_id" value="">
                              <label for="exampleInputUsername1"><strong>Contact Number: </strong>{{ $contact_number }}  </label>
                            </div>

                            @php
                                $genderLabels=[
                                    1=>'Male',
                                    2=>'Female',
                                    3=>'Others'
                                ];
                            @endphp
                            <div class="form-group col-md-6">
                              <input type="hidden" name="user_id" value="">
                              <label for="exampleInputUsername1"><strong>Gender : </strong> {{$genderLabels[$gender] ?? 'Not specified'}}</label>
                            </div>


                            <div class="form-group col-md-6">
                              <input type="hidden" name="user_id" value="">
                              <label for="exampleInputUsername1"><strong>City : </strong>{{  $city }} </label>
                            </div>

                            <div class="form-group col-md-6">
                              <input type="hidden" name="user_id" value="">
                              <label for="exampleInputUsername1"><strong>State : </strong>{{  $state }} </label>
                            </div>

                            <div class="form-group col-md-6">
                              <input type="hidden" name="user_id" value="">
                              <label for="exampleInputUsername1"><strong>Country : </strong> {{$country}}</label>
                            </div>


                          </div>

                          <hr>

                          <div class="row">
                             <div class="form-group col-md-6">
                              <label for="exampleInputUsername1"><strong>Event Name : </strong> {{$event_name}}</label>
                            </div>

                             <div class="form-group col-md-6">
                                {{-- @php
                                  date('Y-m-d', strtotime({{$bookingInfo->$booked_at}}));
                                @endphp --}}
                                <label for="Eventday">
                                    <strong>Event Day - Date:</strong>
                                    {{ \Carbon\Carbon::parse($bookingInfo->booked_at)->format('l - Y-m-d') }}
                                </label>

                            </div>
                             <div class="form-group col-md-6">
                              <label for="exampleInputUsername1"><strong>Event  Date : </strong> {{$slot_date}}</label>
                            </div>

                             <div class="form-group col-md-6">
                              <label for="exampleInputUsername1"><strong>Event Address : </strong> {{$event_address }}</label>
                            </div>

                            <div class="form-group col-md-6">
                              <label for="exampleInputUsername1"><strong>Event Description : </strong> {{ $event_description}}</label>
                            </div>



                            <div class="form-group col-md-6">
                              <label for="exampleInputUsername1"><strong>Ticket Quantity: </strong>{{$ticket_qty}} </label>
                            </div>

                             <div class="form-group col-md-6">
                              <label for="exampleInputUsername1"><strong>Total Price:</strong>{{$total_price}} </label>
                            </div>

                              <div class="form-group col-md-6">
                              <label for="exampleInputUsername1"><strong>Booked At: </strong> {{$booked_at}}</label>
                            </div>



                          </div>
                      </div>


                      <div class="tab-pane" id="profile" role="tabpanel" aria-labelledby="profile-tab">
                      </div>


                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <!-- content-wrapper ends -->
        </div>
@endsection
