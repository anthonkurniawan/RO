<?php
namespace app\controllers;

use Yii;
use yii\web\Controller;

use Exception;

class MainController extends Controller 
{
  protected $urlmap_exclude = ['login', 'suggest', 'user-suggest', 'tag-suggest', 'area-suggest'];
  const REGEX_SQLI = '/[\x00\x0A\x0D\x1A\x22\x25\x27\x5C\x5F\x3b]|\x2D{2,}|(\x2F\x2A)|(\x2A\x2F)/';  // '/[\'\"\;\%]|\-{2,}|\/\*/'

  /**
   * Displays a single User model.
   * @param integer $id
   * @return mixed
   * @throws NotFoundHttpException if the model cannot be found
   */
  public function actionView($id)
  {
    $model = $this->findModel($id);
    $isAjax = Yii::$app->request->isAjax;

    $params = ['model'=>$model, 'isAjax'=>$isAjax, 'redirect'=>$this->httpRedirect];
    if($isAjax){
      return $this->renderAjax('view', $params);
    }
    return $this->render('view', $params);
  }

	/**
	* Store log activity into database
	**/
  public function log($event, $setFlash=null){
    $uid = Yii::$app->user->id;;
		$model = new \app\models\Log();
		$model->setAttributes(['date'=>date('Y-m-d H:i:s'), 'userid'=>$uid, 'event'=>$event]);
		$model->insert(false);
    if($setFlash) Yii::$app->session->setFlash('success', $event);
	}

	/**
	* return array the attributes changed
	**/
	public function getChangesAttr($model){
		$changesAtt = $model->getDirtyAttributes();
		$changeLog = [];
		$count = count($changesAtt);
		if($count){
			foreach($changesAtt as $k=>$v){
				$old = $model->getOldAttribute($k);
				if($old != $v){
					$changeLog[$k]="'$old' to '$v'";
				}
			}
			return $changeLog;
		}
		return $changeLog;
	}

	/**
	* Validation submit form
	**/
	protected function performAjaxValidation($model){
    if(Yii::$app->request->isAjax) {
      $data = array_merge($model->errors, \yii\widgets\ActiveForm::validate($model));
      //$data = \yii\widgets\ActiveForm::validate($model);
			$res = Yii::$app->response;
      $res->format = \yii\web\Response::FORMAT_JSON;
			$res->data  = count($data) ? $data : array('success'=>1);
			$res->send();
			Yii::$app->end();
    }
	}

	/**
	* Fecth suggestion for data area
	**/
  public function actionAreaSuggest()
  {
    $rs = Yii::$app->cache->getOrSet('area', function () {
      return \Yii::$app->db->createCommand("SELECT id, label_a as area FROM area")->queryAll();
    });
    $arr = ['id' => 'other', 'area' => 'Other'];
    $rs = array_merge($rs, [$arr]);
    //$rs = \yii\helpers\ArrayHelper::map($rs, 'id', 'label_a');

    $response = \Yii::$app->response;
    $response->format = \yii\web\Response::FORMAT_JSON;
    $response->data = $rs;
  }
  
