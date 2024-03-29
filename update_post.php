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

$admin_id = $_GET['id'];

if (isset($_POST['submit'])) {
  
    //------- SET $adminName TO SESSION OR COOKIE ADMIN NAME -------//
    $admin = "";
    if (isset($_SESSION["admin_name"])) {
        $admin = $_SESSION["admin_name"];
    } elseif (isset($_COOKIE["admin_name"])) {
        $admin = $_COOKIE["admin_name"];
    }
    //--------------------------------------------------------------//
    $edit_title           = testInput($_POST['edit_title']);
    $edit_categoryTitle   = testInput($_POST['edit_categoryTitle']);
    $edit_post            = testInput($_POST['edit_post']);
    
    // CODE TO UPLOAD IMAGE TO FILE AND IMAGE NAME TO DATA BASE //
    $target_dir      = "images/";
    $image           = $_FILES['edit_image']['name'];
    $target_file     = $target_dir.basename($image);
    $image_file_type = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
    
    if (empty($edit_title)) {
        $_SESSION['error_message'] = "Please fill out the form";
        redirect("www.edit_post.php?id=<?php echo $admin_id; ?>");
    } elseif (strlen($edit_title) < 3) {
        $_SESSION['error_message'] = "Category Title has to be more than 2 letters";
        redirect("www.edit_post.php?id=<?php echo $admin_id; ?>");
    } elseif (strlen($edit_title) > 100) {
        $_SESSION['error_message'] = "Title should be less than 100 letters";
        redirect("www.edit_post.php?id=<?php echo $admin_id; ?>");
    } elseif (strlen($edit_post) > 9999) {
        $_SESSION['error_message'] = "Your Post should be less than 10000 letters";
        redirect("www.edit_post.php?id=<?php echo $admin_id; ?>");
    } else {

        if (!empty($image)) {
            // ----------------------------------------------------------------- //
            // The $validateImage FUNCTION VALIDATES THE IMAGE FROM THE FORM //
            // The $validateImage FUNCTION RETURNS FALSE OR THE IMAGE FILE PATH //
            $validatdImage = imageValidation($newImage); 
            // ----------------------------------------------------------------- //
            $connect  = new Database("localhost", "root", "root", "cms");
            $edit_sql = "UPDATE post SET title = :edit_title, 
						                             category = :edit_categoryTitle, 
																				 image = :image, 
																				 post = :edit_post 
																				 WHERE id = :admin_id";
             $pre_stmt = $connect->conn()->prepare($edit_sql);
             $pre_stmt->bindValue(':edit_title', $edit_title);
             $pre_stmt->bindValue(':edit_categoryTitle', $edit_categoryTitle);
             $pre_stmt->bindValue(':image', $image);
             $pre_stmt->bindValue(':edit_post', $edit_post);
             $pre_stmt->bindValue(':admin_id', $admin_id);
             $execute  = $pre_stmt->execute();

            if ($execute) {

                move_uploaded_file($_FILES["edit_image"]["tmp_name"], $validatdImage);
    
                $_SESSION['success_message'] = 'Your Post Has Been Updated!!!';
                redirect("post.php");
    
            } else {
    
                $_SESSION['error_message'] = "Post Was Not updated!";
                redirect("www.edit_post.php?id=<?php echo $admin_id; ?>");
    
            }

        } else {

             $connect  = new Database("localhost", "root", "root", "cms");
             $edit_sql = "UPDATE post SET title = :edit_title, 
						                              category = :edit_categoryTitle, 
																					post = :edit_post 
																					WHERE id = :admin_id";
             $pre_stmt = $connect->conn()->prepare($edit_sql);
             $pre_stmt->bindValue(':edit_title', $edit_title);
             $pre_stmt->bindValue(':edit_categoryTitle', $edit_categoryTitle);
             $pre_stmt->bindValue(':edit_post', $edit_post);
             $pre_stmt->bindValue(':admin_id', $admin_id);
             $execute  = $pre_stmt->execute();

            if ($execute) {
    
                $_SESSION['success_message'] = 'Your Post Has Been Updated!!!';
                redirect("post.php");
    
            } else {
    
                $_SESSION['error_message'] = "Post Was Not updated!";
                redirect("www.edit_post.php?id=<?php echo $admin_id; ?>");
    
            }

        }
    }
}
?>
<!------------- BEGGINING JAVASCRIPT SECTION ------------->
<script>
    function confirmUpdate()
    {
        return confirm('Are you sure you want to update your record?');
    }
</script>
<!------------- ENDING JAVASCRIPT SECTION ---------------->

<!--  HTML-NAV SECTION -->
<?php 
$title = "Update Post Page";
require_once "includes/links/loggedin_nav_links.php"; 
?>
<!--  HTML-NAV SECTION -->

  <hr>
  <!-- HEADER BEGINS-->
  <header class="bg-light text-white py-3">
    <div class="container">
      <div class="row">
          <div class="col-md-12 ">
          <h1 style="text-align: center;"><i class="fas fa-edit" style="color: #3F628A;"> Update Post </i></h1>
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

        if (isset($admin_id)) {
                $connect_post = new Database("localhost", "root", "root", "cms");
                $select_post  = "SELECT * FROM post WHERE id = '$admin_id'";
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
        <form class="" action="update_post.php?id=<?php echo $admin_id; ?>" method="post" enctype="multipart/form-data">
          <div class="card bg-secondary">
            <div class="card-header">
                <h1 style="color: #3F628A;">Update Post</h1>
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
              <img src="<?php echo 'images/'.$old_image; ?>" width="100">
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
            <a href="post.php" class="btn btn-warning btn-block">
              <i class="fas fa-arrow-left">
                Back to Post page
              </i>
            </a>
        </div>
        <div class="col-lg-6 mb-2">
            <button type="submit" name="submit" class="btn btn-success btn-block" onclick=" return confirmUpdate() ;">
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