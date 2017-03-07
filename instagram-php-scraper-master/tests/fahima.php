<?php



$sql = "SELECT id,fullName,url,email,instagram_unique_id,followers,externalUrl,hashtag,location FROM `mails_scrap` where hashtag in ('Torontobeautyblogger','Canadianlifestyleblogger','bbloggersca','Torontofashionblogger','torontofashionbloggers','torontoblogger','miamiblogger','chicagoblogger','NYCblogger','houstonblogger','midwestblogger','LAblogger','toronto','newyork','newyorkcity','canada','beauty','blog','unitedstates','fashionista','fashion','style','blogger'
,'artist','model','fashiondesigner','makeupartist','traveler','travel','fashionstylist') and email not like '%na_%' and mediaCount > 20 and followers > 1000 and conner != -1
ORDER BY `mails_scrap`.`followers`  DESC limit 5000";

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


$date = date("Y/m/d");
// $filename = 'instagram-data-influencer-conner';
$filename = 'instagram-data-fahima-'.$date;
$file_ending = "xls";
// header info for browser
header("Content-Type: application/xls");    
header("Content-Disposition: attachment; filename=$filename.xls");  
header("Pragma: no-cache"); 
header("Expires: 0");
/*******Start of Formatting for Excel*******/   
//define separator (defines columns in excel & tabs in word)
$sep = "\t"; //tabbed character
//start of printing column names as names of MySQL fields
 while ($fieldinfo=mysqli_fetch_field($result))
    {
    	echo $fieldinfo->name. "\t";
    }
print("\n");    
//end of printing column names  
//start while loop to get data
$ids = array();
    while($row = mysqli_fetch_row($result))
    {
        $schema_insert = "";
        $ids[] = $row[0];
        for($j=0; $j<mysqli_num_fields($result);$j++)
        {   

            if(!isset($row[$j]))
                $schema_insert .= "NULL".$sep;
            elseif ($row[$j] != ""){
                if($j == 1)
                $value = clean($row[$j]);
                else
                $value =  utf8_decode($row[$j]);
                $schema_insert .= "$value".$sep;
            }
            else
                $schema_insert .= "".$sep;
        }
        $schema_insert = str_replace($sep."$", "", $schema_insert);
        $schema_insert = preg_replace("/\r\n|\n\r|\n|\r/", " ", $schema_insert);
        $schema_insert .= "\t";
        print(trim($schema_insert));
        print "\n";
    }  

    markEnteries($ids);
    exit();



    function clean($string) {
   $string = str_replace(' ', '-', $string); // Replaces all spaces with hyphens.

   return preg_replace('/[^A-Za-z0-9\-]/', '', $string); // Removes special chars.
}

    function printme($x)
    {
        echo '<pre>'.print_r($x,true).'</pre>';
    } 


    function markEnteries($ids)
    {   

        
        $ids = implode("','",$ids);

        $servername = "localhost";
        $username = "root";
        $password = "root";
        $dbname = "insta_mails";

        $sql = "update mails_scrap set conner = -1 where id in ('$ids')";



        $conn = mysqli_connect($servername, $username, $password, $dbname);
        // Check connection
        if (!$conn) {
            die("Connection failed: " . mysqli_connect_error());
        }

        $result = $conn->query($sql);

        
    }
?>
