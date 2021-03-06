<?php
namespace common\components\atwho;

use yii;
use yii\web\AssetBundle;

class AtWhoAsset extends AssetBundle {

    /**
     * @var
     */
    public $sourcePath;

    /**
     * @var array
     */
    public $js = [
        'jquery.caret-0.2.2.min.js',
        'jquery.atwho-1.4.1.min.js',
        //'xregexp-3.0.min.js',
    ];

    /**
     * @var array
     */
    public $css = [
        'jquery.atwho-1.4.1.css'
    ];


    public $depends = [
        'yii\web\JqueryAsset',
    ];

    public function init() {
        parent::init();
        if($this->sourcePath == null)
            $this->sourcePath = __DIR__ . DIRECTORY_SEPARATOR . 'assets';
    }

}
