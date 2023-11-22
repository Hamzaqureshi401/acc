<div>

    <div class="row mb-2 mb-xl-3">
        <div class="col-auto d-none d-sm-block">
            <h3><strong>{{ $lang->data['quotations'] ?? 'Quotations' }}</strong></h3>
        </div>
        @if (Auth::user()->can('add_quotation'))
            <div class="col-auto ms-auto text-end mt-n1">
                <a href="{{ route('admin.add_quotation') }}"
                    class="btn btn-primary">{{ $lang->data['new_quotation'] ?? 'New Quotation' }}</a>
            </div>
            {{-- <div class="col-auto ms-auto text-end mt-n1">
                <a href="#" class="btn btn-sm btn-success" wire:click="makeclient()">{{ 'Make Client' }}</a>
            </div> --}}
        @endif
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card p-0">
                <div class="card-body p-0">
                    <table id="table" class="table table-striped table-bordered table-responsive mb-0">
                        <thead class="bg-secondary-light">
                            <tr>
                                <th class="tw-5">{{ $lang->data['sl'] ?? 'Sl' }}</th>
                                <th class="tw-15">{{ $lang->data['quotation_number'] ?? 'Quotation Number' }}</th>
                                <th class="tw-10">{{ $lang->data['customer_name'] ?? 'Lead Name' }}</th>
                                <th class="tw-10">{{ $lang->data['address'] ?? 'Address' }}</th>
                                <th class="tw-10">{{ $lang->data['created_date'] ?? 'Created Date' }}</th>
                                <th class="tw-10">{{ $lang->data['expiry_date'] ?? 'Expiry Date' }}</th>
                                <th class="tw-10">{{ $lang->data['stage'] ?? 'Stage' }}</th>
                                <th class="tw-10">{{ $lang->data['total_amount'] ?? 'Total Amount' }}</th>
                                <th class="tw-15">{{ $lang->data['actions'] ?? 'Actions' }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($quotations as $item)
                                @php
                                    $appointment = App\Models\Appointment::where('lead_id', $item->lead_id)->first();
                                @endphp
                                <tr>
                                    <td>{{ $loop->index + 1 }}</td>
                                    <td>{{ $item->quotation_number }}</td>
                                    <td>{{ $item->lead->name }}</td>
                                    <td>{{ $item->lead->postcode }},{{ $item->lead->address }},{{ $item->lead->city }}
                                    </td>
                                    <td>{{ $item->created_date }}</td>
                                    <td>{{ $item->expiry_date }}</td>
                                    <td><span class="badge bg-dark">{{ $item->stage }}</span></td>
                                    <td>{{ getCurrency() }}{{ $item->total_amount }}</td>

                                    <td>

                                        @if (Auth::user()->can('quotation_list'))
                                            <a href="{{ url('/admin/quotations/print/' . $item->id . '/1') }}"
                                                target="__blank"
                                                class="btn btn-sm btn-success">{{ $lang->data['print_quotation'] ?? 'Print Quotation' }}</a>
                                        @endif

                                        @if (Auth::user()->can('edit_quotation'))
                                            <a href="{{ route('admin.edit_quotation', $item->id) }}"
                                                class="btn btn-sm btn-primary">{{ $lang->data['edit'] ?? 'Edit' }}</a>
                                        @endif

                                        @if (Auth::user()->can('delete_quotation'))
                                            <a href="#" class="btn btn-sm btn-danger"
                                                wire:click="delete({{ $item }})">{{ $lang->data['delete'] ?? 'Delete' }}</a>
                                        @endif
                                        @if ($appointment->customer_status == 0)
                                            @if (Auth::user()->can('add_customer'))
                                                <a href="#" class="btn btn-sm btn-success"
                                                    wire:click="makeclient({{ $item->lead_id }})">{{ $lang->data['make_appointment'] ?? 'Make Client' }}</a>
                                            @endif
                                        @else
                                            <a href="{{ route('admin.customers') }}"
                                                class="btn btn-sm btn-success">{{ $lang->data['converted_to_client'] ?? 'Converted To Client' }}</a>
                                        @endif


                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    @if (count($quotations) == 0)
                        <x-no-data-component
                            message="{{ $lang->data['no_quotations_found'] ?? 'No quotations were found..' }}" />
                    @endif
                </div>
            </div>
        </div>
    </div>


</div>
