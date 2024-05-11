<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Оценка производительности");
?>
<p>
    <p>
        <b>Cамую ресурсоемкая страница</b>: /products/index.php
    </p>
    <p>
        <b>Процент нагрузки</b>: 29.81%
    </p>
</p>
------
<p>
    <p>
       <b>Простой компонент</b>
    </p>
    <p>
        <b>Начальный размер кеша</b>: 102 КБ
    </p>
    <p>
        <b>Оптимизированный размер кеша</b>: 62 КБ
    </p>
    <p>
        <b>Разница размера кеша</b>: 102 КБ - 62 КБ = 40 КБ
    </p>
</p>



<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>