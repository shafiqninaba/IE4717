<!-- script to authenticate user login -->
<?php
include "dbconnect.php";
session_start();
// initialise form variables from account.php
$email = $_POST['email'];
$password = md5($_POST['password']);
$firstname = $_POST['firstname'];
$lastname = $_POST['lastname'];
$gender = $_POST['gender'];
$mobile = $_POST['mobile'];
$address = $_POST['address'];
$date_of_birth = $_POST['dob'];
$user_id = $_SESSION['user_id'];

$query = "UPDATE user_info SET first_name=?,last_name=?,mobile_number=?,gender=?,date_of_birth=?,delivery_address=? WHERE user_id=?";
$stmt = $dbcnx->prepare($query);
$stmt->bind_param('ssssssi',$firstname, $lastname, $mobile, $gender, $date_of_birth, $address, $user_id);
$stmt->execute();
$stmt->free_result();

$query = "UPDATE site_user SET email_address=?,password=? WHERE id=?";
$stmt = $dbcnx->prepare($query);
$stmt->bind_param('ssi',$email, $password, $user_id);
$stmt->execute();
$stmt->free_result();
$dbcnx->close();

$_SESSION['valid_user'] = $email;

header("Location: account.php");

?>