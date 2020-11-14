<h3><?= $this->form_title ?></h3>
<?php include "message.tpl"; ?>
<div class="form">
    <form name="order" action="<?= $this->action ?>" method="post">
        <table id="orders" class="info">
            <tr>
                <th>Товар</th>
                <th>Цвет</th>
                <th>Размер</th>
                <th>Количество</th>
                <th style="border-top-style:hidden; border-right-style:hidden; border-bottom-style:hidden; background:none"></th>
            </tr>
            <?php for ($i = 0; $i < count($this->products); $i++) { ?>
                <tr>
                    <td>
                        <select onchange="refreshProduct(this)">
                            <?php foreach ($this->products_all as $product_all) { ?>
                                <option
                                        value="<?= $product_all["id"] ?>"
                                    <?php if ($product_all["id"] == $this->products[$i]["product_id"]) { ?> selected<?php } ?>
                                        data-units="<?php $dataUnits = "";
                                        foreach ($product_all["units"] as $product_units_all) {
                                            $dataUnits .= $product_units_all["id"] . "%" . $product_units_all["color_title"] . "%" . $product_units_all["img"] . "%";
                                            foreach ($product_units_all["sizes"] as $product_units_size_all) {
                                                $dataUnits .= $product_units_size_all["id"] . ":" . $product_units_size_all["size"] . ",";
                                            }
                                            $dataUnits = substr_replace($dataUnits, ';', -1);
                                        }
                                        echo $dataUnits; ?>"
                                >
                                    <?= $product_all["code_name"] . " " . $product_all["title"] . " " . $product_all["brand"] . " " . $product_all["price"] . "р" ?>
                                </option>
                            <?php } ?>
                        </select>
                    </td>
                    <td><select name="unit_<?= $i ?>" onchange="refreshUnit(this)">
                            <?php foreach ($this->products_all[$this->products[$i]["product_id"]]["units"] as
                                           $product_units_all) { ?>
                                <option
                                        value="<?= $product_units_all[" id
                        "] ?>"
                                    <?php if ($product_units_all["id"] == $this->products[$i]["unit_id"]) { ?> selected<?php } ?>
                                        data-img="<?= $product_units_all["img"] ?>"
                                        data-sizes="<?php foreach ($product_units_all["sizes"] as $product_units_size_all) {
                                            echo $product_units_size_all["id"] . ":" . $product_units_size_all["size"] . ",";
                                        } ?>
                        "
                                >
                                    <?= $product_units_all["color_title"] ?>
                                </option>
                            <?php } ?>
                        </select>
                        <br>
                        <img class="img" src="<?= $this->products[$i]["img"] ?>" alt="фото не найдено"/>
                    </td>
                    <td><select name="unit_size_<?= $i ?>">
                            <?php foreach ($this->
                            products_all[$this->products[$i]["product_id"]]["units"][$this->products[$i]["unit_id"]]["sizes"]
                                           as $product_unit_sizes_all) { ?>
                                <option
                                        value="<?= $product_unit_sizes_all["id"] ?>"
                                    <?php if ($product_unit_sizes_all["size"] == $this->products[$i]["size"]) { ?>
                                        selected<?php } ?>
                                >
                                    <?= $product_unit_sizes_all["size"] ?>
                                </option>
                            <?php } ?>
                        </select>
                    </td>
                    <td>
                        <input type="text" name="unit_size_count_<?= $i ?>"
                               value="<?= $this->products[$i]["count"] ?>"/> шт.
                    </td>
                    <td style="border-top-style:hidden; border-right-style:hidden; border-bottom-style:hidden">
                        <p>
                            <a style="color:#ff0000;" href="#"
                               onclick="return deleteItem(this.parentNode.parentNode.parentNode)">Удалить</a>
                        </p>
                    </td>
                </tr>
            <?php } ?>
        </table>
        <p>
            <a href="#" onclick="return addItem()">Добавить позицию</a>
        </p>
        <hr style="width:50%; margin-bottom:40px">
        <table>
            <tr>
                <td>Способ доставки:</td>
                <td>
                    <select name="delivery">
                        <option value="0"
                                <?php if ($this->delivery == 0) { ?>selected="selected"<?php } ?>>Доставка
                        </option>
                        <option value="1"
                                <?php if ($this->delivery == 1) { ?>selected="selected"<?php } ?>>Самовывоз
                        </option>
                    </select>
                </td>
            </tr>
            <tr>
                <td>Цена:</td>
                <td>
                    <input type="text" name="price" value="<?= $this->price ?>"/> рублей
                </td>
            </tr>
            <tr>
                <td>ФИО:</td>
                <td>
                    <input type="text" name="name" value="<?= $this->name ?>"/>
                </td>
            </tr>
            <tr>
                <td>Телефон:</td>
                <td>
                    <input type="text" name="phone" value="<?= $this->phone ?>"/>
                </td>
            </tr>
            <tr>
                <td>E-mail:</td>
                <td>
                    <input type="text" name="email" value="<?= $this->email ?>"/>
                </td>
            </tr>
            <tr>
                <td>Адрес:</td>
                <td>
                    <textarea name="address" cols="60" rows="5"><?= $this->address ?></textarea>
                </td>
            </tr>
            <tr>
                <td>Примечание:</td>
                <td>
                    <textarea name="notice" cols="60" rows="5"><?= $this->notice ?></textarea>
                </td>
            </tr>
            <tr>
                <td>Статус:</td>
                <td>
                    <select name="is_send">
                        <option value="0"
                                <?php if ($this->date_send == 0) { ?>selected="selected"<?php } ?>>Не получено
                        </option>
                        <option value="1"
                                <?php if ($this->date_send != 0) { ?>selected="selected"<?php } ?>>Получено
                        </option>
                    </select>
                </td>
            </tr>
        </table>
        <hr style="width:50%; margin-top:20px; margin-bottom:20px">
        <input type="hidden" name="id" value="<?= $this->id ?>"/>
        <input type="hidden" name="func" value="<?= $this->func ?>"/>
        <input type="submit" value="Отправить"/>
    </form>
