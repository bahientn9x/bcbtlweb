<h2>Chào {{auth::user()->name}}!</h2>
Bạn có 1 yêu cầu rút tiền, xác thực bằng cách click vào link:<br>
{{url('withdrawal/confirmation',session('token'))}}