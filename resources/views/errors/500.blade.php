@extends('frontEnd.master')
@section('content')
    <style>
        .error{
          font-size: 150px;
          color: #008B62;
          text-shadow: 
            1px 1px 1px #00593E,    
            2px 2px 1px #00593E,
            3px 3px 1px #00593E,
            4px 4px 1px #00593E,
            5px 5px 1px #00593E,
            6px 6px 1px #00593E,
            7px 7px 1px #00593E,
            8px 8px 1px #00593E,
            25px 25px 8px rgba(0,0,0, 0.2);
        }
        
        .page{
          margin: 2rem 0;
          font-size: 20px;
          font-weight: 600;
          color: #444;
        }
        
        .back-home{
          display: inline-block;
          border: 2px solid #222;
          color: #222;
          text-transform: uppercase;
          font-weight: 600;
          padding: 0.75rem 1rem 0.6rem;
          transition: all 0.2s linear;
          box-shadow: 0 3px 8px rgba(0,0,0, 0.3);
        }
        .back-home:hover{
          background: #222;
          color: #ddd;
        }
    </style>
    <section class="hero">
      <div class="hero-body">
         
        <h1 class="error">500</h1>
        <div class="page">Ooops!!! The page you are looking for is not found</div>
        <a class="back-home" href="https://availtrade.com/">Back to home</a>
        
      </div>
    </section>
@endsection