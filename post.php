<?php

require_once 'settings.php';
require_once 'debug.php';
require_once 'text.class.php';
require_once 'db.class.php';
require_once 'functions.php';
require_once 'schedule.class.php';

$schedule = new Schedule;

$schedule->request('show', function () use ($schedule) {
	$posts = $schedule->getPosts();
	echo "<ul>";
	foreach($posts as $post) {
		echo "<li>Текст: {$post['text']}</li>";
		echo "<li>Ссылки на изображения: {$post['imagesLinks']}</li>";
		echo "<li>ID группы ВК: {$post['VKGroupID']}</li>";
		echo '<hr>';
	
	}
	echo "</ul>";
});

$schedule->request('post', function() use ($schedule) {
	$request = $schedule->getLastRequest();
	if(!$request) {
		exit('Нету запросов');
	}
	$post = $schedule->getPost($request['postID']);
	post($request['VKGroupID'], $post['text'], $post['imagesLinks']);
	$schedule->deleteRequest($request['id']);
});