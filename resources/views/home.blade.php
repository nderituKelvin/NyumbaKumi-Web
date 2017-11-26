<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Portal</title>
    <!-- Core CSS - Include with every page -->
    <link href="{{ URL::asset('assets/plugins/bootstrap/bootstrap.css') }}" rel="stylesheet" />
    <link href="{{ URL::asset('assets/font-awesome/css/font-awesome.css') }}" rel="stylesheet" />
    <link href="{{ URL::asset('assets/plugins/pace/pace-theme-big-counter.css') }}" rel="stylesheet" />
    <link href="{{ URL::asset('assets/css/style.css') }}" rel="stylesheet" />
    <link href="{{ URL::asset('assets/css/main-style.css') }}" rel="stylesheet" />
    <!-- Page-Level CSS -->
    <link href="{{ URL::asset('assets/plugins/morris/morris-0.4.3.min.css') }}" rel="stylesheet" />
    <link href="{{ URL::asset('assets/plugins/dataTables/dataTables.bootstrap.css') }}" rel="stylesheet" />
</head>
<body>
<!--  wrapper -->
<div id="wrapper">
    <!-- navbar top -->


    <nav class="navbar navbar-default navbar-fixed-top" role="navigation" id="navbar">
        <!-- navbar-header -->
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".sidebar-collapse">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="{{ route('home') }}">
                <img src="{{ URL::asset('assets/img/logo.png') }}" alt="" />
            </a>
        </div>
        <!-- end navbar-header -->
        <!-- navbar-top-links -->
        <ul class="nav navbar-top-links navbar-right">
            <!-- main dropdown -->

            <li class="dropdown">
                <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                    <i class="fa fa-user fa-3x"></i>
                </a>
                <!-- dropdown user-->
                <ul class="dropdown-menu dropdown-user">
                    <li>
                        <a href="{{ route('logout') }}">
                            <i class="fa fa-sign-out fa-fw"></i>
                            Logout
                        </a>
                    </li>
                    <li class="divider"></li>
                    <li>
                        <a href="">
                            <i class="fa fa-trash-o">
                                Delete This Group
                            </i>
                        </a>
                    </li>
                </ul>
            </li>
        </ul>
    </nav>




    <nav class="navbar-default navbar-static-side" role="navigation">
        <!-- sidebar-collapse -->
        <div class="sidebar-collapse">
            <!-- side-menu -->
            <ul class="nav" id="side-menu">
                <li>
                    <!-- user image section-->
                    <div class="user-section">
                        <div class="user-info">
                            <div><strong>{{ $user -> names }}</strong><br><small><i>({{ \App\Group::where('id', $user->group)->first()->name }})</i></small></div>
                        </div>
                    </div>
                    <!--end user image section-->
                </li>
                <li class="">
                    <a href="{{ route('home') }}"><i class="fa fa-list fa-fw"></i>Chats</a>
                </li>
                <li class="">
                    <a data-toggle="modal" data-target="#addMemberModal"><i class="fa fa-plus fa-fw"></i>Add Member</a>
                </li>
                <li class="">
                    <a data-toggle="modal" data-target="#addServiceModal"><i class="fa fa-bitcoin fa-fw"></i>Add Service</a>
                </li>
                <li class="">
                    <a data-toggle="modal" data-target="#viewMembersModal"><i class="fa fa-users fa-fw"></i>View Members</a>
                </li>
                <li class="">
                    <a data-toggle="modal" data-target="#viewServicesModal"><i class="fa fa-mobile fa-fw"></i>View Services</a>
                </li>

            </ul>
            <!-- end side-menu -->
        </div>
        <!-- end sidebar-collapse -->
    </nav>
    <!-- end navbar side -->
    <!--  page-wrapper -->
    <div id="page-wrapper">

        <div class="row">
            <!-- Page Header -->
            <div class="col-lg-12">
                <h1 class="page-header"> Nyumba Kumi Chats</h1>
                @if(Session::has('message'))
                    <div class="alert alert-{{ Session::get('bg') }}">
                        {{ Session::get('message') }}
                    </div>
                @endif
            </div>
            <!--End Page Header -->
        </div>

        <div class="row">
            <div class="modal fade" id="addMemberModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                            <h4 class="modal-title" id="addMemberLabel">Add Member</h4>
                        </div>
                        <div class="modal-body">
                            <form action="{{ route('addMember') }}" method="post" enctype="multipart/form-data" role="form">
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
                                <input type="hidden" name="_token" value="{{ Session::token() }}">
                                <button type="submit" class="btn btn-primary">Add Member</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <div class="modal fade" id="addServiceModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                            <h4 class="modal-title" id="addServiceLabel">Add Service Provider</h4>
                        </div>
                        <div class="modal-body">
                            <form method="post" action="{{ route('addService') }}" role="form">
                                <div class="form-group">
                                    <input class="form-control" placeholder="Phone" name="phone" type="tel" maxlength="14" minlength="7" required>
                                </div>
                                <div class="form-group">
                                    <input class="form-control" placeholder="Names" name="names" type="text" required maxlength="30" minlength="5">
                                </div>
                                <div class="form-group">
                                    <label>Type of Service</label>
                                    <select name="serviceType" title="Select a Service Below" id="typeOfService" class="form-control">
                                        <option></option>
                                        @foreach($serviceTypes as $serviceType)
                                            <option value="{{ $serviceType->type }}">{{ $serviceType->type }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label>If Type is not Available above, Type it Here</label>
                                    <input class="form-control" placeholder="New Service Type" name="customServiceType" type="text" maxlength="30" minlength="2">
                                </div>
                                <input type="hidden" name="_token" value="{{ Session::token() }}">
                                <button type="submit" class="btn btn-primary">Add Service Provider</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <div class="modal fade" id="viewMembersModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                            <h4 class="modal-title" id="viewMembersLabel">View Members</h4>
                        </div>
                        <div class="modal-body">
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    Advanced Tables
                                </div>
                                <div class="panel-body">
                                    <div class="table-responsive">
                                        <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                                            <thead>
                                            <tr>
                                                <th>Image</th>
                                                <th>Names</th>
                                                <th>Phone</th>
                                                <th>ID No</th>
                                                <th></th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            @foreach($members as $member)
                                                <tr class="odd gradeX">
                                                    <td>
                                                        <img src="{{ URL::asset('proffPics/'.$member->photo) }}" width="40" alt="pic">
                                                    </td>
                                                    <td>{{ $member -> names }}</td>
                                                    <td>{{ $member -> phone }}</td>
                                                    <td class="center">{{ $member -> idno }}</td>
                                                    <td class="center">
                                                        <form method="post" action="{{ route('deleteMember') }}">
                                                            <button type="submit" class="btn btn-sm btn-danger">
                                                                <input type="hidden" value="{{ $member->id }}" name="memberId">
                                                                <input type="hidden" name="_token" value="{{ Session::token() }}">
                                                                <i class="fa fa-trash-o"></i>
                                                            </button>
                                                        </form>
                                                    </td>
                                                </tr>
                                            @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="modal fade" id="viewServicesModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                            <h4 class="modal-title" id="viewServicesLabel">Service Providers</h4>
                        </div>
                        <div class="modal-body">
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered table-hover" id="dataTables">
                                    <thead>
                                    <tr>
                                        <th>Names</th>
                                        <th>Type</th>
                                        <th>Phone</th>
                                        <th></th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($services as $service)
                                            <tr class="odd gradeX">
                                                <td>{{ $service->name }}</td>
                                                <td>{{ $service->type }}</td>
                                                <td>{{ $service->phone }}</td>
                                                <td class="center">
                                                    <form method="post" action="{{ route('deleteService') }}">
                                                        <button type="submit" class="btn btn-sm btn-danger">
                                                            <input type="hidden" name="serviceId" value="{{ $service->id }}">
                                                            <input type="hidden" name="_token" value="{{ Session::token() }}">
                                                            <i class="fa fa-trash-o"></i>
                                                        </button>
                                                    </form>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">


            <div class="col-lg-3">
                <form id="formWithData" role="form">
                    <div class="form-group has-success">
                        <label class="control-label" for="inputSuccess">Type your Message:</label>
                        <input type="text" name="theMessage" class="form-control" id="theMessage">
                        <input type="hidden" value="{{ $user -> id }}" name="userid">
                    </div>
                    <input type="hidden" name="_token" value="{{ Session::token() }}">
                    <button type="submit" class="btn btn-primary">Send</button>
                </form>
                <form id="#hiddenForm" method="post">
                    <input type="hidden" value="{{ $user->id }}" name="userid">
                    <input type="hidden" value="{{ csrf_token() }}" name="_token">
                </form>
            </div>

            <div class="col-lg-9">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        Chats
                    </div>
                    <div id="theChatBox" class="panel-body">

                    </div>
                </div>
            </div>
        </div>

    </div>
    <!-- end page-wrapper -->

</div>
<!-- end wrapper -->

<!-- Core Scripts - Include with every page -->
<script src="{{ URL::asset('assets/plugins/jquery-1.10.2.js') }}"></script>
<script>
    var highestchatid = 0;
    // the jquery code
    $(document).ready(function (){
        var request;
        $('#formWithData').on('submit', function(e) {
            e.preventDefault();
            if(request){
                request.abort();
            }

            var $form = $(this);
            var $inputs = $form.find("input");
            var serializedData = $form.serialize();

            request = $.ajax({
                url: "{{ route('adminsendchat') }}",
                type: "post",
                data: serializedData
            });

            request.done(function (response, textStatus, jqXHr) {
                console.log("Done");
                $('#theMessage').val("");
            });

            request.fail(function (jqXHR, textStatus, errorThrown) {
                alert('Failed');

            });

            request.always(function(){
                console.log("");
            });
        });
        setInterval(requestChats, 2000);

        function requestChats(){

            $.post("{{ route('requestChats') }}", {
                group : "thirteen",
                highestchat : highestchatid,
                _token: "{{ csrf_token() }}"
            }, function(data, status){
                $('#theChatBox').html(data);
            });
            return false;
        }
    });
</script>
<script src="{{ URL::asset('assets/plugins/bootstrap/bootstrap.min.js') }}"></script>
<script src="{{ URL::asset('assets/plugins/metisMenu/jquery.metisMenu.js') }}"></script>
<script src="{{ URL::asset('assets/plugins/pace/pace.js') }}"></script>
<script src="{{ URL::asset('assets/scripts/siminta.js') }}"></script>
<!-- Page-Level Plugin Scripts-->
<script src="{{ URL::asset('assets/plugins/morris/raphael-2.1.0.min.js') }}"></script>
<script src="{{ URL::asset('assets/plugins/morris/morris.js') }}"></script>
<script src="{{ URL::asset('assets/plugins/dataTables/jquery.dataTables.js') }}"></script>
<script src="{{ URL::asset('assets/plugins/dataTables/dataTables.bootstrap.js') }}"></script>
<script>
    $(document).ready(function () {
        $('#dataTables-example').dataTable();
    });
</script>

</body>

</html>
