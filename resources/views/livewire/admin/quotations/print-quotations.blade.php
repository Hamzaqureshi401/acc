<style type="text/css">
    body {
       display: flex;
       flex-direction: column;
       min-height: 100vh;
       margin: 0;
   }
   .content {
       flex: 1;
   }
   .footer {
       background-color: #333;
       color: white;
       text-align: center;
       padding: 10px;
   }
   .footer span {
       font-size: 18px;
   }
   @media print {
       .content:last-child {
           page-break-after: auto; /* Ensure a page break after the last element of the printed content */
       }
   }
</style>
<div class="content">
   @if($printer == 1)
   <div class="card">
      <div class="card-body">
         <div class="row">
            <div class="col-12">
               <div class="d-flex flex-row">
                  <div class="col-md-6">
                     @php
                     $logo = '/uploads/logo/1698076505.png';
                     @endphp
                     <img src="{{ $logo }}" alt="Company Logo" style="width: auto; height: auto; max-width: 60%; max-height: 60%;">
                  </div>
                  <div class="col-md-6 text-end">
                     <div class="address-info">
                        {{$address}}<br>
                        <span style="color: #F4864C;">M</span> &nbsp;{{$store_phone}}<br>
                        <span style="color: #F4864C;">E</span> &nbsp;{{$store_email}}<br>
                        <span style="color: #F4864C;">W</span> &nbsp;www.vanleeuwenairconditioning.nl
                     </div>
                  </div>
               </div>
            </div>
         </div>
         <hr>
         <div class="row">
            <div class="mb-3 col-md-4">
               <strong>
               {{$lang->data['customer_name'] ?? 'Customer Name'}}:
               </strong>    &nbsp;&nbsp;
               <font class="view-f3"> 
               {{ $quotation->lead->name }}
               </font><br>
               <strong>
               {{$lang->data['quotation_no'] ?? 'Quotation No'}}:
               </strong>    &nbsp;&nbsp;
               <font class="view-f3"> 
               {{ $quotation->quotation_number}}
               </font>
               <br>
               <strong>
               {{$lang->data['quotation_date'] ?? 'Quotation Date'}}:
               </strong>    &nbsp;&nbsp;
               <font class="view-f3"> 
               {{ $quotation->created_date}}
               </font>
            </div>
            <div class="mb-3 col-md-8">
            </div>
         </div>
         <div class="row">
            <div class="mb-3 col-md-12">
               <strong> {{$lang->data['dear'] ?? 'Dear'}} {{ $quotation->lead->name }}, </strong><br>
               <p><strong>Naar aanleiding van ons bezoek is het ons een genoegen u hierbij vrijblijvend een offerte te sturen 
                  inzake airconditioning.</strong>
               </p>
            </div>
         </div>
         <div class="row">
            <table class="table table-striped table-bordered table-sm">
               <thead class="bg-secondary-light">
                  <tr class="text-sm">
                     <th class="tw-40">{{$lang->data['product/services'] ?? 'Product/Services'}}</th>
                     <th class="tw-20">{{$lang->data['NO'] ?? 'No'}}</th>
                     <th class="tw-40">{{$lang->data['description'] ?? 'Description'}}</th>
                  </tr>
               </thead>
               <tbody>
                  @foreach ($quotation->details as $item)
                  <tr class="text-sm">
                     <td><b>{{ Str::limit($item->product->name, 40) }}</b></td>
                     <td><span class="px-1">{{ $item->quantity }}</span></td>
                     <td><b>{{ Str::limit($item->description, 40) }}</b></td>
                  </tr>
                  @endforeach
               </tbody>
               <tfoot>
                  <tr>
                     <td ><strong>{{$lang->data['bill_total'] ?? 'Total Price Including Installation'}}:</strong></td>
                     <td><strong>{{ getCurrency() . number_format($quotation->total_amount, 2) }} Incl. VAT</strong></td>
                  </tr>
               </tfoot>
            </table>
         </div>
      </div>
   </div>
   <!-- <div class="footer">
      <div class="row">
         <div class="mb-3 col-md-6">
            <Strong>
            <span style="color: #F4864C;">Airconditioning</span> `&nbsp;
            <span style="color: #F4864C;">Montage</span> `&nbsp;
            <span style="color: #F4864C;">Onderhoud</span> `&nbsp;
            </Strong>
         </div>
      </div>
   </div> -->
   @endif
</div>
<div class="footer">
   <div class="row">
      <div class="mb-3 col-md-6">
         <Strong>
         <span style="color: #F4864C;">Airconditioning</span> `&nbsp;
         <span style="color: #F4864C;">Montage</span> `&nbsp;
         <span style="color: #F4864C;">Onderhoud</span> `&nbsp;
         </Strong>
      </div>
   </div>
</div>