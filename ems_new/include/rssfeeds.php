<?php

require_once 'scrap.php';

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

$feedPoliticsDesc='';
$feedSportsDesc = '';
$feedNDTVDesc = '';
$feedOutlookDesc = '';
$feedTechnologyDesc = '';
$feedAssamDesc = '';

// India & Politics


/*
$url="https://www.ndtv.com/latest#pfrom=home-ndtv_mainnavgation"; 
$ch = curl_init(); 
curl_setopt ($ch, CURLOPT_URL, $url); 
curl_setopt ($ch, CURLOPT_URL, $url); 
curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10);
curl_setopt($ch, CURLOPT_TIMEOUT,10);
curl_setopt($ch,CURLOPT_SSL_VERIFYPEER, false);

$latest = curl_exec ($ch); 
//echo $result;  
curl_close($ch);

if(isset($_COOKIE['politics']) && $_COOKIE['politics'] == 1) {
    $feedPolityHeading = $rssPolitics->channel->title;

    foreach ($rssPolitics->channel->item as $item) {
        $feedPoliticsDesc .= $latest;
    }


}*/


if(isset($_COOKIE['politics']) && $_COOKIE['politics'] == 1) {
   /* $rssPolitics = simplexml_load_file('https://economictimes.indiatimes.com/news/politics-and-nation/rssfeeds/1052732854.cms');
    $feedPolityHeading = $rssPolitics->channel->title;
    foreach ($rssPolitics->channel->item as $item) {
        $feedPoliticsDesc .= '<h5><a href="'. $item->link .'" target="_blank">' . $item->title . "</a></h5>";
        $feedPoliticsDesc .= "<p>" . $item->description . "</p>";
    }*/

    $url="https://www.ndtv.com/world-news"; 

    $latest = scrap($url);
     
    $feedPolityHeading = "World News";

    foreach($latest->find(".lisingNews") as $latestDiv){

       foreach($latestDiv->find('.news_Itm') as $latestPost){

         
            foreach($latestPost->find('.newsHdng') as $latestDiv_heading){

                foreach($latestDiv_heading->find('a') as $latestDiv_link){
                    $feedPoliticsDesc .= '<a href="'.$latestDiv_link->href.'" target="_blank">'.$latestDiv_heading->plaintext.'</a>';
                }

      
            }
            
            foreach($latestPost->find("img") as $latestDiv_img){
                $feedPoliticsDesc .= '<a href="'.$latestDiv_link->href.'" target="_blank">'.'<img src="'.$latestDiv_img->src.'" width="100%"></a><br><br>';
            }

            
       }
      
    }


}
// sports

if(isset($_COOKIE['sports']) && $_COOKIE['sports'] == 1) {

    $url = "https://indianexpress.com/section/sports/";
    $sports = scrap($url);
    $feedSportsHeading = 'Sports';


       // $feedSportsDesc .= 

       foreach($sports->find('.articles') as $sports_post){

            foreach($sports_post->find('.title') as $sports_title){

                foreach($sports_title->find('a') as $sports_href){
                    $feedSportsDesc .= '<a href="'.$sports_href->href.'" target="_blank">'.$sports_title->plaintext.'</a><br>';
                }


                foreach($sports_post->find('img') as $sports_img){

                    $feedSportsDesc .='<a href="'.$sports_href->href.'" target="_blank">'.'<img src="'.$sports_img->src.'"></a><br><br>';
                }



            }

          
            
      



       }


    


}

/*
if(isset($_COOKIE['sports']) && $_COOKIE['sports'] == 1) {
    $rssSports = simplexml_load_file('https://timesofindia.indiatimes.com/rssfeeds/4719148.cms');
    $feedSportsHeading = 'Sports';
    foreach ($rssSports->channel->item as $item) {
        $feedSportsDesc .= '<h5><a href="'. $item->link .'" target="_blank">' . $item->title . "</a></h5>";
        $feedSportsDesc .= "<p>" . $item->description . "</p>";
    }
}    */
// Outlook India



