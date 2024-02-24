<?php
// /models/BookSearch.php

namespace app\models;

use yii\data\ActiveDataProvider;

class BookSearch extends Book
{
    public function rules(): array
    {
        return [
            [['title', 'author_id', 'pages', 'language', 'genre', 'description'], 'safe'],
        ];
    }

    public function search($params): ActiveDataProvider
    {
        $query = Book::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        $query->andFilterWhere(['like', 'title', $this->title])
            ->andFilterWhere(['author_id' => $this->author_id])
            ->andFilterWhere(['pages' => $this->pages])
            ->andFilterWhere(['like', 'language', $this->language])
            ->andFilterWhere(['like', 'genre', $this->genre])
            ->andFilterWhere(['like', 'description', $this->description]);

        return $dataProvider;
    }
}
