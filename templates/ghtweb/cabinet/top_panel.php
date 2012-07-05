<div class="navbar navbar-fixed-top cabinet-top-bar">
    <div class="navbar-inner">
        <div class="container">
            
            <a data-target=".nav-collapse" data-toggle="collapse" class="btn btn-navbar">
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </a>
            <a class="brand"><?php echo $this->auth->get('login') ?></a>
            
            <div class="nav-collapse">
                <ul class="nav">
                    <li <?php echo get_segment_uri(1) == 'cabinet' && !get_segment_uri(2) ? 'class="active"' : '' ?>><?php echo anchor('cabinet', lang('Главная')) ?></li>
                    
                    <li <?php echo get_segment_uri(2) == 'change_password' ? 'class="active"' : '' ?>><?php echo anchor('cabinet/change_password', lang('Смена пароля')) ?></li>
                    
                    <li class="dropdown">
                        <a data-toggle="dropdown" class="dropdown-toggle" href="#"><?php echo lang('Игровые аккаунты') ?> <b class="caret"></b></a>
                        <ul class="dropdown-menu">
                            <li><?php echo anchor('cabinet/game_accounts', lang('Список аккаунтов')) ?></li>
                            <li><?php echo anchor('cabinet/create_game_account', lang('Создать новый аккаунт')) ?></li>
                            <?php if($this->config->item('snap_game_account_allow')) { ?>
                                <li><?php echo anchor('cabinet/snap_game_account', lang('Привязать игровой аккаунт к личному кабинету')) ?></li>
                            <?php } ?>
                        </ul>
                    </li>

                    <li class="dropdown">
                        <a data-toggle="dropdown" class="dropdown-toggle" href="#"><?php echo lang('Защита') ?> <b class="caret"></b></a>
                        <ul class="dropdown-menu">
                            <li><?php echo anchor('cabinet/secure', lang('Привязка к IP адресу')) ?></li>
                        </ul>
                    </li>

                    <?php if($this->config->item('shop_allow')) { ?>
                        <li <?php echo get_segment_uri(2) == 'shop' ? 'class="active"' : '' ?>><?php echo anchor('cabinet/shop', lang('Магазин')) ?></li>
                    <?php } ?>
                    
                    <li <?php echo get_segment_uri(2) == 'warehouse' ? 'class="active"' : '' ?>><?php echo anchor('cabinet/warehouse', lang('Склад')) ?></li>
                    
                    <li class="divider-vertical"></li>
                    
                    <?php if($this->_user_groups[$this->auth->get('group')]['allow_cp']) { ?>
                        <li><?php echo anchor('backend', lang('Админцентр'), 'target="_blank"') ?></li>
                    <?php } ?>
                    
                    <li><?php echo anchor('cabinet/logout', lang('Выход')) ?></li>
                </ul>
            </div><!-- /.nav-collapse -->
        </div>
    </div><!-- /navbar-inner -->
</div>