<?php
/**
 * * @file
 * php version 8.2
 * MyProfile Page for CMS
 * 
 * @category CMS
 * @package  MyProfile_Configuration
 * @author   Rodney St.Cloud <hoyrod1@aol.com>
 * @license  STC Media inc
 * @link     https://cms/myprofile.php
 */
require_once "includes/session.php";
require_once "includes/db_conn.php";
require_once "includes/functions.php";
require_once "includes/date_time.php";

$_SESSION['trackingURL'] = $_SERVER['PHP_SELF'];
confirmLogin();

//--------------------------------------------------------------//
//BEGINNING OF FETCHING EXISTING ADMIN DATA
$admin_id          = "";
if (isset($_SESSION["user_id"])) {
    $admin_id = $_SESSION["user_id"];
} elseif (isset($_COOKIE["admin_id"])) {
    $admin_id = $_COOKIE["admin_id"];
}
//--------------------------------------------------------------//

//--------------------------------------------------------------//
// define $_POST variables and set to empty values
$myProfile_name  = "";
$myProfile_title = "";
$myProfile_bio   = "";
$myProfile_photo = "";
$image           = "";
//--------------------------------------------------------------//

//--------------------------------------------------------------//
$myProfile_connect = new Database("localhost", "root", "root", "cms");
$myProfile_sql     = "SELECT * FROM admin WHERE id = '$admin_id'";
$myProfile_stmt    = $myProfile_connect->conn()->query($myProfile_sql);


while ($myprofile_row = $myProfile_stmt->fetch()) {
    $myProfile_username = htmlspecialchars($myprofile_row['username']);
    $myProfile_name     = htmlspecialchars($myprofile_row['admin_name']);
    $myProfile_title    = htmlspecialchars($myprofile_row['admin_headline']);
    $myProfile_bio      = htmlspecialchars($myprofile_row['admin_bio']);
    $myProfile_photo    = htmlspecialchars($myprofile_row['admin_photo']);
}
//--------------------------------------------------------------//

