<?php
namespace member\controllers;

use Yii;
use yii\web\Controller;
use common\models\LoginForm;
use yii\helpers\Url;

/**
 * index controller
 */
class IndexController extends Controller
{
    

    public function actionLogin()
    {
        if (!\Yii::$app->user->isGuest) {
            return $this->redirect('/');
        }
        $this->layout = "login";
        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->redirect('/');
        } else {
            return $this->render('login', [
                'model' => $model,
            ]);
        }
    }
    
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->redirect('/');
    }
    
    /* ------------------ minify js ------------------------------- */
    public function actionMinify(){
        $this->actionMinifyControllers();
        $this->actionMinifyDirectives();
        $this->actionMinifyServices();
        $this->actionMinifyFilters();
        die;
    }
    
    /**
     * 
     */
    protected function actionMinifyControllers() {
        $dir = dirname(dirname(__FILE__)) . "/web/app/controllers";
        $file_js = $this->getAllFIlejs($dir);
        file_put_contents($dir . "/../minify/minify_controller.js", '');
        foreach ($file_js as $file) {
            $js = file_get_contents($dir . "/" . $file);
            file_put_contents($dir . "/../minify/minify_controller.js", $js, FILE_APPEND);
        }
        
    }
    
    /*
     * 
     */
    protected function actionMinifyServices() {
        $dir = dirname(dirname(__FILE__)) . "/web/app/services";
        $file_js = $this->getAllFIlejs($dir);
        file_put_contents($dir . "/../minify/minify_service.js", '');
        foreach ($file_js as $file) {
            $js = file_get_contents($dir . "/" . $file);
            file_put_contents($dir . "/../minify/minify_service.js", $js, FILE_APPEND);
        }
        
    }

    /*
     * 
     */
    protected function actionMinifyDirectives() {
        $dir = dirname(dirname(__FILE__)) . "/web/app/directives";
        $file_js = $this->getAllFIlejs($dir);
        file_put_contents($dir . "/../minify/minify_directive.js", '');
        foreach ($file_js as $file) {
            $js = file_get_contents($dir . "/" . $file);
            file_put_contents($dir . "/../minify/minify_directive.js", $js, FILE_APPEND);
        }
        
    }
    /*
     * 
     */
    protected function actionMinifyFilters() {
        $dir = dirname(dirname(__FILE__)) . "/web/app/filters";
        $file_js = $this->getAllFIlejs($dir);
        file_put_contents($dir . "/../minify/minify_filter.js", '');
        foreach ($file_js as $file) {
            $js = file_get_contents($dir . "/" . $file);
            file_put_contents($dir . "/../minify/minify_filter.js", $js, FILE_APPEND);
        }
        
    }
    

    /*
     * 
     */
    protected function getAllFIlejs($dir) {
        $file_js = [];
        $files = scandir($dir);
        foreach ($files as $file) {
            $info = pathinfo($file);

            if ($file != "." && $file != ".." && is_dir($dir . '/' . $file)) {
                $child = scandir($dir . '/' . $file);
                foreach ($child as $chi) {
                    $info = pathinfo($chi);
                    if (isset($info['extension']) && $info['extension'] == "js") {
                        $file_js[] = $file . "/" . $chi;
                    }
                }
            } else {
                if (isset($info['extension']) && $info['extension'] == "js") {
                    $file_js[] = $file;
                }
            }
        }
        //echo "<pre>";var_dump($file_js);die;
        return $file_js;
    }

    
}
