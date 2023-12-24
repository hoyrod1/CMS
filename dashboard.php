<?php
/**
 * * @file
 * php version 8.2
 * Dashboard Page for CMS
 * 
 * @category CMS
 * @package  Dashboard_Configuration
 * @author   Rodney St.Cloud <hoyrod1@aol.com>
 * @license  STC Media inc
 * @link     https://cms/dashboard.php
 */
require_once "includes/session.php";
require_once "includes/db_conn.php";
require_once "includes/functions.php";
require_once "includes/date_time.php";

$_SESSION['trackingURL'] = $_SERVER['PHP_SELF'];
confirmLogin(); 
?> 

<!------------BEGGINING  HTML-NAV SECTION ------------>
<?php 
$title = "Dashboard Page";
require_once "includes/nav_links.php"; 
?>
<!-------------ENDING HTML-NAV SECTION---------------->

<hr>
  <!-- HEADER BEGINS-->
  <header class="bg-dark text-white py-3">
    <div class="container">
      <div class="row">
        <div class="col-md-12 mb-2">    
          <h1>
              <i class="fas fa-cog" style="color: #3F628A;">
                  Welcome to the Dashboard page
              </i>
          </h1>
        </div>
        <div class="col-lg-3 mb-2">
            <a href="create_add_post.php" class="btn btn-primary btn-block">
                <i class="fas fa-edit">Add New Post</i>
            </a>
        </div>
        <div class="col-lg-3 mb-2">
            <a href="categories.php" class="btn btn-info btn-block">
                <i class="fas fa-folder-plus">Add New Category</i>
            </a>
        </div>
        <div class="col-lg-3 mb-2">
            <a href="admin.php" class="btn btn-warning btn-block">
                <i class="fas fa-user-plus">Add New Admin</i>
            </a>
        </div>
        <div class="col-lg-3 mb-2">
            <a href="comments.php" class="btn btn-success btn-block">
                <i class="fas fa-check">Approve Comment</i>
            </a>
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
  <hr>
  <!-- MAIN BODY SECTION BEGINS-->
  <section class="container py-2 mb-4">
    <div class="row">
      <!--------------------LEFT SIDE BEGINS-------------------->
      <div class="col-lg-2 d-none d-md-block">
         <!----TOP LEFT SIDE START --->
         <div class="card text-center bg-dark text-white mb-3">
           <div class="card-body">
             <h1 class="lead">Post</h1>
             <h4 class="display-5">
               <i class="fab fa-readme"></i>
               <?php 
                 dashboardCount('post');
                ?>
             </h4>
           </div>
         </div>
        <!----TOP MIDDLE LEFT SIDE START --->
        <div class="card text-center bg-dark text-white mb-3">
          <div class="card-body">
            <h1 class="lead">Categories</h1>
            <h4 class="display-5">
              <i class="fas fa-folder"></i>
              <?php 
                dashboardCount('category');
                ?>
           </h4>
         </div>
       </div>
       <!----TOP MIDDLE LEFT SIDE ENDS --->
       <!----BOTTOM MIDDLE LEFT SIDE START --->
      <div class="card text-center bg-dark text-white mb-3">
        <div class="card-body">
          <h1 class="lead">Admins</h1>
          <h4 class="display-5">
            <i class="fas fa-users"></i>
            <?php 
              dashboardCount('admin');
            ?>
          </h4>
       </div>
     </div>
      <!----BOTTOM MIDDLE LEFT SIDE ENDS --->
      <!------------------------BOTTOM LEFT SIDE START--------------------------->
      <div class="card text-center bg-dark text-white mb-3">
        <div class="card-body">
          <h1 class="lead">Cooments</h1>
            <h4 class="display-5">
            <i class="fas fa-comments"></i>
            <?php  
                dashboardCount('comments');
            ?>
            </h4>
        </div>
     </div>
    <!---------------------------BOTTOM LEFT SIDE ENDS--------------------------->
    </div>
    <!-------------------------------LEFT SIDE ENDS------------------------------->

    <!-------------------------RIGHT SIDE BEGIINS------------------------->
    <div class="col-lg-10">
        <h1>Top Post</h1>
        <table class="table table-strip table-hover">
          <thead class="thead-dark">
            <tr>
              <th>No.</th>
              <th>Title</th>
              <th>Date & Time</th>
              <th>Author</th>
              <th>Comments</th>
              <th>Details</th>
            </tr>
         </thead>
        <?php 
            $conn  = new Database("localhost", "root", "root", "cms");
            $sql   = "SELECT * FROM post ORDER BY id LIMIT 0,5";
            $stmt  = $conn->conn()->query($sql);
            $count = 0;

        while ($post_rows = $stmt->fetch()) {
            $count++;
            $post_id            = $post_rows['id'];
            $post_title         = $post_rows['title'];
            $post_date_time     = $post_rows['reg_date'];
            $post_author        = $post_rows['author'];

            $dateTime = date('m/d/Y H:i:s', strtotime($post_date_time));

            if (strlen($post_title) > 9) { 
                $post_title = substr($post_title, 0, 8);
            };
            ?>
          <tbody>
            <tr>
                <td><?php echo $count; ?></td>
                <td><?php echo $post_title; ?></td>
                <td><?php echo $dateTime; ?></td>
                <td><?php echo $post_author; ?></td>
                <td style="font-size: 25px;padding: 5px;">
                    <span class="badge badge-success">
                        <?php approvedCommentCount('comments', $post_id); ?>
                    </span>
                    <span class="badge badge-danger">
                        <?php disapprovedCommentCount('comments', $post_id); ?>
                    </span>
                </td>
                <td>
                <a href="full_post.php?id=<?php echo $post_id; ?>">
                <span class="btn btn-info">Preview</span>
                </a>
                </td>
            </tr>
          </tbody>
        <?php } ?>
        </table>
      </div>
      <!--------------------RIGHT SIDE ENDS-------------------->
    </div>
  </section>
  <!-- MAIN BODY SECTION ENDS-->


<!----BEGINNING FOOTER AND BODY SECTION---->
<?php require_once "includes/footer.php"; ?>
<!-----ENDING FOOTER AND BODY SECTION------>