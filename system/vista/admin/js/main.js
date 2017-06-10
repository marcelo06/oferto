var chart;
var options;
$(document).ready(function() {	
	var fechai = $('#datepicker').val().split("-");
	// define the options
	options = {
		chart: {
			renderTo: 'container',
			defaultSeriesType: 'line'
		},
		title: {
			text: 'Visitas al sitio por día'
		},
		xAxis: { 
			type: 'datetime',
			title: {
				text: 'Días'
			}
		 },
		yAxis: {
			title: {
				text: 'Visitas'
			}
		},
		credits: {
		enabled: false
		},
		
		legend: {
			enabled: false
		},
		tooltip: {
			formatter: function() {
					return '<b>'+ Highcharts.dateFormat('%e. %b %Y', this.x) +'</b><br/>'+
					 this.y + ' Visitas';
			}
		},
		plotOptions: {
			line: {
				cursor: 'pointer',
				pointInterval: 24*60*60*1000, 
				pointStart: Date.UTC(fechai[0], fechai[1]-1, fechai[2], 0, 0, 0)

			}
		},
		series: []
	}
	
	cargar_stats();

	$('#datepicker').datepicker({
		       
				dateFormat : 'yy-mm-dd',
		        changeMonth: false,
			    changeYear: true,
			   
		       
		    });
	$('#datepicker2').datepicker({
		       
				dateFormat : 'yy-mm-dd',
		        changeMonth: false,
			    changeYear: true,
			   
		       
		    });

	
});

function cargar_stats(){
	
	var fechai = $('#datepicker').val().split("-");
	var fechaf = $('#datepicker2').val().split("-");
	if(Date.UTC(fechai[0], fechai[1]-1, fechai[2], 0, 0, 0) > Date.UTC(fechaf[0], fechaf[1]-1, fechaf[2], 0, 0, 0) ){
		alert('The start date must be less than the end date');
		return;
	}
	
	$('#cargar').val('Loading...').attr('disabled','disabled');
	
	jQuery.getJSON('pa-general', { fecha_desde : $('#datepicker').val() , fecha_hasta :  $('#datepicker2').val()}, function(data) {
		$('#visitas').html(data.visitas);
		$('#rebote').html(data.rebote);
		$('#tiempo').html(data.tiempo);
	});
	
	
	jQuery.getJSON('pa-visitas', { fecha_desde : $('#datepicker').val() , fecha_hasta :  $('#datepicker2').val()}, function(data) {
		
		options.series.length = 0;
		options.series.push({
			name: data.name,
			data: data.data
		});
		
		options.plotOptions.line.pointStart = Date.UTC(fechai[0], fechai[1]-1, fechai[2], 0, 0, 0);
		
		chart = new Highcharts.Chart(options);
		
		$('#cargar').val('Cargar').removeAttr('disabled');
	});
	
	$.get('pa-graph', { fecha_desde : $('#datepicker').val() , fecha_hasta :  $('#datepicker2').val(), tipo : 1}, function(data) {
			$('#referidos').html(data);
		}
	);
	
	$.get('pa-graph', { fecha_desde : $('#datepicker').val() , fecha_hasta :  $('#datepicker2').val(), tipo : 2}, function(data) {
			$('#paises').html(data);
		}
	);

}

