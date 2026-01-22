// AJAX form submit handler for login
$("#login_form").submit(function (e) {
	e.preventDefault();

	$.post("index.php",
		{
			action: 'login',
			email: $("#email").val(),
			password: $("#password").val()
		},
		function (res) {
			// Redirect on success, show error on failure
			if (res.trim() == "success") {
				window.location.href = "home.php";
			} else {
				$("#msg").text("Invalid Login Details");
				setTimeout(function () {
					$('#msg').fadeOut(500, function () {
						$(this).text('').show();
					});
				}, 2000);
			}
		}
	);
});