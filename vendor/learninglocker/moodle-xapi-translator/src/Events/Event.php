<?php namespace MXTranslator\Events;
use \MXTranslator\Repository as Repository;
use \stdClass as PhpObj;

class Event extends PhpObj {
    protected static $xapi_type = 'http://xapi.jisc.ac.uk/vle/';

    /**
     * Reads data for an event.
     * @param [String => Mixed] $opts
     * @return [String => Mixed]
     */
    public function read(array $opts) {
        $version = trim(file_get_contents(__DIR__.'/../../VERSION'));
        $opts['info']->{'https://github.com/JiscDev/Moodle-xAPI-Translator'} = $version;
        $app_name = $opts['app']->fullname ?: 'A Moodle site';
        return [[
            'user_id' => $opts['user']->id,
            'user_url' => $opts['user']->url,
            'user_name' => $opts['user']->username,
            'context_lang' => $opts['course']->lang,
            'context_platform' => 'Moodle',
            'context_ext' => $opts['event'],
            'context_ext_key' => 'http://lrs.learninglocker.net/define/extensions/moodle_logstore_standard_log',
            'context_info' => $opts['info'],
            'time' => date('c', $opts['event']['timecreated']),
            'sessionid' => $opts['sessionid'],
            'app_url' => $opts['app']->url,
            'app_name' => $app_name,
            'app_description' => strip_tags($opts['app']->summary) ?: $app_name,
            'app_type' => 'http://id.tincanapi.com/activitytype/lms',
            'app_ext' => $opts['app'],
            'app_ext_key' => 'http://lrs.learninglocker.net/define/extensions/moodle_course',
            'source_url' => 'http://moodle.org',
            'source_name' => 'Moodle',
            'source_description' => 'Moodle is a open source learning platform designed to provide educators,'
                .' administrators and learners with a single robust, secure and integrated system'
                .' to create personalised learning environments.',
            'source_type' => 'http://id.tincanapi.com/activitytype/source'
        ]];
    }
}
