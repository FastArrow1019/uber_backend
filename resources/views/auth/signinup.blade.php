<!DOCTYPE html>
<!-- 
Template Name: Metronic - Responsive Admin Dashboard Template build with Twitter Bootstrap 3.3.2
Version: 3.3.0
Author: KeenThemes
Website: http://www.keenthemes.com/
Contact: support@keenthemes.com
Follow: www.twitter.com/keenthemes
Like: www.facebook.com/keenthemes
Purchase: http://themeforest.net/item/metronic-responsive-admin-dashboard-template/4021469?ref=keenthemes
License: You must have a valid license purchased only from themeforest(the above link) in order to legally use the theme for your project.
-->
<!--[if IE 8]> <html lang="en" class="ie8 no-js"> <![endif]-->
<!--[if IE 9]> <html lang="en" class="ie9 no-js"> <![endif]-->
<!--[if !IE]><!-->
<html lang="en">
<!--<![endif]-->
<!-- BEGIN HEAD -->
<head>
<meta charset="utf-8"/>
<title>Signup</title>
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta content="width=device-width, initial-scale=1.0" name="viewport"/>
<meta http-equiv="Content-type" content="text/html; charset=utf-8">
<meta content="" name="description"/>
<meta content="" name="author"/>
<!-- BEGIN GLOBAL MANDATORY STYLES -->
<link href="http://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700&subset=all" rel="stylesheet" type="text/css"/>
<link href="http://article-guide.com/public/assets/global/plugins/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css"/>
<link href="http://article-guide.com/public/assets/global/plugins/simple-line-icons/simple-line-icons.min.css" rel="stylesheet" type="text/css"/>
<link href="http://article-guide.com/public/assets/global/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css"/>
<link href="http://article-guide.com/public/assets/global/plugins/uniform/css/uniform.default.css" rel="stylesheet" type="text/css"/>
<!-- END GLOBAL MANDATORY STYLES -->
<!-- BEGIN PAGE LEVEL STYLES -->
<link href="http://article-guide.com/public/assets/admin/pages/css/login2.css" rel="stylesheet" type="text/css"/>
<!-- END PAGE LEVEL SCRIPTS -->
<!-- BEGIN THEME STYLES -->
<link href="http://article-guide.com/public/assets/global/css/components.css" id="style_components" rel="stylesheet" type="text/css"/>
<link href="http://article-guide.com/public/assets/global/css/plugins.css" rel="stylesheet" type="text/css"/>
<link href="http://article-guide.com/public/assets/admin/layout/css/layout.css" rel="stylesheet" type="text/css"/>
<link href="http://article-guide.com/public/assets/admin/layout/css/themes/darkblue.css" rel="stylesheet" type="text/css" id="style_color"/>
<link href="http://article-guide.com/public/assets/admin/layout/css/custom.css" rel="stylesheet" type="text/css"/>
<!-- END THEME STYLES -->
<link rel="shortcut icon" href="favicon.ico"/>
</head>
<!-- END HEAD -->
<!-- BEGIN BODY -->
<body class="login">
<!-- BEGIN SIDEBAR TOGGLER BUTTON -->
<div class="menu-toggler sidebar-toggler">
</div>
<!-- END SIDEBAR TOGGLER BUTTON -->
<!-- BEGIN LOGO -->
<div class="logo">
	
	
	<img src="http://letsride.work/public/img/drive.png" alt="" style="width: 10%; height: auto;" />&nbsp;&nbsp;&nbsp;
	<font style="color: #fff; font-size: 20px; font-style: bold;">Admin Panel</font>
	
</div>
<!-- END LOGO -->


<!-- BEGIN LOGIN -->
<div class="content">
	@if (count($errors) > 0)
	    <div class="alert alert-danger">
	        <ul>
	            @foreach ($errors->all() as $error)
	                <li>{{ $error }}</li>
	            @endforeach
	        </ul>
	    </div>
	@endif 
	<!-- BEGIN REGISTRATION FORM -->
	<form class="Signup-form" action="{{ route('signupcontrol') }}" method="post">
		 {{ csrf_field() }}
		<div class="form-title">
			<span class="form-title">Sign Up</span>
		</div>
		<div class="form-group">
			<label class="control-label visible-ie8 visible-ie9">Full Name</label>
			<input class="form-control placeholder-no-fix" type="text" placeholder="Full Name" id="fullname" name="fullname"/>
		</div>
		<!-- <div class="form-group"> -->
			<!--ie8, ie9 does not support html5 placeholder, so we just show field title for that-->
			<!-- <label class="control-label visible-ie8 visible-ie9">Email</label>
			<input class="form-control placeholder-no-fix" type="text" placeholder="Email" id="name" name="email"/> -->
		<!-- </div> -->
		<div class="form-group">
			<label class="control-label visible-ie8 visible-ie9">Password</label>
			<input class="form-control placeholder-no-fix" type="password" autocomplete="off" id="password" placeholder="Password" name="password"/>
		</div>
		<div class="form-group">
			<label class="control-label visible-ie8 visible-ie9">Re-type Your Password</label>
			<input class="form-control placeholder-no-fix" type="password" autocomplete="off" placeholder="Re-type Your Password" id="password_confirmation" name="password_confirmation"/>
		</div>
		
		<div class="form-actions">
			<a href="/signin" class="btn btn-default">Back</a>
			<button type="submit" id="register-submit-btn" class="btn btn-primary uppercase pull-right">Submit</button>
		</div>
	</form>
	<!-- END REGISTRATION FORM -->
</div>

<!-- END JAVASCRIPTS -->
</body>
<!-- END BODY -->
</html>