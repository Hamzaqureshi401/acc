<div>
    <div class="row mb-2 mb-xl-3">
        <div class="col-auto d-none d-sm-block">
            <h3><strong>{{$lang->data['appointments']??'Appointments'}}</strong></h3>
        </div>

        <div class="col-auto ms-auto text-end mt-n1">
            @if(Auth::user()->can('add_appointment'))
            <a href="#" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#ModalAppointment" wire:click="resetFields">{{$lang->data['new_appointment']??'New
                Appointment'}}</a>
            @endif
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <div class="card p-0">
                <div class="card-header p-3">
                </div>
                <div class="card-body p-0">
                    <table id="table" class="table table-striped table-bordered table-responsive mb-0">
                        <thead class="bg-secondary-light">
                            <tr>
                                <th class="tw-5">{{$lang->data['sl']??'Sl'}}</th>
                                <th class="tw-15">{{$lang->data['name']??'Name'}}</th>
                                <th class="tw-15">{{$lang->data['phone']??'Phone'}}</th>
                                <th class="tw-15">{{$lang->data['email']??'Email'}}</th>
                                <th class="tw-15">{{$lang->data['start_time']??'Start Time'}}</th>
                                <th class="tw-15">{{$lang->data['end_time']??'End Time'}}</th>
                                <th class="tw-15">{{$lang->data['start_date']??'Start Date'}}</th>
                                <th class="tw-15">{{$lang->data['Quotation_no']??'Quotation No.'}}</th>
                                <th class="tw-15">{{$lang->data['Type']??'Type'}}</th>
                                <th class="tw-10">{{$lang->data['actions']??'Actions'}}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($appointments as $item)
                            <tr>
                                <td>{{$loop->index+1}}</td>
                                <td>{{$item->lead->name}}</td>
                                <td>{{$item->lead->phone}}</td>
                                <td>{{$item->lead->email}}</td>
                                <td>{{$item->start_time}}</td>
                                <td>{{$item->end_time}}</td>
                                <td>{{$item->start_date}}</td>
                                <td>{{$item->quotation_no}}</td>
                                <td>{{$item->type}}</td>
                                <td>
                                
                                
                                        @if(Auth::user()->can('edit_appointment'))
                                        <a href="#" class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#EditModalAppointment" wire:click='edit({{$item}})'>{{$lang->data['edit']??'Edit'}}</a>
                                        @endif
                                @if($item->status==0)
                                    @if($item->customer_status==0)
                                        @if(Auth::user()->can('delete_appointment'))
                                        <a href="#" class="btn btn-sm btn-danger" wire:click="delete({{$item}})">{{$lang->data['delete']??'Delete'}}</a>
                                        @endif
                                        @if(Auth::user()->can('add_customer'))
                                        <a href="#" class="btn btn-sm btn-success" wire:click="makeclient({{$item}})">{{$lang->data['make_appointment']??'Make Client'}}</a>
                                        @endif
                                        @if(Auth::user()->can('delete_appointment'))
                                        <a href="#" class="btn btn-sm btn-danger" wire:click="cancel({{$item}})">{{$lang->data['cancel_appointment']??'Cancel Appointment'}}</a>
                                        @endif
                                    @else
                                        <a href="{{ route('admin.customers') }}" class="btn btn-sm btn-success" >{{$lang->data['converted_to_client']??'Converted To Client'}}</a>
                                    @endif
                                @else
                                    <a href="" class="btn btn-sm btn-danger" >{{$lang->data['appointment_canceled']??'Appointment Canceled'}}</a>
                                @endif  
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    @if(count($appointments) == 0)
                        <x-no-data-component message="No leads were found" messageindex="no_leads_found"/>
                    @endif
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="ModalAppointment" tabindex="-1" role="dialog" aria-hidden="true" wire:ignore.self>
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">{{$lang->data['make_appointment']??'Make Appointment'}}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="mb-3 col-md-6">
                            <label class="form-label">{{$lang->data['select_lead']??'Select Lead'}} <span class="text-danger"><strong>*</strong></span></label>
                            <select class="form-control" wire:change="quotationData" wire:model="lead_id">
                                <option selected value="">{{$lang->data['choose'] ?? 'Choose...'}}</option>
                                @foreach ($leads as $item)
                                    <option value="{{$item->id}}">{{$item->name}}</option>
                                @endforeach
                            </select>
                            @error('lead_id')
                                <span class="text-danger">{{$message}}</span>
                            @enderror
                        </div>
                        <div class="mb-3 col-md-6">
                            <label class="form-label">{{$lang->data['end_date']??'Quotation No'}} <span class="text-danger"><strong>*</strong></span></label>
                            <input type="text" class="form-control" id="inputEmail4" placeholder="HH:mm" wire:model="quotation_no" Readonly required>
                            @error('quotation_no')
                                <span class="text-danger">{{$message}}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="row">
                        <div class="mb-3 col-md-6">
                            <label class="form-label">{{$lang->data['start_time']??'Start Time'}} <span class="text-danger"><strong>*</strong></span></label>
                            <input type="text" class="form-control" id="start_time" placeholder="HH:mm" wire:model="start_time">
                            @error('start_time')
                                <span class="text-danger">{{$message}}</span>
                            @enderror
                        </div>
                        <div class="mb-3 col-md-6">
                            <label class="form-label">{{$lang->data['end_time']??'End Time'}} <span class="text-danger"><strong>*</strong></span></label>
                            <input type="text" class="form-control" id="end_time" placeholder="{{$lang->data['end_time']??'End Time'}}" wire:model="end_time">
                            @error('end_time')
                                <span class="text-danger">{{$message}}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="row">
                        <div class="mb-3 col-md-6">
                            <label class="form-label">{{$lang->data['start_date']??'Start Date'}} <span class="text-danger"><strong></strong></span></label>
                            <input type="date" id="theDate" class="form-control" value="{{ date('Y-m-d') }}" placeholder="{{$lang->data['start_date']??'Start Date'}}" wire:model="start_date">
                            @error('start_date')
                                <span class="text-danger">{{$message}}</span>
                            @enderror
                        </div>
                        
                        <div class="mb-3 col-md-6">
                            <label class="form-label">{{$lang->data['select_type']??'Select Type'}} <span class="text-danger"><strong>*</strong></span></label>
                            <select class="form-control" wire:model="type">
                                <option selected value="">{{$lang->data['choose'] ?? 'Choose...'}}</option>
                                <option value="Quote">Quote</option>
                                <option value="Delivery&Install">Delivery&Install</option>
                                <option value="Repair">Repair</option>
                                <option value="Service">Service</option>
                            </select>
                            @error('type')
                                <span class="text-danger">{{$message}}</span>
                            @enderror
                        </div>
                    </div>
                     <div class="row">
                         <div class="mb-3 col-md-12">
                            <label class="form-label">{{$lang->data['end_date']??'Custom Note'}} <span class="text-danger"><strong></strong></span></label>
                            <input type="text" class="form-control" id="custom_note" placeholder="{{$lang->data['custom_note']??'Add Custom Note'}}" wire:model="custom_note">
                            @error('custom_note')
                                <span class="text-danger">{{$message}}</span>
                            @enderror
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{$lang->data['close']??'Close'}}</button>
                    <button type="button" class="btn btn-success" wire:click="create">{{$lang->data['save']??'Save'}}</button>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="EditModalAppointment" tabindex="-1" role="dialog" aria-hidden="true" wire:ignore.self>
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">{{$lang->data['edit_appointment']??'Edit Appointment'}}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="mb-3 col-md-6">
                            <label class="form-label">{{$lang->data['lead']??'Lead'}} <span class="text-danger"><strong>*</strong></span></label>
                            <input type="text" class="form-control" id="inputEmail4" placeholder="{{$lang->data['lead']??'Lead'}}" wire:model="lead_name" readonly>
                        </div>
                    </div>
                    <div class="row">
                        <div class="mb-3 col-md-6">
                            <label class="form-label">{{$lang->data['start_time']??'Start Time'}} <span class="text-danger"><strong>*</strong></span></label>
                            <input type="time" class="form-control" id="inputEmail4" placeholder="{{$lang->data['start_time']??'Start Time'}}" wire:model="start_time">
                            @error('start_time')
                                <span class="text-danger">{{$message}}</span>
                            @enderror
                        </div>
                        <div class="mb-3 col-md-6">
                            <label class="form-label">{{$lang->data['end_time']??'End Time'}} <span class="text-danger"><strong>*</strong></span></label>
                            <input type="time" class="form-control" id="inputEmail4" placeholder="{{$lang->data['end_time']??'End Time'}}" wire:model="end_time">
                            @error('end_time')
                                <span class="text-danger">{{$message}}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="row">
                        <div class="mb-3 col-md-6">
                            <label class="form-label">{{$lang->data['start_date']??'Start Date'}} <span class="text-danger"><strong>*</strong></span></label>
                            <input type="date" class="form-control" id="inputEmail4" placeholder="{{$lang->data['start_date']??'Start Date'}}" wire:model="start_date">
                            @error('start_date')
                                <span class="text-danger">{{$message}}</span>
                            @enderror
                        </div>
                        <div class="mb-3 col-md-6">
                            <label class="form-label">{{$lang->data['end_date']??'Quotation No'}} <span class="text-danger"><strong>*</strong></span></label>
                            <input type="text" class="form-control" id="inputEmail4" placeholder="{{$lang->data['end_date']??'End Date'}}" wire:model="quotation_no">
                            @error('quotation_no')
                                <span class="text-danger">{{$message}}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="row">
                        <div class="mb-3 col-md-6">
                            <label class="form-label">{{$lang->data['select_type']??'Select Type'}} <span class="text-danger"><strong>*</strong></span></label>
                            <select class="form-control" wire:model="type">
                                <option selected value="">{{$lang->data['choose'] ?? 'Choose...'}}</option>
                                <option value="Quote">Quote</option>
                                <option value="Delivery&Install">Delivery&Install</option>
                                <option value="Repair">Repair</option>
                                <option value="Service">Service</option>
                            </select>
                            @error('type')
                                <span class="text-danger">{{$message}}</span>
                            @enderror
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{$lang->data['close']??'Close'}}</button>
                    <button type="button" class="btn btn-success" wire:click="update">{{$lang->data['save']??'Save'}}</button>
                </div>
            </div>
        </div>
    </div>
</div>