<div>
   
<div class="row mb-2 mb-xl-3">
    <div class="col-auto d-none d-sm-block">
        <h3><strong>{{$lang->data['invoices'] ?? 'Invoices'}}</strong></h3>
    </div>
    @if(Auth::user()->can('add_invoice'))
    <div class="col-auto ms-auto text-end mt-n1">
        <a href="{{route('admin.add_invoice')}}" class="btn btn-primary">{{$lang->data['new_invoice'] ?? 'New Invoice'}}</a>
    </div>
    @endif
</div>

<div class="row">
    <div class="col-12">
        <div class="card p-0">
            <div class="card-body p-0">
                <table class="table table-striped table-bordered mb-0">
                    <thead class="bg-secondary-light">
                        <tr>
                            <th class="tw-5">{{$lang->data['sl'] ?? 'Sl'}}</th>
                            <th class="tw-15">{{$lang->data['invoice_number'] ?? 'Invoice Number'}}</th>
                            <th class="tw-10">{{$lang->data['customer_name'] ?? 'Name'}}</th>
                            <th class="tw-10">{{$lang->data['address'] ?? 'Address'}}</th>
                            <th class="tw-10">{{$lang->data['date'] ?? 'Date'}}</th>
                            <th class="tw-10">{{$lang->data['total_amount'] ?? 'Total Amount'}}</th>
                            <th class="tw-15">{{$lang->data['pay'] ?? 'Invoice 1'}}</th>
                            <th class="tw-15">{{$lang->data['pay'] ?? 'Invoice 2'}}</th>
                            <th class="tw-15">{{$lang->data['actions'] ?? 'Actions'}}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($invoices as $item)
                        <tr>
                            <td>{{$loop->index + 1}}</td>
                            <td>{{$item->invoice_number}}</td>
                            <td>{{$item->customer->name}}</td>
                            <td>{{$item->address}}</td>
                            <td>{{$item->date}}</td>
                            <td>{{getCurrency()}}{{$item->total_amount}}</td>
                            <td>
                                @if(Auth::user()->can('invoice_list'))
                                    @if($item->first_invoice==100)
                                     <a href="{{ url('/admin/invoices/print/'.$item->id.'/1'.'/'.$item->first_invoice.'/0') }}" class="btn btn-sm btn-success">{{$lang->data['print_invoice'] ?? 'Print invoice'}}</a>
                                        @if($item->first_invoice_amount==$item->first_invoice_paid)
                                            <a href="#" class="btn btn-sm btn-success">{{$lang->data['pay_invoice'] ?? 'Invoice Paid'}}</a>
                                        @else
                                            <a href="#" class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#Modalpayment" wire:click='payment({{$item}},0)'>{{$lang->data['pay_invoice'] ?? 'Pay invoice'}}<br>{{$lang->data['first_due_date'] ?? 'Due Date:'.$item->first_due_date}}</a>
                                        @endif
                                    @endif

                                    @if($item->first_invoice<100)
                                     <a href="{{ url('/admin/invoices/print/'.$item->id.'/1'.'/'.$item->first_invoice.'/1') }}" class="btn btn-sm btn-success">{{$lang->data['print_invoice'] ?? 'Print invoice'.$item->invoice_number.'-1'}}</a>
                                        @if($item->first_invoice_amount==$item->first_invoice_paid)
                                            <a href="#" class="btn btn-sm btn-success">{{$lang->data['pay_invoice'] ?? 'First Invoice Paid'}}</a>
                                        @else
                                            <a href="#" class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#Modalpayment" wire:click='payment({{$item}},1)'>{{$lang->data['pay_invoice'] ?? 'Pay invoice'.$item->invoice_number.'-1'}}<br>{{$lang->data['first_due_date'] ?? 'Due Date:'.$item->first_due_date}}</a>
                                        @endif
                                       
                                    @endif
                                @endif
                            </td>
                            <td>
                                @if(Auth::user()->can('invoice_list'))
                                    @if($item->first_invoice<100)
                                      @php
                                            $per=100-$item->first_invoice;
                                        @endphp
                                        <a href="{{ url('/admin/invoices/print/'.$item->id.'/1'.'/'.$per.'/2') }}" class="btn btn-sm btn-success">{{$lang->data['print_invoice'] ?? 'Print invoice'.$item->invoice_number.'-2'}}</a>
                                        @if($item->second_invoice_amount==$item->second_invoice_paid)
                                            <a href="#" class="btn btn-sm btn-success">{{$lang->data['pay_invoice'] ?? 'Second Invoice Paid'}}</a>
                                        @else
                                            <a href="#" class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#Modalpayment" wire:click='payment({{$item}},2)'>{{$lang->data['pay_invoice'] ?? 'Pay invoice'.$item->invoice_number.'-2'}}<br>{{$lang->data['second_due_date'] ?? 'Due Date:'.$item->second_due_date}}</a>
                                        @endif
                                    @endif
                                @endif
                            </td>
                
                            <td>
                                
                                @if(Auth::user()->can('invoice_list'))
                                   

                                 
                                
                                    

                                @if(Auth::user()->can('edit_invoice'))
                                <a href="{{route('admin.edit_invoice',$item->id)}}" class="btn btn-sm btn-primary">{{$lang->data['edit'] ?? 'Edit'}}</a>
                                @endif

                                @if(Auth::user()->can('delete_invoice'))
                                <a href="#" class="btn btn-sm btn-danger" wire:click="delete({{$item}})">{{$lang->data['delete'] ?? 'Delete'}}</a>
                                @endif

                                @endif

                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                @if(count($invoices) == 0)
                    <x-no-data-component message="{{$lang->data['no_invoices_found'] ?? 'No invoices were found..'}}" />
                @endif
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="Modalpayment" tabindex="-1" role="dialog" aria-hidden="true" wire:ignore.self>
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">{{$lang->data['make_appointment']??'Make Appointment'}}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="mb-3 col-md-6">
                        <label class="form-label">{{$lang->data['amount']??'Amount'}} <span class="text-danger"><strong>*</strong></span></label>
                        <input type="text" class="form-control" id="inputEmail4" placeholder="{{$lang->data['amount']??''}}" wire:model="amount" Readonly>
                        @error('amount')
                            <span class="text-danger">{{$message}}</span>
                        @enderror
                        <input type="hidden" wire:model="no">
                        <input type="hidden" wire:model="invoice_id">
                    </div>
                    <div class="mb-3 col-md-6">
                        <label class="form-label">{{$lang->data['paid_amount']??'Paid Amount'}} <span class="text-danger"><strong>*</strong></span></label>
                        <input type="text" class="form-control" id="inputEmail4" placeholder="{{$lang->data['paid_amount']??''}}" wire:model="paid_amount" Readonly>
                        @error('paid_amount')
                            <span class="text-danger">{{$message}}</span>
                        @enderror
                    </div>
                    <div class="mb-3 col-md-6">
                        <label class="form-label">{{$lang->data['pay']??'Pay'}} <span class="text-danger"><strong>*</strong></span></label>
                        <input type="text" class="form-control" id="inputEmail4" placeholder="{{$lang->data['pay']??''}}" wire:model="pay">
                        @error('pay')
                            <span class="text-danger">{{$message}}</span>
                        @enderror
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{$lang->data['close']??'Close'}}</button>
                <button type="button" class="btn btn-success" wire:click="savepayment">{{$lang->data['save']??'Save'}}</button>
            </div>
        </div>
    </div>
</div>

</div>
