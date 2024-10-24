<div>
    <br>
    <h1>
        <a href="#">{{$comment->user->name}}</a> commented on
        {{$type}}
        <a href="{{route("twill.{$type}s.show", [$type => $comment->commentable_id])}}">{{$comment->commentable->type}}</a>
        {{$comment->created_at->diffForHumans()}}: <br><br>
        <i>{{$comment->body}}</i>
    </h1>
</div>
