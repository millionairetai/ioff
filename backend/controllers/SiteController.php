<?php

namespace backend\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use backend\models\LoginForm;
use common\models\Invoice;
use common\models\Company;
use yii\filters\VerbFilter;
use yii\web\View;
use yii\base\Application;

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
                'rules' => [
                    [
                        'actions' => ['login', 'error'],
                        'allow' => true,
                    ],
                    [
                        'actions' => ['logout', 'index'],
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
        $exception = Yii::$app->errorHandler->exception;
        if ($exception !== null) {
            if (Yii::$app->errorHandler->exception->statusCode == 404) {
                return [
                    'error' => [
                        'class' => 'backend\controllers\NotAction',
                    ],
                ];
            }
        }
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
        ];
    }

    public function actionIndex() {
        $dataDashboard = [];
        //Get revenue in month
        $dataDashboard['total_revenue_in_month'] = Yii::$app->formatter->asCurrency(Invoice::getRevenueInMonth());
        //Get increase percent
        $previousMonthRevenue = Invoice::getPreviousMonthRevenue();
        if ($dataDashboard['total_revenue_in_month']) {
            $dataDashboard['increase_percent'] = 0;
        }
        else {
            $dataDashboard['increase_percent'] = Yii::$app->formatter->asPercent(
                ($dataDashboard['total_revenue_in_month'] - Invoice::getPreviousMonthRevenue()) / ($dataDashboard['total_revenue_in_month']));
        }
        
        $previousMonthRevenue = Invoice::getPreviousMonthRevenue();
        $previousMonthRevenue = !empty($previousMonthRevenue) ? $previousMonthRevenue : 0;

        //Get info company.
        $company = Company::getCompanyEachPlanType();
        $dataDashboard['total_free_company'] = !empty($company['free']['total']) ? $company['free']['total'] : 0;
        $dataDashboard['total_standard_company'] = !empty($company['standard']['total']) ? $company['standard']['total'] : 0;
        $dataDashboard['total_premium_company'] = !empty($company['premium']['total']) ? $company['premium']['total'] : 0;
        
        //Get total size of database iofficez.
        $db = Yii::$app->getDb();
        $dbName = $this->getDsnAttribute('dbname', $db->dsn);
        $dataDashboard['used_storage_database'] = Company::getTotalDatabaseSize($dbName);
        $dataDashboard['used_storage_database'] = $dataDashboard['used_storage_database'][0]['db_size'];
        $dataDashboard['used_storage_file'] = Yii::$app->formatter->asDecimal(Company::getSumTotalStorage() / 1048576, 2);
        $dataDashboard['percent_used_storage'] = Yii::$app->formatter->asPercent($dataDashboard['used_storage_database'] + $dataDashboard['used_storage_file']) / Yii::$app->params['total_disk'];
        $dataDashboard['percent_used_storage'] = Yii::$app->formatter->asDecimal(($dataDashboard['used_storage_database'] + $dataDashboard['used_storage_file']) / Yii::$app->params['total_disk']);
        //Get revenue per month
        $dataDashboard['revenue_per_month'] = Invoice::getRevenuePerMonth();
        if (!empty($dataDashboard['revenue_per_month'])) {
            foreach ($dataDashboard['revenue_per_month'] as $item) {
                $dataDashboard['revenue_per_month']['labels'][] = Yii::t('common', 'month') . ' ' . $item['month'];
                $dataDashboard['revenue_per_month']['data'][] = $item['total_money'];
            }
        } else {
            $dataDashboard['revenue_per_month']['labels'] = [];
            $dataDashboard['revenue_per_month']['data'] = [];
        }

        $dataDashboard['staff_saling_revenue'] = Invoice::getRevenuePerEmployee();
        if (!empty($dataDashboard['staff_saling_revenue'])) {
            foreach ($dataDashboard['staff_saling_revenue'] as $item) {
                $dataDashboard['staff_saling_revenue']['labels'][] = $item['staff_name'];
                $dataDashboard['staff_saling_revenue']['data'][] = $item['total_money'];
            }
        } else {
            $dataDashboard['staff_saling_revenue']['labels'] = [];
            $dataDashboard['staff_saling_revenue']['data'] = [];
        }

        //Get duedate company for right bar.
        $dataDashboard['duedate_company'] = Company::getExpiredCompany();
        foreach ($dataDashboard['duedate_company'] as &$item) {
            $item['expired_date'] = Yii::$app->formatter->asDate($item['expired_date']);
        }
        
        //Get recently company for right bar.
        $dataDashboard['recently_company'] = Company::getRecentCompany();
        foreach ($dataDashboard['recently_company'] as &$item) {
            $item['company_datetime_created'] = Yii::$app->formatter->asDate($item['company_datetime_created']);
        }
        
        $dashboard = [
            'header' => [
                'total_new_company' => $dataDashboard['total_free_company'] + $dataDashboard['total_standard_company'] + $dataDashboard['total_premium_company'],
                'total_revenue_in_month' => $dataDashboard['total_revenue_in_month'],
                'increase_percent' => $dataDashboard['increase_percent'],
            ],
            'company_overview' => [
                'total_disk' => Yii::$app->params['total_disk'],
                'used_total_storage' => Yii::$app->formatter->asDecimal($dataDashboard['used_storage_database'] + $dataDashboard['used_storage_file'], 2),
                'percent_used_storage' => $dataDashboard['percent_used_storage'],
                'used_storage_database' => Yii::$app->formatter->asDecimal($dataDashboard['used_storage_database'], 2),
                'used_storage_file' => $dataDashboard['used_storage_file'],
                'total_company' => $dataDashboard['total_free_company'] + $dataDashboard['total_standard_company'] + $dataDashboard['total_premium_company'],
                'total_free_company' => $dataDashboard['total_free_company'],
                'total_standard_company' => $dataDashboard['total_standard_company'],
                'total_premium_company' => $dataDashboard['total_premium_company'],
                'total_user' => \common\models\Employee::getTotalEmployee()
            ],
            'revenue_per_month' => [
                'labels' => json_encode($dataDashboard['revenue_per_month']['labels']),
                'datasets' =>
                json_encode([
                    'label' => Yii::t('common', 'Revenue'),
                    'backgroundColor' => "#00a65a",
                    'data' => $dataDashboard['revenue_per_month']['data']
                ])
            ],
            'staff_saling_revenue' => [
                'labels' => json_encode($dataDashboard['staff_saling_revenue']['labels']),
                'datasets' =>
                json_encode([
                    'label' => Yii::t('common', 'Revenue'),
                    'backgroundColor' => "#00a65a",
                    'data' => $dataDashboard['staff_saling_revenue']['data']
                ])
            ],
            'right_bar_company' => [
                'recently_company' => $dataDashboard['recently_company'],
                'duedate_company' => $dataDashboard['duedate_company']
            ]
        ];

        return $this->render('index', ['dashboard' => $dashboard]);
    }

    private function getDsnAttribute($name, $dsn) {
        if (preg_match('/' . $name . '=([^;]*)/', $dsn, $match)) {
            return $match[1];
        } else {
            return null;
        }
    }

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

    public function actionLogout() {
        Yii::$app->user->logout();

        return $this->goHome();
    }

}
