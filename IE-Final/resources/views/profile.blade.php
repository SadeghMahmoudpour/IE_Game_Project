<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>profile page</title>

    <link rel="stylesheet" href="../vendor/bootstrap-3.3.7-dist/css/bootstrap.min.css"/>

    <script src="../vendor/jquery-3.1.1.min.js"></script>
    <script src="../vendor/bootstrap-3.3.7-dist/js/bootstrap.min.js"></script>

    <link rel="stylesheet" href="../css/profile.css" type="text/css"/>

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
            <a class="navbar-brand navbar-right" href="/">
                امیرکبیر <span style="color: #337ab7;"> استودیو</span> <i class="fa fa-gamepad" aria-hidden="true"></i></a>
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
                <li><a href="/login">ورود</a></li>
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
<div class="col-lg-12 col-sm-12">
    <div class="card hovercard">
        @if ($user)
        <div class="card-background">
            <img class="card-bkimg" alt=""
                 src="http://localhost:8000/images/images/call-of-duty-ghosts-pc-screenshot-1920x1080-005.jpg">
            <!-- http://lorempixel.com/850/280/people/9/ -->
        </div>
        <div class="useravatar">
            <img alt="" src="{{ $user->avatar }}">
        </div>
        <div class="card-info">
            <span class="card-title">{{ $user->name }}</span>

        </div>
        @else
        <p>User Not Found</p>
        @endif
    </div>
    @if ($user)
    <div class="btn-pref btn-group btn-group-justified btn-group-lg" role="group" aria-label="...">
        @if(Auth::check() && Auth::id() == $user->id)
        <div class="btn-group" role="group">
            <button type="button" id="password" class="btn btn-default" href="#tab3" data-toggle="tab"><span
                    class="glyphicon glyphicon-star" aria-hidden="true"></span>
                <div class="hidden-xs">تغییر رمزعبور</div>
            </button>
        </div>
        @endif

        <div class="btn-group" role="group">
            <button type="button" id="categories" class="btn btn-default" href="#tab2" data-toggle="tab"><span
                    class="glyphicon glyphicon-heart" aria-hidden="true"></span>
                <div class="hidden-xs">دسته‌بندی‌های مورد‌علاقه</div>
            </button>
        </div>

        <div class="btn-group" role="group">
            <button type="button" id="personal-information" class="btn btn-primary" href="#tab1" data-toggle="tab"><span
                    class="glyphicon glyphicon-user" aria-hidden="true"></span>
                <div class="hidden-xs">اطلاعات شخصی</div>
            </button>
        </div>
    </div>

    <div class="well">
        <div class="tab-content content">
            <div class="tab-pane fade in active" id="tab1">
                <h2>{{ $user->name }}</h2>
                <hr style="border-color: #0f0f0f"/>
                <div class="row">
                    <div class="col-sm-6">
                        <h3>پست الکترونیکی: {{ $user->email }}</h3>
                        <p>
                            <a href="mailto:{{ $user->email }}" class="btn btn-info btn-lg">
                                <span class="glyphicon glyphicon-envelope"></span> ارسال ایمیل
                            </a>
                        </p>
                    </div>
                    @if (Auth::check() && Auth::id() == $user->id)
                    <div class="col-sm-3">
                        <button class="btn btn-primary btn-lg" data-toggle="modal" data-target="#uesrnameModal"
                                style="margin-top: 20px; outline: none;">تغییر اطلاعات کاربری
                        </button>
                        <div class="modal fade" id="uesrnameModal" tabindex="-1" role="dialog"
                             aria-labelledby="exampleModalLabel">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal"
                                                aria-label="Close"><span
                                                aria-hidden="true">&times;</span></button>
                                        <h4 class="modal-title" id="exampleModalLabel">تغییر اطلاعات کاربری</h4>
                                    </div>
                                    <div class="modal-body">
                                        {{ Form::model($user, ['method' => 'PATCH', 'route' => ['profile.update',
                                        $user->id], 'id' => 'userinfo-form']) }}
                                        <!-- Location Field -->
                                        <div class="form-group">
                                            {{ Form::label('username-input', 'نام‌کاربری:') }}
                                            {{ Form::text('name', $user->name, ['class' => 'form-control', 'id' =>
                                            'username-input', 'required' => 'required']) }}
                                            {{ $errors->first('username-input', '<span
                                                class=error>Unvalid Username</span>') }}
                                        </div>
                                        <div class="form-group">
                                            {{ Form::label('email-input', 'پست الکترونیکی:') }}
                                            {{ Form::email('email', $user->email, ['class' => 'form-control', 'id' =>
                                            'email-input']) }}
                                            {{ $errors->first('email-input', '<span class=error>Unvalid Email</span>')
                                            }}
                                        </div>
                                        <div class="form-group">
                                            {{ Form::label('avatar-input', 'تصویر پروفایل:') }}
                                            {{ Form::text('avatar', $user->avatar, ['class' => 'form-control', 'id' =>
                                            'avatar-input']) }}
                                            {{ $errors->first('avatar-input', '<span
                                                class=error>Unvalid Avatar URL</span>') }}
                                        </div>
                                        {{ Form::close() }}
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-default" data-dismiss="modal">بستن</button>
                                        <button type="submit" form="userinfo-form" class="btn btn-primary">ثبت اطلاعات
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
            <div class="tab-pane fade in" id="tab2">
                @if(Auth::check() && Auth::id() == $user->id)
                <h2>دسته‌بندی‌های مورد‌علاقه شما</h2>
                @else
                <h2>دسته‌بندی‌های مورد‌علاقه {{ $user->name }}</h2>
                @endif
                <hr style="border-color: #0f0f0f"/>
                <div class="row">
                    <div class="col-sm-6">
                        @foreach ($usercategories as $category)
                        <h4>{{ $category->name }}</h4>
                        @endforeach
                    </div>
                    @if (Auth::check() && Auth::id() == $user->id)
                    <div class="col-sm-3">
                        <button class="btn btn-primary btn-lg" data-toggle="modal" data-target="#usercategoriesModal"
                                style="margin-top: 20px; outline: none;">بروزرسانی دسته‌بندی‌ها
                        </button>
                        <div class="modal fade" id="usercategoriesModal" tabindex="-1" role="dialog"
                             aria-labelledby="exampleModalLabel">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal"
                                                aria-label="Close"><span
                                                aria-hidden="true">&times;</span></button>
                                        <h4 class="modal-title" id="exampleModalLabel">بروزرسانی دسته‌بندی‌ها</h4>
                                    </div>
                                    <div class="modal-body">
                                        {!! Form::open(['url' => '/profile/categorisation', 'id' => 'usercats-form'])
                                        !!}
                                        <!-- Location Field -->
                                        <div class="form-group">
                                            @foreach ($categories as $category)
                                            <label>{{ Form::checkbox('categories[]', $category->id) }} {{
                                                $category->name }}</label><br/>
                                            @endforeach
                                        </div>
                                        {!! Form::close() !!}
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-default" data-dismiss="modal">بستن</button>
                                        <button type="submit" form="usercats-form" class="btn btn-primary">ثبت اطلاعات
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
            @if(Auth::check() && Auth::id() == $user->id)
            <div class="tab-pane fade in" id="tab3">
                <h2>تغییر رمزعبور</h2>
                <hr style="border-color: #0f0f0f"/>
                <div class="col-sm-4">
                    {!! Form::open(['url' => '/profile/changepassword'])!!}
                    <div class="form-group">
                        {{ Form::label('old_password', 'رمزعبور فعلی:') }}
                        {!! Form::password('old_password', ['class'=>'form-control', 'id' => 'old_password']) !!}
                    </div>
                    <div class="form-group">
                        {{ Form::label('password-input', 'رمزعبور جدید:') }}
                        {!! Form::password('password', ['class'=>'form-control', 'id' => 'password-input']) !!}
                    </div>
                    <div class="form-group">
                        {{ Form::submit('تغییر رمزعبور', ['class' => 'btn btn-primary']) }}
                    </div>
                    {!! Form::close() !!}
                </div>
            </div>
            @endif
        </div>
    </div>
    @endif
</div>
<script src="../js/profile.js"></script>
</body>
</html>