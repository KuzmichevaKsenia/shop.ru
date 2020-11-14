<?php if ($this->message) { ?>
    <p id="message_string"<?php if ($this->message_color) echo "style='color:" . $this->message_color . "'" ?>><?= $this->message ?></p>
<?php } ?>