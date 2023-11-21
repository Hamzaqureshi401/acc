<div>
    <div class="row mb-2 mb-xl-3">
        <div class="col-auto d-none d-sm-block">
            <h3><strong>{{ $lang->data['leads'] ?? 'Leads' }}</strong></h3>
        </div>

        <div class="col-auto ms-auto text-end mt-n1">
            @if (Auth::user()->can('add_lead'))
                <a href="#" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#Modallead"
                    wire:click="resetFields">{{ $lang->data['new_lead'] ??
                        'New
                                    lead' }}</a>
            @endif
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <div class="card p-0">
                <div class="card-header p-3">
                    <!-- <div class="row">
                        <div class="col-md-3">
                            <label>{{ $lang->data['search_customer'] ?? 'Search Lead' }}</label>
                            <input type="text" class="form-control" placeholder="{{ $lang->data['all_leads'] ?? 'All Leads' }}" wire:model='search'>
                        </div>
                    </div> -->
                </div>
                <div class="card-body p-0">
                    <table id="table" class="table table-striped table-bordered table-responsive mb-0">
                        <thead class="bg-secondary-light">
                            <tr>
                                <th class="tw-5">{{ $lang->data['sl'] ?? 'Sl' }}</th>
                                <th class="tw-15">{{ $lang->data['sl'] ?? 'Date' }}</th>
                                <th class="tw-20">{{ $lang->data['name'] ?? 'Name' }}</th>
                                <th class="tw-15">{{ $lang->data['phone'] ?? 'Phone' }}</th>
                                <th class="tw-20">{{ $lang->data['email'] ?? 'Email' }}</th>
                                <th class="tw-30">{{ $lang->data['address'] ?? 'Address' }}</th>
                                <th class="tw-10">{{ $lang->data['actions'] ?? 'Actions' }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($leads as $item)
                                <tr>
                                    <td>{{ $loop->index + 1 }}</td>
                                    <td>{{ $item->created_at }}</td>
                                    <td>{{ $item->name }}</td>
                                    <td>{{ $item->phone }}</td>
                                    <td>{{ $item->email }}</td>
                                    <td>{{ $item->postcode }},{{ Str::limit($item->address, 60) }},{{ $item->city }}
                                    </td>
                                    <td>
                                        @if ($item->quotation_status == 0)
                                            <!-- <a href="{{ route('admin.add_quotation') }}" class="btn btn-sm btn-success">{{ $lang->data['make_quotation'] ?? 'Make Quotation' }}</a> -->
                                            @if (Auth::user()->can('add_appointment'))
                                                <a href="#" class="btn btn-sm btn-success" data-bs-toggle="modal"
                                                    data-bs-target="#MakeAppointment"
                                                    wire:click="appointment({{ $item }})">{{ $lang->data['make_appointment'] ?? 'Make Appointment' }}</a>
                                            @endif
                                        @else
                                            @if ($item->appointment_status == 0)
                                                @if (Auth::user()->can('edit_lead'))
                                                    <a href="#" class="btn btn-sm btn-primary"
                                                        data-bs-toggle="modal" data-bs-target="#EditModallead"
                                                        wire:click='edit({{ $item }})'>{{ $lang->data['edit'] ?? 'Edit' }}</a>
                                                @endif

                                                @if (Auth::user()->can('delete_lead'))
                                                    <a href="#" class="btn btn-sm btn-danger"
                                                        wire:click="delete({{ $item }})">{{ $lang->data['delete'] ?? 'Delete' }}</a>
                                                @endif
                                                @if (Auth::user()->can('add_appointment'))
                                                    <a href="#" class="btn btn-sm btn-success"
                                                        data-bs-toggle="modal" data-bs-target="#MakeAppointment"
                                                        wire:click="appointment({{ $item }})">{{ $lang->data['make_appointment'] ?? 'Make Appointment' }}</a>
                                                @endif
                                            @else
                                                <a href="#" class="btn btn-sm btn-success" data-bs-toggle="modal"
                                                    data-bs-target="#AppointmentData"
                                                    wire:click="appointmentdata({{ $item }})">{{ $lang->data['appointment_scheduled'] ?? 'Appointment Scheduled' }}</a>
                                            @endif
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    @if (count($leads) == 0)
                        <x-no-data-component message="No leads were found" messageindex="no_leads_found" />
                    @endif
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="Modallead" tabindex="-1" role="dialog" aria-hidden="true" wire:ignore.self>
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">{{ $lang->data['add_new_lead'] ?? 'Add New Lead' }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="mb-3 col-md-6">
                            <label class="form-label">{{ $lang->data['name'] ?? 'Name' }} <span
                                    class="text-danger"><strong>*</strong></span></label>
                            <input type="text" class="form-control" id="inputEmail4"
                                placeholder="{{ $lang->data['name'] ?? 'Name' }}" wire:model="name">
                            @error('name')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="mb-3 col-md-6">
                            <label class="form-label">{{ $lang->data['phone_number'] ?? 'Phone Number' }}<span
                                    class="text-danger"><strong>*</strong></span></label>
                            <input type="text" class="form-control"
                                placeholder="{{ $lang->data['phone'] ?? 'Phone' }}" wire:model="phone">
                            @error('phone')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">{{ $lang->data['email'] ?? 'Email' }}</label>
                        <input type="text" class="form-control" placeholder="{{ $lang->data['email'] ?? 'Email' }}"
                            wire:model="email">
                        @error('email')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label class="form-label">{{ $lang->data['postcode'] ?? 'PostCode' }}<span
                                class="text-danger"><strong>*</strong></span></label>
                        <input type="number" class="form-control"
                            placeholder="{{ $lang->data['postcode'] ?? 'PostCode' }}" wire:model="postcode">
                        @error('postcode')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label class="form-label">{{ $lang->data['address'] ?? 'Address' }}<span
                                class="text-danger"><strong>*</strong></span></label>
                        <textarea class="form-control resize-none" placeholder="{{ $lang->data['address'] ?? 'Address' }}"
                            wire:model="address"></textarea>
                        @error('address')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label class="form-label">{{ $lang->data['city'] ?? 'City' }}<span
                                class="text-danger"><strong>*</strong></span></label>
                        <input type="text" class="form-control" placeholder="{{ $lang->data['city'] ?? 'City' }}"
                            wire:model="city">
                        @error('city')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary"
                        data-bs-dismiss="modal">{{ $lang->data['close'] ?? 'Close' }}</button>
                    <button type="button" class="btn btn-success"
                        wire:click="create">{{ $lang->data['save'] ?? 'Save' }}</button>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="EditModallead" tabindex="-1" role="dialog" aria-hidden="true" wire:ignore.self>
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">{{ $lang->data['edit_lead'] ?? 'Edit lead' }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="mb-3 col-md-6">
                            <label class="form-label">{{ $lang->data['name'] ?? 'Name' }} <span
                                    class="text-danger"><strong>*</strong></span></label>
                            <input type="text" class="form-control" id="inputEmail4"
                                placeholder="{{ $lang->data['name'] ?? 'Name' }}" wire:model="name">
                            @error('name')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="mb-3 col-md-6">
                            <label class="form-label">{{ $lang->data['phone_number'] ?? 'Phone Number' }}<span
                                    class="text-danger"><strong>*</strong></span></label>
                            <input type="text" class="form-control"
                                placeholder="{{ $lang->data['phone'] ?? 'Phone' }}" wire:model="phone">
                            @error('phone')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">{{ $lang->data['email'] ?? 'Email' }}</label>
                        <input type="text" class="form-control" placeholder="{{ $lang->data['email'] ?? 'Email' }}"
                            wire:model="email">
                        @error('email')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label class="form-label">{{ $lang->data['postcode'] ?? 'PostCode' }}</label>
                        <input type="text" class="form-control"
                            placeholder="{{ $lang->data['postcode'] ?? 'PostCode' }}" wire:model="postcode">
                        @error('postcode')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label class="form-label">{{ $lang->data['address'] ?? 'Address' }}</label>
                        <textarea class="form-control resize-none" placeholder="{{ $lang->data['address'] ?? 'Address' }}"
                            wire:model="address"></textarea>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">{{ $lang->data['city'] ?? 'City' }}</label>
                        <input type="text" class="form-control" placeholder="{{ $lang->data['city'] ?? 'City' }}"
                            wire:model="city">
                        @error('city')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary"
                        data-bs-dismiss="modal">{{ $lang->data['close'] ?? 'Close' }}</button>
                    <button type="button" class="btn btn-success"
                        wire:click="update">{{ $lang->data['save'] ?? 'Save' }}</button>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="MakeAppointment" tabindex="-1" role="dialog" aria-hidden="true" wire:ignore.self>
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">{{ $lang->data['make_appointment'] ?? 'Make Appointment' }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <input type="hidden" class="form-control" id="inputEmail4" wire:model="lead_id">

                        <div class="mb-3 col-md-6">
                            <label class="form-label">{{ $lang->data['end_date'] ?? 'Lead name' }} <span
                                    class="text-danger"><strong>*</strong></span></label>
                            <input  type="text" class="form-control" id="inputEmail4"
                                placeholder="{{ $lang->data['end_date'] ?? '' }}" wire:model="lead_name" Readonly
                                required>
                            @error('lead_name')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="mb-3 col-md-6">
                            <label class="form-label">{{ $lang->data['end_date'] ?? 'Quotation No' }} <span
                                    class="text-danger"></span></label>
                            <input  type="text" class="form-control" id="inputEmail4"
                                placeholder="{{ $lang->data['end_date'] ?? '' }}" wire:model="quotation_no">
                            @error('quotation_no')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="row">
                        <div class="mb-3 col-md-6">
                            <label class="form-label">{{ $lang->data['start_time'] ?? 'Start Time' }} <span
                                    class="text-danger"><strong>*</strong></span></label>
                            <input  type="text" class="form-control" id="start_time" placeholder="HH:mm"
                                wire:model="start_time" pattern="([01]?[0-9]|2[0-3]):[0-5][0-9]">
                            @error('start_time')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="mb-3 col-md-6">
                            <label class="form-label">{{ $lang->data['end_time'] ?? 'End Time' }} <span
                                    class="text-danger"><strong>*</strong></span></label>
                            <input type="text" class="form-control" id="end_time" placeholder="HH:mm"
                                wire:model="end_time" pattern="([01]?[0-9]|2[0-3]):[0-5][0-9]">
                            @error('end_time')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="row">
                        <div class="mb-3 col-md-6">
                            <label class="form-label">{{ $lang->data['start_date'] ?? 'Start Date' }} <span
                                    class="text-danger"><strong>*</strong></span></label>
                            <input type="date" class="form-control" 
                                wire:model="start_date">
                            @error('start_date')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="mb-3 col-md-6">
                            <label class="form-label">{{ $lang->data['select_type'] ?? 'Select Type' }} <span
                                    class="text-danger"><strong>*</strong></span></label>
                            <select class="form-control" wire:model="type">
                                <option selected value="">{{ $lang->data['choose'] ?? 'Choose...' }}</option>
                                <option value="Quote">Quote</option>
                                <option value="Delivery&Install">Delivery&Install</option>
                                <option value="Repair">Repair</option>
                                <option value="Service">Service</option>
                            </select>
                            @error('type')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                    </div>
                    <div class="row">
                        <div class="mb-3 col-md-12">
                            <label class="form-label">{{ $lang->data['custom_note'] ?? 'Custom Note' }} <span
                                    class="text-danger"><strong></strong></span></label>
                            <input type="text" class="form-control" id="custom_note"
                                placeholder="{{ $lang->data['custom_note'] ?? 'Add Custom Note' }}"
                                wire:model="custom_note">
                            @error('custom_note')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary"
                        data-bs-dismiss="modal">{{ $lang->data['close'] ?? 'Close' }}</button>
                    <button type="button" class="btn btn-success"
                        wire:click="makeappointment">{{ $lang->data['save'] ?? 'Save' }}</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="AppointmentData" tabindex="-1" role="dialog" aria-hidden="true" wire:ignore.self>
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">{{ $lang->data['appointment_data'] ?? 'Appointment Data' }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">

                        <div class="mb-3 col-md-6">
                            <label class="form-label">{{ $lang->data['end_date'] ?? 'Lead name' }} <span
                                    class="text-danger"></span></label>
                            <input type="text" class="form-control" id="inputEmail4"
                                placeholder="{{ $lang->data['end_date'] ?? '' }}" wire:model="data_lead_name" Readonly>
                        </div>
                        <div class="mb-3 col-md-6">
                            <label class="form-label">{{ $lang->data['end_date'] ?? 'Quotation No' }} <span
                                    class="text-danger"></span></label>
                            <input type="text" class="form-control" id="inputEmail4"
                                placeholder="{{ $lang->data['end_date'] ?? '' }}" wire:model="data_quotation_no"
                                Readonly>
                            @error('quotation_no')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="row">
                        <div class="mb-3 col-md-6">
                            <label class="form-label">{{ $lang->data['start_time'] ?? 'Start Time' }} <span
                                    class="text-danger"></span></label>
                            <input type="text" class="form-control" id="inputEmail4"
                                placeholder="{{ $lang->data['start_time'] ?? 'Start Time' }}"
                                wire:model="data_start_time" Readonly>
                        </div>
                        <div class="mb-3 col-md-6">
                            <label class="form-label">{{ $lang->data['end_time'] ?? 'End Time' }} <span
                                    class="text-danger"></span></label>
                            <input type="text" class="form-control" id="inputEmail4"
                                placeholder="{{ $lang->data['end_time'] ?? 'End Time' }}" wire:model="data_end_time"
                                Readonly>
                        </div>
                    </div>
                    <div class="row">
                        <div class="mb-3 col-md-6">
                            <label class="form-label">{{ $lang->data['start_date'] ?? 'Start Date' }} <span
                                    class="text-danger"></span></label>
                            <input type="text" class="form-control" id="inputEmail4"
                                placeholder="{{ $lang->data['start_date'] ?? 'Start Date' }}"
                                wire:model="data_start_date" Readonly>
                        </div>
                        <div class="mb-3 col-md-6">
                            <label class="form-label">{{ $lang->data['type'] ?? 'Type' }} <span
                                    class="text-danger"></span></label>
                            <input type="text" class="form-control" id="inputEmail4"
                                placeholder="{{ $lang->data['start_date'] ?? 'Start Date' }}" wire:model="data_type"
                                Readonly>

                        </div>

                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary"
                        data-bs-dismiss="modal">{{ $lang->data['close'] ?? 'Close' }}</button>
                </div>
            </div>
        </div>
    </div>

</div>
<script>
    window.onkeydown = function(e) {
        if (e.which == 9) { // Tab key
            e.preventDefault();
            var inputs = $('#MakeAppointment input, #MakeAppointment select');
            var activeElement = document.activeElement;
            console.log(activeElement);
            // Check if the active element is a flatpicker-hour input
            if ($(activeElement).hasClass('flatpicker-hour')) {
                console.log('activeflat', activeElement);
                // Focus on the next input element (skip the flatpicker-hour inputs)
                var nextInput = inputs.get(inputs.index(activeElement) + 1);
                if (nextInput) {
                    nextInput.focus();
                }
            } else {
                // Focus on the next input or select element
                var nextInput = inputs.get(inputs.index(activeElement) + 1);
                console.log(nextInput);
                if (nextInput) {
                    nextInput.focus();
                }
            }
        }
    };
</script>



