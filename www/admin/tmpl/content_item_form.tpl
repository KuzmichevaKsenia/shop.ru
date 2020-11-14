<h3><?= $this->form_title ?></h3>
<?php include "message.tpl"; ?>
<div class="form">
    <form name="product" action="<?= $this->action ?>" method="post" enctype="multipart/form-data">
        <table>
            <tr>
                <td>Название:</td>
                <td>
                    <input type="text" name="item_title" value="<?= $this->item_title ?>"/>
                </td>
            </tr>
            <tr>
                <td>Изображение:</td>
                <td>
                    <input type="file" name="img"/>
                </td>
            </tr>
            <tr>
                <td>
                    <input type="hidden" name="id" value="<?= $this->id ?>"/>
                    <input type="hidden" name="func" value="<?= $this->func ?>"/>
                    <input type="submit" value="Отправить"/>
                </td>
            </tr>
        </table>
    </form>
</div>