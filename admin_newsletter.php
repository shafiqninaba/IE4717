<?php
session_start();
// function: if user is logged in, return true, else return false
function logged_in() {
  return isset($_SESSION['valid_user']);
}

function is_admin() {
    if (isset($_SESSION['valid_user'])){
        if ($_SESSION['valid_user'] == 'admin@admin.com'  && $_SESSION['admin'] == false){
            $_SESSION['admin'] == true;
            return true;
        }
        else{
            return false;
        }
    }
    else{
        return false;
    }
}
is_admin();

// if not logged_in(), $_SESSION['cart_count'] = 0
if (!logged_in()) {
  $_SESSION['cart_count'] = 0;
}

function header_class($function){
  if ($function) {echo 'hidden';} else {echo '';}
}

include 'dbconnect.php';
if (logged_in()) {
  $username = $_SESSION['valid_user'];
} else {
  header("Location: login.php");
  exit();
}




// function to send email
function send_newsletter($subject, $message){
    include 'dbconnect.php';
// php query all email_address from newsletter table
$query = "SELECT email_address FROM newsletter";
$result = $dbcnx->query($query);
$emails = array();
while ($row = $result->fetch_assoc()){
    $emails[] = $row['email_address'];
}
    $to      = 'f32ee@localhost';
// append all the email addresses in the newsletter table to the top of the message body
$base_message = "The email addresses in the newsletter table are: \n";
foreach($emails as $email){
    $base_message .= $email . "\n";
}
$final_message = $base_message . $message;
$headers = 'From: f32ee@localhost' . "\r\n" .
    'Reply-To: f32ee@localhost' . "\r\n" .
    'X-Mailer: PHP/' . phpversion();
mail($to, $subject, $final_message, $headers,'-ff32ee@localhost');
}

// if form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $subject = $_POST['subject'];
    $message = $_POST['message'];
    send_newsletter($subject, $message);
    echo "<script>alert('Newsletter sent!'); window.location.href = 'admin_newsletter.php'; </script>";
}
?>

<!DOCTYPE html>

<html lang="en">
<head>
    <title>SneakerHive ADMIN</title>
    <link rel="icon" href="images/favicon.ico">
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="styles.css">
    <script src="shipping_validation.js"></script>
</head>

<body>
    <div class= "header" id="myTopnav">
        <a class="" href="index.php" class="logo" ><img src = images/LOGO.svg alt="sneakerhive logo">ADMIN</a>
    </div>

    <div class="account-content-body">
        <div class="sidebar">
            <ul>
                <li><a href="admin_page.php">Dashboard</a></li>
                <li><a href="admin_newsletter.php"><u>Send Newsletter</u></a></li>
                <li><a href="admin_products.php">Edit Products</a></li>
                <li><a href="logout.php">Logout</a></li>
            
            </ul>
        </div>
        <div class="login-container signup">
            <h1>Newsletter</h1>
            <form class="admin_newsletter" action="" method="post">
                <label for="subject">Subject:</label><br>
                <input type="text" id="subject" name="subject" required><br>
                <label for="message">Message:</label><br>
                <textarea id="message" name="message" rows="10" cols="30" required></textarea><br>
                <input type="submit" value="Send">

    </div>
    </div>


    <footer>
    <div class = "footer">
</div>
    <div class="copyright">
      <p>&copy; 2023 SneakerHive. All Rights Reserved.</p>
      </div>
    
    </footer>
        

    
</body>
</html>