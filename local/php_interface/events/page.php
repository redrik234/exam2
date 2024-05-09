<?php
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

AddEventHandler('main', 'OnEpilog', [PageHandler::class, 'notFound']);

class PageHandler {
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
}