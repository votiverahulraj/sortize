@extends('business.layouts.layout')

@section('content')
<div class="main-panel">
          <div class="content-wrapper">
            <div class="row">
              <div class="col-md-12 grid-margin">
                <div class="row">
                  <div class="col-12 col-xl-8 mb-4 mb-xl-0">
                    <h3 class="font-weight-bold">Ticket List</h3>
                  </div>
                </div>
              </div>
            </div>
                <div class="row mb-3">
                    
                    <div class="table-responsive">
    <table class="table table-bordered align-middle text-center">
      <thead class="table-dark">
        <tr>
          <th scope="col">Ticket Name</th>
          <th scope="col">Ticket Type</th>
          <th scope="col">Date & Time</th>
          <th scope="col">Location</th>
          <th scope="col">Ticket Price</th>
        </tr>
      </thead>
      <tbody>
        <!-- 10 Sample Event Rows -->
        <tr>
          <td>Music Fiesta</td>
          <td>Concert</td>
          <td>July 15, 2025 - 7:00 PM</td>
          <td>Paris</td>
          <td>$600</td>
        </tr>
        <tr>
          <td>Startup Meetup</td>
          <td>Conference</td>
          <td>Aug 2, 2025 - 10:00 AM</td>
          <td>Nantes</td>
          <td>$500</td>
        </tr>
        <tr>
          <td>Art Expo</td>
          <td>Exhibition</td>
          <td>Sep 10, 2025 - 11:00 AM</td>
          <td>Toulouse</td>
          <td>$800</td>
        </tr>
        <tr>
          <td>Food Carnival</td>
          <td>Festival</td>
          <td>Oct 5, 2025 - 1:00 PM</td>
          <td>Nice</td>
          <td>$1200</td>
        </tr>
        <tr>
          <td>Code Camp</td>
          <td>Workshop</td>
          <td>Nov 12, 2025 - 9:00 AM</td>
          <td>Strasbourg</td>
          <td>$600</td>
        </tr>
        <tr>
          <td>Yoga Day</td>
          <td>Health</td>
          <td>June 21, 2025 - 6:00 AM</td>
          <td>Lyon</td>
          <td>$450</td>
        </tr>
        <tr>
          <td>Photography Walk</td>
          <td>Outdoor</td>
          <td>July 20, 2025 - 4:00 PM</td>
          <td>Montpellier</td>
          <td>$900</td>
        </tr>
        <tr>
          <td>Film Festival</td>
          <td>Entertainment</td>
          <td>Aug 30, 2025 - 5:00 PM</td>
          <td>Bordeaux</td>
          <td>$850</td>
        </tr>
        <tr>
          <td>Green Expo</td>
          <td>Environment</td>
          <td>Sep 15, 2025 - 10:00 AM</td>
          <td>Marseille</td>
          <td>$500</td>
        </tr>
        <tr>
          <td>Book Fair</td>
          <td>Exhibition</td>
          <td>Oct 1, 2025 - 11:00 AM</td>
          <td>Rennes</td>
          <td>$400</td>
        </tr>
      </tbody>
    </table>
  </div>


                <!-- Pagination -->
  <nav aria-label="Event table pagination">
    <ul class="pagination justify-content-center mt-4">
      <li class="page-item disabled"><a class="page-link" href="#">Previous</a></li>
      <li class="page-item active"><a class="page-link" href="#">1</a></li>
      <li class="page-item"><a class="page-link" href="#">2</a></li>
      <li class="page-item"><a class="page-link" href="#">3</a></li>
      <li class="page-item"><a class="page-link" href="#">Next</a></li>
    </ul>
  </nav>
                </div>
         </div>
        </div>
            
        @endsection