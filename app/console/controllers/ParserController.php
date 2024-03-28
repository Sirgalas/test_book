<?php

declare(strict_types=1);

namespace console\controllers;

use common\Modules\Book\Forms\BookParserForm;
use common\Modules\Book\Services\BookService;
use common\Modules\Parser\Services\ParserService;
use yii\console\Controller;
use yii\httpclient\Client;

class ParserController extends Controller
{
    private ParserService $parserService;
    private BookService $bookService;

    public function __construct($id, $module, ParserService $parserService,BookService $bookService, $config = [])
    {
        parent::__construct($id, $module, $config);
        $this->parserService = $parserService;
        $this->bookService = $bookService;
    }

    public function actionParse(int $id)
    {
        $parser = $this->parserService->parserRepository->get($id);
        $dataRaw = ($parser->getParseType())->getDataFromUrl($parser->url);
        $data = ($parser->getDecode())->decode($dataRaw);
        foreach ($data as $item) {

            $form = new BookParserForm();
            $transaction = \Yii::$app->db->beginTransaction();

            try {
                if($form->load($item,'') && $form->validate()) {
                    $this->bookService->createParser($form);
                    $transaction->commit();
                 } else {
                    $transaction->rollBack();
                }
            } catch (\RuntimeException $e) {
                \Yii::error($e->getMessage());
                $transaction->rollBack();
            }
        }
    }
}