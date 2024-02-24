<?php

namespace app\models;

use yii\db\ActiveRecord;

/**
 * This is the model class for table "book".
 *
 * @property int $id
 * @property string|null $title
 * @property int|null $author_id
 * @property int|null $pages
 * @property string|null $language
 * @property string|null $genre
 * @property string|null $description
 */
class Book extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName(): string
    {
        return 'book';
    }

    /**
     * {@inheritdoc}
     */
    public function rules(): array
    {
        return [
            [['author_id', 'pages'], 'default', 'value' => null],
            [['author_id', 'pages'], 'integer'],
            [['description'], 'string'],
            [['title', 'language', 'genre'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels(): array
    {
        return [
            'id' => 'ID',
            'title' => 'Title',
            'author_id' => 'Author ID',
            'pages' => 'Pages',
            'language' => 'Language',
            'genre' => 'Genre',
            'description' => 'Description',
        ];
    }
}