</div>
<script>
    const Row = '<td><select onchange="refreshProduct(this)">' +
        '<?php $firstPr = true; $selectedProdUnits = array(); foreach($this->products_all as $product_all) { ?><option value="<?=$product_all["id"]?>"' +
        '<?php if ($firstPr) {
            echo " selected";
            $firstPr = false;
            $selectedProdUnits = $product_all["units"];
        } ?> ' +
        'data-units="<?php $dataUnits = ""; foreach ($product_all["units"] as $product_units_all) {
            $dataUnits .= $product_units_all["id"] . "%" . $product_units_all["color_title"] . "%" . $product_units_all["img"] . "%";
            foreach ($product_units_all["sizes"] as $product_units_size_all) {
                $dataUnits .= $product_units_size_all["id"] . ":" . $product_units_size_all["size"] . ",";
            }
            $dataUnits = substr_replace($dataUnits, ";", -1);
        } echo $dataUnits; ?>">' +
        '<?=$product_all["code_name"] . " " . $product_all["title"] . " " . $product_all["brand"] . " " . $product_all["price"] . "р"?></option><?php } ?></select></td>' +
        '<td><select name="unit_#id#" onchange="refreshUnit(this)">' +
        '<?php $firstUn = true; $selectedProdUnitSizes = array(); $selectedUnitImg = ""; foreach($selectedProdUnits as $product_units_all) { ?><option value="<?=$product_units_all["id"]?>"' +
        '<?php if ($firstUn) {
            echo " selected";
            $firstUn = false;
            $selectedProdUnitSizes = $product_units_all["sizes"];
            $selectedUnitImg = $product_units_all["img"];
        } ?> data-img="<?=$product_units_all["img"]?>" ' +
        'data-sizes="<?php foreach ($product_units_all["sizes"] as $product_units_size_all) {
            echo $product_units_size_all["id"] . ":" . $product_units_size_all["size"] . ",";
        } ?>">' +
        '<?=$product_units_all["color_title"]?></option><?php } ?></select><br><img class="img" src="<?=$selectedUnitImg?>" alt="фото не найдено" /></td>' +
        '<td><select name="unit_size_#id#"><?php $firstSz = true; foreach($selectedProdUnitSizes as $product_unit_sizes_all) { ?><option value="<?=$product_unit_sizes_all["id"]?>"<?php if ($firstSz) {
            echo " selected";
            $firstSz = false;
        } ?>><?=$product_unit_sizes_all["size"]?></option><?php } ?></select></td>' +
        '<td><input type="text" name="unit_size_count_#id#" value="1" /> шт.</td>' +
        '<td style="border-top-style:hidden; border-right-style:hidden; border-bottom-style:hidden"><p><a style="color:#ff0000;" href="#" onclick="return deleteItem(this.parentNode.parentNode.parentNode)">Удалить</a></p></td>';
</script>

