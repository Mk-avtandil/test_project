<x-menu/>

<div class="mx-auto max-w-2xl">
    <h1>{{ $item->title }}</h1>
    <p>{{$item->description}}</p>
    {!! $item->renderBlocks() !!}
</div>
