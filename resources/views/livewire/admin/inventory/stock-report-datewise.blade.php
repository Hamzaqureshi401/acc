<div>
   <div class="row mb-2 mb-xl-3">
      <div class="col-auto d-none d-sm-block">
         <h3><strong>{{$lang->data['stock_report'] ?? 'Stock Report'}}</strong></h3>
      </div>
   </div>
   <div class="row">
      <div class="col-12">
         <div class="card p-0">
            <div class="card-header p-3">
                  <div class="row">
                     <div class="col-md-2">
                        <div class="form-group">
                           <label for="brand">Brand:</label>
                           <select wire:model="supplier_brand_id" id="brand" class="form-control">
                              
                                <option value="All">All Brands</option>
                                @foreach ($brands as $brand)
                                    <option value="{{ $brand->id }}">{{ $brand->name }}</option>
                                @endforeach
                            
                           </select>
                        </div>
                     </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label for="category">Category:</label>
                            <select wire:model="category_id" id="category" class="form-control">
                                <option value="All">All Categories</option>
                                @foreach ($categories as $category)
                                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                     <div class="col-md-2">
                        <div class="form-group">
                           <label for="client">Client:</label>
                           <select wire:model="client_id" id="client" class="form-control">
                              <option value="All">All Client</option>
                              @foreach ($clients as $item)
                           <option value="{{ $item->id }}">{{ $item->name }}</option>
                           @endforeach
                              <!-- Add more client options here -->
                           </select>
                        </div>
                     </div>
                     <div class="col-md-2">
                        <div class="form-group">
                           <label for="date">Date:</label>
                           <input type="date" wire:model="date" id="date" class="form-control">
                        </div>
                     </div>
                     <div class="col-md-2">
                        <label>{{$lang->data['select_product'] ?? 'Select Product'}}</label>
                        <select class="form-select" wire:model="product_id">
                           <option>{{$lang->data['all_products']?? 'All Products'}}</option>
                           @foreach ($product as $item)
                           <option value="{{ $item->id }}">{{ $item->name }}</option>
                           @endforeach
                        </select>
                     </div>
                     <div class="col-md-2">
                        <div class="form-group">
                           <label></label>
                           <br>
                           <a href="#" class="btn btn-primary" wire:click='getData'>{{$lang->data['search'] ?? 'Search'}}</a>
                        </div>
                     </div>
                     <!-- <div class="col-md-2">
                        <br>
                        <a href="#" class="btn btn-primary" wire:click="exportToExcel">{{$lang->data['excel'] ?? 'Excel'}}</a>
                     </div>
                     <div class="col-md-2">
                        <br>
                        <a href="#" class="btn btn-primary" wire:click="exportToPDF">{{$lang->data['pdf'] ?? 'PDF'}}</a>
                     </div> -->
                  </div>
            </div>
            <div class="card-body p-0">
               <div class="table-responsive">
                  <table id="table" class="table table-striped table-sm table-bordered mb-0">
                     <thead class="bg-secondary-light">
                        <tr>
                           <th class="tw-2">{{$lang->data['sl'] ?? 'Sl'}}</th>
                           <th class="tw-25">{{$lang->data['name'] ?? 'Product Name'}}</th>
                           <th class="tw-10">{{$lang->data['quantity'] ?? 'Quantity'}}</th>
                           
                           <th class="tw-10">{{$lang->data['old_stock'] ?? 'Quantity In Stock'}}</th>
                           <th class="tw-10">{{$lang->data['Stock Reserved'] ?? 'Quantity Reserved'}}</th>
                           <th class="tw-10">{{$lang->data['Stock Reserved'] ?? 'Estimated Remaining Quantity'}}</th>
                           
                           <th class="tw-10">{{$lang->data['sold'] ?? 'Sold'}}</th>
                           <th class="tw-10">{{$lang->data['quantity'] ?? 'Date'}}</th>
                           <!-- <th class="tw-10">{{$lang->data['action'] ?? 'Action'}}</th> -->
                        </tr>
                     </thead>
                     <tbody>
                        @foreach ($data as $item)
                        @php
                        $reserved_stock = $item->invoicedetails()
                         ->whereHas('invoice', function ($query) {
                             $query->where('is_approved', 0);
                         })
                         //->whereNotNull('invoice_id') // Add this condition to check for a valid invoice relationship
                         ->sum('quantity');

                        @endphp
                        <tr>
                           <td>{{$loop->index + 1}}</td>
                           <td>{{$item->product->name ?? '--'}}</td>
                           <td>{{$item->total_quantity}}/{{$item->product->unit ?? '--'}}</td>
                           
                           <td>{{ $item->product->quantity ?? '--'}}</td>
                           <td>
                               {{ $reserved_stock }}
                           </td>
                           <td>{{ $item->product->quantity ?? 0 - $reserved_stock }}</td>
                           <td>{{ $item->invoicedetails->sum('quantity')}}</td>
                           <td>{{$item->created_at}}</td>
                           
<!-- <td><a href="" class="btn btn-success">Show Sold Client Detail</a></td> -->
                        </tr>
                        @endforeach
                     </tbody>
                  </table>
                  @if(count($data) == 0)
                  <x-no-data-component message="{{$lang->data['no_data_found'] ?? 'No data found..'}}" />
                  @endif
               </div>
            </div>
         </div>
      </div>
   </div>

   <div class="card-body p-0">
               <div class="table-responsive">
                  <table id="table" class="table table-striped table-sm table-bordered mb-0">
                     <thead class="bg-secondary-light">
                        <tr>
                           <th class="tw-2">{{$lang->data['sl'] ?? 'Sl'}}</th>
                           <th class="tw-25">{{$lang->data['name'] ?? 'Product Name'}}</th>
                           <th class="tw-25">{{$lang->data['name'] ?? 'Customer'}}</th>
                           <th class="tw-10">{{$lang->data['quantity'] ?? 'Quantity Sold'}}</th>
                           <th class="tw-10">{{$lang->data['quantity'] ?? 'Date'}}</th>
                           <th class="tw-10">{{$lang->data['Stock Reserved'] ?? 'Stock Reserved'}}</th>

                           <!-- <th class="tw-10">{{$lang->data['action'] ?? 'Action'}}</th> -->
                        </tr>
                     </thead>
                     <tbody>
                        @foreach ($data as $item)
                        @php
                        $inv =$item->invoicedetails->groupBy('product_id');
                        $reserved_stock = $item->invoicedetails()->whereHas('invoice', function ($query) {
                                   $query->where('is_approved', 0);
                               })->groupBy('product_id')->sum('quantity');
                        @endphp
                        @foreach($inv as $item2)
                        
                        <tr>
                           <td>{{$loop->index + 1}}</td>
                           <td>{{$item->product->name}}</td>
                           <td>{{ $item2->first()->invoice->customer->name }}</td>
                           
                           <td>{{ $item->invoicedetails->sum('quantity')}}</td>
                           <td>{{ $item2->first()->invoice->created_at }}</td>
                           <td>{{ $reserved_stock }}</td>
                           
                           <!-- <td><a href="" class="btn btn-success">Show Sold Client Detail</a></td> -->
                        </tr>
                        @endforeach
                        @endforeach
                     </tbody>
                  </table>
                  @if(count($data) == 0)
                  <x-no-data-component message="{{$lang->data['no_data_found'] ?? 'No data found..'}}" />
                  @endif
               </div>
            </div>
</div>