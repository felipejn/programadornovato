<?php  

namespace Pronov\Model;

use Pronov\Model;
use Pronov\Sql;
use Pronov\Message;

class Post extends Model
{

	public static function listAll($limit = 10000)
	{

		$sql = new Sql();

		return $sql->select("SELECT * FROM tb_posts a 
			INNER JOIN tb_users b
			USING(iduser)
			ORDER BY idpost DESC
			LIMIT 0, $limit
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
			Message::setError("This url has already been used.");
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

		foreach ($this->getValues() as $key => $value) {
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
			$alltags[$i]['desstatus'] = false;
			for ($j=0; $j < count($usedtags); $j++) { 
				if ($alltags[$i]['idtag'] === $usedtags[$j]['idtag'])
				{
					$alltags[$i]['desstatus'] = true;
					break;
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

	public function delete()
	{

		$sql = new Sql();

		$sql->query("CALL sp_post_delete(:idpost)", [
			':idpost'=>$this->getidpost()
		]);

		$path = $_SERVER["DOCUMENT_ROOT"] . DIRECTORY_SEPARATOR . 
			"res" . DIRECTORY_SEPARATOR . 
			"img". DIRECTORY_SEPARATOR .
			"post-".$this->getidpost().".jpg";

		if (file_exists($path)) unlink($path);

	}

	public function changeStatus()
	{
		$newstatus = ($this->getdespub() !== NULL && $this->getdespub() == false) ? true : false;
		
		$sql = new Sql();
		
		$sql->select("UPDATE tb_posts SET despub = :newstatus WHERE idpost = :idpost", [
			'newstatus'=>$newstatus,
			':idpost'=>$this->getidpost()
		]);

	}

	public function setImage($file)
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
			"post-".$this->getidpost().".jpg";

		imagejpeg($image, $path);

		imagedestroy($image);

	}

	public function getPosts($page = 1, $itemsPerPage = 5)
	{

		$start = ($page - 1) * $itemsPerPage;

		$sql = new Sql();

		$results = $sql->select("SELECT SQL_CALC_FOUND_ROWS * FROM tb_posts a
			INNER JOIN tb_users b
			USING(iduser)
			ORDER BY a.idpost DESC
			LIMIT $start, $itemsPerPage");

		if (count($results) > 0)
		{
			$resultTotal = $sql->select("SELECT FOUND_ROWS() as nrtotal");

			return array(
				'posts'=>$results,
				'total'=>(int)$resultTotal[0]['nrtotal'],
				'pages'=>ceil($resultTotal[0]['nrtotal'] / $itemsPerPage)
			);
		}

	}

	public function getSearchPosts($search, $page = 1, $itemsPerPage = 10)
	{

		$start = ($page - 1) * $itemsPerPage;

		$sql = new Sql();

		$results = $sql->select("SELECT SQL_CALC_FOUND_ROWS * FROM tb_posts a
			INNER JOIN tb_users b USING(iduser)
			INNER JOIN tb_poststags c USING(idpost)
			INNER JOIN tb_tags d USING(idtag)
			WHERE a.destittle LIKE :search OR b.desname LIKE :search OR d.destag LIKE :search
			ORDER BY a.idpost DESC
			LIMIT $start, $itemsPerPage", [
			':search'=>'%'.$search.'%'
		]);

		if (count($results) > 0)
		{
			$resultTotal = $sql->select("SELECT FOUND_ROWS() as nrtotal");
		
			$filteredResults = [];
			
			for ($i=0; $i < count($results); $i++) { 
				
				if ($i == 0)
				{
					array_push($filteredResults, $results[$i]);
				} 
				elseif ($results[$i-1]['idpost'] !== $results[$i]['idpost'])
				{
					array_push($filteredResults, $results[$i]);	
				}

			}
			
			return array(
				'posts'=>$filteredResults,
				'total'=>(int)$resultTotal[0]['nrtotal'],
				'pages'=>ceil($resultTotal[0]['nrtotal'] / $itemsPerPage)
			);
			
		}

	}

	public function getByUrl($desurl)
	{

		$sql = new Sql();

		$results = $sql->select("SELECT * FROM tb_posts a
			INNER JOIN tb_users b
			USING(iduser)
			WHERE desurl = :desurl", [
			':desurl'=>$desurl
		]);

		if (count($results) > 0)
		{
			return $this->setData($results[0]);
		
		} else {
			
			throw new \Exception("Publicação não encontrada!", 1);			
			exit;

		}
	}

	public function getByTag($destag, $page = 1, $itemsPerPage = 5)
	{

		$start = ($page - 1) * $itemsPerPage;

		$sql = new Sql();

		$results = $sql->select("SELECT SQL_CALC_FOUND_ROWS * FROM tb_posts a
			INNER JOIN tb_users b
			USING(iduser)
			INNER JOIN tb_poststags c
			USING(idpost)
			INNER JOIN tb_tags d
			USING(idtag)
			WHERE d.destag = :destag
			ORDER BY a.idpost DESC
			LIMIT $start, $itemsPerPage", [
			'destag'=>$destag
		]);

		if (count($results) > 0)
		{
			$resultTotal = $sql->select("SELECT FOUND_ROWS() as nrtotal");

			return array(
				'posts'=>$results,
				'total'=>(int)$resultTotal[0]['nrtotal'],
				'pages'=>ceil($resultTotal[0]['nrtotal'] / $itemsPerPage)
			);
		}

	}

}

?>