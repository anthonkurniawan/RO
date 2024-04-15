<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Area;

/**
 * AreaSearch represents the model behind the search form of `app\models\Area`.
 */
class AreaSearch extends Area
{
  /**
   * {@inheritdoc}
   */
  public function rules()
  {
    return [
      [['label_a', 'dept_id'], 'safe'],
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
    $query = Area::find();

    // add conditions that should always apply here
    $dataProvider = new ActiveDataProvider([
			'query' => $query,
			'sort' => [
        'attributes' => ['label_a']
      ],
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
      return $dataProvider;
    }

    $query->andFilterWhere(['like', 'label_a', $this->label_a]);

    return $dataProvider;
  }
}
