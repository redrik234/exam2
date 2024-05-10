<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();
$arComponentParameters = array(
	"PARAMETERS" => array(
		"NEWS_IBLOCK_ID" => array(
			"NAME" => GetMessage("SIMPLECOMP_EXAM2_NEWS_IBLOCK_ID"),
			"TYPE" => "STRING",
		),
		"AUTHOR_PROP_CODE" => array(
			"NAME" => GetMessage("SIMPLECOMP_EXAM2_AUTHOR_PROP_CODE"),
			"TYPE" => "STRING",
		),
		"USER_ATHOR_PROP_CODE" => array(
			"NAME" => GetMessage("SIMPLECOMP_EXAM2_USER_ATHOR_PROP_CODE"),
			"TYPE" => "STRING",
		),
		"CACHE_TIME"  =>  ["DEFAULT"=>36000000],
	),
);