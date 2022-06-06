<form class="form-horizontal" method="post" onsubmit="">
    @csrf
    <div class="panel panel-default">
        <div class="panel-heading">
            <div class="col-sm-offset-2"><strong style="color: white">로그인</strong></div>
        </div>
        <div class="panel-body">
            <div class="form-group">
                <label for="mb_id" class="col-sm-2 control-label">아이디(이메일)</label>
                <div class="col-sm-4">
                    <input type="text" name="email" id="email" class="form-control" maxlength="100" minlength="2"
                           size="50" itemname="아이디(이메일)" placeholder="아이디(이메일)">
                </div>
            </div>
            <div class="form-group">
                <label for="mb_password" class="col-sm-2 control-label">비밀번호</label>
                <div class="col-sm-4">
                    <input type="password" name="password" id="password" class="form-control" maxlength="50" size="15"
                           itemname="비밀번호" placeholder="비밀번호">
                </div>
            </div>
            <div class="form-group form-inline">
                <label for="auto_login" class="col-sm-2 control-label">자동 로그인</label>
                <div class="checkbox col-sm-4">
                    <input style="margin-left: 10px" type="checkbox" id="remember_me" name="remember_me"
                           onclick="if (this.checked) { if (confirm('자동 로그인을 사용하면 이 기기에 대해서 서버가 무기한으로 인증 정보를 유지하게 됩니다.\n\n공공장소에서는 사용하지 않을 것을 당부드립니다.\n\n자동 로그인을 활성화하시겠습니까?')) { this.checked = true; } else { this.checked = false; } }">
                </div>
            </div>
            <div class="form-group">
                <div class="col-sm-offset-2 col-sm-10">
                    <input type="submit" accesskey="s" class="btn btn-success" value="로그인">
                    <a href="{{ route('register') }}" class="btn btn-default">회원가입</a>
                </div>
            </div>
        </div>
    </div>
</form>
