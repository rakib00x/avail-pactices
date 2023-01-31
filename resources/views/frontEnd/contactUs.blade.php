@extends('frontEnd.master')
@section('title','Contact US')
@section('css')
 <link rel="stylesheet" href="http://cdn.bootcss.com/toastr.js/latest/css/toastr.min.css">
@endsection
@section('content')
<section class="hero is-link mt-1">
  <div class="hero-body">
    <div class="store-contact-bar">
            <h1 class="title has-text-centered" style="font-size: 22px;color: #000;">Contact Us</h1>
        </div>
  </div>
</section>

    <section class="section mt-1 has-background-primary">
      <div class="container">
        <div class="is-vcentered columns is-multiline">
          <div class="column is-4 is-4-desktop">
            <span class="has-text-white" style="margin-top:-3rem;">Any Query</span>
            <h2 class="has-text-white mt-2 mb-3 is-size-3 is-size-4-mobile has-text-weight-bold">Your Any Problem and Abuse Reports Please Contact With Avail Trade Supporting Team</h2>
            <p class="has-text-white">availtradebd@gmail.com</p>
            <p class="has-text-white">01619-469406</p>
          </div>
          <div class="column is-6 ml-auto">
            <div class="mx-auto box p-6 has-background-light has-text-centered">
              <h4 class="is-size-5 mb-2 has-text-weight-bold">Qucick Contact</h4>
              <p class="has-text-grey-dark mb-4">Please Field The input and wait some minute.</p>
              <form action="{{route('insert.contact')}}" method="post">
                  @csrf
                  <div class="field">
							<label class="label has-text-left">Name</label>
							<div class="control">
								<input class="input is-medium" type="text" name="name" required>
							</div>
						</div>
						<div class="field">
							<label class="label has-text-left">Email</label>
							<div class="control">
								<input class="input is-medium" type="email" name="email" required>
							</div>
						</div>
						<div class="field">
							<label class="label has-text-left">Mobile</label>
							<div class="control">
								<input class="input is-medium" type="number" name="phone" >
							</div>
						</div>
						<div class="field">
							<label class="label has-text-left">Subject</label>
							<div class="control">
								<input class="input is-medium" type="text" name="subject" required>
							</div>
						</div>
						<div class="field">
							<label class="label has-text-left">Message</label>
							<div class="control">
								<textarea class="textarea is-medium" name="message" required></textarea>
							</div>
						</div>
               <button class="button is-primary is-fullwidth">Action</button>
              </form>
            </div>
          </div>
        </div>
      </div>
    </section>
<!--<section class="hero is-fullheight">-->
     
<!--		<div class="hero-body">-->
<!--			<div class="container has-text-centered">-->
			   
<!--				<div class="columns is-8 is-variable ">-->
<!--					<div class="column is-two-thirds has-text-left">-->
						
<!--						<p class="is-size-4">Qucik Contact.</p>-->
<!--						<div class="social-media">-->
<!--							<p>House<sup>315</sup></p>-->
<!--						</div>-->
<!--					</div>-->
<!--					<div class="column is-one-third has-text-left">-->
<!--						<div class="field">-->
<!--							<label class="label">Name</label>-->
<!--							<div class="control">-->
<!--								<input class="input is-medium" type="text">-->
<!--							</div>-->
<!--						</div>-->
<!--						<div class="field">-->
<!--							<label class="label">Email</label>-->
<!--							<div class="control">-->
<!--								<input class="input is-medium" type="text">-->
<!--							</div>-->
<!--						</div>-->
<!--						<div class="field">-->
<!--							<label class="label">Message</label>-->
<!--							<div class="control">-->
<!--								<textarea class="textarea is-medium"></textarea>-->
<!--							</div>-->
<!--						</div>-->
<!--						<div class="control">-->
<!--							<button type="submit" class="button is-link is-fullwidth has-text-weight-medium is-medium">Send Message</button>-->
<!--						</div>-->
<!--					</div>-->
<!--				</div>-->
<!--			</div>-->
<!--		</div>-->
<!--	</section>-->
@endsection
@section('js')
<script>
    @if(Session::has('message'))
    var type = "{{ Session::get('alert-type', 'info') }}";
    switch(type){
        case 'info':
        toastr.info("{{ Session::get('message') }}");
        break;
        case "success":
        toastr.success("{{ Session::get('message') }}");
        break;
        case 'warning':
        toastr.warning("{{ Session::get('message') }}");
        break;
        case 'failed':
        toastr.error("{{ Session::get('message') }}");
        break;
    }
    @endif
</script>
@endsection