<?php
session_start();
if (empty($_SESSION['is_auth'])) {
    header('Location: /login_page.php', true, 301);
    exit();
}

// header
require_once 'header.php';

// GET USER DATA
$user_data = mysqli_fetch_assoc(mysqli_query($connect, "SELECT * FROM users WHERE user_id = '" . $_SESSION['is_auth'] . "'"));
$_SESSION['user_id'] = $user_data['user_id'];
$_SESSION['valid_gender'] = $user_data['user_gender'];

?>
<!--main content-->
<div class="main">
    <div class="container">
        <form action="actions/account_edit.php" method="post" class="card grey lighten-2 m-auto my-account" novalidate>
            <h4 class="center-align">Личный кабинет</h4>
            <p class="center-align">(редактирование данных пользователя)</p>
            <div class="row">
                <div class="col s12">
                    <!--  name -->
                    <label for="user_name">Имя</label>
                    <input type="text"
                           id="user_name"
                           name="user_name"
                           value="<?php echo !empty($_SESSION['valid_user_name']) ? $_SESSION['valid_user_name'] : $_SESSION['user_name']; ?>"
                        <?php echo !empty($_SESSION['errors']['error_user_name']) ? 'class="error"' : '' ?>
                           placeholder="<?php echo $user_data['user_name'] ?>"
                    >
                    <?php echo !empty($_SESSION['errors']['error_user_name']) ? '<span class="error">' . $_SESSION['errors']['error_user_name'] . '</span>' : '' ?>
                    <?php echo !empty($_SESSION['success']['success_user_name']) ? '<span class="success">' . $_SESSION['success']['success_user_name'] . '</span>' : '' ?>
                    <!--  /name -->

                    <!--  email-->
                    <label for="user_email">Email</label>
                    <input type="email"
                           id="user_email"
                           name="user_email"
                           value="<?php echo !empty($_SESSION['valid_user_email']) ? $_SESSION['valid_user_email'] : $_SESSION['user_email']; ?>"
                           placeholder="<?php echo $user_data['user_email'] ?>"
                        <?php echo !empty($_SESSION['errors']['error_user_email']) ? 'class="error"' : '' ?>
                    >
                    <?php echo !empty($_SESSION['errors']['error_user_email']) ? '<span class="error">' . $_SESSION['errors']['error_user_email'] . '</span>' : '' ?>
                    <?php echo !empty($_SESSION['success']['success_user_email']) ? '<span class="success">' . $_SESSION['success']['success_user_email'] . '</span>' : '' ?>
                    <!--  /email-->
                    <!-- password-->
                    <label for="user_password">Пароль</label>
                    <input type="password"
                           id="user_password"
                           name="user_password"
                           value="<?php echo !empty($_SESSION['valid_user_password']) ? $_SESSION['valid_user_password'] : ''; ?>"
                        <?php echo !empty($_SESSION['errors']['error_user_password']) ? 'class="error"' : '' ?>
                    >
                    <?php echo !empty($_SESSION['errors']['error_user_password']) ? '<span class="error">' . $_SESSION['errors']['error_user_password'] . '</span>' : '' ?>
                    <?php echo !empty($_SESSION['success']['success_user_password']) ? '<span class="success">' . $_SESSION['success']['success_user_password'] . '</span>' : '' ?>
                    <label for="user_password_repeat">Пароль еще раз</label>
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
                <div class="col s4">Ваш пол:</div>
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
                    >Обновить данные</button>
                </div>
            </div>
            <!-- /submit-->
        </form>






    </div>
</div>
<?php
unset($_SESSION['success']['success_user_name']);
unset($_SESSION['success']['success_user_email']);
unset($_SESSION['success']['success_user_password']);
unset($_SESSION['success']['success_user_gender']);
// footer
require_once 'footer.php';
?>
