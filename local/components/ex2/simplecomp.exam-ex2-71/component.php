<?
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();

use Bitrix\Main\Loader,
	Bitrix\Iblock;

global $CACHE_MANAGER;

if(!Loader::includeModule("iblock"))
{
	ShowError(GetMessage("SIMPLECOMP_EXAM2_IBLOCK_MODULE_NONE"));
	return;
}
$arNavigation = false;
if (!empty($arParams['ELEMENT_COUNT'])) {
	$arNavParams = array(
		"nPageSize" => $arParams["ELEMENT_COUNT"],
		"bDescPageNumbering" => '',
		"bShowAll" => 'Y',
	); 

	$arNavigation = CDBResult::GetNavParams($arNavParams);
}

if ($this->StartResultCache(false, [$USER->GetGroups(), $arNavigation])) {
	$CACHE_MANAGER->RegisterTag('iblock_id_3');
	if (
		intval($arParams['PRODUCTS_IBLOCK_ID']) > 0
		&& intval($arParams['CLASSIFICATOR_IBLOCK_ID']) > 0
		&& !empty($arParams['PRODUCTS_URL_TEMPLATE'])
		&& !empty($arParams['PRODUCTS_PROP_CODE'])
	) {
		$this->arResult['CLASSIFICATOR_DATA'] = [];
		$this->arResult['FIRM_COUNT'] = 0;

		$firmORM = CIBlockElement::GetList(
			[
				'NAME' => 'ASC'
			],
			[
				'IBLOCK_ID' => $arParams['CLASSIFICATOR_IBLOCK_ID'],
				'ACTIVE' => 'Y',
				'CHECK_PERMISSIONS' => $arParams['CACHE_GROUPS']
			],
			false,
			$arNavParams,
			[
				'ID', 'NAME'
			]
		);
		$this->arResult['NAV_STRING'] = $firmORM->GetPageNavString(GetMessage('SIMPLECOMP_EXAM2_NAV_DESC'));

		$firms = [];
		while ($arFirm = $firmORM->Fetch()) {
			$firms[$arFirm['ID']] = $arFirm;
		}

		$this->arResult['FIRM_COUNT'] = count($firms);

		if (count($firms) > 0) {
			$productORM = CIBlockElement::GetList(
				[
					'ID' => 'ASC'
				],
				[
					'IBLOCK_ID' => $arParams['PRODUCTS_IBLOCK_ID'],
					'ACTIVE' => 'Y',
					'CHECK_PERMISSONS' => $arParams['CACHE_GROUPS'],
					'=PROPERTY_' . $arParams['PRODUCTS_PROP_CODE'] => array_column($firms, 'ID')
				],
				false,
				false,
				[
					'ID',
					'NAME',
					'IBLOCK_SECTION_ID',
					'PROPERTY_' . $arParams['PRODUCTS_PROP_CODE'],
					'PROPERTY_PRICE',
					'PROPERTY_MATERIAL',
					'PROPERTY_ARTNUMBER'
				]
			);

			$this->arResult['CLASSIFICATOR_DATA'] = $firms;
			while ($arProduct = $productORM->Fetch()) {
				$this->arResult['CLASSIFICATOR_DATA'][$arProduct['PROPERTY_' . $arParams['PRODUCTS_PROP_CODE'] . '_VALUE']]['PRODUCTS'][] = [
					'ID' => $arProduct['ID'],
					'NAME' => $arProduct['NAME'],
					'PRICE' => $arProduct['PROPERTY_PRICE_VALUE'],
					'MATERIAL' => $arProduct['PROPERTY_MATERIAL_VALUE'],
					'ARTNUMBER' => $arProduct['PROPERTY_ARTNUMBER_VALUE'],
					'DETAIL_URL' => str_replace(['#SECTION_ID#', '#ELEMENT_ID#'], [$arProduct['IBLOCK_SECTION_ID'], $arProduct['ID']], $arParams['PRODUCTS_URL_TEMPLATE']),
				];
			}
		}

		$this->SetResultCacheKeys('FIRM_COUNT');
	}
	else {
		$this->AbortResultCache();
	}

	$this->includeComponentTemplate();	
}

$APPLICATION->SetTitle(GetMessage('SIMPLECOMP_EXAM2_TITLE_FIRM_COUNT', ['#FIRM_COUNT#' => $arResult['FIRM_COUNT']]));