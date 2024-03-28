<?php

declare(strict_types=1);

namespace console\controllers;

use common\Modules\Parser\Services\ParserService;
use yii\console\Controller;

class ParserController extends Controller
{
    private ParserService $parserService;

    public function __construct($id, $module, ParserService $parserService, $config = [])
    {
        parent::__construct($id, $module, $config);
        $this->parserService = $parserService;
    }

    public function actionParse(int $id)
    {
        $parser = $this->parserService->parserRepository->get($id);
        dd(($parser->getParseType())->getUrl($parser->url));
    }
}