<?php
$htaccessContent = 'Options +Multiviews
RewriteEngine On
RewriteBase /
RewriteCond %{SCRIPT_FILENAME} !-d
RewriteCond %{SCRIPT_FILENAME} !-f
RewriteRule ^index$ '.$absoluteUrl.'index.php$1 [L]
RewriteRule ^logout$ '.$absoluteUrl.'logout.php$1 [L]
RewriteRule ^help$ help.php$1 [L]
RewriteRule ^adminHome$ '.$absoluteUrl.'adminHome.php$1 [L]
RewriteRule ^forgotPassword$ '.$absoluteUrl.'forgotPassword.php$1 [L]
RewriteRule ^resetPassword/([A-Z0-9]+)$ '.$absoluteUrl.'resetPassword.php?token=$1 [L]
## Employee
RewriteRule ^createEmployee$ '.$absoluteUrl.'createEmployee.php$1 [L]
RewriteRule ^viewEmployees$ '.$absoluteUrl.'viewEmployees.php$1 [L]
##RewriteRule ^viewEmployeeDetails/(.*)$ '.$absoluteUrl.'viewEmployeeDetails.php?employee_id=$1 [L]
##RewriteRule ^editEmployee/(.*)$ '.$absoluteUrl.'editEmployee.php?employee_id=$1 [L]
RewriteRule ^probationerAppointment$ '.$absoluteUrl.'probationerAppointment.php$1 [L]
RewriteRule ^permanentAppointment$ '.$absoluteUrl.'permanentAppointment.php$1 [L]
RewriteRule ^experienceCertificate$ '.$absoluteUrl.'experienceCertificate.php$1 [L]
RewriteRule ^employeeTermsConditions$ '.$absoluteUrl.'employeeTermsConditions.php$1 [L]
RewriteRule ^payroll$ '.$absoluteUrl.'payroll.php$1 [L]
RewriteRule ^searchPayroll$ '.$absoluteUrl.'searchPayroll.php$1 [L]

## Client
RewriteRule ^createClient$ '.$absoluteUrl.'createClient.php$1 [L]
RewriteRule ^viewClients$ '.$absoluteUrl.'viewClients.php$1 [L]
RewriteRule ^viewProjects$ '.$absoluteUrl.'viewProjects.php$1 [L]
##RewriteRule ^viewClientDetails/(.*)$ '.$absoluteUrl.'viewClientDetails.php?client_id=$1 [L]
##RewriteRule ^editClient/(.*)$ '.$absoluteUrl.'editClient.php?client_id=$1 [L]
##RewriteRule ^viewSingleProjectDetails/(.*)$ '.$absoluteUrl.'viewSingleProjectDetails.php?project_id=$1 [L]

## Invoice
RewriteRule ^createInvoice$ '.$absoluteUrl.'createInvoice.php$1 [L]
RewriteRule ^receiveInvoice$ '.$absoluteUrl.'receiveInvoice.php$1 [L]
RewriteRule ^viewInvoices$ '.$absoluteUrl.'viewInvoices.php$1 [L]
 
## GST
RewriteRule ^currentGST$ '.$absoluteUrl.'currentGST.php$1 [L]
RewriteRule ^searchGST$ '.$absoluteUrl.'searchGST.php$1 [L]
##RewriteRule ^viewGST/(.*)$ '.$absoluteUrl.'viewGST.php?period=$1 [L]

## Settings
RewriteRule ^companyProfile$ '.$absoluteUrl.'companyProfile.php$1 [L]
RewriteRule ^changePasswordForm$ '.$absoluteUrl.'changePasswordForm.php$1 [L]
RewriteRule ^employeeLeaveHoliday$ '.$absoluteUrl.'employeeLeaveHoliday.php$1 [L]
RewriteRule ^notifications$ '.$absoluteUrl.'notifications.php$1 [L]

## Employee Part
RewriteRule ^home$ '.$absoluteUrl.'employee/home.php$1 [L]
RewriteRule ^probationerAppointment$ '.$absoluteUrl.'employee/probationerAppointment.php$1 [L]
RewriteRule ^permanentAppointment$ '.$absoluteUrl.'employee/permanentAppointment.php$1 [L]
RewriteRule ^experienceCertificate$ '.$absoluteUrl.'employee/experienceCertificate.php$1 [L]
RewriteRule ^employeeTermsConditions$ '.$absoluteUrl.'employee/employeeTermsConditions.php$1 [L]
RewriteRule ^payroll$ '.$absoluteUrl.'employee/payroll.php$1 [L]

## 404 error page
ErrorDocument 404 '.$absoluteUrl.'404Error.php';
writeht($htaccessContent);
function writeht($htaccessContent)
{
    $fp = fopen('.htaccess','a+');
    if($fp)
    {
    	ftruncate($fp, 0);
        fwrite($fp, $htaccessContent);
        fclose($fp);
    } else {
    	echo ".htaccess file not available on the server.";
    }
}