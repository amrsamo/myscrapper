<?php


$count = 0;
$loop = true;
while($loop)
{   
    $count++;
    // printme('<h2>Loop number '.$count.'</h2>');
    foreach ($photography_media['medias'] as $photo) {

        $owner_id      = $photo->ownerId;
        $owner_account = $x->testGetAccountById($owner_id);
        
        

        if($owner_account)
        {   
            $user_data = array();
            $user_data['username'] = $owner_account->username;
            $user_data['url'] = 'https://www.instagram.com/'.$owner_account->username.'/';
            $user_data['followers'] = $owner_account->followedByCount;
            $user_data['hashtag']       = $hashtag;
            $user_data['externalUrl']       = $owner_account->externalUrl;
            $user_data['location']       = getPhotoLocation($user_data['username']);

            if($user_data['location'] != "")
            {
                $locationCoords = getCoordinates($user_data['location']);
                $CountryCity    = getLocationByCoords($locationCoords[0],$locationCoords[1]);
                if(!empty($CountryCity) || !$CountryCity)
                {
                    $user_data['country'] = $CountryCity['country'];
                    $user_data['city'] = $CountryCity['city'];
                }
                else
                {
                    $user_data['country'] = "";
                    $user_data['city'] = "";
                }
            }
            else
            {
                $user_data['country'] = "";
                $user_data['city'] = "";
            }

            $user_data['instagram_unique_id']       = $owner_account->id;
            $user_data['fullName']       = $owner_account->fullName;
            $user_data['profilePicUrl']       = $owner_account->profilePicUrl;
            $user_data['biography']       = $owner_account->biography;
            $user_data['followsCount']       = $owner_account->followsCount;
            $user_data['mediaCount']       = $owner_account->mediaCount;
            $user_data['isPrivate']       = $owner_account->isPrivate;
            $user_data['isVerified']       = $owner_account->isVerified;

            saveMails(getMails($owner_account->biography),$user_data);
        }
        
    }
    if($photography_media['hasNextPage'])
    {   
        // $length = count($photography_media['medias']) - 1;
        // $maxID = $photography_media['medias'][$length]->id;
        $maxID = $photography_media['maxId'];
        save_cron_jon($hashtag,$maxID);
        $photography_media = $x->getMediaByTag($hashtag,$maxID);
        $loop = true;
    }
    else
    {
        $loop = false;
    }
}

exit();




function save_cron_jon($hashtag,$max)
{
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
        $sql = "INSERT INTO insta_request (hashtag,max)
                VALUES ('".$hashtag."', '".$max."')";


        if (mysqli_query($conn, $sql)) {
        echo "New Job Record created successfully";
        } else {
            echo "Error: " . $sql . "<br>" . mysqli_error($conn);
        }

        $conn->close();
}

function getCoordinates($address){
        $address = urlencode($address);
        $url = "http://maps.google.com/maps/api/geocode/json?sensor=false&address=" . $address;
        $response = file_get_contents($url);
        $json = json_decode($response,true);
        
        if(isset($json['results'][0]))
        {
            $lat = $json['results'][0]['geometry']['location']['lat'];
            $lng = $json['results'][0]['geometry']['location']['lng'];
        }
        else
        {
            $lat = 0;
            $lng = 0;
        }
        
     
        return array($lat, $lng);
    }

    function getLocationByCoords($lat,$long)
    {

        if($lat == 0 && $long == 0)
            return false;

        $url = "http://maps.googleapis.com/maps/api/geocode/json?latlng=$lat,$long&sensor=false";

        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_HEADER, false);
        curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_ENCODING, "");
        $curlData = curl_exec($curl);
        curl_close($curl);

        $address = json_decode($curlData);
        $address = $address->results[0]->address_components;
        foreach ($address as $x) {
            
            if($x->types[0] == 'administrative_area_level_1')
                $city = $x->long_name;
            if($x->types[0] == 'country')
                $country = $x->long_name;
            
        }

        $output = array();
        $output['city'] = $city;
        $output['country'] = $country;
        
        return $output;
    }


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
        $sql = "INSERT INTO mails_scrap (email,username,url,followers,hashtag, externalUrl, location,instagram_unique_id,fullName,profilePicUrl ,biography,followsCount,mediaCount,isPrivate,isVerified,country,city)
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
                           '".$isVerified."',
                           '".$user_data['country']."',
                           '".$user_data['city']."'


                        )";


        if (mysqli_query($conn, $sql)) {
        echo "New record created successfully";
        } else {
            echo "Error: " . $sql . "<br>" . mysqli_error($conn);
        }
    }

    $conn->close();
}

