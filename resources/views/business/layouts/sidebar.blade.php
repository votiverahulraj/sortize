<nav class="sidebar sidebar-offcanvas" id="sidebar">
  <ul class="nav">
    <li class="nav-item">
      <a class="nav-link" href="{{route('interprise.dashboard')}}">
        <i class="icon-grid menu-icon"></i>
        <span class="menu-title">Dashboard</span>
      </a>
    </li>
    <li class="nav-item">
      <a class="nav-link" data-bs-toggle="collapse" href="#masters" aria-expanded="false" aria-controls="masters">
        <i class="icon-columns menu-icon"></i>
        <span class="menu-title">Profile</span>
      </a>
    </li>
    <li class="nav-item">
      <a class="nav-link" data-bs-toggle="collapse" href="#event-manage" aria-expanded="false" aria-controls="event-manage">
        <i class="icon-head menu-icon"></i>
        <span class="menu-title">Event Management</span>
        <i class="menu-arrow"></i>
      </a>
       <div class="collapse" id="event-manage">
        <ul class="nav flex-column sub-menu">
          <li class="nav-item"> <a class="nav-link" href="{{url('/dashboard/create-event')}}">Create Event</a></li>
          <li class="nav-item"> <a class="nav-link" href="{{url('/dashboard/event-list')}}">Event List</a></li>
        </ul>
      </div> 
    </li>
	
	<!-- <li class="nav-item">
      <a class="nav-link" data-bs-toggle="collapse" href="#ticket-manage" aria-expanded="false" aria-controls="ticket-manage">
        <i class="icon-grid-2 menu-icon"></i>
        <span class="menu-title">Ticket Managment</span>
        <i class="menu-arrow"></i>
      </a>
      <div class="collapse" id="ticket-manage">
        <ul class="nav flex-column sub-menu">
		  <li class="nav-item"><a class="nav-link" href="{{route('interprise.create-ticket')}}">Create Ticket </a></li>
          <li class="nav-item"><a class="nav-link" href="{{route('interprise.ticket-list')}}">Ticket List </a></li>
        </ul>
      </div>
    </li> -->
    
    <li class="nav-item">
      <a class="nav-link" data-bs-toggle="collapse" href="#booking-manage" aria-expanded="false" aria-controls="booking-manage">
        <i class="icon-grid-2 menu-icon"></i>
        <span class="menu-title">Booking Managment</span>
        <i class="menu-arrow"></i>
      </a>
      <div class="collapse" id="booking-manage">
        <ul class="nav flex-column sub-menu">
          <li class="nav-item"><a class="nav-link" href="#">Booking List </a></li>
        </ul>
      </div>
    </li>

    

    <li class="nav-item">
      <a class="nav-link" data-bs-toggle="collapse" href="#review-manage" aria-expanded="false" aria-controls="review-manage">
        <i class="icon-grid-2 menu-icon"></i>
        <span class="menu-title">Review Managment</span>
        <i class="menu-arrow"></i>
      </a>
      <div class="collapse" id="review-manage">
        <ul class="nav flex-column sub-menu">
          <li class="nav-item"><a class="nav-link" href="#">Review </a></li>
        </ul>
      </div>
    </li>
  </ul>
</nav>