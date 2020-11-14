<h3>Статистика</h3>
<div class="form">
    <form name="statistics" action="" method="get">
        <table>
            <tr>
                <td>От:</td>
                <td>
                    <input type="text" name="start" value="<?= $this->start ?>"/>
                </td>
            </tr>
            <tr>
                <td>До:</td>
                <td>
                    <input type="text" name="end" value="<?= $this->end ?>"/>
                </td>
            </tr>
            <tr>
                <td colspan="2" align="right">
                    <input type="hidden" name="view" value="statistics"/>
                    <input type="submit" name="statistics" value="Показать"/>
                </td>
            </tr>
        </table>
    </form>
</div>
<h3>Результат</h3>
<table class="info">
    <tr>
        <th>Количество заказов</th>
        <th>Заказанных единиц товара</th>
        <th>Заказов на сумму</th>
        <th>Полученных заказов на сумму</th>
    </tr>
    <tr>
        <td><?= $this->result["count_orders"] ?></td>
        <td><?= $this->result["count_goods"] ?></td>
        <td><?= $this->result["amount_account"] ?> рублей</td>
        <td><?= $this->result["income"] ?> рублей</td>
    </tr>
</table>