<?php
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
use Bitrix\Main\Localization\Loc;

Loc::loadMessages(__FILE__);

AddEventHandler("iblock", "OnBeforeIBlockElementUpdate", [ElementHandler::class, "deactivateElement"]);
class ElementHandler {
    private const CATALOG_IBLOCK_ID = 2;
    private const MIN_SHOW_COUNT = 2;

    public static function deactivateElement(&$arFields) {
        if ((int)$arFields['IBLOCK_ID'] !== self::CATALOG_IBLOCK_ID || $arFields['ACTIVE'] !== 'N') {
            return true;
        }

        $catalogORM = CIBlockElement::GetList(
            [],
            [
                'IBLOCK_ID' => $arFields['IBLOCK_ID'],
                'ID' => $arFields['ID']
            ],
            false,
            false,
            [
                'ID',
                'SHOW_COUNTER'
            ]
        );

        $counterData = $catalogORM->Fetch();

        if ($counterData['SHOW_COUNTER'] > self::MIN_SHOW_COUNT) {
            global $APPLICATION;

            $APPLICATION->throwException(Loc::getMessage('ERROR_ELEMENT_DEACTIVATE', ['#SHOW_COUNT#' => $counterData['SHOW_COUNTER']]));
            return false;
        }
    }
}