//ENDING OF FETCHING EXISTING ADMIN DATA
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit'])) {
    
    $editName      = testInput($_POST['editName']);
    $editHeadLine  = testInput($_POST['editHeadLine']);
    $enterBio      = testInput($_POST['enterBio']);
    $image         = $_FILES['image']['name'];;

    // VALIDATE UPDATED ADMINS DATA INPUTED WITH NO IMAGE FOR THE DATABASE
    if (empty($editName) && empty($editHeadLine) && empty($enterBio) && empty($image)) {
        $_SESSION['error_message'] = "Please Update Your Profile!";
        redirect("myprofile.php");
    } elseif (strlen($editHeadLine) > 31) {
        $_SESSION['error_message'] = "Headline should be less than 30 characters";
        redirect("myprofile.php");
    } elseif (strlen($enterBio) > 9999) {
        $_SESSION['error_message'] = "Your Bio should be less than 10000 characters";
        redirect("myprofile.php");
    } else {
        //QUERY TO UPDATE ADMINS DATA WITH NO IMAGE IN THE DATABASE
        if (empty($editHeadLine) && empty($enterBio) && empty($image)) {
            // CHECK IF COOKIE WORKS WHEN SESSION ID DOESN'T EXIST //
            $admin_id = $_SESSION["user_id"];
            $connect  = new Database("localhost", "root", "root", "cms");
            $edit_sql = "UPDATE admin SET admin_name = :editName 
						                          WHERE id = :admin_id";
            $pre_stmt = $connect->conn()->prepare($edit_sql);
            $pre_stmt->bindValue(':editName', $editName);
            $pre_stmt->bindValue(':admin_id', $admin_id);
            $execute = $pre_stmt->execute();
            
            if ($execute) {
                $_SESSION['success_message'] = 'Your name has been updated';
                redirect("myprofile.php");
            } else {
                $_SESSION['error_message'] = "Your name has not been updated";
                redirect("myprofile.php");
            }

        } elseif (empty($editName) && empty($enterBio) && empty($image)) {
            $admin_id = $_SESSION["user_id"];
            $connect  = new Database("localhost", "root", "root", "cms");
            $edit_sql = "UPDATE admin SET admin_headline = :editHeadLine 
						                        WHERE id = :admin_id";
            $pre_stmt = $connect->conn()->prepare($edit_sql);
            $pre_stmt->bindValue(':editHeadLine', $editHeadLine);
            $pre_stmt->bindValue(':admin_id', $admin_id);
            $execute = $pre_stmt->execute();
            
            if ($execute) {
                $_SESSION['success_message'] = 'Your headline has been updated';
                redirect("myprofile.php");
            } else {
                $_SESSION['error_message'] = "Your headline has not been updated";
                redirect("myprofile.php");
            }

        } elseif (empty($editName) && empty($editHeadLine) && empty($image)) {
            $admin_id = $_SESSION["user_id"];
            $connect  = new Database("localhost", "root", "root", "cms");
            $edit_sql = "UPDATE admin SET admin_bio = :enterBio 
                                           WHERE id = :admin_id";
            $pre_stmt = $connect->conn()->prepare($edit_sql);
            $pre_stmt->bindValue(':enterBio', $enterBio);
            $pre_stmt->bindValue(':admin_id', $admin_id);
            $execute = $pre_stmt->execute();
            
            if ($execute) {
                $_SESSION['success_message'] = 'Your bio has been updated';
                redirect("myprofile.php");
            } else {
                $_SESSION['error_message'] = "Your bio has not been updated";
                redirect("myprofile.php");
            }

        } elseif (empty($editHeadLine) && empty($image)) {

            $admin_id = $_SESSION["user_id"];
            $connect  = new Database("localhost", "root", "root", "cms");
            $edit_sql = "UPDATE admin SET admin_name = :editName, 
						                  admin_bio = :enterBio 
                                           WHERE id = :admin_id";
            $pre_stmt = $connect->conn()->prepare($edit_sql);
            $pre_stmt->bindValue(':editName', $editName);
            $pre_stmt->bindValue(':enterBio', $enterBio);
            $pre_stmt->bindValue(':admin_id', $admin_id);
            $execute = $pre_stmt->execute();
            
            if ($execute) {
                $_SESSION['success_message'] = 'Your name & bio has been updated';
                redirect("myprofile.php");
            } else {
                $_SESSION['error_message'] = "Your name &  bio has not been updated";
                redirect("myprofile.php");
            }

        } elseif (empty($editName) && empty($image)) {

            $admin_id = $_SESSION["user_id"];
            $connect  = new Database("localhost", "root", "root", "cms");
            $edit_sql = "UPDATE admin SET admin_headline = :editHeadLine, 
						                  admin_bio = :enterBio 
                                           WHERE id = :admin_id";
            $pre_stmt = $connect->conn()->prepare($edit_sql);
            $pre_stmt->bindValue(':editHeadLine', $editHeadLine);
            $pre_stmt->bindValue(':enterBio', $enterBio);
            $pre_stmt->bindValue(':admin_id', $admin_id);
            $execute = $pre_stmt->execute();
            
            if ($execute) {
                $_SESSION['success_message'] = 'Your headline & bio has been updated';
                redirect("myprofile.php");
            } else {
                $_SESSION['error_message'] = "Your headline &  bio has not been updated";
                redirect("myprofile.php");
            }

        } elseif (empty($enterBio) && empty($image)) {
            $admin_id = $_SESSION["user_id"];
            $connect  = new Database("localhost", "root", "root", "cms");
            $edit_sql = "UPDATE admin SET admin_name = :editName, 
						                  admin_headline = :editHeadLine 
                                          WHERE id = :admin_id";
            $pre_stmt = $connect->conn()->prepare($edit_sql);
            $pre_stmt->bindValue(':editName', $editName);
            $pre_stmt->bindValue(':editHeadLine', $editHeadLine);
            $pre_stmt->bindValue(':admin_id', $admin_id);
            $execute = $pre_stmt->execute();
            
            if ($execute) {
                $_SESSION['success_message'] = 'Your name & headline has been updated';
                redirect("myprofile.php");
            } else {
                $_SESSION['error_message'] = "Your name & headline has not been updated";
                redirect("myprofile.php");
            }

        } elseif (empty($image)) {

            $admin_id = $_SESSION["user_id"];
            $connect  = new Database("localhost", "root", "root", "cms");
            $edit_sql = "UPDATE admin SET admin_name = :editName, 
										  admin_headline = :editHeadLine, 
										  admin_bio = :enterBio 
                                        WHERE id = :admin_id";
            $pre_stmt = $connect->conn()->prepare($edit_sql);
            $pre_stmt->bindValue(':editName', $editName);
            $pre_stmt->bindValue(':editHeadLine', $editHeadLine);
            $pre_stmt->bindValue(':enterBio', $enterBio);
            $pre_stmt->bindValue(':admin_id', $admin_id);
            $execute = $pre_stmt->execute();
            
            if ($execute) {
                $_SESSION['success_message'] = 'Your name, headline & bio has been updated';
                redirect("myprofile.php");
            } else {
                $_SESSION['error_message'] = "Your name, headline & bio has not been updated";
                redirect("myprofile.php");
            }

        } elseif (!empty($image)) {
            // ----------------------------------------------------------------- //
            // The $validateImage FUNCTION VALIDATES THE IMAGE FROM THE FORM //
            // The $validateImage FUNCTION RETURNS FALSE OR A IMAGE FILE NAME //
            $validatdImage = imageValidation($image); 
            // ----------------------------------------------------------------- //

            if ($validatdImage == false) {
                redirect("myprofile.php");
            } else {

                if (empty($editName) && empty($editHeadLine) && empty($enterBio)) {

                    $admin_id = $_SESSION["user_id"];
                    
                    $connect  = new Database("localhost", "root", "root", "cms");
                    $edit_sql = "UPDATE admin SET admin_photo = :image 
                                                     WHERE id = :admin_id";
                    $pre_stmt = $connect->conn()->prepare($edit_sql);
                    $pre_stmt->bindValue(':image', $image);
                    $pre_stmt->bindValue(':admin_id', $admin_id);
                    $execute = $pre_stmt->execute();
            
                    if ($execute) {
                        $movImg = move_uploaded_file($_FILES["image"]["tmp_name"], $validatdImage);
                        unlink("images/" . $myProfile_photo);
                        if (!$movImg) {
                            $_SESSION['error_message'] = "There's an error moving your image";
                            redirect("myprofile.php");
                        } else {
                            $_SESSION['success_message'] = "Your image has been updated";
                            redirect("myprofile.php");
                        }
                    } else {
                        $_SESSION['error_message'] = "Your image has not been updated";
                        redirect("myprofile.php");
                    }
        
                } elseif (empty($editHeadLine) && empty($editName)) {
    
    
                    $admin_id = $_SESSION["user_id"];
                    $connect  = new Database("localhost", "root", "root", "cms");
                    $edit_sql = "UPDATE admin SET admin_bio = :enterBio', 
                                                  admin_photo = :image 
                                                  WHERE id = :admin_id";
                    $pre_stmt = $connect->conn()->prepare($edit_sql);
                    $pre_stmt->bindValue(':enterBio', $enterBio);
                    $pre_stmt->bindValue(':image', $image);
                    $pre_stmt->bindValue(':admin_id', $admin_id);
                    $execute = $pre_stmt->execute();
            
                    if ($execute) {
                        $movImg = move_uploaded_file($_FILES["image"]["tmp_name"], $validatdImage);
                        unlink("images/" . $myProfile_photo);
                        if (!$movImg) {
                            $_SESSION['error_message'] = "There's an error moving your image";
                            redirect("myprofile.php");
                        } else {
                            $_SESSION['success_message'] = "Your bio & image has been updated";
                            redirect("myprofile.php");
                        }
                    } else {
                        $_SESSION['error_message'] = "Your image has not been updated";
                        redirect("myprofile.php");
                    }
        
                } elseif (empty($enterBio) && empty($editName)) {
                    
                    $admin_id = $_SESSION["user_id"];
                    $connect  = new Database("localhost", "root", "root", "cms");
                    $edit_sql = "UPDATE admin SET admin_headline = :editHeadLine, 
                                                  admin_photo = :image 
                                                  WHERE id = :admin_id";
                    $pre_stmt = $connect->conn()->prepare($edit_sql);
                    $pre_stmt->bindValue(':editHeadLine', $editHeadLine);
                    $pre_stmt->bindValue(':image', $image);
                    $pre_stmt->bindValue(':admin_id', $admin_id);
                    $execute = $pre_stmt->execute();
            
                    if ($execute) {
                        $movImg = move_uploaded_file($_FILES["image"]["tmp_name"], $validatdImage);
                        unlink("images/" . $myProfile_photo);
                        if (!$movImg) {
                            $_SESSION['error_message'] = "There's an error moving your image";
                            redirect("myprofile.php");
                        } else {
                            $_SESSION['success_message'] = "Your headline & image has been updated";
                            redirect("myprofile.php");
                        }
                    } else {
                        $_SESSION['error_message'] = "Your image has not been updated";
                        redirect("myprofile.php");
                    }
        
                } elseif (empty($enterBio) && empty($editHeadLine)) {
                    
                    $admin_id = $_SESSION["user_id"];
                    $connect  = new Database("localhost", "root", "root", "cms");
                    $edit_sql = "UPDATE admin SET admin_name = :editName, 
                                                  admin_photo = :image 
                                                  WHERE id = :admin_id";
                    $pre_stmt = $connect->conn()->prepare($edit_sql);
                    $pre_stmt->bindValue(':editName', $editName);
                    $pre_stmt->bindValue(':image', $image);
                    $pre_stmt->bindValue(':admin_id', $admin_id);
                    $execute = $pre_stmt->execute();
            
                    if ($execute) {
                        $movImg = move_uploaded_file($_FILES["image"]["tmp_name"], $validatdImage);
                        unlink("images/" . $myProfile_photo);
                        if (!$movImg) {
                            $_SESSION['error_message'] = "There's an error moving your image";
                            redirect("myprofile.php");
                        } else {
                            $_SESSION['success_message'] = "Your name & image has been updated";
                            redirect("myprofile.php");
                        }
                    } else {
                        $_SESSION['error_message'] = "Your image has not been updated";
                        redirect("myprofile.php");
                    }
        
                } elseif (empty($editName)) {
        
                    $admin_id = $_SESSION["user_id"];
                    $connect  = new Database("localhost", "root", "root", "cms");
                    $edit_sql = "UPDATE admin SET admin_headline = :editHeadLine, 
                                                  admin_bio = :enterBio', 
                                                  admin_photo = :image 
                                                  WHERE id = :admin_id";
                    $pre_stmt = $connect->conn()->prepare($edit_sql);
                    $pre_stmt->bindValue(':editHeadLine', $editHeadLine);
                    $pre_stmt->bindValue(':enterBio', $enterBio);
                    $pre_stmt->bindValue(':image', $image);
                    $pre_stmt->bindValue(':admin_id', $admin_id);
                    $execute = $pre_stmt->execute();
            
                    if ($execute) {
                        $movImg = move_uploaded_file($_FILES["image"]["tmp_name"], $validatdImage);
                        unlink("images/" . $myProfile_photo);
                        if (!$movImg) {
                            $_SESSION['error_message'] = "There's an error moving your image";
                            redirect("myprofile.php");
                        } else {
                            $_SESSION['success_message'] = "Your headline, bio & image has been updated";
                            redirect("myprofile.php");
                        }
                    } else {
                        $_SESSION['error_message'] = "Your image has not been updated";
                        redirect("myprofile.php");
                    }
        
                } elseif (empty($editHeadLine)) {
        
                    $admin_id = $_SESSION["user_id"];
                    $connect  = new Database("localhost", "root", "root", "cms");
                    $edit_sql = "UPDATE admin SET admin_name = :editName, 
                                                  admin_bio = :enterBio', 
                                                  admin_photo = :image 
                                                  WHERE id = :admin_id";
                    $pre_stmt = $connect->conn()->prepare($edit_sql);
                    $pre_stmt->bindValue(':editName', $editName);
                    $pre_stmt->bindValue(':enterBio', $enterBio);
                    $pre_stmt->bindValue(':image', $image);
                    $pre_stmt->bindValue(':admin_id', $admin_id);
                    $execute = $pre_stmt->execute();
            
                    if ($execute) {
                        $movImg = move_uploaded_file($_FILES["image"]["tmp_name"], $validatdImage);
                        unlink("images/" . $myProfile_photo);
                        if (!$movImg) {
                            $_SESSION['error_message'] = "There's an error moving your image";
                            redirect("myprofile.php");
                        } else {
                            $_SESSION['success_message'] = "Your name, bio & image has been updated";
                            redirect("myprofile.php");
                        }
                    } else {
                        $_SESSION['error_message'] = "Your image has not been updated";
                        redirect("myprofile.php");
                    }
        
                } elseif (empty($enterBio)) {
        
                    $admin_id = $_SESSION["user_id"];
                    $connect  = new Database("localhost", "root", "root", "cms");
                    $edit_sql = "UPDATE admin SET admin_name = :editName, 
                                                  admin_headline = :editHeadLine, 
                                                  admin_photo = :image 
                                                  WHERE id = :admin_id";
                    $pre_stmt = $connect->conn()->prepare($edit_sql);
                    $pre_stmt->bindValue(':editName', $editName);
                    $pre_stmt->bindValue(':editHeadLine', $editHeadLine);
                    $pre_stmt->bindValue(':image', $image);
                    $pre_stmt->bindValue(':admin_id', $admin_id);
                    $execute = $pre_stmt->execute();
            
                    if ($execute) {
                        $movImg = move_uploaded_file($_FILES["image"]["tmp_name"], $validatdImage);
                        unlink("images/" . $myProfile_photo);
                        if (!$movImg) {
                            $_SESSION['error_message'] = "There's an error moving your image";
                            redirect("myprofile.php");
                        } else {
                            $_SESSION['success_message'] = "Your name, headline & image has been updated";
                            redirect("myprofile.php");
                        }
                    } else {
                        $_SESSION['error_message'] = "Your image has not been updated";
                        redirect("myprofile.php");
                    }
        
                } else {
        
                    $admin_id = $_SESSION["user_id"];
                    $connect  = new Database("localhost", "root", "root", "cms");
                    $edit_sql = "UPDATE admin SET admin_name = :editName, 
                                                  admin_headline = :editHeadLine, 
                                                  admin_bio = :enterBio,  
                                                  admin_photo = :image 
                                                  WHERE id = :admin_id";
                    $pre_stmt = $connect->conn()->prepare($edit_sql);
                    $pre_stmt->bindValue(':editName', $editName);
                    $pre_stmt->bindValue(':editHeadLine', $editHeadLine);
                    $pre_stmt->bindValue(':enterBio', $enterBio);
                    $pre_stmt->bindValue(':image', $image);
                    $pre_stmt->bindValue(':admin_id', $admin_id);
                    $execute = $pre_stmt->execute();
            
                    if ($execute) {
                        $movImg = move_uploaded_file($_FILES["image"]["tmp_name"], $validatdImage);
                        unlink("images/" . $myProfile_photo);
                        if (!$movImg) {
                            $_SESSION['error_message'] = "There's an error moving your image";
                            redirect("myprofile.php");
                        } else {
                            $_SESSION['success_message'] = "Your name, headline, bio & image has been updated";
                            redirect("myprofile.php");
                        }
                    } else {
                        $_SESSION['error_message'] = "Your image has not been updated";
                        redirect("myprofile.php");
                    }
                }
            }
            
        }
    }
}

