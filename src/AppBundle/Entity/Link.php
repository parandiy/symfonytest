<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use AppBundle\Entity\Statistic;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * Link
 *
 * @ORM\Table(name="links", indexes={@ORM\Index(name="user_id", columns={"user_id"})})
 * @ORM\Entity
 * @UniqueEntity("shortLink")
 */
class Link
{

	/**
	 * @var string
	 *
	 * @ORM\Column(name="link", type="text", length=65535, nullable=false)
	 */
	private $link;

	/**
	 * @var string
	 *
	 * @ORM\Column(name="short_link", type="string", length=255, nullable=true, unique=true)
	 */
	private $shortLink;

	/**
	 * @var \DateTime
	 *
	 * @ORM\Column(name="date_to", type="datetime", nullable=false)
	 */
	private $dateTo;

	/**
	 * @var \DateTime
	 *
	 * @ORM\Column(name="created_at", type="datetime", nullable=false)
	 */
	private $createdAt = 'CURRENT_TIMESTAMP';

	/**
	 * @var integer
	 *
	 * @ORM\Column(name="id", type="integer")
	 * @ORM\Id
	 * @ORM\GeneratedValue(strategy="IDENTITY")
	 */
	private $id;

	/**
	 * @ORM\OneToMany(targetEntity="AppBundle\Entity\Statistic", mappedBy="link")
	 * @ORM\OrderBy({"createdAt" = "DESC"})
	 */
	private $statistics;

	/**
	 * @var \AppBundle\Entity\User
	 *
	 * @ORM\ManyToOne(targetEntity="AppBundle\Entity\User")
	 * @ORM\JoinColumns({
	 *   @ORM\JoinColumn(name="user_id", referencedColumnName="id")
	 * })
	 */
	private $user;


	public function __construct()
	{
		$this->setCreatedAt( new \DateTime() );
		$this->statistics = new ArrayCollection();
	}


	/**
	 * @return Collection|Statistic[]
	 */
	public function getStatistics(): Collection
	{
		return $this->statistics;
	}


	/**
	 * Set link
	 *
	 * @param string $link
	 *
	 * @return Link
	 */
	public function setLink( $link )
	{
		$this->link = $link;

		return $this;
	}

	/**
	 * Get link
	 *
	 * @return string
	 */
	public function getLink()
	{
		return $this->link;
	}

	/**
	 * Set shortLink
	 *
	 * @param string $shortLink
	 *
	 * @return Link
	 */
	public function setShortLink( $shortLink )
	{
		$this->shortLink = $shortLink;

		return $this;
	}

	/**
	 * Get shortLink
	 *
	 * @return string
	 */
	public function getShortLink()
	{
		return $this->shortLink;
	}

	/**
	 * Set dateTo
	 *
	 * @param \DateTime $dateTo
	 *
	 * @return Link
	 */
	public function setDateTo( $dateTo )
	{
		$this->dateTo = $dateTo;

		return $this;
	}

	/**
	 * Get dateTo
	 *
	 * @return \DateTime
	 */
	public function getDateTo()
	{
		return $this->dateTo;
	}

	/**
	 * Set createdAt
	 *
	 * @param \DateTime $createdAt
	 *
	 * @return Link
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
	 * Set user
	 *
	 * @param \AppBundle\Entity\User $user
	 *
	 * @return Link
	 */
	public function setUser( \AppBundle\Entity\User $user = NULL )
	{
		$this->user = $user;

		return $this;
	}

	/**
	 * Get user
	 *
	 * @return \AppBundle\Entity\User
	 */
	public function getUser()
	{
		return $this->user;
	}
}
