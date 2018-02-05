<?php
// $to = "goswamim654@gmail.com";
// $txt = '<a href="www.enterhelix.com"></a>';
// $headers = "From: adminems@enterhelix.com";
// $subject = "Salary Amount Credited";
// mail($to,$subject,$txt,$headers);
ini_set("SMTP","aspmx.l.google.com");
$to = "goswamim654@gmail.com";
$subject = "Test mail";
$message = "Hello! This is a simple email message.";
$from = "adminems@enterhelix.com";
$headers  = 'From: '.$from. "\r\n" .
            'Reply-To: '.$from. "\r\n" .
            'MIME-Version: 1.0' . "\r\n" .
            'Content-type: text/html; charset=iso-8859-1' . "\r\n" .
            'X-Mailer: PHP/' . phpversion();
if(mail($to,$subject,$message,$headers)) echo "Mail Sent.";
?> 