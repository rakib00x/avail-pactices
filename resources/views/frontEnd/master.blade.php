<?php
	$social 	= DB::table('tbl_social_media')->where('supplier_id', 0)->first();
	$meta_info 	= DB::table('tbl_meta_tags')->first();
	$currency  	= DB::table('tbl_currency_status')->where('status',1)->get();
	$settings 	= DB::table('tbl_logo_settings')->where('status', 1)->first();
	
	$login_page = URL::current();
	if($login_page != "https://availtrade.com/search" || $login_page != "https://availtrade.com/search"){
	    Session::put('keywords', "");
	    
	}
	
	if (Session::get('supplier_id') != null || Session::get('buyer_id') != null || Session::get('buyer_id') != null){
        if(Session::get('supplier_id') != null){
            $main_login_id = Session::get('supplier_id');
            $pending_order_count = DB::table('order')->where('supplier_id', Session::get('supplier_id'))->where('status', 0)->count() ;
	        $confirm_order_count = DB::table('order')->where('supplier_id', Session::get('supplier_id'))->where('status', 1)->count() ;
            
        }else if(Session::get('seller_id') != null){
            $main_login_id = Session::get('seller_id');
            $pending_order_count = DB::table('order')->where('supplier_id', Session::get('seller_id'))->where('status', 0)->count() ;
	        $confirm_order_count = DB::table('order')->where('supplier_id', Session::get('seller_id'))->where('status', 1)->count() ;
            
        }
        else{
            $main_login_id = Session::get('buyer_id');
            $pending_order_count = DB::table('order')->where('customer_id', Session::get('buyer_id'))->where('status', 0)->count() ;
	        $confirm_order_count = DB::table('order')->where('customer_id', Session::get('buyer_id'))->where('status', 1)->count() ;
           
        }
    }else{
        $pending_order_count = 0;
        $confirm_order_count = 0;
        $main_login_id = 0;
    }
	
	
	
    $active_popup_ads = DB::table('tbl_popup_ads')->where('status', 1)->first() ;
?>
<!DOCTYPE html> 
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Availtrade| @yield('title')</title>
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta name="csrf-token" content="{{ csrf_token() }}">
	@yield('meta_info')
	
	<meta name="author" content="Availtrade">
	<meta name="google-site-verification" content="k0EeY83SLz-MJ7Qhk_rszBYI1Ip9xLZ1MG6R26DEvow" />
	<link rel="canonical" href="{{ url()->full() }}"/>
	<link rel="stylesheet" href="{{ URL::to('public/webassets/main.css') }}"/>
	<link rel="stylesheet" href="{{ URL::to('public/webassets/custom.css') }}"/>
	<link rel="stylesheet" href="{{ URL::to('public/webassets/popup.css') }}"/>
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bulma@0.9.3/css/bulma.min.css">
	<link rel="stylesheet" href="{{ URL::to('public/chat/style.css') }}"/>
	<link rel="stylesheet" href="{{ URL::to('public/chat/chat-main.css') }}"/>
    <link rel="stylesheet" href="{{ URL::to('public/webassets/notification-counter.css') }}">
	<link rel="stylesheet" href="{{ URL::to('public/webassets/category-megamenu.css') }}"/>
	<?php if($settings): ?>
	<link rel="icon" href="{{ URL::to('public/images/'.$settings->favicon) }}" type="image/x-icon">
	<?php endif; ?>
	
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">

    <!-- fancybox -->
    <link rel="stylesheet" type="text/css" href="{{ URL::to('public/fancybox/jquery.fancybox.css') }}" media="screen" />
    <!-- Add Button helper (this is optional) -->
    <link rel="stylesheet" type="text/css" href="{{ URL::to('public/fancybox/helpers/jquery.fancybox-buttons.css') }}" />

    <!-- jQuery Zoom Plugins -->
    <link rel="stylesheet" type="text/css" href="{{ URL::to('public/zoom/css/xzoom.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ URL::to('public/frontEnd/assets/css/jquery.countdownTimer.css')}}">
    <link rel="stylesheet" type="text/css" href="{{ URL::to('public/frontEnd/assets/css/master.css') }}">
    

	<script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
	
	<!-- jQuery Modal -->
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-modal/0.9.1/jquery.modal.min.js"></script>
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-modal/0.9.1/jquery.modal.min.css" />
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.lazyload/1.9.1/jquery.lazyload.js"></script>
	
	<script src="{{ URL::to('public/frontEnd/assets/js/jquery.countdownTimer.js')}}"></script>
	
	
	<link rel="icon" href="{{ URL::to('public/images/'.$settings->favicon) }}" type="image/x-icon">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css" integrity="sha512-vKMx8UnXk60zUwyUnUPM3HbQo8QfmNx7+ltw8Pm5zLusl1XIfwcxo8DbWCqMGKaWeNxWA8yrx5v3SaVpMvR3CA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
	

	



    @yield('css')
    <meta name="google-site-verification" content="xsR18vCOX2APvVUtx0_MQg1KOsiVODZkSMU6D9OBhKM" />
    
    
<!-- Google tag (gtag.js) -->
<script async src="https://www.googletagmanager.com/gtag/js?id=G-Z8VVD2W6RR"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'G-Z8VVD2W6RR');
</script>

