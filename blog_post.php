<?php
/**
 * * @file
 * php version 8.2
 * Blog Post Page for CMS
 * 
 * @category CMS
 * @package  Blog_Post_Page
 * @author   Rodney St.Cloud <hoyrod1@aol.com>
 * @license  STC Media inc
 * @link     https://cms/blog_post.php
 */
require_once "includes/session.php";
require_once "includes/db_conn.php";
require_once "includes/functions.php";
require_once "includes/date_time.php";

?>
<?php
if (isset($_POST["email_button"])) {
    
    if (!empty($_POST["email"])) {

        $email   = filter_var($_POST["email"], FILTER_SANITIZE_EMAIL);

        if ($email) {

            $connect = new Database("localhost", "root", "root", "cms");
            $sql     = "INSERT INTO blog_email (email)
						            VALUE (:email)";
            $prepare_stmt = $connect->conn()->prepare($sql);
            $prepare_stmt->bindValue(':email', $email);
            $execute      = $prepare_stmt->execute();
            if ($execute) {
                $connect = null;
                $_SESSION["success_message"] = 'You email has been saved';
                redirect('blog_post.php');
            } else {
                $_SESSION["error_message"] = 'Your email has not been submitted';
                redirect('blog_post.php');
            }
        } else {
            $_SESSION["error_message"] = 'Please enter valid email';
            redirect('blog_post.php');
        }
    } else {
        $_SESSION["error_message"] = 'Please fill out email field';
        redirect('blog_post.php');
    }
}
?>


<!-------------------------- HTML-NAV SECTION -------------------------->
<?php 
$title = "Blog Post Page";
require_once "includes/blog_nav_links.php"; 
?>
<!--------------------------  HTML-NAV SECTION -------------------------->


