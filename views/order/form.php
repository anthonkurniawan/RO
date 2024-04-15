<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
app\assets\SelectizeAsset::register($this);

$this->title = $title;
$isNewRecord = $model->isNewRecord;
if(!$isNewRecord)
	$this->params['breadcrumbs'] = $this->context->breadcrumb;

$this->registerCss('.wrap > .container{padding-right:100px} .title.no{padding-top:7px;font-size:17px} .selectize-control.ui-search.loading::before{top:9px} .search-order{display:none} #file_update{margin-left:5px;vertical-align:middle;color:gray}'.($isNewRecord ? '' : '.printPdf{display:block}'));
// $this->registerJsFile('https://cdn.jsdelivr.net/npm/luxon@3.4.3/build/global/luxon.min.js');

$st = $model->status;
$isAssigned = $model->isAssigned;
$assign_disable = !($isAssigned && !$model->isComplete);
$owner_editable = $isOwner && $st < $model::STATUS_ONPROGRESS;
$disabled = !$owner_editable || $model->isComplete;
$isOpen = $model->isOpen;
$canAttach = $model->canAttach;
if($owner_editable || !$assign_disable)
	app\assets\LitePickerAsset::register($this);
$script = "
isNew = ".(int)$isNewRecord."; 
order_id = isNew ? '' : '$model->id';
app.registerPageOrder(order_id);
app.registerAjaxForm($('#order-form')); 
app.registerBtnBack($('.submit a'));
getLegend();
set_checkmark(document.getElementById('order-quality_ass').value, $disabled);
if(isNew){
	window.onscroll=null;
}
else {
	app.registerBtnScroll(); /*app.validate_attr();*/
}
var showSearch = document.getElementById('search-ico') ? true : false;
app.handleSearchScroll(showSearch);
";
?>

<?php
if($model->status == $model::STATUS_ONPROGRESS && ($model->isAssigned || Yii::$app->user->identity->isAdmin))
	echo Html::a(null, ['order/print', 'id'=>$model->id], ['id'=>'order_btn', 'class'=>'printPdf', 'data-pjax'=>"0", 'target'=>'_blank', 'title'=>'Print To PDF']);
?>

