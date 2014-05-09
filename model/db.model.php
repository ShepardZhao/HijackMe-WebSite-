<?php
/**
 *
 *
 * modal
 * This controller is only for database connection
 * @Xun zhao
 * @Time:02/05/2014
 *
 *
 */

/**
 * DataBase class declare
 */

class DataBase extends mysqli {
    public function __construct($host, $user, $pass, $db) {
        parent::__construct($host, $user, $pass, $db);

        if (mysqli_connect_error()) {
            die('Connect Error (' . mysqli_connect_errno() . ') '
                . mysqli_connect_error());
        }
    }
}

/**
 * End
 */









?>