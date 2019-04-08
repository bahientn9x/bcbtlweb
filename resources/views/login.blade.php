<!doctype html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" integrity="sha384-WskhaSGFgHYWDcbwN70/dfYBj47jz9qbsMId/iRN3ewGhXQFZCSftd1LZCfmhktB" crossorigin="anonymous">
	<style>
	body{
		background: #e9e9e9;
		font-size: 14px;
	}
	.form-login{
		background: #fafafa;
		margin-top: 10%;
		border-top: 5px solid #33b5e5;
		padding: 50px 0px;
	}
	.form-group .title{
		color: #33b5e5;
		padding-bottom: 40px;
		padding-top: 20px;
	}
	.group-input input[type='email'], .group-input input[type='password'], .alert{
		width: 80%;
		padding: 10px 15px;
		margin: 0 0 20px;
		border: 1px solid #d9d9d9;
		outline: none;
		font-size: 17px;
		margin-left: auto;
		margin-right: auto;
	}
	.alert{
		font-size: 14px;
	}
	.form-group .btn-submmit{
		width: 200px;
		height: 40px;
		margin-top: 30px;
		border-radius: 0;
	}
	.form-group .footer-login{
		height: 60px;
		background: #f2f2f2;
		line-height: 60px;
		cursor: pointer;
	}
	.form-group .btn-login{
		display: none;
	}
	.form-register{
		background: #fafafa;
		margin-top: 10%;
		border-top: 5px solid #33b5e5;
		padding: 50px 0px;
		display: none;	
	}
</style>
<title>Login / Register</title>
</head>
<body>
	<div class="container">
		<div class="row justify-content-center form-group">
			<div class="col-md-5 form-login">
				@if ($errors->any())
				<div class="alert alert-danger">
					<ul>
						@foreach ($errors as $error)
						<li>$error</li>
						@endforeach
					</ul>
				</div>
				@endif
				<form action="{{ route('admin.login.submit') }}" method="post">
					@csrf
					<h3 class="title text-center">Đăng nhập quản trị viên</h3>
					@if (session('notify_login'))
					<div class="alert alert-danger">
						{{ session('notify_login') }}
					</div>
					@endif
					<div class="group-input text-center">
						<input type="email" name="email" placeholder="Email" required value="{{ old('email') }}">
						<input type="password" name="password" placeholder="Password" required value="{{ old('password') }}">
					</div>
					<div class="text-center"><input type="submit" class="btn btn-primary btn-submmit" value="LOGIN"></div>
				</form>
			</div>
			<div class="col-md-12"></div>		
		</div>

	</div>

	<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js" integrity="sha384-smHYKdLADwkXOn1EmN1qk/HfnUcbVRZyYmZ4qpPea6sjB/pTJ0euyQp0Mk8ck+5T" crossorigin="anonymous"></script>
	<script>
		$(document).ready(function () {
			$('.btn-create').on('click', function () {
				$('.form-register').show();
				$('.form-login').hide();
				$('.btn-create').hide();
				$('.btn-login').show();
				$('.form-register input[type=text]').val('');
			});

			$('.btn-login').on('click', function () {
				$('.form-register').hide();
				$('.form-login').show();
				$('.btn-create').show();
				$('.btn-login').hide();
				$('.form-login input[type=text]').val('');
			});

		});
	</script>
</body>
</html>