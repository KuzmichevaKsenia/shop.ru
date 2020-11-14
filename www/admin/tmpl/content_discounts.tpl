<h3>Купоны</h3>
<?php include "message.tpl"; ?>
<?php include "pagination.tpl"; ?>
<p class="link_new">
    <a href="<?= $this->link_new ?>">Добавить новый купон</a>
</p>
<table class="info">
    <tr>
        <th>ID</th>
        <th>Код</th>
        <th>Размер скидки</th>
        <th>Функции</th>
    </tr>
    <?php foreach ($this->table_data as $data) { ?>
        <tr>
            <td><?= $data["id"] ?></td>
            <td><?= $data["code"] ?></td>
            <td><?= ($data["value"] * 100) ?>%</td>
            <td>
                <a href="<?= $data["link_admin_edit"] ?>">Редактировать</a>
                <br/>
                <a href="<?= $data["link_admin_delete"] ?>" onclick="return confirm('Вы уверены, что хотите удалить элемент?')">Удалить</a>
            </td>
        </tr>
    <?php } ?>
</table>