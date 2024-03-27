<?php

declare(strict_types=1);

namespace common\Modules\Image\Forms;

use PhpParser\Node\Expr\BinaryOp\Mod;
use yii\base\Model;
/**
* @property int $id
* @property string|null $extension
* @property string|null $name
* @property string|null $url
* @property string|null $created_at
* @property string|null $updated_at
 * */
class ImageForm extends Model
{
    public $id;
    public string $extension;
    public string $name;
    public string $url;
    public string $created_at;
    public string $updated_at;
    public function rules()
    {
        return [
            [['created_at', 'updated_at'], 'safe'],
            [['extension', 'name', 'url'], 'string', 'max' => 610],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'extension' => 'Extension',
            'name' => 'Name',
            'url' => 'Url',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }
}