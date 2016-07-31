<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 16-7-30
 */

namespace Dubuqingfeng\ShipyardAPI\Client;


use Dubuqingfeng\ShipyardAPI\Exception\AuthFalseException;
use Dubuqingfeng\ShipyardAPI\Exception\Exception;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;

class Shipyard implements ClientInterface
{
    private $settings = null;
    private $httpClient = null;

    public function __construct(array $settings)
    {
        if (!is_array($settings) || empty($settings)) {
            throw new Exception();
        }
        if (isset($settings['base_url'])) {
            try {
                $this->httpClient = new Client(['base_uri' => $settings['base_url']]);
            } catch (Exception $e) {
                echo 'Caught exception: ', $e->getMessage(), "\n";
            }
        } else {
            throw new AuthFalseException();
        }
        $this->settings = $settings;
    }

    public function get($uri, $class)
    {
        return $this->request($uri, 'GET', $this->getAuth(null))->getBody();
    }

    public function request($uri, $method, array $options = array())
    {
        try {
            $response = $this->httpClient->request($method, $uri, $options);
            return $response;
        } catch (RequestException $e) {
            echo $e->getMessage();
            echo $e->getResponse()->getBody();
            return null;
        }
    }

    public function getAuth($body)
    {
        $options = [
            'headers' => [
                'User-Agent' => 'test/1.0',
                'Accept' => 'application/json',
            ],
            'body' => $body
        ];
        if (isset($this->settings['service_key'])) {
            $options['headers']['X-Service-Key'] = $this->settings['service_key'];
        } else if (isset($this->settings['username']) && isset($this->settings['password'])) {
            $token = $this->auth($this->settings['username'], $this->settings['password']);
            $options['headers']['X-Access-Token'] = $this->settings['username'] . ":" . $token;
        } else {
            throw new AuthFalseException();
        }
        return $options;
    }

    public function auth($username, $password)
    {
        $auth = array("username" => $username, "password" => $password);
        $content = json_decode($this->request("/auth/login", 'POST', ['body' => json_encode($auth)])->getBody());
        return $content->auth_token;
    }

    public function post($uri, $data)
    {
        echo $this->request($uri, 'POST', $this->getAuth($data))->getBody();
    }

    public function delete($uri, $data, $class)
    {
        return $this->request($uri, 'DELETE', $this->getAuth($data))->getBody();
    }

    public function getHost()
    {
        // TODO: Implement getHost() method.
    }

    public function getImages($host)
    {
        // TODO: Implement getImages() method.
    }

    public function getAccounts()
    {
        // TODO: 封装并反射类
        $result = $this->get("/api/accounts", "Account");
        $json = json_decode($result, true);
        $collection = new Collection();
        foreach ($json as $key => $value) {
            $collection->set($key, $value);
        }
        return $collection;
    }

    public function getRegistries()
    {
        // TODO: Implement getRegistries() method.
    }

    public function getServiceKeys()
    {
        // TODO: Implement getServiceKeys() method.
    }

    public function getEvents()
    {
        $result = $this->get("/api/events", "");
        $json = json_decode($result, true);
        $collection = new Collection();
        foreach ($json as $key => $value) {
            $collection->set($key, $value);
        }
        return $collection;
    }
}