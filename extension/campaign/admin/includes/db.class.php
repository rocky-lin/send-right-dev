<?php
include_once './../config.php';

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


	public function loginCheck($login,$pass) {
			try {
				$conn=$this->connect();
				$stmt = $conn->prepare("SELECT `Id` FROM `bal_users` WHERE `Login`=? and `Password`=? and isadmin=1");

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

	public function getTemplates() {
			try {
				$sql='SELECT * FROM `v_templates`';
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

	public function deleteTemplate($TemplateId) {

	    try {
	      $conn=$this->connect();
				$stmt = $conn->prepare("DELETE FROM `bal_email_builder` WHERE ID=?");
				$stmt->bind_param("i", $TemplateId);

		  	$stmt->execute();
				$stmt->close();
				$conn->close();
	      return true;

	    } catch (Exception $e) {
				file_put_contents('error.txt', "\xEF\xBB\xBF".$e);
	      return false;
	    }
  }

	public function getTemplatesById($templateId) {
			try {
				$sql='SELECT * FROM `v_templates` where TemplateId='.$templateId;
				$conn=$this->connect();
				$result = mysqli_query($conn, $sql);
				$newArr=array();

				if (mysqli_num_rows($result) > 0) {
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

	public function getUsers() {
			try {
				$sql='SELECT * FROM `v_users`';
				$conn=$this->connect();
				$result = mysqli_query($conn, $sql);
				$newArr=array();

				if (mysqli_num_rows($result) > 0) {
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

	public function deleteUser($id) {

	    try {
	      $conn=$this->connect();
				$stmt = $conn->prepare("DELETE FROM `bal_users` WHERE ID=?");
				$stmt->bind_param("i", $id);

		  	$stmt->execute();
				$stmt->close();
				$conn->close();
	      return true;

	    } catch (Exception $e) {
				file_put_contents('error.txt', "\xEF\xBB\xBF".$e);
	      return false;
	    }
  }

	public function insertUser($Login,$Password,$Name,$Email,$isAdmin,$isUser) {
			try {
				$conn=$this->connect();
				$stmt = $conn->prepare("INSERT INTO `bal_users`  (Login,Password,Name,Email,isAdmin,isUser) Values (?,?,?,?,?,?)");
				$stmt->bind_param("ssssss", $Login,$Password,$Name,$Email,$isAdmin,$isUser);

				$stmt->execute();
				$stmt->close();
				$conn->close();
				return true;

			} catch (Exception $e) {
				file_put_contents('error.txt', "\xEF\xBB\xBF".$e);
				return false;
			}
	}

	public function updateUser($Login,$Password,$Name,$Email,$isAdmin,$isUser,$Id) {
			try {
				$conn=$this->connect();
				$stmt = $conn->prepare("UPDATE `bal_users` SET  Login=?,Password=?,Name=?,Email=?,isAdmin=?,isUser=? WHERE Id=?");
				$stmt->bind_param("sssssss", $Login,$Password,$Name,$Email,$isAdmin,$isUser,$Id);

				$stmt->execute();
				$stmt->close();
				$conn->close();
				return true;

			} catch (Exception $e) {
				file_put_contents('error.txt', "\xEF\xBB\xBF".$e);
				return false;
			}
	}


	public function checkLogin($login) {
		try {
			$conn=$this->connect();
			$stmt = $conn->prepare("SELECT count(*) FROM `bal_users` WHERE `Login`=?");

		/* bind parameters for markers */
				$stmt->bind_param("s",$login);

				/* execute query */
				$stmt->execute();

				/* bind result variables */
				$stmt->bind_result($data);

				/* fetch value */
				$stmt->fetch();
				/* close statement */
				$stmt->close();
				$conn->close();
				return $data;
		} catch (Exception $e) {
				file_put_contents('error.txt', "\xEF\xBB\xBF".$e);
				return '-1';
		 }
	}

	public function checkLoginById($login,$id) {
		try {
			$conn=$this->connect();
			$stmt = $conn->prepare("SELECT count(*) FROM `bal_users` WHERE `Login`=? and `Id`<>?");

		/* bind parameters for markers */
				$stmt->bind_param("ss",$login,$id);

				/* execute query */
				$stmt->execute();

				/* bind result variables */
				$stmt->bind_result($data);

				/* fetch value */
				$stmt->fetch();
				/* close statement */
				$stmt->close();
				$conn->close();
				return $data;
		} catch (Exception $e) {
				file_put_contents('error.txt', "\xEF\xBB\xBF".$e);
				return '-1';
		 }
	}


	public function getUserInfoById($id) {
			try {
				$sql='SELECT * FROM `bal_users` WHERE id='.$id;
				$conn=$this->connect();
				$result = mysqli_query($conn, $sql);
				$newArr=array();

				if (mysqli_num_rows($result) > 0) {
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


}

?>
