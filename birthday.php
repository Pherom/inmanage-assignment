<?php
include("DatabaseInitializer.php");
include("ImageDownloader.php");
include("StatisticsCollector.php");
include("PostView.php");

$dbInit = new DatabaseInitializer();
$dbInit->initialize();

$imgDownloader = new ImageDownloader();
$imgDownloader->download(AVATAR_IMAGE_URL, AVATAR_FILE_NAME);

$statCollector = new StatisticsCollector();
$statCollector->gatherStats();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inmanage Assignment - Birthday</title>
    <link rel="stylesheet" href="post_view.css">
</head>
<body>
<?php
        $postsWithUserData = Database::getInstance()->select(POSTS_TABLE . " NATURAL JOIN " . USERS_TABLE,
        ["*"],
        ["MONTH(" . USER_BIRTH_DATE_COL . ") = MONTH(CURDATE())",
        POST_DATE_CREATED_COL . " >= ALL(SELECT " . POST_DATE_CREATED_COL . " FROM " . POSTS_TABLE . " P WHERE P." . POST_USER_ID_COL . " = " . POST_USER_ID_COL . ")"]);
        foreach ($postsWithUserData as $post => $data) {
            $pv = new PostView($data[USER_NAME_COL], $data[USER_EMAIL_COL], $data[USER_ACTIVE_COL],
                               $data[POST_TITLE_COL], $data[POST_BODY_COL], $data[POST_DATE_CREATED_COL], $data[POST_ACTIVE_COL]);
            $pv->display();
        }
    ?>
</body>
</html>