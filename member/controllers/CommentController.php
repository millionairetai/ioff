<?php

namespace member\controllers;

use Yii;
use common\models\Comment;
use common\models\Like;

class CommentController extends ApiController {

    /**
     * Add comment
     */
    public function actionAdd() {
        $transaction = \Yii::$app->db->beginTransaction();
        try {
            if ($comment = new Comment()) {
                $comment->attributes = Yii::$app->request->post();
                $comment->employee_id = Yii::$app->user->identity->id;
                $comment->company_id = Yii::$app->user->identity->company_id;
                if ($comment->save() !== false) {
                    //increase total_comment in activity table one step.
                    \common\models\Activity::updateAllCounters(['total_comment' => 1], ['id' => $comment->activity_id]);
                    $return = [
                        $comment->id => [
                            'content' => $comment->content,
                            'datetime' => \Yii::$app->formatter->asDateTime($comment->datetime_created),
                            'total_like' => 0,
                            'employee' => [
                                'avatar' => Yii::$app->user->identity->image,
                                'fullname' => Yii::$app->user->identity->fullname,
                            ],
                        ]
                    ];
                    $transaction->commit();
                    return $this->sendResponse($this->_error, $this->_message, ['comments' => $return]);
                }

                $this->_message = $this->parserMessage($comment->getErrors());
            }

            throw new \Exception('Can not initialize object');
        } catch (\Exception $ex) {
            $transaction->rollBack();
            $this->_error = true;
            return $this->sendResponse($this->_error, \Yii::t('member', 'error_system'), []);
        }

        return $this->sendResponse(false, "", $comment);
    }

    /**
     * Like comment
     */
    public function actionLike() {
        try {
            $transaction = \Yii::$app->db->beginTransaction();
            if ($commentId = Yii::$app->request->post('commentId')) {
                //save into like table.
                $like = new Like();
                $like->employee_id = Yii::$app->user->identity->id;
                $like->owner_id = $commentId;
                $like->owner_table = Like::TABLE_COMMENT;
                if ($like->save() === false) {
                    throw new \Exception('Can not like');
                }
                //increase like 1 step in comment
                Comment::updateAllCounters(['total_like' => 1], ['id' => $commentId]);
                $transaction->commit();
                return $this->sendResponse($this->_error, '', []);
            }

            throw new \Exception('Can not like');
        } catch (\Exception $ex) {
            $transaction->rollBack();
            $this->_error = true;
            return $this->sendResponse($this->_error, \Yii::t('member', 'error_system'), []);
        }

        return $this->sendResponse(false, '', []);
    }

}
