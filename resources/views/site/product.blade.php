<!doctype html>
<html lang="en">
<head>
    <title>Product revision page</title>
</head>
<body>
<div>
    <table style="margin:20px;">
        <thead>
        <tr>
            <td><h2>Product Details:</h2></td>
        </tr>
        </thead>
        <tbody>
        <tr>
            <td rowspan="8" style="padding-right: 20px;">
                <img width="200px" src="{{'/storage/uploads/' . $item->medias()->first()?->uuid}}" alt="{{$item->type}}">
            </td>
            <td>Product type: </td>
            <td>{{ $item->type }}</td>
        </tr>
        <tr>
            <td>Price: </td>
            <td>{{ $item->price }}</td>
        </tr>
        <tr>
            <td>Quantity: </td>
            <td>{{ $item->quantity  }}</td>
        </tr>
        <tr>
            <td>Size: </td>
            <td>{{$item->size}}</td>
        </tr>
        <tr>
            <td>Color: </td>
            <td>{{$item->color}}</td>
        </tr>
        <tr>
            <td>Created at</td>
            <td>{{$item->created_at}}</td>
        </tr>
        <tr>
            <td>Updated at</td>
            <td>{{$item->updated_at}}</td>
        </tr>
        <tr>
            <td>Description: </td>
            <td>{{strip_tags($item->description)}}</td>
        </tr>
        </tbody>
    </table>
</div>
</body>
</html>
