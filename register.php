<!-- script to register a user into the database -->
<!-- variables are retrieved from signup.php form using POST -->
<?php
include "dbconnect.php";

// initialise form variables from signup.php
$email = $_POST['email'];
$password = md5($_POST['password']);
$firstname = $_POST['firstname'];
$lastname = $_POST['lastname'];
$gender = $_POST['gender'];
$mobile = $_POST['mobile'];
$address = $_POST['address'];
$date_of_birth = $_POST['dob'];

// check if email already exists
$sql = "SELECT * FROM site_user WHERE email_address=?";
$stmt = $dbcnx->prepare($sql);
$stmt->bind_param('s', $email);
$stmt->execute();
$result = $stmt->get_result();  
$num_results = $result->num_rows;

if ($num_results > 0) {
    echo "<script>alert('Email already exists! Please use a different email.'); window.location.href = 'signup.php'; </script>";
    exit();
} else {
    $stmt->free_result();
    // insert data into site_user table
    $sql = "INSERT INTO site_user (email_address, password) VALUES (?, ?)";
    $stmt = $dbcnx->prepare($sql);
    $stmt->bind_param('ss', $email, $password);
    $stmt->execute();

    // get the user id of the newly inserted row
    $user_id = $stmt->insert_id;

    // insert data into user_info table
    $sql = "INSERT INTO user_info (user_id, first_name, last_name, mobile_number, gender, date_of_birth, delivery_address) 
            VALUES (?, ?, ?, ?, ?, ?, ?)";
    $stmt = $dbcnx->prepare($sql);
    $stmt->bind_param('issssss', $user_id, $firstname, $lastname, $mobile, $gender, $date_of_birth, $address);
    $stmt->execute();

    // redirect to login page
    header("Location: login.php");
    exit();
}
?>