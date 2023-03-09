<!DOCTYPE html>
<html>
<head>
	<title>UbuntuNet Conference registration</title>
	<link rel="stylesheet" type="text/css" href="style.css">
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
	<script src="script.js"></script>
</body>
</html>
