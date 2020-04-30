@extends('layouts.app')

@section('content') 

@if (count($errors) > 0)
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif    
	<div class="container text-center">

		<form class="form-horizontal" method="POST" action="{{ route('login') }}">
                {{ csrf_field() }}
			<div class="row" style="margin-top: 12%">

				<div class="col-md-8 col-md-offset-2">
					
					<div class="input-field form-group{{ $errors->has('email') ? ' has-error' : '' }}">
						<input id="name" name="name" type="input" required placeholder="User Name">							
					</div>
					<div class="input-field form-group">
						<input id="password" name="password" class="validate required" value="" placeholder="Password" required type="password">
						
					</div>
					<div class="input-field form-group">
						<button type="submit" class="btn-primary">Log in</button>
					</div>

					<div  class="col-md-12  col-xs-12 mb30px">
						<a href="{{ route('signup') }}" >No Account, Sign UP</a>
					</div>
				</div>
			</div>					

		</form>
	</div>
	
  @stop  
	