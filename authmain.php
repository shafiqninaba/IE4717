<!-- script to authenticate user login -->
<?php
include "dbconnect.php";
session_start();
if (isset($_POST['username']) && isset($_POST['password']))
{
  // if the user has just tried to log in
  $username = $_POST['username'];
  $password = md5($_POST['password']);
  $query = 'select * from site_user '
           ."where email_address='$username' "
           ." and password='$password'";
  $result = $dbcnx->query($query);
  echo $result->num_rows;
  
  if ($result->num_rows >0 )
  {
    // if they are in the database, initialise session id
    $_SESSION['valid_user'] = $username;

    $row = $result->fetch_assoc();
    $_SESSION['user_id'] = $row['id'];
  }
  else
  {
    echo "<script>alert('Invalid username or password!'); window.location.href = 'login.php'; </script>";
    exit();
  }
  $dbcnx->close();
  header("Location: index.php");
}

?>