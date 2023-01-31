<div class="form-body">

    <div class="row">
        {!! Form::open(['id' =>'updateBanner','method' => 'post','role' => 'form', 'class' => 'form form-horizontal', 'files'=>'true']) !!}
            <div class="col-md-12" >
                <label>Banner <span style="color:red;">Max Size : 3M*</span></label>
                <br>
                <img src="{{ URL::to('public/images/Banner/'.$value->image) }}" alt="" width="150" height="150">
                <input type="file" class="form-control" name="image"  required="">
            </div>
            <input type="hidden" name="primary_id" value="3">
            <br>
            <br>
            <br>
            <div class="col-sm-12 d-flex justify-content-end">
                <button type="submit" class="btn btn-primary mr-1 mb-1" id="updateBannerInfo">Submit</button>
            </div>
        {!! Form::close() !!}
    </div>
    
</div>