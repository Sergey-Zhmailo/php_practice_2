<?php
session_start();
if (empty($_SESSION['is_auth'])) {
    header('Location: /login_page.php', true, 301);
    exit();
}
// header
require_once 'header.php';

//EDIT POST
if ($_GET['edit']) {
    $post_edit = mysqli_fetch_assoc(mysqli_query($connect, "SELECT * FROM posts WHERE post_id = '" . $_GET['edit'] . "'"));
    $_SESSION['post_title'] = $post_edit['post_title'];
    $_SESSION['post_text'] = $post_edit['post_text'];
    $_SESSION['post_edit'] = $_GET['edit'];
}

?>
<!--main content-->
<div class="main">
    <div class="container">
        <h4 class="center-align">Мои записи</h4>
        <div class="row">
            <div class="col s6">
                <form action="actions/post_edit.php" method="post" class="card grey lighten-2 m-auto" novalidate>
                    <h4 class="center-align"><?php echo $post_edit['post_title'] ? 'Редактировать запись' : 'Новая запись' ?></h4>
                    <div class="row">
                        <div class="col s12">
                            <label for="post_title">Заголовок</label>
                            <input type="text"
                                   id="post_title"
                                   name="post_title"
                                   value="<?php echo !empty($_SESSION['valid_post_title']) ? $_SESSION['valid_post_title'] : $_SESSION['post_title']; ?>"
                                <?php echo !empty($_SESSION['errors']['error_post_title']) ? 'class="error"' : '' ?>
                            >
                            <?php echo !empty($_SESSION['errors']['error_post_title']) ? '<span class="error">' . $_SESSION['errors']['error_post_title'] . '</span>' : '' ?>
                            <label for="post_text">Текст</label>
                            <textarea id="post_text" name="post_text" <?php echo !empty($_SESSION['errors']['error_post_text']) ? 'class="error"' : '' ?>><?php echo !empty($_SESSION['valid_post_text']) ? $_SESSION['valid_post_text'] : $_SESSION['post_text']; ?></textarea>
                            <?php echo !empty($_SESSION['errors']['error_post_text']) ? '<span class="error">' . $_SESSION['errors']['error_post_text'] . '</span>' : '' ?>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col s6">
                            <button type="submit" class="btn waves-effect waves-light light-blue darken-4">Опубликовать</button>
                        </div>
                    </div>
                </form>
            </div>
            <div class="col s6">
                <ul class="collection">
                    <?php
                    $sql = "SELECT * FROM posts WHERE author_id = '" . $_SESSION['is_auth'] . "'";
                    $query = mysqli_query($connect, $sql);
                    while ($res[] = mysqli_fetch_assoc($query)) {
                        $user_posts = $res;
                    }
                    if ($user_posts) {
                        foreach ($user_posts as $user_post) {
                            echo '<li class="collection-item">' . $user_post['post_title'] . '<a href="/actions/post_edit.php?delete=' . $user_post['post_id'] . '" class="secondary-content"><i class="material-icons light-blue-text text-darken-4">delete</i></a><a href="/posts.php?edit=' . $user_post['post_id'] . '" class="secondary-content"><i class="material-icons light-blue-text text-darken-4">edit</i></a></li>';
                        }
                    } else {
                        echo '<p>Ваших записей нет</p>';
                    }
                    ?>
                </ul>
            </div>
        </div>







    </div>
</div>
<?php

// footer
require_once 'footer.php';
?>
