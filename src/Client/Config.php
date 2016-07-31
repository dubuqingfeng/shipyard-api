<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 16-7-30
 */

namespace Dubuqingfeng\ShipyardAPI\Client;


class Config
{
    protected static $ins = null;
    protected static $data = array(
        "auth_login" => "/auth/login",
        "list_accounts" => "/api/accounts",
        "list_events" => "/api/events",
        "list_nodes" => "/api/nodes",
        "list_registries" => "/api/registries",
        "list_service_keys" => "/api/servicekeys",
        "list_webhook_keys" => "/api/webhookkeys",
        "list_roles" => "/api/roles",
    );

    public static function getIns()
    {
        if (self::$ins instanceof self) {
            return self::$ins;
        } else {
            self::$ins = new self();
            return self::$ins;
        }
    }

    public function __get($key)
    {
        if (array_key_exists($key, self::$data)) {
            return self::$data[$key];
        } else {
            return null;
        }
    }
}