<?php
include("config.php");

class StatisticsCollector {

    public function gatherStats() {
        $dates = Database::getInstance()->select(POSTS_TABLE, ["DISTINCT " . POST_DATE_CREATED_COL]);
        
        foreach ($dates[0] as $date) {
            $dateObject = new DateTime($date);
            $date = $dateObject->format("Y-m-d");
            $nextDateObject = clone $dateObject;
            $nextDateObject->modify('+1 day');
            for ($hour = 0; $hour < 24; $hour++) {
                $currHour = str_pad($hour, 2, '0', STR_PAD_LEFT) . ":00:00";
                $nextHour = null;
                $nextHour = $currHour != "23:00:00" ? str_pad($hour + 1, 2, '0', STR_PAD_LEFT) . ":00:00" : "00:00:00";
                $currDateTime = $date . " " . $currHour;
                $nextDateTime = $nextHour != "00:00:00" ? $date . " " . $nextHour : $nextDateObject->format("Y-m-d") . " " . $nextHour;
                $count = Database::getInstance()->select(POSTS_TABLE, ["COUNT(*) AS post_count"], [POST_DATE_CREATED_COL . " BETWEEN '$currDateTime' AND '$nextDateTime'"]);
                Database::getInstance()->insert(POST_STATS_TABLE, [POST_STATS_DATE_COL => $date, POST_STATS_TIME_COL => $currHour, POST_STATS_COUNT_COL => $count[0]["post_count"]], [POST_STATS_COUNT_COL]);
            }
        }
    }

}