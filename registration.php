<?php
$errors = [];
$success = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['register'])) {


    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);
    $password2 = trim($_POST['password2']);

    // Empty field validation
    if ($name === "") {
        $errors[] = "Name is required.";
    }

    if ($email === "") {
        $errors[] = "Email is required.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Please enter a valid email.";
    }

    if ($password === "") {
        $errors[] = "Password is required.";
    }

    if ($password2 === "") {
        $errors[] = "Confirm Password is required.";
    }

    if ($password !== "" && $password2 !== "" && $password !== $password2) {
        $errors[] = "Passwords do not match.";
    }

    // Save ONLY if no errors
    if (empty($errors)) {

        $filename = 'users.json';
        $data = [];

        if (is_file($filename)) {
            $data = json_decode(file_get_contents($filename), true);
            if (!is_array($data)) {
                $data = [];
            }
        }

        $data[] = [
            'name' => $name,
            'email' => $email,
            'password' => $password
        ];

        file_put_contents($filename, json_encode($data, JSON_PRETTY_PRINT));

        $success = "Registration successful!";
    }
}
?>




<!DOCTYPE html>
<head>
    <title>Registration</title>
    <link rel="stylesheet"  href="style.css">
</head>
<body>
	<img id="bgPhoto" src="bg.jpg" alt="BackGround Photo">

	<?php
		if (!empty($errors)) {
		    echo "<div style='color:red;'>";
		    foreach ($errors as $error) {
		        echo "<p>$error</p>";
		    }
		    echo "</div>";
		}

		if ($success != "") {
		    echo "<p style='color:green;'>$success</p>";
		}
	?>


	<form id="form" method="POST">
		<label> Name  :</label>
		<input type="text" name="name">
		<label> Email  :</label>
		<input type="text" name="email">
		<label> Password  :</label>
		<input type="text" name="password">
		<label> Confirm Password  :</label>
		<input type="text" name="password2">

		<button type="submit" name="register"> Register</button>




	</form>





	<style>
	
		#bgPhoto{
			position: fixed;
			z-index: -1;
			object-fit: cover;
			height: 100%;
			width: 100%;
			background-image: cover;
		}

		#form{
			display: flex;
			flex-direction: column;
			width: 500px;
			margin: 0 auto;
			align-items: center;
			padding: 90px;

		}
		
	</style>




</body>
</html>



