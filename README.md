# EnterpriseManagementSystem
### Enterprise Management System (EMS) is an application for small to medium size enterprises and companies. It is an application for managing your employees, payrolls, clients, invoices, GST etc.. To help and support, please use the [support](http://www.alegralabs.com/ems/support) page.

#### Installation steps
1. Clone or download the repository into your local machine or your web server.
2. Create a database on your local machine or server. Add a user to this database with all privileges. You should remember the name of database, username & password, as you will require them during setup.
3. In the EMS application, you will see a folder called “settings”. Inside it, you will find a file called config.php. Edit this file, in your favourite editor. Each and every line in this file is self explanatory.
a. You will first need to enter your database credentials.
b. Then you will also have to edit the absolute path i.e., where you have installed or running the EMS. Similarly, edit the email address of all out going emails. Out going emails will go to your employees and clients. You can disable out going emails to clients by changing the $sendEmailToClient from true to false.
Likewise, there are more customised options available in this config file.
Apart from the database credentials, you can change all other values later, if you want.
4. EMS generates PDF’s for Invoices for clients and Payrolls for employees. For this, the system use the popular WKHTMLTOPDF.
a. You will need to install WKHTMLTOPDF in your machine or server.

A nice tutorial, for how to install WKHTMLTOPDF is available here https://jaimegris.wordpress.com/2015/03/04/how-to-install-wkhtmltopdf-in-centos-7-0/

b. Next, you will also need to make all the folders inside “uploads” writeable.

** You are done! **

Now open your browser and point to the setup file. For example, if you your site is http://www.example.com and you have installed EMS in a folder called “ems”, than you will open http://www.example.com/ems/setup in your browser.

Just follow the on screen instructions.
