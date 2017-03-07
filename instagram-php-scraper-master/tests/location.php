<?php 

	//create MySQL connection   
$sql = "SELECT * FROM mails_scrap where location is null";


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

	$result = $conn->query($sql);


	while ($row=mysqli_fetch_object($result))
    {
    	$username = $row->username;
    	$instaResult= file_get_contents('https://www.instagram.com/'.$username.'/media/');
		$insta = json_decode($instaResult);
		foreach ($insta->items as $item) {

			if(!isset($item->location->name))
				continue;

			$location = $item->location->name;
			if($location != "")
			{
				$sql = "UPDATE mails_scrap SET location='".$location."' WHERE username='".$username."' ";
				if ($conn->query($sql) === TRUE) {
				    break;
				} else {
				    continue;
				}

			}
			
		}
    }
	echo 'done';
	exit();

	



function printme($x)
    {
        echo '<pre>'.print_r($x,true).'</pre>';
    } 
 ?>