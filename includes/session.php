<?php session_start();

function error_message()
{
	if (isset($_SESSION['error_message'])) {
		
		$error_message = "<div style=\"width: 535px;margin: auto;\" align=\"center\" class=\"alert alert-danger\">";
		$error_message .= htmlentities($_SESSION['error_message']);
		$error_message .= "</div>";

		$_SESSION['error_message'] = null;
		return $error_message;
	}
}

function success_message()
{
	if (isset($_SESSION["success_message"])) {
		
		$success_message = "<div style=\"width: 535px;margin: auto;\" align=\"center\" class=\"alert alert-success\">";
		$success_message .= htmlentities($_SESSION["success_message"]);
		$success_message .= "</div>";

		$_SESSION["success_message"] = null;
		return $success_message;
	}
}

 ?>