<?php
namespace Utility;
use Class\News, Class\Comment;
use Utility\DB, Utility\CommentManager;


class NewsManager
{
	private static $instance = null;

	/**
	 * Instance of Comment
	 *
	 * @var CommentManager::class
	 */
	private $oCommentInstance;

	/**
	 * Instance of Database
	 *
	 * @var DB::class
	 */
	private $oDatabase;

	/**
	 * Private constructor for factory pattern
	 *
	 * @param CommentManager $comments
	 */
    private function __construct(CommentManager $comments, DB $oDatabase)
    {
        $this->oCommentInstance = $comments;
		$this->oDatabase = $oDatabase;
    }

	/**
	 * Returns an Instance of NewsManager
	 *
	 * @param CommentManager $comments
	 * @return NewsManager::class
	 */
	public static function create(CommentManager $comments, DB $oDatabase)
    {
        return new NewsManager($comments, $oDatabase);
    }

	/**
	* List all news
	* @param int $page
	* @return News::class
	*/
	public function listNews(int $page = 1)
	{
		$itemsPerPage = 10;
		$offset = ($page - 1) * $itemsPerPage;
		$sSqlStatement = 'SELECT news.id, news.title, news.body, news.created_at FROM `news`';
		$sSqlStatement .= sprintf(' LIMIT %d OFFSET %d', $itemsPerPage, $offset);
		
		$rows = $this->oDatabase::getInstance()->select($sSqlStatement);

		/**
		 * Returns empty array if theres no data.
		 */
		if (empty($rows) === true) {
			return [];
		}

		/**
		 * Get news Id
		 */
		$aIds = array_map(function ($item) {
			return $item['id'];
		}, $rows);
		
		/**
		 * Retrieved the comments using news Id/s to avoid multiple queries
		 */
		$comments = $this->oCommentInstance->getCommentsByNewsId($aIds);

		$news = [];
		foreach($rows as $row) {
			$aNewsComment = [];
			foreach ($comments as $comment) {
				if ((int)$row['id'] === (int)$comment->getNewsId()) {
					$aNewsComment[] = array(
						'id' => $comment->getId(),
						'body' => $comment->getBody()
					);
				}
			}
			$news[] = new News($row['id'], $row['title'], $row['body'], $row['created_at'], $aNewsComment);
			
		}

		return $news;
	}

	/**
	* add a record in news table
	*/
	public function addNews(string $title, string $body)
	{
		$title = htmlspecialchars($title, ENT_QUOTES, 'UTF-8');
		$body = htmlspecialchars($body, ENT_QUOTES, 'UTF-8');

		$sql = "INSERT INTO `news` (`title`, `body`, `created_at`) VALUES('$title','$body','" . date('Y-m-d') . "')";
		// $this->oDatabase::getInstance()->exec($sql);
		$aParams = array(
			$title, $body
		);
		$sStatement = $this->oDatabase::getInstance()->pdoStatement($sql);
		$sStatement->execute();
		return $this->oDatabase::getInstance()->lastInsertId($sql);
	}

	/**
	* deletes a news, and also linked comments
	*/
	public function deleteNews(int $id)
	{
		$id = htmlspecialchars($id, ENT_QUOTES, 'UTF-8');
		$comments = $this->oCommentInstance->listComments();
		$idsToDelete = [];

		foreach ($comments as $comment) {
			if ($comment->getNewsId() == $id) {
				$idsToDelete[] = $comment->getId();
			}
		}

		foreach($idsToDelete as $id) {
			$this->oCommentInstance->deleteComment($id);
		}
		
		$sql = "DELETE FROM `news` WHERE `id`=$id";
		$aParams = array(
			$sql
		);
		$sStatement = $this->oDatabase::getInstance()->pdoStatement($sql);
		
		return $sStatement->execute();
	}
}