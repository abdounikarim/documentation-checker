<?php

namespace App\Controller;

use App\Service\Documentation;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class FrontController extends AbstractController
{
    /**
     * @Route("/", name="app_homepage")
     */
    public function index(Documentation $documentation)
    {
        $content = $documentation->getRstFiles();
        dump($content);
        return $this->render('front/index.html.twig', [
            'content' => $content
        ]);
    }
}
