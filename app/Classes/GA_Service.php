<?php

namespace App\Classes;


use Google_Client;
use Google_Service_Analytics;

class GA_Service
{
    private $client;
    private $access_token;

    public function __construct($access_token='')
    {
        $this->client = new Google_Client();
        $this->access_token = $access_token;
        $this->init();
    }

    private function init()
    {
        $this->client->setAuthConfig(config_path('client_secret_1.json'));
        $this->client->addScope(Google_Service_Analytics::ANALYTICS_READONLY);
        $this->client->setRedirectUri(url('callback/oauth2callback'));
        if($this->access_token) $this->client->setAccessToken($this->access_token);
    }

    public function getCliet()
    {
        return $this->client;
    }

    public function accounts()
    {
        $service = new Google_Service_Analytics($this->client);
        $man_accounts = $service->management_accounts->listManagementAccounts();
        $accounts = [];

        foreach ($man_accounts['items'] as $account) {
            $accounts[] = [ 'id' => $account['id'], 'name' => $account['name'] ];
        }

        return $accounts;
    }

    public function properties($account_id)
    {
        $service = new Google_Service_Analytics($this->client);
        $man_properties = $service->management_webproperties->listManagementWebproperties($account_id);
        $properties = [];

        foreach ($man_properties['items'] as $property) {
            $properties[] = [ 'id' => $property['id'], 'name' => $property['name'] ];
        }

        return $properties;
    }


    public function views( $account_id, $property_id )
    {
        $service = new Google_Service_Analytics($this->client);
        $man_views = $service->management_profiles->listManagementProfiles( $account_id, $property_id );
        $views = [];

        foreach ($man_views['items'] as $view) {
            $views[] = [ 'id' => $view['id'], 'name' => $view['name'] ];
        }

        return $views;
    }


}