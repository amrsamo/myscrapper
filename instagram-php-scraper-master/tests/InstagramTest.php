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

    public function getMediaByTag1($tag)
    {
        $medias = Instagram::getMediasByTag($tag);
        return $medias;
        // echo '<pre>'.print_r($medias,true).'</pre>';
    }

}








// $hashtags = array('restaurants','petcare','daycar','airline','airlines','travel','weddingphotography','makeupartist','makeup','influencer','influencers','traveler','travelers','fitness','hotels','brands','hairstylist','interiordesign','interiordesigner','eventplanner','weddingplanner','fashiondesigner','fashionstylist','barber','grocery','supermarket');

// $index = array_rand($hashtags,1);
// $hashtag = $hashtags[$index];

$x = new InstagramTest();
$hashtag = 'torontoblogger';
$photography_media = $x->getMediaByTag($hashtag);

include('instagram_script.php');


