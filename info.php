<?php 

function getInBytes($value){
	$value = trim($value);
	$last_char = strtolower($value[strlen($value) - 1]);
	switch($last_char){
		case 'g': $value *= 1024;
		case 'm': $value *= 1024;
		case 'k': $value *= 1024;
	}
	return $value;
}
function apacheGetModules(){
	if (function_exists('apache_get_modules')) {
		$apacheGetModules = apache_get_modules();
	}else {
		$apacheGetModules = array();
	}
	return $apacheGetModules;
}
$title='System Requirement check';
$text_install_php = '1. Please configure your PHP settings to match requirements listed below.';
$text_install_extension = '2. Please make sure the PHP extensions listed below are installed.';
$text_msql_version = '3. Please make sure you have Mysql version 5.6 or greater than 5.6';
$text_note='Note: In some server environment, script unable to detect server settings. So if you have configured your server as per required settings, You can install <a href="http://www.fatbit.com/" target="_blank">FatBit</a> Powered Scripts. ';
$text_strict_trans_tables='4. sql_mode - strict_trans_tables should be disabled.';
$text_setting = 'PHP Settings';
$text_current = 'Current Settings';
$text_required = 'Required Settings';
$text_extension = 'Extension Settings';
$text_file = 'Files';
$text_directory = 'Directories';
$text_status = 'Status';
$text_on = 'On';
$text_off = 'Off';
$text_missing = 'Missing';
$text_writable = 'Writable';
$text_unwritable = 'Unwritable';
$text_memory_limit = 'Memory Limit';
$text_version = 'PHP Version';
$text_mysql_version = 'MySql Version';
$text_ioncube = 'Ioncube';
$text_global = 'Register Globals';
$text_magic = 'Magic Quotes GPC';
$text_file_upload = 'File Uploads';
$text_allow_url_fopen = 'Allow Url fopen ';
$text_json = 'JSON';
$text_session = 'Session Auto Start';
$text_safe_mode = 'Safe Mode';
$text_db = 'MySQLi';
$text_mysqli = 'MySQLi';
$text_mysql = 'MySQL';
$text_mpdo = 'mPDO';
$text_gd = 'GD';
$text_curl = 'cURL';
$text_mcrypt = 'mCrypt';
$text_zlib = 'ZLIB';
$text_zip = 'ZIP';
$text_mbstring = 'mbstring';
$text_short_open_tag = 'Short Open Tag';
$text_rewrite_url = 'Url Rewriting (mod_rewrite)';


$button_continue = 'Continue';
$button_back = 'Back';
$memory_limit = getInBytes(ini_get('memory_limit'))>=getInBytes('32M');
$php_version = phpversion();
//$mysql_version = mysql_get_server_info();
$register_globals = ini_get('register_globals');
$magic_quotes_gpc = ini_get('magic_quotes_gpc');
$file_uploads = ini_get('file_uploads');

$allow_url_fopen = ini_get('allow_url_fopen');
$session_auto_start = ini_get('session_auto_start');
$safeModeOn=ini_get('safe_mode');
$short_open_tag = ini_get('short_open_tag');

if(in_array('mod_rewrite', apacheGetModules())){
	$rewrite_url=true;
}else{
	$rewrite_url=false;
}

if (!array_filter(array('mysqli'), 'extension_loaded')) {
	$db = false;
} else {
	$db = true;
}

$gd = extension_loaded('gd');
$curl = extension_loaded('curl');
$zlib = extension_loaded('zlib');
$zip = extension_loaded('zip');
$iconv = function_exists('iconv');
$mbstring = extension_loaded('mbstring');
$ioncube = extension_loaded('IonCube Loader');
$json = extension_loaded('json');


?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8" />
<title><?php echo $title; ?></title>
<link href="//fonts.googleapis.com/css?family=Open+Sans:400,400i,300,700" rel="stylesheet" type="text/css" />
<style>
html {
	overflow: -moz-scrollbars-vertical;
	margin: 0;
	padding: 0;
}
*,h1,h2,h3,h4,h5,h6 {
	font-family: 'Open Sans', sans-serif;
	font-weight: 400;line-height:1.2;
}
body {
	margin: 0px;
	padding: 0px;
	line-height: 1.5;
	background: #FFF;
}
body, p, td, th, input, textarea, select, option {
	color: #777777;
	text-decoration: none;
	font-size: 13px;
}
fieldset {
	border: 1px solid #DBDBDB;
	padding: 10px;
	margin-bottom: 20px;
	-webkit-border-radius: 5px 5px 5px 5px;
	-moz-border-radius: 5px 5px 5px 5px;
	-khtml-border-radius: 5px 5px 5px 5px;
	border-radius: 5px 5px 5px 5px;
}
fieldset table {
	width: 100%;
	border-collapse: collapse;
}
fieldset table.form tr td:first-child {
	width: 250px;
}
fieldset table td {
	padding: 5px;
}
.page{margin:0 auto;max-width:1000px;}

