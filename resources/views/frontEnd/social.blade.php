<!DOCTYPE html>
<html lang="en">
<head>
	<!-- Meta -->
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, minimum-scale=1, user-scalable=no, viewport-fit=cover">
	<meta name="apple-mobile-web-app-capable" content="yes">
	<meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
	<meta name="theme-color" content="#309f5f">
	<meta http-equiv="Content-Security-Policy" content="default-src * 'self' 'unsafe-inline' 'unsafe-eval' data: gap:">

	<meta name="description" content="উপজেলা নির্বাহী অফিসারের কার্যালয় - বড়াইগ্রাম" />
	<meta property="og:title" content="উপজেলা নির্বাহী অফিসারের কার্যালয় - বড়াইগ্রাম" />
	<meta property="og:description" content="নাগরিক সেবার মতামত প্রদান এবং সাইবার ক্রাইম অভিযোগ প্রদানের ওয়েব পোর্টাল" />
	<meta property="og:image" content="https://unobaraigram.com/public/frontend/img/social-image.png"/>
	<meta name="format-detection" content="telephone=no">

	<!-- Title -->
	<title>উপজেলা নির্বাহী অফিসারের কার্যালয় - বড়াইগ্রাম, নাটোর</title>


	<style>
    @font-face {
        font-family: SolaimanLipi;
        src: local('SolaimanLipi'),
        url('<?php echo URL::to('public/backend/assets/fonts/solaimanlipi.woff'); ?>') format('woff'),
        url('<?php echo URL::to('public/backend/assets/fonts/solaimanlipi.woff2'); ?>') format('woff2');
    }
	</style>

</head>
<body style="font-family:'SolaimanLipi','Arial';">
<div id="app">
	<div class="view view-main view-init safe-areas" data-master-detail-breakpoint="800" data-url="/">

		<div class="page page-onboading" data-name="home">

			<div class="page-content">

				<div class="view-logo text-center">
                    <center>
                    <table>
                        <tr>
                            <td><img width="90" height="90" src="{{ URL::to('public/frontend/img/f7-icon.png') }}" alt=""></td>
                            <td style="width: 90px; height: 90px;"></td>
                            <td><img width="90" height="90" src="{{ URL::to('public/frontend/img/mujib.png') }}" alt=""></td>
                        </tr>
                    </table>
                    </center>

                    <br>
					<h2 style="font-family:'SolaimanLipi','Arial';font-size: 22px;color:#000;" class="logo-text">উপজেলা নির্বাহী অফিসারের কার্যালয়</h2>
					<h2 style="font-family:'SolaimanLipi','Arial';font-size: 22px;color:#000;" class="logo-text">বড়াইগ্রাম, নাটোর</h2>
                    <br>
				</div>

				<div class="toolbar toolbar-bottom container footer-button">
					<a href="#" class="button-large button button-fill button-secondary"><span style="font-size: 22px;">নাগরিক সেবার মতামত প্রদান</span></a>
                    <a href="#" class="button-large button button-fill login-btn"><span style="font-size: 22px;">সাইবার ক্রাইম অভিযোগ প্রদান</span></a>
				</div>

			</div>

		</div>

	</div>
</div>
<!-- script -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</body>
</html>
