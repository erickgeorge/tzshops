<!DOCTYPE html>
<html>
<head>
	<title>message</title>
</head>
<body>

	@if(session()->has('message'))
    <div class="alert alert-success">
        {{ session()->get('message') }}
    </div>
@endif
		<form action="{{ url('sms')}}" method="post">
			{{csrf_field()}}
  First name:<br>
  <input type="text" name="mobile" id="mobile"><br>
  <button type="submit">send sms</button>
  
</form>

</body>
</html>