@extends('frontEnd.master')
@section('title','Employee Terms & Condition')
@section('content')
<main class="main">
	<nav aria-label="breadcrumb" class="breadcrumb-nav">
		<div class="container">
			<h1 class="has-text-centered is-size-2 mt-4">Employee Terms & Condition</h1>

		</div><!-- End .container -->
	</nav>
	<div class="container mt-2">
		<div class="row">
		    <div class="content">
		        <h1>Affiliate Rules Of Avail Trade</h1>
		 <ol class="is-upper-alpha">
		        <h4><li>Each affiliate needs to create an availtrade.com affiliate account.</li>
		        <li>Each Affiliate will receive money commission base.</li>
		        <li>The Affiliate must given all his Information correctly during the account.otherwise no transaction will be made.</li>
		        <li>Affiliate will be paid 10,000 - 15.000 tk per month. (Include Transtion Cost And Internet Bill)</li>
		        <li>Affiliate must register 4 suppliers per day. Ten products must be uploaded from each supplier otherwise this supplier will not be counted. A minimum of 104 suppliers should be paid per month. If it is reduced or increased, the price will be reduced or increased by 50 tk from the salary.</li>
		        <li>A commission of 2 tk will be paid to the affiliate for each subsequent product uploaded by the supplier. 40 products from each supplier will be commissionable.</li>
		        <li>An attractive T-shirt and a pen will be provided to each Affiliate on behalf of avail trade.</li>
		        <li>Affiliate must complete all their information correctly. All Affiliate transactions will be stopped if it is proved that the Affiliate account has been created with any kind of false information.</li>
		        <li>If any type of financial transaction is given from the supplier in the name of availtrade.com, it will be taken according to the law.</li>
		        <li>Affiliate must remember all the principles of avail trade.</li>
		    </ol></h4>
		    </div>
		     <div class="content">
		        <h1>Avail Trade এর অ্যাফিলিয়েট নিয়ম</h1>
		       <ol class="">
		        <h4><li>প্রতিটি অ্যাফিলিয়েটকে একটি availtrade.com অ্যাফিলিয়েট অ্যাকাউন্ট তৈরি করতে হবে।</li>
		        <li>
		       availtrade.com প্রতিটি অ্যাফিলিয়েট কারী অর্থ কমিশন ভিওিক পাবেন ।
		        </li>
		        <li>অ্যাফিলিয়েটকে অবশ্যই অ্যাকাউন্ট চলাকালীন তার সমস্ত তথ্য সঠিকভাবে দিতে হবে। অন্যথায় কোনও লেনদেন করা হবে না।</li>
	    	    <li>অ্যাফিলিয়েটকে প্রতি মাসে ১০,০০০-১৫,০০০ টাকা দেওয়া হবে। (ট্রান্সশন খরচ এবং ইন্টারনেট বিল অন্তর্ভুক্ত করুন)</li>
		        <li>অ্যাফিলিয়েট প্রতিদিন ৪ টি সরবরাহকারী নিবন্ধন করাতে হবে. প্রতিটি সরবরাহকারী থেকে দশটি পণ্য আপলোড করতে হবে অন্যথায় এই সরবরাহকারী গননা করা হবে না। সর্বানিম্ন প্রতি মাসে ১০৪ সরবরাহকারী দিতে হবে । এর চেয়ে হ্রাস বা বৃদ্ধি পেলে মূল্য বেতন থেকে   ৫০ টাকা করে হ্রাস বা বৃদ্ধি পাবে।</li>
		        
		        <li>সরবরাহকারীর  দ্বারা আপলোড করা পরবর্তী  প্রতিটি পণ্যের জন্য ২ টাকা অ্যাফিলিয়েটকে কমিশন প্রদান করা হবে। প্রত্যক সরবরাহকারী থেকে ৪০ টি পণ্য এর কমিশন দেওয়া হবে। </li>
		       
		        <li>availtrade.com পক্ষ থেকে প্রতিটি কর্মচারীকে একটি আকর্ষণীয় টি-শার্ট এবং একটি কলম প্রদান করা হবে।</li>
		     <li>অ্যাফিলিয়েটকে কে অবশ্যই তার সকল তথ্য সঠিক ভাবে পূরন করতে হবে । কোনো প্রকার মিথ্যা তথ্য দিয়ে অ্যাফিলিয়েটকে একাউন্ট তৈরি হয়েছে প্রমাণিত হলে সকল অথীক লেন দেন বন্ধ করে দেয়া  হবে</li>
		        <li>availtrade.com নাম ব্যবহার করে সাপ্লায়ার থেকে কোনো প্রকার আর্থীক  লেন দেন করলে আইন অনুযায়ী ব্যবস্থায় নিয়া হবে ।</li>

		        <li>অ্যাফিলিয়েটকে কে avail trade সকল নীতিমালা মনে চলতে হবে ।</li>
		    </ol></h4>
		    </div>
		   
		    <div class="buttons">
		     <a class="button is-primary ml-5" href="{{URL::to('employee/register')}}"> Registration</a>
		     </div>
		     <div id="google_translate_element"></div>
		    </div>
		    </div>

@endsection
@section('js')
<script>
//   var english = document.getElementById("en"),
//   bangla = document.getElementById("bn"),
//   chinese = document.getElementById("cn"),
//   change_text = document.getElementById("translate");
// // declare some variables to catch the various HTML elements

// english.addEventListener("click", function() {
//     change(english, bangla, chinese);
//   }, false
// );
// // add an event listener to listen to when the user clicks on one of the language span tags
// // this triggers our custom "change" function, which we will define later

// bangla.addEventListener("click", function() {
//     change(bangla, english, chinese);
//   }, false
// );

// chinese.addEventListener("click", function() {
//     change(chinese, english, bangla);
//   }, false
// );

// function change(lang_on, lang_off1, lang_off2) {
//   if (!lang_on.classList.contains("current_lang")) {
//     // if the span that the user clicks on does not have the "current_lang" class
//     lang_on.classList.add("current_lang");
//     // add the "current_lang" class to it
//     lang_off1.classList.remove("current_lang");
//     lang_off2.classList.remove("current_lang");
//     // remove the "current_lang" class from the other span
//   }

//   if (lang_on.innerHTML == "EN") {
//     change_text.classList.add("english");
//     change_text.classList.remove("chinese");
//     change_text.classList.remove("bangla");
//     change_text.innerHTML = "The text here will change";
//   }
  
//   else if (lang_on.innerHTML == "中文") {
//     change_text.classList.add("chinese");
//     // first line adds the corrent language class to the text
//     change_text.classList.remove("english");
//     // second and third line removes the other language classes
//     // this allows you to apply CSS that is specific to each language
//     change_text.classList.remove("bangla");
//     change_text.innerHTML = "这里的文字会改变";
//     // fourth line is where you key in the text that will replace what is currently on-screen
//   }
  
//   else if (lang_on.innerHTML == "日本語") {
//     change_text.classList.add("japanese");
//     change_text.classList.remove("english");
//     change_text.classList.remove("chinese");
//     change_text.innerHTML = "ここの文字は変わります";
//   }
// }  
    
</script>


<!--<script type="text/javascript">-->
<!--function googleTranslateElementInit() {-->
<!--  new google.translate.TranslateElement({pageLanguage: 'en', layout: google.translate.TranslateElement.InlineLayout.SIMPLE}, 'google_translate_element');-->
<!--}-->
<!--</script>-->
<!--<script type="text/javascript" src="//translate.google.com/translate_a/element.js?cb=googleTranslateElementInit"></script>-->
@endsection
