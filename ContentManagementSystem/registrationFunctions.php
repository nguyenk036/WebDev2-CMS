<?php
	
	class RegistrationFunctions{


		//Creates new user registration
		function Register($name, $email, $username, $password){
			try{
				$db = DB();

				$query = $db->prepare("INSERT INTO users (Username, Password, Name, Email) VALUES (:username, :password, :name, :email)")
				$query->bindParam("name", $name, PDO::PARAM_STR);
				$query->bindParam("email", $email, PDO::PARAM_STR);
				$query->bindParam("username", $username, PDO::PARAM_STR);
	            $enc_password = hash('sha256', $password);
	            $query->bindParam("password", $enc_password, PDO::PARAM_STR);
	            $query->execute();

	            return $db->lastInsertId();
			}
			catch(PDOException $e){
				exit($e->getMessage());
			}
		}

		//Check for username validity and availability
		function isUsername($username){
			try{
				$db = DB();
				$query = $db->prepare("SELECT userID FROM users WHERE username=:username");
	            $query->bindParam("username", $username, PDO::PARAM_STR);
	            $query->execute();

	            if ($query->rowCount() > 0) {
	                return true;
	            } else {
	                return false;
            	}
			}
			catch(PDOException $e){
				exit($e->getMessage());
            }
		}

		//Check for email validity and availability
		function isEmail($email){
			try {
	            $db = DB();
	            $query = $db->prepare("SELECT userID FROM users WHERE email=:email");
	            $query->bindParam("email", $email, PDO::PARAM_STR);
	            $query->execute();

	            if ($query->rowCount() > 0) {
	                return true;
	            } else {
	                return false;
	            }
	        } 
	        catch (PDOException $e) {
	            exit($e->getMessage());
	        }
		}

		//Get user logon information using email or username
		function Login($username, $password){
			try{
				$db = DB();
				$query = $db->prepare("SELECT userID FROM users WHERE (username = :username OR email = :username) AND password = :password");
				$query->bindParam("username", $username, PDO::PARAM_STR);
				$enc_password = hash('sha256', $password);
				$query->bindParam("password", $enc_password, PDO::PARAM_STR);
				$query->execute();

				if($query->rowCount() > 0){
					$result = $query->fetch(PDO::FETCH_OBJ);
					return $result->userID;
				}
				else{
					return false;
				}
			}
			catch(PDOException $e){
				exit($e->getMessage());
			}
		}

		//Obtain user details based off user ID
		function UserDetails($userID){
			try {
	            $db = DB();
	            $query = $db->prepare("SELECT userID, name, username, email FROM users WHERE userID = :userID");
	            $query->bindParam("userID", $userID, PDO::PARAM_STR);
	            $query->execute();
	            if ($query->rowCount() > 0) {
	                return $query->fetch(PDO::FETCH_OBJ);
	            }
	        } 
	        catch (PDOException $e) {
	            exit($e->getMessage());
	        }
		}
	}

?>
