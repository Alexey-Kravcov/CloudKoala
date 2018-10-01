<div class="cell-edit-content">
    <div class="cell-left-part cell-part">
        <?= $this->render(
            'cell-navigation.php',
            ['cellTypeModels' => $cellTypeModels]
        ) ?>
    </div>
    <div class="cell-right-part cell-part">
        <?= $this->render('index-'.$template,
            ['dataProvider'=>$dataProvider,
                'searchModel'=>$searchModel]
        ) ?>
    </div>
</div>
<?php
Url::remember();
?>