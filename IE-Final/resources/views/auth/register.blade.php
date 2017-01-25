<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">

    <title>ثبت نام</title>
    <meta name="description" content="ثبت نام در سایت">
    <meta name="author" content="9231018">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <script>
        window.Laravel = <?php echo json_encode([
            'csrfToken' => csrf_token(),
        ]); ?>
    </script>

    <link rel="stylesheet" href="../css/hw2-global.css" type="text/css">
    <link rel="stylesheet" href="../css/register.css" type="text/css">
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
                <div class="card_header canter_text">ثبت‌نام</div>
                <div class="card_body">
                    <form class="form-horizontal" role="form" method="POST" action="{{ url('/register') }}">
                        {{ csrf_field() }}
                        <div class="card_form">
                            <input placeholder="نام کاربری من" type="text" name="name" required>
                            <i class="material-icons card_icon">person</i>
                        </div>
                        @if ($errors->has('name'))
                        <span class="help-block">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                        @endif
                        <div class="card_form">
                            <input placeholder="رایانامه" type="email" name="email" required>
                            <i class="material-icons card_icon">email</i>
                        </div>
                        @if ($errors->has('email'))
                        <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                        @endif
                        <div class="card_form">
                            <input placeholder="رمزعبور" type="password" name="password" required>
                            <i class="material-icons card_icon">lock</i>
                        </div>
                        @if ($errors->has('password'))
                        <span class="help-block">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                        @endif
                        <!--                    <div class="card_form">-->
                        <!--                        <input id="accept_rules_ckb" type="checkbox">-->
                        <!--                        <label id="register_rules_label" for="accept_rules_ckb"><a class="underlineLink"-->
                        <!--                                                                                   href="#">قوانین</a> را-->
                        <!--                            می‌پذیرم</label>-->
                        <!--                    </div>-->
                        <div class="canter_text">
                            <button id="login_btn" class="btn" type="submit">ثبت‌نام</button>
                        </div>
                    </form>
                </div>
                <div class="card_footer canter_text">
                    <p>هم‌اکنون حساب کاربری دارید؟ <a class="underlineLink" href="login">ورود</a></p>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>