<div>

<div class="row mb-2 mb-xl-3">
        <div class="col-auto d-none d-sm-block">
            <h3><strong>{{$lang->data['customer_report'] ?? 'Appointment Report'}}</strong></h3>
        </div>
    </div>
   

    <div class="row">
        <div class="col-12">
            <div class="card p-0">
                

                <div class="card-body p-0">
                   <div>
    <table class="table table-striped table-bordered mb-0">
        <thead>
            <tr>
                <th>ID</th>
                <th>Lead</th>
                <th>Start Time</th>
                <th>End Time</th>
                <th>Start Date</th>
                <th>Quotation No</th>
                <th>Type</th>
                <th>Created By</th>
                <th>Customer Status</th>
                <th>Status</th>
                <th>Created At</th>
                <th>Updated At</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($appointmentReports as $appointment)
                <tr>
                    <td>{{ $appointment->id }}</td>
                    <td>{{ $appointment->lead->name }}</td> 
                    <td>{{ $appointment->start_time }}</td>
                    <td>{{ $appointment->end_time }}</td>
                    <td>{{ $appointment->start_date }}</td>
                    <td>{{ $appointment->quotation_no }}</td>
                    <td>{{ $appointment->type }}</td>
                    <td>{{ $appointment->creater->name }}</td>
                    <td>{{ $appointment->customer_status }}</td>
                    <td>{{ $appointment->status }}</td>
                    <td>{{ $appointment->created_at }}</td>
                    <td>{{ $appointment->updated_at }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>

                    @if(count($appointmentReports) == 0)
                        <x-no-data-component message="{{$lang->data['no_data_found'] ?? 'No data was found..'}}" />
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>