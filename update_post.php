<?php 
/**
 * * @file
 * php version 8.2
 * Update Post Page for CMS
 * 
 * @category CMS
 * @package  Update_Post_Configuration
 * @author   Rodney St.Cloud <hoyrod1@aol.com>
 * @license  STC Media inc
 * @link     https://cms/update_post.php
 */
require_once "includes/session.php";
require_once "includes/db_conn.php";
require_once "includes/functions.php";
require_once "includes/date_time.php";

confirmLogin();

$search_param = $_GET['id'];
if (isset($_POST['submit'])) {
    $edit_title           = testInput($_POST['edit_title']);
    $edit_categoryTitle   = testInput($_POST['edit_categoryTitle']);
    $edit_post            = testInput($_POST['edit_post']);
    $admin                = $_SESSION["admin_name"];
    // CODE TO UPLOAD IMAGE TO FILE AND IMAGE NAME TO DATA BASE //
    $target_dir      = "uploads/";
    $image           = $_FILES['edit_image']['name'];
    $target_file     = $target_dir.basename($image);
    $image_file_type = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
    
    if (empty($edit_title)) {
        $_SESSION['error_message'] = "Please fill out the form";
        redirect("www.edit_post.php?id=<?php echo $search_param; ?>");
    } elseif (strlen($edit_title) < 3) {
        $_SESSION['error_message'] = "Category Title should be more than 2 letters! ";
        redirect("www.edit_post.php?id=<?php echo $search_param; ?>");
    } elseif (strlen($edit_title) > 100) {
        $_SESSION['error_message'] = "Title should be less than 100 letters! ";
        redirect("www.edit_post.php?id=<?php echo $search_param; ?>");
    } elseif (strlen($edit_post) > 9999) {
        $_SESSION['error_message'] = "Your Post should be less than 10000 letters! ";
        redirect("www.edit_post.php?id=<?php echo $search_param; ?>");
    } else {

        if (!empty($image)) {
            $connect  = new Database("localhost", "root", "root", "cms");
            $edit_sql = "UPDATE post SET title = '$edit_title', 
						                             category = '$edit_categoryTitle', 
																				 image = '$image', 
																				 post = '$edit_post' 
																				 WHERE id = $search_param";
            $execute  = $connect->conn()->query($edit_sql);
            move_uploaded_file($_FILES["edit_image"]["tmp_name"], $target_file);
        } else {

             $connect  = new Database("localhost", "root", "root", "cms");
             $edit_sql = "UPDATE post SET title = '$edit_title', 
						                              category = '$edit_categoryTitle', 
																					post = '$edit_post' 
																					WHERE id = $search_param";
             $execute  = $connect->conn()->query($edit_sql);

        }

        if ($execute) {

            $_SESSION['success_message'] = 'Your Post Has Been Updated!!!';
            redirect("post.php");

        } else {

            $_SESSION['error_message'] = "Post Was Not Added!";
            redirect("www.edit_post.php?id=<?php echo $search_param; ?>");

        }
    }
}

?>

<!--  HTML-NAV SECTION -->
<?php 
$title = "Update Post Page";
require_once "includes/nav_links.php"; 
?>
<!--  HTML-NAV SECTION -->

  <hr>
  <!-- HEADER BEGINS-->
  <header class="bg-dark text-white py-3">
    <div class="container">
      <div class="row">
          <div class="col-md-12 ">
          <h1><i class="fas fa-edit" style="color: #3F628A;"> Update Post </i></h1>
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
        ?>
        <!-- FORM STARTS HERE-->
        <form class="" action="update_post.php?id=<?php echo $search_param; ?>" method="post" enctype="multipart/form-data">
          <div class="card bg-secondary">
            <div class="card-header">
                <h1 style="color: #3F628A;">Add New Post</h1>
            </div>
        <!-- INSERT NEW TITLE -->
        <div class="card-body bg-dark">
          <div class="form-group">
            <label for="title"><span class="label"> Update Title: </span></label>
            <input class="form-control" id="title" type="text" name="edit_title" placeholder="Please Enter Title..." value="<?php echo $old_title; ?>">
          </div>
        <!-- SELECT NEW CATEGORY -->
        <div class="form-group"><span class="label">Existing Category: <?php echo $old_category; ?></span></div>
          <label for="categoryTitle">
            <span class="label"> Update Category: </span>
          </label>
          <select class="form-control" id="categoryTitle" name="edit_categoryTitle">
              <option value="">Select...</option>
              <?php 
                  $connect = new Database("localhost", "root", "root", "cms");
                  $sql     = "SELECT * FROM category";
                  $stmt    = $connect->conn()->query($sql);
                while ($data_row = $stmt->fetch()) {

                      $id       = $data_row['id'];
                      $category = $data_row['title'];
                    ?>
              <option><?php echo $category;?></option>
                <?php } ?>
          </select>
        <!-- SELECT IMAGE INPUT-->
        <div class="form-group py-2">
          <div class="form-group">
            <span class="label">Existing Image: </span>
              <img src="<?php echo 'uploads/'.$old_image; ?>" width="100">
          </div>
          <label for="image"><span style="color: white;">Update Image:</span></label>
          <div class="custom-file">
            <input class="custom-file-input" type="file" name="edit_image" id="image" value="">
            <label class="custom-file-label" for="image"> Select Image... </label>
          </div>
        </div>
      </div>
      <!-- POST DESCRIPTION OF TITLE AND CATEGORY -->
      <div class="form-group bg-dark px-4 py-2">
          <label for="post">
              <span style="color: white;">Update Post Description:</span></label>
              <textarea name="edit_post" class="form-control" id="post" rows="8" cols="80"><?php echo $old_post; ?></textarea>
      </div>
      <!-- NAVIGATE BACK TO DASHBOARD AND SUBMIT BUTTON -->
      <div class="row py-3" style="margin: 0 5px 0 5px;">
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
      </div>
    </div>
  </section>

  <!-- MAIN AREA ENDS-->
  <hr>

<!----BEGINNING FOOTER AND BODY SECTION---->
<?php require_once "includes/footer.php"; ?>
<!-----ENDING FOOTER AND BODY SECTION------>