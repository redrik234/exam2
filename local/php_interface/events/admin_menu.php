<?php
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

AddEventHandler('main', 'OnBuildGlobalMenu', [AdminMenuHandler::class, 'contentManager']);

class AdminMenuHandler {

    private const CONTENT_MANAGER_PERMISSION_SEC = ['global_menu_content'];
    private const CONTENT_MANAGER_PERMISSION_MOD = ['menu_iblock_/news'];

    private const CONTENT_MANAGER_GROUP_CODE = 'content_editor';

    public static function contentManager(&$aGlobalMenu, &$aModuleMenu) {
        global $USER;

        if ($USER->IsAdmin() || !in_array(self::getContentGroupId(), CUser::GetUserGroup($USER->GetID()))) {
            return true;
        }

        foreach($aGlobalMenu as $key => $data) {
            if (!in_array($key, self::CONTENT_MANAGER_PERMISSION_SEC)) {
                unset($aGlobalMenu[$key]);
            }
        }

        foreach($aModuleMenu as $key => $data) {
            if (!in_array($data['items_id'], self::CONTENT_MANAGER_PERMISSION_MOD)) {
                unset($aModuleMenu[$key]);
            }
        }

        return true;
    }

    private static function getContentGroupId() {
        $groupORM = CGroup::GetList(
            "c_sort",
            "asc",
            [
                'STRING_ID' => self::CONTENT_MANAGER_GROUP_CODE
            ]
        );

        if ($group = $groupORM->Fetch()) {
            return $group['ID'];
        }
        return false;
    }
}