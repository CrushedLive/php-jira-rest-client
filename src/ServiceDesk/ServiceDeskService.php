<?php

namespace JiraRestApi\ServiceDesk;

use JiraRestApi\Configuration\ConfigurationInterface;
use Psr\Log\LoggerInterface;

class ServiceDeskService extends \JiraRestApi\JiraClient
{
    private $baseUri = '/rest/servicedeskapi';

    public function __construct(ConfigurationInterface $configuration = null, LoggerInterface $logger = null, $path = './')
    {
        parent::__construct($configuration, $logger, $path);
        $this->setAPIUri($this->baseUri);
    }
}
