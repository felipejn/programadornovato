<?php

/** Handles the subscribers
 * 
 *
 * @author Felipe Nascimento
 **/

namespace Pronov\Model;

use Pronov\Model;
use Pronov\Sql;
use Pronov\Message;
use Pronov\Mailer;

class Subscriber extends Model
{

	// Adds subscriber to database and send welcome email
	public function saveSubscriber()
	{

		$sql = new Sql();

		$results = $sql->select("SELECT * FROM tb_subscribers WHERE dessubscriber = :dessubscriber", [
			':dessubscriber'=>$this->getdessubscriber()
		]);
		
		if (count($results) > 0)
		{

			Message::setError("Este email já foi cadastrado.");
			header("Location: /");
			exit;

		} else {

			$sql->query("INSERT INTO tb_subscribers (dessubscriber) VALUES(:dessubscriber)", [
				':dessubscriber'=>$this->getdessubscriber()
			]);

			$result = $sql->select("SELECT idsubscriber FROM tb_subscribers WHERE dessubscriber = :dessubscriber", [
				':dessubscriber'=>$this->getdessubscriber()
			]);

			$code = User::codeFromId($result[0]['idsubscriber']);

			$link = "http://www.programadornovato.pt/unsubscribe?code=$code";

			$mailer = new Mailer($this->getdessubscriber(), $this->getdessubscriber(), utf8_decode("Subscrição"), "new-subscriber", $data = [
				'link'=>$link
			]);

		}

	}

	// Get subscriber info from id
	public function getFromId($id)
	{

		$sql = new Sql();

		$result = $sql->select("SELECT * FROM tb_subscribers WHERE idsubscriber = :idsubscriber", [
			':idsubscriber'=>$id
		]);

		if (count($result) === 1)
		{
		
			$this->setData($result[0]);
		
		} else {

			Message::setError("Este email não está cadastrado.");
			header("Location: /");
			exit;

		}
		
	}

	// Delete subscriber
	public function delete()
	{

		$sql = new Sql();

		$sql->query("DELETE FROM tb_subscribers WHERE idsubscriber = :idsubscriber", [
			':idsubscriber'=>$this->getidsubscriber()
		]);

		Message::setSuccess("Email descadastrado com sucesso.");	
		header("Location: /");
		exit;

	}

} 

?>