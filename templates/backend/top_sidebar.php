<div class="navbar navbar-fixed-top cabinet-top-bar">
    <div class="navbar-inner">
        <div class="container">
            <a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </a>
            <a class="brand right"><?php echo VERSION ?></a>
            
            <div class="nav-collapse">
                <ul class="nav">
                    <li <?php echo (!get_segment_uri(2) ? 'class="active"' : '') ?>><a href="/backend/">Главная</a></li>
                    
                    <li class="dropdown <?php echo (get_segment_uri(2) == 'news' ? 'active' : '') ?>">
                        <a class="dropdown-toggle" data-toggle="dropdown">Новости <b class="caret"></b></a>
                        <ul class="dropdown-menu">
                            <li><a href="/backend/news/">Просмотр</a></li>
                            <li><a href="/backend/news/add/">Добавить</a></li>
                        </ul>
                    </li>

                    <li class="dropdown <?php echo (get_segment_uri(2) == 'pages' ? 'active' : '') ?>">
                        <a class="dropdown-toggle" data-toggle="dropdown">Страницы <b class="caret"></b></a>
                        <ul class="dropdown-menu">
                            <li><a href="/backend/pages/">Просмотр</a></li>
                            <li><a href="/backend/pages/add/">Добавить</a></li>
                        </ul>
                    </li>
                    
                    <li class="dropdown <?php echo (get_segment_uri(2) == 'settings' ? 'active' : '') ?>">
                        <a class="dropdown-toggle" data-toggle="dropdown">Настройки <b class="caret"></b></a>
                        <ul class="dropdown-menu">
                            <?php foreach($settings_group as $id => $name) { ?>
                                <li><a href="/backend/settings/group/<?php echo $id ?>/"><?php echo $name ?></a></li>
                            <?php } ?>
                        </ul>
                    </li>
                    
                    <li class="dropdown <?php echo (get_segment_uri(2) == 'users' ? 'active' : '') ?>">
                        <a class="dropdown-toggle" data-toggle="dropdown">Пользователи <b class="caret"></b></a>
                        <ul class="dropdown-menu">
                            <li><a href="/backend/users/">Просмотр</a></li>
                            <li><a href="/backend/users/add/">Добавить</a></li>
                        </ul>
                    </li>
                    
                    <li class="dropdown <?php echo (get_segment_uri(2) == 'shop' ? 'active' : '') ?>">
                        <a class="dropdown-toggle" data-toggle="dropdown">Магазин <b class="caret"></b></a>
                        <ul class="dropdown-menu">
                            <li class="nav-header">Товары</li>
                            <li><a href="/backend/shop/">Просмотр</a></li>
                            <li><a href="/backend/shop/add/">Добавить</a></li>
                            <li class="divider"></li>
                            <li class="nav-header">Разделы товаров</li>
                            <li><a href="/backend/shop_categories/">Просмотр</a></li>
                            <li><a href="/backend/shop_categories/add/">Добавить</a></li>
                            <li class="divider"></li>
                            <li class="nav-header">Статистика</li>
                            <li><a href="/backend/shop/stats/">Просмотр</a></li>
                            <li><a href="/backend/shop/stats_sales_products/">График проданных товаров</a></li>
                        </ul>
                    </li>
                    
                    <!-- LINEAGE -->
                    <li class="dropdown">
                        <a class="dropdown-toggle" data-toggle="dropdown">Lineage2 <b class="caret"></b></a>
                        <ul class="dropdown-menu">
                            <li class="nav-header">Игровые сервера</li>
                            <li><a href="/backend/servers/">Просмотр</a></li>
                            <li><a href="/backend/servers/add/">Добавить</a></li>
                            
                            <li class="divider"></li>
                            <li class="nav-header">Логин сервера</li>
                            <li><a href="/backend/logins/">Просмотр</a></li>
                            <li><a href="/backend/logins/add/">Добавить</a></li>

                            <li class="divider"></li>
                            <li class="nav-header">Аккаунты</li>
                            <li><a href="/backend/accounts/">Просмотр</a></li>
                            
                            <li class="divider"></li>
                            <li class="nav-header">Персонажи</li>
                            <li><a href="/backend/characters/">Просмотр</a></li>
                            
                            <!-- <li class="divider"></li>
                            <li class="nav-header">Разное</li>
                            <li><a href="/backend/online_map/">Online карта</a></li> -->
                            
                        </ul>
                    </li>
                    
                    <li <?php echo (get_segment_uri(2) == 'telnet' ? 'class="active"' : '') ?>><a href="/backend/telnet/">Telnet</a></li>
                    <li><a href="/">На сайт</a></li>

               </ul>
            </div><!-- /.nav-collapse -->
        </div>
    </div><!-- /navbar-inner -->
</div>