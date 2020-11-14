<div class="products">
    <?php if ($this->products[0]["id"])
        for ($i = 0; $i < count($this->products); $i++) { ?>
            <a href="<?= $this->products[$i]["link"] ?>" class="product">
                <p class="img">
                    <img src="<?= $this->products[$i]["units"][0]["img"] ?>" alt=""/>
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
			