if(isset($_COOKIE['outlook']) && $_COOKIE['outlook'] == 1) {


 /*   $url="https://www.ndtv.com/latest#pfrom=home-ndtv_mainnavgation"; 
    $ch = curl_init(); 
    curl_setopt ($ch, CURLOPT_URL, $url); 
    curl_setopt ($ch, CURLOPT_URL, $url); 
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10);
    curl_setopt($ch, CURLOPT_TIMEOUT,10);
    curl_setopt($ch,CURLOPT_SSL_VERIFYPEER, false);

    $latest = curl_exec ($ch); 
    //echo $result;  
    curl_close($ch);

    $oDom = new simple_html_dom(); 
    $latest = $oDom->load($latest); */

    $url="https://www.ndtv.com/latest#pfrom=home-ndtv_mainnavgation"; 

    $latest = scrap($url);
     
    $feedOutlookHeading = "Latest News";

    foreach($latest->find(".lisingNews") as $latestDiv){

       foreach($latestDiv->find('.news_Itm') as $latestPost){

         
            foreach($latestPost->find('.newsHdng') as $latestDiv_heading){

                foreach($latestDiv_heading->find('a') as $latestDiv_link){
                    $feedOutlookDesc .= '<a href="'.$latestDiv_link->href.'" target="_blank">'.$latestDiv_heading->plaintext.'</a>';
                }

                //$feedOutlookDesc .= $latestDiv_heading->plaintext.'<br>';
            }
            
            foreach($latestPost->find("img") as $latestDiv_img){
                $feedOutlookDesc .= '<a href="'.$latestDiv_link->href.'" target="_blank">'.'<img src="'.$latestDiv_img->src.'" width="100%"></a><br><br>';
            }

            
       }
      
    }

}

/*
if(isset($_COOKIE['outlook']) && $_COOKIE['outlook'] == 1) {
    $rssOutlook = simplexml_load_file('https://timesofindia.indiatimes.com/rssfeeds/-2128936835.cms');
    //$feedOutlookHeading = $rssOutlook->channel->title;
    $feedOutlookHeading = 'Outlook';
    foreach ($rssOutlook->channel->item as $item) {
        $feedOutlookDesc .= '<h5><a href="'. $item->link .'" target="_blank">' . $item->title . "</a></h5>";
        $feedOutlookDesc .= "<p>" . $item->description . "</p>";
    }
}*/

// NDTV Top Stories
if(isset($_COOKIE['ndtv']) && $_COOKIE['ndtv'] == 1) {
  /*  $rssNDTV = simplexml_load_file('https://feeds.feedburner.com/ndtvnews-top-stories');
    $feedNDTVHeading = $rssNDTV->channel->title;
    foreach ($rssNDTV->channel->item as $item) {
        $feedNDTVDesc .= '<h5><a href="'. $item->link .'" target="_blank">' . $item->title . "</a></h5>";
        $feedNDTVDesc .= "<p>" . $item->description . "</p>";
    }*/

    $url="https://www.ndtv.com/top-stories"; 

    $latest = scrap($url);
     
    $feedNDTVHeading = "NDTV - Top Stories";

    foreach($latest->find(".lisingNews") as $latestDiv){

       foreach($latestDiv->find('.news_Itm') as $latestPost){

         
            foreach($latestPost->find('.newsHdng') as $latestDiv_heading){

                foreach($latestDiv_heading->find('a') as $latestDiv_link){
                    $feedNDTVDesc .= '<a href="'.$latestDiv_link->href.'" target="_blank">'.$latestDiv_heading->plaintext.'</a>';
                }

      
            }
            
            foreach($latestPost->find("img") as $latestDiv_img){
                $feedNDTVDesc .= '<a href="'.$latestDiv_link->href.'" target="_blank">'.'<img src="'.$latestDiv_img->src.'" width="100%"></a><br><br>';
            }

            
       }
      
    }


}
// World

