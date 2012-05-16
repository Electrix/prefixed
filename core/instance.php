<?php

class phpbb_ext_imkingdavid_prefixed_core_instance
{
	/**
	 * @var dbal Database
	 */
	private $db;
	/**
	 * @var acm Cache
	 */
	private $cache;
	/**
	 * @var int Prefix ID
	 */
	private $prefix;
	/**
	 * @var string Topic ID
	 */
	private $topic;
	/**
	 * @var string Serialized token array
	 */
	private $token_data;
	/**
	 * @var array Token array
	 */
	private $tokens;
	/**
	 * @var int Time when the prefix instance was created
	 */
	private $applied_time;
	/**
	 * @var int Order of the prefix
	 */
	private $ordered;

	/**
	 * Constructor method
	 */
	public function __construct(dbal $db, acm $cache, $id = 0)
	{
		$this->set('id', $id);
		$this->set('db', $db);
	}

	public function load()
	{
		if ($this->id)
		{
			$sql = 'SELECT prefix, topic, token_data, ordered
				FROM ' . PREFIXES_USED_TABLE . '
				WHERE id = ' . (int) $this->id;
			$result = $this->db->sql_query($sql);
			$row = $this->db->sql_fetchrow($result);

			$this->set('prefix', (int) $row['prefix']);
			$this->set('topic', $row['topic']);
			$this->set('token_data', $row['token_data']);
			$this->set('tokens', unserialize($this->token_data));
			$this->set('applied_time', $row['applied_time']);
			$this->set('ordered', $row['ordered']);
		}
	}

	/**
	 * Set properties
	 *
	 * @param string $property Which property to modify
	 * @param mixed $value What value to assign to the property
	 * @return null
	 */
	public function set($property, $value)
	{
		// If the property exists let's set it
		if (isset($this->$property))
		{
			$this->$property = $value;
		}
	}

	/**
	 * Get a property's value
	 *
	 * @param string $property The property to get
	 * @return mixed Value of the property, null if !isset($property)
	 */
	public function get($property)
	{
		return (isset($this->$property)) ? $this->$property : null;
	}
}
