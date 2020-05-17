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

	public function get($idpost)
	{

		$sql = new Sql();

		$results = $sql->select("SELECT * FROM tb_posts WHERE idpost = :idpost", [
			':idpost'=>$idpost
		]);

		$this->setData($results[0]);

	}

	public function createPost()
	{

		$sql = new Sql();

		$check = $sql->select("SELECT * FROM tb_posts WHERE desurl = :desurl", [
			':desurl'=>$this->getdesurl()
		]);

		if (count($check) > 0)
		{
			Post::setError("This url has already been used.");
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

	public function setTags()
	{

		foreach ($this->getvalues() as $key => $value) {
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

	public function getTags()
	{

		$sql = new Sql();

		$usedtags = $sql->select("SELECT * FROM tb_poststags WHERE idpost = :idpost", [
			':idpost'=>$this->getidpost()
		]);

		$alltags = Tag::listAll();

		for ($i=0; $i <	count($alltags); $i++) { 
			for ($j=0; $j < count($usedtags); $j++) { 
				if ($alltags[$i]['idtag'] === $usedtags[$j]['idtag'])
				{
					$alltags[$i]['desstatus'] = 1;
				} 
			} 
		}

		return $alltags;

	}

	public function updatePost()
	{

		$sql = new Sql();

		$results = $sql->select("CALL sp_post_update(:idpost, :iduser, :desurl, :deslink, :desimage, :destittle, :destext, :despub)", [
			':idpost'=>$this->getidpost(),
			':iduser'=>$this->getiduser(),
			':desurl'=>$this->getdesurl(),
			':deslink'=>$this->getdeslink(),
			':desimage'=>$this->getdesimage(),
			':destittle'=>$this->getdestittle(),
			':destext'=>$this->getdestext(),
			':despub'=>$this->getdespub()
		]);

		$this->setData($results[0]);

	}

	public function updateTags()
	{

		$sql = new Sql();

		$sql->query("DELETE FROM tb_poststags WHERE idpost = :idpost", [
			':idpost'=>$this->getidpost()
		]);

		$this->setTags();

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

	public function delete()
	{

		$sql = new Sql();

		$sql->query("CALL sp_post_delete(:idpost)", [
			':idpost'=>$this->getidpost()
		]);

	}

	public function changeStatus()
	{
		$newstatus = ($this->getdespub() !== NULL && $this->getdespub() == 0) ? 1 : 0;
		
		$sql = new Sql();
		
		$sql->select("UPDATE tb_posts SET despub = :newstatus WHERE idpost = :idpost", [
			'newstatus'=>$newstatus,
			':idpost'=>$this->getidpost()
		]);

	}

	public function setPhoto($file)
	{

		$extension = explode(".", $file["name"]);
		$extension = end($extension);

		switch ($extension) {

			case "jpg":
			case "jpeg":
			$image = imagecreatefromjpeg($file["tmp_name"]);
			break;

			case "gif":
			$image = imagecreatefromgif($file["tmp_name"]);
			break;

			case "png":
			$image = imagecreatefrompng($file["tmp_name"]);
			break;

		}

		$path = $_SERVER["DOCUMENT_ROOT"] . DIRECTORY_SEPARATOR . 
			"res" . DIRECTORY_SEPARATOR . 
			"img". DIRECTORY_SEPARATOR .
			"post - ".$this->getidpost() . ".jpg";

		imagejpeg($image, $path);

		imagedestroy($image);

	}

}

?>