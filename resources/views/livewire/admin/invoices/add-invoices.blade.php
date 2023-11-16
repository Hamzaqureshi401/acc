<div>
    
<div class="row mb-2 mb-xl-3">
    <div class="col-auto d-none d-sm-block">
        <h3><strong>{{$lang->data['create_invoice'] ?? 'Create Invoice'}}</strong></h3>
    </div>

    <div class="col-auto ms-auto text-end mt-n1">
        <a href="{{route('admin.view_invoices')}}" class="btn btn-dark">{{$lang->data['back'] ?? 'Back'}}</a>
    </div>
</div>

<div class="col-md-12">
    <div class="card">

        <div class="card-body">
            <form x-data="{ isUploading: false, progress: 0 }" 
            x-on:livewire-upload-start="isUploading = true"
            x-on:livewire-upload-finish="isUploading = false"
            x-on:livewire-upload-error="isUploading = false">
                <div class="row">
                    <div class="mb-3 col-md-6">
                        <label class="form-label">{{$lang->data['select_quotation'] ?? 'Select Quotation '}}</label>
                        <select class="form-control" wire:change="selectQuotation" wire:model="quotation_id">
                            <option selected value="">{{$lang->data['choose'] ?? 'Choose...'}}</option>
                            @foreach ($quotations as $item)
                                @if($item->lead->appointments->customer_status==1)
                                <option value="{{$item->id}}">{{$item->quotation_number}}({{$item->customer->name}})</option>
                                @endif
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3 col-md-4">
                        <label class="form-label">{{$lang->data['type'] ?? 'Type '}}</label>
                        <select class="form-control" wire:model="type">
                            <option selected value="">{{$lang->data['choose'] ?? 'Choose...'}}</option>
                            <option value="Standard">{{$lang->data['Standard'] ?? 'Standard'}}</option>
                            <option value="Maintenance">{{$lang->data['Maintenance'] ?? 'Maintenance'}}</option>
                        </select>
                        @error('type')
                            <span class="text-danger">{{$message}}</span>
                        @enderror
                    </div>
                </div>
                <div class="row">
                    <div class="mb-3 col-md-4">
                        <label class="form-label">{{$lang->data['customers'] ?? 'Customers '}}</label>
                        <select class="form-control" wire:model="customer_id">
                            <option selected value="">{{$lang->data['choose'] ?? 'Choose...'}}</option>
                            @foreach ($customers as $item)
                                <option value="{{$item->id}}">{{$item->name}}</option>
                            @endforeach
                        </select>
                        @error('customer_id')
                            <span class="text-danger">{{$message}}</span>
                        @enderror
                    </div>
                    <div class="mb-3 col-md-4">
                        <label class="form-label" for="inputCity">{{$lang->data['date'] ?? 'Date'}}</label>
                        <input type="date" class="form-control" wire:model="date">
                        @error('date')
                            <span class="text-danger">{{$message}}</span>
                        @enderror
                    </div>
                
                    <div class="mb-3 col-md-4">
                        <label class="form-label" for="inputCity">{{$lang->data['address'] ?? 'Address'}}</label>
                        <input type="textarea" class="form-control" placeholder="{{$lang->data['address'] ?? 'Address'}}" wire:model="address">
                        @error('address')
                            <span class="text-danger">{{$message}}</span>
                        @enderror
                    </div>
                </div>
                <div class="row">
                    <div class="mb-3 col-md-4">
                        <label class="form-label" for="inputCity">{{$lang->data['sales_tax'] ?? 'Sales Tax %'}}</label>
                        <input type="text" class="form-control" wire:model="sales_tax">
                        @error('sales_tax')
                            <span class="text-danger">{{$message}}</span>
                        @enderror
                    </div>
                
                    <div class="mb-3 col-md-4">
                        <label class="form-label" for="inputCity">{{$lang->data['discount'] ?? 'Discount %'}}</label>
                        <input type="text" class="form-control" wire:model="discount">
                        @error('discount')
                            <span class="text-danger">{{$message}}</span>
                        @enderror
                    </div>
                    <div class="mb-3 col-md-4">
                        <label class="form-label" for="inputCity">{{$lang->data['maintenance_date'] ?? 'Maintenance Date'}}</label>
                        <input type="date" class="form-control" wire:model="maintenance_date">
                        @error('maintenance_date')
                            <span class="text-danger">{{$message}}</span>
                        @enderror
                    </div>
                    <div class="mb-3 col-md-4">
                        <label class="form-label" for="inputCity">{{$lang->data['first_invoice'] ?? 'First Invoice %'}}</label>
                        <input type="text" class="form-control" wire:change="checkper" wire:model="first_invoice">
                        @error('first_invoice')
                            <span class="text-danger">{{$message}}</span>
                        @enderror
                    </div>
                    {{-- <div class="mb-3 col-md-4">
                        <label class="form-label" for="inputCity">{{$lang->data['first_invoice_amount'] ?? 'First Invoice Amount'}}</label>
                        <input type="text" class="form-control" wire:model="first_invoice_amount" readonly> 
                        @error('first_invoice_amount')
                            <span class="text-danger">{{$message}}</span>
                        @enderror
                    </div> --}}
                    <div class="mb-3 col-md-4">
                        <label class="form-label" for="inputCity">{{$lang->data['first_due_date'] ?? 'First Invoice Due Date'}}</label>
                        <input type="date" class="form-control" wire:model="first_due_date">
                        @error('first_due_date')
                            <span class="text-danger">{{$message}}</span>
                        @enderror
                    </div>
                    <div class="mb-3 col-md-4">
                        <label class="form-label" for="inputCity">{{$lang->data['second_invoice'] ?? 'Second Invoice %'}}</label>
                        <input type="text" class="form-control" wire:model="second_invoice" readonly>
                        @error('second_invoice')
                            <span class="text-danger">{{$message}}</span>
                        @enderror
                    </div>
                    {{-- <div class="mb-3 col-md-4">
                        <label class="form-label" for="inputCity">{{$lang->data['second_invoice_amount'] ?? 'Second Invoice Amount'}}</label>
                        <input type="text" class="form-control" wire:model="second_invoice_amount">
                        @error('second_invoice_amount')
                            <span class="text-danger">{{$message}}</span>
                        @enderror
                    </div> --}}
                    <div class="mb-3 col-md-4">
                        <label class="form-label" for="inputCity">{{$lang->data['second_due_date'] ?? 'Second Invoice DueDate'}}</label>
                        <input type="date" class="form-control" wire:model="second_due_date">
                        @error('second_due_date')
                            <span class="text-danger">{{$message}}</span>
                        @enderror
                    </div>
                </div>
                
                <br>
                <div class="row">
                    <div class="mb-3 col-md-2">
                        <label for="productName">Product Name:</label>
                        <select class="form-control" wire:change="selectProduct" wire:model="product_id">
                            <option selected value="">{{$lang->data['choose'] ?? 'Choose...'}}</option>
                            @foreach ($products as $item)
                                <option value="{{$item->id}}">{{$item->name}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3 col-md-1">
                        <label for="productPrice">Price:</label>
                        <input type="text" wire:change="calculate" wire:model="productPrice">
                    </div>
                    <div class="mb-3 col-md-1">
                        <label for="productQuantity">Quantity:</label>
                        <input type="text" wire:change="calculate" wire:model="productQuantity">
                    </div>
                    <div class="mb-3 col-md-1">
                        <label for="productQuantity">Unit:</label>
                        <input type="text" wire:model="productUnit" readonly>
                    </div>
                    <div class="mb-3 col-md-1">
                        <label for="total">Total:</label>
                        <input type="text" wire:model="total" readonly>
                    </div>
                    <!-- <div class="mb-3 col-md-2">
                        <label for="total">Description:</label>
                        <input type="text" wire:model="productdescription">
                    </div>
                    <div class="mb-3 col-md-1">
                        <label for="tax">Tax:</label>
                        <select class="form-control" wire:change="calculate" wire:model="tax">
                            <option value="No">No</option>
                            <option value="Yes">Yes</option>
                        </select>
                        <input type="hidden" wire:model="total_tax">
                    </div> -->
                    <div class="mb-3 col-md-2">
                        <br>
                        <button class="btn btn-primary float-end" wire:click.prevent="addProduct">Add Product</button>
                    </div>
                </div>
                <br>
                <div>
                    <table class="table table-striped table-bordered mb-0">
                        <thead class="bg-secondary-light">
                            <tr>
                                <th>Name</th>
                                <th>Price</th>
                                <th>Quantity</th>
                                <th>Tax</th>
                                <th>Description</th>
                                <th>Total</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($selected_products as $index => $product)
                                <tr>
                                    <td>{{ $product['name'] }}</td>
                                    <td>{{ $product['price'] }}</td>
                                    <td>{{ $product['quantity'] }}/{{$product['unit']}}</td>
                                    <td>{{ $product['total_tax'] }}</td>
                                    <td>{{ $product['description'] }}</td>
                                    <td>{{ $product['total'] }}</td>
                                    <td><button wire:click.prevent="removeProduct({{ $index }})">Remove</button></td>
                                </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="3"></td>
                                <td><strong>Total Tax:</strong></td>
                                <td>{{ $totalTax = $this->calculateTotalTax() }}</td>
                                <td></td>
                            </tr>
                            <tr>
                                <td colspan="3"></td>
                                <td><strong>Sub Amount:</strong></td>
                                <td>{{ $subAmount = $this->calculatesubAmount() }}</td>
                                <td></td>
                            </tr>
                            <tr>
                                <td colspan="3"></td>
                                <td><strong>Total Discount:</strong></td>
                                <td>{{ $totalDiscount = $this->calculateTotalDiscount() }}</td>
                                <td></td>
                            </tr>
                            <tr>
                                <td colspan="3"></td>
                                <td><strong>Total Amount:</strong></td>
                                <td>{{ $totalAmount = $this->calculateTotalAmount() }}</td>
                                <td></td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
                <br>
                <div class="row">
               <!--  <div class="mb-3">
                    <label class="form-label" for="inputAddress">{{$lang->data['customer_note'] ?? 'Customer Note'}}</label>
                    <textarea class="form-control resize-none" rows="4" wire:model="customer_note"></textarea>
                    @error('customer_note')
                        <span class="text-danger">{{$message}}</span>
                    @enderror
                </div> -->
                <!-- <div class="mb-3">
                    <label class="form-label" for="inputAddress">{{$lang->data['description'] ?? 'Description'}}</label>
                    <textarea class="form-control resize-none" rows="4" wire:model="description"></textarea>
                    @error('description')
                        <span class="text-danger">{{$message}}</span>
                    @enderror
                </div> -->
                </div>
                <button type="button" class="btn btn-primary float-end" :disabled="isUploading == true" wire:click.prevent="create">{{$lang->data['submit'] ?? 'Submit'}}</button>
            </form>
        </div>
    </div>
</div>
</div>
