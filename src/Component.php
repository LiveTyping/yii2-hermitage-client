<?php

namespace livetyping\hermitage\client\yii2;

use GuzzleHttp\Client as Guzzle;
use livetyping\hermitage\client\Client;
use livetyping\hermitage\client\contracts\Client as ClientInterface;
use livetyping\hermitage\client\signer\RequestSigner;
use livetyping\hermitage\client\signer\Signer;
use yii\base\InvalidConfigException;

/**
 * Class Component
 *
 * @package livetyping\hermitage\client\yii2
 */
class Component extends \yii\base\Component implements ClientInterface
{
    /** @var string */
    public $secret;

    /** @var \Psr\Http\Message\UriInterface|string */
    public $baseUri;

    /** @var string */
    public $algorithm;

    /** @var \livetyping\hermitage\client\Client */
    protected $client;

    /**
     * Initializes the object.
     * This method is invoked at the end of the constructor after the object is initialized with the
     * given configuration.
     */
    public function init()
    {
        if (empty($this->secret)) {
            throw new InvalidConfigException('Secret is not set.');
        }

        if (empty($this->baseUri)) {
            throw new InvalidConfigException('Base URI is not set.');
        }

        if (empty($this->algorithm)) {
            $this->algorithm = 'sha256';
        }

        $this->client = $this->createClient();
    }

    /**
     * @param string $binary
     *
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function upload($binary)
    {
        return $this->client->upload($binary);
    }

    /**
     * @param string $filename
     *
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function delete($filename)
    {
        return $this->client->delete($filename);
    }

    /**
     * @param string $filename
     * @param string $version
     *
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function get($filename, $version = '')
    {
        return $this->client->get($filename, $version);
    }

    /**
     * @param string $filename
     * @param string $version
     *
     * @return \Psr\Http\Message\UriInterface
     */
    public function uriFor($filename, $version = '')
    {
        return $this->client->uriFor($filename, $version);
    }

    /**
     * @return \livetyping\hermitage\client\Client
     */
    protected function createClient()
    {
        return new Client($this->createRequestSigner(), new Guzzle(), $this->baseUri);
    }

    /**
     * @return \livetyping\hermitage\client\signer\RequestSigner
     */
    protected function createRequestSigner()
    {
        return new RequestSigner(new Signer($this->secret, $this->algorithm));
    }
}
