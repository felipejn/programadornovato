<?php  

namespace Pronov\Model;

use Pronov\Sql;
use Pronov\Model;
use Pronov\Message;

class Tag extends Model
{
	
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
			Message::setError("This tag name already exists.");
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