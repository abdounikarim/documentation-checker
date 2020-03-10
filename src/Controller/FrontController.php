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
        array_push($dataLink,'https://URLdeTEST404.com');
        //dd($dataLink);
        $links = $links->checkExternalLinks($dataLink);
        $count = count($links['link']);

        return $this->render('front/links.html.twig', [
            'links' => $links,
            'count' => $count,
        ]);

        /*
        return $this->render('front/links.html.twig', [
            'links' => $dataLink,
            'statusCode' => $statusCodeLink
        ]);
        */
    }


}
