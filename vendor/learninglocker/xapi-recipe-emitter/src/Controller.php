<?php namespace XREmitter;
use \stdClass as PhpObj;

class Controller extends PhpObj {
    protected $repo;
    public static $routes = [
        'course_viewed' => 'CourseViewed',
        'discussion_viewed' => 'DiscussionViewed',
        'module_viewed' => 'ModuleViewed',
        'attempt_started' => 'AttemptStarted',
        'attempt_abandoned' => 'AttemptCompleted',
        'attempt_completed' => 'AttemptCompleted',
        'attempt_question_completed' => 'QuestionAnswered',
        'user_loggedin' => 'UserLoggedin',
        'user_loggedout' => 'UserLoggedout',
        'assignment_graded' => 'AssignmentGraded',
        'assignment_submitted' => 'AssignmentSubmitted',
        'user_registered' => 'UserRegistered',
        /*'enrolment_created' => 'EnrolmentCreated',*/
        'scorm_launched' => 'ScormLaunched',
    ];

    /**
     * Constructs a new Controller.
     * @param Repository $repo
     */
    public function __construct($repo) {
        $this->repo = $repo;
    }

    /**
     * Creates a new event.
     * @param [String => Mixed] $events
     * @return [String => Mixed]
     */
    public function createEvents(array $events) {
        $statements = [];
        foreach ($events as $index => $opts) {


            $route = isset($opts['recipe']) ? $opts['recipe'] : '';


            if (isset(static::$routes[$route])) {
                $event = '\XREmitter\Events\\'.static::$routes[$route];
                $service = new $event($this->repo);
                $opts['context_lang'] = $opts['context_lang'] ?: 'en';
                array_push($statements, $service->read($opts));
            }
        }
        return $this->repo->createEvents($statements);
    }
}
