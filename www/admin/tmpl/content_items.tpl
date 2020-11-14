<h3>Разделы</h3>
<?php include "message.tpl"; ?>
<?php include "pagination.tpl"; ?>
<p class="link_new">
    <a href="<?= $this->link_new ?>">Добавить новый раздел</a>
</p>
<table class="info">
    <tr>
        <th>ID</th>
        <th>Раздел</th>
        <th>Функции</th>
    </tr>
    <?php foreach ($this->table_data as $data) { ?>
        <tr>
            <td><?= $data["id"] ?></td>
            <td>
                <?= $data["title"] ?>
                <br/>
                <img class="img_item" src="<?= $data["img"] ?>" alt="<?= $data["title"] ?>"/>
            </td>
            <td>
                <a href="<?= $data["link_admin_edit"] ?>">Редактировать</a>
                <br/>
                <a href="<?= $data["link_admin_delete"] ?>" onclick="return confirm('Вы уверены, что хотите удалить элемент?')">Удалить</a>
            </td>
        </tr>
    <?php } ?>
</table>