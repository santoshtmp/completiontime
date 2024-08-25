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

global $DB, $PAGE;

$cmid = $PAGE->cm->id;
$table_data =  $DB->get_record('local_completion_time', ['cmid' => $cmid], $fields = '*', IGNORE_MISSING);
$delay_time_sec = 0;
if ($table_data) {
    $hour = (int)$table_data->hour;
    $min = (int)$table_data->min;
    $sec = (int)$table_data->sec;
    $delay_time_sec = $hour * 3600 + $min * 60 +  $sec;
}

?>
<div class="local_completion_time">

    <script type="text/javascript">
        var delay_time = <?php echo $delay_time_sec; ?>;
        console.log(delay_time);
        if (delay_time > 0) {
            var time_count_down_div = document.querySelector('button[data-action="toggle-manual-completion"]');
            if (time_count_down_div) {
                time_count_down_div.outerHTML = time_count_down_div.outerHTML + '<button id="time_count_down" class="btn btn-secondary" disabled>0 : 0 : 0</button>';

                var completion_button = document.querySelector('button[data-action="toggle-manual-completion"]');
                completion_button.disabled = true;
                if (!completion_button.classList.contains('btn-success')) {

                    // Update the count down every 1 second
                    var distance = delay_time;
                    var timer = setInterval(function() {
                        // Time calculations for hours, minutes and seconds
                        var hours = Math.floor((distance % (60 * 60 * 24)) / (60 * 60));
                        var minutes = Math.floor((distance % (60 * 60)) / (60));
                        var seconds = Math.floor((distance % (60)));
                        document.getElementById("time_count_down").innerHTML = hours + " : " +
                            minutes + " : " + seconds;

                        // the count down is over
                        if (distance < 0) {
                            clearInterval(timer);
                            compltion_event_click();
                            document.getElementById("time_count_down").innerHTML = "<span>Time complete</span> <span style = 'padding-left: 5px;'> 0 : 0 : 0</span> ";
                            // document.getElementById("time_count_down").style.display = "none";;
                        }
                        distance = distance - 1;
                    }, 1000);

                    // 
                    function compltion_event_click() {
                        completion_button.disabled = false;
                        completion_button.click();
                        completion_button.disabled = true;
                        var btn_success = setInterval(function() {
                            if (document.querySelector('button[data-action="toggle-manual-completion"]').classList.contains('btn-success')) {
                                document.querySelector('button[data-action="toggle-manual-completion"]').disabled = true;
                                clearInterval(btn_success);
                            } else {
                                setTimeout(function() {
                                    document.querySelector('button[data-action="toggle-manual-completion"]').disabled = true;
                                    clearInterval(btn_success);
                                }, 20000);
                            }
                        }, 1000);
                    }

                } else {
                    document.getElementById("time_count_down").innerHTML = "<span>Time complete</span> <span style = 'padding-left: 5px;'> 0 : 0 : 0</span> ";
                    // document.getElementById("time_count_down").style.display = "none";;
                }
            }
            // reset time on forward and backward
            window.onbeforeunload = function() {
                distance = delay_time;
            };
        }
    </script>
</div>