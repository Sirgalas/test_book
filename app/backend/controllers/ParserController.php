<?php

namespace backend\controllers;

use common\Helpers\EnumHelpers;
use common\Modules\Parser\Entities\Parser;
use backend\SearchForms\ParserSearch;
use common\Modules\Parser\Enums\EncodesEnum;
use common\Modules\Parser\Enums\TypeEnum;
use common\Modules\Parser\Forms\ParserForm;
use common\Modules\Parser\Services\ParserService;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * ParserController implements the CRUD actions for Parser model.
 */
class ParserController extends Controller
{

    private ParserService $parserService;

    public function __construct($id, $module, ParserService $parserService, $config = [])
    {
        parent::__construct($id, $module, $config);
        $this->parserService = $parserService;
    }

    /**
     * @inheritDoc
     */
    public function behaviors()
    {
        return array_merge(
            parent::behaviors(),
            [
                'verbs' => [
                    'class' => VerbFilter::class,
                    'actions' => [
                        'delete' => ['POST'],
                    ],
                ],
            ]
        );
    }

    public function actionIndex()
    {
        $searchModel = new ParserSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionView($id)
    {
        try {
            return $this->render('view', [
                'model' => $this->parserService->parserRepository->get($id),
            ]);
        }catch (NotFoundHttpException $e) {
            \Yii::$app->session->setFlash('error', $e->getMessage());
            return $this->redirect('index');
        }
    }

    public function actionCreate()
    {
        $model = new ParserForm();
            if ($this->request->isPost && $model->load($this->request->post()) && $model->validate()) {
                try {
                    $parser = $this->parserService->create($model);
                    return $this->redirect(['view', 'id' => $parser->id]);
                }catch (\RuntimeException $e) {
                    \Yii::$app->session->setFlash('error', $e->getMessage());
                }
            }
        return $this->render('create', [
            'model' => $model,
            'type' => EnumHelpers::enumsToArr(TypeEnum::cases()),
            'encode' => EnumHelpers::enumsToArr(EncodesEnum::cases()),
        ]);
    }

    public function actionUpdate($id)
    {
        try{
        $parser = $this->parserService->parserRepository->get($id);
        $model = new ParserForm($parser);
            if ($this->request->isPost && $model->load($this->request->post()) && $model->validate()) {
                $this->parserService->edit($parser,$model);
                return $this->redirect(['view', 'id' => $model->id]);
            }

            return $this->render('update', [
                'model' => $model,
                'type' => EnumHelpers::enumsToArr(TypeEnum::cases()),
                'encode' => EnumHelpers::enumsToArr(EncodesEnum::cases()),
            ]);
        } catch (NotFoundHttpException $e) {
            \Yii::$app->session->setFlash('error', $e->getMessage());
            return $this->redirect('index');
        }
        catch (\RuntimeException $e) {
            \Yii::$app->session->setFlash('error', $e->getMessage());
            return $this->render('update', [
                'model' => $model,
                'type' => EnumHelpers::enumsToArr(TypeEnum::cases()),
                'encode' => EnumHelpers::enumsToArr(EncodesEnum::cases()),
            ]);
        }
    }

    public function actionDelete($id)
    {
        try{
            $this->parserService->parserRepository->delete($id);
            \Yii::$app->session->setFlash('success', 'parser delete');
        } catch (NotFoundHttpException $e) {
            \Yii::$app->session->setFlash('error', $e->getMessage());
        }
        return $this->redirect(['index']);
    }
}
