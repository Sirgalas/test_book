<?php

declare(strict_types=1);

namespace common\Modules\Image\Forms;

use common\Modules\Image\Entities\Image;
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
    public ?int $id = null;
    public ?string $extension = null;
    public ?string $name = null;
    public ?string $url = null;


    public function __construct(Image $image = null, $config = [])
    {
        parent::__construct($config);
        if($image) {
            $this->id = $image->id;
            $this->extension = $image->extension;
            $this->name = $image->name;
            $this->url = $image->url;
        }
    }

    public function rules()
    {
        return [
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
        ];
    }
}