<?php
session_start();
if ($_SESSION['is_auth']) {
    header('Location: /', true, 301);
    exit();
}
// header
require_once 'header.php';

?>
<!--main content-->
<div class="main">
    <div class="container">
        <form action="actions/register.php" method="post" class="card grey lighten-2 m-auto" novalidate>
            <h4 class="center-align">Регистрация</h4>
            <div class="row">
                <div class="col s12">
                    <!--  name -->
                    <label for="user_name">Имя *</label>
                    <input type="text"
                           id="user_name"
                           name="user_name"
                           value="<?php echo !empty($_SESSION['valid_user_name']) ? $_SESSION['valid_user_name'] : $_SESSION['user_name']; ?>"
                        <?php echo !empty($_SESSION['errors']['error_user_name']) ? 'class="error"' : '' ?>
                    >
                    <?php echo !empty($_SESSION['errors']['error_user_name']) ? '<span class="error">' . $_SESSION['errors']['error_user_name'] . '</span>' : '' ?>
                    <!--  /name -->

                    <!--  email-->
                    <label for="user_email">Email *</label>
                    <input type="email"
                           id="user_email"
                           name="user_email"
                           value="<?php echo !empty($_SESSION['valid_user_email']) ? $_SESSION['valid_user_email'] : $_SESSION['user_email']; ?>"
                        <?php echo !empty($_SESSION['errors']['error_user_email']) ? 'class="error"' : '' ?>
                    >
                    <?php echo !empty($_SESSION['errors']['error_user_email']) ? '<span class="error">' . $_SESSION['errors']['error_user_email'] . '</span>' : '' ?>
                    <!--  /email-->
                    <!-- password-->
                    <label for="user_password">Пароль *</label>
                    <input type="password"
                           id="user_password"
                           name="user_password"
                           value="<?php echo !empty($_SESSION['valid_user_password']) ? $_SESSION['valid_user_password'] : ''; ?>"
                        <?php echo !empty($_SESSION['errors']['error_user_password']) ? 'class="error"' : '' ?>
                    >
                    <?php echo !empty($_SESSION['errors']['error_user_password']) ? '<span class="error">' . $_SESSION['errors']['error_user_password'] . '</span>' : '' ?>
                    <label for="user_password_repeat">Пароль еще раз *</label>
                    <input type="password"
                           id="user_password_repeat"
                           name="user_password_repeat"
                           value="<?php echo !empty($_SESSION['valid_user_password']) ? $_SESSION['valid_user_password'] : ''; ?>"
                        <?php echo !empty($_SESSION['errors']['error_user_password_repeat']) ? 'class="error"' : '' ?>
                    >
                    <?php echo !empty($_SESSION['errors']['error_user_password_repeat']) ? '<span class="error">' . $_SESSION['errors']['error_user_password_repeat'] . '</span>' : '' ?>
                    <!--  /password-->
                </div>
            </div>
            <!-- gender-->
            <div class="row">
                <div class="col s4">Ваш пол: *</div>
                <div class="col s4 radio-wrapper">
                    <input type="radio"
                           name="gender"
                           value="1"
                        <?php echo !empty($_SESSION['valid_gender']) && $_SESSION['valid_gender'] == 1 ? 'checked' : '' ?>
                    >
                    <span>Мужчина</span>
                </div>
                <div class="col s4 radio-wrapper">
                    <input type="radio"
                           name="gender"
                           value="2"
                        <?php echo !empty($_SESSION['valid_gender']) && $_SESSION['valid_gender'] == 2 ? 'checked' : '' ?>
                    >
                    <span>Женщина</span>
                </div>
                <?php echo !empty($_SESSION['errors']['error_gender']) ? '<span class="error col s12">' . $_SESSION['errors']['error_gender'] . '</span>' : '' ?>
            </div>
            <!-- /gender-->

            <!-- submit-->
            <div class="row">
                <div class="col s12 center-align">
                    <button type="submit"
                            class="btn waves-effect waves-light light-blue darken-4"
                            name="submit_register"
                    >Отправить</button>
                </div>
            </div>
            <div class="row">
                <div class="col s12 center-align">
                    <a href="login_page.php">Уже есть аккаунт? Вход</a>
                </div>
            </div>
            <!-- /submit-->
        </form>
    </div>
</div>
<?php

// footer
require_once 'footer.php';
?>
