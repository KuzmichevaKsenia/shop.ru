<h3><?= $this->form_title ?></h3>
<?php include "message.tpl"; ?>
<div class="form">
    <form name="product" action="<?= $this->action ?>" method="post" enctype="multipart/form-data">
        <table>
            <tr>
                <td>Артикул:</td>
                <td>
                    <input type="text" name="code_name" value="<?= $this->code_name ?>"/>
                </td>
            </tr>
            <tr>
                <td>Раздел:</td>
                <td>
                    <select name="item_id">
                        <?php foreach ($this->items as $item) { ?>
                            <option value="<?= $item["id"] ?>" <?php if ($item["id"] == $this->item_id) { ?>selected="selected"<?php } ?>
                            ><?= $item["title"] ?></option>
                        <?php } ?>
                    </select>
                </td>
            </tr>
            <tr>
                <td>Бренд:</td>
                <td>
                    <select name="brand_id">
                        <?php foreach ($this->brands as $brand) { ?>
                            <option value="<?= $brand["id"] ?>" <?php if ($brand["id"] == $this->brand_id) { ?>selected="selected"<?php } ?>
                            ><?= $brand["title"] ?></option>
                        <?php } ?>
                    </select>
                </td>
            </tr>
            <tr>
                <td>Название:</td>
                <td>
                    <input type="text" name="pr_title" value="<?= $this->pr_title ?>"/>
                </td>
            </tr>
            <tr>
                <td>Коллекция:</td>
                <td>
                    <input type="text" name="collection" value="<?= $this->collection ?>"/>
                </td>
            </tr>
            <tr>
                <td>Состав:</td>
                <td>
                    <input type="text" name="composition" value="<?= $this->composition ?>"/>
                </td>
            </tr>
            <tr>
                <td>Цена:</td>
                <td>
                    <input type="text" name="price" value="<?= $this->price ?>"/> рублей
                </td>
            </tr>
            <tr>
                <td>Старая цена (для распродажи):</td>
                <td>
                    <input type="text" name="before_sale_price" value="<?= $this->before_sale_price ?>"/> рублей
                </td>
            </tr>
        </table>
        <hr style="width: 900px">
        <h4>Единицы товара</h4>
        <table id="units-table" class="simple-table">
            <tr>
                <td>Цвет</td>
                <td>Изображение</td>
                <td>Размеры</td>
                <td>Наличие товара</td>
                <td style="border-top-style:hidden; border-right-style:hidden; border-bottom-style:hidden"></td>
            </tr>
            <?php if ($this->units != false) {
                foreach ($this->units as $unit) { ?>
                    <tr id="unittr-<?= $unit["id"] ?>">
                        <td>
                            <select name="color_id-<?= $unit[" id"] ?>">
                                <?php foreach ($this->colors as $color) { ?>
                                    <option
                                            value="<?= $color["id"] ?>"
                                        <?php if ($color["id"] == $unit["color_id"]) echo " selected"; ?>
                                    >
                                        <?= $color["title"] ?>
                                    </option>
                                <?php } ?>
                            </select>
                        </td>
                        <td>
                            <?php if ($unit["img"]) { ?>
                                <img src="<?= $unit["img"] ?>" width="74px" height="112"/>
                                <br>
                            <?php } ?>
                            <input type="file" name="img-<?= $unit["id"] ?>"/>
                        </td>
                        <td>
                            <input type="hidden" class="size-input" id="size-<?= $unit["id"] ?>"
                                   name="size_ids-<?= $unit["id"] ?>"
                                   value="<?= $unit["size_ids"] ?>"/>
                            <?php $j = 0;
                            foreach ($this->sizes as $size) {
                                if ($j != 0 && $j % 5 == 0) echo "<br>";
                                $j++; ?>
                                <span style="border: 1px solid #000;">
                                    <input
                                            type="checkbox"
                                            id="sz-<?= $unit["id"] ?>-<?= $size["id"] ?>"
                                            value="<?= $size["id"] ?>"
                    <?php if (key_exists($size["id"], $unit["sizes"])) echo " checked"; ?>
                    onclick="checkSize(this);"
                                    >
                                    <label for="sz-<?= $unit["id"] ?>-<?= $size["id"] ?>"><?= $size["size"] ?></label>
                                </span>
                            <?php } ?>
                        </td>
                        <td>
                            <select name="availability-<?= $unit["id"] ?>">
                                <option value="В наличии"
                                    <?php if ($unit["availability"] == "В наличии") { ?> selected<?php } ?>>В наличии
                                </option>
                                <option value="Ожидается"
                                    <?php if ($unit["availability"] == "Ожидается") { ?> selected<?php } ?>>Ожидается
                                </option>
                                <option value="Под заказ"
                                    <?php if ($unit["availability"] == "Под заказ") { ?> selected<?php } ?>>Под заказ
                                </option>
                            </select>
                        </td>
                        <td style="border-top-style:hidden; border-right-style:hidden; border-bottom-style:hidden">
                            <a style="color:#ff0000; margin-left: 10px;" href="javascript:void(0);"
                               onclick="deleteUnitRow(this.parentNode.parentNode)">Удалить</a>
                        </td>
                    </tr>
                <?php }
            } ?>
        </table>
        <br>
        <a style="color:#008000" href="javascript:void(0);" onclick="addNewRow()">Добавить единицу товара</a>
        <input type="hidden" name="id" value="<?= $this->id ?>"/>
        <input type="hidden" name="func" value="<?= $this->func ?>"/>
        <hr style="width: 900px">
        <br>
        <input type="submit" value="Отправить"/>
    </form>
</div>
<script>
    const ROW = '<td><select name="color_id-#id#">' +
        '<?php $first = true; foreach ($this->colors as $color) { ?><option value="<?=$color["id"]?>"<?php if ($first) {
            echo " checked";
            $first = false;
        }?>><?=$color["title"]?></option><?php } ?>' +
        '</select></td><td><input type="file" name="img-#id#" /></td><td><input type="hidden" class="size-input" id="size-#id#" name="size_ids-#id#" value="" />' +
        '<?php $j = 0; foreach ($this->sizes as $size) { if ($j != 0 && $j % 5 == 0) echo "<br>"; $j++;?><span style="border: 1px solid #000;"><input type="checkbox" id="sz-#id#-<?=$size["id"]?>" value="<?=$size["id"]?>" onclick="checkSize(this);"><label for="sz-#id#-<?=$size["id"]?>"><?=$size["size"]?></label></span><?php } ?>' +
        '</td><td><select name="availability-#id#"><option value="В наличии" checked>В наличии</option><option value="Ожидается">Ожидается</option><option value="Под заказ">Под заказ</option></select></td><td style="border-top-style:hidden; border-right-style:hidden; border-bottom-style:hidden"><a style="color:#ff0000; margin-left: 10px;" href="javascript:void(0);" onclick="deleteUnitRow(this.parentNode.parentNode)">Удалить</a></td>';
</script>