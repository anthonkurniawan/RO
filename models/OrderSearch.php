<?php
namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Order;

/**
 * SearchOrder represents the model behind the search form of `app\models\Order`.
 */
class OrderSearch extends Order
{
	public $region_name;
	public $type_name;

  /**
   * {@inheritdoc}
   */
  public function rules()
  {
    return [
      ['id', 'string'],
      [['initiator_id', 'dept_id', 'region_id', 'initiator_dept'], 'integer'],
      [['tag_num_XXX','priority','type','item_desc','assign_to','status','title','detail_desc','initiator_name','assignTo_name','type_name','region_name','quality_ass','ehs_assest'], 'safe'],
      [['create_at', 'complete_at', 'target_dt'], 'date'],
    ];
  }

  /**
   * {@inheritdoc}
   */
  public function scenarios()
  {
    // bypass scenarios() implementation in the parent class
    return Model::scenarios();
  }
	
	public function getQuery(){
		$uid = \Yii::$app->user->id;
		$q = "orders.*, d1.label as initiator_dept, u1.uname AS initiator_name, u2.uname as assignTo_name, d2.label as assignTo_dept,
		(CASE orders.status WHEN 1 THEN 'Rejected' WHEN 2 THEN 'Open' WHEN 3 THEN 'In-progress' WHEN '4' THEN 'Closed' END) as statusText,
		(CASE orders.priority WHEN 1 THEN 'Low' WHEN 2 THEN 'Medium' WHEN 3 THEN 'High' END) as priorityText
		";

		$query = Order::find()->select($q)
			->join('LEFT JOIN', ['u1'=>'users'], 'orders.initiator_id = u1.id')
      ->join('LEFT JOIN', ['u2'=>'users'], 'orders.assign_to = u2.id')
      ->join('LEFT JOIN', ['d1'=>'dept'], 'u1.dept_id = d1.id')
      ->join('LEFT JOIN', ['d2'=>'dept'], 'u2.dept_id = d2.id')
			
			->orderBy("(CASE WHEN (initiator_id='$uid' AND orders.status=1) OR 
			(assign_to='$uid' AND (orders.status=2 OR orders.status=3)) THEN 1 WHEN (assign_to='$uid' AND orders.status=1) THEN 3 WHEN (initiator_id='$uid' OR assign_to='$uid') THEN 2 ELSE 4 END),
			(CASE WHEN initiator_id='$uid' or assign_to='$uid' THEN 1 ELSE 2 END), orders.status, orders.priority desc, orders.target_dt");
		return $query;
	}
	
