<?php









$sql = "SELECT id,email,username,url,followers,hashtag,externalUrl FROM `mails_scrap` where mediaCount > 250 and conner = 0 and email not like '%na%' and externalUrl != '' and hashtag in ('photographer','artist','dj','youtuber','model','promoter','videographer','dancer','musician','photography','talent','hiphop','interiordesign','weddingphotography','fashiondesigner','interiordesigner','fashionista') order by followers desc limit 300";

//Dancer Queryy
// $sql = "SELECT email,username,url,followers,hashtag,externalUrl FROM `mails_scrap` where mediaCount > 700 and conner = 0 and email not like '%na%' and externalUrl != '' and hashtag = 'dancer' order by id desc limit 100";




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
$filename = 'instagram-data-conner-'.$date;
$file_ending = "xls";
//header info for browser
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
    // echo mysqli_field_name($fieldinfo->name) . "\t";
    	echo $fieldinfo->name. "\t";
    }
// for ($i = 0; $i < mysqli_num_fields($result); $i++) {
// 	echo '<pre>'.print_r($result,true).'</pre>';
// 	exit();
// echo mysqli_field_name($result,$i) . "\t";
// }
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
                $value = $row[$j];
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

    function printme($x)
    {
        echo '<pre>'.print_r($x,true).'</pre>';
    } 


    function clean($string) {
   $string = str_replace(' ', '-', $string); // Replaces all spaces with hyphens.

   return preg_replace('/[^A-Za-z0-9\-]/', '', $string); // Removes special chars.
}

     function markEnteries($ids)
    {   

        $ids = implode("','",$ids);

        $servername = "localhost";
        $username = "root";
        $password = "root";
        $dbname = "insta_mails";

        $sql = "update mails_scrap set conner = 1 where id in ('$ids')";



        $conn = mysqli_connect($servername, $username, $password, $dbname);
        // Check connection
        if (!$conn) {
            die("Connection failed: " . mysqli_connect_error());
        }

        $result = $conn->query($sql);

        
    }
?>
