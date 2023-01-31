@extends('supplier.masterSupplier')
@section('title','Supplier Header')
@section('content')
<style>

    .text .panel-heading .panel-title a{
        text-decoration: none;
        color: black; 
        font-weight: bold;
    }
    .menu li a{
        text-decoration: none;
    }
    .one-header{
        font-size: 16px;
        width: 55%;
    }
    /*Header 3 part*/
    .topnav {
        overflow: hidden;
        background-color: none;

    }

    .topnav a {
        float: left;
        display: block;
        color: black;
        text-align: center;
        padding: 14px 16px;
        text-decoration: none;
        font-size: 17px;
    }

    .topnav a:hover {
        background-color: #ddd;
        color: black;
    }

    .topnav a.active {
        background-color: #2196F3;
        color: white;
    }

    .topnav .search-container {
        float: right;
    }

    .topnav input[type=text] {
        padding: 5px;
        margin-top: 8px;
        font-size: 17px;
        border: 1px solid gray;
    }

    .topnav .search-container button {
        float: right;
        padding: 6px 10px;
        margin-top: 8px;
        margin-right: 16px;
        background: #ddd;
        font-size: 17px;
        border: none;
        cursor: pointer;
    }

    .topnav .search-container button:hover {
        background: #ccc;
    }
    .headc .fourth-header a{
        color: black;
    }
    .headc .fourth-header .fourth-header1 li a{
        color: black;
        font-weight: bold;
    }
    .headc .fourth-header .fourth-header1 li a:hover{
        color: blue;
    }
    /*4th header part*/

</style>

