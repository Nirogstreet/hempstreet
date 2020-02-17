<?php
use yii\helpers\Html;
?>
<header class="main-header">
    <a href="/" class="logo">
        <span class="logo-mini"><img src="/images/pharmacy.png"></span><span class="logo-lg"><img src="/images/image_header.png"></span></a>
    <nav class="navbar navbar-static-top" role="navigation">
        <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
            <span class="sr-only">Toggle navigation</span>
        </a>
        <div class="navbar-custom-menu">
            <ul class="nav navbar-nav">             
                <li class="dropdown user user-menu">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        <img src="/images/user2-160x160.jpg" class="user-image" alt="User Image"/>
                        <?php $user = backend\models\BackendUser::findOne(['id' => Yii::$app->user->id]); ?>
                        <span class="hidden-xs"><?= ucfirst(isset($user->username)?$user->username:''); ?></span>
                    </a>
                    <ul class="dropdown-menu">
                        <!-- User image -->
                        <li class="user-header">
                            <img src="/images/user2-160x160.jpg" class="img-circle"
                                 alt="User Image"/>
                            <p>
                                <?= ucfirst(isset($user->username)?$user->username:''); ?>
<!--                                <small>Member since Nov. 2012</small>-->
                            </p>
                        </li> 
                        <li class="user-footer">
                            <div class="pull-left">
<!--                                <a href="#" class="btn btn-default btn-flat">Profile</a>-->
                            </div>
                            <div class="pull-right">
                                <?= Html::a(
                                    'Sign out',
                                    ['/site/logout'],
                                    ['data-method' => 'post', 'class' => 'btn btn-default btn-flat']
                                ) ?>
                            </div>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>
    </nav>
</header>
