<?
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();

use Bitrix\Main\Loader,
	Bitrix\Iblock;

if(!Loader::includeModule("iblock"))
{
	ShowError(GetMessage("SIMPLECOMP_EXAM2_IBLOCK_MODULE_NONE"));
	return;
}
$isFilter = false;
if (isset($_REQUEST['F'])) {
	$isFilter = true;
}

if ($USER->IsAuthorized() && intval($arParams["PRODUCTS_IBLOCK_ID"]) > 0) {
	$buttons = CIBlock::GetPanelButtons($arParams["PRODUCTS_IBLOCK_ID"]);
	
	$this->AddIncludeAreaIcon(
		[
			'URL'   => $buttons['submenu']['element_list']['ACTION_URL'],
			'TITLE' => GetMessage('SIMPLECOMP_EXAM2_PARAMS_MENU_IBLOCK_BUTTON'),
			'IN_PARAMS_MENU' => 'Y'
		]
	);
}

if ($this->StartResultCache(false, [$isFilter])) {
	if (intval($arParams["PRODUCTS_IBLOCK_ID"]) > 0
		&& intval($arParams["NEWS_IBLOCK_ID"]) > 0
		&& !empty($arParams['LINK_PROPERTY_CODE'])){

			$this->arResult['CLASSIFICATOR_DATA'] = [];
			$this->arResult['ELEMENT_COUNT'] = 0;
			$this->arResult['ADD_NEWS'] = ['IBLOCK_ID' =>$arParams["NEWS_IBLOCK_ID"]];
			$this->arResult['ADD_PRODUCT'] = ['IBLOCK_ID' =>$arParams["PRODUCTS_IBLOCK_ID"]];

			$newsORM = CIBlockElement::GetList(
				[],
				[
					'IBLOCK_ID' => $arParams['NEWS_IBLOCK_ID'],
					'ACTIVE' => 'Y'
				],
				false,
				false,
				[
					'ID', 'IBLOCK_ID', 'NAME', 'ACTIVE_FROM'
				]
			);
			$news = [];
			while($arNews = $newsORM->Fetch()) {
				$controlButtons = CIBlock::GetPanelButtons(
					$arParams['NEWS_IBLOCK_ID'],
					$arNews['ID'],
					false,
				);
				$this->arResult['ADD_NEWS']['ADD_LINK'] = $controlButtons['edit']['add_element']['ACTION_URL'];
				$arNews['EDIT_LINK'] = $controlButtons['edit']['edit_element']['ACTION_URL'];
				$arNews['DELETE_LINK'] = $controlButtons['edit']['delete_element']['ACTION_URL'];

				$news[] = $arNews;
			}

			$sectionORM = CIBlockSection::GetList(
				[
					"NAME" => "ASC",
					"SORT" => "ASC"
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

			$arProductFilter =	[
				'IBLOCK_ID' => $arParams['PRODUCTS_IBLOCK_ID'],
				'ACTIVE' => 'Y',
				'SECTION_ID' => array_column($sections, 'ID')
			];

			if ($isFilter) {
				$arProductFilter[] = [
					'LOGIC' => 'OR',
					['<=PROPERTY_PRICE' => 1700, 'PROPERTY_MATERIAL' => 'Дерево, ткань'],
					['<PROPERTY_PRICE' => 1500, 'PROPERTY_MATERIAL' => 'Металл, пластик']
				];
				$this->AbortResultCache();
			}

			$productORM = CIBlockElement::GetList(
				[],
				$arProductFilter,
				false,
				false,
				[
					'ID', 'NAME', 'CODE', 'IBLOCK_SECTION_ID', 'PROPERTY_ARTNUMBER', 'PROPERTY_MATERIAL', 'PROPERTY_PRICE'
				]
			);

			$this->arResult['PRICE_RANGE'] = [
				'MIN' => PHP_INT_MAX,
				'MAX' => 0
			];
			$products = [];
			while($arProduct = $productORM->Fetch()) {
				++$this->arResult['ELEMENT_COUNT'];
				$controlButtons = CIBlock::GetPanelButtons(
					$arParams['PRODUCTS_IBLOCK_ID'],
					$arProduct['ID'],
					false,
				);

				if ($arProduct['PROPERTY_PRICE_VALUE'] < $arResult['PRICE_RANGE']['MIN']) {
					$this->arResult['PRICE_RANGE']['MIN'] = $arProduct['PROPERTY_PRICE_VALUE'];
				}
				elseif ($arProduct['PROPERTY_PRICE_VALUE'] > $arResult['PRICE_RANGE']['MAX']) {
					$this->arResult['PRICE_RANGE']['MAX'] = $arProduct['PROPERTY_PRICE_VALUE'];
				}

				$this->arResult['ADD_PRODUCT']['ADD_LINK'] = $controlButtons['edit']['add_element']['ACTION_URL'];

				$products[(int)$arProduct['IBLOCK_SECTION_ID']][] = [
					'ID' => $arProduct['ID'],
					'NAME' => $arProduct['NAME'],
					'IBLOCK_ID' => $arParams['PRODUCTS_IBLOCK_ID'],
					'PRICE' => $arProduct['PROPERTY_PRICE_VALUE'],
					'MATERIAL' => $arProduct['PROPERTY_MATERIAL_VALUE'],
					'ARTNUMBER' => $arProduct['PROPERTY_ARTNUMBER_VALUE'],
					'DETAIL_URL' => str_replace(
						['#SECTION_ID#', '#ELEMENT_CODE#'],
						[$arProduct['IBLOCK_SECTION_ID'], $arProduct['CODE']], 
						$arParams['DETAIL_URL_TEMPLATE']
					),
					'EDIT_LINK' => $controlButtons['edit']['edit_element']['ACTION_URL'],
					'DELETE_LINK' => $controlButtons['edit']['delete_element']['ACTION_URL'],
				];
			}

			if ($arResult['PRICE_RANGE']['MIN'] === PHP_INT_MAX) {
				$this->arResult['PRICE_RANGE']['MIN'] = 0;
			}

			foreach ($news as $arNews) {
				$item = $arNews;
				$item['SECTIONS'] = [];
				$item['PRODUCTS'] = [];
				foreach ($sections as $arSection) {
					if (in_array($arNews['ID'], $arSection[$arParams['LINK_PROPERTY_CODE']])) {
						$item['SECTIONS'][(int)$arSection['ID']] =  $arSection['NAME'];
						if (isset( $products[(int)$arSection['ID']])) {
							$item['PRODUCTS'] = array_merge($item['PRODUCTS'], $products[(int)$arSection['ID']]);
						}
					}
				}
				$this->arResult['CLASSIFICATOR_DATA'][] = $item;
			}

			$this->SetResultCacheKeys(['ELEMENT_COUNT', 'PRICE_RANGE']);
	}
	else {
		$this->AbortResultCache();
	}

	$this->includeComponentTemplate();
}

$APPLICATION->SetTitle(GetMessage('SIMPLECOMP_EXAM2_ELEM_COUNT', ['#ELEMENT_COUNT#' => $arResult['ELEMENT_COUNT']]));