<div class="page-header">
    <h1>Информация о системе</h1>
</div>

<table class="table table-striped table-bordered">
    <tr>
    	<td width="40%">Версия PHP</td>
    	<td width="60%"><?php echo phpversion() ?></td>
    </tr>
    <tr>
    	<td>Версия MySQL</td>
    	<td><?php echo $this->db->platform() ?> - <?php echo $this->db->version() ?></td>
    </tr>
    <tr>
    	<td>Register_globals</td>
    	<td><?php echo (ini_get ('register_globals') ? '<font color="red">Вкл</font>' : '<font color="green">Выкл</font>') ?></td>
    </tr>
    <tr>
    	<td>Memory_limit</td>
    	<td><?php echo ini_get ('memory_limit') ?></td>
    </tr>
    <tr>
    	<td>Библиотека GD</td>
    	<td><?php $gd = gd_info (); echo $gd['GD Version'] ?></td>
    </tr>
    <tr>
    	<td>Размер БД</td>
    	<td><?php echo $length_bd ?></td>
    </tr>
    <tr>
    	<td>Размер Кэша <!-- <a class="clear-cache">очистить</a> --></td>
    	<td><?php echo $cache_size ?></td>
    </tr>
</table>

<div class="page-header">
    <h1>Информация о сайте</h1>
</div>

<script type="text/javascript">
$(function(){
    chart1 = new Highcharts.Chart({
        chart: {
            renderTo: 'container_chart',
            type: 'area'
        },
        title: {
            text: 'График регистраций'
        },
        credits: {
            enabled: false
        },
        xAxis: {
            categories: <?php echo $reg_data_time ?> // Даты
        },
        yAxis: {
            title: {
               text: ''
            }
        },
        series: [{
            name: 'Регистраций',
            data: <?php echo $reg_data_count ?> // Кол-во регистраций
        }]
    });
})
</script>
<script type="text/javascript" src="/resources/libs/highcharts/highcharts.js"></script>
<script type="text/javascript" src="/resources/libs/highcharts/exporting.js"></script>

<div id="container_chart" style="height: 200px; overflow: hidden; margin: 0 0 40px 0;"></div>


<table class="table table-striped table-bordered">
    <tr>
    	<td width="40%">Всего регистраций</td>
    	<td width="60%"><?php echo $users_count_register ?></td>
    </tr>
    <tr>
    	<td>Неактивированных регистраций</td>
    	<td><?php echo $users_count_not_activated ?></td>
    </tr>
    <tr>
    	<td>За последнии 30 дней</td>
    	<td><?php echo $users_count_register_last_30_dey ?></td>
    </tr>
    <tr>
    	<td>За последнии 7 дней</td>
    	<td><?php echo $users_count_register_last_7_day ?></td>
    </tr>
    <tr>
    	<td>Забаненые</td>
    	<td><?php echo $users_count_banned ?></td>
    </tr>
</table>