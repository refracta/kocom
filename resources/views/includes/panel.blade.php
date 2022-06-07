@php
    use App\Models\Board;
    use App\Models\Post;

    $board = Board::getBoardByName($name);
    if($board->isAllBoard()){
        $boards = Board::all();
    }
    $posts = ($board->name == 'all' ? Post::orderByDesc('id') : Post::whereBoardId($board->id))->orderByDesc('id')->paginate($limit);
@endphp
<div class="panel panel-default">
    <div class="panel-heading">
        <a href="{{ route('board', $name) }}" onfocus="this.blur()">{{ $board->alias }}</a>
    </div>
    <div class="panel-body" style="overflow:hidden">
        <ul class="list-unstyled">
            @foreach($posts as $post)
                @php
                    if($board->isAllBoard()){
                        $currentBoard = $boards[$post->board_id - 1];
                        $name = $currentBoard->name;
                    }
                @endphp
                <li>
                    <a style="text-decoration: none;" href="{{route("post", [$name, $post->getBoardNumber()])}}"
                       onfocus="this.blur()"
                       title="{{$post->title}}">
                            <span onMouseOver="this.style.textDecoration='underline'"
                                  onMouseOut="this.style.textDecoration='none'"
                                  style="overflow: hidden; text-overflow: ellipsis; white-space: nowrap; max-width: 90%; display: block; float: left">
                                @if($board->isAllBoard())
                                    <font color="gray">{{$currentBoard->alias}} </font>
                                @endif
                                {{$post->title}}</span>
                        <span style="text-decoration:none; display: block; white-space: pre; font-weight: bold"> ({{$post->getCommentsCount()}})</span>
                    </a>
                </li>
            @endforeach
        </ul>
    </div>
</div>
