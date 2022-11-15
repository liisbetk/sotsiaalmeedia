// (function(drupalSettings, $ , Drupal){

(function ($, Drupal) {
  Drupal.behaviors.EpicCharts = {
    attach: function (context, settings) {
      $('#chart', context).once('ChartIt').each(function () {
        google.charts.load('current', {'packages': ['corechart']});
        google.charts.setOnLoadCallback(drawChart);

        function drawChart() {
          var data = google.visualization.arrayToDataTable([
            ['Social media network', 'Clicks'],
            ['Facebook', parseInt(drupalSettings.chart_data.facebook)],
            ['Linkedin', parseInt(drupalSettings.chart_data.linkedin)],
            ['Twitter', parseInt(drupalSettings.chart_data.twitter)],
            ['Google', parseInt(drupalSettings.chart_data.google)]
          ]);

          var options = {
            title: 'Clicked Social media links'
          };

          var chart = new google.visualization.BarChart(document.getElementById('chart'));

          chart.draw(data, options);
        }
      });
    }
  };
})(jQuery, Drupal);


// })(drupalSettings)