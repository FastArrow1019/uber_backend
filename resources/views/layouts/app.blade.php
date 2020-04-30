<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
    <head>
    <meta charset="utf-8">
    <meta charset="shift_jis">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <META http-equiv="X-UA-Compatible" content="IE=Shift_JIS">
    <meta name="keywords" content="キーワード">
    <meta name="description" content="紹介文">
    <META name="GENERATOR" content="IBM WebSphere Studio Homepage Builder Version 11.0.0.0 for Windows">
    <META http-equiv="Content-Type" content="text/html; charset=Shift_JIS">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script>
    <script type="text/javascript" src="https://cdn.rawgit.com/travist/seamless.js/master/build/seamless.child.js"></script>
    <script src="http://article-guide.com/public/js/search.js"></script>
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="http://article-guide.com/public/css/sp.css">
    <link rel="stylesheet" href="http://article-guide.com/public/css/pc.css">
    <title>上位15サイトの記事をまとめることができます。</title>

    <script>
        window.Laravel = {!! json_encode([
            'csrfToken' => csrf_token(),
        ]) !!};
    </script>
    </head>
    
    <body onload="doOnload()" id="my_body">
        <div class="flex-center position-ref full-height">
        <div id="main">
            <div id="header">
                <h1>上位15サイトの記事をまとめることができます。</h1>

                <div id="header_inner">
                    <div id="h_logo"><h2><A href="/">
                        <img src="http://article-guide.com/public/img/logo.png" alt="サイト・タイトル"></A></h2>
                    </div>
                    <div id="h_info"></div>
                    <div style="float: right; margin-top: 3%;">
                        <div class="dropdown">
                            <button class="btn btn-primary dropdown-toggle" type="button" data-toggle="dropdown">{{Auth::user()->name}}
                            </button>
                            <ul class="dropdown-menu">
                              @if (Auth::user()->status == 2)
                                <li><a href="/dashboard">Dashboard</a></li>
                              @else
                                <li><a data-toggle="modal" data-target="#myModal" onclick="fetchRecords({{Auth::user()->id}})">MyInfo Edit</a></li>
                              @endif
                              <li><a href="/logout">Logout</a></li>
                            </ul>
                        </div>                  
                    </div>  
                </div>

            </div>
        <div class="content" id="content">
    @yield('content')
            <div class="loader" id="loader"></div>
        </div>
        </div>
    @yield('footer')
            <div id="footer"><br>
            Copyright (C) 2019 ARTICLE-NAVI All Rights Reserved.　
            </div>
        </div>
    <div class="modal fade" id="myModal" role="dialog">
        <div class="modal-dialog">

          <!-- Modal content-->
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal">&times;</button>
              <h4 class="modal-title">User Info</h4>
            </div>
            <div class="modal-body">
                <form class="Signup-form" action="{{ route('userupdate') }}" method="post">
                         {{ csrf_field() }}
                        <div class="form-group">
                            <input type="hidden" name="mid" id="mid">
                            <label class="control-label visible-ie8 visible-ie9">UserName</label>
                            <input class="form-control placeholder-no-fix" type="text" placeholder="Full Name" id="mfullname" name="mfullname"/>
                        </div>
                        <!-- <div class="form-group"> -->
                            <!--ie8, ie9 does not support html5 placeholder, so we just show field title for that-->
                            <!-- <label class="control-label visible-ie8 visible-ie9">Email</label>
                            <input class="form-control placeholder-no-fix" type="text" placeholder="Email" id="memail" name="memail"/> -->
                        <!-- </div> -->
                        <div class="form-group">
                            <label class="control-label visible-ie8 visible-ie9">Password</label>
                            <input class="form-control placeholder-no-fix" type="password" autocomplete="off" id="mpassword" placeholder="Password" name="mpassword"/>
                        </div>
                        <!--<div class="form-group">-->
                        <!--    <label class="control-label visible-ie8 visible-ie9">Status</label>-->
                        <!--    <input class="form-control placeholder-no-fix" type="text" placeholder="status" id="mstatus" name="mstatus"/>-->
                        <!--</div>-->
                        <div class="form-actions">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                            <button type="submit" id="register-submit-btn" class="btn btn-primary uppercase pull-right">Submit</button>
                        </div>
                    </form>

            </div>
          </div>
          
        </div>
        </div>
    <script>
        function fetchRecords(id){
           $.ajax({
             url: 'getUser_data/'+id,
             type: 'get',
             dataType: 'json',
             success: function(response){
               var len = 0;
               if(response['data'] != null){
                 len = response['data'].length;
               }
               if(len > 0){
                 for(var i=0; i<len; i++){
                   var id = response['data'][i].id;
                   var username = response['data'][i].name;
                   var email = response['data'][i].email;
                   var password = response['data'][i].password;
                   var status = response['data'][i].status;
                   $("#mfullname").val(username);
                   // $("#memail").val(email);
                   //$("#mstatus").val(status);
                   // $("#mpassword").val(password);
                   $("#mid").val(id);

                 }
               }
             }
           });
        }
    </script>
    </body>
</html>
