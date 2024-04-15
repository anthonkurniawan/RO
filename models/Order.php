<?php

namespace app\models;

use Yii;
// use yii\web\UploadedFile;
//use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "order".
 *
 * @property int $id
 * @property string $create_at
 * @property string $update_at
 * @property string|null $complete_at
 * @property int $initiator_id
 * @property int $dept_id
 * @property int $area
 * @property string|null $tag_num
 * @property string $priority
 * @property string|null $item_desc
 * @property int $region_id
 * @property string $assign_to
 * @property string $status
 * @property string $title
 * @property string|null $detail_desc
 * @property string|null $replacement
 * @property int|null $ehs_assest
 * @property string|null $ehs_hazard
 * @property string|null $ehs_hazard_risk
 * @property string|null $comment
 */
class Order extends \yii\db\ActiveRecord
{
  const PRIORITY_LOW = 1; // Material order, setting/trial, project (Tag Number Others)
  const PRIORITY_MEDIUM = 2; // RO Recomendasi dari HIRA/Operator care/ Gemba EHS
	const PRIORITY_HIGH = 3;  // Direct impact to Safety, Quality, Supply, Financial (Reactive)
	
	const STATUS_REJECTED = 1;
	const STATUS_OPEN = 2;       // new order created
  const STATUS_ONPROGRESS = 3; // order accepted
	const STATUS_COMPLETE = 4;   // order complete WITHOUT attachment submitted
	const STATUS_CLOSED = 5;     // order closed WITH attachment submitted (internal use)
	const UPLOAD_DIR = "../web/uploads/";
	
  //const TAG_REGEX = '/[\x00\x0A\x0D\x1A\x22\x25\x27\x5C\x5F]|\x2D{2,}|(\x2F\x2A)|(\x2A\x2F)/';
  //public $_lastComment;
  public $initiator_name;
  public $initiator_dept;
	public $initiator_email;
  public $assignTo_name;
  public $assignTo_fullname;
  public $assignTo_email;
  public $assignTo_dept;
  public $area_id;
  public $ehs_ass_name;
	public $file_attach;
	private $_region_index;
	// public $_attachment;
	// public $tag_desc;
  // public $area_name;
  // public $region_name;
	// public $priority_name;
	// public $type_name;
	// public $statusText;

  /**
   * {@inheritdoc}
   */
  public static function tableName()
  {
    return 'orders';
  }

  /**
   * {@inheritdoc}
   */
  public function rules()
  {
    return [
      [['type','create_at','update_at','initiator_id','dept_id','area','assign_to','status','title','priority','tag_num','item_desc','detail_desc','region_id','ehs_assest','quality_ass','area_id','complete_at','complete_hours'],'required'],
      [['create_at','target_dt','update_at','complete_at_sys','initiator_dept','uname','assignTo_email','assignTo_name','assignTo_fullname'],'safe'],
      [['type','initiator_id','assign_to','dept_id','status','priority','region_id','quality_ass','ehs_assest'],'integer'],
			['status', 'in', 'range'=>[self::STATUS_REJECTED, self::STATUS_OPEN, self::STATUS_ONPROGRESS, self::STATUS_COMPLETE]],
      [['title','detail_desc','tag_num','item_desc','area','replacement','ehs_hazard_risk'], 'trim'],
			[['tag_num','item_desc','area'],'string','max'=>56],
			['title','string','max'=>255],
      [['replacement','ehs_hazard_risk'],'string','max'=>500],
			// ['attachment','string','max'=>17],
			['attachment', 'file', 'maxSize'=>1000000, 'extensions'=>'png,jpg,pdf,xlsx,doc,zip'],
			// ['ehs_assest','default','value'=>1],
			// ['quality_ass','default','value'=>1],
			[['quality_ass'],'default','value'=>1],
			[['mmnr','complete_hours'], 'integer'],
			['mmnr', 'required', 'on'=>'create', 'when'=>function($model){
					return $model->quality_ass != 1;
			}],
			//[['initiator_name'],'safe','on'=>'search'],
      //[['tag_num'],'match','pattern'=>self::TAG_REGEX,'not'=>true],
      //'passwordMatch'=>[['password','passwordConfirm'],'match','pattern'=>'/^(?=.*\d).{8,16}$/',
    ];
  }

