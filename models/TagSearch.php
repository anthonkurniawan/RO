<?php
namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Tag;

/**
 * TagSearch represents the model behind the search form of `app\models\Tag`.
 */
class TagSearch extends Tag
{
  /**
   * {@inheritdoc}
   */
  public function rules()
  {
    return [
      [['tagnum', 'desct', 'area_name'], 'safe'],
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
    $query = Tag::find()
      ->select(['tag.*', 'area.label_a as area_name'])
      ->join('LEFT JOIN', 'area', 'tag.area_id = area.id');

    // add conditions that should always apply here
    $dataProvider = new ActiveDataProvider([
      'query' => $query,
      'sort' => [
        'attributes' => [
          'tagnum',
          'desct',
          'area_name'=>[
            'asc' => ['area.label_a' => SORT_ASC],
            'desct' => ['area.label_a' => SORT_DESC],
          ]
        ]
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
      // uncomment the following line if you do not want to return any records when validation fails
      // $query->where('0=1');
      return $dataProvider;
    }

    $query->andFilterWhere(['like', 'tagnum', $this->tagnum])
      ->andFilterWhere(['like', 'desct', $this->desct])
      ->andFilterWhere(['like', 'area.label_a', $this->area_name]);

    return $dataProvider;
  }
}
