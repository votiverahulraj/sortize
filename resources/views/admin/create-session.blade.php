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

<div class="main-panel">
          <div class="content-wrapper">
            <div class="row">
              <div class="col-md-12 grid-margin">
                <div class="row">
                  <div class="col-12 col-xl-8 mb-4 mb-xl-0">
                    <h3 class="font-weight-bold">Update Slot</h3>
                  </div>
                </div>
              </div>
            </div>

     <form class="add-evnt" id="eventForm" method="POST" action="{{ route('admin.updateSession', ['id' => $session->id]) }}" enctype="multipart/form-data">
                {!! csrf_field() !!}

                 <div class="form-group col-md-6">
                          <input type="hidden" name="event_id" value="{{ $event_id }}">
                         

    <div class="form-group col-md-6">
    <label for="exampleInputUsername1">Start Time</label>
    <input type="time" name="start_time" class="form-control form-control-sm" value="{{ $session->start_time }}" >
  </div>
 <div class="form-group col-md-6">
    <label for="exampleInputUsername1">End Time</label>
    <input type="time" name="end_time" value="{{ $session->end_time }}" class="form-control form-control-sm">
  </div>
 <div class="form-group col-md-6">
    <label for="exampleInputUsername1">Capacity</label>
    <input type="number" name="capacity" value="{{ $session->capacity }}" min="1" class="form-control form-control-sm">
  </div>
    <button type="submit" class="btn btn-primary btn-submit">Update</button>
    </form>
   
</div>
</div>
 
        @endsection
      