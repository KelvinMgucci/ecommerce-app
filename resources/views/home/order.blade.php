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

  <table>

<tr>

<th>Product Title</th>
<th>Price</th>
<th>Image</th>
<th>Delivery Status</th>
</tr>

@foreach ($order as $order)



<tr>
  <td>{{$order->product->title}}</td>
  <td>Tsh {{$order->product->price}} </td>
  <td>
    <img width="150" src="/products/{{$order->product->image}}">
  </td>
  
  <td>
  @if($order->status == 'in progress')
                            <span style="color: red;">
                            {{$order->status}}
                            </span>
                            @elseif($order->status == 'On The Way')
                            <span style="color: yellow;">{{$order->status}}</span>
                            @else
                            <span style="color: green;">{{$order->status}}</span>
                            @endif
  
  </td>
</tr>

@endforeach

</table>
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