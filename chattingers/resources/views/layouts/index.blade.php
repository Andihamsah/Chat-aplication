<html lang="en">

<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
<meta http-equiv="x-ua-compatible" content="ie=edge">
<title>Material Design Bootstrap</title>
<!-- Font Awesome -->
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.2/css/all.css">
<!-- Bootstrap core CSS -->

<!-- Material Design Bootstrap -->
<link href="{{asset('css/mdb.min.css') }}" media="all" rel="stylesheet" type="text/css" />
<link href="{{asset('css/bootstrap.min.css') }}" media="all" rel="stylesheet" type="text/css" />
</head>

    <body class="fixed-sn white-skin">


    <!--Navbar -->
    <nav class="mb-1 navbar navbar-expand-lg navbar-dark orange lighten-1">
            <a class="navbar-brand" href="#">Navbar</a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent-555"
            aria-controls="navbarSupportedContent-555" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent-555">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item active">
                <a class="nav-link" href="#">Home
                    <span class="sr-only">(current)</span>
                </a>
                </li>
                <li class="nav-item">
                <a class="nav-link" href="#">Features</a>
                </li>
                <li class="nav-item">
                <a class="nav-link" href="#">Pricing</a>
                </li>
            </ul>
            <ul class="navbar-nav ml-auto nav-flex-icons">
                <li class="nav-item avatar">
                <a class="nav-link p-0" href="#">
                    <img src="https://mdbootstrap.com/img/Photos/Avatars/avatar-5.jpg" class="rounded-circle z-depth-0"
                    alt="avatar image" height="35">
                </a>
                </li>
            </ul>
            </div>
        </nav>
        <!--/.Navbar -->

        <section class="user_list">
            <div class="full-list">
                <div class="container">
                    @yield('user-list')
                </div>
            </div>
        </section>

        <section class="chats">
            <div class="full-chat">
                <div class="container">
                    @yield('chats')
                </div>
            </div>
        </section>

        

    <!-- SCRIPTS -->
    <!-- JQuery -->
<script type="text/javascript" src="{{asset('js/jquery-3.4.1.min.js')}}" media="all"></script>
<!-- Bootstrap tooltips -->
<script type="text/javascript" src="{{asset('js/popper.min.js')}}" media="all"></script>
<!-- Bootstrap core JavaScript -->
<script type="text/javascript" src="{{asset('js/bootstrap.min.js')}}" media="all"></script>
<!-- MDB core JavaScript -->
<script type="text/javascript" src="{{asset('js/mdb.min.js')}}" media="all"></script>
<script type="text/javascript" src="{{asset('js/animation.js')}}" media="all"></script>
<script type="text/javascript" src="{{asset('js/documentation.js')}}" media="all"></script>

<!-- css animation -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js" media="all"></script>
<script src="{{asset('css_animation/js/css3-animate-it.js')}}" media="all"></script>


</body>

</html>