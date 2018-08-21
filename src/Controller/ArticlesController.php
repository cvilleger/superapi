<?php

namespace App\Controller;

use App\Entity\Article;
use App\Entity\User;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\FOSRestController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\HttpFoundation\Request;

class ArticlesController extends FOSRestController
{
    private $userRepository;
    private $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    public function getArticleAction(User $user)
    {
        return $this->view($user);
    }

    /**
     * @Rest\Post("/articles")
     * @ParamConverter("article", converter="fos_rest.request_body")
     */
    public function postArticlesAction(Article $article)
    {
        $this->em->persist($article);
        $this->em->flush();
        return $this->view($article);
    }

}
