<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Простой компонент ex2-71");
?><?$APPLICATION->IncludeComponent(
	"ex2:simplecomp.exam-ex2-71", 
	".default", 
	array(
		"CACHE_TIME" => "3600",
		"CACHE_TYPE" => "A",
		"CLASSIFICATOR_IBLOCK_ID" => "8",
		"PRODUCTS_IBLOCK_ID" => "2",
		"PRODUCTS_PROP_CODE" => "FIRM",
		"PRODUCTS_URL_TEMPLATE" => "/products/#SECTION_ID#/#ELEMENT_ID#/",
		"COMPONENT_TEMPLATE" => ".default",
		"CACHE_GROUPS" => "Y",
		"ELEMENT_COUNT" => "2"
	),
	false
);?><?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>