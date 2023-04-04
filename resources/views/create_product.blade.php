@extends('app')

@section('content')
@php $productId = ''; @endphp
@if(!empty(Request::segment(3)))
    @php $productId = Request::segment(3); @endphp
@endif
    <div class="container">
       <div class="row">
            @if(empty($productId))
            <div class="col-sm-4" id="attributeList">
                Attributes list
            </div>

            <div class="col-sm-4">
                <form id="productForm" method="post" enctype="multipart/form-data">
                    <div class="form-group">
                        <label for="name">Name:</label>
                        <input type="text" class="form-control" id="name">
                    </div>
                    <div class="form-group">
                        <label for="price">Price: <sub>($)</sub></label>
                        <input type="text" class="form-control" id="price">
                    </div>

                    <div class="form-group">
                        <label for="price">Attribute: <sub>assign attributes using comma (,)</sub></label>
                        <input type="text" class="form-control" id="attribute">
                    </div>

                    <div class="form-group">
                        <label for="vat">Vat: <sub>(%)</sub></label>
                        <input type="text" class="form-control" id="vat">
                    </div>

                    <div class="form-group">
                        <label for="product_image">Product Image: </label>
                        <input type="file" class="form-control" id="product_image" accept="image/*">
                    </div>
                    <button type="submit" class="btn btn-default">Submit</button>
                </form>
            </div>
            @endif
            <div class="col-sm-{{!empty($productId) ? 12 : 4}}" id="createdProduct">
               
            </div>
           
        <div>
    </div>
@endsection

@section('jsscript')
<script>
    $(document).ready(function(){
        let token = localStorage.getItem("token");
        let productId = '{{$productId}}';
        if(token != null) {
            if(productId != ''){
                displayProduct(token,productId);
            }else{
                getAttribute(token);
                $("form#productForm").on('submit', function(event){
                    event.preventDefault();
                    var formData = new FormData();
                    formData.append("name", $("#name").val());
                    formData.append("price", $("#price").val());
                    formData.append("attribute", $("#attribute").val());
                    formData.append("vat", $("#vat").val());
                    formData.append("product_image", product_image.files[0]);
    
                    $.ajax({
                        type: "POST",
                        url: "http://localhost:8002/api/products",
                        headers: {
                            authorization: "bearer "+token
                        }, 
                        data: formData,
                        cache: false,
                        contentType: false,
                        processData: false
                    }).done(function (data) {
                        if(data.success == true){
                            let productId = data.data.product.id;
                            getProduct(token, productId);
                            $("#name").val('')
                            $("#price").val('');
                            $("#attribute").val('');
                            $("#vat").val('');
                            $("#product_image").val('');
                        }else{
                            alert("Invalid credentials");
                        }
                    });
                });
            }
        }else{
            let redirect_url = "{{route('login')}}";
            window.location.replace(redirect_url);
        }

        function getAttribute(token){
            $.ajax({
                type: "GET",
                url: "http://localhost:8002/api/attributes",
                contentType: "application/json; charset=utf-8",
                headers: {
                    authorization: "bearer "+token
                }, 
                dataType: "json",
                encode: true,
            }).done(function (data) {
                if(data.success == true){
                    attributes = data.data.attribute;
                    html = `
                        <table class="table">
                            <tr><th>#</th><th>Attribute Name</th><th>Attribute Value</th></tr>`;
                        
                    $.each( attributes, function( key, attribute ) {
                        html += `
                            <tr>
                                <td>`+attribute.id+`</td>
                                <td>`+attribute.attribute_name+`</td>
                                <td>`+attribute.attribute_value+`</td>
                            </tr>`;
                    });
                    html += `</table>`;
                    $("#attributeList").html(html);
                }else{
                    
                }
            });
        }

        function getProduct(token, id){
            $.ajax({
                type: "GET",
                url: "http://localhost:8002/api/products/"+id,
                contentType: "application/json; charset=utf-8",
                headers: {
                    authorization: "bearer "+token
                }, 
                dataType: "json",
                encode: true,
            }).done(function (data) {
                if(data.success == true){
                    let product = data.data.product;
                    let html = `<table class="table">
                        <tr>
                            <th>Id</th>
                            <td>`+product.id+`</td>
                        </tr>
                        <tr>
                            <th>Name</th>
                            <td>`+product.name+`</td>
                        </tr>
                        <tr>
                            <th>Price</th>
                            <td>$`+product.price+`</td>
                        </tr>
                        <tr>
                            <th>Vat</th>
                            <td>`+product.vat+`%</td>
                        </tr>
                        <tr>
                            <th>Product image</th>
                            <td><img src='`+product.product_image+`' class='img-rounded img-thumbnail'></td>
                        </tr>`;

                    if(product.product_attributes.length > 0){
                        $.each( product.product_attributes, function( key, pAttribute ) {
                        html += `
                            <tr>
                                <th>`+pAttribute.attribute_name+`</th>
                                <td>`+pAttribute.attribute_value+`</td>
                            </tr>`;
                        });
                    }
                    let vat_amount = product.price * product.vat/100;
                    let total = Math.round(product.price + vat_amount).toFixed(2);
                    
                    html +=`  <tr>
                                <th>Total</th>
                                <td>$`+total+`</td>
                            </tr>
                            </table>`;

                    $("#createdProduct").html(html);
                }else{
                    
                }
            });
        }
        
        function displayProduct(token, id){
            getProduct(token,id);
        }

    });


    
</script>
@endsection