<?php
/**
 * * @file
 * php version 8.2
 * Comments Page for CMS
 * 
 * @category CMS
 * @package  Comments_Configuration_Page
 * @author   Rodney St.Cloud <hoyrod1@aol.com>
 * @license  STC Media inc
 * @link     https://cms/comments.php
 */
require_once "includes/session.php";
require_once "includes/db_conn.php";
require_once "includes/functions.php";
require_once "includes/date_time.php";

$_SESSION['trackingURL'] = $_SERVER['PHP_SELF'];
confirmLogin();

//---------------------- BEGGING HTML-NAV SECTION ----------------------//
$title = "Comment Page";
require_once "includes/links/loggedin_nav_links.php";
//---------------------- ENDING HTML-NAV SECTION ----------------------//
?>
<!------------- BEGGINING JAVASCRIPT SECTION ------------->
<script>
    function confirmDelete()
    {
        return confirm('Are you sure you want to delete this comment?');
    }
    function confirmDisApprove()
    {
        return confirm('Are you sure you want to disapprove this comment?');
    }
    function confirmApprove()
    {
        return confirm('Are you sure you want to approve this comment?');
    }
</script>
<!------------- ENDING JAVASCRIPT SECTION ---------------->

  <hr>
  <!-- HEADER BEGINS-->
  <header class="bg-light text-white py-3">
    <div class="container">
      <div class="row">
        <div class="col-md-12 ">
          <h1>
            <i class="fas fa-comments" style="color: #3F628A;"> 
              Welcome to the Manage Comment page
            </i>
          </h1>
        </div>
      </div>
    </div>
  </header>
  <!-- HEADER ENDS-->
  <hr>
  <?php 
      echo errorMessage();
      echo successMessage(); 
    ?>
  <!----------BEGINNING OF SECTION------->
  <section class="container py-2 mb-4">
    <div class="row" style="min-height: 30px;">
      <div class="col-lg-12" style="min-height: 400px;">
        <h2>Un-Approved Comments</h2>
  <!-------------BEGINNING OF TABLE-------------->
  <table class="table table-striped table-hover">
    <!----------BEGINNING OF TABLE HEADING------->
    <thead class="thead-dark">
      <tr>
        <th>No.</th>
        <th>Name</th>
        <th>Date & Time</th>
        <th>Comment</th>
        <th>Approve</th>
        <th>Action</th>
        <th>Details</th>
     </tr>
    </thead>
    <!---------ENDING OF TABLE HEADING------------>
        <!----------BEGINNING OF TABLE DATA------->
        <?php  
            $conn     = new Database("localhost", "root", "root", "cms");
            $sql      = "SELECT * FROM comments
                        WHERE comment_status = 'off' ORDER BY id DESC";
            $execute  = $conn->conn()->query($sql);

            $count    = 1; 
        while ($comment_rows = $execute->fetch()) {

            $comment_count           = $count++;
            $comment_id              = $comment_rows['id'];
            $comment_date_time       = $comment_rows['reg_date'];
            $comment_name            = $comment_rows['name'];
            $comment_email           = $comment_rows['email'];
            $comment_comments        = $comment_rows['comment'];
            $comment_post_id         = $comment_rows['post_id'];

            $dateTime = date('m/d/Y g:i a', strtotime($comment_date_time));

            if (strlen($dateTime) > 9) { 
                $dateTime = substr($dateTime, 0, 8);
            }
            if (strlen($comment_name) > 6) { 
                $comment_name = substr($comment_name, 0, 5).".."; 
            }
            // if (strlen($comment_comments) > 30) { 
            //$comment_comments = substr($comment_comments, 0, 29)."...."; 
            //}
            ?>
        <!----------BEGINNING OF TABLE HEADING------->
        <thead>
          <tr>
            <td><?php echo htmlentities($comment_count); ?></td>
            <td><?php echo htmlentities($comment_name); ?></td>
            <td><?php echo htmlentities($dateTime); ?></td>
            <td><?php echo htmlentities($comment_comments); ?></td>
            <td style="min-width: 150px;">
              <a href="approve_comment.php?id=<?php echo $comment_id;?>" class="btn btn-success" onclick="return confirmApprove() ;">
                Approve
              </a>
            </td> 
            <td>
              <a href="delete_comment.php?id=<?php echo $comment_id; ?>" class="btn btn-danger" onclick="return confirmDelete() ;">
                Delete
              </a>
            </td>
            <td style="min-width: 160px;">
              <a class="btn btn-primary" href="full_post.php?id=<?php echo $comment_post_id; ?>" target="_blank">
                Full Comment
              </a>
            </td>
         </tr>
        <!----------BEGINNING OF TABLE HEADING------->
        </thead>
        <?php }; ?>
  <!-------ENDING OF FETCHING TABLE DATA--------->
  </table>
  <!-------------ENDING OF TABLE----------------->
        <h2>Approved Comments</h2>
        <!-------------ENDING OF TABLE----------------->
        <table class="table table-striped table-hover">
          <!------BEGINNING OF TABLE HEADING------->
          <thead class="thead-dark">
            <tr>
              <th>No.</th>
              <th>Name</th>
              <th>Date & Time</th>
              <th>Comment</th>
              <th>Revert</th>
              <th>Action</th>
              <th>Details</th>
            </tr>
          </thead>
          <!--------ENDING OF TABLE HEADING-------->

          <!----------BEGINNING OF TABLE DATA------->
          <?php  
            $conn     = new Database("localhost", "root", "root", "cms");
            $sql      = "SELECT * FROM comments 
                         WHERE comment_status = 'ON' ORDER BY id DESC";
            $execute  = $conn->conn()->query($sql);
            //$sql_results =
            $count    = 1; 
            while ($comment_rows = $execute->fetch()) {

                $comment_count           = $count++;
                $comment_id              = $comment_rows['id'];
                $comment_date_time       = $comment_rows['reg_date'];
                $comment_name            = $comment_rows['name'];
                $comment_email           = $comment_rows['email'];
                $comment_comments        = $comment_rows['comment'];
                $comment_post_id         = $comment_rows['post_id'];

                $dateTime = date('m/d/Y g:i a', strtotime($comment_date_time));

                if (strlen($dateTime) > 9) { 
                    $dateTime = substr($dateTime, 0, 8); 
                }
                if (strlen($comment_name) > 6) { 
                    $comment_name = substr($comment_name, 0, 5).".."; 
                }
                //if (strlen($comment_comments) > 30) { 
                    // $comment_comments = substr($comment_comments, 0, 29)."...."; }
                ?>
          <thead>
            <tr>
                <td><?php echo htmlentities($comment_count); ?></td>
                <td><?php echo htmlentities($comment_name); ?></td>
                <td><?php echo htmlentities($dateTime); ?></td>
                <td><?php echo htmlentities($comment_comments); ?></td>
                <td style="min-width: 150px;">
                  <a href="dis_approve_comment.php?id=<?php echo $comment_id; ?>" class="btn btn-warning" onclick="return confirmDisApprove() ;">
                    Dis-Approve
                  </a>
                </td> 
                <td>
                  <a href="delete_comment.php?id=<?php echo $comment_id; ?>" class="btn btn-danger" onclick="return confirmDelete() ;">
                    Delete
                  </a>
                </td>
                <td style="min-width: 160px;">
                  <a class="btn btn-primary" href="full_post.php?id=<?php echo $comment_post_id; ?>">
                    Full Comment
                  </a>
                </td>
            </tr>
          </thead>
          <!----------------ENDING OF TABLE HEADING----------------->
            <?php }; ?>
        </table>
        <!-------------ENDING OF TABLE----------------->
        </div>
      </div>
      <div style="width:100%;background-color: #343a40;padding:4px;">
                <div class="col-lg-4 mx-auto">
                    <a href="dashboard.php" class="btn btn-warning btn-block">
                        <i class="fas fa-arrow-left"></i> Back to Dashboard
                    </a>
                </div>
      </div>
    </section>
  <hr>
<!--------------------BEGINNING FOOTER AND BODY SECTION-------------------->
<?php require_once "includes/footer.php"; ?>
<!---------------------ENDING FOOTER AND BODY SECTION---------------------->