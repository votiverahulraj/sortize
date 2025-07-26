@extends('admin.layouts.layout')

<style>
    .form-control-sm {
        padding: 0.45rem .5rem !important;
    }

    .card .card-body {
        padding: 0.25rem 0.25rem !important;
    }

    .dt-column-title {
        text-align: center;
    }

    @media (max-width: 480px) {

        .buttons-print,
        .buttons-copy,
        .buttons-csv {
            display: none !important;
        }

        .dt-layout-start {
            margin: 10px;
        }

        .buttons-pdf {
            background: linear-gradient(135deg, #f79ae6, #00d0ffa1) !important;
            border: none !important;
            border-radius: 5px !important;
            margin-right: 8px !important;
        }

        .buttons-excel {
            background: linear-gradient(135deg, #f79ae6, #00d0ffa1) !important;
            border: none !important;
            border-radius: 5px !important;
            margin-left: 8px !important;
        }


    }
</style>

@section('content')
    <div class="main-panel">

        <div class="content-wrapper">
            <div class="row">
                <div class="col-md-12 grid-margin">
                    @include('admin.partials.breadcrumbs', [
                        'title' => 'Event List',
                        'breadcrumbs' => [['label' => 'Event List']],
                    ])
                </div>
            </div>

            <div class="row mb-3">
                <div class="card">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered align-middle text-center" id="eventtable">
                                <thead class="table-secondary">
                                    <tr>
                                        <th scope="col">S No</th>
                                        <th scope="col">Event Name</th>
                                        <th scope="col">Event Type</th>
                                        <th scope="col">Event Location</th>
                                        <th scope="col">Event Price</th>
                                        <th scope="col">Events Limit</th>
                                        <th scope="col"> &nbsp; Status &nbsp; </th>
                                        <th scope="col">Action</th>
                                        <th scope="col">Slot</th>
                                        <th scope="col">Booking</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $eventStatuses = [
                                            0 => 'Pending',
                                            1 => 'Published',
                                            2 => 'UnPublished',
                                        ];
                                    @endphp
                                    @if ($eventlist)
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
                                                <td>{{ $event->address }}</td>
                                                <td>${{ $event->price }}</td>
                                                <td>
                                                    @if ($event->event_limit == 0)
                                                        single
                                                    @else
                                                        Recurrent Event
                                                    @endif

                                                </td>
                                                <td>
                                                    <div class="dropdown">
                                                        <button
                                                            class="btn btn-sm dropdown-toggle
                                                            {{ $event->status == 0 ? 'btn-warning' : ($event->status == 1 ? 'btn-success' : 'btn-secondary') }}"
                                                            type="button" id="dropdownMenuStatus{{ $event->id }}"
                                                            data-bs-toggle="dropdown" aria-expanded="false">
                                                            {{ $eventStatuses[$event->status] }}
                                                        </button>

                                                        <ul class="dropdown-menu"
                                                            aria-labelledby="dropdownMenuStatus{{ $event->id }}">
                                                            @foreach ($eventStatuses as $key => $label)
                                                                <li>
                                                                    <a class="dropdown-item {{ $event->status == $key ? 'active' : '' }}"
                                                                        href="#" data-event-id="{{ $event->id }}"
                                                                        data-status="{{ $key }}">
                                                                        {{ $label }}
                                                                    </a>
                                                                </li>
                                                            @endforeach
                                                        </ul>
                                                    </div>
                                                </td>
                                                <td>
                                                    <a href="{{ route('admin.edit-event') }}/{{ $event->id }}"><i
                                                            class="mdi mdi-lead-pencil"></i></a>
                                                    <a href="javascript:void(0)" class="del_user"
                                                        event_id="{{ $event->id }}"><i class="mdi mdi-delete"></i></a>
                                                    <a href="{{ route('admin.view-event') }}/{{ $event->id }}"><i
                                                            class="mdi mdi-eye"></i></a>

                                                </td>
                                                <td>
                                                    <a href="{{ route('admin.generateSessions') }}/{{ $event->id }}">View
                                                        Slot
                                                    </a>
                                                </td>
                                                <td>
                                                    <a
                                                        href="{{ route('admin.viewBookings') }}/{{ $event->id }}">View</a>
                                                </td>
                                            </tr>
                                            @php $i++; @endphp
                                        @endforeach
                                    @endif
                                </tbody>
                            </table>
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
    $(document).on('change', '.event_status', function() {
        var status = $(this).val();
        var event_id = $(this).attr('user');
        $.ajax({
            url: "{{ url('/admin/event_update_status') }}",
            type: "POST",
            datatype: "json",
            data: {
                status: status,
                user: event_id,
                '_token': '{{ csrf_token() }}'
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
                    topEnd: {
                        search: {
                            input: {
                                className: 'form-control form-control-sm p-2'
                            }
                        },
                        buttons: [{
                            text: 'Add Event',
                            className: 'btn  btn-success custom-dt-btn',
                            action: function(e, dt, node, config) {
                                // alert('Button activated');
                                window.location.href = "{{ route('admin.addEvent') }}";
                            }
                        }]
                    }
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
