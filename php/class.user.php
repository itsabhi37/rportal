<?php

require_once('dbconfig.php');

class USER
{	

	private $conn;
	public function __construct()
	{
		$database = new Database();
		$db = $database->dbConnection();
		$this->conn = $db;
    }
	
	public function runQuery($sql)
	{
		$stmt = $this->conn->prepare($sql);
		return $stmt;
	}
	
	public function register($uname,$umail,$upass)
	{
		try
		{
			$new_password = password_hash($upass, PASSWORD_DEFAULT);
			
			$stmt = $this->conn->prepare("INSERT INTO users(user_name,user_email,user_pass) 
		                                               VALUES(:uname, :umail, :upass)");
												  
			$stmt->bindparam(":uname", $uname);
			$stmt->bindparam(":umail", $umail);
			$stmt->bindparam(":upass", $new_password);										  
				
			$stmt->execute();	
			
			return $stmt;	
		}
		catch(PDOException $e)
		{
			echo $e->getMessage();
		}				
	}
	
	
	public function doLogin($uname,$upass)
	{
		try
		{
			$cupass=sha1($upass);
			$stmt = $this->conn->prepare("SELECT userid, password FROM applicantlogin WHERE BINARY userid=:uname AND BINARY password=:upass ");
			$stmt->execute(array(':uname'=>$uname, ':upass'=>$cupass));
			$userRow=$stmt->fetch(PDO::FETCH_ASSOC);		
			
				if($stmt->rowCount() == 1)
				{
					$_SESSION['applicantid'] = $userRow['userid'];
					return true;
				}		
		}
		catch(PDOException $e)
		{
			echo $e->getMessage();
		}
	}
	
	public function is_loggedin()
	{
		if(isset($_SESSION['applicantid']))
		{
			return true;
		}
	}
	
	public function redirect($url)
	{
		header("Location: $url");
	}
	public function doLogout()
	{
		session_destroy();
		unset($_SESSION['applicantid']);
		return true;
	}
}
?>