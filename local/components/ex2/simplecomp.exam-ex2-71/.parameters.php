<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();
$arComponentParameters = array(
	"PARAMETERS" => array(
		"PRODUCTS_IBLOCK_ID" => array(
			"NAME" => GetMessage("SIMPLECOMP_EXAM2_CAT_IBLOCK_ID"),
			"TYPE" => "STRING",
		),
		"CLASSIFICATOR_IBLOCK_ID" => array(
			"NAME" => GetMessage("SIMPLECOMP_EXAM2_CLASS_IBLOCK_ID"),
			"TYPE" => "STRING",
		),
		"PRODUCTS_URL_TEMPLATE" => array(
			"NAME" => GetMessage("SIMPLECOMP_EXAM2_URL_TEMPLATE"),
			"TYPE" => "STRING",
		),
		"PRODUCTS_PROP_CODE" => array(
			"NAME" => GetMessage("SIMPLECOMP_EXAM2_PROP_CODE"),
			"TYPE" => "STRING",
		),
		"CACHE_TIME" => array(
			'DEFAULT' => 3600
		),
		"CACHE_GROUPS" => [
			"PARENT" => "CACHE_SETTINGS",
			"NAME" => GetMessage("CP_BNL_CACHE_GROUPS"),
			"TYPE" => "CHECKBOX",
			"DEFAULT" => "Y",
		],
		"ELEMENT_COUNT" => [
			"PARENT" => "BASE",
			"NAME" => GetMessage("SIMPLECOMP_EXAM2_ELEMENT_COUNT"),
			"TYPE" => "STRING",
			"DEFAULT" => "20",
		],
	),
);