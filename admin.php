<?php 
/**
 * * @file
 * php version 8.2
 * Admin Page for CMS registration
 * 
 * @category CMS
 * @package  Admin_Configuration
 * @author   Rodney St.Cloud <hoyrod1@aol.com>
 * @license  STC Media inc
 * @link     https://cms/admin.php
 */
require_once "includes/session.php";
require_once "includes/db_conn.php";
require_once "includes/functions.php";
require_once "includes/date_time.php";

$_SESSION['trackingURL'] = $_SERVER['PHP_SELF'];
confirmLogin();

if (isset($_POST['submit'])) {
    $username         = testInput($_POST['username']);
    $name             = testInput($_POST['name']);
    $password         = testInput($_POST['password']);
    $confirm_password = testInput($_POST['confirmpassword']);
    $admin            = $_SESSION['admin_name'];
    

    if (empty($username) || empty($name) || empty($password) || empty($confirm_password)) {
        $_SESSION['error_message'] = "Please fill out the form";
        redirect("admin.php");
    } elseif (strlen($password) < 5) {
        $_SESSION['error_message'] = "Your password should be more than 4 characters! ";
        redirect("admin.php");
        // CREATE VALIDATION FOR STRONG PASSWORD//
    } elseif ($password !== $confirm_password) {
        $_SESSION['error_message'] = "Your passwords do not match! ";
        redirect("admin.php");
    } elseif (usernameExist($username)) {
        $_SESSION['error_message'] = "$username already exist, choose another one";
        redirect("admin.php");
    } else {
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        $connect  = new Database("localhost", "root", "root", "cms");

        $sql      = "INSERT INTO admin(username, 
                                       password, 
                                       admin_name, 
                                       added_by) 
                                       VALUES(:adminUserName, 
                                       :adminPassWord, 
                                       :adminAdminName, 
                                       :adminAddedBy)";
        $pre_stmt = $connect->conn()->prepare($sql);
        $pre_stmt->bindValue(':adminUserName', $username);
        $pre_stmt->bindValue(':adminPassWord', $hashed_password);
        $pre_stmt->bindValue(':adminAdminName', $name);
        $pre_stmt->bindValue(':adminAddedBy', $admin);
        $execute = $pre_stmt->execute();
        if ($execute) {

            $_SESSION['success_message'] = 'Admin '. $name . ' added succesfully!';
            redirect("admin.php");

        } else {

            $_SESSION['success_message'] = "New Admin has not been submitted!";
            redirect("admin.php");

        }
    }
}
?>

<!------------BEGGINING  HTML-NAV SECTION ------------>
<?php 
$title = "Admin Page";
require_once "includes/loggedin_nav_links.php"; 
?>
<!-------------ENDING HTML-NAV SECTION---------------->
   <!---------------------------------HEADER BEGINS-------------------------------->
   <hr>
   <header class="bg-dark text-white py-3">
     <div class="container">
       <div class="row">
           <div class="col-md-12 ">
               <h1>
                   <i class="fas fa-user" style="color: #3F628A;"> Manage Admins </i>
               </h1>
           </div>
      </div>
    </div>
  </header>
  <hr>
  <!----------------------------------HEADER ENDS---------------------------------->

  <!--------------------------------MAIN AREA BEGIN-------------------------------->
  <section class="container py-2 mb-4">
    <div class="row">
      <div class="offset-lg-1 col-md-10 bg-light" style="min-height:500px;">
        <?php 
          echo errorMessage();
          echo successMessage();
        ?>
       <form class="" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" enctype="multipart/form-data">
         <div class="card bg-secondary">
            <div class="card-header">
              <h1 style="color: #3F628A;">Add New Admin</h1>
            </div>
            <div class="card-body bg-dark">
              <div class="form-group">
                <label for="username"><span class="label"> User Name: </span></label>
               <input class="form-control" id="username" type="text" name="username" required>
              </div>
              <div class="form-group">
                <label for="name"><span class="label"> Name: </span></label>
                <input class="form-control" id="name" type="text" name="name" required>
                <!-- <small class="text-warning text-muted">Optional</small> -->
              </div>
                <div class="form-group">
                    <label for="password"><span class="label"> Password: </span></label>
                    <input class="form-control" id="password" type="password" name="password" required>
                </div>
                <div class="form-group">
                    <label for="confirmpassword"><span class="label"> Confirm Password: </span></label>
                    <input class="form-control" id="confirmpassword" type="password" name="confirmpassword" required>
                </div>
                <div class="row py-3">
                    <div class="col-lg-6 mb-2">
                        <a href="dashboard.php" class="btn btn-warning btn-block">
                            <i class="fas fa-arrow-left"></i> Back to Dashboard
                        </a>
                    </div>
                    <div class="col-lg-6 mb-2">
                       <button type="submit" name="submit" class="btn btn-success btn-block">
                         <i class="fas fa-check"></i> Submit
                       </button>
                    </div>
                  </div>
            </div>
          </div>
        </form>
      <br>
      <h2>Existing Admins</h2>
      <!----------BEGINNING OF TABLE HEADING------->
      <table class="table table-striped table-hover">
         <thead class="thead-dark">
            <tr>
               <th>No.</th>
               <th style="min-width: 150px;">Date & Time Added</th>
               <th style="min-width: 150px;">User Name</th>
               <th style="min-width: 150px;">Amin Name</th>
               <th style="min-width: 150px;">Approved By</th>
               <th style="min-width: 150px;">Delete Admin</th>
            </tr>
         </thead>
       <!---------ENDING OF TABLE HEADING------------>

       <!----------BEGINNING OF CATEGORIY TABLE DATA------->
       <?php  
        $conn     = new Database("localhost", "root", "root", "cms");
        $sql      = "SELECT * FROM admin ORDER BY id DESC";
        $execute  = $conn->conn()->query($sql);
        //$sql_results =
        $count    = 1; 
        while ($comment_rows = $execute->fetch()) {

            $admin_count      = $count++;
            $admin_id         = $comment_rows['id'];
            $admin_date_time  = $comment_rows['date_time'];
            $admin_username   = $comment_rows['username'];
            $admin_password   = $comment_rows['password'];
            $admin_name       = $comment_rows['admin_name'];
            $admin_added_by   = $comment_rows['added_by'];

            $dateTime = date('m/d/Y g:i a', strtotime($admin_date_time));

            ?>
          <thead>
            <tr>
              <td><?php echo htmlentities($admin_count); ?></td>
              <td><?php echo htmlentities($dateTime); ?></td>
              <td><?php echo htmlentities($admin_username); ?></td>
              <td><?php echo htmlentities($admin_name); ?></td>
              <td><?php echo htmlentities($admin_added_by); ?></td>
              <td>
                  <a href="delete_admin.php?id=<?php echo $admin_id; ?>" 
                     class="btn btn-danger"> Delete
                  </a>
              </td>
              </td>
            </tr>
          </thead>
        <?php };?>
      </table>
      </div>
    </div>
  </section>

</body>
<!-- MAIN AREA ENDS-->
<hr>

<!----BEGINNING FOOTER AND BODY SECTION---->
<?php require_once "includes/footer.php"; ?>
<!-----ENDING FOOTER AND BODY SECTION------>