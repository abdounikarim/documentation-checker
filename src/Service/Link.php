<?php
/**
 * Created by PhpStorm.
 * User: sacha
 * Date: 04/03/2020
 * Time: 00:27
 */

namespace App\Service;

use Symfony\Component\HttpClient\HttpClient;


class Link
{

    private $documentation;

    public function __construct(Documentation $documentation)
    {
        $this->documentation = $documentation;
    }

    public function searchLinkInContent($content)
    {
        preg_match('#https://[a-z0-9._/-]', $content, $result, PREG_OFFSET_CAPTURE);

        /* Search HTTP link with regex */
        dd($result);
        return $result;
    }

    public function TestResponseInLinks($links)
    {
        foreach($links as $link){
            $client = HttpClient::create();
            $response = $client->request('GET', $link);
            $linkStatus = $response->getStatusCode();
        }
    }
}