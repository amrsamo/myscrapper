<?php 


$sql = "SELECT id FROM `mails_scrap` where email not like '%na_%' and followers > 1000  and fullName != '' and mediaCount > 20 and hashtag not in ('Torontobeautyblogger','Canadianlifestyleblogger','bbloggersca','Torontofashionblogger','torontofashionbloggers','torontoblogger','miamiblogger','chicagoblogger','NYCblogger','houstonblogger','midwestblogger','LAblogger') order by followers desc limit 500";




$servername = "localhost";
$username = "root";
$password = "root";
$dbname = "insta_mails";



$conn = mysqli_connect($servername, $username, $password, $dbname);
// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
$ids = array();
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_assoc()) {
        $id = $row['id'];
        $ids[] = $id;
    }
} else {
    echo "0 results";
}

$ids = implode("','",$ids);

 		$servername = "localhost";
        $username = "root";
        $password = "root";
        $dbname = "insta_mails";

        $sql = "update mails_scrap set hashtag='nycbloggers' where id in ('$ids')";



        $conn = mysqli_connect($servername, $username, $password, $dbname);
        // Check connection
        if (!$conn) {
            die("Connection failed: " . mysqli_connect_error());
        }

        $result = $conn->query($sql);




function get_numerics ($str) {
    preg_match_all('/\d+/', $str, $matches);
    return $matches[0];
}

function printme($x)
{
    echo '<pre>'.print_r($x,true).'</pre>';
} 