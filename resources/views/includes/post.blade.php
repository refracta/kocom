@php

    use Illuminate\Support\Facades\Auth;
    use \App\Models\Recommend;
    use \App\Models\Post;
    use \App\Models\Board;
   $board = $post->getBoard();
   $is_login = Auth::check();
   if($is_login){
       $login_user = Auth::user();
       $recommended = Recommend::isRecommended($login_user->id, $post->id);
   }
   $user = $post->getUser();
   $raw_comments = $post->getComments();
   $len = count($raw_comments);
   $comments = [];
   $current = 0;
   foreach($raw_comments as $comment){
       if($comment->reply == null){
           $comments[$current++] = $comment;
       } else {
           for($i = $current - 1; $i > -1; $i--){
               $retComment = $comments[$i];
               if($retComment->id == $comment->reply || $retComment->reply == $comment->reply){
                   $comment->level = $retComment->level + 1;
                   if($retComment->reply == $comment->reply) {
                       $comment->level--;
                   }
                   array_splice($comments, $i + 1, 0, [$comment]);
                   break;
               }
           }
           $current++;
       }
   }
    if($board->type == 'anonymous') {
        $nickname = "익명_" . substr(sha1($post->id . $user->nickname), 0, 5);
    } else{
        $nickname = $post->getUser()->nickname;
    }
@endphp

