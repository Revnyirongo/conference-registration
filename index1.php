<!DOCTYPE html>
<html>
<head>
	<title>UbuntuNet-Connect Conference registration</title>
	<style>
		body {
			text-align: center;
		}
		h1 {
			margin-top: 50px;
			margin-bottom: 20px;
		}
		form {
			margin: 0 auto;
			width: 50%;
			text-align: left;
		}
		label {
			display: inline-block;
			width: 100px;
			margin-bottom: 10px;
			text-align: right;
		}
		input[type=text], input[type=email], input[type=tel], textarea {
			width: 250px;
			padding: 5px;
			margin-bottom: 10px;
			border: 1px solid #ccc;
			border-radius: 4px;
			box-sizing: border-box;
		}
		input[type=file] {
			margin-top: 10px;
		}
		input[type=submit] {
			background-color: #4CAF50;
			color: white;
			padding: 10px 20px;
			border: none;
			border-radius: 4px;
			cursor: pointer;
			margin-top: 10px;
		}
		input[type=submit]:hover {
			background-color: #45a049;
		}
	</style>
</head>
<body>
	<h1>UbuntuNet-Connect conference registration</h1>
	<form action="" method="POST">
		<label for="name">Name:</label>
		<input type="text" name="name" id="name" required><br>
		<br>
		<label for="email">Email:</label>
		<input type="email" name="email" id="email" required><br>
		<br>
		<label for="phone">Phone:</label>
		<input type="tel" name="phone" id="phone" required><br>
		<br>
		<label for="country">Country:</label>
		<textarea name="country" id="country" rows="1" required></textarea><br>
		<br>
		<label for="message">Message:</label>
		<textarea name="message" id="message" rows="5" required></textarea><br>
		<br>
		<label for="attachment">Attachment:</label>
		<input type="file" name="attachment" id="attachment"><br>
		<input type="submit" name="submit" value="Register">
	</form>
	
<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Include the PHPMailer library
require 'vendor/autoload.php';

// Handle form submission
if (isset($_POST['submit'])) {

    // Send email using PHPMailer
    $mail = new PHPMailer(true);

    try {
        // Establishing a connection to the MySQL database
        $servername = "database";
        $username = "user";
        $password = "password";
        $dbname = "registrations";

        $conn = mysqli_connect($servername, $username, $password, $dbname);

        // Checking if the connection is successful
        if (!$conn) {
            die("Connection failed: " . mysqli_connect_error());
        }

        // Retrieving the form data
        $name = $_POST['name'];
        $email = $_POST['email'];
        $phone = $_POST['phone'];
        $message = $_POST['message'];
        $country = $_POST['country'];
        $attachment = $_FILES['attachment'];

        // Inserting the form data into the MySQL database
        $sql = "INSERT INTO clients (name, email, phone, message)
                VALUES ('$name', '$email', '$phone', '$message')";

        if (mysqli_query($conn, $sql)) {
            echo "Registration Successful!";
        } else {
            echo "Error: " . $sql . "<br>" . mysqli_error($conn);
        }

        // Get a summary of all registrations
        $result = mysqli_query($conn, "SELECT name, email, phone, message FROM clients");
        $registrations = "";
        while ($row = mysqli_fetch_array($result)) {
            $registrations .= "Name: " . $row['name'] . "\nEmail: " . $row['email'] . "\nPhone: " . $row['phone'] . "\nMessage: " . $row['message'] . "\n\n";
        }

        // Server settings
        $mail->SMTPDebug = 0;
        $mail->isSMTP();
        $mail->Host       = 'smtp.sparkpostmail.com';
        $mail->SMTPAuth   = true;
        $mail->Username   = 'SMTP_Injection';
        $mail->Password   = 'b41b5387e9104d465f00d6b472ce3b84e5bcbdea';
        $mail->SMTPSecure = 'tls';
        $mail->Port       = 587;

        // Recipients
        $mail->setFrom('revnyirongo@live.com', 'Client Registration');
        $mail->addAddress('devops@ubuntunet.net', 'Organizers');

        // Attach file if uploaded
        if ($attachment['name']) {
            $mail->addAttachment($attachment['tmp_name'], $attachment['name']);
        }

        // Content
        $mail->isHTML(false);
        $mail->Subject = 'New Client Registration';
        $mail->Body    = "A new client has registered. Details are as follows:\n\nName: $name\nEmail: $email\nPhone: $phone\nMessage: $message\n\nSummary of all registrations:\n\n$registrations";

        $mail->send();
        echo 'Registration successful!';
    } catch (Exception $e) {
        echo "Registration failed: {$mail->ErrorInfo}";
    }
}
?>
</body>
</html>