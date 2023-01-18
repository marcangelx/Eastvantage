<?php

namespace Class;
/**
 * Responsible for formatting and validating the 
 * data structure of comments.
 */
class Comment
{
	
	/**
	 *  Primary key of the comment table
	 *
	 * @var int
	 */
	protected $id;

	/**
	 * Content of the comment
	 *
	 * @var string
	 */
	protected $body;

	/**
	 * Date and time created
	 *
	 * @var object
	 */
	protected $createdAt;

	/**
	 * Foreign key of the News table
	 *
	 * @var int
	 */
	protected $newsId;

	/**
	 * Constructor injection
	 *
	 * @param int $id
	 * @param string $body
	 * @param object $createdAt
	 * @param int $newsId
	 */
	public function __construct($id, $body, $createdAt, $newsId)
	{
		$this->setId($id);
        $this->setBody($body);
        $this->setCreatedAt($createdAt);
        $this->setNewsId($newsId);
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

	public function getNewsId()
	{
		return $this->newsId;
	}

	public function setNewsId($newsId)
	{
		if ((int)$newsId < 0 && is_int($newsId) !== true) {
            throw new InvalidArgumentException('Invalid comment newsId');
        }

		$this->newsId = $newsId;

		return $this;
	}
}