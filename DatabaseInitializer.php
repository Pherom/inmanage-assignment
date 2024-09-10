<?php
include("Database.php");

class DatabaseInitializer
{

    private function populateTable($init_table)
    {
        $ch = curl_init();

        $resourceName = $init_table["apiName"];
        curl_setopt($ch, CURLOPT_URL, API_URL . "/$resourceName");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $api_response = json_decode(curl_exec($ch), true);

        curl_close($ch);
        foreach ($api_response as $entity) {
            $data = array();
            foreach ($init_table["columns"] as $column) {
                if (isset($column["apiName"])) {
                    $value = $entity[$column["apiName"]];
                    $data[$column["name"]] = $value;
                }
            }
            Database::getInstance()->insert($init_table["name"], $data, []);
        }
    }

    public function initialize()
    {
        if (!Database::getInstance()->connected()) {
            Database::getInstance()->connect();
        }
        foreach (INIT_TABLES as $init_table) {
            if (!Database::getInstance()->tableExists($init_table["name"])) {
            Database::getInstance()->createTable($init_table["name"], $init_table["columns"], $init_table["constraints"]);
                if (isset($init_table["apiName"])) {
                    $this->populateTable($init_table);
                }
            }
        }
    }
}
