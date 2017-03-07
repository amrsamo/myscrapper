<?php 



  
    $servername = "localhost";
    $username = "root";
    $password = "root";
    $dbname = "insta_mails";

    // Create connection
    $conn = mysqli_connect($servername, $username, $password, $dbname);
    // Check connection
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }

        $sql = "INSERT INTO cron (test) VALUES ('working')";

        if (mysqli_query($conn, $sql)) {
        echo "New record created successfully";
        } else {
            echo "Error: " . $sql . "<br>" . mysqli_error($conn);
        }
