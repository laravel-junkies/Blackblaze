<?php

namespace LaraJunkies\Backblaze;

/**
 * Class BackblazeManager
 * @package LaraJunkies\Backblaze
 * @author Tobias Maxham
 */
class BackblazeManager
{

    /**
     * @var \b2_api $b2API
     */
    private $b2API;

    private $AUTH_TOKEN;

    private $ACCOUNT_ID;

    private $BUCKET_ID;

    private $API_URL;

    public function __construct($b2API)
    {
        $this->b2API = $b2API;
    }

    /**
     * @return \b2_api
     */
    public function api()
    {
        return $this->b2API;
    }

    public function uploadURL()
    {
        return $this->api()->b2_get_upload_url($this->API_URL, $this->ACCOUNT_ID, $this->AUTH_TOKEN, $this->BUCKET_ID);
    }

    public function backup($aFile)
    {
       return $this->api()->b2_upload_file($this->uploadURL(), $this->AUTH_TOKEN, $aFile);
    }

}