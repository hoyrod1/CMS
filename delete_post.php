<?php 
/**
 * * @file
 * php version 8.2
 * Delete Post Page for CMS
 * 
 * @category CMS
 * @package  Update_Post_Configuration
 * @author   Rodney St.Cloud <hoyrod1@aol.com>
 * @license  STC Media inc
 * @link     https://cms/delete_post.php
 */
require_once "includes/session.php";
require_once "includes/db_conn.php";
require_once "includes/functions.php";
require_once "includes/date_time.php";

confirmLogin();

$search_param = $_GET['id'];
if (isset($search_param)) {
    $connect_post = new Database("localhost", "root", "root", "cms");
    $select_post  = "SELECT * FROM post WHERE id = '$search_param'";
    $show_post    = $connect_post->conn()->query($select_post);

    while ($post_row = $show_post->fetch()) {
        $old_title       = $post_row['title'];
        $old_category    = $post_row['category'];
        $old_image       = $post_row['image'];
        $old_post        = $post_row['post'];
    }

}

if (isset($_POST['submit'])) {

        $connect    = new Database("localhost", "root", "root", "cms");
        $delete_sql = "DELETE FROM post WHERE id = $search_param";
        $execute    = $connect->conn()->query($delete_sql);

    if ($execute) {
        $remove_image = "uploads/$old_image";
        unlink($remove_image);
        $_SESSION['success_message'] = 'Your Post Has Been Deleted!!!';
        redirect("post.php");
    } else {
        $url = "www.delete_post.php?id=$search_param";
        $_SESSION['success_message'] = "Post Was Not Deleted!";
        redirect($url);
    }

}

?>

<!--  HTML-NAV SECTION -->
<?php 
$title = "Delete Post Page";
require_once "includes/nav_links.php"; 
?>
<!--  HTML-NAV SECTION -->

  <hr>
  <!-- HEADER BEGINS-->
  <header class="bg-dark text-white py-3">
    <div class="container">
      <div class="row">
        <div class="col-md-12 ">
          <h1><i class="fas fa-edit" style="color: #3F628A;"> Delete Post </i></h1>
        </div>
      </div>
    </div>
  </header>
  <!-- HEADER ENDS-->
  <hr>
  <!-- MAIN AREA BEGIN -->
  <section class="container py-2 mb-4">
    <div class="row">
      <div class="offset-lg-1 col-md-10 bg-light" style="min-height:500px;">
      <?php 
          echo errorMessage();
          echo successMessage();
        ?>
        <!--------------------------FORM STARTS HERE-------------------------->
        <form class="" action="delete_post.php?id=<?php echo $search_param; ?>" method="post" enctype="multipart/form-data">
          <div class="card bg-secondary">
            <div class="card-header">
              <h1 style="color: #3F628A;">Delete Post</h1>
            </div>
        <!-- INSERT NEW TITLE -->
        <div class="card-body bg-dark">
          <div class="form-group">
            <label for="title"><span class="label"> Existing Title: </span></label>
              <input class="form-control" id="title" type="text" name="edit_title" placeholder="Please Enter Title..." value="<?php echo $old_title; ?>" disabled>
          </div>
        <!-------------DISABLING CATEGORY FIELD AND SELECT IMAGE FEILD------------->
        <!----------------------------EXISTING CATEGORY---------------------------->
        <div class="form-group">
          <span class="label">
              Existing Category: 
              &nbsp;<?php echo $old_category; ?>
          </span>
        </div>
        <!----------------------------SELECT IMAGE INPUT---------------------------->
        <div class="form-group py-2">
          <div class="form-group">
            <span class="label">Existing Image:</span>
                &nbsp;<img src="<?php echo 'uploads/'.$old_image; ?>" width="100">
          </div>
        </div> 
        <!-------------DISABLING CATEGORY FIELD AND SELECT IMAGE FEILD-------------->
        <!-----------------POST DESCRIPTION OF TITLE AND CATEGORY------------------->
        <div class="form-group bg-dark px-4 py-2">
            <label for="post"><span style="color: white;">Update Post Description:</span></label>
            <textarea name="edit_post" class="form-control" id="post" rows="8" cols="80" disabled>
                <?php echo $old_post; ?>
            </textarea>
        </div>
        <!---------------NAVIGATE BACK TO DASHBOARD AND SUBMIT BUTTON--------------->
        <div class="row py-3">
          <div class="col-lg-6 mb-2">
            <a href="dashboard.php" class="btn btn-warning btn-block">
                <i class="fas fa-arrow-left"></i> 
                    Back to Dashboard
            </a>
          </div>
        <div class="col-lg-6 mb-2">
          <button type="submit" name="submit" class="btn btn-danger btn-block" onclick="confirm('Are you sure you want to delete this record?');">
            <i class="fas fa-trash"></i> 
            Delete Post
          </button>
        </div>
              </div>
            </div>
          </div>
        </form>
      </div>
    </div>
  </section>
  <!-- MAIN AREA ENDS-->
  <hr>
<!----BEGINNING FOOTER AND BODY SECTION---->
<?php require_once "includes/footer.php"; ?>
<!-----ENDING FOOTER AND BODY SECTION------>