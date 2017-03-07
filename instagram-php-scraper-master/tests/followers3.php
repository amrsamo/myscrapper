
<?php 

ini_set('max_execution_time', 3000000000);
ini_set('memory_limit', '500M'); 

$file = file_get_contents('followers/johanlolos.log');
$file = explode('https://', $file);
// printme($file);
$usernames = array();
$usernames[] = 'johanlolos';
foreach ($file as $x) {
    $x = explode('.com/', $x);
    if(count($x) < 2)
      continue;
    else{
      $username = explode('/', $x[1])[0];
      $usernames[] = $username;
    }
    
}

$usernames = array_unique($usernames);
// printme($usernames);exit();
$count = 0;
foreach ($usernames as $username) 
{


	$result = scrape_insta($username);
	if($result)
	{	
		$result = $result['entry_data']['ProfilePage'][0]['user'];


		$user_data = array();
		$user_data['username'] = $username;
		$user_data['url'] = 'https://www.instagram.com/'.$username.'/';
		$user_data['followers'] = $result['followed_by']['count'];
		$user_data['hashtag']       = 'nycblogger';
		$user_data['externalUrl']       = $result['external_url'];
		$user_data['location']       = 'New York';


		$user_data['instagram_unique_id']       = $result['id'];
		$user_data['fullName']       = $result['full_name'];
		$user_data['profilePicUrl']       = $result['profile_pic_url'];
		$user_data['biography']       = $result['biography'];
		$user_data['followsCount']       = $result['follows']['count'];
		$user_data['mediaCount']       = $result['media']['count'];
		$user_data['isPrivate']       = $result['is_private'];
		$user_data['isVerified']       = $result['is_verified'];


		$mails = getMails($result['biography']);
		saveMails(getMails($result['biography']),$user_data);
	}
}

exit();



 function getBetween($content,$start,$end){
    $r = explode($start, $content);
    if (isset($r[1])){
        $r = explode($end, $r[1]);
        return $r[0];
    }
    return '';
}

// ini_set('max_execution_time', 300000);
// ini_set('memory_limit', '500M'); 

// $files = array();
// $files[] = 'mimiandchichi';
// $files[] = 'nakdfashion';

// foreach ($files as $file) 
// {

// 		$content =file_get_contents("followers/".$file.".txt");

// 		//cremedemichelle followers
// 		$content = html_to_obj($content);
// 		$content = $content['children'][0]['children'][0]['children'];
// 		$usernames = array();
// 		$usernames[]= $file;
// 		foreach ($content as $user) {

// 			$username = $user['children'][0]['children']['0']['children']['0']['href'];
// 			$username = str_replace('/','', $username);
// 			$usernames[] =  $username;
// 			$result = scrape_insta($username);
// 			if($result)
// 			{	
// 				$result = $result['entry_data']['ProfilePage'][0]['user'];

// 				$user_data = array();
// 				$user_data['username'] = $username;
// 				$user_data['url'] = 'https://www.instagram.com/'.$username.'/';
// 				$user_data['followers'] = $result['followed_by']['count'];
// 				$user_data['hashtag']       = $file;
// 				$user_data['externalUrl']       = $result['external_url'];
// 				$user_data['location']       = 'New York';


// 				$user_data['instagram_unique_id']       = $result['id'];
// 				$user_data['fullName']       = $result['full_name'];
// 				$user_data['profilePicUrl']       = $result['profile_pic_url'];
// 				$user_data['biography']       = $result['biography'];
// 				$user_data['followsCount']       = $result['follows']['count'];
// 				$user_data['mediaCount']       = $result['media']['count'];
// 				$user_data['isPrivate']       = $result['is_private'];
// 				$user_data['isVerified']       = $result['is_verified'];

				
// 				$mails = getMails($result['biography']);
// 				saveMails(getMails($result['biography']),$user_data);
// 			}
// 		}



// }






printme($usernames);exit();
























function getPhotoLocation($username)
{
    $instaResult= file_get_contents('https://www.instagram.com/'.$username.'/media/');
    $insta = json_decode($instaResult);
   
    foreach ($insta->items as $item) {

        if(!isset($item->location->name))
            continue;

        $location = $item->location->name;
        if($location != "")
        {
           return $location;
        }

        return '';
        
    }
}







function printme($x)
    {
        echo '<pre>'.print_r($x,true).'</pre>';
    } 


function html_to_obj($html) {
    $dom = new DOMDocument();
    $dom->loadHTML($html);
    return element_to_obj($dom->documentElement);
}

function element_to_obj($element) {
    $obj = array( "tag" => $element->tagName );
    foreach ($element->attributes as $attribute) {
        $obj[$attribute->name] = $attribute->value;
    }
    foreach ($element->childNodes as $subElement) {
        if ($subElement->nodeType == XML_TEXT_NODE) {
            $obj["html"] = $subElement->wholeText;
        }
        else {
            $obj["children"][] = element_to_obj($subElement);
        }
    }
    return $obj;
}


function scrape_insta($username) {
	$insta_source = file_get_contents('http://instagram.com/'.$username);
	$shards = explode('window._sharedData = ', $insta_source);
	$insta_json = explode(';</script>', $shards[1]); 
	$insta_array = json_decode($insta_json[0], TRUE);
	return $insta_array;
}


function getMails($string)
{   
    $mails = array();
    $pattern = '/[A-Za-z0-9_-]+@[A-Za-z0-9_-]+\.([A-Za-z0-9_-][A-Za-z0-9_]+)/';
    preg_match_all($pattern, $string, $matches);
    $matches = $matches[0];
    if(is_array($matches))
    {
        foreach ($matches as $match) {
            $mails[] = $match;
        }
    }

    return $mails;
}

function saveMails($data, $user_data)
{

    if(empty($data))
    {
        $data = array();
        $data[] = 'na_'.$user_data['instagram_unique_id'];
    }
    

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


    
    
    if($user_data['isPrivate'])
        $isPrivate = 1;
    else
        $isPrivate = 0;

    if($user_data['isVerified'])
        $isVerified = 1;
    else
        $isVerified = 0;

    foreach ($data as $mail) {
        $sql = "INSERT INTO mails_scrap (email,username,url,followers,hashtag, externalUrl, location,instagram_unique_id,fullName,profilePicUrl ,biography,followsCount,mediaCount,isPrivate,isVerified)
                VALUES ('".$mail."','".$user_data['username'].
                           "','".$user_data['url'].
                           "',".$user_data['followers'].",
                           '".$user_data['hashtag']."',
                           '".$user_data['externalUrl']."',
                           '".$user_data['location']."',
                           '".$user_data['instagram_unique_id']."',
                           '".$user_data['fullName']."',
                           '".$user_data['profilePicUrl']."',
                           '".$user_data['biography']."',
                           '".$user_data['followsCount']."',
                           '".$user_data['mediaCount']."',
                           '".$isPrivate."',
                           '".$isVerified."'


                        )";


        if (mysqli_query($conn, $sql)) {
        echo "New record created successfully";
        } else {
            echo "Error: " . $sql . "<br>" . mysqli_error($conn);
        }
    }
}
 ?>