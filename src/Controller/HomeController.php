<?php
namespace App\Controller;

use App\Repository\PropertyRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Twig\Environment;

class HomeController extends AbstractController
{
   
      /**
       * @param PropertyRepository $repository
     * @return Response
     * @Route("/",name="Home")
     */
    public function index(PropertyRepository $repository){

        $properties = $repository ->findlatest();
        dump($properties);
        return $this -> render('pages/home.html.twig',
        ['properties'=>$properties]);
    }
}