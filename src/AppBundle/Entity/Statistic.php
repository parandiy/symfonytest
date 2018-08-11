<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Statistic
 *
 * @ORM\Table(name="statistic", indexes={@ORM\Index(name="link_id", columns={"link_id"})})
 * @ORM\Entity
 */
class Statistic
{
	/**
	 * @var string
	 *
	 * @ORM\Column(name="geo", type="string", length=7, nullable=false)
	 */
	private $geo;

	/**
	 * @var string
	 *
	 * @ORM\Column(name="user_agent", type="text", length=65535, nullable=false)
	 */
	private $userAgent;

	/**
	 * @var integer
	 *
	 * @ORM\Column(name="ip", type="string", length=20, nullable=false)
	 */
	private $ip;

	/**
	 * @var \DateTime
	 *
	 * @ORM\Column(name="created_at", type="datetime", nullable=false)
	 */
	private $createdAt;

	/**
	 * @var integer
	 *
	 * @ORM\Column(name="id", type="integer")
	 * @ORM\Id
	 * @ORM\GeneratedValue(strategy="IDENTITY")
	 */
	private $id;

	/**
	 * @var \AppBundle\Entity\Link
	 *
	 * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Link")
	 * @ORM\JoinColumns({
	 *   @ORM\JoinColumn(name="link_id", referencedColumnName="id")
	 * })
	 */
	private $link;


	public function __construct()
	{
		$this->setCreatedAt( new \DateTime() );
	}

	/**
	 * Set geo
	 *
	 * @param string $geo
	 *
	 * @return Statistic
	 */
	public function setGeo( $geo )
	{
		$this->geo = $geo;

		return $this;
	}

	/**
	 * Get geo
	 *
	 * @return string
	 */
	public function getGeo()
	{
		return $this->geo;
	}

	/**
	 * Set userAgent
	 *
	 * @param string $userAgent
	 *
	 * @return Statistic
	 */
	public function setUserAgent( $userAgent )
	{
		$this->userAgent = $userAgent;

		return $this;
	}

	/**
	 * Get userAgent
	 *
	 * @return string
	 */
	public function getUserAgent()
	{
		return $this->userAgent;
	}

	/**
	 * Set ip
	 *
	 * @param integer $ip
	 *
	 * @return Statistic
	 */
	public function setIp( $ip )
	{
		$this->ip = $ip;

		return $this;
	}

	/**
	 * Get ip
	 *
	 * @return integer
	 */
	public function getIp()
	{
		return $this->ip;
	}

	/**
	 * Set createdAt
	 *
	 * @param \DateTime $createdAt
	 *
	 * @return Statistic
	 */
	public function setCreatedAt( $createdAt )
	{
		$this->createdAt = $createdAt;

		return $this;
	}

	/**
	 * Get createdAt
	 *
	 * @return \DateTime
	 */
	public function getCreatedAt()
	{
		return $this->createdAt;
	}

	/**
	 * Get id
	 *
	 * @return integer
	 */
	public function getId()
	{
		return $this->id;
	}

	/**
	 * Set link
	 *
	 * @param \AppBundle\Entity\Link $link
	 *
	 * @return Statistic
	 */
	public function setLink( \AppBundle\Entity\Link $link = NULL )
	{
		$this->link = $link;

		return $this;
	}

	/**
	 * Get link
	 *
	 * @return \AppBundle\Entity\Link
	 */
	public function getLink()
	{
		return $this->link;
	}
}
