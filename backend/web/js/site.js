jQuery('.show-form-search').click(function () {
    if (open) {
        jQuery('.search-form').css('display', 'block');
    }
    else {
        jQuery('.search-form').css('display', 'none');
    }
    open = !open;
});

$('#translation-owner_table').on('change', function () {
    $('#translation-form').submit();

})


$(".knob").knob({
    'min': 0,
    'max': 700,
    readOnly: true,
//    format : function (value) {
//     return value + '%';
//     },
    draw: function () {

        // "tron" case
        if (this.$.data('skin') === 'tron') {

            this.cursorExt = 0.3;

            var a = this.arc(this.cv)  // Arc
                    , pa                   // Previous arc
                    , r = 1;

            this.g.lineWidth = this.lineWidth;

            if (this.o.displayPrevious) {
                pa = this.arc(this.v);
                this.g.beginPath();
                this.g.strokeStyle = this.pColor;
                this.g.arc(this.xy, this.xy, this.radius - this.lineWidth, pa.s, pa.e, pa.d);
                this.g.stroke();
            }

            this.g.beginPath();
            this.g.strokeStyle = r ? this.o.fgColor : this.fgColor;
            this.g.arc(this.xy, this.xy, this.radius - this.lineWidth, a.s, a.e, a.d);
            this.g.stroke();

            this.g.lineWidth = 2;
            this.g.beginPath();
            this.g.strokeStyle = this.o.fgColor;
            this.g.arc(this.xy, this.xy, this.radius - this.lineWidth + 1 + this.lineWidth * 2 / 3, 0, 2 * Math.PI, false);
            this.g.stroke();

            return false;
        }
    }
});
Chart.defaults.global.legend.display = false;
var confixbarChart = {
    type: 'bar',
    data: {
        labels: ["Eating", "Drinking", "Sleeping", "Designing", "Coding", "Cycling", "Running"],
        datasets: [
            {
                label: "My First dataset",
                backgroundColor: "#00a65a",
                data: [65, 59, 90, 81, 56, 55, 40]
            }
        ]
    },
    options: {
        legendTemplate: "<ul class=\"<%=name.toLowerCase()%>-legend\"><% for (var i=0; i<datasets.length; i++){%><li><span style=\"background-color:<%=datasets[i].fillColor%>\"></span><%if(datasets[i].label){%><%=datasets[i].label%><%}%></li><%}%></ul>"
    }
};

var ctxbarChart = document.getElementById("barChart").getContext("2d");
var myBarChart = new Chart(ctxbarChart, confixbarChart);
// HORIZONTAL CHART
var config = {
    type: 'horizontalBar',
    data: {
        labels: ["Eating", "Drinking", "Sleeping", "Designing", "Coding", "Cycling", "Running"],
        datasets: [{
                label: "My First dataset",
                backgroundColor: '#666666',
                data: [65, 59, 90, 81, 56, 55, 40]
            }, {
                label: "My Second dataset",
                backgroundColor: '#00a65a',
                data: [28, 48, 40, 19, 96, 27, 100]
            }]
    },
    options: {
        legendTemplate: "<ul class=\"<%=name.toLowerCase()%>-legend\"><% for (var i=0; i<datasets.length; i++){%><li><span style=\"background-color:<%=datasets[i].fillColor%>\"></span><%if(datasets[i].label){%><%=datasets[i].label%><%}%></li><%}%></ul>"
    }
};
var ctxhorizontalChart = document.getElementById("horizontal-chart").getContext("2d");
var horizontalChart = new Chart(ctxhorizontalChart, config);
