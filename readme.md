# Интернет-магазин женской одежды
Интернет-магазин на PHP без использования фреймворков. Адаптивный дизайн. Собственный движок.
![Image not found](images/main-desktop-page.jpg)
![Image not found](images/main-mobile-page.jpg)
![Image not found](images/sidebar-mobile-page.jpg)
## Функционал сайта

- Разделы (блузы, платья, юбки и т.д.)
- Бренды
- Корзина
- Форма оформления заказа
- Поиск
- Скидки


## Функционал панели администратора

- Управление товарами, разделами и брендами
- Управление заказами
- Управление купонами
- Статистика


## Технологии

- HTML, CSS и JS
- PHP и MySQL


## Структура движка

![Image not found](images/structure.png)

## Установка

1. Размещаем папку сайта на веб-сервере
2. В СУБД запускаем [скрипт создания бд](localhost.sql)

<i>Конифги содержит класс [Config](www/lib/config_class.php). Дефолтный логин и пароль панели администратора (доступна по пути shop.ru/admin) - Admin 123.</i>

## Скриншоты

| ![Image not found](images/cart-desktop-page.jpg) | 
|:--:| 
| *Корзина* |

| ![Image not found](images/order-desktop-page.jpg) | 
|:--:| 
| *Оформление заказа* |

| ![Image not found](images/admin-orders-desktop-page.jpg) | 
|:--:| 
| *Список заказов в панели администратора* |

| ![Image not found](images/admin-product-desktop-page.jpg) | 
|:--:| 
| *Редактирование товара в панели администратора* |