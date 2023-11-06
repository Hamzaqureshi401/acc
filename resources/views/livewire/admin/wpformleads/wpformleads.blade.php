<div>
    <div class="row mb-2 mb-xl-3">
        <div class="col-auto d-none d-sm-block">
            <h3><strong>{{$lang->data['wpform_leads']??'Contact'}}</strong></h3>
        </div>
<!-- 
        <div class="col-auto ms-auto text-end mt-n1">
            @if(Auth::user()->can('add_lead'))
            <a href="#" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#Modallead" wire:click="resetFields">{{$lang->data['new_lead']??'New
                lead'}}</a>
            @endif
        </div> -->
    </div>
    <div class="row">
        <div class="col-12">
            <div class="card p-0">
                <div class="card-header p-3">
                    <!-- <div class="row">
                        <div class="col-md-3">
                            <label>{{$lang->data['search_customer'] ?? 'Search Lead'}}</label>
                            <input type="text" class="form-control" placeholder="{{$lang->data['all_leads'] ?? 'All Leads'}}" wire:model='search'>
                        </div>
                    </div> -->
                </div>
                <div class="card-body p-0">
                    <table id="table" class="table datatable table-striped table-bordered mb-0">
                        <thead class="bg-secondary-light">
                            <tr>
                                <th class="tw-5">{{$lang->data['sl']??'Sl'}}</th>
                                <th class="tw-20">{{$lang->data['date']??'Datum Tijd'}}</th>
                                <th class="tw-20">{{$lang->data['name']??'Naam'}}</th>
                                <th class="tw-15">{{$lang->data['phone']??'Phone'}}</th>
                                <th class="tw-15">{{$lang->data['email']??'E-mail'}}</th>
                                <th class="tw-30">{{$lang->data['address']??'Address'}}</th>
                                <th class="tw-10">{{$lang->data['actions']??'Actions'}}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($leads as $item)
                            <tr>
                                <td>{{$loop->index+1}}</td>
                                <td>{{$item->created_at}}</td>
                                <td>{{$item->name}}</td>
                                <td>{{$item->phone}}</td>
                                <td>{{$item->email}}</td>
                                <td>{{Str::limit($item->address,60)}}</td>
                                <td>
                                @if ($item->quotation_status==0)
                                    <a href="{{route('admin.add_quotation')}}" class="btn btn-sm btn-success">{{$lang->data['make_quotation']??'Make Quotation'}}</a>
                                @else
                                    @if($item->appointment_status==0)
                                            
                                    <!--    @if(Auth::user()->can('edit_lead'))
                                        <a href="#" class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#EditModallead" wire:click='edit({{$item}})'>{{$lang->data['edit']??'Edit'}}</a>
                                        @endif
                                        
                                        @if(Auth::user()->can('delete_lead'))
                                        <a href="#" class="btn btn-sm btn-danger" wire:click="delete({{$item}})">{{$lang->data['delete']??'Delete'}}</a>
                                        @endif !-->
                                        @if(Auth::user()->can('add_appointment'))
                                        <a href="{{route('admin.appointments')}}" class="btn btn-sm btn-success">{{$lang->data['make_quotation']??'Make Appointment'}}</a>
                                           <!-- <a href="#" class="btn btn-sm btn-success" data-bs-toggle="modal" data-bs-target="#MakeAppointment" wire:click="appointment({{$item}})">{{$lang->data['make_appointment']??'Make Appointment'}}</a> !-->
                                    
                                        @endif
                                    @else
                                            <a 
                                            href="#" 
                                            class="btn btn-sm btn-success" 
                                            data-bs-toggle="modal" 
                                            data-bs-target="#AppointmentData" 
                                            wire:click="loadRelatedAppointments({{$item->id}})">
                                            {{$lang->data['appointment_scheduled']??'Appointment Scheduled'}}</a>
                                    @endif
                                @endif
                            </td>
                                
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    @if(count($leads) == 0)
                        <x-no-data-component message="No leads were found" messageindex="no_leads_found"/>
                    @endif
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="Modallead" tabindex="-1" role="dialog" aria-hidden="true" wire:ignore.self>
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">{{$lang->data['add_new_lead']??'Add New Lead'}}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="mb-3 col-md-6">
                            <label class="form-label">{{$lang->data['name']??'Name'}} <span class="text-danger"><strong>*</strong></span></label>
                            <input type="text" class="form-control" id="inputEmail4" placeholder="{{$lang->data['name']??'Name'}}" wire:model="name">
                            @error('name')
                                <span class="text-danger">{{$message}}</span>
                            @enderror
                        </div>
                        <div class="mb-3 col-md-6">
                            <label class="form-label">{{$lang->data['phone_number']??'Phone Number'}}<span
                                    class="text-danger"><strong>*</strong></span></label>
                            <input type="text" class="form-control" placeholder="{{$lang->data['phone']??'Phone'}}" wire:model="phone">
                            @error('phone')
                                <span class="text-danger">{{$message}}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">{{$lang->data['email']??'Email'}}</label>
                        <input type="text" class="form-control" placeholder="{{$lang->data['email']??'Email'}}" wire:model="email">
                        @error('email')
                            <span class="text-danger">{{$message}}</span>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label class="form-label">{{$lang->data['address']??'Address'}}</label>
                        <textarea class="form-control resize-none" placeholder="{{$lang->data['address']??'Address'}}" wire:model="address"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{$lang->data['close']??'Close'}}</button>
                    <button type="button" class="btn btn-success" wire:click="create">{{$lang->data['save']??'Save'}}</button>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="EditModallead" tabindex="-1" role="dialog" aria-hidden="true" wire:ignore.self>
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">{{$lang->data['edit_lead']??'Edit lead'}}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="mb-3 col-md-6">
                            <label class="form-label">{{$lang->data['name']??'Name'}} <span class="text-danger"><strong>*</strong></span></label>
                            <input type="text" class="form-control" id="inputEmail4" placeholder="{{$lang->data['name']??'Name'}}" wire:model="name">
                            @error('name')
                                <span class="text-danger">{{$message}}</span>
                            @enderror
                        </div>
                        <div class="mb-3 col-md-6">
                            <label class="form-label">{{$lang->data['phone_number']??'Phone Number'}}<span
                                    class="text-danger"><strong>*</strong></span></label>
                            <input type="text" class="form-control" placeholder="{{$lang->data['phone']??'Phone'}}" wire:model="phone">
                            @error('phone')
                                <span class="text-danger">{{$message}}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">{{$lang->data['email']??'Email'}}</label>
                        <input type="text" class="form-control" placeholder="{{$lang->data['email']??'Email'}}" wire:model="email">
                        @error('email')
                            <span class="text-danger">{{$message}}</span>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label class="form-label">{{$lang->data['address']??'Address'}}</label>
                        <textarea class="form-control resize-none" placeholder="{{$lang->data['address']??'Address'}}" wire:model="address"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{$lang->data['close']??'Close'}}</button>
                    <button type="button" class="btn btn-success" wire:click="update">{{$lang->data['save']??'Save'}}</button>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="MakeAppointment" tabindex="-1" role="dialog" aria-hidden="true" wire:ignore.self>
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">{{$lang->data['make_appointment']??'Make Appointment'}}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <input type="hidden" class="form-control" id="inputEmail4" wire:model="lead_id" >
                       
                    <div class="mb-3 col-md-6">
                            <label class="form-label">{{$lang->data['end_date']??'Lead name'}} <span class="text-danger"><strong>*</strong></span></label>
                            <input type="text" class="form-control" id="inputEmail4" placeholder="{{$lang->data['end_date']??''}}" wire:model="lead_name" Readonly required>
                            @error('lead_name')
                                <span class="text-danger">{{$message}}</span>
                            @enderror
                        </div>
                    <div class="mb-3 col-md-6">
                            <label class="form-label">{{$lang->data['end_date']??'Quotation No'}} <span class="text-danger"><strong>*</strong></span></label>
                            <input type="text" class="form-control" id="inputEmail4" placeholder="{{$lang->data['end_date']??''}}" wire:model="quotation_no" Readonly required>
                            @error('quotation_no')
                                <span class="text-danger">{{$message}}</span>
                            @enderror
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
                        
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{$lang->data['close']??'Close'}}</button>
                    <button type="button" class="btn btn-success" wire:click="create">{{$lang->data['save']??'Save'}}</button>
                </div>
            </div>
        </div>
    </div>
    
   <div class="modal fade" id="AppointmentData" tabindex="-1" role="dialog" aria-hidden="true" wire:ignore.self>
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">{{$lang->data['add_new_lead']??'Appointment Details'}}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" wire:key="modal-content">
                
                <p><strong>Start Date:</strong> {{ $appointment->start_date ?? '' }}</p>
                <p><strong>Start Time:</strong> {{ $appointment->start_time ?? '' }}</p>
                <p><strong>End Time:</strong> {{ $appointment->end_time ?? '' }}</p>
                <p><strong>Quotation Number:</strong> {{ $appointment->quotation_no ?? '' }}</p>
                <!-- Add more appointment details as needed -->
                <p><strong>Lead:</strong> {{ $appointment->lead->name ?? '' }}</p>
                <p><strong>Type:</strong> {{ $appointment->type ?? '' }}</p>
               <!--  <p><strong>Created By:</strong> {{ $appointment->creater->name ?? '' }}</p>
                <p><strong>Customer Status:</strong> {{ $appointment->customer_status ?? '' }}</p>
                <p><strong>Status:</strong> {{ $appointment->status ?? '' }}</p>
                <p><strong>Created At:</strong> {{ $appointment->created_at ?? '' }}</p> -->
                </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{$lang->data['close']??'Close'}}</button>
                
            </div>
        </div>
    </div>
</div>

    
</div>