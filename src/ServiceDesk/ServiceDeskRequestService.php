<?php

namespace JiraRestApi\ServiceDesk;

use JiraRestApi\JiraException;

class ServiceDeskRequestService extends ServiceDeskService
{
    private $uri = '/request';

    /**
     * Adds a new comment to an issue.
     *
     * @param string|int $issueIdOrKey Issue id or key
     * @param ServiceDeskComment $comment
     *
     * @return ServiceDeskComment|object Comment class
     * @throws \JsonMapper_Exception
     *
     * @throws JiraException
     */
    public function addComment($issueIdOrKey, $comment)
    {
        $this->log->info("addComment=\n");

        if (!($comment instanceof ServiceDeskComment) || empty($comment->body)) {
            throw new JiraException('comment param must instance of Comment and have to body text.!');
        }

        $data = json_encode($comment);

        $ret = $this->exec($this->uri."/$issueIdOrKey/comment", $data);

        $this->log->debug('add comment result='.var_export($ret, true));
        $comment = $this->json_mapper->map(
            json_decode($ret),
            new ServiceDeskComment()
        );

        return $comment;
    }
}