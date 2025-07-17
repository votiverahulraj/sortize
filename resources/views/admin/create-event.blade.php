@extends('admin.layouts.layout')

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
                  $event_name=$event_type=$address=$ticket_price=$ticket_quantity=$event_days=$start_time=$end_time=$duration=$gap=$event_limit=$description=$date_time=$media=$price=$start_date=$end_date="";
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
                      $start_date=$eventdetails->start_date;
                    $end_date=$eventdetails->end_date;
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

          @if(empty($event_id))
<select id="eventTypeDropdown" class="form-select" name="event_limit">
    <option value="">Select Event Type</option>
    <option value="0">Only One Event</option>
    <option value="1">Recurrent Event</option>
</select>
@endif
<div id="oneEventFields" style="display: {{ old('event_limit', $event_limit ?? '') == '0' ? 'block' : 'none' }}; margin-top: 15px;">
    <p><strong>Only One Event Fields:</strong></p>

     <form class="add-evnt" id="eventForm" method="POST" action="{{ route('admin.createEvent') }}" enctype="multipart/form-data">
                {!! csrf_field() !!}

                <input type="hidden" name="event_limit" id="eventLimitOne" value="0">
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
        <label for="start_date">Start Date</label>
        <input type="date" class="form-control" id="start_date" name="start_date" value="{{ old('start_date', $start_date ?? '') }}">
    </div>
</div>

<div class="col-md-6">
    <div class="form-group">
        <label for="end_date">End Date</label>
        <input type="date" class="form-control" id="end_date" name="end_date" value="{{ old('end_date', $end_date ?? '') }}">
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
                        <label for="exampleInputUsername1">Select Address</label>
                        <input type="text" class="form-control" id="exampleInputUsername1" placeholder="Add address here" name="address" value="{{$address}}">
                        </div>
                    </div> 
                    <div class="col-md-6">
                        <div class="form-group">
                        <label for="exampleInputUsername1">Ticket Price</label>
                        <input type="number" class="form-control" id="exampleInputUsername1" placeholder="Enter price" name="price" value="{{$price}}">
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
    <div class="form-group mb-3">
  <label for="" class="form-label">Photos</label>
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
   
</div>

<div id="recurrentEventFields" style="display: {{ old('event_limit', $event_limit ?? '') == '1' ? 'block' : 'none' }}; margin-top: 15px;">
    <p><strong>Recurrent Event Fields:</strong></p>

     <form class="add-evnt" id="eventForm" method="POST" action="{{ route('admin.createEvent') }}" enctype="multipart/form-data">
                {!! csrf_field() !!}
               <input type="hidden" name="event_limit" id="eventLimitRecurring" value="1">
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
                        <label for="exampleInputUsername1">Select Address</label>
                        <input type="text" class="form-control" id="exampleInputUsername1" placeholder="Add address here" name="address" value="{{$address}}">
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
        <label for="start_date">Start Date</label>
        <input type="date" class="form-control" id="start_date" name="start_date" value="{{ old('start_date', $start_date ?? '') }}">
    </div>
</div>

<div class="col-md-6">
    <div class="form-group">
        <label for="end_date">End Date</label>
        <input type="date" class="form-control" id="end_date" name="end_date" value="{{ old('end_date', $end_date ?? '') }}">
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
    <option value="5" {{ $duration == 5 ? 'selected' : '' }}>5 minutes</option>
<option value="10" {{ $duration == 10 ? 'selected' : '' }}>10 minutes</option>
<option value="15" {{ $duration == 15 ? 'selected' : '' }}>15 minutes</option>
<option value="20" {{ $duration == 20 ? 'selected' : '' }}>20 minutes</option>
<option value="25" {{ $duration == 25 ? 'selected' : '' }}>25 minutes</option>
<option value="30" {{ $duration == 30 ? 'selected' : '' }}>30 minutes</option>
<option value="35" {{ $duration == 35 ? 'selected' : '' }}>35 minutes</option>
<option value="40" {{ $duration == 40 ? 'selected' : '' }}>40 minutes</option>
<option value="45" {{ $duration == 45 ? 'selected' : '' }}>45 minutes</option>
<option value="50" {{ $duration == 50 ? 'selected' : '' }}>50 minutes</option>
<option value="55" {{ $duration == 55 ? 'selected' : '' }}>55 minutes</option>
<option value="60" {{ $duration == 60 ? 'selected' : '' }}>1 hour</option>
<option value="120" {{ $duration == 120 ? 'selected' : '' }}>2 hours</option>
<option value="180" {{ $duration == 180 ? 'selected' : '' }}>3 hours</option>
<option value="240" {{ $duration == 240 ? 'selected' : '' }}>4 hours</option>
<option value="300" {{ $duration == 300 ? 'selected' : '' }}>5 hours</option>
<option value="360" {{ $duration == 360 ? 'selected' : '' }}>6 hours</option>
<option value="420" {{ $duration == 420 ? 'selected' : '' }}>7 hours</option>
<option value="480" {{ $duration == 480 ? 'selected' : '' }}>8 hours</option>
<option value="540" {{ $duration == 540 ? 'selected' : '' }}>9 hours</option>
<option value="600" {{ $duration == 600 ? 'selected' : '' }}>10 hours</option>

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
                        <div class="form-group">
                        <label for="exampleInputUsername1">Ticket Price</label>
                        <input type="number" class="form-control" id="exampleInputUsername1" placeholder="Enter price" name="price" value="{{$price}}">
                        </div>
                    </div>

    <div class="col-md-6">
         <div class="form-group">
        <label for="ticket_quantity">No. of Tickets</label>
        <input type="number" class="form-control" id="ticket_quantity" name="ticket_quantity" min="1" value="{{ old('ticket_quantity', $ticket_quantity ?? 1) }}">
    </div>
    </div>

</div>

              

     <div class="row mb-3">

    <div class="col-md-6">
    <div class="form-group mb-3">
  <label for="" class="form-label">Photos</label>
  <input type="file" class="form-control" id="inputGroupFile" name="event_media[]" multiple accept="image/*">

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
   
</div>
<script>
document.addEventListener('DOMContentLoaded', function () {
    const dropdown = document.getElementById('eventTypeDropdown');
    const oneEventDiv = document.getElementById('oneEventFields');
    const recurrentDiv = document.getElementById('recurrentEventFields');

    function toggleForms(value) {
        if (value === '0') {
            oneEventDiv.style.display = 'block';
            recurrentDiv.style.display = 'none';
        } else if (value === '1') {
            oneEventDiv.style.display = 'none';
            recurrentDiv.style.display = 'block';
        } else {
            oneEventDiv.style.display = 'none';
            recurrentDiv.style.display = 'none';
        }
    }

    if (dropdown) {
        toggleForms(dropdown.value); // initial load
        dropdown.addEventListener('change', function () {
            toggleForms(this.value);
        });
    }
});
</script>


           
        @endsection
      