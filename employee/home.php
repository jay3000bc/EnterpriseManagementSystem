<?php include('../employee/include/header.php');
$totalProfileUpdateRequest = $employeeManager->getProfileUpdateRequest();
// rss feeds
include_once('../include/rssfeeds.php');
?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
<!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>Dashboard<small>Control panel</small></h1>
        <div class="navbar-custom-menu">
            <ul class="nav navbar-nav">
                <li><a href="http://www.alegralabs.com/support" target="_blank">Support</a></li>
                <li><?php if(!isset($_COOKIE['skinColor'])) {
                    $cookie_name = "skinColor";
                    $cookie_value = "skin-blue";
                    setcookie($cookie_name, $cookie_value, time() + (86400 * 90), "/"); // 86400 = 1 day
                    $_COOKIE['skinColor'] = "skin-blue";
                }?>
            <select id="changeSkin" class="form-control">
                <option>Select Skin</option>
                <option value="skin-blue">Blue</option>
                <option value="skin-yellow">Yellow</option>
                <option value="skin-black">Black</option>
                <option value="skin-purple">Purple</option>
                <option value="skin-green">Green</option>
                <!-- <option value="skin-blue-light">Light Blue</option>
                <option value="skin-black-light">Black Light</option> -->
            </select></li>
            </ul>
        </div>
    </section>

<!-- Main content -->
    <section class="content">
        <!-- Small boxes (Stat box) -->
        <div class="row">
            <div class="col-md-11">
                <p class="well">Tags:
                    <?php if(isset($_COOKIE['outlook']) && $_COOKIE['outlook'] == 1) { ?> 
                    <span class="tags outlook"> #Outlook India &nbsp;<span onclick="removeFeeds('outlook');">&times;</span></span>
                    <?php } ?>
                    <?php if(isset($_COOKIE['assam']) && $_COOKIE['assam'] == 1) { ?>
                    <span class="tags assam"> #Assam &nbsp;<span onclick="removeFeeds('assam');">&times;</span></span>
                     <?php } ?>
                     <?php if(isset($_COOKIE['technology']) && $_COOKIE['technology'] == 1) { ?>
                    <span class="tags technology"> #Technology &nbsp;<span onclick="removeFeeds('technology');">&times;</span></span>
                     <?php } ?>
                    <?php if(isset($_COOKIE['sports']) && $_COOKIE['sports'] == 1) { ?>
                    <span class="tags sports"> #Sports &nbsp;<span onclick="removeFeeds('sports');">&times;</span></span>
                    <?php } ?>
                    <?php if(isset($_COOKIE['politics']) && $_COOKIE['politics'] == 1) { ?>
                    <span class="tags politics"> #Politics &nbsp;<span onclick="removeFeeds('politics');">&times;</span></span>
                    <?php } ?> 
                    <?php if(isset($_COOKIE['ndtv']) && $_COOKIE['ndtv'] == 1) { ?>
                    <span class="tags ndtv"> #NDTV News &nbsp;<span onclick="removeFeeds('ndtv');">&times;</span></span>
                    <?php } ?> 
                    <?php if(isset($_COOKIE['world']) && $_COOKIE['world'] == 1) { ?>
                    <span class="tags world"> #World &nbsp;<span onclick="removeFeeds('world');">&times;</span></span>
                    <?php } ?>
                    
                </p>
            </div>
            <div class="col-md-1">
                <button class="reset-feeds btn btn-sm btn-success">Reset All</button>
            </div>
        </div>
        <div class="row">
            <?php if(isset($_COOKIE['outlook']) && $_COOKIE['outlook'] == 1) { ?>
            <div class="col-md-4 feeds-box outlook">
                <div class="panel panel-primary">
                    <div class="panel-heading">
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
                <div class="panel panel-primary">
                    <div class="panel-heading">
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
                <div class="panel panel-primary">
                    <div class="panel-heading">
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
                <div class="panel panel-primary">
                    <div class="panel-heading">
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
                <div class="panel panel-primary">
                    <div class="panel-heading">
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
                <div class="panel panel-primary">
                    <div class="panel-heading">
                        <?php echo $feedNDTVHeading;?>
                    </div>
                    <div class="panel-body  panel-height">
                        <?php echo $feedNDTVDesc;?>
                    </div>
                </div>
            </div>
            <?php } ?> 
            <?php if(isset($_COOKIE['world']) && $_COOKIE['world'] == 1) { ?>
            <div class="col-md-4 feeds-box world">
                <div class="panel panel-primary">
                    <div class="panel-heading">
                        <?php echo $feedWorldHeading;?>
                    </div>
                    <div class="panel-body  panel-height">
                        <?php echo $feedWorldDesc;?>
                    </div>
                </div>
            </div>
            <?php } ?>
        </div>        
    </section>
<!-- /.content -->
</div>
  <!-- /.content-wrapper -->
<?php include('../employee/include/footer.php');
if(isset($_SESSION['successMsg'])) {
    if($_SESSION['successMsg'] == 'successProfileRequest') {
?>
    <script type="text/javascript">
        swal('Congrats','Request for profile update has been sent to Admin. You will see the changes if admin approves.', 'success');

    </script>
<?php
    }
    if($_SESSION['successMsg'] == 'employeeEdited') {
?>
    <script type="text/javascript">
        swal('Congrats','Employee Edited Successfully', 'success');

    </script>
<?php
    }
unset($_SESSION['successMsg']);  
}
?>
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

    })
    // technology add style using jquery
    $('.technology p a').attr('target','_blank');
    $('.technology p img').addClass('img-responsive');
</script>
</body>
</html>