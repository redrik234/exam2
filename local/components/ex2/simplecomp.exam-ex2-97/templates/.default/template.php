<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<p>---</p>
<p><b><?=GetMessage("SIMPLECOMP_EXAM2_AUTHOR_TITLE")?></b></p>

<?if (!empty($arResult['AUTHOR_DATA'])):?>
    <ul>
        <?foreach($arResult['AUTHOR_DATA'] as $user):?>
            <li>
                [<?=$user['ID'];?>] - <?=$user['LOGIN'];?>
            </li>
            <?if (!empty($user['NEWS'])):?>
                <ul>
                    <?foreach($user['NEWS'] as $news):?>
                        <li>
                            <?= $news['NAME'];?> - <?= $news['ACTIVE_FROM'];?>
                        </li>
                    <?endforeach;?>
                </ul>
            <?endif;?>
        <?endforeach;?>
    </ul>
<?endif;?>