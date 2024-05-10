<?php
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

AddEventHandler('main', 'OnEpilog', [PageHandler::class, 'notFound']);
AddEventHandler('main', 'OnEpilog', [PageHandler::class, 'replaceMetaTag']);

class PageHandler {

    private const META_TAG_IBLOCK_CODE = 'metatags'; 

    public static function notFound() {
        if (!defined('ERROR_404') || ERROR_404 !== 'Y') {
            return true;
        }

        global $APPLICATION;
        CEventLog::Add([
            "SEVERITY" => "INFO",
            "AUDIT_TYPE_ID" => "ERROR_404",
            "MODULE_ID" => "main",
            "DESCRIPTION" => $APPLICATION->GetCurPage(),
        ]);
    }

    public static function replaceMetaTag() {
        global $APPLICATION;
        if (CModule::IncludeModule("iblock")) {
            $metaTagORM = CIBlockElement::GetList(
                [],
                [
                    'IBLOCK_CODE' => self::META_TAG_IBLOCK_CODE,
                    '=NAME' => $APPLICATION->GetCurPage(),
                    'ACTIVE' => 'Y'
                ],
                false,
                false,
                [
                    'ID', 'NAME', 'PROPERTY_TITLE', 'PROPERTY_DESCRIPTION'
                ]
            );
            if ($data = $metaTagORM->Fetch()) {
                if ($data['PROPERTY_TITLE_VALUE']) {
                    $APPLICATION->SetPageProperty('title', $data['PROPERTY_TITLE_VALUE']);
                }
    
                if ($data['PROPERTY_DESCRIPTION_VALUE']) {
                    $APPLICATION->SetPageProperty('description', $data['PROPERTY_DESCRIPTION_VALUE']);
                }
            }
        }
    }
}