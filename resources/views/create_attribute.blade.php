@extends('app')

@section('content')
    <div class="container">
       <div class="row">
            <div class="col-sm-4">
                <form id="attributeForm">
                    <div class="form-group">
                        <label for="attribute_name">Attribute name:</label>
                        <input type="text" class="form-control" id="attribute_name">
                    </div>
                    <div class="form-group">
                        <label for="attribute_value">Attribute value:</label>
                        <input type="text" class="form-control" id="attribute_value">
                    </div>
                    <button type="submit" class="btn btn-default">Submit</button>
                </form>
            </div>
            <div class="col-sm-8" id="attributeList">
                Attribute lists
            </div>
        <div>
    </div>
@endsection

@section('jsscript')
<script>
    $(document).ready(function(){
        let token = localStorage.getItem("token");
        if(token != null) {
            getAttribute(token);
            $("#attributeForm").on('submit', function(event){
                event.preventDefault();
                var formData = {
                    attribute_name: $("#attribute_name").val(),
                    attribute_value: $("#attribute_value").val(),
                };

                $.ajax({
                    type: "POST",
                    url: "http://localhost:8002/api/attributes",
                    headers: {
                        authorization: "bearer "+token
                    }, 
                    data: formData,
                    dataType: "json",
                    encode: true,
                }).done(function (data) {
                    if(data.success == true){
                        getAttribute(token);
                        $("#attribute_name").val('')
                        $("#attribute_value").val('');
                    }else{
                        alert("Invalid credentials");
                    }
                });
            });

            
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
                    html = `<table class="table">
                    <tr>
                        <th>#</th>
                        <th>Attribute Name</th>
                        <th>Attribute Value</th>
                    </tr>`;
                    if(attributes.length > 0){
                        $.each( attributes, function( key, attribute ) {
                            html += `
                                <tr>
                                    <td>`+attribute.id+`</td>
                                    <td>`+attribute.attribute_name+`</td>
                                    <td>`+attribute.attribute_value+`</td>
                                </tr>`;
                        });
                    }else{
                        html += `<tr><th colspan="6">Sorry, no attribute created yet !</th></tr>`;
                    }
                    html += `</table>`;
                    $("#attributeList").html(html);
                }
            });
        }
            
    });


    
</script>
@endsection