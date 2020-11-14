<div class="mainbar-title">
    <h1 class="title">
        <img src="<?= $this->products_img ?>" alt="<?= $this->products_title ?>"/>
    </h1>
    <div class="pic">
        <img src="images/MM.png" alt=""/>
    </div>
    <div class="sort">
        <div class="sort-top">
            <p>Сортировать по:</p>
        </div>
        <div class="bottom-sort">
            <p>названию (<a href="<?= $this->link_title_up ?>">возр.</a> | <a
                        href="<?= $this->link_title_down ?>">убыв.</a>)
            </p>
            <p>цене (<a href="<?= $this->link_price_up ?>">возр.</a> | <a href="<?= $this->link_price_down ?>">убыв.</a>)
            </p>
        </div>
    </div>
    <hr/>
</div>
<p style="max-width:700px; margin:20px 50px"><?= $this->brand_description ?></p>
	