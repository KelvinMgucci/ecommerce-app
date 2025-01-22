<!DOCTYPE html>
<html>
  <head> 
@include('admin.css')
  </head>
  <body>
  @include('admin.header')
 <!-- Sidebar Navigation start-->
@include('admin.sidebar')
 <!-- Sidebar Navigation end-->
      <div class="page-content">
        <div class="page-header">
          <div class="container-fluid">

          <div class="title"><strong>Orders</strong></div>
                  <div class="table-responsive"> 
                    <table class="table">
                      <thead>
                        <tr>
                          <th>Order ID</th>
                          <th>Customer Name</th>
                          <th>Address</th>
                          <th>Phone</th>
                          <th>Product Title</th>
                          <th>Price</th>
                          <th>Image</th>
                          <th>Status</th>
                          <th>Change Status</th>
                          
                        </tr>
                      </thead>
                      <tbody>
                        @foreach ($data as $data )
                        <tr>
                          <th scope="row">{{$data->id}}</th>
                          <td>{{$data->name}}</td>
                          <td>{{$data->rec_address}}</td>
                          <td>{{$data->phone}}</td>
                          <td>{{$data->product->title}}</td>
                          <td>Tsh {{$data->product->price}}</td>
                          <td>
                            <img width="150" src="products/{{$data->product->image}}">
                          </td>
                          <td>
                            @if($data->status == 'in progress')
                            <span style="color: red;">
                            {{$data->status}}
                            </span>
                            @elseif($data->status == 'On The Way')
                            <span style="color: yellow;">{{$data->status}}</span>
                            @else
                            <span style="color: green;">{{$data->status}}</span>
                            @endif
                          </td>
                          <td>
                            <a href="{{url('on_the_way',$data->id)}}" class="btn btn-primary">On The Way</a>
                            <a href="{{url('delivered',$data->id)}}" class="btn btn-success">Delivered</a>
                          </td>
                          
                        </tr>
                        @endforeach
                       
                       
                        
                        </div>
                        </div>
          </div>
      </div>
    </div>
    <!-- JavaScript files-->
    <script src="{{asset('admincss/vendor/jquery/jquery.min.js')}}"></script>
    <script src="{{asset('admincss/vendor/popper.js/umd/popper.min.js')}}"> </script>
    <script src="{{asset('admincss/vendor/bootstrap/js/bootstrap.min.js')}}"></script>
    <script src="{{asset('admincss/vendor/jquery.cookie/jquery.cookie.js')}}"> </script>
    <script src="{{asset('admincss/vendor/chart.js/Chart.min.js')}}"></script>
    <script src="{{asset('admincss/vendor/jquery-validation/jquery.validate.min.js')}}"></script>
    <script src="{{asset('admincss/js/charts-home.js')}}"></script>
    <script src="{{asset('admincss/js/front.js')}}"></script>
  </body>
</html>