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

    public function getUserMedia($username)
    {
        $medias = Instagram::getMedias($username, 1);
        $this->assertEquals(1, sizeof($medias));
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

    public function getMediaByTag1($tag)
    {
        $medias = Instagram::getMediasByTag($tag);
        return $medias;
        // echo '<pre>'.print_r($medias,true).'</pre>';
    }

}



$x = new InstagramTest();
$username = 'hotels';
// $user_media = $x->getUserMedia($username);

$url = 'https://www.instagram.com/'.$username.'/media/';
$instaResult= file_get_contents('https://www.instagram.com/'.$username.'/media/');
$insta = json_decode($instaResult);
foreach ($insta->items as $item) {
    printme($item);
    // $item_insta= file_get_contents($item->link);
    // $item_insta = json_decode($item_insta);
    // printme($curl_result);
    exit();
}
printme($insta);
exit();

include('instagram_script.php');




function fetchData($url){
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_TIMEOUT, 20);
    $result = curl_exec($ch);
    curl_close($ch);
    return $result;
}

function printme($string)
{
    echo '<pre>'.print_r($string,true).'</pre>';
}