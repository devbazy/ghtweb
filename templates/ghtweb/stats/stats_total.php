<script type="text/javascript">
var chart;
$(document).ready(function() {

    
	var colors = Highcharts.getOptions().colors;
    
    // Статистика по рейтам
    var data = [{
        y: <?php echo $rates['exp'] ?>,
        color: colors[7],
    }, {
        y: <?php echo $rates['sp'] ?>,
        color: colors[6],
    }, {
        y: <?php echo $rates['adena'] ?>,
        color: colors[5],
    }, {
        y: <?php echo $rates['items'] ?>,
        color: colors[4],
    }, {
        y: <?php echo $rates['spoil'] ?>,
        color: colors[3],
    }, {
        y: <?php echo $rates['q_drop'] ?>,
        color: colors[2],
    }, {
        y: <?php echo $rates['rb'] ?>,
        color: colors[1],
    }, {
        y: <?php echo $rates['erb'] ?>,
        color: colors[0],
    }];
    chart = new Highcharts.Chart({
        chart: {
            renderTo: 'rates_charts',
            type: 'column'
        },
        title: {
            text: '<?php echo lang('Статистика по рейтам') ?>'
        },
        credits: {
            enabled: false
        },
        xAxis: {
            categories: ['Exp', 'Sp', 'Adena', 'Items', 'Spoil', 'Quest Drop', 'Quest Reward', 'Drop Raid Boss', 'Drop Epic Raid Boss']
        },
        yAxis: {
            title: {
                text: null
            }
        },
        plotOptions: {
            column: {
                cursor: 'pointer',
                showInLegend: false,
            },
        },
        tooltip: {
            formatter: function() {
                var point = this.point,
                s = this.x +':<b>x'+ this.y +'</b>';
                return s;
            }
        },
        series: [{
            data: data,
            //color: 'white'
        }],
    });
    
    // Статистика online
    chart = new Highcharts.Chart({
		chart: {
			renderTo: 'online_charts',
			plotBackgroundColor: null,
			plotBorderWidth: null,
			plotShadow: false
		},
		title: {
			text: '<?php echo lang('Общий Online') ?>'
		},
        credits: {
            enabled: false
        },
		tooltip: {
			formatter: function() {
				return '<b>' + this.point.name + '</b>: ' + this.y;
			}
		},
		plotOptions: {
			pie: {
				allowPointSelect: true,
                connectNulls: false,
				cursor: 'pointer',
				dataLabels: {
					enabled: false
				},
				showInLegend: true
			}
		},
		series: [{
			type: 'pie',
			data: [
                <?php $count = count($race_list); foreach($race_list as $key => $row) { ?>
                    ['<?php echo get_race_name_by_id($row['race']) ?>', <?php echo $row['count'] ?>] <?php echo ($key == ($count-1) ? '' : ',') ?>
                <?php } ?>
			]
		}]
	});
    
    
    // Соотношение Рас
    chart = new Highcharts.Chart({
		chart: {
			renderTo: 'classes_charts'
		},
		title: {
			text: '<?php echo lang('Соотношение Рас') ?>'
		},
        credits: {
            enabled: false
        },
		tooltip: {
			formatter: function() {
				return '<b>' + this.point.name + '</b>: ' + this.y;
			}
		},
		plotOptions: {
			pie: {
				allowPointSelect: true,
				cursor: 'pointer',
				dataLabels: {
					enabled: false,
                    color: '#333',
                    formatter: function() {
                        return this.point.name +': '+ this.y;
                    } 
				},
				showInLegend: true
			}
		},
		series: [{
			type: 'pie',
			//name: 'Browser share',
			data: [
                ['<?php echo lang('Люди') ?>',         <?php echo $race['count']['human'] ?>   ],
			    ['<?php echo lang('Эльфы') ?>',        <?php echo $race['count']['elf'] ?>     ],
				['<?php echo lang('Тёмные Эльфы') ?>', <?php echo $race['count']['dark_elf'] ?>],
				['<?php echo lang('Орки') ?>',         <?php echo $race['count']['orc'] ?>     ],
				['<?php echo lang('Гномы') ?>',        <?php echo $race['count']['dwarf'] ?>   ],
				['<?php echo lang('Камаели') ?>',      <?php echo $race['count']['kamael'] ?>  ]
			]
		}]
	});
    
    
    // Общая статистика
    var data = [{
        y: <?php echo $stats['accounts'] ?>,
        color: colors[2],
    }, {
        y: <?php echo $stats['characters'] ?>,
        color: colors[0],
    }, {
        y: <?php echo $stats['clans'] ?>,
        color: colors[5],
    }, {
        y: <?php echo $stats['men'] ?>,
        color: colors[3],
    }, {
        y: <?php echo $stats['women'] ?>,
        color: colors[1],
    }];
    chart = new Highcharts.Chart({
        chart: {
            renderTo: 'total_charts',
            type: 'column'
        },
        title: {
            text: '<?php echo lang('Общая статистика') ?>'
        },
        credits: {
            enabled: false
        },
        xAxis: {
            categories: ['<?php echo lang('Аккаунты') ?>', '<?php echo lang('Персонажи') ?>', '<?php echo lang('Кланы') ?>', '<?php echo lang('Мужчин') ?>', '<?php echo lang('Женщин') ?>']
        },
        yAxis: {
            title: {
                text: null
            }
        },
        plotOptions: {
            column: {
                cursor: 'pointer',
                showInLegend: false,
            },
        },
        tooltip: {
            formatter: function() {
                var point = this.point,
                s = this.x +':<b>'+ this.y +'</b>';
                return s;
            }
        },
        series: [{
            data: data,
            //color: 'white'
        }],
    });    
});
</script>


<!-- Уровни -->
<!-- <div id="levels_charts" style="height: 350px; width: 320px; overflow: hidden; margin: 0 0 20px 0;" class="left"></div> -->

<!-- Online -->
<div id="online_charts" style="height: 350px; width: 320px; overflow: hidden; margin: 0 0 20px 0;" class="left"></div>

<!-- Классы -->
<div id="classes_charts" style="height: 350px; width: 320px; overflow: hidden; margin: 0 0 20px 0;" class="right"></div>

<div class="clear"></div>

<!-- Рейты -->
<div id="rates_charts" style="height: 350px; width: 658px; overflow: hidden; margin: 0 0 20px 0;" class="right"></div>

<!-- Общая -->
<div id="total_charts" style="height: 350px; width: 658px; overflow: hidden; margin: 0 0 20px 0;" class="right"></div>

<script type="text/javascript" src="/resources/libs/highcharts/highstock.js"></script>