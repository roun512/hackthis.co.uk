<?php
    define("PAGE_PUBLIC", true);
    require_once('init.php');

    $result = array("status"=>false);

    $articles = new articles();

    if (isset($_GET['action'])) {
        if ($_GET['action'] == "get") {
            $comments = $articles->get_comments($_GET['id']);

            $result['status'] = true;
            $result['comments'] = $comments;
        } else if ($_GET['action'] == "add") {
            $comment = $articles->add_comment($_POST['body'], $_POST['id'], $_POST['parent']);

            if ($comment) {
                $result['status'] = true;
                $result['comment'] = $comment;
            } else
                $result['status'] = false;
        }
    }

    echo json_encode($result);
?>