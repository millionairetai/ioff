<?php

namespace backend\controllers;

use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use backend\models\ChangePasswordForm;

class StaffController extends \yii\web\Controller {

    private $_model;

    public function __construct($id, $module, $config = array()) {
        $this->_model = new \common\models\Staff();
        parent::__construct($id, $module, $config);
    }

    /**
     * Get list of staff
     */
    public function actionIndex() {
        $dataProvider = $this->_model->search(\Yii::$app->request->getQueryParams());
        return $this->render('index', ['model' => $this->_model, 'dataProvider' => $dataProvider]);
    }

    /**
     * Add staff
     */
    public function actionAdd() {
        $staff = \Yii::$app->request->post('Staff');

        if (isset($staff)) {
            $this->_model->attributes = $staff;
//            $this->_model->generateAuthKey();
            if ($this->_model->validate()) {
                $this->_model->setPassword($this->_model->password);
                if ($this->_model->save(false)) {
                    //Send email to staff.
                    return $this->redirect(['staff/index']);
                }
            }
        }

        return $this->render('form', ['model' => $this->_model]);
    }

    /**
     * Update staff
     */
    public function actionUpdate($id) {
        $this->_model = \common\models\Staff::findOne($id);

        if (!$this->_model) {
            throw new NotFoundHttpException('The requested page does not exist.');
        }

        $staff = \Yii::$app->request->post('Staff');

        if (isset($staff)) {
            $this->_model->attributes = $staff;
//            $this->_model->package_name = \common\models\Package::findOne($staff['package_id'])->name;

            if ($this->_model->save()) {
                return $this->redirect(['staff/index']);
            }
        }

        return $this->render('form', ['model' => $this->_model]);
    }

    /**
     * Delete staff
     */
    public function actionDelete($id) {
        $this->_model = \common\models\Staff::findOne($id);

        if (!$this->_model) {
            throw new NotFoundHttpException('The requested page does not exist.');
        }

        if ($this->_model->delete()) {
            return $this->redirect(['staff/index']);
        }

        throw new NotFoundHttpException('Can not delete staff');
    }

    /**
     * Change password for staff
     */
    public function actionChangePassword() {
        $model = new ChangePasswordForm();
        if (Yii::$app->request->post()) {
            $model->attributes = Yii::$app->request->post('ChangePasswordForm');
            if ($model->changePassword(Yii::$app->user->identity->id)) {
                Yii::$app->session->setFlash('success', 'Thay đổi mật khẩu thành công.');
            } else {
                Yii::$app->session->setFlash('error', 'Thay đổi mật khẩu thất bại');
            }
        }

        return $this->render('change_password', ['model' => $model]);
    }

}
