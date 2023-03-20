<?php 

$full_name = $email_id = $phone_no = $address = $hire_me_reason = "";
$discipline =  $working = 0;

include 'career_form.php';
$career_submit = 0;

?>

<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="css/style.css">
    <link rel="stylesheet" type="text/css" href="css/career.css">

    <title>Career@alegralabs</title>
  </head>
  <body>

    <header id="header">
      <div class="container">
        <div class="row">
          <div class="col-lg-12">
            <div class="logo logo-navbar">
              <a href="http://www.alegralabs.com/">
                 <img src="http://alegralabs.com/source/img/logo-black.png">
              </a>
            </div>
            <div class="language">
              <!--<span class="hidden">
                <a href="Denmark.html">
                  DE
                </a>
              </span>
              <span >
                <a href="index.html">
                  EN
                </a>
              </span> -->
            </div>
            <div class="menu-icon">
              <div class="hamburg-menu">
                  <div class="hamburger" id="hamburger-1">
                      <img src="http://alegralabs.com/source/img/menu-black.svg">
                  </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </header>
    <div class="col-sm-6 sidebar-menu">
        <div class="close-sidebar">
            <img src="img/close-white.svg">
        </div>
        <div class="col-sm-10 sidebar-inner">
            <div class="col-sm-6 no-pad-lf menu-items inline">
                <div class="social-icon">
                      <a href="#">
                        <img src="img/facebook.png">
                      </a>
                      <a href="#">
                        <img src="img/linkedin.png">
                      </a>
                      <a href="#">
                        <img src="img/twitter.png">
                      </a>
                </div>
                <ul>
                    <li><p>menu</p></li>
                    <li><a href="https://www.alegralabs.com/#what_we_do">what we do</a></li>
                    <li><a href="https://www.alegralabs.com/#services">services</a></li>
                    <li><a href="https://www.alegralabs.com/#who_we_are">who we are</a></li>
                    <li><a href="https://www.alegralabs.com/#testimonials">testimonials</a></li>
                    <li><a href="https://www.alegralabs.com/#contact">contact</a></li>
                </ul>
            </div>
            <div class="col-sm-6 explore-tab inline">
              <div class="col-sm-12 no-pad-lf menu-items">
                <ul>
                    <li><p>explore</p></li>
                    <li><a href="https://www.alegralabs.com/career/">carrers</a></li>
                </ul>
              </div>
            </div>
            <div class="col-sm-12 inline sidebar-extra-menu">
                <!-- <a href="#" class="other-menu-items">Imprint</a> -->
                <a href="https://www.alegralabs.com/privacy-policy" class="other-menu-items">Privacy Policy</a>
                <!-- <a href="#" class="other-menu-items">Data protection</a> -->
            </div>
            <div class="col-sm-12 no-pad-lf inline address-box-main">
                <div class="col-sm-4 inline address-box no-pad-l">
                    <h4>Germany</h4>
                    <p>Vordersteig 12 Ettlingen 76275, Germany <br> Contact: +49 0123</p>
                </div>
                <div class="col-sm-4 inline address-box no-pad-l">
                    <h4>India</h4>
                    <p>UCO Bank Bldg (Old) Eastern Valley Public School (3rd Floor), Adabari Tiniali, Guwahati - 781012 <br>Contact: +91 9864081806</p>
                </div>
                <div class="col-sm-4 inline address-box no-pad-l">
                    <h4>UK</h4>
                    <p>66 Montana Gardens London SE26 5BG, UK <br>Contact: +44 7809600786</p>
                </div>
            </div>
        </div>
    </div>

    <section class="career-section all_sections">
        <div class="container">
            <div class="row">
              <div class="col-lg-12">
                <noscript>
                    <p class="noscript-mes">This Website needs javascipt to be enable in your browser.</p>
                </noscript>
              </div>
              <div class="col-lg-12 no-pad-lr">
                  <div class="col-lg-12 career-head">
                    <h1>Recruitment@Alegralabs</h1>
                    <p>Please fill up the form below. Based on your input the company at it's own discretion may absorb you. The company will call suitable candidates for interview.</p>
                    <hr class="after-tab-hr">
                  </div>
              </div>
            </div>
            <form id="career_form" action="<?php $_SERVER["PHP_SELF"];?>" method="POST" enctype="multipart/form-data" novalidate>
              
                <div class="row form-tab">
                    <div class="col-lg-4">
                        <h3>Personal Info</h3>
                    </div>
                    <div class="col-lg-8">
                        <div class="col-sm-12 text-danger" id="main-error-message">
                            <p></p>
                        </div>
                        <div class="col-sm-12 main-php-message">
                            <?php                        
                            if( $status == 'success' )
                            {
                                $full_name = $email_id = $phone_no = $address = $hire_me_reason = "";
                                $discipline =  $working = 0;
                                header("thankyou.php");

                            }elseif ( $status == 'fail' ){
                                echo "<p>Please check your fields properly then submit the form.";
                            }
                            ?>
                        </div>
                        <div class="col-lg-12 no-pad-lr form-box">
                            <div class="form-group">
                                <label>Full Name: <span class="text-danger err_mes_tab" id="full_name_err"><?php echo ( isset($error['full_name']) ) ? $error['full_name'] : '' ?></span></label>
                                <input type="text" name="full_name" class="form-control form-input" value="<?php echo $full_name; ?>">
                            </div>
                            <div class="form-group">
                                <label>E-Mail Id: <span class="text-danger err_mes_tab" id="email_id_err"><?php echo ( isset($error['email_id']) ) ? $error['email_id'] : '' ?></span></label>
                                <input type="text" name="email_id" value="<?php echo $email_id; ?>" class="form-control form-input">
                            </div>
                            <div class="form-group">
                                <label>Phone / Mobile No: <span class="text-danger err_mes_tab" id="phone_no_err"><?php echo ( isset($error['phone_no']) ) ? $error['phone_no'] : '' ?></span></label>
                                <input type="text" name="phone_no" value="<?php echo $phone_no; ?>" class="form-control form-input">
                            </div>
                            <div class="form-group">
                                <label>Address: <span class="text-danger err_mes_tab" id="address_err"><?php echo ( isset($error['address']) ) ? $error['address'] : '' ?></span></label>
                                <input type="text" name="address" class="form-control form-input" value="<?php echo $address; ?>">
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-12">
                        <hr class="after-tab-hr">
                    </div>
                </div>
                <div class="row form-tab">
                    <div class="col-lg-4">
                        <h3>Skills / Questions</h3>
                    </div>
                    <div class="col-lg-8">
                        <div class="col-lg-12 no-pad-lr form-box">
                            <div class="form-group skill-tab">
                                <label>Please add your skills and years of experience: <span class="text-danger err_mes_tab" id="skills_err"><?php echo ( isset($error['singleskills']) ) ? $error['singleskills'] : '' ?></span></label>
                                <table class="col-sm-12 skill-tab-info">
                                    <thead>
                                        <tr>
                                            <th>Skills</th>
                                            <th>Experience</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            
                                        </tr>
                                    </tbody>
                                </table>
                                <div class="col-sm-12 no-pad-lr">
                                    <select class="form-control width-33 border-r-none form-input" name="skill_select" id="skill_input">
                                        <option value="">Skills</option>
                                        <option value="Linux">Linux</option>
                                        <option value="C">C</option>
                                        <option value="C++">C++</option>
                                        <option value="Objective C (for iOS)">Objective C (for iOS)</option>
                                        <option value="Swift (for iOS)">Swift (for iOS)</option>
                                        <option value="GO">GO</option>
                                        <option value="Scala">Scala</option>
                                        <option value="Java (for Android)">Java (for Android)</option>
                                        <option value="React JS">React JS</option>
                                        <option value="React Native">React Native</option>
                                        <option value="Ionic-Flutter for Hybrid Mobile App">Ionic, Flutter for Hybrid Mobile App</option>
                                        <option value="Artificial Inteligence">Artificial Inteligence</option>
                                        <option value="Machine Learning/ Deep Learning">Machine Learning/ Deep Learning</option>
                                        <option value="Blockchain">Blockchain</option>
                                        <option value="Vue">Vue</option>
                                        <option value="Angular">Angular</option>
                                        <option value="Node">Node</option>
                                        <option value="HTML5">HTML5</option>
                                        <option value="CSS3">CSS3</option>
                                        <option value="Twitter Bootstrap">Twitter Bootstrap</option>
                                        <option value="PHP">PHP</option>
                                        <option value="Python">Python</option>
                                        <option value="Ruby">Ruby</option>
                                        <option value="jQuery">jQuery</option>
                                        <option value="Javascript">Javascript</option>
                                        <option value="Restful API (XML/JSON)">Restful API (XML/JSON)</option>
                                        <option value="MySQL">MySQL</option>
                                        <option value="PgSQL">PgSQL</option>
                                        <option value="Apache Storm">Apache Storm</option>
                                        <option value="Firebase">Firebase</option>
                                        <option value="Mongo DB">Mongo DB</option>
                                        <option value="Couch DB">Couch DB</option>
                                        <option value="Hadoop">Hadoop</option>
                                        <option value="Wordpress">Wordpress</option>
                                        <option value="WooCommerce">WooCommerce</option>
                                        <option value="Magento">Magento</option>
                                        <option value="Drupal">Drupal</option>
                                        <option value="Sales Force">Sales Force</option>
                                        <option value="Shopify">Shopify</option>
                                        <option value="SAP">SAP</option>
                                        <option value="Zend MVC Framework">Zend MVC Framework</option>
                                        <option value="Yii MVC Framework">Yii MVC Framework</option>
                                        <option value="Laravel MVC Framework">Laravel MVC Framework</option>
                                        <option value="CodeIgnitor MVC Framework">CodeIgnitor MVC Framework</option>
                                        <option value="Cake PHP MVC Framework">Cake PHP MVC Framework</option>
                                        <option value="Symphony MVC Framework">Symphony MVC Framework</option>
                                        <option value="Smarty Templates">Smarty Templates</option>
                                    </select>
                                    <select class="form-control width-33 border-r-none form-input" name="yr-expert_select" id="yr_expert_input">
                                        <option value="">Years</option>
                                        <option value="1">1</option>
                                        <option value="2">2</option>
                                        <option value="3">3</option>
                                        <option value="4">4</option>
                                        <option value="5">5</option>
                                        <option value="6">6</option>
                                        <option value="7">7</option>
                                        <option value="8">8</option>
                                        <option value="9">9</option>
                                        <option value="10">10</option>
                                        <option value="11">11</option>
                                        <option value="12">12</option>
                                        <option value="13">13</option>
                                        <option value="14">14</option>
                                        <option value="15">15</option>
                                    </select>
                                    <a class="btn btn-primary" type="submit" id="add_skills">Add Skills</a>
                                </div>
                            </div>
                            <div class="form-group">
                                <label>If my skill does not fit the company's requirement. I am willing to undergo a free training program for 1-3 months depending on my learning capability. <span class="text-danger err_mes_tab" id="training_err"><?php echo ( isset($error['training']) ) ? $error['training'] : '' ?></span></label>
                                <div class="custom-control custom-radio custom-control-inline">
                                    <input type="radio" id="customRadioInline1" name="training" value="yes" checked class="custom-control-input">
                                    <label class="custom-control-label" for="customRadioInline1">Yes</label>
                                </div>
                                <div class="custom-control custom-radio custom-control-inline">
                                    <input type="radio" id="customRadioInline2" name="training" value="no" class="custom-control-input">
                                    <label class="custom-control-label" for="customRadioInline2">No</label>
                                </div>
                            </div>
                            <div class="form-group">
                                <label>Why should the company hire me ? <span class="text-danger err_mes_tab" id="hire_me_reason_err"><?php echo ( isset($error['hire_me_reason']) ) ? $error['hire_me_reason'] : '' ?></span> </label>
                                <textarea rows="3" class="form-control form-input" name="hire_me_reason"><?php echo $hire_me_reason; ?></textarea>
                            </div>
                            <div class="form-group">
                                <label for="discipline">How would you grade your discipline ? <span class="text-danger err_mes_tab" id="discipline_err"><?php echo ( isset($error['discipline']) ) ? $error['discipline'] : '' ?></span></label>
                                <input type="range" min="0" max="10" value="<?=(empty($discipline) ? 0 : $discipline);?>" class="form-control-range custom-range" name="discipline" id="discipline"><span class="discipline_range"><?=(empty($discipline) ? 0 : $discipline);?></span>
                            </div>
                            <div class="form-group">
                                <label for="zeal">How would you grade your attendance and work zeal ? <span class="text-danger err_mes_tab" id="working_err"><?php echo ( isset($error['working']) ) ? $error['working'] : '' ?></span>
                                </label>
                                <input type="range" min="0" max="10" value="<?=(empty($working) ? 0 : $working);?>" class="form-control-range custom-range" name="working" id="zeal"><span class="zeal_range"><?=(empty($working) ? 0 : $working);?></span>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-12">
                        <hr class="after-tab-hr">
                    </div>
                </div>
                <div class="row form-tab">
                    <div class="col-lg-4">
                        <h3>Documents</h3>
                    </div>
                    <div class="col-lg-8">
                        <div class="col-lg-12 no-pad-lr form-box">
                            <div class="form-group">
                                <label class="resume-label">Add your resume : <span>(Allowed document types are .txt, .doc, .docx, .pdf)</span></label>
                                <p class="text-danger err_mes_tab" id="resume_err"><?php echo ( isset($error['resume']) ) ? $error['resume'] : '' ?></p>
                                <div class="custom-file">
                                  <input type="file" class="custom-file-input form-input" value="<?php echo $resumeName; ?>"  id="resume" name="resume">
                                  <label class="custom-file-label file-input" id="file_name" for="resume">Choose file</label>
                                </div>
                            </div>
                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" class="custom-control-input form-input" value="agree" name="policy" checked id="customCheck1">
                                <label class="custom-control-label" for="customCheck1">I will work for at least 2 years for the company. </label>
                                <p>(I join the company not for fun, experimentation, entertainment and use their resources)</p>
                                <p class="err_mes_tab text-danger" id="agree_err"><?php echo ( isset($error['agree']) ) ? $error['agree'] : '' ?></p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-8 offset-lg-4">
                        <button class="btn btn-primary mar-t-30 submit-btn pull-left" value="<?php echo $career_submit = 0;?>" name="career_submit" id="career_submit" >Submit</button>
                        
                        <div class="form-preloader spinner-border text-primary" role="status">
                            <span class="sr-only">Loading...</span>
                        </div>
                    </div>
                    <div class="col-lg-8 offset-lg-4">
                        <p class="success_message"></p>
                    </div>
                </div>
            </form>
        </div>
    </section>

    <footer id="footer">
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <div class="footer_case">
                        <div class="logo">
                            <img src="img/logo-black.png" alt="Logo">
                            <span class="copyright">
                                Copyright 2019. Alegra labs GmbH. All rights reserved.
                            </span>
                            <a href="https://www.alegralabs.com/privacy-policy">Privay Policy</a>
                        </div>
                        <div class="locations">
                            <ul class="locations_list">
                                <h6>
                                    Locations
                                </h6>
                                <a href="https://www.alegralabs.com/#contact" class="footer-contact-german">
                                    <li>
                                        Germany
                                    </li>
                                </a>
                                <a href="https://www.alegralabs.com/#contact" class="footer-contact-india">
                                    <li>
                                        India
                                    </li>
                                </a>
                                <a href="https://www.alegralabs.com/#contact" class="footer-contact-uk">
                                    <li>
                                        UK
                                    </li>
                                </a>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="footer_case">
                        <nav>
                            <div class="links">
                                <ul class="footer_nav">
                                    <h6>
                                        Links
                                    </h6>
                                <a href="https://www.alegralabs.com/#what_we_do">
                                    <li>
                                        What we do
                                    </li>
                                </a>
                                <a href="https://www.alegralabs.com/#services">
                                    <li>
                                        Services
                                    </li>
                                </a>
                                <a href="https://www.alegralabs.com/#who_we_are">
                                    <li>
                                        Who we are
                                    </li>
                                </a>
                                <a href="https://www.alegralabs.com/#testimonials">
                                    <li>
                                        Testimonials
                                    </li>
                                </a>
                                </ul>
                                <ul class="footer_nav">
                                    <a href="https://www.alegralabs.com/#contact" data-anchor="#contact">
                                        <li>
                                            Contact
                                        </li>
                                    </a>
                                    <a href="https://www.alegralabs.com/career/">
                                        <li>
                                            Career
                                        </li>
                                    </a>
                                </ul>
                            </div>
                        </nav>
                        <div class="social">
                            <a href="#">
                                <img src="img/linkedin.png">
                            </a>
                            <a href="#">
                                <img src="img/facebook.png">
                            </a>
                            <a href="#">
                                <img src="img/twitter.png">
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </footer>

    <script src="https://code.jquery.com/jquery-3.3.1.js"></script>

    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
    <script type="text/javascript">
        //open sidebar
        $('.hamburger').on('click', function(){
            $(".sidebar-menu").removeClass("hidden");
            $(".sidebar-menu").show().animate({right: "0%"});
        });

        //close sidebar
        $('.close-sidebar').on('click', function(){
            if ($(window).width() < 767) {

                $(".sidebar-menu").animate({
                  right: "-100%"
                }, {
                  complete: function(){
                  $(this).hide();
                  }
                });

            }else{
                $(".sidebar-menu").animate({
                  right: "-50%"
                }, {
                  complete: function(){
                  $(this).hide();
                  }
                });
            }
        });

        //close sidebar on body click
        $('.all_sections').on('click', function(){
            $(".sidebar-menu").animate({
              right: "-50%"
            }, {
              complete: function(){
              $(this).hide();
              }
            });
        });



    </script>
    <script type="text/javascript">
        function showerror(err, form_input_name){
            $("#"+form_input_name+"_err" ).html(err);
        }
        
        $(".form-input").blur(function(){
            var form_input_name = $(this).attr("name");
            var form_input_value = $(this).val();
            switch (form_input_name) {
                  case "full_name":
                        if( !$(this).val() ) {
                            err = "Full name can't be empty.";
                            showerror(err, form_input_name);
                        }else{
                            var pattern = /^[a-zA-Z\s.]{3,255}$/;
                            var result = pattern.test(form_input_value);
                            if (result == true) {
                                err = "";
                                showerror(err, form_input_name);

                            }else if (result == false){
                                err = "Please enter only alphabets.";
                                showerror(err, form_input_name);
                            }
                        }

                    break;
                  case "email_id":
                        if( !$(this).val() ) {
                            err = "Email can't be empty.";
                            showerror(err, form_input_name);
                        }else{
                            var pattern = /^([a-zA-Z0-9_\.\-\+])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
                            var result = pattern.test(form_input_value);
                            if (result == false){
                                err = "Please enter valid email id.";
                                showerror(err, form_input_name);
                            }else{

                                var email_id = $(this).val();
                                var email = JSON.stringify({email_id: email_id});
                                $.ajaxSetup({
                                    url: "usercheck.php",
                                    data: email,
                                    async: true,
                                    cache: false,
                                    enctype: 'multipart/form-data',
                                    contentType: false,
                                    processData: false,
                                });
                                    
                                $.post()
                                .done(function(response) {
                                    var res = JSON.parse(response);
                                    var status = res['status'];
                                    var message = res['message'];
                                    var error = res['error'];

                                    if ( status == 'notexist' ){
                                        err = "";
                                        showerror(err, form_input_name);
                                    }
                                    else if ( status == 'exist' ){
                                        err = "This email is already exist, please use another email id.";
                                        showerror(err, form_input_name);
                                    }
                                })
                                .fail(function() {
                                    alert('failed to process');
                                })
                                return false;
                            }
                        }
                    break;

                  case "phone_no":
                        if( !$(this).val() ) {
                            err = "Phone no can't be empty.";
                            showerror(err, form_input_name);
                        }else{
                            var pattern = /^[+0-9*]{6,15}$/;
                            var result = pattern.test(form_input_value);

                            if (result == false) {
                                err = "Please enter valid phone number.";
                                showerror(err, form_input_name);
                            }else {

                                var phone_no = $(this).val();
                                var phone = JSON.stringify({phone_no: phone_no});
                                $.ajaxSetup({
                                    url: "phonecheck.php",
                                    data: phone,
                                    async: true,
                                    cache: false,
                                    enctype: 'multipart/form-data',
                                    contentType: false,
                                    processData: false,
                                });
                                    
                                $.post()
                                .done(function(response) {
                                    var res = JSON.parse(response);
                                    var status = res['status'];
                                    var message = res['message'];
                                    var error = res['error'];

                                    if ( status == 'notexist' ){
                                        err = "";
                                        showerror(err, form_input_name);
                                    }
                                    else if ( status == 'exist' ){
                                        err = "This phone no is already exist, please use another phone no.";
                                        showerror(err, form_input_name);
                                    }
                                })
                                .fail(function() {
                                    alert('failed to process');
                                })
                                return false;
                            }
                        }
                    break;

                  case "address":
                        if( !$(this).val() ) {
                            err = "Address can't be empty.";
                            showerror(err, form_input_name);
                        }else{
                            var add_len = $(this).val().length;
                            
                            if( add_len > 250){
                                err = "Address max length is 250 character.";
                                showerror(err, form_input_name);
                                console.log(add_len);
                            }else{
                                err = "";
                                showerror(err, form_input_name);
                            }
                        }
                   break;

                  case "hire_me_reason":
                        if( !$(this).val() ) {
                            err = "Address can't be empty.";
                            showerror(err, form_input_name);
                        }else{
                            err = "";
                            showerror(err, form_input_name);
                        }
                    break;
            }
        });

    
        var skill_array = new Array();
        var year_array = new Array();

        $("#add_skills").click(function(){
            var skill = $("#skill_input").val();
            var yr = $("#yr_expert_input").val();
            
            if (skill != 0 && yr != 0) {
                err = "";
                form_input_name = "skills"
                showerror(err, form_input_name);
                $("#skill_input option[value='"+skill+"']").remove();
                $('.skill-tab-info').show();
                $('.skill-tab-info tbody').append( "<tr>" +"<td>" +skill  +"</td>" +"<td>" +yr +" yr"  +"</td>" +"</tr>");

                skill_array.push(skill);

                year_array.push(yr);
            }else{
                err = "Add skills and experience first.";
                form_input_name = "skills"
                showerror(err, form_input_name);
            }
        });

        $('#discipline').on("change click", function() {
            $(this).next().html($(this).val());
            
            if ($(this).val() <= 0) {
                err = "Please grade your discipline.";
                form_input_name = "discipline"
                showerror(err, form_input_name);
            }else{
                err = "";
                form_input_name = "discipline"
                discipline_check = 1;
                showerror(err, form_input_name);
            }
        });

        $('#zeal').on("change click", function() {
            $(this).next().html($(this).val());
            if ($(this).val() <= 0) {
                err = "Please grade your attendance and work zeal.";
                form_input_name = "working";
                showerror(err, form_input_name);
            }else{
                err = "";
                form_input_name = "working";
                showerror(err, form_input_name);
            }
        });

        $(document).ready(function(){
            $("#resume").change(function(){

                    $("#file_name").html("Browse");
                    var file = $('#resume')[0].files[0];
                    var fileName = file.name;
                    var fileSize = file.size;
                    $("#file_name").html(fileName);
                    var resumeFile = $('#resume').val();
                    
                    fileExtension = fileName.replace(/^.*\./, '');
                    var format  = ["doc","docx","pdf","txt"]; // defined the file types
                    
                    if( resumeFile == '' )
                    {
                        err = "Please upload your resume";
                        form_input_name = "resume";
                        showerror(err, form_input_name);

                    }else{

                        if(!(( fileExtension == format[0]) || ( fileExtension == format[1]) || ( fileExtension == format[2]) || ( fileExtension == format[3]) )){
                            err = "Please select a valid (.doc, .docx, .pdf, .txt) file.";
                            form_input_name = "resume";
                            showerror(err, form_input_name);
                        }else{

                            if( fileSize > 1048576 ){ //1mb in bytes
                                err = "Resume size not more than 1MB";
                                form_input_name = "resume";
                                showerror(err, form_input_name);
                            }else{
                                err = "";
                                form_input_name = "resume"
                                showerror(err, form_input_name);
                            }
                        }
                    }
            });
        });


        $('#career_form').submit(function(e){
            e.preventDefault();

            $('#main-error-message').hide();
            $('#main-error-message').html("");
            var career_submit = 1;

            var resumeFile = $('#resume').val();
            if( resumeFile == '' )
            {
                err = "Please upload your resume";
                form_input_name = "resume";
                showerror(err, form_input_name);
            }

                var formData = new FormData($(this)[0]);
                formData.append('skill_array', skill_array);
                formData.append('year_array', year_array);
                formData.append('career_submit', career_submit);

                $.ajaxSetup({
                    url: "career_form.php",
                    data: formData,
                    async: true,
                    cache: false,
                    enctype: 'multipart/form-data',
                    contentType: false,
                    processData: false,
                    beforeSend: function(){
                        $(".form-preloader").show();
                        $(".form-preloader").css("display","inline-block");
                    },
                    complete: function(){
                       $(".form-preloader").hide();
                    }
                });
                $.post()
                .done(function(response) {
                    var res = JSON.parse(response);
                    var status = res['status'];
                    var message = res['message'];
                    var error = res['error'];

                    if ( status == 'success' ){
                        window.location="thankyou.php";
                    }
                    else{

                        if(Object.keys(error).length > 0)
                        {
                            for (x in error)
                            {
                                $('#'+x+'_err').html('('+error[x]+')');
                            }
                        }

                        $("html, body").animate({ scrollTop: 100 }, "slow");
                        $('#main-error-message').show();
                        $('#main-error-message').html(message);
                    }
                })
                .fail(function() {
                    alert('failed to process');
                })
                return false;
        });
    </script>

  </body>
</html>