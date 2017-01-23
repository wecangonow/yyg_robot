#!/bin/bash

robot_process=`ps aux|grep php|grep -v grep |grep robot|wc -l`

if [ $robot_process -eq 0 ]; then
	/export/soft/php/bin/php /export/yyg_robot/robot.php &
 	echo "success start robot task:"+`date +%Y%m%d%H%M%S` >> /export/yyg_robot/start_robot.log
fi
