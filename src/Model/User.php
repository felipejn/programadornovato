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

	public static function listAll()
	{

		$sql = new Sql();

		return $sql->select("SELECT * FROM tb_users");

	}

}

?>