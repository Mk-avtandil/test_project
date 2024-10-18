<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
@if($type==='Product')
    <div style="margin:40px">
        @if($type==='Product') <img src="{{'/storage/uploads/' . $media_url?->uuid}}" alt="{{$model->orderable->type}} IMG"> @endif

    </div>
@endif
<table style="margin:40px;">
    <thead>
    <tr>
        <td><b>Order Details:</b></td>
    </tr>
    </thead>
    <tbody>
    <tr>
        <td>User:</td>
        <td>{{$model->user->name}}</td>
    </tr>
    <tr>
        <td>{{$type}}:</td>
        <td><a href="{{route('twill.products.edit', $model->orderable->id)}}">{{$model->orderable->type}}</a></td>
    </tr>
    <tr>
        <td>Ordered:</td>
        <td>{{$model?->created_at->diffForHumans()}}</td>
    </tr>
    @if($type==='Product')
        <tr>
            <td>Quantity:</td>
            <td>{{ $model->quantity }}</td>
        </tr>
    @endif
    <tr>
        <td>Status:</td>
        <td>{{$model->status}}</td>
    </tr>
    <tr>
        <td>Price:</td>
        <td>{{$model->orderable->price}}</td>
    </tr>
    <tr>
        <td>Total Price:</td>
        <td>{{$model->orderable->price * $model->quantity}}</td>
    </tr>
    </tbody>
    <tfoot>
    <tr>
        <td>{{$type}} Description:</td>
        <td style="padding-top: 10px; overflow: auto"> {{$model->orderable->description}}</td>
    </tr>
    </tfoot>
</table>

</body>
</html>
