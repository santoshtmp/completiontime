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




global $CFG, $DB, $PAGE;
$cmid = 0;
if (isset($PAGE->cm->id)) {
    $cmid = $PAGE->cm->id;
}
$table = 'local_completion_time';
$conditions =  [
    'cmid' => $cmid
];
$table_data =  $DB->get_record($table, $conditions, $fields = '*', IGNORE_MISSING);
$hour = $min = $sec = '';
if ($table_data) {
    $hour = $table_data->hour;
    $min = $table_data->min;
    $sec = $table_data->sec;
}

?>

<div class="local_completion_time">

    <div id="id_local_completion_time">
        <div id="id_completion_time" class="form-group row  fitem ">
            <div class="col-md-3 col-form-label d-flex pb-0 pr-md-0">
                <p id="id_completion_time_label" class="mb-0 word-break" aria-hidden="true" style="cursor: default;">
                    Set time to complete
                </p>
            </div>
            <div class="col-md-9 checkbox">
                <div class="d-flex left-indented">
                    <div class="completion_time">
                        <input type="number" name="completion_time_hour" id="completion_time_hour" class="completion-time-select" placeholder="hour" min="0" max="24" value="<?php echo $hour; ?>">
                        <input type="number" name="completion_time_min" id="completion_time_min" class="completion-time-select" placeholder="minute" min="0" max="60" value="<?php echo $min; ?>">
                        <input type="number" name="completion_time_sec" id="completion_time_sec" class="completion-time-select" placeholder="second" min="0" max="60" value="<?php echo $sec; ?>">
                    </div>
                </div>
                <div id="validate-completion-time">
                    <div class="hour"></div>
                    <div class="min"></div>
                    <div class="sec"></div>
                </div>
            </div>
        </div>
    </div>

    <script type="text/javascript">
        var id_local_completion_time = document.querySelector("#id_local_completion_time");;
        var fitem_id_completionexpected = document.querySelector("#fitem_id_completionexpected");
        if (id_local_completion_time && fitem_id_completionexpected) {
            fitem_id_completionexpected.outerHTML = fitem_id_completionexpected.outerHTML + id_local_completion_time.innerHTML;
            id_local_completion_time.remove();
            // For input[name="completion"]
            if (document.querySelector('input[name="completion"]')) {
                var id_completion_val = document.querySelector('input[name="completion"]:checked').value;
                if (id_completion_val != 1) {
                    document.getElementById("id_completion_time").style.display = "none";
                }
                document.querySelectorAll('input[name="completion"]').forEach((item) => {
                    item.addEventListener("change", (event) => {
                        if (event.target.value == 1) {
                            document.getElementById("id_completion_time").style = '';
                        } else {
                            document.getElementById("id_completion_time").style.display = "none";
                        }
                    });
                });
            }
            //For select[name="completion"]
            if (document.querySelector('select[name="completion"]')) {
                var id_completion_val = document.querySelector('select[name="completion"]').value;
                if (id_completion_val != 1) {
                    document.getElementById("id_completion_time").style.display = "none";
                }
                document.querySelector('select[name="completion"]').addEventListener("change", (event) => {
                    if (event.target.value == 1) {
                        document.getElementById("id_completion_time").style = '';
                    } else {
                        document.getElementById("id_completion_time").style.display = "none";
                    }
                });
            }
            // validate
            document.querySelector('#completion_time_hour').addEventListener("change", (event) => {
                var validation_output_section = document.querySelector("#validate-completion-time .hour");
                if (event.target.value < 0) {
                    validation_output_section.innerHTML = 'Hour value cannot be less then 0';
                } else if (event.target.value > 24) {
                    validation_output_section.innerHTML = "Hour value cannot be greater then 24";
                } else {
                    validation_output_section.innerHTML = "";
                }
            });
            document.querySelector('#completion_time_min').addEventListener("change", (event) => {
                var validation_output_section = document.querySelector("#validate-completion-time .min");
                if (event.target.value < 0) {
                    validation_output_section.innerHTML = 'Minute value cannot be less then 0';
                } else if (event.target.value > 60) {
                    validation_output_section.innerHTML = "Minute value cannot be greater then 60";
                } else {
                    validation_output_section.innerHTML = "";
                }
            });
            document.querySelector('#completion_time_sec').addEventListener("change", (event) => {
                var validation_output_section = document.querySelector("#validate-completion-time .sec");
                if (event.target.value < 0) {
                    validation_output_section.innerHTML = 'Second value cannot be less then 0';
                } else if (event.target.value > 60) {
                    validation_output_section.innerHTML = "Second value cannot be greater then 60";
                } else {
                    validation_output_section.innerHTML = "";
                }
            });


        }
    </script>
</div>