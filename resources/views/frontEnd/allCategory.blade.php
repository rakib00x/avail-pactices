@extends('frontEnd.master')
@section('title','Home')
@section('content')
    <div class="container mt-5 mb-5">
        <div class="columns is-full">
            <table width="100%">
                <tr>
                    <td><img src="{{ URL::to('public/images/1631357662678icons8-agriculture-64.png') }}" width="32" height="32"/><a href="#">Agriculture & Food</a></td>
                    <td>Apparel,Textiles & Accessories</td>
                    <td>Auto & Transportation</td>
                    <td>Bags, Shoes & Accessories</td>
                    <td>Electronics</td>
                    <td>Electrical Equipment, Components & Telecoms</td>
                </tr>
                <tr>
                    <td>Gifts, Sports & Toys</td>
                    <td>Health & Beauty</td>
                    <td>Home, Lights & Construction</td>
                    <td>Machinery, Industrial Parts & Tools</td>
                    <td>Metallurgy, Chemicals, Rubber & Plastics</td>
                    <td>Packaging, Advertising & Office</td>
                </tr>
            </table>
        </div>
    </div>
@endsection


