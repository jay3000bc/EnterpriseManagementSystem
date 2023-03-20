<?php 

session_start();
// echo $_SESSION['username'];
if(isset($_SESSION['username']) == 'admin' ) {
    require_once 'database.php';
    // Fetch user details
    $sql = "SELECT * FROM recruit_application";
    $res = $db->query($sql);
    $count = mysqli_num_rows($res);
   
    $skill = array();

    // $resume_file_path  = "http://".$_SERVER['SERVER_NAME']."/career/resume_application/";
    // $resume_file_path  = "/career/resume_application/";

    
    if( isset($_GET['show_entries']) ){
        $total_records_per_page = $_GET['show_entries'];
        $show_entries = $_GET['show_entries'];
    }
    else{
        $total_records_per_page = 5;
        $show_entries = 5; 
    }
    // echo $total_records_per_page;


    if ( (isset( $_GET['page_no'])) && ($_GET['page_no']!="") ) {
        $page_no = $_GET['page_no'];
    } 
    else {
        $page_no = 1;
    }

    // if ( (isset( $_GET['page_no'])) && ($_GET['page_no']!="") && (isset($_GET['show_entries'])) ) {
    //     $page_no = $_GET['page_no'];
    //     $total_records_per_page = $_GET['show_entries'];
    // }

	// $total_records_per_page = 5;

    if( isset($_GET['offset']) ){

        $offset = $_GET['offset'];
        $previous_page = $page_no - 1;
        $next_page = $page_no + 1;
        $adjacents = "2";
    }
    else{

        $offset = ($page_no-1) * $total_records_per_page;
        $previous_page = $page_no - 1;
        $next_page = $page_no + 1;
        $adjacents = "2";
    }
    // $offset = ($page_no-1) * $total_records_per_page;
	// $previous_page = $page_no - 1;
	// $next_page = $page_no + 1;
	// $adjacents = "2"; 


	// $result_count = mysqli_query($db,"SELECT COUNT(*) As total_records FROM `recruit_application`");
	// $total_records = mysqli_fetch_array($result_count);
	// $total_records = $total_records['total_records'];
    // $total_no_of_pages = ceil($total_records / $total_records_per_page);
	// $second_last = $total_no_of_pages - 1; // total page minus 1

    // $result = mysqli_query($db,"SELECT * FROM `recruit_application` ORDER BY apply_date DESC LIMIT $offset, $total_records_per_page");
    
    
    if( isset($_POST['submit']) || !empty($_GET['search']) ){
        // echo $_POST['search'];
        if( !empty($_POST['search']) ){
            $search = $_POST['search'];
        }
        else if(!empty($_GET['search'])){
            $search = $_GET['search'];
        }
        $result_count = mysqli_query($db,"SELECT COUNT(*) As total_records FROM `recruit_application` WHERE (full_name LIKE '%$search%') OR (skills LIKE '%$search%' ) ");
        $total_records = mysqli_fetch_array($result_count);
        $total_records = $total_records['total_records'];
        $total_no_of_pages = ceil($total_records / $total_records_per_page);
        $second_last = $total_no_of_pages - 1; // total page minus 1

        $result = mysqli_query($db,"SELECT * FROM `recruit_application` WHERE (full_name LIKE '%$search%') OR (skills LIKE '%$search%' )  ORDER BY apply_date DESC LIMIT $offset, $total_records_per_page");

    }
    else{

        $search = '';
        $result_count = mysqli_query($db,"SELECT COUNT(*) As total_records FROM `recruit_application`");
        $total_records = mysqli_fetch_array($result_count);
        $total_records = $total_records['total_records'];
        $total_no_of_pages = ceil($total_records / $total_records_per_page);
        $second_last = $total_no_of_pages - 1; // total page minus 1

        $result = mysqli_query($db,"SELECT * FROM `recruit_application` ORDER BY apply_date DESC LIMIT $offset, $total_records_per_page");
    }

    // $resume_file_path  = "http://".$_SERVER['SERVER_NAME']."/career/resume_application/";
    $resume_file_path = "https://www.alegralabs.com/career/resume_application/";
    
    
}
else{
    // Changes were made here for demo purposes
    header('Location:EMS_LINK');
}

?>
<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

    <!-- DataTable CSS -->
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/datatables/1.10.21/css/jquery.dataTables.min.css" />

    <!-- DataTable Script -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/datatables/1.10.21/js/jquery.dataTables.min.js"></script>

    <!-- Font Awesome 5.15.4 -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css"
        integrity="sha512-1ycn6IcaQQ40/MKBW2W4Rhis/DbILU74C1vSrLJxCq57o941Ym01SwNsOMqvEBFlcgUa6xLiPY/NS5R+E6ztJQ=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />

    <link rel="stylesheet" href="css/bootstrap-side-modals.css">

    <!-- DataTables CSS -->
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/datatables/1.10.21/css/jquery.dataTables.min.css" />


    <!-- Sweetalert2 -->
    <link rel="stylesheet" href="css/sweetalert2.min.css">
    <!-- Sweetalert2 -->

    <title>Career@alegralabs</title>

    <style>
        #applicant_data_table_filter {
            display: none;
        }

        .dataTables_info {
            display: none;
        }

        .page-item.active .page-link {
            background-color: #6c757d !important;
            color: white !important;
            border: 1px solid #dee2e6;
        }

        .page-link {
            color: #6c757d !important;
        }
        .swal2-cancel{
            margin-right:10px;
        }


    </style>
