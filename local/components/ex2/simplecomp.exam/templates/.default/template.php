<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<p><?=GetMessage('SIMPLECOMP_EXAM2_CAT_FILTER');?> <a href="<?=$APPLICATION->GetCurPage() . '?F=Y';?>"><?=$APPLICATION->GetCurPage() . '?F="Y"';?></a></p>
<p>---</p>
<p><b><?=GetMessage("SIMPLECOMP_EXAM2_CAT_TITLE")?></b></p>
<?if (!empty($arResult['CLASSIFICATOR_DATA'])):?>
    <?
        $this->AddEditAction(
            'add-news', 
            $arResult['ADD_NEWS']['ADD_LINK'], 
            CIBlock::GetArrayByID($arResult['ADD_NEWS']["IBLOCK_ID"], "ELEMENT_ADD")
        );
    ?>
    <ul id="<?=$this->GetEditAreaId('add-news');?>">
        <?foreach($arResult['CLASSIFICATOR_DATA'] as $item):?>
            <?
                $this->AddEditAction($item['ID'], $item['EDIT_LINK'], CIBlock::GetArrayByID($item["IBLOCK_ID"], "ELEMENT_EDIT"));
                $this->AddDeleteAction($item['ID'], $item['DELETE_LINK'], CIBlock::GetArrayByID($item["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => GetMessage('CT_BNL_ELEMENT_DELETE_CONFIRM')));
            ?>
            <li id="<?=$this->GetEditAreaId($item['ID']);?>">
                <b><?=$item['NAME'];?></b> - <?=$item['ACTIVE_FROM'];?> (<?=implode(', ', $item['SECTIONS']);?>)
                <?if (!empty($item['PRODUCTS'])):?>
                    <?
                        $htmlId = 'add-product' . uniqid();
                        $this->AddEditAction(
                            $htmlId, 
                            $arResult['ADD_PRODUCT']['ADD_LINK'], 
                            CIBlock::GetArrayByID($arResult['ADD_PRODUCT']["IBLOCK_ID"], "ELEMENT_ADD")
                        );
                    ?>
                    <ul id="<?=$this->GetEditAreaId($htmlId);?>">
                        <?foreach($item['PRODUCTS'] as $arProduct):?>
                            <?
                                $this->AddEditAction($item['ID'] . '-' . $arProduct['ID'], $arProduct['EDIT_LINK'], CIBlock::GetArrayByID($arProduct["IBLOCK_ID"], "ELEMENT_EDIT"));
                                $this->AddDeleteAction($item['ID'] . '-' . $arProduct['ID'], $arProduct['DELETE_LINK'], CIBlock::GetArrayByID($arProduct["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => GetMessage('CT_BNL_ELEMENT_DELETE_CONFIRM')));
                            ?>
                            <li id="<?=$this->GetEditAreaId($item['ID'] . '-' . $arProduct['ID']);?>">
                                <?=$arProduct['NAME'];?> 
                                - <?=$arProduct['PRICE'];?> 
                                - <?=$arProduct['MATERIAL'];?> 
                                - <?=$arProduct['ARTNUMBER'];?>
                                - <?=$arProduct['DETAIL_URL'];?>
                            </li>
                        <?endforeach;?>
                    </ul>
                <?endif;?>
            </li>
        <?endforeach;?>
    </ul>
<?endif;?>