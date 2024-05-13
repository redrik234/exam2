<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Оценка производительности ex2-11");
?>
<p>
    <p>
        <b>Самая ресурсоемкая страница</b>: /products/index.php
    </p>
    <p>
        Cреднее время выполнения(сек.): 0.3200
    </p>
    -----
    <p>
        Самый ресурсоемкий компонент на данной странице: bitrix:catalog.section
    </p>
    <p>
        Количество запросов: 28
    </p>
</p>
<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>