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
 * @copyright  santoshtmp7
 * @author    santoshtmp7
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();



/**
 * Callback allowing to add js to $PAGE->requires
 */
// function local_completion_time_before_http_headers()
// {
// }

/**
 * 
 */
// function local_completion_time_before_standard_top_of_body_html()
// {
// }


/**
 * Callback allowing to add to <head> of the page
 *
 * @return string
 */
function local_completion_time_before_standard_html_head()
{
    $helper = new \local_completion_time\helper();
    $helper->before_standard_html_head();
}

/**
 * Callback allowing to add contetnt inside the region-main, in the very end
 *
 * @return string
 */
function local_completion_time_before_footer()
{
    $helper = new \local_completion_time\helper();

    return $helper->before_footer_content();
}
