@extends('mobile.master-website')
@section('content')
<?php 
    $base_url = "https://availtrade.com/";
?>

 
        <div class="container" style="padding-top: 53px!important;">
            <!-- Cart Wrapper-->
            <div class="cart-wrapper-area py-3">
                <center><h1 class="mb-3 package-pricing mt-2">Affiliate Rules Of Avail Trade</h1></center>
                <ul class="page-nav ps-0">
                    <li><a href="">Each affiliate needs to create an availtrade.com affiliate account</a></li>
                    <li><a href="">Each Affiliate will receive money commission base.</a></li>
                    <li><a href="">The Affiliate must given all his Information correctly during the account.otherwise no transaction will be made. </a></li>
                    <li><a href="">Affiliate will be paid 10,000-15,000 tk per month. (Include Transtion Cost And Internet Bill). </a></li>
                    <li><a href="">Affiliate must register 4 suppliers per day. Ten products must be uploaded from each supplier otherwise this supplier will not be counted. A minimum of 104 suppliers should be paid per month. If it is reduced or increased, the price will be reduced or increased by 50 tk from the salary. </a></li>
                   <li><a href="">A commission of  2 tk will be paid to the affiliate for each subsequent product uploaded by the supplier. 40 products from each supplier will be commissionable.</a></li>
               <li><a href="">An attractive T-shirt and a pen will be provided to each Affiliate on behalf of avail trade.</a></li>
                    <li><a href="">Affiliate must complete all their information correctly. All Affiliate transactions will be stopped if it is proved that the Affiliate account has been created with any kind of false information.</a></li>
                    <li><a href="">If any type of financial transaction is given from the supplier in the name of availtrade.com, it will be taken according to the law.</a></li>
                    <li><a href="">Affiliate must remember all the principles of avail trade.</a></li>
            </ul>
             <center><h1 class="mb-3 package-pricing mt-2">Avail Trade এর অ্যাফিলিয়েট নিয়ম</h1></center>
                <ul class="page-nav ps-0">
                   <li><a href="">প্রতিটি অ্যাফিলিয়েটকে একটি availtrade.com অ্যাফিলিয়েট অ্যাকাউন্ট তৈরি করতে হবে।</a></li> 
                     <li><a href=""> availtrade.com প্রতিটি অ্যাফিলিয়েট কারী অর্থ কমিশন ভিওিক পাবেন  ।</a></li>
                     <li><a href="">অ্যাফিলিয়েটকে অবশ্যই অ্যাকাউন্ট চলাকালীন তার সমস্ত তথ্য সঠিকভাবে দিতে হবে। অন্যথায় কোনও লেনদেন করা হবে না। </a></li>
                   <li><a href="">অ্যাফিলিয়েটকে প্রতি মাসে ১০,০০০-১৫,০০০ টাকা দেওয়া হবে। (ট্রান্সশন খরচ এবং ইন্টারনেট বিল অন্তর্ভুক্ত থাকবে) । </a></li>
                   <li><a href="">অ্যাফিলিয়েট প্রতিদিন ৪ টি সরবরাহকারী নিবন্ধন করাতে হবে. প্রতিটি সরবরাহকারী থেকে দশটি পণ্য আপলোড করতে হবে অন্যথায় এই সরবরাহকারী গননা করা হবে না। সর্বানিম্ন প্রতি মাসে ১০৪ সরবরাহকারী দিতে হবে । এর চেয়ে হ্রাস বা বৃদ্ধি পেলে মূল্য বেতন থেকে ৫০ টাকা করে হ্রাস বা বৃদ্ধি পাবে। </a></li>
                     <li><a href="">সরবরাহকারীর  দ্বারা আপলোড করা পরবর্তী  প্রতিটি পণ্যের জন্য ২ টাকা অ্যাফিলিয়েটকে কমিশন প্রদান করা হবে। প্রত্যক সরবরাহকারী থেকে ৪০ টি পণ্য এর কমিশন দেওয়া হবে। </a></li>
                     <li><a href="">একজন সাপ্লায়ার নিয়মিত পণ্য অপলোড দিলে  মাসে  ৫০ টাকা অ্যাফিলিয়েটকে একাউন্টে স্বয়ংক্রিয় ভাবে যুক্ত হবে এইভাবে তিন মাস পর্যন্ত তার একাউান্টে কমিশন যুক্ত হবে ।</a></li>
                     <li><a href="">availtrade.com পক্ষ থেকে প্রতিটি কর্মচারীকে একটি আকর্ষণীয় টি-শার্ট এবং একটি কলম প্রদান করা হবে।</a></li>
                     <li><a href=""> অ্যাফিলিয়েটকে কে অবশ্যই তার সকল তথ্য সঠিক ভাবে পূরন করতে হবে । কোনো প্রকার মিথ্যা তথ্য দিয়ে অ্যাফিলিয়েটকে একাউন্ট তৈরি হয়েছে প্রমাণিত হলে সকল অথীক লেন দেন বন্ধ করে দেয়া হবে  ।</a></li>
                     <li><a href="">avail trade নাম ব্যবহার করে সাপ্লায়ার থেকে কোনো প্রকার আর্থীক  লেন দেন করলে আইন অনুযায়ী ব্যবস্থায় নিয়া হবে ।</a></li>  
                      <li><a href="">অ্যাফিলিয়েটকে কে avail trade সকল নীতিমালা মনে চলতে হবে ।</a></li>
                                         
             </ul>
                <a class="btn btn-primary" href="{{URL::to('m/employee/register')}}">Registration</a>
                </div>
                </div>
                 

@endsection
@section('js')

<script type="text/javascript" src="//translate.google.com/translate_a/element.js?cb=googleTranslateElementInit"></script>
*/
@endsection