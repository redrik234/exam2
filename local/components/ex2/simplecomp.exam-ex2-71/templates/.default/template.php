<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<p>---</p>
<p><b><?=GetMessage("SIMPLECOMP_EXAM2_CAT_TITLE")?></b></p>
<?if (!empty($arResult['CLASSIFICATOR_DATA'])):?>
    <ul>
        <?foreach($arResult['CLASSIFICATOR_DATA'] as $item):?>
            <li>
                <b><?=$item['NAME'];?></b>
                <?if (!empty($item['PRODUCTS'])):?>
                    <ul>
                        <?foreach($item['PRODUCTS'] as $product):?>
                            <li>
                                <?=$product['NAME'];?> 
                                - <?=$product['PRICE'];?> 
                                - <?=$product['MATERIAL'];?> 
                                - <?=$product['ARTNUMBER'];?> 
                                - <a href="<?=$product['DETAIL_URL'];?>"><?=$product['DETAIL_URL'];?></a>
                            </li>
                        <?endforeach;?>
                    </ul>
                <?endif;?>
            </li>
        <?endforeach;?>
    </ul>
<?endif;?>