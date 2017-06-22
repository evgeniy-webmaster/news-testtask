<?php

namespace app\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use app\models\User;

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
    public $image;

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
            [['authorId'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['authorId' => 'id']],
            [['title'], 'string', 'max' => 150],
            [['shortText'], 'string', 'max' => 500],
            [['image'], 'file', 'skipOnEmpty' => false, 'skipOnEmpty' => true, 'extensions' => 'jpg'],
            [['text'], 'string'],
            [['status'], 'boolean'],
        ];
    }

    public function getImageSrc()
    {
        if(file_exists(Yii::getAlias('@app') . '/web/news-images/' . $this->id . '.jpg'))
            return '/news-images/' . $this->id . '.jpg';
        else false;
    }

    public function afterSave($insert, $changedAttributes)
    {
        if($this->image instanceof \yii\web\UploadedFile)
            $this->image->saveAs(Yii::getAlias('@app') . '/web/news-images/' . $this->id . '.jpg');

        if($insert && $this->status) {
            $users = User::find()->where(['confirmed' => true, 'get_emails' => true])->all();
            foreach($users as $u) {
                Yii::$app->mailer->compose('news/news-created', ['news' => $this])
                    ->setFrom('noreply@' . Yii::$app->request->serverName)
                    ->setTo($u->email)
                    ->setSubject(Yii::$app->request->serverName . ': ' . $this->title)
                    ->send();
            }
        }
        parent::afterSave($insert, $changedAttributes);
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
