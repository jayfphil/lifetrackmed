<?php declare(strict_types = 1);

class DBH{
	
	private $connection;
	private $servername;
	private $username;
	private $password;
	private $dbname;

	function __construct()
	{	
		$this->connect_db();
	}

	public function connect_db(){

		$this->servername = "localhost";
		$this->username = "root";
		$this->password = "";
		$this->dbname = "pepperstone";
		$this->connection = mysqli_connect($this->servername, $this->username, $this->password, $this->dbname);
		if(mysqli_connect_error()){
			die("Database Connection Failed" . mysqli_connect_error() . mysqli_connect_errno());
		}
	}

	public function createupdate($request){

		$response = array();
		foreach (array($request[0],$request[1]) as $key => $value) {

			if(!$this->checkaccountexist($value)) {

				$stmt = $this->connection->prepare("INSERT INTO `account` (account_id, amount, currency, comment) VALUES(?,?,?,?)");
				$stmt->bind_param("iiss", $value,$request[2],$request[3],$request[4]);
				$stmt->execute();
				$stmt->close();
			}

			if($this->getcurrency(array($request[1],$request[3])) && $request[4]="Cash Transfer") {

				if($value==$request[1]) {
					$stmt = $this->connection->prepare("UPDATE `account` SET `amount`=amount+?, `comment`=? WHERE account_id=?");
					$stmt->bind_param("isi", $request[2],$request[4],$value);
				} else {
					$stmt = $this->connection->prepare("UPDATE `account` SET `amount`=amount-?, `comment`=? WHERE account_id=?");
					$stmt->bind_param("isi", $request[2],$request[4],$value);
				}

				$stmt->execute();
				$stmt->close();
				$request[5]="Successful";
                $request[6]="";

			} elseif($request[4]="Cash Transfer") {

				$stmt = $this->connection->prepare("UPDATE `account` SET `amount`=?, `comment`=? WHERE account_id=?");
				$stmt->bind_param("isi", $request[2],$request[4],$value);
				$stmt->execute();
				$stmt->close();
				$request[5]="Successful";
                $request[6]="";

			}else {
				$request[5]="Error";
                $request[6]="Invalid currency in account ".$request[1];
			}

			$response[]=$request;
		}

		
		return $response;
		
	}

	public function getcurrency($request){
		$exists=0;
		$stmt = $this->connection->prepare("SELECT COUNT(`id`) FROM `account` WHERE `account_id`=? AND `currency`=?");
		$stmt->bind_param("is", $request[0],$request[1]);
		$stmt->execute();
		$stmt->bind_result($exists);
		$stmt->fetch();

		if($exists>0) {
			return true;
		} else {
			return false;
		}
	}

	public function checkaccountexist($request){
		
		$exists=0;
		$stmt = $this->connection->prepare("SELECT COUNT(`id`) FROM `account` WHERE `account_id`=?");
		$stmt->bind_param("i", $request);
		$stmt->execute();
		$stmt->bind_result($exists);
		$stmt->fetch();

		if($exists>0) {
			return true;
		} else {
			return false;
		}
	}

	// public function sanitize($var){
	// 	$return = mysqli_real_escape_string($this->connection, $var);
	// 	return $return;
	// }

}

?>