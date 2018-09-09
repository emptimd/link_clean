<?php

return [

  /**
   * Should we send errors to Airbrake
   */
  'enabled'             => false,

  /**
   * Airbrake API key
   */
  'api_key'             => 'hidden_test',

  /**
   * Should we send errors async
   */
  'async'               => false,

  /**
   * Which enviroments should be ingored? (ex. local)
   */
  'ignore_environments' => [],

  /**
   * Ignore these exceptions
   */
  'ignore_exceptions'   => [],

  /**
   * Connection to the airbrake server
   */
  'connection'          => [

    'host'      => 'errorlogger.org',

    'port'      => '80',

    'secure'    => false,

    'verifySSL' => false
  ]

];