@extends('layouts.app')

@section('content')     
    <link rel="stylesheet" href="{{ asset('plugins/intel-input/css/intlTelInput.css') }}">
	<section class="gray-bg section-padding" id="login-page">

        <div class="container text-center">

            @include('common/flash-message')

            <div class="section-title">
                <h3 class="m50px c-white font-35">Extreme Cloud Accelerator User Registration</h3>
            </div>

        <form class="form-horizontal" method="POST" action="{{ route('register') }}">
            {{ csrf_field() }}
            <div class="row">
                <div class="col-md-8 col-md-offset-2">
					
                    <div class="input-field form-group">
                        <input id="phone" name="phone" type="tel" placeholder="Phone Number" value="">	
                    </div>
                    <br>
                    <div class="input-field form-group">
                        <input id="password" name="password" class="validate required" value="" placeholder="Password" required type="password">                       
                    </div>
                    <br>
                    <div class="input-field form-group">
                        <input id="password_confirm" name="password_confirmation" class="validate required" value="" placeholder="Confirm Password" required type="password">
                    </div>
                    <br>
                    <div class="input-field form-group">
                        <input type="text" readonly name="inviteCode" value="<?php echo isset($_REQUEST['code'])?$_REQUEST['code']:"";?>"  placeholder="Invitation code" class="form-control" >
                    </div>
                    <br>

                    <input type="hidden" value="1" name="area" id="area">
                   
                    <div  class="col-md-12  col-xs-12 mb30px">
                        <button type="submit" class="btn w-250 p-12 waves-effect">Register</button>
                    </div>

                    <div  class="col-md-12  col-xs-12 mb30px">
                        <a href="{{ route('login') }}" >Already have an account? Sign in now!</a>
                    </div>



            </div>
			
			
           
        </form>
    </div>
</section>
<script src="{{asset('plugins/intel-input/js/intlTelInput.js') }}"></script>
<script>
   var input = document.querySelector("#phone");
   window.intlTelInput(input, {			  
       utilsScript: "plugins/intel-input/js/utils.js",
   });
</script>
  @stop 
