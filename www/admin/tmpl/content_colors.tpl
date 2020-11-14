<h3>Цвета</h3>
<?php include "message.tpl"; ?>
<?php include "pagination.tpl"; ?>
<p class="link_new">
    <a href="<?= $this->link_new ?>">Добавить новый цвет</a>
</p>
<table class="info">
    <tr>
        <th>Название</th>
        <th>Цвет</th>
        <th>Функции</th>
    </tr>
    <?php foreach ($this->table_data as $data) { ?>
        <tr>
            <td>
                <?= $data["title"] ?>
            </td>
            <td>
                <span class="span-color" style="background:<?= $data["color"] ?>;"></span>
            </td>
            <td>
                <a href="<?= $data["link_admin_edit"] ?>">Редактировать</a>
                <br/>
                <a href="<?= $data["link_admin_delete"] ?>" onclick="return confirm('Вы уверены, что хотите удалить элемент?')">Удалить</a>
            </td>
        </tr>
    <?php } ?>
</table>