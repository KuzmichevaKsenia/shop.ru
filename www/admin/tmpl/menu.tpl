<?php if ($this->auth) { ?>
    <div id="menu">
        <h2>Меню</h2>
        <div id="logout" style="float: right;font-size: 25px;margin-top: -55px;">
            <a href="<?= $this->logout ?>">Выход</a>
        </div>
        <table>
            <tr>
                <td>
                    <a href="<?= $this->index ?>">Главная</a>
                </td>
                <td>
                    <a href="<?= $this->link_orders ?>">Заказы</a>
                </td>
                <td>
                    <a href="<?= $this->link_items ?>">Разделы</a>
                </td>
                <td>
                    <a href="<?= $this->link_colors ?>">Цвета</a>
                </td>
            </tr>
            <tr>
                <td>
                    <a href="<?= $this->link_statistics ?>">Статистика</a>
                </td>
                <td>
                    <a href="<?= $this->link_products ?>">Товары</a>
                </td>
                <td>
                    <a href="<?= $this->link_brands ?>">Бренды</a>
                </td>
                <td></td>
            </tr>
        </table>
    </div>
    <hr/>
<?php } ?>