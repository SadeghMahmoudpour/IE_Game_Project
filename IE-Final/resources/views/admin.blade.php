<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>profile page</title>

    <link rel="stylesheet" href="../vendor/bootstrap-3.3.7-dist/css/bootstrap.min.css"/>

    <script src="../vendor/jquery-3.1.1.min.js"></script>
    <script src="../vendor/bootstrap-3.3.7-dist/js/bootstrap.min.js"></script>

    <link rel="stylesheet" href="../css/admin.css" type="text/css"/>

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
<div class="col-lg-12 col-sm-12" style="background-color: rgba(214, 224, 226, 0.2); height: 100vh;">
    <div class="content" style="padding-top: 60px; direction: rtl;">
        <h2>بازی‌ها</h2>
        <hr style="border-color: #0f0f0f"/>
        <div class="row">
            <div class="col-sm-6">
                @foreach ($games as $game)
                <input style="outline: none;" @if($game->id == 1) checked @endif type="radio" name="game" id="game-{{
                $game->id }}" class="game" title="{{ $game->title }}" game-id="{{ $game->id }}" abstract="{{
                $game->abstract }}" info='{{ $game->info }}' large_image="{{ $game->large_image }}" small_image="{{
                $game->small_image }}" categories="{{ $game->categories }}">
                <label style="cursor: pointer;" for="game-{{ $game->id }}">{{ $game->title }}</label>
                </input>
                <br/>
                @endforeach
                <button class="btn btn-primary btn-lg" data-toggle="modal" data-target="#newgameModal"
                        style="margin-top: 20px; outline: none;">بازی جدید
                </button>
                <div class="modal fade" id="newgameModal" tabindex="-1" role="dialog"
                     aria-labelledby="exampleModalLabel">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal"
                                        aria-label="Close"><span
                                        aria-hidden="true">&times;</span></button>
                                <h4 class="modal-title" id="exampleModalLabel">بازی جدید</h4>
                            </div>
                            <div class="modal-body" style="background-color: rgba(214, 224, 226, 0.2);">
                                {{ Form::model($games, ['method' => 'PATCH', 'route' => ['admin.update', $admin->id],
                                'id' =>
                                'new-form']) }}
                                {{ Form::hidden('gameId', 'newGame', ['class' => 'form-control', 'id' =>
                                'gameId-newinput', 'required' => 'required' ]) }}
                                <div class="form-group">
                                    {{ Form::label('title-newinput', 'نام بازی:') }}
                                    {{ Form::text('title', '', ['class' => 'form-control', 'id' =>
                                    'title-newinput', 'required' => 'required']) }}
                                    {{ $errors->first('title', '<span
                                        class=error>Unvalid Title</span>') }}
                                </div>
                                <div class="form-group">
                                    {{ Form::label('abstract-newinput', 'توضیح مختصر:') }}
                                    {{ Form::textarea('abstract', '', ['class' => 'form-control',
                                    'id' =>
                                    'abstract-newinput', 'required' => 'required', 'rows' => '4']) }}
                                    {{ $errors->first('abstract', '<span
                                        class=error>Unvalid Abstraact</span>') }}
                                </div>
                                <div class="form-group">
                                    {{ Form::label('info-newinput', 'راهنمای بازی:') }}
                                    {{ Form::textarea('info', '', ['class' => 'form-control', 'id' =>
                                    'info-newinput', 'required' => 'required', 'rows' => '8']) }}
                                    {{ $errors->first('info', '<span
                                        class=error>Unvalid Info</span>') }}
                                </div>
                                <div class="form-group">
                                    {{ Form::label('large_image-newinput', 'عکس بزرگ:') }}
                                    {{ Form::text('large_image', '', ['class' =>
                                    'form-control', 'id' =>
                                    'large_image-newinput', 'required' => 'required']) }}
                                    {{ $errors->first('large_image', '<span
                                        class=error>Unvalid Info</span>') }}
                                </div>
                                <div class="form-group">
                                    {{ Form::label('small_image-newinput', 'عکس کوچک:') }}
                                    {{ Form::text('small_image', '', ['class' =>
                                    'form-control', 'id' =>
                                    'small_image-newinput', 'required' => 'required']) }}
                                    {{ $errors->first('small_image', '<span
                                        class=error>Unvalid Info</span>') }}
                                </div>
                                <div class="form-group">
                                    <label>دسته‌بندی‌:</label><br/>
                                    @foreach ($categories as $category)
                                    <label>{{ Form::checkbox('categories[]', $category->id) }} {{
                                        $category->name }}</label><br/>
                                    @endforeach
                                </div>
                                {{ Form::close() }}
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-default" data-dismiss="modal">بستن</button>
                                <button type="submit" form="new-form" class="btn btn-primary">ثبت بازی
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-6">
                {{ Form::model($games, ['method' => 'PATCH', 'route' => ['admin.update', $admin->id], 'id' =>
                'update-form']) }}
                {{ Form::hidden('gameId', $games->first()->id, ['class' => 'form-control', 'id' =>
                'gameId-input', 'required' => 'required' ]) }}
                <div class="form-group">
                    {{ Form::label('title-input', 'نام بازی:') }}
                    {{ Form::text('title', $games->first()->title, ['class' => 'form-control', 'id' =>
                    'title-input', 'required' => 'required']) }}
                    {{ $errors->first('title', '<span
                        class=error>Unvalid Title</span>') }}
                </div>
                <div class="form-group">
                    {{ Form::label('abstract-input', 'توضیح مختصر:') }}
                    {{ Form::textarea('abstract', $games->first()->abstract, ['class' => 'form-control', 'id' =>
                    'abstract-input', 'required' => 'required', 'rows' => '4']) }}
                    {{ $errors->first('abstract', '<span
                        class=error>Unvalid Abstraact</span>') }}
                </div>
                <div class="form-group">
                    {{ Form::label('info-input', 'راهنمای بازی:') }}
                    {{ Form::textarea('info', $games->first()->info, ['class' => 'form-control', 'id' =>
                    'info-input', 'required' => 'required', 'rows' => '8']) }}
                    {{ $errors->first('info', '<span
                        class=error>Unvalid Info</span>') }}
                </div>
                <div class="form-group">
                    {{ Form::label('large_image-input', 'عکس بزرگ:') }}
                    {{ Form::text('large_image', $games->first()->large_image, ['class' => 'form-control', 'id' =>
                    'large_image-input', 'required' => 'required']) }}
                    {{ $errors->first('large_image', '<span
                        class=error>Unvalid Info</span>') }}
                </div>
                <div class="form-group">
                    {{ Form::label('small_image-input', 'عکس کوچک:') }}
                    {{ Form::text('small_image', $games->first()->small_image, ['class' => 'form-control', 'id' =>
                    'small_image-input', 'required' => 'required']) }}
                    {{ $errors->first('small_image', '<span
                        class=error>Unvalid Info</span>') }}
                </div>
                <div class="form-group">
                    <label>دسته‌بندی‌:</label><br/>
                    @foreach ($categories as $category)
                    <label>{{ Form::checkbox('categories[]', $category->id) }} {{
                        $category->name }}</label><br/>
                    @endforeach
                </div>
                <div class="form-group">
                    {{ Form::submit('بروزرسانی بازی', ['class' => 'btn btn-primary']) }}
                </div>
                {{ Form::close() }}
            </div>
        </div>
    </div>
</div>
<script src="../js/admin.js"></script>
</body>
</html>