'use strict';

$(document).ready(function() {
	let currentChart = null;

	// Patient Chart with enhanced design and year filter
	if ($('#patient-chart').length > 0) {
		// Load chart with current year on page load
		loadPatientChart(new Date().getFullYear());

		// Handle year selector change
		$('#yearSelector').on('change', function() {
			const selectedYear = $(this).val();
			console.log('Year changed to:', selectedYear); // Debug log
			loadPatientChart(selectedYear);
		});
	}

	function loadPatientChart(year) {
		console.log('Loading chart for year:', year); // Debug log
		// Show loading state
		showChartLoading();

		$.ajax({
			url: '/api/chart/patients',
			method: 'GET',
			data: { year: year },
			dataType: 'json',
			success: function(response) {
				console.log('Chart data received:', response); // Debug log
				if (response && response.categories && response.series) {
					renderPatientChart(response);
					updateGenderPercentages(response.series);
				} else {
					console.error('Invalid data format:', response);
					showChartError('Invalid data format received');
				}
			},
			error: function(jqXHR, textStatus, errorThrown) {
				console.error("Error fetching chart data:", textStatus, errorThrown);
				console.error("Response:", jqXHR.responseText);
				showChartError('Failed to load chart data. Please try again.');
			}
		});
	}

	function renderPatientChart(data) {
		// Destroy existing chart if it exists
		if (currentChart) {
			currentChart.destroy();
			currentChart = null;
		}

		const chartConfig = {
			chart: {
				height: 380,
				type: 'bar',
				stacked: true,
				toolbar: {
					show: true,
					tools: {
						download: true,
						selection: false,
						zoom: false,
						zoomin: false,
						zoomout: false,
						pan: false,
						reset: false
					}
				},
				animations: {
					enabled: true,
					easing: 'easeinout',
					speed: 1000,
					animateGradually: {
						enabled: true,
						delay: 150
					},
					dynamicAnimation: {
						enabled: true,
						speed: 350
					}
				},
				fontFamily: 'Inter, -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif',
				dropShadow: {
					enabled: false
				},
				background: 'transparent'
			},
			responsive: [{
				breakpoint: 768,
				options: {
					chart: {
						height: 320
					},
					legend: {
						position: 'bottom',
						offsetY: 10
					}
				}
			}, {
				breakpoint: 480,
				options: {
					chart: {
						height: 280
					},
					plotOptions: {
						bar: {
							columnWidth: '80%'
						}
					}
				}
			}],
			plotOptions: {
				bar: {
					horizontal: false,
					columnWidth: '55%',
					borderRadius: 6,
					borderRadiusApplication: 'end',
					borderRadiusWhenStacked: 'last',
					dataLabels: {
						total: {
							enabled: true,
							offsetY: -5,
							style: {
								fontSize: '12px',
								fontWeight: 600,
								color: '#374151'
							}
						}
					}
				}
			},
			dataLabels: {
				enabled: false
			},
			series: data.series,
			colors: ['#667eea', '#f093fb'],
			xaxis: {
				categories: data.categories,
				labels: {
					style: {
						colors: '#64748b',
						fontSize: '12px',
						fontWeight: 500
					}
				},
				axisBorder: {
					show: false
				},
				axisTicks: {
					show: false
				}
			},
			yaxis: {
				labels: {
					style: {
						colors: '#64748b',
						fontSize: '12px',
						fontWeight: 500
					},
					formatter: function(value) {
						return Math.floor(value);
					}
				},
				title: {
					text: 'Number of Patients',
					style: {
						color: '#64748b',
						fontSize: '13px',
						fontWeight: 600
					}
				}
			},
			legend: {
				show: true,
				position: 'top',
				horizontalAlign: 'right',
				fontSize: '13px',
				fontWeight: 500,
				offsetY: -5,
				markers: {
					width: 8,
					height: 8,
					radius: 4
				},
				itemMargin: {
					horizontal: 12,
					vertical: 0
				}
			},
			grid: {
				show: true,
				borderColor: '#e2e8f0',
				strokeDashArray: 2,
				position: 'back',
				xaxis: {
					lines: {
						show: false
					}
				},
				yaxis: {
					lines: {
						show: true
					}
				},
				padding: {
					top: 0,
					right: 0,
					bottom: 0,
					left: 10
				}
			},
			fill: {
				type: 'gradient',
				gradient: {
					shade: 'light',
					type: 'vertical',
					shadeIntensity: 0.2,
					gradientToColors: ['#764ba2', '#f093fb'],
					inverseColors: false,
					opacityFrom: 0.9,
					opacityTo: 1,
					stops: [0, 100]
				}
			},
			tooltip: {
				enabled: true,
				shared: true,
				intersect: false,
				theme: 'light',
				style: {
					fontSize: '13px',
					fontFamily: 'Inter, sans-serif'
				},
				x: {
					show: true
				},
				y: {
					formatter: function(value, { series, seriesIndex, dataPointIndex, w }) {
						return value + ' patient' + (value !== 1 ? 's' : '');
					}
				},
				marker: {
					show: true
				}
			},
			states: {
				hover: {
					filter: {
						type: 'lighten',
						value: 0.1
					}
				},
				active: {
					allowMultipleDataPointsSelection: false,
					filter: {
						type: 'darken',
						value: 0.2
					}
				}
			}
		};

		try {
			currentChart = new ApexCharts(document.querySelector("#patient-chart"), chartConfig);
			currentChart.render().then(() => {
				console.log('Chart rendered successfully');
				hideChartLoading();
			}).catch((error) => {
				console.error('Error rendering chart:', error);
				showChartError('Error rendering chart');
			});
		} catch (error) {
			console.error('Error creating chart:', error);
			showChartError('Error creating chart');
		}
	}

	function updateGenderPercentages(series) {
		try {
			const maleData = series.find(s => s.name === 'Male');
			const femaleData = series.find(s => s.name === 'Female');

			if (maleData && femaleData) {
				const totalMale = maleData.data.reduce((sum, val) => sum + val, 0);
				const totalFemale = femaleData.data.reduce((sum, val) => sum + val, 0);
				const total = totalMale + totalFemale;

				if (total > 0) {
					const malePercent = Math.round((totalMale / total) * 100);
					const femalePercent = Math.round((totalFemale / total) * 100);

					$('#male-percent').text(malePercent + '%');
					$('#female-percent').text(femalePercent + '%');
				} else {
					$('#male-percent').text('0%');
					$('#female-percent').text('0%');
				}
			}
		} catch (error) {
			console.error('Error updating gender percentages:', error);
			$('#male-percent').text('N/A');
			$('#female-percent').text('N/A');
		}
	}

	function showChartLoading() {
		$('#patient-chart').html(`
            <div class="chart-loading" style="display: flex; justify-content: center; align-items: center; height: 380px; flex-direction: column;">
                <div class="spinner-border text-primary" role="status" style="width: 3rem; height: 3rem;">
                    <span class="visually-hidden">Loading...</span>
                </div>
                <p class="mt-3 text-muted mb-0">Loading chart data...</p>
            </div>
        `);
	}

	function hideChartLoading() {
		$('.chart-loading').remove();
	}

	function showChartError(message) {
		$('#patient-chart').html(`
            <div class="chart-error" style="display: flex; justify-content: center; align-items: center; height: 380px; flex-direction: column;">
                <i class="fas fa-exclamation-triangle text-warning" style="font-size: 3rem; margin-bottom: 1rem;"></i>
                <p class="text-muted mb-3">${message}</p>
                <button class="btn btn-primary btn-sm" onclick="location.reload()">
                    <i class="fas fa-redo me-1"></i> Retry
                </button>
            </div>
        `);
	}

	// Initialize year selector styling
	function initYearSelector() {
		// Add custom styling or behavior if needed
		$('#yearSelector').addClass('fade-in');
	}

	// Call initialization
	initYearSelector();
});