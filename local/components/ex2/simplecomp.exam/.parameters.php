<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();
$arComponentParameters = array(
	"PARAMETERS" => array(
		"PRODUCTS_IBLOCK_ID" => array(
			"NAME" => GetMessage("SIMPLECOMP_EXAM2_CAT_IBLOCK_ID"),
			"TYPE" => "STRING",
		),
		"NEWS_IBLOCK_ID" => array(
			"NAME" => GetMessage("SIMPLECOMP_EXAM2_NEWS_IBLOCK_ID"),
			"TYPE" => "STRING",
		),
		"LINK_PROPERTY_CODE" => array(
			"NAME" => GetMessage("SIMPLECOMP_EXAM2_LINK_PROPERTY_CODE"),
			"TYPE" => "STRING",
		),
		"DETAIL_URL_TEMPLATE" => array(
			"NAME" => GetMessage("SIMPLECOMP_EXAM2_DETAIL_URL_TEMPLATE"),
			"TYPE" => "STRING",
			"DEFAULT" => "catalog_exam/#SECTION_ID#/#ELEMENT_CODE#"
		),
		"CACHE_TIME" => array("DEFAULT" => 3600)
	),
);