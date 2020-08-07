<?php  

namespace Pronov\Model;

use Pronov\Sql;
use Pronov\Model;
use Pronov\Mailer;
use Pronov\Message;

class User extends Model
{

	const SECRET = "Progr_Nov_Secret"; //-> Deve ter 16 caracteres
	const SECRET_IV = "Progr_Nov_Secret";
	const SESSION = "User";
	const REC_EMAIL = "Recovery Email";

	// List all users
	public static function listAll()
	{

		$sql = new Sql();

		return $sql->select("SELECT * FROM tb_users ORDER BY iduser");

	}

	// Create new user
	public function createUser()
	{

		$sql = new Sql();

		$check = $sql->select("SELECT * FROM tb_users WHERE desemail = :desemail", [
			':desemail'=>$this->getdesemail()
		]);

		if (count($check) > 0)
		{
			Message::setError("This login already exists.");
			header("Location: /admin/users/create");
			exit;
		
		} else {

			$results = $sql->select("CALL sp_user_new(:desname, :desemail, :despassword)", [
				':desname'=>$this->getdesname(),
				':desemail'=>$this->getdesemail(),
				':despassword'=>User::getpasswordhash($this->getdespassword())
			]);

			$this->setData($results[0]);
		
		}

	}

	// Update user data
	public function update()
	{

		$sql = new Sql();

		$sql->query("UPDATE tb_users SET desname = :desname, desemail = :desemail, despassword = :despassword WHERE iduser = :iduser", [
			'iduser'=>$this->getiduser(),
			'desname'=>$this->getdesname(),
			'desemail'=>$this->getdesemail(),
			'despassword'=>$this->getdespassword()
		]);

	}

	// Get user data by iduser
	public function get($iduser)
	{

		$sql = new Sql();

		$results = $sql->select("SELECT * FROM tb_users WHERE iduser = :iduser", [
			':iduser'=>$iduser
		]);

		$this->setData($results[0]);

	}

	// Get id from session
	public static function getIdFromSession()
	{

		return $_SESSION[User::SESSION]['iduser'];		

	}

	// Delete user
	public function delete()
	{

		$sql = new Sql();

		$sql->query("DELETE FROM tb_users WHERE iduser = :iduser", [
			':iduser'=>$this->getiduser()
		]);

	}

	// Create hash from input password
	public static function getPasswordHash($password)
	{

		return password_hash($password, PASSWORD_DEFAULT, [
		"cost"=>12
		]);

	}

	// Login admin area
	public static function login($login, $password)
	{

		$sql = new Sql();

		$results = $sql->select("SELECT * FROM tb_users WHERE desemail = :desemail", [
			':desemail'=>$login
		]);

		if (count($results) === 0)
		{
			Message::setError("Login or password incorrect.");
			
			header("Location: /admin/login");
			
			exit;
		}

		$data = $results[0];

		if (password_verify($password, $data['despassword']) === true)
		{

			$user = new User();

			$user->setData($data);

			$_SESSION[User::SESSION] = $user->getValues();

			return $user;

		} else {

			Message::setError("Login or password incorrect.");

			header("Location: /admin/login");
			
			exit;

		}

	}

	// Verify if user is logged
	public static function verifyLogin():bool
	{

		if (
			!isset($_SESSION[User::SESSION])
			||
			!$_SESSION[User::SESSION]
			||
			!(int)$_SESSION[User::SESSION]['iduser'] > 0
		)
		{
		
			return false;
		
		} else {

			return true;

		} 

	}

	// Send user to login page if not logged
	public static function checkUser()
	{

		if (!User::verifyLogin())
		{

			header("Location: /admin/login");
			exit;

		}

	}

	// Logout from system
	public static function logout()
	{

		$_SESSION[User::SESSION] = NULL;

	}

	// Generate code from Id
	public static function codeFromId($id)
	{

		return base64_encode(openssl_encrypt($id, "AES-128-CBC", User::SECRET, 0, User::SECRET_IV));

	}

	// Get email from db and send email to reset password
	public static function getForgot($email)
	{

		$sql = new Sql();

		$results = $sql->select("SELECT * FROM tb_users WHERE desemail = :desemail", [
			':desemail'=>$email
		]);

		if (count($results) === 0)
		{
			
			Message::setError("Invalid login.");
			header("Location: /admin/login/forgot");
			exit;
		
		} else {

			$data = $results[0];

			$results2 = $sql->select("CALL sp_set_recovery(:iduser)", [
				':iduser'=>$data['iduser']
			]);

			if (count($results2) === 0)
			{

				Message::setError("It is not possible to recover your password. Database procedure error.");
				header("Location: /admin/login/forgot");
				exit;

			} else {

				$_SESSION[User::REC_EMAIL] = $email;

				$recoveryData = $results2[0];

				$code = User::codeFromId($recoveryData['idrecovery']);

				$link = "http://www.programadornovato.pt/admin/login/reset?code=$code";

				$mailer = new Mailer($data['desemail'], $data['desname'], "Password Reset", "reset-password", [
					'name'=>$data['desname'],
					'link'=>$link
				]);

			}

		}

	}

	// Get Id From Code
	public static function getIdFromCode($code)
	{

		return openssl_decrypt(base64_decode($code), "AES-128-CBC", User::SECRET, 0, User::SECRET_IV);

	}

	// Check recovery code 
	public static function getIdRecoveryByCode($code)
	{

		$idrecovery = User::getIdFromCode($code);

		$sql = new Sql();

		$results = $sql->select("SELECT *
			FROM tb_pswdrecovery a
			INNER JOIN tb_users b USING(iduser)
			WHERE a.idrecovery = :idrecovery AND
			a.dtrecovery IS NULL AND 
			DATE_ADD(a.dtregister, INTERVAL 1 HOUR) >= NOW()", array(
			':idrecovery'=>$idrecovery
		));

		if (count($results) === 0)
		{
					
			Message::setError("This code has been already used or it is expired.");
			header("Location: /admin/login");
			exit;

		} 

		return $results[0];

	}

	// Set recovery time to disable code
	public static function setRecoveryTime($idrecovery)
	{

		$sql = new Sql();

		$sql->query("UPDATE tb_pswdrecovery 
				SET dtrecovery = CURRENT_TIMESTAMP
				WHERE idrecovery = :idrecovery", [
				'idrecovery'=>$idrecovery
			]);

	}

}

?>