<!DOCTYPE html>
<html>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
</head>
<body>
    <!-- Desktop View -->
    <div class="container ">
         <h3 style="font-weight: bold; text-align: center; color: #fbc904;">Choice Your Header</h3>
        <div class="panel-group" id="accordion"><br>

            <div class="row">
                <!-- 1st Header Part -->
                <div class="col-md-10 col-10 headc">
                    <nav class="navbar navbar-expand-sm bg-gray navbar-dark fourth-header">
                        <!-- Brand -->
                        <a class="navbar-brand" href="#">Logo</a>
                        <!-- Links -->
                        <ul class="navbar-nav one-header fourth-header1">
                            <li class="nav-item">
                                <a class="nav-link" href="#">Home</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#">About</a>
                            </li>
                            <li class="nav-item dropdown">
                                <a class="nav-link" href="#" id="navbardrop" data-toggle="dropdown">Products <i class="fa fa-angle-down"></i>
                                </a>
                                <div class="dropdown-menu">
                                    <a class="dropdown-item" href="#">Link 1</a>
                                    <a class="dropdown-item" href="#">Link 2</a>
                                    <a class="dropdown-item" href="#">Link 3</a>
                                </div>
                            </li>
                            <!-- Dropdown -->
                            <li class="nav-item dropdown">
                                <a class="nav-link" href="#" id="navbardrop" data-toggle="dropdown">Profile <i class="fa fa-angle-down"></i>
                                </a>
                                <div class="dropdown-menu">
                                    <a class="dropdown-item" href="#">Link 1</a>
                                    <a class="dropdown-item" href="#">Link 2</a>
                                    <a class="dropdown-item" href="#">Link 3</a>
                                </div>
                            </li>
                        </ul>
                        <form class="navbar-form navbar-left" action="" style="text-align: right;">
                            <div class="form-group">
                                <input type="text" class="form-control" placeholder="Search" name="search">
                            </div>
                            <button type="submit" class="btn btn-defult"><i class="fa fa-search"></i></button>
                        </form>

                    </nav>
                </div>
                <div class="col-md-2 col-2">
                    <input type="radio" id="save" name="save" value="save">
                    <label for="save" style="margin-top: 22px; font-size: 17px;">Save</label> 
                </div>
                <!-- 2nd Header Part -->
                <div class=" col-md-10 col-10">
                    <nav class="main-nav w-100 bg-light">
                        <ul class="menu">
                            <li>
                                <a href="#">Home</a>
                            </li>
                            <li>
                                <a href="product.html">Products</a>
                                <div class="megamenu megamenu-fixed-width">
                                    <div class="row">
                                        <div class="col-lg-6">
                                            <a href="#" class="nolink">Variations 1</a>
                                            <ul class="submenu">
                                                <li><a href="product.html">Horizontal Thumbs</a></li>
                                                <li><a href="product-full-width.html">Vertical Thumbnails</a></li>
                                                <li><a href="product.html">Inner Zoom</a></li>
                                                <li><a href="product-addcart-sticky.html">Addtocart Sticky</a></li>
                                                <li><a href="product-sidebar-left.html">Accordion Tabs</a></li>
                                            </ul>
                                        </div><!-- End .col-lg-4 -->
                                        <div class="col-lg-6">
                                            <a href="#" class="nolink">Product Layout Types</a>
                                            <ul class="submenu">
                                                <li><a href="product.html">Default Layout</a></li>
                                                <li><a href="product-extended-layout.html">Extended Layout</a></li>
                                                <li><a href="product-full-width.html">Full Width Layout</a></li>
                                                <li><a href="product-grid-layout.html">Grid Images Layout</a></li>
                                                <li><a href="product-sticky-both.html">Sticky Both Side Info</a></li>
                                                <li><a href="product-sticky-info.html">Sticky Right Side Info</a></li>
                                            </ul>
                                        </div><!-- End .col-lg-4 -->
                                    </div><!-- End .row -->
                                </div><!-- End .megamenu -->
                            </li>
                            <li>
                                <a href="#">Pages</a>
                                <ul>
                                    <li><a href="cart.html">Shopping Cart</a></li>
                                    <li><a href="#">Checkout</a>
                                        <ul>
                                            <li><a href="checkout-shipping.html">Checkout Shipping</a></li>
                                            <li><a href="checkout-shipping-2.html">Checkout Shipping 2</a></li>
                                            <li><a href="checkout-review.html">Checkout Review</a></li>
                                        </ul>
                                    </li>
                                    <li><a href="#">Dashboard</a>
                                        <ul>
                                            <li><a href="dashboard.html">Dashboard</a></li>
                                            <li><a href="my-account.html">My Account</a></li>
                                        </ul>
                                    </li>
                                    <li><a href="about.html">About Us</a></li>
                                    <li><a href="#">Blog</a>
                                        <ul>
                                            <li><a href="blog.html">Blog</a></li>
                                            <li><a href="single.html">Blog Post</a></li>
                                        </ul>
                                    </li>
                                    <li><a href="contact.html">Contact Us</a></li>
                                    <li><a href="">Login</a></li>
                                    <li><a href="" >Sign Up</a></li>
                                    <li><a href="privacy.html" >Privacy & Policy</a></li>
                                    <li><a href="forgot-password.html">Forgot Password</a></li>
                                </ul>
                            </li>
                            <li><a href="blog.html">Blog</a></li>
                            <li><a href="about.html">About Us</a></li>
                            <li><a href="contact.html">Contact Us</a></li>
                            <li>
                                <a href="contact.html">Contact Us</a>
                            </li>
                            <form class="navbar-form navbar-left" action="" style="text-align: right;">
                                <div class="form-group">
                                    <input type="text" class="form-control" placeholder="Search" name="search">
                                </div>
                                <button type="submit" class="btn btn-primary"><i class="fa fa-search"></i></button>
                            </form>
                        </ul>
                    </nav>
                </div>
                <div class="col-md-2 col-2">
                    <input type="radio" id="save" name="save" value="save">
                    <label for="save" style="margin-top: 22px; font-size: 17px;">Save</label>
                </div><br><br><br><br>

                <!-- 3rd Header part -->
                <div class="col-md-10 col-10">
                    <nav class="navbar navbar-expand-sm bg-dark navbar-dark">
                        <!-- Brand -->
                        <a class="navbar-brand" href="#">Logo</a>
                        <!-- Links -->
                        <ul class="navbar-nav one-header">
                            <li class="nav-item">
                                <a class="nav-link" href="#">Home</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#">About</a>
                            </li>
                            <li class="nav-item dropdown">
                                <a class="nav-link" href="#" id="navbardrop" data-toggle="dropdown">Products <i class="fa fa-angle-down"></i>
                                </a>
                                <div class="dropdown-menu">
                                    <a class="dropdown-item" href="#">Link 1</a>
                                    <a class="dropdown-item" href="#">Link 2</a>
                                    <a class="dropdown-item" href="#">Link 3</a>
                                </div>
                            </li>
                            <!-- Dropdown -->
                            <li class="nav-item dropdown">
                                <a class="nav-link" href="#" id="navbardrop" data-toggle="dropdown">Profile <i class="fa fa-angle-down"></i>
                                </a>
                                <div class="dropdown-menu">
                                    <a class="dropdown-item" href="#">Link 1</a>
                                    <a class="dropdown-item" href="#">Link 2</a>
                                    <a class="dropdown-item" href="#">Link 3</a>
                                </div>
                            </li>
                        </ul>
                        <form class="navbar-form navbar-left" action="" style="text-align: right;">
                            <div class="form-group">
                                <input type="text" class="form-control" placeholder="Search" name="search">
                            </div>
                            <button type="submit" class="btn btn-defult"><i class="fa fa-search"></i></button>
                        </form>

                    </nav>
                </div>
                <div class="col-md-2 col-2">
                    <input type="radio" id="save" name="save" value="save">
                    <label for="save" style="margin-top: 22px; font-size: 17px;">Save</label>
                </div>
                <!-- 4th Header Part -->
                <div class="col-md-10 col-10">
                    <div class="topnav">
                        <a  href="#home">Home</a>
                        <a href="#about">About</a>
                        <a href="#contact">Products</a>
                        <a href="#contact">Contact</a>
                        <div class="search-container">
                            <form action="">
                                <input type="text" placeholder="Search.." name="search">
                                <button type="submit"><i class="fa fa-search"></i></button>
                            </form>
                        </div>

                    </div>
                </div>
                <div class="col-md-2 col-2">
                    <input type="radio" id="save" name="save" value="save">
                    <label for="save" style="margin-top: 22px; font-size: 17px;">Save</label> 
                </div>
            </div>
        </div> 
    </div><br>
</body>
</html>

@endsection