@extends('mobile.master-website')

@section('content')
<style>
.bg-contact2 {
  width: 100%;
  background-repeat: no-repeat;
  background-position: center center;
  background-size: cover;
}
.container-contact2 {
  width: 100%;
  min-height: 100vh;
  display: -webkit-box;
  display: -webkit-flex;
  display: -moz-box;
  display: -ms-flexbox;
  display: flex;
  flex-wrap: wrap;
  justify-content: center;
  align-items: center;
  padding: 15px;
  background: rgba(219,21,99,0.8);
  background: -webkit-linear-gradient(45deg, rgba(213,0,125,0.8), rgba(229,57,53,0.8));
  background: -o-linear-gradient(45deg, rgba(213,0,125,0.8), rgba(229,57,53,0.8));
  background: -moz-linear-gradient(45deg, rgba(213,0,125,0.8), rgba(229,57,53,0.8));
  background: linear-gradient(45deg, rgba(213,0,125,0.8), rgba(229,57,53,0.8));
}
.wrap-contact2 {
  width: 790px;
  background: #fff;
  border-radius: 10px;
  overflow: hidden;
  padding: 72px 55px 90px 55px;
}
.contact2-form {
  width: 100%;
}
.contact2-form-title {
  display: block;
  font-family: Poppins-Bold;
  font-size: 39px;
  color: #333333;
  line-height: 1.2;
  text-align: center;
  padding-bottom: 35px;
}
input.input2 {
  height: 45px;
}
.input2 {
  display: block;
  width: 100%;
  font-family: Poppins-Regular;
  font-size: 15px;
  color: #555555;
  line-height: 1.2;
}

.wrap-input2 {
  width: 100%;
  position: relative;
  border-bottom: 2px solid #adadad;
  margin-bottom: 25px;
}
.container-contact2-form-btn {
  display: -webkit-box;
  display: -webkit-flex;
  display: -moz-box;
  display: -ms-flexbox;
  display: flex;
  flex-wrap: wrap;
  justify-content: center;
  padding-top: 13px;
}
.wrap-contact2-form-btn {
  display: block;
  position: relative;
  z-index: 1;
  border-radius: 2px;
  width: auto;
  overflow: hidden;
  margin: 0 auto;
}

</style>
<div class="bg-contact2" style="margin-top:2.5rem;margin-bottom:2.5rem;">
<div class="pt-5 container-contact2">
<div class="wrap-contact2">
   <form action="{{route('insert.contact')}}" method="post" class="contact2-form">
        @csrf
<span class="contact2-form-title">
Contact Us
</span>
<div class="wrap-input2">
  <div class="form-group">
    <label for="exampleInputEmail1">Name</label>
    <input type="text" class="form-control" name="name" aria-describedby="emailHelp" placeholder="Enter Name" required>
  </div>
  </div>
  <div class="wrap-input2">
  <div class="form-group">
    <label for="exampleInputEmail1">Mobile Number</label>
    <input type="text" class="form-control" name="phone" placeholder="Enter Mobile Number">
  </div>
  </div>
  <div class="wrap-input2">
  <div class="form-group">
    <label for="exampleInputEmail1">Email</label>
    <input type="email" class="form-control" id="exampleInputEmail1" name="email" placeholder="Enter email" required>
  </div>
  </div>
  
  <div class="wrap-input2">
  <div class="form-group">
    <label >Subject</label>
    <input type="text" class="form-control" name="subject" placeholder="Enter Your Subject" required>
  </div>
  </div>
  
  <div class="form-group">
    <label>Message</label>
    <textarea class="form-control" name="message" row="5" style="height: 150px;" required></textarea>
  </div>
  
  <div class="pt-2">
       <button type="submit" class="btn btn-primary">Submit</button>
  </div>
 
</form>
</div>
</div>
</div>

@endsection