@php
    use App\Models\Post;
    use App\Models\User;
    use App\Models\Board;

    $is_all = $board->name == 'all';
    $query = Post::query();
    if (!$is_all) {
        $query = $query->whereBoardId($board->id);
    } else {
        $anon = Board::getBoardByName('anon');
        $query = $query->where('board_id', '!=', $anon->id);
    }
    if ($option == 'tc'){
        $query = $query->where(function ($query) use ($search){
            $query->where('title', 'LIKE', "%$search%")->orWhere('content', 'LIKE', "%$search%");
        });
    } else if ($option == 'title'){
        $query = $query->where(function ($query) use ($search){
            $query->where('title', 'LIKE', "%$search%");
        });
    } else if ($option == 'content'){
        $query = $query->where(function ($query) use ($search){
            $query->where('content', 'LIKE', "%$search%");
        });
    } else if ($option == 'nickname' && $board->name != 'anon'){
        $nickid = User::whereNickname($search)->first();
        $nickid = $nickid != null ?  $nickid->id : -1;
        $query = $query->where(function ($query) use ($nickid){
            $query->where('user_id', $nickid);
        });
    }
    $posts = $query->orderByDesc('id')->paginate(20);
    $count = $posts->total();
@endphp

<div class="col-xs-12 col-sm-12 col-md-10 col-lg-10" id="main_content"><!-- 메인 content 시작 -->
    <div>
        <div class="btn-group">
            <a href="{{ route('board', $board->name) }}" class="btn btn-default">
                {{$board->alias}}
            </a>
        </div>
        @if(!$is_all)
            @if(($board->name == 'notice' && $login_user->permission >= 10) || $board->name != 'notice')
                <div class="btn-group">
                    <a href="{{ route('write', $board->name) }}" class="btn btn-default"><i class="fa fa-edit"></i> 글쓰기</a>
                </div>
            @endif
        @endif
        <div class="hidden-xs" style="block:inline;float:right;margin-right:3px;">
            {{$posts->currentPage()}}/{{$posts->lastPage()}}
        </div>
    </div>

    <!-- 제목 -->
    <form name="fboardlist" method="post" role="form" class="form-inline">
        <input type="hidden" name="bo_table" value="deep"> <input type="hidden" name="sfl" value="">
        <input type="hidden" name="stx" value=""> <input type="hidden" name="spt" value="">
        <input type="hidden" name="page" value="1"> <input type="hidden" name="sw" value="">
        <input type="hidden" name="sca" value="">

        <div class="table-responsive" id="list_deep" name="list_deep">
            <table width="100%" class="table table-condensed table-hover" style="word-wrap:break-word;">
                <thead>
                <tr class="table-header">
                    <th width="50px" class="hidden-xs">번호</th>
                    <th>제목<span class="visible-xs pull-right"
                                style="font-weight: normal;color:#B8B8B8;">페이지 {{$posts->currentPage()}}/{{$posts->lastPage()}}</span>
                    </th>
                    <th width="120px" class="hidden-xs">글쓴이</th>
                    <th width="70px" class="hidden-xs">날짜</th>
                    <th width="80px" class="hidden-xs">조회</th>
                    <th width="60px" class="hidden-xs">추천</th>
                </tr>
                </thead>
                <tbody>
                @foreach($posts as $post)
                    @php
                        $user = $post->getUser();
                        if($board->type == 'anonymous') {
                            $nickname = "익명_" . substr(sha1($post->id . $user->nickname), 0, 5);
                        } else{
                            $nickname = $post->getUser()->nickname;
                        }
                        $postNumber = $post->getBoardNumber();
                        if($board->isAllBoard()){
                            $name = $post->getBoard()->name;
                        } else {
                            $name = $board->name;
                        }
                    @endphp
                    <tr class="">
                        <td class="hidden-xs">
                            <span style="color:#BABABA;">{{$postNumber}}</span></td>
                        <td class="hidden-xs" align="left" style="word-break:break-all;">
                            <a href="{{route('post', [$name, $postNumber])}}"><span>{{$post->title}}</span></a> <a
                                href="{{route('post', [$name, $postNumber])}}"><span
                                    style="color:#EE5A00;"><small>({{$post->getCommentsCount()}})</small></span></a>
                        </td>
                        <td class="hidden-xs">
                            <a class="sideview"
                               href="@if($board->name=='anon'){{""}}@else{{route('board', ['board'=>$board->isAllBoard() ? 'all' : $name, 'search'=>$nickname,'option'=>'nickname'])}}@endif"
                               alt="{{$nickname}}" style="cursor:pointer;" role="button"
                               data-placement="auto right"
                               tabindex="0" data-toggle="popover"
                               data-trigger="focus">{{$nickname}}</a></td>
                        <td class="hidden-xs">{{$post->getSimpleCreatedAt()}}</td>
                        <td class="hidden-xs">{{$post->view}}</td>
                        <td class="hidden-xs" align="center">{{$post->getRecommendsCount()}}</td>
                    </tr>
                    <tr class="visible-xs">
                        <td align="left" style="word-break:break-all;">
                            <div>
                                <a href="{{route('post', [$name, $postNumber])}}"><span>{{$post->title}}</span></a> <a
                                    href="{{route('post', [$name, $postNumber])}}"><span
                                        style="color:#EE5A00;"><small><b>({{$post->getCommentsCount()}})</b></small></span></a>
                            </div>
                            <span class="pull-right">
                                <font style="color:#BABABA;">
                                    {{$post->getSimpleCreatedAt()}}&nbsp;&nbsp;
                                    {{$post->view}}&nbsp;&nbsp;
                                </font>
                                    {{$post->getRecommendsCount()}}&nbsp;
                                <a class="sideview"
                                   href="@if($board->name=='anon'){{""}}@else{{route('board', ['board'=>$board->isAllBoard() ? 'all' : $name, 'search'=>$nickname,'option'=>'nickname'])}}@endif"
                                   alt="{{$nickname}}" style="cursor:pointer;" role="button"
                                   data-placement="auto right"
                                   tabindex="0" data-toggle="popover"
                                   data-trigger="focus">{{$nickname}}</a>
                            </span>
                        </td>
                    </tr>
                    @php
                        $count-=1;
                    @endphp
                @endforeach
                </tbody>
            </table>
        </div>
    </form>


    <div class="hidden-xs" style="text-align:center;">
        {{$posts->appends(request()->input())->links()}}
    </div>
    <div class="center-block visible-xs">
        {{$posts->appends(request()->input())->links()}}
    </div>

    <form method="get" role="form" class="form-inline">
        <div class="btn-group">
            <a href="{{ route('board', $board->name) }}" class="btn btn-default"><i class="fa fa-list"></i> 목록</a>
        </div>
        @if(!$is_all)
            @if(($board->name == 'notice' && $login_user->permission >= 10) || $board->name != 'notice')
                <div class="btn-group">
                    <a href="{{ route('write', $board->name) }}" class="btn btn-default"><i class="fa fa-edit"></i> 글쓰기</a>
                </div>
            @endif
        @endif


        <div class="pull-right hidden-lg hidden-md hidden-sm">
            <a class="btn btn-default" data-toggle="collapse" data-target=".board-bottom-search-collapse"><i
                    class="fa fa-search"></i></a>
        </div>

        <div class="pull-right collapse navbar-collapse board-bottom-search-collapse">
            <div class="form-group">
                <label class="sr-only" for="option">sfl</label> <select name="option" class="form-control" id="option">
                    <option value="tc">제목+내용</option>
                    <option value="title">제목</option>
                    <option value="content">내용</option>
                    @if($board->name !='anon')
                        <option value="nickname">닉네임</option>
                    @endif
                </select>
            </div>
            <div class="form-group">
                <label class="sr-only" for="stx">stx</label>
                <input name="search" maxlength="15" size="10" itemname="검색어" required="" value="" class="form-control"
                       id="search">
            </div>

            <div class="form-group">
                <button class="btn btn-primary">검색</button>
            </div>
        </div>
    </form>
</div>
<script type="text/javascript">
    $("#{{$board->name}}").css({'background-color': '#ed6e0c'});
    let query = Object.fromEntries(new URLSearchParams(window.location.search).entries());
    if (query.option) {
        $('#option').val(query.option).prop('selected', true);
    }
    if (query.search) {
        $('#search').val(query.search);
    }
</script>
