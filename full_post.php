<?php
/**
 * * @file
 * php version 8.2
 * Full Posting Page for CMS
 * 
 * @category CMS
 * @package  Full_Posting_Configuration_Page
 * @author   Rodney St.Cloud <hoyrod1@aol.com>
 * @license  STC Media inc
 * @link     https://cms/full_post.php
 */
require_once "includes/session.php";
require_once "includes/db_conn.php";
require_once "includes/functions.php";
require_once "includes/date_time.php";

$full_post_id = $_GET['id'];

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
                redirect("full_post.php?id=$full_post_id");
            } else {
                $_SESSION["error_message"] = 'Your email has not been submitted';
                redirect("full_post.php?id=$full_post_id");
            }
        } else {
            $_SESSION["error_message"] = 'Please enter valid email';
            redirect("full_post.php?id=$full_post_id");
        }
    } else {
        $_SESSION["error_message"] = 'Please fill out email field';
        redirect("full_post.php?id=$full_post_id");
    }
}

if (isset($_POST['submit'])) {

    $name    = testInput($_POST['commenter_name']);
    $email   = testInput($_POST['commenter_email']);
    $comment = testInput($_POST['commenter_thoughts']);

    if (empty($name) || empty($email) || empty($comment)) {
        $_SESSION['error_message'] = "Please fill out the form";
        redirect("full_post.php?id=$full_post_id");
    } elseif (strlen($comment) > 500) {
        $_SESSION['error_message'] = "Category Title should be less than 500 characters! ";
        redirect("full_post.php?id=$full_post_id");
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $_SESSION['error_message'] = "Please enter vailid email! ";
        redirect("full_post.php?id=$full_post_id");
    } else {
        $connect = new Database("localhost", "root", "root", "cms");

        $sql      = "INSERT INTO comments(name, 
                                          email, 
        																	comment, 
        																	approved_by, 
        																	comment_status, 
        																	post_id) 
        																	VALUES(:Name, 
        																	       :Email, 
        																				 :Comment, 
        																				 'CommentPending', 
        																				 'off', 
        																				 :post_id)";
        $pre_stmt = $connect->conn()->prepare($sql);
        $pre_stmt->bindValue(':Name', $name, PDO::PARAM_STR);
        $pre_stmt->bindValue(':Email', $email, PDO::PARAM_STR);
        $pre_stmt->bindValue(':Comment', $comment, PDO::PARAM_STR);
        $pre_stmt->bindValue(':post_id', $full_post_id, PDO::PARAM_INT);
        $execute = $pre_stmt->execute();

        if ($execute) {

            $_SESSION['success_message'] = 'Your comment successfully submited!';
            redirect("full_post.php?id=$full_post_id");

        } else {
            $_SESSION['success_message'] = "Your comment was not submited!";
            redirect("full_post.php?id=$full_post_id");
        }
    }
}

//-------------------------- HTML-NAV SECTION --------------------------//
$title = "Category Page";
require_once "includes/blog_nav_links.php"; 
//--------------------------  HTML-NAV SECTION --------------------------//

?>

