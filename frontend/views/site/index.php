<?php
use yii\widgets\ActiveForm;
use yii\helpers\Html;
/** @var yii\web\View $this */

$this->title = 'Apples Problem';
?>
<div class="site-index">
    <div class="body-content">
        <div class="row">
			<?php foreach ($apples as $k=>$apple):?>
			
            <div class="col-md-2" style="margin:6px">
			<?php $form = ActiveForm::begin(); ?>
				<?= $form->field($apple, 'id')->hiddenInput()->label(false) ?>
                <h2>#<?=$apple->id?> Apple <?=$apple->color?></h2>
				<p>State: <?=$apple->state?></p>
				<p>Size: <?=$apple->size?>
				<p>Weight Left / Eat Available: <?=$apple->weight_left?>%
				<p>Created At: <?=date('d.m.Y H:i:s',$apple->created_at)?></p>
				<?php if ($apple->fall_at):?>
                <p>Fall At: <?=date('d.m.Y H:i:s',$apple->fall_at)?></p>
				<?php endif?>
				<select name="action">
					<option value="fall">Fall</option>
					<option value="eat">Eat</option>
					<option value="delete">Delete</option>
				</select>
				<input class="form-control" name="amount" type="text" value="<?=rand(10,95)?>"/>
				<div class="form-group">
					<?= Html::submitButton('Execute', ['class' => 'btn btn-success']) ?>
				</div>
			<?php ActiveForm::end(); ?>	
            </div>
			<?php endforeach?>
        </div>
    </div>
</div>
