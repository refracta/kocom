<form class="form-horizontal" role="form" method="post" action="{{route('register')}}">
    @csrf
    <div class="panel panel-default">
        <div class="panel-heading"><h4><strong style="color: white">회원가입</strong></h4>
        </div>
        @if ($errors->any())
            <center><p style="margin-top: 5px; color: red;">회원가입 오류입니다. 명시된 조건을 다시 한번 확인해주세요.</p></center>
        @endif
        <div class="panel-body">
            <div class="form-group">
                <label for="email" class="col-sm-2 control-label">아이디(이메일)</label>
                <div class="col-sm-6">
                    <input type="email" class="form-control" placeholder="아이디(이메일)" maxlength="100" id="email" name="email"
                           required="" style="ime-mode:disabled">
                    <p class="help-block">아이디로 사용할 이메일을 입력해주세요.</p>
                </div>
            </div>

            <div class="form-group">
                <label for="password" class="col-sm-2 control-label">비밀번호</label>
                <div class="col-sm-6">
                    <input class="form-control" type="password" name="password" id="password"
                           style="ime-mode:disabled" maxlength="50" required="" itemname="비밀번호"
                           placeholder="비밀번호" aria-autocomplete="list">
                </div>
            </div>

            <div class="form-group">
                <label for="password_confirmation" class="col-sm-2 control-label">비밀번호 확인</label>
                <div class="col-sm-6">
                    <input class="form-control" type="password" name="password_confirmation" style="ime-mode:disabled"
                           maxlength="50" required="" itemname="비밀번호 확인" placeholder="비밀번호를 한번 더 입력">
                    <p class="help-block">비밀번호는 8자 이상의 영문, 숫자, 특수기호로 구성되어야 합니다.</p>
                </div>
            </div>

            <div class="form-group">
                <label for="name" class="col-sm-2 control-label">이름</label>
                <div class="col-sm-6">
                    <input class="form-control" type="text" id="name" name="name" required="" maxlength="50" value=""
                           placeholder="이름">
                </div>
            </div>

            <div class="form-group">
                <label for="nickname" class="col-sm-2 control-label">닉네임</label>
                <div class="col-sm-6">
                    <input class="form-control" type="text" id="nickname" name="nickname" required="" maxlength="50"
                           value="" placeholder="닉네임">
                    <p class="help-block">게시판에 표시되는 별명입니다.</p>
                </div>
            </div>
        </div>
        <div class="panel-footer">
            <div style="text-align:center">
                <button class="btn btn-success">가 입</button>
            </div>
        </div>
    </div>
</form>


