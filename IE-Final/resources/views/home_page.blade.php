<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>home</title>

    <link rel="stylesheet" href="vendor/bootstrap-3.3.7-dist/css/bootstrap.min.css"/>
    <script src="vendor/jquery-3.1.1.min.js"></script>
    <script src="vendor/bootstrap-3.3.7-dist/js/bootstrap.min.js"></script>

    <link rel="stylesheet" href="vendor/slick-1.6.0/slick/slick.css"/>

    <link rel="stylesheet" href="css/common.css"/>
    <link rel="stylesheet" href="css/home_page.css"/>

    <link rel="stylesheet" href="vendor/bootstrap-star-rating-master/css/star-rating.css" media="all"
          type="text/css"/>
    <link rel="stylesheet" href="vendor/bootstrap-star-rating-master/themes/krajee-fa/theme.css" media="all"
          type="text/css"/>
    <script src="js/ajax_loading.js"></script>
    <script>
        window.Laravel = <?php echo json_encode([
            'csrfToken' => csrf_token(),
        ]); ?>
    </script>
</head>
<body>
<nav class="navbar navbar-default navbar-fixed-top">
    <div class="container-fluid">
        <div class="navbar-header navbar-right">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand navbar-right" href="#">امیرکبیر <span class="blue-color"> استودیو</span> <i
                    class="fa fa-gamepad" aria-hidden="true"></i></a>
        </div>
        <div class="collapse navbar-collapse" id="myNavbar">
            <ul class="nav navbar-nav navbar-left">
                @if(Auth::check())
                <form id="logout-form" class="navbar-nav nav" action="{{ url('/logout') }}" method="POST">
                    {{ csrf_field() }}
                    <li><a onclick="document.getElementById('logout-form').submit();" style="cursor: pointer;">خروج</a></li>
                </form>
                <li><a href="/profile/{{ Auth::id() }}"><span class="glyphicon glyphicon-user"></span></a></li>
                @else
                <li><a id="register-link" href="register">ثبت نام</a></li>
                <li><a href="login">ورود</a></li>
                @endif
            </ul>
        </div>
    </div>
</nav>

<div id="home-carousel" class="carousel slide <!--carousel-fade-->" data-ride="carousel" data-interval="false"
     data-pause="false">
    <div class="carousel-inner" role="listbox">
    </div>
</div>

<div id="home-slick-slider" class="slick-autoplay">
</div>

<div class="home-content">
    <div id="home-new-games" class="new-games">
        <h3>جدیدترین بازی‌ها</h3>
        <div id="new-games-slider">

            <!--<div class="slick-item game-card"><img src="images/images/T2dGRk.jpg" alt="New York"></div>-->
            <!--<div class="slick-item game-card"><img-->
            <!--src="images/images/Assassins-Creed-3-pc-game-free-download.jpg"-->
            <!--alt="Chicago"></div>-->
            <!--<div class="slick-item game-card"><img-->
            <!--src="images/images/marco_reus_fifa_17-1920x1080-1024x576.jpg"-->
            <!--alt="Los Angeles"></div>-->
            <!--<div class="slick-item game-card"><img src="images/images/HaaEipp.jpg" alt="New York"></div>-->
            <!--<div class="slick-item game-card"><img src="images/images/JgWyefg.jpg" alt="Chicago"></div>-->
            <!--<div class="slick-item game-card"><img src="images/images/image_2.img.jpg" alt="Los Angeles">-->
            <!--</div>-->
            <!--<div class="slick-item game-card"><img src="images/images/thmub.jpg" alt="New York"></div>-->
            <!--<div class="slick-item game-card"><img src="images/images/call-of-duty-background-17.jpg"-->
            <!--alt="New York"></div>-->
            <!--<div class="slick-item game-card"><img src="images/images/The-Witcher-3-Wild-Hunt.jpg"-->
            <!--alt="New York"></div>-->
        </div>
    </div>

    <div id="comments-tutors">
        <div class="cgcontent">
            <h2>نظرات کاربران و راهنمای بازی‌ها</h2>
            <hr/>
            <div class="row">
                <div id="tutors" class="col-sm-5">
                    <h3>آخرین راهنماهای بازی‌ها</h3>
                    <!--<div class="horiz-card row">-->
                    <!--<div class="horiz-card-img col-sm-2">-->
                    <!--<img src="images/images/call-of-duty-background-17.jpg"/>-->
                    <!--</div>-->
                    <!--<div class="horiz-card-content col-sm-8">-->
                    <!--<h4>راهنمای بازی</h4>-->
                    <!--<h5>دوشنبه</h5>-->
                    <!--</div>-->
                    <!--</div>-->
                </div>
                <div class="col-sm-2"></div>
                <div id="comments" class="col-sm-5">
                    <h3>نظرات و گفت‌و‌گو‌ها</h3>
                    <!--<div class="horiz-card row">-->
                    <!--<div class="horiz-card-img col-sm-2">-->
                    <!--<img src="images/images/call-of-duty-background-17.jpg"/>-->
                    <!--</div>-->
                    <!--<div class="horiz-card-content col-sm-8">-->
                    <!--<h4>راهنمای بازی</h4>-->
                    <!--<h5>دوشنبه</h5>-->
                    <!--</div>-->
                    <!--</div>-->
                </div>
            </div>
        </div>
    </div>

    <div id="join-us">
        <div id="join-us-img-container"></div>
        <div id="join-us-caption">
            <div id="join-amirkabir">به جامعه بازی سازان امیرکبیر بپیوندید</div>
            <div id="join-num">بیش از ۵۰۰۰ عضو از سرتاسر کشور</div>
            <button class="btn-default">به ما بپیوندید</button>
        </div>
    </div>
</div>

<div class="footer">
    <div class="footer-content">
        <div class="row">
            <a class="footer-logo col-sm-2"><i class="fa fa-gamepad" aria-hidden="true"></i> امیرکبیر <span
                    class="blue-color"> استودیو</span></a>
            <div class="col-sm-2"></div>
            <div class="footer-links col-sm-8">
                <a href="#">صفحه اصلی</a>
                <a href="#">درباره ما</a>
                <a href="#">ارتباط با سازندگان</a>
                <a href="#">سوالات متداول</a>
                <a href="#">حریم خصوصی</a>
            </div>
        </div>
        <div class="footer-share">
            <a href="#" target="_blank" class="btn-social btn-facebook"><i class="fa fa-facebook"></i></a>
            <a href="#" target="_blank" class="btn-social btn-twitter"><i class="fa fa-twitter"></i></a>
            <a href="#" target="_blank" class="btn-social btn-instagram"><i class="fa fa-instagram"></i></a>
        </div>
    </div>
</div>

<div class="site-rights">
    <h3>تمامی حقوق محفوظ و متعلق به دانشگاه امیرکبیر است</h3>
</div>

<script src="vendor/bootstrap-star-rating-master/js/star-rating.js"></script>
<script src="vendor/bootstrap-star-rating-master/themes/krajee-fa/theme.js"></script>
<script src="vendor/slick-1.6.0/slick/slick.min.js"></script>
<script src="js/home_page.js"></script>

<div class="ajax-modal"></div>

</body>
</html>