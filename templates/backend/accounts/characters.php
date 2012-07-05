<div class="page-header">
    <h1>Аккаунты <small>список персонажей на аккаунте</small> <span class="label label-info"><?php echo get_segment_uri(5) ?></span></h1>
</div>

<?php if($this->session->flashdata('message')) { ?>
    <?php echo $this->session->flashdata('message') ?>
<?php } ?>

<table class="table table-striped table-bordered">
    <tr>
        <th width="3%">#</th>
        <th width="50%">Имя персонажа</th>
        <th width="11%">Уровень</th>
        <th width="21%">Класс</th>
        <th width="11%">Online</th>
        <th width="4%"></th>
    </tr>
    <?php if($content) { ?>
        <?php foreach($content as $i => $row) { ?>
            <tr>
                <td><?php echo (++$i) ?></td>
            	<td><?php echo $row['char_name'] ?></td>
            	<td><?php echo $row['level'] ?></td>
            	<td><?php echo get_class_name_by_id($row['classid']) ?></td>
                <td><?php echo ($row['online'] ? '<span class="green">online</span>' : '<span class="red">offline</span>') ?></td>
                <td>
                    <div class="btn-toolbar">
                        <div class="btn-group">
                            <button data-toggle="dropdown" class="btn btn-mini dropdown-toggle"><span class="caret"></span></button>
                            <ul class="dropdown-menu" style="z-index: 999;">
                                <li><a>Coming soon ...</a></li>
                                <!-- <li><a href="/backend/characters/view/<?php echo get_segment_uri(4) ?>/<?php echo $row[$char_id] ?>/"><i class="icon-search"></i> Просмотр данных</a></li>
                                <li><a href="/backend/characters/intentar/<?php echo get_segment_uri(4) ?>/<?php echo $row[$char_id] ?>/"><i class="icon-th"></i> Просмотр вещей</a></li> -->
                            </ul>
                        </div><!-- /btn-group -->
                    </div>
                </td>
            </tr>
        <?php } ?>
    <?php } else { ?>
        <tr>
        	<td colspan="6">Персонажей нет</td>
        </tr>
    <?php } ?>
</table>