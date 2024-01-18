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
  
    //------- SET $adminName TO SESSION OR COOKIE ADMIN NAME -------//
    $adminName = "";
    if (isset($_SESSION["admin_name"])) {
        $adminName = $_SESSION["admin_name"];
    } elseif (isset($_COOKIE["admin_name"])) {
        $adminName = $_COOKIE["admin_name"];
    }
    //--------------------------------------------------------------//
    $newTitle       = testInput($_POST['newtitle']);
    $newCategory    = testInput($_POST['newCategory']);
    $postdesciption = testInput($_POST['postdesciption']);
    $newImage       = $_FILES['image']['name'];

    if (empty($newTitle) && empty($newCategory) && empty($newImage) && empty($postdesciption)) {
        $_SESSION['error_message'] = "Please enter title, category and description";
        redirect("create_add_post.php");
    } elseif (empty($newTitle) && empty($newCategory) && empty($newImage)) {
        $_SESSION['error_message'] = "Please enter a title, category and image";
        redirect("create_add_post.php");
    } elseif (empty($newTitle) && empty($newImage) && empty($postdesciption)) {
        $_SESSION['error_message'] = "Please enter a title  image and description";
        redirect("create_add_post.php");
    } elseif (empty($newCategory) && empty($newImage) && empty($postdesciption)) {
        $_SESSION['error_message'] = "Please enter category, image and description";
        redirect("create_add_post.php");
    } elseif (empty($newTitle) && empty($postdesciption)) {
        $_SESSION['error_message'] = "Please enter a title and the description";
        redirect("create_add_post.php");
    } elseif (empty($newTitle) && empty($newCategory)) {
        $_SESSION['error_message'] = "Please enter a title and the category";
        redirect("create_add_post.php");
    } elseif (empty($newTitle) && empty($newImage)) {
        $_SESSION['error_message'] = "Please enter a title and the image";
        redirect("create_add_post.php");
    } elseif (empty($newCategory) && empty($newImage)) {
        $_SESSION['error_message'] = "Please enter a category and the image";
        redirect("create_add_post.php");
    } elseif (empty($newCategory) && empty($postdesciption)) {
        $_SESSION['error_message'] = "Please enter a category and the description";
        redirect("create_add_post.php");
    } elseif (empty($newImage) && empty($postdesciption)) {
        $_SESSION['error_message'] = "Please enter a image and the description";
        redirect("create_add_post.php");
    } elseif (empty($newTitle)) {
        $_SESSION['error_message'] = "Please enter a title";
        redirect("create_add_post.php");
    } elseif (empty($newCategory)) {
        $_SESSION['error_message'] = "Please select a category";
        redirect("create_add_post.php");
    } elseif (empty($newImage)) {
        $_SESSION['error_message'] = "Please select a image";
        redirect("create_add_post.php");
    } elseif (empty($postdesciption)) {
        $_SESSION['error_message'] = "Please enter a description";
        redirect("create_add_post.php");
    } elseif (strlen($newTitle) < 3) {
        $_SESSION['error_message'] = "Your Title should be more than 2 characters ";
        redirect("create_add_post.php");
    } elseif (strlen($newTitle) > 100) {
        $_SESSION['error_message'] = "Title must be less than 100 characters";
        redirect("create_add_post.php");
    } elseif (strlen($postdesciption) < 30) {
        $_SESSION['error_message'] = "Your Post should be more than 30 characters";
        redirect("create_add_post.php");
    } elseif (strlen($postdesciption) > 9999) {
          $_SESSION['error_message'] = "Your Post must be less than 10000 characters";
          redirect("create_add_post.php");
    } else {
        // ----------------------------------------------------------------- //
        // The $validateImage FUNCTION VALIDATES THE IMAGE FROM THE FORM //
        // The $validateImage FUNCTION RETURNS FALSE OR THE IMAGE FILE PATH //
        $validatdImage = imageValidation($newImage); 
        // ----------------------------------------------------------------- //
        if ($validatdImage == false) {
            redirect("create_add_post.php");
        } else {
            // CODE TO UPLOAD IMAGE TO FILE AND IMAGE NAME TO DATA BASE //
    
            $connect = new Database("localhost", "root", "root", "cms");
    
            $sql      = "INSERT INTO post( title, category, author, image, post) 
            VALUES(:newTitle, 
            :newCategory, 
            :New_Author, 
            :New_Image, 
            :New_Post)";
            $pre_stmt = $connect->conn()->prepare($sql);
            $pre_stmt->bindValue(':newTitle', $newTitle);
            $pre_stmt->bindValue(':newCategory', $newCategory);
            $pre_stmt->bindValue(':New_Author', $adminName);
            $pre_stmt->bindValue(':New_Image', $newImage);
            $pre_stmt->bindValue(':New_Post', $postdesciption);
            $execute = $pre_stmt->execute();
    
            if ($execute) {
    
                $_SESSION['success_message'] = 'Post id: ' .$connect->conn()->lastInsertId(). ' was added.';
                $movImg = move_uploaded_file($_FILES["image"]["tmp_name"], $validatdImage);
                if (!$movImg) {
                    $_SESSION['error_message'] = "There's a error saving your image";
                    redirect("myprofile.php");
                }
                redirect("post.php");
    
            } else {
    
                $_SESSION['success_message'] = "Post Was Not Added!";
                redirect("create_add_post.php");
    
            }

        }

    }
}

//----------- BEGGINING HTML-NAV SECTION -----------//
$title = "Create Post Page";
require_once "includes/links/loggedin_nav_links.php";
//------------ ENDING HTML-NAV SECTION ------------//

?>
<!------------- BEGGINING JAVASCRIPT SECTION ------------->
<script>
    function confirmAddPost()
    {
        return confirm('Press "OK" to add your post');
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
          <label for="title"><span class="label"> Enter title: </span></label>
          <input class="form-control" id="title" type="text" name="newtitle" placeholder="Type title here..." required>
          <span class="text-danger" style="font-size: 15px;">
              Please do not enter more than 100 characters
          </span>
       </div>
      <!-- SELECT NEW CATEGORY -->
      <label for="categoryTitle"><span class="label"> Choose category: </span></label>
        <select class="form-control" id="categoryTitle" name="newCategory" required>
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
        <label for="image"><span style="color: white;">Select image:</span></label>
          <div class="custom-file">
            <input class="custom-file-input" type="file" name="image" id="image" value="" required>
            <label class="custom-file-label" for="image"> Select Image... </label>
          </div>
      </div>
      <!-- POST DESCRIPTION OF TITLE AND CATEGORY -->
      <div class="form-group bg-dark px-4 py-2">
        <label for="post">
          <span style="color: white;">Post description:</span>
        </label>
        <textarea name="postdesciption" class="form-control" id="post" rows="8" cols="80" required>
        </textarea>
      </div>
      <!-- NAVIGATE BACK TO DASHBOARD AND SUBMIT BUTTON -->
      <div class="row py-3" style="margin: 0 5px 0 5px;">
        <div class="col-lg-6 mb-2">
          <a href="dashboard.php" class="btn btn-warning btn-block">
            <i class="fas fa-arrow-left"></i> Back to Dashboard</a>
        </div>
      <div class="col-lg-6 mb-2">
        <button type="submit" name="submit" class="btn btn-success btn-block" onclick="return confirmAddPost() ;">
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