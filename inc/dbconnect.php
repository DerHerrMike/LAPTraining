<?php
include ('config.php');


class Connection
{

    protected function connect()
    {
        try {
            $connection = new PDO("mysql:host=" . DBHOST . ";dbname=" . DBNAME . ";user=" . DBUSER . ";password=" . DBPASS);
            $connection->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
            return $connection;
        } catch (PDOException $e) {
            echo "Couldn't connect to the database: " . $e->getMessage();
            die();
        }

    }
}

