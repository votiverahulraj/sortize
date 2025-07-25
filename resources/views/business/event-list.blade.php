@extends('business.layouts.layout')

<style>
    .form-control-sm {
        padding: 0.45rem .5rem !important;
    }

    .badge-cust {
        padding: 5px 10px;
        font-size: 14px;
        border-radius: 20px;

    }

    .card .card-body {
        padding: 0.25rem 0.25rem !important;
    }
</style>

@section('content')
    <div class="main-panel">
        <div class="content-wrapper">
            <div class="row">
                <div class="col-md-12 grid-margin">
                    <div class="row">
                        <div class="col-12 ">
                            @include('business.partials.breadcrumbs', [
                                'title' => 'Event List',
                                'breadcrumbs' => [['label' => 'Event List']],
                            ])
                        </div>
                    </div>
                </div>
            </div>

            @if (session()->has('success'))
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
                <div class="card">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered align-middle text-center" id="eventtable">
                                <thead class="table-secondary">
                                    <tr>
                                        <th scope="col">S No.</th>
                                        <!-- <th scope="col">Event Image</th> -->
                                        <th scope="col">Event Name</th>
                                        <th scope="col">Event Type</th>
                                        <th scope="col">Date</th>
                                        <th scope="col">Time</th>

                                        <th scope="col">Event Location</th>
                                        <th scope="col">Event Price</th>
                                        <th scope="col">Events Limit</th>
                                        <th scope="col">Action</th>
                                        <th scope="col">Manage Session</th>
                                        <th scope="col">view Bookings</th>
                                        <!-- <th scope="col">View S</th> -->
                                    </tr>
                                </thead>
                                <tbody>
                                    <!-- 10 Sample Event Rows -->
                                    @if (isset($eventlist))
                                        @php $i=1; @endphp
                                        @foreach ($eventlist as $event)
                                            <tr>

                                                <td>{{ $i }}</td>
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
                                                     @php
                                                        $start = \Carbon\Carbon::parse($event->start_date);
                                                        $end = \Carbon\Carbon::parse($event->end_date);
                                                    @endphp

                                                    <td>
                                                        <label class="badge rounded-pill bg-success">
                                                            {{ $start->format('d') }} - {{ $end->format('d F Y') }}
                                                        </label>
                                                    </td>


                                                  <td>
                                                     <label class="badge rounded-pill bg-primary">
                                                          {{ \Carbon\Carbon::parse($event->start_time)->format('H:i') ?? '' }} -
                                                        {{ \Carbon\Carbon::parse($event->end_time)->format('H:i') ?? '' }}
                                                      </label></td>
                                                <td>{{ $event->address }}</td>
                                                <td>₹{{ $event->price }}</td>
                                                <td>

                                                    @if ($event->event_limit == 0)
                                                        single
                                                    @else
                                                        Recurrent Event
                                                    @endif
                                                </td>
                                                <td>
                                                    <a href="{{ route('interprise.edit-event') }}/{{ $event->id }}"><i
                                                            class="mdi mdi-lead-pencil"></i></a>
                                                    <a href="javascript:void(0)" class="del_user"
                                                        event_id="{{ $event->id }}"><i class="mdi mdi-delete"></i></a>
                                                    <a href="{{ route('interprise.view-event') }}/{{ $event->id }}"><i
                                                            class="mdi mdi-eye"></i></a>

                                                </td>
                                                <td><a
                                                        href="{{ route('interprise.generateSessions', ['id' => $event->id]) }}">View
                                                        Slots</a></td>
                                                <td><a href="{{ route('interprise.view-booking', ['id' => $event->id]) }}">
                                                        <i class="mdi mdi-eye"></i></a></td>
                                            </tr>
                                            @php $i++; @endphp
                                        @endforeach
                                    @endif
                                </tbody>
                            </table>
                            <div class="d-flex add-pagination mt-4">
                                {{-- {{ $eventlist->links('pagination::bootstrap-4') }} --}}
                            </div>
                        </div>

                    </div>
                </div>

            </div>
        </div>

    @endsection
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script type="text/javascript">
        $(document).on('click', '.del_user', function() {
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

                    var event_id = $(this).attr('event_id');
                    $.ajax({
                        url: "{{ route('interprise.delete_event') }}",
                        type: "POST",
                        datatype: "json",
                        data: {
                            event: event_id,
                            '_token': '{{ csrf_token() }}'
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


    @push('scripts')
        <script>
            $(document).ready(function() {
                $('#eventtable').DataTable({
                    layout: {
                        topStart: {
                            buttons: [{
                                    extend: 'copy',
                                    className: 'btn btn-primary custom-dt-btn'
                                },
                                {
                                    extend: 'csv',
                                    className: 'btn  btn-primary custom-dt-btn'
                                },
                                {
                                    extend: 'excel',
                                    className: 'btn btn-primary custom-dt-btn'
                                },
                                {
                                    extend: 'pdf',
                                    className: 'btn  btn-primary custom-dt-btn'
                                },
                                {
                                    extend: 'print',
                                    className: 'btn btn-primary custom-dt-btn'
                                }
                            ]
                        },

                    },
                    paging: true,
                    info: true,
                    responsive: true,
                    initComplete: function() {
                        // Wrap .dt-buttons in a Bootstrap .btn-group
                        let $buttons = $('.dt-buttons');
                        if (!$buttons.hasClass('btn-group')) {
                            $buttons.addClass('btn-group').attr('role', 'group');
                        }

                        // Optional: adjust parent container
                        // $buttons.closest('.dt-layout-start').addClass('mb-3'); // spacing below buttons
                    }
                });
            });
        </script>
    @endpush
