<h1 style="margin: 40px 40px 0 40px;">ORDER DETAILS:</h1>
<div style="margin: 40px; display: flex;">
    <div style="width: 50%">
        @if($products)
            <h3>PRODUCTS:</h3>
            <ol>
                @foreach($products as $product)
                    <li><a href="{{route('twill.products.show', ['product' => $product])}}">{{$product->type}}</a></li>
                @endforeach
            </ol>
        @endif
    </div>
    <div style="width: 50%">
        @if($services)
            <h3>SERVICES:</h3>
            <ol>
                @foreach($services as $service)
                    <li><a href="{{route('twill.services.show', ['service' => $service])}}">{{$service->type}}</a></li>
                @endforeach
            </ol>
        @endif
    </div>
</div>
<div style="margin: 40px">
    <h3>USER:</h3>
    <p>{{$model->user->name}}</p>
</div>