  /**
   * Creates data provider instance with search query applied
   * @param array $params
   * @return ActiveDataProvider
   */
  public function search($params)
  {
		$query = $this->getQuery();
		$query->join('LEFT JOIN', 'ehs_ass', 'orders.ehs_assest = ehs_ass.id');
		array_push($query->select, 'ehs_ass.label as ehs_ass_name');
		
		if(isset($params['sort'])){
			$query->orderBy(false);
			if(preg_match('/type/', $params['sort'])){
				array_push($query->select, 'order_type.label as type_name');
				$query->join('LEFT JOIN', 'order_type', 'orders.type = order_type.id');
			}
			elseif(preg_match('/region_name/', $params['sort'])){
				array_push($query->select, 'region.nama as region_name');
				$query->join('LEFT JOIN', 'region', 'orders.region_id = region.id');
			}
		}

    // add conditions that should always apply here
    $dataProvider = new ActiveDataProvider([
      'query' => $query,
			'sort' => [
        'enableMultiSort' => FALSE,
        'attributes' => [
          'id','region_id','title','create_at','complete_at','priority','quality_ass','ehs_assest',
					'id' => [
            'asc' => ['orders.id' => SORT_ASC],
            'desc' => ['orders.id' => SORT_DESC],
          ],
					'initiator_name' => [
            'asc' => ['u1.uname' => SORT_ASC],
            'desc' => ['u1.uname' => SORT_DESC],
          ],
					'assignTo_name' => [
            'asc' => ['u2.uname' => SORT_ASC],
            'desc' => ['u2.uname' => SORT_DESC],
          ],
					'region_name' => [
            'asc' => ['region.nama' => SORT_ASC],
            'desc' => ['region.nama' => SORT_DESC],
          ],
					'type_name' => [
            'asc' => ['order_type.label' => SORT_ASC],
            'desc' => ['order_type.label' => SORT_DESC],
          ],
					'status' => [
            'asc' => ['orders.status' => SORT_ASC],
            'desc' => ['orders.status' => SORT_DESC],
          ],
        ]
      ],
    ]);
		
		if(isset($params['print'])){
			$query->join('LEFT JOIN', 
				'(SELECT order_id, MAX(comment.time) MaxDate FROM comment GROUP BY order_id) comments', 
				'orders.id = comments.order_id '
			)
			->join('LEFT JOIN', 'comment c', 'c.order_id = c.order_id');
			array_push($query->select, 'c.comment');
			
			$dataProvider->setPagination(false);
			return $dataProvider;
		}else{
			$size = isset($params['size']) ? $params['size'] : \Yii::$app->params['pagesize'];
			$dataProvider->setPagination(['pageSize'=>$size]);
		}
		
    $this->load($params);

    // grid filtering conditions
		if(isset($params['OrderSearch'])){
			$query->andFilterWhere([
				// 'id' => $this->id,
				// 'create_at' => $this->create_at,
				// 'update_at' => $this->update_at,
				// 'complete_at' => $this->complete_at,
				// 'initiator_id' => $this->initiator_id,
				// 'region_id' => $this->region_id,
				'orders.dept_id' => $this->dept_id,
				'priority' => $this->priority,
				'orders.status' => $this->status,
				'type' => $this->type_name,
				'region_id' => $this->region_name,
				'quality_ass' => $this->quality_ass,
				'orders.ehs_assest' => $this->ehs_assest
			]);

			$query->andFilterWhere(['like', 'orders.id', $this->id])
				->andFilterWhere(['like', 'u1.uname', $this->initiator_name])
				->andFilterWhere(['like', 'u2.uname', $this->assignTo_name])
				->andFilterWhere(['like', 'title', $this->title]);
				// ->andFilterWhere(['like', 'tag_num', $this->tag_num])
				// ->andFilterWhere(['like', 'area', $this->area])
				// ->andFilterWhere(['like', 'item_desc', $this->item_desc])
				// ->andFilterWhere(['like', 'detail_desc', $this->detail_desc])
				// ->andFilterWhere(['like', 'replacement', $this->replacement])
				// ->andFilterWhere(['like', 'ehs_assest', $this->ehs_assest])
				// ->andFilterWhere(['like', 'ehs_hazard', $this->ehs_hazard])
				// ->andFilterWhere(['like', 'ehs_hazard_risk', $this->ehs_hazard_risk]);

			if($this->create_at){
				$day = new \DateTime($this->create_at);
				$day = $day->modify('+1 day')->format('Y-m-d');
				$query->andWhere(['BETWEEN', 'create_at', date('Y-m-d', strtotime($this->create_at)), $day]);
			}
			if($this->complete_at){
				$day = new \DateTime($this->complete_at);
				$day = $day->modify('+1 day')->format('Y-m-d');
				$query->andWhere(['BETWEEN', 'complete_at', date('Y-m-d', strtotime($this->complete_at)), $day]);
			}
			if($this->target_dt){
				$day = new \DateTime($this->target_dt);
				$day = $day->modify('+1 day')->format('Y-m-d');
				$query->andWhere(['BETWEEN', 'target_dt', date('Y-m-d', strtotime($this->target_dt)), $day]);
			}
		}
    return $dataProvider;
  }
	
	public function list_search()
  {
		$req = \Yii::$app->request;
		$params = $req->queryParams; // bodyparams
		
		$query = $this->getQuery();
		if($req->isPost){
			$body = $req->bodyParams;
			if($body['offset']){
				return $query->offset($body['offset'])->limit(3);
			}else{
				$search = $body['q'];
				$query->limit(false);
				return $query->filterWhere(['like', 'orders.id', $search])
					->orFilterWhere(['like', 'orders.title', $search])
					->orFilterWhere(['like', 'orders.detail_desc', $search])
					->orFilterWhere(['like', 'orders.create_at', $search]);
			}
    }
    elseif($req->isGet){
			// $search = preg_replace("/[';]/", "", $req->getQueryParam('q')); 
			return new ActiveDataProvider([
				'query' => $query,
				// 'pagination'=>false,
				'pagination' => ['pageSize'=>3],
			]);
		}
		
	}
}