<?php
/**
 * * @file
 * php version 8.2
 * Posting Page for CMS
 * 
 * @category CMS
 * @package  Posting_Configuration_Page
 * @author   Rodney St.Cloud <hoyrod1@aol.com>
 * @license  STC Media inc
 * @link     https://cms/post.php
 */

require_once "includes/db_conn.php";
require_once "includes/functions.php";
require_once "includes/session.php";
require_once "includes/date_time.php";

$_SESSION['trackingURL'] = $_SERVER['PHP_SELF'];
confirmLogin(); 
?>

<!----------------------  HTML-NAV SECTION ---------------------->
<?php 
$title = "Post Page";
require_once "includes/loggedin_nav_links.php"; 
?>
<!----------------------  HTML-NAV SECTION ----------------------->


  <hr>
  <!-- HEADER BEGINS-->
  <header class="bg-dark text-white py-3">
    <div class="container">
      <div class="row">  
        <div class="col-md-12 mb-2">
          <h1>
            <i class="fas fa-blog" style="color: #3F628A;"> 
              Welcome to the Blog Post page
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
  <!-- MAIN BODY BEGINS-->
  <section class="container py-2 mb-2">
    <div class="row">
      <div class="col-lg-12">
        <table class="table table-striped table-hover">
          <thead class="thead-dark">
            <tr >
                <th>ID #</th>
                <th>Title</th>
                <th>Category</th>
                <th>Date & Time</th>
                <th>Author</th>
                <th>Banner Photo</th>
                <th>Comments</th>
                <th>Action</th>
                <th>Live Preview</th>
            </tr>
          </thead>
  <?php 

    //CONNECT TO THE DATABASE FOR QUERY
    $connect = new Database("localhost", "root", "root", "cms");

    $sql      = "SELECT * FROM  post";
    $sql_stmt = $connect->conn()->query($sql);
    $counter    = 0;
    //FETCH ALL THE DATA FROM THE POST TABLE AND STORE IN VARIABLE
    while ($data_rom = $sql_stmt->fetch()) {

        $id         = $data_rom['id'];
        $title      = $data_rom['title'];
        $category   = $data_rom['category'];
        $date_Time  = $data_rom['reg_date'];
        $author     = $data_rom['author'];
        $image      = $data_rom['image'];
        $post       = $data_rom['post'];
        $counter++;

        ?>
  <!--DISPLAY ALL THE DATA FTECHED FROM THE POST TABLE-->
  <tbody>
    <tr>
      <td><?php echo $counter; ?></td>
      <td>
        <?php if (strlen($title)>9) { 
            $title = substr($title, 0, 8).'..';  
        } echo $title; 
        ?>
      </td>
      <td>
        <?php if (strlen($category)>9) { 
            $category = substr($category, 0, 8).'..'; 
        } echo $category; 
        ?>
      </td>
      <td>
        <?php if (strlen($date_Time)>9) { 
            $date_Time = substr($date_Time, 0, 8).'..'; 
        }  echo $date_Time;
        ?>
      </td>
        <td><?php echo $author ?></td>
        <td><img src="<?php echo 'uploads/'.$image; ?>" width="50"></td>
        <td style="font-size: 25px;padding: 5px;">
        <span class="badge badge-success">
          <?php approvedCommentCount('comments', $id);?>
        </span>
        <span class="badge badge-danger">
          <?php disapprovedCommentCount('comments', $id);?>
        </span>
      </td>
        <td>
            <a href="update_post.php?id=<?php echo $id; ?>">
              <span class="btn btn-warning">Edit</span>
            </a>
            <a href="delete_post.php?id=<?php echo $id; ?>">
              <span class="btn btn-danger">Delete</span>
            </a>
        </td>
        <td>
          <a href="full_post.php?id=<?php echo $id; ?>">
            <span class="btn btn-primary">Live Preview</span>
          </a>
        </td>
      </tr>
    </tbody>
    <?php } ?>
        </table>
      </div>
    </div>
  </section>

<!----------------------BEGINNING FOOTER AND BODY SECTION---------------------->
<?php require_once "includes/footer.php"; ?>
<!------------------------ENDING FOOTER AND BODY SECTION----------------------->