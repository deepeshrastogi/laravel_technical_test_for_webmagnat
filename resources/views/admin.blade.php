@extends('app')

@section('content')
    <div class="container">
       <div class="row">
            <h2>Product Lists</h2>
            <div class="col-sm-12" id="productList">
                Products list
            </div>
        <div>
    </div>
@endsection

@section('jsscript')
<script>
    $(document).on('click', '.deleteProduct', function () {
        let id = $(this).data("id");
        let token = localStorage.getItem("token");
        if(token != null) {
            deleteProduct(token, id)
        }
    });

    $(document).ready(function(){
        let token = localStorage.getItem("token");
        if(token != null) {
            getProductList(token);
        }else{
            let redirect_url = "{{route('login')}}";
            window.location.replace(redirect_url);
        }   
    });

    function getProductList(token){
        $.ajax({
            type: "GET",
            url: "http://localhost:8002/api/products",
            contentType: "application/json; charset=utf-8",
            headers: {
                authorization: "bearer "+token
            }, 
            dataType: "json",
            encode: true,
        }).done(function (data) {
            if(data.success == true){
                let products = data.data.products;
                let html = `<table class="table">
                            <tr>
                                <th>Id</th>
                                <th>Name</th>
                                <th>Price</th>
                                <th>Vat</th>
                                <th>Product image</th>
                                <th>Total</th>
                                <th>Action</th>
                            </tr>`;
                if(products.length > 0){
                    $.each(products, function( key, product ) {
                            let vat_amount = product.price * product.vat/100;
                            let total = Math.round(product.price + vat_amount).toFixed(2);
                            html += `
                            <tr>
                                <td>`+product.id+`</td>
                                <td>`+product.name+`</td>
                                <td>$`+product.price+`</td>
                                <td>`+product.vat+`%</td>
                                <td><img src='`+product.product_image+`' class='img-rounded img-thumbnail product_image'></td>
                                <td>$`+total+`</td>
                                <td><a href="{{route('create_product')}}/`+product.id+`" class="btn btn-sm btn-info">View</a> 
                                <button type="button" class="deleteProduct btn btn-sm btn-danger" data-id="`+product.id+`">Delete</button></td>
                            </tr>`;
                    });
                }else{
                    html = `<tr><th colspan="6">Sorry, no product created yet !</th></tr>`;
                }
                html +=`</table>`;
                $("#productList").html(html);
            }else{
                
            }
        });
    }

    function deleteProduct(token, id){
            $.ajax({
                type: "DELETE",
                url: "http://localhost:8002/api/products/"+id,
                contentType: "application/json; charset=utf-8",
                headers: {
                    authorization: "bearer "+token
                }, 
                dataType: "json",
                encode: true,
            }).done(function (data) {
                if(data.success == true){
                    getProductList(token);
                }
            });
        }
    
</script>
@endsection