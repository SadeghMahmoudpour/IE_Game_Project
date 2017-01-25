<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>game</title>

    <link rel="stylesheet" href="../vendor/bootstrap-3.3.7-dist/css/bootstrap.min.css"/>
    <script src="../vendor/jquery-3.1.1.min.js"></script>
    <script src="../vendor/bootstrap-3.3.7-dist/js/bootstrap.min.js"></script>

    <link rel="stylesheet" href="../vendor/slick-1.6.0/slick/slick.css"/>

    <link rel="stylesheet" href="../css/common.css"/>
    <link rel="stylesheet" href="../css/game_page.css"/>

    <link rel="stylesheet" href="../vendor/bootstrap-star-rating-master/css/star-rating.css" media="all"
          type="text/css"/>
    <link rel="stylesheet" href="../vendor/bootstrap-star-rating-master/themes/krajee-fa/theme.css" media="all"
          type="text/css"/>
    <script src="../js/ajax_loading.js"></script>
    <script>
        window.Laravel = <?php echo json_encode([
            'csrfToken' => csrf_token(),
        ]); ?>
    </script>
</head>
<body>
<nav class="navbar navbar-default navbar-fixed-top">
    <div class="container-fluid content">
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
            <div class="horiz-card row">
                <div class="horiz-card-img col-sm-4">
                    <img/>
                </div>
                <div class="horiz-card-content col-sm-5">
                </div>
                <div class="col-sm-1"></div>
                <div class="col-sm-2">
                    @if(Auth::check())
                    <a class="btn btn-primary" id="start-game">شروع بازی</a>
                    @else
                    <a class="btn btn-primary" id="start-game" href="/login">شروع بازی</a>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
