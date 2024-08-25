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

?>
<div class="local_completion_time">
    <style>
        .btn-success.disabled,
        .btn-success:disabled {
            color: #fff !important;
            background-color: #357a32 !important;
            border-color: #357a32 !important;
        }
    </style>
    <script type="text/javascript">
        var completion_button = document.querySelectorAll('button[data-action="toggle-manual-completion"]');
        if (completion_button) {
            completion_button.forEach((item) => {
                var data = [];
                data['param'] = "cmid=" + item.getAttribute('data-cmid');
                get_XMLHttpRequest_Data(data, function(request) {
                    valu = request.responseText;
                    valu_obj = JSON.parse(valu);
                    if (valu_obj.delay_time_sec > 0) {
                        item.disabled = true;
                    }
                })
            });
        }

        /**
         * =========================================================
         * Make HTTP Object with javascript
         * https://developer.mozilla.org/en-US/docs/Web/API/XMLHttpRequest
         * =========================================================
         */

        function make_XMLHttpRequest() {
            try {
                return new XMLHttpRequest();
            } catch (error) {}
            try {
                return new ActiveXObject('Msxml2.XMLHTTP');
            } catch (error) {}
            try {
                return new ActiveXObject('Microsoft.XMLHTTP');
            } catch (error) {}

            throw new Error('Could not create HTTP request object.');
        }

        /**
         *
         * @param {*} filtr_area_id
         * @param {*} include_script
         * @returns
         */
        function get_XMLHttpRequest_Data(data = [], callback) {
            data = data ? data : []
            submission_link = data['submission_link'] ? data['submission_link'] : M.cfg.wwwroot + '/local/completion_time/classes/api/check_completion_time_mod.php';
            var param = data['param'] ? data['param'] : null;

            var request = make_XMLHttpRequest();
            request.open('POST', submission_link, true);
            request.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
            request.onreadystatechange = () => {
                if (request.readyState === XMLHttpRequest.DONE) {
                    const status = request.status;
                    if (status === 0 || (status >= 200 && status < 400)) {
                        // The request has been completed successfully
                        // console.log(request.responseText);
                    } else {
                        // Oh no! There has been an error with the request!
                    }
                    if (callback) callback(request);
                }
            };

            request.send(param);

        }
    </script>
</div>