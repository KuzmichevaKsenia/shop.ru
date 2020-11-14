<h1 class="cartitle">Корзина</h1>
<?php if ($this->count > 0) { ?>
    <div class="cart-block">
        <div class="table-hat">
            <p class="cart-product-name-title">Товар</p>
            <p class="cart-product-number-title">Кол.-во</p>
            <p class="cart-product-price-title">Цена</p>
        </div>
        <?php for ($i = 0; $i < count($this->cart); $i++) { ?>
            <div class="cart-product">
                <a href="<?= $this->cart[$i]["link_to_product"] ?>">
                    <p class="cart-product-img">
                        <img src="<?= $this->cart[$i]["img"] ?>" alt="<?= $this->cart[$i]["title"] ?>"/>
                    </p>
                </a>
                <p class="cart-product-name">
                    <?= $this->cart[$i]["title"] ?>
                    <br>
                    <?= $this->cart[$i]["brand"] ?>
                    <?php if ($this->cart[$i]["size"] != "-") { ?>
                        <br>Размер: <?= $this->cart[$i]["size"] ?>
                    <?php } ?>
                </p>
                <p class="cart-product-number">
                    <a style="text-decoration:none;" href="<?= $this->cart[$i]["link_remove"] ?>">
                        <i> - </i>
                    </a>
                    <span><?= $this->cart[$i]["count"] ?> шт.</span>
                    <a style="text-decoration:none;" href="<?= $this->cart[$i]["link_add"] ?>">
                        <i> + </i>
                    </a>
                </p>
                <p class="cart-product-price"><?= $this->cart[$i]["cost"] ?> руб.</p>
                <p class="link-delete"><a href="<?= $this->cart[$i]["link_delete"] ?>">X</a></p>
            </div>
        <?php } ?>
    </div>
    <div class="cart-bottom">
        <!--<div class="discount-block">
        <p>*Введите промокод (если есть): </p>
        <p>
            <input type="text"name="discount" value="<?= $this->discount ?>"/>
        </p>
    </div>-->
        <div class="total"><p>Итого: <span><?= $this->amount ?> руб.</span></p></div>
        <!--<p class="left">
             <input type="image" src="images/cart_recalc.png" alt="Пересчитать" onmouseover="this.src='images/cart_recalc_active.png'" onmouseout="this.src='images/cart_recalc.png'"/>
        </p>-->
        <p class="right">
            <a href="<?= $this->link_order ?>">
                <img src="images/cart_order.png" alt="Оформить заказ"
                     onmouseover="this.src='images/cart_order_active.png'"
                     onmouseout="this.src='images/cart_order.png'"/>
            </a>
        </p>
        <!--<div class="note">
        <p>* При наличии карты постоянного покупателя введите в поле для промокода номер телефона, к которому привязана эта карта.</p>
        </div>-->
    </div>
<?php } else { ?>
    <div style="color: red;">В корзине еще нет ни одного товара</div>
<?php } ?>