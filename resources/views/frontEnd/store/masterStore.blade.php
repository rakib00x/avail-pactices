<style>
    .supplier-slider{
        object-fit: contain;
        object-position: 50% 50%;
        height: 60vh!important;
    }
</style>
<div class="columns mb-0">
            <div class="column mb-0">
                @php 
     $all_sli = DB::table('tbl_slider')->where('supplier_id', $supplier_id)->where('status', 1)->get(); 
    @endphp

                @if(count($all_sli) > 0)
                    <div id="store-banner" style="
                    background-size: 1400px 220px;;
                    ">
                    <div id="supplier-slider">
                        <?php $all_slider = DB::table('tbl_slider')->where('supplier_id', $supplier_id)->where('status', 1)->get(); ?>
                        <?php foreach ($all_slider as $key => $slidervalue): ?>
                            <a href="#" title=""><img src="{{ URL::to('public/images/supplierSlider/'.$slidervalue->slider_image) }}" alt="{{ $store_info->storeName }}"/>
                                 </a>
                        <?php endforeach ; ?>
                       
                    </div>
                
                        <div style="    position: absolute;top: 0;right: 0;">
                            <div class="store_left">
    
                           </div>
                           <div class="store_middle">
    
                           </div>
                           <div class="store_right mt-5">
                               <div class="store_contact_supplier mt-5">
                                    <p><a href="#" onclick="sendquotationinfo(<?php echo $store_info->id; ?>, '<?php echo $store_info->storeName;  ?>')"><span>Contact Supplier</span></a></p>
                               </div>
                               <div class="store_chat_now mt-3">
                                    <?php 
                                        if (Session::get('supplier_id') != null || Session::get('buyer_id') != null){
                                            if(Session::get('supplier_id') != null){
                                                $main_login_id = Session::get('supplier_id');
                                            }else{
                                                $main_login_id = Session::get('buyer_id');
                                            }
                                        }else{
                                            $main_login_id = 0;
                                        }
                                    ?>
                                    <?php if($main_login_id == 0): ?>
                                        <p><a href="#" onclick="supplierChatPageShow({{ $main_login_id }}, {{ $store_info->id }}, '{{ $store_info->first_name." ".$store_info->last_name }}')"><span>Chat Now</span></a></p>
                                    <?php else: ?>
                                        <p><a href="#" onclick="supplierChatPageShow({{ $main_login_id }}, {{ $store_info->id }}, '{{ $store_info->first_name." ".$store_info->last_name }}')"><span>Chat Now</span></a></p>
                                    <?php endif; ?>
                               </div>
                           </div>
                        
                        </div>

                    </div>
                @else
                    <div id="store-banner" style="background: url('{{ URL::to("public/images/defult/")}}/<?php if($banner_info){ if($banner_info->header_image != ""){echo $banner_info->header_image;}else{ echo $default_banner->banner_image; } $banner_info->header_image; }else{echo $default_banner->banner_image; } ?>');
                    background-size: 1400px 220px;;
                    background-repeat: no-repeat;">
                       <div class="store_left">
                           	<?php if ($store_info->image): ?>
                           	<img class="store_company_logo" src="{{ URL::to('public/images/spplierPro/'.$store_info->image) }}" alt="">
							<?php else: ?>
							<img class="store_company_logo" src="{{ URL::to('public/images/defult/'.$default_banner->logo) }}" alt="">
							<?php endif ?>
                       </div>
                       <div class="store_middle">
                            <h1 class="store_company">{{ $store_info->storeName }}</h1>
                            <p><label><span></span> {{ $store_info->countryCode }} <span>
                                <?php
                                    $created_at = date("d M Y", strtotime($store_info->created_at)) ;
                                    $today_date = date("d M Y");
                                    $datetime1 = new DateTime("$created_at");
                                    $datetime2 = new DateTime($today_date);
                                    $interval = $datetime1->diff($datetime2);
                                    
                                    if($interval->format('%y') == 0){
                                        echo $interval->format('%m M, %d D');
                                    }else{
                                        echo $interval->format('%y Y, %m M');
                                    }
                                ?>
                            </span></label></p>
                            <p>{{ $store_info->companyDetails }}</p>
                       </div>
                       <div class="store_right mt-5">
                           <div class="store_contact_supplier mt-5">
                                <p><a href="#" onclick="sendquotationinfo(<?php echo $store_info->id; ?>, '<?php echo $store_info->storeName;  ?>')"><span>Contact Supplier</span></a></p>
                           </div>
                           <div class="store_chat_now mt-3">
                                <?php 
                                    if (Session::get('supplier_id') != null || Session::get('buyer_id') != null){
                                        if(Session::get('supplier_id') != null){
                                            $main_login_id = Session::get('supplier_id');
                                        }else{
                                            $main_login_id = Session::get('buyer_id');
                                        }
                                    }else{
                                        $main_login_id = 0;
                                    }
                                ?>
                                <?php if($main_login_id == 0): ?>
                                    <p><a href="#" onclick="supplierChatPageShow({{ $main_login_id }}, {{ $store_info->id }}, '{{ $store_info->first_name." ".$store_info->last_name }}')"><span>Chat Now</span></a></p>
                                <?php else: ?>
                                    <p><a href="#" onclick="supplierChatPageShow({{ $main_login_id }}, {{ $store_info->id }}, '{{ $store_info->first_name." ".$store_info->last_name }}')"><span>Chat Now</span></a></p>
                                <?php endif; ?>
                           </div>
                       </div>
                    </div>
                @endif
                
            </div>
        </div>

        <!-- Store Menu Bar -->
        <div class="column m-0 p-0">
            <div class="column m-0 p-0 mb-3">
                <div id="store-navbar" class="navbar-menu">
                    <div class="navbar-start">
                        <a href="{{ URL::to('store/'.strtolower($store_name)) }}" class="navbar-item not-nested">Home</a>
                        <div class="navbar-item has-dropdown is-hoverable">
                            <a class="navbar-link not-nested">Products</a>
                            <div class="navbar-dropdown">

                               <?php
                                    $supplier_catgeory = DB::table('tbl_supplier_primary_category')->where('status', 1)->where('supplier_id', $supplier_id)->get() ;
                                    foreach ($supplier_catgeory as $key => $categoryvalues):
                                ?>
                                <?php

                                    $get_secondary_category = DB::table('tbl_supplier_secondary_category')
                                        ->where('primary_category_id', $categoryvalues->id)
                                        ->where('supplier_id', $supplier_id)
                                        ->where('status', 1)
                                        ->get() ;

                                ?>

                                <div class="nested dropdown">
                                    <a href="{{ URL::to('stp-category/'.strtolower($store_name).'/'.$categoryvalues->catgeory_slug.'/g'.'/heightolow') }}" class="navbar-item">
                                        <?php if(count($get_secondary_category) > 0): ?>
                                            <span class="icon-text "><span>{{ $categoryvalues->category_name }}</span>
                                            <span class="icon"><i class="fas fa-chevron-right"></i></span></span>
                                        <?php else: ?>
                                            <span class="icon-text "><span>{{ $categoryvalues->category_name }}</span></span>
                                        <?php endif; ?>
                                    </a>
                                    <?php if(count($get_secondary_category) > 0): ?>
                                    <div class="dropdown-menu" id="dropdown-menu" role="menu">
                                        <div class="dropdown-content">
                                            <?php foreach ($get_secondary_category as $key => $secondarycategoryvalue): ?>
                                                <a href="{{ URL::to('sps-category/'.strtolower($store_name).'/'.$secondarycategoryvalue->secondary_category_slug.'/g'.'/heightolow') }}" class="dropdown-item">{{ $secondarycategoryvalue->secondary_category_name }}</a>
                                            <?php endforeach ?>
                                        </div>
                                    </div>
                                    <?php endif; ?>
                                </div>
                                <?php endforeach ?>

                            </div>
                        </div>
                        <div class="navbar-item has-dropdown is-hoverable">
                            <a class="navbar-link not-nested">Prifle</a>
                            <div class="navbar-dropdown">

                                <div class="nested dropdown">
                                    <a href="{{ URL::to('company-overview/'.strtolower($store_name)) }}" class="navbar-item"><span class="icon-text"><span>Company Overview</span></span></a>
                                </div>
                                {{--<div class="nested dropdown">
                                    <a href="{{ URL::to('production-capacity/'.strtolower($store_name)) }}" class="navbar-item"><span class="icon-text"><span>Production Capacity</span></span></a>
                                </div>
                                <div class="nested dropdown">
                                    <a href="{{ URL::to('trade-capacity/'.strtolower($store_name)) }}" class="navbar-item"><span class="icon-text"><span>Trade Capacity</span></span></a>
                                </div>--}}

                            </div>
                        </div>
                        <a href="{{ URL::to('store-contact/'.strtolower($store_name)) }}" class="navbar-item not-nested">Contact</a>
                        <?php
                            $check_count = DB::table('tbl_supplier_terms_conditions')->where('status', 1)->where('supplier_id', $store_info->id)->count() ;
                            if($check_count > 0):
                        ?>
                        <a href="{{ URL::to('terms-condition/'.strtolower($store_name)) }}" class="navbar-item not-nested">Terms & Conditions</a>
                        <?php endif; ?>
                    </div>
                    <div class="navbar-end">
                        <div class="navbar-item">
                            {!! Form::open(['url' =>'ssearch','method' => 'get','role' => 'form', 'files'=>true]) !!}
                            <div class="field is-grouped">
                                <p class="control">
                                    <input class="input" type="text" name="keywrods" placeholder="Search in this store">
                                </p>
                                <input type="hidden" name="store" value="{{ strtolower($store_name) }}">
                                <input type="hidden" name="filter" value="lowtoheigh">
                                <input type="hidden" name="type" value="g">
                                <p class="control">
                                    <input type="submit" class="button is-primary" value="Search">
                                </p>
                            </div>
                            {!! Form::close() !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
    <script src="{{ URL::to('public/frontEnd/assets/js/supplierSlider.js') }}"></script>
    <script>
        $(function() {
            $('#supplier-slider').supplierMiniSlider();
        });
    </script>