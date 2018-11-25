// Morris.js Charts sample data for SB Admin template

$(function() {

    // Area Chart
    Morris.Area({
        element: 'morris-area-chart',
        data: [{
            period: '2010 Q1',
            doc01: 2666,
            doc02: null,
            doc03: 2647
        }, {
            period: '2010 Q2',
            doc01: 2778,
            doc02: 2294,
            doc03: 2441
        }, {
            period: '2010 Q3',
            doc01: 4912,
            doc02: 1969,
            doc03: 2501
        }, {
            period: '2010 Q4',
            doc01: 3767,
            doc02: 3597,
            doc03: 5689
        }, {
            period: '2011 Q1',
            doc01: 6810,
            doc02: 1914,
            doc03: 2293
        }, {
            period: '2011 Q2',
            doc01: 5670,
            doc02: 4293,
            doc03: 1881
        }, {
            period: '2011 Q3',
            doc01: 4820,
            doc02: 3795,
            doc03: 1588
        }, {
            period: '2011 Q4',
            doc01: 15073,
            doc02: 5967,
            doc03: 5175
        }, {
            period: '2012 Q1',
            doc01: 10687,
            doc02: 4460,
            doc03: 2028
        }, {
            period: '2012 Q2',
            doc01: 8432,
            doc02: 5713,
            doc03: 1791
        }],
        xkey: 'period',
        ykeys: ['doc01', 'doc02', 'doc03'],
        labels: ['Orden Servicio', 'Documento 02', 'Documento 03'],
        pointSize: 2,
        hideHover: 'auto',
        resize: true
    });

    // Donut Chart
    Morris.Donut({
        element: 'morris-donut-chart',
        data: [{
            label: "OS pendientes",
            value: 10
        }, {
            label: "OS en proceso",
            value: 15
        }, {
            label: "OS culminadas",
            value: 45
        }],
        resize: true
    });

    // Line Chart
    Morris.Line({
        // ID of the element in which to draw the chart.
        element: 'morris-line-chart',
        // Chart data records -- each entry in this array corresponds to a point on
        // the chart.
        data: [{
            d: '2012-10-01',
            visits: 802
        }, {
            d: '2012-10-02',
            visits: 783
        }, {
            d: '2012-10-03',
            visits: 820
        }, {
            d: '2012-10-04',
            visits: 839
        }, {
            d: '2012-10-05',
            visits: 792
        }, {
            d: '2012-10-06',
            visits: 859
        }, {
            d: '2012-10-07',
            visits: 790
        }, {
            d: '2012-10-08',
            visits: 1680
        }, {
            d: '2012-10-09',
            visits: 1592
        }, {
            d: '2012-10-10',
            visits: 1420
        }, {
            d: '2012-10-11',
            visits: 882
        }, {
            d: '2012-10-12',
            visits: 889
        }, {
            d: '2012-10-13',
            visits: 819
        }, {
            d: '2012-10-14',
            visits: 849
        }, {
            d: '2012-10-15',
            visits: 870
        }, {
            d: '2012-10-16',
            visits: 1063
        }, {
            d: '2012-10-17',
            visits: 1192
        }, {
            d: '2012-10-18',
            visits: 1224
        }, {
            d: '2012-10-19',
            visits: 1329
        }, {
            d: '2012-10-20',
            visits: 1329
        }, {
            d: '2012-10-21',
            visits: 1239
        }, {
            d: '2012-10-22',
            visits: 1190
        }, {
            d: '2012-10-23',
            visits: 1312
        }, {
            d: '2012-10-24',
            visits: 1293
        }, {
            d: '2012-10-25',
            visits: 1283
        }, {
            d: '2012-10-26',
            visits: 1248
        }, {
            d: '2012-10-27',
            visits: 1323
        }, {
            d: '2012-10-28',
            visits: 1390
        }, {
            d: '2012-10-29',
            visits: 1420
        }, {
            d: '2012-10-30',
            visits: 1529
        }, {
            d: '2012-10-31',
            visits: 1892
        }, ],
        // The name of the data record attribute that contains x-visitss.
        xkey: 'd',
        // A list of names of data record attributes that contain y-visitss.
        ykeys: ['visits'],
        // Labels for the ykeys -- will be displayed when you hover over the
        // chart.
        labels: ['Visits'],
        // Disables line smoothing
        smooth: false,
        resize: true
    });

    // Bar Chart
    Morris.Bar({
        element: 'morris-bar-chart',
        data: [{
            device: 'doc01',
            geekbench: 136
        }, {
            device: 'doc01 3G',
            geekbench: 137
        }, {
            device: 'doc01 3GS',
            geekbench: 275
        }, {
            device: 'doc01 4',
            geekbench: 380
        }, {
            device: 'doc01 4S',
            geekbench: 655
        }, {
            device: 'doc01 5',
            geekbench: 1571
        }],
        xkey: 'device',
        ykeys: ['geekbench'],
        labels: ['Geekbench'],
        barRatio: 0.4,
        xLabelAngle: 35,
        hideHover: 'auto',
        resize: true
    });


});
