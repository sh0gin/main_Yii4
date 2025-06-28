<?php


namespace app\controllers;

use yii\web\Controller;

class AppController extends Controller
{

    public function printd($data)
    {
        print_r('<pre><p style="background-color: beige; color: maroon; padding: 10px; margin: 5px; border: 1px maroon solid;">');
        print_r($data);
        print_r('</p></pre>');
    }
}
