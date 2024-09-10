<?php
include("DatabaseInitializer.php");
include("ImageDownloader.php");

$dbInit = new DatabaseInitializer();
$dbInit->initialize();

$imgDownloader = new ImageDownloader();
$imgDownloader->download(AVATAR_IMAGE_URL, AVATAR_FILE_NAME);