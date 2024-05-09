<?php
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

use Bitrix\Main\Localization\Loc;

Loc::loadMessages(__FILE__);

AddEventHandler('main', 'OnBeforeEventAdd', [MailHandler::class, 'feedback']);

class MailHandler {
    private const FEEDBACK_EVENT = 'FEEDBACK_FORM';

    public static function feedback(&$event, &$lid, &$arFields) {
        if (strcasecmp($event, self::FEEDBACK_EVENT) !== 0) {
            return true;
        }

        global $USER;
        if ($USER->isAuthorized()) {
            $arFields['AUTHOR'] = Loc::getMessage('AUTHORIZE_USER', [
                    '#ID#' => $USER->GetID(),
                    '#NAME#' => $USER->GetFirstName(),
                    '#LOGIN#' => $USER->GetLogin(),
                    '#FORM_USER_NAME#' => $arFields['AUTHOR']
                ]
            );
        }
        else {
            $arFields['AUTHOR'] = Loc::getMessage('UNAUTHORIZE_USER', [
                    '#FORM_USER_NAME#' => $arFields['AUTHOR']
                ]
            );
        }

        CEventLog::Add([
            "SEVERITY" => "INFO",
            "AUDIT_TYPE_ID" => "FEEDBACK_FORM",
            "MODULE_ID" => "main",
            "DESCRIPTION" => Loc::getMessage('CHANGE_AUTHOR_MSG', ['#AUTHOR#' => $arFields['AUTHOR']]),
        ]);

        return true;
    }
}