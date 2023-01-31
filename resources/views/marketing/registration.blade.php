<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Job Application Form</title>
    <link rel="stylesheet" href="{{ asset('public/mobile/css/bootstrap.min.css') }}">



    <style>
        body{
            font-family: "comic sans ms", sans serif;
            background-color: #cee2ce;
            margin: 0;
            
        }
        
        h2{
            background-color: forestgreen;
            color: white;
            padding: 10px;
            text-align: center;
        }
        td{
            padding: 7px;
        }
        input{
            height: 30px;
            border-radius: 10px;
            border: none;
            
        }
        
        input:focus{
            outline: none;
            border: 1px solid forestgreen;
        }
        input:hover{
            box-shadow: 5px 5px 5px black;
        }
        
        .button{
            background-color: forestgreen;
            color:#fff;
            border: none;
            padding: 7px
        }
        
        .button:hover {
            cursor: pointer;
            box-shadow: 5px 5px 5px red;
        }
    </style>
</head>
<body>
   
<div class="container">
   <div class="row" style="margin-top:45px">
      <div class="col-md-12 col-md-offset-12">
           <h2 class="text-center">Avail Trade | Employee Registration form</h2><hr>
           <form action="{{ route('auth.save') }}" method="post" enctype="multipart/form-data">

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
            <div class="col-md-6">
           <div class="form-group">
                 <label>* Name</label>
                 <input type="text" class="form-control" name="name" placeholder="Enter full name" value="{{ old('name') }}">
                 <span class="text-danger">@error('name'){{ $message }} @enderror</span>
              </div>
          </div>
            <div class="col-md-6">
              <div class="form-group">
                 <label>Username</label>
                 <input type="text" class="form-control" name="username" placeholder="Enter Your Username" value="{{ old('username') }}">
                 <span class="text-danger">@error('username'){{ $message }} @enderror</span>
              </div>
          </div>
      </div>
       <div class="row">
            <div class="col-md-6">
           <div class="form-group">
                 <label>* Father Name</label>
                 <input type="text" class="form-control" name="father_name" placeholder="Enter Father name" value="{{ old('father_name') }}">
                 <span class="text-danger">@error('father_name'){{ $message }} @enderror</span>
              </div>
          </div>
            <div class="col-md-6">
              <div class="form-group">
                 <label>* Mother Name</label>
                 <input type="text" class="form-control" name="mather_name" placeholder="Enter Your Mother Name" value="{{ old('mather_name') }}">
                 <span class="text-danger">@error('mather_name'){{ $message }} @enderror</span>
              </div>
          </div>
      </div>
          <div class="row">
            <div class="col-md-6">
              <div class="form-group">
                 <label>* Mobile</label>
                 <input type="number" class="form-control" name="mobile" placeholder="Enter Mobile Number" value="{{ old('mobile') }}">
                 <span class="text-danger">@error('mobile'){{ $message }} @enderror</span>
              </div>
          </div>
            <div class="col-md-6">
              <div class="form-group">
                 <label>* Email</label>
                 <input type="text" class="form-control" name="email" placeholder="Enter email address" value="{{ old('email') }}">
                 <span class="text-danger">@error('email'){{ $message }} @enderror</span>
              </div>
          </div>
          
        </div>
        <div class="row">
            <div class="col-md-6">
              <div class="form-group">
                    <label>* Brithday</label>
                   <input class="form-control" type="date" name="dob" value="{{ old('dob') }}">
                        <span class="text-danger">@error('dob'){{ $message }} @enderror</span>
                </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                 <label>* Gender</label>
                 <select class="form-control" name="gender">
                    <option >Select Gender</option>
                    <option value="male">Male</option>
                    <option value="female">Female</option>
                 </select>
                 <span class="text-danger">@error('gender'){{ $message }} @enderror</span>
              </div>
          </div>
      </div>
           <div class="row">
            <div class="col-md-6">
              
                <div class="form-group">
                    <label>* District</label>
                    @php
                    $district  = DB::table('districts')->get() ;
                    @endphp
                <select class="form-control" id="district_id" name="city">
                 <option >Select District</option>
                 @foreach($district as $value)
                 <option value="{{$value->id}}" >{{$value->name}}</option>
                 @endforeach
                        </select>
                 <span class="text-danger">@error('city'){{ $message }} @enderror</span>

                </div>
            </div>
                <div class="col-md-6">
                <div class="form-group">
                    <label>* Thana</label>
                <select class="form-control" name="thana" id="thana_id">
                        </select>
                        <span class="text-danger">@error('thana'){{ $message }} @enderror</span>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
             <div class="form-group">
                    <label>* Address</label>
                   <input class="form-control" type="text" name="address" value="{{ old('address') }}">
                        <span class="text-danger">@error('address'){{ $message }} @enderror</span>
                </div>
            </div>
             <div class="col-md-6">
                <div class="form-group">
                    <label>Education Qulification</label>
                   <input class="form-control" type="text" name="edu_qulification" value="{{ old('edu_qulification') }}">
                        <span class="text-danger">@error('edu_qulification'){{ $message }} @enderror</span>
                </div>
            </div>
        </div>
           <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label>Work Experience</label>
                   <input class="form-control" type="text" name="work_experience" value="{{ old('work_experience') }}">
                        <span class="text-danger">@error('work_experience'){{ $message }} @enderror</span>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label>* Work Area</label>
                   <input class="form-control" type="text" name="work_area" value="{{ old('work_area') }}">
                        <span class="text-danger">@error('work_area'){{ $message }} @enderror</span>
                </div>
            </div>
        </div>
                <div class="row">
            <div class="col-md-6">
              <div class="form-group">
                 <label>* Password</label>
                 <input type="password" class="form-control" name="password" placeholder="Enter password">
                 <span class="text-danger">@error('password'){{ $message }} @enderror</span>
              </div>
          </div>
          <div class="col-md-6">
              <div class="form-group">
                 <label>* Confrim Password</label>
                 <input type="password" class="form-control" name="password_confirmation" placeholder="Enter password">
                 @error('password_confirmation'){{ $message }} @enderror
              </div>
          </div>
      </div>
              <div class="form-group">
                 <label>Image</label>
                 <input type="file" class="form-control" name="photo">
                 <span class="text-danger">@error('photo'){{ $message }} @enderror</span>
              </div>
              <input type="checkbox" id="term" name="term" style="margin-top:1rem" required>
           <label for="term" > I have a check<a href="{{ URL::to('employee/terms') }}">Terms & Condition</a></label><br>
              <div class="row mt-1">
              <div class="col-md-12">
              <button type="submit" class="btn btn-primary btn-lg btn-block" style="width:420px;">Sign Up</button>
              </div>
              </div>
              <br>
               
              I already have an account <a class="btn btn-primary" href="{{ route('auth.login') }}">Sign In</a>
           </form>
      </div>
   </div>
</div>
<script src="{{ URL::to('public/mobile/js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ URL::to('public/mobile/js/jquery.min.js') }}"></script>
    <script type="text/javascript">
       $('body').on('change', '#district_id', function (e) {
            e.preventDefault();

            var district_id = $('#district_id :selected').val() ;
            $.ajaxSetup({
             headers: {
               'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
             });
            $.ajax({
                'url':"{{ url('/getThana') }}",
                'type':'post',
                'dataType':'text',
                data: {district_id: district_id},
                success:function(data){
                    $("#thana_id").empty();
                    $("#thana_id").html(data);
                  
                }
            });

        });
    </script>
</body>
</html>
