<?php

// This file is part of Moodle - http://moodle.org/
//
// Moodle is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.
//
// Moodle is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with Moodle.  If not, see <http://www.gnu.org/licenses/>.

/**
 * @package   local_completion_time    
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

namespace local_completion_time\event;

use stdClass;

defined('MOODLE_INTERNAL') || die();

/**
 * Observer definition
 *
 * @package    
 * @copyright  2017 e-ABC Learning
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 * @author     Osvaldo Arriola <osvaldo@e-abclearning.com>
 */
class observer
{

    /**
     * hook module_updated event
     * @param \core\event\course_module_updated $event
     */
    public static function module_updated(\core\event\course_module_updated $event)
    {
        module_created_update($event);
    }

    /**
     * hook module_created event
     * @param \core\event\course_module_created $event
     */
    public static function module_created(\core\event\course_module_created $event)
    {
        module_created_update($event);
    }

    // 
}

/**
 * @param $event
 */
function module_created_update($event)
{
    global $DB, $CFG;
    $cm_id = $event->objectid;
    $modulename = $event->other['modulename'];
    $completion = isset($_POST['completion']) ? $_POST['completion'] : '';
    if ($completion == 1) {
        $hour = isset($_POST['completion_time_hour']) ? $_POST['completion_time_hour'] : 0;
        $min = isset($_POST['completion_time_min']) ? $_POST['completion_time_min'] : 0;
        $sec = isset($_POST['completion_time_sec']) ? $_POST['completion_time_sec'] : 0;

        $data = new stdClass();
        $data->cmid = (int)$cm_id;
        $data->hour = (int)$hour;
        $data->min = (int)$min;
        $data->sec = (int)$sec;
        $data->timemodified = time();

        $table = 'local_completion_time';
        $conditions =  [
            'cmid' => $data->cmid
        ];
        $table_data =  $DB->get_record($table, $conditions, $fields = '*', IGNORE_MISSING);
        if ($table_data) {
            $data->id = $table_data->id;
            $status = $DB->update_record($table, $data);
        } else {
            $data->timecreated = time();
            $status = $DB->insert_record($table, $data);
        }
    }
}
