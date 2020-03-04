<?php

namespace App\Controller;

use App\Service\Documentation;
use App\Service\Link;
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

    /**
     * @Route("/links", name="links")
     */
    public function LinksList(Link $links, Documentation $documentation)
    {
        $content = $documentation->getRstFiles();
        //dd($content);
        $dataLink = $links->searchLinkInContent($content);
        dd($dataLink);

        return $this->render('front/links.html.twig', [
            'links' => $dataLink,
        ]);
    }


}
