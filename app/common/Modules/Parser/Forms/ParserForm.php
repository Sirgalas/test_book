<?php

declare(strict_types=1);

namespace common\Modules\Parser\Forms;

use common\Modules\Parser\Entities\Parser;
use yii\base\Model;

class ParserForm extends Model
{
    public ?int $id = null;
    public ?string $name = null;
    public ?string $url = null;
    public ?string $type = null;
    public ?string $encode = null;
    public function __construct(Parser $parser = null,$config = [])
    {
        parent::__construct($config);
        if($parser) {
            $this->id = $parser->id;
            $this->name = $parser->name;
            $this->url = $parser->url;
            $this->type = $parser->type;
            $this->encode = $parser->encode;
        }
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            ['id','integer'],
            [['type','encode'], 'string', 'max' => 25],
            [['name'], 'string', 'max' => 255],
            [['url'], 'string', 'max' => 610],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'url' => 'Url',
        ];
    }
}