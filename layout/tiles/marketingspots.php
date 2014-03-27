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
 * Shoehorn theme with the underlying Bootstrap theme.
 *
 * @package    theme
 * @subpackage shoehorn
 * @copyright  &copy; 2014-onwards G J Barnard in respect to modifications of the Bootstrap theme.
 * @author     G J Barnard - gjbarnard at gmail dot com and {@link http://moodle.org/user/profile.php?id=442195}
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

$numberofmarketingspots = (empty($PAGE->theme->settings->numberofmarketingspots)) ? false : $PAGE->theme->settings->numberofmarketingspots;
$marketingspotsdisplay = (empty($PAGE->theme->settings->marketingspotsdisplay)) ? 4 : $PAGE->theme->settings->marketingspotsdisplay;

// Decide on showing the marketing spots.  If so, then the number will still need to be greater than zero.
switch($marketingspotsdisplay) {
    case 1: // Never.
        $numberofmarketingspots = false;
        break;
    case 2: // Logged out.
        $numberofmarketingspots = (isloggedin() == false) ? $numberofmarketingspots : false;
        break;
    case 3: // Logged in.
        $numberofmarketingspots = (isloggedin() == true) ? $numberofmarketingspots : false;
        break;
    case 4: // Always.
    default: // Do nothing.
        break;
}

if ($numberofmarketingspots) {
    $marketingspots = array();
    $lang = current_language();
    $o = '';
    for ($ms = 1; $ms <= $numberofmarketingspots; $ms++) {
        $marketingspotlang = 'marketingspotlang'.$ms;
        if (empty($PAGE->theme->settings->$marketingspotlang) or ($PAGE->theme->settings->$marketingspotlang == 'all') or ($PAGE->theme->settings->$marketingspotlang == $lang)) {
            // Show the marketing spot.
            $marketingspotheading = 'marketingspotheading'.$ms;
            $marketingspotcontent = 'marketingspotcontent'.$ms;
            $themarketingspot = html_writer::tag('h2', $PAGE->theme->settings->$marketingspotheading);
            $themarketingspot .= html_writer::tag('div', $PAGE->theme->settings->$marketingspotcontent);
            $marketingspots[] = $themarketingspot;
        }
    }
    $mscount = count($marketingspots);
    if ($mscount >= 1) {
        $col = 12 / $mscount;
        if ($col < 3) {
            $col = 3;
        }
        $o = html_writer::start_tag('div', array('class' => 'row'));
        foreach($marketingspots as $marketingspot) {
            $o .= html_writer::start_tag('div', array('class' => 'col-sm-'.$col.' col-md-'.$col.' col-lg-'.$col));
            $o .= html_writer::start_tag('div', array('class' => 'marketingspot'));
            $o .= $marketingspot;
            $o .= html_writer::end_tag('div');
            $o .= html_writer::end_tag('div');
        }
        $o .= html_writer::end_tag('div');
        echo $o;
    }
}
