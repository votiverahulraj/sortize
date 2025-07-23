@extends('admin.layouts.layout')

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
                                        <th scope="col">User Name</th>
                                        <th scope="col">Event Name</th>
                                        <th scope="col">Event Slot</th>
                                        <th scope="col">Ticket Qty</th>
                                        <th scope="col">Price</th>
                                        <th scope="col">Payment Status</th>
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
                                    <!-- 10 Sample Booking Rows -->
                                    @if ($bookings)
                                        @php $i=1; @endphp
                                        @foreach ($bookings as $booking)
                                            <tr>
                                                <td>{{ $i }}</td>

                                                <td>{{ $booking->user->first_name ?? '' }}
                                                    {{ $booking->user->last_name ?? '' }}</td>
                                                <td>{{ $booking->event->event_name ?? '' }}</td>
                                                <td>
                                                    {{ $booking->slot->date ?? '' }}<br>
                                                    {{ $booking->slot->start_time ?? '' }} -
                                                    {{ $booking->slot->end_time ?? '' }}
                                                </td>

                                                <td>{{ $booking->ticket_quantity }}</td>
                                                <td>{{ $booking->total_price }}</td>
                                                <td>{{ ucfirst($booking->payment_status) }}</td>
                                                <td>{{ ucfirst($booking->booking_status) }}</td>
                                                <td>{{ \Carbon\Carbon::parse($booking->booked_at)->format('d M Y, h:i A') }}
                                                </td>



                                                <td>
                                                    <a href="javascript:void(0)" class="del_booking" booking_id=""><i
                                                            class="mdi mdi-delete"></i></a> |
                                                    {{-- admin.booking-delete
                                           admin.booking-edit --}}
                                                    <a href="#"><i class="mdi mdi-lead-pencil"></i></a> |
                                                    <a href="#"><i class="mdi mdi mdi-eye"></i></a>

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
