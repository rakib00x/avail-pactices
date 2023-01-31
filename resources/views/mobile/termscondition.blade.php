@extends('mobile.master-website')
@section('content')
<style>
.log-men{
    display: flex;
    justify-content: center;
}
.log-men p{
    text-color:#fff;
}
.log-men a{
    padding-left:2rem;
}
</style>
<div class="container mt-2 mb-2">

        <div class="columns is-gapless">
            <!-- Left Sidebar -->
            <div class="column is-full">
                <!-- 1st sidebar -->
                <div class="box pl-5 pt-5 pr-5">
                    <div class="columns">
                        <div style="width: 100%;border-left: 1px solid #dbe3ef;border-right: 1px solid #dbe3ef;border-bottom: 1px solid #dbe3ef;">
                                
                            <div class="columns">
                                <h1 class="has-text-centered pt-4" style="color: #000;">Terms And Conditions</h1>
                                <div class="column  mb-5 pb-5">
                                        
                                         <div class="box" style="padding:10px;">
                                            <div class="content">
                                                {!! $terms->descp !!}
                                                <nav class="navbar" role="navigation" aria-label="main navigation">
                                      <diV class="log-men">
                                        <p><sup>*</sup> Are You Agree With All Of Terms & Condition</p>
                                        <a class="button is-inverted "  href="{{ URL::to('m/signin') }}">Login</a>
                                        </diV>
                                      
                                    
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