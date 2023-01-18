<?php
require 'vendor/autoload.php';
use Utility\DB, Utility\NewsManager, Utility\CommentManager;

$oInstaceDB = DB::getInstance();
foreach (NewsManager::create(CommentManager::create($oInstaceDB), $oInstaceDB)->listNews() as $news) {
	echo("############ NEWS " . $news->getTitle() . " ############\n");
	echo($news->getBody() . "\n");
	foreach ($news->getComments() as $comment) {
		echo("Comment " . $comment['id'] . " : " . $comment['body'] . "\n");
	}
	// Causing multiple queries
	// foreach (CommentManager::create()->listComments() as $comment) {
	// 	if ($comment->getNewsId() == $news->getId()) {
	// 		echo("Comment " . $comment->getId() . " : " . $comment->getBody() . "\n");
	// 	}
	// }
}

$commentManager = CommentManager::create($oInstaceDB);
$c = $commentManager->listComments();
