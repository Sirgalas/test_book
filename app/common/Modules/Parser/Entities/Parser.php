<?php

namespace common\Modules\Parser\Entities;

use common\Modules\Parser\Forms\ParserForm;
use common\Modules\Parser\Services\Types\UrlDefault;
use common\Modules\Parser\Services\Types\UrlGitLab;
use common\Modules\Parser\Services\Types\UrlParserInterface;
use Yii;

/**
 * This is the model class for table "parser".
 *
 * @property int $id
 * @property string|null $name
 * @property string|null $url
 * @property string $type
 * @property string $encode
 */
class Parser extends \yii\db\ActiveRecord
{
    public static function create(ParserForm $form): self
    {
        $parser = new static();
        $parser->name = $form->name;
        $parser->url = $form->url;

        return $parser;
    }

    public function edit(ParserForm $form): void
    {
        $this->name = $form->name;
        $this->url = $form->url;
    }

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'parser';
    }

    public function getParseType(): UrlParserInterface
    {
        if(strpos($this->url,'gitlab')) {
            return new UrlGitLab();
        }
        return new UrlDefault();
    }

}
