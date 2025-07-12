@extends('business.layouts.layout')

@section('content')
 <style>
            input[type="checkbox"].form-check-input {
                width: 10px;
                height: 10px;
            }
            .form-check-label {
                margin-left: 2px;
            }
            .form-check-inline {
                margin-right: 6px;
            }
        </style>

         <?php
                  $event_name=$event_type=$address=$ticket_price=$ticket_quantity=$event_days=$start_time=$end_time=$duration=$gap=$event_limit=$description=$date_time=$media=$price="";
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
                   
                  }
                ?>

<div class="main-panel">
          <div class="content-wrapper">
            <div class="row">
              <div class="col-md-12 grid-margin">
                <div class="row">
                  <div class="col-12 col-xl-8 mb-4 mb-xl-0">
                    <h3 class="font-weight-bold">Create New Event</h3>
                  </div>
                </div>
              </div>
            </div>
            <form class="add-evnt" id="eventForm" method="POST" action="{{ route('interprise.add-event') }}" enctype="multipart/form-data">
                {!! csrf_field() !!}
                <div class="row mb-3">
                    <div class="col-md-6">
                        <div class="form-group">
                        <label for="exampleInputUsername1">Event Name</label>
                        <input type="hidden" name="event_id" value="{{$event_id}}">
                        <input type="text" class="form-control" id="exampleInputUsername1" placeholder="Type your event name" name="event_name" value="{{$event_name}}" >
                        </div>
                       
                    </div>
                    <div class="col-md-6">
                    <div class="form-group">
                        <label for="type-event">Event Type</label>
                        <select class="form-select" id="type-event" name="event_type">
                        <option  {{ $event_type === null ? 'selected' : '' }}>Choose...</option>
                        <option value="0" {{ $event_type == 0 ? 'selected' : '' }}>Sports</option>
                        <option value="1" {{ $event_type == 1 ? 'selected' : '' }}>Music</option>
                        <option value="2" {{ $event_type == 2 ? 'selected' : '' }}>Arts</option>
                        <option value="3" {{ $event_type == 3 ? 'selected' : '' }}>Conferences</option>
                        <option value="4" {{ $event_type == 4 ? 'selected' : '' }}>Fashion shows</option>
                        <option value="5" {{ $event_type == 5 ? 'selected' : '' }}>Festivals</option>
                    </select>
                        </div>
                     
                        </div> 
                </div>

                <div class="row mb-3">
                    <div class="col-md-6">
                    <div class="form-group">
                        <label for="event_datetime">Select Date & Time</label>
                        <input type="datetime-local" class="form-control" id="event_datetime" name="date_time" value="{{$date_time}}">
                    </div>

                </div>

                    <div class="col-md-6">
                        <div class="form-group">
                        <label for="exampleInputUsername1">Select Address</label>
                        <input type="text" class="form-control" id="exampleInputUsername1" placeholder="Add address here" name="address" value="{{$address}}">
                        </div>
                    </div>
                    
                </div>

                <input type="hidden" class="form-control" id="lat" name="lat" value="" readonly>
                 <input type="hidden" class="form-control" id="exampleInputUsername1" name="long" value="" readonly>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <div class="form-group">
                        <label for="exampleInputUsername1">Ticket Price</label>
                        <input type="number" class="form-control" id="exampleInputUsername1" placeholder="Enter price" name="price" value="{{$price}}">
                        </div>
                    </div>

        <div class="col-md-6">
            <div class="form-group">
                <label>Select Event Days :</label><br>
              
              @php
    $days = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'];

    $selected_days = [];

    if (isset($eventdetails) && isset($eventdetails->event_days)) {
     
        if (is_array($eventdetails->event_days)) {
            $selected_days = $eventdetails->event_days;
        }
      
        elseif (is_string($eventdetails->event_days)) {
            $decoded = json_decode($eventdetails->event_days, true);
            $selected_days = is_array($decoded) ? $decoded : [];
        }
    }
@endphp



@foreach($days as $day)
    <div class="form-check form-check-inline">
        <input class="form-check-input" type="checkbox"
               name="event_days[]"
               id="day_{{ $day }}"
               value="{{ $day }}"
               {{ in_array($day, $selected_days) ? 'checked' : '' }}>
        <label class="form-check-label" for="day_{{ $day }}">{{ $day }}</label>
    </div>
@endforeach

            </div>
        </div>
                </div>

                <div class="row mb-3">
    <div class="col-md-6">
         <div class="form-group">
        <label for="ticket_quantity">No. of Tickets</label>
        <input type="number" class="form-control" id="ticket_quantity" name="ticket_quantity" min="1" value="{{ old('ticket_quantity', $ticket_quantity ?? 1) }}">
    </div>
    </div>

    <div class="col-md-6">
         <div class="form-group">
        <label for="ticket_price">Price per Ticket (₹)</label>
        <input type="number" class="form-control" id="ticket_price" name="ticket_price" step="0.01" value="{{ old('ticket_price', $ticket_price ?? 1) }}">
    </div>
    </div>

