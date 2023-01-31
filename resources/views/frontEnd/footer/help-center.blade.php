@extends('frontEnd.master')
@section('css')
<link rel="stylesheet" type="text/css" href="{{ URL::to('public/frontEnd/assets/css/help-center.css') }}">
@endsection

@section('content')

   <section class="section  is-white is-fullwidth">
            <!--<div class="">-->
            <!--    <div class="container">-->
            <!--        <h1 class="title is-1 is-primary">-->
            <!--        Need A Help -->
            <!--        </h1>-->
            <!--        <h2 class="subtitle is-1">-->
            <!--        This is help center-->
            <!--        </h2>-->
            <!--    </div>-->
            <!--</div>-->
            <section class="hero is-info welcome is-small">
                    <div class="hero-body">
                        <div class="container">
                            <h1 class="title is-1">
                                Need A Help
                            </h1>
                            <h2 class="subtitle is-2">
                                This is help center
                            </h2>
                        </div>
                    </div>
                </section>
            <div class="tabs is-boxed is-centered main-menu" id="nav">
                <ul>
                    <li data-target="pane-1" id="1" class="is-active">
                        <a>
                            <span class="icon is-small"><i class="far fa-file-alt"></i></span>
                            <span>Faq</span>
                           
                        </a>
                    </li>
                    <li data-target="pane-2" id="2">
                        <a>
                            <span class="icon is-small"><i class="fa fa-film"></i></span>
                            <span>Video</span> 
                        </a>
                    </li>
                    
                </ul>
            </div>
            <div class="tab-content">
                 <div class="tab-pane is-active" id="pane-1">
                <!--   <div class="container">-->
              <!--<div class="section">-->
              <div class = "main-wrapper">
                        <div class = "container">
                            <!--<div class = "faq-title"><h1>frequently asked questions</h1></div>-->
                            <div class = "faq-content">
                                <div class = "faq-left-content">
                                    <img src = "{{asset('public/frontEnd/images')}}/ask-a-qun.jpg">
                                    <p style="font-size:25px"> You Have a Different Question? <a href="{{URL::to('contact')}}">Contact</a></p>
                                </div>
                
                                <div class = "faq-right-content">
                                    @foreach($faq as $result)
                                    <div class = "faq-item">
                                        <div class = "faq-item-head">
                                            <span class = "faq-item-text">{{$result->qun}}?</span>
                                            <span class = "faq-item-icon">
                                                <i class = "fa fa-chevron-down"></i>
                                            </span>
                                        </div>
                                        <div class = "faq-item-body">
                                            <p>{{$result->ans}}</p>
                                        </div>
                                    </div>
                                     @endforeach
                
                                   
                
                                   
                
                                   
                                </div>
                            </div>
                        </div>
                    </div> 
                
            </div>
                <div class="tab-pane" style="display:none" id="pane-2">
                        <div class="row columns is-multiline">
                    @foreach($video as $value)
                  <div class="column is-4">
                       
                             
                              <div class="card">
                                  <div class="card-image">
        
                             <iframe 
                            src="https://www.youtube.com/embed/{{$value->link}}" controls  webkitAllowFullScreen mozallowfullscreen allowFullScreen>
                            </iframe> 
        
                                  </div>
                                  <div class="card-header">
                                  <div class="card-header-title">
                                  {{$value->name}}
                                  </div>
                                  </div>
                                  </div>
                                     
                     
                  </div>
                  @endforeach
                  
                </div>  
            
                </div>
               
                
               
        </div>
    </section> 
    
 

     
            
@endsection
@section('js')
<script>
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

<script type="text/javascript">
    document.querySelectorAll("#nav li").forEach(function(navEl) {
  navEl.onclick = function() { toggleTab(this.id, this.dataset.target); }
});

function toggleTab(selectedNav, targetId) {
  var navEls = document.querySelectorAll("#nav li");

  navEls.forEach(function(navEl) {
    if (navEl.id == selectedNav) {
      navEl.classList.add("is-active");
    } else {
      if (navEl.classList.contains("is-active")) {
        navEl.classList.remove("is-active");
      }
    }
  });

  var tabs = document.querySelectorAll(".tab-pane");

  tabs.forEach(function(tab) {
    if (tab.id == targetId) {
      tab.style.display = "block";
    } else {
      tab.style.display = "none";
    }
  });
}
  </script>
@endsection
