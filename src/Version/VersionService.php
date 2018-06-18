<?php

namespace JiraRestApi\Version;

use JiraRestApi\Issue\Version;
use JiraRestApi\JiraException;
use JiraRestApi\Project\ProjectService;

class VersionService extends \JiraRestApi\JiraClient
{
    private $uri = '/version';

    /**
     * Function to create a new project version.
     *
     * @param Version|array $version
     *
     * @throws \JiraRestApi\JiraException
     * @throws \JsonMapper_Exception
     *
     * @return Version|object Version class
     */
    public function create($version)
    {
        if($version->releaseDate instanceof \DateTime)
        {
            $version->releaseDate = $version->releaseDate->format('Y-m-d');
        }
        $data = json_encode($version);

        $this->log->addInfo("Create Version=\n".$data);

        $ret = $this->exec($this->uri, $data, 'POST');

        return $this->json_mapper->map(
            json_decode($ret), new Version()
        );
    }

    /**
     * Modify a version's sequence within a project.
     *
     * @param $version
     *
     * @throws JiraException
     */
    public function move($version)
    {
        throw new JiraException('move version not yet implemented');
    }

    /**
     * get project version.
     *
     * @param $id version id
     *
     * @return Version
     *
     * @see ProjectService::getVersions()
     */
    public function get($id)
    {
        $ret = $this->exec($this->uri.'/'.$id);

        $this->log->addInfo('Result='.$ret);

        $json = json_decode($ret);
        $results = array_map(function ($elem) {
            return $this->json_mapper->map($elem, new ProjectType());
        }, $json);

        return $results;
    }

    /**
     * @author Martijn Smidt <martijn@squeezely.tech>
     *
     * @param Version $version
     *
     * @return string
     * @throws JiraException
     *
     */
    public function update(Version $version)
    {
        if(!$version->id || !is_numeric($version->id))
        {
            throw new JiraException($version->id . ' is not a valid version id.');
        }

        if($version->releaseDate instanceof \DateTime)
        {
            $version->releaseDate = $version->releaseDate->format('Y-m-d');
        }

        $data = json_encode($version);
        $ret = $this->exec($this->uri . '/' . $version->id, $data, 'PUT');

        return $ret;
    }

    /**
     * @author Martijn Smidt <martijn@squeezely.tech>
     *
     * @param Version $version
     * @param Version|bool $moveAffectedIssuesTo
     * @param Version|bool $moveFixIssuesTo
     *
     * @return string
     * @throws JiraException
     */

    public function delete(Version $version, $moveAffectedIssuesTo = false, $moveFixIssuesTo = false)
    {
        if(!$version->id || !is_numeric($version->id))
        {
            throw new JiraException($version->id . ' is not a valid version id.');
        }

        $data = [];

        if($moveAffectedIssuesTo && $moveAffectedIssuesTo instanceof Version)
        {
            $data['moveAffectedIssuesTo'] = $moveAffectedIssuesTo->name;
        }

        if($moveFixIssuesTo && $moveFixIssuesTo instanceof Version)
        {
            $data['moveFixIssuesTo'] = $moveFixIssuesTo->name;
        }

        $ret = $this->exec($this->uri . '/' . $version->id, json_encode($data), 'DELETE');

        return $ret;
    }

    public function merge($ver)
    {
        throw new JiraException('merge version not yet implemented');
    }

    /**
     * Returns a bean containing the number of fixed in and affected issues for the given version.
     *
     * @param $id int version id
     *
     * @throws JiraException
     *
     * @see https://docs.atlassian.com/jira/REST/server/#api/2/version-getVersionRelatedIssues
     */
    public function getRelatedIssues($id)
    {
        throw new JiraException('get version Related Issues not yet implemented');
    }
}
