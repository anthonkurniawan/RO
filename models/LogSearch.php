<?php
namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Log;

/**
 * LogSearch represents the model behind the search form of `app\models\Log`.
 */
class LogSearch extends Log
{
  /**
   * {@inheritdoc}
   */
  public function rules()
  {
    return [
      [['id', 'userid'], 'integer'],
      [['event', 'uname'], 'safe'],
      [['date'], 'date'],
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

  /**
   * Creates data provider instance with search query applied
   *
   * @param array $params
   *
   * @return ActiveDataProvider
   */
  public function search($params)
  {
    $query = Log::find()
      ->select(['log.*', 'users.uname as uname'])
      ->join('LEFT JOIN', 'users', 'log.userid = users.id')
			->orderBy('date desc');

    // add conditions that should always apply here

    $dataProvider = new ActiveDataProvider([
      'query' => $query,
      'sort' => ['attributes' => ['event', 'uname', 'date']],
    ]);

		if(isset($params['print'])) 
			$dataProvider->setPagination(false);
		else{
			$size = isset($params['size']) ? $params['size'] : \Yii::$app->params['pagesize'];
			$dataProvider->setPagination([
        'pageSize' => $size
      ]);
		}

    $this->load($params);

    if (!$this->validate()) {
      // uncomment the following line if you do not want to return any records when validation fails
      // $query->where('0=1');
      return $dataProvider;
    }

    // grid filtering conditions
    $query->andFilterWhere(['like', 'event', $this->event])
      ->andFilterWhere(['like', 'users.uname', $this->uname]);

    if($this->date){
			$day = new \DateTime($this->date);
			$day = $day->modify('+1 day')->format('Y-m-d');
      $query->andWhere(['BETWEEN', 'date', date('Y-m-d', strtotime($this->date)), $day]);
		}

    return $dataProvider;
  }
}
