@extends('site.layouts.block')
<div class="prose">
    <h2>{{$block->translatedInput('title')}}</h2>
    {!! $block->translatedInput('text') !!}
</div>
