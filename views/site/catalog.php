<?php

use yii\helpers\Html;

$this->title = 'Catalog';

$this->registerJsFile('https://code.jquery.com/jquery-3.6.4.min.js');
$this->registerJsFile('https://cdnjs.cloudflare.com/ajax/libs/jstree/3.3.11/jstree.min.js', ['depends' => [\yii\web\JqueryAsset::class]]);
$this->registerCssFile('https://cdnjs.cloudflare.com/ajax/libs/jstree/3.3.11/themes/default/style.min.css');

?>

<div class="row">
    <div class="col-md-3">
        <h3>Категории</h3>
        <div id="categoryTree"></div>
    </div>
    <div class="col-md-9">
        <h2>Товары</h2>
        <div class="row" id="productList">
            <?php foreach ($products as $product): ?>
                <div class="col-md-4">
                    <div class="thumbnail">
                        <div class="caption">
                            <h4><?= Html::encode($product->name) ?></h4>
                            <p><?= Html::encode($product->description) ?></p>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</div>

<?php
$jsTreeData = json_encode(buildJsTreeData($categories, $selectedCategoryId));
$this->registerJs("
    $('#categoryTree').jstree({
        'core' : {
            'data' : $jsTreeData
        }
    }).on('changed.jstree', function (e, data) {
        var selectedCategoryId = data.selected[0];
        if (selectedCategoryId !== undefined) {
            window.location.hash = selectedCategoryId;
            loadProducts(selectedCategoryId);
        }
    });

    function loadProducts(categoryId) {
        $.ajax({
            url: '/site/catalog?categoryId=' + categoryId,
            success: function (result) {
                $('#productList').html($(result).find('#productList').html());
            }
        });
    }

    $(document).ready(function() {
        var initialHash = window.location.hash.substring(1);
        if (initialHash !== '') {
            loadProducts(initialHash);
        }
    });
");

function buildJsTreeData($categories, $selectedCategoryId) {
    $result = [];
    foreach ($categories as $category) {
        $node = [
            'id' => $category->id,
            'parent' => ($category->parent_id) ? $category->parent_id : '#',
            'text' => $category->name,
            'state' => [
                'opened' => true,
                'selected' => ($selectedCategoryId == $category->id),
            ],
        ];
        $result[] = $node;
    }
    return $result;
}
?>
