<?php
require_once 'classes/Migration.php';
try {
    new MigrateCategories();
} catch(Exception $e) {
    print_r($e->getMessage());
}