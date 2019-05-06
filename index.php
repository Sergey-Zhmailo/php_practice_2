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
        <h4 class="center-align">Статьи</h4>
        <div class="row">
            <ul class="collection">
                <?php
                $sql = "SELECT * FROM posts";
                $query = mysqli_query($connect, $sql);
                while ($res[] = mysqli_fetch_assoc($query)) {
                    $user_posts = $res;
                }
                if ($user_posts) {
                    foreach ($user_posts as $user_post) {
                        echo '<li class="collection-item avatar"><span class="title">' . $user_post['post_title'] . '</span><p>'. $user_post['post_text'] . '</p></li>';
                    }
                } else {
                    echo '<p>Записей нет</p>';
                }

                ?>
            </ul>
        </div>
    </div>
</div>
<?php

    // footer
    require_once 'footer.php';
?>
