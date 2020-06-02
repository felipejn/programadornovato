<?php  

namespace Pronov\Model;

use Pronov\Sql;
use Pronov\Model;
use Pronov\Mailer;

class User extends Model
{

	const SECRET = "Progr_Nov_Secret"; //-> Deve ter 16 caracteres
	const SECRET_IV = "Progr_Nov_Secret";
	const ERROR = "UserError";
	const SUCCESS = "UserSuccess";
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
			User::setError("This login already exists.");
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
			User::setError("Login or password incorrect.");
			
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

			User::setError("Login or password incorrect.");

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

	public static function setError($msg)
	{

		$_SESSION[User::ERROR] = $msg;

	}

	public static function getError()
	{

		$msg = (isset($_SESSION[User::ERROR]) && $_SESSION[User::ERROR]) ? $_SESSION[User::ERROR] : "" ;

		User::clearError();

		return $msg;

	}

	public static function clearError()
	{

		$_SESSION[User::ERROR] = NULL;

	}

	public static function logout()
	{

		$_SESSION[User::SESSION] = NULL;

	}

	public static function setSuccess($msg)
	{

		$_SESSION[User::SUCCESS] = $msg;

	}

	public static function getSuccess()
	{

		$msg = (isset($_SESSION[User::SUCCESS]) && $_SESSION[User::SUCCESS]) ? $_SESSION[User::SUCCESS] : "" ;

		User::clearSuccess();

		return $msg;

	}

	public static function clearSuccess()
	{

		$_SESSION[User::SUCCESS] = NULL;

	}
	
	public function saveSubscriber()
	{

		$sql = new Sql();

		$results = $sql->select("SELECT * FROM tb_subscribers WHERE dessubscriber = :dessubscriber", [
			':dessubscriber'=>$this->getdessubscriber()
		]);
		
		if (count($results) > 0)
		{

			Post::setError("Este email já foi cadastrado.");
			header("Location: /");
			exit;

		} else {

			$sql->query("INSERT INTO tb_subscribers (dessubscriber) VALUES(:dessubscriber)", [
				':dessubscriber'=>$this->getdessubscriber()
			]);

		}

	}

	public static function getForgot($email)
	{

		$sql = new Sql();

		$results = $sql->select("SELECT * FROM tb_users WHERE desemail = :desemail", [
			':desemail'=>$email
		]);

		if (count($results) === 0)
		{
			
			User::setError("Invalid login.");
			header("Location: /admin/login/forgot");
			exit;
		
		} else {

			$data = $results[0];

			$results2 = $sql->select("CALL sp_set_recovery(:iduser)", [
				':iduser'=>$data['iduser']
			]);

			if (count($results2) === 0)
			{

				User::setError("It is not possible to recover your password. Database stored procedure error.");
				header("Location: /admin/login/forgot");
				exit;

			} else {

				$_SESSION[User::REC_EMAIL] = $email;

				$recoveryData = $results2[0];

				$code = base64_encode(openssl_encrypt($recoveryData['idrecovery'], "AES-128-CBC", User::SECRET, 0, User::SECRET_IV));

				$link = "http://www.programadornovato.pt/admin/login/reset?code=$code";

				$mailer = new Mailer($data['desemail'], $data['desname'], "Password Reset", "reset-password", [
					'name'=>$data['desname'],
					'link'=>$link
				]);

			}

		}

	}

	public static function getIdRecoveryByCode($code)
	{

		$idrecovery = openssl_decrypt(base64_decode($code), "AES-128-CBC", User::SECRET, 0, User::SECRET_IV);

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
			User::setError("It was not possible to reset your password.");
			header("Location: /admin/login");
			exit;

		} else {
			
			$sql->query("UPDATE tb_pswdrecovery 
				SET dtrecovery = CURRENT_TIMESTAMP
				WHERE idrecovery = :idrecovery", [
				'idrecovery'=>$idrecovery
			]);
			
			return $results[0];

		}

	}

}

?>