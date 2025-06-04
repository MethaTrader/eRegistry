'use strict';

$(document).ready(function() {
	// Patient Chart
	if ($('#patient-chart').length > 0) {
		$.ajax({
			url: '/api/chart/patients', // API-эндпоинт, который возвращает данные в формате JSON
			method: 'GET',
			dataType: 'json',
			success: function(response) {
				// Проверяем, что ответ содержит нужные поля
				if (response && response.categories && response.series) {
					var sColStacked = {
						chart: {
							height: 230,
							type: 'bar',
							stacked: true,
							toolbar: {
								show: false,
							}
						},
						responsive: [{
							breakpoint: 480,
							options: {
								legend: {
									position: 'bottom',
									offsetX: -10,
									offsetY: 0
								}
							}
						}],
						plotOptions: {
							bar: {
								horizontal: false,
								columnWidth: '15%'
							},
						},
						dataLabels: {
							enabled: false
						},
						series: response.series, // данные из API
						xaxis: {
							categories: response.categories // категории (месяцы)
						}
					};

					var chart = new ApexCharts(
						document.querySelector("#patient-chart"),
						sColStacked
					);
					chart.render();
				} else {
					console.error("API returned invalid data format.");
				}
			},
			error: function(jqXHR, textStatus, errorThrown) {
				console.error("Error fetching chart data:", textStatus, errorThrown);
			}
		});
	}

	// Donut Chart (просто статический пример, можно оставить как есть)
	if ($('#donut-chart-dash').length > 0) {
		var donutChart = {
			chart: {
				height: 290,
				type: 'donut',
				toolbar: {
					show: false,
				}
			},
			plotOptions: {
				bar: {
					horizontal: false,
					columnWidth: '50%'
				},
			},
			dataLabels: {
				enabled: false
			},
			series: [44, 55, 41, 17],
			labels: [
				'18-25',
				'26-35',
				'36-45',
				'45+'
			],
			responsive: [{
				breakpoint: 480,
				options: {
					chart: {
						width: 200
					},
					legend: {
						position: 'bottom'
					}
				}
			}],
			legend: {
				position: 'bottom',
			}
		};

		var donut = new ApexCharts(
			document.querySelector("#donut-chart-dash"),
			donutChart
		);
		donut.render();
	}
});
