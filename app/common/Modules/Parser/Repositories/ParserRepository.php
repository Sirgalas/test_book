<?php

declare(strict_types=1);

namespace common\Modules\Parser\Repositories;

use common\Helpers\ErrorHelper;
use common\Modules\Image\Entities\Image;
use common\Modules\Parser\Entities\Parser;
use yii\web\NotFoundHttpException;

class ParserRepository
{
    public function get(int $id): Parser
    {
        if(!$parser = Parser::findOne($id)) {
            throw new NotFoundHttpException(sprintf('Parser id %d not found', $id));
        }
        return $parser;
    }
    public function find(int $id): ?Parser
    {
        if(!$parser = Parser::findOne($id)) {
            return null;
        }
        return $parser;
    }

    public function save(Parser $parser): Parser
    {
        if(!$parser->save()) {
            throw new \RuntimeException(ErrorHelper::errorsToStr($parser->errors));
        }
        return $parser;
    }

    public function delete(int $id): void
    {
        $parser = $this->get($id);
        $parser->delete();
    }
}