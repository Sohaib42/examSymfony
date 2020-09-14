<?php

namespace App\Controller;

use App\Entity\Article;
use App\Form\ArticleFormType;
use App\Repository\ArticleRepository;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\Request;

class ArticleController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function index(ArticleRepository $repo)
    {
        $articles = $repo->findAll();
        return $this->render('article/show.html.twig', [
            'controller_name' => 'ArticleController',
            'articles' => $articles
         ]);
}
        /**
         * @Route("/article/{id}", name="article_detail")
         */
    public function show(Article $article){
        return $this->render('article/detail.html.twig',[
            'article' => $article
        ]);
        
    }
   /**
     * @Route("/add", name="add_article")
     */
    public function addArticle(Request $request){
        $article = new Article();
        $form = $this->createForm(ArticleFormType::class, $article);
        $form->handleRequest($request);

        if($form->isSubmitted() and $form->isValid()){
            $photoArticle = $form->get('photo')->getData();
            if($photoArticle){
                $newFilename = uniqid().'.'.$photoArticle->guessExtension();
                try {
                    $photoArticle->move(
                        $this->getParameter('photo_directory'),
                        $newFilename
                    );
                    $article->setPhoto('assets/image/'.$newFilename);
                } catch (FileException $e) {
                    // ... handle exception if something happens during file upload
                }
            }
            $article = $form->getData();
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($article);
            $entityManager->flush();
            return $this->redirectToRoute('home');
        } else {
            return $this->render('article/add.html.twig',
                [
                    'form'=> $form->createView(),
                    'errors'=> $form->getErrors()
                ]);
               }
    }
    /**
     * @Route("/delete/{article}",name="delete_article")
     */
    public function delete(Article $article){
        $em = $this->getDoctrine()->getManager();
        $em->remove($article);
        $em->flush();
        return $this->redirectToRoute('home');
    }
}
?>