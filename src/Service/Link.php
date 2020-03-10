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

    private function checkUrlCurl($link)
    {
        // initialisation de la session
        $ch = curl_init();

        // configuration des options
        curl_setopt($ch, CURLOPT_URL, $link);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);

        // exécution de la session
        curl_exec($ch);

        $output = curl_exec($ch);
        //dd(curl_error($ch));
        $code = curl_getinfo($ch,CURLINFO_HTTP_CODE);

        //dd($code);
        // fermeture des ressources
        curl_close($ch);
        return $code;

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

            //$response = $this->checkConnection()->request('GET', $link);

            $linkStatus = $this->checkUrlCurl($link);


            array_push($finalResult['link'],$link);
            array_push($finalResult['code'],$linkStatus);

            //dump($finalResult['code']);
            // array_push($finalResult['link'], $link, $linkStatus);
        }
        //dd($finalResult);
        return $finalResult;
    }
}