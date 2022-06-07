@php
    use Illuminate\Support\Facades\Auth;
    if(Auth::check()){
        $user = Auth::user();
    }
@endphp
@if(Auth::check())
    <div class="panel panel-default">
        <div class="panel-heading">
            <strong><a href="#" style="color: white">{{$user->nickname}}</a></strong>
            <span class="pull-right" style="margin-right:-10px;margin-left:5px;border:1px;"></span>
            <a class="point-info" href=""><span class="pull-right"><font
                        color="#737373"><small style="color: #efefef">{{$user->point}} PT</small></font></span></a>
        </div>
        <div class="btn-group btn-group-justified">
            <a href=""
               class="btn btn-default btn-sm " style="border-color: #ffffff;"
               onfocus="">{{$user->permission == 10 ? "LV: 10 (관리자)" : "LV: ".$user->permission}}</a>
        </div>
        <div class="btn-group btn-group-justified">
            <a href="{{route('board', ['board'=>'all', 'search'=>$user->nickname, 'option'=>'nickname'])}}"
               class="btn btn-default btn-sm " style="border-color: #ffffff;"
               href="" onfocus="this.blur()">내 글 보기</a>
        </div>
        <div class="btn-group btn-group-justified">
            <a class="btn btn-default btn-sm" href="{{route('logout')}}">로그아웃</a>
        </div>
    </div>
@else
    <form method="post" role="form"
          class="form-inline" action="{{route('login')}}">
        @csrf
        <input type="hidden" name="url" value="{{ route("root") }}">

        <input type="text" class="form-control" style="width:100%" name="email" id="email" maxlength="100"
               itemname="아이디(이메일)" placeholder="아이디(이메일)"> <label for="email" class="sr-only">member_email</label>
        <input type="password" class="form-control" style="width:100%;margin-top:-1px;" name="password"
               id="outlogin_mb_password" maxlength="50" itemname="패스워드" placeholder="비밀번호">
        <label for="outlogin_mb_password" class="sr-only">password</label>

        <div class="input-group" style="margin-top:-1px;width:100%">
            <span class="input-group-addon">
                <div class="checkbox custom">
                <label>
                <input type="checkbox" name="remember" title="자동로그인"
                       onclick="if (this.checked) { if (confirm('자동 로그인을 사용하면 이 기기에 대해서 서버가 무기한으로 인증 정보를 유지하게 됩니다.\n\n공공장소에서는 사용하지 않을 것을 당부드립니다.\n\n자동 로그인을 활성화하시겠습니까?')) { this.checked = true; } else { this.checked = false; } }">
                자동
                </label>
                </div>
            </span>
            <button type="submit" class="btn btn-default btn-group-justified">로그인</button>
        </div>


        <div class="btn-group btn-group-justified" style="margin-bottom:3px;">
            <a class="btn btn-default" style="border-color: #ffffff;" title="회원가입"
               href="{{ route("register") }}">회원가입</a>
        </div>

    </form>
@endif


<form action="{{route('board',['board'=>'all'])}}" id="cse-search-box" target="_blank" accept-charset="UTF-8">
    <div>
        <input type="text" name="search" size="16" placeholder="검색 내용" style="width:calc(100% - 45px);">
        <input type="submit" value="검색" class="pull-right"> <input name="option" value="tc" type="hidden">
    </div>
</form>

<a href="https://portal.koreatech.ac.kr" alt="KOREATECH LOGO"><img style="margin-top: 10px;"
                                                                   src="/resources/koreatech_banner.gif"
                                                                   class="img-responsive"
                                                                   style="border:none;"></a>