  /**
   * {@inheritdoc}
   */
  public function attributeLabels()
  {
    return [
      'id'=>'No.',
      'create_at'=>'Created',
      'update_at'=>'Updated',
      'complete_at'=>'Completed',
      'initiator_id'=>'Initiator ID',
      'dept_id'=>'Departement',
      'area_id'=>'Area / Room',
      'area'=>'Area / Room',
      'tag_num'=>'Tag Number',
      'item_desc'=>'Machine / Equipment Descripton',
      'priority'=>'Priority',
      'assign_to'=>'Assigned To',
      'region_id'=>'Regional',
      'status'=>'Status',
      'title'=>'Title Descripton',
      'detail_desc'=>'Detail Request Descriptons',
      'replacement'=>'Replacement',
			'quality_ass'=>'Quality Assessment',
      'ehs_assest'=>'EHS Assestment',
      'ehs_hazard'=>'Hazard',
      'ehs_hazard_risk'=>'Consequence of Hazard',
      'initiator_name'=>'Initiator',
      'assignTo_name'=>'Assign To',
      'assignTo_dept'=>'Departement',
      'initiator_dept'=>'Departement',
			'type'=>'Request Type',
			'target_dt'=>'Propose Complete Date',
			'complete_hours'=>'Hours',
			'mmnr'=>'No. MMNR'
			// 'file_attach'
			// 'attachment'
			// 'tag_name'=>Yii::t('app','Tag Number')
      // 'area_name'=>'Area / Room',
    ];
  }

  public function scenarios()
  {
    return array_merge(parent::scenarios(),[
      'pre-create'=>['region_id'],
      'create'=>['id','status','area_id','type','tag_num','priority','item_desc','assign_to','title','detail_desc','area','ehs_assest','ehs_hazard','ehs_hazard_risk','quality_ass','assignTo_email','assignTo_name','assignTo_fullname','mmnr'],
      'acceptation'=>['status'],
			'completion'=>['status', 'replacement', 'attachment', 'complete_at', 'complete_hours'],
			'update-attach'=>['attachment'],
			'commenting'=>[],
    ]);
  }

	public function beforeSave($insert)
  {
    if (parent::beforeSave($insert)) {
      $this->update_at = date('Y-m-d H:i:s');
			if($this->isComplete)
				$this->complete_at_sys = date('Y-m-d H:i:s');
			else
				$this->complete_at_sys = NULL;
      return true;
    }
		else 
			return false;  // IS UPDATE
  }
	
  /**
   * {@inheritdoc}
   * @return OrderQuery the active query used by this AR class.
   */
  public static function find()
  {
    return new OrdersQuery(get_called_class());
  }

  public function getId($regid=null)
  {
		$regid = $regid ? $regid : $this->region_id;
		$d = new \DateTime();
    $ds = $d->modify('first day of this month')->format('Y-m-d');
    $de = $d->modify('last day of this month')->format('Y-m-d');
    $count = $this->db->createCommand("select id from orders where region_id=:reg and create_at between '$ds' and '$de' order by create_at desc")->bindValue(':reg',$regid)->queryScalar();

    if($count){
      $index = sprintf("%03d", substr($count + 1, 7));
    }else{
      $index = sprintf("%03d", $count + 1);
    }
    $this->id = sprintf("%02d",$regid) . "" . date("mY") . "" . $index;
    return $this->id;
  }

  public function getRegionIndex($region=null)
  {
    $d = new \DateTime();
    $ds = $d->modify('first day of this month')->format('Y-m-d');
    $de = $d->modify('last day of this month')->format('Y-m-d');
    $count = $this->db->createCommand("select id from orders where region_id=:reg and create_at between '$ds' and '$de' order by create_at desc")->bindValue(':reg',$this->region_id)->queryScalar();

    if ($count) {
      $this->_region_index = sprintf("%03d", substr($count + 1, 7));
    } else {
      $this->_region_index = sprintf("%03d", $count + 1);
    }
    return $this->_region_index;
  }
	
	public function getRegionTotal()
  {
    return $this->db->createCommand("select count(region_id) from orders where region_id=:reg")->bindValue(':reg',$this->region_id)->queryScalar();
  }

  public function getComplete_hours_sys()
  {
    if (!$this->complete_at) return;
    $d1 = new \DateTime($this->create_at);
    $d2 = new \DateTime($this->complete_at);
    $diff = $d1->diff($d2);
    return ($diff->days * 24) + $diff->format('%H');
  }

  public function getTypeOrderList()
  {
    return [self::ORDER_ITEM=>'Item', self::ORDER_SERVICE=>'Service'];
  }

  public function getPriorityList()
  {
    return [self::PRIORITY_LOW=>'Low', self::PRIORITY_MEDIUM=>'Medium', self::PRIORITY_HIGH=>'High'];
  }
	
	public function getPriorityText()
  {
		if($this->priority){
			$list = $this->getPriorityList();
			return $list[$this->priority];
		}
  }
	
	public function getStatusList()
  {
    return [self::STATUS_OPEN=>'Open', self::STATUS_REJECTED=>'Rejected', self::STATUS_ONPROGRESS=>'In-Progress', self::STATUS_COMPLETE=>'Closed'];
  }

	public function getStatusText($status=null)
  {
		$status = $status ? $status : $this->status;
		$list = $this->getStatusList();
		
    return $list[$status];
  }
	
	public function getIsOpen()
  {
		return $this->status == self::STATUS_OPEN;
	}
	
	public function getIsRejected()
  {
		return $this->status == self::STATUS_REJECTED;
	}
	
