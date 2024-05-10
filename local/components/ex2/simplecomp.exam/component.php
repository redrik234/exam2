<?
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();

use Bitrix\Main\Loader,
	Bitrix\Iblock;

if(!Loader::includeModule("iblock"))
{
	ShowError(GetMessage("SIMPLECOMP_EXAM2_IBLOCK_MODULE_NONE"));
	return;
}

if ($this->StartResultCache()) {
	if (intval($arParams["PRODUCTS_IBLOCK_ID"]) > 0
		&& intval($arParams["NEWS_IBLOCK_ID"]) > 0
		&& !empty($arParams['LINK_PROPERTY_CODE'])){

			$this->arResult['CLASSIFICATOR_DATA'] = [];
			$this->arResult['ELEMENT_COUNT'] = 0;

			$newsORM = CIBlockElement::GetList(
				[],
				[
					'IBLOCK_ID' => $arParams['NEWS_IBLOCK_ID'],
					'ACTIVE' => 'Y'
				],
				false,
				false,
				[
					'ID', 'NAME', 'ACTIVE_FROM'
				]
			);
			$news = [];
			while($arNews = $newsORM->Fetch()) {
				$news[] = $arNews;
			}

			$sectionORM = CIBlockSection::GetList(
				[
					"NAME" => "ASC"
				],
				[
					'IBLOCK_ID' =>	$arParams['PRODUCTS_IBLOCK_ID'],
					'ACTIVE' => 'Y',
					$arParams['LINK_PROPERTY_CODE'] => array_column($news, 'ID')
				],
				false,
				[
					'ID', 'NAME', $arParams['LINK_PROPERTY_CODE']
				]
			);

			$sections = [];
			while($arSection = $sectionORM->Fetch()) {
				$sections[] = $arSection;
			}

			$productORM = CIBlockElement::GetList(
				[],
				[
					'IBLOCK_ID' => $arParams['PRODUCTS_IBLOCK_ID'],
					'ACTIVE' => 'Y',
					'SECTION_ID' => array_column($sections, 'ID')
				],
				false,
				false,
				[
					'ID', 'NAME', 'IBLOCK_SECTION_ID', 'PROPERTY_ARTNUMBER', 'PROPERTY_MATERIAL', 'PROPERTY_PRICE'
				]
			);

			$products = [];
			while($arProduct = $productORM->Fetch()) {
				++$this->arResult['ELEMENT_COUNT'];
				$products[(int)$arProduct['IBLOCK_SECTION_ID']][] = [
					'ID' => $arProduct['ID'],
					'NAME' => $arProduct['NAME'],
					'PRICE' => $arProduct['PROPERTY_PRICE_VALUE'],
					'MATERIAL' => $arProduct['PROPERTY_MATERIAL_VALUE'],
					'ARTNUMBER' => $arProduct['PROPERTY_ARTNUMBER_VALUE'],
				];
			}

			foreach ($news as $arNews) {
				$item = $arNews;
				$item['SECTIONS'] = [];
				$item['PRODUCTS'] = [];
				foreach ($sections as $arSection) {
					if (in_array($arNews['ID'], $arSection[$arParams['LINK_PROPERTY_CODE']])) {
						$item['SECTIONS'][(int)$arSection['ID']] =  $arSection['NAME'];
						$item['PRODUCTS'] = array_merge($item['PRODUCTS'], $products[(int)$arSection['ID']]);
					}
				}
				$this->arResult['CLASSIFICATOR_DATA'][] = $item;
			}

			$this->SetResultCacheKeys(['ELEMENT_COUNT']);
	}
	else {
		$this->AbortResultCache();
	}

	$this->includeComponentTemplate();
}

$APPLICATION->SetTitle(GetMessage('SIMPLECOMP_EXAM2_ELEM_COUNT', ['#ELEMENT_COUNT#' => $arResult['ELEMENT_COUNT']]));