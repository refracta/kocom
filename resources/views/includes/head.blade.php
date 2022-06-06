<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no, maximum-scale=1">

<meta name="author" content="refracta">
<meta name="keywords" content="kocom kocom.abstr.net 코컴">
<meta name="description" content="한국기술교육대학교의 컴퓨터 커뮤니티">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta http-equiv="Imagetoolbar" content="no">

<title>KOCOM, {{ $title }}</title>

<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

<link rel="stylesheet" href="{{ asset('resources/css/style.css') }}" type="text/css">
<link href="{{ asset('resources/favicon.ico') }}" rel="shortcut icon">

@if(Session::has('errors'))
    <script type="text/javascript">
        alert("{{Session::get('errors')->first()}}")
    </script>
@endif
