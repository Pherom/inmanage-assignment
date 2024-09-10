<?php
if (!defined("DB_HOST")) define("DB_HOST", "localhost");
if (!defined("DB_USER")) define("DB_USER", "root");
if (!defined("DB_PASS")) define("DB_PASS", "");
if (!defined("DB_NAME")) define("DB_NAME", "inmanage_assignment_db");
if (!defined("USER_ID_COL")) define("USER_ID_COL", "user_id");
if (!defined("USER_NAME_COL")) define("USER_NAME_COL", "name");
if (!defined("USER_EMAIL_COL")) define("USER_EMAIL_COL", "email");
if (!defined("USER_ACTIVE_COL")) define("USER_ACTIVE_COL", "active");
if (!defined("USER_BIRTH_DATE_COL")) define("USER_BIRTH_DATE_COL", "birth_date");
if (!defined("POST_ID_COL")) define("POST_ID_COL", "post_id");
if (!defined("POST_USER_ID_COL")) define("POST_USER_ID_COL", "user_id");
if (!defined("POST_TITLE_COL")) define("POST_TITLE_COL", "title");
if (!defined("POST_BODY_COL")) define("POST_BODY_COL", "body");
if (!defined("POST_DATE_CREATED_COL")) define("POST_DATE_CREATED_COL", "date_created");
if (!defined("POST_ACTIVE_COL")) define("POST_ACTIVE_COL", "active");
if (!defined("POST_STATS_DATE_COL")) define("POST_STATS_DATE_COL", "date");
if (!defined("POST_STATS_TIME_COL")) define("POST_STATS_TIME_COL", "time");
if (!defined("POST_STATS_COUNT_COL")) define("POST_STATS_COUNT_COL", "post_count");
if (!defined("POSTS_TABLE")) define("POSTS_TABLE", "posts");
if (!defined("USERS_TABLE")) define("USERS_TABLE", "users");
if (!defined("POST_STATS_TABLE")) define("POST_STATS_TABLE", "post_stats");
if (!defined("INIT_TABLES")) define("INIT_TABLES",
[
    [
        "name" => USERS_TABLE,
        "columns" =>
        [
            [
                "name" => USER_ID_COL,
                "definition" => "INT PRIMARY KEY AUTO_INCREMENT NOT NULL",
                "apiName" => "id"
            ],
            [
                "name" => USER_NAME_COL,
                "definition" => "VARCHAR(50) NOT NULL",
                "apiName" => "name"
            ],
            [
                "name" => USER_EMAIL_COL,
                "definition" => "VARCHAR(50) UNIQUE NOT NULL",
                "apiName" => "email"
            ],
            [
                "name" => USER_BIRTH_DATE_COL,
                "definition" => "DATE",
                "apiName" => null
            ],
            [
                "name" => USER_ACTIVE_COL,
                "definition" => "BOOLEAN NOT NULL DEFAULT 1",
                "apiName" => null
            ]
        ],
        "constraints" =>
        [],
        "apiName" => "users"
    ],
    [
        "name" => POSTS_TABLE,
        "columns" =>
        [
            [
                "name" => POST_ID_COL,
                "definition" => "INT PRIMARY KEY AUTO_INCREMENT NOT NULL",
                "apiName" => "id"
            ],
            [
                "name" => POST_USER_ID_COL,
                "definition" => "INT NOT NULL",
                "apiName" => "userId"
            ],
            [
                "name" => POST_TITLE_COL,
                "definition" => "VARCHAR(50) NOT NULL",
                "apiName" => "title"
            ],
            [
                "name" => POST_BODY_COL,
                "definition" => "VARCHAR(500) NOT NULL",
                "apiName" => "body"
            ],
            [
                "name" => POST_DATE_CREATED_COL,
                "definition" => "DATETIME NOT NULL DEFAULT NOW()",
                "apiName" => null
            ],
            [
                "name" => POST_ACTIVE_COL,
                "definition" => "BOOLEAN NOT NULL DEFAULT 1",
                "apiName" => null
            ]
        ],
        "constraints" =>
        [
            "FOREIGN KEY (". POST_USER_ID_COL .") REFERENCES users(". USER_ID_COL .")"
        ],
        "apiName" => "posts"
    ],
    [
        "name" => POST_STATS_TABLE,
        "columns" =>
        [
            [
                "name" => POST_STATS_DATE_COL,
                "definition" => "DATE NOT NULL",
                "apiName" => null
            ],
            [
                "name" => POST_STATS_TIME_COL,
                "definition" => "TIME NOT NULL",
                "apiName" => null
            ],
            [
                "name" => POST_STATS_COUNT_COL,
                "definition" => "INT NOT NULL",
                "apiName" => null
            ]
        ],
        "constraints" =>
        [
            "PRIMARY KEY (" . POST_STATS_DATE_COL . ", " . POST_STATS_TIME_COL . ")"
        ],
        "apiName" => null
    ]
]);
if (!defined("API_URL")) define("API_URL", "https://jsonplaceholder.typicode.com");
if (!defined("AVATAR_IMAGE_URL")) define("AVATAR_IMAGE_URL", "https://cdn2.vectorstock.com/i/1000x1000/23/81/default-avatar-profile-icon-vector-18942381.jpg");
if (!defined("AVATAR_FILE_NAME")) define("AVATAR_FILE_NAME", "avatar.jpg");
