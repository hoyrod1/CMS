<?php 
/**
 * * @file
 * php version 8.2
 * Search Post Page for CMS
 * 
 * @category CMS
 * @package  Search_Post_Configuration
 * @author   Rodney St.Cloud <hoyrod1@aol.com>
 * @license  STC Media inc
 * @link     https://cms/search_post.php
 */
require_once "includes/session.php";
require_once "includes/db_conn.php";
require_once "includes/functions.php";
require_once "includes/date_time.php";

?>

<!-------------------------- HTML-NAV SECTION -------------------------->
<?php 
$title = "Search Post";
require_once "includes/links/unlogged_nav_links.php"; 
?>
<!--------------------------  HTML-NAV SECTION -------------------------->
  <hr>
  <!-- CONTAINER BEGINS-->
  <div class="container">
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

        if (isset($_GET["search_button"])) {
            $search_field = testInput($_GET["search"]);
            $sql_search   = "SELECT * FROM post 
						                 WHERE title LIKE :Search 
														 OR category LIKE :Search 
														 OR author LIKE :Search 
														 OR post LIKE :Search";
            $stmt_post    = $connect->conn()->prepare($sql_search);
            $stmt_post->bindValue(':Search', '%'.$search_field.'%');
            $stmt_post->execute();
        } else {
            $sql_post  = "SELECT * FROM post ORDER BY id DESC";
            $stmt_post = $connect->conn()->query($sql_post);
        }

        while ($data_row = $stmt_post->fetch()) {

             $post_id   = $data_row['id'];
             $post_date_time = $data_row['datetime'];
             $title     = $data_row['title'];
             $category  = $data_row['category'];
             $author    = $data_row['author'];
             $image     = $data_row['image'];
             $post      = $data_row['post'];

            ?>
        <div class="card">
          <!-- <dive style="width:250px; margin:auto; padding:5px; border: solid 4px #666699;"> -->
            <img src="<?php echo 'uploads/'.htmlentities($image); ?>" max-height="300px" class="img-fluid card-img-top">
          <!--</div> -->
        <div class="card-body">
          <h4 class="card-title"><?php htmlentities($post_id); ?></h4>
            <small class="text-muted">
              Written by <?php echo htmlentities($author); ?> on 
              <?php echo htmlentities($post_date_time); ?>
            </small>
          <span style="float:right;" class="badge badge-dark text-white">
            Comments 20
          </span>
        <hr>
        <p class="card-text">
            <?php 
            if (strlen($post)>150) {
                $post = substr($post, 0, 150)."...";
            } echo htmlentities($post); 
            ?>
        </p>
        <a href="full_post.php?id=<?php echo $post_id; ?>" style="float:right;">
          <span class="btn btn-info">Read More>></span>
        </a>
      </div>
    </div>
        <?php } ?>
    </div>
    <!-- MAIN AREA ENDS-->
    <!-- SIDE AREA BEGINS-->
    <div class="col-sm-4" style="min-height: 40px;background-color:#9494b8;">
    </div>
    <!-- SIDE AREA ENDS-->
    </div>
  </div>
  <!-- CONTAINER ENDS-->
  <hr>

  <hr>
  <!-- BODY BEGINS-->
  <body>

  </body>
  <!-- BODY END -->

<!----BEGINNING FOOTER AND BODY SECTION---->
<?php require_once "includes/footer.php"; ?>
<!-----ENDING FOOTER AND BODY SECTION------>
</html>