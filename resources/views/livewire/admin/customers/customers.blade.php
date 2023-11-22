<div>
    <div class="row mb-2 mb-xl-3">
        <div class="col-auto d-none d-sm-block">
            <h3><strong>{{ $lang->data['customers'] ?? 'Clients' }}</strong></h3>
        </div>

        <div class="col-auto ms-auto text-end mt-n1">
            @if (Auth::user()->can('add_customer'))
                <a href="#" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#ModalCustomer"
                    wire:click="resetFields">{{ $lang->data['new_customer'] ??
                        'New
                                                                            Client' }}</a>
            @endif
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <div class="card p-0">
                <div class="card-body p-0">
                    <table id="table" class="table table-striped table-bordered mb-0">
                        <thead class="bg-secondary-light">
                            <tr>
                                <th class="tw-5">{{ $lang->data['sl'] ?? 'Sl' }}</th>
                                <th class="tw-5">{{ 'Image' }}</th>
                                <th class="tw-15">{{ $lang->data['name'] ?? 'Name' }}</th>
                                <th class="tw-15">{{ $lang->data['phone'] ?? 'Phone' }}</th>
                                <th class="tw-15">{{ $lang->data['email'] ?? 'Email' }}</th>
                                <th class="tw-20">{{ $lang->data['address'] ?? 'Address' }}</th>
                                <th class="tw-20">{{ $lang->data['address'] ?? 'Situation Description' }}</th>
                                <th class="tw-20">{{ $lang->data['lead_from'] ?? 'Lead From' }}</th>
                                <th class="tw-10">{{ $lang->data['actions'] ?? 'Actions' }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($customers as $item)
                                <tr>
                                    <td>{{ $loop->index + 1 }}</td>
                                    <td><img src="{{ asset($item->media[0]->situation_image ?? '') }}"
                                            alt="Customer Image" width="100" height="100"></td>
                                    <td>{{ $item->name }}</td>
                                    <td>{{ $item->phone }}</td>
                                    <td>{{ $item->email }}</td>
                                    <td>{{ $item->postcode }},{{ Str::limit($item->address, 60) }},{{ $item->city }}
                                    </td>
                                    <td>{{ $item->customer_note }}</td>
                                    <td>{{ $item->lead->source }}</td>
                                    <td>
                                        <a href="#" class="btn btn-sm btn-success" data-bs-toggle="modal"
                                            data-bs-target="#ViewModalCustomer"
                                            wire:click='view({{ $item }})'>{{ $lang->data['view'] ?? 'View' }}</a>
                                        @if (Auth::user()->can('edit_customer'))
                                            <a href="#" class="btn btn-sm btn-primary" data-bs-toggle="modal"
                                                data-bs-target="#EditModalCustomer"
                                                wire:click='edit({{ $item }})'>{{ $lang->data['edit'] ?? 'Edit' }}</a>
                                        @endif
                                        @if (Auth::user()->can('delete_customer'))
                                            <a href="#" class="btn btn-sm btn-danger"
                                                wire:click="delete({{ $item }})">{{ $lang->data['delete'] ?? 'Delete' }}</a>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    @if (count($customers) == 0)
                        <x-no-data-component message="No Customers were found" messageindex="no_customers_found" />
                    @endif
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="ModalCustomer" tabindex="-1" role="dialog" aria-hidden="true" wire:ignore.self>
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">{{ $lang->data['add_new_customer'] ?? 'Add New Client' }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="mb-3 col-md-6">
                            <label class="form-label">{{ $lang->data['select_lead'] ?? 'Select Lead' }} <span
                                    class="text-danger"><strong>*</strong></span></label>
                            <select class="form-control" wire:model="lead_id">
                                <option selected value="">{{ $lang->data['choose'] ?? 'Choose...' }}</option>
                                @foreach ($leads as $item)
                                    @if ($item->appointments->customer_status == 0)
                                        <option value="{{ $item->id }}">{{ $item->name }}</option>
                                    @endif
                                @endforeach
                            </select>
                            @error('lead_id')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
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
    <div class="modal fade" id="EditModalCustomer" tabindex="-1" role="dialog" aria-hidden="true" wire:ignore.self>
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">{{ $lang->data['edit_customer'] ?? 'Edit Client' }}</h5>
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
                        <input type="text" class="form-control"
                            placeholder="{{ $lang->data['email'] ?? 'Email' }}" wire:model="email">
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
                    <!-- Blade File -->
                    <div class="mb-3">
                        <label class="form-label"
                            for="inputCity">{{ $lang->data['situation_image'] ?? 'Situation Image' }}</label>
                        <input type="file" class="form-control" wire:model="situation_images" multiple>
                        @error('situation_images.*')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label">{{ $lang->data['situation_image'] ?? 'Current Images' }}:</label>

                        <!-- Display old images -->
                        <div wire:loading.remove class="d-flex flex-wrap">
                            @foreach ($old_situation_images as $index => $image)
                                <div class="position-relative m-2">
                                    <img src="{{ asset($image) }}" alt="Situation Image"  width="100" height="100">
                                    <button wire:click="deleteImage({{ $index }})" class="btn btn-sm btn-danger position-absolute top-0 end-0">
                                        <li class="fa fa-trash"></li>
                                    </button>
                                </div>
                            @endforeach
                        </div>
                            @if(count($situation_images) > 0)
                            <div>
                                <p>New Images</p>
                            </div>
                        @foreach ($situation_images as $index => $image)
                            @if (!in_array($image, $old_situation_images))
                                <div style="position: relative; display: inline-block; margin-right: 10px;">
                                    @if (is_string($image))
                                        <img src="{{ asset($image) }}" alt="Situation Image" width="100"
                                            height="100">
                                    @else
                                        <img src="{{ asset($image->temporaryUrl()) }}" alt="Situation Image"
                                            width="100" height="100">
                                    @endif
                         
                                </div>
                            @endif
                        @endforeach
                        @endif
                    </div>
                    <div wire:loading wire:target="refreshOldImages">
                        Loading old images...
                    </div>
                    <div class="mb-3">
                        <label class="form-label">{{ $lang->data['customer_note'] ?? 'Situation Description' }}<span
                                class="text-danger"><strong>*</strong></span></label>
                        <textarea class="form-control resize-none" wire:model="customer_note"></textarea>

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
    <div class="modal fade" id="ViewModalCustomer" tabindex="-1" role="dialog" aria-hidden="true"
        wire:ignore.self>
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">{{ $lang->data['edit_customer'] ?? 'View Client' }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">

                    <div class="mb-3 ">
                        <label class="form-label">{{ $lang->data['name'] ?? 'Name' }}:</label>
                        <span class="text-danger"><strong>{{ $name ?? '--' }}</strong></span>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">{{ $lang->data['phone_number'] ?? 'Phone Number' }}:</label>
                        <span class="text-danger"><strong>{{ $phone ?? '--' }}</strong></span>
                    </div>


                    <div class="mb-3">
                        <label class="form-label">{{ $lang->data['email'] ?? 'Email' }}:</label>
                        <span class="text-danger"><strong>{{ $email ?? '--' }}</strong></span>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">{{ $lang->data['postcode'] ?? 'PostCode' }}:</label>
                        <span class="text-danger"><strong>{{ $postcode ?? '--' }}</strong></span>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">{{ $lang->data['address'] ?? 'Address' }}:</label>
                        <span class="text-danger"><strong>{{ $address ?? '--' }}</strong></span>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">{{ $lang->data['city'] ?? 'City' }}:</label>
                        <span class="text-danger"><strong>{{ $city ?? '--' }}</strong></span>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">{{ $lang->data['situation_image'] ?? 'Situation Images' }}:</label>
                        @foreach ($situation_images as $image)
                            <img src="{{ asset($image ?? '') }}" alt="Situation Image" width="100"
                                height="100">
                        @endforeach
                    </div>


                    <div class="mb-3">
                        <label
                            class="form-label">{{ $lang->data['customer_note'] ?? 'Situation Description' }}:</label>
                        <span class="text-danger"><strong>{{ $customer_note ?? '--' }}</strong></span>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary"
                            data-bs-dismiss="modal">{{ $lang->data['close'] ?? 'Close' }}</button>

                    </div>
                </div>
            </div>
        </div>
    </div>
