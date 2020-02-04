/**
* Theme: Montran Admin Template
* Author: Coderthemes
* Chart Js Page
* 
*/

!function($) {
    "use strict";

    function $_GET(param) {
        var vars = {};
        window.location.href.replace( 
        /[?&]+([^=&]+)=?([^&]*)?/gi, // regexp
        function( m, key, value ) { // callback
            vars[key] = value !== undefined ? value : '';
        }
        );

        if ( param ) {
            return vars[param] ? vars[param] : null;    
        }
        return vars;
    }

    var ChartJs = function() {};

    ChartJs.prototype.respChart = function respChart(selector,type,data, options) {
        // get selector by context
        var ctx = selector.get(0).getContext("2d");
        // pointing parent container to make chart js inherit its width
        var container = $(selector).parent();

        // enable resizing matter
        $(window).resize( generateChart );

        // this function produce the responsive Chart JS
        function generateChart(){
            // make chart width fit with its container
            var ww = selector.attr('width', $(container).width() );
            switch(type){
                case 'Line':
                new Chart(ctx).Line(data, {   multiTooltipTemplate: "<%= datasetLabel %> - <%= value %>"});
                break;
                case 'Doughnut':
                new Chart(ctx).Doughnut(data, options);
                break;
                case 'Pie':
                new Chart(ctx).Pie(data, options);
                break;
                case 'Bar':
                new Chart(ctx).Bar(data, options);
                break;
                case 'Radar':
                new Chart(ctx).Radar(data, options);
                break;
                case 'PolarArea':
                new Chart(ctx).PolarArea(data, options);
                break;
            }
            // Initiate new chart or Redraw

        };
        // run function - render chart at first load
        generateChart();
    },
    //init
    ChartJs.prototype.init = function() {
        //creating lineChart
        var request = new XMLHttpRequest();
        
        if ($_GET('year')) {
            var years = $_GET('year');            
        }else{
            var d = new Date();
            var years = d.getFullYear();
        }

        request.open("GET", "https://hijabkarani.com/dev/marketing/ajax_content/realisasi/"+years, false);
        request.send(null);
        var getRealisasi = JSON.parse(request.responseText);

        var request = new XMLHttpRequest();
        request.open("GET", "https://hijabkarani.com/dev/marketing/ajax_content/target/"+years, false);
        request.send(null);
        var getTarget = JSON.parse(request.responseText);

        var data = {
            labels : ["January","February","March","April","May","June","July","August","September","October","November","December"],
            datasets : [
            {
                label : "Realisasi",
                fillColor : "rgba(94, 53, 114, 0.3)",
                strokeColor : "rgba(94, 53, 114, 1)",
                pointColor : "#rgba(94, 53, 114, 1)",
                pointStrokeColor : "#fff",
                data : getRealisasi,
                multiTooltipTemplate : "<%=datasetLabel%> : <%= value %>",
            },

            {
                label : "Target",
                fillColor : "rgba(0, 177, 157, 0.5)",
                strokeColor : "#00b19d",
                pointColor : "#00b19d",
                pointStrokeColor : "#fff",
                data : getTarget
            }

            ]
        };
        
        this.respChart($("#lineChart"),'Line',data);

        //donut chart
        var data1 = [
        {
            value: 80,
            color:"#00b19d"
        },
        {
            value : 50,
            color : "#7e57c2"
        },
        {
            value : 80,
            color : "#ebeff2"
        },
        {
            value : 50,
            color : "#dcdcdc"
        }

        ]
        this.respChart($("#doughnut"),'Doughnut',data1);


        //Pie chart
        var data2 = [
        {
            value: 40,
            color:"#00b19d"
        },
        {
            value : 80,
            color : "#7e57c2"
        },
        {
            value : 70,
            color : "#ebeff2"
        }
        ]
        this.respChart($("#pie"),'Pie',data2);


        //barchart
        var data3 = {
            labels : ["January","February","March","April","May","June","July"],
            datasets : [
            {
                fillColor : "#7e57c2",
                strokeColor : "#7e57c2",
                data : [65,59,90,81,56,55,40]
            },
            {
                fillColor : "#ebeff2",
                strokeColor : "#ebeff2",
                data : [28,48,40,19,96,27,100]
            }
            ]
        }
        this.respChart($("#bar"),'Bar',data3);

        //radar chart
        var data4 = {
            labels : ["Eating","Drinking","Sleeping","Designing","Coding","Partying","Running"],
            datasets : [
            {
                fillColor : "rgba(0, 177, 157, 0.5)",
                strokeColor : "rgba(0, 177, 157, 0.75))",
                pointColor : "rgba(0, 177, 157, 1)",
                pointStrokeColor : "#fff",
                data : [65,59,90,81,56,55,40]
            },
            {
                fillColor : "rgba(220, 220, 220, 0.5)",
                strokeColor : "rgba(220, 220, 220, 0.75)",
                pointColor : "rgba(220, 220, 220,1)",
                pointStrokeColor : "#fff",
                data : [28,48,40,19,96,27,100]
            }
            ]
        }
        this.respChart($("#radar"),'Radar',data4);

        //Polar area chart
        var data5 = [
        {
            value : 30,
            color: "#00b19d"
        },
        {
            value : 90,
            color: "#bac3d2"
        },
        {
            value : 24,
            color: "#4697ce"
        },
        {
            value : 58,
            color: "#6c85bd"
        },
        {
            value : 82,
            color: "#7e57c2"
        },
        {
            value : 8,
            color: "#1ca8dd"
        }
        ]
        this.respChart($("#polarArea"),'PolarArea',data5);
    },
    $.ChartJs = new ChartJs, $.ChartJs.Constructor = ChartJs

}(window.jQuery),

//initializing 
function($) {
    "use strict";
    $.ChartJs.init()
}(window.jQuery);