<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Простой компонент ex2-97");
?><?$APPLICATION->IncludeComponent(
	"ex2:simplecomp.exam-ex2-97", 
	".default", 
	array(
		"COMPONENT_TEMPLATE" => ".default",
		"CACHE_TYPE" => "A",
		"CACHE_TIME" => "36000000",
		"NEWS_IBLOCK_ID" => "1",
		"AUTHOR_PROP_CODE" => "AUTHOR",
		"USER_ATHOR_PROP_CODE" => "UF_AUTHOR_TYPE"
	),
	false
);?><?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>