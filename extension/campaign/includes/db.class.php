<?php
include_once './config.php';

class Db{

	public function connect() {
		// Create connection
		$conn = mysqli_connect(DB_SERVER, DB_USER, DB_PASS, DB_NAME);
		// Check connection
		if (!$conn) {
			die("Connection failed: " . mysqli_connect_error());
		}
		return $conn;
	}

	public function select() {
		try {
			$sql='SELECT * FROM `bal_email_builder`';
			$conn=$this->connect();
			$result = mysqli_query($conn, $sql);
			$newArr=array();

			if (mysqli_num_rows($result) > 0) {
				// output data of each row
				while($row = mysqli_fetch_assoc($result)) {
					$newArr[]=$row;
				}
				mysqli_close($conn);
			} else {
				return 0;
			}
			return $newArr;
		} catch (Exception $e) {
		  	file_put_contents('error.txt', "\xEF\xBB\xBF".$e);
				return -1;
		}


	}

	public function insert($name,$content,$UserId) {

    try {
      $conn=$this->connect();
			$stmt = $conn->prepare("INSERT INTO `bal_email_builder` (`name`,`content`,`UserId`) VALUES (?, ?, ?)");
			$stmt->bind_param("sss", $name, $content,$UserId);

	  	$stmt->execute();
			$stmt->close();
			$conn->close();
      return true;

    } catch (Exception $e) {
			file_put_contents('error.txt', "\xEF\xBB\xBF".$e);
      return false;
    }


  }

	public function loginCheck($login,$pass) {
			try {
				$conn=$this->connect();
				$stmt = $conn->prepare("SELECT `Id` FROM `bal_users` WHERE `Login`=? and `Password`=? and isuser=1");

			/* bind parameters for markers */
					$stmt->bind_param("ss",$login,$pass);

					/* execute query */
					$stmt->execute();

					/* bind result variables */
					$stmt->bind_result($UserId);

					/* fetch value */
					$stmt->fetch();
					/* close statement */
					$stmt->close();
					$conn->close();
					return $UserId;
			} catch (Exception $e) {
					file_put_contents('error.txt', "\xEF\xBB\xBF".$e);
					return -3;
			}
		}

	public function getUserName($Id) {
		try {
			$conn=$this->connect();
			$stmt = $conn->prepare("SELECT `Name` FROM `bal_users` WHERE `Id`=?");

		/* bind parameters for markers */
				$stmt->bind_param("s",$Id);

				/* execute query */
				$stmt->execute();

				/* bind result variables */
				$stmt->bind_result($Name);

				/* fetch value */
				$stmt->fetch();
				/* close statement */
				$stmt->close();
				$conn->close();
				return $Name;
		} catch (Exception $e) {
				file_put_contents('error.txt', "\xEF\xBB\xBF".$e);
				return '0';
		}
		}
}

?>
