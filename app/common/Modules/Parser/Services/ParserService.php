<?php

declare(strict_types=1);

namespace common\Modules\Parser\Services;

use common\Modules\Image\Entities\Image;
use common\Modules\Image\Forms\ImageForm;
use common\Modules\Parser\Entities\Parser;
use common\Modules\Parser\Forms\ParserForm;
use common\Modules\Parser\Repositories\ParserRepository;

class ParserService
{
    public function __construct(public readonly ParserRepository $parserRepository)
    {}

    public function create(ParserForm $form): Parser
    {
        $parser = Parser::create($form);
        return $this->parserRepository->save($parser);
    }

    public function edit(Parser $parser, ParserForm $form): Parser
    {
        $parser->edit($form);
        return $this->parserRepository->save($parser);
    }
}