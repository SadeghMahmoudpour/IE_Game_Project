<?php
Session::set('backUrl', URL::previous());
?>
<!DOCTYPE html>
<html lang="fa">
<head>
    <meta charset="utf-8">

    <title>ورود</title>
    <meta name="description" content="ورود به سایت">
    <meta name="author" content="9231018">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <script>
        window.Laravel = <?php echo json_encode([
            'csrfToken' => csrf_token(),
        ]); ?>
    </script>

    <link rel="stylesheet" href="../css/hw2-global.css" type="text/css">
    <link rel="stylesheet" href="../css/login.css" type="text/css">
    <link href="{{ captcha_layout_stylesheet_url() }}" type="text/css" rel="stylesheet">
</head>
<body>
<header class="site_header">
    <div class="header_wrap">
<!--        <span class="header_image"><i class="material-icons md-light md-48">person</i></span>-->
        <div class="header_widget">
            <ul class="menu">
                <li class="menu_item">
                    <a href="/">امیرکبیر <span style="color: #337ab7;">استودیو</span> <i class="fa fa-gamepad" aria-hidden="true"></i></a>
                </li>
            </ul>
        </div>
    </div>
</header>
<div class="site_inner">
    <div class="card_outer">
        <div class="card_miidle">
            <div class="card_inner">
                <div class="card_header canter_text">ورود</div>
                <div class="card_body">
                    <form method="POST" action="{{ url('/login') }}">
                        {{ csrf_field() }}
                        <div class="card_form">
                            <input id="login_mail_input" placeholder="ایمیل یا شماره تلفن" type="email" name="email"
                                   required>
                            <i class="material-icons card_icon">email</i>
                        </div>
                        @if ($errors->has('email'))
                        <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                        @endif
                        <div class="card_form">
                            <input placeholder="رمز عبور" type="password" name="password" required>
                            <i class="material-icons card_icon">lock</i>
                        </div>
                        @if ($errors->has('password'))
                        <span class="help-block">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                        @endif

                        <div class="card_form">
                            {!! captcha_image_html('LoginCaptcha') !!}
                            <input type="text" class="form-control" name="CaptchaCode" id="CaptchaCode" required>
                        </div>
                        @if ($errors->has('CaptchaCode'))
                        <span class="help-block">
                    <strong>{{ $errors->first('CaptchaCode') }}</strong>
                  </span>
                        @endif

                        <div class="card_form">
                            <input id="accept_rules_ckb" type="checkbox" name="remember" {{ old('remember') ? 'checked'
                            : ''}}>
                            <label id="register_rules_label" for="accept_rules_ckb">مرا بخاطر بسپار</label>
                        </div>
                        <div class="canter_text">
                            <button id="login_btn" class="btn" type="submit">ورود</button>
                        </div>
                        <!--                        <div class="canter_text">-->
                        <!--                            <a class="underlineLink" href="{{ url('/password/reset') }}">رمزمو یادم رفته</a>-->
                        <!--                        </div>-->
                    </form>
                </div>
                <div class="card_footer canter_text">
                    <p>حساب کاربری ندارید؟ <a class="underlineLink" href="register">ثبت‌نام کنید</a></p>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>