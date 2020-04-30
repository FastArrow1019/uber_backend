
<!DOCTYPE html>

<!--[if !IE]><!-->
<html lang="en">
<!--<![endif]-->
<!-- BEGIN HEAD -->
<head>
<meta charset="utf-8"/>
<title>User Manage Dashboard</title>
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta content="width=device-width, initial-scale=1.0" name="viewport"/>
<meta http-equiv="Content-type" content="text/html; charset=utf-8">
<meta content="" name="description"/>
<meta content="" name="author"/>
<!-- BEGIN GLOBAL MANDATORY STYLES -->

  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script>

<link href="http://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700&subset=all" rel="stylesheet" type="text/css"/>
<link href="http://article-guide.com/public/assets/global/plugins/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css"/>
<link href="http://article-guide.com/public/assets/global/plugins/simple-line-icons/simple-line-icons.min.css" rel="stylesheet" type="text/css"/>
<link href="http://article-guide.com/public/assets/global/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css"/>
<link href="http://article-guide.com/public/assets/global/plugins/uniform/css/uniform.default.css" rel="stylesheet" type="text/css"/>
<link href="http://article-guide.com/public/assets/global/plugins/bootstrap-switch/css/bootstrap-switch.min.css" rel="stylesheet" type="text/css"/>
<!-- END GLOBAL MANDATORY STYLES -->
<!-- BEGIN THEME STYLES -->
<link href="http://article-guide.com/public/assets/global/css/components.css" id="style_components" rel="stylesheet" type="text/css"/>
<link href="http://article-guide.com/public/assets/global/css/plugins.css" rel="stylesheet" type="text/css"/>
<link href="http://article-guide.com/public/assets/admin/layout/css/custom.css" rel="stylesheet" type="text/css"/>
<!-- END THEME STYLES -->
<link rel="shortcut icon" href="favicon.ico"/>

<style>
.center {
  margin: auto;
  width: 70%;
}
.middle {
  vertical-align: middle;
}
</style>

</head>
<!-- END HEAD -->

<body class="page-header-fixed page-quick-sidebar-over-content ">



<!-- BEGIN CONTAINER -->
<div class="page-container">

	<!-- BEGIN CONTENT -->
	<div class="page-content-wrapper">
		<div class="page-content middle">

			<!-- BEGIN PAGE CONTENT-->

			<div class="row center" style="margin-top: 3%;">
				
				<div class="row">
					<div class="col-md-8">
						<div class="logo">
							<img src="http://article-guide.com//public/img/logo.png" alt=""/>
						</div>
					</div>
					<div style="float: right;margin-right: 2.5%; margin-top: 3%;">
						<div class="dropdown">
						    <button class="btn btn-primary dropdown-toggle" type="button" data-toggle="dropdown">{{Auth::user()->name}}
						    <span class="caret"></span></button>
						    <ul class="dropdown-menu">
						      <li><a href="/logout">Logout</a></li>
						      <li><a href="/" >Go to Site</a></li>
						      
						    </ul>
					  	</div>					
					</div>					

				</div>
				<br>
				
				<div class="col-md-12">
					<!-- BEGIN CONDENSED TABLE PORTLET-->
					<div class="portlet box green">
						<div class="portlet-title">
							<div class="caption">
								<i class="fa fa-picture"></i>User Manager Dashboard
							</div>
						</div>
						<div class="portlet-body">
							<div class="table-scrollable">
								<table class="table table-condensed table-hover">
								<thead>
								<tr>
									<th>
										 No
									</th>
									<th>
										 UserName
									</th>
									<th>
										 Status
									</th>
									<th>
										 Update
									</th>
									<th>
										 Delete
									</th>									
								</tr>
								</thead>
								<tbody>
									<?php
										$no = 1;
									?>
									@foreach($users as $key => $user)
									    <tr>    
									      <td>{{$no}}</td>
									      <td>{{$user->name}}</td>
                						  <td>{{$user->status}}</td>
                						  <td>
											<a class="label label-sm label-success" data-toggle="modal" data-target="#myModal" onclick="fetchRecords({{$user->id}})">Update</a>
										  </td>
										  <td>
										  	<a class="label label-sm label-warning" href="delete/{{$user->id}}">Delete</a>
							  	
										  </td>
									    </tr>
									    <?php $no++?>
									@endforeach
								</tbody>
								</table>
							</div>
						</div>
					</div>
					<!-- END CONDENSED TABLE PORTLET-->
				</div>
			</div>
			<!-- END PAGE CONTENT-->
		</div>
	</div>
	<!-- END CONTENT -->

</div>
<!-- END CONTAINER -->
  <!-- Modal -->
  <div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">User Info</h4>
        </div>
        <div class="modal-body">
			<form class="Signup-form" action="{{ route('update') }}" method="post">
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
					<div class="form-group">
						<label class="control-label visible-ie8 visible-ie9">Status</label>
						<input class="form-control placeholder-no-fix" type="text" placeholder="status" id="mstatus" name="mstatus"/>
					</div>
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
	         url: 'getUsers/'+id,
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
	               $("#mstatus").val(status);
	               // $("#mpassword").val(password);
	               $("#mid").val(id);

	             }
	           }
	         }
	       });
	  }
</script>
</body>
<!-- END BODY -->
</html>