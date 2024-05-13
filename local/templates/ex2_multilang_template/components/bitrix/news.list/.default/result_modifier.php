<?php
if(!defined('B_PROLOG_INCLUDED')||B_PROLOG_INCLUDED!==true)die();

if ($arParams['SPECIAL_DATE'] === 'Y' && !empty($arResult['ITEMS'])) {
    $firstElem = reset($arResult['ITEMS']);
    $this->getComponent()->arResult['SPECIAL_DATE'] = isset($firstElem['ACTIVE_FROM']) ? $firstElem['ACTIVE_FROM'] : null;
    $this->getComponent()->SetResultCacheKeys(['SPECIAL_DATE']);
}