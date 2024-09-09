<?php
include("Database.php");
include("config.php");

class DatabaseInitializer
{

    private function populateTable($init_table)
    {
        $ch = curl_init();

        $resourceName = $init_table["apiName"];
        curl_setopt($ch, CURLOPT_URL, API_URL . "/$resourceName");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $api_response = json_decode(curl_exec($ch));

        foreach ($api_response as $entity) {
            $data = array();
            foreach ($init_table["columns"] as $column) {
                if (isset($column["apiName"])) {
                    $value = $entity[$column["apiName"]];
                    $data[$column["name"]] = $value;
                }
            }
            Database::getInstance()->insert($init_table["name"], $data);
        }

        curl_close($ch);
    }

    public function initialize()
    {
        if (!Database::getInstance()->connected()) {
            Database::getInstance()->connect();
        }
        foreach (INIT_TABLES as $init_table) {
            Database::getInstance()->createTable($init_table["name"], $init_table["columnDefinitions"], $init_table["constraints"]);
            $this->populateTable($init_table);
        }
    }
}
