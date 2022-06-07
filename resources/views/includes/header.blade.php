<header class="header-wrapper">
    <div class="container-fluid">
        <div class="row" style="margin-top:6px;margin-bottom:5px;min-height: 60px">
            <div class="navbar-header pull-left" style="float:left">
                <a class="navbar-brand hidden-xs hidden-sm hidden-md" href="{{ route("root") }}"
                   style="border:0;margin-top:-15px;margin-left:-10px;">
                    <img src="/resources/kocom_logo_large.png" alt="KOCOM, 한기대 컴퓨터 커뮤니티"
                         style="width:200px;height:60px;margin-top:5px;margin-bottom: 5px;"> </a>
                <div class="navbar-brand visible-xs visible-sm visible-md"
                     style="margin-top:-5px;margin-bottom:15px;float:left;">
                    <a href="{{ route("root") }}" style="border:0;">
                        <img src="/resources/kocom_logo_small.png" alt="KOCOM, 한기대 컴퓨터 커뮤니티" style="height:50px;"> </a>
                </div>
            </div>

        </div>
        <div class="navbar navbar-default" role="navigation">
            <nav class="navbar main-navbar">
                <div class="container-fluid">
                    <div class="navbar-header">
                        <button type="button" class="navbar-toggle collapsed" data-toggle="collapse"
                                data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
                            <span class="sr-only">Toggle navigation</span> <span class="icon-bar"></span>
                            <span class="icon-bar"></span> <span class="icon-bar"></span>
                        </button>
                    </div>

                    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                        <ul class="nav navbar-nav">
                            <li id="notice"><a href="{{ route("board", ["notice"]) }}">공지</a></li>
                            <li id="free"><a href="{{ route("board", ["free"]) }}">자유</a></li>
                            <li id="quot"><a href="{{ route("board", ["quot"]) }}">견적</a></li>
                            <li id="qna"><a href="{{ route("board", ["qna"]) }}">QnA</a></li>
                            <li id="buy"><a href="{{ route("board", ["buy"]) }}">구매</a></li>
                            <li id="sell"><a href="{{ route("board", ["sell"]) }}">판매</a></li>
                            <li id="school"><a href="{{ route("board", ["school"]) }}">학교</a></li>
                            {{--                            <li id="unreg"><a href="{{ route("board", ["unreg"]) }}">비회원</a></li>--}}
                            <li id="anon"><a href="{{ route("board", ["anon"]) }}">익명</a></li>
                            {{--                            <li id="deep"><a href="#">출석</a></li>--}}
                            <li class="dropdown">
                                <a class="dropdown-toggle hidden-xs hidden-sm" href="#"
                                   data-toggle="dropdown">기타<b class="caret"></b></a>
                                <ul class="dropdown-menu">
                                    <li id="dog">
                                        <a href="{{ route("board", ["dog"]) }}">강아지 게시판</a>
                                    </li>
                                    <li id="cat">
                                        <a href="{{ route("board", ["cat"]) }}">고양이 게시판</a>
                                    </li>
                                </ul>
                            </li>
                        </ul>

                        <ul class="nav navbar-nav navbar-right">
                            <li class="dropdown">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button"
                                   aria-haspopup="true" aria-expanded="false">문의<span class="caret"></span></a>
                                <ul class="dropdown-menu">
                                    <li id="inquiry"><a href="{{ route("board", ["inquiry"]) }}">문의</a></li>
                                    <li id="map"><a href="{{route('map')}}">찾아 오시는 길</a></li>
                                </ul>
                            </li>
                        </ul>
                    </div>
                </div>
            </nav>
        </div>
    </div>
</header>
