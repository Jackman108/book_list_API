<?php
// /models/AuthorSearch.php

namespace app\models;

use yii\data\ActiveDataProvider;

class AuthorSearch extends Author
{
    public function rules(): array
    {
        return [
            [['name', 'birth_year', 'country'], 'safe'],
        ];
    }

    public function search($params): ActiveDataProvider
    {
        $query = Author::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        $query->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['birth_year' => $this->birth_year])
            ->andFilterWhere(['like', 'country', $this->country]);

        return $dataProvider;
    }
}
