<?php 

    require_once 'database.php';
    if( isset($_GET['id']) ){
        $id = $_GET['id'];
        // $sql = "SELECT * FROM recruit_application where id=$id";
        // $res = $db->query($sql);


        $result = mysqli_query($db,"SELECT resume FROM `recruit_application` where id=$id" );
        $userdata = mysqli_fetch_assoc($result);
        // print_r($userdata['resume']);

        $path = $userdata['resume'];

        // $path = "https://www.alegralabs.com/ems/career/resume_application/".$path;
        $path = "https://www.alegralabs.com/career/resume_application/".$path;

        // echo $path;


    }
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html lang="en" style="width:100%; height:100%;">
<head>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

  <meta http-equiv="content-type" content="text/html; charset=utf-8">
  <title>Career@alegralabs</title>
</head>
<body id="iframeContainer" style="height: 100%; width: 100%; overflow: hidden; margin:0px;">
<script>
    
    var URL = "https://docs.google.com/gview?url=<?php echo $path; ?>&embedded=true";
    var count = 0;
        var iframe = `<iframe id = "myIframe" src = "${URL}" style="width:100%; height:100%;" frameborder="0" allowfullscreen=""></iframe>`;
            
       $(`#iframeContainer`).html(iframe);
            $('#myIframe').on('load', function(){ 
            count++;
            if(count>0){
                clearInterval(ref)
            }
        });

        var ref = setInterval(()=>{
        $(`#iframeContainer`).html(iframe);
        $('#myIframe').on('load', function() {
            count++;
            if (count > 0) {
                clearInterval(ref)
            }
        });
    }, 2000)
</script>
</body>
</html>