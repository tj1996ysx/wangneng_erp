</div>
</div>

<script type="text/javascript" src="/static/js/jquery.min.js"></script>
<script type="text/javascript" src="/static/js/bootstrap.min.js"></script>
<script type="text/javascript" src="/static/js/perfect-scrollbar.min.js"></script>
<script type="text/javascript" src="/static/js/main.min.js"></script>

<!--图表插件-->
<!--
<script type="text/javascript" src="/common/js/Chart.js"></script>
<script type="text/javascript">
$(document).ready(function(e) {
    var $dashChartBarsCnt  = jQuery( '.js-chartjs-bars' )[0].getContext( '2d' ),
        $dashChartLinesCnt = jQuery( '.js-chartjs-lines' )[0].getContext( '2d' );
    
    var $dashChartBarsData = {
        labels: ['周一', '周二', '周三', '周四', '周五', '周六', '周日'],
        datasets: [
            {
                label: '注册用户',
                borderWidth: 1,
                borderColor: 'rgba(0,0,0,0)',
                backgroundColor: 'rgba(51,202,185,0.5)',
                hoverBackgroundColor: "rgba(51,202,185,0.7)",
                hoverBorderColor: "rgba(0,0,0,0)",
                data: [2500, 1500, 1200, 3200, 4800, 3500, 1500]
            }
        ]
    };
    var $dashChartLinesData = {
        labels: ['2003', '2004', '2005', '2006', '2007', '2008', '2009', '2010', '2011', '2012', '2013', '2014'],
        datasets: [
            {
                label: '交易资金',
                data: [20, 25, 40, 30, 45, 40, 55, 40, 48, 40, 42, 50],
                borderColor: '#358ed7',
                backgroundColor: 'rgba(53, 142, 215, 0.175)',
                borderWidth: 1,
                fill: false,
                lineTension: 0.5
            }
        ]
    };
    
    new Chart($dashChartBarsCnt, {
        type: 'bar',
        data: $dashChartBarsData
    });
    
    var myLineChart = new Chart($dashChartLinesCnt, {
        type: 'line',
        data: $dashChartLinesData,
    });
});
</script>-->
</body>
<script>
    function layerOpen (layer,param,layer_btn_el,table){
        layer.open({
            type: (param.type)?(param.type):0,
            title: (param.title)?(param.title):"信息",
            maxmin: true,
            area: (param.area)?(param.area):['800px', '495px'],
            btn: ['确认', '取消'],
            content: (param.content)?(param.content):"确认操作吗?",
            yes: function (index, layero) {
                var body = layer.getChildFrame('body', index);//获取layer主体
                body.find("#"+layer_btn_el).click();
            },
            end: function () {
                table.reload({
                    where:{}
                });
            }
        })
    }
</script>
</html>