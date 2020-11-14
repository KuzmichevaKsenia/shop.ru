<h3>Бренды</h3>
<?php include "message.tpl"; ?>
<?php include "pagination.tpl"; ?>
<p class="link_new">
    <a href="<?= $this->link_new ?>">Добавить новый бренд</a>
</p>
<table class="info">
    <tr>
        <th>ID</th>
        <th>Бренд</th>
        <th>Страна</th>
        <th>Описание</th>
        <th>Функции</th>
    </tr>
    <?php foreach ($this->table_data as $data) { ?>
        <tr>
            <td><?= $data["id"] ?></td>
            <td>
                <?= $data["title"] ?>
                <br/>
                <img class="img_brand" src="<?= $data["logo"] ?>" alt="<?= $data["title"] ?>"/>
            </td>
            <td><?= $data["country"] ?></td>
            <td><?= $data["description"] ?></td>
            <td>
                <a href="<?= $data["link_admin_edit"] ?>">Редактировать</a>
                <br/>
                <a href="<?= $data["link_admin_delete"] ?>" onclick="return confirm('Вы уверены, что хотите удалить элемент?')">Удалить</a>
            </td>
        </tr>
    <?php } ?>
</table>