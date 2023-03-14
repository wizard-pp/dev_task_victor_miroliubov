<?php

namespace orders\models\search;

use orders\models\Order;
use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * OrderSearch represents the model behind the search form of `app\models\Order`.
 */
class OrderSearch extends Order
{
    const PAGE_SIZE = 100;

    public string $user;
    public string $service;
    public ?string $username = null;

    /**
     * {@inheritdoc}
     */
    public function rules(): array
    {
        return [
            [['id', 'user_id', 'quantity', 'service_id', 'status', 'created_at', 'mode'], 'integer'],
            [['link'], 'safe'],
            [['user', 'service', 'username'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function scenarios(): array
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
    public function search(array $params): ActiveDataProvider
    {
        $query = Order::find();

        // add conditions that should always apply here
        $query->joinWith(['user', 'service']);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => self::PAGE_SIZE,
            ],
            'sort' => false
        ]);

        $this->load($params);

        if (!$this->validate()) {
            $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'orders.id' => $this->id,
            'orders.user_id' => $this->user_id,
            'orders.service_id' => $this->service_id,
            'orders.status' => $this->status,
            'orders.mode' => $this->mode,
        ]);

        $query->andFilterWhere(['like', 'orders.link', $this->link]);

        $query->andFilterWhere(['like', 'users.first_name', $this->username])
            ->orFilterWhere(['like', 'users.last_name', $this->username]);

        $query->orderBy(['orders.id' => SORT_DESC]);

        return $dataProvider;
    }
}
