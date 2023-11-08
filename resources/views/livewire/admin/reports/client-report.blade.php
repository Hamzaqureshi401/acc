<div>

<div class="row mb-2 mb-xl-3">
        <div class="col-auto d-none d-sm-block">
            <h3><strong>{{$lang->data['customer_report'] ?? 'Client Quotation and Invoices Report'}}</strong></h3>
        </div>
    </div>
   

    <div class="row">
        <div class="col-12">
            <div class="card p-0">
                

                <div class="card-body p-0">
                    <table class="table table-striped table-sm table-bordered mb-0">
                       
    <thead>
        <tr>
            <th>Client Name</th>
            <th>Total Quotation</th>
            <th>Total Invoice</th>
          <!--   <th>Parts</th>
            <th>Products Installed</th> -->
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($clients as $client)
            <tr>
                <td>{{ $client->name }}</td>
                <td>{{ $client->quotation->count() }}</td>
                <td>{{ $client->invoices->count() }}</td>
               <!--  <td>{{ '--' }}</td>
                <td>{{ '--' }}</td> -->

                <td>
                    <a href="" class="btn btn-primary">View Details</a>
                </td>
            </tr>
        @endforeach
    </tbody>


                    </table>
                    @if(count($clients) == 0)
                        <x-no-data-component message="{{$lang->data['no_data_found'] ?? 'No data was found..'}}" />
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>