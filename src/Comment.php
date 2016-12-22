<?php

namespace floor12\comments;

use Yii;
use yii\db\ActiveRecord;
use backend\components\UserBehavior;

/**
 * This is the model class for table "comment".
 *
 * @property integer $id
 * @property integer $created
 * @property integer $updated
 * @property integer $create_user_id
 * @property integer $update_user_id
 * @property integer $class
 * @property integer $object_id
 * @property integer $parent_id
 * @property integer $status
 * @property string $content
 * @property integer $likes
 */
class Comment extends ActiveRecord
{

    /**
     * Общее количество комментов
     *
     * @param $classname string
     * @param $object_id integer
     * @return integer
     */

    public static function total($classname, $object_id, $sub = false)
    {
        $classname = str_replace("\\", "\\\\", $classname);
        $res = Yii::$app->db->createCommand("SELECT count(id) as count FROM comment WHERE `status`=0 AND parent_id=0 AND `object_id`='{$object_id}' AND `class`='{$classname}' ")->queryOne();
        return $res['count'];
    }

    /**
     * Получаем дочерние коменты
     *
     * @return Comment[]
     *
     **/


    public function getChildren()
    {
        return self::find()->where("status=0 AND parent_id='{$this->id}'")->orderBy('created ASC')->all();
    }


    /**
     * Получаем автора
     *
     * @return User
     *
     **/

    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'create_user_id']);
    }


    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'comment';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['class', 'object_id'], 'required'],
            [['content'], 'required', 'message' => 'Нельзя сохранить пустой комментарий.'],
            [['created', 'updated', 'create_user_id', 'update_user_id', 'object_id', 'parent_id', 'status'], 'integer'],
            [['content'], 'string'],
        ];
    }

    /**
     * Количество лайков
     *
     * @return integer
     */

    public function getLikes()
    {
        return Like::total($this->className(), $this->id);
    }


    public function behaviors()
    {
        return [
            'user' => \floor12\defaultbehavior\DefaultBehavior::className(),
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'created' => Yii::t('app', 'Created'),
            'updated' => Yii::t('app', 'Updated'),
            'create_user_id' => Yii::t('app', 'Create User ID'),
            'update_user_id' => Yii::t('app', 'Update User ID'),
            'class' => Yii::t('app', 'Class'),
            'object_id' => Yii::t('app', 'Object ID'),
            'parent_id' => Yii::t('app', 'Parent ID'),
            'status' => Yii::t('app', 'Status'),
            'content' => Yii::t('app', 'Content'),
        ];
    }

    public function getParent()
    {
        return $this->hasOne(self::className(), ['id' => 'parent_id']);
    }


}
