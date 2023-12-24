<?php
/**
 * * @file
 * php version 8.2
 * Create Post Page for CMS
 * 
 * @category CMS
 * @package  Create_Add_Configuration_Page
 * @author   Rodney St.Cloud <hoyrod1@aol.com>
 * @license  STC Media inc
 * @link     https://cms/create_add_post.php
 */
require_once "includes/session.php";
require_once "includes/db_conn.php";
require_once "includes/functions.php";
require_once "includes/date_time.php";

$_SESSION['trackingURL'] = $_SERVER['PHP_SELF'];

confirmLogin();

if (isset($_POST['submit'])) {
    $newPost         = testInput($_POST['newpost']);
    $categoryTitle   = testInput($_POST['categoryTitle']);
    $postdesciption  = testInput($_POST['postdesciption']);
    $admin           = $_SESSION['admin_name'];
    // CODE TO UPLOAD IMAGE TO FILE AND IMAGE NAME TO DATA BASE //
    $target_dir      = "uploads/";
    $image           = $_FILES['image']['name'];
    $target_file     = $target_dir.basename($image);
    $image_file_type = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

    if (empty($newPost)) {
        $_SESSION['error_message'] = "Please fill out the form";
        redirect("create_add_post.php");
    } elseif (strlen($newPost) < 3) {
        $_SESSION['error_message'] = "Category Title should be more than 2 characters! ";
        redirect("create_add_post.php");
    } elseif (strlen($newPost) > 100) {
        $_SESSION['error_message'] = "Title should be less than 100 characters! ";
        redirect("create_add_post.php");
    } elseif (strlen($postdesciption) > 9999) {
        $_SESSION['error_message'] = "Your Post should be less than 10000 characters! ";
        redirect("create_add_post.php");
    } else {

        $connect = new Database("localhost", "root", "root", "cms");

        $sql      = "INSERT INTO post( title, category, author, image, post) 
        VALUES(:New_Title, 
        :New_Category, 
        :New_Author, 
        :New_Image, 
        :New_Post)";
        $pre_stmt = $connect->conn()->prepare($sql);
        $pre_stmt->bindValue(':New_Title', $newPost);
        $pre_stmt->bindValue(':New_Category', $categoryTitle);
        $pre_stmt->bindValue(':New_Author', $admin);
        $pre_stmt->bindValue(':New_Image', $image);
        $pre_stmt->bindValue(':New_Post', $postdesciption);
        $execute = $pre_stmt->execute();
        move_uploaded_file($_FILES["image"]["tmp_name"], $target_file);

        if ($execute) {

            $_SESSION['success_message'] = 'Posted Title With ID: ' .$connect->conn()->lastInsertId(). ' Was Added.';
            redirect("post.php");

        } else {

            $_SESSION['success_message'] = "Post Was Not Added!";
            redirect("create_add_post.php");

        }
    }
}

?>

<!--  HTML-NAV SECTION -->
<?php 
$title = "Create Post Page";
require_once "includes/nav_links.php"; 
?>
<!--  HTML-NAV SECTION -->
  <hr>
  <!-- HEADER BEGINS-->
  <header class="bg-dark text-white py-3">
    <div class="container">
      <div class="row">
        <div class="col-md-12 ">
          <h1>
            <i class="fas fa-edit" style="color: #3F628A;">
              Create A New Post 
            </i>
          </h1>
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
    <!-- FORM STARTS HERE-->
    <form class="" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" enctype="multipart/form-data">
      <div class="card bg-secondary">
        <div class="card-header">
          <h1 style="color: #3F628A;">Add New Post</h1>
      </div>
      <!-- INSERT NEW TITLE -->
     <div class="card-body bg-dark">
       <div class="form-group">
         <label for="title"><span class="label"> Enter New Title: </span></label>
         <input class="form-control" id="title" type="text" name="newpost" placeholder="Type title here...">
       </div>
      <!-- SELECT NEW CATEGORY -->
      <label for="categoryTitle"><span class="label"> Choose Category: </span></label>
        <select class="form-control" id="categoryTitle" name="categoryTitle">
          <option value="">Select...</option>
          <?php 
              $connect = new Database("localhost", "root", "root", "cms");
              $sql     = "SELECT * FROM category";
              $stmt    = $connect->conn()->query($sql);
            while ($data_row = $stmt->fetch()) {
                  $id           = $data_row['id'];
                  $category     = $data_row['title'];

                ?>
          <option><?php echo $category;?></option>
            <?php }; ?>
        </select>
      <!-- SELECT IMAGE INPUT-->
      <div class="form-group py-2">
        <label for="image"><span style="color: white;">Select Image:</span></label>
          <div class="custom-file">
            <input class="custom-file-input" type="file" name="image" id="image" value="">
            <label class="custom-file-label" for="image"> Select Image... </label>
          </div>
      </div>
      <!-- POST DESCRIPTION OF TITLE AND CATEGORY -->
      <div class="form-group bg-dark px-4 py-2">
        <label for="post">
          <span style="color: white;">Post Description:</span>
        </label>
        <textarea name="postdesciption" class="form-control" id="post" rows="8" cols="80"></textarea>
      </div>
      <!-- NAVIGATE BACK TO DASHBOARD AND SUBMIT BUTTON -->
      <div class="row py-3" style="margin: 0 5px 0 5px;">
        <div class="col-lg-6 mb-2">
          <a href="dashboard.php" class="btn btn-warning btn-block">
            <i class="fas fa-arrow-left"></i> Back to Dashboard</a>
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