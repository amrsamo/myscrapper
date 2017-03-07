<?php

exit();

$file = file_get_contents('test');
$ids = explode(',', $file);



unset($ids[count($ids)-1]);

markEnteries($ids);



function markEnteries($ids)
    {   

        
        $ids = implode("','",$ids);

        $servername = "localhost";
        $username = "root";
        $password = "root";
        $dbname = "insta_mails";

        $sql = "update mails_scrap set conner = 0 where id in ('$ids')";

        // printme($sql);
        // exit();

        $conn = mysqli_connect($servername, $username, $password, $dbname);
        // Check connection
        if (!$conn) {
            die("Connection failed: " . mysqli_connect_error());
        }

        $result = $conn->query($sql);

        
    }


    function printme($x)
{
	echo '<pre>'.print_r($x,true).'</pre>';
}
