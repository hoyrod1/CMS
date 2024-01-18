<?php
/**
 * * @file
 * php version 8.2
 * Category Posting Page for CMS
 * 
 * @category CMS
 * @package  Category_Posting_Configuration_Page
 * @author   Rodney St.Cloud <hoyrod1@aol.com>
 * @license  STC Media inc
 * @link     https://cms/category.php
 */
require_once "includes/session.php";
require_once "includes/db_conn.php";
require_once "includes/functions.php";
require_once "includes/date_time.php";

// $full_post_id = $_GET['id'];
$cat_title = testInput($_GET["category"]);

if (isset($_POST["email_button"])) {

    if (!empty($_POST["email"])) {

        $email = filter_var($_POST["email"], FILTER_SANITIZE_EMAIL);

        if ($email) {

            $connect      = new Database("localhost", "root", "root", "cms");
            $sql          = "INSERT INTO blog_email(email) VALUE(:email)";
            $prepare_stmt = $connect->conn()->prepare($sql);
            $prepare_stmt->bindValue(':email', $email, PDO::PARAM_STR);
            $execute      = $prepare_stmt->execute();
            if ($execute) {
                $connect = null;
                $_SESSION["success_message"] = 'You email has been saved';
                
            } else {
                $_SESSION["error_message"] = 'Your email has not been submitted';
                
            }
        } else {
            $_SESSION["error_message"] = 'Please enter valid email';
            
        }
    } else {
        $_SESSION["error_message"] = 'Please fill out email field';
        
    }
}

//-------------------------- HTML-NAV SECTION --------------------------//
$title = "Category Page";
require_once "includes/links/blog_nav_links.php"; 
//--------------------------  HTML-NAV SECTION --------------------------//

?>

<hr>
<!-- HEADER BEGINS-->
<header class="bg-light text-white py-3">
  <div class="container">
    <div class="row">
      <div class="col-md-12 ">
        <h1 style="text-align: center;">
          <i class="about_i fas fa-text-height text-info"> 
            STC Media CMS Category Page
          </i>
        </h1>
      </div>
    </div>
  </div>
</header>
<!-- HEADER ENDS-->

