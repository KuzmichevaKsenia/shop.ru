<div id="order">
    <h1>Оформление заказа</h1>
    <?php include "message.tpl"; ?>
    <form name="order" action="<?= $this->action ?>" method="post">
        <div>
            <span>ФИО: </span>
            <input type="text" name="name" value="<?= $this->name ?>"/>
        </div>
        <div>
            <span>Телефон: </span>
            <input type="text" name="phone" value="<?= $this->phone ?>"/>
        </div>
        <div>
            <span>E-mail: </span>
            <input type="text" name="email" value="<?= $this->email ?>"/>
        </div>
        <div>
            <span>Доставка: </span>
            <select name="delivery" onchange="changeDelivery(this)">
                <option value="">выберите, пожалуйста...</option>
                <option value="0"
                        <?php if ($this->delivery == "0") { ?>selected="selected"<?php } ?>>Доставка
                </option>
                <option value="1"
                        <?php if ($this->delivery == "1") { ?>selected="selected"<?php } ?>>Самовывоз
                </option>
            </select>
        </div>
        <div id="address" class="big-block">
            <p>Полный адрес:</p>
            <p><textarea name="address" rows="3"><?= $this->address ?></textarea></p>
        </div>
        <div class="big-block">
            <p>Примечание к заказу:</p>
            <p><textarea name="notice" rows="5"><?= $this->notice ?></textarea></p>
        </div>
        <p class="order-button">
            <input type="hidden" name="func" value="order"/>
            <input type="image" src="images/order_end.png" alt="Закончить оформление заказа"
                   onmouseover="this.src='images/order_end_active.png'" onmouseout="this.src='images/order_end.png'"/>
        </p>
    </form>
</div>