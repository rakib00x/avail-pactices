<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Seller Register form</title>
    <link rel="stylesheet" href="{{ asset('public/mobile/css/bootstrap.min.css') }}">
</head>
<body>
    
    <div class="content">
        <h1 class="text-center">Seller Registration  Page</h1>
    
    <div class="m-4"> 
         <form action="{{ route('seller.save') }}" method="POST" enctype="multipart/form-data">
             @if(Session::get('success'))
             <div class="alert alert-success" style="color:red;">
                {{ Session::get('success') }}
             </div>
           @endif

           @if(Session::get('fail'))
             <div class="alert alert-danger">
                {{ Session::get('fail') }}
             </div>
           @endif
          @csrf
            <div class="row">
              <div class="col">
                <input type="text" class="form-control" placeholder="name" name="name">
                 <span class="text-danger">@error('name'){{ $message }} @enderror</span>
              </div>
              <div class="col">
                 <input type="text" class="form-control"  placeholder="Enter Shop Name" name="shop_name">
                  <span class="text-danger">@error('shop_name'){{ $message }} @enderror</span>
              </div>
              
            </div>
            <div class="row">
              <div class="col">
                <input type="number" class="form-control mt-4 " placeholder="Number" name="mobile">
                 <span class="text-danger">@error('mobile'){{ $message }} @enderror</span>
             </div>
                <div class="col">
                <input type="email" class="form-control mt-4" placeholder="Email name" name="email">
                <span class="text-danger">@error('email'){{ $message }} @enderror</span>
              </div>
              </div>
              <div class="row">
                  <div class="col">
                      <select class="form-control mt-4" id="exampleFormControlSelect1" name"gender">
                      <option value="">Select Gender</option>
                      <option value="men">Men</option>
                      <option value="women">Women</option>
                      <option value="others">Others</option>
                    </select>
                    <span class="text-danger">@error('gender'){{ $message }} @enderror</span>
                      
                  </div>
                  <div class="col">
                      <input type="date" class="form-control mt-4"   name="dob">
                      <span class="text-danger">@error('dob'){{ $message }} @enderror</span>
                  </div>
                  </div>
                 <div class="row mt-4">
                    <div class="col">
                      <input type="text" class="form-control" placeholder="Password" name="password">
                      <span class="text-danger">@error('password'){{ $message }} @enderror</span>
                    </div>
                    <div class="col">
                      <input type="text" class="form-control " placeholder="Confirm Password" name="password_confirmation">
                      <span class="text-danger">@error('password_confirmation'){{ $message }} @enderror</span>
                    </div>
                  </div>

                <div class="row mt-4" >
                    <div class="col-9">   
                     <p>By clicking register, you agree to the <a href="#">Terms and Conditions</a> set out by this site, including our Cookie Use.</p>
                     </div>
                    <div class="col-3"> 
                    
                    <div class="form-check">
                      <input class="form-check-input position-static" type="checkbox" name="blankRadio">I Agree
                    </div>
                    </div>
                    
                </div>


                  <div class="row mt-4" >
                      <button type="submit" style="width: 100%;" class="btn btn-primary">Register</button>
                
                    <!--<div class="col">    -->
                      
                    <!--</div>-->
                 
                    <!--<div class="col">  -->
                    <!--    <button type="submit" style="width: 100%;" class="btn btn-success">Sign in</button>-->
                    <!--</div>-->
                 
                </div>
          </form>
    </div>
    </div>

</body>
</html>