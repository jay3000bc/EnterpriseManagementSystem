<?php 
$title = 'Home';
// rss feeds
include_once('include/rssfeeds.php');
include_once('include/header.php');
if($companyInfo['theme_color'] == 'skin-blue') { 
    $theme_color = 'blue-skin'; 
} 
if($companyInfo['theme_color'] == 'skin-yellow') { 
    $theme_color = 'yellow-skin'; 
}
if($companyInfo['theme_color'] == 'skin-purple') { 
    $theme_color = 'purple-skin'; 
} 
if($companyInfo['theme_color'] == 'skin-green') { 
    $theme_color = 'green-skin'; 
} 
if($companyInfo['theme_color'] == 'skin-black') { 
    $theme_color = 'black-skin'; 
}  
?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
<!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>Dashboard<small>Control panel</small></h1>
        <?php include_once('include/notificationBell.php'); ?>
    </section>

<!-- **** CHANGES **** -->
<!-- Main content -->
    <section class="content">
        <!-- Small boxes (Stat box) -->
        <div class="row">
            <div class="col-md-11">
                <p class="well">Tags:
                    
                    <?php if(isset($_COOKIE['world']) && $_COOKIE['world'] == 1) { ?>
                    <span class="tags world"> #Facebook &nbsp;<span onclick="removeFeeds('world');">&times;</span></span>
                    <?php } ?>

                    <?php if(isset($_COOKIE['outlook']) && $_COOKIE['outlook'] == 1) { ?> 
                    <span class="tags outlook"> #Latest News &nbsp;<span onclick="removeFeeds('outlook');">&times;</span></span>
                    <?php } ?>
                    <?php if(isset($_COOKIE['assam']) && $_COOKIE['assam'] == 1) { ?>
                    <span class="tags assam"> #The Sentinel &nbsp;<span onclick="removeFeeds('assam');">&times;</span></span>
                     <?php } ?>
                     <?php if(isset($_COOKIE['technology']) && $_COOKIE['technology'] == 1) { ?>
                    <span class="tags technology"> #Technology &nbsp;<span onclick="removeFeeds('technology');">&times;</span></span>
                     <?php } ?>
                    <?php if(isset($_COOKIE['sports']) && $_COOKIE['sports'] == 1) { ?>
                    <span class="tags sports"> #Sports &nbsp;<span onclick="removeFeeds('sports');">&times;</span></span>
                    <?php } ?>
                    <?php if(isset($_COOKIE['politics']) && $_COOKIE['politics'] == 1) { ?>
                    <span class="tags politics"> #World News &nbsp;<span onclick="removeFeeds('politics');">&times;</span></span>
                    <?php } ?> 
                    <?php if(isset($_COOKIE['ndtv']) && $_COOKIE['ndtv'] == 1) { ?>
                    <span class="tags ndtv"> #NDTV-Top News &nbsp;<span onclick="removeFeeds('ndtv');">&times;</span></span>
                    <?php } ?> 

                    
                </p>
            </div>
            <div class="col-md-1">
                <button class="reset-feeds btn btn-sm btn-success">Reset All</button>
            </div>
        </div>
        <div class="row">

            <div class="col-md-4 feeds-box world">
                <div class="panel">
                    <div class="panel-heading <?php echo $theme_color;?>">
                        Facebook - Alegra Labs
                    </div>
                    <div class="panel-body  panel-height">
                    <script async defer crossorigin="anonymous" src="https://connect.facebook.net/en_US/sdk.js#xfbml=1&version=v13.0&appId=1040098503231700&autoLogAppEvents=1" nonce="DGh3dDvk"></script>
                    <div class="fb-page" data-href="https://www.facebook.com/Alegralabs/" data-tabs="timeline" data-width="520" data-height="370" data-small-header="false" data-adapt-container-width="true" data-hide-cover="false" data-show-facepile="true"><blockquote cite="https://www.facebook.com/Alegralabs/" class="fb-xfbml-parse-ignore"><a href="https://www.facebook.com/Alegralabs/">Alegra Labs</a></blockquote></div>
                    </div>
                </div>
            </div>

            <?php if(isset($_COOKIE['outlook']) && $_COOKIE['outlook'] == 1) { ?>
            <div class="col-md-4 feeds-box outlook">
                <div class="panel">
                    <div class="panel-heading <?php echo $theme_color;?>">
                        <?php echo $feedOutlookHeading;?>
                    </div>
                    <div class="panel-body  panel-height">
                        <?php echo $feedOutlookDesc;?>
                    </div>
                </div>
            </div>
            <?php } ?>
            <?php if(isset($_COOKIE['assam']) && $_COOKIE['assam'] == 1) { ?>
            <div class="col-md-4 feeds-box assam">
                <div class="panel">
                    <div class="panel-heading <?php echo $theme_color;?>">
                        <?php echo $feedAssamHeading;?>
                    </div>
                    <div class="panel-body  panel-height">
                        <?php echo $feedAssamDesc;?>
                    </div>
                </div>
            </div>
            <?php } ?>
            <?php if(isset($_COOKIE['technology']) && $_COOKIE['technology'] == 1) { ?>
            <div class="col-md-4 feeds-box technology">
                <div class="panel">
                    <div class="panel-heading <?php echo $theme_color;?>">
                        <?php echo $feedTechnologyHeading;?>
                    </div>
                    <div class="panel-body  panel-height">
                        <?php echo $feedTechnologyDesc;?>
                    </div>
                </div>
            </div>
            <?php } ?>
            <?php if(isset($_COOKIE['sports']) && $_COOKIE['sports'] == 1) { ?>
            <div class="col-md-4 feeds-box sports">
                <div class="panel">
                    <div class="panel-heading <?php echo $theme_color;?>">
                        <?php echo $feedSportsHeading;?>
                    </div>
                    <div class="panel-body  panel-height">
                        <?php echo $feedSportsDesc;?>
                    </div>
                </div>
            </div>
            <?php } ?>
            <?php if(isset($_COOKIE['politics']) && $_COOKIE['politics'] == 1) { ?>
            <div class="col-md-4 feeds-box politics">
                <div class="panel">
                    <div class="panel-heading <?php echo $theme_color;?>">
                        <?php echo $feedPolityHeading;?>
                    </div>
                    <div class="panel-body  panel-height">
                        <?php echo $feedPoliticsDesc;?>
                    </div>
                </div>
            </div>
            <?php } ?>
            <?php if(isset($_COOKIE['ndtv']) && $_COOKIE['ndtv'] == 1) { ?>
            <div class="col-md-4 feeds-box ndtv">
                <div class="panel">
                    <div class="panel-heading <?php echo $theme_color;?>">
                        <?php echo $feedNDTVHeading;?>
                    </div>
                    <div class="panel-body  panel-height">
                        <?php echo $feedNDTVDesc;?>
                    </div>
                </div>
            </div>
            <?php } ?> 
            <?php //if(isset($_COOKIE['world']) && $_COOKIE['world'] == 1) { ?>
           <!-- <div class="col-md-4 feeds-box world">
                <div class="panel">
                    <div class="panel-heading <?php //echo $theme_color;?>">
                        <?php //echo $feedWorldHeading;?>
                    </div>
                    <div class="panel-body  panel-height">
                        <?php //echo $feedWorldDesc;?>
                    </div>
                </div>
            </div>-->
            <?php //} ?>
        </div>        
    </section>
<!-- /.content -->
</div>
<!-- /.content-wrapper -->
<?php include('include/footer.php');?>
<script type="text/javascript">
    // remove feeds
    function removeFeeds(arg) {
        $('.'+arg).fadeOut();
        $.cookie(arg, 0);
        //alert( $.cookie(arg));
    }
    // reset feeds
    $('.reset-feeds').click(function(){
        $('.feeds-box').fadeIn();
        $('.tags').fadeIn();
        $.cookie('politics', 1);
        $.cookie('assam', 1);
        $.cookie('sports', 1);
        $.cookie('outlook', 1);
        $.cookie('technology', 1);
        $.cookie('world', 1);
        $.cookie('ndtv', 1);
        location.reload();

    });
    // technology add style using jquery
    $('.feeds-box p a').attr('target','_blank');

</script>
</body>
</html>