<?php
if(!defined('B_PROLOG_INCLUDED')||B_PROLOG_INCLUDED!==true)die();

if (!empty($arParams['CANONICAL_IBLOCK_ID'])) {
    $canonicalORM = CIBlockElement::GetList(
        [],
        [
            'IBLOCK_ID' => $arParams['CANONICAL_IBLOCK_ID'],
            'PROPERTY_NEWS_ID' => $arResult['ID']
        ]
    );

    if ($canonical = $canonicalORM->Fetch()) {
        $this->getComponent()->arResult['CANONICAL_URL'] = $canonical['NAME'];
        $this->getComponent()->SetResultCacheKeys(['CANONICAL_URL']);
    }
}