.row { margin-right: -15px; margin-left: -15px;}
.row:before,.row:after { display: table; content: " ";}
.row:after {  clear: both;}
.row:before,.row:after { display: table; content: " ";}
.row:after {  clear: both;}
.col-sm-3,.col-sm-9{ float: left;}
.col-sm-3 {   width: 25%;  }
.col-sm-9 { width: 75%; }
.table {width: 100%; margin-bottom: 20px;}
.table > thead > tr > th,.table > tbody > tr > th,.table > tfoot > tr > th,.table > thead > tr > td,.table > tbody > tr > td,.table > tfoot > tr > td {  padding: 8px;  line-height: 1.428571429;
  vertical-align: top;  border-top: 1px solid #dddddd;}
.table > thead > tr > th {  vertical-align: bottom;  border-bottom: 2px solid #dddddd;}
.table > caption + thead > tr:first-child > th,.table > colgroup + thead > tr:first-child > th,.table > thead:first-child > tr:first-child > th,.table > caption + thead > tr:first-child > td,
.table > colgroup + thead > tr:first-child > td,.table > thead:first-child > tr:first-child > td {
  border-top: 0;}
.table > tbody + tbody {  border-top: 2px solid #dddddd;}
.table .table {  background-color: #ffffff;}
.text-center {  text-align: center;}
.text-success {  color: #468847;}
.text-danger {  color: #b94a48;}
#logo{margin:10px 0;}
h1.heading{font-size:24px;font-weight:600;line-height:1.5;}
h1.heading small{font-size:14px;font-weight:400;line-height:1;display:block;}

.svg-icn svg{width:20px; height:21px; display:block; margin:0 auto;}
.svg-icn.check svg path, .svg-icn.check svg{fill:#008000;}
.svg-icn.delete svg path, .svg-icn.delete svg{fill:#FF0000;}
#logo svg { height: auto; width: 200px;}
</style>
</head>
<body>
<svg version="1.1"  xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"  style="display:none">
<defs>
	<symbol id="Check_Circle" viewBox="0 0 384.97 384.97" style="enable-background:new 0 0 384.97 384.97;" xml:space="preserve">
		<path d="M192.485,0C86.173,0,0,86.173,0,192.485S86.173,384.97,192.485,384.97c106.3,0,192.485-86.185,192.485-192.485
			C384.97,86.173,298.785,0,192.485,0z M192.485,360.909c-93.018,0-168.424-75.406-168.424-168.424S99.467,24.061,192.485,24.061
			s168.424,75.406,168.424,168.424S285.503,360.909,192.485,360.909z"/>
		<path d="M280.306,125.031L156.538,247.692l-51.502-50.479c-4.74-4.704-12.439-4.704-17.179,0c-4.752,4.704-4.752,12.319,0,17.011
			l60.139,58.936c4.932,4.343,12.307,4.824,17.179,0l132.321-131.118c4.74-4.692,4.74-12.319,0-17.011
			C292.745,120.339,285.058,120.339,280.306,125.031z"/>
	</symbol>
	 <symbol id="Check_Close" viewBox="0 0 66.915 66.915" style="enable-background:new 0 0 66.915 66.915;" xml:space="preserve">
		<path d="M46.133,20.688c-0.781-0.781-2.047-0.781-2.828,0l-9.899,9.899l-9.9-9.899c-0.781-0.781-2.047-0.781-2.828,0
			s-0.781,2.047,0,2.828l9.9,9.899l-9.9,9.899c-0.781,0.781-0.781,2.047,0,2.828c0.391,0.391,0.902,0.586,1.414,0.586
			s1.023-0.195,1.414-0.586l9.9-9.899l9.899,9.899c0.391,0.391,0.902,0.586,1.414,0.586s1.023-0.195,1.414-0.586
			c0.781-0.781,0.781-2.047,0-2.828l-9.899-9.899l9.899-9.899C46.914,22.735,46.914,21.468,46.133,20.688z"/>
		<path d="M57.107,9.8C50.788,3.481,42.386,0,33.449,0S16.112,3.48,9.792,9.8c-13.045,13.045-13.045,34.271,0,47.315
			c6.318,6.319,14.721,9.8,23.657,9.8c8.938,0,17.34-3.48,23.659-9.8c6.319-6.318,9.799-14.721,9.799-23.658
			C66.906,24.521,63.426,16.119,57.107,9.8z M54.281,54.287c-5.564,5.563-12.962,8.628-20.831,8.628
			c-7.868,0-15.266-3.064-20.829-8.628c-11.485-11.485-11.485-30.174,0-41.659C18.185,7.064,25.581,4,33.449,4
			s15.266,3.064,20.829,8.627s8.628,12.961,8.629,20.83C62.907,41.326,59.844,48.724,54.281,54.287z"/>
	</symbol>
</defs>
</svg>
<div class="page">
  <header>
    <div class="row">
      <div class="col-sm-3">       
        <div id="logo" class="">
          <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" preserveAspectRatio="xMidYMid" width="160" height="43" viewBox="0 0 160 43">     <g id="logo-copy">       <path d="M159.127,5.103 C158.828,5.646 158.409,6.066 157.871,6.366 C157.332,6.666 156.768,6.816 156.180,6.816 C155.592,6.816 155.028,6.666 154.489,6.366 C153.950,6.066 153.531,5.646 153.230,5.103 C152.931,4.561 152.780,3.995 152.780,3.408 C152.780,2.814 152.933,2.244 153.237,1.696 C153.542,1.150 153.966,0.730 154.509,0.436 C155.052,0.142 155.610,-0.005 156.180,-0.005 C156.750,-0.005 157.307,0.142 157.851,0.436 C158.394,0.730 158.817,1.150 159.120,1.696 C159.423,2.244 159.575,2.814 159.575,3.408 C159.575,3.995 159.426,4.561 159.127,5.103 ZM158.631,1.982 C158.378,1.525 158.024,1.175 157.571,0.929 C157.118,0.683 156.654,0.561 156.180,0.561 C155.703,0.561 155.238,0.683 154.787,0.929 C154.335,1.175 153.981,1.525 153.726,1.982 C153.471,2.438 153.344,2.914 153.344,3.408 C153.344,3.899 153.469,4.370 153.719,4.820 C153.970,5.270 154.321,5.621 154.771,5.874 C155.221,6.124 155.691,6.251 156.180,6.251 C156.669,6.251 157.139,6.124 157.589,5.874 C158.039,5.621 158.389,5.270 158.638,4.820 C158.887,4.370 159.012,3.899 159.012,3.408 C159.012,2.914 158.885,2.438 158.631,1.982 ZM157.282,4.290 C157.406,4.821 157.496,5.190 157.570,5.337 C157.570,5.337 157.062,5.337 157.062,5.337 C157.000,5.229 156.916,4.900 156.814,4.426 C156.701,3.899 156.493,3.701 156.047,3.684 C156.047,3.684 155.585,3.684 155.585,3.684 C155.585,3.684 155.585,5.337 155.585,5.337 C155.585,5.337 155.095,5.337 155.095,5.337 C155.095,5.337 155.095,1.580 155.095,1.580 C155.343,1.527 155.704,1.493 156.036,1.493 C156.560,1.493 156.904,1.595 157.141,1.810 C157.327,1.974 157.440,2.236 157.440,2.535 C157.440,3.033 157.119,3.366 156.724,3.504 C156.724,3.504 156.724,3.520 156.724,3.520 C157.012,3.621 157.186,3.894 157.282,4.290 ZM156.944,2.586 C156.944,2.094 156.588,1.879 156.070,1.879 C155.833,1.879 155.670,1.901 155.585,1.925 C155.585,1.925 155.585,3.311 155.585,3.311 C155.585,3.311 156.087,3.311 156.087,3.311 C156.611,3.311 156.944,3.022 156.944,2.586 Z" id="path-1" class="logo-cl-1" fill-rule="evenodd"/>       <path d="M-0.011,31.949 C-0.011,31.949 8.339,31.949 8.339,31.949 C8.339,31.949 8.339,22.681 8.339,22.681 C8.339,22.681 26.478,22.681 26.478,22.681 C26.478,22.681 26.478,16.634 26.478,16.634 C26.478,16.634 8.339,16.634 8.339,16.634 C8.339,16.634 8.339,12.158 8.339,12.158 C8.339,12.158 27.232,12.158 27.232,12.158 C27.232,12.158 27.232,5.265 27.232,5.265 C27.232,5.265 -0.011,5.265 -0.011,5.265 C-0.011,5.265 -0.011,31.949 -0.011,31.949 C-0.011,31.949 -0.011,31.949 -0.011,31.949 ZM65.810,12.121 C65.810,12.121 77.119,12.121 77.119,12.121 C77.119,12.121 77.119,31.901 77.119,31.901 C77.119,31.901 85.483,31.901 85.483,31.901 C85.483,31.901 85.483,12.121 85.483,12.121 C85.483,12.121 96.811,12.121 96.811,12.121 C96.811,12.121 96.811,5.265 96.811,5.265 C96.811,5.265 65.810,5.265 65.810,5.265 C65.810,5.265 65.810,12.121 65.810,12.121 C65.810,12.121 65.810,12.121 65.810,12.121 ZM27.281,31.901 C27.281,31.901 41.332,5.263 41.332,5.263 C41.332,5.263 51.693,5.263 51.693,5.263 C51.693,5.263 65.961,31.901 65.961,31.901 C65.961,31.901 57.106,31.901 57.106,31.901 C57.106,31.901 46.494,11.562 46.494,11.562 C46.494,11.562 42.096,20.138 42.096,20.138 C42.096,20.138 36.170,31.901 36.170,31.901 C36.170,31.901 27.281,31.901 27.281,31.901 Z" id="path-2" class="logo-cl-1" fill-rule="evenodd"/>       <path d="M151.261,37.601 C151.027,37.408 150.681,37.312 150.223,37.312 C149.747,37.312 149.399,37.399 149.181,37.575 C148.963,37.750 148.854,37.961 148.854,38.209 C148.854,38.424 148.931,38.600 149.086,38.739 C149.237,38.877 149.633,39.020 150.274,39.165 C150.914,39.310 151.354,39.437 151.592,39.546 C151.939,39.707 152.195,39.910 152.360,40.156 C152.525,40.402 152.608,40.685 152.608,41.006 C152.608,41.324 152.517,41.623 152.335,41.905 C152.154,42.186 151.893,42.405 151.553,42.561 C151.214,42.718 150.831,42.796 150.406,42.796 C149.867,42.796 149.415,42.717 149.051,42.559 C148.687,42.402 148.401,42.164 148.194,41.848 C147.987,41.531 147.878,41.173 147.867,40.773 C147.867,40.773 148.611,40.708 148.611,40.708 C148.646,41.007 148.728,41.252 148.856,41.444 C148.985,41.636 149.185,41.791 149.455,41.909 C149.726,42.027 150.031,42.086 150.369,42.086 C150.670,42.086 150.935,42.041 151.166,41.952 C151.396,41.862 151.567,41.739 151.679,41.583 C151.792,41.426 151.848,41.256 151.848,41.071 C151.848,40.883 151.794,40.720 151.686,40.580 C151.577,40.440 151.398,40.322 151.149,40.227 C150.990,40.165 150.636,40.067 150.089,39.935 C149.542,39.804 149.159,39.679 148.940,39.562 C148.655,39.413 148.443,39.227 148.304,39.006 C148.164,38.784 148.095,38.536 148.095,38.262 C148.095,37.960 148.180,37.678 148.351,37.416 C148.521,37.153 148.770,36.954 149.098,36.818 C149.426,36.683 149.790,36.615 150.191,36.615 C150.632,36.615 151.021,36.686 151.359,36.829 C151.696,36.971 151.955,37.181 152.136,37.459 C152.318,37.736 152.415,38.050 152.429,38.400 C152.429,38.400 151.673,38.457 151.673,38.457 C151.633,38.080 151.495,37.794 151.261,37.601 ZM134.700,36.716 C134.700,36.716 139.005,36.716 139.005,36.716 C139.005,36.716 139.005,37.422 139.005,37.422 C139.005,37.422 135.488,37.422 135.488,37.422 C135.488,37.422 135.488,39.253 135.488,39.253 C135.488,39.253 138.782,39.253 138.782,39.253 C138.782,39.253 138.782,39.954 138.782,39.954 C138.782,39.954 135.488,39.954 135.488,39.954 C135.488,39.954 135.488,41.988 135.488,41.988 C135.488,41.988 139.143,41.988 139.143,41.988 C139.143,41.988 139.143,42.694 139.143,42.694 C139.143,42.694 134.700,42.694 134.700,42.694 C134.700,42.694 134.700,36.716 134.700,36.716 ZM124.603,36.716 C124.603,36.716 125.391,36.716 125.391,36.716 C125.391,36.716 125.391,42.694 125.391,42.694 C125.391,42.694 124.603,42.694 124.603,42.694 C124.603,42.694 124.603,36.716 124.603,36.716 ZM112.938,42.796 C112.353,42.796 111.822,42.670 111.344,42.419 C110.866,42.167 110.505,41.804 110.261,41.328 C110.017,40.852 109.896,40.321 109.896,39.734 C109.896,39.152 110.017,38.609 110.259,38.105 C110.502,37.601 110.850,37.226 111.305,36.982 C111.760,36.737 112.284,36.615 112.877,36.615 C113.308,36.615 113.697,36.685 114.045,36.825 C114.393,36.965 114.666,37.160 114.864,37.410 C115.061,37.660 115.211,37.986 115.314,38.388 C115.314,38.388 114.604,38.584 114.604,38.584 C114.514,38.279 114.403,38.040 114.270,37.866 C114.138,37.692 113.948,37.553 113.702,37.448 C113.455,37.344 113.182,37.291 112.881,37.291 C112.521,37.291 112.210,37.346 111.947,37.457 C111.684,37.567 111.472,37.711 111.311,37.891 C111.150,38.070 111.025,38.267 110.936,38.482 C110.784,38.852 110.708,39.253 110.708,39.685 C110.708,40.218 110.799,40.663 110.982,41.022 C111.165,41.381 111.431,41.647 111.780,41.821 C112.130,41.995 112.501,42.082 112.893,42.082 C113.235,42.082 113.568,42.016 113.893,41.884 C114.218,41.753 114.464,41.612 114.632,41.462 C114.632,41.462 114.632,40.349 114.632,40.349 C114.632,40.349 112.881,40.349 112.881,40.349 C112.881,40.349 112.881,39.648 112.881,39.648 C112.881,39.648 115.404,39.644 115.404,39.644 C115.404,39.644 115.404,41.862 115.404,41.862 C115.017,42.172 114.617,42.405 114.205,42.561 C113.794,42.718 113.371,42.796 112.938,42.796 ZM99.775,42.427 C99.328,42.673 98.846,42.796 98.328,42.796 C97.768,42.796 97.267,42.660 96.825,42.388 C96.384,42.116 96.050,41.745 95.822,41.275 C95.595,40.805 95.481,40.307 95.481,39.783 C95.481,38.790 95.746,38.014 96.277,37.452 C96.808,36.891 97.493,36.610 98.332,36.610 C98.882,36.610 99.378,36.742 99.819,37.006 C100.261,37.270 100.597,37.637 100.829,38.109 C101.060,38.580 101.176,39.115 101.176,39.713 C101.176,40.319 101.054,40.862 100.810,41.340 C100.567,41.819 100.221,42.181 99.775,42.427 ZM100.118,38.435 C99.954,38.072 99.714,37.791 99.399,37.591 C99.083,37.391 98.729,37.291 98.337,37.291 C97.779,37.291 97.299,37.484 96.897,37.868 C96.494,38.253 96.293,38.895 96.293,39.795 C96.293,40.515 96.486,41.083 96.872,41.497 C97.258,41.912 97.742,42.119 98.324,42.119 C98.917,42.119 99.406,41.910 99.789,41.491 C100.172,41.072 100.364,40.478 100.364,39.709 C100.364,39.223 100.282,38.798 100.118,38.435 ZM83.158,36.716 C83.158,36.716 83.946,36.716 83.946,36.716 C83.946,36.716 83.946,41.988 83.946,41.988 C83.946,41.988 86.879,41.988 86.879,41.988 C86.879,41.988 86.879,42.694 86.879,42.694 C86.879,42.694 83.158,42.694 83.158,42.694 C83.158,42.694 83.158,36.716 83.158,36.716 ZM72.871,42.427 C72.424,42.673 71.942,42.796 71.424,42.796 C70.864,42.796 70.363,42.660 69.921,42.388 C69.480,42.116 69.146,41.745 68.918,41.275 C68.691,40.805 68.577,40.307 68.577,39.783 C68.577,38.790 68.842,38.014 69.373,37.452 C69.904,36.891 70.589,36.610 71.428,36.610 C71.978,36.610 72.474,36.742 72.915,37.006 C73.357,37.270 73.693,37.637 73.925,38.109 C74.156,38.580 74.272,39.115 74.272,39.713 C74.272,40.319 74.150,40.862 73.906,41.340 C73.663,41.819 73.317,42.181 72.871,42.427 ZM73.214,38.435 C73.050,38.072 72.810,37.791 72.495,37.591 C72.179,37.391 71.825,37.291 71.433,37.291 C70.875,37.291 70.395,37.484 69.993,37.868 C69.590,38.253 69.389,38.895 69.389,39.795 C69.389,40.515 69.582,41.083 69.968,41.497 C70.354,41.912 70.838,42.119 71.420,42.119 C72.013,42.119 72.502,41.910 72.885,41.491 C73.268,41.072 73.460,40.478 73.460,39.709 C73.460,39.223 73.378,38.798 73.214,38.435 ZM55.653,37.997 C55.653,37.997 55.653,42.694 55.653,42.694 C55.653,42.694 54.897,42.694 54.897,42.694 C54.897,42.694 54.897,36.716 54.897,36.716 C54.897,36.716 55.706,36.716 55.706,36.716 C55.706,36.716 58.834,41.409 58.834,41.409 C58.834,41.409 58.834,36.716 58.834,36.716 C58.834,36.716 59.589,36.716 59.589,36.716 C59.589,36.716 59.589,42.694 59.589,42.694 C59.589,42.694 58.781,42.694 58.781,42.694 C58.781,42.694 55.653,37.997 55.653,37.997 ZM44.902,39.876 C44.902,39.876 41.807,39.876 41.807,39.876 C41.807,39.876 41.807,42.694 41.807,42.694 C41.807,42.694 41.019,42.694 41.019,42.694 C41.019,42.694 41.019,36.716 41.019,36.716 C41.019,36.716 41.807,36.716 41.807,36.716 C41.807,36.716 41.807,39.171 41.807,39.171 C41.807,39.171 44.902,39.171 44.902,39.171 C44.902,39.171 44.902,36.716 44.902,36.716 C44.902,36.716 45.690,36.716 45.690,36.716 C45.690,36.716 45.690,42.694 45.690,42.694 C45.690,42.694 44.902,42.694 44.902,42.694 C44.902,42.694 44.902,39.876 44.902,39.876 ZM28.578,41.838 C28.890,42.025 29.227,42.119 29.590,42.119 C30.031,42.119 30.405,41.991 30.711,41.736 C31.017,41.480 31.224,41.101 31.332,40.598 C31.332,40.598 32.121,40.798 32.121,40.798 C31.955,41.448 31.658,41.943 31.229,42.284 C30.800,42.625 30.275,42.796 29.655,42.796 C29.013,42.796 28.491,42.665 28.089,42.402 C27.687,42.140 27.381,41.760 27.171,41.263 C26.961,40.765 26.856,40.231 26.856,39.660 C26.856,39.038 26.975,38.495 27.212,38.031 C27.448,37.568 27.786,37.216 28.223,36.975 C28.660,36.735 29.142,36.615 29.667,36.615 C30.263,36.615 30.764,36.767 31.170,37.071 C31.576,37.376 31.859,37.804 32.019,38.356 C32.019,38.356 31.243,38.539 31.243,38.539 C31.105,38.104 30.905,37.787 30.642,37.589 C30.379,37.391 30.049,37.291 29.651,37.291 C29.193,37.291 28.811,37.401 28.503,37.622 C28.196,37.842 27.980,38.137 27.855,38.508 C27.731,38.879 27.668,39.262 27.668,39.656 C27.668,40.165 27.742,40.608 27.890,40.987 C28.037,41.367 28.267,41.650 28.578,41.838 ZM13.648,36.716 C13.648,36.716 17.954,36.716 17.954,36.716 C17.954,36.716 17.954,37.422 17.954,37.422 C17.954,37.422 14.436,37.422 14.436,37.422 C14.436,37.422 14.436,39.253 14.436,39.253 C14.436,39.253 17.730,39.253 17.730,39.253 C17.730,39.253 17.730,39.954 17.730,39.954 C17.730,39.954 14.436,39.954 14.436,39.954 C14.436,39.954 14.436,41.988 14.436,41.988 C14.436,41.988 18.092,41.988 18.092,41.988 C18.092,41.988 18.092,42.694 18.092,42.694 C18.092,42.694 13.648,42.694 13.648,42.694 C13.648,42.694 13.648,36.716 13.648,36.716 ZM2.950,42.694 C2.950,42.694 2.162,42.694 2.162,42.694 C2.162,42.694 2.162,37.422 2.162,37.422 C2.162,37.422 0.200,37.422 0.200,37.422 C0.200,37.422 0.200,36.716 0.200,36.716 C0.200,36.716 4.920,36.716 4.920,36.716 C4.920,36.716 4.920,37.422 4.920,37.422 C4.920,37.422 2.950,37.422 2.950,37.422 C2.950,37.422 2.950,42.694 2.950,42.694 Z" id="path-3" class="logo-cl-1" fill-rule="evenodd"/>       <path d="M148.993,31.847 C148.993,31.847 102.053,31.847 102.053,31.847 C99.964,31.847 98.271,30.148 98.271,28.051 C98.271,28.051 98.271,9.124 98.271,9.124 C98.271,7.028 99.964,5.328 102.053,5.328 C102.053,5.328 148.993,5.328 148.993,5.328 C151.081,5.328 152.774,7.028 152.774,9.124 C152.774,9.124 152.774,28.051 152.774,28.051 C152.774,30.148 151.081,31.847 148.993,31.847 ZM122.501,20.192 C122.501,16.542 121.441,14.424 114.641,14.424 C114.641,14.424 113.046,14.424 113.046,14.424 C110.835,14.424 108.568,14.716 108.232,16.963 C108.232,16.963 108.176,16.963 108.176,16.963 C108.176,16.963 108.176,8.311 108.176,8.311 C108.176,8.311 102.898,8.311 102.898,8.311 C102.898,8.311 102.898,28.838 102.898,28.838 C102.898,28.838 108.218,28.838 108.218,28.838 C108.218,28.838 108.218,26.008 108.218,26.008 C108.218,26.008 108.275,26.008 108.275,26.008 C108.862,27.777 109.827,28.872 113.074,28.872 C113.074,28.872 114.641,28.872 114.641,28.872 C121.441,28.872 122.501,26.429 122.501,22.777 C122.501,22.777 122.501,20.192 122.501,20.192 ZM129.295,8.310 C129.295,8.310 124.048,8.310 124.048,8.310 C124.048,8.310 124.048,11.303 124.048,11.303 C124.048,11.303 129.295,13.363 129.295,13.363 C129.295,13.363 129.295,8.310 129.295,8.310 ZM129.295,14.416 C129.295,14.416 124.048,14.416 124.048,14.416 C124.048,14.416 124.048,28.836 124.048,28.836 C124.048,28.836 129.295,28.836 129.295,28.836 C129.295,28.836 129.295,14.416 129.295,14.416 ZM148.201,22.706 C148.201,22.706 143.689,22.706 143.689,22.706 C143.689,22.706 143.689,23.471 143.689,23.471 C143.689,24.791 143.150,25.184 141.415,25.184 C140.128,25.184 139.124,24.959 139.124,23.892 C139.124,23.892 139.124,18.197 139.124,18.197 C139.124,18.197 147.432,18.197 147.432,18.197 C147.432,18.197 147.432,14.416 147.432,14.416 C147.432,14.416 139.124,14.416 139.124,14.416 C139.124,14.416 139.124,10.624 139.124,10.624 C139.124,10.624 133.908,10.624 133.908,10.624 C133.908,10.624 133.908,14.416 133.908,14.416 C133.908,14.416 130.835,14.416 130.835,14.416 C130.835,14.416 130.835,18.197 130.835,18.197 C130.835,18.197 133.908,18.197 133.908,18.197 C133.908,18.197 133.908,24.060 133.908,24.060 C133.908,28.020 136.826,28.870 140.128,28.870 C140.128,28.870 142.255,28.870 142.255,28.870 C146.536,28.870 148.201,26.981 148.201,24.257 C148.201,24.257 148.201,22.706 148.201,22.706 ZM114.249,24.828 C114.249,24.828 111.087,24.828 111.087,24.828 C108.960,24.828 107.840,24.350 107.840,22.187 C107.840,22.187 107.840,20.783 107.840,20.783 C107.840,18.620 108.960,18.143 111.087,18.143 C111.087,18.143 114.249,18.143 114.249,18.143 C116.823,18.143 117.075,19.042 117.075,20.643 C117.075,20.643 117.075,22.327 117.075,22.327 C117.075,23.929 116.823,24.828 114.249,24.828 ZM46.422,18.208 C46.422,18.208 53.606,31.777 53.606,31.777 C53.606,31.777 39.426,31.777 39.426,31.777 C39.426,31.777 46.422,18.208 46.422,18.208 Z" id="path-4" class="logo-cl-2" fill-rule="evenodd"/>     </g>     </svg>

        </div>		
      </div>
	  <div class="col-sm-9">
		<h1 class="heading">Pre-Installation<small>Check your server is set-up correctly</small></h1>
	  </div>
	  </div>
	  
  </header>
  <?php if ($error_warning) { ?>
  <div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i> <?php echo $error_warning; ?>
    <button type="button" class="close" data-dismiss="alert">&times;</button>
  </div>
  <?php } ?>
  <div class="row">
    <div class="col-sm-12">
      <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data">
        <p><?php echo $text_install_php; ?></p>
        <fieldset>
          <table class="table">
            <thead>
              <tr>
                <td width="35%"><b><?php echo $text_setting; ?></b></td>
                <td width="25%"><b><?php echo $text_current; ?></b></td>
                <td width="25%"><b><?php echo $text_required; ?></b></td>
                <td width="15%" class="text-center"><b><?php echo $text_status; ?></b></td>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td><?php echo $text_memory_limit; ?></td>
                <td><?php echo ini_get('memory_limit'); ?></td>
                <td>32M or 32M+</td>
                <td class="text-center"><?php if ($memory_limit) { ?>
                  <span class="text-success"><i class="fa fa-check-circle svg-icn check"><svg class="icon icon--check"><use xlink:href="#Check_Circle" /></svg></i></span>
                  <?php } else { ?>
                  <span class="text-danger"><i class="fa fa-minus-circle svg-icn delete"><svg class="icon icon--check"><use xlink:href="#Check_Close" /></svg></i></span>
                  <?php } ?>
                </td>
              </tr>
              <tr>
                <td><?php echo $text_version; ?></td>
                <td><?php echo $php_version; ?></td>
                <td>5.5+</td>
                <td class="text-center"><?php if ($php_version >= '5.5') { ?>
                  <span class="text-success"><i class="fa fa-check-circle svg-icn check"><svg class="icon icon--check"><use xlink:href="#Check_Circle" /></svg>

</i></span>
                  <?php } else { ?>
                  <span class="text-danger"><i class="fa fa-minus-circle svg-icn delete"><svg class="icon icon--check"><use xlink:href="#Check_Close" /></svg></i></span>
                  <?php } ?>
                </td>
              </tr>              
              <tr>
                <td><?php echo $text_ioncube; ?></td>
                <td><?php if ($ioncube) { ?>
                  <?php echo $text_on; ?>
                  <?php } else { ?>
                  <?php echo $text_off; ?>
                  <?php } ?></td>
                <td><?php echo $text_on; ?></td>
                <td class="text-center"><?php if ($ioncube) { ?>
                  <span class="text-success"><i class="fa fa-check-circle svg-icn check"><svg class="icon icon--check"><use xlink:href="#Check_Circle" /></svg>

</i></span>
                  <?php } else { ?>
                  <span class="text-danger"><i class="fa fa-minus-circle svg-icn delete"><svg class="icon icon--check"><use xlink:href="#Check_Close" /></svg></i></span>
                  <?php } ?>
                </td>
              </tr>
              <tr>
                <td><?php echo $text_global; ?></td>
                <td><?php if ($register_globals) { ?>
                  <?php echo $text_on; ?>
                  <?php } else { ?>
                  <?php echo $text_off; ?>
                  <?php } ?>
                </td>
                <td><?php echo $text_off; ?></td>
                <td class="text-center"><?php if (!$register_globals) { ?>
                  <span class="text-success"><i class="fa fa-check-circle svg-icn check"><svg class="icon icon--check"><use xlink:href="#Check_Circle" /></svg>

</i></span>
                  <?php } else { ?>
                  <span class="text-danger"><i class="fa fa-minus-circle svg-icn delete"><svg class="icon icon--check"><use xlink:href="#Check_Close" /></svg></i></span>
                  <?php } ?>
                </td>
              </tr>
              <tr>
                <td><?php echo $text_magic; ?></td>
                <td><?php if ($magic_quotes_gpc) { ?>
                  <?php echo $text_on; ?>
                  <?php } else { ?>
                  <?php echo $text_off; ?>
                  <?php } ?>
                </td>
                <td><?php echo $text_off; ?></td>
                <td class="text-center"><?php if (!$magic_quotes_gpc) { ?>
                  <span class="text-success"><i class="fa fa-check-circle svg-icn check"><svg class="icon icon--check"><use xlink:href="#Check_Circle" /></svg>

</i></span>
                  <?php } else { ?>
                  <span class="text-danger"><i class="fa fa-minus-circle svg-icn delete"><svg class="icon icon--check"><use xlink:href="#Check_Close" /></svg></i></span>
                  <?php } ?>
                </td>
              </tr>
              <tr>
                <td><?php echo $text_file_upload; ?></td>
                <td><?php if ($file_uploads) { ?>
                  <?php echo $text_on; ?>
                  <?php } else { ?>
                  <?php echo $text_off; ?>
                  <?php } ?>
                </td>
                <td><?php echo $text_on; ?></td>
                <td class="text-center"><?php if ($file_uploads) { ?>
                  <span class="text-success"><i class="fa fa-check-circle svg-icn check"><svg class="icon icon--check"><use xlink:href="#Check_Circle" /></svg>

</i></span>
                  <?php } else { ?>
                  <span class="text-danger"><i class="fa fa-minus-circle svg-icn delete"><svg class="icon icon--check"><use xlink:href="#Check_Close" /></svg></i></span>
                  <?php } ?>
                </td>
              </tr>
			  <tr>
				<td><?php echo $text_allow_url_fopen; ?></td>
				<td><?php if ($allow_url_fopen) { ?>
                  <?php echo $text_on; ?>
                  <?php } else { ?>
                  <?php echo $text_off; ?>
                  <?php } ?>
                </td>
				<td><?php echo $text_on; ?></td>
				<td class="text-center"><?php if ($allow_url_fopen) { ?>
                  <span class="text-success"><i class="fa fa-check-circle svg-icn check"><svg class="icon icon--check"><use xlink:href="#Check_Circle" /></svg>

</i></span>
                  <?php } else { ?>
                  <span class="text-danger"><i class="fa fa-minus-circle svg-icn delete"><svg class="icon icon--check"><use xlink:href="#Check_Close" /></svg></i></span>
                  <?php } ?>
                </td>
			  </tr>
              <tr>
                <td><?php echo $text_session; ?></td>
                <td><?php if ($session_auto_start) { ?>
                  <?php echo $text_on; ?>
                  <?php } else { ?>
                  <?php echo $text_off; ?>
                  <?php } ?>
                </td>
                <td><?php echo $text_off; ?></td>
                <td class="text-center"><?php if (!$session_auto_start) { ?>
                  <span class="text-success"><i class="fa fa-check-circle svg-icn check"><svg class="icon icon--check"><use xlink:href="#Check_Circle" /></svg>

</i></span>
                  <?php } else { ?>
                  <span class="text-danger"><i class="fa fa-minus-circle svg-icn delete"><svg class="icon icon--check"><use xlink:href="#Check_Close" /></svg></i></span>
                  <?php } ?>
                </td>
              </tr>
			  <?php /*?>
			  <tr>
                <td><?php echo $text_safe_mode; ?></td>
                <td><?php if ($safeModeOn) { ?>
                  <?php echo $text_on; ?>
                  <?php } else { ?>
                  <?php echo $text_off; ?>
                  <?php } ?>
                </td>
                <td><?php echo $text_off; ?></td>
                <td class="text-center"><?php if (!$safeModeOn) { ?>
                  <span class="text-success"><i class="fa fa-check-circle svg-icn check"><svg class="icon icon--check"><use xlink:href="#Check_Circle" /></svg>

</i></span>
                  <?php } else { ?>
                  <span class="text-danger"><i class="fa fa-minus-circle svg-icn delete"><svg class="icon icon--check"><use xlink:href="#Check_Close" /></svg></i></span>
                  <?php } ?>
                </td>
              </tr> <?php */?>
			  <tr>
                <td><?php echo $text_short_open_tag; ?></td>
                <td><?php if ($short_open_tag) { ?>
                  <?php echo $text_on; ?>
                  <?php } else { ?>
                  <?php echo $text_off; ?>
                  <?php } ?>
                </td>
                <td><?php echo $text_on; ?></td>
                <td class="text-center"><?php if ($short_open_tag) { ?>
                  <span class="text-success"><i class="fa fa-check-circle svg-icn check"><svg class="icon icon--check"><use xlink:href="#Check_Circle" /></svg>

</i></span>
                  <?php } else { ?>
                  <span class="text-danger"><i class="fa fa-minus-circle svg-icn delete"><svg class="icon icon--check"><use xlink:href="#Check_Close" /></svg></i></span>
                  <?php } ?>
                </td>
              </tr> <tr>
                <td><?php echo $text_rewrite_url; ?> (Optional) If Off, then SEO URLs will not work.</td>
                <td><?php if ($rewrite_url) { ?>
                  <?php echo $text_on; ?>
                  <?php } else { ?>
                  <?php echo $text_off; ?>
                  <?php } ?>
                </td>
                <td><?php echo $text_on; ?></td>
                <td class="text-center"><?php if ($rewrite_url) { ?>
                  <span class="text-success"><i class="fa fa-check-circle svg-icn check"><svg class="icon icon--check"><use xlink:href="#Check_Circle" /></svg>

</i></span>
                  <?php } else { ?>
                  <span class="text-danger"><i class="fa fa-minus-circle svg-icn delete"><svg class="icon icon--check"><use xlink:href="#Check_Close" /></svg></i></span>
                  <?php } ?>
                </td>
              </tr>
            </tbody>
          </table>
        </fieldset>
        <p><?php echo $text_install_extension; ?></p>
        <fieldset>
          <table class="table">
            <thead>
              <tr>
                <td width="35%"><b><?php echo $text_extension; ?></b></td>
                <td width="25%"><b><?php echo $text_current; ?></b></td>
                <td width="25%"><b><?php echo $text_required; ?></b></td>
                <td width="15%" class="text-center"><b><?php echo $text_status; ?></b></td>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td><?php echo $text_db; ?></td>
                <td><?php if ($db) { ?>
                  <?php echo $text_on; ?>
                  <?php } else { ?>
                  <?php echo $text_off; ?>
                  <?php } ?>
                </td>
                <td><?php echo $text_on; ?></td>
                <td class="text-center"><?php if ($db) { ?>
                  <span class="text-success"><i class="fa fa-check-circle svg-icn check"><svg class="icon icon--check"><use xlink:href="#Check_Circle" /></svg>

</i></span>
                  <?php } else { ?>
                  <span class="text-danger"><i class="fa fa-minus-circle svg-icn delete"><svg class="icon icon--check"><use xlink:href="#Check_Close" /></svg></i></span>
                  <?php } ?>
                </td>
              </tr>
              <tr>
                <td><?php echo $text_gd; ?></td>
                <td><?php if ($gd) { ?>
                  <?php echo $text_on; ?>
                  <?php } else { ?>
                  <?php echo $text_off; ?>
                  <?php } ?>
                </td>
                <td><?php echo $text_on; ?></td>
                <td class="text-center"><?php if ($gd) { ?>
                  <span class="text-success"><i class="fa fa-check-circle svg-icn check"><svg class="icon icon--check"><use xlink:href="#Check_Circle" /></svg>

</i></span>
                  <?php } else { ?>
                  <span class="text-danger"><i class="fa fa-minus-circle svg-icn delete"><svg class="icon icon--check"><use xlink:href="#Check_Close" /></svg></i></span>
                  <?php } ?>
                </td>
              </tr>
              <tr>
                <td><?php echo $text_curl; ?></td>
                <td><?php if ($curl) { ?>
                  <?php echo $text_on; ?>
                  <?php } else { ?>
                  <?php echo $text_off; ?>
                  <?php } ?>
                </td>
                <td><?php echo $text_on; ?></td>
                <td class="text-center"><?php if ($curl) { ?>
                  <span class="text-success"><i class="fa fa-check-circle svg-icn check"><svg class="icon icon--check"><use xlink:href="#Check_Circle" /></svg>

</i></span>
                  <?php } else { ?>
                  <span class="text-danger"><i class="fa fa-minus-circle svg-icn delete"><svg class="icon icon--check"><use xlink:href="#Check_Close" /></svg></i></span>
                  <?php } ?>
                </td>
              </tr>
              
              <tr>
                <td><?php echo $text_zlib; ?></td>
                <td><?php if ($zlib) { ?>
                  <?php echo $text_on; ?>
                  <?php } else { ?>
                  <?php echo $text_off; ?>
                  <?php } ?>
                </td>
                <td><?php echo $text_on; ?></td>
                <td class="text-center"><?php if ($zlib) { ?>
                  <span class="text-success"><i class="fa fa-check-circle svg-icn check"><svg class="icon icon--check"><use xlink:href="#Check_Circle" /></svg>

</i></span>
                  <?php } else { ?>
                  <span class="text-danger"><i class="fa fa-minus-circle svg-icn delete"><svg class="icon icon--check"><use xlink:href="#Check_Close" /></svg></i></span>
                  <?php } ?>
                </td>
              </tr>
              <tr>
                <td><?php echo $text_zip; ?></td>
                <td><?php if ($zip) { ?>
                  <?php echo $text_on; ?>
                  <?php } else { ?>
                  <?php echo $text_off; ?>
                  <?php } ?>
                </td>
                <td><?php echo $text_on; ?></td>
                <td class="text-center"><?php if ($zip) { ?>
                  <span class="text-success"><i class="fa fa-check-circle svg-icn check"><svg class="icon icon--check"><use xlink:href="#Check_Circle" /></svg>

</i></span>
                  <?php } else { ?>
                  <span class="text-danger"><i class="fa fa-minus-circle svg-icn delete"><svg class="icon icon--check"><use xlink:href="#Check_Close" /></svg></i></span>
                  <?php } ?>
                </td>
              </tr>
			  <tr>
                <td><?php echo $text_json; ?></td>
                <td><?php if ($json) { ?>
                  <?php echo $text_on; ?>
                  <?php } else { ?>
                  <?php echo $text_off; ?>
                  <?php } ?>
                </td>
                <td><?php echo $text_on; ?></td>
                <td class="text-center"><?php if ($json) { ?>
                  <span class="text-success"><i class="fa fa-check-circle svg-icn check"><svg class="icon icon--check"><use xlink:href="#Check_Circle" /></svg>

</i></span>
                  <?php } else { ?>
                  <span class="text-danger"><i class="fa fa-minus-circle svg-icn delete"><svg class="icon icon--check"><use xlink:href="#Check_Close" /></svg></i></span>
                  <?php } ?>
                </td>
              </tr>
			  
              <?php if (!$iconv) { ?>
              <tr>
                <td><?php echo $text_mbstring; ?></td>
                <td>
                  <?php if ($mbstring) { ?>
                  <?php echo $text_on; ?>
                  <?php } else { ?>
                  <?php echo $text_off; ?>
                  <?php } ?>
                </td>
                <td><?php echo $text_on; ?></td>
                <td class="text-center">
                  <?php if ($mbstring) { ?>
                  <span class="text-success"><i class="fa fa-check-circle svg-icn check"><svg class="icon icon--check"><use xlink:href="#Check_Circle" /></svg>

</i></span>
                  <?php } else { ?>
                  <span class="text-danger"><i class="fa fa-minus-circle svg-icn delete"><svg class="icon icon--check"><use xlink:href="#Check_Close" /></svg></i></span>
                  <?php } ?>
                </td>
              </tr>
              <?php } ?>
            </tbody>
          </table>
        </fieldset>
        <p><?php echo $text_msql_version; ?></p>
        <p><?php echo $text_strict_trans_tables; ?></p>
        <p><?php echo $text_note; ?></p>
                
      </form>
    </div>    
  </div>
</div>