</div>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <div class="form-group">
                        <label for="exampleInputUsername1">Start Time:</label>
                        <input type="time" class="form-control" id="exampleInputUsername1" placeholder="Choose event type" name="start_time" value="{{$start_time}}">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                        <label for="exampleInputUsername1">End Time:</label>
                        <input type="time" class="form-control" id="exampleInputUsername1" placeholder="Add address here" name="end_time" value="{{$end_time}}">
                        </div>
                    </div>
                    
                </div>

                 <div class="row mb-3">
                    <div class="col-md-6">
                        <div class="form-group">
                        <label for="exampleInputUsername1">Event Duration:</label>
                        <select name="duration" class="form-control" id="exampleInputUsername1">
    <option value="15" {{ $duration == 15 ? 'selected' : '' }}>15 minutes</option>
    <option value="30" {{ $duration == 30 ? 'selected' : '' }}>30 minutes</option>
    <option value="45" {{ $duration == 45 ? 'selected' : '' }}>45 minutes</option>
    <option value="60" {{ $duration == 60 ? 'selected' : '' }}>1 hour</option>
</select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                        <label for="exampleInputUsername1">Gap Between Events (in minutes, optional):</label>
                        <input type="number" name="gap" min="0" max="120" value="{{ old('gap', $gap ?? 1) }}" class="form-control" id="exampleInputUsername1">
                        <small>(e.g., 5 or 10 minutes — leave 0 for no gap)</small>
                        </div>
                    </div>
                    
                </div>

     <div class="row mb-3">
   <div class="col-md-6">
    <label class="form-label">Limit Events per Day:</label>
    <div class="d-flex gap-3">
        <div class="form-check">
            <input class="form-check-input" type="radio" name="event_limit" id="event_single" value="single"
                {{ $event_limit == '0' ? 'checked' : '' }}>
            <label class="form-check-label" for="event_single">
                Only one event per day
            </label>
        </div>

        <div class="form-check">
            <input class="form-check-input" type="radio" name="event_limit" id="event_multiple" value="multiple"
                {{ $event_limit == '1' ? 'checked' : '' }}>
            <label class="form-check-label" for="event_multiple">
                Multiple events per day
            </label>
        </div>
    </div>
</div>

    <div class="col-md-6">
    <div class="form-group mb-3">
  <label for="" class="form-label">Attach Media</label>
  <input type="file" class="form-control" id="inputGroupFile" name="media" >

  @if (!empty($eventdetails->media))
            <div class="mt-2">
                <label class="form-label">Previously Uploaded Media:</label><br>
                <img src="{{ asset('/public/' . $media) }}" alt="Media" class="img-thumbnail" style="max-width: 150px;">
            </div>
        @endif
  <div id="fileList" class="mt-2 text-secondary small"></div>
</div>
                    </div>

                     <div class="col-md-6">
    <div class="form-group mb-3">
  <label for="" class="form-label">Evenit Media</label>
  <input type="file" class="form-control" id="inputGroupFile" name="event_media[]" multiple>

 @if (!$eventgallery->isEmpty())
    <div class="mt-2">
        <label class="form-label">Previously Uploaded Media:</label><br>
        @foreach ($eventgallery as $gallery)
            <img src="{{ asset('public/' . $gallery->event_media) }}" alt="Media" class="img-thumbnail m-2" style="max-width: 150px;">
        @endforeach
    </div>
@endif

  <div id="fileList" class="mt-2 text-secondary small"></div>
</div>
                    </div>
</div>

            <div class="row mb-3">
                    <div class="form-group mb-3">
                        <label for="message" class="form-label">Event Description</label>
                        <textarea class="form-control" id="message" rows="5" placeholder="Type your event description..." name="description">{{$description}}</textarea>
                    </div>
                </div>

                <button type="submit" class="btn btn-primary btn-submit">PUBLISH NOW</button>
            </form>
            
        @endsection
       <!--  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="{{ url('/public') }}/js/jquery.validate.min.js"></script>

<script>
$(document).ready(function () {
    $("#eventForm").validate({
        rules: {
            event_name: {
                required: true,
                minlength: 3
            },
            event_type: {
                required: true
            },
            date_time: {
                required: true
            },
            address: {
                required: true
            },
            price: {
                required: true,
                number: true,
                min: 0
            },
            ticket_quantity: {
                required: true,
                number: true,
                min: 1
            },
            ticket_price: {
                required: true,
                number: true,
                min: 0
            },
            start_time: {
                required: true
            },
            end_time: {
                required: true
            },
            description: {
                required: true,
                minlength: 10
            }
        },
        messages: {
            event_name: {
                required: "Please enter an event name",
                minlength: "Event name must be at least 3 characters"
            },
            event_type: {
                required: "Please select an event type"
            },
            date_time: {
                required: "Please select date & time"
            },
            address: {
                required: "Please enter address"
            },
            price: {
                required: "Enter the ticket price",
                number: "Price must be a number",
                min: "Price cannot be negative"
            },
            ticket_quantity: {
                required: "Enter ticket quantity",
                number: "Quantity must be a number",
                min: "Minimum 1 ticket required"
            },
            ticket_price: {
                required: "Enter ticket price",
                number: "Must be a number",
                min: "Must be zero or more"
            },
            start_time: {
                required: "Enter start time"
            },
            end_time: {
                required: "Enter end time"
            },
            description: {
                required: "Please enter a description",
                minlength: "Minimum 10 characters required"
            }
        },
        errorElement: 'span',
        errorClass: 'text-danger',
        highlight: function (element) {
            $(element).addClass('is-invalid');
        },
        unhighlight: function (element) {
            $(element).removeClass('is-invalid');
        }
    });
});
</script> -->
