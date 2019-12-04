<?php

namespace App\Services\DBConnection;

use Session;
use Config;

class DBConnection {

    /**
     *  Stores passed db credentials and settings in the session
     * @param type $db_adapter
     * @param type $db_name
     * @param type $db_host
     * @param type $db_user
     * @param type $db_pass
     */
    public function setSessionDBparams($client_key) {
        $connectionConfig = Config::get('database.connections.' . $client_key);

        Session::put('db_connection', array(
            'driver' => $connectionConfig['driver'],
            'database' => $connectionConfig['database'],
            'host' => $connectionConfig['host'],
            'username' => $connectionConfig['username'],
            'password' => $connectionConfig['password'],
            'charset' => $connectionConfig['charset'],
            'collation' => $connectionConfig['collation'],
        ));

        return true;
    }

    /**
     * Setting current db connection configuration, if it's stored in the session
     * @return boolean
     */
    public function setDBconnection($clientKey) {
        $connectionConfig = \Config::get('clients.' . $clientKey . '.database');
        Config::set('database.connections.app.driver', $connectionConfig['driver']);
        Config::set('database.connections.app.database', $connectionConfig['database']);
        Config::set('database.connections.app.host', $connectionConfig['host']);
        Config::set('database.connections.app.username', $connectionConfig['username']);
        Config::set('database.connections.app.password', $connectionConfig['password']);
        Config::set('database.connections.app.charset', $connectionConfig['charset']);
        Config::set('database.connections.app.collation', $connectionConfig['collation']);
        Config::set('database.default', 'app');
        return true;
    }

    /**
     * Setting db connection configuration to Login Database
     * @return boolean
     */
    public function setLoginDBconnection() {
        Config::set('database.default', 'logindb');
        return true;
    }

}
