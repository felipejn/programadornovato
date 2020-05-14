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
			ORDER BY idpost DESC
		");

	}

	public function createPost()
	{

		$sql = new Sql();

		$check = $sql->select("SELECT * FROM tb_tags WHERE desurl = :desurl", [
			':desurl'=>$this->getdesurl()
		]);

		if (count($check) > 0)
		{
			Tag::setError("This url has already been used.");
			header("Location: /admin/posts/create");
			exit;
		
		} else {

			$results = $sql->select("CALL sp_post_new(:iduser, :desurl, :deslink, :desimage, :destittle, :destext, :despub)", [
				':iduser'=>User::getIdFromSession(),
				':desurl'=>$this->getdesurl(),
				':deslink'=>$this->getdeslink(),
				':desimage'=>$this->getdesimage(),
				':destittle'=>$this->getdestittle(),
				':destext'=>$this->getdestext(),
				':despub'=>$this->getdespub()
			]);

			$this->setData($results[0]);

		}

	}

	public function setNewTags($data)
	{

		foreach ($data as $key => $value) {
			if (substr($key, 0, 5) == "idtag")
			{
				$idtag = substr($key, 5);

				$sql = new Sql();

				$sql->query("INSERT INTO tb_poststags (idpost, idtag) VALUES(:idpost, :idtag)", [
					':idpost'=>$this->getidpost(),
					':idtag'=>$idtag
				]);
			}	
		}

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