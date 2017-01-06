<?php namespace LogExpander\Events;
use \LogExpander\Repository as Repository;
use \stdClass as PhpObj;

class Event extends PhpObj {
    protected $repo;

    /**
     * Constructs a new Event.
     * @param repository $repo
     */
    public function __construct(Repository $repo) {
        $this->repo = $repo;
    }

    /**
     * Reads data for an event.
     * @param [String => Mixed] $opts
     * @return [String => Mixed]
     */
    public function read(array $opts) {
        $version = trim(file_get_contents(__DIR__.'/../../VERSION'));
        $user = $opts['userid'] < 1 ? null : $this->repo->readUser($opts['userid']);
        $relateduser = $opts['relateduserid'] < 1 ? null : $this->repo->readUser($opts['relateduserid']);
        $course = $this->repo->readCourse($opts['courseid']);
        if (
            ($user === false)
            || ($relateduser === false)
            || ($course === false)
        ){
            return null;
        }

        return [
            'user' => $user,
            'sessionid' =>sesskey(),
            'relateduser' => $relateduser,
            'course' => $course,
            'app' => $this->repo->readSite(),
            'info' => (object) [
                'https://moodle.org/' => $this->repo->readRelease(),
                'https://github.com/LearningLocker/Moodle-Log-Expander' => $version,
            ],
            'event' => $opts,
        ];
    }
}
