<?php
require '../vendor/autoload.php';

use InstagramScraper\Instagram;
use PHPUnit\Framework\TestCase;


class InstagramTest 
{
    public function testGetAccountByUsername()
    {
        $account = Instagram::getAccount('amr__p');
        echo '<pre>'.print_r($account,true).'</pre>';
        exit();
        $this->assertEquals('kevin', $account->username);
        $this->assertEquals('3', $account->id);
    }

    public function testGetAccountById($id)
    {
        $account = Instagram::getAccountById($id);
        return $account;
        // $this->assertEquals('kevin', $account->username);
        // $this->assertEquals('3', $account->id);
    }

    public function testGetMedias()
    {
        $medias = Instagram::getMedias('kevin', 80);
        $this->assertEquals(80, sizeof($medias));
    }

    public function testGet1000Medias()
    {
        $medias = Instagram::getMedias('kevin', 1000);
        $this->assertEquals(1000, sizeof($medias));
    }

    public function testGetMediaByCode()
    {
        $media = Instagram::getMediaByCode('BHaRdodBouH');
        $this->assertEquals('kevin', $media->owner->username);
    }

    public function testGetMediaByUrl()
    {
        $media = Instagram::getMediaByUrl('https://www.instagram.com/p/BHaRdodBouH');
        echo '<pre>'.print_r($media,true).'</pre>';
        exit();
        $this->assertEquals('kevin', $media->owner->username);
    }

    public function testGetLocationTopMediasById()
    {
        $medias = Instagram::getLocationTopMediasById(1);
        $this->assertEquals(9, count($medias));
    }

    public function testGetLocationMediasById()
    {
        $medias = Instagram::getLocationMediasById(1);
        $this->assertEquals(12, count($medias));
    }

    public function testGetLocationById()
    {
        $location = Instagram::getLocationById(1);
        $this->assertEquals('Dog Patch Labs', $location->name);
    }

    public function getMediaByTag($tag,$maxID = '')
    {
        $medias = Instagram::getPaginateMediasByTag($tag,$maxID);
        return $medias;
        // echo '<pre>'.print_r($medias,true).'</pre>';
    }

}


// $hashtags = array('restaurants','petcare','daycar','airline','airlines','travel','weddingphotography','makeupartist','makeup','influencer','influencers','traveler','travelers','fitness','hotels','brands','hairstylist','interiordesign','interiordesigner','eventplanner','weddingplanner','fashiondesigner','fashionstylist','barber','grocery','supermarket');

// $index = array_rand($hashtags,1);
// $hashtag = $hashtags[$index];





$hashtags = "#love
#instagood
#me
#tbt
#cute
#follow
#followme
#photooftheday
#happy
#tagforlikes
#beautiful
#self
#girl
#picoftheday
#like4like
#smile
#friends
#fun
#like
#fashion
#summer
#instadaily
#igers
#instalike
#food
#swag
#amazing
#tflers
#follow4follow
#bestoftheday
#likeforlike
#instamood
#style
#wcw
#family
#141
#f4f
#nofilter
#lol
#life
#pretty
#repost
#hair
#my
#sun
#webstagram
#iphoneonly
#art
#tweegram
#cool
#followback
#instafollow
#instasize
#bored
#instacool
#funny
#mcm
#instago
#instasize
#vscocam
#girls
#all_shots
#party
#music
#eyes
#nature
#beauty
#night
#fitness
#beach
#look
#nice
#sky
#christmas
#baby
#Torontobeautyblogger
#bbloggersca
#Torontofashionblogger
#torontofashionbloggers
#torontoblogger
#miamiblogger
#chicagoblogger
#NYCblogger
#houstonblogger
#midwestblogger
#LAblogger
#toronto
#newyork
#newyorkcity
#canada
#beauty
#blog
#unitedstates
#fashionista
#fashion
#style
#blogger
#youtube
#brasil
#bloggers
#bloggerlife
#blogs
#fashionblogger
#nyc
#ny
#newyorker
#newyorkcity
";

$hashtags = explode('#', $hashtags);
foreach ($hashtags as $x => $value) {
    $hashtags[$x] = trim($value);
}


unset($hashtags[0]);

// printme($hashtags);
// exit();






// exit();

// $hashtags = array('Torontobeautyblogger','bbloggersca','Torontofashionblogger','torontofashionbloggers','torontoblogger','miamiblogger','chicagoblogger','NYCblogger','houstonblogger','midwestblogger','LAblogger','toronto','newyork','newyorkcity','canada','beauty','blog','unitedstates','fashionista','fashion','style','blogger','youtube','brasil','bloggers','bloggerlife','blogs','fashionblogger','nyc','ny','newyorker','newyorkcity');

$index =file_get_contents("index.txt");
$index = intval($index);

if($index == count($hashtags))
{
    $index = 1;
}

$hashtag = $hashtags[$index];
$new_index = $index+1;
file_put_contents('index.txt',$new_index);

// printme($hashtag);
// exit();


$x = new InstagramTest();
$max_id = get_cron_request($hashtag);

// printme($hashtags);
// printme($max_id);

if($max_id)
{
    $photography_media = $x->getMediaByTag($hashtag,$max_id);
}
else
{
    $photography_media = $x->getMediaByTag($hashtag);
}


include('instagram_script.php');


function get_cron_request($hashtag)
{
    $servername = "localhost";
    $username = "root";
    $password = "root";
    $dbname = "insta_mails";

    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);
    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    } 

    $sql = "SELECT * FROM `insta_request` where hashtag = '".$hashtag."' order by id desc limit 1";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // output data of each row
        while($row = $result->fetch_assoc()) {
            return $row['max'];
        }
    } else {
        return false;
    }
    $conn->close();
}


function printme($string)
{
    echo '<pre>'.print_r($string,true).'</pre>';
}