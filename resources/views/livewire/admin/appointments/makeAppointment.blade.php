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
                            <label class="form-label">{{$lang->data['end_date']??'Lead name'}} <span class="text-danger"><strong>*</strong></span></label>
                            <input type="text" class="form-control" id="inputEmail4" placeholder="{{$lang->data['end_date']??''}}" wire:model="lead_name" Readonly required>
                            @error('lead_name')
                                <span class="text-danger">{{$message}}</span>
                            @enderror
                        </div>
                        <div class="mb-3 col-md-6">
                            <label class="form-label">{{ $lang->data['end_date'] ?? 'Quotation No' }} <span
                                    class="text-danger"></span></label>
                            <input tabindex="2" type="text" class="form-control" id="inputEmail4"
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
                            <input tabindex="3" type="text" class="form-control" id="start_time" placeholder="HH:mm"
                                wire:model="start_time" pattern="([01]?[0-9]|2[0-3]):[0-5][0-9]">
                            @error('start_time')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="mb-3 col-md-6">
                            <label class="form-label">{{ $lang->data['end_time'] ?? 'End Time' }} <span
                                    class="text-danger"><strong>*</strong></span></label>
                            <input tabindex="4" type="text" class="form-control" id="end_time" placeholder="HH:mm"
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