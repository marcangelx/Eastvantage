<?php
namespace Utility;

use Class\Comment;
use Utility\DB;

class CommentManager
{

	/**
	 * Instance of Database
	 *
	 * @var DB::class
	 */
	private $oDatabase;

	/**
	 * Self Instance
	 *
	 * @var [type]
	 */
	private static $instance = null;

	private function __construct(DB $oDatabase)
	{
		$this->oDatabase = $oDatabase;
	}

	/**
	 *	Get list of comments 
	 *
	 * @param int $page
	 * @return array
	 */
	public function listComments($page = 1)
	{
		$sql = 'SELECT * FROM `comment`';
		return $this->getComments($sql, $page);
	}

	/**
	 * Get comments by Id/s
	 *
	 * @param int|array $aNewsId
	 * @param int $page
	 * @return void
	 */
	public function getCommentsByNewsId($mNewsId = array(), $page = 1)
	{
		//casting array to int
		$aNewsId = (array)$mNewsId;
		$aNewsId = array_map('intval', $aNewsId);

		if (empty($aNewsId) === true) {
			return [];
		}
		
		$sql = 'SELECT * FROM `comment` WHERE news_id IN (' .implode(",", $aNewsId) .')' ;
	
		return $this->getComments($sql, $page);

	}

	/**
	 * Retrieve comments
	 *
	 * @param string $sql
     * @param int $page
	 * @return Comment::class
	 */
	private function getComments($sql, $page)
	{
		$itemsPerPage = 10;
		$offset = ($page - 1) * $itemsPerPage;
		$sql .= sprintf(' LIMIT %d OFFSET %d', $itemsPerPage, $offset);
		$rows = $this->oDatabase::getInstance()->select($sql);

		/**
		 * returns empty array if theres no data.
		 */
		if (empty($rows) === true) {
		
			return [];
		}

		foreach($rows as $row) {
			$comments[] = new Comment($row['id'], $row['body'], $row['created_at'], $row['news_id']);
		}


		return $comments;
	}


	/**
	 * Add comment for news
	 *
	 * @param string $body
	 * @param int $newsId
	 * @return int|boolean
	 */
	public function addCommentForNews(string $body, int $newsId)
	{
		$body = htmlspecialchars($body, ENT_QUOTES, 'UTF-8');
		$newsId = htmlspecialchars($newsId, ENT_QUOTES, 'UTF-8');


		$sql = "INSERT INTO `comment` (`body`, `created_at`, `news_id`) VALUES('$body','" . date('Y-m-d') . "','$newsId')";
		$aParams = array(
			$body, $newsId
		);
		$sStatement = $this->oDatabase::getInstance()->pdoStatement($sql);
		$sStatement->execute();
		return DB::getInstance()->lastInsertId($sql);
	}

	/**
	 * Delete comment
	 *
	 * @param int $id
	 * @return boolean
	 */
	public function deleteComment(int $id)
	{
		$id = htmlspecialchars($id, ENT_QUOTES, 'UTF-8');

		$sql = "DELETE FROM `comment` WHERE `id`=$id";

		$sStatement = $this->oDatabase::getInstance()->pdoStatement($sql, array($id));
		$sStatement->execute();
		return $this->oDatabase::getInstance()->exec($sql);
	}

	/**
	 * Factory pattern of CommentManager
	 *
	 * @return void
	 */
	public static function create(DB $oDatabase)
    {
        return new CommentManager($oDatabase);
    }
}