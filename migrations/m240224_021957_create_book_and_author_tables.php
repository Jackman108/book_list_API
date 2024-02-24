<?php

use yii\db\Migration;

/**
 * Class m240224_021957_create_book_and_author_tables
 */
class m240224_021957_create_book_and_author_tables extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {

        // Создание таблицы для книг
        $this->createTable('book', [
            'id' => $this->primaryKey(),
            'title' => $this->string()->notNull(),
            'author_id' => $this->integer(),
            'pages' => $this->integer(),
            'language' => $this->string(),
            'genre' => $this->string(),
            'description' => $this->text(),
        ]);

        // Создание таблицы для авторов
        $this->createTable('author', [
            'id' => $this->primaryKey(),
            'name' => $this->string()->notNull(),
            'birth_year' => $this->integer(),
            'country' => $this->string(),
        ]);
    }


    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        // Удаление таблицы книг
        $this->dropTable('book');

        // Удаление таблицы авторов
        $this->dropTable('author');
    }
}
