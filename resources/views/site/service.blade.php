<!doctype html>
<html lang="en">
<head>
    <title>Service page</title>
</head>
<body>
<div>
    <table style="margin:20px;">
        <thead>
        <tr>
            <td><h2>Service Details:</h2></td>
        </tr>
        </thead>
        <tbody>
        <tr>
            <td>Service type: </td>
            <td>{{ $item->type }}</td>
        </tr>
        <tr>
            <td>Price: </td>
            <td>{{ $item->price }}</td>
        </tr>
        <tr>
            <td>Deadline: </td>
            <td>{{ $item->deadline  }}</td>
        </tr>
        <tr>
            <td>Example link: </td>
            <td>{{$item->example_link}}</td>
        </tr>
        <tr>
            <td>Created at: </td>
            <td>{{$item->created_at}}</td>
        </tr>
        <tr>
            <td>Updated at: </td>
            <td>{{$item->updated_at}}</td>
        </tr>
        </tbody>
    </table>
</div>
</body>
</html>
