<table id="pagination">
    <tr>
        <td>Стр.</td>
        <?php for ($i = 0; $i < count($this->pages); $i++) { ?>
            <td>
                <?php if ($i != 0) echo "<span> - </span>"; ?>
                <a href="<?= $this->pages[$i] ?>"><?= ($i + 1) ?></a>
            </td>
        <?php } ?>
    </tr>
</table>