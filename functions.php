<?php

use Pronov\Sql;
use Pronov\Model\Tag;
use Pronov\Model\Post;

function getPostImage($idpost)
{

	if (file_exists($_SERVER["DOCUMENT_ROOT"] . DIRECTORY_SEPARATOR . 
			"res" . DIRECTORY_SEPARATOR . 
			"img". DIRECTORY_SEPARATOR .
			"post-".$idpost.".jpg"))
	{
		return "/res/img/post-".$idpost.".jpg";
	} else {
		return "/res/img/blank.png";
	}

}

function checkPostImage($idpost)
{

	if (file_exists($_SERVER["DOCUMENT_ROOT"] . DIRECTORY_SEPARATOR . 
			"res" . DIRECTORY_SEPARATOR . 
			"img". DIRECTORY_SEPARATOR .
			"post-".$idpost.".jpg"))
	{
		return true;
	} else {
		return false;
	}

}

function getAllTags()
{

	return Tag::listAll();

}

function getSelectedTags($idpost)
{

	$sql = new Sql();

	return $sql->select("SELECT *
		FROM tb_poststags a
		INNER JOIN tb_tags b
		USING(idtag)
		WHERE a.idpost = :idpost", [
			'idpost'=>$idpost
		]);

}

function getNPosts($n=5)
{

	return Post::listAll($n);

}

function formatDate($date) // input format: 2020-05-17 22:57:23
{

	$year = substr($date, 0, 4);
	$month = substr($date, 5, 2);
	switch ($month) {
		case '01':
			$month = "JAN";
			break;
		case '02':
			$month = "FEV";
			break;
		case '03':
			$month = "MAR";
			break;
		case '04':
			$month = "ABR";
			break;
		case '05':
			$month = "MAI";
			break;
		case '06':
			$month = "JUN";
			break;
		case '07':
			$month = "JUL";
			break;
		case '08':
			$month = "AGO";
			break;
		case '09':
			$month = "SET";
			break;
		case '10':
			$month = "OUT";
			break;
		case '11':
			$month = "NOV";
			break;
		case '12':
			$month = "DEZ";
			break;
	}

	$day = substr($date, 8, 2);

	return $day." ".$month." ".$year;

}

?>