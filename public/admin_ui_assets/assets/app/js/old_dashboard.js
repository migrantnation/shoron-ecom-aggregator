//== Class definition
var Dashboard = function () {

    //== Sparkline Chart helper function
    var _initSparklineChart = function (src, data, lbl, color, border, label, kpi_value) {
        if (src.length == 0) {
            return;
        }

        var config = {
            type: 'line',
            data: {
                labels: lbl,
                datasets: [{
                    label: "" + label,
                    //backgroundColor: ['rgba(113, 106, 202, 0)'],
                    borderColor: color,
                    borderWidth: border,
                    radius: 0,
                    pointHoverRadius: 4,
                    pointHoverBorderWidth: 12,
                    pointBackgroundColor: Chart.helpers.color('#000000').alpha(0).rgbString(),
                    pointBorderColor: Chart.helpers.color('#000000').alpha(0).rgbString(),
                    pointHoverBackgroundColor: mUtil.getColor('danger'),
                    pointHoverBorderColor: Chart.helpers.color('#000000').alpha(0.1).rgbString(),
                    fill: false,
                    data: data,
                }, {
                    label: "" + label,
                    //backgroundColor: ['rgba(113, 106, 202, 0)'],
                    borderColor: color,
                    borderWidth: border,
                    radius: 0,
                    pointHoverRadius: 4,
                    pointHoverBorderWidth: 12,
                    pointBackgroundColor: Chart.helpers.color('#000000').alpha(0).rgbString(),
                    pointBorderColor: Chart.helpers.color('#000000').alpha(0).rgbString(),
                    pointHoverBackgroundColor: mUtil.getColor('danger'),
                    pointHoverBorderColor: Chart.helpers.color('#000000').alpha(0.1).rgbString(),
                    fill: false,
                    data: kpi_value,
                }]
            },
            options: {
                title: {
                    display: true,
                },
                tooltips: {
                    mode: 'index',
                    intersect: false,
                },
                legend: {
                    display: false,
                    labels: {
                        usePointStyle: false
                    }
                },
                responsive: true,
                maintainAspectRatio: false,
                hover: {
                    mode: 'index'
                },
                scales: {
                    xAxes: [{
                        display: true,
                        gridLines: false,
                        scaleLabel: {
                            display: false,
                            labelString: 'Month'
                        },
                        ticks: {
                            fontSize: 10,
                            padding: 10
                        }
                    }],
                    yAxes: [{
                        display: true,
                        gridLines: false,
                        scaleLabel: {
                            display: false,
                            labelString: 'Value'
                        },
                        ticks: {
                            beginAtZero: true,
                            userCallback: function (label, index, labels) {
                                if (Math.floor(label) === label) {
                                    return label;
                                }
                            },
                        }
                    }]
                },

                elements: {
                    point: {
                        radius: 4,
                        borderWidth: 12
                    },
                },

                layout: {
                    padding: {
                        left: 0,
                        right: 0,
                        top: 5,
                        bottom: 0
                    }
                }
            }
        };

        return new Chart(src, config);
    }

    //== Daily Sales chart.
    //** Based on Chartjs plugin - http://www.chartjs.org/
    var dailySales = function () {
        var chartContainer = $('#m_chart_daily_sales');
        var chartLabels = $(chartContainer).data('labels');
        var salesChartData = $(chartContainer).data('sale-values');
        var totalPoint = $(chartLabels).length;
        var salesBackgroundColor = [], orderBackgroundColor = [], i;

        for (i = 0; i < totalPoint; i++) {
            salesBackgroundColor.push('rgba(233, 30, 99, 0.5)');
            orderBackgroundColor.push('rgba(113, 106, 202, 0.0)');
        }

        //
        var ordersChartData = $(chartContainer).data('orders-values');
        var activeOrdersChartData = $(chartContainer).data('active-order-values');
        var label = $(chartContainer).data('label');
        if (chartContainer.length == 0) {
            return;
        }
        var ctx = document.getElementById("m_chart_daily_sales").getContext("2d");
        /*var gradient = ctx.createLinearGradient(0, 0, 0, 240);
        gradient.addColorStop(0, Chart.helpers.color('#d1f1ec').alpha(1).rgbString());
        gradient.addColorStop(1, Chart.helpers.color('#d1f1ec').alpha(0.3).rgbString());*/

        var chartData = {
            labels: chartLabels,
            datasets: [{
                yAxisID: 'A',
                label: label + ' (৳)',
                backgroundColor: salesBackgroundColor,
                borderWidth: 1,
                radius: 0,
                borderColor: '#E91E63',
                pointBackgroundColor: Chart.helpers.color('#ff000').alpha(0).rgbString(),
                pointBorderColor: Chart.helpers.color('#ff000').alpha(0).rgbString(),
                pointHoverBackgroundColor: mUtil.getColor('danger'),
                pointHoverBorderColor: Chart.helpers.color('#ff0000').alpha(0.1).rgbString(),
                data: salesChartData,
                fill: true
            }, {
                yAxisID: 'B',
                label: 'Orders',
                backgroundColor: orderBackgroundColor,
                borderWidth: 1,
                radius: 0,
                borderColor: mUtil.getColor('primary'),
                pointBackgroundColor: Chart.helpers.color('#ff000').alpha(0).rgbString(),
                pointBorderColor: Chart.helpers.color('#ff000').alpha(0).rgbString(),
                pointHoverBackgroundColor: mUtil.getColor('danger'),
                pointHoverBorderColor: Chart.helpers.color('#ff0000').alpha(0.1).rgbString(),
                data: ordersChartData,
                type: 'line'
            }]
        };

        var chart = new Chart(chartContainer, {
            type: 'line',
            data: chartData,
            options: {
                scales: {
                    xAxes: [{
                        display: true,
                        scaleLabel: {
                            display: false,
                            labelString: 'Month'
                        },
                        ticks: {
                            padding: 10
                        }
                    }],
                    yAxes: [{
                        id: 'A',
                        position: 'left',
                        display: true,
                        scaleLabel: {
                            display: true,
                            labelString: 'Total Sales(taka)'
                        },
                        ticks: {
                            beginAtZero: true,
                            userCallback: function (label, index, labels) {
                                if (Math.floor(label) === label) {
                                    return label;
                                }
                            },
                        }
                    }, {
                        id: 'B',
                        position: 'right',
                        display: true,
                        stacked: false,
                        scaleLabel: {
                            display: true,
                            labelString: 'Total Orders(number)'
                        },
                        ticks: {
                            beginAtZero: true,
                            userCallback: function (label, index, labels) {
                                if (Math.floor(label) === label) {
                                    return label;
                                }

                            },
                        }
                    }]
                },
                responsive: true,
                maintainAspectRatio: false,
                title: {
                    display: false,
                    text: 'Over all'
                },
                tooltips: {
                    mode: 'index',
                    intersect: false,
                },
                legend: {
                    display: true
                },
                hover: {
                    mode: 'nearest',
                    intersect: true
                },
                barRadius: 0,
                elements: {
                    line: {
                        //tension: 0.0000001
                    },
                    point: {
                        /*radius: 4,
                        borderWidth: 12*/
                    }
                }
            }
        });
    }

    //== Daily Sales chart.
    //** Based on Chartjs plugin - http://www.chartjs.org/
    var inactiveUserChart = function () {

        var chartContainer = $('#inactiveUserBarChart');
        var chartLabels = $(chartContainer).data('labels');
        var salesChartData = $(chartContainer).data('sale-values');
        var totalPoint = $(chartLabels).length;
        var salesBackgroundColor = [], orderBackgroundColor = [], i;

        for (i = 0; i < totalPoint; i++) {
            salesBackgroundColor.push('rgba(233, 30, 99, 0.3)');
            orderBackgroundColor.push('rgba(113, 106, 202, 0.3)');
        }


        var ordersChartData = $(chartContainer).data('orders-values');
        var activeOrdersChartData = $(chartContainer).data('active-order-values');
        var label = $(chartContainer).data('label');
        if (chartContainer.length == 0) {
            return;
        }
        var ctx = document.getElementById("inactiveUserBarChart").getContext("2d");

        var chartData = {
            labels: chartLabels,
            datasets: [{
                // yAxisID: 'A',
                label: 'Users',
                backgroundColor: salesBackgroundColor,
                borderWidth: 0.7,
                radius: 0,
                borderColor: '#E91E63',
                pointBackgroundColor: Chart.helpers.color('#ff000').alpha(0).rgbString(),
                pointBorderColor: Chart.helpers.color('#ff000').alpha(0).rgbString(),
                pointHoverBackgroundColor: mUtil.getColor('danger'),
                pointHoverBorderColor: Chart.helpers.color('#ff0000').alpha(0.2).rgbString(),
                data: salesChartData,
                // fill: true
            }, {
               // yAxisID: 'B',
                label: 'Activated Users',
                backgroundColor: orderBackgroundColor,
                borderWidth: 0.7,
                radius: 0,
                borderColor: mUtil.getColor('primary'),
                pointBackgroundColor: Chart.helpers.color('#ff000').alpha(0).rgbString(),
                pointBorderColor: Chart.helpers.color('#ff000').alpha(0).rgbString(),
                pointHoverBackgroundColor: mUtil.getColor('danger'),
                pointHoverBorderColor: Chart.helpers.color('#ff0000').alpha(0.2).rgbString(),
                data: ordersChartData
            }]
        };

        var chart = new Chart(chartContainer, {
            type: 'line',
            data: chartData,
            options: {
                scales: {
                    xAxes: [{
                        display: true,
                        scaleLabel: {
                            display: false,
                            labelString: 'Month'
                        },
                        ticks: {
                            padding: 10
                        }
                    }],
                    yAxes: [{
                        position: 'left',
                        display: true,
                        scaleLabel: {
                            display: true,
                            labelString: 'Users'
                        },
                        ticks: {
                            beginAtZero: true,
                            userCallback: function (label, index, labels) {
                                if (Math.floor(label) === label) {
                                    return label;
                                }
                            },
                        }
                    }]
                },
                responsive: true,
                maintainAspectRatio: false,
                title: {
                    display: false,
                    text: 'Over all'
                },
                tooltips: {
                    mode: 'index',
                    intersect: false,
                },
                legend: {
                    display: true
                },
                hover: {
                    mode: 'nearest',
                    intersect: true
                },
                barRadius: 0,
                elements: {
                    line: {
                        //tension: 0.0000001
                    },
                    point: {
                        /*radius: 4,
                        borderWidth: 12*/
                    }
                }
            }
        });
    }

    var userStatistics = function () {
        var chartContainer = $('#m_userStatistics');
        if (chartContainer.length == 0) {
            return;
        }
        var labels = $(chartContainer).data('labels');
        var values = $(chartContainer).data('values');
        var colors = $(chartContainer).data('colors');
        var dataLength = $(labels).length;
        var backgroundColor = [];

        for (i = 0; i < dataLength; i++) {
            backgroundColor.push(colors[i]);
        }

        var ctx = document.getElementById("m_userStatistics").getContext("2d");
        var chartData = {
            labels: labels,
            datasets: [{
                label: '',
                backgroundColor: backgroundColor,
                borderWidth: 0,
                radius: 0,
                borderWidth: 0,
                pointBackgroundColor: Chart.helpers.color('#ff000').alpha(0).rgbString(),
                pointBorderColor: Chart.helpers.color('#ff000').alpha(0).rgbString(),
                pointHoverBackgroundColor: mUtil.getColor('danger'),
                pointHoverBorderColor: Chart.helpers.color('#ff0000').alpha(0.1).rgbString(),
                data: values,
                fill: true
            }]
        };

        var chart = new Chart(chartContainer, {
            type: 'bar',
            data: chartData,
            options: {
                scales: {
                    xAxes: [{
                        display: true,
                        scaleLabel: {
                            display: false,
                            labelString: ''
                        },
                        ticks: {
                            padding: 10
                        }
                    }],
                    yAxes: [{
                        display: true,
                        scaleLabel: {
                            display: true,
                            labelString: 'Percentage %'
                        },
                        ticks: {
                            beginAtZero: true,
                            userCallback: function (label, index, labels) {
                                if (Math.floor(label) === label) {
                                    return label;
                                }
                            },
                            suggestedMin: 0,
                            suggestedMax: 100,
                        }
                    }]
                },
                /*tooltips: {
                    callbacks: {
                        label: function(tooltipItem, data) {
                            return '%';
                        },
                        afterLabel: function(tooltipItem, data) {
                            return '%';
                        }
                    }
                },*/
                responsive: true,
                maintainAspectRatio: false,
                title: {
                    display: false,
                    text: 'Over all'
                },
                tooltips: {
                    mode: 'index',
                    intersect: false,
                },
                legend: {
                    display: false
                },
                hover: {
                    mode: 'nearest',
                    intersect: true
                },
                barRadius: 0,
                elements: {
                    line: {
                        //tension: 0.0000001
                    },
                    point: {
                        /*radius: 4,
                        borderWidth: 12*/
                    }
                }
            }
        });
    }

    var cancellationOrderChart = function () {
        var chartContainer = $('#cancellationOrderChart');
        var chartLabels = $(chartContainer).data('labels');
        var salesChartData = $(chartContainer).data('sale-values');
        var totalPoint = $(chartLabels).length;
        var salesBackgroundColor = [], orderBackgroundColor = [], i;

        for (i = 0; i < totalPoint; i++) {
            salesBackgroundColor.push('#F4516C');
            orderBackgroundColor.push('#34BFA3');
        }


        var ordersChartData = $(chartContainer).data('orders-values');
        var activeOrdersChartData = $(chartContainer).data('active-order-values');
        var label = $(chartContainer).data('label');
        if (chartContainer.length == 0) {
            return;
        }
        var ctx = document.getElementById("cancellationOrderChart").getContext("2d");

        var chartData = {
            labels: chartLabels,
            datasets: [{
                label: 'Canceled Orders',
                backgroundColor: salesBackgroundColor,
                borderWidth: 0,
                radius: 0,
                borderColor: '#E91E63',
                pointBackgroundColor: Chart.helpers.color('#ff000').alpha(0).rgbString(),
                pointBorderColor: Chart.helpers.color('#ff000').alpha(0).rgbString(),
                pointHoverBackgroundColor: mUtil.getColor('danger'),
                pointHoverBorderColor: Chart.helpers.color('#ff0000').alpha(0.1).rgbString(),
                data: salesChartData,
                fill: true
            }, {
                label: 'Total Orders',
                backgroundColor: orderBackgroundColor,
                borderWidth: 0,
                radius: 0,
                borderColor: mUtil.getColor('primary'),
                pointBackgroundColor: Chart.helpers.color('#ff000').alpha(0).rgbString(),
                pointBorderColor: Chart.helpers.color('#ff000').alpha(0).rgbString(),
                pointHoverBackgroundColor: mUtil.getColor('danger'),
                pointHoverBorderColor: Chart.helpers.color('#ff0000').alpha(0.1).rgbString(),
                data: ordersChartData
            }]
        };

        var chart = new Chart(chartContainer, {
            type: 'bar',
            data: chartData,
            options: {
                scales: {
                    xAxes: [{
                        display: true,
                        scaleLabel: {
                            display: false,
                            labelString: 'Month'
                        },
                        ticks: {
                            padding: 10
                        }
                    }],
                    yAxes: [{
                        display: true,
                        scaleLabel: {
                            display: true,
                            labelString: 'Orders'
                        },
                        ticks: {
                            beginAtZero: true,
                            userCallback: function (label, index, labels) {
                                if (Math.floor(label) === label) {
                                    return label;
                                }
                            },
                        }
                    }]
                },
                responsive: true,
                maintainAspectRatio: false,
                title: {
                    display: false,
                    text: 'Over all'
                },
                tooltips: {
                    mode: 'index',
                    intersect: false,
                },
                legend: {
                    display: true
                },
                hover: {
                    mode: 'nearest',
                    intersect: true
                },
                barRadius: 0,
                elements: {
                    line: {
                        //tension: 0.0000001
                    },
                    point: {
                        /*radius: 4,
                        borderWidth: 12*/
                    }
                }
            }
        });
    }

    //== Monthly Average Delivery.
    //** Based on Chartjs plugin - http://www.chartjs.org/
    var monthlyAverageDelivery = function () {
        var chartContainer = $('#m_chart_average_delivery');
        var chartData = $(chartContainer).data('values');
        var chartLabels = $(chartContainer).data('labels');

        if (chartContainer.length == 0) {
            return;
        }

        var chartData = {
            labels: chartLabels,
            datasets: [{
                //label: 'Dataset 1',
                backgroundColor: mUtil.getColor('success'),
                data: chartData
            }]
        };

        var chart = new Chart(chartContainer, {
            type: 'bar',
            data: chartData,
            options: {
                title: {
                    display: false,
                },
                tooltips: {
                    intersect: false,
                    mode: 'nearest',
                    xPadding: 10,
                    yPadding: 10,
                    caretPadding: 10
                },
                legend: {
                    display: false
                },
                responsive: true,
                maintainAspectRatio: false,
                barRadius: 4,
                scales: {
                    xAxes: [{
                        display: false,
                        gridLines: false,
                        stacked: true,
                        ticks: {
                            padding: 10
                        }
                    }],
                    yAxes: [{
                        display: false,
                        stacked: true,
                        gridLines: false
                    }]
                },
                layout: {
                    padding: {
                        left: 0,
                        right: 0,
                        top: 0,
                        bottom: 0
                    }
                }
            }
        });
    }

    //== Profit Share Chart.
    //** Based on Chartist plugin - https://gionkunz.github.io/chartist-js/index.html
    var profitShare = function () {
        if ($('#m_chart_profit_share').length == 0) {
            return;
        }

        var newOrders = $('.newOrder').data('value'),
            warehouseLeft = $('.warehouseLeft').data('value'),
            onDelivery = $('.onDelivery').data('value'),
            deliveredOrders = $('.deliveredOrders').data('value'),
            cancelledOrders = $('.cancelledOrders').data('value');
        var pieOptions = {
            animation: false
        };
        var chart = new Chartist.Pie('#m_chart_profit_share', {
            series: [{
                value: newOrders,
                className: 'custom',
                meta: {
                    color: mUtil.getColor('warning')
                }
            },
                {
                    value: warehouseLeft,
                    className: 'custom',
                    meta: {
                        color: mUtil.getColor('info')
                    }
                },
                {
                    value: onDelivery,
                    className: 'custom',
                    meta: {
                        color: mUtil.getColor('brand')
                    }
                },
                {
                    value: deliveredOrders,
                    className: 'custom',
                    meta: {
                        color: mUtil.getColor('success')
                    }
                },
                {
                    value: cancelledOrders,
                    className: 'custom',
                    meta: {
                        color: mUtil.getColor('danger')
                    }
                }
            ],
            labels: [1, 2, 3]
        }, {
            donut: true,
            donutWidth: 17,
            showLabel: false,
            animation: false
        });

        chart.on('draw', function (data) {
            if (data.type === 'slice') {
                // Get the total path length in order to use for dash array animation
                var pathLength = data.element._node.getTotalLength();

                // Set a dasharray that matches the path length as prerequisite to animate dashoffset
                data.element.attr({
                    'stroke-dasharray': pathLength + 'px ' + pathLength + 'px'
                });

                // Create animation definition while also assigning an ID to the animation for later sync usage
                var animationDefinition = {
                    'stroke-dashoffset': {
                        id: 'anim' + data.index,
                        dur: 1000,
                        from: -pathLength + 'px',
                        to: '0px',
                        easing: Chartist.Svg.Easing.easeOutQuint,
                        // We need to use `fill: 'freeze'` otherwise our animation will fall back to initial (not visible)
                        fill: 'freeze',
                        'stroke': data.meta.color
                    }
                };

                // If this was not the first slice, we need to time the animation so that it uses the end sync event of the previous animation
                if (data.index !== 0) {
                    animationDefinition['stroke-dashoffset'].begin = 'anim' + (data.index - 1) + '.end';
                }

                // We need to set an initial value before the animation starts as we are not in guided mode which would do that for us

                data.element.attr({
                    'stroke-dashoffset': -pathLength + 'px',
                    'stroke': data.meta.color
                });

                // We can't use guided mode as the animations need to rely on setting begin manually
                // See http://gionkunz.github.io/chartist-js/api-documentation.html#chartistsvg-function-animate
                data.element.animate(animationDefinition, false);
            }
        });

        // For the sake of the example we update the chart every time it's created with a delay of 8 seconds
        chart.on('created', function () {
            if (window.__anim21278907124) {
                clearTimeout(window.__anim21278907124);
                window.__anim21278907124 = null;
            }
            // window.__anim21278907124 = setTimeout(chart.update.bind(chart), 1500);
        });
    }

    //== Sales Stats.
    //** Based on Chartjs plugin - http://www.chartjs.org/
    var salesStats = function () {
        if ($('#m_chart_sales_stats').length == 0) {
            return;
        }
        var config = {
            type: 'line',
            data: {
                datasets: [{
                    borderWidth: 1
                }]
            },
            options: {
                title: {
                    display: false,
                },
                tooltips: {
                    intersect: false,
                    mode: 'nearest',
                    xPadding: 10,
                    yPadding: 10,
                    caretPadding: 10
                },
                legend: {
                    display: false,
                    labels: {
                        usePointStyle: false
                    }
                },
                responsive: true,
                maintainAspectRatio: false,
                hover: {
                    mode: 'index'
                },
                scales: {
                    xAxes: [{
                        display: true,
                        gridLines: false,
                        scaleLabel: {
                            display: false,
                            labelString: 'Month'
                        },
                        gridLines: {
                            offsetGridLines: true
                        },
                        ticks: {
                            padding: 10
                        }
                    }],
                    yAxes: [{
                        display: true,
                        gridLines: false,
                        scaleLabel: {
                            display: false,
                            labelString: 'Value'
                        },
                        gridLines: {
                            offsetGridLines: true
                        }
                    }]
                },
                elements: {
                    point: {
                        radius: 0,
                        borderWidth: 0,
                        hoverRadius: 0,
                        hoverBorderWidth: 2
                    }
                }
            }
        };
        // Sales Stats
        //var salesValues = [10, 20, 16, 18, 12, 40, 35, 30, 33, 34, 45, 40, 60, 55, 70, 65, 75, 62];
        var salesLabels = $('#m_chart_sales_stats').data('labels');
        var salesValues = $('#m_chart_sales_stats').data('values');
        var chartSales = new Chart($('#m_chart_sales_stats'), config);
        var chartSalesData = chartSales.config.data;
        chartSalesData.labels = salesLabels;
        chartSalesData.datasets[0].label = "Sales Stats";
        chartSalesData.datasets[0].borderColor = mUtil.getColor('brand');
        chartSalesData.datasets[0].pointBackgroundColor = mUtil.getColor('brand');
        chartSalesData.datasets[0].backgroundColor = mUtil.getColor('accent');
        chartSalesData.datasets[0].pointHoverBackgroundColor = mUtil.getColor('danger');
        chartSalesData.datasets[0].pointHoverBorderColor = Chart.helpers.color(mUtil.getColor('danger')).alpha(0.2).rgbString();
        chartSalesData.datasets[0].data = salesValues;
        chartSales.update();
    }
    var ordersStats = function () {
        if ($('#m_chart_orders_stats').length == 0) {
            return;
        }
        var config = {
            type: 'line',
            data: {
                datasets: [{
                    borderWidth: 1,
                }]
            },
            options: {
                title: {
                    display: false,
                },
                tooltips: {
                    intersect: false,
                    mode: 'nearest',
                    xPadding: 10,
                    yPadding: 10,
                    caretPadding: 10
                },
                legend: {
                    display: false,
                    labels: {
                        usePointStyle: false
                    }
                },
                responsive: true,
                maintainAspectRatio: false,
                hover: {
                    mode: 'index'
                },
                scales: {
                    xAxes: [{
                        display: true,
                        gridLines: false,
                        scaleLabel: {
                            display: false,
                            labelString: 'Month'
                        },
                        gridLines: {
                            offsetGridLines: true
                        },
                        ticks: {
                            padding: 10
                        }
                    }],
                    yAxes: [{
                        display: true,
                        gridLines: false,
                        scaleLabel: {
                            display: false,
                            labelString: 'Value'
                        },
                        gridLines: {
                            offsetGridLines: true
                        }
                    }]
                },
                elements: {
                    point: {
                        radius: 0,
                        borderWidth: 0,

                        hoverRadius: 8,
                        hoverBorderWidth: 2
                    }
                }
            }
        };
        // Order Stats
        //var ordersValues = [10, 60, 16, 18, 12, 55, 35, 45, 33, 34, 45, 40, 60, 55, 70, 65, 75, 62];
        var orderLabels = $('#m_chart_orders_stats').data('labels');
        var orderValues = $('#m_chart_orders_stats').data('values');
        var chartOrders = new Chart($('#m_chart_orders_stats'), config);
        var chartOrdersData = chartOrders.config.data;
        chartOrdersData.labels = orderLabels;
        chartOrdersData.datasets[0].label = "Orders Stats";
        chartOrdersData.datasets[0].borderColor = mUtil.getColor('warning');
        chartOrdersData.datasets[0].pointBackgroundColor = mUtil.getColor('warning');
        chartOrdersData.datasets[0].backgroundColor = mUtil.getColor('info');
        chartOrdersData.datasets[0].pointHoverBackgroundColor = mUtil.getColor('danger');
        chartOrdersData.datasets[0].pointHoverBorderColor = Chart.helpers.color(mUtil.getColor('danger')).alpha(0.2).rgbString();
        chartOrdersData.datasets[0].data = orderValues;
        chartOrders.update();
    }

    //== Sales By mUtillication Stats.
    //** Based on Chartjs plugin - http://www.chartjs.org/
    var salesByApps = function () {
        // Init chart instances
        _initSparklineChart($('#m_chart_sales_by_apps_1_1'), [10, 20, -5, 8, -20, -2, -4, 15, 5, 8], mUtil.getColor('accent'), 1);
        _initSparklineChart($('#m_chart_sales_by_apps_1_2'), [2, 16, 0, 12, 22, 5, -10, 5, 15, 2], mUtil.getColor('danger'), 1);
        _initSparklineChart($('#m_chart_sales_by_apps_1_3'), [15, 5, -10, 5, 16, 22, 6, -6, -12, 5], mUtil.getColor('success'), 1);
        _initSparklineChart($('#m_chart_sales_by_apps_1_4'), [8, 18, -12, 12, 22, -2, -14, 16, 18, 2], mUtil.getColor('warning'), 1);

        _initSparklineChart($('#m_chart_sales_by_apps_2_1'), [10, 20, -5, 8, -20, -2, -4, 15, 5, 8], mUtil.getColor('danger'), 1);
        _initSparklineChart($('#m_chart_sales_by_apps_2_2'), [2, 16, 0, 12, 22, 5, -10, 5, 15, 2], mUtil.getColor('metal'), 1);
        _initSparklineChart($('#m_chart_sales_by_apps_2_3'), [15, 5, -10, 5, 16, 22, 6, -6, -12, 5], mUtil.getColor('brand'), 1);
        _initSparklineChart($('#m_chart_sales_by_apps_2_4'), [8, 18, -12, 12, 22, -2, -14, 16, 18, 2], mUtil.getColor('info'), 1);
    }

    //== Latest Updates.
    //** Based on Chartjs plugin - http://www.chartjs.org/
    var latestUpdates = function () {
        if ($('#m_chart_latest_updates').length == 0) {
            return;
        }

        var ctx = document.getElementById("m_chart_latest_updates").getContext("2d");

        var config = {
            type: 'line',
            data: {
                labels: ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October"],
                datasets: [{
                    label: "Sales Stats",
                    backgroundColor: mUtil.getColor('danger'), // Put the gradient here as a fill color
                    borderColor: mUtil.getColor('danger'),
                    pointBackgroundColor: Chart.helpers.color('#000000').alpha(0).rgbString(),
                    pointBorderColor: Chart.helpers.color('#000000').alpha(0).rgbString(),
                    pointHoverBackgroundColor: mUtil.getColor('accent'),
                    pointHoverBorderColor: Chart.helpers.color('#000000').alpha(0.1).rgbString(),

                    //fill: 'start',
                    data: [
                        10, 14, 12, 16, 9, 11, 13, 9, 13, 15
                    ]
                }]
            },
            options: {
                title: {
                    display: false,
                },
                tooltips: {
                    intersect: false,
                    mode: 'nearest',
                    xPadding: 10,
                    yPadding: 10,
                    caretPadding: 10
                },
                legend: {
                    display: false
                },
                responsive: true,
                maintainAspectRatio: false,
                hover: {
                    mode: 'index'
                },
                scales: {
                    xAxes: [{
                        display: false,
                        gridLines: false,
                        scaleLabel: {
                            display: true,
                            labelString: 'Month'
                        }
                    }],
                    yAxes: [{
                        display: false,
                        gridLines: false,
                        scaleLabel: {
                            display: true,
                            labelString: 'Value'
                        },
                        ticks: {
                            beginAtZero: true,
                            padding: 10
                        }
                    }]
                },
                elements: {
                    line: {
                        // tension: 0.0000001
                    },
                    point: {
                        radius: 4,
                        borderWidth: 12
                    }
                }
            }
        };

        var chart = new Chart(ctx, config);
    }

    //== Trends Stats.
    //** Based on Chartjs plugin - http://www.chartjs.org/
    var trendsStats = function () {
        if ($('#m_chart_trends_stats').length == 0) {
            return;
        }

        var ctx = document.getElementById("m_chart_trends_stats").getContext("2d");

        var gradient = ctx.createLinearGradient(0, 0, 0, 240);
        gradient.addColorStop(0, Chart.helpers.color('#00c5dc').alpha(0.7).rgbString());
        gradient.addColorStop(1, Chart.helpers.color('#f2feff').alpha(0).rgbString());

        var config = {
            type: 'line',
            data: {
                labels: [
                    "January", "February", "March", "April", "May", "June", "July", "August", "September", "October",
                    "January", "February", "March", "April", "May", "June", "July", "August", "September", "October",
                    "January", "February", "March", "April", "May", "June", "July", "August", "September", "October",
                    "January", "February", "March", "April"
                ],
                datasets: [{
                    label: "Sales Stats",
                    backgroundColor: gradient, // Put the gradient here as a fill color
                    borderColor: '#0dc8de',

                    pointBackgroundColor: Chart.helpers.color('#ffffff').alpha(0).rgbString(),
                    pointBorderColor: Chart.helpers.color('#ffffff').alpha(0).rgbString(),
                    pointHoverBackgroundColor: mUtil.getColor('danger'),
                    pointHoverBorderColor: Chart.helpers.color('#000000').alpha(0.2).rgbString(),

                    //fill: 'start',
                    data: [
                        20, 10, 18, 15, 26, 18, 15, 22, 16, 12,
                        12, 13, 10, 18, 14, 24, 16, 12, 19, 21,
                        16, 14, 21, 21, 13, 15, 22, 24, 21, 11,
                        14, 19, 21, 17
                    ]
                }]
            },
            options: {
                title: {
                    display: false,
                },
                tooltips: {
                    intersect: false,
                    mode: 'nearest',
                    xPadding: 10,
                    yPadding: 10,
                    caretPadding: 10
                },
                legend: {
                    display: false
                },
                responsive: true,
                maintainAspectRatio: false,
                hover: {
                    mode: 'index'
                },
                scales: {
                    xAxes: [{
                        display: false,
                        gridLines: false,
                        scaleLabel: {
                            display: true,
                            labelString: 'Month'
                        },
                        ticks: {
                            padding: 10
                        }
                    }],
                    yAxes: [{
                        display: false,
                        gridLines: false,
                        scaleLabel: {
                            display: true,
                            labelString: 'Value'
                        },
                        ticks: {
                            beginAtZero: true,
                        }
                    }]
                },
                elements: {
                    line: {
                        tension: 0.19
                    },
                    point: {
                        radius: 4,
                        borderWidth: 12
                    }
                },
                layout: {
                    padding: {
                        left: 0,
                        right: 0,
                        top: 5,
                        bottom: 0
                    }
                }
            }
        };

        var chart = new Chart(ctx, config);
    }

    //== Trends Stats 2.
    //** Based on Chartjs plugin - http://www.chartjs.org/
    var trendsStats2 = function () {
        if ($('#m_chart_trends_stats_2').length == 0) {
            return;
        }

        var ctx = document.getElementById("m_chart_trends_stats_2").getContext("2d");

        var config = {
            type: 'line',
            data: {
                labels: [
                    "January", "February", "March", "April", "May", "June", "July", "August", "September", "October",
                    "January", "February", "March", "April", "May", "June", "July", "August", "September", "October",
                    "January", "February", "March", "April", "May", "June", "July", "August", "September", "October",
                    "January", "February", "March", "April"
                ],
                datasets: [{
                    label: "Sales Stats",
                    backgroundColor: '#d2f5f9', // Put the gradient here as a fill color
                    borderColor: mUtil.getColor('brand'),

                    pointBackgroundColor: Chart.helpers.color('#ffffff').alpha(0).rgbString(),
                    pointBorderColor: Chart.helpers.color('#ffffff').alpha(0).rgbString(),
                    pointHoverBackgroundColor: mUtil.getColor('danger'),
                    pointHoverBorderColor: Chart.helpers.color('#000000').alpha(0.2).rgbString(),

                    //fill: 'start',
                    data: [
                        20, 10, 18, 15, 32, 18, 15, 22, 8, 6,
                        12, 13, 10, 18, 14, 24, 16, 12, 19, 21,
                        16, 14, 24, 21, 13, 15, 27, 29, 21, 11,
                        14, 19, 21, 17
                    ]
                }]
            },
            options: {
                title: {
                    display: false,
                },
                tooltips: {
                    intersect: false,
                    mode: 'nearest',
                    xPadding: 10,
                    yPadding: 10,
                    caretPadding: 10
                },
                legend: {
                    display: false
                },
                responsive: true,
                maintainAspectRatio: false,
                hover: {
                    mode: 'index'
                },
                scales: {
                    xAxes: [{
                        display: false,
                        gridLines: false,
                        scaleLabel: {
                            display: true,
                            labelString: 'Month'
                        },
                        ticks: {
                            padding: 10
                        }
                    }],
                    yAxes: [{
                        display: false,
                        gridLines: false,
                        scaleLabel: {
                            display: true,
                            labelString: 'Value'
                        },
                        ticks: {
                            beginAtZero: true
                        }
                    }]
                },
                elements: {
                    line: {
                        tension: 0.19
                    },
                    point: {
                        radius: 4,
                        borderWidth: 12
                    }
                },
                layout: {
                    padding: {
                        left: 0,
                        right: 0,
                        top: 5,
                        bottom: 0
                    }
                }
            }
        };

        var chart = new Chart(ctx, config);
    }

    //== Trends Stats.
    //** Based on Chartjs plugin - http://www.chartjs.org/
    var latestTrendsMap = function () {
        if ($('#m_chart_latest_trends_map').length == 0) {
            return;
        }

        try {
            var map = new GMaps({
                div: '#m_chart_latest_trends_map',
                lat: -12.043333,
                lng: -77.028333
            });
        } catch (e) {
            console.log(e);
        }
    }

    //== Revenue Change.
    //** Based on Morris plugin - http://morrisjs.github.io/morris.js/
    var revenueChange = function () {
        if ($('#m_chart_revenue_change').length == 0) {
            return;
        }

        Morris.Donut({
            element: 'm_chart_revenue_change',
            data: [{
                label: "New York",
                value: 10
            },
                {
                    label: "London",
                    value: 7
                },
                {
                    label: "Paris",
                    value: 20
                }
            ],
            colors: [
                mUtil.getColor('accent'),
                mUtil.getColor('danger'),
                mUtil.getColor('brand')
            ],
        });
    }

    //== Support Tickets Chart.
    //** Based on Morris plugin - http://morrisjs.github.io/morris.js/
    var supportTickets = function () {
        if ($('#m_chart_support_tickets').length == 0) {
            return;
        }

        Morris.Donut({
            element: 'm_chart_support_tickets',
            data: [{
                label: "Margins",
                value: 20
            },
                {
                    label: "Profit",
                    value: 70
                },
                {
                    label: "Lost",
                    value: 10
                }
            ],
            labelColor: '#a7a7c2',
            colors: [
                mUtil.getColor('accent'),
                mUtil.getColor('brand'),
                mUtil.getColor('danger')
            ]
            //formatter: function (x) { return x + "%"}
        });
    }

    //== Support Tickets Chart.
    //** Based on Morris plugin - http://morrisjs.github.io/morris.js/
    var supportTickets2 = function () {
        if ($('#m_chart_support_tickets2').length == 0) {
            return;
        }

        var chart = new Chartist.Pie('#m_chart_support_tickets2', {
            series: [{
                value: 32,
                className: 'custom',
                meta: {
                    color: mUtil.getColor('brand')
                }
            },
                {
                    value: 32,
                    className: 'custom',
                    meta: {
                        color: mUtil.getColor('accent')
                    }
                },
                {
                    value: 36,
                    className: 'custom',
                    meta: {
                        color: mUtil.getColor('warning')
                    }
                }
            ],
            labels: [1, 2, 3]
        }, {
            donut: true,
            donutWidth: 17,
            showLabel: false
        });

        chart.on('draw', function (data) {
            if (data.type === 'slice') {
                // Get the total path length in order to use for dash array animation
                var pathLength = data.element._node.getTotalLength();

                // Set a dasharray that matches the path length as prerequisite to animate dashoffset
                data.element.attr({
                    'stroke-dasharray': pathLength + 'px ' + pathLength + 'px'
                });

                // Create animation definition while also assigning an ID to the animation for later sync usage
                var animationDefinition = {
                    'stroke-dashoffset': {
                        id: 'anim' + data.index,
                        dur: 1000,
                        from: -pathLength + 'px',
                        to: '0px',
                        easing: Chartist.Svg.Easing.easeOutQuint,
                        // We need to use `fill: 'freeze'` otherwise our animation will fall back to initial (not visible)
                        fill: 'freeze',
                        'stroke': data.meta.color
                    }
                };

                // If this was not the first slice, we need to time the animation so that it uses the end sync event of the previous animation
                if (data.index !== 0) {
                    animationDefinition['stroke-dashoffset'].begin = 'anim' + (data.index - 1) + '.end';
                }

                // We need to set an initial value before the animation starts as we are not in guided mode which would do that for us

                data.element.attr({
                    'stroke-dashoffset': -pathLength + 'px',
                    'stroke': data.meta.color
                });

                // We can't use guided mode as the animations need to rely on setting begin manually
                // See http://gionkunz.github.io/chartist-js/api-documentation.html#chartistsvg-function-animate
                data.element.animate(animationDefinition, false);
            }
        });
    }

    //== Activities Charts.
    //** Based on Chartjs plugin - http://www.chartjs.org/
    var activitiesChart = function () {
        if ($('#m_chart_activities').length == 0) {
            return;
        }

        var ctx = document.getElementById("m_chart_activities").getContext("2d");

        var gradient = ctx.createLinearGradient(0, 0, 0, 240);
        gradient.addColorStop(0, Chart.helpers.color('#e14c86').alpha(1).rgbString());
        gradient.addColorStop(1, Chart.helpers.color('#e14c86').alpha(0.3).rgbString());

        var config = {
            type: 'line',
            data: {
                labels: ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October"],
                datasets: [{
                    label: "Sales Stats",
                    backgroundColor: gradient,
                    borderColor: '#e13a58',

                    pointBackgroundColor: Chart.helpers.color('#000000').alpha(0).rgbString(),
                    pointBorderColor: Chart.helpers.color('#000000').alpha(0).rgbString(),
                    pointHoverBackgroundColor: mUtil.getColor('light'),
                    pointHoverBorderColor: Chart.helpers.color('#ffffff').alpha(0.1).rgbString(),

                    //fill: 'start',
                    data: [
                        10, 14, 12, 16, 9, 11, 13, 9, 13, 15
                    ]
                }]
            },
            options: {
                title: {
                    display: false,
                },
                tooltips: {
                    mode: 'nearest',
                    intersect: false,
                    position: 'nearest',
                    xPadding: 10,
                    yPadding: 10,
                    caretPadding: 10
                },
                legend: {
                    display: false
                },
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    xAxes: [{
                        display: false,
                        gridLines: false,
                        scaleLabel: {
                            display: true,
                            labelString: 'Month'
                        }
                    }],
                    yAxes: [{
                        display: false,
                        gridLines: false,
                        scaleLabel: {
                            display: true,
                            labelString: 'Value'
                        },
                        ticks: {
                            beginAtZero: true
                        }
                    }]
                },
                elements: {
                    line: {
                        // tension: 0.0000001
                    },
                    point: {
                        radius: 4,
                        borderWidth: 12
                    }
                },
                layout: {
                    padding: {
                        left: 0,
                        right: 0,
                        top: 10,
                        bottom: 0
                    }
                }
            }
        };

        var chart = new Chart(ctx, config);
    }

    //== Bandwidth Charts 1.
    //** Based on Chartjs plugin - http://www.chartjs.org/
    var bandwidthChart1 = function () {
        if ($('#m_chart_bandwidth1').length == 0) {
            return;
        }

        var labels = $('#m_chart_bandwidth1').data('labels');
        var values = $('#m_chart_bandwidth1').data('values');

        var ctx = document.getElementById("m_chart_bandwidth1").getContext("2d");

        var gradient = ctx.createLinearGradient(0, 0, 0, 240);
        gradient.addColorStop(0, Chart.helpers.color('#d1f1ec').alpha(1).rgbString());
        gradient.addColorStop(1, Chart.helpers.color('#d1f1ec').alpha(0.3).rgbString());

        var config = {
            type: 'line',
            data: {
                labels: labels,
                datasets: [{
                    label: "Bandwidth Stats",
                    backgroundColor: gradient,
                    borderColor: mUtil.getColor('success'),
                    pointBackgroundColor: Chart.helpers.color('#000000').alpha(0).rgbString(),
                    pointBorderColor: Chart.helpers.color('#000000').alpha(0).rgbString(),
                    pointHoverBackgroundColor: mUtil.getColor('danger'),
                    pointHoverBorderColor: Chart.helpers.color('#000000').alpha(0.1).rgbString(),

                    //fill: 'start',
                    data: values
                }]
            },
            options: {
                title: {
                    display: false,
                },
                tooltips: {
                    mode: 'nearest',
                    intersect: false,
                    position: 'nearest',
                    xPadding: 10,
                    yPadding: 10,
                    caretPadding: 10
                },
                legend: {
                    display: false
                },
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    xAxes: [{
                        display: false,
                        gridLines: false,
                        scaleLabel: {
                            display: true,
                            labelString: 'Month'
                        }
                    }],
                    yAxes: [{
                        display: false,
                        gridLines: false,
                        scaleLabel: {
                            display: true,
                            labelString: 'Value'
                        },
                        ticks: {
                            beginAtZero: true
                        }
                    }]
                },
                elements: {
                    line: {
                        // tension: 0.0000001
                    },
                    point: {
                        radius: 4,
                        borderWidth: 12
                    }
                },
                layout: {
                    padding: {
                        left: 0,
                        right: 0,
                        top: 10,
                        bottom: 0
                    }
                }
            }
        };

        var chart = new Chart(ctx, config);
    }

    //== Bandwidth Charts 2.
    //** Based on Chartjs plugin - http://www.chartjs.org/
    var bandwidthChart2 = function () {
        if ($('#m_chart_bandwidth2').length == 0) {
            return;
        }

        var labels = $('#m_chart_bandwidth2').data('labels');
        var values = $('#m_chart_bandwidth2').data('values');
        var epNames = $('#m_chart_bandwidth2').data('ep-name');
        var colorsTo = ['#F44336', '#2196F3', '#8BC34A', '#FFB600', '#9C27B0', '#00BCD4', '#FFEB3B', '#01579B', '#AECC31', 'orange', 'purple', 'red', 'silver', 'teal', 'white', 'yellow'];
        var colorsStop = ['#ffc3a0', '#6dd5ed', '#753a88', 'gray', 'green', 'lime', '#FFEB3B', 'navy', 'olive', 'orange', 'purple', 'red', 'silver', 'teal', 'white', 'yellow', 'aqua'];
        var dataSets = [], i;

        console.log(labels);
        console.log(values);
        console.log(epNames);

        function hexToRgbA(hex) {
            var c;
            if (/^#([A-Fa-f0-9]{3}){1,2}$/.test(hex)) {
                c = hex.substring(1).split('');
                if (c.length == 3) {
                    c = [c[0], c[0], c[1], c[1], c[2], c[2]];
                }
                c = '0x' + c.join('');
                return 'rgba(' + [(c >> 16) & 255, (c >> 8) & 255, c & 255].join(',') + ',.2)';
            }
            throw new Error('Bad Hex');
        }

        var ctx = document.getElementById("m_chart_bandwidth2").getContext("2d");
        var gradient = ctx.createLinearGradient(0, 0, 0, 240);
        // gradient.addColorStop(0, Chart.helpers.color('#052ffc').alpha(1).rgbString());
        // gradient.addColorStop(1, Chart.helpers.color('#ffefce').alpha(0.1).rgbString());

        for (i = 0; i < values.length; i++) {
            gradient = ctx.createLinearGradient(0, 0, 0, 240);
            gradient.addColorStop(0, Chart.helpers.color(colorsTo[i]).alpha(1).rgbString());
            gradient.addColorStop(1, Chart.helpers.color(colorsStop[i]).alpha(0.1).rgbString());

            dataSets.push({
                label: epNames[i],
                backgroundColor: hexToRgbA(colorsTo[i]),
                borderColor: colorsTo[i],
                pointBackgroundColor: Chart.helpers.color('#000000').alpha(0).rgbString(),
                pointBorderColor: Chart.helpers.color('#000000').alpha(0).rgbString(),
                pointHoverBackgroundColor: mUtil.getColor(colorsTo[i]),
                pointHoverBorderColor: Chart.helpers.color('#000000').alpha(0.1).rgbString(),
                borderWidth: 1,
                data: values[i]
            });
        }

        console.log(dataSets);

        var config = {
            type: 'line',
            data: {
                labels: labels,
                datasets: dataSets
            },
            options: {
                title: {
                    display: false,
                },
                tooltips: {
                    mode: 'index',
                    intersect: false,
                    position: 'nearest',
                    xPadding: 10,
                    yPadding: 10,
                    caretPadding: 10
                },
                legend: {
                    display: true
                },
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    xAxes: [{
                        display: true,
                        gridLines: false,
                        scaleLabel: {
                            display: false,
                            labelString: 'Month'
                        },
                        gridLines: {
                            offsetGridLines: true
                        },
                        ticks: {
                            beginAtZero: true,
                            padding: 10
                        }
                    }],
                    yAxes: [{
                        display: true,
                        gridLines: false,
                        scaleLabel: {
                            display: false,
                            labelString: 'Value'
                        },
                        ticks: {
                            beginAtZero: true,
                            userCallback: function (label, index, labels) {
                                if (Math.floor(label) === label) {
                                    return label;
                                }
                            }
                        },
                        gridLines: {
                            offsetGridLines: true
                        }
                    }]
                },
                elements: {
                    line: {
                        // tension: 0.0000001
                    },
                    point: {
                        radius: 4,
                        borderWidth: 12
                    }
                },
                layout: {
                    padding: {
                        left: 0,
                        right: 0,
                        top: 10,
                        bottom: 0
                    }
                }
            }
        };

        var chart = new Chart(ctx, config);
    }

    //== Visitor Charts.
    //** Based on Chartjs plugin - http://www.chartjs.org/
    var visitorChart = function () {
        if ($('#m_chart_visitor').length == 0) {
            return;
        }

        var labels = $('#m_chart_visitor').data('labels');
        var values = $('#m_chart_visitor').data('values');

        var ctx = document.getElementById("m_chart_visitor").getContext("2d");

        var gradient = ctx.createLinearGradient(0, 0, 0, 240);
        gradient.addColorStop(0, Chart.helpers.color('#d1f1ec').alpha(1).rgbString());
        gradient.addColorStop(1, Chart.helpers.color('#d1f1ec').alpha(0.3).rgbString());

        var config = {
            type: 'line',
            data: {
                labels: labels,
                datasets: [{
                    label: "Visitor ",
                    backgroundColor: gradient,
                    borderColor: mUtil.getColor('success'),
                    borderWidth: 1,
                    pointBackgroundColor: Chart.helpers.color('#000000').alpha(0).rgbString(),
                    pointBorderColor: Chart.helpers.color('#000000').alpha(0).rgbString(),
                    pointHoverBackgroundColor: mUtil.getColor('danger'),
                    pointHoverBorderColor: Chart.helpers.color('#000000').alpha(0.1).rgbString(),
                    //fill: 'start',
                    data: values
                }]
            },
            options: {
                title: {
                    display: false,
                },
                tooltips: {
                    mode: 'nearest',
                    intersect: false,
                    position: 'nearest',
                    xPadding: 10,
                    yPadding: 10,
                    caretPadding: 10
                },
                legend: {
                    display: false
                },
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    xAxes: [{
                        display: true,
                        gridLines: false,
                        scaleLabel: {
                            display: false,
                            labelString: 'Month'
                        },
                        gridLines: {
                            offsetGridLines: true
                        },
                        ticks: {
                            beginAtZero: true,
                            padding: 10
                        }
                    }],
                    yAxes: [{
                        display: true,
                        gridLines: false,
                        scaleLabel: {
                            display: false,
                            labelString: 'Value'
                        },
                        ticks: {
                            beginAtZero: true,
                            userCallback: function (label, index, labels) {
                                if (Math.floor(label) === label) {
                                    return label;
                                }
                            }
                        },
                        gridLines: {
                            offsetGridLines: true
                        }
                    }]
                },
                elements: {
                    line: {
                        // tension: 0.0000001
                    },
                    point: {
                        radius: 4,
                        borderWidth: 12
                    }
                },
                layout: {
                    padding: {
                        left: 0,
                        right: 0,
                        top: 10,
                        bottom: 0
                    }
                }
            }
        };

        var chart = new Chart(ctx, config);
    }

    //== Bandwidth Charts 2.
    //** Based on Chartjs plugin - http://www.chartjs.org/
    var adWordsStat = function () {
        if ($('#m_chart_adwords_stats').length == 0) {
            return;
        }

        var ctx = document.getElementById("m_chart_adwords_stats").getContext("2d");

        var gradient = ctx.createLinearGradient(0, 0, 0, 240);
        gradient.addColorStop(0, Chart.helpers.color('#ffefce').alpha(1).rgbString());
        gradient.addColorStop(1, Chart.helpers.color('#ffefce').alpha(0.3).rgbString());

        var config = {
            type: 'line',
            data: {
                labels: ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October"],
                datasets: [{
                    label: "AdWord Clicks",
                    backgroundColor: mUtil.getColor('brand'),
                    borderColor: mUtil.getColor('brand'),
                    pointBackgroundColor: Chart.helpers.color('#000000').alpha(0).rgbString(),
                    pointBorderColor: Chart.helpers.color('#000000').alpha(0).rgbString(),
                    pointHoverBackgroundColor: mUtil.getColor('danger'),
                    pointHoverBorderColor: Chart.helpers.color('#000000').alpha(0.1).rgbString(),
                    data: [
                        12, 16, 9, 18, 13, 12, 18, 12, 15, 17
                    ]
                }, {
                    label: "AdWords Views",

                    backgroundColor: mUtil.getColor('accent'),
                    borderColor: mUtil.getColor('accent'),

                    pointBackgroundColor: Chart.helpers.color('#000000').alpha(0).rgbString(),
                    pointBorderColor: Chart.helpers.color('#000000').alpha(0).rgbString(),
                    pointHoverBackgroundColor: mUtil.getColor('danger'),
                    pointHoverBorderColor: Chart.helpers.color('#000000').alpha(0.1).rgbString(),
                    data: [
                        10, 14, 12, 16, 9, 11, 13, 9, 13, 15
                    ]
                }]
            },
            options: {
                title: {
                    display: false,
                },
                tooltips: {
                    mode: 'nearest',
                    intersect: false,
                    position: 'nearest',
                    xPadding: 10,
                    yPadding: 10,
                    caretPadding: 10
                },
                legend: {
                    display: false
                },
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    xAxes: [{
                        display: false,
                        gridLines: false,
                        scaleLabel: {
                            display: true,
                            labelString: 'Month'
                        },
                        ticks: {
                            beginAtZero: true,
                            padding: 10
                        }
                    }],
                    yAxes: [{
                        stacked: true,
                        display: false,
                        gridLines: false,
                        scaleLabel: {
                            display: true,
                            labelString: 'Value'
                        },
                        ticks: {
                            beginAtZero: true
                        }
                    }]
                },
                elements: {
                    line: {
                        // tension: 0.0000001
                    },
                    point: {
                        radius: 4,
                        borderWidth: 12
                    }
                },
                layout: {
                    padding: {
                        left: 0,
                        right: 0,
                        top: 10,
                        bottom: 0
                    }
                }
            }
        };

        var chart = new Chart(ctx, config);
    }

    //== Bandwidth Charts 2.
    //** Based on Chartjs plugin - http://www.chartjs.org/
    var financeSummary = function () {
        if ($('#m_chart_finance_summary').length == 0) {
            return;
        }

        var ctx = document.getElementById("m_chart_finance_summary").getContext("2d");

        var config = {
            type: 'line',
            data: {
                labels: ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October"],
                datasets: [{
                    label: "AdWords Views",
                    backgroundColor: mUtil.getColor('accent'),
                    borderColor: mUtil.getColor('accent'),
                    pointBackgroundColor: Chart.helpers.color('#000000').alpha(0).rgbString(),
                    pointBorderColor: Chart.helpers.color('#000000').alpha(0).rgbString(),
                    pointHoverBackgroundColor: mUtil.getColor('danger'),
                    pointHoverBorderColor: Chart.helpers.color('#000000').alpha(0.1).rgbString(),
                    data: [
                        10, 14, 12, 16, 9, 11, 13, 9, 13, 15
                    ]
                }]
            },
            options: {
                title: {
                    display: false,
                },
                tooltips: {
                    mode: 'nearest',
                    intersect: false,
                    position: 'nearest',
                    xPadding: 10,
                    yPadding: 10,
                    caretPadding: 10
                },
                legend: {
                    display: false
                },
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    xAxes: [{
                        display: false,
                        gridLines: false,
                        scaleLabel: {
                            display: true,
                            labelString: 'Month'
                        },
                        ticks: {
                            beginAtZero: true,
                            padding: 10
                        }
                    }],
                    yAxes: [{
                        display: false,
                        gridLines: false,
                        scaleLabel: {
                            display: true,
                            labelString: 'Value'
                        },
                        ticks: {
                            beginAtZero: true
                        }
                    }]
                },
                elements: {
                    line: {
                        // tension: 0.0000001
                    },
                    point: {
                        radius: 4,
                        borderWidth: 12
                    }
                },
                layout: {
                    padding: {
                        left: 0,
                        right: 0,
                        top: 10,
                        bottom: 0
                    }
                }
            }
        };

        var chart = new Chart(ctx, config);
    }

    //== Quick Stat Charts
    var quickStats = function () {

        var allSales = $('#m_chart_quick_stats_1').data('values');
        var todaysOrders = $('#m_chart_quick_stats_2').data('values');
        var udcCommission = $('#m_chart_quick_stats_3').data('values');
        var averageOrders = $('#m_chart_quick_stats_4').data('values');
        var deliveredOrders = $('#m_chart_quick_stats_5').data('values');
        var opepdOrders = $('#m_chart_quick_stats_6').data('values');

        var salesKpi = $('#m_chart_quick_stats_1').data('kpi-values');
        var transactionKpi = $('#m_chart_quick_stats_2').data('kpi-values');
        var commissionKpi = $('#m_chart_quick_stats_3').data('kpi-values');
        var deliveredOrdersKpi = $('#m_chart_quick_stats_5').data('kpi-values');
        var opepdOrdersKpi = $('#m_chart_quick_stats_6').data('kpi-values');
        var averageOrdersKpi = $('#m_chart_quick_stats_4').data('kpi-values');

        var allSalesLabels = $('#m_chart_quick_stats_1').data('labels');
        var todaysOrdersLabels = $('#m_chart_quick_stats_2').data('labels');
        var udcCommissionLabels = $('#m_chart_quick_stats_3').data('labels');
        var deliveredOrdersLabels = $('#m_chart_quick_stats_5').data('labels');
        var averageOrdersLabels = $('#m_chart_quick_stats_4').data('labels');
        var opepdOrdersLabels = $('#m_chart_quick_stats_6').data('labels');

        _initSparklineChart($('#m_chart_quick_stats_1'), allSales, allSalesLabels, mUtil.getColor('brand'), 1, '৳ ', salesKpi);
        _initSparklineChart($('#m_chart_quick_stats_2'), todaysOrders, todaysOrdersLabels, mUtil.getColor('danger'), 1, '৳ ', transactionKpi);
        _initSparklineChart($('#m_chart_quick_stats_3'), udcCommission, udcCommissionLabels, mUtil.getColor('success'), 1, '৳ ', commissionKpi);
        _initSparklineChart($('#m_chart_quick_stats_4'), averageOrders, averageOrdersLabels, mUtil.getColor('accent'), 1, '', averageOrdersKpi);
        _initSparklineChart($('#m_chart_quick_stats_5'), deliveredOrders, deliveredOrdersLabels, mUtil.getColor('accent'), 1, '', deliveredOrdersKpi);
        _initSparklineChart($('#m_chart_quick_stats_6'), opepdOrders, opepdOrdersLabels, mUtil.getColor('accent'), 1, '', opepdOrdersKpi);

    }


    var salePerDayChart = function(){

        var salesKpiValues = $('#sale_kpi').data('values');
        var salesKpiLabels = $('#sale_kpi').data('labels');
        var salesKpi = $('#sale_kpi').data('kpi-values');
        _initSparklineChart($('#sale_kpi'), salesKpiValues, salesKpiLabels, mUtil.getColor('accent'), 1, '৳ ', salesKpi);

    }

    var transactionPerDayChart = function(){

        var transactionKpiValues = $('#transaction_kpi').data('values');
        var transactionKpiLabels = $('#transaction_kpi').data('labels');
        var transactionKpi = $('#transaction_kpi').data('kpi-values');
        _initSparklineChart($('#transaction_kpi'), transactionKpiValues, transactionKpiLabels, mUtil.getColor('accent'), 1, '৳ ', transactionKpi);

    }

    var opepdChart = function(){

        var opepdKpiValues = $('#opepd_kpi').data('values');
        var opepdKpiLabels = $('#opepd_kpi').data('labels');
        var opepdKpi = $('#opepd_kpi').data('kpi-values');
        _initSparklineChart($('#opepd_kpi'), opepdKpiValues, opepdKpiLabels, mUtil.getColor('accent'), 1, '', opepdKpi);

    }

    var averageDeliveryTimeChart = function(){

        var averageDeliveryTimeKpiValues = $('#average_delivery_time_kpi').data('values');
        var averageDeliveryTimeKpiLabels = $('#average_delivery_time_kpi').data('labels');
        var averageDeliveryTimeKpi = $('#average_delivery_time_kpi').data('kpi-values');
        _initSparklineChart($('#average_delivery_time_kpi'), averageDeliveryTimeKpiValues, averageDeliveryTimeKpiLabels, mUtil.getColor('accent'), 1, '', averageDeliveryTimeKpi);

    }



    var daterangepickerInit = function () {
        if ($('#m_dashboard_daterangepicker').length == 0) {
            return;
        }

        var picker = $('#m_dashboard_daterangepicker');
        var start = moment();
        var end = moment();

        function cb(start, end, label) {
            var title = '';
            var range = '';

            if ((end - start) < 100) {
                title = 'Today:';
                range = start.format('MMM D');
            } else if (label == 'Yesterday') {
                title = 'Yesterday:';
                range = start.format('MMM D');
            } else {
                range = start.format('MMM D') + ' - ' + end.format('MMM D');
            }

            picker.find('.m-subheader__daterange-date').html(range);
            picker.find('.m-subheader__daterange-title').html(title);
        }

        picker.daterangepicker({
            startDate: start,
            endDate: end,
            opens: 'left',
            ranges: {
                'Today': [moment(), moment()],
                'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                'Last 7 Days': [moment().subtract(6, 'days'), moment()],
                'Last 30 Days': [moment().subtract(29, 'days'), moment()],
                'This Month': [moment().startOf('month'), moment().endOf('month')],
                'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
            }
        }, cb);

        cb(start, end, '');
    }

    var datatableLatestOrders = function () {
        if ($('#m_datatable_latest_orders').length === 0) {
            return;
        }

        var url = $('#m_datatable_latest_orders').data('url')
        var baseURL = $('#m_datatable_latest_orders').data('baseURL')

        var datatable = $('.m_datatable').mDatatable({
            data: {
                type: 'remote',
                source: {
                    read: {
                        url: url
                    }
                },
                pageSize: 10,
                saveState: {
                    cookie: false,
                    webstorage: true
                },
                serverPaging: true,
                serverFiltering: true,
                serverSorting: true
            },

            layout: {
                theme: 'default',
                class: '',
                scroll: true,
                height: 380,
                footer: false
            },

            sortable: true,

            filterable: false,

            pagination: true,

            columns: [{
                field: "order_code",
                title: "Order ID",
                filterable: false,
                width: 100,
                template: function (row) {
                    if (row.order_code == null) {
                        return '<a href="admin/udc/order-details/' + row.id + '">View Detail</a>';
                    } else {
                        return '<a href="admin/udc/order-details/' + row.id + '">' + row.order_code + '</a>';
                    }
                }
            }, {
                field: "created_at",
                title: "Order Date",
                sortable: 'desc',
                width: 100,
                template: function (row) {
                    return row.created_at;
                    // var time = new Date("" + row.created_at);
                    // var created_at = time.toLocaleString('en-BD', {
                    //     year: "numeric",
                    //     month: "numeric",
                    //     day: "numeric",
                    //     hour: 'numeric',
                    //     minute: 'numeric',
                    //     hour12: true
                    // });
                    // return created_at;
                }
            }, {
                field: "receiver_name",
                title: "UDC Agent",
                width: 100
            }, {
                field: "ep_name",
                title: "eCommerce Partners",
                width: 100
            }, {
                field: "lp_name",
                title: "Logistic Partners",
                width: 100,
                responsive: {
                    visible: 'lg'
                }
            }, {
                field: "status_badge",
                title: "Delivery Performance",
                width: 100,
                responsive: {
                    visible: 'lg'
                },
                template: function (row) {
                    var statusLabels = {1: "success", 2: "brand", 3: "warning", 4: "danger"}
                    var performanceData = {1: "Good", 2: "Average", 3: "Need Attention", 4: "Delayed"}
                    var process_time = ((row.process_time == 0) ? 1 : row.process_time) + ' Day' + ((row.process_time > 1) ? 's' : '');
                    return process_time + '<br><span class="m-badge m-badge--' + statusLabels[row.status_badge] + ' m-badge--wide">' + performanceData[row.status_badge] + '</span>';
                }
            }, {
                field: "status",
                title: "Status",
                width: 100,
                // callback function support for column rendering
                template: function (row) {
                    return row.status;
                }
            }]
        });
    }

    var dcDatatableLatestOrders = function () {
        if ($('#dc_datatable_latest_orders').length === 0) {
            return;
        }

        var url = $('#dc_datatable_latest_orders').data('url')
        var baseURL = $('#dc_datatable_latest_orders').data('baseURL')

        var datatable = $('.m_datatable').mDatatable({
            data: {
                type: 'remote',
                source: {
                    read: {
                        url: url
                    }
                },
                pageSize: 10,
                saveState: {
                    cookie: false,
                    webstorage: true
                },
                serverPaging: true,
                serverFiltering: true,
                serverSorting: true
            },

            layout: {
                theme: 'default',
                class: '',
                scroll: true,
                height: 380,
                footer: false
            },

            sortable: true,

            filterable: false,

            pagination: true,

            columns: [{
                field: "order_code",
                title: "Order ID",
                sortable: 'asc',
                filterable: false,
                width: 100,
                template: function (row) {
                    if (row.order_code == null) {
                        return '<a href="udc/order-details/' + row.id + '" target="_blank" >View Detail</a>';
                    } else {
                        return '<a href="udc/order-details/' + row.id + '" target="_blank" >' + row.order_code + '</a>';
                    }
                }
            }, {
                field: "created_at",
                title: "Order Date",
                width: 100,
                template: function (row) {
                    return row.created_at;
                }
            }, {
                field: "ep_name",
                title: "eCommerce Partners",
                width: 100
            }, {
                field: "lp_name",
                title: "Logistic Partners",
                width: 100,
                responsive: {
                    visible: 'lg'
                }
            }, {
                field: "status_badge",
                title: "Delivery Performance",
                width: 100,
                responsive: {
                    visible: 'lg'
                },
                template: function (row) {
                    var statusLabels = {1: "success", 2: "brand", 3: "warning", 4: "danger"}
                    var performanceData = {1: "Good", 2: "Average", 3: "Need Attention", 4: "Delayed"}
                    var process_time = ((row.process_time == 0) ? 1 : row.process_time) + ' Day' + ((row.process_time > 1) ? 's' : '');
                    return process_time + '<br><span class="m-badge m-badge--' + statusLabels[row.status_badge] + ' m-badge--wide">' + performanceData[row.status_badge] + '</span>';
                }
            }, {
                field: "status",
                title: "Status",
                width: 100,
                // callback function support for column rendering
                template: function (row) {
                    return row.status;
                }
            }]
        });
    }

    var epDatatableLatestOrders = function () {
        if ($('#ep_datatable_latest_orders').length === 0) {
            return;
        }

        var url = $('#ep_datatable_latest_orders').data('url')
        var baseURL = $('#ep_datatable_latest_orders').data('baseURL')

        var datatable = $('.m_datatable').mDatatable({
            data: {
                type: 'remote',
                source: {
                    read: {
                        url: url
                    }
                },
                pageSize: 10,
                saveState: {
                    cookie: false,
                    webstorage: true
                },
                serverPaging: true,
                serverFiltering: true,
                serverSorting: true
            },

            layout: {
                theme: 'default',
                class: '',
                scroll: true,
                height: 380,
                footer: false
            },

            sortable: true,

            filterable: false,

            pagination: true,

            columns: [{
                field: "order_code",
                title: "Order ID",
                sortable: 'asc',
                filterable: false,
                width: 100,
                template: function (row) {
                    if (row.order_code == null) {
                        return '<a href="ep/order-details/' + row.order_code + '" target="_blank">View Detail</a>';
                    } else {
                        return '<a href="ep/order-details/' + row.order_code + '" target="_blank">' + row.order_code + '</a>';
                    }
                }
            }, {
                field: "created_at",
                title: "Order Date",
                width: 100,
                template: function (row) {
                    return row.created_at;
                }
            }, {
                field: "receiver_name",
                title: "UDC Agent",
                width: 100
            }, {
                field: "lp_name",
                title: "Logistic Partners",
                width: 100,
                responsive: {
                    visible: 'lg'
                }
            }, {
                field: "status_badge",
                title: "Delivery Performance",
                width: 100,
                responsive: {
                    visible: 'lg'
                },
                template: function (row) {
                    var statusLabels = {1: "success", 2: "brand", 3: "warning", 4: "danger"}
                    var performanceData = {1: "Good", 2: "Average", 3: "Need Attention", 4: "Delayed"}
                    var process_time = ((row.process_time == 0) ? 1 : row.process_time) + ' Day' + ((row.process_time > 1) ? 's' : '');
                    return process_time + '<br><span class="m-badge m-badge--' + statusLabels[row.status_badge] + ' m-badge--wide">' + performanceData[row.status_badge] + '</span>';
                }
            }, {
                field: "status",
                title: "Status",
                width: 100,
                // callback function support for column rendering
                template: function (row) {
                    return row.status;
                }
            }]
        });
    }

    var lpDatatableLatestOrders = function () {
        if ($('#lp_datatable_latest_orders').length === 0) {
            return;
        }

        var url = $('#lp_datatable_latest_orders').data('url')
        var baseURL = $('#lp_datatable_latest_orders').data('baseURL')

        var datatable = $('.m_datatable').mDatatable({
            data: {
                type: 'remote',
                source: {
                    read: {
                        url: url
                    }
                },
                pageSize: 10,
                saveState: {
                    cookie: false,
                    webstorage: true
                },
                serverPaging: true,
                serverFiltering: true,
                serverSorting: true
            },

            layout: {
                theme: 'default',
                class: '',
                scroll: true,
                height: 380,
                footer: false
            },

            sortable: true,

            filterable: false,

            pagination: true,

            columns: [{
                field: "order_code",
                title: "Order ID",
                sortable: 'asc',
                filterable: false,
                width: 100,
                template: function (row) {
                    if (row.order_code == null) {
                        return '<a href="lp/order-details/' + row.order_code + '" target="_blank">View Detail</a>';
                    } else {
                        return '<a href="lp/order-details/' + row.order_code + '" target="_blank">' + row.order_code + '</a>';
                    }
                }
            }, {
                field: "created_at",
                title: "Order Date",
                width: 100,
                template: function (row) {
                    return row.created_at;
                }
            }, {
                field: "receiver_name",
                title: "UDC Agent",
                width: 100
            }, {
                field: "ep_name",
                title: "eCommerce Partners",
                width: 100
            }, {
                field: "status_badge",
                title: "Delivery Performance",
                width: 100,
                responsive: {
                    visible: 'lg'
                },
                template: function (row) {
                    var statusLabels = {1: "success", 2: "brand", 3: "warning", 4: "danger"}
                    var performanceData = {1: "Good", 2: "Average", 3: "Need Attention", 4: "Delayed"}
                    var process_time = ((row.process_time == 0) ? 1 : row.process_time) + ' Day' + ((row.process_time > 1) ? 's' : '');
                    return process_time + '<br><span class="m-badge m-badge--' + statusLabels[row.status_badge] + ' m-badge--wide">' + performanceData[row.status_badge] + '</span>';
                }
            }, {
                field: "status",
                title: "Status",
                width: 100,
                // callback function support for column rendering
                template: function (row) {
                    return row.status;
                }
            }]
        });
    }

    var calendarInit = function () {
        if ($('#m_calendar').length === 0) {
            return;
        }

        var todayDate = moment().startOf('day');
        var YM = todayDate.format('YYYY-MM');
        var YESTERDAY = todayDate.clone().subtract(1, 'day').format('YYYY-MM-DD');
        var TODAY = todayDate.format('YYYY-MM-DD');
        var TOMORROW = todayDate.clone().add(1, 'day').format('YYYY-MM-DD');

        $('#m_calendar').fullCalendar({
            header: {
                left: 'prev,next today',
                center: 'title',
                right: 'month,agendaWeek,agendaDay,listWeek'
            },
            editable: true,
            eventLimit: true, // allow "more" link when too many events
            navLinks: true,
            defaultDate: moment('2017-09-15'),
            events: [
                {
                    title: 'Meeting',
                    start: moment('2017-08-28'),
                    description: 'Lorem ipsum dolor sit incid idunt ut',
                    className: "m-fc-event--light m-fc-event--solid-warning"
                },
                {
                    title: 'Conference',
                    description: 'Lorem ipsum dolor incid idunt ut labore',
                    start: moment('2017-08-29T13:30:00'),
                    end: moment('2017-08-29T17:30:00'),
                    className: "m-fc-event--accent"
                },
                {
                    title: 'Dinner',
                    start: moment('2017-08-30'),
                    description: 'Lorem ipsum dolor sit tempor incid',
                    className: "m-fc-event--light  m-fc-event--solid-danger"
                },
                {
                    title: 'All Day Event',
                    start: moment('2017-09-01'),
                    description: 'Lorem ipsum dolor sit incid idunt ut',
                    className: "m-fc-event--danger m-fc-event--solid-focus"
                },
                {
                    title: 'Reporting',
                    description: 'Lorem ipsum dolor incid idunt ut labore',
                    start: moment('2017-09-03T13:30:00'),
                    end: moment('2017-09-04T17:30:00'),
                    className: "m-fc-event--accent"
                },
                {
                    title: 'Company Trip',
                    start: moment('2017-09-05'),
                    end: moment('2017-09-07'),
                    description: 'Lorem ipsum dolor sit tempor incid',
                    className: "m-fc-event--primary"
                },
                {
                    title: 'ICT Expo 2017 - Product Release',
                    start: moment('2017-09-09'),
                    description: 'Lorem ipsum dolor sit tempor inci',
                    className: "m-fc-event--light m-fc-event--solid-primary"
                },
                {
                    title: 'Dinner',
                    start: moment('2017-09-12'),
                    description: 'Lorem ipsum dolor sit amet, conse ctetur'
                },
                {
                    id: 999,
                    title: 'Repeating Event',
                    start: moment('2017-09-15T16:00:00'),
                    description: 'Lorem ipsum dolor sit ncididunt ut labore',
                    className: "m-fc-event--danger"
                },
                {
                    id: 1000,
                    title: 'Repeating Event',
                    description: 'Lorem ipsum dolor sit amet, labore',
                    start: moment('2017-09-18T19:00:00'),
                },
                {
                    title: 'Conference',
                    start: moment('2017-09-20T13:00:00'),
                    end: moment('2017-09-21T19:00:00'),
                    description: 'Lorem ipsum dolor eius mod tempor labore',
                    className: "m-fc-event--accent"
                },
                {
                    title: 'Meeting',
                    start: moment('2017-09-11'),
                    description: 'Lorem ipsum dolor eiu idunt ut labore'
                },
                {
                    title: 'Lunch',
                    start: moment('2017-09-18'),
                    className: "m-fc-event--info m-fc-event--solid-accent",
                    description: 'Lorem ipsum dolor sit amet, ut labore'
                },
                {
                    title: 'Meeting',
                    start: moment('2017-09-24'),
                    className: "m-fc-event--warning",
                    description: 'Lorem ipsum conse ctetur adipi scing'
                },
                {
                    title: 'Happy Hour',
                    start: moment('2017-09-24'),
                    className: "m-fc-event--light m-fc-event--solid-focus",
                    description: 'Lorem ipsum dolor sit amet, conse ctetur'
                },
                {
                    title: 'Dinner',
                    start: moment('2017-09-24'),
                    className: "m-fc-event--solid-focus m-fc-event--light",
                    description: 'Lorem ipsum dolor sit ctetur adipi scing'
                },
                {
                    title: 'Birthday Party',
                    start: moment('2017-09-24'),
                    className: "m-fc-event--primary",
                    description: 'Lorem ipsum dolor sit amet, scing'
                },
                {
                    title: 'Company Event',
                    start: moment('2017-09-24'),
                    className: "m-fc-event--danger",
                    description: 'Lorem ipsum dolor sit amet, scing'
                },
                {
                    title: 'Click for Google',
                    url: 'http://google.com/',
                    start: moment('2017-09-26'),
                    className: "m-fc-event--solid-info m-fc-event--light",
                    description: 'Lorem ipsum dolor sit amet, labore'
                }
            ],

            eventRender: function (event, element) {
                if (element.hasClass('fc-day-grid-event')) {
                    element.data('content', event.description);
                    element.data('placement', 'top');
                    mApp.initPopover(element);
                } else if (element.hasClass('fc-time-grid-event')) {
                    element.find('.fc-title').append('<div class="fc-description">' + event.description + '</div>');
                } else if (element.find('.fc-list-item-title').lenght !== 0) {
                    element.find('.fc-list-item-title').append('<div class="fc-description">' + event.description + '</div>');
                }
            }
        });
    }

    return {
        //== Init demos
        init: function () {
            // init charts
            dailySales();
            userStatistics();
            inactiveUserChart();
            cancellationOrderChart();
            monthlyAverageDelivery();
            profitShare();
            salesStats();
            ordersStats();
            salesByApps();
            latestUpdates();
            trendsStats();
            trendsStats2();
            latestTrendsMap();
            revenueChange();
            supportTickets();
            supportTickets2();
            activitiesChart();
            bandwidthChart1();
            bandwidthChart2();
            visitorChart();
            adWordsStat();
            financeSummary();
            quickStats();

            // init daterangepicker
            daterangepickerInit();

            // datatables
            datatableLatestOrders();
            dcDatatableLatestOrders();
            epDatatableLatestOrders();
            lpDatatableLatestOrders();

            // calendar
            calendarInit();
        },
        initActiveUserChart: function(){
            inactiveUserChart();
        },
        initCancelOrderChart: function(){
            cancellationOrderChart();
        },
        initEPStatisticsChart: function(){
            bandwidthChart2();
        },
        visitorsChart: function(){
            visitorChart();
        },
        salePerDayChart: function(){
            salePerDayChart();
        },
        transactionPerDayChart: function(){
            transactionPerDayChart();
        },
        opepdChart: function(){
            opepdChart();
        },
        averageDeliveryTimeChart: function(){
            averageDeliveryTimeChart();
        }
    };
}();

//== Class initialization on page load
jQuery(document).ready(function () {
    Dashboard.init();

    $(document).on('click', '.plx__nav-link', function (e) {
        e.preventDefault();
        var target = $(this).attr('href');
        $('.plx__nav-link').removeClass('active');
        $(this).addClass('active');
        $('.tab-pane').removeClass('active');
        $(target).addClass('active');

    })
});