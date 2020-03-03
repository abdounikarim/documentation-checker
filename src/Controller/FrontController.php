<?php

namespace App\Controller;

use App\Service\Documentation;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class FrontController extends AbstractController
{
    /**
     * @Route("/", name="front")
     */
    public function index(Documentation $documentation)
    {
        $content = $documentation->getRstFiles();
        dd($content);
        return $this->render('front/index.html.twig', [
            'content' => $content
        ]);
    }
}
