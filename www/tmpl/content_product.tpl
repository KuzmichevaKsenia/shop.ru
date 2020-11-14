<?php for ($i = 0; $i < count($this->product["units"]); $i++) { ?>
    <div id="unit-img-<?= $this->product["units"][$i]["id"] ?>"
         class="product-image<?php if ($i == 0) { ?> active-img<?php } ?>">
        <img src="<?= $this->product["units"][$i]["img"] ?>" alt="Фото не найдено"/>
    </div>
<?php } ?>
<div class="description">
    <h1 class="product-name"><?= $this->product["title"] ?></h1>
    <p class="product-title">Артикул</p>
    <p class="product-code-name"><?= $this->product["code_name"] ?></p>
    <p class="product-title">Бренд</p>
    <p class="product-content"><a href="<?= $this->product["brand_link"] ?>"><?= $this->product["brand"] ?></a></p>
    <p class="product-title">Коллекция</p>
    <p class="product-content"><?= $this->product["collection"] ?></p>
    <p class="product-title">Цвет</p>
    <p class="product-content">
        <?php for ($i = 0; $i < count($this->product["units"]); $i++) { ?>
            <span id="unit-color-<?= $this->product["units"][$i]["id"] ?>"
                  class="span-color<?php if ($i == 0) { ?> active-color<?php } ?>"
                  style="background:<?= $this->product["units"][$i]["color"] ?>;"
                  onclick="changeColor(this);">
            </span>
        <?php } ?>
    </p>
    <?php for ($i = 0; $i < count($this->product["units"]); $i++) {
        $sizes = $this->product["units"][$i]["sizes"]; ?>
        <div id="div-sizes-<?= $this->product["units"][$i]["id"] ?>"
             class="div-sizes<?php if ($i == 0 && stristr($this->product["units"][$i]["size_ids"], '25,') === FALSE) echo "active-sizes"; ?>">
            <p class="product-title">Размер</p>
            <p class="product-content">
                <?php for ($j = 0; $j < count($sizes); $j++) {
                    if ($sizes[$j]["size"] != '') { ?>
                        <span id="unit-size-<?= $this->product[" units"][$i]["id"] ?>-<?= $sizes[$j]["id"] ?>"
                              class="span-size<?php if ($j == 0) { ?> active-size<?php } ?>"
                              onclick="changeSize(this);">
                            <?= $sizes[$j]["size"] ?>
                        </span>
                    <?php } ?>
                <?php } ?>
            </p>
        </div>
    <?php } ?>
    <p class="product-title">Материал</p>
    <p class="product-content"><?= $this->product["composition"] ?></p>
    <p class="product-title">Наличие товара</p>
    <p class="product-content">
        <?php for ($i = 0; $i < count($this->product["units"]); $i++) { ?>
            <div id="unit-availability-<?= $this->product[" units"][$i]["id"] ?>"
                 class="div-availability<?php if ($i == 0) { ?> active-availability<?php } ?>">
                <?= $this->product["units"][$i]["availability"] ?>
            </div>
        <?php } ?>
    </p>
    <p class="topay">
        <a id="prod-link-cart" class="link-cart" href="<?= $this->product["units"][0]["link_cart"] ?>">ДОБАВИТЬ В КОРЗИНУ</a>
        <?php if ($this->product["price"] == $this->product["before_sale_price"]) { ?>
            <span class="product-price"><?= $this->product["price"] ?> руб.</span>
        <?php } else { ?>
            <span style="float: right;">
				<span class="old-price"><?= $this->product["before_sale_price"] ?> руб.</span>
				<br>
				<span class="sale-price"><?= $this->product["price"] ?> руб.</span>
			</span>
        <?php } ?>
    </p>
</div>
<div class="others">
    <p class="others-title">Вам может быть интересно:</p>
    <div class="products">
        <?php if ($this->products[0]["id"]) for ($i = 0; $i < count($this->products); $i++) { ?>
            <a href="<?= $this->products[$i]["link"] ?>" class="product">
                <p class="img">
                    <img src="<?= $this->products[$i]["units"][0]["img"] ?>"
                         alt="<?= $this->products[$i]["title"] ?>"/>
                </p>
                <p class="name"><?= $this->products[$i]["title"] ?></p>
                <p class="brand"><?= $this->products[$i]["brand"] ?></p>
                <?php if ($this->products[$i]["price"] == $this->products[$i]["before_sale_price"]) { ?>
                    <p class="price"><?= $this->products[$i]["price"] ?> руб.</p>
                <?php } else { ?>
                    <p class="price"><span class="old-price"><?= $this->products[$i]["before_sale_price"] ?> руб.</span><span
                                class="sale-price"><?= $this->products[$i]["price"] ?> руб.</span></p>
                <?php } ?>
            </a>
        <?php } ?>
    </div>
</div>