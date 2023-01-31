@extends('frontEnd.master')
@section('css')
<link rel="stylesheet" type="text/css" href="{{ URL::to('public/frontEnd/assets/css/faq.css') }}">
@endsection

@section('content')

	 
   <div class = "main-wrapper">
        <div class = "container">
            <div class = "faq-title"><h1>frequently asked questions</h1></div>
            <div class = "faq-content">
                <div class = "faq-left-content">
                    <img src = "faq.jpg">
                    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit.</p>
                </div>

                <div class = "faq-right-content">
                    @foreach($faq as $value)
                    <div class = "faq-item">
                        <div class = "faq-item-head">
                            <span class = "faq-item-text">{{$value->qun}}?</span>
                            <span class = "faq-item-icon">
                                <i class = "fa fa-chevron-down"></i>
                            </span>
                        </div>
                        <div class = "faq-item-body">
                            <p>{{$value->ans}}</p>
                        </div>
                    </div>
                    @endforeach

                </div>
            </div>
        </div>
    </div>      
	
@endsection

@section('js')
<script type="text/javascript">
    const faqItemHead = document.querySelectorAll('.faq-item-head');

faqItemHead.forEach((head, index) => {
    head.addEventListener('click', () => {
        let icon = head.querySelector('.faq-item-icon').firstElementChild;
        if(icon.className == "fa fa-chevron-down"){
            head.nextElementSibling.classList.add('show-para');
            icon.className = "fa fa-chevron-up";
        } else if(icon.className == "fa fa-chevron-up"){
            head.nextElementSibling.classList.remove('show-para');
            icon.className = "fa fa-chevron-down";
        }
    });
});
  </script>
@endsection