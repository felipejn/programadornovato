<?php  

namespace Pronov\Model;

use Pronov\Sql;
use Pronov\Model;

class Tag extends Model
{

	const ERROR = "TagError";
	const SUCCESS = "TagSuccess";
	
	public static function listAll()
	{

		$sql = new Sql();

		return $sql->select("SELECT * FROM tb_tags ORDER BY destag");

	}

	public function createTag()
	{

		$sql = new Sql();

		$check = $sql->select("SELECT * FROM tb_tags WHERE destag = :destag", [
			':destag'=>$this->getdestag()
		]);

		if (count($check) > 0)
		{
			Tag::setError("This tag name already exists.");
			header("Location: /admin/tags/create");
			exit;
		
		} else {

			$sql->query("INSERT INTO tb_tags (idtag, destag) VALUES(null, :destag)", [
				':destag'=>$this->getdestag()
			]);
		
		}

	}

	public function get($idtag)
	{

		$sql = new Sql();

		$results = $sql->select("SELECT * FROM tb_tags WHERE idtag = :idtag", [
			':idtag'=>$idtag
		]);

		$this->setData($results[0]);

	}

	public function delete()
	{

		$sql = new Sql();

		$sql->query("DELETE FROM tb_tags WHERE idtag = :idtag", [
			':idtag'=>$this->getidtag()
		]);

	}

	public static function setError($msg)
	{

		$_SESSION[Tag::ERROR] = $msg;

	}

	public static function getError()
	{

		$msg = (isset($_SESSION[Tag::ERROR]) && $_SESSION[Tag::ERROR]) ? $_SESSION[Tag::ERROR] : "" ;

		Tag::clearError();

		return $msg;

	}

	public static function clearError()
	{

		$_SESSION[Tag::ERROR] = NULL;

	}

	public static function setSuccess($msg)
	{

		$_SESSION[Tag::SUCCESS] = $msg;

	}

	public static function getSuccess()
	{

		$msg = (isset($_SESSION[Tag::SUCCESS]) && $_SESSION[Tag::SUCCESS]) ? $_SESSION[Tag::SUCCESS] : "" ;

		Tag::clearSuccess();

		return $msg;

	}

	public static function clearSuccess()
	{

		$_SESSION[Tag::SUCCESS] = NULL;

	}

	public function update()
	{

		$sql = new Sql();

		$sql->query("UPDATE tb_tags SET destag = :destag WHERE idtag = :idtag", [
			'idtag'=>$this->getidtag(),
			'destag'=>$this->getdestag()
		]);

	}

}

?>