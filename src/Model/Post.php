<?php  

namespace Pronov\Model;

use Pronov\Model;
use Pronov\Sql;

class Post extends Model
{

	const ERROR = "UserError";
	const SUCCESS = "UserSuccess";

	public static function listAll()
	{

		$sql = new Sql();

		return $sql->select("SELECT * FROM tb_posts a 
			INNER JOIN tb_users b
			USING(iduser)
			ORDER BY idpost
		");

	}

}

?>