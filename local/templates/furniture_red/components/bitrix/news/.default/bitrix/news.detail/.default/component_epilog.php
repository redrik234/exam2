<?php
if(!defined('B_PROLOG_INCLUDED')||B_PROLOG_INCLUDED!==true)die();

if (isset($arResult['CANONICAL_URL']) && !empty($arResult['CANONICAL_URL'])) {
    $APPLICATION->SetPageProperty('canonical', $arResult['CANONICAL_URL']);
}

if (isset($_REQUEST['R']) && $_REQUEST['R'] === 'Y') {
    $reportData = [
        'ACTIVE_FROM' => new \Bitrix\Main\Type\DateTime(),
        'USER' => '',
        'NEWS_ID' => $arResult['ID']
    ];

    if ($USER->IsAuthorized()) {
        $reportData['USER'] = implode(' - ', [$USER->GetID(), $USER->GetLogin(), $USER->GetFullName()]);
    }
    else {
        $reportData['USER'] = GetMessage('USER_UNAUTH');
    }

    $reportORM = new CIBLockElement;
    $elem = [
        'IBLOCK_ID' => 9,
        "NAME" => GetMessage('REPORT_NAME', ['#NEWS_ID#' => $reportData['NEWS_ID']]),
        'PROPERTY_VALUES' => [
            'USER' => $reportData['USER'],
            'NEWS_ID' => $reportData['NEWS_ID']
        ],
        'ACTIVE_FROM' => $reportData['ACTIVE_FROM']
    ];

    $reportId = $reportORM->Add($elem);

    $msg = '';
    if ($reportId > 0) {
        $msg = GetMessage('REPORT_SUCCESS', ['#REPORT_ID#' => $reportId]);
    }
    else {
        $msg = GetMessage('REPORT_ERROR');
    }

    if ($arParams['AJAX_NEWS_REPORT'] === 'Y') {
            $APPLICATION->RestartBuffer();
            
            echo json_encode([
                'content' => $msg
            ]);
            die;
    }
    else {
        echo "<script>history.pushState(null, null, '" . $APPLICATION->GetCurPage() . "'); document.getElementById('report-msg').textContent ='" . $msg ."';</script>";
    }
}