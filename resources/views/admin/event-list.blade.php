@extends('admin.layouts.layout')

@section('content')
<div class="main-panel">
          <div class="content-wrapper">
            <div class="row">
              <div class="col-md-12 grid-margin">
                <div class="row">
                  <div class="col-12 col-xl-8 mb-4 mb-xl-0">
                    <h3 class="font-weight-bold">Event List</h3>
                  </div>
                </div>
              </div>
            </div>

          @if(session()->has('success'))
    <div class="alert alert-success" id="success-alert">
        {{ session()->get('success') }}
    </div>

    <script>
        setTimeout(function() {
            const alert = document.getElementById('success-alert');
            if (alert) {
                alert.style.transition = 'opacity 0.5s ease';
                alert.style.opacity = '0';
                setTimeout(() => alert.remove(), 500); // Remove after fade
            }
        }, 5000); // 5000ms = 5 seconds
    </script>
@endif

                <div class="row mb-3">
                    
  <div class="table-responsive">
    <table class="table table-bordered align-middle text-center">
      <thead class="table-dark">
        <tr>
          <th scope="col">Event Image</th>
          <th scope="col">Event Name</th>
          <th scope="col">Event Type</th>
          <th scope="col">Event Date & Time</th>
          <th scope="col">Event Location</th>
          <th scope="col">Event Price</th>
          <th scope="col">Action</th>
        </tr>
      </thead>
      <tbody>
        <!-- 10 Sample Event Rows -->
         @if($eventlist)
          @php $i=1; @endphp
        @foreach($eventlist as $event)
<tr>
    <td>
        <img src="{{ asset('/public/' . $event->media) }}" class="img-fluid rounded" alt="" style="width: 80px; height: 60px;">
    </td>
    <td>{{ $event->event_name }}</td>
    @php
    $eventTypes = [
        0 => 'Sports',
        1 => 'Music',
        2 => 'Arts',
        3 => 'Conferences',
        4 => 'Fashion shows',
        5 => 'Festivals',
    ];
@endphp
   <td>{{ $eventTypes[$event->event_type] ?? 'N/A' }}</td>
    <td>
        {{ \Carbon\Carbon::parse($event->date_time)->format('F d, Y - h:i A') }}
    </td>
    <td>{{ $event->address }}</td>
    <td>₹{{ $event->ticket_price }}</td>
    <td>
       <!-- <a href="{{route('interprise.edit-event')}}/{{ $event->id }}"><i class="mdi mdi-lead-pencil"></i></a>  -->
        <a href="javascript:void(0)" class="del_user" event_id="{{$event->id}}"><i class="mdi mdi-delete"></i></a>
         <a href="{{route('admin.view-event')}}/{{ $event->id }}"><i class="mdi mdi-eye"></i></a>

    </td>
</tr>
 @php $i++; @endphp
@endforeach
@endif
  </tbody>
    </table>     
                <div class="d-flex add-pagination mt-4">
                        {{ $eventlist->links('pagination::bootstrap-4') }}
                    </div>
                </div>
         </div>
        </div>
            
        @endsection
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script type="text/javascript">
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

                  var event_id=$(this).attr('event_id');
                  $.ajax({
                    url: "{{route('interprise.delete_event')}}",
                    type: "POST",
                    datatype: "json",
                    data: {
                      event:event_id,
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
        </script>