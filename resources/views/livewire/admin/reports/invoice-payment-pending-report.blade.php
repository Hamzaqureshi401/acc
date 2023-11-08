<div>

<div class="row mb-2 mb-xl-3">
        <div class="col-auto d-none d-sm-block">
            <h3><strong>{{$lang->data['customer_report'] ?? 'Client Invoice Payment Pending Report'}}</strong></h3>
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
                <th>Invoice Number</th>
                <th>Date</th>
                <th>Customer ID</th>
                <th>Address</th>
                <th>Type</th>
                <th>Sub Total</th>
                <th>Discount Amount</th>
                <th>Tax Amount</th>
                <th>Total Amount</th>
                <th>First Invoice Amount</th>
                <th>First Due Date</th>
                <th>Second Invoice Amount</th>
                <th>Second Due Date</th>
                <th>Created By</th>
                <th>Created At</th>
                <th>Updated At</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($invoicePaymentPendingReport as $invoice)
                <tr>
                    <td>{{ $invoice->id }}</td>
                    <td>{{ $invoice->invoice_number }}</td>
                    <td>{{ $invoice->date }}</td>
                    <td>{{ $invoice->customer->name }}</td>
                    <td>{{ $invoice->address }}</td>
                    <td>{{ $invoice->type }}</td>
                    <td>{{ $invoice->sub_total }}</td>
                    <td>{{ $invoice->discount_amount }}</td>
                    <td>{{ $invoice->tax_amount }}</td>
                    <td>{{ $invoice->total_amount }}</td>
                    <td>{{ $invoice->first_invoice_amount }}</td>
                    <td>{{ $invoice->first_due_date }}</td>
                    <td>{{ $invoice->second_invoice_amount }}</td>
                    <td>{{ $invoice->second_due_date }}</td>
                    <td>{{ $invoice->created_by }}</td>
                    <td>{{ $invoice->created_at }}</td>
                    <td>{{ $invoice->updated_at }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>

                    @if(count($invoicePaymentPendingReport) == 0)
                        <x-no-data-component message="{{$lang->data['no_data_found'] ?? 'No data was found..'}}" />
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>