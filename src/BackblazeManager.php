<?php

/*
 * This file is part of Laravel Junkies Backblaze.
 *
 * Copyright (c) 2016 Tobias Maxham <git2016@maxham.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * Feel free to edit as you please, and have fun.
 */

namespace LaraJunkies\Backblaze;

/**
 * Class BackblazeManager
 * @package LaraJunkies\Backblaze
 *
 * @author Tobias Maxham <git2016@maxham.de>
 */
class BackblazeManager
{

    /**
     * @var \b2_api $b2API
     */
    private $b2API;


    private $AUTH_TOKEN;

    private $UPLOAD_AUTH_TOKEN;

    private $ACCOUNT_ID;

    private $DOWNLOAD_URL;

    private $UPLOAD_URL;

    private $APPLICATION_KEY;

    private $BUCKET_ID;

    private $API_URL;

    /**
     * BackblazeManager constructor.
     * @param $b2API
     * @param array $config
     */
    public function __construct($b2API, $config = [])
    {
        $this->b2API = $b2API;

        if (isset($config['ACCOUNT_ID'])) {
            $this->ACCOUNT_ID = $config['ACCOUNT_ID'];
        }

        if (isset($config['APPLICATION_KEY'])) {
            $this->APPLICATION_KEY = $config['APPLICATION_KEY'];
        }

        if (isset($config['BUCKET_ID'])) {
            $this->BUCKET_ID = $config['BUCKET_ID'];
        }
    }

    public function __call($name, $arguments)
    {
        if (!method_exists($this->api(), $name)) {
            throw new \Exception('Method "' . $name . '" not found. Invalid callback for ' . self::class);
        }
        return call_user_func_array([$this->api(), $name], $arguments);
    }

    /**
     * @return \b2_api
     */
    public function api()
    {
        return $this->b2API;
    }

    /**
     * @param null $accountID
     * @param null $appKey
     * @return \stdClass
     */
    public function authorize($accountID = null, $appKey = null)
    {
        if (null == $accountID) $accountID = $this->ACCOUNT_ID;
        else $this->ACCOUNT_ID = $accountID;

        if (null == $appKey) $appKey = $this->APPLICATION_KEY;
        else $this->APPLICATION_KEY = $appKey;

        $auth = $this->api()->b2_authorize_account($accountID, $appKey);
        $this->AUTH_TOKEN = $auth->authorizationToken;
        $this->API_URL = $auth->apiUrl;
        $this->DOWNLOAD_URL = $auth->downloadUrl;

        return $auth;
    }

    /**
     * @param string $filePath
     * @param null $bucketID
     * @return mixed
     */
    public function backup($filePath, $bucketID = null)
    {
        $this->initUploadURL($bucketID);
        return $this->api()->b2_upload_file($this->UPLOAD_URL, $this->UPLOAD_AUTH_TOKEN, $filePath);
    }

    /**
     * @param null $bucketID
     */
    public function initUploadURL($bucketID = null)
    {
        if (null != $this->UPLOAD_URL && null != $this->UPLOAD_AUTH_TOKEN) {
            return;
        }

        // checks if already logged in B2 API
        if (null == $this->AUTH_TOKEN || null == $this->API_URL) {
            $this->authorize();
        }

        if (null != $bucketID) {
            $this->BUCKET_ID = $bucketID;
        }

        $uploadURL = $this->api()->b2_get_upload_url($this->API_URL, $this->ACCOUNT_ID, $this->AUTH_TOKEN, $this->BUCKET_ID);
        $this->UPLOAD_URL = $uploadURL->uploadUrl;
        $this->UPLOAD_AUTH_TOKEN = $uploadURL->authorizationToken;
    }

}