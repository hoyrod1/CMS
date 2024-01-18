<?php
/**
 * * @file
 * php version 8.2
 * Categories Page for CMS
 * 
 * @category CMS
 * @package  Categories_Configuration
 * @author   Rodney St.Cloud <hoyrod1@aol.com>
 * @license  STC Media inc
 * @link     https://cms/categories.php
 */
require_once "includes/session.php";
require_once "includes/db_conn.php";
require_once "includes/functions.php";
require_once "includes/date_time.php";

$_SESSION['trackingURL'] = $_SERVER['PHP_SELF'];
confirmLogin();

if (isset($_POST['submit'])) {
  
    //------- SET $adminName TO SESSION OR COOKIE ADMIN NAME -------//
    $admin = "";
    if (isset($_SESSION["admin_name"])) {
        $admin = $_SESSION["admin_name"];
    } elseif (isset($_COOKIE["admin_name"])) {
        $admin = $_COOKIE["admin_name"];
    }
    //--------------------------------------------------------------//
    $categoryTitle = testInput($_POST['newtitle']);

    if (empty($categoryTitle)) {
        $_SESSION['error_message'] = "Please enter a category";
        redirect("categories.php");
    } elseif (strlen($categoryTitle) < 3) {
        $_SESSION['error_message'] = "Category Title has to be more than 2 letters ";
        redirect("categories.php");
    } elseif (strlen($categoryTitle) > 100) {
        $_SESSION['error_message'] = "Category Title has to be less than 100 letters ";
        redirect("categories.php");
    } else {

        $connect  = new Database("localhost", "root", "root", "cms");
        $sql      = "INSERT INTO category(title, author) 
				             VALUES(:categoryTitle, :adminAuthor)";
        $pre_stmt = $connect->conn()->prepare($sql);
        $pre_stmt->bindValue(':categoryTitle', $categoryTitle, PDO::PARAM_STR);
        $pre_stmt->bindValue(':adminAuthor', $admin, PDO::PARAM_STR);

        $lastInsertedId = $connect->conn()->lastInsertId();
        $execute = $pre_stmt->execute();

        if ($execute) {

            $_SESSION['success_message'] = 'Category Title ID: ' . $lastInsertedId . ' was Sent.';
            redirect("categories.php");

        } else {

            $_SESSION['success_message'] = "Record has not been submitted!";
            redirect("categories.php");

        }
    }
}
//----------- BEGGINING HTML-NAV SECTION -----------//
$title = "Category Page";
require_once "includes/links/loggedin_nav_links.php"; 
//------------ ENDING HTML-NAV SECTION ------------//

?>
<!------------- BEGGINING JAVASCRIPT SECTION ------------->
<script>
    function confirmDeleteCategory()
    {
        return confirm('Are you sure you want to delete this record?');
    }
    function confirmAddCategory()
    {
        return confirm('Press "OK" to add your category');
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
                Manage catergories 
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
         <!----------------BEGINNING OF FORM----------------------->
         <form class="" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" enctype="multipart/form-data">
          <div class="card bg-secondary">
            <div class="card-header">
                <h1 style="color: #3F628A;">Add New Category</h1>
            </div>
            <div class="card-body bg-dark">
                <div class="form-group">
                    <label for="title">
                            <span class="label"> 
                                Category Title:
                            </span>
                    </label>
                  <input class="form-control" id="title" type="text" name="newtitle" placeholder="Type title here..." required>
              </div>
                    <span class="text-danger" style="font-size: 15px;">
                        Please do not type in more than 100 characters
                    </span>
              <div class="row py-3">
                  <div class="col-lg-6 mb-2">
                      <a href="dashboard.php" class="btn btn-warning btn-block">
                          <i class="fas fa-arrow-left"></i> Back to Dashboard
                      </a>
                  </div>
                   <div class="col-lg-6 mb-2">
                      <button type="submit" name="submit" class="btn btn-success btn-block" onclick="return confirmAddCategory() ;">
                          <i class="fas fa-check"></i> Submit
                      </button>
                   </div>
              </div>
            </div>
          </div>
        </form>
        <!-----------------END OF FORM------------------------------>

       <h2>Existing Categories</h2>
       <!----------BEGINNING OF TABLE HEADING------->
       <table class="table table-striped table-hover">
           <thead class="thead-dark">
               <tr>
                   <th>No.</th>
                   <th>Category Name</th>
                   <th>Date & Time</th>
                   <th>Creator Name</th>
                   <th>Action</th>
               </tr>
           </thead>
         <!---------ENDING OF TABLE HEADING------------>

        <!----------BEGINNING OF CATEGORIY TABLE DATA------->
        <?php  
            $conn     = new Database("localhost", "root", "root", "cms");
            $sql      = "SELECT * FROM category ORDER BY id DESC";
            $execute  = $conn->conn()->query($sql);
            //$sql_results =
            $count    = 1; 
        while ($comment_rows = $execute->fetch()) {

            $category_count           = $count++;
            $catgory_id               = $comment_rows['id'];
            $date_time                = $comment_rows['date_time'];
            $category_title           = $comment_rows['title'];
            $creator_name             = $comment_rows['author'];
            ?>
          <thead>
              <tr>
                  <td><?php echo $category_count; ?></td>
                  <td><?php echo $category_title; ?></td>
                  <td>
                      <?php 
                            $dateTime = date('m/d/Y g:i a', strtotime($date_time));
                            echo $dateTime; 
                        ?>
                  </td>
                  <td><?php echo htmlentities($creator_name); ?></td>
                    <td>
                      <a href="delete_category.php?id=<?php echo $catgory_id; ?>" class="btn btn-danger" onclick="return confirmDeleteCategory() ;">
                        Delete
                      </a>
                    </td>
                  </td>
              </tr>
          </thead>
            <?php 
        }; 
        ?>
        </table>
        <!----------ENDING OF CATEGORIY TABLE DATA------->
      </div>
    </div>
  </section>
<!-- MAIN AREA ENDS-->
<hr>

<!----BEGINNING FOOTER AND BODY SECTION---->
<?php require_once "includes/footer.php"; ?>
<!-----ENDING FOOTER AND BODY SECTION------>