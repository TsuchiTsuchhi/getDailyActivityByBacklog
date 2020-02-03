<meta charset="UTF-8">
<style>
	pre {
		display: inline-block;
		padding:  20px;
		width: 500px;
		background-color: #ededed;
		color: #333;
		font-size: 12px;
		margin-bottom: 30px;
		vertical-align: top;
		margin-right: 30px;
	}
</style>

<?php
ini_set('xdebug.var_display_max_children', -1);
ini_set('xdebug.var_display_max_data', -1);
ini_set('xdebug.var_display_max_depth', -1);

/**
 * Backlog連携周りの設定
 */
$userId = 00000;
$backlogApiKey = 'XXXXXXXXXXXXXXXXXXXXXXXXXXXXXXX';
$getCommentCnt = 100;
$getDate = date('Y-m-d');
$getStartDate = '10:30';
$getEndDate = '19:30';

/**
 * 出力テキスト内変数
 */

$params = array(
	'apiKey' => $backlogApiKey,
	'count' => $getCommentCnt
);
$getActivitiesUrl = "https://alfos.backlog.com/api/v2/users/".$userId."/activities?".http_build_query($params, '','&');

$headers = array('Content-Type:application/x-www-form-urlencoded');
$context = array(
	'http' => array(
		'method' => 'GET',
		'header' => $headers,
		'ignore_errors' => true,
	)
);
# レスポンスを変数で扱えるように変換
$activitiesList = json_decode(
	mb_convert_encoding(
		file_get_contents(
			$getActivitiesUrl, false, stream_context_create($context)),
		'UTF8',
		'ASCII,JIS,UTF-8,EUC-JP,SJIS-WIN'
	),
	true
);

$exportText = '';
$exportList = array();
$taskList = array();
foreach ($activitiesList as $activityKey => $activity) {
	$project = $activity['project']['projectKey'];
	$createdDate = date('Y-m-d', strtotime($activity['created']));
	
	if(
		!empty($activity['content']['key_id'])
	&& $createdDate == $getDate
	) {
		$taskName = $project.'-'.$activity['content']['key_id'].' '.$activity['content']['summary'];
		
		$exportList[$project][] = array(
			'task_key' => $project.'-'.$activity['content']['key_id'],
			'project' => $project,
			'task_name' => $taskName
		);
	}
}

/**
 * 投稿テキスト作成
 */
$reportText = "\n## 実施時間\n";
$reportText .= $getStartDate."-".$getEndDate."\n\n";
$reportText .= "## 実施内容\n";

foreach ($exportList as $exportProjectKey => $exportProject) {
	$taskList = array_unique($exportProject, SORT_REGULAR);
	$reportText .= '* '.$exportProjectKey."\n";
	foreach ($taskList as $taskKey => $task) {
		$reportText .= '    *  '.$task['task_name']."\n";
	}
}
echo '<pre>';
echo $reportText;
echo '</pre>';

