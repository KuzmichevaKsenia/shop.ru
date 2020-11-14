<h3>Вход в Admin-панель</h3>
<?php include "message.tpl"; ?>
<div class="form">
    <form name="auth" action="<?= $this->action ?>" method="post">
        <table>
            <tr>
                <td>Логин:</td>
                <td>
                    <input type="text" name="login" value="<?= $this->login ?>"/>
                </td>
            </tr>
            <tr>
                <td>Пароль:</td>
                <td>
                    <input type="password" name="password"/>
                </td>
            </tr>
            <tr>
                <td colspan="2" align="right">
                    <input type="hidden" name="r" value="<?= $this->r ?>"/>
                    <input type="hidden" name="func" value="auth"/>
                    <input type="submit" name="auth" value="Войти"/>
                </td>
            </tr>
        </table>
    </form>
</div>