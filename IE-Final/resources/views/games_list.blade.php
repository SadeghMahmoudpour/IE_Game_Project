<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>games list</title>

    <link rel="stylesheet" href="vendor/bootstrap-3.3.7-dist/css/bootstrap.min.css"/>

    <script src="vendor/jquery-3.1.1.min.js"></script>
    <script src="vendor/bootstrap-3.3.7-dist/js/bootstrap.min.js"></script>

    <link rel="stylesheet" href="css/common.css" type="text/css"/>
    <link rel="stylesheet" href="css/games_list.css" type="text/css"/>

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
    <div class="container-fluid content" style="min-height: 58px;">
        <div class="navbar-header navbar-right">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand navbar-right" href="/"><i class="fa fa-gamepad" aria-hidden="true"></i>
                امیرکبیر <span class="blue-color"> استودیو</span></a>
        </div>
        <div class="collapse navbar-collapse" id="myNavbar">
            <ul class="nav navbar-nav navbar-left">
                @if(Auth::check())
                <form id="logout-form" class="navbar-nav nav" action="{{ url('/logout') }}" method="POST">
                    {{ csrf_field() }}
                    <li><a onclick="document.getElementById('logout-form').submit();" style="cursor: pointer;">خروج</a>
                    </li>
                </form>
                <li><a href="/profile/{{ Auth::id() }}"><span class="glyphicon glyphicon-user"></span></a></li>
                @else
                <li><a href="login">ورود</a></li>
                @endif
                <li>
                    <div id="imaginary_container">
                        <div class="input-group stylish-input-group">
                                    <span class="input-group-addon">
                        <button id="search-button" type="submit">
                            <span class="glyphicon glyphicon-search"></span>
                        </button>
                    </span>
                            <input type="text" id="search-input" class="form-control" placeholder="جست و جو ..."/>
                        </div>
                    </div>

                </li>
            </ul>
        </div>
    </div>
</nav>
<div class="header">
    <div id="header-img-container"></div>
    <div id="header-caption">
        <div class="content">
        </div>
    </div>
</div>

<div class="games-list content">
    <div id="filters">
        <div class="jumbotron">
            <h3>دسته‌بندی بازی‌ها</h3>
            <div id="category-filters">

            </div>
        </div>
        <div class="jumbotron">
            <h3>امتیاز بازی‌ها</h3>
            <div id="star-filters">
                <div class="filter-input" value="5" type="rate-filter">
                    <input type="text" class="kv-fa-star rating-loading filter-stars"
                           value="5" dir="rtl"
                           data-size="xs" title="">
                </div>
                <div class="filter-input" value="4" type="rate-filter">
                    <input type="text" class="kv-fa-star rating-loading filter-stars"
                           value="4" dir="rtl"
                           data-size="xs" title="">
                </div>
                <div class="filter-input" value="3" type="rate-filter">
                    <input type="text" class="kv-fa-star rating-loading filter-stars"
                           value="3" dir="rtl"
                           data-size="xs" title="">
                </div>
                <div class="filter-input" value="2" type="rate-filter">
                    <input type="text" class="kv-fa-star rating-loading filter-stars"
                           value="2" dir="rtl"
                           data-size="xs" title="">
                </div>
                <div class="filter-input" value="1" type="rate-filter">
                    <input type="text" class="kv-fa-star rating-loading filter-stars"
                           value="1" dir="rtl"
                           data-size="xs" title="">
                </div>
                <div class="filter-input" value="0" type="rate-filter">
                    <input type="text" class="kv-fa-star rating-loading  filter-stars"
                           value="0" dir="rtl"
                           data-size="xs" title="">
                </div>
            </div>
        </div>
    </div>
    <div id="search-games">
    </div>
</div>

<div class="footer">
    <div class="footer-content">
        <div class="row">
            <a class="footer-logo col-sm-2" href="/"><i class="fa fa-gamepad" aria-hidden="true"></i>
                امیرکبیر <span class="blue-color"> استودیو</span></a>
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
<script src="js/games_list.js"></script>

<div class="ajax-modal"></div>

</body>
</html>