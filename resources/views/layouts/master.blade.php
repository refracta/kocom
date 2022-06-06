<!DOCTYPE html>
<html lang="ko">
<head>
    @include('includes.head', ['title'=> $title])
</head>
<body>
    @include('includes.header')

    <div role="main" class="container-fluid">
        <div role="main" class="container-fluid">
            <div class="row">
                <div class="hidden-xs hidden-sm col-md-2 col-lg-2">
                    @include('includes.left')
                </div>

                <div class="col-xs-12 col-sm-12 col-md-10 col-lg-10" id="main_content">
                    @yield('content')
                </div>
        </div>

    </div>

    @include('includes.updown')

    @include('includes.footer')
</body>
</html>
