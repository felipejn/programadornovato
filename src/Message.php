<?php

/**
 * Class to handle messages on the frontend pages
 *
 * @author Felipe Nascimento
 **/

namespace Pronov;

class Message
{

	const ERROR = "error";
	const SUCCESS = "success";

	public static function setError($msg)
	{

		$_SESSION[Message::ERROR] = $msg;

	}

	public static function getError()
	{

		$msg = (isset($_SESSION[Message::ERROR]) && $_SESSION[Message::ERROR]) ? $_SESSION[Message::ERROR] : "" ;

		Message::clearError();

		return $msg;

	}

	public static function clearError()
	{

		$_SESSION[Message::ERROR] = NULL;

	}

	public static function setSuccess($msg)
	{

		$_SESSION[Message::SUCCESS] = $msg;

	}

	public static function getSuccess()
	{

		$msg = (isset($_SESSION[Message::SUCCESS]) && $_SESSION[Message::SUCCESS]) ? $_SESSION[Message::SUCCESS] : "" ;

		Message::clearSuccess();

		return $msg;

	}

	public static function clearSuccess()
	{

		$_SESSION[Message::SUCCESS] = NULL;

	}

} 

?>