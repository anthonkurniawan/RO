<?php
use yii\helpers\Html;
use yii\helpers\Url;
?>
<!DOCTYPE html>
<html lang="en-US">
<head>
<meta charset="UTF-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link href="<?=Url::to('@web/css/print.css', true)?>" rel="stylesheet">
</head>

<body>
<div class="order">
	<table>
	<tr>
		<td width="40%"><?= Html::img(Url::to('@web/images/logo.jpg', true)) ?></td>
		<td style="font-size:30px; font-weight:700;">Request Order</td>
		<td style="text-align:right; font-weight:bold">
			<?php 
			echo $model->region_name ? "To:&nbsp;".$model->region_name."<br>" : "";
			echo date('F - Y') . " - " . sprintf("%03d",$model->regionTotal); 
			?>
		</td>
	</tr>
	</table>
	<!--------------------------------------------------------->
	<?=$this->render('_view', ['model'=>$model, 'print'=>1])?>
	<!--------------------------------------------------------->
  <p id="pb" style="display:none">&nbsp;</p>
	
	<?php //echo $model->renderComments('view',1); ?>
	
	<div id="sign" style="width:100%;float:left">
		<div class="separator">Approval</div>
		<div class="sign col-sm-12">
			<div class="col col-sm-4">&nbsp;</div>
			<div class="col col-sm-4">&nbsp;</div>
			<div class="col col-sm-4">&nbsp;</div>
			<!--<div class="col col-sm-3">&nbsp;</div>-->
			<div class="col-sm-4">Assign Person</div>
			<div class="col-sm-4">Initiator Area/Owner</div>
			<!--<div class="name col-sm-3">SPV</div>-->
			<div class="col-sm-4">Engineering Spv</div>
		</div>
	</div>
</div>
<script>
var max_h = 950; //960;
var arr=['desc', 'con_hz_txt', 'repl'];
var h = document.body.scrollHeight;
var desc_h = document.getElementById('desc').offsetHeight;
var hz_h = document.getElementById('con_hz_txt').offsetHeight;
var rep = document.getElementById('repl');
var rep_h = rep.offsetHeight;
var h2 = h - (desc_h + hz_h + rep_h);
var elem = {};

function resizePage(){
	for(var i=0; i < 3; i++){
		var el = document.getElementById(arr[i]);
		if(arr[i] != 'con_hz_txt' || el.offsetHeight < 80){
			el.style.minHeight = '';
			el.style.height = el.offsetHeight +'px';
		}
		h2 += el.offsetHeight;
		elem[arr[i]] = el.offsetHeight;
		el.innerText += ' EL:'+arr[i]+'  RESIZE=> ' + el.offsetHeight + ' H2: ' + h2 + ' ELEM:'+JSON.stringify(elem);
		if(document.body.scrollHeight <= max_h){
			break;
		}
		// document.getElementById('repl').innerText +=' > '+ document.body.scrollHeight;
	}
}

document.addEventListener('DOMContentLoaded', function(){
	var hz_len = document.getElementById('hz_txt').innerText.length;
	var con_hz_len = document.getElementById('con_hz_txt').innerText.length;
	if(hz_len > 31){
		var hz = document.getElementById('hz');
		var hz_con = document.getElementById('con_hz');
		hz.classList.remove('col-sm-2');
		hz.classList.add('col-sm-4');
		hz_con.classList.remove('col-sm-10');
		hz_con.classList.add('col-sm-8');
	}
	
	// var h = document.body.scrollHeight;//-40;  // max:962 max-full:967, max:1684(full), 1644(spare sign name)
	// var con = document.getElementById('con');  // sign:81
	// var page = rep.offsetHeight+81+12; //214;
	
	// rep.innerText +=' H-scroll: '+ document.body.scrollHeight +' H-offset: ' + document.body.offsetHeight 
	// +'\ndesc_h: '+desc_h +' hz_h: '+hz_h +' rep_h: '+rep_h + ' ('+ h2 +')';
	// + ' sisa: ' + (h-(page+40+53)) + 'px  ' + (page+40+53)
	// + ' sign: '+document.getElementById('sign').offsetHeight + ' sisa: ' + (rep_h + (940-h));
	
	// rep.innerText +=' ' + document.body.scrollHeight;
	
	// if(page < h)
		// rep.style.height = rep.offsetHeight + (h-(page+40+12)) + 'px';
		// con.style.marginBottom = (h-(page+40+12)) + 'px'  // 133
	
	if(h > max_h){ // max: 1596,   old:1644
		if(h > max_h + 100){
			document.getElementById('pb').style.display='block';
		} else {
			resizePage();
			if(h2 > max_h){
				document.getElementById('pb').style.display='block';
				for(var e in elem){
					// console.log('=>elem:', e, elem[e], document.getElementById(e));
					if(elem[e] < 80){
						document.getElementById(e).style.minHeight = '80px';
						h2 += 80;
					}
				}
				h2 = h2 - 81;
				rep.style.height = (rep.offsetHeight + (1020 - h2)) + 'px';
				// rep.innerText += ',  RESIZE=> ' + rep.offsetHeight + ' H2: ' + h2 +', SISA: '+ (980 - h2);
			}
		}
		// rep.innerText += ',  RESIZE=> ' + rep.offsetHeight + ' H2: ' + h2 +', SISA: '+ (980 - h2) + ' H: '+h;
	}
	else if(h < max_h){
		var est_h = max_h - h;
		rep.style.height = rep_h + (940-h) + 'px';
	}
	// document.getElementById('sign').firstElementChild.innerText += ' '+document.body.scrollHeight;
	// document.getElementsByClassName('order')[0].style.border = '1px solid red';
});
</script>
</body>
</html>
