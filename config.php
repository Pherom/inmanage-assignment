<?php
define("DB_HOST", "localhost");
define("DB_USER", "root");
define("DB_PASS", "");
define("DB_NAME", "inmanage-assignment-db");
define("INIT_TABLES", [
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
define("API_URL", "https://jsonplaceholder.typicode.com");
