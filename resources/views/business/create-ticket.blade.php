@extends('business.layouts.layout')

@section('content')
<div class="main-panel">
          <div class="content-wrapper">
            <div class="row">
              <div class="col-md-12 grid-margin">
                <div class="row">
                  <div class="col-12 col-xl-8 mb-4 mb-xl-0">
                    <h3 class="font-weight-bold">Create New Ticket</h3>
                  </div>
                </div>
              </div>
            </div>
            <form class="add-evnt">
                <div class="row mb-3">
                    <div class="col-md-6">
                        <div class="form-group">
                        <label for="ticketName">Ticket Name</label>
                        <input type="text" class="form-control" id="ticketName" placeholder="Enter your ticket name">
                        </div>
                    </div>
                    <div class="col-md-6">
                    <div class="form-group">
                        <label for="type-event">Ticket Type</label>
                        <select class="form-select" id="type-event">
                        <option selected disabled>Choose...</option>
                        <option>Sports</option>
                        <option>Music</option>
                        <option>Arts</option>
                        <option>Conferences</option>
                        <option>Fashion shows</option>
                        <option>Festivals</option>
                    </select>
                        </div>
                        </div> 
                </div>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <div class="form-group">
                        <label for="exampleInputUsername1">Select Date & Time</label>
                        <input type="text" class="form-control" id="exampleInputUsername1" placeholder="Choose event type">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                        <label for="exampleInputUsername1">Select Address</label>
                        <input type="text" class="form-control" id="exampleInputUsername1" placeholder="Add address here">
                        </div>
                    </div>
                    
                </div>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <div class="form-group">
                        <label for="exampleInputUsername1">Ticket Price</label>
                        <input type="text" class="form-control" id="exampleInputUsername1" placeholder="Enter price">
                        </div>
                    </div>
                    <div class="col-md-6">
                       <div class="form-group mb-3">
  <label for="" class="form-label">Attach Media</label>
  <input type="file" class="form-control" id="inputGroupFile" multiple>

  <!-- Attached media display section -->
  <div id="fileList" class="mt-2 text-secondary small"></div>
</div>
                    </div>
                    
                </div>

                <div class="row mb-3">
                    <div class="form-group mb-3">
                        <label for="message" class="form-label">Ticket Description</label>
                        <textarea class="form-control" id="message" rows="5" placeholder="Type your ticket description..."></textarea>
                    </div>
                </div>

                <button type="submit" class="btn btn-primary btn-submit">PUBLISH NOW</button>
            </form>
            
        @endsection