<?php
if (!defined("DB_HOST")) define("DB_HOST", "localhost");
if (!defined("DB_USER")) define("DB_USER", "root");
if (!defined("DB_PASS")) define("DB_PASS", "");
if (!defined("DB_NAME")) define("DB_NAME", "inmanage-assignment-db");
if (!defined("INIT_TABLES")) define("INIT_TABLES", [
    [
        "name" => "users",
        "columns" =>
        [
            [
                "name" => "user_id",
                "definition" => "INT PRIMARY KEY AUTO_INCREMENT NOT NULL",
                "apiName" => "id"
            ],
            [
                "name" => "name",
                "definition" => "VARCHAR(50) NOT NULL",
                "apiName" => "name"
            ],
            [
                "name" => "email",
                "definition" => "VARCHAR(50) UNIQUE NOT NULL",
                "apiName" => "email"
            ],
            [
                "name" => "active",
                "definition" => "BOOLEAN NOT NULL DEFAULT 1",
                "apiName" => null
            ]
        ],
        "constraints" =>
        [],
        "apiName" => "users"
    ],
    [
        "name" => "posts",
        "columns" => [
            [
                "name" => "post_id",
                "definition" => "INT PRIMARY KEY AUTO_INCREMENT NOT NULL",
                "apiName" => "id"
            ],
            [
                "name" => "user_id",
                "definition" => "INT NOT NULL",
                "apiName" => "userId"
            ],
            [
                "name" => "title",
                "definition" => "VARCHAR(50) NOT NULL",
                "apiName" => "title"
            ],
            [
                "name" => "body",
                "definition" => "VARCHAR(500) NOT NULL",
                "apiName" => null
            ],
            [
                "name" => "date_created",
                "definition" => "DATETIME NOT NULL DEFAULT NOW()",
                "apiName" => null
            ],
            [
                "name" => "active",
                "definition" => "BOOLEAN NOT NULL DEFAULT 1",
                "apiName" => null
            ]
        ],
        "constraints" =>
        [
            "FOREIGN KEY (user_id) REFERENCES users(user_id)"
        ],
        "apiName" => "posts"
    ]
]);
if (!defined("API_URL")) define("API_URL", "https://jsonplaceholder.typicode.com");
if (!defined("AVATAR_IMAGE_URL")) define("AVATAR_IMAGE_URL", "https://cdn2.vectorstock.com/i/1000x1000/23/81/default-avatar-profile-icon-vector-18942381.jpg");
if (!defined("AVATAR_FILE_NAME")) define("AVATAR_FILE_NAME", "avatar.jpg");
