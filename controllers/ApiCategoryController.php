<?php

namespace app\controllers;

use app\models\Category;
use yii\rest\ActiveController;
use yii\web\Request;
use yii\web\NotFoundHttpException;
use yii\web\ServerErrorHttpException;
use yii\web\UnprocessableEntityHttpException;

class ApiCategoryController extends ActiveController
{
    public $modelClass = 'app\models\Category';

    /**
     * @return Category[]
     */
    public function actionGetCategories()
    {
        $categories = Category::find()->all();

        return $categories;
    }

    /**
     * @param Request $request
     * @throws UnprocessableEntityHttpException
     * @return Category
     */
    public function actionCreateCategory(Request $request)
    {
        $model = new Category();
        $model->load($request->getBodyParams(), '');

        if ($model->save()) {
            return $model;
        } else {
            throw new UnprocessableEntityHttpException('Failed to save category. Errors: ' . json_encode($model->errors));
        }
    }

    /**
     * @param int $id
     * @throws NotFoundHttpException
     * @throws UnprocessableEntityHttpException
     * @return Category
     */
    public function actionUpdateCategory($id, Request $request)
    {
        $model = $this->findModel($id);
        $model->load($request->getBodyParams(), '');

        if ($model->save()) {
            return $model;
        } else {
            throw new UnprocessableEntityHttpException('Failed to update category. Errors: ' . json_encode($model->errors));
        }
    }

    /**
     * @param int $id
     * @throws NotFoundHttpException
     * @return array
     */
    public function actionDeleteCategory($id)
    {
        $model = $this->findModel($id);
        $model->delete();

        return ['status' => 'success'];
    }

    /**
     * @param int $id
     * @throws NotFoundHttpException
     * @return Category
     */
    protected function findModel($id)
    {
        $model = Category::findOne($id);
        if (!$model) {
            throw new NotFoundHttpException("Category not found with id $id");
        }

        return $model;
    }
}