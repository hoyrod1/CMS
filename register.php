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


if (isset($_POST['submit'])) {

    if (!empty($_POST['name'])
        && !empty($_POST['email']) 
        && !empty($_POST['contact_num']) 
        && !empty($_POST['username']) 
        && !empty($_POST['password'])
    ) { 


        $name            = testInput($_POST['name']);
        $email           = testInput($_POST['email']);
        $contact_num     = testInput($_POST['contact_num']);
        $username        = testInput($_POST['username']);
        $password        = testInput($_POST['password']);
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        // ADD SECURITY FOR UPLOADED IMAGES
        $target_dir      = "uploads/";
        $photo           = $_FILES['photo']['name'];
        $target_file     = $target_dir.basename($photo);
        $uploadOk        = 1;
        $imageFileType   = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

        $test_db = new Database("localhost", "root", "root", "cms");

        $sql = "INSERT INTO user_record(
					name, 
					email, 
					contact_num, 
					username, 
					password, 
					photo)
					VALUES(:namE, :emaiL, :contact_nuM, :usernamE, :passworD, :photO)";

        $prepare_stmt = $test_db->conn()->prepare($sql);
        $prepare_stmt->bindValue(':namE', $name);
        $prepare_stmt->bindValue(':emaiL', $email);
        $prepare_stmt->bindValue(':contact_nuM', $contact_num);
        $prepare_stmt->bindValue(':usernamE', $username);
        $prepare_stmt->bindValue(':passworD', $hashed_password);
        $prepare_stmt->bindValue(':photO', $photo);
        $execute = $prepare_stmt->execute();
        move_uploaded_file($_FILES["photo"]["tmp_name"], $target_file);

        if ($execute) {
            $test_db = null;
            $_SESSION["success_message"] = 'You have registered, please login.';
            redirect('login.php');

        } else {
            echo '<span class="error">Record has not been submitted!"</span>' ;
        }
    } else {
        echo '<span class="error">Please enter all fields!</span>';
    }
}

?>

      <!---------------------- OPENING HTML TAGS AND NAV LINKS --------------------->
      <?php 
        $title = "Registratrion Page";
        require_once "includes/unlogged_nav_link.php"; 
        ?>
      <!---------------------- CLOSING HTML TAGS AND NAV LINKS --------------------->

      <div class="reg_form mt-5 mb-5">
        <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>"  class="dbform" method="POST" enctype="multipart/form-data">
          <fieldset>
            <span class="fieldinput">Name:</span>
            <br>
            <input type="text" name="name" value="
            <?php if (isset($name)) {
                echo $name;
            } ?>">
            <br>
            <span class="fieldinput">Email:</span>
            <br>
            <input type="text" name="email" value="
            <?php if (isset($email)) {
                echo $email;
            } ?>">
            <br>
            <span class="fieldinput">Contact Number:</span>
            <br>
            <input type="text" name="contact_num" value="
            <?php if (isset($contact_num)) {
                echo $contact_num;
            } ?>">
            <br>
            <span class="fieldinput">User Name:</span>
            <br>
            <input type="text" name="username" value="
            <?php if (isset($username)) {
                echo $username;
            } ?>">
            <br>
            <span class="fieldinput">Password:</span>
            <br>
            <input type="password" name="password" value="
            <?php if (isset($password)) {
                echo $password;
            } ?>">
            <br>
            <br>
            <span class="fieldinput">Add Photo:</span>
            <br>
            <input type="file" name="photo" value="
            <?php if (isset($photo)) {
                echo $photo;
            } ?>">
            <br>
            <br>
            <input type="submit" name="submit" value="Submit Record:">
          </fieldset>
        </form>
      </div>
      <hr>
<!----BEGINNING FOOTER AND BODY SECTION---->
<?php require_once "includes/footer.php"; ?>
<!-----ENDING FOOTER AND BODY SECTION------>
</html> 