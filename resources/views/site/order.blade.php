<!doctype html>
<html lang="en">
<head>
    <title>Order page</title>
</head>
<body>
<div>
    <table>
    <thead>
    <tr>
        <td><h2>Order Details:</h2></td>
    </tr>
    </thead>
    <tbody>
    <tr>
        <td rowspan="8" style="padding-right: 20px;">
            <img width="200px" src="{{'/storage/uploads/' . $item->orderable->medias()->first()?->uuid}}" alt="{{$item->orderable->type}}">
        </td>
        <td>User: </td>
        <td>{{ $item->user_id }}</td>
    </tr>
    <tr>
        <td>Order type: </td>
        <td>{{ $item->orderable->type }}</td>
    </tr>
    <tr>
        <td>Status</td>
        <td>{{ $item->status  }}</td>
    </tr>
    <tr>
        <td>Price</td>
        <td>{{ $item->orderable->price }}</td>
    </tr>
    <tr>
        <td>Quantity</td>
        <td>{{ $item->quantity }}</td>
    </tr>
    <tr>
        <td>Created at</td>
        <td>{{ $item->created_at }}</td>
    </tr>
    <tr>
        <td>Updated at</td>
        <td>{{ $item->updated_at }}</td>
    </tr>
    <tr>
        <td>Total price</td>
        <td>{{ $item->quantity * $item->orderable->price }}</td>
    </tr>
    </tbody>
    </table>
</div>
</body>
</html>
