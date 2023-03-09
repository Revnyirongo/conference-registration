<?php
require_once __DIR__ . '/vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Handle form submission
if (isset($_POST['submit'])) {
    // Retrieving the form data
    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $message = $_POST['message'];
    $country = $_POST['country'];

    // Inserting the form data into the MySQL database
    $servername = "database";
    $username = "user";
    $password = "password";
    $dbname = "registrations";

    $conn = mysqli_connect($servername, $username, $password, $dbname);

    // Checking if the connection is successful
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }

      // Prepare file attachment for insertion into database
    $attachment = '';
    if (!empty($_FILES['attachment']['name'])) {
        $tmp_name = $_FILES['attachment']['tmp_name'];
        $attachment = addslashes(file_get_contents($tmp_name));
    }

    $sql = "INSERT INTO clients (name, email, phone, country, message, attachment)
            VALUES ('$name', '$email', '$phone', '$country', '$message', '$attachment')";

    if (mysqli_query($conn, $sql)) {
        echo "Registration Successful!";
    } else {
        echo "Error: " . $sql . "<br>" . mysqli_error($conn);
    }

    // Get a summary of all registrations
    $result = mysqli_query($conn, "SELECT name, email, phone, country, message FROM clients");
    $registrations = "";
    while ($row = mysqli_fetch_array($result)) {
        $registrations .= "Name: " . $row['name'] . "\nEmail: " . $row['email'] . "\nPhone: " . $row['phone'] . "\nCountry: " . $row['country'] . "\nMessage: " . $row['message'] . "\n\n";
    }

    // Send email to the organizers
    $mail = new PHPMailer(true);

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
    $mail->setFrom('devops@ubuntunet.net', 'Sender Name');
    $mail->addAddress('devops@ubuntunet.net', 'Organizers');

    // Content
    $mail->isHTML(false);
    $mail->Subject = 'New Client Registration';
    $mail->Body    = "A new client has registered for the UbuntuNet-Connect conference.\n\n";
    $mail->Body   .= "Name: $name\nEmail: $email\nPhone: $phone\nCountry: $country\nMessage: $message\n\n";

    if($mail->send()) {
        echo "An email has been sent to the organizers.";
    } else {
        echo "Registration Successful but Failed to send email to the organizers.";
    }


    mysqli_close($conn);
} 
?>
