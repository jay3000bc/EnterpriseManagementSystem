<?php
if(!isset($_COOKIE['politics'])) {
    $cookie_name = "politics";
    $cookie_value = 1;
    setcookie($cookie_name, $cookie_value, time() + (86400 * 90), "/"); // 86400 = 1 day
    $_COOKIE['politics'] = 1 ;
}
if(!isset($_COOKIE['sports'])) {
    $cookie_name = "sports";
    $cookie_value = 1;
    setcookie($cookie_name, $cookie_value, time() + (86400 * 90), "/"); // 86400 = 1 day
    $_COOKIE['sports'] = 1 ;
}
if(!isset($_COOKIE['outlook'])) {
    $cookie_name = "outlook";
    $cookie_value = 1;
    setcookie($cookie_name, $cookie_value, time() + (86400 * 90), "/"); // 86400 = 1 day
    $_COOKIE['outlook'] = 1 ;
}
if(!isset($_COOKIE['ndtv'])) {
    $cookie_name = "ndtv";
    $cookie_value = 1;
    setcookie($cookie_name, $cookie_value, time() + (86400 * 90), "/"); // 86400 = 1 day
    $_COOKIE['ndtv'] = 1 ;
} 
if(!isset($_COOKIE['world'])) {
    $cookie_name = "world";
    $cookie_value = 1;
    setcookie($cookie_name, $cookie_value, time() + (86400 * 90), "/"); // 86400 = 1 day
    $_COOKIE['world'] = 1 ;
} 
if(!isset($_COOKIE['technology'])) {
    $cookie_name = "technology";
    $cookie_value = 1;
    setcookie($cookie_name, $cookie_value, time() + (86400 * 90), "/"); // 86400 = 1 day
    $_COOKIE['technology'] = 1 ;
} 
if(!isset($_COOKIE['assam'])) {
    $cookie_name = "assam";
    $cookie_value = 1;
    setcookie($cookie_name, $cookie_value, time() + (86400 * 90), "/"); // 86400 = 1 day
    $_COOKIE['assam'] = 1 ;
} 

// India & Politics

if(isset($_COOKIE['politics']) && $_COOKIE['politics'] == 1) {
    $rssPolitics = simplexml_load_file('https://economictimes.indiatimes.com/news/politics-and-nation/rssfeeds/1052732854.cms');
    $feedPolityHeading = $rssPolitics->channel->title;
    foreach ($rssPolitics->channel->item as $item) {
        $feedPoliticsDesc .= '<h5><a href="'. $item->link .'" target="_blank">' . $item->title . "</a></h5>";
        $feedPoliticsDesc .= "<p>" . $item->description . "</p>";
    }
}
// sports
if(isset($_COOKIE['sports']) && $_COOKIE['sports'] == 1) {
    $rssSports = simplexml_load_file('https://timesofindia.indiatimes.com/rssfeeds/4719148.cms');
    $feedSportsHeading = 'Sports';
    foreach ($rssSports->channel->item as $item) {
        $feedSportsDesc .= '<h5><a href="'. $item->link .'" target="_blank">' . $item->title . "</a></h5>";
        $feedSportsDesc .= "<p>" . $item->description . "</p>";
    }
}    
// Outlook India
if(isset($_COOKIE['outlook']) && $_COOKIE['outlook'] == 1) {
    $rssOutlook = simplexml_load_file('https://timesofindia.indiatimes.com/rssfeeds/-2128936835.cms');
    //$feedOutlookHeading = $rssOutlook->channel->title;
    $feedOutlookHeading = 'Outlook';
    foreach ($rssOutlook->channel->item as $item) {
        $feedOutlookDesc .= '<h5><a href="'. $item->link .'" target="_blank">' . $item->title . "</a></h5>";
        $feedOutlookDesc .= "<p>" . $item->description . "</p>";
    }
}
// NDTV Top Stories
if(isset($_COOKIE['ndtv']) && $_COOKIE['ndtv'] == 1) {
    $rssNDTV = simplexml_load_file('http://feeds.feedburner.com/ndtvnews-top-stories');
    $feedNDTVHeading = $rssNDTV->channel->title;
    foreach ($rssNDTV->channel->item as $item) {
        $feedNDTVDesc .= '<h5><a href="'. $item->link .'" target="_blank">' . $item->title . "</a></h5>";
        $feedNDTVDesc .= "<p>" . $item->description . "</p>";
    }
}
// World
if(isset($_COOKIE['world']) && $_COOKIE['world'] == 1) {
    $rssWorld = simplexml_load_file('http://www.hindustantimes.com/rss/world/rssfeed.xml');
    $feedWorldHeading = $rssWorld->channel->title;
    foreach ($rssWorld->channel->item as $item) {
        $feedWorldDesc .= '<h5><a href="'. $item->link .'" target="_blank">' . $item->title . "</a></h5>";
        $feedWorldDesc .= "<p>" . $item->description . "</p>";
    }
}
// Technology
if(isset($_COOKIE['technology']) && $_COOKIE['technology'] == 1) {
    $rssTechnology = simplexml_load_file('http://feeds.feedburner.com/TechCrunch/');
    $feedTechnologyHeading = $rssTechnology->channel->title;
    foreach ($rssTechnology->channel->item as $item) {
        $feedTechnologyDesc .= '<h5><a href="'. $item->link .'" target="_blank">' . $item->title . "</a></h5>";
        $feedTechnologyDesc .= "<p>" . $item->description . "</p>";
    }
}

// Assam
if(isset($_COOKIE['assam']) && $_COOKIE['assam'] == 1) {
    $rssAssam = simplexml_load_file('http://newsrack.in/crawled.feeds/at.rss.xml');
    //$feedAssamHeading = $rssAssam->channel->title;
    $feedAssamHeading = 'The Asssam Tribune';
    foreach ($rssAssam->channel->item as $item) {
        $feedAssamDesc .= '<h5><a href="'. $item->link .'" target="_blank">' . $item->title . "</a></h5>";
        $feedAssamDesc .= "<p>" . $item->description . "</p>";
    }
}
?>