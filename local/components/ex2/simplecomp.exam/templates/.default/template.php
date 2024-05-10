<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<p>---</p>
<p><b><?=GetMessage("SIMPLECOMP_EXAM2_CAT_TITLE")?></b></p>
<?if (!empty($arResult['CLASSIFICATOR_DATA'])):?>
    <ul>
        <?foreach($arResult['CLASSIFICATOR_DATA'] as $item):?>
            <li>
                <b><?=$item['NAME'];?></b> - <?=$item['ACTIVE_FROM'];?> (<?=implode(', ', $item['SECTIONS']);?>)
                <?if (!empty($item['PRODUCTS'])):?>
                    <ul>
                        <?foreach($item['PRODUCTS'] as $arProduct):?>
                            <li>
                                <?=$arProduct['NAME'];?> 
                                - <?=$arProduct['PRICE'];?> 
                                - <?=$arProduct['MATERIAL'];?> 
                                - <?=$arProduct['ARTNUMBER'];?>
                            </li>
                        <?endforeach;?>
                    </ul>
                <?endif;?>
            </li>
        <?endforeach;?>
    </ul>
<?endif;?>