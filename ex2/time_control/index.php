<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Оценка производительности ex2-10");
?>
<p>
    <p>
        <b>Самая ресурсоемкая страница</b>: /products/index.php
    </p>
    <p>
        Нагрузка: 30.46%
    </p>
    <p>
        Среднее время (сек.): 0.3182
    </p>
    -----
    <p>
        Самый ресурсоемкий компонент на данной странице: bitrix:catalog
    </p>
    <p>
        Среднее время (сек.): 0.0677
    </p>
</p>
<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>