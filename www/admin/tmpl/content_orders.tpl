<h3>Заказы</h3>
<?php include "message.tpl"; ?>
<?php include "pagination.tpl"; ?>
<p class="link_new">
    <a href="<?= $this->link_new ?>">Добавить новый заказ</a>
</p>
<table class="info">
    <tr>
        <th>ID</th>
        <th>Заказ</th>
        <th>Способ доставки</th>
        <th>Цена</th>
        <th>Контакты</th>
        <th>Примечание</th>
        <th>Дата заказа</th>
        <th>Дата получения</th>
        <th>Функции</th>
    </tr>
    <?php foreach ($this->table_data as $data) { ?>
        <tr>
            <td><?= $data["id"] ?></td>
            <td>
                <?php foreach ($data["products"] as $product) { ?>
                    <a href="<?= $product["link"] ?>"
                       target="_blank"><?= $product["title"] ?> <?= $product["brand"] ?></a><br>
                    <span>Артикул: <?= $product["code_name"] ?></span><br>
                    <span>Размер: <?= $product["size"] ?></span><br>
                    <span>Кол-во: <?= $product["count"] ?></span><br>
                    <span>Цвет: <?= $product["color_title"] ?></span><br>
                    <img class="img" src="<?= $product["img"] ?>" alt="Товар удален"/>
                    <hr>
                <?php } ?>
            </td>
            <td><?php if ($data["delivery"] == 0) { ?>Доставка<?php } else { ?>Самовывоз<?php } ?></td>
            <td><?= $data["price"] ?> руб.</td>
            <td>
                <p>ФИО: <?= $data["name"] ?></p>
                <p>Телефон: <?= $data["phone"] ?></p>
                <p>E-mail: <?= $data["email"] ?></p>
                <p>Адрес: <?php echo $data["address"] ? $data["address"] : "не указан" ?></p>
            </td>
            <td><?php echo $data["notice"] ? $data["notice"] : "не указано" ?></td>
            <td><?= $data["date_order"] ?></td>
            <td><?php if ($data["date_send"] == 0) { ?>Не получено<?php } else { ?><?= $data["date_send"] ?><?php } ?></td>
            <td>
                <a href="<?= $data["link_admin_edit"] ?>">Редактировать</a>
                <br/><br/>
                <a
                        href="<?= $data["link_admin_delete"] ?>"
                        onclick="return confirm('Вы уверены, что хотите удалить элемент?')"
                        style="color:red"
                >
                    Удалить
                </a>
            </td>
        </tr>
    <?php } ?>
</table>