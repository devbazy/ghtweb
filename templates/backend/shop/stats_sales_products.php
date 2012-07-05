<div class="page-header">
    <h1>Магазин <small>график проданных товаров</small></h1>
</div>

<?php if($this->session->flashdata('message')) { ?>
    <?php echo $this->session->flashdata('message') ?>
<?php } ?>

<!-- ADENA -->
<?php if(($key = array_search('Adena', $graph_sales_products['name'])) !== NULL) { ?>
    <b>Adena:</b> <?php echo number_format($graph_sales_products['sum'][$key], 0, '', '.') ?>
    <?php
    unset($graph_sales_products['name'][$key], $graph_sales_products['item_id'][$key], $graph_sales_products['sum'][$key]);
    ?>
<?php } ?>



<!-- ГРАФИК ПРОДАЖ -->
<script type="text/javascript">
$(function(){
    
    chart1 = new Highcharts.Chart({
        chart: {
            renderTo: 'container_chart',
            type: 'area'
        },
        title: {
            text: 'График проданных товаров'
        },
        credits: {
            enabled: false
        },
        xAxis: {
            categories: <?php echo '["' . (isset($graph_sales_products['name']) ? implode('","', $graph_sales_products['name']) : '') . '"]' ?>
        },
        yAxis: {
            title: {
               text: ''
            }
        },
        series: [{
            name: 'Товары',
            data: <?php echo '[' . (isset($graph_sales_products['sum']) ? implode(',', $graph_sales_products['sum']) : '') . ']' ?>
        }]
    });
})
</script>
<script type="text/javascript" src="/resources/libs/highcharts/highcharts.js"></script>
<script type="text/javascript" src="/resources/libs/highcharts/exporting.js"></script>

<div id="container_chart" style="height: 300px; overflow: hidden; margin: 0 0 40px 0;"></div>