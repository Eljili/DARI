<?php
namespace App\Controller\Admin;

use App\Entity\Property;
use App\Form\PropertyType;
use App\Repository\PropertyRepository;
use Doctrine\Persistence\ObjectManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class Adminpropertycontroler extends AbstractController
{
     /**
      *@var PropertyRepository
     */
    private $repository;
    /**
      *@var ObjectManager
     */

    public function __construct(PropertyRepository $repository, ObjectManager $em)
    {
      $this ->repository = $repository; 
      $this ->em = $em;
    }

     /**
     * @Route("/Admin",name="Admin.property.index")
     * @Route("/biens",name="property.index")
     */
    public function index():Response
    {
      
        $properties = $this ->repository->findAll() ;
        return $this-> render('Admin\property\index.html.twig',compact('properties')
    );
  }
       /**
     * @Route("/Admin/property/create",name="Admin.property.New")
     * 
     */
    public function New( Request $request):Response
    {
        $property = new Property;
        $from = $this-> createForm(PropertyType::class, $property);
        $from ->handleRequest($request);

            if ($from -> isSubmitted() && $from ->isValid() ) {
                $this -> em ->persist($property);
                $this -> em ->flush();
                return $this -> redirectToRoute('Admin.property.index');
            }
                return $this -> render('Admin/property/New.html.twig',[
                    'property'=>$property,
                    'form'=>$from->createView()
                ]) ;  
    }
      

     /**
      * @param Property $property 
     * @Route("/Admin/property/{id}",name="Admin.property.Edit", methods="GET | POST")
     * 
     */
    public function Edit(Property $property, Request $request):Response
    {
        $from = $this-> createForm(PropertyType::class, $property);
        $from ->handleRequest($request);

            if ($from -> isSubmitted() && $from ->isValid() ) {
                $this -> em ->flush();
                return $this -> redirectToRoute('Admin.property.index');
            }
        return $this -> render('Admin/property/Edit.html.twig',[
            'property'=>$property,
            'form'=>$from->createView()
        ]) ;  
    }

     /**
      * @param Property $property 
     * @Route("/Admin/property/{id}",name="Admin.property.Delete", methods="DELETE")
     * 
     * 
     */
    public function Delete(Property $property, Request $request)
    {
       // if ($this->isCsrfTokenValid('delete' . $property->getId(), $request->get('_token'))) {
            return new Response('suppression');
           
        return $this -> redirectToRoute('Admin.property.index');
    }
       
}