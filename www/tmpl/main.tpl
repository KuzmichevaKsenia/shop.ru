<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" lang="ru">
<head>
    <title><?= $this->title ?></title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta name="description" content="<?= $this->meta_desc ?>"/>
    <meta name="keywords" content="<?= $this->meta_key ?>"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles/main.css" type="text/css"/>
    <link rel="stylesheet" href="styles/nubex.css" media="screen" type="text/css"/>
    <link rel="stylesheet" href="styles/nubexMobile.css" media="handheld" type="text/css"/>
    <link rel="shortcut icon" href="favicon.ico" type="image/x-icon">
</head>
<body>
<div id="container">
    <a id="header" href="<?= $this->index ?>"> <!-- x-lines.ru №20 !-->
        <img src="images/logo-info.png" alt="магазин дизайнерской женской одежды европейских брендов" width=850/>
    </a>
    <div id="topmenu">
        <div class="logo"></div>
        <a href="<?= $this->link_sale ?>" class="topmenu-links topmenu-links-1">РАСПРОДАЖА</a>
        <a href="<?= $this->link_help ?>" class="topmenu-links topmenu-links-2">ПОМОЩЬ</a>
        <a href="<?= $this->link_style ?>" class="topmenu-links topmenu-links-3">УСЛУГИ СТИЛИСТА</a>
        <a href="<?= $this->link_about ?>" class="topmenu-links topmenu-links-4">О МАГАЗИНЕ</a>
        <div class="cart">
            <span class="number-for-mobile"><?= $this->cart_count ?></span>
            <div class="text">
                <p class="title-line">Текущий заказ</p>
                <p class="p-lines">В корзине <span><?= $this->cart_count ?></span> <?= $this->cart_word ?><br/>на сумму
                    <span><?= $this->cart_amount ?></span> руб.</p>
            </div>
            <a href="<?= $this->cart_link ?>" class="link"><img src="images/cart.png" alt="Корзина"/></a>
        </div>
    </div>
    <div class="content">
        <input class="nav-burger__checkbox" type="checkbox" id="burger">
        <label class="nav-burger" for="burger">Категории</label>
        <nav id="sidebar">
            <div class="search">
                <form name="search" action="<?= $this->link_search ?>" method="get">
                    <table>
                        <tr>
                            <td><img class="loupe" src="images/loupe.png" alt=""/></td>
                            <td>
                                <input type="text" name="q" value="Поиск.."
                                       onfocus="if(this.value == 'Поиск..') this.value=''"
                                       onblur="if(this.value == '') this.value='Поиск..'"/>
                            </td>
                        </tr>
                    </table>
                </form>
            </div>
            <div id="items">
                <?php for ($i = 0; $i < count($this->items); $i++) { ?>
                    <a href='<?= $this->items[$i]["link"] ?>'><?= $this->items[$i]["title"] ?></a>
                <?php } ?>
            </div>
            <div id="brands">
                <?php for ($i = 0; $i < count($this->brands); $i++) { ?>
                    <a href='<?= $this->brands[$i]["link"] ?>'>
                        <img src='<?= $this->brands[$i]["logo"] ?>' alt='<?= $this->brands[$i]["title"] ?>'/>
                    </a>
                <?php } ?>
            </div>
        </nav>
        <div id="mainbar">
            <?php include "content_" . $this->content . ".tpl"; ?>
        </div>
    </div>
    <div id="footer">
            <span>
				<a href="<?= $this->link_sale ?>">Распродажа</a>
				<a href="<?= $this->link_help ?>">Доставка и оплата</a>
				<a href="<?= $this->link_style ?>">Услуги стилиста</a>
				<a href="<?= $this->link_about ?>">О нас</a>
            </span>
        <br/>
        <div>
            <h2>Адрес магазина</h2>
            <p>г. Москва, ул. Московская, 1</p>
            <p>ст. м. Московская, ТЦ "Shop"</p>
            <p>Ежедневно с 10:00 до 21:00</p>
        </div>
        <div>
            <h2>Контакты</h2>
            <p>тел.: 8 (555) 555-55-55 Shop</p>
            <p>также доступны WhatsApp и Viber</p>
            <p>e-mail: shop@mail.ru</p>
        </div>
    </div>
</div>
<script src="js/jquery-3.4.1.js"></script>
<script type="text/javascript" src="js/functions.js"></script>
</body>
</html>
