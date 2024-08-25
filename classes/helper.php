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

namespace local_completion_time;

defined('MOODLE_INTERNAL') || die();

class helper
{
    public function before_standard_html_head()
    {
        global $PAGE;
        $PAGE->requires->css('/local/completion_time/dist/style.css');
        $PAGE->requires->js('/local/completion_time/dist/javascript.js');
    }

    public function before_footer_content()
    {
        $contents = '';
        $contents .= $this->local_completion_time_user_section();
        $contents .= $this->local_completion_time_form_section();
        // $contents .= '<script src=" ' . $CFG->wwwroot . '/local/completion_time/dist/javascript.js"></script>';
        return  $contents;
    }

    /**
     * 
     */
    public function local_completion_time_form_section()
    {
        global $CFG;
        $url = $_SERVER['REQUEST_URI'];
        $url_path = parse_url($url, PHP_URL_PATH);
        if (str_contains($url_path, '/course/modedit.php')) {
            ob_start();
            include_once($CFG->dirroot .'//local/completion_timeinc/completion_time_form.php');
            $contents = ob_get_contents();
            ob_end_clean();
            return  $contents;
        }
        return '';
    }

    /**
     * 
     */
    public function local_completion_time_user_section()
    {
        global $PAGE, $CFG;

        if ($PAGE->pagelayout === 'course') {
            ob_start();
            include_once($CFG->dirroot . '/local/completion_time/inc/completion_time_user_course.php');
            $contents = ob_get_contents();
            ob_end_clean();
            return  $contents;
        }

        if ($PAGE->pagelayout === 'incourse' && isset($PAGE->cm->id)) {
            if ($PAGE->cm->completion == 1) {
                ob_start();
                include_once($CFG->dirroot . '/local/completion_time/inc/completion_time_user_incourse.php');
                $contents = ob_get_contents();
                ob_end_clean();
                return  $contents;
            }
        }

        return  '';
    }
}
