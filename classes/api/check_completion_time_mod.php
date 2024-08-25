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
 * @copyright 
 * @author    
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */



define('AJAX_SCRIPT', true);
define('REQUIRE_CORRECT_ACCESS', true);
define('NO_DEBUG_DISPLAY', true);

@header('Access-Control-Allow-Origin: *');

require_once(dirname(__FILE__) . '/../../../../config.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $return_data = [];

    $cmid = isset($_POST['cmid']) ? (int)$_POST['cmid'] : 0;
    if ($cmid) {
        $table_data =  $DB->get_record('local_completion_time', ['cmid' => $cmid], $fields = '*', IGNORE_MISSING);
        $delay_time_sec = 0;
        if ($table_data) {
            $hour = (int)$table_data->hour;
            $min = (int)$table_data->min;
            $sec = (int)$table_data->sec;
            $delay_time_sec = ($hour * 3600 + $min * 60 +  $sec) * 1000;
        }
        $return_data['cmid'] = $cmid;
        $return_data['delay_time_sec'] = $delay_time_sec;
        echo json_encode($return_data);
    }
}
die;