<main class="order">
  <div class="region_assigned clearfix">
    <span class="title pull-left">
			<?= $isNewRecord ? 'New '.$title : $title ?>
			<i class="edited glyphicon glyphicon-edit" title="Edited"></i>
		</span>
    <div class="link<?=$model->isNewRecord ? ' clickable" title="Change Region"':''?>">
      <p>To:&nbsp;<?= $model->region_name ?></p>
      <p><?php echo date('F - Y') . " - " . sprintf("%03d",$model->regionTotal) ?></p>
    </div>
  </div>

  <div class="form order">
    <?php
    $form = ActiveForm::begin([
      'id'=>'order-form',
			'options'=>['autocomplete'=>"off"],
			'successCssClass'=>'',
			'scrollToErrorOffset'=>160,
			'validateOnBlur' => false,
			'validateOnChange' => false,
      //'options'=>['autocomplete'=>"off", "enctype"=>"multipart/form-data"],
    ]);
    ?>

    <?=
    $form->field($model, 'region_id', [
      'options'=>['class'=>'form-group region_form animate__animated animate__fadeIn'],
      'template'=>"<div class='input-group'>{input}" . Html::a('Go', ['order/create'], ['id'=>'region-link', 'class'=>'input-group-addon']). "</div>\n{hint}\n{error}"
    ])->dropDownList(\app\models\Region::getList(),[
        'prompt'=>['text'=>'Regional Department Assignment', 'options'=>['value'=>'none', 'class'=>'prompt', 'readonly'=>'readonly', 'selected'=>'selected']],
        'disabled'=>$disabled,
				'title'=>'Area Region'
        //'style'=>'width:200px'
      ]
    ) ?>

    <div class="separator"> Request </div>

    <div class="form-group col-sm-2">
      <label>Request No.</label>
      <div class="title no"><?= $model->id?></div>
    </div>

		<?=$form->field($model, 'type', ['options'=>['class'=>'form-group col-sm-10']])->dropDownList(
      \app\models\OrderType::getList(),
      [
        'prompt'=>['text'=>'Select Type', 'options'=>['class'=>'prompt', 'readonly'=>'readonly', 'selected'=>'selected']],
        'disabled'=>$disabled,
				'autofocus'=>'autofocus',
				// 'tabindex'=>'1', 
        //'style'=>'width:200px'
      ]
    ) ?>

    <?=$form->field($model, 'title', ['options'=>['class'=>'form-group col-sm-12']])->textarea(['disabled'=>$disabled, 'rows'=>2, 'spellcheck'=>'false'])->label('Title Descriptions') ?>
    <?=$form->field($model, 'initiator_name', ['options'=>['class'=>'form-group col-sm-6']])->textInput(['maxlength'=>true, 'disabled'=>true])->label('Initiator') ?>
    <?=$form->field($model, 'initiator_dept', ['options'=>['class'=>'form-group col-sm-6']])->textInput(['maxlength'=>true, 'disabled'=>true]) ?>
    <?=$form->field($model, 'tag_num', ['options'=>['class'=>'form-group col-sm-6']])->textInput(['disabled'=>$disabled,'class'=>'form-control ui-search', 'title'=>'Tag Number'])?>
    <?=$form->field($model, 'item_desc', ['options'=>['class'=>'form-group col-sm-6']])->textInput(['readonly'=>$disabled, 'disabled'=>$disabled, 'maxlength'=>true]) ?>

    <?php
    echo $form->field($model, 'area_id', ['options'=>['class'=>'form-group col-sm-6 clear']])
    ->textInput(['disabled'=>$disabled,'class'=>'form-control ui-search', 'value'=>$model->area, 'title'=>'Area/Room']);
		
		if($isOwner){
			echo $form->field($model, 'area', [
				'options'=>['id'=>'addArea', 'class'=>'form-group col-sm-6'],
				'template'=>'<div>{label} {input} {error}</div>',
				'inputOptions'=>['class'=>'form-control', 'disabled'=>$disabled]
			])->label('Other Area / Room');
		}
		
		echo $form->field($model, 'create_at', ['options'=>['class'=>'form-group col-sm-3']])
      ->textInput(['value'=>date('l, d-M-Y, h:i'), 'class'=>'form-control text-center', 'disabled'=>true])->label('Request Date and Time');
		
		echo $form->field($model, 'target_dt', ['options'=>['class'=>'form-group col-sm-3']])
      ->textInput(['value'=>$model->target_dt ? date('l, d-M-Y', strtotime($model->target_dt)) : 'None', 'id'=>'target_dt', 'name'=>'target_dt',  'class'=>'form-control text-center', 'disabled'=>!$owner_editable]);
		?>

    <?= $form->field($model, 'detail_desc', ['options'=>['class'=>'form-group col-sm-12']])->textarea(['disabled'=>$disabled, 'rows'=>4, 'spellcheck'=>'false'])->label('Request Descriptions') ?>

    <?php
		if($owner_editable){
			echo $form->field($model, 'assign_to', ['options'=>['class'=>'form-group col-sm-6']])->dropDownList([],
				[
					'prompt'=>['text' =>null, 'options'=>['class'=>'prompt', 'value'=>$model->assign_to, 'selected'=>'selected']],
					'disabled'=>$disabled,
					'class'=>'form-control ui-search',
					'title'=>'Assigned Person'
				]
			);
			echo Html::activeHiddenInput($model, 'assignTo_name');
			echo Html::activeHiddenInput($model, 'assignTo_email');
			echo Html::activeHiddenInput($model, 'assignTo_fullname');
			echo Html::activeHiddenInput($model, 'target_dt');
		}else{
			echo $form->field($model, 'assignTo_fullname', ['options'=>['class'=>'form-group col-sm-6']])->textInput(['disabled'=>true])->label('Assigned To');
		}
    ?>

		<?=$form->field($model, 'assignTo_dept', ['options'=>['class'=>'form-group col-sm-6']])->textInput(['disabled'=>true])?>

		<?=$form->field($model, 'priority', ['options'=>['class'=>'form-group col-sm-12']])->dropDownList(
      $model->priorityList,
      [
        'prompt'=>['text'=>'Select Priority', 'options'=>['class'=>'prompt', 'readonly'=>'readonly', 'selected'=>'selected']],
        'disabled'=>$disabled,
        //'style'=>'width:200px'
      ]
    )?>

		<div class="separator">Quality Assestment</div>
		<div class="form-group q_ass clearfix">
			<div class="yes">
				<div><label for="q_ass_yes">Yes</label></div>
				<div style="border-left:1px solid #ccc">
					<input id="q_ass_yes" type="checkbox" checked>
				</div>
			</div>

			<?=$form->field($model, 'mmnr', [
				'options'=>['class'=>'form-group disabled', 'style'=>'width:370px'], 
				'template'=>"<div style='width:auto;padding:4px 7px'>{label}</div>\n{input}\n{hint}\n{error}",
				'errorOptions'=>['class'=>'help-block','style'=>'padding:0px 7px'],
				])->textInput(['disabled'=>true, 'class'=>'form-control', 'style'=>'float:left;height:30px;width:100px'])->label('MMNR No.')?>
			
			<div class="no" style="margin-left:100px">
				<div><label for="q_ass_no">No</label></div>
				<div style="border-left:1px solid #ccc">
					<input id="q_ass_no" type="checkbox">
				</div>
			</div>
		</div>
		<?=Html::activeHiddenInput($model, 'quality_ass', ['disabled'=>$disabled])?>

		<!-- HEADER OF ASSESTMENT --->
		<div class="separator" id="ehs_assest">EHS Assestment</div>
    <div class="form-group col-sm-5">
      <?=$form->field($model, 'ehs_assest')->dropDownList(\app\models\Ehs::getList(),['disabled'=>$disabled]) ?>
			<?=$form->field($model, 'ehs_hazard')->dropDownList(\app\models\Hazard::getList(),['disabled'=>!($isOwner && $model->ehs_assest!=1)]) ?>
    </div>
    <?= $form->field($model, 'ehs_hazard_risk', ['options'=>['class'=>'form-group col-sm-7']])->textarea(['disabled'=>!($isOwner && $model->ehs_assest!=1), 'spellcheck'=>'false']) ?>

		<?php
		if($isAssigned && $isOpen){
			echo Html::activeHiddenInput($model, 'status');
		}
		else {
			if($st && $st <= $model::STATUS_OPEN){
				echo "<div class='separator'>Status</div>";
				echo $form->field($model, 'status', ['options'=>['class'=>'form-group col-sm-3']])->dropDownList(
					[1=>'Rejected', 2=>'Open'],
					[
						'options'=>[1=>['disabled' => true]],
						'disabled'=>!($isOwner && $model->isRejected),
					]
				);
			}
			else if($st > $model::STATUS_OPEN){
				echo "<div class='separator' id='completion'>Completion</div>";
				echo $form->field($model, 'status', ['options'=>['class'=>'form-group col-sm-3']])->dropDownList(
					[3=>'In-Progress', 1=>'Reject', 4=>'Close'],
					[
						//'prompt'=>['text'=>'Status', 'options'=>['value'=>'none', 'class'=>'prompt', 'readonly'=>'readonly', 'selected'=>'selected']],
						'options'=>[ 3=> ['disabled' => true]],
						'disabled'=>!$isAssigned || $canAttach
					]
				);
				
				echo $form->field($model, 'complete_at', ['options'=>['class'=>'form-group col-sm-3']])->textInput(['name'=>'complete_at', 'id'=>'complete_at', 'class'=>'form-control text-center','disabled'=>true])->label('Completion Date');
				echo $form->field($model, 'complete_hours', ['options'=>['class'=>'form-group col-sm-3']])->textInput(['class'=>'form-control text-center', 'disabled'=>true]);
				echo $form->field($model, 'complete_at_sys', ['options'=>['class'=>'form-group col-sm-3']])->textInput(['class'=>'form-control text-center', 'disabled'=>true])->label('Completion System Date');
				echo $form->field($model, 'replacement', ['options'=>['class'=>'form-group col-sm-12']])->textarea(['disabled'=>true, 'rows'=>4, 'spellcheck'=>'false']);
				if($isAssigned){
					echo $form->field($model, 'attachment', [
						'options'=>['class'=>'form-group col-sm-12'],
						'template'=>'<div>{label} '
						. ($model->isComplete && $model->attachment ? (
						'<div style="padding-bottom:5px">'. 
						Html::a($model->attachment." <i class='glyphicon glyphicon-download'></i>", '@web/uploads/'.$model->attachment, ['class'=>'link','download'=>true, 'data-pjax'=>'0'])
						.'<div style="margin-top:5px"><span class="btn btn-sm btn-primary" onclick="$(\'#order-attachment\').trigger(\'click\')">Update Attachment</span> <span id="file_update"></span></div></div>'
						) : '')
						. '{input} {error}</div>',
						// 'inputOptions'=>['class'=>'form-control', 'disabled'=>$disabled]
					])->fileInput([
						'disabled'=>$model->status < $model::STATUS_COMPLETE,
						'class'=>'form-control',
						'hiddenOptions'=>['id'=>'file_a','value'=>$model->attachment]
					]);
				
					if($model->IsInprogress)
						echo Html::activeHiddenInput($model, 'complete_at');
				}
			}
		}
		
		if(!$isNewRecord){
			echo $comment_html = $model->renderComments('update');
			echo "<div id='new-cmt-con' class='form-group col-sm-12 field-order-comment animate__animated animate__fadeIn' style='display:none'></div>";
			$new_cmt_label = "Comment";
			if($comment_html){
				$new_cmt_label = "New Comment";
				$script .= "reg_comment_view();";
			}
			if(($isAssigned && ($isOpen || $st==$model::STATUS_ONPROGRESS)) || ($isOwner && $model->isRejected)){
				\yii\validators\ValidationAsset::register($this);
				$script .="createCommentForm('$new_cmt_label', true);";
			} 
		}
		
		echo '<div class="form-group col-sm-12 submit">';
		echo Html::a('Back', ($redirect ? $redirect : ['order/index']), ['class'=>'btn border','style'=>'margin-right:10px']);
		if($isAssigned && $isOpen){
				echo "<div class='pull-right'>";
				echo Html::submitButton('Reject', ['id'=>'reject-btn', 'class'=>'btn btn-danger', 'style'=>'margin-right:10px']);
				echo Html::submitButton('Accept', ['id'=>'accept-btn', 'class'=>'btn btn-primary']);
				echo "</div>";
		}
		elseif($isAssigned && $st==$model::STATUS_COMPLETE){
			echo Html::submitButton('Update', ['class'=>'btn btn-primary','disabled'=>1]);
		}
		elseif($isOwner && !$isNewRecord && $st < $model::STATUS_ONPROGRESS){
			echo Html::submitButton('Update', ['class'=>'btn btn-primary','disabled'=>1]);
		}
		elseif($st < $model::STATUS_COMPLETE){	
			echo Html::submitButton('Submit', ['id'=>'submit', 'class'=>'btn btn-primary','disabled'=>1]);
		}
		echo '</div>';
		
		ActiveForm::end();
    ?>
  </div>
