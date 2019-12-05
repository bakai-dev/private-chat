<!DOCTYPE html>
<html lang="en" >
<head>
    <meta charset="UTF-8">
    <title>Private Chat Laravel Vue Sign in</title>
    <link rel="chat icon" href="{{ asset('favicon.ico') }}" >
    <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=yes"><link rel='stylesheet' href='https://fonts.googleapis.com/css?family=Open+Sans'>

    <link rel="shortcut icon" href="{{ asset('favicon.ico') }}">


    <link href="{{ asset('css/app.css') }}" rel="stylesheet">

</head>
<body>
<!-- partial:index.partial.html -->
<div class="cont">
    <div  style="text-align: left">

        <p class="login__signup">TEST LOGIN 1: <a>test@gmail.com</a></p>
        <p class="login__signup">PASSWORD 1:  &nbsp;<a>test@gmail.com</a></p>
        <br>
        <p class="login__signup">TEST LOGIN 2: <a>test2@gmail.com</a></p>
        <p class="login__signup">PASSWORD 2:  &nbsp;<a>test2@gmail.com</a></p>
    </div>
    <div class="demo">


        <div class="login">

            <div class="login__check"></div>

            <form method="POST" action="{{ route('login') }}">

                @csrf
                <div class="login__form">



                    <div class="login__row">
                        <svg class="login__icon name svg-icon" viewBox="0 0 20 20">
                            <path d="M0,20 a10,8 0 0,1 20,0z M10,0 a4,4 0 0,1 0,8 a4,4 0 0,1 0,-8" />
                        </svg>
                        <input type="text"  name="email" class="login__input name"  placeholder="Username" value="test@gmail.com"/>
                        @error('email')
                        <span class="invalid-feedback login__signup" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                        @enderror
                    </div>
                    <div class="login__row">
                        <svg class="login__icon pass svg-icon" viewBox="0 0 20 20">
                            <path d="M0,20 20,20 20,8 0,8z M10,13 10,16z M4,8 a6,8 0 0,1 12,0" />
                        </svg>
                        <input type="password" name="password" class="login__input pass" placeholder="Password" value="test@gmail.com"/>
                        @error('password')
                        <span class="invalid-feedback login__signup" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                        @enderror
                    </div>

                    <button type="submit" class="login__submit ">Sign in</button>
                    <p  class="login__signup">Don't have an account? &nbsp;<a href="{{ route('register') }}">Sign up</a></p>
                </div>
            </form>

        </div>

        <div class="app">
            <div class="app__top">

            </div>

            <div class="app__logout">
                <svg class="app__logout-icon svg-icon" viewBox="0 0 20 20">
                    <path d="M6,3 a8,8 0 1,0 8,0 M10,0 10,12"/>
                </svg>
            </div>
        </div>


    </div>
</div>
<!-- partial -->
<script src='https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js'></script>

<script>
    $(document).ready(function() {

        var animating = false,
            submitPhase1 = 1100,
            submitPhase2 = 400,
            logoutPhase1 = 800,
            $login = $(".login"),
            $app = $(".app");

        function ripple(elem, e) {
            $(".ripple").remove();
            var elTop = elem.offset().top,
                elLeft = elem.offset().left,
                x = e.pageX - elLeft,
                y = e.pageY - elTop;
            var $ripple = $("<div class='ripple'></div>");
            $ripple.css({top: y, left: x});
            elem.append($ripple);
        };

        $(document).on("click", ".login__submit", function(e) {
            if (animating) return;
            animating = true;
            var that = this;
            ripple($(that), e);
            $(that).addClass("processing");
            setTimeout(function() {
                $(that).addClass("success");
                setTimeout(function() {
                    $app.show();
                    $app.css("top");
                    $app.addClass("active");
                }, submitPhase2 - 70);
                setTimeout(function() {
                    $login.hide();
                    $login.addClass("inactive");
                    animating = false;
                    $(that).removeClass("success processing");
                }, submitPhase2);
            }, submitPhase1);
        });

        $(document).on("click", ".app__logout", function(e) {
            if (animating) return;
            $(".ripple").remove();
            animating = true;
            var that = this;
            $(that).addClass("clicked");
            setTimeout(function() {
                $app.removeClass("active");
                $login.show();
                $login.css("top");
                $login.removeClass("inactive");
            }, logoutPhase1 - 120);
            setTimeout(function() {
                $app.hide();
                animating = false;
                $(that).removeClass("clicked");
            }, logoutPhase1);
        });

    });
</script>
</body>
</html>
