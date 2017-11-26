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
                    <h3 class="panel-title">Register New Nyumba Kumi</h3>
                </div>

                <div class="panel-body">
                    <form method="post" action="{{ route('register') }}" enctype="multipart/form-data" role="form">
                        <fieldset>
                            <div class="form-group">
                                <input class="form-control" placeholder="Phone" name="phone" type="tel" maxlength="14" minlength="7" required>
                            </div>
                            <div class="form-group">
                                <input class="form-control" placeholder="Names" name="names" type="text" required maxlength="30" minlength="5">
                            </div>
                            <div class="form-group">
                                <input class="form-control" placeholder="ID Number" name="idno" type="number" required maxlength="10" minlength="5">
                            </div>
                            <div class="form-group">
                                <label for="proffPic">Select Profile Photo</label>
                                <input id="proffPic" type="file" name="proffPic" class="form-control" accept="image/*" required>
                            </div>
                            <div class="form-group">
                                <input class="form-control" placeholder="Nyumba Kumi Name" name="nyumbaKumiName" type="text" maxlength="30" minlength="5" required>
                            </div>

                            <div class="form-group">
                                <input class="form-control" placeholder="Password" name="password" type="password" value="" maxlength="30" minlength="6" required>
                            </div>
                            <div class="form-group">
                                <input class="form-control" placeholder="Confirm Password" name="passwordCon" type="password" value="" maxlength="30" minlength="6" required>
                            </div>
                            <input type="hidden" name="_token" value="{{ Session::token() }}">
                            <!-- Change this to a button or input when using this as a form -->
                            <button type="submit" class="btn btn-lg btn-primary btn-block">Register</button>
                        </fieldset>
                    </form>
                </div>
                <div class="panel-heading">
                    <a class="panel-title" href="{{ route('loginPage') }}">Login</a>
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
