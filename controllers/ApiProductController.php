<?php

namespace app\controllers;

use app\models\Product;
use yii\rest\ActiveController;
use yii\web\Request;
use yii\web\NotFoundHttpException;
use yii\web\ServerErrorHttpException;
use yii\web\UnprocessableEntityHttpException;

class ApiProductController extends ActiveController
{
    public $modelClass = 'app\models\Product';

    /**
     * @return Product[]
     */
    public function actionGetProducts()
    {
        $products = Product::find()->all();

        return $products;
    }

    /**
     * @param Request $request
     * @throws UnprocessableEntityHttpException
     * @return Product
     */
    public function actionCreateProduct(Request $request)
    {
        $model = new Product();
        $model->load($request->getBodyParams(), '');

        if ($model->save()) {
            return $model;
        } else {
            throw new UnprocessableEntityHttpException('Failed to save product. Errors: ' . json_encode($model->errors));
        }
    }

    /**
     * @param int $id
     * @throws NotFoundHttpException
     * @throws UnprocessableEntityHttpException
     * @return Product
     */
    public function actionUpdateProduct($id, Request $request)
    {
        $model = $this->findModel($id);
        $model->load($request->getBodyParams(), '');

        if ($model->save()) {
            return $model;
        } else {
            throw new UnprocessableEntityHttpException('Failed to update product. Errors: ' . json_encode($model->errors));
        }
    }

    /**
     * @param int $id
     * @throws NotFoundHttpException
     * @return array
     */
    public function actionDeleteProduct($id)
    {
        $model = $this->findModel($id);
        $model->delete();

        return ['status' => 'success'];
    }

    /**
     * @param int $id
     * @throws NotFoundHttpException
     * @return Product
     */
    protected function findModel($id)
    {
        $model = Product::findOne($id);
        if (!$model) {
            throw new NotFoundHttpException("Product not found with id $id");
        }

        return $model;
    }
}