@extends('layouts.front')

@section('content')     
   
	<section class="gray-bg section-padding" id="login-page">

        <div class="container text-center">

            @include('common/flash-message')

            <div class="section-title">
                <h3 class="m50px c-white font-35">User Verify With SMS</h3>
            </div>

        <form class="form-horizontal" method="POST" action="{{ route('verify') }}">
            {{ csrf_field() }}
            <div class="row">
                <div class="col-md-8 col-md-offset-2">					
                    
                   
                    <div class="input-field form-group">
                        <div class="pos-relative" >
                            <input type="text" id="verify_code" name="verify_code" placeholder="Verification code" class="validate required form-control">                           
                        </div>
                    </div>
                   
                    <div  class="col-md-12  col-xs-12 mb30px">
                        <button type="submit" class="btn w-250 p-12 waves-effect">Verification</button>
                    </div>

                   
            </div>
			
			
           
        </form>
    </div>
</section>

  @stop 
