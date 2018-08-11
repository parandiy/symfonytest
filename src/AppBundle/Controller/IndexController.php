<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Link;
use AppBundle\Entity\Statistic;
use AppBundle\Form\LinksType;
use FOS\UserBundle\Model\UserInterface;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Victorybiz\GeoIPLocation\GeoIPLocation;

class IndexController
	extends Controller
{
	/**
	 * @Route("/", name="index")
	 */
	public function indexAction( Request $request )
	{
		$link = new Link();
		$form = $this->createForm( LinksType::class,
		                           $link,
		                           array(
			                           'action' => $this->generateUrl( 'index' ),
			                           'method' => 'POST',
		                           ) );

		$form->handleRequest( $request );

		if ( $form->isSubmitted() && $form->isValid() )
		{
			// $form->getData() holds the submitted values
			// but, the original `$task` variable has also been updated
			$link = $form->getData();
			$user = $this->get( 'security.token_storage' )
			             ->getToken()
			             ->getUser();
			$link->setUser( $user );

			$entityManager = $this->getDoctrine()
			                      ->getManager();
			$entityManager->persist( $link );
			$entityManager->flush();

			$shortLink = base_convert( ( $link->getId() + 10000 ), 20, 36 );

			$link->setShortLink( $shortLink );
			$entityManager->persist( $link );
			$entityManager->flush();

			return $this->redirectToRoute( 'link_view', [ 'id' => $link->getId() ] );
		}

		return $this->render( 'AppBundle:Index:index.html.twig',
		                      array(
			                      'form'  => $form->createView(),
			                      'links' => $link = $this->getDoctrine()
			                                              ->getRepository( Link::class )
			                                              ->findByUser( $this->get( 'security.token_storage' )
			                                                                 ->getToken()
			                                                                 ->getUser() )
		                      ) );
	}

	/**
	 * @Route("/view/{id}", name="link_view")
	 */
	public function linkViewAction( $id )
	{
		$link = $this->getDoctrine()
		             ->getRepository( Link::class )
		             ->find( $id );

		if ( !$link )
		{
			throw $this->createNotFoundException( 'The link does not exist' );
		}

		return $this->render( 'AppBundle:Index:view.html.twig',
		                      array(
			                      'link' => $link
		                      ) );
	}

	/**
	 * @Route("/edit/{id}", name="edit_link")
	 */
	public function edit( $id, Request $request )
	{
		$link = $this->getDoctrine()
		             ->getRepository( Link::class )
		             ->find( $id );

		if ( !$link )
		{
			throw $this->createNotFoundException( 'The link does not exist' );
		}

		$new_link = $request->request->get( 'link' );

		if ( !empty( $new_link ) )
		{
			$link->setShortLink( $request->request->get( 'link' ) );
			$entityManager = $this->getDoctrine()
			                      ->getManager();
			$entityManager->persist( $link );
			$entityManager->flush();
		}

		return $this->redirectToRoute( 'link_view', [ 'id' => $link->getId() ] );
	}

	/**
	 * @Route("/{link}", name="process")
	 */
	public function process( $link, Request $request )
	{
		$link = $this->getDoctrine()
		             ->getRepository( Link::class )
		             ->findOneByShortLink( $link );

		if ( $link && $link->getDateTo() >= new \DateTime() )
		{
			$geoip = new GeoIPLocation();

			$stat = new Statistic();
			$stat->setGeo( $geoip->getCountryCode() );
			$stat->setIp( $geoip->getIP() );
			$stat->setUserAgent( $request->headers->get( 'User-Agent' ) );
			$stat->setLink( $link );

			$entityManager = $this->getDoctrine()
			                      ->getManager();
			$entityManager->persist( $stat );
			$entityManager->flush();

			return $this->redirect( $link->getLink() );
		}
		else
		{
			throw $this->createNotFoundException( 'The link does not exist' );
		}
	}
}
