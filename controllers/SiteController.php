<?php

namespace app\controllers;

use yii\web\Controller;
use app\models\Category;

class SiteController extends Controller
{
    public function actionIndex()
    {
        return $this->render('index');
    }

    public function actionCatalog($categoryId = null)
    {
        $categories = Category::find()->orderBy('id')->all();
        $products = [];

        if ($categoryId !== null) {
            $category = Category::findOne($categoryId);
            if ($category) {
                $products = $category->getProducts()->all();
            }
        }

        return $this->render('catalog', [
            'categories' => $categories,
            'products' => $products,
            'selectedCategoryId' => $categoryId,
        ]);
    }
}
