<?php
/**
 * * @file
 * php version 8.2
 * Registration Page for CMS
 * 
 * @category CMS
 * @package  Registration_Page_Configuration
 * @author   Rodney St.Cloud <hoyrod1@aol.com>
 * @license  STC Media inc
 * @link     https://cms/registration.php
 */

require_once "includes/session.php";
require_once "includes/db_conn.php";
require_once "includes/functions.php";
require_once "includes/date_time.php";

// define $_POST variables and set to empty values
$name         = "";
$email        = "";
$contact_num  = "";
$username     = "";
$password     = "";
$con_password = "";
$phot_err     = "";

// define error variables and set to empty values
$nameErr     = "";
$emailErr    = "";
$contactErr  = "";
$usernameErr = "";
$passwordErr = "";
$confpassErr = "";
$passNoMatchErr = "";

// define form data and image error array and set to empty values
$formDataErr = [];
$photoErr    = [];

//- CODE TO REGISTER USER IF THE REQUEST METHOD IS POST $_POST["submit"] ISSET -//
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit'])) {

    //------------ CODE TO VALIDATE IF THE FORM DATA IS VALID ------------//
    if (empty($_POST["name"])) {
        $nameErr = "Name is required";
        array_push($formDataErr, $nameErr);
    } else {
        $name = testInput($_POST['name']);
        if (!preg_match("/^[a-zA-Z-'\. ]*$/", $name)) {
            $nameErr = "Only letters hyphens, spaces and periods";
            array_push($formDataErr, $nameErr);
        }
    }

    if (empty($_POST["email"])) {
        $emailErr = "Email is required";
        array_push($formDataErr, $emailErr);
    } else {
        $email = testInput($_POST['email']);
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $emailErr = "Invalid email format";
            array_push($formDataErr, $emailErr);
        }
    }

    if (empty($_POST["contact_num"])) {
        $contactErr = "Contact Number required";
        array_push($formDataErr, $contactErr);
    } else {
        $contact_num = testInput($_POST['contact_num']);
        if (!preg_match("/[0-9]/", $contact_num)) {
            $contactErr = "Only numbers and hyphens";
            array_push($formDataErr, $contactErr);
        }
    }

    if (empty($_POST["username"])) {
        $usernameErr = "Username required";
        array_push($formDataErr, $usernameErr);
    } else {
        $username = testInput($_POST['username']);
        if (!preg_match("/^[0-9A-Za-z]{6,16}$/", $username)) {
            $usernameErr = "Please enter between 6-16 letters and numbers";
            array_push($formDataErr, $usernameErr);
        }
    }

    if (empty($_POST["password"])) {
        $passwordErr = "Password required";
        array_push($formDataErr, $passwordErr);
    } else {
        $password = testInput($_POST['password']);
        // find one number
        // one uppercase letter
        // one lowercase letter
        // and one character that is NOT alphanumeric
        // a string with any characters between 6 and 32 characters long
        // /^(?=.*?[0-9])(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[^0-9A-Za-z]).{6,32}$/
        if (!preg_match("/^(?=.*?[0-9])(?=.*?[A-Za-z]).{6,32}$/", $password)) {
            $passwordErr = "Invalid password";
            array_push($formDataErr, $passwordErr);
        }
    }

    if (empty($_POST["confirm_pass"])) {
        $confpassErr = "Confirm Password required";
        array_push($formDataErr, $confpassErr);
    } else {
        $con_password = testInput($_POST['confirm_pass']);
    }

    if ($password !== $con_password) {
        $passNoMatchErr = "Password doesn't match";
        array_push($formDataErr, $passNoMatchErr);
    } else {
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
    }
    // --------------------------------------------------------------------------- //
    if (empty($formDataErr)) {

        if ($_FILES["photo"]["size"] === 0) {

            // ---CODE TO INSERT VALIDATED FORM DATA TO DATABASE IF NO IMAGE -- //
            $database      = new Database("localhost", "root", "root", "cms");
        
            $sql           = "INSERT INTO user_record(name, 
                                                        email, 
                                                        contact_num, 
                                                        username, 
                                                        password)
                                VALUES(:namE, 
                                        :emaiL, 
                                        :contact_nuM, 
                                        :usernamE, 
                                        :passworD)";
        
            $prepare_stmt  = $database->conn()->prepare($sql);
            $prepare_stmt->bindValue(':namE', $name);
            $prepare_stmt->bindValue(':emaiL', $email);
            $prepare_stmt->bindValue(':contact_nuM', $contact_num);
            $prepare_stmt->bindValue(':usernamE', $username);
            $prepare_stmt->bindValue(':passworD', $hashed_password);
            $execute = $prepare_stmt->execute();
        
            if ($execute) {
                $test_db = null;
                $_SESSION["success_message"] = "You have registered, please login";
                redirect("login.php");
        
            } else {
                $test_db = null;
                $_SESSION["error_message"] = "Record has not been submitted";
                // echo '<span class="error">Record has not been submitted!"</span>';
            }
            // ------------------------------------------------------------------- //
        } else {

            // ------ CODE TO UPLOAD IMAGE IF $_FILES["photo"]["size"] ISSET ----- //
            $target_dir    = "uploads/";
            $photo         = $_FILES['photo']['name'];
            $target_file   = $target_dir.basename($photo);
            $uploadOk      = 1;
            $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

            // ------------- CODE TO VALIDATE IF THE IMAGE IS VALID -------------- //
            // 1st CHECK TO SEE IF FILE EXIST ALREADY
            if (file_exists($target_file)) {
                $photoErr[] = "Sorry, file already exists <br>";
                $uploadOk = 0;
            }
            // 2nd CHECK FILE SIZE
            if ($_FILES["photo"]["size"] > 900000) {
                $photoErr[] = "Sorry, your file is too large <br>";
                $uploadOk = 0;
            }
            // 3rd CHECK TO SEE IF FILE FORMAT IS A jpg, jpeg, png, gif
            if ($imageFileType != "jpg" 
                && $imageFileType != "jpeg" 
                && $imageFileType != "png"
                && $imageFileType != "gif"
            ) {
                $photoErr[] = "Sorry, only JPG, JPEG, PNG & GIF files are allowed <br>";
                $uploadOk = 0;
            }
            // ------------------------------------------------------------------- //
            // ?4th STORE THE getimagesize() ARRAY DATA FROM THE $_FILE SUPER GLOBAL
            // $verify_image = getimagesize($_FILES["photo"]["tmp_name"]);
        
            // ?5th CHECK THE STORED getimagesize() ARRAY IS A VALID IMAGE
            // if (!$verify_image) {
            //     $photoErr[] = "File is not an image <br>";
            //     $uploadOk = 0;
            // }
            // ------------------------------------------------------------------- //
            // 5th Check if $uploadOk is set to 0 by an error
            if ($uploadOk == 0) {
                $photoErr[] = "Sorry, your file was not uploaded <br>";
            } else {
                $movImg = move_uploaded_file($_FILES["photo"]["tmp_name"], $target_file);
                if (!$movImg) {
                    $photoErr[] = "Sorry, there was an error uploading your image <br>";
                }
            }
            // ---------- CODE TO INSERT VALIDATED FORM DATA TO DATABASE --------- //
            $database      = new Database("localhost", "root", "root", "cms");
        
            $sql           = "INSERT INTO user_record(name, 
                                                        email, 
                                                        contact_num, 
                                                        username, 
                                                        password, 
                                                        photo)
                                VALUES(:namE, 
                                        :emaiL, 
                                        :contact_nuM, 
                                        :usernamE, 
                                        :passworD, 
                                        :photO)";
        
            $prepare_stmt  = $database->conn()->prepare($sql);
            $prepare_stmt->bindValue(':namE', $name, PDO::PARAM_STR);
            $prepare_stmt->bindValue(':emaiL', $email, PDO::PARAM_STR);
            $prepare_stmt->bindValue(':contact_nuM', $contact_num, PDO::PARAM_STR);
            $prepare_stmt->bindValue(':usernamE', $username, PDO::PARAM_STR);
            $prepare_stmt->bindValue(':passworD', $hashed_password, PDO::PARAM_STR);
            $prepare_stmt->bindValue(':photO', $photo, PDO::PARAM_STR);
            $execute = $prepare_stmt->execute();
        
            if ($execute) {
                $test_db = null;
                $_SESSION["success_message"] = "You have registered, please login";
                redirect("login.php");
        
            } else {
                $test_db = null;
                $_SESSION["error_message"] = "Record has not been submitted";
            }
            // ------------------------------------------------------------------- //
        }
    }
    // --------------------------- TEST CODE -------------------------- //
    // echo "<pre>";
    // print_r($verify_image);
    // echo "</pre>";
    // exit;
    // ---------------------------------------------------------------- //
    // VIEW THE IMAGE DETAILS IN THE $_FILE SUPER GLOBAL
    // echo "<pre>";
    // print_r($_FILES);
    // echo "</pre>";
    // exit;
    // ---------------------------------------------------------------- //
    // echo "<pre>";
    // print_r($photoErr);
    // echo "</pre>";
    // exit;
    // ---------------------------------------------------------------- //
    // echo "<pre>";
    // print_r($formDataErr);
    // echo "</pre>";
    // exit;
    // ---------------------------------------------------------------- //

}

