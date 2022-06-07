@php
    use App\Models\Counter;
    use Illuminate\Support\Facades\Auth;
@endphp
<footer class="footer-wrapper col-sm-offset-2" role="contentinfo" style="margin-top:20px;">
    <div class="container-fluid" id="footer">
        <div class="panel panel-default hidden-sm hidden-md hidden-lg">
            <div class="panel-heading">
                <div>
                    <a class="btn btn-default" data-toggle="collapse" data-target=".navbar-bottom-collapse">정보</a>
                    <div class="btn-group">
                    </div>
                    <a class="btn btn-default pull-right"
                       onclick="$('html, body').animate({scrollTop: 0}, 100);">TOP</a>

                </div>
            </div>
        </div>

        <div class="collapse navbar-collapse navbar-bottom-collapse">
            <a href=""><strong>KO</strong>REATECH <strong>COM</strong>PUTER COMMUNITY <strong>KOCOM</strong></a> |
            <a href="https://github.com/refracta/kocom">GitHub</a> |
            <a href="mailto:refracta@koreatech.ac.kr">관리자: refracta (refracta@koreatech.ac.kr)</a>

            <p></p>

            <ul class="list-inline">
                <li><a href="{{ route("board", ["notice"]) }}"><strong>공지</strong></a></li>
                <span>|</span>
                <li><a href="{{ route("board", ["free"]) }}">자유</a></li>
                <span>|</span>
                <li><a href="{{ route("board", ["quot"]) }}">견적</a></li>
                <span>|</span>
                <li><a href="{{ route("board", ["qna"]) }}">QnA</a></li>
                <span>|</span>
                <li><a href="{{ route("board", ["buy"]) }}">구매</a></li>
                <span>|</span>
                <li><a href="{{ route("board", ["sell"]) }}">판매</a></li>
                <span>|</span>
                <li><a href="{{ route("board", ["school"]) }}">학교</a></li>
                <span>|</span>
                <li><a href="{{ route("board", ["anon"]) }}">익명</a></li>
                <span>|</span>
                <li>오늘 방문자: {{Counter::increaseAndGet()->count}}, 전체 방문자: {{Counter::getFullCount()}}</li>
            </ul>
            @if(Auth::check())
                @php
                    $user = Auth::user();
                @endphp
                <p></p>
                <ul class="list-inline visible-xs visible-sm">
                    <li><strong>{{$user->nickname}} ({{"LV: ".$user->permission}})</strong>, PT: {{$user->point}}</li>
                </ul>
            @endif
        </div>
    </div>
</footer>
