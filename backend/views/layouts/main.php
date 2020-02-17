<?php
use yii\helpers\Html;

/* @var $this \yii\web\View */
/* @var $content string */


if (Yii::$app->controller->action->id === 'login') { 
/**
 * Do not use this code in your template. Remove it. 
 * Instead, use the code  $this->layout = '//main-login'; in your controller.
 */
    echo $this->render(
        'main-login',
        ['content' => $content]
    );
} else {
    if (class_exists('backend\assets\AppAsset')) {
        backend\assets\AppAsset::register($this);
    } else {
        app\assets\AppAsset::register($this);
    }
    dmstr\web\AdminLteAsset::register($this);
    $directoryAsset = Yii::$app->assetManager->getPublishedUrl('@vendor/almasaeed2010/adminlte/dist');
    ?>
    <?php $this->beginPage() ?>
    <!DOCTYPE html>
    <html lang="<?= Yii::$app->language ?>">
    <head>
        <meta charset="<?= Yii::$app->charset ?>"/>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="url" content="<?= \yii\helpers\Url::home(true); ?>" />
        <?= Html::csrfMetaTags() ?>
        <!-- Font Awesome -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css">
        <!-- Ionicons -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">
        <link href='https://fonts.googleapis.com/css?family=Istok+Web:400,700' rel='stylesheet' type='text/css'>
        <link href='http://fonts.googleapis.com/css?family=Open+Sans:400,300,600' rel='stylesheet' type='text/css'>        
        <title><?= Html::encode($this->title) ?></title>
        <link rel="apple-touch-icon" sizes="57x57" href="<?= Yii::$app->request->hostInfo.'/images/favicon/apple-touch-icon-57x57.png' ?>">
        <link rel="apple-touch-icon" sizes="60x60" href="<?= Yii::$app->request->hostInfo.'/images/favicon/apple-touch-icon-60x60.png' ?>">
        <link rel="apple-touch-icon" sizes="72x72" href="<?= Yii::$app->request->hostInfo.'/images/favicon/apple-touch-icon-72x72.png' ?>">
        <link rel="apple-touch-icon" sizes="76x76" href="<?= Yii::$app->request->hostInfo.'/images/favicon/apple-touch-icon-76x76.png' ?>">
        <link rel="apple-touch-icon" sizes="114x114" href="<?= Yii::$app->request->hostInfo.'/images/favicon/apple-touch-icon-114x114.png' ?>">
        <link rel="apple-touch-icon" sizes="120x120" href="<?= Yii::$app->request->hostInfo.'/images/favicon/apple-touch-icon-120x120.png' ?>">
        <link rel="apple-touch-icon" sizes="144x144" href="<?= Yii::$app->request->hostInfo.'/images/favicon/apple-touch-icon-144x144.png' ?>">
        <link rel="apple-touch-icon" sizes="152x152" href="<?= Yii::$app->request->hostInfo.'/images/favicon/apple-touch-icon-152x152.png' ?>">
        <link rel="apple-touch-icon" sizes="180x180" href="<?= Yii::$app->request->hostInfo.'/images/favicon/apple-touch-icon-180x180.png' ?>">
        <link rel="icon" type="/images/png" href="/images/pharmacy.png" sizes="16x16" />
        <link rel="manifest" href="<?= Yii::$app->request->hostInfo.'/images/favicon/manifest.json' ?>">
        <link rel="mask-icon" href="<?= Yii::$app->request->hostInfo.'/images/favicon/safari-pinned-tab.svg' ?>" color="#d91b5c">
        <link src='/js/jquery.geocomplete.min.js'/>
            <?php $this->head() ?>
    </head>
    <body class="hold-transition sidebar-mini <?= \dmstr\helpers\AdminLteHelper::skinClass() ?>">
    <?php $this->beginBody() ?>
    <div class="wrapper">

        <?= $this->render(
            'header.php',
            ['directoryAsset' => $directoryAsset]
        ) ?>

        <?= $this->render(
            'left.php',
            ['directoryAsset' => $directoryAsset]
        )
        ?>

        <?= $this->render(
            'content.php',
            ['content' => $content, 'directoryAsset' => $directoryAsset]
        ) ?>

    </div>
        <div id="data-loading" style="background-color: rgba(255,255,255,0.7);position:fixed;left:0;top:0;right:0;bottom:0;z-index:999999;text-align: center;line-height:100vh;display:none;">
           <img src="<?= Yii::$app->params['frontendUrl'].'images/nirog-loader.gif' ?>" alt="Loading.." >
        </div>
    <?php $this->endBody() ?>
<script src="https://cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.11.2/moment.min.js"></script>
<script>
    (function(h,o,t,j,a,r){
        h.hj=h.hj||function(){(h.hj.q=h.hj.q||[]).push(arguments)};
        h._hjSettings={hjid:700675,hjsv:6};
        a=o.getElementsByTagName('head')[0];
        r=o.createElement('script');r.async=1;
        r.src=t+h._hjSettings.hjid+j+h._hjSettings.hjsv;
        a.appendChild(r);
    })(window,document,'https://static.hotjar.com/c/hotjar-','.js?sv=');
</script>
    </body>
    </html>
    <?php $this->endPage() ?>
<?php } ?>

