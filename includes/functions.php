<?php require_once("includes/db_conn.php"); 

function test_input($data) 
{
    $data = trim($data);
    $data = stripcslashes($data);
    $data = htmlentities($data, ENT_QUOTES, 'UTF-8');
    $data = htmlspecialchars($data);
    return $data;
}

function redirect($new_url)
{
    header("location:".$new_url);
    exit;
}

function username_exist($username)
{
    $connect =new Database("localhost", "root", "root", "API_ToDo_List");

    $sql  = 'SELECT username FROM user_record WHERE username = :userName';
    $stmt = $connect->conn()->prepare($sql);
    $stmt->bindValue(':userName', $username);
    $stmt->execute();

    $results = $stmt->rowcount();
    if ($results == 1) {
        return true;
    } else {
        return false;
    }
}

function login_attempt($username, $password)
{
    $connect      =new Database("localhost", "root", "root", "API_ToDo_List");

    echo "Username: " . $username . " Password " . $password;
    $sql_login = 'SELECT * FROM user_record WHERE username = :uSernAme AND password = :pAsswOrd LIMIT 1';
    $pre_login = $connect->conn()->prepare($sql_login);
    $pre_login->bindValue(':uSernAme', $username);    
    $pre_login->bindValue(':pAsswOrd', $password);
    $pre_login->execute();

    $execute_results  = $pre_login->rowcount();
    if ($execute_results == 1) {
        //echo "<div align=\"center\">It Works!</div>";
        return $user_account = $pre_login->fetch();
    } else {
        return null;
        //echo "<div align=\"center\">IIt Doesn't Work!<?div>";
    }
}

function confirm_login()
{
    if (isset($_SESSION['user_name'])) {
        return true;
    } else {
        $_SESSION['error_message'] = 'Please Login!';
        redirect('login.php');
    }
}

function dashboard_count ($table) {
    $conn       = new Database("localhost", "root", "root", "API_ToDo_List");
    $sql        = "SELECT COUNT(*) FROM $table";
    $stmt_count = $conn->conn()->query($sql);
    $execute    = $stmt_count->fetch();
    $row_count  = array_shift($execute);
    echo $row_count;
}

function approved_comment_count ($table, $post_id) {
    $conn       = new Database("localhost", "root", "root", "API_ToDo_List");
    $sql        = "SELECT COUNT(*) FROM 
		               $table WHERE comment_status = 'ON' 
									 AND post_id = $post_id";
    $stmt_count = $conn->conn()->query($sql);
    $execute    = $stmt_count->fetch();
    $row_count  = array_shift($execute);
    echo $row_count;
}

function disapproved_comment_count ($table, $post_id) {
    $conn       = new Database("localhost", "root", "root", "API_ToDo_List");
    $sql        = "SELECT COUNT(*) FROM $table 
		               WHERE comment_status = 'off' 
									 AND post_id = $post_id";
    $stmt_count = $conn->conn()->query($sql);
    $execute    = $stmt_count->fetch();
    $row_count  = array_shift($execute);
    echo $row_count;
}

