<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 16-7-30
 */
namespace Dubuqingfeng\ShipyardAPI\Client;

interface ClientInterface
{
    /**
     * @param $uri
     * @param $class
     * @return mixed
     */
    public function get($uri);

    /**
     * @param $uri
     * @param $data
     * @param $class
     * @return mixed
     */
    public function delete($uri, $data);

    /**
     * @param $uri
     * @param $data
     * @param $options
     * @return mixed
     */
    public function post($uri, $data);

    public function request($uri, $method, array $options = array());

    public function auth($username, $password);

    public function getHost();

    public function getImages($host);

    public function getAccounts();

    public function getRegistries();

    public function getServiceKeys();

    public function getEvents();
}