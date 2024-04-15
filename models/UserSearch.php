<?php
namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\User;

/**
 * UserSearch represents the model behind the search form of `app\models\User`.
 */
class UserSearch extends User
{
  /**
   * {@inheritdoc}
   */
  public function rules()
  {
    return [
      [['status', 'role', 'dept_id'], 'safe'],
      [['uname', 'fullname', 'email'], 'string'],
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
    $query = User::find()
      ->select(['users.*', 'dept.label as dept_name'])
      ->join('LEFT JOIN', 'dept', 'users.dept_id = dept.id')
      ->where("users.uname != 'admin'");

    // add conditions that should always apply here
    $dataProvider = new ActiveDataProvider([
			'query' => $query,
      'sort' => [
        'attributes' => ['uname','fullname','email', 'dept_id', 'role', 'status'
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

    // grid filtering conditions
    $query->andFilterWhere([
      'dept_id' => $this->dept_id,
      'role' => $this->role,
      'dept_id' => $this->dept_id,
      'status' => $this->status,
      //'id' => $this->id,
      //'created_at' => $this->created_at,
      //'updated_at' => $this->updated_at,
    ]);

    $query->andFilterWhere(['like', 'uname', $this->uname])
      ->andFilterWhere(['like', 'fullname', $this->fullname])
      ->andFilterWhere(['like', 'email', $this->email]);
      //->andFilterWhere(['like', 'signature', $this->signature])
      //->andFilterWhere(['like', 'spv', $this->spv])
      //->andFilterWhere(['like', 'priv', $this->priv])
      //->andFilterWhere(['like', 'auth_key', $this->auth_key])
      //->andFilterWhere(['like', 'password_hash', $this->password_hash])
      //->andFilterWhere(['like', 'access_token', $this->access_token])
      //->andFilterWhere(['like', 'password_reset_token', $this->password_reset_token]);

    return $dataProvider;
  }
}
