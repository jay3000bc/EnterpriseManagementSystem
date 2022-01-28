<?php
$rss = simplexml_load_file('https://economictimes.indiatimes.com/news/politics-and-nation/rssfeeds/1052732854.cms');
$feed1 = '<h3>'. $rss->channel->title . '</h3>';
foreach ($rss->channel->item as $item) {
   $feed1 .= '<h4><a href="'. $item->link .'">' . $item->title . "</a></h4>";
 
}
$rss = simplexml_load_file('https://www.outlookindia.com/rss/section/22');
$feed2 = '<h3>'. $rss->channel->title . '</h3>';
foreach ($rss->channel->item as $item) {
   $feed2 .= '<h4><a href="'. $item->link .'">' . $item->title . "</a></h4>";
 
}
$rss = simplexml_load_file('https://www.outlookindia.com/rss/main/newswire');
$feed3 = '<h3>'. $rss->channel->title . '</h3>';
foreach ($rss->channel->item as $item) {
   $feed3 .= '<h4><a href="'. $item->link .'">' . $item->title . "</a></h4>";
 
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
  "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
  <head>
    <title>How to read RSS feed in PHP | PGPGang.com</title>
    <meta http-equiv="Content-Type" content="text/html;charset=utf-8" />
    <script type="text/javascript" src="jquery-1.8.0.min.js"></script> 
<link rel="stylesheet" href="http://code.jquery.com/ui/1.10.3/themes/smoothness/jquery-ui.css" />
<script src="http://code.jquery.com/ui/1.10.3/jquery-ui.js"></script>
<script type="text/javascript">
$(function() {
    $( "#tabs" ).tabs();
  });
</script>
  </head>
  <body>
    <h2>How to read RSS feed in PHP example.&nbsp;&nbsp;&nbsp;=> <a href="https://www.phpgang.com/">Home</a> | <a href="http://demo.phpgang.com/">More Demos</a></h2>
 
<div id="tabs" style="margin-left:auto;margin-right:auto;width:600px;">
  <ul>
    <li><a href="#tabs-1">PHPGang</a></li>
    <li><a href="#tabs-2">TechCrunch</a></li>
    <li><a href="#tabs-3">Mashable</a></li>
 
  </ul>                 
  <div id="tabs-1">
  <?php echo $feed1; ?>
  </div>
  <div id="tabs-2">
  <?php echo $feed2; ?>
  </div>
  <div id="tabs-3">
  <?php echo $feed3; ?>
  </div>
</div>
</body>
</html>