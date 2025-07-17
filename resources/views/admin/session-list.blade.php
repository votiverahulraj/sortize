@extends('admin.layouts.layout')

@section('content')
<div class="main-panel">
          <div class="content-wrapper">
            <div class="row">
              <div class="col-md-12 grid-margin">
                <div class="row">
                  <div class="col-12 col-xl-8 mb-4 mb-xl-0">
                    <h3 class="font-weight-bold">Slot List</h3>
                  </div>
                </div>
              </div>
            </div>

          @if(session()->has('success'))
    <div class="alert alert-success" id="success-alert">
        {{ session()->get('success') }}
    </div>

     @if (Session::has('error'))
                      <div class="alert alert-danger">
                          {{ Session::get('error') }}
                      </div>
                  @endif

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

<!--  <a href="{{route('admin.addSession')}}" 
   class="btn btn-outline-info btn-fw" 
   style="float: right; margin-top: -55px;">
   Add Session
</a> -->

  <div class="row mb-3">
                    
  <div class="table-responsive">
    <table class="table table-bordered align-middle text-center">
      <thead class="table-dark">
        <tr>
          <th>S no.</th>
         <th>Date</th>
      <th>start time</th>
       <th>end time</th>
      <th>Capacity</th>
      <th>Status</th>
      <th>Actions</th>
        </tr>
      </thead>
      <tbody>
         @if($sessionlist)
          @php $i=1; @endphp
       
  @foreach($sessionlist as $session)
      <tr>
        <td>{{ $i++}}</td>
        <td>{{ $session->date }}</td>
        <td>{{ $session->start_time }}</td>
        <td>{{ $session->end_time }}</td>
        <td>
          {{ $session->capacity }}
        </td>
        <td>
        
          <select class="session_status form-select form-select-sm" user="{{$session->id}}">
          <option value="0" {{$session->is_active==0?'selected':''}}>InActive</option>
          <option value="1" {{$session->is_active==1?'selected':''}}>Active </option>
          </select>
                              </td>
        </td>
        <td>
 <a href="{{ route('admin.session.edit', ['id' => $session->id]) }}">
    <i class="mdi mdi-lead-pencil"></i>
</a>
        </td>
      </tr>
    @endforeach
    @endif
  </tbody>
    </table>     
                <div class="d-flex add-pagination mt-4">
                        {{ $sessionlist->links('pagination::bootstrap-4') }}
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
            $(document).on('change','.session_status',function(){
              var status=$(this).val();
              var session_id=$(this).attr('user');
              $.ajax({
                url: "{{url('/admin/session_status')}}",
                type: "POST",
                datatype: "json",
                data: {
                  status: status,
                  user:session_id,
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
        </script>