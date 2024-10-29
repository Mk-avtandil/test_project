<h1 style="margin: 40px 40px 0 40px;">ORDER DETAILS:</h1>
<br>
<br>
<div style="margin: 40px; display: flex;">
    <div style="width: 50%">
        @if($products)
            <h3>PRODUCTS:</h3>
                <table style="width: 100%">
                    @foreach($products as $product)
                        <tr>
                            <td style="width: 50%"><a href="{{route('twill.products.show', ['product' => $product])}}">{{$product->type}}</a>: </td>
                            <td>{{$product->pivot->quantity}} * {{$product->price}} = {{$product->price * $product->pivot->quantity}}</td>
                        </tr>
                    @endforeach
                </table>
        @endif
    </div>
    <div style="width: 50%">
        @if($services)
            <h3>SERVICES:</h3>
            <table style="width: 100%">
                @foreach($services as $service)
                    <tr>
                        <td style="width: 50%">
                            <a href="{{route('twill.services.show', ['service' => $service])}}">{{$service->type}}</a>:
                        </td>
                        <td>{{$service->price}}</td>

                    </tr>
                @endforeach
            </table>
        @endif
    </div>
</div>
<div style="margin: 40px">
    <h3>USER:</h3>
    <p>{{$model->user->name}}</p>
</div>
