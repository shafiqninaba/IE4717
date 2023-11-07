<!-- script to submit newsletter email to SQL table -->
<?php
include "dbconnect.php";
    if(isset($_POST['newsletter_email'])){
        $email = $_POST['newsletter_email'];
        // check if email is already in newsletter
        $query = "SELECT * FROM newsletter WHERE email_address = ?";
        $stmt = $dbcnx->prepare($query);
        $stmt->bind_param('s',$email);
        $stmt->execute();
        $result = $stmt->get_result();  
        $num_results = $result->num_rows;
        if ($num_results > 0) {
            echo "<script>alert('This email has been signed up for the newsletter!');</script>";
            echo "<script>window.history.go(-1);</script>";
            exit();
        }
        else{
        $query = "INSERT INTO newsletter (email_address) VALUES (?)";
        $stmt = $dbcnx->prepare($query);
        $stmt->bind_param('s',$email);
        $stmt->execute();
        $stmt->free_result();
        $dbcnx->close();
        if($result){
            echo "<script>alert('Thank you for subscribing to our newsletter!')</script>";
            echo "<script>window.history.go(-1);</script>";
            exit();
        }
        exit();
    }
    }