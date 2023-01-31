@extends('admin.masterAdmin')
@section('title','Email Send')
@section('content')
@push('styles')
<style>
	@media screen and (min-width: 992px){
		.modal-dialog {
			max-width: 1000px!important;
		}
	}
	.siam_active .card{
		border: 1px solid red ;
	}

	.siam_class{
		cursor: pointer;
	}

</style>
@endpush
<div class="app-content content">
	<div class="content-wrapper">
		<div class="content-body">
			<section id="basic-datatable">
				<div class="row">

					<div class="col-12">
						<div class="row">

							<div class="col-md-2 mb-2 mb-md-0 pills-stacked">
								<ul class="nav nav-pills flex-column">
									<li class="nav-item">
										<a class="nav-link d-flex align-items-center active" id="account-pill-general" data-toggle="pill" href="#account-vertical-general" aria-expanded="true">
											<i class="fa fa-list" aria-hidden="true"></i>
											<span> Suppliers</span>
										</a>
									</li>
									<li class="nav-item">
										<a class="nav-link d-flex align-items-center" id="account-pill-password" data-toggle="pill" href="#account-vertical-password" aria-expanded="false">
											<i class="fa fa-list" aria-hidden="true"></i>
											<span> Buyers</span>
										</a>
									</li>
                                    <li class="nav-item">
										<a class="nav-link d-flex align-items-center" id="account-pill-password" data-toggle="pill" href="#send-mail-to-customer" aria-expanded="false">
											<i class="fa fa-list" aria-hidden="true"></i>
											<span> Subscriber</span>
										</a>
									</li>
								</ul>
							</div>


							<div class="col-md-10">

                                <div class="card">
                                    <div class="card-content">
                                        <div class="card-body card-dashboard">
                                            <div class="col-12">
                                                <div class="form-group">
                                                    <label>MAIL SUBJECT</label>
                                                    <input type="text" id="first-name-vertical" class="form-control" name="subject" placeholder="Mail Subject ...">
                                                </div>
                                                <div class="form-group">
                                                    <label>MAIL BODY</label>
                                                    <textarea class="form-control" name="body" cols="30" rows="10" placeholder="Write your message here ..."></textarea>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

								<div class="card">
									<div class="card-content" id="">
										<div class="card-body card-dashboard">

											<div class="tab-content">

												<div role="tabpanel" class="tab-pane active" id="account-vertical-general" aria-labelledby="account-pill-general" aria-expanded="true">
													<div class="table-responsive">
														<table class="table zero-configuration">
															<thead>
																<tr>
                                                                    <th><input type="checkbox" id="checkedAll"></th>
																	<th>ID</th>
																	<th>Supplier Name</th>
																	<th>Email</th>
                                                                    <th></th>
																</tr>
															</thead>
															<?php $i=1; ?>
															<tbody>
																@foreach ($supplier as $value)
																<tr>
                                                                    <td>
                                                                        <input type="checkbox" class="checkSingle mail_id" value="{{ $value->email }}">
                                                                    </td>
																	<td>{{ $i++ }} </td>
																	<td>{{ $value->first_name." ".$value->last_name }}</td>
																	<td>{{ $value->email }}</td>
                                                                    <td></td>
																</tr>
																@endforeach
															</tbody>
															<tr>
																<td colspan="4"></td>
																<td>
																	<button class="btn btn-primary btn-sm send-mail-to-seller" type="button">SEND MAIL</button>
																</td>
															</tr>
														</table>
													</div>
												</div>

												<div class="tab-pane fade" id="account-vertical-password" role="tabpanel" aria-labelledby="account-pill-password" aria-expanded="false">
													<div class="table-responsive">
														<table class="table zero-configuration">
															<thead>
																<tr>
																	<th><input type="checkbox" id="checkedAllCustomer"></th>
																	<th>Buyer Name</th>
																	<th>Email</th>
																	<th>Select</th>
                                                                    <th></th>
																</tr>
															</thead>
															<?php $i=1; ?>
															<tbody>
																@foreach ($buyer as $value)
																<tr>
                                                                    <td><input type="checkbox" class="checkSingle customer_mail_id" value="{{ $value->email }}"></td>
																	<td>{{ $i++ }} </td>
																	<td>{{ $value->first_name." ".$value->last_name }}</td>
																	<td>{{ $value->email }}</td>
                                                                    <td></td>
																</tr>
																@endforeach
															</tbody>
															<tr>
																<td colspan="4"></td>
																<td>
                                                                    <button class="btn btn-primary btn-sm send-mail-to-customer" type="button">SEND MAIL</button>
																</td>
															</tr>
														</table>
													</div>
												</div>

                                                <div class="tab-pane fade" id="send-mail-to-customer" role="tabpanel" aria-labelledby="account-pill-password" aria-expanded="false">
                                                    <div class="table-responsive">
                                                        <table class="table zero-configuration">
                                                            <thead>
                                                            <tr>
                                                                <th><input type="checkbox" id="checkedAllSubscriber"></th>
                                                                <th>#SL</th>
                                                                <th>e-mail</th>
                                                                <th></th>
                                                                <th></th>
                                                            </tr>
                                                            </thead>
                                                            <?php $i=1; ?>
                                                            <tbody>
                                                            @foreach ($subscribers as $value)
                                                                <tr>
                                                                    <td><input type="checkbox" class="checkSingle subscriber_mail_id" value="{{ $value->email }}"></td>
                                                                    <td>{{ $i++ }} </td>
                                                                    <td>{{ $value->email }}</td>
                                                                    <td></td>
                                                                    <td></td>
                                                                </tr>
                                                            @endforeach
                                                            </tbody>
                                                            <tr>
                                                                <td colspan="4"></td>
                                                                <td>
                                                                    <button class="btn btn-primary btn-sm send-mail-to-subscriber" type="button">SEND MAIL</button>
                                                                </td>
                                                            </tr>
                                                        </table>
                                                    </div>
                                                </div>


											</div>

										</div>
									</div>
								</div>
							</div>

						</div>
					</div>
				</section>


			</div>
		</div>
	</div>

	@endsection

    @section('js')
    <script>
        $(document).ready(function() {
            $("#checkedAll").change(function(){
                if(this.checked){
                    $(".checkSingle").each(function(){
                        this.checked=true;
                    })
                }else{
                    $(".checkSingle").each(function(){
                        this.checked=false;
                    })
                }
            });

            $(".checkSingle").click(function () {
                if ($(this).is(":checked")){
                    var isAllChecked = 0;
                    $(".checkSingle").each(function(){
                        if(!this.checked)
                            isAllChecked = 1;
                    })
                    if(isAllChecked == 0){ $("#checkedAll").prop("checked", true); }
                }else {
                    $("#checkedAll").prop("checked", false);
                }
            });
        });

        // check all for customer
        $(document).ready(function() {
            $("#checkedAllCustomer").change(function(){
                if(this.checked){
                    $(".checkSingle").each(function(){
                        this.checked=true;
                    })
                }else{
                    $(".checkSingle").each(function(){
                        this.checked=false;
                    })
                }
            });

            $(".checkSingle").click(function () {
                if ($(this).is(":checked")){
                    var isAllChecked = 0;
                    $(".checkSingle").each(function(){
                        if(!this.checked)
                            isAllChecked = 1;
                    })
                    if(isAllChecked == 0){ $("#checkedAllCustomer").prop("checked", true); }
                }else {
                    $("#checkedAllCustomer").prop("checked", false);
                }
            });
        });

        // check all for subscriber
        $(document).ready(function() {
            $("#checkedAllSubscriber").change(function(){
                if(this.checked){
                    $(".checkSingle").each(function(){
                        this.checked=true;
                    })
                }else{
                    $(".checkSingle").each(function(){
                        this.checked=false;
                    })
                }
            });

            $(".checkSingle").click(function () {
                if ($(this).is(":checked")){
                    var isAllChecked = 0;
                    $(".checkSingle").each(function(){
                        if(!this.checked)
                            isAllChecked = 1;
                    })
                    if(isAllChecked == 0){ $("#checkedAllSubscriber").prop("checked", true); }
                }else {
                    $("#checkedAllSubscriber").prop("checked", false);
                }
            });
        });

        // Send mail to Seller
        $(".send-mail-to-seller").on('click',function(e){
            e.preventDefault();

            let mail_array = [];
            $('.mail_id').each(function () {
                let i = $(this).val();

                if ($(this).is(":checked")){
                    mail_array.push(i);
                }

            });

            let mail_subject = $('[name="subject"]').val();
            let mail_body = $('[name="body"]').val();

            if(mail_subject == ""){
                alert('You are missing mail subject');
                return false;
            }

            if(mail_body == ""){
                alert('You are missing mail body');
                return false;
            }

            let array_length = mail_array.length;

            if(array_length == 0){
                alert('You have not selected any email...');
                return false;
            }

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $.ajax({
                'url':"{{ url('/sendEmailToSeller') }}",
                'type':'post',
                'dataType':'text',
                data:{mail_subject:mail_subject,mail_body:mail_body,mail_array:mail_array},
                success:function(data)
                {

                    if(data == 'success'){
                        alert('E-mail Sent Successfully');
                    }else{
                        alert('Something went wrong....');
                    }
                    
                }
            });

        });

        // Send mail to customer (all)
        $(".send-mail-to-customer").on('click',function(e){
            e.preventDefault();

            let mail_array = [];
            $('.customer_mail_id').each(function () {
                let i = $(this).val();
                if ($(this).is(":checked")){
                    mail_array.push(i);
                }
            });

            let mail_subject = $('[name="subject"]').val();
            let mail_body = $('[name="body"]').val();

            if(mail_subject == ""){
                alert('You are missing mail subject');
                return false;
            }

            if(mail_body == ""){
                alert('You are missing mail body');
                return false;
            }

            let array_length = mail_array.length;

            if(array_length == 0){
                alert('You have not selected any email...');
                return false;
            }

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $.ajax({
                'url':"{{ url('/sendEmailToCustomer') }}",
                'type':'post',
                'dataType':'text',
                data:{mail_subject:mail_subject,mail_body:mail_body,mail_array:mail_array},
                success:function(data)
                {

                    if(data == 'success'){
                        alert('E-mail Sent Successfully');
                    }else{
                        alert('Something went wrong....');
                    }
                    
                }
            });

        });

        // Send mail to subscriber
        $(".send-mail-to-subscriber").on('click',function(e){
            e.preventDefault();

            let mail_array = [];
            $('.subscriber_mail_id').each(function () {
                let i = $(this).val();
                if ($(this).is(":checked")){
                    mail_array.push(i);
                }
            });

            let mail_subject = $('[name="subject"]').val();
            let mail_body = $('[name="body"]').val();

            if(mail_subject == ""){
                alert('You are missing mail subject');
                return false;
            }

            if(mail_body == ""){
                alert('You are missing mail body');
                return false;
            }

            let array_length = mail_array.length;

            if(array_length == 0){
                alert('You have not selected any email...');
                return false;
            }

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $.ajax({
                'url':"{{ url('/sendEmailToSubscriber') }}",
                'type':'post',
                'dataType':'text',
                data:{mail_subject:mail_subject,mail_body:mail_body,mail_array:mail_array},
                success:function(data)
                {

                    if(data == 'success'){
                        alert('E-mail Sent Successfully');
                    }else{
                        alert('Something went wrong....');
                    }
                    
                }
            });

        });

    </script>
    @endsection
