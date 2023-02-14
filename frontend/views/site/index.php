<?php
use yii\widgets\ActiveForm;
use yii\helpers\Html;
/** @var yii\web\View $this */

$this->title = 'Apples Problem';
?>
<div class="site-index">
    <div class="body-content">
		<div class="row">
			<div class="col-md-12" style="margin:6px">
				<?php $form = ActiveForm::begin(['action' => ['site/generate']]); ?>
				<div class="form-group">
						<?= Html::submitButton('Generate', ['class' => 'btn btn-warning']) ?>
				</div>
				<?php ActiveForm::end(); ?>	
			</div>
		</div>
        <div class="row">
			<?php foreach ($apples as $k=>$apple):?>
			
            <div class="col-md-3" style="margin:6px">
			<?php $form = ActiveForm::begin(); ?>
				<?= $form->field($apple, 'id')->hiddenInput()->label(false) ?>
                <h2>#<?=$apple->id?> Apple <?=$apple->color?></h2>
				<p>State: <?=$apple->state?></p>
				<p>Size: <?=$apple->size?>
				<p>Weight Left / Eat Available: <?=$apple->weight_left?>%
				<p>Created At: <?=date('d.m.Y H:i:s',$apple->created_at)?></p>
                <p>Fall At: <?php if ($apple->fall_at):?><?=date('d.m.Y H:i:s',$apple->fall_at)?><?php endif?></p>
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
