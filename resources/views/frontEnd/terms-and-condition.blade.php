@extends('frontEnd.master')
@section('title')
terms and condition
@endsection

@section('content')
    <style>
        .active{
            background-color: green;
            color: white;
        }
        .active:hover{
            color: white!important;
        }
        .log-bu a{
            justify-content:right;
            margin-bottom:2rem;
            
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
                            <div class="store-contact-bar">
                                <h1 class="has-text-centered" style="font-size: 22px;color: #000;">Terms And Conditions</h1>
                            </div>
                            <div class="columns">
                                <div class="column  mt-5 pt-5 mb-5 pb-5">
                                        
                                         <div class="box" style="text-align: justify;text-justify: inter-word;">
                                            <div class="content" style="text-align: justify;">
                                                {!! $result->descp !!}
                                                
                                    <nav class="navbar" role="navigation" aria-label="main navigation">
                                      <div class="navbar-brand">
                                        <h2><sup>*</sup> Are You Agree With All Of Terms & Condition</h2>
                                      </div>
                                      <div class="navbar-menu" style="margin-left:25rem;">
                                        <a class="button is-primary" style="width:90px;height:42px;font-size:26px" href="{{ URL::to('login') }}">Login</a>
                                      </div>
                                    </nav>
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

@section('css')
    <link rel="stylesheet" href="{{ URL::to('public/frontEnd/assets/css/storeSlider.css') }}">
    <link rel="stylesheet" href="{{ URL::to('public/frontEnd/assets/css/supplierSlider.css') }}">

    <link rel="stylesheet" href="{{ URL::to('public/frontEnd/assets/css/store.css') }}">
    <link rel="stylesheet" href="{{ URL::to('public/frontEnd/assets/css/store_nested_menu.css') }}">

    <style>
        .store_social ul {
            list-style-type: none;
            margin: 0;
            padding: 0;
            overflow: hidden;
        }

        .store_social li {
            float: left;
        }

        .store_social li a {
            display: block;
            color: #000;
            text-align: center;
            padding: 10px 10px;
            text-decoration: none;
        }

        .store-contact-bar {
            width: 100%;
            height: 55px;
            background: #fff;
            border-top: 4px solid #644c40;
            border-bottom: 1px solid #dbe3ef;
        }

    </style>
@endsection

@section('js')
    <script src="{{ URL::to('public/frontEnd/assets/js/storeMiniSlider.js') }}"></script>
    <script src="{{ URL::to('public/frontEnd/assets/js/supplierSlider.js') }}"></script>

    <script>
        $(function() {
            $('#store-slider').miniSlider();
            $('#supplier-slider').supplierMiniSlider();
        });
    </script>

    <script>
    @if(Session::has('message'))
    var type = "{{ Session::get('alert-type', 'info') }}";
    switch(type){
        case 'info':
        toastr.info("{{ Session::get('message') }}", "Success", { positionClass: 'toast-top-center', });
        break;
        case "success":
        toastr.success("{{ Session::get('message') }}", "Success", { positionClass: 'toast-top-center', });
        break;
        case 'warning':
        toastr.warning("{{ Session::get('message') }}", "Warning", { positionClass: 'toast-top-center', });
        break;
        case 'failed':
        toastr.error("{{ Session::get('message') }}", "Failed", { positionClass: 'toast-top-center', });
        break;
    }
    @endif
</script>
@endsection
