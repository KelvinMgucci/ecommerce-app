<!DOCTYPE html>
<html>

<head>
  @include('home.css')
  <style>
    .div_deg{
        display: flex;
        justify-content: center;
        align-items: center;
        margin: 60px;
    }
    table{
        border: 2px solid black;
        text-align: center;
        width: 800px;
    }

    th{
        border: 2px solid black;
        text-align: center;
        color: white;
        font: 20px;
        font-weight: bold;
        background-color: black;
    }

    td{
        border: 1px solid skyblue;
    }

    .cart_style{
        text-align: center;
        margin-bottom: 70px;
        padding: 18px;
    }
    .order_deg{
        padding-right: 100px;
        margin-top: -50px;
    }
    label{
        display: inline-block;
        width: 150px;
    }
    .div_gap{
    padding: 20px;
    }
  </style>
</head>

<body>
  <div class="hero_area">
    <!-- header section strats -->
    @include('home.header')
    <!-- end header section -->
    <!-- slider section -->


    <!-- end slider section -->
  </div>
  
 
  <div class="div_deg">
  <div class="order_deg">
          <form action="{{('confirm_order')}}" method="post">
            @csrf
            <div class="div_gap">
                <label>Reciever Name</label>
              <input type="text" name="name" value="{{Auth::user()->name}}">
            </div>
            <div class="div_gap">
                <label>Receiver address</label>
              <textarea name="address" value="" >{{Auth::user()->address}}</textarea>
            </div>
            <div class="div_gap">
                <label>Receiver Phone</label>
              <input type="text" name="phone" value="{{Auth::user()->phone}}">
            </div>

            <div class="div_gap">
              <button class="btn btn-primary">
                Place Order
              </button>
            </div>
          </form>
        </div>
  <table>

<tr>

<th>Product Title</th>
<th>Price</th>
<th>Image</th>
<th>Remove</th>
</tr>

<?php
$value=0;
?>
@foreach ($cart as $cart)
<tr>
  <td>{{$cart->product->title}}</td>
  <td>Tsh {{$cart->product->price}}</td>
  <td>
    <img width="150" src="/products/{{$cart->product->image}}">
  </td>
  <td>
    <a class="btn btn-danger" href="{{url('delete_cart',$cart->id)}}">Remove</a>
  </td>
</tr>

<?php
$value = $value + $cart->product->price;
?>
@endforeach
</table>


  </div>
  <div class="cart_style">
    <h3>Total Value In Cart Is: Tsh {{$value}}</h3>
  </div>
  
 

  @include('home.footer')

  <!-- end info section -->


  <script src="{{asset('js/jquery-3.4.1.min.js')}}"></script>
  <script src="{{asset('js/bootstrap.js')}}"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js">
  </script>
  <script src="{{asset('js/custom.js')}}"></script>

</body>

</html>