<div>
    <form style="display: none;" role="form"
          id="recommend" method="post"
          action="{{route('recommends')}}" onsubmit=""
          autocomplete="off" style="margin:0px;">
        @csrf
        <input type="hidden" name="post_id" value="{{$post->id}}">
    </form>
    <form style="display: none;" role="form"
          id="delete" method="post"
          action="{{route('posts.delete')}}" onsubmit=""
          autocomplete="off" style="margin:0px;">
        @csrf
        <input type="hidden" name="post_id" value="{{$post->id}}">
    </form>
    <div id="view_btn_top">
        <div class="btn-group">
            <a href="{{route('board', $board->name)}}" class="btn btn-default btn-sm btn-list">목록</a></div>
        <div class="btn-group">
            <a href="{{route('write', $board->name)}}" class="btn btn-default btn-sm btn-write">글쓰기</a></div>
        @if($is_login)
            @if($post->user_id == $login_user->id || $login_user->permission >= 10)
                <div class="btn-group">
                    <a href="{{route('modify', ['modify'=>$post->id])}}"
                       class="btn btn-default btn-sm btn-good">수정</a>
                    <a onclick="javascript:confirm('정말 삭제하시겠습니까?') ? $('#delete').submit() : void 0" target="hiddenframe"
                       class="btn btn-danger btn-sm btn-good">삭제</a>
                </div>
            @endif
            <div class="btn-group">
                <a onclick="javascript:$('#recommend').submit();" target="hiddenframe"
                   class="btn btn-{{$recommended ? "danger" : "primary"}} btn-sm btn-good">{{$recommended ? "추천해제" : "추천"}}</a>
            </div>
        @endif

        <div class="btn-group pull-right">
            <a href="#commentContents" class="btn btn-default btn-sm"><i class="fa fa-chevron-down"></i></a>
            <a href="{{route('board', $board->name)}}" class="btn btn-default btn-sm btn-list">목록</a></div>
        <div class="btn-group hidden-xs hidden-sm  pull-right">
        </div>
    </div>

    <div id="view_header" class="panel panel-default">
        <div class="panel-heading" style="padding-bottom:0px; background-color: #f5f5f5 !important;">
            <p>
                <strong>{{$post->title}}</strong>
            </p>
            <p>
                <font style="color:#BABABA;">
                </font></p>
            <div class="pull-left"><font style="color:#BABABA;"><a class="sideview"
                                                                   href="@if($board->name=='anon'){{""}}@else{{route('board', ['board'=>$board->name, 'search'=>$nickname,'option'=>'nickname'])}}@endif"
                                                                   alt="{{$nickname}}"
                                                                   style="cursor:pointer;"
                                                                   role="button" data-placement="auto right"
                                                                   tabindex="0" data-toggle="popover"
                                                                   data-trigger="focus">{{$nickname}}</a>&nbsp;&nbsp;&nbsp;</font>
            </div>
            <font style="color:#BABABA;">
                <div class="hidden-md hidden-lg pull-left">{{$post->getSimpleCreatedAt()}}</div>
                <div class="hidden-xs hidden-sm pull-left">{{$post->created_at->format('Y-m-d H:i:s')}}</div>&nbsp;&nbsp;
                조회 {{$post->view}}&nbsp;&nbsp;
                추천 {{$post->getRecommendsCount()}}&nbsp;&nbsp;&nbsp;&nbsp; </font>
            <span class="pull-right">
    <a href="javascript:prompt('이 글의 주소입니다. CTRL-C를 눌러서 복사하세요.','{{route('post.number', [$post->id])}}');"
       style="letter-spacing:0;"><i class="fa fa-link"></i></a>
    </span>
            <p></p>
            @php
                use Illuminate\Support\Facades\Storage;
                    $files = json_decode($post->files);
            @endphp
            @foreach($files as $file)

                <p><i class="fa fa-file" title="attached file"></i> <a download href="{{asset('storage/uploads/' . $file)}}"
                                                                       title="">{{$file}}<font
                            style="font-weight:normal;color:#B8B8B8;">
                            ({{floor(Storage::disk('local')->size('public/uploads/' . $file) / 1024 * 100)/100}}
                            KB)</font></a><br></p>
            @endforeach

        </div>

        <div id="view_main" class="panel-body">
            <span id="writeContents" style="word-wrap:break-word;">
                {!!  $post->content  !!}
            </span>
        </div>

    </div>

    <script text="text/javascript">
        function comment_box(id) {
            $('#comment_' + id + ' .comment-target').after($('#comment_write'));
            $('#reply').val(id);
        }
    </script>
    <div name="commentContents" id="commentContents" class="commentContents">
        @foreach($comments as $comment)
            @php
                $cuser = $comment->getUser();
                if($board->type == 'anonymous') {
                    $cnickname = "익명_" . substr(sha1($post->id . $cuser->nickname), 0, 5);
                } else{
                    $cnickname = $cuser->nickname;
                }
            @endphp
            <table role="table" width="100%" cellpadding="0" cellspacing="0" border="0" id="comment_{{$comment->id}}"
                   data-level="{{$comment->level}}">
                <tbody>
                <tr>
                    <td>{!! str_repeat("&nbsp;", 5 * $comment->level) !!}</td>
                    <td width="100%">
                        <table border="0" cellpadding="0" cellspacing="0" width="100%">
                            <tbody>
                            <tr>
                                <td height="1" colspan="3" bgcolor="#dddddd"></td>
                                <td>
                                </td>
                            </tr>
                            <tr>
                                <td height="1" colspan="3"></td>
                            </tr>
                            <tr class="comment-target">
                                <td valign="top">
                                    <div style="float:left; margin:2px 0 0 2px;">
                                        @if(!$comment->deleted)
                                            <strong><a
                                                    href="@if($board->name=='anon'){{""}}@else{{route('board', ['board'=>$board->name, 'search'=>$cnickname,'option'=>'nickname'])}}@endif"
                                                    class="sideview" alt="{{$cnickname}}"
                                                    style="cursor:pointer;" role="button"
                                                    data-placement="auto right" tabindex="0" data-toggle="popover"
                                                    data-trigger="focus">{{$cnickname}}</a></strong>
                                            <font style="color:#BABABA;">
                                            </font>
                                            {{$post->getSimpleCreatedAt()}}
                                        @endif
                                    </div>
                                    <div class="btn-group pull-right" style="margin-top:5px;">
                                        @if(!$comment->deleted)
                                            <a class="btn btn-default btn-sm"
                                               href="javascript:comment_box('{{$comment->id}}');">댓글</a>
                                        @endif
                                        @if(($is_login && $login_user->id == $comment->user_id || $login_user->permission >= 10) && !$comment->deleted)
                                            <form style="display: none;" role="form"
                                                  id="comment_delete_{{$comment->id}}" method="post"
                                                  action="{{route('comments.delete')}}" onsubmit=""
                                                  autocomplete="off" style="margin:0px;">
                                                @csrf
                                                <input type="hidden" name="comment_id" value="{{$comment->id}}">
                                            </form>
                                            <a class="btn btn-danger btn-sm"
                                               href="javascript:confirm('정말 삭제하시겠습니까?') ? $('#comment_delete_{{$comment->id}}').submit() : void 0">삭제</a>
                                        @endif
                                    </div>

                                    <div
                                        style="line-height:20px; padding:7px; word-break:break-all; word-wrap:break-word; overflow:hidden; clear:both; ">
                                        @if(!$comment->deleted)
                                            {{$comment->content}}
                                        @else
                                            * .. 삭제된 댓글입니다 .. *
                                        @endif
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td height="5" colspan="3"></td>
                            </tr>
                            </tbody>
                        </table>

                    </td>
                </tr>
                </tbody>
            </table>
        @endforeach
    </div>

    <div id="comment_write" style="display: block;">
        <table width="100%" border="0" cellpadding="1" cellspacing="0" bgcolor="#dddddd">
            <tbody>
            <tr>
                <td>
                    <form role="form" class="form-horizontal" name="comment" method="post"
                          action="{{route('comments.create')}}" onsubmit=""
                          autocomplete="off" style="margin:0px;">
                        @csrf
                        <input type="hidden" name="reply" id="reply" value="null">
                        <input type="hidden" name="post_id" value="{{$post->id}}">

                        <table role="table" width="100%">
                            <tbody>
                            <tr>
                                <td width="95%">
                                    <a name="g4_comment"></a>
                                    <textarea class="form-control" id="wr_content" name="content" rows="8"
                                              itemname="내용" required=""
                                              style="width:100%; word-break:break-all;"></textarea>
                                </td>
                                <td width="85" align="center">
                                    <button type="submit" class="btn btn-success">작성</button>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </form>
                </td>
            </tr>
            </tbody>
        </table>
    </div>
    <div style="height:10px;"></div>
    <div id="view_btn_top">
        <div class="btn-group">
            <a href="{{route('board', $board->name)}}" class="btn btn-default btn-sm btn-list">목록</a></div>
        <div class="btn-group">
            <a href="{{ route('write', $board->name) }}" class="btn btn-default btn-sm btn-write">글쓰기</a></div>
        @if($is_login)
            @if($post->user_id == $login_user->id || $login_user->permission >= 10)
                <div class="btn-group">
                    <a href="{{route('modify', ['modify'=>$post->id])}}"
                       class="btn btn-default btn-sm btn-good">수정</a>
                    <a onclick="javascript:confirm('정말 삭제하시겠습니까?') ? $('#delete').submit() : void 0" target="hiddenframe"
                       class="btn btn-danger btn-sm btn-good">삭제</a>
                </div>
            @endif
                <div class="btn-group">
                    <a onclick="javascript:$('#recommend').submit();" target="hiddenframe"
                       class="btn btn-{{$recommended ? "danger" : "primary"}} btn-sm btn-good">{{$recommended ? "추천해제" : "추천"}}</a>
                </div>
        @endif
        <div class="btn-group pull-right">
            <a href="#commentContents" class="btn btn-default btn-sm"><i class="fa fa-chevron-down"></i></a>
            <a href="{{route('board', $board->name)}}" class="btn btn-default btn-sm btn-list">목록</a></div>
        <div class="btn-group hidden-xs hidden-sm  pull-right">
        </div>
    </div>
    <br>
    <br>
</div>

{{--{{dump($board)}}--}}
{{--{{dump($post)}}--}}
