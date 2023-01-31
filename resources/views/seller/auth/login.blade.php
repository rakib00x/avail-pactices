<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Login</title>
       <link rel="stylesheet" href="{{ asset('public/mobile/css/bootstrap.min.css') }}">
		<link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet">
		<style>
		    html,
body {
    height: 100%;
}

body {
    margin: 0;
    overflow: hidden;
}

.flex-container-center {
    height: 100%;
    padding: 0;
    margin: 0;
    display: -webkit-box;
    display: -moz-box;
    display: -ms-flexbox;
    display: -webkit-flex;
    display: flex;
    align-items: center;
    justify-content: center;
}

.btn-login {
    width: 100%;
    height: 60px;
    border: 2px solid #277cff;
    background-color: white;
    color: #277cff;
    transition: 0.25s;
    cursor: pointer;
    font-weight: bold;
}

.hero-title{
    font-size: 8rem;
    line-height: 1.3;
    font-family: 'Roboto';
    border-left: 15px solid;
}

.hero-title span{
	background-color: #277cffb0;
	padding: 0px 25px;
}

.btn-login:hover {
    background-color: #277cff;
    color: white;
}

#loginBox {
    width: 400px;
    background-color: white;
}

.social-media {
    width: 50px;
    height: 50px;
    margin: 10px;
    border-radius: 4px;
    border: 2px solid black;
    transition: 0.15s;
    padding: 0;
    display: -webkit-box;
    display: -moz-box;
    display: -ms-flexbox;
    display: -webkit-flex;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    font-size: 1.7rem;
    border: none;
}

.social-media.facebook {
    border-color: #3b5998;
    color: #3b5998;
}

.social-media.facebook:hover {
    background-color: #3b5998;
    color: white;
}

.social-media.linkedin {
    border-color: #007bb5;
    color: #007bb5;
}

.social-media.linkedin:hover {
    background-color: #007bb5;
    color: white;
}

.social-media.google {
    border-color: #db4437;
    color: #db4437;
}

.social-media.google:hover {
    background-color: #db4437;
    color: white;
}

.social-media.microsoft {
    border-color: #f35022;
    color: #db4437;
}

.social-media.microsoft:hover {
    background-color: #f35022;
    color: white;
}

.social-media.conectado {
    border-color: #3fb8bf;
    color: #3fb8bf;
}

.form-control:focus {
    border-color: #5472d3;
    box-shadow: 0 0 0 0.2rem rgba(84, 114, 211, 0.25);
}

.login-header {
    color: #277cff;
    margin: -1rem;
    height: 70px;
}

#wpLogin {
    width: 30%;
    -webkit-box-shadow: 8px 0px 64px 0px rgba(0,0,0,0.75);
    -moz-box-shadow: 8px 0px 64px 0px rgba(0,0,0,0.75);
    box-shadow: 8px 0px 64px 0px rgba(0,0,0,0.75);
}

#publicidade {
    width: 70%;
}

@media (max-width: 1500px) {
    #wpLogin {
        width: 40%;
    }
    #publicidade {
        width: 60%;
    }
    .hero-title{
        font-size: 5.5rem;
        border-left: 10px solid;
    }
}

@media (max-width: 1024px) {
    #loginBox {
        width: 300px;
        /*height: 510px;*/
    }
    .social-media {
        font-size: 1.2rem;
        height: 40px;
    }
    #wpLogin {
        width: 100% !important;
    }
    #publicidade {
        display: none;
    }
}

.half {
    width: 50%;
    height: 100%;
    top: 0;
    position: relative;
    float: left;
}

.fundo,
.fundo-cor {
    background: url(background.jpg);
    background-repeat: no-repeat;
    background-size: cover;
    opacity: 0.4;
    z-index: -1;
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
}

.fundo-cor {
    background: #277cff;
}

.input-group-text {
    background-color: unset;
}
		</style>
		
    </head>
    <body>
        <div class="half" id="publicidade">
            <div class="fundo-cor"></div>
            <div class="fundo"></div>
			<div class="w-100 h-100 d-flex justify-content-center align-items-center p-5">
				<h1 class="hero-title text-white w-100 p-5">
				Availtrade Seller <span>Simple</span> Solution
				</h1>
			</div>  
        </div>
        <div class="half" id="wpLogin">
            <div class="flex-container-center">
                <div id="loginBox">
                    <div class="container p-3 text-center">
                        <div class="login-header flex-container-center">
                            <h4>Sign in or create an Account</h4>
                        </div>
                        <form action="{{ route('seller.check') }}" method="post" enctype="multipart/form-data">

                       @if(Session::get('success'))
                         <div class="alert alert-success" style="color:red;">
                            {{ Session::get('success') }}
                         </div>
                       @endif
            
                       @if(Session::get('fail'))
                         <div class="alert alert-danger">
                            {{ Session::get('fail') }}
                         </div>
                       @endif
            
                       @csrf
                        <div class="mt-4 p-3">
                            <div class="row">
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">
                                            <span class="fas fa-envelope"></span>
                                        </span>
                                    </div>
                                    <input type="email" name="email" class="form-control" placeholder="E-mail">
                                </div>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">
                                            <span class="fas fa-lock"></span>
                                        </span>
                                    </div>
                                    <input type="password" name="password" class="form-control" placeholder="Password">
                                </div>
                                <span class="text-danger mt-2">
                                    E-mail or password incorrect!
                                </span>
                            </div>
                        </div>
                        <!--<em class="text-muted">or sign in using:</em>-->
                        <!--<div class="flex-container-center mt-1">-->
                        <!--    <div class="social-media facebook">-->
                        <!--        <span class="fab fa-facebook"></span>-->
                        <!--    </div>-->
                        <!--    <div class="social-media google">-->
                        <!--        <span class="fab fa-google"></span>-->
                        <!--    </div>-->
                        <!--    <div class="social-media linkedin">-->
                        <!--        <span class="fab fa-linkedin"></span>-->
                        <!--    </div>-->
                        <!--    <div class="social-media microsoft">-->
                        <!--        <span class="fab fa-microsoft"></span>-->
                        <!--    </div>-->
                        <!--</div>-->

                        <button class="btn-login my-3">
                            LOGIN
                        </button>
                        </form>
                        <span class="text-muted">
                            Don't have an account? Click
                            <a href="#" id="linkCriarConta">here</a> to create one
                        </span>
                    </div>
                </div>
            </div>
        </div>
        <script defer src="https://use.fontawesome.com/releases/v5.2.0/js/all.js" integrity="sha384-4oV5EgaV02iISL2ban6c/RmotsABqE4yZxZLcYMAdG7FAPsyHYAPpywE9PJo+Khy" crossorigin="anonymous"></script>
    </body>
</html>