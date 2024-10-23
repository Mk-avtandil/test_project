<div>
    <h3>Hello, {{$user->name}} <br> Welcome to Test Project</h3>
    <br><br>

    <p>You have successfully registered in our <a href="{{route('product.index')}}">Test Project Website</a></p>
    <br><br>

    Thanks,<br>
    {{ config('app.name') }}
</div>
