
@extends('admin.masterAdmin')
@section('title','smtp')
@section('content')


<div class="app-content content">
	<div class="content-overlay"></div>
	<div class="content-wrapper">
		<div class="content-header row">
		</div>
		<div class="content-body">
			<div class="row">

				<div class="col-md-6 col-12">
					<div class="card">
						<div class="card-header">
							<h4 class="card-title">SMTP ( Registration )</h4>
						</div>
						<div class="card-content">
							<div class="card-body">
                                {!! Form::open(['url' =>'updateRegistrationSmtp','method' => 'post', 'class'=>'form form-horizontal']) !!}
									<div class="form-body">
										<div class="row">
										<div class="card-body">
                                            <div class="tab-content">

                                        	<!-- Send Form -->
                                            <div role="tabpanel" class="tab-pane active" id="pill31" aria-expanded="true" aria-labelledby="base-pill31">

                                            <div class="col-12">
                                                <div class="form-group">

                                                    <?php if(Session::get('success-r') != null) { ?>
                                                    <div class="alert alert-info alert-dismissible" role="alert">
                                                        <a href="#" class="fa fa-times" data-dismiss="alert" aria-label="close"></a>
                                                        <strong><?php echo Session::get('success-r') ;  ?></strong>
                                                        <?php Session::put('success-r',null) ;  ?>
                                                    </div>
                                                    <?php } ?>

                                                    <?php
                                                    if(Session::get('failed-r') != null) { ?>
                                                    <div class="alert alert-danger alert-dismissible" role="alert">
                                                        <a href="#" class="fa fa-times" data-dismiss="alert" aria-label="close"></a>
                                                        <strong><?php echo Session::get('failed-r') ; ?></strong>
                                                        <?php echo Session::put('failed-r',null) ; ?>
                                                    </div>
                                                    <?php } ?>

                                                    @if (count($errors) > 0)
                                                        @foreach ($errors->all() as $error)
                                                            <div class="alert alert-danger alert-dismissible" role="alert">
                                                                <a href="#" class="fa fa-times" data-dismiss="alert" aria-label="close"></a>
                                                                <strong>{{ $error }}</strong>
                                                            </div>
                                                        @endforeach
                                                    @endif

                                                </div>
                                            </div>

											<div class="col-12">
												<div class="form-group">
													<label>MAIL HOST</label>
													<input type="text" id="first-name-vertical" class="form-control" name="mail_host" value="{{ $smtp_registration->mail_host }}">
												</div>
											</div>
											<div class="col-12">
												<div class="form-group">
													<label>MAIL PORT</label>
													<input type="text" id="first-name-vertical" class="form-control" name="mail_port" value="{{ $smtp_registration->mail_port }}">
												</div>
											</div>
											<div class="col-12">
												<div class="form-group">
													<label>MAIL USERNAME</label>
													<input type="text" id="first-name-vertical" class="form-control" name="mail_username" value="{{ $smtp_registration->mail_username }}">
												</div>
											</div>
											<div class="col-12">
												<div class="form-group">
													<label>MAIL PASSWORD</label>
													<input type="text" id="first-name-vertical" class="form-control" name="mail_password" value="{{ $smtp_registration->mail_password }}">
												</div>
											</div>
											<div class="col-12">
												<div class="form-group">
													<label>MAIL ENCRYPTION</label>
													<input type="text" id="first-name-vertical" class="form-control" name="mail_encryption" value="{{ $smtp_registration->mail_encryption }}">
												</div>
											</div>
											<div class="col-12">
												<div class="form-group">
													<label>MAIL FROM ADDRESS</label>
													<input type="text" id="first-name-vertical" class="form-control" name="reply_email" value="{{ $smtp_registration->reply_email }}">
												</div>
											</div>
											<div class="col-12">
												<div class="form-group">
													<label>MAIL FROM NAME</label>
													<input type="text" id="first-name-vertical" class="form-control" name="from_name" value="{{ $smtp_registration->from_name }}">
												</div>
											</div>
											<div class="col-sm-12 d-flex justify-content-end">
												<input type="submit" class="btn btn-primary mr-1 mb-1" value="Save Configration" />
											</div>
                                            </div>
                                        </div>
                                        </div>
										</div>
									</div>
                                {!! Form::close() !!}
							</div>
						</div>
					</div>

                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">SMTP ( Forget Password )</h4>
                        </div>
                        <div class="card-content">
                            <div class="card-body">
                                {!! Form::open(['url' =>'updateForgetSmtp','method' => 'post','class'=>'form form-horizontal']) !!}
                                    <div class="form-body">
                                        <div class="row">
                                            <div class="card-body">
                                                <div class="tab-content">
                                                    <!-- Send Form -->
                                                    <div role="tabpanel" class="tab-pane active" id="pill31" aria-expanded="true" aria-labelledby="base-pill31">
                                                        <div class="col-12">
                                                            <div class="form-group">

                                                                <?php if(Session::get('success-f') != null) { ?>
                                                                <div class="alert alert-info alert-dismissible" role="alert">
                                                                    <a href="#" class="fa fa-times" data-dismiss="alert" aria-label="close"></a>
                                                                    <strong><?php echo Session::get('success-f') ;  ?></strong>
                                                                    <?php Session::put('success-f',null) ;  ?>
                                                                </div>
                                                                <?php } ?>

                                                                <?php
                                                                if(Session::get('failed-f') != null) { ?>
                                                                <div class="alert alert-danger alert-dismissible" role="alert">
                                                                    <a href="#" class="fa fa-times" data-dismiss="alert" aria-label="close"></a>
                                                                    <strong><?php echo Session::get('failed-f') ; ?></strong>
                                                                    <?php echo Session::put('failed-f',null) ; ?>
                                                                </div>
                                                                <?php } ?>

                                                                @if (count($errors) > 0)
                                                                    @foreach ($errors->all() as $error)
                                                                        <div class="alert alert-danger alert-dismissible" role="alert">
                                                                            <a href="#" class="fa fa-times" data-dismiss="alert" aria-label="close"></a>
                                                                            <strong>{{ $error }}</strong>
                                                                        </div>
                                                                    @endforeach
                                                                @endif

                                                            </div>
                                                        </div>
                                                        <div class="col-12">
                                                            <div class="form-group">
                                                                <label>MAIL HOST</label>
                                                                <input type="text" id="first-name-vertical" class="form-control" name="mail_host" value="{{ $smtp_forget->mail_host }}">
                                                            </div>
                                                        </div>
                                                        <div class="col-12">
                                                            <div class="form-group">
                                                                <label>MAIL PORT</label>
                                                                <input type="text" id="first-name-vertical" class="form-control" name="mail_port" value="{{ $smtp_forget->mail_port }}">
                                                            </div>
                                                        </div>
                                                        <div class="col-12">
                                                            <div class="form-group">
                                                                <label>MAIL USERNAME</label>
                                                                <input type="text" id="first-name-vertical" class="form-control" name="mail_username" value="{{ $smtp_forget->mail_username }}">
                                                            </div>
                                                        </div>
                                                        <div class="col-12">
                                                            <div class="form-group">
                                                                <label>MAIL PASSWORD</label>
                                                                <input type="text" id="first-name-vertical" class="form-control" name="mail_password" value="{{ $smtp_forget->mail_password }}">
                                                            </div>
                                                        </div>
                                                        <div class="col-12">
                                                            <div class="form-group">
                                                                <label>MAIL ENCRYPTION</label>
                                                                <input type="text" id="first-name-vertical" class="form-control" name="mail_encryption" value="{{ $smtp_forget->mail_encryption }}">
                                                            </div>
                                                        </div>
                                                        <div class="col-12">
                                                            <div class="form-group">
                                                                <label>MAIL FROM ADDRESS</label>
                                                                <input type="text" id="first-name-vertical" class="form-control" name="reply_email" value="{{ $smtp_forget->reply_email }}">
                                                            </div>
                                                        </div>
                                                        <div class="col-12">
                                                            <div class="form-group">
                                                                <label>MAIL FROM NAME</label>
                                                                <input type="text" id="first-name-vertical" class="form-control" name="from_name" value="{{ $smtp_forget->from_name }}">
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-12 d-flex justify-content-end">
                                                            <button type="submit" class="btn btn-primary mr-1 mb-1">Save Configration</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                {!! Form::close() !!}
                            </div>
                        </div>
                    </div>

				</div>

				<div class="col-md-6 col-12">
					<div class="card">
						<div class="card-header">
							<h4 class="card-title">SMTP ( Subscriber and Marketing )</h4>
						</div>
						<div class="card-content">
							<div class="card-body">
                                {!! Form::open(['url' =>'updateSubscribeSmtp','method' => 'post','class'=>'form form-horizontal']) !!}
                                    <div class="form-body">
                                        <div class="row">
                                            <div class="card-body">
                                                <div class="tab-content">
                                                    <!-- Send Form -->
                                                    <div role="tabpanel" class="tab-pane active" id="pill31" aria-expanded="true" aria-labelledby="base-pill31">
                                                        <div class="col-12">
                                                            <div class="form-group">

                                                                <?php if(Session::get('success-s') != null) { ?>
                                                                <div class="alert alert-info alert-dismissible" role="alert">
                                                                    <a href="#" class="fa fa-times" data-dismiss="alert" aria-label="close"></a>
                                                                    <strong><?php echo Session::get('success-s') ;  ?></strong>
                                                                    <?php Session::put('success-s',null) ;  ?>
                                                                </div>
                                                                <?php } ?>

                                                                <?php
                                                                if(Session::get('failed-s') != null) { ?>
                                                                <div class="alert alert-danger alert-dismissible" role="alert">
                                                                    <a href="#" class="fa fa-times" data-dismiss="alert" aria-label="close"></a>
                                                                    <strong><?php echo Session::get('failed-s') ; ?></strong>
                                                                    <?php echo Session::put('failed-s',null) ; ?>
                                                                </div>
                                                                <?php } ?>

                                                                @if (count($errors) > 0)
                                                                    @foreach ($errors->all() as $error)
                                                                        <div class="alert alert-danger alert-dismissible" role="alert">
                                                                            <a href="#" class="fa fa-times" data-dismiss="alert" aria-label="close"></a>
                                                                            <strong>{{ $error }}</strong>
                                                                        </div>
                                                                    @endforeach
                                                                @endif

                                                            </div>
                                                        </div>
                                                        <div class="col-12">
                                                            <div class="form-group">
                                                                <label>MAIL HOST</label>
                                                                <input type="text" id="first-name-vertical" class="form-control" name="mail_host" value="{{ $smtp_subscribtion->mail_host }}">
                                                            </div>
                                                        </div>
                                                        <div class="col-12">
                                                            <div class="form-group">
                                                                <label>MAIL PORT</label>
                                                                <input type="text" id="first-name-vertical" class="form-control" name="mail_port" value="{{ $smtp_subscribtion->mail_port }}">
                                                            </div>
                                                        </div>
                                                        <div class="col-12">
                                                            <div class="form-group">
                                                                <label>MAIL USERNAME</label>
                                                                <input type="text" id="first-name-vertical" class="form-control" name="mail_username" value="{{ $smtp_subscribtion->mail_username }}">
                                                            </div>
                                                        </div>
                                                        <div class="col-12">
                                                            <div class="form-group">
                                                                <label>MAIL PASSWORD</label>
                                                                <input type="text" id="first-name-vertical" class="form-control" name="mail_password" value="{{ $smtp_subscribtion->mail_password }}">
                                                            </div>
                                                        </div>
                                                        <div class="col-12">
                                                            <div class="form-group">
                                                                <label>MAIL ENCRYPTION</label>
                                                                <input type="text" id="first-name-vertical" class="form-control" name="mail_encryption" value="{{ $smtp_subscribtion->mail_encryption }}">
                                                            </div>
                                                        </div>
                                                        <div class="col-12">
                                                            <div class="form-group">
                                                                <label>MAIL FROM ADDRESS</label>
                                                                <input type="text" id="first-name-vertical" class="form-control" name="reply_email" value="{{ $smtp_subscribtion->reply_email }}">
                                                            </div>
                                                        </div>
                                                        <div class="col-12">
                                                            <div class="form-group">
                                                                <label>MAIL FROM NAME</label>
                                                                <input type="text" id="first-name-vertical" class="form-control" name="from_name" value="{{ $smtp_subscribtion->from_name }}">
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-12 d-flex justify-content-end">
                                                            <button type="submit" class="btn btn-primary mr-1 mb-1">Save Configration</button>

                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                {!! Form::close() !!}
							</div>
						</div>
					</div>


						</div>
						
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
@endsection
