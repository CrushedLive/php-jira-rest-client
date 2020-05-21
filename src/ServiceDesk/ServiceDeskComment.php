<?php

namespace JiraRestApi\ServiceDesk;

use JiraRestApi\Issue\Comment;

class ServiceDeskComment extends Comment
{
    /** @var boolean */
    public $public;

    public function setPublic(bool $public)
    {
        $this->public = $public;

        return $this;
    }
}