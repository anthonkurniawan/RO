<?php
namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Dept;

/**
 * DeptSearch represents the model behind the search form of `app\models\Dept`.
 */
class DeptSearch extends Dept
{
  /**
   * {@inheritdoc}
   */
  public function rules()
  {
    return [
      [['id'], 'integer'],
      [['label'], 'safe'],
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
    $query = Dept::find();

    // add conditions that should always apply here
    $dataProvider = new ActiveDataProvider(['query' => $query,]);

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
    $query->andFilterWhere(['like', 'label', $this->label]);

    return $dataProvider;
  }
}