	/**
	* Export and download report to excel
	**/
  public function _printXls($filename, $title="Record List") {
		try{
			require_once dirname(__FILE__) . '/../vendor/phpoffice/phpexcel/Classes/PHPExcel/IOFactory.php';
			require_once dirname(__FILE__) . '/../vendor/phpoffice/phpexcel/Classes/PHPExcel.php';
			
			$objReader = \PHPExcel_IOFactory::createReader('html');
			$excel = $objReader->load($filename);

			$sheet = $excel->getActiveSheet();
			//$protect = $sheet->getProtection();
			//$protect->setPassword('');
			//$protect->setSheet(true);
			$maxRow = $sheet->getHighestRow(); // find max row
			$maxCol = $sheet->getHighestColumn(); // find max col
			$maxColAsNum = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::columnIndexFromString($maxCol);
			$offsetMaxCol = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($maxColAsNum + 1);
			$theadArea = 'A3:' . $maxCol . '3';
			$bodyArea = 'A4:' . $maxCol . $maxRow;
			
			# STYLE AREA
			$bodyAreaStyle = [
				'borders' => array('allborders' => array('style' => \PHPExcel_Style_Border::BORDER_THIN)),
				'alignment' => array(
					'vertical' => \PHPExcel_Style_Alignment::VERTICAL_TOP,
				),
			];
			# FORMAT HEADER
			$headerstyl = array(
				'font' => ['size'=>10, 'bold'=>true, 'color' => array('argb' => 'FFFFFFFF'),],
				'alignment' => array(
					'vertical' => \PHPExcel_Style_Alignment::VERTICAL_CENTER,
					'horizontal' => \PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
					'wrapText' => true,
				),
				'fill' => array(
					'type' => \PHPExcel_Style_Fill::FILL_SOLID,
					'startcolor' => array('argb' => 'FF0000FF'), // COLOR_BLUE
				),
				'borders' => array('allborders' => array('style' => \PHPExcel_Style_Border::BORDER_THIN)),
			);
			
			$sheet->getStyle($theadArea)->applyFromArray($headerstyl);
			$sheet->getStyle($bodyArea)->applyFromArray($bodyAreaStyle);
			$sheet->getRowDimension(3)->setRowHeight(20);
			for ($col = 'B'; $col != $offsetMaxCol; ++$col) {
				$sheet->getColumnDimension($col)->setAutoSize(true);
			}
			$sheet->mergeCells('A1:'.$maxCol.'1');
			$sheet->mergeCells('A2:'.$maxCol.'2');
			$sheet->getStyle('A1:'.$maxCol.$maxRow)->applyFromArray(['font'=>['name'=>'Arial', 'size'=>11]]);
			$sheet->getStyle('A2')->applyFromArray(['font' => ['size'=>10, 'bold'=>false]]);
			// Set aligment for some page
			$sheet->getStyle("A4:A".$maxRow)->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER)->setVertical(\PHPExcel_Style_Alignment::VERTICAL_CENTER);

			if((isset($_GET['r']) && $_GET['r']=='order') || Yii::$app->request->pathInfo=='order'){
				$sheet->getStyle("B4:B".$maxRow)->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER); // title
				$sheet->getStyle("N4:P".$maxRow)->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER); // quality ass, mmnr, ehs ass
				$sheet->getStyle("T4:Z".$maxRow)->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER); // all date, status
				$sheet->getStyle("C4:D$maxRow")->getAlignment()->setWrapText(true);
				$sheet->getStyle("R4:S$maxRow")->getAlignment()->setWrapText(true);
				$sheet->getStyle("AA4:AA$maxRow")->getAlignment()->setWrapText(true);
				$sheet->getColumnDimension('C')->setAutoSize(false)->setWidth(50);
				$sheet->getColumnDimension('D')->setAutoSize(false)->setWidth(50);
				$sheet->getColumnDimension('R')->setAutoSize(false)->setWidth(50);
				$sheet->getColumnDimension('S')->setAutoSize(false)->setWidth(50);
				$sheet->getColumnDimension('AA')->setAutoSize(false)->setWidth(50);
			}

			$writer = \PHPExcel_IOFactory::createWriter($excel, 'Excel2007');
			header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'); // header for .xlxs file
			header('Content-Disposition: attachment;filename="' . trim($title) . '.xlsx"'); // specify the download file name
			header('Cache-Control: max-age=0');
		
			ob_end_clean();
			return $writer->save('php://output');
		}
		catch(\Exception $e){
			$err = preg_replace('/[\'\"]/',"\\'", $e->getMessage());
			$response = \Yii::$app->response;
			$response->statusCode = 401;
			$response->data = array('name'=>'EXPORT-EXCEL', 'message'=>$err);
		} catch(\Throwable $e) {
			print_r($e->getMessage());
    }
	}
	
	/**
	* Export and download report to excel
	* @param dataProvider
	* @param string
	**/
	public function printXls($dataProvider, $title="Record List") {
    // $this->layout = '@app/views/layouts/print.php';  // for newer php
		$this->layout = '@app/views/layouts/print-excel.php';  // php 5.4
    $html = $this->render("@app/views/".$this->id."/print.php", [
      'dataProvider' => $dataProvider, 'title' => $title
    ]);

    $tmpfile = Yii::$app->basePath . "/runtime/" . time() . '.html';
    file_put_contents($tmpfile, $html);
		$this->_printXls($tmpfile, $title);
		unlink($tmpfile);
		exit;
  }
	
	/**
	* return array for breadcrums
	**/
	public function getBreadcrumb(){
		$rewrite = Yii::$app->params['rewrite_on'];
		$curr_url = $rewrite ? $_SERVER['REQUEST_URI'] : urldecode($_SERVER['REQUEST_URI']);  
    $host = Yii::$app->homeUrl;
		$sep = $rewrite ? '' : '?r=';
		$path = Yii::$app->request->pathInfo;
		if(!$path) {
			$path = $_GET['r'] . (isset($_GET['id']) ? "/".$_GET['id'] : '');
		}
		$arr = explode('/', $path); 
		
		$breadcrumbs = [];
    foreach($arr as $i=>$v){
			if(!preg_match("/create|view|update/", $v)){
				$breadcrumbs[$i]['label'] = $v;
				if($i < count($arr)-1)
					$breadcrumbs[$i]['url'] = $host.$sep.$v;
			}
    }
    return $breadcrumbs;
  }
	
	/**
	* return string last visited url
	**/
  public function getHttpRedirect(){
    if(isset($_SERVER['HTTP_REFERER']) && !preg_match("/login/", rawurldecode($_SERVER['HTTP_REFERER'])))
			return $_SERVER['HTTP_REFERER'];
  }
}
?>