</head>

<body>


         
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <nav class="navbar navbar-light bg-light">
                    <div class="container">
                        <a class="navbar-brand" href="https://www.alegralabs.com/ems">
                            <img src="img/logo-black.png" alt="" width="200" />
                        </a>
                    </div>
                </nav>
            </div>
            <div class="col-12">
                <div class="card">
                    <div class="card-body table-responsive">
                        <h5 class="card-title text-center">Candidate List</h5>
                        <h6 class="card-subtitle mb-2 text-muted text-center">Total Applicants:
                            <span><?=$count;?></span></h6>

                        <hr>

                        <div class="row my-3">
                            <div class="col-sm-12 col-md-6 text-md-start text-center my-2">
                                <input type="hidden" name="pageNo" id="pageNo" value="<?php echo $page_no ?>" />
                                <input type="hidden" name="offset" id="offset" value="<?php echo $offset ?>" />
                                <div class="form-check form-check-inline" style="padding-left:0 !important">
                                    <label class="form-check-label" for="inlineCheckbox1">Show: </label>
                                    <select name="showEntries" id="showEntries">
                                        <option disabled selected value="">Select</option>
                                        <option <?php if( $total_records_per_page =='10' ){ echo 'selected'; } ?>
                                            value="10">10</option>
                                        <option <?php if( $total_records_per_page =='20' ){ echo 'selected'; } ?>
                                            value="20">20</option>
                                        <option <?php if( $total_records_per_page =='50' ){ echo 'selected'; } ?>
                                            value="50">50</option>
                                        <option <?php if( $total_records_per_page =='100' ){ echo 'selected'; } ?>
                                            value="100">100</option>
                                        <option
                                            <?php if( $total_records_per_page ==$total_records ){ echo 'selected'; } ?>
                                            value="<?php echo $total_records;?>">All</option>
                                    </select>
                                </div>

                            </div>
                            <div class="col-sm-12 col-md-6 text-md-end text-center my-2">
                                <!-- <input type="text" name="search" id="search" /> -->
                                <div class="form-check form-check-inline" style="margin-right:0 !important">
                                    <!-- <form action="index" method="POST">
                                        <label class="form-check-label" for="inlineCheckbox1">Search: </label>
                                        <input type="text" id="search" name="search" id="search" placeholder="Search By Candidate Name" required
                                            value="<?php if( !empty($search) ){ echo $search; } ?>"/>
                                        <button type="submit" name="submit" class="btn btn-secondary btn-sm" style="margin-top:-7px;">Search</button>
                                    </form> -->
                                    <form class="row g-3 d-flex justify-content-center" action="index" method="POST">
                                        <!-- <div class="col-auto">
                                            <label for="staticEmail2" class="visually-hidden">Email</label>
                                            <input type="text" readonly class="form-control-plaintext text-center text-md-end text-lg-end " id="staticEmail2"
                                                value="Search">
                                        </div> -->
                                        <div class="col-auto">
                                            <label for="inputPassword2" class="visually-hidden">Password</label>
                                            <input type="text" class="form-control" id="search" name="search"
                                                value="<?php if( !empty($search) ){ echo $search; } ?>"
                                                placeholder="Search By Candidate Name">
                                        </div>
                                        <div class="col-auto">
                                            <button type="submit" name="submit" class="btn btn-secondary mb-3">Search</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>

                        <div class="row mt-3">
                            <div class="col-12 d-flex justify-content-end">
                                <nav aria-label="...">
                                    <ul class="pagination">
                                        <li class="page-item <?php if($page_no <= 1){ echo "class='disabled'"; } ?>">
                                            <a <?php if($page_no > 1){ echo "href='?page_no=$previous_page&show_entries=$show_entries'"; } ?>
                                                class="page-link" href="#" tabindex="-1"
                                                aria-disabled="true">Previous</a>
                                        </li>

                                        <?php 
                                    if ($total_no_of_pages <= 10){  	 
                                        for ($counter = 1; $counter <= $total_no_of_pages; $counter++){
                                            if ($counter == $page_no) {
                                        echo "<li class='page-item active'><a class='page-link'>$counter</a></li>";	
                                                }else{
                                                    if( !empty($search)){
                                                        echo "<li class='page-item'><a class='page-link' href='?page_no=$counter&show_entries=$show_entries&search=$search'>$counter</a></li>";
                                                    }
                                                    else{
                                                        echo "<li class='page-item'><a class='page-link' href='?page_no=$counter&show_entries=$show_entries'>$counter</a></li>";
                                                    }
                                                }
                                        }
                                    }
                                    elseif($total_no_of_pages > 10){

                                        if($page_no <= 4) {			
                                            for ($counter = 1; $counter < 8; $counter++){		 
                                                if ($counter == $page_no) {
                                                    echo "<li class='page-item active'><a class='page-link'>$counter</a></li>";	
                                                }else{
                                                    if( !empty($search) ){
                                                        echo "<li class='page-item'><a class='page-link' href='?page_no=$counter&show_entries=$show_entries&search=$search'>$counter</a></li>";
                                                    }
                                                    else{
                                                        echo "<li class='page-item'><a class='page-link' href='?page_no=$counter&show_entries=$show_entries'>$counter</a></li>";
                                                    }
                                                }
                                            }
                                            echo "<li class='page-item' ><a class='page-link'>...</a></li>";
                                            if( !empty($search) ){
                                                echo "<li class='page-item'><a class='page-link' href='?page_no=$second_last&show_entries=$show_entries&search=$search'>$second_last</a></li>";
                                                echo "<li class='page-item'><a class='page-link' href='?page_no=$total_no_of_pages&show_entries=$show_entries&search=$search'>$total_no_of_pages</a></li>";
    
                                            }
                                            else{
                                                echo "<li class='page-item'><a class='page-link' href='?page_no=$second_last&show_entries=$show_entries'>$second_last</a></li>";
                                                echo "<li class='page-item'><a class='page-link' href='?page_no=$total_no_of_pages&show_entries=$show_entries'>$total_no_of_pages</a></li>";
    
                                            }
                                                                                   }
                                        elseif($page_no > 4 && $page_no < $total_no_of_pages - 4) {		

                                            if( !empty($search) ){
                                                echo "<li class='page-item'><a class='page-link' href='?page_no=1&show_entries=$show_entries&search=$search'>1</a></li>";
                                                echo "<li class='page-item'><a class='page-link' href='?page_no=2&show_entries=$show_entries&search=$search'>2</a></li>";
                                            }
                                            else{
                                                echo "<li class='page-item'><a class='page-link' href='?page_no=1&show_entries=$show_entries'>1</a></li>";
                                                echo "<li class='page-item'><a class='page-link' href='?page_no=2&show_entries=$show_entries'>2</a></li>";
                                            }
                                            
                                            echo "<li class='page-item'><a class='page-link'>...</a></li>";
                                            for ($counter = $page_no - $adjacents; $counter <= $page_no + $adjacents; $counter++) {			
                                            if ($counter == $page_no) {
                                            echo "<li class='page-item active'><a class='page-link'>$counter</a></li>";	
                                                    }else{

                                                        if( !empty($search) ){
                                                            echo "<li class='page-item'><a class='page-link' href='?page_no=$counter&show_entries=$show_entries&search=$search'>$counter</a></li>";
                                                        }
                                                        else{
                                                            echo "<li class='page-item'><a class='page-link' href='?page_no=$counter&show_entries=$show_entries'>$counter</a></li>";
                                                        }

                                           
                                                    }                  
                                            }
                                            echo "<li class='page-item'><a class='page-link'>...</a></li>";
                                            if( !empty($search) ){
                                                echo "<li class='page-item'><a class='page-link' href='?page_no=$second_last&show_entries=$show_entries&search=$search'>$second_last</a></li>";
                                                echo "<li class='page-item'><a class='page-link' href='?page_no=$total_no_of_pages&show_entries=$show_entries&search=$search'>$total_no_of_pages</a></li>";  
                                            }
                                            else{
                                                echo "<li class='page-item'><a class='page-link' href='?page_no=$second_last&show_entries=$show_entries'>$second_last</a></li>";
                                                echo "<li class='page-item'><a class='page-link' href='?page_no=$total_no_of_pages&show_entries=$show_entries'>$total_no_of_pages</a></li>";  
                                            }
    
                                        }
                                        else {

                                            if( !empty($search) ){
                                                echo "<li class='page-item'><a class='page-link' href='?page_no=1&show_entries=$show_entries&search=$search'>1</a></li>";
                                                echo "<li class='page-item'><a class='page-link' href='?page_no=2&show_entries=$show_entries&search=$search'>2</a></li>";
                                                echo "<li class='page-item'><a class='page-link'>...</a></li>";
                                            }
                                            else{
                                                echo "<li class='page-item'><a class='page-link' href='?page_no=1&show_entries=$show_entries'>1</a></li>";
                                                echo "<li class='page-item'><a class='page-link' href='?page_no=2&show_entries=$show_entries'>2</a></li>";
                                                echo "<li class='page-item'><a class='page-link'>...</a></li>";
                                            }
                          
                        
                                            for ($counter = $total_no_of_pages - 6; $counter <= $total_no_of_pages; $counter++) {
                                                if ($counter == $page_no) {
                                                    echo "<li class='page-item active'><a class='page-link'>$counter</a></li>";	
                                                }else{
                                                    if( !empty($search) ){
                                                        echo "<li class='page-item'><a class='page-link' href='?page_no=$counter&show_entries=$show_entries&search=$search
                                                        '>$counter</a></li>";
                                                    }
                                                    else{
                                                        echo "<li class='page-item'><a class='page-link' href='?page_no=$counter&show_entries=$show_entries'>$counter</a></li>";
                                                    }
                                                }                   
                                            }
                                        }



                                    }
                                   


                                ?>

                                        <li
                                            <?php if($page_no >= $total_no_of_pages){ echo "class='page-item disabled'"; } ?>>
                                            <?php if( !empty($search)){ ?>
                                            <a class='page-link'
                                                <?php if($page_no < $total_no_of_pages) { echo "href='?page_no=$next_page&show_entries=$show_entries&search=$search'"; } ?>>Next</a>
                                            <?php }else{?>
                                            <a class='page-link'
                                                <?php if($page_no < $total_no_of_pages) { echo "href='?page_no=$next_page&show_entries=$show_entries'"; } ?>>Next</a>
                                            <?php }?>

                                        </li>
                                        <?php if($page_no < $total_no_of_pages){
                                             if( !empty($search) ){
                                                 echo "<li class='page-item'><a class='page-link' href='?page_no=$total_no_of_pages&show_entries=$show_entries&search=$search'>Last &rsaquo;&rsaquo;</a></li>";
                                            }
                                            else{
                                                echo "<li class='page-item'><a class='page-link' href='?page_no=$total_no_of_pages&show_entries=$show_entries'>Last &rsaquo;&rsaquo;</a></li>";
                                            }
                                        } ?>
                                    </ul>
                                    </ul>
                                </nav>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-12">
                                <div class="text-end">
                                    <strong>Page <?php echo $page_no." of ".$total_no_of_pages; ?></strong>
                                </div>
                            </div>
                        </div>

                        <div class="row my-3">
                            <div class="col-12">
                                <table id="applicant_data_table"
                                    class="table table-striped table-bordered border-secondary py-3 text-center">
                                    <thead>
                                        <tr>
                                            <th scope="col">Sl.No</th>
                                            <th scope="col">Full Name</th>
                                            <th scope="col">Skills</th>
                                            <th scope="col">Application Date</th>
                                            <th scope="col">Action</th>
                                            <th scope="col">View Details</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php 
                                    $i = $offset+1;
                                    while($userdata = mysqli_fetch_assoc($result)): 
                                        $skills = $userdata['skills'];
                                        $years = $userdata['years'];
                                        $skillsarr = explode(",", $skills);
                                        $yearsarr = explode(",", $years);

                                        $fileurl = $resume_file_path.$userdata['resume'];
                                       
                                ?>

                                        <tr id="table-row-<?=$userdata['id'];?>">
                                            <td width="5%">
                                                <p><?=$i;?>
                                            </td>
                                            <td>
                                                <p><?=$userdata['full_name'];?></p>
                                            </td>

                                            <td class="skill">
                                                <ul>
                                                    <?php for ($j=0; $j < count($skillsarr); $j++) { ?>
                                                    <span
                                                        class="badge rounded-pill bg-secondary position-relative px-3 py-2 mx-2 my-2">
                                                        <?php echo $skillsarr[$j]; ?>
                                                        <span
                                                            class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-secondary">
                                                            <?php echo $yearsarr[$j]; ?>
                                                            <span class="visually-hidden">unread messages</span>
                                                        </span>
                                                    </span>
                                                    <?php } ?>
                                                </ul>
                                            </td>

                                            <td width="12%">
                                                <!-- <p><?=$userdata['apply_date'];?></p> -->
                                                <?php 
                                                    $dt = new DateTime($userdata['apply_date']);
                                                    echo $dt->format('d-m-Y');
                                                ?>
                                            </td>
                                            <td class="action-btn" width="10%">
                                                <a title="Delete Data" class="delete" style="cursor: pointer;"
                                                    value="<?=$userdata['id'];?>"><img src="img/delete.svg"
                                                        height="20px"></a>

                                                <!-- <a href="<?=$fileurl;?>" target="_blank"
                                                    title="View Resume"><img src="img/view.svg" height="20px"></a> -->

                                                <a href="document.php?id=<?php echo $userdata['id']; ?>" target="_blank"
                                                    title="View Resume"><img src="img/view.svg" height="20px"></a>

                                                <!-- <a href="https://docs.google.com/gview?url=<?=$fileurl;?>" target="_blank" title="View Resume">
                                                <img src="../img/view.svg" height="20px"></a> -->

                                                <a title="Reply" data-bs-toggle="modal" style="cursor: pointer;"
                                                    data-bs-target="#reply-modal"><img src="img/reply.svg"
                                                        height="20px"></a>
                                            </td>
                                            <td width="5%">
                                                <button id="candidateViewBtn" type="button"
                                                    class="btn btn-secondary candidateViewBtn" data-bs-toggle="modal"
                                                    value="<?=$userdata['id'];?>" data-bs-target="#right_modal_lg">
                                                    View
                                                </button>
                                            </td>
                                        </tr>
                                        <?php 
                                    $i++; 
                                    endwhile;
                                ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-12">
                                <div class="text-end">
                                    <strong>Page <?php echo $page_no." of ".$total_no_of_pages; ?></strong>
                                </div>
                            </div>
                        </div>

                        <div class="row mt-3">
                            <div class="col-12 d-flex justify-content-end">
                                <nav aria-label="...">
                                    <ul class="pagination">
                                        <li class="page-item <?php if($page_no <= 1){ echo "class='disabled'"; } ?>">
                                            <a <?php if($page_no > 1){ echo "href='?page_no=$previous_page&show_entries=$show_entries'"; } ?>
                                                class="page-link" href="#" tabindex="-1"
                                                aria-disabled="true">Previous</a>
                                        </li>

                                        <?php 
                                    if ($total_no_of_pages <= 10){  	 
                                        for ($counter = 1; $counter <= $total_no_of_pages; $counter++){
                                            if ($counter == $page_no) {
                                        echo "<li class='page-item active'><a class='page-link'>$counter</a></li>";	
                                                }else{
                                                    if( !empty($search)){
                                                        echo "<li class='page-item'><a class='page-link' href='?page_no=$counter&show_entries=$show_entries&search=$search'>$counter</a></li>";
                                                    }
                                                    else{
                                                        echo "<li class='page-item'><a class='page-link' href='?page_no=$counter&show_entries=$show_entries'>$counter</a></li>";
                                                    }
                                                }
                                        }
                                    }
                                    elseif($total_no_of_pages > 10){

                                        if($page_no <= 4) {			
                                            for ($counter = 1; $counter < 8; $counter++){		 
                                                if ($counter == $page_no) {
                                                    echo "<li class='page-item active'><a class='page-link'>$counter</a></li>";	
                                                }else{
                                                    if( !empty($search) ){
                                                        echo "<li class='page-item'><a class='page-link' href='?page_no=$counter&show_entries=$show_entries&search=$search'>$counter</a></li>";
                                                    }
                                                    else{
                                                        echo "<li class='page-item'><a class='page-link' href='?page_no=$counter&show_entries=$show_entries'>$counter</a></li>";
                                                    }
                                                }
                                            }
                                            echo "<li class='page-item' ><a class='page-link'>...</a></li>";
                                            if( !empty($search) ){
                                                echo "<li class='page-item'><a class='page-link' href='?page_no=$second_last&show_entries=$show_entries&search=$search'>$second_last</a></li>";
                                                echo "<li class='page-item'><a class='page-link' href='?page_no=$total_no_of_pages&show_entries=$show_entries&search=$search'>$total_no_of_pages</a></li>";
    
                                            }
                                            else{
                                                echo "<li class='page-item'><a class='page-link' href='?page_no=$second_last&show_entries=$show_entries'>$second_last</a></li>";
                                                echo "<li class='page-item'><a class='page-link' href='?page_no=$total_no_of_pages&show_entries=$show_entries'>$total_no_of_pages</a></li>";
    
                                            }
                                                                                   }
                                        elseif($page_no > 4 && $page_no < $total_no_of_pages - 4) {		

                                            if( !empty($search) ){
                                                echo "<li class='page-item'><a class='page-link' href='?page_no=1&show_entries=$show_entries&search=$search'>1</a></li>";
                                                echo "<li class='page-item'><a class='page-link' href='?page_no=2&show_entries=$show_entries&search=$search'>2</a></li>";
                                            }
                                            else{
                                                echo "<li class='page-item'><a class='page-link' href='?page_no=1&show_entries=$show_entries'>1</a></li>";
                                                echo "<li class='page-item'><a class='page-link' href='?page_no=2&show_entries=$show_entries'>2</a></li>";
                                            }
                                            
                                            echo "<li class='page-item'><a class='page-link'>...</a></li>";
                                            for ($counter = $page_no - $adjacents; $counter <= $page_no + $adjacents; $counter++) {			
                                            if ($counter == $page_no) {
                                            echo "<li class='page-item active'><a class='page-link'>$counter</a></li>";	
                                                    }else{

                                                        if( !empty($search) ){
                                                            echo "<li class='page-item'><a class='page-link' href='?page_no=$counter&show_entries=$show_entries&search=$search'>$counter</a></li>";
                                                        }
                                                        else{
                                                            echo "<li class='page-item'><a class='page-link' href='?page_no=$counter&show_entries=$show_entries'>$counter</a></li>";
                                                        }

                                           
                                                    }                  
                                            }
                                            echo "<li class='page-item'><a class='page-link'>...</a></li>";
                                            if( !empty($search) ){
                                                echo "<li class='page-item'><a class='page-link' href='?page_no=$second_last&show_entries=$show_entries&search=$search'>$second_last</a></li>";
                                                echo "<li class='page-item'><a class='page-link' href='?page_no=$total_no_of_pages&show_entries=$show_entries&search=$search'>$total_no_of_pages</a></li>";  
                                            }
                                            else{
                                                echo "<li class='page-item'><a class='page-link' href='?page_no=$second_last&show_entries=$show_entries'>$second_last</a></li>";
                                                echo "<li class='page-item'><a class='page-link' href='?page_no=$total_no_of_pages&show_entries=$show_entries'>$total_no_of_pages</a></li>";  
                                            }
    
                                        }
                                        else {

                                            if( !empty($search) ){
                                                echo "<li class='page-item'><a class='page-link' href='?page_no=1&show_entries=$show_entries&search=$search'>1</a></li>";
                                                echo "<li class='page-item'><a class='page-link' href='?page_no=2&show_entries=$show_entries&search=$search'>2</a></li>";
                                                echo "<li class='page-item'><a class='page-link'>...</a></li>";
                                            }
                                            else{
                                                echo "<li class='page-item'><a class='page-link' href='?page_no=1&show_entries=$show_entries'>1</a></li>";
                                                echo "<li class='page-item'><a class='page-link' href='?page_no=2&show_entries=$show_entries'>2</a></li>";
                                                echo "<li class='page-item'><a class='page-link'>...</a></li>";
                                            }
                          
                        
                                            for ($counter = $total_no_of_pages - 6; $counter <= $total_no_of_pages; $counter++) {
                                                if ($counter == $page_no) {
                                                    echo "<li class='page-item active'><a class='page-link'>$counter</a></li>";	
                                                }else{
                                                    if( !empty($search) ){
                                                        echo "<li class='page-item'><a class='page-link' href='?page_no=$counter&show_entries=$show_entries&search=$search
                                                        '>$counter</a></li>";
                                                    }
                                                    else{
                                                        echo "<li class='page-item'><a class='page-link' href='?page_no=$counter&show_entries=$show_entries'>$counter</a></li>";
                                                    }
                                                }                   
                                            }
                                        }



                                    }
                                   


                                ?>

                                        <li
                                            <?php if($page_no >= $total_no_of_pages){ echo "class='page-item disabled'"; } ?>>
                                            <?php if( !empty($search)){ ?>
                                            <a class='page-link'
                                                <?php if($page_no < $total_no_of_pages) { echo "href='?page_no=$next_page&show_entries=$show_entries&search=$search'"; } ?>>Next</a>
                                            <?php }else{?>
                                            <a class='page-link'
                                                <?php if($page_no < $total_no_of_pages) { echo "href='?page_no=$next_page&show_entries=$show_entries'"; } ?>>Next</a>
                                            <?php }?>

                                        </li>
                                        <?php if($page_no < $total_no_of_pages){
                                             if( !empty($search) ){
                                                 echo "<li class='page-item'><a class='page-link' href='?page_no=$total_no_of_pages&show_entries=$show_entries&search=$search'>Last &rsaquo;&rsaquo;</a></li>";
                                            }
                                            else{
                                                echo "<li class='page-item'><a class='page-link' href='?page_no=$total_no_of_pages&show_entries=$show_entries'>Last &rsaquo;&rsaquo;</a></li>";
                                            }
                                        } ?>
                                    </ul>
                                    </ul>
                                </nav>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>


    <!-- Modal -->
    <div class="modal modal-right fade" id="right_modal_lg" tabindex="-1" aria-labelledby="right_modal_lg"
        aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title candidateName" id="exampleModalLabel">Modal title</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="container py-3">
                        <div class="row">
                            <div class="col-12 py-3">
                                <div class="card">
                                    <div class="card-body">
                                        <h5 class="card-title fw-bold">Personal Info</h5>
                                        <hr>
                                        <table class="table">
                                            <tbody>
                                                <tr>
                                                    <td class="fw-bold" width="20%">Full Name</td>
                                                    <td id="full_name"></td>
                                                </tr>
                                                <tr>
                                                    <td class="fw-bold" width="20%">Email ID</td>
                                                    <td id="email"></td>
                                                </tr>
                                                <tr>
                                                    <td class="fw-bold" width="20%">Phone Number</td>
                                                    <td id="phone"></td>
                                                </tr>
                                                <tr>
                                                    <td class="fw-bold" width="20%">Address</td>
                                                    <td id="address"></td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>

                            <div class="col-12 py-3">
                                <div class="card">
                                    <div class="card-body">
                                        <h5 class="card-title fw-bold">Skills / Questions</h5>
                                        <hr>
                                        <table class="table">
                                            <tbody>
                                                <tr>
                                                    <td class="fw-bold" width="20%">Skills And Years Of Experience</td>
                                                    <td id="skillsList">
                                                        <!-- <span
                                                            class="badge rounded-pill bg-success position-relative px-3 py-2 mx-2 my-2">
                                                            Restful API (XML/JSON)
                                                            <span
                                                                class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-info">
                                                                10
                                                                <span class="visually-hidden">unread messages</span>
                                                            </span>
                                                        </span>

                                                        <span
                                                            class="badge rounded-pill bg-success position-relative px-3 py-2 mx-2 my-2">
                                                            Restful API (XML/JSON)
                                                            <span
                                                                class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-info">
                                                                10
                                                                <span class="visually-hidden">unread messages</span>
                                                            </span>
                                                        </span>

                                                        <span
                                                            class="badge rounded-pill bg-success position-relative px-3 py-2 mx-2 my-2">
                                                            Restful API (XML/JSON)
                                                            <span
                                                                class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-info">
                                                                10
                                                                <span class="visually-hidden">unread messages</span>
                                                            </span>
                                                        </span>

                                                        <span
                                                            class="badge rounded-pill bg-success position-relative px-3 py-2 mx-2 my-2">
                                                            Restful API (XML/JSON)
                                                            <span
                                                                class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-info">
                                                                10
                                                                <span class="visually-hidden">unread messages</span>
                                                            </span>
                                                        </span>

                                                        <span
                                                            class="badge rounded-pill bg-success position-relative px-3 py-2 mx-2 my-2">
                                                            Linux
                                                            <span
                                                                class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-info">
                                                                10
                                                                <span class="visually-hidden">unread messages</span>
                                                            </span>
                                                        </span>

                                                        <span
                                                            class="badge rounded-pill bg-success position-relative px-3 py-2 mx-2 my-2">
                                                            Linux
                                                            <span
                                                                class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-info">
                                                                10
                                                                <span class="visually-hidden">unread messages</span>
                                                            </span>
                                                        </span>

                                                        <span
                                                            class="badge rounded-pill bg-success position-relative px-3 py-2 mx-2 my-2">
                                                            Linux
                                                            <span
                                                                class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-info">
                                                                10
                                                                <span class="visually-hidden">unread messages</span>
                                                            </span>
                                                        </span>

                                                        <span
                                                            class="badge rounded-pill bg-success position-relative px-3 py-2 mx-2 my-2">
                                                            Linux
                                                            <span
                                                                class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-info">
                                                                10
                                                                <span class="visually-hidden">unread messages</span>
                                                            </span>
                                                        </span>

                                                        <span
                                                            class="badge rounded-pill bg-success position-relative px-3 py-2 mx-2 my-2">
                                                            Linux
                                                            <span
                                                                class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-info">
                                                                10
                                                                <span class="visually-hidden">unread messages</span>
                                                            </span>
                                                        </span>

                                                        <span
                                                            class="badge rounded-pill bg-success position-relative px-3 py-2 mx-2 my-2">
                                                            Linux
                                                            <span
                                                                class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-info">
                                                                10
                                                                <span class="visually-hidden">unread messages</span>
                                                            </span>
                                                        </span>

                                                        <span
                                                            class="badge rounded-pill bg-success position-relative px-3 py-2 mx-2 my-2">
                                                            Linux
                                                            <span
                                                                class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-info">
                                                                10
                                                                <span class="visually-hidden">unread messages</span>
                                                            </span>
                                                        </span>

                                                        <span
                                                            class="badge rounded-pill bg-success position-relative px-3 py-2 mx-2 my-2">
                                                            Linux
                                                            <span
                                                                class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-info">
                                                                10
                                                                <span class="visually-hidden">unread messages</span>
                                                            </span>
                                                        </span>


                                                        <span
                                                            class="badge rounded-pill bg-success position-relative px-3 py-2 mx-2 my-2">
                                                            Linux
                                                            <span
                                                                class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-info">
                                                                10
                                                                <span class="visually-hidden">unread messages</span>
                                                            </span>
                                                        </span>

                                                        <span
                                                            class="badge rounded-pill bg-success position-relative px-3 py-2 mx-2 my-2">
                                                            Linux
                                                            <span
                                                                class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-info">
                                                                10
                                                                <span class="visually-hidden">unread messages</span>
                                                            </span>
                                                        </span> -->

                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="fw-bold" width="20%">Training</td>
                                                    <td id="training">
                                                        <!-- <span class="badge rounded-pill bg-success">Yes</span>
                                                        <span class="badge rounded-pill bg-danger">No</span> -->
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="fw-bold" width="20%">Discipline</td>
                                                    <td id="discipline"></td>
                                                </tr>
                                                <tr>
                                                    <td class="fw-bold" width="20%">Working Grade</td>
                                                    <td id="grade"></td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>


                            <div class="col-12 py-3">
                                <div class="card">
                                    <div class="card-body">
                                        <h5 class="card-title fw-bold">Documents</h5>
                                        <hr>
                                        <table class="table">
                                            <tbody>
                                                <tr>
                                                    <td class="fw-bold" width="20%">Agreement Accepted</td>
                                                    <td id="agreement">
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="fw-bold" width="20%">Application Date</td>
                                                    <td id="applicationDate"></td>
                                                </tr>
                                                <!-- <tr>
                                                    <td class="fw-bold" width="20%">Resume Link</td>
                                                    <td>
                                                        <a
                                                            href="#">http://www.alegralabs.com/career/resume_application/20190503005553163964SamarCV.docx</a>
                                                    </td>
                                                </tr> -->
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <!-- <button type="button" class="btn btn-primary">Save changes</button> -->
                </div>
            </div>
        </div>
    </div>
    <!-- Modal -->

    <!-- Reply Modal -->
    <!-- Modal -->
    <div class="modal fade" id="reply-modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="form-inline">
                        <label class="my-1 mr-2 col-lg-4" for="subject">Subject</label>
                        <input type="text" class="form-control col-lg-7" name="subject" value="Application Form Submit">
                    </div>
                    <div class="form-inline">
                        <label class="my-1 mr-2 col-lg-4" for="subject">Message</label>
                        <textarea class="form-control col-lg-7" rows="5">Thank You For Submit Your Message</textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary">Send</button>
                </div>
            </div>
        </div>
    </div>
    <!-- Reply Modal -->

    <!-- Optional JavaScript; choose one of the two! -->

    <!-- Option 1: Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous">
    </script>

    <!-- Jquery Core Js -->
    <!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script> -->
    <script src="https://code.jquery.com/jquery-3.3.1.js"></script>

    <!-- DataTables -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/datatables/1.10.21/js/jquery.dataTables.min.js"></script>

    <!-- Sweetalert2 -->
    <script src="js/sweetalert2.min.js"></script>
    <!-- Sweetalert2 -->

    <script>

        $(document).ready(function () {

            $('#applicant_data_table').dataTable({
                "searching": false,
                "info": true,
                "lengthChange": false,
                "bPaginate": false,
                // "bProcessing": true,
                // "bServerSide": true,
                // "ajax": "process_data.php"

            });

            $("#showEntries").change(function () {
                // console.log( $("#showEntries").val() );
                if ($("#showEntries").val()) {
                    // window.location = '?page_no='+$("#pageNo").val()+'&show_entries=' + $("#showEntries").val();
                    if ($("#search").val().length == 0) {
                        window.location = '?page_no=' + $("#pageNo").val() + '&show_entries=' + $(
                            "#showEntries").val() + '&offset=' + $("#offset").val();
                    } else {
                        window.location = '?page_no=' + $("#pageNo").val() + '&show_entries=' + $(
                                "#showEntries").val() + '&offset=' + $("#offset").val() + '&search=' +
                            $("#search").val();
                    }
                }
            });

            var table = $('#applicant_data_table').DataTable();
            // #myInput is a <input type="text"> element
            $('#search').on('keyup', function () {
                table.search(this.value).draw();
            });

            // $('#applicant_data_table').DataTable();

            $('.delete').click(function () {
                var id = $(this).attr("value");
                var data_id = JSON.stringify({
                    deleteid: id
                });

                const swalWithBootstrapButtons = Swal.mixin({
                customClass: {
                    confirmButton: 'btn btn-success',
                    cancelButton: 'btn btn-danger'
                },
                buttonsStyling: false
                })

                swalWithBootstrapButtons.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Yes, delete it!',
                cancelButtonText: 'No, cancel!',
                reverseButtons: true
                }).then((result) => {
                if (result.isConfirmed) {
                        $.ajaxSetup({
                            url: "delete-data.php",
                            data: data_id,
                            async: true,
                            cache: false,
                            contentType: false,
                            processData: false,
                            beforeSend: function () {
                                $(".preloader").show();
                            },
                            complete: function () {
                                $(".preloader").hide();
                            }
                        });
                        $.post()
                            .done(function (response) {

                                console.log(response)
                                var res = JSON.parse(response);
                                var status = res['status'];
                                var message = res['message'];

                                if (status == 'success') {
                                    $('#delete-message').show();
                                    $('#table-row-' + id).fadeOut();
                                        //     swalWithBootstrapButtons.fire(
                                        //     'Deleted!',
                                        //     'Your file has been deleted.',
                                        //     'success'
                                        // )
                                        Swal.fire({
                                            icon: 'success',
                                            title: 'Success',
                                            text: 'Something went wrong!',
                                            // footer: '<a href="">Why do I have this issue?</a>'
                                        }).then(function() {
                                            window.location = "index";
                                        });

                                } else {
                                    location.reload(true);
                                }
                            })
                            .fail(function () {
                                alert('failed to process');
                            })
                        return false;
                } else if (
                    /* Read more about handling dismissals below */
                    result.dismiss === Swal.DismissReason.cancel
                ) {
                    swalWithBootstrapButtons.fire(
                    'Cancelled',
                    'Data is safe :)',
                    'error'
                    )
                }
                })

                // $.ajaxSetup({
                //     url: "delete-data.php",
                //     data: data_id,
                //     async: true,
                //     cache: false,
                //     contentType: false,
                //     processData: false,
                //     beforeSend: function () {
                //         $(".preloader").show();
                //     },
                //     complete: function () {
                //         $(".preloader").hide();
                //     }
                // });
                // $.post()
                //     .done(function (response) {

                //         console.log(response)
                //         var res = JSON.parse(response);
                //         var status = res['status'];
                //         var message = res['message'];

                //         if (status == 'success') {
                //             $('#delete-message').show();
                //             $('#table-row-' + id).fadeOut();
                //         } else {
                //             location.reload(true);
                //         }
                //     })
                //     .fail(function () {
                //         alert('failed to process');
                //     })
                // return false;
            });

            // Fetch Candidate Details
            $('.candidateViewBtn').click(function () {
                var id = $(this).attr("value");
                console.log("id", id);
                var data_id = JSON.stringify({
                    deleteid: id
                });

                $.ajaxSetup({
                    url: "candidate-details.php",
                    data: data_id,
                    async: true,
                    cache: false,
                    contentType: false,
                    processData: false,
                    beforeSend: function () {
                        // $(".preloader").show();
                    },
                    complete: function () {
                        // $(".preloader").hide();
                    }
                });
                $.post()
                    .done(function (response) {

                        var response = $.parseJSON(response);
                        console.log(response)
                        $(".candidateName").text(response.full_name);
                        $("#full_name").text(response.full_name);
                        $("#email").text(response.email);
                        $("#phone").text(response.phone);
                        $("#address").text(response.address);



                        // console.log( response.skills.split(',') )
                        var years = response.years.split(',');
                        var skills = response.skills.split(',')
                        $("#skillsList").html('');
                        for (var i = 0; i < skills.length; i++) {
                            console.log("skill", skills[i]);
                            $("#skillsList").append(
                                '<span class="badge rounded-pill bg-success position-relative px-3 py-2 mx-2 my-2">' +
                                skills[i] +
                                '<span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-info">' +
                                years[i] +
                                '<span class="visually-hidden">unread messages</span>' +
                                '</span>' +
                                '</span>');
                        }
                        if (response.training == 'yes') {
                            $("#training").html(
                                '<span class="badge rounded-pill bg-success">Yes</span>');
                        } else if (response.training == 'no') {
                            $("#training").html(
                                '<span class="badge rounded-pill bg-danger">No</span>');
                        }
                        $("#discipline").text(response.discipline_grade);
                        $("#grade").text(response.working_grade);
                        if (response.agreement == 'agree') {
                            $("#agreement").html(
                                '<span class="badge rounded-pill bg-success">Agree</span>');
                        } else {
                            $("#agreement").html(
                                '<span class="badge rounded-pill bg-danger">Disagree</span>');
                        }

                        var currentTime = new Date(response.apply_date);
                        var month = currentTime.getMonth() + 1;
                        var date = currentTime.getDate();
                        var year = currentTime.getFullYear();
                        $('#applicationDate').html(date + '-' + month + '-' + year);

                    })
                    .fail(function () {
                        alert('failed to process');
                    })
                return false;
            });
            // Fetch Candidate Details

        });
    </script>


</body>

</html>