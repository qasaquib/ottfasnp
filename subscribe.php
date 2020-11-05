<?php

$email = filter_input(INPUT_POST, 'email');

if (!empty($email)){

$host = "localhost";
$dbusername = "root";
$dbpassword = "";
$dbname = "teacher_finder";

// Create connection
$conn = new mysqli ($host, $dbusername, $dbpassword, $dbname);

if (mysqli_connect_error()){
    die('Connect Error('. mysqli_connect_errno() .') '
        .mysqli_connect_error());
}
else{
    $sql = "INSERT INTO subscriber (email_address) values ('$email')";
    if ($conn->query($sql)){
        echo "Thanks for your subcription. Redirecting ....";
        header( "refresh:2;url=home.php" );
    }
    else{
        echo "Error: ". $sql ."<br>". $conn->error;
    }
    $conn->close();
}
}
else{
    echo "Email should not be empty";
    die();
}
?>