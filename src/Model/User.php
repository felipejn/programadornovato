<?php  

namespace Pronov\Model;

use Pronov\Sql;
use Pronov\Model;

class User extends Model
{

	const SECRET = "HcodePhp7_Secret"; //-> Deve ter 16 caracteres
	const SECRET_IV = "HcodePhp7_Secret";
	const ERROR = "UserError";
	const SUCCESS = "UserSuccess";
	const SESSION = "User";

	public static function listAll()
	{

		$sql = new Sql();

		return $sql->select("SELECT * FROM tb_users ORDER BY iduser");

	}

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

	public function get($iduser)
	{

		$sql = new Sql();

		$results = $sql->select("SELECT * FROM tb_users WHERE iduser = :iduser", [
			':iduser'=>$iduser
		]);

		$this->setData($results[0]);

	}

	public function delete()
	{

		$sql = new Sql();

		$sql->query("DELETE FROM tb_users WHERE iduser = :iduser", [
			':iduser'=>$this->getiduser()
		]);

	}

	public static function getPasswordHash($password)
	{

		return password_hash($password, PASSWORD_DEFAULT, [
		"cost"=>12
		]);

	}

	public static function login($login, $password)
	{

		$sql = new Sql();

		$results = $sql->select("SELECT * FROM tb_users WHERE desemail = :desemail", [
			':desemail'=>$login
		]);

		if (count($results) === 0)
		{
			User::setError("Login name or password incorrect.");
			
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

			User::setError("Login name or password incorrect.");

			header("Location: /admin/login");
			
			exit;

		}

	}

	public static function verifyLogin()
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

}

?>