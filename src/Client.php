<?php
namespace WowzaRestApi;

class Client
{
    const AUTH_TYPE_NONE = 'none';
    const AUTH_TYPE_DIGEST = 'digest';
    const AUTH_TYPE_BASIC = 'basic';

    const PROTOCOL_HTTP = 'http';
    const PROTOCOL_HTTPS = 'https';

    private $config;

    /**
     * Takes an array with configuration parameters as constructor argument
     *
     * @param array $config Client configuration settings
     */
    public function __construct(array $config = [])
    {
        $this->initConfiguration($config);
    }

    /**
     * Sets configuration option
     *
     * @param string $option
     * @param string $value
     */
    public function setOption($option, $value)
    {
        $this->config[$option] = $value;
    }

    public function getOption($option)
    {
        if ($this->isOptionSet($option)) {
            return $this->config[$option];
        }
        return null;
    }

    /**
     * Sets authentication details
     *
     * @param string $login
     * @param string $password
     * @param string $authType
     */
    public function setCredentials($login, $password, $authType = 'digest')
    {
        $this->setOption('login', $login);
        $this->setOption('password', $password);
        $this->setOption('authType', $authType);
    }

    public function getApplicationList($withSettings=true)
    {
        $uri = '/v2/servers/_defaultServer_/vhosts/_defaultVHost_/applications';
        $data = $this->execGETRequest($uri);
        if ($withSettings) {
            foreach($data->applications as $app=>$idx) {
                // TODO
                // $this->getApplicationSettings($app->id);
            }
        }
        return $data->applications;
    }

    public function getApplicationSettings($appName) {
        $uri ='/v2/servers/_defaultServer_/vhosts/_defaultVHost_/applications/'.$appName;
        $data = $this->execGETRequest($uri);
        return $data;
    }

    /**
     * Initializes configuration options
     *
     * @param array $config
     */
    private function initConfiguration(array $config)
    {
        $this->config = $config;
        $authType = self::AUTH_TYPE_DIGEST;
        if (!$this->isOptionSet('host')) {
            $this->setOption('host', 'localhost');
        }
        if (!$this->isOptionSet('port')) {
            $this->setOption('port', '8087');
        }
        if (!$this->isOptionSet('protocol')) {
            $this->setOption('protocol', self::PROTOCOL_HTTP);
        }
        if (!$this->isOptionSet('login')) {
            $this->setOption('login', '');
            $authType = self::AUTH_TYPE_NONE;
        }
        if (!$this->isOptionSet('password')) {
            $this->setOption('password', '');
            $authType = self::AUTH_TYPE_NONE;
        }
        if (!$this->isOptionSet('authType')) {
            $this->setOption('authType', $authType);
        }
    }

    /**
     * Returns true if a configuration option is set
     *
     * @param string $option Configuration option name
     * @return bool
     */
    private function isOptionSet($option)
    {
        if (isset($this->config[$option])) {
            return true;
        }
        return false;
    }

    private function execGETRequest($uri)
    {
        $req = new \GuzzleHttp\Client();
        $url = sprintf('%s://%s:%s%s',
            $this->getOption('protocol'),
            $this->getOption('host'),
            $this->getOption('port'), $uri);
        $res = $req->get($url,['headers'=>['Accept'=>'application/json; charset=utf-8']]);
        if ($res->getStatusCode()==200) {
            $n=$res->getBody();
            return json_decode($n->getContents());
        }
        return null;
    }

}
