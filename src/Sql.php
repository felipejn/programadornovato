<?php 

namespace Pronov;

class Sql {

	// const HOSTNAME = '81.88.52.62';
	// const USERNAME = 'xl3vjqxg_felipe';
	// const PASSWORD = 'eYaSJBQ)t$bf';
	// const PORT = '3306';
	// const DBNAME = 'xl3vjqxg_prognovato_db';

	
	// Localhost
	const HOSTNAME = "127.0.0.1";
	const USERNAME = "root";
	const PASSWORD = "root";
	const PORT = "8889";
	const DBNAME = "prognovato";

	private $conn;

	public function __construct()
	{

		$this->conn = new \PDO(
			"mysql:dbname=".Sql::DBNAME.";host=".Sql::HOSTNAME.";port=".Sql::PORT, 
			Sql::USERNAME,
			Sql::PASSWORD
		);

	}

	private function setParams($statement, $parameters = array())
	{

		foreach ($parameters as $key => $value) {
			
			$this->bindParam($statement, $key, $value);

		}

	}

	private function bindParam($statement, $key, $value)
	{

		$statement->bindParam($key, $value);

	}

	public function query($rawQuery, $params = array())
	{

		$stmt = $this->conn->prepare($rawQuery);

		$this->setParams($stmt, $params);

		$stmt->execute();

	}

	public function select($rawQuery, $params = array()):array
	{

		$stmt = $this->conn->prepare($rawQuery);

		$this->setParams($stmt, $params);

		$stmt->execute();

		return $stmt->fetchAll(\PDO::FETCH_ASSOC);

	}

}

 ?>