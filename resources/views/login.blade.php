<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nyumba Kumi Admin Portal</title>
    <!-- Core CSS - Include with every page -->
    <link href="{{ URL::asset('assets/plugins/bootstrap/bootstrap.css') }}" rel="stylesheet" />
    <link href="{{ URL::asset('assets/font-awesome/css/font-awesome.css') }}" rel="stylesheet" />
    <link href="{{ URL::asset('assets/plugins/pace/pace-theme-big-counter.css') }}" rel="stylesheet" />
    <link href="{{ URL::asset('assets/css/style.css') }}" rel="stylesheet" />
    <link href="{{ URL::asset('assets/css/main-style.css') }}" rel="stylesheet" />

</head>

<body class="body-Login-back">

<div class="container">

    <div class="row">
        <div class="col-md-4 col-md-offset-4 text-center logo-margin ">
            <img src="{{ URL::asset('assets/img/logo.png') }}" width="200" alt=""/>
            <br><br>
            @if(Session::has('message'))
                <div class="alert alert-{{ Session::get('bg') }}">
                    {{ Session::get('message') }}
                </div>
            @endif
        </div>
        <div class="col-md-4 col-md-offset-4">
            <div class="login-panel panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">Please Sign In</h3>
                </div>
                <div class="panel-body">
                    <form method="post" action="{{ route('login') }}" role="form">
                        <fieldset>
                            <div class="form-group">
                                <input class="form-control" placeholder="Phone" name="phone" type="tel" autofocus>
                            </div>
                            <div class="form-group">
                                <input class="form-control" placeholder="Password" name="password" type="password" value="">
                            </div>
                            <!-- Change this to a button or input when using this as a form -->
                            <input type="hidden" name="_token" value="{{ Session::token() }}">
                            <input type="submit" class="btn btn-lg btn-success btn-block" value="Login">
                        </fieldset>
                    </form>
                </div>
                <div class="panel-heading">
                    <a class="panel-title" href="{{ route('registerPage') }}">Register New Nyumba Kumi Group</a>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Core Scripts - Include with every page -->
<script src="{{ URL::asset('assets/plugins/jquery-1.10.2.js') }}"></script>
<script src="{{ URL::asset('assets/plugins/bootstrap/bootstrap.min.js') }}"></script>
<script src="{{ URL::asset('assets/plugins/metisMenu/jquery.metisMenu.js') }}"></script>

</body>

</html>
