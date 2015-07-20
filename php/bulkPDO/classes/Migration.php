<?php
require_once "classes/LkzDatabase.php";
class MigrateCategories {
    public function __construct() {
        $this->fixMigratingMainCategory();
    }

    private function fixMigratingMainCategory() {
        $pdo = LkzDatabase::getInstance();
        $dbHandler = $pdo->prepare("SELECT id, category_id, 1 as main FROM product WHERE category_id IS NOT NULL");
        $dbHandler->execute();
        $data = [];
        while($data[] = $dbHandler->fetch(PDO::FETCH_NUM)) {
            if(count($data) > 20000) { // prevent the script to kill the server | max insert 20.000 relations per request
                $this->modifyCategoryProducts($data);
                $data = [];
            }
        }
        unset($data[count($data) -1]); // The last value is assigned to data no matter that it casts to false
        $this->modifyCategoryProducts($data);
    }

    private function modifyCategoryProducts($data) {
        $data = $this->prepareIds($data);
        $pdo = LkzDatabase::getInstance();
        foreach(LkzDatabase::getBulkInsert('category_product', ['product_id', 'category_id', 'main', 'id'], $data, true) as $q) {
            $bulkHandler = $pdo->prepare($q);
            $bulkHandler->execute();
        }
    }

    private function prepareIds($data) {
        foreach($data as $k => $v) {
            $data[$k][] = $v[0] . "|" . $v[1]; // Compound key, in order to be able to replace easily without duplicates
        }
        return $data;
    }
}