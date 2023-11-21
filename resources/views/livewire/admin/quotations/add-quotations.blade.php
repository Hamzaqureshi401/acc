<div>
    
<div class="row mb-2 mb-xl-3">
    <div class="col-auto d-none d-sm-block">
        <h3><strong>{{$lang->data['create_quotation'] ?? 'Create Quotation'}}</strong></h3>
    </div>

    <div class="col-auto ms-auto text-end mt-n1">
        <a href="{{route('admin.view_quotations')}}" class="btn btn-dark">{{$lang->data['back'] ?? 'Back'}}</a>
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
                    <div class="mb-3 col-md-4">
                        <label class="form-label">{{$lang->data['leads'] ?? 'Leads Name '}}</label>
                        <select class="form-control" wire:change="leadData" wire:model="lead_id">
                            <option selected value="">{{$lang->data['choose'] ?? 'Choose...'}}</option>
                            @foreach ($leads as $item)
                                <option value="{{$item->id}}">{{$item->name}}</option>
                            @endforeach
                        </select>
                        @error('lead_id')
                            <span class="text-danger">{{$message}}</span>
                        @enderror
                    </div>
                    <div class="mb-3 col-md-4">
                        <label class="form-label" for="inputCity">{{$lang->data['phone'] ?? 'Phone'}}</label>
                        <input type="textarea" class="form-control" placeholder="{{$lang->data['phone'] ?? 'Phone'}}" wire:model="phone">
                        @error('phone')
                            <span class="text-danger">{{$message}}</span>
                        @enderror
                        
                    </div>
                    <div class="mb-3 col-md-4">
                        <label class="form-label" for="inputCity">{{$lang->data['email'] ?? 'Email'}}</label>
                        <input type="textarea" class="form-control" placeholder="{{$lang->data['email'] ?? 'Email'}}" wire:model="email">
                        @error('email')
                            <span class="text-danger">{{$message}}</span>
                        @enderror
                    </div>
                </div>
                <div class="row">
                    <div class="mb-3 col-md-4">
                        <label class="form-label" for="inputCity">{{$lang->data['date_created'] ?? 'Date Created'}}</label>
                        <input type="date" class="form-control" value="{{ date('Y-m-d') }}" wire:model="created_date">
                        @error('created_date')
                            <span class="text-danger">{{$message}}</span>
                        @enderror
                    </div>
                    <div class="mb-3 col-md-4">
                        <label class="form-label" for="inputCity">{{$lang->data['date_expiry'] ?? 'Date Expiry'}}</label>
                        <input type="date" class="form-control" wire:model="expiry_date">
                        @error('expiry_date')
                            <span class="text-danger">{{$message}}</span>
                        @enderror
                    </div>
                    <div class="mb-3 col-md-4">
                        <label class="form-label">{{$lang->data['stage'] ?? 'Stage '}}</label>
                        <select class="form-control" wire:model="stage">
                            <option selected value="">{{$lang->data['choose'] ?? 'Choose...'}}</option>
                            <option  value="Sent">Sent</option>
                            <option value="Decline">Decline</option>
                            <option value="Accepted">Accepted</option>
                            
                        </select>
                        @error('stage')
                            <span class="text-danger">{{$message}}</span>
                        @enderror
                    </div>
                    
                </div>
                <div class="row">
                    <div class="mb-3 col-md-4">
                        <label class="form-label"for="inputCity">{{$lang->data['sales_tax'] ?? 'BTW'}}</label>
                        <input type="text" class="form-control" wire:model="sales_tax">
                        @error('sales_tax')
                            <span class="text-danger">{{$message}}</span>
                        @enderror
                    </div>
                   <!--  <div class="mb-3 col-md-4">
                        <label class="form-label" for="inputCity">{{$lang->data['discount'] ?? 'Discount %'}}</label>
                        <input type="text" class="form-control" wire:model="discount">
                        @error('discount')
                            <span class="text-danger">{{$message}}</span>
                        @enderror
                    </div> -->

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
                    <div class="mb-3 col-md-2">
                        <label for="productPrice">Price:</label>
                        <input type="text" wire:change="calculate" wire:model="productPrice" >
                    </div>
                    <div class="mb-3 col-md-1">
                        <label for="productQuantity">Quantity:</label>
                        <input type="text" wire:change="calculate" wire:model="productQuantity">
                    </div>
                    <div class="mb-3 col-md-1">
                        <label for="productQuantity">Unit:</label>
                        <input type="text" wire:model="productUnit" readonly>
                    </div>
                    <div class="mb-3 col-md-2">
                        <label for="total">Total:</label>
                        <input type="text" wire:model="total" readonly>
                    </div>
                    <div class="mb-3 col-md-2">
                        <label for="total">Description:</label>
                        <input type="text" wire:model="productdescription">
                    </div>
                    {{-- <div class="mb-3 col-md-1">
                        <label for="tax">Tax:</label>
                        <select class="form-control" wire:change="calculate" wire:model="tax">
                            <option value="No">No</option>
                            <option value="Yes">Yes</option>
                        </select>
                    </div> --}}
                    <input type="hidden" wire:model="total_tax">
                    <input type="hidden" wire:model="tax" value="yes">
                    <div class="mt-3 col-md-2">
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
                                <th>Total</th>
                                <th>Description</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($selected_products as $index => $product)
                                <tr>
                                    <td>{{ $product['name'] }}</td>
                                    <td>{{ $product['price'] }}</td>
                                    <td>{{ $product['quantity'] }}/{{ $product['unit'] }}</td>
                                    <td>{{ $product['total_tax'] }}</td>
                                    <td>{{ $product['total'] }}</td>
                                    <td>{{ $product['description'] }}</td>
                                    <td><button wire:click.prevent="removeProduct({{ $index }})">Remove</button></td>
                                </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="3"></td>
                                <td><strong>Total BTW:</strong></td>
                                <td>{{ $totalTax = $this->calculateTotalTax() }}</td>
                                <td></td>
                            </tr>
                            <tr>
                                <td colspan="3"></td>
                                <td><strong>Sub Amount:</strong></td>
                                <td>{{ $subAmount = $this->calculatesubAmount() }}</td>
                                <td></td>
                            </tr>
                            {{-- <tr>
                                <td colspan="3"></td>
                                {{-- <td><strong>Total Discount:</strong></td> --}}
                                {{-- <td>{{ $totalDiscount = $this->calculateTotalDiscount() }}</td> --}}
                                {{-- <td></td> --}}
                            {{-- </tr> --}} 
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
                <div class="mb-3 col-md-12">
                    <label class="form-label" for="inputAddress">{{$lang->data['customer_note'] ?? 'Customer Note'}}</label>
                    <textarea class="form-control resize-none" rows="4" wire:model="customer_note"></textarea>
                    @error('customer_note')
                        <span class="text-danger">{{$message}}</span>
                    @enderror
                </div>
                {{-- <div class="mb-3 col-md-6">
                    <label class="form-label" for="inputAddress">{{$lang->data['description'] ?? 'Description'}}</label>
                    <textarea class="form-control resize-none" rows="4" wire:model="description"></textarea>
                    @error('description')
                        <span class="text-danger">{{$message}}</span>
                    @enderror
                </div>     --}}
                </div>
                <button type="button" class="btn btn-primary float-end" :disabled="isUploading == true" wire:click.prevent="create">{{$lang->data['submit'] ?? 'Submit'}}</button>
            </form>
        </div>
    </div>
</div>
</div>