</head>
<body @yield('store_background')>

	<header>
		<div class="container">
			<div class="columns">
				<div class="column is-one-fifth">
				    <h1 class="avail">availtrade</h1>
					<div class="logo">
						<a  href="{{ URL::to('') }}" title=""><img class="logass" src="{{ URL::to('public/images/'.$settings->logo) }}"  alt="availtrade"/></a>
					</div>
				</div>
				<div class="column is-two-quarters">
					{!! Form::open(['url' =>'search','method' => 'get','role' => 'form', 'class' => 'form form-horizontal', 'files'=>'true']) !!}
					<div class="searchbar">

						<select name="search_type">
							<option value="product" <?php if(Session::has('search_type')){ if(Session::get('search_type') == "product"){echo "selected"; }else{echo ""; } } ?>>Products</option>
							<option value="supplier" <?php if(Session::has('search_type')){ if(Session::get('search_type') == "supplier"){echo "selected"; }else{echo ""; } } ?>>supplier</option>
						</select>
					<input class="input" type="text" name="keywords" placeholder=" <?php echo Session::get('buyer_id'); ?> What are you looking for..." value="<?php if(Session::has('keywords')){echo Session::get('keywords'); } ?>">
						<input type="hidden" name="viewType" value="L">
						<button class="button">
							<span class="ml-2 mr-2">
								<i class="fa fa-search" aria-hidden="true"></i>
							</span>
							Search</button>
					</div>
					{!! Form::close() !!}
				</div>
				<div class="column is-one-third">
					<div class="rightmenu">
						<ul>


							<?php if (Session::get('supplier_id') != null || Session::get('buyer_id') != null || Session::get('seller_id') != null): ?>
								<li>
									<?php if (Session::get('supplier_id') != null && Session::get('seller_type') != 1){ ?>
									<div class="dropdown is-right is-hoverable">
									  <div class="dropdown-trigger">

								  		<a href="#" aria-haspopup="true" aria-controls="dropdown-menu4">
								  			<?php $supplier_info = DB::table('express')->where('id', Session::get('supplier_id'))->first() ; ?>
											<div style="display: flex;" class="user">
											    <?php if($supplier_info->image != "" || $supplier_info->image != null){
				                                    if(strpos($supplier_info->image, "https") !== false){
				                                       $image_urlo = $supplier_info->image ;
				                                    } else{
				                                       $image_urlo = "public/images/spplierPro/".$supplier_info->image;
				                                    }
				                                }else{
				                                    $image_urlo = "public/images/Image 4.png";
				                                } ?>
											    
											    <img class="storsdf"  src='{{ URL::to("$image_urlo") }}'  alt="Availtrade"/>
												<span class="styuig" >{{ $supplier_info->storeName }}</span>
											</div>
										</a>

									  </div>
									  <div class="dropdown-menu" id="dropdown-menu4" role="menu">
									    <div class="dropdown-content">
									      <a href="{{ URL::to('supplierDashboard') }}" class="dropdown-item">
									        Dashboard
									      </a>
									      <a href="{{ URL::to('logout') }}" class="dropdown-item">
									        Logout
									      </a>
									    </div>
									  </div>
									</div>
									<?php }else if(Session::get('supplier_id') != null && Session::get('seller_type') == 1){ ?>
									<div class="dropdown is-right is-hoverable">
									  <div class="dropdown-trigger">

								  		<a href="#" aria-haspopup="true" aria-controls="dropdown-menu4">
								  			<?php
                                       $seller_info = DB::table('express')->where('id', Session::get('supplier_id'))->first() ; 
								  				?>
								  				
								  				
											<div class="user">
                	                            <?php if($seller_info->image != "" || $seller_info->image != null){
				                                    if(strpos($seller_info->image, "https") !== false){
				                                       $image_ursl = $seller_info->image ;
				                                    } else{
				                                       $image_ursl = "public/images/spplierPro/".$seller_info->image;
				                                    }
				                                }else{
				                                    $image_ursl = "public/images/Image 4.png";
				                                } ?>

				                                <img class="jkisdop"  src='{{ URL::to("$image_ursl") }}'  alt="$seller_info->first_name"/>

												<span class="styuig">{{ $seller_info->first_name." ".$seller_info->last_name }}</span>
												
											</div>
										</a>

									  </div>
									  <div class="dropdown-menu" id="dropdown-menu4" role="menu">
									    <div class="dropdown-content">
									      <a href="{{ URL::to('sellerDashboard') }}" class="dropdown-item">
									        Dashboard
									      </a>
									      <a href="{{ URL::to('logout') }}" class="dropdown-item">
									        Logout
									      </a>
									    </div>
									  </div>
									</div>
									
									<?php }else{ ?>
								
									<div class="dropdown is-right is-hoverable">
									  <div class="dropdown-trigger">

								  		<a href="#" aria-haspopup="true" aria-controls="dropdown-menu4">
								  			<?php

								  				$customer_info = DB::table('express')->where('id', $main_login_id)->first() ; ?>
											<div class="user">

												<?php if($customer_info->image != "" || $customer_info->image != null){
				                                    if(strpos($customer_info->image, "https") !== false){
				                                       $image_url = $customer_info->image ;
				                                    } else{
				                                       $image_url = "public/images/buyerPic/".$customer_info->image;
				                                    }
				                                }else{
				                                    $image_url = "public/images/Image 4.png";
				                                } ?>

				                                <img class="jkisdop"  src='{{ URL::to("$image_url") }}'  alt="{{$customer_info->first_name}}"/>

												<span class="styuig">{{ $customer_info->first_name." ".$customer_info->last_name }}</span>
											</div>
										</a>

									  </div>
									  <div class="dropdown-menu" id="dropdown-menu4" role="menu">
									    <div class="dropdown-content">
									      <a href="{{ URL::to('buyerDashboard') }}" class="dropdown-item">
									        Dashboard
									      </a>
									      <a href="{{ URL::to('logout') }}" class="dropdown-item">
									        Logout
									      </a>
									    </div>
									  </div>
									</div>
									<?php } ?>

								</li>
							<?php else: ?>
                                <li>
                                    <div class="dropdown is-right is-hoverable">
                                        <div class="dropdown-trigger">
                                            <a href="{{ URL::to('login') }}" class="hover-signin" aria-haspopup="true" aria-controls="dropdown-menu4">
                                                <div class="user">
                                                    <div class="header-signin-mother">
                                                        <div class="header-signin-child-one user">
                                                            <img src="{{ URL::to('public/images/Image 4.png') }}" class="imgesingn" alt="singin"/>
                                                            <span class="dfsign">Sign in & <br/>Join free</span>
                                                        </div>
                                                        <div class="header-signin-child-two" >
                                                            <?php if (Session::get('supplier_id') != null || Session::get('buyer_id') != null): ?>
                                                                <span class="pending-messages">0</span>
                                                            <?php endif; ?>
                                                        </div>
                                                    </div>
                                                </div>
                                            </a>
                                        </div>
                                    </div>
                                </li>
							<?php endif ?>
                                <li>
                                  
                                    @if (Session::get('supplier_id') != null || Session::get('buyer_id') != null)
                                    <a href="#" onclick="showChatOptions(event)"  class="<?php if (Session::get('supplier_id') != null || Session::get('buyer_id') != null){echo "hover-message"; }else{echo " "; }?> ">
                                        <div class="header-message-mother">
                                            <div class="header-message-child-one">
                                                <img src="{{ URL::to('public/images/Image 5.png') }}" alt="User"/><br/>
                                                <span>Messages</span>
                                            </div>
                                            <div class="header-message-child-two">
                                                <?php if (Session::get('supplier_id') != null || Session::get('buyer_id') != null): ?>
                                                    <?php
                                                        $total_pending_count = DB::table('tbl_messages')->where('receiver_id', $main_login_id)->where('is_read', 0)->count() ;    
                                                    ?>
                                                    <span class="pending-messages">{{  $total_pending_count }}</span>
                                                <?php endif; ?>
                                                
                                            </div>
                                        </div>
                                    </a>
                                    @else
                                        <a href="#" onclick="showLoginModal(event)" class="<?php if (Session::get('supplier_id') != null || Session::get('buyer_id') != null){echo "hover-message"; }else{echo " "; }?> ">
                                            <div class="header-message-mother">
                                                <div class="header-message-child-one">
                                                    <img src="{{ URL::to('public/images/Image 5.png') }}" alt="user"/><br/>
                                                    <span>Messages</span>
                                                </div>
                                                <div class="header-message-child-two">
                                                    <?php if (Session::get('supplier_id') != null || Session::get('buyer_id') != null): ?>
                                                        
                                                        <?php
                                                            $total_pending_count = DB::table('tbl_messages')->where('receiver_id', $main_login_id)->where('is_read', 0)->count() ;    
                                                        ?>
                                                        <span class="pending-messages">{{  $total_pending_count }}</span>
                                                    <?php endif; ?>
                                                    
                                                </div>
                                            </div>
                                        </a>
                                    @endif
                                    
                                </li>
                                <li>
                                    <a href="#" class="<?php if (Session::get('supplier_id') != null || Session::get('buyer_id') != null){echo "hover-order"; }else{echo " "; }?>">

                                        <div class="header-order-mother">
                                            <div class="header-order-child-one">
                                                <img src="{{ URL::to('public/images/Image 6.png') }}" alt="{{Session::get('name')}}"/><br/>
                                                <span>Orders</span>
                                            </div>
                                            <div class="header-order-child-two">
                                                <?php if (Session::get('supplier_id') != null || Session::get('buyer_id') != null): ?>
                                                    <span class="pending-messages-2">{{ $pending_order_count }}</span>
                                                <?php endif; ?>
                                            </div>
                                        </div>

                                    </a>
                                </li>
                                <li>
                                    <a href="{{ URL::to('cart') }}" class="trep">
                                        <div class="header-cart-mother">
                                            <div class="header-cart-child-one">
                                                <img src="{{ URL::to('public/images/Image 7.png') }}" alt="cart-availtrade"/><br/>
                                                <span>Cart</span>
                                            </div>
                                            <div class="header-cart-child-two minxa">
                                                <span class="pending-messages">98</span>
                                            </div>
                                        </div>
                                    </a>
                                </li>
						</ul>
					</div>
				</div>

                <!-- Cart POP-UP -->
                <div id="pop-up" class="mout">
                    <div class="cart-parent">
                        <div class="cart-child-one">
                            <img src="{{ URL::to('public/images') }}/upper-arrow.png" alt="arrow-availtrade">
                        </div>
                        <?php if (Session::get('supplier_id') != null || Session::get('buyer_id') != null): ?>
                        <div class="cart-child-two">
                            <div class="cart-pop">
                                <div class="cart-area">

                                </div>
                                <div class="cart-button">
                                	<a href="{{ URL::to('cart') }}" title="">
                                    <input type="submit" class="cart-submit" value="Go to cart" style="cursor :pointer"></a>
                                </div>
                            </div>
                        </div>
                        <?php else: ?>
                        <div class="cart-child-two">
                            <div class="cart-pop-no-session">
                                <h3>No items in cart</h3>
                            </div>
                        </div>
                        <?php endif; ?>
                    </div>
                </div>
   
                <!-- Message POP-UP -->
                <div id="message-pop-up">
                    <div class="message-parent">
                        <div class="message-child-one">
                            <img src="{{ URL::to('public/images') }}/upper-arrow.png" alt="arrow-availtrade">
                        </div>
                        <div class="message-child-two">
                            <div class="message-pop">
                               
                                
                                <div class="cart-button">
                                    <input type="submit" class="cart-submit" value="View all messages >">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Sign-in POP-UP -->
                <div id="signin-pop-up">
                    <div class="signin-parent">
                        <div class="signin-child-one">
                            <img src="{{ URL::to('public/images') }}/upper-arrow.png" alt="availtrade">
                        </div>
                        <div class="signin-child-two">
                            <div class="signin-pop">
                                <h3 class="getstart">Get started now</h3>
                                <a class="button is-link insign"   href="{{ URL::to('login') }}">Sign In</a>
                                <h3 class="ors">Or</h3>
                                <a class="button is-link joinfree" href="{{ URL::to('registration') }}">Join Free</a>
                                <a class="button is-link facebook" href="{{URL::to('loginwithfacebook')}}">Login with Facebook</a>
                                <a class="button is-link google"  href="{{URL::to('loginwithgmail')}}">Login with Google</a>
                                <a class="button is-link linkdin" href="{{URL::to('loginwithlinkedin')}}">Login with Linkedin</a>
                                <!--<a class="button is-link" style="width: 100% !important;background: #00acee;" href="{{ URL::to('login')}}">Login with Twitter</a>-->
                            </div>
                        </div>
                    </div>
                </div>

               <!--//  Order POP-UP -->
                <div id="order-pop-up">
                    <div class="order-parent">
                        <div class="order-child-one">
                            <img src="{{ URL::to('public/images') }}/upper-arrow.png" alt="availtrade">
                        </div>
                        

                        <div class="order-child-two">
                            <div class="order-pop">
                            <?php if(Session::get('buyer_id')): ?>
                                <p class="order-link"><a href="#">Pending Order <sup>({{ $pending_order_count }})</sup> </a></p>
                                <p class="order-link"><a href="#">Confirm Order <sup>({{ $confirm_order_count }})</sup> </a></p>
                               
                                <hr class="hrcas">
                                <div class="cart-button">
                                    <a href="{{URL::to('buyerOrderList')}}"><input type="submit" class="cart-submit" value="Order with trade assurance"></a>
                            
                                </div>
                            <?php else: ?>
                                <p class="order-link"><a href="#">Pending Order <sup>({{ $pending_order_count }})</sup> </a></p>
                                <p class="order-link"><a href="#">Confirm Order <sup>({{ $confirm_order_count }})</sup> </a></p>
                                       
                                <hr class="hrcas">
                                <div class="cart-button">
                                    <a href="{{URL::to('supplier-orders-list')}}"><input type="submit" class="cart-submit" value="Order with trade assurance"></a>
                                </div>
                             <?php endif; ?>
                    </div>
                </div>

			</div>
		</div>
	</header>

	<div class="header-bottom">
		<div class="container">
		    <div class="columns is-full">
		        <div class="column is-four-fifths">
				<ul>
					<li id="header-category">
						<div class="header-category-link">
							Categories <i class="fa fa-angle-down" aria-hidden="true"></i>
						</div>

						<div class="header-category-1st">
							<ul>
								<?php
									$all_categorys_top = DB::table('tbl_primarycategory')
									->join('tbl_secondarycategory', 'tbl_primarycategory.id', '=', 'tbl_secondarycategory.primary_category_id')
									->select('tbl_primarycategory.*', 'tbl_secondarycategory.primary_category_id')
									->where('tbl_primarycategory.status', 1)
									->groupBy('tbl_primarycategory.id')
									->groupBy('tbl_secondarycategory.primary_category_id')
									->limit(8)
									->get() ;
									foreach ($all_categorys_top as $top_catvalue) { ?>
								<li id="dropdown">
									    <div class="is-pulled-right mt-1">
    										<span ><i class="fa fa-chevron-right" aria-hidden="true"></i></span>
    									</div>
									    <?php 
									        $all_sec_category_top3 = DB::table('tbl_secondarycategory')
												->where('status', 1)
												->where('primary_category_id', $top_catvalue->id)
												->limit(4)
												->get() ; 
												
											foreach ($all_sec_category_top3 as $key => $svalue): ?>
										<a href="{{ URL::to('/seccategory/'.$svalue->secondary_category_slug.'/heightolow')}}" class="linkup"><?php echo $svalue->secondary_category_name; ?></a> <?php if(count($all_sec_category_top3) == $key+1){ echo ""; }else{echo "/"; } ?>
									<?php endforeach ?>
									
									<div class="header-category-2nd catago">
										<div class="is-flex columns is-multiline">
											<?php
												$all_sec_category_top = DB::table('tbl_secondarycategory')
												->where('status', 1)
												->where('primary_category_id', $top_catvalue->id)
												->limit(4)
												->get() ;
											foreach ($all_sec_category_top as $sec_catvalue) { ?>
											<div class="column is-narrow">
												<p><a href="{{ URL::to('seccategory/'.$sec_catvalue->secondary_category_slug.'/heightolow') }}"><strong><?php echo $sec_catvalue->secondary_category_name; ?></strong></a></p>
												<ul>
													<?php
														$all_ter = DB::table('tbl_tartiarycategory')
														->where('primary_category_id', $top_catvalue->id)
														->where('secondary_category_id', $sec_catvalue->id)
														->limit(7)
														->get() ;
														foreach($all_ter as $tervalue){?>
															<li><a href="{{ URL::to('/tercategory/'.$tervalue->tartiary_category_slug.'/heightolow') }}">{{ $tervalue->tartiary_category_name }}</a></li>
													<?php }?>
												</ul>
											</div>
											<?php }
											?>
										</div>
									</div>
								</li>

								<?php } ?>

							</ul>
						</div>
						
					</li>
					<!--<li><a href="#"></a></li>-->
					
					<li><a href="{{URL::to('package')}}" target="_blank">Supplier package</a></li>
				    
					<li><a href="{{route('help')}}">Help</a></li>
					<h3 class="avail">availtrade</h3>
				</ul>

		        </div>
		        <div class="column is-auto">
		            
		            
		            	<!--  <currency/ship/langouse/>-->
		            
			    <ul>
	    		<div class="navbar-item has-dropdown is-hoverable">
	    		    
                    <a class="navbar-link"><img src="{{ URL::to('public/country_flags/') }}/<?php echo strtolower(Session::get('countrycode')).".png"; ?>"  alt="availtrade">&nbsp;&nbsp;<?php 
					    if(Session::has('requestedCurrency')){
					        $currency_info = DB::table('tbl_currency_status')->where('id', Session::get('requestedCurrency'))->first();
					        echo $currency_info->code."/".$currency_info->name;
					    }
					?></a>
					<?php $all_country = DB::table('tbl_countries')->orderBy('countryName', 'asc')->get() ; ?>
                    <div class="navbar-dropdown">
                            <p class="pl-2">Ship to</p>
                            {!! Form::open(['url' =>'changeCurrency','method' => 'post','role' => 'form' ,'files' => true]) !!}
                            <select class="shipto-input" name="country">
                                <option value="">Select Country</option>
                                <?php foreach($all_country as $country): ?>
                                <option value="{{ $country->countryCode }}" get_country_code="{{ $country->id }}">{{ substr($country->countryName, 0, 15) }}</option>
                                <?php endforeach; ?>
                            </select>
                            <p class="pl-2">Language</p>
                            <select class="shipto-input" name="lan">
                                <option value="">Select Language</option>
                                <option value="1">Bangla</option>
                                <option value="2">English</option>
                            </select>
                            
                            <p class="pl-2">Currency</p>
                            <select class="shipto-input" name="currency_id">
                                <option value="">Select Currency</option>
                                <?php
    						        $all_currency = DB::table('tbl_currency_status')
    						            ->whereNotIn('id', [Session::get('requestedCurrency')])
    						            ->where('status', 1)
    						            ->get() ;
    						        foreach($all_currency as $currencyvalue):
    						    ?>
                                    <option value="{{ $currencyvalue->id }}">{{ $currencyvalue->name }} {{ $currencyvalue->code }}</option>
                                <?php endforeach; ?>
                                
                            </select>
                            <input type="submit" class="shipto-submit ml-2 mr-2" value="SAVE">
                        {!! Form::close() !!}
                    </div>
                    
			    </div>
			    </ul>
			</div>
			</div>
		</div>
	</div>
   @php
	$namaz 	= DB::table('namazs')->where('status', 1)->get();
