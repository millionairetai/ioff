<?php

namespace frontend\controllers;

use Yii;
use yii\base\InvalidParamException;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use frontend\models\SubscribeForm;
use common\models\LoginForm;
use common\models\PlanType;
use frontend\models\PasswordResetRequestForm;
use frontend\models\ResetPasswordForm;
use frontend\models\SignupForm;
use frontend\models\ContactForm;

/**
 * Site controller
 */
class SiteController extends Controller {

    /**
     * @inheritdoc
     */
    public function behaviors() {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout', 'signup'],
                'rules' => [
                    [
                        'actions' => ['signup'],
                        'allow' => true,
                        'roles' => ['?'],
                    ],
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function actions() {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return mixed
     */
    public function actionIndex() {
        $model = new SignupForm();
        $subscribeModel = new SubscribeForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            $planType = PlanType::getsIndexByColumnName();
            $packageInfo = ['package_name' => $planType[$model->plan_type]['name']];
            switch ($model->plan_type) {
                case 'free':
                    $model->numberMonth = 0;
                    $packageInfo += [
                        'total_money' => 0,
                        'number_month' => 'Unlimited',
                    ];
                    $model->maxUser = $planType[$model->plan_type]['max_user'];
                    $model->maxStorage = $planType[$model->plan_type]['max_storage'];
                    break;
                case 'standard':
                    $packageInfo += [
                        'total_money' => ($planType[$model->plan_type]['fee_user'] * $model->maxUser + $planType[$model->plan_type]['fee_storage'] * $model->maxStorage) * $model->numberMonth,
                        'number_month' => $model->numberMonth,
                    ];
                    break;
                case 'premium':
                    $model->maxUser = 0;
                    $packageInfo += [
                        'total_money' => ($planType[$model->plan_type]['fee_user'] + $planType[$model->plan_type]['fee_storage'] * $model->maxStorage) * $model->numberMonth,
                        'number_month' => $model->numberMonth,
                    ];
                    break;
            }

            return $this->render('order', ['model' => $model, 'packageInfo' => $packageInfo]);
        } else if ($subscribeModel->load(Yii::$app->request->post()) && $subscribeModel->validate()) {
            if ($subscribeModel->add()) {
                Yii::$app->session->setFlash('success', Yii::t('frontend', 'Congratulation! You have just been subscribed successfully'));
            } else {
                Yii::$app->session->setFlash('error', 'There was an error subscribe.');
            }

            return $this->refresh();
        } else {
            return $this->render('index', [
                        'model' => $model,
                        'subscribeModel' => $subscribeModel,
            ]);
        }

        return $this->render('index');
    }

    /**
     * Action order
     *
     */
    public function actionOrder() {
        $model = new SignupForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->signup()) {
                $planType = PlanType::getsIndexByColumnName();
                $packageInfo = ['package_name' => $planType[$model->plan_type]['name']];
                switch ($model->plan_type) {
                    case 'free':
                        $model->numberMonth = 0;
                        $packageInfo += [
                            'total_money' => 0,
                            'number_month' => 'Unlimited',
                            'is_free_plan_type' => true,
                        ];
                        $model->maxUser = $planType[$model->plan_type]['max_user'];
                        $model->maxStorage = $planType[$model->plan_type]['max_storage'];
                        break;
                    case 'standard':
                        $packageInfo += [
                            'total_money' => ($planType[$model->plan_type]['fee_user'] * $model->maxUser + $planType[$model->plan_type]['fee_storage'] * $model->maxStorage) * $model->numberMonth,
                            'number_month' => $model->numberMonth,
                            'is_free_plan_type' => false,
                        ];
                        break;
                    case 'premium':
                        $model->maxUser = 0;
                        $packageInfo += [
                            'total_money' => ($planType[$model->plan_type]['fee_user'] + $planType[$model->plan_type]['fee_storage'] * $model->maxStorage) * $model->numberMonth,
                            'number_month' => $model->numberMonth,
                            'is_free_plan_type' => false,
                        ];
                        break;
                }
            } else {
                Yii::$app->session->setFlash('error', 'There was an error registering account.');
            }

            return $this->render('order_success', ['model' => $model, 'packageInfo' => $packageInfo]);
        }

        return $this->redirect('/');
    }

    /**
     * Logs in a user.
     *
     * @return mixed
     */
    public function actionLogin() {
        if (!\Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        } else {
            return $this->render('login', [
                        'model' => $model,
            ]);
        }
    }

    /**
     * Logs out the current user.
     *
     * @return mixed
     */
    public function actionLogout() {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    /**
     * Displays contact page.
     *
     * @return mixed
     */
    public function actionContact() {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->add()) {
                Yii::$app->session->setFlash('success', Yii::t('frontend', 'Thank you for contacting us. We will respond to you as soon as possible'));
            } else {
                Yii::$app->session->setFlash('error', Yii::t('common', 'There was an error sending email'));
            }

            return $this->refresh();
        } else {
            return $this->render('contact', [
                        'model' => $model,
            ]);
        }
    }

    /**
     * Displays about page.
     *
     * @return mixed
     */
    public function actionAbout() {
        return $this->render('about');
    }

    /**
     * Displays about page.
     */
    public function actionTerm() {
        return $this->render('term');
    }

    /**
     * Signs user up.
     *
     * @return mixed
     */
    public function actionSignup() {
        $model = new SignupForm();
        if ($model->load(Yii::$app->request->post())) {
            if ($user = $model->signup()) {
                if (Yii::$app->getUser()->login($user)) {
                    return $this->goHome();
                }
            }
        }

        return $this->render('signup', [
                    'model' => $model,
        ]);
    }

    /**
     * Requests password reset.
     *
     * @return mixed
     */
    public function actionRequestPasswordReset() {
        $model = new PasswordResetRequestForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail()) {
                Yii::$app->session->setFlash('success', 'Check your email for further instructions.');

                return $this->goHome();
            } else {
                Yii::$app->session->setFlash('error', 'Sorry, we are unable to reset password for email provided.');
            }
        }

        return $this->render('requestPasswordResetToken', [
                    'model' => $model,
        ]);
    }

    /**
     * Resets password.
     *
     * @param string $token
     * @return mixed
     * @throws BadRequestHttpException
     */
    public function actionResetPassword($token) {
        try {
            $model = new ResetPasswordForm($token);
        } catch (InvalidParamException $e) {
            throw new BadRequestHttpException($e->getMessage());
        }

        if ($model->load(Yii::$app->request->post()) && $model->validate() && $model->resetPassword()) {
            Yii::$app->session->setFlash('success', 'New password was saved.');

            return $this->goHome();
        }

        return $this->render('resetPassword', [
                    'model' => $model,
        ]);
    }

}