<div class="tabs">
    <ul class="nav nav-tabs nav-justified">
        <li class="active"><a data-toggle="tab" href="#gametab-info">اطلاعات بازی</a></li>
        <li><a data-toggle="tab" href="#gametab-leaderboard">رتبه‌بندی و امتیازات</a></li>
        <li><a data-toggle="tab" href="#gametab-comments">نظرات کاربران</a></li>
        <li><a data-toggle="tab" href="#gametab-related_games">بازی‌های مشابه</a></li>
    </ul>

    <div class="tab-content content">
        <div id="gametab-info" class="tab-pane fade in active">
            <h1>اطلاعات بازی</h1>
            <hr/>
        </div>
        <div id="gametab-leaderboard" class="tab-pane fade">
            <h1>رتبه بندی و امتیازات</h1>
            <hr/>
            <div id="leader-header">
                <div id="second_place" class="vertical_item">
                    <div class="horizontal_item">۲</div>
                    <div class="horizontal_item">
                        <div>
                            <img src=""/>
                            <div class="score_container">
                                <div class="triangle2"></div>
                                <div class="square"></div>
                                <div class="triangle1"></div>
                            </div>
                        </div>
                    </div>
                    <div class="horizontal_item name"></div>
                    <div class="horizontal_item number"></div>
                </div>

                <div id="first_place" class="vertical_item place_hover">
                    <div class="horizontal_item">۱</div>
                    <div class="horizontal_item">
                        <div>
                            <img src="">
                            <div class="score_container">
                                <div class="triangle2"></div>
                                <div class="square"></div>
                                <div class="triangle1"></div>
                            </div>
                        </div>
                    </div>
                    <div class="horizontal_item name"></div>
                    <div class="horizontal_item number"></div>
                </div>
                <div id="third_place" class="vertical_item place_hover">
                    <div class="horizontal_item">۳</div>
                    <div class="horizontal_item">
                        <div>
                            <img src="">
                            <div class="score_container">
                                <div class="triangle2"></div>
                                <div class="square"></div>
                                <div class="triangle1"></div>
                            </div>
                        </div>
                    </div>
                    <div class="horizontal_item name"></div>
                    <div class="horizontal_item number"></div>
                </div>
            </div>
            <table class="table table-striped leader-table">
                <thead>
                <tr>
                    <th>رتبه</th>
                    <th>بازیکن</th>
                    <th>سطح</th>
                    <th>تغییر رتبه</th>
                    <th>امتیاز</th>
                </tr>
                </thead>
                <tbody>
                <!--<tr>-->
                <!--<td>1.<span class="glyphicon glyphicon-star"></span></td>-->
                <!--<td class="player-name"><img src="../assets/clinton3.jpg">wefrgthyjuh,</td>-->
                <!--<td class="number">34</td>-->
                <!--<td class="displacement">34</td>-->
                <!--<td class="number">44</td>-->
                <!--</tr>-->
                </tbody>
            </table>
        </div>
        <div id="gametab-comments" class="tab-pane fade">
            <div class="comments-header row">
                <div class="col-sm-4">
                    <h1>نظرات کاربران</h1>
                </div>
                <div class="col-sm-2">
                    <h3 id="comments-number">۸۴ نظر</h3>
                </div>
                <div class="col-sm-4"></div>
                <div class="col-sm-2">
                    @if(Auth::check())
                    <button class="btn-primary" data-toggle="modal" data-target="#exampleModal">نظر دهید</button>
                    @else
                    <button id="comment-add" class="btn-primary" onclick="window.location='login';">نظر دهید</button>
                    @endif
                </div>
            </div>
            <hr/>
            <table class="table table-striped">
                <tbody>
                </tbody>
            </table>

            <div id="load-more-div">
                <button id="load-more-button" class="btn-primary">بارگذاری نظرات بعدی</button>
            </div>

            <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                    aria-hidden="true">&times;</span></button>
                            <h4 class="modal-title" id="exampleModalLabel">افزودن نظر</h4>
                        </div>
                        <div class="modal-body">
                            <form method="post" action="{{ url('/api/games/add_comment') }}" id="add-comment-form">
                                {{ csrf_field() }}
                                <input type="hidden" name="user_id" value="{{ Auth::id() }}"/>
                                <div class="form-group">
                                    <label for="recipient-name" class="control-label">امتیاز</label>
                                    <input name="rate" type="number" class="form-control" id="recipient-name" min="1"
                                           max="5" step="1">
                                </div>
                                <div class="form-group">
                                    <label for="message-text" class="control-label">نظر:</label>
                                    <input name="text" type="text" class="form-control" id="message-text"
                                           required/>
                                </div>
                            </form>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">بستن</button>
                            <button type="submit" form="add-comment-form" class="btn btn-primary"
                                    id="add-comment-submit-btn">ثبت نظر
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div id="gametab-related_games" class="tab-pane fade">
            <h1>بازی‌های مشابه</h1>
            <hr/>
        </div>
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

<script src="../vendor/bootstrap-star-rating-master/js/star-rating.js"></script>
<script src="../vendor/bootstrap-star-rating-master/themes/krajee-fa/theme.js"></script>
<script src="../vendor/slick-1.6.0/slick/slick.min.js"></script>
<script src="../js/game_page.js"></script>
<!--<script>-->
<!--    $('#add-comment-submit-btn').click(function () {-->
<!--        console.log('click');-->
<!--        var data = {-->
<!--            "game_title": $('#add-comment-game-title').val(),-->
<!--            "user_id": "{{ Auth::id() }}",-->
<!--            "text": $('#message-text').val(),-->
<!--            "rate": $('#recipient-name').val(),-->
<!--        };-->
<!--        console.log(data);-->
<!--        console.log(JSON.stringify(data));-->
<!--        $.ajax({-->
<!--            url: "{{ url('/api/games/add_comment') }}",-->
<!--            dataType: 'json',-->
<!--            type: 'post',-->
<!--            contentType: 'application/json',-->
<!--            data: JSON.stringify( data ),-->
<!--            processData: false,-->
<!--            success: function( data, textStatus, jQxhr ){-->
<!--                console.log(data);-->
<!--//                renderComments(checkXml(result));-->
<!--            }-->
<!--        });-->
<!--    });-->
<!--</script>-->

<div class="ajax-modal"></div>

</body>
</html>