@endphp
@if(count($namaz) > 0)
	<div class="notify">
	     
	    <marquee class="marquges" scrollamount="4">
        @foreach($namaz as $namazvalue)
	        {{$namazvalue->name}}
        @endforeach
	   
	    </marquee>
	     
    </div>
@endif
   
    
	@yield('content')

    @yield('store_social_network')

	<footer class="footer-top-bar">
        <div class="container">

            <div class="columns ml-2">
                <div class="column is-one-third">

                    <ul class="footer-list-controller">
                        <li><p class="carecustomer">Customer Care</p></li>
                        <li><a href="{{route('help')}}">Help Center</a></li>
                        <li><a href="{{route('contact')}}">Contact Us</a></li>
                        <li><a href="{{route('termsc')}}">Terms & Conditions</a></li>
                        <li><a href="{{route('privacy.policy')}}">Privacy & Policy</a></li>
                    </ul>
                    <br>
                    <ul class="footer-list-controller">
                        <li><p class="carecustomer">Earn with Availtrade</p></li>
                        <li><a href="{{route('auth.login')}}">Join Affiliate Team</a></li>
                        <li><a href="{{URL::to('supplierregistration')}}">Supplier Registation</a></li>
                        <!--<li><a href="#">Report Abuse</a></li>-->
                        <!--<li><a href="#">Submit a Dispute</a></li>-->
                    </ul>

                </div>
                <div class="column is-one-third">
                    <ul class="footer-list-controller">
                        <li><p class="carecustomer">Availtrade</p></li>
                        <li><a href="{{route('help')}}">Help Center</a></li>
                        <li><a href="{{URL::to('all-categories')}}">All Category</a></li>
                        <li><a href="{{route('contact')}}">Contact Us</a></li>
                        <li><a href="#">Report Abuse</a></li>
                        <!--<li><a href="#">Submit a Dispute</a></li>-->
                        <!--<li><a href="#">Help Center</a></li>-->
                        <!--<li><a href="#">Contact Us</a></li>-->
                        <!--<li><a href="#">Report Abuse</a></li>-->
                        <!--<li><a href="#">Submit a Dispute</a></li>-->
                        <!--<li><a href="#">Contact Us</a></li>-->
                        <!--<li><a href="#">Report Abuse</a></li>-->
                        <!--<li><a href="#">Submit a Dispute</a></li>-->
                    </ul>
                </div>
                <div class="column is-auto">
                    <div class="is-flex subscribe">
                        {!! Form::open(['id' =>'insertSubscribeInfo','method' => 'post','role' => 'form' ,'files' => true]) !!}
                            <input class="footer-subscribe-controller" id="subscribe_email_address" name="subscribe_email_address" type="text" placeholder="Your email" pattern="[^@]+@[^@]+\.[a-zA-Z]{2,6}" required>
                            <button class="button is-info is-medium ml-1 mt-2">Subscribe</button>
                        {!! Form::close() !!}
                    </div>
                    <div class="footer-social-icon mt-5">
                        <a href="<?php if($social){echo $social->facebook; }?>" target="_new"><img src="{{ URL::to('public/frontEnd/footer/facebook.png') }}" alt="facebook"></a>
                        &nbsp;&nbsp;
                        <a href="<?php if($social){echo $social->twitter; }?>" target="_new"><img src="{{ URL::to('public/frontEnd/footer/twitter.png') }}" alt="twitter"></a>
                        &nbsp;&nbsp;
                        <a href="<?php if($social){echo $social->google; }?>" target="_new"><img src="{{ URL::to('public/frontEnd/footer/google.png') }}" alt="google"></a>
                        &nbsp;&nbsp;
                        <a href="<?php if($social){echo $social->linkedin; }?>" target="_new"><img src="{{ URL::to('public/frontEnd/footer/linkedin.png') }}" alt="linkdin"></a>
                         &nbsp;&nbsp;
                        <a href="<?php if($social){echo $social->youtube; }?>" target="_new"><img src="{{ URL::to('public/frontEnd/footer/youtube.png') }}" alt="youtube"></a>
                    </div>
                    <div class="footer-apps-icon mt-5">
                        <img src="{{ URL::to('public/frontEnd/footer/appStore.png') }}" alt="availtrade-apps">
                        &nbsp;&nbsp;
                        <a href="{{ URL::to('availtrade.apk') }}" download="{{ URL::to('availtrade.apk') }}"><img src="{{ URL::to('public/frontEnd/footer/playStore.png') }}" alt="availtrade-apps"></a>
                    </div>
                </div>
            </div>
        </div>
    </footer>
	
	<?php if(Session::get('buyer_id') != NULL || Session::get('supplier_id') != NULL): ?>
	
	<!-- Chat Start -->
    <section>
		<button class="chat-btn">
		    <?php
                $total_pending_count = DB::table('tbl_messages')->where('receiver_id', $main_login_id)->where('is_read', 0)->count() ;    
            ?>
			<span class="pending"><span class="pending-messages">{{ $total_pending_count }}</span> Messanger</span>
		</button>
		<div class="chat-popup">
			<div class="chat-wrapper">
				<div class="chat-window">

					<div class="chat-window-header">
						<p class="contact-name supplier-name-holder">Chat Windows</p>
					</div>

                    <?php if((Session::get('buyer_id') || Session::get('supplier_id')) == NULL){ echo "<a style='color:red;' href='https://availtrade.com/login'>Log in to chat</a>"; } ?>

					<div class="chat-details" id="loadChat">

					</div>
                    {!! Form::open(['method'=>'post','id'=>'saveMessage','files' => true ]) !!}
				    <div class="send">
						    <input type="text" id="messagebox" name="message" placeholder="Please type your message here ..." class="sonia" style="width: 65% !important; padding-left:0 !important;">
						    <label id="messageattachment"  style="height:2.5rem;margin-right: 113px;margin-top:11px;">
						        <span class="icon">
                                <i class="fas fa-image"><input type="file" name="attachment" id="fileInputId" style="right:0px;opacity: 0;filter: alpha(opacity = 0);-ms-filter: "alpha(opacity=0)";"></i>
                                </span></label>
    						<input type="hidden" id="receiver_id_by_ajax" name="receiver_id">
    						<div class="lod" style="float: right;margin-top: -1.5rem;margin-right: 70px;">
    						    
    						<button type="submit" class="send-button" style="height: 2.5rem;">SEND</button>
						</div>
					</div>
					{!! Form::close() !!}

				</div>
				<style>
				   .butt {
  background-color: #4CAF50; /* Green */
  border: none;
  color: white;
  /*padding: 15px 30px;*/
  width:14rem;
  text-align: center;
  text-decoration: none;
  display: inline-block;
  font-size: 20px;
}
span.icon > i >input {
   width: 38px;
height: 28px;
margin-left: -2.7rem;
}
span.icon > i  {
    width: 20px;
    height:16px;
}
				</style>

				<div class="chat-messenger">
					<div class="chat-window-header">
					    <button class="butt"><a href="{{URL::to('msBox')}}">Messenger</a></button>
						<p class="contact-name " style="padding-left: 80px !important;" id="close">X</p>
					</div>

					<div class="chat-members">

                        <?php
                        
                            if(Session::get('buyer_id') != NULL){
                                $login_primary_id = Session::get('buyer_id');
                            }else{
                                $login_primary_id = Session::get('supplier_id');
                            }
                        
                        $getSupplier = DB::table('tbl_messages')->where('sender_id',$login_primary_id)->orWhere('receiver_id',  $login_primary_id)->get();
                        
                        $allSupplierIds = array();
                        $allSenderIds = array();
                        foreach($getSupplier as $supplierChatValue){
                            $allSupplierIds[]   = $supplierChatValue->receiver_id;
                            $allSenderIds[]     = $supplierChatValue->sender_id;
                            
                            $data_main_chat                         = array();
                            $data_main_chat['chat_person_count']    = 1;
                            DB::table('tbl_messages')->where('receiver_id', $login_primary_id)->update($data_main_chat) ;
                        }

                            $mainSupplierMarge  = array_merge($allSupplierIds, $allSenderIds);
                            $uniqueArray        = array_unique($mainSupplierMarge);
                        ?>
                        
                        <?php 
                        
                        foreach($uniqueArray as $getSupplierValue){
                            $scQuery = DB::table('express')->where('id',$getSupplierValue)->first();
                            
                        ?>
                            <?php if($getSupplierValue != $login_primary_id && $scQuery != null): ?>
                                @php 
                                        $unread_count = DB::table('tbl_messages')
                                            ->join('express', 'tbl_messages.sender_id', '=', 'express.id')
                                            ->select('tbl_messages.*', DB::raw('count(tbl_messages.id) as totalnewmessage'))
                                            ->where('tbl_messages.receiver_id', $main_login_id)
                                            ->where('tbl_messages.is_read', 0)
                                            ->where('tbl_messages.sender_id', $scQuery->id)
                                            ->count() ;
                                        @endphp
    						   <div class="member sonia member_with_<?php echo $getSupplierValue; ?>" zamirul="<?php echo $scQuery->id; ?>" sabbir="<?php if($scQuery->type == 2){echo str_replace("-",' ',$scQuery->storeName); }else{echo $scQuery->first_name.' '.$scQuery->last_name ;} ?>" style="background-color:<?php if($unread_count > 0){echo "#e6e5ee"; }else{echo "#f8f8f8"; } ?>">
        							<div class="photo">
        								<?php if($scQuery->image != "" || $scQuery->image != null){
                                            if(strpos($scQuery->image, "https") !== false){
                                                    $image_url_2 = $scQuery->image ;
                                                    $image_system = 1 ;
                                                } else{
                                                    
                                                    if($scQuery->type == 2){
                                                        $image_url_2 = "http://availtrade.com/public/images/spplierPro/".$scQuery->image;
                                                    }else{
                                                        $image_url_2 = "http://availtrade.com/public/images/buyerPic/".$scQuery->image;
                                                    }
                        
                                                    $image_system = 0 ;
                                                }
                                            }else{
                                                $image_url_2 = "http://availtrade.com/public/images/Image 4.png";
                                                $image_system = 0 ;
                                            } 
                                        ?>
                                        @if($image_system = 0 )
                                            <img class="avatar" src='{{ URL::to("$image_url_2") }}' alt="user">
                                        @else
                                            <img class="avatar" src="<?php echo $image_url_2; ?>" alt="user">
                                        @endif
        							</div>
        							<div class="userinfo">
        								<h3 style="width: 100% !important;" class="username username_color_<?php echo $getSupplierValue; ?>" >
                                        @if($scQuery->type == 2)
                                        {{ str_replace("-",' ',$scQuery->storeName) }}
                                        @else
                                        {{ $scQuery->first_name.' '.$scQuery->last_name }}
                                        @endif 
                                        <span id="message_count_<?php echo $getSupplierValue; ?>" class="message_count">{{ $unread_count }}</span></h3>
        								<p style="width: 100% !important;" class="company username_color_<?php echo $getSupplierValue; ?>"><?php echo $scQuery->storeName; ?></p>
        							</div>
        						</div>
    						<?php endif; ?>
                        <?php } ?>
				

					</div>
				</div>
			</div>
		</div>
	</section>
	<?php else: ?>
		<!-- Chat Start -->
        <section id="chat_section_main">
            <a href="#" onclick="showLoginModal(event)" class="emty-chat-box">
                <span  class="messangersg">Messanger</span>
            </a>
    	</section>
	<?php endif ?>
	
	<script src="{{ URL::to('//js.pusher.com/7.0/pusher.min.js') }}"></script>
	
	
