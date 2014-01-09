<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<link rel="stylesheet" href="css/style.css">
		<script type "text/javascript" src="js/piwik.js"></script>
		<script src="//code.jquery.com/jquery-1.9.1.js"></script>
		<script src="//ajax.aspnetcdn.com/ajax/jquery.validate/1.9/jquery.validate.min.js"></script>
		<script type="text/javascript" src="js/script.js"></script>

		<!-- Piwik --> 
		<script type="text/javascript">
			var pkBaseURL = (("https:" == document.location.protocol) ? "https://chs.no-ip.org/piwik/" : "http://chs.no-ip.org/piwik/");
			document.write(unescape("%3Cscript src='" + pkBaseURL + "piwik.js' type='text/javascript'%3E%3C/script%3E"));
		</script>
		<script type="text/javascript">
			try {
			var piwikTracker = Piwik.getTracker(pkBaseURL + "piwik.php", 1);
			piwikTracker.trackPageView();
			piwikTracker.enableLinkTracking();
			} catch( err ) {}
		</script>
		<noscript><p><img src="http://chs.no-ip.org/piwik/piwik.php?idsite=1" style="border:0" alt="" /></p></noscript>
		<!-- End Piwik Tracking Code -->
	</head>
	<body>
		<script>
			$(function() {	

				// Setup form validation on the #register-form element
				$("#register-form").validate({
					// Specify the validation rules
					rules: {
						name: "required",
						gender: "required",
						address: "required",
						email: {
							required: true,
							email: true
						},
						username: "required",
						password: {
							required: true,
							minlength: 5
						},
						password2: {
							required: true,
							minlength: 5
						}
					},
					// Specify the validation error messages
					messages: {
						name: "Please enter your name",
						gender: "Please specify your gender",
						address: "Please enter your address",
						email: "Please enter a valid email address",
						username: "Please enter a valid username",
						password: {
							required: "Please provide a password",
							minlength: "Your password must be at least 5 characters long"
						},
						password2: {
							required: "Please confirm your password",
							minlength: "Your password must be at least 5 characters long"
						}
					},
					submitHandler: function(form) {
						form.submit();
					}
				});
			  });
		</script>
		<div>
			<form id="register-form" >
				<div class="label">Name</div><input type="text" id="name" name="name" value="<? echo $name; ?>" /><br />
				<div class="label">Gender</div><select id="gender" name="gender" />
												  <option value="Female">Female</option>
												  <option value="Male">Male</option>
												  <option value="Other">Other</option>
											   </select><br />
				<div class="label">Address</div><input type="text" id="address" name="address" value="<? echo $address; ?>" /><br />
				<div class="label">Email</div><input type="text" id="email" name="email" value="<? echo $email; ?>" /><br />
				<div class="label">Username</div><input type="text" id="username" name="username" value="<? echo $username; ?>" /><br />
				<div class="label">Password</div><input type="password" id="password" name="password" /><br />
				<div class="label">Confirm Password</div><input type="password" id="password2" name="password2" /><br />
				<div style="margin-left:140px;"><input type="submit" name="formSubmitted" value="Submit" /></div>
			</form>			
		</div>
		<div id="formResponse">
		</div>
		<script>
		// form submit
			$('#register-form').submit(function() {
			    $.post('add.php', {
						name: $('#name').val(),
						gender: $('#gender').val(),
						address: $('#address').val(),
						email: $('#email').val(),
						username: $('#username').val(),
						password: $('#password').val(),
						formSubmitted: 'yes',
						password2: $('#password2').val()
					}, 
					function(data) {
						$('#formResponse').html(data).fadeIn('100');
						$('#name, #address, #email, #username, #password, #password2').val(''); /* Clear the inputs */
						$('#gender').val('Female');
					}, 'text');	
				return false;
			});
		</script>
	</body>
</html>