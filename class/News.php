<?php

namespace Class;

/**
 * Responsible for formatting and validating the 
 * data structure of News.
 */
class News
{
	/**
	 * Primary key of News table
	 *
	 * @var int
	 */
	protected $id;

	/**
	 * Title of the news
	 *
	 * @var string
	 */
	protected $title;
	/**
	 * Content of the news
	 *
	 * @var string
	 */
	protected $body;

	/**
	 * list of comments
	 *
	 * @var string
	 */
	protected $comments;

	/**
	 * Date time created
	 *
	 * @var object
	 */
	protected $createdAt;

	/**
	 * Constructor injection
	 *
	 * @param int $id
	 * @param string $title
	 * @param string $body
	 * @param object $createdAt
	 * @param int $newsId
	 * @param array $aComments => optional
	 */
	public function __construct($id, $title, $body, $createdAt, $aComments = array())
	{
		$this->setId($id);
		$this->setTitle($title);
        $this->setBody($body);
        $this->setCreatedAt($createdAt);
		$this->setComments($aComments);
	}

	public function setComments($aComments)
	{
		$this->comments = $aComments;
		return $this;
	}

	public function getComments()
	{
		return $this->comments;
	}
	
	public function setId($id)
	{
		if ((int)$id < 0 && is_int($id) !== true) {
            throw new InvalidArgumentException('Invalid comment id');
        }

		$this->id = $id;
		return $this;
	}

	public function getId()
	{
		return $this->id;
	}

	public function setTitle($title)
	{
		if (is_string($title) !== true) {
            throw new InvalidArgumentException('Invalid comment title');
        }

		$this->title = $title;

		return $this;
	}

	public function getTitle()
	{
		return $this->title;
	}

	public function setBody($body)
	{
		if (is_string($body) !== true) {
            throw new InvalidArgumentException('Invalid comment body');
        }


		$this->body = $body;

		return $this;
	}

	public function getBody()
	{
		return $this->body;
	}

	public function setCreatedAt($createdAt)
	{
		if ($createdAt instanceof DateTime) {
			throw new InvalidArgumentException('Invalid comment date time');
		}
		
		$this->createdAt = $createdAt;

		return $this;
	}

	public function getCreatedAt()
	{
		return $this->createdAt;
	}
}