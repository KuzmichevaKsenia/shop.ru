<h3><?= $this->form_title ?></h3>
<?php include "message.tpl"; ?>
<div class="form">
    <form name="product" action="<?= $this->action ?>" method="post" enctype="multipart/form-data">
        <table>
            <tr>
                <td>Название:</td>
                <td>
                    <input type="text" name="color_title" value="<?= $this->color_title ?>"/>
                </td>
            </tr>
            <tr>
                <td>HEX-код цвета:</td>
                <td>
                    <input type="text" name="color" value="<?= $this->color ?>"/>
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