<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta name="csrf-token" content="{{ csrf_token() }}">
	<title>Employee Forget Password</title>
	<link rel="stylesheet" href="{{ asset('public/mobile/css/bootstrap.min.css') }}">
	<style>
	    body{
	        background:#e3ede3;
	    }
	</style>
</head>
<body>
    
        <div class="container padding-bottom-3x mb-2 mt-5">
      <div class="row justify-content-center">
        <div class="col-lg-8 col-md-10">
          <div class="forgot">
               @if (Session::has('message'))
                         <div class="alert alert-success" role="alert">
                            {{ Session::get('message') }}
                        </div>
                    @endif
          	
          	<h2>Forgot your password?</h2>
          <p>Change your password in three easy steps. This will help you to secure your password!</p>
          <ol class="list-unstyled">
            <li><span class="text-primary text-medium">1. </span>Enter your email address below.</li>
            <li><span class="text-primary text-medium">2. </span>Our system will send you a temporary link</li>
            <li><span class="text-primary text-medium">3. </span>Use the link to reset your password</li>
          </ol>

          </div>	
          
          <form class="card mt-4" action="{{ route('ForgetPasswordPost') }}" method="POST">
              @csrf
            <div class="card-body">
              <div class="form-group">
                <label for="email-for-pass">Enter your email address</label>
                <input class="form-control" type="text"  required="" name="email"><small class="form-text text-muted">Enter the email address you used during the registration on availtrade.com. Then we'll email a link to this address.</small>
                @if ($errors->has('email'))
                     <span class="text-danger">{{ $errors->first('email') }}</span>
                 @endif
              </div>
            </div>
            <div class="card-footer">
              <button class="btn btn-success" type="submit">Get New Password</button>
              <a class="btn btn-danger" href="{{route('auth.login')}}">Back to Login</a>
            </div>
          </form>
        </div>
      </div>
    </div>
</body>
</html> 