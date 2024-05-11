<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

if (!empty($arResult['PRICE_RANGE'])) {
    $APPLICATION->AddViewContent('SIMPLECOMP_PRICE', GetMessage('SIMPLECOMP_PRICE', [
        '#MIN#' => $arResult['PRICE_RANGE']['MIN'],
        '#MAX#' => $arResult['PRICE_RANGE']['MAX']
    ]
));
}