?>

<!--  HTML-NAV SECTION -->
<?php 
$title = "My Profile Page";
require_once "includes/loggedin_nav_links.php"; 
?>
<!--  HTML-NAV SECTION -->

<hr>
  <!-- HEADER BEGINS-->
  <header class="bg-dark text-white py-3">
  <div class="container">
    <div class="row">
      <div class="col-md-12 ">
          <h1>
              <i class="fas fa-user mr-2 text-success"> 
                  <?php echo $myProfile_name ; ?>'s Profile 
              </i>
          </h1>
          <small style="font-weight:bold;float:right;font-size:20px;margin-right:30%;">
              <?php echo $myProfile_title ; ?>
          </small>
      </div>
    </div>
  </div>
  </header>
  <!-- HEADER ENDS-->
  <hr>
  <!-- MAIN AREA BEGIN -->
  <section class="container py-2 mb-4">
    <div class="row">
      <!-- BEGINNING OF LEFT AREA-->
      <div class="col-md-3" style="min-height:500px;">
        <div class="card">
          <div class="card-header bg-dark text-white">
            <h3 style="text-align: center;">
              <?php echo $myProfile_name ; ?>
            </h3>
          </div>
          <div class="card-body" style="background-color: lightgrey;">
              <img src="<?php echo 'images/'. $myProfile_photo ; ?>" class="block img-fluid" height="225px" width="205px">
          </div>
          <div class="bg-dark text-white" style="padding: 10px;">
              <?php echo $myProfile_bio ; ?>
          </div>
       </div>
     </div>
     <!-- ENDING OF LEFT AREA-->
     <!-- BEGINNING OF RIGHT AREA-->
     <div class="col-md-9" style="min-height:500px;">
         <?php 
             echo errorMessage();
             echo successMessage();
            ?>
         <!-- FORM STARTS HERE-->
        <form class="" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" enctype="multipart/form-data">
             <div class="card bg-dark text-light">
                 <div class="card-header bg-secondary text-light">
                     <h4 style="color: #3F628A;">Edit Profile</h1>
                 </div>
                 <!-- EDIT NAME AND INSERT NEW HEADLINE -->
                 <div class="card-body">
                     <div class="form-group">
                         <input class="form-control" id="title" type="text" name="editName" placeholder="<?php echo $myProfile_name ; ?>">
                     </div>
                     <div class="form-group">
                         <input class="form-control" style="margin-bottom: 10px;" id="title" type="text" name="editHeadLine" placeholder="<?php echo $myProfile_title ; ?>">
                         <small class="text-muted">
                             Add or edit a Professional Headline
                         </small>
                         <span class="text-danger">
                             Don't enter more than 100 characters
                         </span>
                     </div>
                     <!-- ENTER BIO -->
                     <div class="form-group bg-dark">
                         <textarea class="form-control" id="post" name="enterBio" rows="8" cols="80" placeholder="<?php echo $myProfile_bio; ?>">
                         </textarea>
                     </div>
                     <!-- SELECT IMAGE INPUT-->
                     <div class="form-group py-2">
                         <label for="image">
                            <span class="label">Existing Image: </span>
                            <img src="<?php echo 'images/'. $myProfile_photo ; ?>" class="block img-fluid" height="65px" width="50px">
                         </label>
                     <div class="custom-file">
                         <input class="custom-file-input" type="file" name="image" id="image">
                         <label class="custom-file-label" for="image">Edit Image:</label>
                     </div>
                 </div>
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
        <!-- FORM ENDS HERE-->
    </div>
    <!-- ENDING OF RIGHT AREA-->
    </div>
  </section>
  <!-- MAIN AREA ENDS-->
<hr>

<!----BEGINNING FOOTER AND BODY SECTION---->
<?php require_once "includes/footer.php"; ?>
<!-----ENDING FOOTER AND BODY SECTION------>