<hr>
<!-- CONTAINER BEGINS-->
<div class="container">
  <?php 
    echo errorMessage();
    echo successMessage();
    //----------------- BEGGINING OF FULL CATEGORY QUERY -----------------//
    
    $connect   = new Database("localhost", "root", "root", "cms");

    if (isset($_GET["search_button"])) {
        $search_field    = testInput($_GET["search"]);
        $sql_search      = "SELECT * FROM post 
                            WHERE title LIKE :Search OR 
                                category LIKE :Search OR 
                                author LIKE :Search OR 
                                post LIKE :Search";
        $stmt_post = $connect->conn()->prepare($sql_search);
        $stmt_post->bindValue(':Search', '%'.$search_field.'%');
        $stmt_post->execute();
    } else {

        /* IF STATEMENT FOR FULL POST WITH INVALID URL ID VALUE */
        if (!isset($cat_title)) {
            $_SESSION['error_message'] = "Invalid URL!";
            redirect('blog_post.php?page=1');
        }
        
        $sql_cat          = "SELECT * FROM category WHERE title = :cat_title";
        $stmt_cat         = $connect->conn()->prepare($sql_cat);
        $stmt_cat->bindValue(':cat_title', $cat_title);
        $stmt_cat->execute();
        $rowcount_results = $stmt_cat->rowcount();
        
        if ($rowcount_results != 1) {
            $_SESSION['error_message'] = "Category Not Found!";
            redirect('blog_post.php?page=1');
        }
    }
    while ($cat_row = $stmt_cat->fetch()) {
        $cat_id        = $cat_row['id'];
        $title          = $cat_row['title'];
        $author         = $cat_row['author'];
        $cat_date_time = $cat_row['date_time'];

        $dateTime = date('m-d-Y g:i a', strtotime($cat_date_time));

        ?>
  <div class="row mt-4">
    <!-- MAIN AREA BEGINS-->
    <div class="col-sm-8 pt-4" style="min-height: 40px;background-color:#666699;">
      <h1 style="color: white;font-family: Times, Arial, serif; font-size: 35px;text-align:center;"> 
        Welcome to the <?php echo $title; ?> blog list
      </h1>
    <div class="card">
      <div class="card-body">
        <h5 class="card-title">
            Category of
            <a href="category.php?category=<?php echo urlencode(htmlspecialchars_decode($title)); ?>">
              <?php echo $title; ?>
            </a>
        </h5>
        <small class="text-muted">
          <span class="text-dark">  
            Written by <strong><?php echo htmlentities($author); ?></strong> on
              <?php echo htmlentities($dateTime); ?>
          </span>
        </small>
        <hr>      
      </div>
    </div>
    <br>
    <?php } ?>
  </div>
  <!-----------------MAIN AREA ENDS----------------->
  <!----------------SIDE AREA BEGINS---------------->
  <div class="col-sm-4">
    <div class="card mt-4">
      <div class="card-body" style="background-color:#666699;">
        <img src="images/sidearea pic.jpg" class="d-block img-fluid mb-3">
        <div class="text-center text-white">
          Lorem Ipsum is simply dummy text of the printing 
          and typesetting industry. Lorem Ipsum has been the 
          industry's standard dummy text ever since the 1500s, 
          when an unknown printer took a galley of type and 
          scrambled it to make a type specimen book. It has 
          survived not only five centuries, but also the leap 
          into electronic typesetting, remaining essentially unchanged. 
          It was popularised in the 1960s with the release of Letraset 
          sheets containing Lorem Ipsum passages, and more recently with 
          desktop publishing software like Aldus PageMaker including 
          versions of Lorem Ipsum.
        </div>
      </div>
    </div>
    <br>
        <?php 
        if (isset($_SESSION["user_id"])) {
            echo '
            <div class="card">
              <div class="card-header bg-info text-light">
                <h2 class="lead">
                  <center>
                    Hello  &nbsp;' . $_SESSION['admin_name'] . 
                '</center>
                </h2>
              </div>
              <div class="card-body" style="background-color:#666699;">
                <a href="dashboard.php" class="text-white">
                  <button type="button" class="btn btn-success btn-block text-center text-white mb-3" name="button">
                    Return to the dashboard
                  </button>
                </a>
                <a href="logout.php" class="text-white">
                  <button type="button" class="btn btn-danger btn-block text-center" name="log_button">
                    Logout
                  </button>
                </a>
              </div>
            </div> ';
        } else {
            echo '
            <div class="card">
              <div class="card-header bg-info text-light">
                <h2 class="lead"><center>Sign Up</center></h2>
              </div>
              <div class="card-body" style="background-color:#666699;">
                <a href="blog_post.php?page=1" class="text-white">
                  <button type="button" class="btn btn-success btn-block text-center text-white mb-3" name="button">
                    Return to the blog
                  </button>
                </a>
                <a href="login.php" class="text-white">
                  <button type="button" class="btn btn-danger btn-block text-center" name="button">
                    Login
                  </button>
                </a>
                <div class="input-group mt-3 mb-3">
                  <form class="" action="full_post.php?id=<?php echo $full_post_id; ?>" method="post">
                    <div class="input-group-append">
                      <input type="text" name="email" class="form-control mr-2" placeholder="Enter Your Email" required>
                      <button type="submit" name="email_button" class="btn btn-primary btn-small text-center text-white">
                        Submit
                      </button>
                    </div>
                  </form>
                </div>
              </div>
            </div> ';
        }
        ?>
  <br>
  <div class="card">
    <div class="card-header bg-info text-white">
      <h2 class="text-center">Category's</h2>
    </div>
    <div class="card-body text-center" style="background-color:#666699;">
    <?php 
      $connect_c    = new Database("localhost", "root", "root", "cms");
      $sql_cat      = "SELECT * FROM category ORDER BY id";
      $sql_stmt     = $connect_c->conn()->query($sql_cat);

    while ($cat_row = $sql_stmt->fetch()) {
        $cat_id   = $cat_row['id'];
        $cat_name = $cat_row['title'];
        $cat_title = urlencode(htmlspecialchars_decode($cat_name));
        ?>
        <a href="category.php?category=<?php echo $cat_title; ?>">
          <span class="heading text-white">
          <?php echo $cat_name; ?>
          </span>
        </a>
        <br>
    <?php } ?>
    </div>
  </div>
  <br>
  <div class="card">
    <div class="card-header bg-info text-white">
      <h2 class="lead">Recent Post</h2>
    </div>
    <div class="card-body" style="background-color:#666699;">
      <?php  
        $rec_connect  = new Database("localhost", "root", "root", "cms");
        $rec_sql      = "SELECT * FROM post ORDER BY id";
        $rec_stmt     = $connect->conn()->query($rec_sql);
        while ($rec_post = $rec_stmt->fetch()) {
            $recent_id       = $rec_post['id'];
            $recent_title    = $rec_post['title'];
            $recent_datetime = $rec_post['reg_date'];
            $recent_image    = $rec_post['image'];
            ?>
        <div class="media mb-3" style="box-shadow:1px 1px 20px 1px rgba(0, 0, 0, 0.5);background-color:#17a2b8;">
          <img src="<?php echo 'images/'.htmlentities($recent_image); ?>" width="70px" heigth="74" class="d-block img-fluid align-self-start">
          <div class="media-body ml-2">
            <a href="full_post.php?id=<?php echo htmlentities($recent_id); ?>">
              <h6 class="lead text-white">
                Post: <?php echo htmlentities($recent_id); ?>
              </h6>
            </a>
            <p class="small">
              <?php
                $dateTime = date('m/d/Y g:i a', strtotime($recent_datetime));
                echo htmlentities($dateTime); 
                ?>
            </p>
        </div>
    </div>
    <hr>
        <?php } ?>
  </div>
</div>
</div>
<!----------------------------SIDE AREA ENDS---------------------------->
</div>
</div>
<!---------------------------- CONTAINER ENDS ---------------------------->
<hr>
<!---------------------BEGINNING FOOTER AND BODY SECTION------------------>
<?php require_once "includes/footer.php"; ?>
<!-----------------------ENDING FOOTER AND BODY SECTION------------------->