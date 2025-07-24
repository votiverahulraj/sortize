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
    .badge-success{
        color:#57B657 !important;
    }
    .badge-danger{
        color: #FF4747!important;
    }
    .badge-warning{
        color: #FFC100!important;
    }
    .badge-info{
        color: #248AFD!important;
    }
</style>

@section('content')
    <div class="main-panel">
        <div class="content-wrapper">
            <div class="row">
                <div class="col-md-12 grid-margin">
                    <div class="row">
                        <div class="col-12 col-xl-8 mb-4 mb-xl-0">
                            <h3 class="font-weight-bold">Booking List</h3>
                        </div>
                    </div>
                </div>
            </div>


            <a href="#" class="btn btn-outline-info btn-fw"
                style="float: right; margin-top: -55px;">
                Book Slot
            </a>

            <div class="row mb-3">
                <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                    <table class="table table-bordered align-middle text-center" id="bookingtable">
                        <thead class="table-secondary">
                            <tr>
                                <th scope="col">S No</th>
                                <th scope="col">User Name</th>
                                <th scope="col">Event Name</th>
                                <th scope="col">Date</th>
                                <th scope="col">Time</th>
                                <th scope="col">Ticket<br> Qty</th>
                                <th scope="col">Price</th>
                                <th scope="col">Payment<br> Status</th>
                                <th scope="col">Status</th>
                                 <th scope="col">Booked At</th>
                                <th scope="col">Action</th>
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

                                         <td>{{ $booking->user->first_name ?? '' }} {{ $booking->user->last_name ?? '' }}</td>
                                        <td>{{ $booking->event->event_name ?? '' }}</td>

                                        <td>
                                            <label class="badge rounded-pill bg-success">{{ $booking->slot->date ?? '' }}</label>
                                        </td>
                                        <td>
                                            <label class="badge badge-info">
                                                {{ \Carbon\Carbon::parse($booking->slot?->start_time)->format('H:i') ?? '' }} -
                                                {{ \Carbon\Carbon::parse($booking->slot?->end_time)->format('H:i') ?? '' }}
                                            </label>
                                        </td>

                                        <td>{{ $booking->ticket_quantity }}</td>
                                        <td>{{ $booking->total_price }}</td>
                                        {{-- <td>{{ ucfirst($booking->payment_status) }}</td> --}}
                                        <td>
                                            {{-- <label class="badge-cust badge-outline-primary">{{ ucfirst($booking->payment_status) }}</label> --}}
                                          <label class="
                                                @if($booking->payment_status === 'success') badge badge-success
                                                @elseif($booking->payment_status === 'pending') badge badge-warning
                                                @elseif($booking->payment_status === 'failed') badge badge-danger
                                                @else badge-outline-primary
                                                @endif">
                                                {{ ucfirst($booking->payment_status) }}
                                            </label>

                                        </td>
                                        <td>{{ ucfirst($booking->booking_status) }}</td>
                                        <td>{{ \Carbon\Carbon::parse($booking->booked_at)->format('d M Y, h:i A') }}</td>

                                        <td>
                                            {{-- <a href="javascript:void(0)" class="del_booking" booking_id=""><i class="mdi mdi-delete"></i></a> | --}}
                                            {{-- <a href="#"><i class="mdi mdi-lead-pencil"></i></a> | --}}
                                            <a href="{{ route('interprise.user_info')}}/{{ $booking->id }}"><i class="mdi mdi mdi-eye"></i></a>
                                        </td>
                                    </tr>


                                    @php $i++; @endphp
                                @endforeach
                            @endif
                        </tbody>
                    </table>
                    <div class="d-flex add-pagination mt-4">
                        {{-- {{ $bookings->links('pagination::bootstrap-4') }} --}}
                    </div>
                </div>

                </div>
                </div>

            </div>
        </div>

@endsection

 @push('scripts')
        <script>
            $(document).ready(function() {
                $('#bookingtable').DataTable({
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