</main>

<?php
$script2="";
if($model->canEdit || $canAttach)
	$script .="app.registerInputChange();";
if($model->canEdit){
	$script .="
var th;
$('#order-form textarea:not(:disabled),#order-mmnr').off('keyup').on('keyup', function(e){
	clearTimeout(th);
	th = setTimeout(function(){
		//console.log(e.originalEvent.key, e.which, e.ctrlKey, String.fromCharCode(e.which), \$(this));
		\$(e.target).trigger('change');
	},1000);
});
";	
}

if($canAttach){
	$script .="
var attach = $('#order-attachment').on('change',(e)=>{
	$('#file_update').text(e.target.files[0].name);
});
";
	if($model->attachment)
		$script .="attach.hide();";
}

if($owner_editable){
	$script .="reg_selectize();";
	$script2 .="var target_dt=makeDatePickerForm(document.getElementById('target_dt'), document.getElementById('order-target_dt'));
var d = new Date();
target_dt.options.minDate = d;
target_dt.options.maxDate=null;
";
}
if(!$disabled)
	$script .= "reg_form_ctrl();";

if($isAssigned && $isOpen){
	$script .= "reg_btn_approval();";
}

if($isAssigned && $st > $model::STATUS_OPEN && $st < $model::STATUS_COMPLETE){
	$script .="reg_st_chg(true);";
	$script2 .= "var complete_at=makeDatePickerForm(document.getElementById('complete_at'), document.getElementById('order-complete_at'));
	complete_at.options.minDate = new Date('".date('d-M-Y', strtotime($model->create_at))."');
	complete_at.options.maxDate = new Date();
	reg_btn_submit();
	var el = document.getElementById('completion');
	if(el){
		const promise2 = new Promise((resolve, reject) => {
			const loop = () =>{
				app.loaderActive == false ? resolve() : setTimeout(loop);
			} 
			loop();
		});
		promise2.then(() => {
			setTimeout(function(){
				window.scrollTo({top:el.offsetTop-60, behavior: 'smooth'});
				setTimeout(function(){\$('#order-status').focus()},700);
			}, 800);
		});
	}
";
}

$this->registerJs($script, \yii\web\View::POS_READY);
$this->registerJs($script2, \yii\web\View::POS_END);
?>