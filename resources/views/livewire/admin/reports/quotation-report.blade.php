<div>

<div class="row mb-2 mb-xl-3">
        <div class="col-auto d-none d-sm-block">
            <h3><strong>{{$lang->data['customer_report'] ?? 'Quotations Report'}}</strong></h3>
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
                <th>Quotation Number</th>
                <th>Created Date</th>
                <th>Expiry Date</th>
                <th>Lead</th>
                <th>Stage</th>
                <th>Sub Total</th>
                <th>Discount Amount</th>
                <th>Tax Amount</th>
                <th>Total Amount</th>
                <th>Created By</th>
                <th>Created At</th>
                <th>Updated At</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($quotationReport as $quotation)
                <tr>
                    <td>{{ $quotation->id }}</td>
                    <td>{{ $quotation->quotation_number }}</td>
                    <td>{{ $quotation->created_date }}</td>
                    <td>{{ $quotation->expiry_date }}</td>
                    <td>{{ $quotation->lead->name }}</td>
                    <td>{{ $quotation->stage }}</td>
                    <td>{{ $quotation->sub_total }}</td>
                    <td>{{ $quotation->discount_amount }}</td>
                    <td>{{ $quotation->tax_amount }}</td>
                    <td>{{ $quotation->total_amount }}</td>
                    <td>{{ $quotation->creater->name }}</td>
                    <td>{{ $quotation->created_at }}</td>
                    <td>{{ $quotation->updated_at }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>

                    @if(count($quotationReport) == 0)
                        <x-no-data-component message="{{$lang->data['no_data_found'] ?? 'No data was found..'}}" />
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>