<h3>Товары</h3>
<?php include "message.tpl"; ?>
<?php include "pagination.tpl"; ?>
<p class="link_new">
    <a href="<?= $this->link_new ?>">Добавить новый товар</a>
</p>
<table class="info">
    <tr>
        <th>№</th>
        <th>Товар</th>
        <th>Дата добавления</th>
        <th>Функции</th>
    </tr>
    <?php $i = 1;
    foreach ($this->table_data as $data) { ?>
        <tr>
            <td><?php echo ($this->page_number - 1) * 10 + $i++ ?></td>
            <td>
                Название: <a href="<?= $data["link"] ?>" target="_blank"><?= $data["title"] ?></a><br>
                Артикул: <?= $data["code_name"] ?><br>
                Бренд: <?= $data["brand"] ?><br>
                Коллекция: <?= $data["collection"] ?><br>
                Состав: <?= $data["composition"] ?><br>
                Цена: <?php if ($data["price"] == $data["before_sale_price"]) {
                    echo $data["price"]; ?> рублей
                <?php } else { ?>
                    <p class="old-price"><?= $data["before_sale_price"] ?> рублей</p>
                    <p class="sale-price"><?= $data["price"] ?> рублей</p>
                <?php } ?>
            </td>
            <td><?= $data["date"] ?></td>
            <td>
                <a href="<?= $data["link_admin_edit"] ?>">Редактировать</a>
                <br/><br/>
                <a style="color:red;" href="<?= $data["link_admin_delete"] ?>" onclick="return confirm('Вы уверены, что хотите удалить элемент?')">Удалить</a>
            </td>
        </tr>
    <?php } ?>
</table>