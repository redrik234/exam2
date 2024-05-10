<?
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();

use Bitrix\Main\Loader,
	Bitrix\Iblock;

if(!Loader::includeModule("iblock"))
{
	ShowError(GetMessage("SIMPLECOMP_EXAM2_IBLOCK_MODULE_NONE"));
	return;
}

if ($USER->isAuthorized() && $this->StartResultCache(false, $USER->GetID())) {
	if(
		intval($arParams["NEWS_IBLOCK_ID"]) > 0
		&& !empty($arParams["AUTHOR_PROP_CODE"])
		&& !empty($arParams["USER_ATHOR_PROP_CODE"])
	) {

		$this->arResult['AUTHOR_DATA'] = [];
		$this->arResult['NEWS_COUNT'] = 0;
		$userORM = CUser::GetList(
			'',
			'',
			[
				'!' . $arParams["USER_ATHOR_PROP_CODE"] => false
			],
			[
				'SELECT' => [$arParams["USER_ATHOR_PROP_CODE"]],
				'FIELDS' => ['ID', 'LOGIN']
			]
		);

		$currentUserType = 0;
		$userTypes = [];
		while ($arUser = $userORM->Fetch()) {
			if ((int)$USER->GetID() === (int)$arUser['ID']) {
				$currentUserType = $arUser[$arParams["USER_ATHOR_PROP_CODE"]];
				continue;
			}
			$userTypes[$arUser[$arParams["USER_ATHOR_PROP_CODE"]]][$arUser['ID']] = $arUser;
		}

		if (isset($userTypes[$currentUserType]) && count($userTypes[$currentUserType]) >0) {
			$newsORM = CIBlockElement::GetList(
				[
					'ID' => 'ASC'
				],
				[
					'IBLOCK_ID' => $arParams["NEWS_IBLOCK_ID"],
					'PROPERTY_' . $arParams["AUTHOR_PROP_CODE"] => array_column($userTypes[$currentUserType], 'ID'),
					// [
					// 	'LOGIC' => 'AND',
					// 	'PROPERTY_' . $arParams["AUTHOR_PROP_CODE"] => array_column($userTypes[$currentUserType], 'ID'),
					// 	'!PROPERTY_' . $arParams["AUTHOR_PROP_CODE"] => $USER->GetID()
					// ]
				],
				false,
				false,
				// [
				// 	'ID', 'NAME', 'PROPERTY_' . $arParams["AUTHOR_PROP_CODE"]
				// ]
			);
	
			$this->arResult['AUTHOR_DATA'] = $userTypes[$currentUserType];
			while ($arNews = $newsORM->GetNextElement()) {
				$arFields = $arNews->GetFields();
				$arProps = $arNews->GetProperties();
				if (isset($arProps[$arParams["AUTHOR_PROP_CODE"]]['VALUE']) && !in_array($USER->GetID(), $arProps[$arParams["AUTHOR_PROP_CODE"]]['VALUE'])) {
					++$this->arResult['NEWS_COUNT'];
					foreach ($arProps[$arParams["AUTHOR_PROP_CODE"]]['VALUE'] as $author) {
						if (array_key_exists($author, $this->arResult['AUTHOR_DATA'])) {
							$this->arResult['AUTHOR_DATA'][$author]['NEWS'][] = [
								'ID' => $arFields['ID'],
								'NAME' => $arFields['NAME'],
								'ACTIVE_FROM' => $arFields['ACTIVE_FROM'],
							];
						}
					}
				}
			}
		}

		$this->SetResultCacheKeys(['NEWS_COUNT']);
	}
	else {
		$this->AbortResultCache();
	}
}

$this->includeComponentTemplate();

$APPLICATION->SetTitle(GetMessage('SIMPLECOMP_EXAM2_TITLE', ['#NEWS_COUNT#' => $arResult['NEWS_COUNT']]));