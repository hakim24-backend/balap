<?php
use common\models\Setkelas;    
?>

<aside class="main-sidebar">

    <section class="sidebar">

        <!-- Sidebar user panel -->
        <div class="user-panel">
            <div class="pull-left image">
                <img src="<?= $directoryAsset ?>/img/user2-160x160.jpg" class="img-circle" alt="User Image"/>
            </div>
            <div class="pull-left info">
                <p>Admin</p>

                <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
            </div>
        </div>

        <?= dmstr\widgets\Menu::widget(
            [
                'options' => ['class' => 'sidebar-menu tree', 'data-widget'=> 'tree'],
                'items' => [
                    ['label' => 'Menu Race Event', 'options' => ['class' => 'header']],
                    ['label' => 'Master Bracket', 'icon' => 'bar-chart', 'url' => ['/bracket']],
                    ['label' => 'Master Jadwal', 'icon' => 'calendar', 'url' => ['/jadwal']],
                    ['label' => 'Master Gallery', 'icon' => 'picture-o', 'url' => ['/gallery']],
                    ['label' => 'Master Sponsor', 'icon' => 'usd', 'url' => ['/sponsor']],
                    [
                        'label' => 'Master Kelas',
                        'icon' => 'bars',
                        'url' => '#',
                        'items' => [
                            ['label' => 'Semua Kelas', 'icon' => 'dot-circle-o', 'url' => ['/kelas'],],
                            ['label' => 'Set Per Kelas', 'icon' => 'dot-circle-o', 'url' => ['/set-kelas'],],
                        ],
                    ],
                    [
                        'label' => 'Master HEAT',
                        'icon' => 'automobile',
                        'url' => '#',
                        'items' => [
                            ['label' => 'HEAT 1', 'icon' => 'dot-circle-o', 'url' => ['/het-one'],],
                            ['label' => 'HEAT 2', 'icon' => 'dot-circle-o', 'url' => ['/het-two'],],
                        ],
                    ],
                    ['label' => 'Master Artikel', 'icon' => 'file-text-o', 'url' => ['/artikel']],
                ],
            ]
        ) ?>

    </section>

</aside>
