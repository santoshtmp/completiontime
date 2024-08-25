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


defined('MOODLE_INTERNAL') || die();

//  https://docs.moodle.org/dev/Events_API

/* 
eventname – fully qualified event class name or "*" indicating all events, ex.: \plugintype_pluginname\event\something_happened.
callback - PHP callable type.
includefile - optional. File to be included before calling the observer. Path relative to dirroot.
priority - optional. Defaults to 0. Observers with higher priority are notified first.
internal - optional. Defaults to true. Non-internal observers are not called during database transactions, but instead after a successful commit of the transaction. 
*/

$observers = array(

    // course module updated
    array(
        'eventname'   => 'core\event\course_module_updated',
        'callback'    => 'local_completion_time\event\observer::module_updated',
    ),
    // // course module created
    array(
        'eventname'   => 'core\event\course_module_created',
        'callback'    => 'local_completion_time\event\observer::module_created',
    ),


);
