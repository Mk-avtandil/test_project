<x-mail::message>
# Hello, {{auth()->user()->name}} Welcome to Test Project

You have successfully registered in our <a href="{{route('product.index')}}">Test Project Website</a>

<x-mail::button :url="''">
Please Verify Your Email
</x-mail::button>

Thanks,<br>
{{ config('app.name') }}
</x-mail::message>