?>

      <!---------------------- OPENING HTML TAGS AND NAV LINKS --------------------->
      <?php 
        $title = "Registratrion Page";
        require_once "includes/unlogged_nav_link.php"; 
        ?>
      <!---------------------- CLOSING HTML TAGS AND NAV LINKS --------------------->

      <div class="reg_form mt-5 mb-5">
      <?php 
        echo errorMessage(); 
        echo successMessage(); 
        ?>
    <br>
        <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>"  class="dbform" method="POST" enctype="multipart/form-data">
          <fieldset>
            <label for="name" class="fieldinput">Name:</label>
            <br>
            <input type="text" id="name" name="name" value="<?php echo $name;?>">
            <span class="error">* <?php echo $nameErr;?></span>
            <br>

            <label for="email" class="fieldinput">email:</label>
            <br>
            <input type="text" id="email" name="email" value="<?php echo $email;?>">
            <span class="error">* <?php echo $emailErr;?></span>
            <br>
            <!---------------------------------------------------------------------->
            <label for="contact_num" class="fieldinput">Number:</label>
            <br>
            <input type="text" id="contact_num" name="contact_num" value="<?php echo $contact_num;?>">
            <span class="error">* <?php echo $contactErr;?></span>
            <br>
            <!---------------------------------------------------------------------->
            <label for="username" class="fieldinput">Username:</label>
            <br>
            <input type="text" id="username" name="username" value="<?php echo $username;?>">
            <span class="error">* <?php echo $usernameErr;?></span>
            <br>
            <!---------------------------------------------------------------------->
            <label for="password" class="fieldinput">Password:</label>
            <br>
            <input type="password" id="password" name="password" value="<?php echo $password;?>">
            <span class="error">* <?php echo $passwordErr;?></span>
            <br>
            <!---------------------------------------------------------------------->
            <label for="confirm_pass" class="fieldinput">Confirm Password:</label>
            <br>
            <input type="password" id="confirm_pass" name="confirm_pass" value="<?php echo $con_password;?>">
            <span class="error">* <?php echo $confpassErr ." &nbsp; ". $passNoMatchErr;?></span>
            <br>
            <br>
            <!---------------------------------------------------------------------->
            <label for="photo" class="fieldinput">Photo:</label>
            <br>
            <input type="file" id="photo" name="photo" value="">
            <br>
            <br>
            <!---------------------------------------------------------------------->
            <input type="submit" name="submit" value="Submit Record:">
            <!---------------------------------------------------------------------->
          </fieldset>
        </form>
      </div>
      <hr>
<!----BEGINNING FOOTER AND BODY SECTION---->
<?php require_once "includes/footer.php"; ?>
<!-----ENDING FOOTER AND BODY SECTION------>
</html> 