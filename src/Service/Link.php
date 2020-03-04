<?php
/**
 * Created by PhpStorm.
 * User: sacha
 * Date: 04/03/2020
 * Time: 00:27
 */

namespace App\Service;

use Symfony\Component\HttpClient\HttpClient;
use Symfony\Component\HttpClient\ScopingHttpClient;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;


class Link
{

    private $documentation;

    public function __construct(Documentation $documentation)
    {
        $this->documentation = $documentation;
    }

    /*
    * Search Intern Links
    */
    public function searchLinkInContent($content)
    {
        /* Search HTTP & HTTPS  link with regex */
        $fileContent = base64_decode($content['content']);
        dump($fileContent);
        preg_match_all("#(https?://)([\w\d.&:\#@%/;$~_?\+-=]*)#",$fileContent, $out);
        dd($out[0]);
    }

    /*
     * Test Intern Links
     */
    public function checkExternalLinks($links)
    {
        $links = $this->searchLinkInContent();
        foreach($links as $link){

            $response = $this->request('GET', $link);
            $linkStatus = $response->setStatusCode(Response::HTTP_OK);

            $finalResult = array(
                $link => $linkStatus,
            );
            return $finalResult;
        }
    }
}