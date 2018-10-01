<aside class="main-sidebar">

    <section class="sidebar">

        <!-- Sidebar user panel -->
        <div class="user-panel">
            <div class="pull-left image">
                <img src="<?= $directoryAsset ?>/img/user2-160x160.jpg" class="img-circle" alt="User Image"/>
            </div>
            <div class="pull-left info">
                <p> <?= \Yii::$app->user->identity->username ?></p>

                <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
            </div>
        </div>

        <!-- search form -->
        <form action="#" method="get" class="sidebar-form">
            <div class="input-group">
                <input type="text" name="q" class="form-control" placeholder="Search..."/>
              <span class="input-group-btn">
                <button type='submit' name='search' id='search-btn' class="btn btn-flat"><i class="fa fa-search"></i>
                </button>
              </span>
            </div>
        </form>
        <!-- /.search form -->

        <?= dmstr\widgets\Menu::widget(
            [
                'options' => ['class' => 'sidebar-menu'],
                'items' => [
                    ['label' => 'Menu Yii2', 'options' => ['class' => 'header']],
                    ['label' => 'Gii', 'icon' => 'fa fa-gear', 'url' => ['/gii']],
                    ['label' => 'Debug', 'icon' => 'fa fa-gear', 'url' => ['/debug']],
                    ['label' => 'Войти', 'url' => ['site/login'], 'visible' => Yii::$app->user->isGuest],
                    ['label' => 'Контент', 'icon' => 'fa fa-database', 'url' => ['/content']],
                    [   'label' => 'Пользователи',
                        'icon' => 'fa fa-users',
                        'url' => '#',
                        'items'=> [
                            ['label'=>'Профили', 'icon'=> 'fa fa-user-circle-o','url' => ['/users/index'] ],
                            ['label'=>'Роли', 'icon'=> 'fa fa-user-circle-o','url' => ['/users/roles'] ],
                            ['label'=>'Права ролей', 'icon'=> 'fa fa-user-circle-o','url' => ['/users/permissions'] ],
                        ],


                    ],
                    [
                        'label' => 'Магазин',
                        'icon' => 'fa fa-shopping-basket',
                        'url' => '#',
                        'items' => [
                            ['label' => 'Товары', 'icon' => 'fa fa-shopping-cart', 'url' => ['/product']],
                            ['label' => 'Цены', 'icon' => 'fa fa-rub', 'url' => ['/price']],
                            ['label' => 'Доставка', 'icon' => 'fa fa-truck', 'url' => ['/delivery']],
                            ['label' => 'Заказы', 'icon' => 'fa fa-database', 'url' => ['/order']],
                            [   'label' => 'Настройки магазина',
                                'icon' => 'fa fa-wrench',
                                'url' => '#',
                                'items' => [
                                    ['label' => 'Свойства товара', 'icon' => 'fa fa-sliders', 'url' => ['/product-maintenance']],
                                ]
                            ]
                        ]
                    ],
                    [
                        'label' => 'Покупатели',
                        'icon' => 'fa fa-user',
                        'url' => '#',
                        'items' => [
                            ['label' => 'Типы покупателей', 'icon' => 'fa fa-group', 'url' => ['/buyers']],
                            ['label' => 'Корзины', 'icon' => 'fa fa-shopping-cart', 'url' => ['/basket']],

                        ]
                    ],
                    [
                        'label' => 'Настройки сайта',
                        'icon' => 'fa fa-tasks',
                        'url' => '#',
                        'items' => [
                            [   'label' => 'Контент отделы', 'icon' => 'fa fa-database', 'url' => ['/cell']],
                            [   'label' => 'Списки меню',
                                'icon' => 'fa fa-list',
                                'url' => '#',
                                'items' => [
                                    ['label' => 'Меню сайта', 'icon' => 'fa fa-circle-o', 'url' => ['/menus/index'],],
                                    ['label' => 'Пунты меню', 'icon' => 'fa fa-circle-o', 'url' => ['/menus/list-menu-item'],],
                                ]

                            ],
                            [   'label' => 'Страницы',
                                'icon' => 'fa fa-files-o',
                                'url' => '#',
                                'items' => [
                                    ['label' => 'Список страниц', 'icon' => 'fa fa-files-o', 'url' => ['/pages/index'],],
                                    ['label' => 'Структура страниц', 'icon' => 'fa fa-file-text-o', 'url' => ['/pages/structure'],],
                                ]

                            ],
                            [   'label' => 'Компоненты',
                                'icon' => 'fa fa-files-o',
                                'url' => '#',
                                'items' => [
                                    ['label' => 'Список компонентов', 'icon' => 'fa fa-files-o', 'url' => ['/components/index'],],
                                ]

                            ],
                            [   'label' => 'Шаблоны',
                                'icon' => 'fa fa-files-o',
                                'url' => '#',
                                'items' => [
                                    ['label' => 'Список шаблонов', 'icon' => 'fa fa-files-o', 'url' => ['/templates/index'],],
                                ]

                            ],
                            [   'label' => 'Параметры', 'icon' => 'fa fa-gear', 'url' => ['/main/settings'],],
                            [
                                'label' => 'Level One',
                                'icon' => 'fa fa-circle-o',
                                'url' => '#',
                                'items' => [
                                    ['label' => 'Level Two', 'icon' => 'fa fa-circle-o', 'url' => '#',],
                                    [
                                        'label' => 'Level Two',
                                        'icon' => 'fa fa-circle-o',
                                        'url' => '#',
                                        'items' => [
                                            ['label' => 'Level Three', 'icon' => 'fa fa-circle-o', 'url' => '#',],
                                            ['label' => 'Level Three', 'icon' => 'fa fa-circle-o', 'url' => '#',],
                                        ],
                                    ],
                                ],
                            ],
                        ],
                    ],
                ],
            ]
        ) ?>

    </section>

</aside>
