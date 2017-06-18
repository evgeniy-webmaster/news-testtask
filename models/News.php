<?php

namespace app\models;

use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "news".
 *
 * @property integer $id
 * @property integer $authorId
 * @property string $shortText
 * @property string $text
 * @property integer $status
 *
 * @property User $author
 */
class News extends \yii\db\ActiveRecord
{
    
    function init()
    {
        $this->status = true;
    }

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'news';
    }

    public function behaviors()
    {
        return [
            TimestampBehavior::className(),
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['title', 'shortText', 'text', 'status'], 'required'],
            [['authorId'], 'default', 'value' => Yii::$app->user->identity->id],
            [['authorId'], 'integer'],
            [['status'], 'boolean'],
            [['text'], 'string'],
            [['title'], 'string', 'max' => 150],
            [['shortText'], 'string', 'max' => 500],
            [['authorId'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['authorId' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'authorId' => 'Author ID',
            'title' => 'Title',
            'shortText' => 'Short Text',
            'text' => 'Text',
            'status' => 'Status',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAuthor()
    {
        return $this->hasOne(User::className(), ['id' => 'authorId']);
    }
}
