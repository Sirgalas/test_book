<?php

declare(strict_types=1);

namespace common\Modules\Parser\Services\Types;

use common\Helpers\ErrorHelper;
use common\Modules\Parser\Forms\TreeForm;
use yii\httpclient\Client;

class UrlGitLab implements UrlParserInterface
{
    private $client;
    public function __construct()
    {
        $this->client = new Client();
    }
    public const PROTOCOL = 'https://';
    public const API_URL = '/api/v4/projects/';
    public function getUrl(string $url): string
    {
        [$urlRepository,$meta] = $this->returnArrayUrl($url);
        [$service,$projectId] = $this->explodeUrlAndId($urlRepository);
        [$metaBlob,$fileName] = $this->getMetaBlobAndFilename($meta);
        $file = array_filter($this->getTree($service,$projectId)->getData(),function ($element) use ($fileName) {
            return $element['name'] === $fileName;
        });
        $formTree = new TreeForm();
        if(empty($file)) {
            throw new \RuntimeException('File not found in repository');
        }
        if($formTree->load(array_shift($file),'') && $formTree->validate()) {
            dd(sprintf('%s/blobs/%s/raw',$this->getApiUrl($service,$projectId),$formTree->id));
            return sprintf('%s/blobs/%s/raw',$this->getApiUrl($service,$projectId),$formTree->id);
        }
        throw new \RuntimeException(ErrorHelper::errorsToStr($formTree->errors));
    }

    private function returnArrayUrl(string $url): array
    {
        return explode('/-/',str_replace(self::PROTOCOL,'', $url));
    }

    private function explodeUrlAndId(string $url): array
    {
        $raw = explode('/',$url);
        $firstElement = array_shift($raw);
        return [$firstElement,implode("%2F",$raw)];
    }

    private function getMetaBlobAndFilename(string $meta): array
    {
        $raw = explode('/', $meta);
        return [array_shift($raw),array_pop($raw)];
    }

    private function getApiUrl(string $service,string $projectId): string
    {
        return sprintf('%s%s%s%s/repository',self::PROTOCOL,$service,self::API_URL,$projectId);
    }

    private function getTree(string $service,string $projectId)
    {
        return $this->client->createRequest()->setMethod('GET')
            ->setUrl(sprintf('%s/tree',$this->getApiUrl($service,$projectId)))
            ->send();
    }


}