<div>
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
         <div class="invoice-box table-height">
            <table cellpadding="0" cellspacing="0"
               class="view-table">
               <tbody>
                  <tr class="top">
                     <td colspan="6" class="view-td1">
                        <table class="view-table1">
                           <tbody>
                              <tr>
                                 <td
                                    class="view-td2">
                                    <font class="view-f1">
                                    <font
                                       class="view-f2">
                                    {{$lang->data['customer_info'] ?? 'Customer Info'}}
                                    </font>
                                    </font><br>
                                    <font class="view-align1">
                                    <font
                                       class="view-f3">
                                    {{ $invoice->customer->name }}
                                    </font>
                                    </font><br>
                                    <font class="view-align1">
                                    <font
                                       class="view-f3">
                                    @if ($invoice->address)
                                    {{ $invoice->address }}
                                    @else
                                    -
                                    @endif
                                    </font>
                                    </font><br>
                                 </td>
                                 <td
                                    class="view-f4 text-end">
                                    <font class="view-f5">
                                    <font
                                       class="view-f6">
                                    {{$lang->data['company_info'] ?? 'Billing Details'}}</font>
                                    </font><br>
                                    <font class="view-align1">
                                    <!-- <font
                                       class="view-f3">
                                    {{$store_name}} </font> -->
                                    <font
                                       class="view-f3">
                                    {{$lang->data['invoice_date'] ?? 'invoice Date'}}: {{ $invoice->date ?? '--'}} </font>
                                    </font>
                                    </font><br>
                                    <font class="view-align1">
                                    <font
                                       class="view-f3">
                                    {{$lang->data['quotation_No'] ?? 'Quotation No'}}: {{ $invoice->customer->quotation->quotation_number ?? '--'}} </font>
                                    </font>
                                    </font><br>
                                    <font class="view-align1">
                                    <font
                                       class="view-f3">
                                    {{$lang->data['invoice_no'] ?? 'invoice No'}}: 



                                    {{ $invoice->invoice_number ?? '--'}}
                                    @if($no == 1)
                                     -1
                                     @else
                                     -2
                                     @endif
                                 </font>
                                    </font>
                                    </font><br>
                                 </td>
                               
                              </tr>
                            
                           </tbody>
                        </table>
                     </td>
                  </tr>
               </tbody>
            </table>
         </div>
         <div class="row">
            <span class="text-center">Invoice Upon Delivery
             
               @if($no == 1)
             {{ $invoice->first_invoice }}
             @else
             {{ $invoice->second_invoice }}
             @endif
          %</span>
            <table class="table table-striped table-binvoiceed table-sm">
               <thead class="bg-secondary-light">
            
                  <tr class="text-sm">
                     <th>{{$lang->data['sl'] ?? 'Sl'}}</th>
                     <th>{{$lang->data['product_servise'] ?? 'Product/Service'}}</th>
                     <th class="">{{$lang->data['btw'] ?? 'Btw'}}</th>
                     <th class="text-end">{{$lang->data['total'] ?? 'Total'}}</th>
                  </tr>
               </thead>
               <tbody>
                  @foreach ($invoice->details as $item)
                  <tr class="text-sm">
                     <td>{{ $loop->index + 1 }}</td>
                     <td>
                        <b> {{ Str::limit($item->product->name,40) }}</b>
                     </td>
                     <td class="">
                        <span class="px-1">{{ $item->tax }}</span>
                     </td>
                     <td class="text-end">
                        <span class="px-1">{{ $item->total ?? 0 }}</span>
                     </td>
                  </tr>
                  @endforeach
                 
               </tbody>
               <tfoot>
                 
                  @php
                  $total=($invoice->total_amount/100)*$percentage;
                  $percentage = ($no == 1) ? $invoice->first_invoice : $invoice->second_invoice;
                  $bill = $invoice->total_amount * ($percentage / 100);
                  @endphp
                  <tr>
                     <td></td>
                     <td colspan="2" class="text-end"><strong>{{$lang->data['total_amt_exc_val'] ?? 'Total Amt Execl. VAT'}}:</strong></td>
                     <td class="text-end"><strong>{{ getCurrency() }}{{ number_format($invoice->total_amount, 2) }}</strong></td>
                  </tr>
                  <tr>
                     <td></td>
                     <td colspan="2" class="text-end"><strong> 'Btw'  @if($no == 1)
                      {{ $invoice->first_invoice }}
                      @else
                      {{ $invoice->second_invoice }}
                      @endif %:</strong></td>
                     <td class="text-end"><strong>{{getCurrency()}}{{ number_format(($invoice->tax_amount) , 2)  }}</strong></td>
                  </tr>
                  <hr>
                  <tr>
                     <td></td>
                     <td colspan="2" class="text-end"><strong>{{$lang->data['total_amt_inc_vat'] ?? 'Total Amt Inc VAT' }}:</strong></td>

                    <td class="text-end"><strong>{{ getCurrency() . number_format($invoice->total_amount ,2) }}</strong></td>
                  </tr>
                  <tr>
                     <td>Total Amount is {{$invoice->total_amount}} excluding tex and @if($no == 1) 
                        {{ $invoice->first_invoice }}
                      @else
                      {{ $invoice->second_invoice }}
                      @endif 

                   % of Invoice is {{ $bill }}</td>
                  </tr>
               </tfoot>
            </table>
         </div>
      </div>
   </div>
   @endif
   <!-- <script type="text/javascript">
      "use strict";
         window.onload = function() {
             window.print();
             setTimeout(function() {
                 window.close();
             }, 1);
         }
   </script> -->
</div>