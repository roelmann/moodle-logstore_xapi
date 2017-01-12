<?php namespace XREmitter\Events;

error_reporting(E_ALL);
ini_set('display_errors', 1);


use \XREmitter\Repository as Repository;
use \stdClass as PhpObj;

abstract class Event extends PhpObj {
    protected static $verb_display;
    protected $repo;

    /**
     * Constructs a new Event.
     * @param repository $repo
     */
    public function __construct($repo) {
        $this->repo = $repo;
    }

    /**
     * Creates an event in the repository.
     * @param [string => mixed] $event
     * @return [string => mixed]
     */
    public function create(array $event) {
        return $this->repo->createEvent($event);

    }

    /**
     * Reads data for an event.
     * @param [String => Mixed] $opts
     * @return [String => Mixed]
     */
    public function read(array $opts) {
        $version = trim(file_get_contents(__DIR__.'/../../VERSION'));
        $version_key = 'https://github.com/JiscDev/xAPI-Recipe-Emitter';
        $opts['context_info']->{$version_key} = $version;



        return [
            'actor' => $this->readUser($opts, 'user'),
            'context' => [
                'platform' => $opts['context_platform'],
                'extensions' => [
                    'http://xapi.jisc.ac.uk/sessionId'=>$opts['sessionid'],

                    'http://id.tincanapi.com/extension/ip-address'=>$opts['context_ext']['ip']
                    ,
                    'http://lrs.learninglocker.net/define/extensions/info' => $opts['context_info'],

                        'http://xapi.jisc.ac.uk/courseArea'=> [
                            'id'=>$opts['course_ext']->url,
                            'http://xapi.jisc.ac.uk/vle_mod_id'=>$opts['course_ext']->shortname,

                        ],
                ],
            ],
            'timestamp' => $opts['time'],
        ];
    }

    protected function readUser(array $opts, $key) {
        return [
            'account' => [
                'homePage' => $opts[$key.'_url'],
                'name' => $opts[$key.'_name'],
            ],
        ];
    }

    protected function readActivity(array $opts) {
            $activity=[
                'id' => $opts['module_url'],
                'definition' => [
                    'type' => "http://adlnet.gov/expapi/activities/module",
                    'name' => [
                    $opts['context_lang'] => $opts['module_name'],
                    ],
                    'description' => [
                        $opts['context_lang'] => $opts['module_description'],
                        ],

            ],
        ];



        return $activity;
    }


    protected function readAssignment(array $opts) {
            $activity=[
                'id' => $opts['module_url'],
                'definition' => [
                    'type' => "http://adlnet.gov/expapi/activities/module",
                    'name' => [
                    $opts['context_lang'] => $opts['module_name'],
                    ],
                    'description' => [
                        $opts['context_lang'] => $opts['module_description'],
                        ],


                    'extensions' => [
                        'http://xapi.jisc.ac.uk/dueDate'=>date('c', $opts['module_ext']->duedate),
                    ],
            ],
        ];



        return $activity;
    }

    protected function readCourse($opts) {


    $course = [
            'id' => $opts['course_url'],
            'definition' => [
                'type' => $opts['course_type'],
                'name' => [
                    $opts['context_lang'] => $opts['course_name'],
                ],
                'description' => [
                    $opts['context_lang'] => $opts['course_description'],
                ],
            ],
        ];



        return $course;
    }

    protected function readApp($opts) {
       $app = [
            'id' => $opts['app_url'],
            'definition' => [
                'type' => "http://activitystrea.ms/schema/1.0/application",
                'name' => [
                    $opts['context_lang'] => $opts['app_name'],
                ],
                'description' => [
                    $opts['context_lang'] => $opts['app_description'],
                ],
                'extensions' => [
                    'http://xapi.jisc.ac.uk/applicationType' => 'http://id.tincanapi.com/activitytype/lms'

                ],
            ],
        ];

        return $app;
    }

    protected function readSource($opts) {
        return $this->readActivity($opts, 'source');
    }

    protected function readModule($opts) {

        $o=print_r($opts,true);


        $module = [
            'id' => $opts['module_url'],
            'definition' => [
                'type' => $opts['module_type'],
                'name' => [
                    $opts['context_lang'] => $opts['module_name'],
                ],
                'description' => [
                    $opts['context_lang'] => $opts['module_description'],
                ],
                'extensions' => [
                    'http://xapi.jisc.ac.uk/applicationType' => 'http://id.tincanapi.com/activitytype/lms'

                ],

            ],
        ];

        return $module;
    }

    protected function readDiscussion($opts) {
        return $this->readActivity($opts, 'discussion');
    }

    protected function readQuestion($opts) {
        $opts['question_type'] = 'http://adlnet.gov/expapi/activities/cmi.interaction';
        $question = $this->readActivity($opts, 'question');

        $question['definition']['interactionType'] = $opts['interaction_type'];
        $question['definition']['correctResponsesPattern'] = $opts['interaction_correct_responses'];

        $supportedComponentLists = [
            'choice' => ['choices'],
            'sequencing' => ['choices'],
            'likert' => ['scale'],
            'matching' => ['source', 'target'],
            'performance' => ['steps'],
            'true-false' => [],
            'fill-in' => [],
            'long-fill-in' => [],
            'numeric' => [],
            'other' => []
        ];

        foreach ($supportedComponentLists[$opts['interaction_type']] as $index => $listType) {
            if (isset($opts['interaction_'.$listType]) && !is_null($opts['interaction_'.$listType])) {
                $componentList = [];
                foreach ($opts['interaction_'.$listType] as $id => $description) {
                    array_push($componentList, (object)[
                        'id' => (string) $id,
                        'description' => [
                            $opts['context_lang'] => $description,
                        ]
                    ]);
                }
                $question['definition'][$listType] = $componentList;
            }
        }
        return $question;
    }

    protected function readVerbDisplay($opts) {
        $lang = $opts['context_lang'];
        $lang = isset(static::$verb_display[$lang]) ? $lang : array_keys(static::$verb_display)[0];
        return [$lang => static::$verb_display[$lang]];
    }
}
