<h3>Статистика за последние 7 дней</h3>
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