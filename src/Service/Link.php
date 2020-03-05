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
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;


class Link
{

    private $connection;

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
        $fileContent = base64_decode($content['content']);
        preg_match_all("#(https?://)([\w\d.&:\#@%/;$~_?\+-=]*)#",$fileContent, $out);
        return $out[0];
    }

    protected function checkConnection()
    {
        if($this->connection) {
            return $this->connection;
        }
        return $this->connect();
    }

    private function connect()
    {
        $this->connection = HttpClient::create();
        return $this->connection;
    }

    /*
     * Test Intern Links
     */
    public function checkExternalLinks($links)
    {
        dump($links);
        $finalResult = array("link"  => array (),"code"  =>array() );
        $i = 0;
        foreach($links as $link){
            $i = $i + 1;
            $this->connection = HttpClient::create();
            $response = $this->checkConnection()->request('GET', $link);
            //throw new NotFoundHttpException();
            $linkStatus = $response->getStatusCode();


            array_push($finalResult['link'],$link);
            array_push($finalResult['code'],$linkStatus);


            // array_push($finalResult['link'], $link, $linkStatus);
        }
        //dd($finalResult);
        return $finalResult;
    }
}