<hr>
<!-- CONTAINER BEGINS-->
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
        <!----------------- BEGGINING OF FULL POST QUERY ----------------->
        <?php 
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
            $post_full_id = $_GET["id"];
            /* IF STATEMENT FOR FULL POST WITH INVALID URL ID VALUE */
            if (!isset($post_full_id)) {
                $_SESSION['error_message'] = "Invalid URL!";
                redirect('blog_post.php?page=1');
            }
            $sql_post         = "SELECT * FROM post WHERE id = '$post_full_id'";
            $stmt_post        = $connect->conn()->query($sql_post);
            $rowcount_results = $stmt_post->rowcount();
            
            if ($rowcount_results != 1) {
                $_SESSION['error_message'] = "Post Not Found!";
                redirect('blog_post.php?page=1');
            }
        }
        while ($data_row = $stmt_post->fetch()) {
            $post_id        = $data_row['id'];
            $post_date_time = $data_row['reg_date'];
            $title          = $data_row['title'];
            $category       = $data_row['category'];
            $author         = $data_row['author'];
            $image          = $data_row['image'];
            $post           = $data_row['post'];

            $dateTime = date('m/d/Y H:i:s', strtotime($post_date_time));

            ?>
    <div class="card">
      <!-- <dive style="width:250px; margin:auto; padding:5px; border: solid 4px #666699;"> -->
        <img src="<?php echo 'uploads/'.htmlentities($image); ?>" max-height="300px" class="img-fluid card-img-top">
      <!--</div> -->
        <div class="card-body">
          <h4 class="card-title">
            Post: <?php echo htmlentities($post_id); ?>
          </h4>
          <small class="text-muted">
            <span class="text-dark">
              Category of
              <a href="category.php?category=<?php echo urlencode(htmlspecialchars_decode($category)); ?>">
                <?php echo $category; ?>
              </a>
              <br> 
              Written by 
              <a href="profile.php?admin_name=<?php echo htmlentities($author); ?>">
                <?php echo htmlentities($author); ?>
              </a> on
                <?php
                    $dateTime = date('m/d/Y g:i a', strtotime($post_date_time));
                    echo htmlentities($dateTime);
                ?>
            </span>
          </small>
         <span style="float:right;font-size: 15px;" class="badge badge-dark text-white">
           Comments: 
            <?php approvedCommentCount('comments', $post_id); ?>
         </span>
         <hr>
        <p class="card-text"><?php echo nl2br($post); ?></p>
      </div>
    </div>
    <br>
        <?php } ?>
    <!----------------ENDINING OF FULL POST QUERY---------------->
    <!-----------------FETCH COMMENT AREA START---------------->
    <br>
      <span style="font-weight: bold;padding: 5px;color: white;font-size: 20px;">
        Comment:
      </span>
      <br>
      <?php 
        $connect = new Database("localhost", "root", "root", "cms");
        $sql     = "SELECT * FROM comments WHERE post_id = '$full_post_id' AND comment_status = 'ON'";
        $stmt    = $connect->conn()->query($sql);
        while ($rows = $stmt->fetch()) {
            $comment_date   = $rows['reg_date'];
            $comment_name   = $rows['name'];
            $comment_post   = $rows['comment'];
            ?>
       <div style="background-color: white; border: 2px blue solid;font-size: 17px;padding: 5px;border-radius: 5px">
         <div class="media">
           <img class="d-sm-block img-fluid align-self-start" src="uploads/2010 Exotica Pic1.jpg" width="65">
           <div class="media-body ml-2">
             <h6 class="lead"><?php echo $comment_name; ?></h6>
             <p class="small">
                <?php
                    $dateTime = date('m/d/Y g:i a', strtotime($comment_date));
                    echo htmlentities($dateTime); 
                ?>
             </p>
             <p><?php echo $comment_post; ?></p>
           </div>
         </div>
       </div>
       <br>
        <?php } ?>
        <!----FETCH COMMENT AREA END-->
        <!----COMMENT AREA START-->
        <div class="">
          <form class="" action="full_post.php?id=<?php echo $full_post_id; ?>" method="post">
            <div class="card mb-3">
              <div class="card-header">
                <h5 class="FieldInfo">Please Post Your Comments About This Post</h5>
              </div>
              <div class="card-body">
                <div class="form-group">
                  <div class="input-group">
                  <div class="input-group-prepend">
                    <span class="input-group-text">
                      <i class="fas fa-user"></i>
                    </span>
                    </div>
                    <input type="text" name="commenter_name" value="" placeholder="Name" class="form-control" required>
                  </div>
                </div>
                <div class="form-group">
                  <div class="input-group">
                  <div class="input-group-prepend">
                    <span class="input-group-text">
                      <i class="fas fa-envelope"></i>
                    </span>
                  </div>
                  <input type="email" name="commenter_email" value="" placeholder="Email" class="form-control" required>
                </div>
              </div>
              <div class="form-group">
                <textarea name="commenter_thoughts" class="form-control" rows="6" cols="80" required></textarea>
              </div>
              <div class="">
                <button type="submit" name="submit" class="btn btn-primary btn-block"> 
                  Submit
                </button>
              </div>
              </div>
            </div>
          </form>
        </div>
        <!----COMMENT AREA ENDS--->
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
                  <div class="card-header bg-dark text-light">
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
                  <div class="card-header bg-dark text-light">
                    <h2 class="lead"><center>Sign Up</center></h2>
                  </div>
                  <div class="card-body" style="background-color:#666699;">
                    <a href="blog_post.php" class="text-white">
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
   <!-- SIDE AREA ENDS-->
  </div>
</div>
<!-- CONTAINER ENDS-->
<hr>
<!----BEGINNING FOOTER AND BODY SECTION---->
<?php require_once "includes/footer.php"; ?>
<!-----ENDING FOOTER AND BODY SECTION------>