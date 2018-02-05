<div class="navbar-custom-menu">
    <ul class="nav navbar-nav">
        <li class="dropdown notifications-menu">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="true">
            
            <?php if(isset($totalProfileUpdateRequest) && $totalProfileUpdateRequest > 0) { ?>
            <i class="fa fa-bell-o" style="color: #FF0000;"></i>
            <span class="label label-warning"><?php echo $totalProfileUpdateRequest;?></span>
            <?php } else { ?>
            <i class="fa fa-bell-o" style="color: #808080;"></i>
            <?php } ?>
            </a>
            <ul class="dropdown-menu">
                <li class="header">You have <?php echo $totalProfileUpdateRequest;?> notifications</li>
                <li>
                <!-- inner menu: contains the actual data -->
                    <ul class="menu">
                        <?php for ($i=0; $i < $totalProfileUpdateRequest ; $i++) { 
                            $employeeDetails = $employeeManager->getEmployeeDetailsByEmployeeId($employeeManager->request_profile_employee_id[$i]);
                        ?>
                        <li>
                        <a href="editEmployee?request_id=<?php echo $employeeDetails['employee_id'];?>">
                        <i class="fa fa-user text-aqua"></i><?php echo $employeeDetails['name']. ' has requested for Profile Update'; ?>
                        </a>
                        </li>
                        <?php } ?>
                    </ul>
                </li>
                <li class="footer"><a href="notifications">View all</a></li>
            </ul>
        </li>
        <li><a href="http://www.alegralabs.com/support" target="_blank">Support</a></li>
        <li><!-- <a href="#" data-toggle="control-sidebar"><i class="fa fa-gears"></i></a> -->
            <?php if(!isset($_COOKIE['skinColor'])) {
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
            </select>
        </li>
    </ul>
</div>