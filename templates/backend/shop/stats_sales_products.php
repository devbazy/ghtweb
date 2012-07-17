<div class="page-header">
    <h1>Магазин <small>график проданных товаров</small></h1>
</div>

<?php if($this->session->flashdata('message')) { ?>
    <?php echo $this->session->flashdata('message') ?>
<?php } ?>

<!-- ADENA -->
<?php if(($key = array_search('Adena', $graph_sales_products['name'])) !== NULL) { ?>
    <b>Adena:</b> <?php echo number_format($graph_sales_products['count'][$key], 0, '', '.') ?>
    <?php
    unset($graph_sales_products['name'][$key], $graph_sales_products['item_id'][$key], $graph_sales_products['sum'][$key], $graph_sales_products['count'][$key]);
    ?>
<?php } ?>



<!-- ГРАФИК ПРОДАЖ -->
<script type="text/javascript">
$(function(){

    var chart = new Highcharts.Chart({
        chart: {
            renderTo: 'container_chart',
            type: 'spline'
        },
        title: {
            text: 'Проданные товары'
        },
        xAxis: {
            categories: <?php echo '["' . (isset($graph_sales_products['name']) ? implode('","', $graph_sales_products['name']) : '') . '"]' ?>
        },
        yAxis: {
            title: {
                text: ''
            }
        },
        tooltip: {
            crosshairs: true,
            shared: true
        },
        plotOptions: {
            spline: {
                marker: {
                    radius: 4,
                    lineColor: '#666666',
                    lineWidth: 1
                }
            }
        },
        series: [{
            name: 'Сумма',
            data: <?php echo '[' . (isset($graph_sales_products['sum']) ? implode(',', $graph_sales_products['sum']) : '') . ']' ?>

        }, {
            name: 'Кол-во',
            data: <?php echo '[' . (isset($graph_sales_products['count']) ? implode(',', $graph_sales_products['count']) : '') . ']' ?>
        }]
    });
})
</script>
<script type="text/javascript" src="/resources/libs/highcharts/highcharts.js"></script>
<script type="text/javascript" src="/resources/libs/highcharts/exporting.js"></script>

<div id="container_chart" style="height: 300px; overflow: hidden; margin: 0 0 40px 0;"></div>