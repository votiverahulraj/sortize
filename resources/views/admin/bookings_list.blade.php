@extends('admin.layouts.layout')

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

    .badge-success {
        color: #57B657 !important;
    }

    .badge-danger {
        color: #FF4747 !important;
    }

    .badge-warning {
        color: #FFC100 !important;
    }

    .badge-info {
        color: #248AFD !important;
    }

    .dt-column-title {
        text-align: center;
    }

    /* select2 css */
    .select2-selection {
        border-radius: 15px !important;
    }

    .event-date {
        border-radius: 15px !important;
    }

    .expanded-row h6{
        color: #0B0F32 !important;
        font-size: 14px !important;
        font-weight: 500;
    line-height: 1;
    }
   .expanded-row p {
        font-size: 11px;
    margin-bottom: 0;
    }
</style>

@section('content')
    <div class="main-panel">
        <div class="content-wrapper">
            <div class="row">
                <div class="col-md-12 grid-margin">
                    <div class="row">
                        <div class="col-12">
                            @include('admin.partials.breadcrumbs', [
                                'title' => 'Booking List',
                                'breadcrumbs' => [['label' => 'Booking List']],
                            ])
                        </div>

                        <div class="col-12 col-xl-4">
                            <div class="d-flex">

                                <div class="justify-content-end d-flex">
                                    <div class="dropdown flex-md-grow-1 flex-xl-grow-0">
                                        <select id="eventFilter"
                                            class="form-control select2 dropdown-toggle bg-white btn-light btn-sm"
                                            style="width: 200px;">
                                            <option value="">Select Event</option>
                                            @foreach ($events as $event)
                                                <option class="dropdown-item" value="{{ $event->id }}">
                                                    {{ $event->event_name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="justify-content-end d-flex">
                                    <div class="dropdown flex-md-grow-1 flex-xl-grow-0">
                                        <input type="date" class="form-control event-date" id="booking_date"
                                            name="booking_date" value="" style="width: 200px;">
                                    </div>
                                </div>


                                <div class="justify-content-end d-flex">
                                    <div class="dropdown flex-md-grow-1 flex-xl-grow-0">
                                        <select id="eventFilter"
                                            class="form-control select2 dropdown-toggle bg-white btn-light btn-sm"
                                            style="width: 200px;">
                                            <option value="">Select Event</option>
                                            @foreach ($events as $event)
                                                <option class="dropdown-item" value="{{ $event->id }}">
                                                    {{ $event->event_name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>


                            </div>

                        </div>

                    </div>
                </div>
            </div>




            <div class="row mb-3">
                <div class="card">
                    <div class="card-body">

                        <div class="table-responsive">
                            <table class="table table-bordered align-middle text-center" id="bookingtable">
                                <thead class="table-secondary">
                                    <tr>
                                        <th scope="col">S No</th>
                                        <th class="d-none">Event ID</th> <!-- 👈 hidden column -->
                                        <th scope="col">User Name</th>
                                        <th scope="col">Event Name</th>
                                        <th scope="col">Date</th>
                                        <th class="d-none">Event Date</th> <!-- 👈 hidden column -->
                                        <th scope="col">Time</th>
                                        <th scope="col">Ticket Qty</th>
                                        <th scope="col">Price</th>
                                        <th scope="col">Payment Status</th>
                                        <th scope="col">Status</th>
                                        <th scope="col">Booked At</th>
                                        <th scope="col">Action</th>
                                        <th scope="col"></th>
                                    </tr>
                                </thead>
                                <tbody>
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

                                    @if (isset($bookings))
                                        @php $i=1; @endphp
                                        @foreach ($bookings as $booking)
                                            <tr>
                                                <td>{{ $i }}</td>
                                                <td class="d-none">{{ $booking->event->id ?? '' }}</td>
                                                <td>{{ $booking->user->first_name ?? '' }}
                                                    {{ $booking->user->last_name ?? '' }}</td>
                                                <td> {{ $booking->event->event_name ?? '' }}</td>
                                                <td>
                                                    <label class="badge rounded-pill bg-success">
                                                        {{ \Carbon\Carbon::parse($booking->slot->date)->format('j F Y') }}
                                                    </label>
                                                </td>
                                                <td class="d-none"> {{ $booking->slot->date ?? '' }}</td>
                                                <td>
                                                    <label class="badge badge-info">
                                                        {{ \Carbon\Carbon::parse($booking->slot?->start_time)->format('H:i') ?? '' }}
                                                        -
                                                        {{ \Carbon\Carbon::parse($booking->slot?->end_time)->format('H:i') ?? '' }}
                                                    </label>
                                                </td>
                                                <td>{{ $booking->ticket_quantity }}</td>
                                                <td>{{ $booking->total_price }}</td>
                                                <td>
                                                    <label
                                                        class="
                                                            @if ($booking->payment_status === 'success') badge badge-success
                                                            @elseif($booking->payment_status === 'pending') badge badge-warning
                                                            @elseif($booking->payment_status === 'failed') badge badge-danger
                                                            @else badge-outline-primary @endif">
                                                        {{ ucfirst($booking->payment_status) }}
                                                    </label>
                                                </td>
                                                <td>
                                                    {{ ucfirst($booking->booking_status) }}
                                                </td>
                                                <td>
                                                    @php
                                                        $dt = \Carbon\Carbon::parse($booking->booked_at);
                                                    @endphp
                                                    {{ $dt->format('d M Y') }}<br>{{ $dt->format('h:i A') }}
                                                </td>
                                                <td>
                                                    <a href="javascript:void(0)" class="del_booking" booking_id=""><i
                                                            class="mdi mdi-delete"></i></a> |

                                                    <a href="#"><i class="mdi mdi-lead-pencil"></i></a> |
                                                    {{-- <a href="{{ route('admin.user_info') }}/{{ $booking->user_id }}"><i
                                                            class="mdi mdi mdi-eye"></i></a> --}}

                                                </td>
                                                <td class="accord-control" id={{ $booking->user_id }}><i class="mdi mdi-chevron-down" ></i></td>
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

    @endsection

    @push('scripts')
        <script>
            $(document).ready(function() {
                $('#eventFilter').select2({
                    placeholder: "Select an event",
                    allowClear: true
                });

                const table = $('#bookingtable').DataTable({
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
                    columnDefs: [{
                            targets: 1,
                            visible: false
                        }, // 👈 hides the 1st column (event_id)
                        {
                            targets: 5,
                            visible: false
                        }, // 👈 hides the 1st column (event_id)
                        {
                            targets: -1, // last column (details-control)
                            orderable: false,
                            className: 'accord-control',
                            // data: null,
                            defaultContent: ''
                        }

                    ],
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

                function formatChildRow(data) {
                    const genderMap = {
                        0: 'Male',
                        1: 'Female',
                        2: 'Other'
                    };

                    return `
                            <table cellpadding="5" cellspacing="0" border="0" style="width:100%;">
                                <tr class="expanded-row">
                                    <td colspan="8" class="row-bg">
                                        <div class="d-flex justify-content-between">
                                            <div class="cell-hilighted">
                                                <div class="d-flex mb-2">
                                                    <div class="me-2 min-width-cell"><p>Name </p><h6> ${data.name}</h6></div>
                                                    <div class="min-width-cell"><p>Email</p><h6> ${data.email}</h6></div>
                                                     <div class="min-width-cell"><p>Phone</p><h6> ${data.phone}</h6></div>

                                                </div>
                                                <div class="d-flex">
                                                    <div class="me-2 min-width-cell"><p>City</p><h6>${data.city}</h6></div>
                                                    <div class="min-width-cell"><p>Country</p><h6>${data.country}</h6></div>
                                                </div>
                                            </div>
                                            <div class="expanded-table-normal-cell">

                                                <div class="me-2"><p>Event Name.</p><h6>${data.event_name}</h6></div>
                                            </div>

                                        </div>
                                    </td>
                                </tr>
                            </table>
                        `;
                }

                $('#bookingtable tbody').on('click', 'td.accord-control', function() {
                    const tr = $(this).closest('tr');
                    const row = table.row(tr);
                     const userId = $(this).attr('id');

                    if (row.child.isShown()) {
                        row.child.hide();
                        tr.removeClass('shown');
                    } else {
                        row.child('<div class="p-3 text-muted">Loading user info...</div>').show();

                        $(this).find('i').removeClass('mdi-chevron-down').addClass('mdi-chevron-up');

                        tr.addClass('shown');

                        $.ajax({
                            url: "{{ url('admin/user_info') }}",
                            type: "POST",
                            dataType: "json",
                            data: {
                                booker_id: userId,
                                _token: '{{ csrf_token() }}'
                            },
                            success: function (result) {
                                // console.log(result);
                                row.child(formatChildRow(result)).show();

                            },
                            error: function (xhr) {
                                console.log(xhr.responseText);
                                row.child('<div class="text-danger p-3">Failed to load data</div>').show();
                            }
                        });
                    }
                });

                $('#eventFilter').on('change', function() {
                    let eventId = $(this).val();
                    let table = $('#bookingtable').DataTable();

                    table.column(1) // 👈 1 is the column index for Event ID
                        .search(eventId)
                        .draw();
                });
                $('#booking_date').on('change', function() {
                    let eventDate = $(this).val();
                    let table = $('#bookingtable').DataTable();

                    table.column(5) // 👈 5 is the column index for Event Date
                        .search(eventDate)
                        .draw();
                });

                //  $(document).on('click', '#country', function () {
                //     var cid = this.value;   //let cid = $(this).val(); we cal also write this.
                    // $.ajax({
                    //     url: "{{url('admin.user_info')}}",
                    //     type: "POST",
                    //     datatype: "json",
                    //     data: {
                    //     booker_id: id,
                    //     '_token':'{{csrf_token()}}'
                    //     },
                    //     success: function(result) {
                    //     $('#state').html('<option value="">Select State</option>');
                    //     $.each(result.state, function(key, value) {
                    //         $('#state').append('<option value="' +value.state_id+ '">' +value.state_name+ '</option>');
                    //     });
                    //     },
                    //     errror: function(xhr) {
                    //         console.log(xhr.responseText);
                    //     }
                    //     });
                    // });
                // });
            });
        </script>
    @endpush
