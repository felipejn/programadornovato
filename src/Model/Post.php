<?php  

namespace Pronov\Model;

use Pronov\Model;
use Pronov\Sql;

class Post extends Model
{

	const ERROR = "PostError";
	const SUCCESS = "PostSuccess";

	public static function listAll()
	{

		$sql = new Sql();

		return $sql->select("SELECT * FROM tb_posts a 
			INNER JOIN tb_users b
			USING(iduser)
			ORDER BY idpost
		");

	}

	public static function setError($msg)
	{

		$_SESSION[Post::ERROR] = $msg;

	}

	public static function getError()
	{

		$msg = (isset($_SESSION[Post::ERROR]) && $_SESSION[Post::ERROR]) ? $_SESSION[Post::ERROR] : "" ;

		Post::clearError();

		return $msg;

	}

	public static function clearError()
	{

		$_SESSION[Post::ERROR] = NULL;

	}

	public static function setSuccess($msg)
	{

		$_SESSION[Post::SUCCESS] = $msg;

	}

	public static function getSuccess()
	{

		$msg = (isset($_SESSION[Post::SUCCESS]) && $_SESSION[Post::SUCCESS]) ? $_SESSION[Post::SUCCESS] : "" ;

		Post::clearSuccess();

		return $msg;

	}

	public static function clearSuccess()
	{

		$_SESSION[Post::SUCCESS] = NULL;

	}

}

?>