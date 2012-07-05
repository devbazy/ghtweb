<div class="content-box left">
    <div class="content-box-header">
        <h3>Группы настроек</h3>
    </div>
    <div class="content-box-content">
        
        <?php
        if($content)
        {
            echo '<ul class="settings-group">';
            
            foreach($content as $row)
            {
                echo '<li><a href="/backend/settings/group/' . $row['id'] . '/">' . $row['title'] . '</a><p>' . $row['description'] . '</p></li>';
            }
            
            echo '</ul>';
        }
        else
        {
            echo lang('Данных нет');
        }
        ?>
        
    </div>
</div>
