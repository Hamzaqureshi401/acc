<div>
    <nav id="sidebar" class="sidebar js-sidebar">
        <div class="sidebar-content js-simplebar">
            <a class="sidebar-brand" >
                <span class="sidebar-brand-text align-middle">
                    {{getStoreName()}}
                    <!-- <sup><small class="badge bg-primary text-uppercase">{{$lang->data['version']??'v2'}}</small></sup> -->
                </span>
                <svg class="sidebar-brand-icon align-middle" width="32px" height="32px" viewBox="0 0 24 24"
                    fill="none" stroke="#FFFFFF" stroke-width="1.5" stroke-linecap="square" stroke-linejoin="miter"
                    color="#FFFFFF" class="mm-3">
                    <path d="M12 4L20 8.00004L12 12L4 8.00004L12 4Z"></path>
                    <path d="M20 12L12 16L4 12"></path>
                    <path d="M20 16L12 20L4 16"></path>
                </svg>
            </a>

            <ul class="sidebar-nav">
                <li class="sidebar-header">
                    {{$lang->data['pages']??'Pages'}}
                </li>
                        @if (Auth::user()->can('products_list') ||Auth::user()->can('categories_list'))
                <li class="sidebar-item {{ Request::is('admin/inventory/*') ? 'active' : '' }}">
                    <a data-bs-target="#forms" data-bs-toggle="collapse" class="sidebar-link collapsed">
                        <i class="align-middle" data-feather="check-circle"></i> <span
                            class="align-middle">{{$lang->data['products']??'Products'}}</span>
                    </a>
                    <ul id="forms"
                        class="sidebar-dropdown list-unstyled collapse {{ Request::is('admin/inventory/*') ? 'show' : '' }}"
                        data-bs-parent="#sidebar">
                        @if (Auth::user()->can('categories_list'))
                        <li class="sidebar-item {{ Request::is('admin/inventory/category*') ? 'active' : '' }}"><a
                                class=" sidebar-link" href="{{ route('admin.product_category') }}">{{$lang->data['category']??'Category'}}</a></li>
                        @endif
                        @if (Auth::user()->can('products_list'))
                        <li class="sidebar-item {{ Request::is('admin/inventory/products*') ? 'active' : '' }}"><a
                                class="sidebar-link" href="{{ route('admin.view_products') }}">{{$lang->data['products']??'Products'}}</a></li>
                        @endif
                        @if (Auth::user()->can('services_list'))
                        <li class="sidebar-item {{ Request::is('admin/services*') ? 'active' : '' }}"><a
                                class=" sidebar-link" href="{{ route('admin.services') }}">{{$lang->data['Services']??'Services'}}</a></li>
                        @endif
                    
                        @if (Auth::user()->can('suppliers_list'))
                        <li class="sidebar-item {{ Request::is('admin/inventory/supplier*') ? 'active' : '' }}"><a
                                class=" sidebar-link" href="{{ route('admin.supplier') }}">{{$lang->data['supplier']??'Brands'}}</a></li>
                        @endif
                    </ul>
                </li>
                @endif
    
                @if (Auth::user()->can('leads_list') ||Auth::user()->can('quoteleads_list'))
                <li class="sidebar-item {{ Request::is('admin/leads*') ? 'active' : '' }}">
                    <a data-bs-target="#leads" data-bs-toggle="collapse" class="sidebar-link collapsed">
                        <i class="align-middle" data-feather="check-circle"></i> <span
                            class="align-middle">{{$lang->data['leads']??'Leads'}}</span>
                    </a>
                    <ul id="leads" class="sidebar-dropdown list-unstyled collapse {{ Request::is('admin/leads*') ? 'show' : '' }}"
                                data-bs-parent="#sidebar">


                        @if (Auth::user()->can('leads_list'))
                        <li class="sidebar-item {{ Request::is('admin/leads*') ? 'active' : '' }}">
                            <a class="sidebar-link" href="{{ route('admin.leads') }}">
                                <i class="align-middle" data-feather="user"></i> <span class="align-middle">{{$lang->data['leads']??'Leads'}}</span>
                            </a>
                        </li>
                        @endif
                        @if (Auth::user()->can('contactleads_list'))
                        <li class="sidebar-item {{ Request::is('admin/leads/wpform-leads*') ? 'active' : '' }}">
                            <a class="sidebar-link" href="{{ route('admin.wpformleads') }}">
                                <i class="align-middle" data-feather="user"></i> <span class="align-middle">{{$lang->data['wpform_leads']??'Contact '}}</span>
                            </a>
                        </li>
                        @endif
                        @if (Auth::user()->can('quoteleads_list'))
                        <li class="sidebar-item {{ Request::is('admin/leads/quote-leads*') ? 'active' : '' }}">
                            <a class="sidebar-link" href="{{ route('admin.quote_leads') }}">
                                <i class="align-middle" data-feather="user"></i> <span class="align-middle">{{$lang->data['quote']??'Qoute '}}</span>
                            </a>
                        </li>
                        @endif
                        
                        @if (Auth::user()->can('productleads_list'))
                        <li class="sidebar-item {{ Request::is('admin/leads/product-leads*') ? 'active' : '' }}">
                            <a class="sidebar-link" href="{{ route('admin.product_leads') }}">
                                <i class="align-middle" data-feather="user"></i> <span class="align-middle">{{$lang->data['product']??'Product'}}</span>
                            </a>
                        </li>
                        @endif
                    </ul>
                </li>

                @endif             
                 
              
              
                @if (Auth::user()->can('appointment_list'))
                    <li class="sidebar-item {{ Request::is('admin/appointments*') ? 'active' : '' }}">
                        <a class="sidebar-link" href="{{ route('admin.appointments') }}">
                        <i class="align-middle" data-feather="user"></i> <span class="align-middle">{{$lang->data['appointments']??'Apponitments'}}</span>
                        </a>
                    </li>
                @endif    
                @if (Auth::user()->can('appointment_list'))
                    <li class="sidebar-item {{ Request::is('admin/calender*') ? 'active' : '' }}">
                        <a class="sidebar-link" href="{{ route('admin.calender') }}">
                        <i class="align-middle" data-feather="user"></i> <span class="align-middle">{{$lang->data['calender']??'Calender'}}</span>
                        </a>
                    </li>
                @endif 
                 @if (Auth::user()->can('quotation_list'))
                    <li class="sidebar-item {{ Request::is('admin/quotations*') ? 'active' : '' }}">
                        <a class="sidebar-link" href="{{ route('admin.view_quotations') }}">
                        <i class="align-middle" data-feather="check-circle"></i> <span class="align-middle">{{$lang->data['quotations']??'Quotations'}}</span>
                        </a>
                    </li>
                @endif 
        
                
                @if (Auth::user()->can('customers_list'))
                    <li class="sidebar-item {{ Request::is('admin/customers*') ? 'active' : '' }}">
                        <a class="sidebar-link" href="{{ route('admin.customers') }}">
                        <i class="align-middle" data-feather="user"></i> <span class="align-middle">{{$lang->data['clients']??'Clients'}}</span>
                        </a>
                    </li>
                @endif 
               
                @if (Auth::user()->can('invoice_list'))
                    <li class="sidebar-item {{ Request::is('admin/invoices*') ? 'active' : '' }}">
                        <a class="sidebar-link" href="{{ route('admin.view_invoices') }}">
                        <i class="align-middle" data-feather="sliders"></i> <span class="align-middle">{{$lang->data['inovicing']??'Inovicing'}}</span>
                        </a>
                    </li>
                @endif 
                @if (Auth::user()->can('inventory_list'))
                    <li class="sidebar-item {{ Request::is('admin/stock*') ? 'active' : '' }}">
                        <a class="sidebar-link" href="{{ route('admin.inventory') }}">
                        <i class="align-middle" data-feather="grid"></i> <span class="align-middle">{{$lang->data['inventory']??'Inventory'}}</span>
                        </a>
                    </li>
                @endif 
                  
                  
                  
                    <!-- <li class="sidebar-item {{ Request::is('admin/dashboard') ? 'active' : '' }}">
                    <a class="sidebar-link" href="{{ route('admin.dashboard') }}">
                        <i class="align-middle" data-feather="sliders"></i> <span class="align-middle">{{$lang->data['dashboard'] ?? 'Dashboard'}}</span>
                    </a>
                </li> -->
                <!-- @if (Auth::user()->can('products_list') ||Auth::user()->can('categories_list'))
                <li class="sidebar-item {{ Request::is('admin/inventory/*') ? 'active' : '' }}">
                    <a data-bs-target="#forms" data-bs-toggle="collapse" class="sidebar-link collapsed">
                        <i class="align-middle" data-feather="check-circle"></i> <span
                            class="align-middle">{{$lang->data['products']??'Products'}}</span>
                    </a>
                    <ul id="forms"
                        class="sidebar-dropdown list-unstyled collapse {{ Request::is('admin/inventory/*') ? 'show' : '' }}"
                        data-bs-parent="#sidebar">
                        @if (Auth::user()->can('categories_list'))
                        <li class="sidebar-item {{ Request::is('admin/inventory/category*') ? 'active' : '' }}"><a
                                class=" sidebar-link" href="{{ route('admin.product_category') }}">{{$lang->data['category']??'Category'}}</a></li>
                        @endif
                        @if (Auth::user()->can('products_list'))
                        <li class="sidebar-item {{ Request::is('admin/inventory/products*') ? 'active' : '' }}"><a
                                class="sidebar-link" href="{{ route('admin.view_products') }}">{{$lang->data['products']??'Products'}}</a></li>
                        @endif
                        @if (Auth::user()->can('suppliers_list'))
                        <li class="sidebar-item {{ Request::is('admin/inventory/supplier*') ? 'active' : '' }}"><a
                                class=" sidebar-link" href="{{ route('admin.supplier') }}">{{$lang->data['supplier']??'Supplier'}}</a></li>
                        @endif
                    </ul>
                </li>
                @endif
                @if (Auth::user()->can('customers_list'))
                <li class="sidebar-item {{ Request::is('admin/customers*') ? 'active' : '' }}">
                    <a class="sidebar-link" href="{{ route('admin.customers') }}">
                        <i class="align-middle" data-feather="user"></i> <span class="align-middle">{{$lang->data['customers']??'Customers'}}</span>
                    </a>
                </li>
                @endif
                @if (Auth::user()->can('add_order'))
                <li class="sidebar-item">
                    <a class="sidebar-link" href="{{ route('admin.pos') }}">
                        <i class="align-middle" data-feather="shopping-bag"></i> <span class="align-middle">{{$lang->data['pos'] ?? 'POS'}}</span>
                    </a>
                </li>
                @endif
                @if (Auth::user()->can('add_order') ||Auth::user()->can('orders_list') ||Auth::user()->can('edit_order') || Auth::user()->can('delete_order'))
                <li
                    class="sidebar-item  {{ Request::is('admin/orders') || Request::is('admin/orders/view*') ? 'active' : '' }}">
                    <a class="sidebar-link" href="{{ route('admin.orders') }}">
                        <i class="align-middle" data-feather="layout"></i> <span class="align-middle">{{$lang->data['orders'] ?? 'Orders'}}</span>
                    </a>
                </li>
                @endif
                @if (Auth::user()->can('view_status_screen') )
                <li class="sidebar-item {{ Request::is('admin/orders/status-screen*') ? 'active' : '' }}">
                    <a class="sidebar-link" href="{{ route('admin.order_status_screen') }}">
                        <i class="align-middle" data-feather="check-circle"></i> <span class="align-middle">{{$lang->data['order_status_screen'] ?? 'Order Status Screen'}}</span>
                    </a>
                </li>
                @endif
                @if (Auth::user()->can('invoices_list') )
                <li
                    class="sidebar-item  {{ Request::is('admin/invoices') || Request::is('admin/invoices/view*') ? 'active' : '' }}">
                    <a class="sidebar-link" href="{{ route('admin.view_invoices') }}">
                        <i class="align-middle" data-feather="layout"></i> <span class="align-middle">{{$lang->data['invoices'] ?? 'Invoices'}}</span>
                    </a>
                </li>
                @endif
                @if (Auth::user()->can('tables_list'))
                <li class="sidebar-item {{ Request::is('admin/tables*') ? 'active' : '' }}">
                    <a class="sidebar-link " href="{{ route('admin.tables') }}">
                        <i class="align-middle" data-feather="grid"></i> <span class="align-middle">{{$lang->data['table']??'Table'}}</span>
                    </a>
                </li>
                @endif

                -->
                @if (Auth::user()->can('sales_report') || Auth::user()->can('day_wise_sales_report') || Auth::user()->can('item_wise_sales_report') || Auth::user()->can('customer_report'))
            <li class="sidebar-item {{ Request::is('admin/reports*') ? 'active' : '' }}">
                <a data-bs-target="#reports" data-bs-toggle="collapse" class="sidebar-link collapsed">
                    <i class="align-middle" data-feather="bar-chart"></i> <span class="align-middle">{{$lang->data['reports']??'Reports'}}</span>
                </a>
                <ul id="reports" class="sidebar-dropdown list-unstyled collapse {{ Request::is('admin/reports*') ? 'show' : '' }}" data-bs-parent="#sidebar">
                    @if (Auth::user()->can('sales_report'))
                        <li class="sidebar-item {{ Request::is('admin/reports/sales*') ? 'active' : '' }} "><a class="sidebar-link" href="{{route('admin.sales_report')}}">{{$lang->data['sales_report'] ?? 'Sales Report'}}</a>
                        </li>
                    @endif
                     <li class="sidebar-item {{ Request::is('admin/reports/client-report*') ? 'active' : '' }} "><a class="sidebar-link" href="{{route('client.report')}}">{{$lang->data['client_report'] ?? 'Client  Report'}}</a>
                        </li>
                     <li class="sidebar-item {{ Request::is('quotation-report*') ? 'active' : '' }}">
                        <a class="sidebar-link" href="{{ route('quotation.report') }}">Quotation Report</a>
                    </li>
                    <li class="sidebar-item {{ Request::is('invoice-payment-pending-report*') ? 'active' : '' }}">
                        <a class="sidebar-link" href="{{ route('invoice.payment.pending.report') }}">Invoice Payment Pending Report</a>
                    </li>
                    <li class="sidebar-item {{ Request::is('appointment-report*') ? 'active' : '' }}">
                        <a class="sidebar-link" href="{{ route('appointment.report') }}">Appointment Report</a>
                    </li>
                    @if (Auth::user()->can('day_wise_sales_report'))
                        <li class="sidebar-item {{ Request::is('admin/reports/day-wise*') ? 'active' : '' }} "><a class="sidebar-link" href="{{route('admin.daywise_report')}}">{{$lang->data['day_wise_report']??'Day Wise Sales
                                Report'}}</a></li>
                    @endif
                    @if (Auth::user()->can('item_wise_sales_report'))
                        <li class="sidebar-item {{ Request::is('admin/reports/item-sales*') ? 'active' : '' }} "><a class="sidebar-link" href="{{route('admin.item_sales_report')}}">{{$lang->data['item_wise_report']??'Item Wise
                                Sales Report'}}</a></li>
                    @endif
                   <!--  @if (Auth::user()->can('customer_report'))
                        <li class="sidebar-item {{ Request::is('admin/reports/customer*') ? 'active' : '' }} "><a class="sidebar-link" href="{{route('admin.customer_report')}}">{{$lang->data['customer_report']??'Customer Report'}}</a></li>
                    @endif -->
                   <!--  @if (Auth::user()->can('stock_report'))
                        <li class="sidebar-item {{ Request::is('admin/reports/stock*') ? 'active' : '' }} "><a class="sidebar-link" href="{{route('admin.stock')}}">{{$lang->data['stock_report']??'Stock Report'}}</a></li>
                    @endif -->
                    @if (Auth::user()->can('low_stock_report'))
                        <li class="sidebar-item {{ Request::is('admin/reports/low_stock*') ? 'active' : '' }} "><a class="sidebar-link" href="{{route('admin.low_stock')}}">{{$lang->data['low_stock_report']??'Low Stock Report'}}</a></li>
                    @endif
                    @if (Auth::user()->can('stock_report_datewise'))
                        <li class="sidebar-item {{ Request::is('admin/reports/datewise_stock*') ? 'active' : '' }} "><a class="sidebar-link" href="{{route('admin.stockdatewise')}}">{{$lang->data['stock_report_datewise']??' Stock Report Date Wise'}}</a></li>
                    @endif

                </ul>
            </li>
            @endif          
                @if (Auth::user()->can('add_staff') ||Auth::user()->can('staffs_list') ||Auth::user()->can('edit_staff') || Auth::user()->can('delete_staff'))
                <li class="sidebar-item {{ Request::is('admin/staff*') ? 'active' : '' }}">
                    <a class="sidebar-link " href="{{ route('admin.staffs') }}">
                        <i class="align-middle" data-feather="users"></i> <span class="align-middle">{{$lang->data['staffs']??'Staffs'}}</span>
                    </a>
                </li>
                @endif
            
                @if (Auth::user()->can('translations_list') )
                <li class="sidebar-item {{ Request::is('admin/translations*') ? 'active' : '' }}">
                    <a class="sidebar-link " href="{{ route('admin.translations') }}">
                        <i class="align-middle" data-feather="globe"></i> <span class="align-middle">{{$lang->data['translations']??'Translations'}}</span>
                    </a>
                </li>
                @endif
                @if (Auth::user()->can('account_settings') || Auth::user()->can('app_settings'))
                <li class="sidebar-item {{ Request::is('admin/settings*') ? 'active' : '' }}">
                    <a data-bs-target="#settings" data-bs-toggle="collapse" class="sidebar-link collapsed">
                        <i class="align-middle" data-feather="settings"></i> <span class="align-middle">{{$lang->data['settings']??'Settings'}}</span>
                    </a>
                    <ul id="settings" class="sidebar-dropdown list-unstyled collapse  {{ Request::is('admin/settings/*') ? 'show' : '' }}" data-bs-parent="#sidebar">
                        @if (Auth::user()->can('account_settings') )
                        <li class="sidebar-item {{ Request::is('admin/settings/account') ? 'active' : '' }}" ><a class="sidebar-link"
                                href="{{ route('admin.account_settings') }}">{{$lang->data['account_settings']??'Account Settings'}}</a>
                        </li>
                        @endif
                        @if (Auth::user()->can('app_settings') )
                        <li class="sidebar-item {{ Request::is('admin/settings/app') ? 'active' : '' }}"><a class="sidebar-link" href="{{ route('admin.app_settings') }}">{{$lang->data['app_settings']??'App
                                Settings'}}</a></li>
                        @endif
                        @if (Auth::user()->can('mail_settings') )
                        <li class="sidebar-item {{ Request::is('admin/settings/mail') ? 'active' : '' }}"><a class="sidebar-link" href="{{ route('admin.mail_settings') }}">{{$lang->data['mail_settings']??'Mail
                                Settings'}}</a></li>
                        @endif
                    </ul>
                </li>
                @endif
                <li class="sidebar-item">
                    <a class="sidebar-link" href="#" wire:click.prevent='logout'>
                        <i class="align-middle" data-feather="log-out"></i> <span class="align-middle">{{$lang->data['logout']??'Logout'}}</span>
                    </a>
                </li>
            </ul>
        </div>
    </nav>
</div>
