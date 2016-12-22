<?php
/**
 * Created by PhpStorm.
 * User: floor12
 * Date: 09.11.2016
 * Time: 13:06
 */

namespace floor12\comments;


use backend\logic\comment\CommentUpdate;
use common\models\Comment;
use common\models\Post;
use backend\components\CommentsWidget;
use yii\web\Controller;
use yii\filters\AccessControl;
use yii\web\ForbiddenHttpException;
use backend\components\UserBehavior;


class CommentController extends Controller
{
    public $layout = 'private';
    public $defaultAction = 'index';

    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ]
        ];
    }

    public function actionIndex($id, $model)
    {

        $classname = 'common\\models\\' . ucfirst($model);

//        if (($model == 'post') && !\Yii::$app->user->can('commentCreate', ['post' => Post::findOne($id)]))
//            throw new ForbiddenHttpException("Read this comments is not permitted");

        return CommentsWidget::widget(['classname' => $classname, 'object_id' => $id]);
    }

    public function actionForm($component = NULL, $object_id = 0, $parent = 0, $id = 0)
    {

        if ($id) {
            $model = Comment::findOne($id);
//            if (($model->class == 'common\models\Post') && !\Yii::$app->user->can('commentUpdate', ['comment' => $model]))
//                throw new ForbiddenHttpException("Update this comment is not permitted");
        } else {
            $model = new Comment();

//            if (($component == 'post') && !\Yii::$app->user->can('commentCreate', ['post' => Post::findOne($object_id)]))
//                throw new ForbiddenHttpException("Comment this post is not permitted");

            if ($model)
                $model->class = "common\\models\\" . ucwords($component);
            $model->object_id = $object_id;
            $model->parent_id = $parent;
        }


        if (\Yii::$app->request->post('Comment') && \Yii::createObject(CommentUpdate::class, [
                $model,
                \Yii::$app->request->post('Comment'),
                \Yii::$app->user->identity])->execute()
        ) {
            if (!$component)
                $component = strtolower((new \ReflectionClass($model->class))->getShortName());
            return "
            <script>
                info('Комментарий успешно сохранен',1);
                hideFormModal();
                comments({$model->object_id},'{$component}')
            </script>";
        }

        return $this->renderAjax('_form', ['model' => $model]);
    }

    public function actionDelete()
    {
        $id = \Yii::$app->request->getBodyParams('id');
        if (!$id)
            throw new BadRequestHttpException;
        $model = Comment::findOne($id);
//        if (!\Yii::$app->user->can('commentDelete', ['comment' => $model]))
//            throw new ForbiddenHttpException("Forbidden to delete this comment.");
        if (!$model)
            throw new NotFoundHttpException;
        $model->delete();
    }
}