<script>
    function showLoginModal(event)
    {
        event.preventDefault() ;
        $("#login_modal").modal('show');
        return false ;
    }
	$(document).ready(function () {


        var select_id = null ;
	    
        $(".chat-btn").on('click',function(){
            $(".chat-popup").show();
            $(this).hide();
        });
    
        $("#close").on('click',function(){
            $(".chat-popup").hide();
            $(".chat-btn").show();
        });
        
        

        $.ajaxSetup({
            headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $.ajax({
            'url':"{{ url('/loadHeaderMessages') }}",
            'type':'post',
            'dataType':'text',
            success:function(data)
            {
                $(".message-pop").empty().html(data);
            }
        });

        

        $('body').on('click','.member',function(e) {
            e.preventDefault();
           
           $(this).addClass("activesid");
            
           var receiver_id      = $(this).attr("zamirul");
           var supplier_name    = $(this).attr("sabbir");

           select_id = receiver_id;

           
           $(".sonia").css({backgroundColor: 'white'});
           $(this).css({backgroundColor: '#ffefb3'});
           
           $(".username_color_"+receiver_id).removeClass('chat_danger') ;
           
           $("#message_count_"+receiver_id).empty().append(0);

           var my_id = <?php echo $main_login_id; ?> ;
           
           
           $('.supplier-name-holder').empty();
           $('.supplier-name-holder').text(supplier_name);
           
           $('#receiver_id_by_ajax').empty();
           $('#receiver_id_by_ajax').val(receiver_id);


           var pending4 = parseInt($('.pending-messages').html());
           var pending5 = parseInt($('.sender_message_'+receiver_id).html());
            if(pending5){
                var total_pendin_count = pending4-pending5 ;
                if(total_pendin_count < 0){
                    $('.pending-messages').empty().append(0);
                }else{
                    $('.pending-messages').empty().append(total_pendin_count);
                }
            }else{
                $('.pending-messages').empty().append(pending4);
            }
        
            $(".sender_media_"+receiver_id).remove() ;
           
            $.ajaxSetup({
            	headers: {
            	'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            
            $.ajax({
            	'url':"{{ url('/loadMessages') }}",
            	'type':'post',
            	'dataType':'text',
            	data:{receiver_id:receiver_id},
            	success:function(data)
            	{
                    $("#loadChat").empty();
                    $("#loadChat").html(data);
                    $(".chat-window .chat-details").animate({ scrollTop: 9999999 }, 'slow');
            	}
            });

            
            Pusher.logToConsole = false;

            var pusher = new Pusher('01cfb52a4bea1b16b3c3', {
                cluster: 'ap2'
            });

            var channel = pusher.subscribe('my-channel');
            channel.bind('my-event', function(data) {

                $("#messagebox").val("");
                $("#fileInputId").val(null);

                var form_id     = data.from ;
                var to_id       = data.to ;


                if (my_id == form_id && to_id == select_id) {
                    $("#message_count_"+receiver_id).empty().append(0);

                    $.ajax({
                        'url':"{{ url('/loadMessages') }}",
                        'type':'post',
                        'dataType':'text',
                        data:{receiver_id:receiver_id},
                        success:function(data)
                        {
                            $("#loadChat").empty();
                            $("#loadChat").html(data);
                            $(".chat-window .chat-details").animate({ scrollTop: 9999999 }, 'slow');

                        }
                    });
                } else if (my_id == to_id && select_id == form_id) {
                    if (select_id == form_id && to_id == my_id) {
                        $("#message_count_"+form_id).empty().append(0);
                        $.ajax({
                            'url':"{{ url('/loadMessages') }}",
                            'type':'post',
                            'dataType':'text',
                            data:{receiver_id:receiver_id},
                            success:function(data)
                            {

                                $("#loadChat").empty();
                                $("#loadChat").html(data);
                                $(".chat-window .chat-details").animate({ scrollTop: 9999999 }, 'slow');

                            }
                        });
                    } else {
                        // $('.message_count').append(1);
                    }
                }

            });

        });
        $('body').on('click','.another_member_selector',function(e) {
            e.preventDefault() ;
            $( ".chat-btn" ).trigger( "click" );

            var main_receiver_id_s = $(this).attr('siam_main_id') ;
            $('.member_with_'+main_receiver_id_s).trigger( "click" )
        })
        

        var receiver_id = 0 ;
        Pusher.logToConsole = false;

        var pusher = new Pusher('01cfb52a4bea1b16b3c3', {
            cluster: 'ap2'
        });

        var channel = pusher.subscribe('my-channel');
        channel.bind('my-event', function(data) {

            var form_id     = data.from ;
            var to_id       = data.to ;

            var pending = parseInt($('#message_count_'+form_id).html());
            $('#message_count_'+form_id).empty().append(pending+1);

            if(form_id != select_id){
                $(".member_with_"+form_id).css('background-color', '#e6e5ee') ;
                $(".username_color_"+form_id).addClass('chat_danger') ;
            }

            $.ajaxSetup({
            	headers: {
            	'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $.ajax({
                'url':"{{ url('/newchatpersoncount') }}",
                'type':'post',
                'dataType':'text',
                data:{receiver_id: receiver_id},
                success:function(data)
                {
                    if(data != 2){
                        $(".chat-members").append(data) ;
                    }
                }
            });


            var main_siam_id = <?php echo $main_login_id; ?> ;

            if(form_id != main_siam_id && form_id != select_id){

                $.ajax({
                    'url':"{{ url('/loadHeaderMessages') }}",
                    'type':'post',
                    'dataType':'text',
                    data:{receiver_id: receiver_id},
                    success:function(data)
                    {
                        var pending4 = parseInt($('.pending-messages').html());
                        $('.pending-messages').empty().append(pending4+1);
                        $(".message-pop").empty().html(data);
                    }
                });

            }
            
        });

	})
	</script>

	
	<script>
	function supplierChatPageShow(sender_id, receiver_id, supplier_name)
	{
	    
	    if(sender_id == receiver_id){
	        toastr.info('Oh shit!! Sorry you can not send Message .', "warning", { positionClass: 'toast-top-center', });
	        return false ;
	    }
	    
	    var product_id = 0;
	    if(sender_id == 0)
	    {
	        $("#login_modal").modal('show');
	        return false ;
	    }
	    
	    $(".chat-popup").show();
        $('.chat-btn').hide();

        $(".sonia").css({backgroundColor: 'white'});
       
        $('.supplier-name-holder').empty();
        $('.supplier-name-holder').text(supplier_name);
           
        $('#receiver_id_by_ajax').empty();
        $('#receiver_id_by_ajax').val(receiver_id);
        
        
        $.ajaxSetup({
        	headers: {
        	'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
        });

        $.ajax({
        	'url':"{{ url('/insertProductChatInfo') }}",
        	'type':'post',
        	'dataType':'text',
        	data:{product_id:product_id, receiver_id:receiver_id, sender_id:sender_id},
        	success:function(data)
        	{
        	    if(data != 2){
        	        $(".chat-members").append(data);
        	    }else{
        	        $.ajax({
                        'url':"{{ url('/loadMessages') }}",
                        'type':'post',
                        'dataType':'text',
                        data:{receiver_id:receiver_id},
                        success:function(data)
                        {

                            $("#loadChat").empty();
                            $("#loadChat").html(data);
                            $(".chat-window .chat-details").animate({ scrollTop: 9999999 }, 'slow');

                        }
                    });
        	        $(".member_with_"+receiver_id).css({backgroundColor: '#ffefb3'});
        	    }

        	}
        });
	    
	}
	
    $(function(){
        $('body').on('submit','#saveMessage',function(e) {
            e.preventDefault();
            
        	var form_data = new FormData(this);
            var receiver_id = $("#receiver_id_by_ajax").val();

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
        
            $.ajax({
                url:"{{ url('/saveMessage') }}",
                type:'post',
                dataType:'text',
                contentType: false,
                processData: false,
                cache: false,
                data:form_data,
                success:function(data)
                {
                    
                    $("[name=attachment]").empty();
                }
            }); 
        });
    })    

    function chatpersonnew()
    {
        console.log("Hello Siam") ;
        return false ;
    }
	</script>
	
	<script src="{{ URL::to('public/chat/chat-main.js') }}" defer></script>
	<script src="{{ URL::to('public/webassets/main.js') }}" defer></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js" integrity="sha512-VEd+nq25CkR676O+pLBnDW09R7VQX9Mdiij052gVCp5yVH3jGtH70Ho/UUv4mJDsEdTvqRCFZg0NKGiojGnUCw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    
    <script type="text/javascript">
        $(document).ready(function(){

            // start of cart popup
            $('div#pop-up').hide();

            $('a.trep,#pop-up').hover(function(e){
                $('div#pop-up').show();
            },function(){
                $('div#pop-up').hide();
            });
            // end of cart popup

            // start of message popup
            $('div#message-pop-up').hide();

            $('a.hover-message,#message-pop-up').hover(function(e){
                $('div#message-pop-up').show();
            }, function(){
                $('div#message-pop-up').hide();
            });
            // end of message popup

            // start of signin popup
            $('div#signin-pop-up').hide();

            $('a.hover-signin,#signin-pop-up').hover(function(e){
                $('div#signin-pop-up').show();
            }, function(){
                $('div#signin-pop-up').hide();
            });
            // end of signin popup

            // start of signin popup
            $('div#order-pop-up').hide();

            $('a.hover-order,#order-pop-up').hover(function(e){
                $('div#order-pop-up').show();
            }, function(){
                $('div#order-pop-up').hide();
            });
            // end of signin popup

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

	        $.ajax({
	            'url':"{{ url('/getcartdata') }}",
	            'type':'post',
	            'dataType':'text',
	            success:function(data)
	            {
	            	$('.cart-area').empty().html(data) ;
	            }
	        });

        })
    </script>

    <!-- Start of zoom -->
    <script src="{{ URL::to('public/zoom/js/xzoom.min.js') }}"></script>
    <script>
        $(document).ready(function(){

            $(".sabbir").on('click',function(){
                $('.imageBorder').removeClass('imageBorder');
                $(this).addClass('imageBorder');
            })

        })
    </script>
    <script src="{{ URL::to('public/zoom/js/setup.js') }}"></script>
    <script>
        $(function(){
            $(".img-border").on('click',function(e){
                e.preventDefault();

                let imgurl = $(this).attr("src");
                $(".xzoom5").attr("src",imgurl);
                // $(".xzoom5").css("width","470");
                // $(".xzoom5").css("height","450");
                $(".fancybox").attr("href",imgurl);
                $(".xzoom5").attr("xoriginal",imgurl);

            });
        })
    </script>

//      <script type="text/javascript">
//   		$(document).ready(function(){

//   			var height = $(window).height();
// 			if (height < 900) {
//                 $('body').css('zoom','80%'); / Webkit browsers /
//                 $('body').css('zoom','0.8'); / Other non-webkit browsers /
//                 $('body').css('-moz-transform',scale(0.8, 0.8)); / Moz-browsers /
// 			}
// 		});
//   	</script>
    <!-- End of zoom -->

    <!-- Start of Fancybox -->
    <script type="text/javascript" src="{{ URL::to('public/fancybox/jquery.fancybox.pack.js') }}"></script>
    <script type="text/javascript" src="{{ URL::to('public/fancybox/helpers/jquery.fancybox-buttons.js') }}"></script>
    <script type="text/javascript">
    $(document).ready(function() {
        $('.fancybox').fancybox();
    });
    </script>

    <script>
        $(window).on('load', function () {
            var height = $(window).height();
			if (height < 900) {
                $('body').css('zoom','80%'); / Webkit browsers /
                $('body').css('zoom','0.8'); / Other non-webkit browsers /
                $('body').css('-moz-transform',scale(0.8, 0.8)); / Moz-browsers /
			}
        })
    </script>
    <!-- End of Fancybox -->
    <script>
    @if(Session::has('all_message'))
    var type = "{{ Session::get('alert-type', 'currency_info') }}";
    switch(type){
        case 'currency_info':
        toastr.info("{{ Session::get('all_message') }}", "Success", { positionClass: 'toast-top-center', });
        break;
        case "currency_success":
        toastr.success("{{ Session::get('all_message') }}", "Success", { positionClass: 'toast-top-center', });
        break;
    }
    @endif
</script>

	@yield('js')
	
<!-- start of sending message to supplier -->
<div id="ex1" class="container modal exyt">
	<div class="columns is-gapless">
		<div class="column is-full cdf">
			<div class="p-5">
				<h4>Send your message to this supplier</h4>
				 <?php if (Session::get('buyer_id') == null) {
                        $customer_id_main = Session::get('supplier_id') ;
                    }else{
                        $customer_id_main = Session::get('buyer_id') ;
                    }
                 ?>
                <?php if($customer_id_main == null || $customer_id_main == ""): ?>
				    <h3 id="modal_display_none" class="fristlogin">Please Login First <a href="{{ URL::to('login') }}">Login</a></h3>
				<?php endif ; ?>
				<br>
				{!! Form::open(['id' =>'sendSupplierQuotation','method' => 'post','role' => 'form', 'class' => 'form form-horizontal', 'files'=>'true']) !!}
				<table width="70%">
					<tr>
						<td class="storenamesd">To:&nbsp;&nbsp;&nbsp;</td>
						<td id="storeNameQuotation"></td>
					</tr>
					<tr>
                        <td class="storenamesd">*Subject:&nbsp;&nbsp;&nbsp;</td>
                        <td colspan="3">
                            <input class="input" type="text" name="subject"  placeholder="Subject" required="">
                        </td>
                    </tr>
                    <tr>
						<td>&nbsp;</td>
						<td>&nbsp;</td>
					</tr>
					<tr>
						<td class="storenamesd">*Message:&nbsp;&nbsp;&nbsp;</td>
						<td colspan="3">
							<textarea class="textarea" name="message" placeholder="e.g. Hello world"></textarea>
						</td>
					</tr>

					<tr>
						<td>&nbsp;</td>
						<td>&nbsp;</td>
					</tr>
					<tr>
						<td class="storenamesd"></td>
						<td colspan="3">
							<label class="checkbox">
								<input type="checkbox">
								Recommend matching suppliers if this supplier doesn’t contact me on Message Center within 24 hours.
							</label>
						</td>
					</tr>
					<tr>
						<td class="storenamesd"></td>
						<td colspan="3">
							<label class="checkbox">
								<input type="checkbox" checked>
								agree to share my Business Card to the supplier.
							</label>
						</td>
					</tr>
					<tr>
						<td>&nbsp;</td>
						<td>&nbsp;</td>
					</tr>
					<input type="hidden" name="supplier_id_message" id="contact_person" >
					<input type="hidden" name="product_id_slug" id="product_id_slug" >
					<tr>
						<td class="storenamesd"></td>
						<td colspan="3">
							<button class="button is-danger" <?php if($customer_id_main == null || $customer_id_main == ""){echo "disabled"; }else{echo ""; } ?>>Send</button>
						</td>
					</tr>
				</table>
				{!! Form::close() !!}
			</div>
		</div>
	</div>
</div>
<!-- end of sending message to supplier -->	


<!-- start of sending message to supplier -->
<div id="login_modal"  class="container modal jio">
	<div class="columns is-gapless">
		<div class="column is-full messages">
		    <div class="login-box">
                @if (!empty(Session::get('login_faild')))
                <article class="message is-danger">
                  <div class="message-header">
                    <p><?php
                    $message2 = Session::get('login_faild');
                    if($message2){
                            echo '<strong>'.$message2.'</strong>';
                            Session::put('login_faild',null);
                        }
                    ?></p>
                  </div>
                </article>
                @endif
                <h3 class="loginback">Login</h3>

                {!! Form::open(['id' =>'buyerSignIn','method' => 'post','role' => 'form', 'files' => true]) !!}
                    <table width="100%">
                        <tr>
                            <td>
                                <label>Account: </label><br>
                                <input class="login-text" type="text" name="email" placeholder="Email address" value="<?php if(!empty($_COOKIE['cookie_username'])){ echo $_COOKIE['cookie_username']; }else{ echo ""; } ?>" required="">
                            </td>
                        </tr>
                        <tr>
                            <td>
                                &nbsp;
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <label>Password:</label><span class="forget" ><a href="{{ URL::to('forgot-password') }}">forget password ?</a></span><br>
                                <input class="login-text" type="password" name="password" id="password" placeholder="Password" value="<?php if(!empty($_COOKIE['cookie_password'])){ echo $_COOKIE['cookie_password']; }else{ echo ""; } ?>" required="">
                            </td>
                             <td class="bigd" ><span id="togglePasswordshow" class="fa fa-eye fa-eye-slash"></span></td>
                        </tr>
                        <tr>
                            <td>
                                <input type="checkbox" name="remember" checked> <label>Stay signed in</label>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                &nbsp;
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <input class="signin" type="submit" value="Sign In">
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <label>Mobile Number Sign In</label><span class="joinn"><a href="{{ URL::to('registration') }}">Join Free</a></span><br>
                            </td>
                        </tr>
                    </table>
                    <input type="hidden" name="prev" value="{!! URL::previous() !!}">
                {!! Form::close() !!}
                <hr>
                <div class="social-container">
                    <div class="social-left">
                        <p>Sign in with: </p>
                    </div>
                    <div class="social-right">
                        <p><a href="{{URL::to('loginwithfacebook')}}"><img src="{{ URL::to('public/frontEnd/footer/facebook.png') }}" width="32" height="32" alt="facebook"></a>&nbsp;&nbsp;&nbsp;&nbsp;<a href="{{URL::to('loginwithgmail')}}"><img src="{{ URL::to('public/frontEnd/footer/google.png') }}" width="32" height="32" alt="google"></a>&nbsp;&nbsp;&nbsp;&nbsp;<a href="{{URL::to('loginwithlinkedin')}}"><img src="{{ URL::to('public/frontEnd/footer/linkedin.png') }}" width="32" height="32" alt="linkdin"></a>&nbsp;&nbsp;&nbsp;&nbsp;<a href="#"><img src="{{ URL::to('public/frontEnd/footer/twitter.png') }}" width="32" height="32" alt="twitter"></a></p>
                    </div>
                </div>

            </div>
		</div>
	</div>
</div>
<!-- end of sending message to supplier -->	

@if($active_popup_ads)
    @if(Session::get('ads_id') != $active_popup_ads->id && Session::get('ads_close') == "" || Session::get('ads_close') == null)
    <div id="popupads"  class="container modal hppay">
         <a href="{{ $active_popup_ads->ads_link }}">
        <div class="columns is-gapless">
           
            <!--<div class="column is-full">-->
                {{--<h4>{{ $active_popup_ads->ads_heading }}</h4>--}}
               {{--<a href="<?php echo $active_popup_ads->ads_link; ?>
               <div>--}}
                    <img style="width: 590px !important;height: 300px !important;padding-bottom:1.2rem;" src="{{ URL::to('public/images/popupAds/'.$active_popup_ads->ads_image) }}" alt="{{ $active_popup_ads->ads_heading }}">
               <!--{{-- </div>--}}-->
               <!-- {{--</a>--}}-->
                {{--<p>{{ $active_popup_ads->ads_paragraph }}</p>
                <a href="<?php echo $active_popup_ads->ads_link; ?>">{{ $active_popup_ads->link_title }}</a>--}}
                
            </div>
            </a>
        <!--</div>-->
    </div>
    @endif
@endif




<script>

    
    function sendquotationinfo(supplier_id, storeName, product_id)
    {
        var login_id = '<?php echo $customer_id_main;  ?>';
        if(login_id == 0){
            $("#login_modal").modal('show');
            return false ;
        }
        
        $("#storeNameQuotation").empty().append(storeName) ;
        $("#contact_person").val(supplier_id);
        $("#product_id_slug").val(product_id);
        $("#ex1").modal('show');
 
    }
    
    $("#sendSupplierQuotation").submit(function(e){
        e.preventDefault();
        
        $("#ex1").modal('show');
        
        let myForm = document.getElementById('sendSupplierQuotation');
        let formData = new FormData(myForm);
        
        
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        
        $.ajax({
            'url':"{{ url('/insertsuppliercontactmessage') }}",
            'data': formData,
            'processData': false, // prevent jQuery from automatically transforming the data into a query string.
            'contentType': false,
            'type': 'POST',
            success: function(data) {
                if (data == "login_first") {
                    toastr.info('Oh shit!! Please Login First', "warning", { positionClass: 'toast-top-center', });
                    $("#ex1").modal('show');
                    return false ;
                }else if(data == "send_failed"){
                    toastr.info('Oh shit!! Sorry you can not send quotation.', "warning", { positionClass: 'toast-top-center', });
                    $("#ex1").modal('show');
                    return false ;
                }else{
                    $("#contact_person").val(" ");
                    toastr.success('Quotation Send Successfully', "success", { positionClass: 'toast-top-center', });
                    setTimeout(function(){
                        location.reload();
                    }, 3000);
                    return false ;
                }
            }
        })
    })
    
    $("#buyerSignIn").submit(function(e){
        e.preventDefault() ;
        $("#login_modal").modal('show');
        
        let myForm = document.getElementById('buyerSignIn');
        let formData = new FormData(myForm);
        
        $.ajax({
            'url':"{{ url('/usermoallogin') }}",
            'data': formData,
            'processData': false, // prevent jQuery from automatically transforming the data into a query string.
            'contentType': false,
            'type': 'POST',
            success: function(data) {
                
                
                if (data == "package_hold") {
                    toastr.info('Oh shit!! Your account under review. Please wait', "warning", { positionClass: 'toast-top-center', });
                    $("#ex1").modal('show');
                    return false ;
                }else if(data == "login_but_not_active_package"){

                     toastr.success('Login granted successfully. Please Select A Package', "success", { positionClass: 'toast-top-center', });
                    setTimeout(function(){
                        location.reload();
                    }, 3000);
                    return false ;
                }else if(data == "success"){
                    toastr.success('Login granted successfully', "success", { positionClass: 'toast-top-center', });
                    setTimeout(function(){
                        location.reload();
                    }, 3000);
                    return false ;
                }else if(data == "mail_not_verifyed"){
                    toastr.info('Verify Your Email First And Try Again.', "warning", { positionClass: 'toast-top-center', });
                    return false ;
                }else if(data == "account_hold_by_admin"){
                    toastr.info('Your Account Hold By Admin If you have any query Contact With Us : info@availtrade.com.', "warning", { positionClass: 'toast-top-center', });
                    return false ;
                }else{
                    toastr.info('Email Or Password Not Match', "warning", { positionClass: 'toast-top-center', });
                    return false ;
                }
            }
        })
        
    })
</script>
<?php if (Session::get('supplier_id') != null || Session::get('buyer_id') != null){ ?>
<script type="text/javascript">
    function setup() {
        this.addEventListener("mousemove", resetTimer, false);
        this.addEventListener("mousedown", resetTimer, false);
        this.addEventListener("keypress", resetTimer, false);
        this.addEventListener("keydown", resetTimer, false);
        this.addEventListener("keyup", resetTimer, false);
        this.addEventListener("DOMMouseScroll", resetTimer, false);
        this.addEventListener("mousewheel", resetTimer, false);
        this.addEventListener("touchmove", resetTimer, false);
        this.addEventListener("MSPointerMove", resetTimer, false);
        startTimer();
    }

	setup();

	function startTimer() {
	    // wait 2 seconds before calling goInactive
	    timeoutID = window.setTimeout(goInactive, (60000*5));
	}
	 
	function resetTimer(e) {
	    window.clearTimeout(timeoutID);
	    goActive();
	}

	function goActive() {
	    // do something     
	    startTimer();
	}

	function goInactive() {
        location.href = 'https://availtrade.com/logout';
	}
	
	$("img").lazyload({

	    effect : "fadeIn"
	});
</script>


<?php } ?>

<script>
    togglePasswordshow.addEventListener('click', function (e) {
        const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
        password.setAttribute('type', type);
        this.classList.toggle('fa-eye-slash');
    });
    
    $("#insertSubscribeInfo").submit(function(e){
        e.preventDefault();
        
        var subscribe_email_address = $("#subscribe_email_address").val() ;
        if(subscribe_email_address == ""){
            toastr.warning('Email Filed Is Required.', 'Warning', { positionClass: 'toast-top-center', });
	  	    return false ;
        }
        
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        
        $.ajax({
            'url':"{{ url('/insertSubscribeInfo') }}",
            'type':'post',
            'dataType':'text',
            data: {subscribe_email_address: subscribe_email_address},
            success: function(data) {
                if (data == "email_exist") {
                    toastr.warning('Oh shit!! Subscribe Email Already Exist. ', "warning", { positionClass: 'toast-top-center', });
                    return false ;
                }else if(data == "success"){
                    $("#subscribe_email_address").val(" ");
                    toastr.success('Subscribe Complete Successfully', "success", { positionClass: 'toast-top-center', });
                    return false ;
                }else{
                   
                    toastr.warning('Sorry! Somthing went wrong', "", { positionClass: 'toast-top-center', });
                    return false ;
                }
            }
        })
    })
</script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-3-typeahead/4.0.1/bootstrap3-typeahead.min.js"></script> 
<script type="text/javascript">


 var path = "{{ route('autocomplete') }}";

    $('input.typeahead').typeahead({

        source:  function (search_keyword, process) {

        return $.post(path, { search_keyword: search_keyword }, function (data) {
         return process(data);
         console.log(data);

            });

        }

    });
    
    
    
    // $(document).ready(function(){
    //  $('input.typeahead' ).typeahead({
    //       $.ajaxSetup({
    //          headers: {
    //           'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    //         }
    //          });
    //     source: function( search_keyword, response ) {
           
    //       // Fetch data
    //       $.ajax({
    //         url:"{{route('autocomplete')}}",
    //         type: 'post',
    //         dataType: "json",
    //         data: {search_keyword: search_keyword},
    //         success: function( data ) {
    //           return response(data);
    //         }
    //       });
          
    //     }
        
    //  });
     
    // });
    
    
    
//     $(document).ready(function(){    
//     $("#outlet").typeahead({
//          source: function(query, process) {

//                 $.ajax({
//                  url: '/autocomplete',
//                  data: {outlets:$("#search_keyword").val()},
//                  type: 'POST',
//                  dataType: 'JSON',
//                  success: function(data) {
//                           process(data);
//                           console.log(data);
//                         }               
//                     });
//          },
//         minLength: 2
//     });
// }); 
    //  $('body').on('change', '#autosearch', function (e) {
    //         e.preventDefault();
    //         var keywords = $('input[name ="keywords"]').val() ;
    //         $.ajaxSetup({
    //          headers: {
    //           'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    //         }
    //          });
    //         $.ajax({
    //             'url':"{{ url('/autocomplete') }}",
    //             'type':'post',
    //             'dataType':'text',
    //             data: {keywords: keywords},
    //             success:function(data){
    //                 $(".typeahead").empty();
    //                 $(".typeahead").html(data);
                  
    //             }
    //         });

    //     });
    
</script>

<script>
    $("document").ready(function(){

        setTimeout(function(){
            $("#popupads").modal('show');
            $("#popupads").find('.close-modal').addClass('popupcolse') ;
        }, 3000);


    });

    $('#popupads').on('click', '.popupcolse', function(e) {
        e.preventDefault() ;
        
        var ads_id = <?php if($active_popup_ads){echo $active_popup_ads->id;  }else{echo "0"; } ; ?>

    
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        
        $.ajax({
            'url':"{{ url('/closeMainPopupAds') }}",
            'type':'post',
            'dataType':'text',
            data: {ads_id: ads_id},
            success: function(data) {
                console.log(data);
            }
        });
    });
    
    function showChatOptions(event){
        event.preventDefault() ;
        
        $(".chat-popup").show();
        $(".chat-btn").hide();
    }
</script>
<script type="text/javascript">
   
document.onkeydown = function(e){
if(event.keyCode == 123){
return false;
}
if(e.crtlKey && e.shiftKey && e.keyCode == "I".charCode(0)){
return false;

}
if(e.crtlKey && e.shiftKey && e.keyCode == "C".charCode(0)){
return false;
}
if(e.crtlKey && e.shiftKey && e.keyCode == "J".charCode(0)){
return false;
}
if(e.crtlKey && e.keyCode == "U".charCode(0)){
return false;
}
}
     
</script>

<script>


    // Get the modal
var modals = document.getElementById("myModal");

// Get the button that opens the modal
var btn = document.getElementById("myBtn");

// Get the <span> element that closes the modal
var span = document.getElementsByClassName("close")[0];

// When the user clicks on the button, open the modal
btn.onclick = function() {
  modals.style.display = "block";
}

// When the user clicks on <span> (x), close the modal
span.onclick = function() {
  modals.style.display = "none";
}

// When the user clicks anywhere outside of the modal, close it
window.onclick = function(event) {
  if (event.target == modals) {
    modals.style.display = "none";
  }
} 


</script>
</body>
</html>
