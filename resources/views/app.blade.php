<!DOCTYPE html>
<html>
  <title>Laravel Technical Test - Webmagnat</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
  <style>
        .menu{
            display: inline-flex;
            list-style-type: none;
            margin: 0px 157px;
        }
        .menu > li{
            margin-left: 35px;
        }
        .product_image{
            width:100px;height:100px;object-fit:contain;
        }
        .menu_right{
            float:right;
            list-style-type: none;
        }
  </style>
  <body>
    <div class="well">
      <h1>{{ !empty(Request::segment(1)) ? Request::segment(1) : 'Login'}}</h1>
        @if(Request::segment(1) == 'admin')
           <ul class="menu">
                <li><a href="{{route('admin')}}">Dashboard</a></li>
                <li><a href="{{route('create_attribute')}}">Attribute</a></li>
                <li><a href="{{route('create_product')}}">Product</a></li>
           </ul>

           <ul class="menu_right">
                <li><a href="javascript:void(0);" class="user_name"></a> | &nbsp;<a href="javascript:void(0);" id="logout">Logout</a></li>
           </ul>
        @endif
    </div>
    <div class="main">
        @yield('content')
    </div>
  </body>
  <script src="https://code.jquery.com/jquery-3.6.4.min.js" integrity="sha256-oP6HI9z1XaZNBrJURtCoUT5SUnxFr8s3BzRl+cbzUq8=" crossorigin="anonymous"></script>
  @yield('jsscript')
  <script>
    $("#logout").click(function(){
        localStorage.clear();
        let redirect_url = "{{route('login')}}";
        window.location.replace(redirect_url);
    });
    let userString = localStorage.getItem('user');
    let user = JSON.parse(userString);
    $(".user_name").text(user.name.toUpperCase());
  </script>
</html>