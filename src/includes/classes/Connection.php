<?php
namespace HouSplit;
use MySQLi;
require_once '../../config.php';

class Connection extends MySQLi {
    public function __construct() {
        parent::__construct($config['db_server'], $config['db_username'], $config['db_password'],
                            $config['db_name']);
    }
}