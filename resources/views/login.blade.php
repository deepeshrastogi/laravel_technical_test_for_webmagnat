@extends('app')

@section('content')
<div class="container">
       <div class="row">
            <div class="col-sm-4" id="attributeList">
                <form id="loginForm" action="/action_page.php">
                    <div class="form-group">
                        <label for="email">Email:</label>
                        <input type="email" class="form-control" id="email">
                    </div>
                    <div class="form-group">
                        <label for="password">Password:</label>
                        <input type="password" class="form-control" id="password">
                    </div>
                    <button type="submit" class="btn btn-default" id="login">Login</button>
                </form>
                Click here for <a href="{{route('signup')}}">sign up</a>
            </div>
        </div>
    </div>
@endsection

@section('jsscript')
<script>
    $(document).ready(function(event){
        let token = localStorage.getItem("token");
        if(token != null) {
            let redirect_url = "{{route('admin')}}";
            window.location.replace(redirect_url);
        } 

        $("#loginForm").on('submit', function(event){
            event.preventDefault();
            var formData = {
                email: $("#email").val(),
                password: $("#password").val(),
            };

            $.ajax({
                type: "POST",
                url: "http://localhost:8002/api/login",
                data: formData,
                dataType: "json",
                encode: true,
            }).done(function (data) {
                if(data.success == true){
                    localStorage.setItem("token", data.data.authorisation.token);
                    localStorage.setItem("user", JSON.stringify(data.data.user));
                    let redirect_url = "{{route('admin')}}";
                    window.location.replace(redirect_url);
                }else{
                    alert("Invalid credentials");
                }
            });
        });
    });
  </script>
  @endsection