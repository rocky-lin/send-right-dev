@extends('layouts.app')

@section('content')
	<div class="container">
		<div class="row">
			<div class="panel panel-default">
				<div class="panel-heading">Payment success</div>
				<div class="panel-body">
					<h2>Congratulation!</h2>
 					<br>
					<h4>
						<span class="glyphicon glyphicon-ok" aria-hidden="true"></span>	Your account is ready and thank you for choosing us.
					</h4>
					<br><br>

					<a href="{{url('/home')}}">
						<button class="btn btn-success"> Back to home page </button>
					</a>

				</div>
			</div>
		</div>
	</div>
@endsection