<!--------------------------  CONTAINER BEGINS -------------------------->
  <hr>
  <div class="container">
    <?php 
      echo errorMessage();
      echo successMessage();
    ?>
    <div class="row mt-4">
      <!-- MAIN AREA BEGINS-->
      <div class="col-sm-8" style="min-height: 40px;background-color:#666699;">
        <h1 style="color: white;font-family: Times, Arial, serif; font-size: 35px;"> 
          Welcome to Rodney St. Cloud's Blog
        </h1>
        <h1 class="lead" style="color: white;font-family: Times, Arial, serif;">
          The most polpular adult blogging platform on the internet!!!
        </h1>
        <?php 
        $connect   = new Database("localhost", "root", "root", "cms");
        //QUERY WHEN SEARCH PARAMETER IS SET//
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
        } elseif (isset($_GET['page'])) {
            //QUERY SET WHEN PAGE PARAMETER IS SET FOR PAGINATION//
            $page = $_GET['page'];

            if ($page < 1 || $page = 0) {
                $page_num = 0;

            } else {
                //  PAGINATION ERROR WAS $page_num = -4 FIXED WITH MATH OPERATION  //
                $page = $_GET['page'];
                $page_num = ($page * 4) - 4;
            }

                $sql        = "SELECT * FROM post ORDER BY id LIMIT $page_num, 4";
                $stmt_post  = $connect->conn()->query($sql);

        } elseif (isset($_GET['category'])) {

            // QUERY WHEN CATEGORY IS ACTIVE IN THE URL //
            $category  = $_GET['category'];
            $sql       = "SELECT * FROM post 
					                WHERE category = '$category' ORDER BY id";
            $stmt_post = $connect->conn()->query($sql);
            // QUERY DATABASE USING PREPARED STATEMENTS //
            /*
            $sql       = "SELECT * FROM post 
                          WHERE category = ':categoryName' ORDER BY id";
            $cat_stmt  = $connect->conn()->prepare($sql);
            $cat_stmt->bindValue(':categoryName', $category);
            $stmt_post = $cat_stmt->execute();
            */
        } else {
            // QUERY FOR DEFAULT SQL //
            $sql_post  = "SELECT * FROM post ORDER BY id";
            $stmt_post = $connect->conn()->query($sql_post);
        }

        while ($data_row = $stmt_post->fetch()) {
             //$counter        = 1;
             $post_id        = $data_row['id'];
             $post_date_time = $data_row['reg_date'];
             $title          = $data_row['title'];
             $category       = $data_row['category'];
             $author         = $data_row['author'];
             $image          = $data_row['image'];
             $post           = $data_row['post'];

            ?>
           <div class="card">
             <!-- <dive style="width:250px; margin:auto; padding:5px; border: solid 4px #666699;"> -->
             <img src="<?php echo 'uploads/'.htmlentities($image); ?>" max-height="300px" class="img-fluid card-img-top">
             <!--</div> -->
             <div class="card-body">
               <h4 style="color: purple;"> 
                 Post: <?php echo htmlentities($post_id); ?>
               </h4>
               <small class="text-muted">
                 <span class="text-dark">Category of 
                    <a href="blog_post.php?category=<?php echo htmlentities($category); ?>">
                    <?php echo htmlentities($category); ?></a>
                    <br> 
                    Written by <a href="profile.php?admin_name=<?php echo htmlentities($author); ?>">
                    <?php echo htmlentities($author); ?></a> on 
                    <?php
                          $dateTime = date('m/d/Y H:i:s', strtotime($post_date_time));
                          echo htmlentities($dateTime);  
                    ?>
                 </span>
               </small>
               <span style="float:right;" class="badge badge-dark text-white">
                 Comments:  <?php approvedCommentCount('comments', $post_id); ?>
               </span>
               <hr>
               <p class="card-text">
                 <?php if (strlen($post)>150) {
                         $post = substr($post, 0, 150)."...";
                 }
                 echo htmlentities($post);

                    ?>
               </p>
                 <a href="full_post.php?id=<?php echo $post_id; ?>" style="float:right;">
                   <span class="btn btn-info">Read More>></span>
                 </a>
          </div>
        </div>
        <?php } ?>
        <!---------------------------PAGINATION LINKS BEGIN------------------------->
        <nav>
          <ul class="pagination pagination-md">
            <!--THE BEGINNING OF PREVIOUS PAGE LINK-->
              <?php if (isset($page) && !empty($page)) { 
                    if ($page > 1) { 
                        ?>
            <li class="page-item mr-2 mt-2">
              <a href="blog_post.php?page=<?php echo $page - 1;?>" class="page-link">
                &laquo;
              </a>
            </li>
                        <?php 
                    }
              }
                ?>
            <!--THE ENDING OF PREVIOUS PAGE LINK-->
            <?php  
              $connect_p        = new Database("localhost", "root", "root", "cms");
              $sql_p            = "SELECT COUNT(*) FROM post";
              $stmt_pagination  = $connect_p->conn()->query($sql_p);
              $total_rows       = $stmt_pagination->fetch();
              $pagination_count = array_shift($total_rows);
              $pagination_count = $pagination_count/4;
              $final_page_count = ceil($pagination_count);

            for ($i = 1; $i <= $final_page_count; $i++) {
                if (isset($page)) {
                    $page = $_GET['page'];
                    //THE BEGINNING OF PAGINATION LINK//
                    if ($i == $page) {
                        ?>
            <li class="page-item active mr-2 mt-2">
              <a href="blog_post.php?page=<?php echo $i;?>" class="page-link">
                        <?php echo $i; ?>
              </a>
            </li>
                    <?php } else { ?>
            <li class="page-item mr-2 mt-2">
              <a href="blog_post.php?page=<?php echo $i;?>" class="page-link">
                        <?php echo $i; ?>
              </a>
            </li>
            <!--THE ENDING OF PAGINATION LINK-->
                    <?php }
                } 
            } ?>
            <!--THE BEGINNING OF NEXT PAGE LINK-->
            <?php if (isset($page) && !empty($page)) {
                if ($page+1 <= $final_page_count) {
                    ?>
            <li class="page-item mr-2 mt-2">
              <a href="blog_post.php?page=<?php echo $page + 1;?>" class="page-link">
                &raquo;
              </a>
            </li>
                <?php }
            } ?>
            <!--THE ENDING OF NEXT PAGE LINK-->
          </ul>
        </nav>
      </div>
      <!-- MAIN AREA ENDS-->
      <!-- SIDE AREA BEGINS-->
      <div class="col-sm-4">
        <div class="card mt-4">
          <div class="card-body" style="background-color:#666699;">
          <img src="images/sidearea pic.jpg" class="d-block img-fluid mb-3">
            <div class="text-center text-white">
                Lorem Ipsum is simply dummy text of the printing 
                and typesetting industry. Lorem Ipsum has been the 
                industry's standard dummy text ever since the 1500s, 
                when an unknown printer took a galley of type and scrambled 
                it to make a type specimen book. It has survived not only 
                five centuries, but also the leap into electronic typesetting, 
                remaining essentially unchanged. It was popularised in the 1960s 
                with the release of Letraset sheets containing Lorem Ipsum passages, 
                and more recently with desktop publishing software 
                like Aldus PageMaker including versions of Lorem Ipsum.
            </div>
          </div>
        </div>
        <br>
        <div class="card">
          <div class="card-header bg-dark text-light">
            <h2 class="lead">Sign Up</h2>
          </div>
          <div class="card-body" style="background-color:#666699;">
            <button type="button" class="btn btn-success btn-block text-center text-white mb-3" name="button">
                Join The Forum
            </button>
            <a href="login.php" class="text-white">
              <button type="button" class="btn btn-danger btn-block text-center" name="button">
                Login
              </button>
            </a>
          <div class="input-group mt-3 mb-3">
            <form class="" action="full_post.php?id=<?php echo $full_post_id; ?>" method="post">
             <div class="input-group-append">
               <input type="text" name="email" class="form-control mr-2" placeholder="Enter Your Email">
               <button type="submit" name="email_button" class="btn btn-primary btn-small text-center text-white">
                 Submit
               </button>
             </div>
            </form>
          </div>
        </div>
        </div> 
        <br>
        <div class="card">
          <div class="card-header bg-info text-white">
            <h2 class="text-center">Category's</h2>
          </div>
          <div class="card-body text-center" style="background-color:#666699;">
            <?php 
              $connect_c  = new Database("localhost", "root", "root", "cms");
              $sql_cat    = "SELECT * FROM category ORDER BY id";
              $sql_stmt = $connect_c->conn()->query($sql_cat);

            while ($cat_row = $sql_stmt->fetch()) {
                  $cat_id   = $cat_row['id'];
                  $cat_name = $cat_row['title'];
                ?>
            <a href="blog_post.php?category=<?php echo $cat_name; ?>">
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
          <div class="media mb-3" style="border: 2px solid white">
            <img src="<?php echo 'uploads/'.htmlentities($recent_image); ?>" width="70px" heigth="74" class="d-block img-fluid align-self-start">
            <div class="media-body ml-2">
              <a href="full_post.php?id=<?php echo htmlentities($recent_id); ?>">
                <h6 class="lead text-white">
                  Post: <?php echo htmlentities($recent_id); ?>
                </h6>
              </a>
              <p class="small">
                <?php
                    $dateTime = date('m/d/Y H:i:s', strtotime($recent_datetime));
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
    <!-- SIDE AREA ENDS-->
    </div>
  </div>
  <hr>
<!--------------------------  CONTAINER ENDS -------------------------->


<!----------------- BEGINNING FOOTER AND BODY SECTION ----------------->
<?php require_once "includes/footer.php"; ?>
<!------------------- ENDING FOOTER AND BODY SECTION ------------------>