/*
if(isset($_COOKIE['world']) && $_COOKIE['world'] == 1) {
    $rssWorld = simplexml_load_file('https://www.hindustantimes.com/rss/world/rssfeed.xml');
    $feedWorldHeading = $rssWorld->channel->title;
    foreach ($rssWorld->channel->item as $item) {
        $feedWorldDesc .= '<h5><a href="'. $item->link .'" target="_blank">' . $item->title . "</a></h5>";
        $feedWorldDesc .= "<p>" . $item->description . "</p>";
    }
}*/
// Technology

if(isset($_COOKIE['technology']) && $_COOKIE['technology'] == 1) {

   // $feedTechnologyDesc

   $url="https://indianexpress.com/section/technology/"; 

   $tech = scrap($url);

   $feedTechnologyHeading = 'Technology';

   foreach($tech->find('.article-list') as $tech_post_div){

    foreach($tech_post_div->find('li') as $tech_post_heading){

        foreach($tech_post_heading->find('a') as $tech_post_link){
           
            $feedTechnologyDesc .= '<a href="'.$tech_post_link->href.'" target="_blank">'.$tech_post_heading->plaintext.'</a><br><br>';
            foreach($tech_post_link->find('img') as $tech_postImage){
                $feedTechnologyDesc .= '<a href="'.$tech_post_link->href.'" target="_blank">'.'<img src="' . $tech_postImage->getAttribute('src').'" width="100%"></a><br><br>';
            }

        }


       /* foreach($tech_post_div->find('img') as $tech_postImage){
            $feedTechnologyDesc .= '<a href="'.$tech_post_link->href.'" target="_blank">'.'<img src="' . $tech_postImage->getAttribute('src').'" width="100%"></a><br><br>';
        }*/



    }

  

   }




}
/*
if(isset($_COOKIE['technology']) && $_COOKIE['technology'] == 1) {
    $rssTechnology = simplexml_load_file('https://feeds.feedburner.com/TechCrunch/');
    $feedTechnologyHeading = $rssTechnology->channel->title;
    foreach ($rssTechnology->channel->item as $item) {
        $feedTechnologyDesc .= '<h5><a href="'. $item->link .'" target="_blank">' . $item->title . "</a></h5>";
        $feedTechnologyDesc .= "<p>" . $item->description . "</p>";
    }
}*/

// Assam

/*
if(isset($_COOKIE['assam']) && $_COOKIE['assam'] == 1) {
    $rssAssam = simplexml_load_file('http://newsrack.in/crawled.feeds/at.rss.xml');
    //$feedAssamHeading = $rssAssam->channel->title;
    $feedAssamHeading = 'The Asssam Tribune';
    foreach ($rssAssam->channel->item as $item) {
        $feedAssamDesc .= '<h5><a href="'. $item->link .'" target="_blank">' . $item->title . "</a></h5>";
        $feedAssamDesc .= "<p>" . $item->description . "</p>";
    }
}*/

if(isset($_COOKIE['assam']) && $_COOKIE['assam'] == 1) {

    $url="https://www.sentinelassam.com/breaking-news"; 

    $sentinel = scrap($url);

    $feedAssamHeading = 'The Sentinel';

    foreach($sentinel->find('.article') as $sentinel_post_div){



         
        foreach($sentinel_post_div->find('.article-heading') as $sentinel_post_heading){

            foreach($sentinel_post_heading->find('a') as $sentinel_post_link){
                $feedAssamDesc .= '<a href="https://www.sentinelassam.com'.$sentinel_post_link->href.'" target="_blank">'.$sentinel_post_heading->plaintext.'</a>';
            }
        }
        
      /*  foreach($latestPost->find("img") as $latestDiv_img){
            $feedOutlookDesc .= '<a href="'.$latestDiv_link->href.'" target="_blank">'.'<img src="'.$latestDiv_img->src.'" width="100%"></a><br><br>';
        }*/

        foreach($sentinel_post_div->find('img') as $postImage){
            $feedAssamDesc .= '<a href="https://www.sentinelassam.com'.$sentinel_post_link->href.'" target="_blank">'.'<img src="' . $postImage->getAttribute('data-src').'" width="100%"></a><br><br>';
        }

    }

  
}
?>