	public function getIsInprogress()
  {
		return $this->status == self::STATUS_ONPROGRESS;
	}
	
	public function getIsComplete()
  {
		return $this->status == self::STATUS_COMPLETE;
	}
	
	public function getIsClosed()
  {
		return $this->status == self::STATUS_CLOSED;
	}
	
  public function getIsOwner()
  {
    return $this->initiator_id === Yii::$app->user->id;
	}

  public function getIsAssigned()
  {
    return $this->assign_to === Yii::$app->user->id;
  }

	public function getCanEdit()
  {
		return !$this->isComplete && (($this->isOwner && $this->status < self::STATUS_ONPROGRESS) || ($this->isAssigned && $this->status > self::STATUS_REJECTED));
  }
	
	public function getCanAttach(){
		return $this->isAssigned && $this->status > self::STATUS_ONPROGRESS;
	}
	
  /**
   * Gets query for [[Dept]].
   *
   * @return \yii\db\ActiveQuery
   */
  public function getDept()
  {
    return $this->hasOne(Dept::className(), ['id'=>'dept_id']);
  }

  /**
   * Gets query for [[Dept]].
   */
  public function getRegion()
  {
    return $this->hasOne(Region::className(), ['id'=>'region_id']);
  }
	
	public function getRegion_name()
  {
		if($this->region_id)
			return \app\models\Region::getlabel($this->region_id);
  }
	
	public function getType_name()
  {
		if($this->type)
			return \app\models\OrderType::getlabel($this->type);
  }
	
	public function getHazard_name()
  {
		if($this->ehs_hazard)
			return Hazard::getlabel($this->ehs_hazard);
  }

	/**
   * Gets query for [[Dept]].
   */
  public function getHazard()
  {
    return $this->hasOne(Hazard::className(), ['id'=>'ehs_hazard']);
  }
	
  /**
   * Gets query for [[Area]].
   */
  public function getArea()
  {
    return $this->hasOne(Area::className(), ['id'=>'area']);
  }

	/**
   * Gets query for [[OrderType]].
   */
  public function getOrderType()
  {
    return $this->hasOne(OrderType::className(), ['id'=>'type']);
  }

  /**
   * Gets query for [[Initiator]].
   *
   * @return \yii\db\ActiveQuery
   */
  public function getInitiator()
  {
    return $this->hasOne(User::className(), ['id'=>'initiator_id']);
  }

  /**
   * Gets query for [[AssignTo]].
   *
   * @return \yii\db\ActiveQuery
   */
  public function getAssignTo()
  {
    return $this->hasOne(User::className(), ['id'=>'assign_to']);
  }

  /**
   * Gets query for [[Tag]].
   *
   * @return \yii\db\ActiveQuery
   */
  public function getTag()
  {
    return $this->hasOne(Tag::className(), ['id'=>'tag_num']);
  }

	/**
   * Gets query for [[Comments]].
   *
   * @return \yii\db\ActiveQuery
   */
  public function getComments()
  {
		return $this->db->createCommand("select comment.comment, comment.time, comment.context_id, users.uname from comment left join users on comment.user_id = users.id where order_id=:order_id")
		->bindValue(':order_id',$this->id)->queryAll();
  }
	
	/**
   * Gets query for [[Last Comment Model]].
   */
  public function getLastComment()
  {
    $comments = $this->comments;
    $count = count($comments);
    if ($count) return $comments[$count - 1];
  }
	
	public function renderComments($action, $print=0){
		$comments = $this->comments;
		$str="";
		if($comments){
			if($print){
				$str.="<div class='form-group col-sm-12'><label>Comments</label>
    <div class='comment_box' style='min-height:80px'>".$this->lastComment['comment']."</div></div>";
			}
			else{
				$count = count($comments);
				$str .= "<div id='comment_list' class='form-group col-sm-12'".($count > 1 ? " style='margin:0'><label>Comments ($count)" : "><label>Comment")."</label>";
				$last = $count - 1;
				for ($i = 0; $i < $count; $i++) {
					if ($i == $last) {
						$str .= "<div class='comment_box last'>".$this->renderComment($comments[$i])."</div>";
					} else {
						$str .= "<div class='comment_box' style='display:none'>".$this->renderComment($comments[$i])."</div>";
					}
				}
				$str .= "<div class='col-sm-12 clearfix cmt-ctrl'>";
				$str .= ($count > 1 ? "<span id='view-cmt' class='btn-link pull-right'>Show More</span> </div></div>" : "</div></div>");
			}
		}
		return $str;
	}
	
	public function renderComment($cmt){
		return "<div class='comment'>".$cmt['comment']."</div><div class='from'><span>".$cmt['uname']."</span>"
		.",<span>".$this->getStatusText($cmt['context_id'])."</span><span>".date("d-m-Y H:i:s",$cmt['time'])."</span></div>";
	}
}
