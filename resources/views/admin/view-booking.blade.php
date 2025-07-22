@extends('admin.layouts.layout')

<style>
    .badge-cust {
        padding: 5px 10px;
        font-size: 14px;
        border-radius: 20px;

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


            {{-- <a href="#" class="btn btn-outline-info btn-fw" style="float: right; margin-top: -55px;">
                Book Slot
            </a> --}}

            <div class="row mb-3">

                <div class="table-responsive">
                    <table class="table table-bordered align-middle text-center" id="bookingtable">
                        <thead class="table-dark">
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

                                        <td>{{ $booking->user->first_name ?? '' }} {{ $booking->user->last_name ?? '' }}
                                        </td>
                                        <td>{{ $booking->event->event_name ?? '' }}</td>
                                        <td>
                                            {{ $booking->slot->date ?? '' }}<br>
                                            {{ $booking->slot->start_time ?? '' }} - {{ $booking->slot->end_time ?? '' }}
                                        </td>

                                        <td>{{ $booking->ticket_quantity }}</td>
                                        <td>{{ $booking->total_price }}</td>
                                        {{-- <td>{{ ucfirst($booking->payment_status) }}</td> --}}
                                        <td>
                                            {{-- <label class="badge-cust badge-outline-primary">{{ ucfirst($booking->payment_status) }}</label> --}}
                                            <label
                                                class="badge-cust {{ $booking->payment_status == 'success' ? 'badge-outline-success' : 'badge-outline-primary' }}">
                                                {{ ucfirst($booking->payment_status) }}
                                            </label>

                                        </td>
                                        <td>{{ ucfirst($booking->booking_status) }}</td>
                                        <td>{{ \Carbon\Carbon::parse($booking->booked_at)->format('d M Y, h:i A') }}</td>

                                        <td>

                                            <a href="#"><i
                                                    class="mdi mdi mdi-eye"></i></a>
                                        </td>
                                    </tr>


                                    @php $i++; @endphp
                                @endforeach
                            @endif
                        </tbody>
                    </table>
                    <div class="d-flex add-pagination mt-4">
                        {{ $bookings->links('pagination::bootstrap-4') }}
                    </div>
                </div>
            </div>
        </div>

    @endsection
    {{--
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> --}}


    @push('scripts')
        <script>
            $(document).ready(function() {
                var table = $('#bookingtable').DataTable({
                    "bPaginate": false,
                    "bInfo": false,
                });

            });
        </script>
    @endpush
