function formatNumber(number){
    number = number.toString().replace(/,/g, '');
    number = parseInt(number);
    return number.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
}
function timeFormatToSeconds(time){
    var seconds = 0;
    if(time != ""){
        var tmp = time.split(":");
        seconds = (+tmp[0]) * 60 * 60 + (+tmp[1]) * 60 + (+tmp[2]);
    }
    return seconds;
}
var meses = ["Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre"];
function getMes(d, cortos){
    while(d >= meses.length)
        d = d - meses.length;
    return !cortos ? meses[d] : meses[d].substr(0,3);
}
function getMaxYValue (data) {
    var max = 0;
    for(var i in data)
        max = data[i].y > max ? data[i].y : max;
    return max;
}
function getMargins(){
    var margins = {top: 10, right: 50, bottom: 50, left: 100},
        windowWidth = $(window).width();
    if(windowWidth <= 720)
        margins = {top: 10, right: 10, bottom: 20, left: 80}
    if(windowWidth <= 480)
        margins = {top: 10, right: 10, bottom: 20, left: 30}

    return margins;
}
function getSliderWidth(){
    var width = 600,
        windowWidth = $(window).width();
    if(windowWidth <= 1199)
        width = 500;
    if(windowWidth <= 979)
        width = 400;
    if(windowWidth <= 767)
        width = 480;
    if(windowWidth <= 480)
        width = 300;


    return width;
}
(function($){
    var e = {
        init : function(){
            this.numeroAtenciones = na.init();
            this.visitasSitio = vs.init();
            this.atencionesRegiones = ar.init();
            this.evolucionTiempoEspera = et.init();
            this.evolucionSucursales = es.init();
            this.numeroComunas = nc.init();
            this.evolucionCrecimiento = ec.init();
            return this;
        }
    };

    var na = {
        loadData : function(){
            na.data = [];
            return $.getJSON(na.dataUrl, function(data){
                var sinDatos = 0;
                for(var i = 0; i < data.length; i++){
                    sinDatos = !parseInt(data[i]["oficina"])
                        && !parseInt(data[i]["oficina"])
                        && !parseInt(data[i]["oficina"])
                        ? 1 : 0;
                    na.data[data[i].periodo] = [
                        {
                            "name" : "Canal presencial",
                            "value" : parseInt(data[i]["oficina"]),
                            "color" : "#01a0db"
                        },
                        {
                            "name" : "Canal digital",
                            "value" : parseInt(data[i]["online"]),
                            "color" : "#7cba2c"
                        },
                        {
                            "name" : "Canal telefónico",
                            "value" : parseInt(data[i]["callcenter"]),
                            "color" : "#f6be45"
                        },
                        {
                            "name" : "Sin datos",
                            "value" : parseInt(sinDatos),
                            "color" : "#333333"
                        }
                    ];
                }
            });
        },
        calculaTamanoContenedores: function (year) {
            var contPie = na.container.find('#cont-pie-'+year).first(),
                w = h = contPie.width();
            return {x:w, y:h};
        },
        drawContainer: function (year) {
            var cont = na.container.find('.row-fluid');
            var template = '<div class="cont-pie-graph span4" id="cont-pie-'+year+'">'+
                                '<svg id="pie-'+year+'" class="pie-chart"></svg>'+
                                '<div class="cont-info-chart"></div>'+
                                '<div class="cont-info-bajada-chart">'+
                                    '<h3>'+year+'</h3>'+
                                '</div>'+
                            '</div>';
            cont.append(template);
        },
        drawChart: function (year) {
            nv.addGraph(function(){
                var size = na.calculaTamanoContenedores(year),
                    w = size.x,
                    h = size.y;

                na.charts[year] = nv.models.pieChart()
                    .x(function(d) { return d.name; })
                    .y(function(d) { return d.value; })
                    .color(function(d) { return d.data.color; })
                    .width(w)
                    .height(h)
                    .margin({top: 0, right: 0, bottom: 0, left: 0})
                    .showLegend(false)
                    .showLabels(false)
                    .donut(true)
                    .tooltipContent(function(k, y, x, graph){
                        var atenciones = formatNumber(y);
                        if(k.indexOf('digital') > 0)
                            k += '<br><small>(visitas sitio web)</small>';
                        return '<div><h2>'+atenciones+'</h2><h4> '+k+'</h4></div>';
                    });

                d3.select("#pie-"+year)
                    .datum(na.data[year])
                    .transition().duration(1200)
                    .attr('width', w)
                    .attr('height', h)
                    .call(na.charts[year]);

                return na.charts[year];
            });
        },
        drawChartInfo: function (year) {
            var total = 0,
                container = $('#cont-pie-'+year+' .cont-info-chart'),
                text = "";
            for(var i = 0; i < na.data[year].length; i++){
                total += na.data[year][i].value;
            }
            if(total == 1){
                text = "<h5>Sin datos</h5>";
                text += "<h6>disponibles</h6>"
            }else{
                text = "<h5>"+formatNumber(total)+"</h5>";
                text += "<h6>atenciones</h6>"
            }
            container.html(text);
        },
        disableCharts: function () {
            na.container.find('.cont-pie-graph.disabled').each(function(){
                var elem = $(this);
                elem.append('<div class="disable-chart"></div>');
            });
        },
        bindEvents : function(){
            $(window).on('resize', function(){
                if(na.charts.length){
                    for(var i in na.charts){
                        na.updateChart(i);
                    }
                }
            });
        },
        updateChart : function(i){
            var size = na.calculaTamanoContenedores(i),
                container = $('#cont-pie-'+ i +' .cont-info-chart');

            if(na.charts.length && na.charts[i]){
                na.charts[i].width(size.x).height(size.y);
                na.charts[i].update();
            }

            container.css({
                'top' : ((size.y/2) - (container.height() / 2))+"px",
                'left' : ((size.x/2) - (container.width() / 2))+"px"
            });
        },
        init : function(){
            na.dataUrl = site_url+"estadisticas/loadData/num-atenciones";
            na.charts = [];
            this.container = $('#cont-nun-atenciones');
            $.when(this.loadData()).then(function(){
                for(var i in na.data){
                    na.drawContainer(i);
                    na.drawChart(i);
                    na.drawChartInfo(i);
                    na.updateChart(i);
                }
                na.disableCharts();
                na.bindEvents();
            });
            return na;
        }
    }

    var vs = {
        loadData : function(){
            var x = 0;
            vs.data = [];
            vs.sliderData = [{
                "key" : "Visitas",
                "values" : [],
                "color" : "#01a0db",
                area : true
            }];
            vs.originalValues = [];
            return $.getJSON(vs.dataUrl, function(data){
                vs.sliderMaxData = data.length - 1;
                for(var i = 0; i < data.length; i++){
                    vs.sliderData[0].values.push({
                        "series" : 0,
                        "x" : i,
                        "y" : parseInt(data[i].cantidad),
                        "periodo" : data[i].periodo,
                        "mes" : data[i].mes
                    });
                    vs.originalValues.push({
                        "series" : 0,
                        "x" : i,
                        "y" : parseInt(data[i].cantidad),
                        "periodo" : data[i].periodo,
                        "mes" : data[i].mes
                    });
                }
            });
        },
        getLabels : function(d, i){
            var label = formatNumber(d),
                windowWidth = $(window).width();
            if(windowWidth <= 480 && i != undefined)
                label = (d/1000000).toFixed(1) + "m";

            return label;
        },
        drawChart : function(){
            nv.addGraph(function(){
                vs.chart = nv.models.lineChart()
                    .margin(getMargins())
                    .height(300)
                    .showYAxis(true)
                    .x(function(d,i) { return i; })
                    .showLegend(false)
                    .transitionDuration(250)
                    .yDomain([0, getMaxYValue(vs.sliderData[0].values)])
                    .tooltipContent(function(k, y, x, graph){
                        return '<div><h2>'+x+'</h2><h4> Visitas</h4></div>';
                    });

                vs.chart.yAxis
                    .axisLabel('Número Visitas')
                    .tickFormat(function(d, i){
                        value = vs.getLabels(d, i);
                        return value;
                    });

                vs.chart.xAxis
                    .tickFormat(function(d, i){
                        return getMes(vs.sliderDesde + d, true);
                    });

                d3.select('#line-evolucion-visitas')
                    .datum(vs.sliderData)
                    .call(vs.chart);

                return vs.chart;
            });
        },
        updateChart: function () {
            vs.sliderData[0].values = [];
            for(var i = vs.sliderDesde; i <= vs.sliderHasta; i++){
                vs.sliderData[0].values.push(vs.originalValues[i]);
            }
            vs.chart.yDomain([0, getMaxYValue(vs.sliderData[0].values)]);
            vs.chart.margin(getMargins());
            vs.chart.update();
        },
        bindEvents: function () {
            vs.slider.slider().on('slideStop', function(e){
                vs.sliderDesde = e.value[0];
                vs.sliderHasta = e.value[1];
                vs.updateChart();
            });
            $(window).on('resize', function(){
                if(vs.chart){
                    vs.updateChart();
                    vs.updateSlider();
                }
            });
        },
        updateSlider : function(){
            var container = vs.slider.parents('.slider-horizontal');
            container.width(getSliderWidth());
        },
        initSlider: function () {
            vs.sliderDesde = vs.sliderMinData;
            vs.sliderHasta = vs.sliderMaxData;
            vs.slider.slider({
                "min" : vs.sliderMinData,
                "max" : vs.sliderMaxData,
                "value" : [vs.sliderMinData, vs.sliderMaxData],
                "tooltip" : 'show',
                "formater" : function(value){
                    return vs.originalValues[value].mes + ' de ' + vs.originalValues[value].periodo;
                }
            });
        },
        init : function(){
            this.container = $('.info-evolucion-visitas');
            this.slider = $('#slider-evolucion-visitas');
            vs.chart = null;
            vs.sliderMinData = 0;
            vs.sliderMaxData = 0;
            vs.sliderDesde = 0;
            vs.sliderHasta = 0;
            vs.dataUrl = site_url+"estadisticas/loadData/visitas-sitio";
            $.when(this.loadData()).then(function(){
                vs.drawChart();
                vs.initSlider();
                vs.bindEvents();
            });
            return this;
        }
    };

    var et = {
        loadData : function(){
            var x = 0;
            et.data = [];
            et.sliderData = [{
                    "key" : "IPS",
                    "values" : [],
                    "color" : "#F6BE45",
                    area : true
                },
                {
                    "key" : "Chileatiende",
                    "values" : [],
                    "color" : "#01a0db",
                    area : true
                }
            ];
            et.originalValues = [];
            et.originalValues[0] = [];
            et.originalValues[1] = [];
            return $.getJSON(et.dataUrl, function(data){
                et.sliderMaxData = data.length - 1;
                for(var i = 0; i < data.length; i++){
                    //Se deben llenar ambas secciones
                    et.sliderData[0].values[i] = {
                        "series" : 0,
                        "x" : i,
                        "y" : 0,
                        "periodo" : data[i].periodo,
                        "mes" : data[i].mes
                    }

                    et.sliderData[1].values[i] = {
                        "series" : 0,
                        "x" : i,
                        "y" : 0,
                        "periodo" : data[i].periodo,
                        "mes" : data[i].mes
                    }

                    //Revisa si es data de chileatiende o de IPS
                    seccion = (parseInt(data[i].periodo) >= 2012) ? 1 : 0;

                    et.sliderData[seccion].values[i] = {
                        "series" : 0,
                        "x" : i,
                        "y" : timeFormatToSeconds(data[i].presencial),
                        "periodo" : data[i].periodo,
                        "mes" : data[i].mes
                    };

                    et.originalValues[0].push(et.sliderData[0].values[i]);
                    et.originalValues[1].push(et.sliderData[1].values[i]);
                }
            });
        },
        drawChart : function(){
            nv.addGraph(function(){
                et.chart = nv.models.lineChart()
                    .margin(getMargins())
                    .height(300)
                    .showYAxis(true)
                    .x(function(d,i) { return i; })
                    .transitionDuration(250)
                    .yDomain([5, getMaxYValue(et.sliderData[0].values)])
                    .tooltipContent(function(k, y, x, graph){
                        return '<div><h2>'+x+'</h2><h4> Minutos</h4></div>';
                    });

                et.chart.yAxis
                    .axisLabel('Minutos')
                    .axisLabelDistance(30)
                    .tickFormat(function(d, i){
                        var minutos = (d/60).toFixed(1);
                        return minutos;
                    });

                et.chart.xAxis
                    .tickFormat(function(d, i){
                        return getMes(et.sliderDesde + d, true);
                    });

                d3.select('#line-evolucion-tiempo-espera')
                    .datum(et.sliderData)
                    .call(et.chart);

                et.updateChart();

                return et.chart;
            });
        },
        initSlider: function () {
            et.sliderDesde = et.sliderMinData;
            et.sliderHasta = et.sliderMaxData;
            et.slider.slider({
                "min" : et.sliderMinData,
                "max" : et.sliderMaxData,
                "value" : [et.sliderMinData, et.sliderMaxData],
                "tooltip" : 'show',
                "formater" : function(value){
                    return et.originalValues[0][value].mes + ' de ' + et.originalValues[0][value].periodo;
                }
            });
        },
        updateChart: function () {
            et.sliderData[0].values = [];
            et.sliderData[1].values = [];
            for(var i = et.sliderDesde; i <= et.sliderHasta; i++){
                et.sliderData[0].values.push(et.originalValues[0][i]);
                et.sliderData[1].values.push(et.originalValues[1][i]);
            }
            var maxIps = getMaxYValue(et.sliderData[0].values),
                maxCha = getMaxYValue(et.sliderData[1].values);
            et.chart.yDomain([0, (maxIps > maxCha ? maxIps : maxCha)]);
            et.chart.margin(getMargins());
            et.chart.update();
        },
        bindEvents: function () {
            et.slider.slider().on('slideStop', function(e){
                et.sliderDesde = e.value[0];
                et.sliderHasta = e.value[1];
                et.updateChart();
            });
            $(window).on('resize', function(){
                if(et.chart){
                    et.updateChart();
                    et.updateSlider();
                }
            });
        },
        updateSlider : function(){
            var container = et.slider.parents('.slider-horizontal');
            container.width(getSliderWidth());
        },
        init : function(){
            et.chart = null;
            et.dataUrl = site_url+"estadisticas/loadData/tiempo-espera";
            et.container = $('.info-evolucion-tiempo-espera');
            et.slider = $('#slider-evolucion-tiempo-espera');
            et.sliderMinData = 0;
            et.sliderMaxData = 0;
            et.sliderDesde = 0;
            et.sliderHasta = 0;
            $.when(et.loadData()).then(function(){
                et.drawChart();
                et.initSlider();
                et.bindEvents();
            });
            return et;
        }
    };

    var ar = {
        obtieneDataAgrupada : function(){
            var total = 0,
                mes = ar.selectedMes,
                region = "Todos";

            if(ar.data[ar.selectedPeriodo]){
                if(!ar.regionActiva){
                    total = ar.data[ar.selectedPeriodo][mes]["Todos"].cantidad;
                } else {
                    total = ar.data[ar.selectedPeriodo][mes][ar.regionActiva.id].cantidad;
                    region = ar.regionActiva.id;
                }
            }

            if(total > 0)
                return {
                    "cantidad" : total,
                    "nombre" : ar.data[ar.selectedPeriodo][mes][region].nombre
                };
            else
                return null;
        },
        muestraInfoRegion: function () {
            var dataRegion,
                textoInfo,
                region = ar.regionActiva ? ar.regionActiva.id : "Todos",
                mes = ar.selectedMes ? ar.selectedMes : "Todos";

            if(!ar.data[ar.selectedPeriodo])
                return false;

            if(mes == "Todos"){
                textoInfo = "atenciones<br>durante "+ar.selectedPeriodo;
                dataRegion = ar.obtieneDataAgrupada();
            }else{
                textoInfo = "atenciones durante<br>"+ar.selectedMes+" de "+ar.selectedPeriodo;
                dataRegion = ar.data[ar.selectedPeriodo][ar.selectedMes][region];
            }

            $.when(ar.escondeInfoRegion()).then(function(){
                if(!dataRegion)
                    return false;

                var /*size = ar.regionActiva.getBoundingClientRect(),*/
                    cantidad = isNaN(dataRegion.cantidad) ? 'Sin datos' : formatNumber(dataRegion.cantidad),
                    nombre = dataRegion.nombre;
                ar.tooltip.find('.nombre-region').html(nombre);
                ar.tooltip.find('.cant-atenciones').html(cantidad);
                ar.tooltip.find('.text-atenciones').html(textoInfo);
                ar.tooltip.fadeIn(200);
            });
        },
        escondeInfoRegion : function(){
            return ar.tooltip.fadeOut(200);
        },
        actualizaTablaInstituciones: function () {
            var tabla = "",
                region = ar.regionActiva ? ar.regionActiva.id : "Todos",
                mes = ar.selectedMes ? ar.selectedMes : "Todos";

            if(ar.dataInst[ar.selectedPeriodo][mes]){
                var data = ar.dataInst[ar.selectedPeriodo][mes][region];

                for(var i in data){
                    if(!isNaN(data[i].atenciones))
                        tabla += "<tr><td>"+data[i].institucion+"</td><td align='right'>"+formatNumber(data[i].atenciones)+"</td></tr>";
                }
            }

            if(tabla == ""){
                tabla = "<tr><td colspan='2' class='no-data'><strong>No hay información disponible</strong></td></tr>";
            }
            ar.tablaInstituciones.find('tbody').fadeOut(200, function(){
                $(this).html(tabla).fadeIn(200);
            });
        },
        activaRegion: function (region, d3Elem) {
            ar.regionActiva = region;
            d3Elem.classed('active', true);
            ar.muestraInfoRegion();
            ar.actualizaTablaInstituciones();
        },
        desactivaRegion: function (region) {
            var d3Elem = d3.select(region);
            ar.regionActiva = null;
            d3Elem.classed('active', false);
            ar.escondeInfoRegion();
            ar.muestraInfoRegion();
            ar.actualizaTablaInstituciones();
        },
        toggleRegion: function (region) {
            var elem = d3.select(region);
            if(region == ar.regionActiva){
                return ar.desactivaRegion(region, elem);
            }else{
                ar.desactivaRegion(ar.regionActiva);
                return ar.activaRegion(region, elem);
            }
        },
        loadImage: function () {
            var xhr = new XMLHttpRequest();
            ar.d3Mapa = null;
            ar.d3Regiones = null;
            xhr.open('GET', site_url+'assets_v2/estadisticas/images/mapa_optimizado.svg', false);
            xhr.overrideMimeType('image/svg+xml');
            xhr.send("");
            var mapa = xhr.responseXML.documentElement;
            document.getElementById('cont-mapa-chile').appendChild(mapa);
            ar.d3Mapa = d3.select('#cont-mapa-chile');
            ar.d3Regiones = ar.d3Mapa.selectAll('path');
        },
        loadData : function(){
            ar.data = [];
            return $.getJSON(ar.dataUrl, function(d){
                for(var i = 0; i < d.length; i++){
                    if(!ar.data[d[i].periodo])
                        ar.data[d[i].periodo] = [];
                    if(!ar.data[d[i].periodo][d[i].mes])
                        ar.data[d[i].periodo][d[i].mes] = [];
                    ar.data[d[i].periodo][d[i].mes][d[i].region] = {
                        "cantidad" : parseInt(d[i].cantidad),
                        "nombre" : d[i].nombre
                    }
                }
            });
        },
        loadDataInstituciones : function(){
            ar.dataInst = [];
            return $.getJSON(this.dataInstitucionesUrl, function(d){
                for(var i = 0; i < d.length; i++){
                    if(!ar.dataInst[d[i].periodo])
                        ar.dataInst[d[i].periodo] = [];
                    if(!ar.dataInst[d[i].periodo][d[i].mes])
                        ar.dataInst[d[i].periodo][d[i].mes] = [];
                    if(!ar.dataInst[d[i].periodo][d[i].mes][d[i].region])
                        ar.dataInst[d[i].periodo][d[i].mes][d[i].region] = [];
                    ar.dataInst[d[i].periodo][d[i].mes][d[i].region].push({
                        "atenciones" : parseInt(d[i].atenciones),
                        "institucion" : d[i].institucion
                    });
                    if(d[i].mes == "Todos")
                        ar.totalAtenciones += parseInt(d[i].atenciones);
                }
            });
        },
        bindEvents : function(){
            ar.d3Regiones.on('click', function(d,i){
                ar.toggleRegion(this);
            });
            ar.selectorPeriodo.on('change', function(d, i){
                ar.selectedPeriodo = $(this).val();
                ar.fillSelectorMes();
                ar.selectorMes.trigger('change');
            });
            ar.selectorMes.on('change', function(d, i){
                ar.selectedMes = $(this).val();
                if(ar.regionActiva != null){
                    var region = ar.regionActiva;
                    ar.regionActiva = null;
                    ar.toggleRegion(region);
                } else {
                    ar.muestraInfoRegion();
                    ar.actualizaTablaInstituciones();
                }
            });
        },
        fillSelectorPeriodo: function () {
            var opciones = "",
                maxValue = 0;
            for(var i in ar.dataInst){
                opciones += '<option value="'+i+'">'+i+'</option>';
                if(!isNaN(i))
                    maxValue = i > maxValue ? i : maxValue;
            }
            ar.selectorPeriodo.html(opciones);
            ar.selectorPeriodo.find('[value="'+maxValue+'"]').prop('selected', true);
            ar.selectedPeriodo = ar.selectorPeriodo.val();
        },
        fillSelectorMes: function () {
            var opciones = "";
            for(var i in ar.dataInst[ar.selectedPeriodo]){
                if(i == "Todos")
                    opciones = '<option value="'+i+'">'+i+'</option>' + opciones;
                else
                    opciones += '<option value="'+i+'">'+i+'</option>';
            }
            ar.selectorMes.html(opciones);
            ar.selectedMes = ar.selectorMes.val();
        },
        init : function(){
            ar.dataUrl = site_url+'estadisticas/loadData/presencial-region';
            ar.dataInstitucionesUrl = site_url+'estadisticas/loadData/instituciones-region';
            ar.selectorPeriodo = $('#periodos-atenciones-region');
            ar.selectorMes = $('#mes-atenciones-region');
            ar.tooltip = $('#tooltip-mapa');
            ar.tablaInstituciones = $('#tabla-instituciones');
            ar.totalAtenciones = 0;
            $.when(ar.loadData(), ar.loadDataInstituciones()).then(function(){
                ar.fillSelectorPeriodo();
                ar.fillSelectorMes();
                ar.loadImage();
                ar.bindEvents();
                ar.muestraInfoRegion();
                ar.actualizaTablaInstituciones();
            });
            return ar;
        }
    };

    var es = {
        loadData : function(){
            es.data = [];
            es.sliderData = [];
            return $.getJSON(es.dataUrl, function(data){
                for(var i = 0; i < data.length; i++){
                    if(!es.data[0]){
                        es.data[0] = {
                            "key" : "Anteriores",
                            "values" : [],
                            "color" : "#01a0db"
                        };
                        es.data[1] = {
                            "key" : "Nuevas",
                            "values" : [],
                            "color" : "#f6be45"
                        };
                    }
                    es.data[0].values.push({
                        "series" : 0,
                        "size" : parseInt(data[i].mes_anterior),
                        "x" : i,
                        "y" : parseInt(data[i].mes_anterior),
                        "y0" : 0,
                        "y1" : parseInt(data[i].mes_anterior),
                        "periodo" : data[i].periodo,
                        "mes" : data[i].mes
                    });
                    es.data[1].values.push({
                        "series" : 1,
                        "size" : parseInt(data[i].nuevas),
                        "x" : i,
                        "y" : parseInt(data[i].nuevas),
                        "y0" : es.data[0].values[i].size,
                        "y1" : es.data[0].values[i].size + parseInt(data[i].nuevas)
                    });
                    es.sliderData.push(i);
                }
                es.originalData = [];
                es.originalData[0] = $.extend({},es.data[0]);
                es.originalData[1] = $.extend({},es.data[1]);
            });
        },
        drawChart : function(){
            nv.addGraph(function(){
                es.chart = nv.models.multiBarChart()
                    .margin(getMargins())
                    .x(function(d,i) { return i; })
                    .stacked(true)
                    .yDomain([es.minYValue, es.maxYValue])
                    .reduceXTicks(false)
                    .tooltipContent(function(k, y, x, graph){
                        var tooltip = '<div><h2>'+formatNumber(x)+'</h2><h4> Actuales</h4></div>';
                        if(k == 'Nuevas')
                            tooltip = '<div><h2>'+formatNumber(x)+'</h2><h4> Nuevas</h4></div>';
                        return tooltip;
                    });

                es.chart.xAxis
                    .tickFormat(function(d, i){
                        return getMes(es.sliderDesde + d, true);
                    });

                es.chart.yAxis
                    .axisLabel('Cantidad de Sucursales')
                    .axisLabelDistance(30)
                    .tickFormat(function(d, i){
                        return formatNumber(d);
                    });

                d3.select('#line-evolucion-sucursales')
                    .datum(es.data)
                    .call(es.chart);

                es.chart.dispatch.on('stateChange', function(state){
                    es.state = state;
                    es.updateChart();
                });

                return es.chart;
            });
        },
        bindEvents : function(){
            $(window).on('resize', function(){
                if(es.chart)
                    es.chart.update();
            });
            es.slider.slider().on('slideStop', function(e){
                es.sliderDesde = e.value[0];
                es.sliderHasta = e.value[1];
                es.updateChart();
            });
        },
        updateChart: function () {
            es.data[0].values = [];
            es.data[1].values = [];
            for(var i = es.sliderDesde; i <= es.sliderHasta; i++){
                es.data[0].values.push(es.originalData[0].values[i]);
                es.data[1].values.push(es.originalData[1].values[i]);
            }
            if(es.state.disabled[0] == false){
                es.minYValue = 0;
                es.maxYValue = getMaxYValue(es.data[0].values) + 10;
            }else{
                es.minYValue = 0;
                es.maxYValue = 15;
            }
            es.chart.yDomain([es.minYValue, es.maxYValue]);
            es.chart.margin(getMargins());
            es.chart.update();
        },
        updateSlider : function(){
            var container = es.slider.parents('.slider-horizontal');
            container.width(getSliderWidth());
        },
        initSlider: function () {
            es.sliderDesde = 0;
            es.sliderHasta = es.sliderData.length - 1;
            es.slider.slider({
                "min" : es.sliderDesde,
                "max" : es.sliderHasta,
                "value" : [es.sliderDesde, es.sliderHasta],
                "tooltip" : 'show',
                "formater" : function(i){
                    return es.originalData[0].values[i].mes + ' de ' + es.originalData[0].values[i].periodo;
                }
            });
        },
        init : function(){
            es.chart = null;
            es.minYValue = 0;
            es.maxYValue = 250;
            es.state = {disabled:[]};
            es.state.disabled[0] = false;
            es.container = $('.info-evolucion-sucursales');
            es.dataUrl = site_url+"estadisticas/loadData/evolucion-sucursales";
            es.slider = $('#slider-evolucion-sucursales');
            $.when(es.loadData()).then(function(){
                es.drawChart();
                es.initSlider();
                es.bindEvents();
            });
            return this;
        }
    };

    var nc = {
        loadData : function(){
            nc.data = {};
            return $.getJSON(nc.dataUrl, function(data){
                nc.data.totalComunas = parseInt(data[0].total_comunas);
                nc.data.porcentajePoblacion = data[0].porcentaje_poblacion;
                nc.data.comunasChileatiende = parseInt(data[0].comunas_chileatiende);
                nc.data.oficinasMoviles = parseInt(data[0].oficinas_moviles);
                nc.data.regionesOficinasMoviles = parseInt(data[0].regiones_oficinas_moviles);
                nc.data.comunasOficinasMoviles = parseInt(data[0].comunas_oficinas_moviles);
            });
        },
        drawPuntosComunas: function () {
            var htmlComunas = '', conChileatiende = true;
            for(var i = 0; i < nc.data.totalComunas; i++){
                if(i == nc.data.comunasChileatiende)
                    conChileatiende = false;
                htmlComunas += '<div class="punto-comuna'+(conChileatiende ? " con-chileatiende" : "")+'">&nbsp;</div>'
            }
            nc.contPuntosComunas.html(htmlComunas+'<div class="clearfix"></div>');
        },
        muestraDatos: function () {
            nc.container.find('.cantidad-comunas').html(nc.data.comunasChileatiende);
            nc.container.find('.porcentaje-poblacion').html(nc.data.porcentajePoblacion+'%');
            nc.containerMovil.find('#num-oficinas-moviles').html(nc.data.oficinasMoviles);
            nc.containerMovil.find('#num-regiones-oficinas-moviles').html(nc.data.regionesOficinasMoviles);
            nc.containerMovil.find('#num-comunas-oficinas-moviles').html(nc.data.comunasOficinasMoviles + ' comunas');
        },
        init : function(){
            nc.container = $('.info-numero-comunas');
            nc.containerMovil = $('.info-numero-oficinas-moviles');
            nc.contPuntosComunas = nc.container.find('.cont-puntos-comunas');
            nc.dataUrl = site_url+"estadisticas/loadData/numero-comunas";
            $.when(nc.loadData()).then(function(){
                nc.drawPuntosComunas();
                nc.muestraDatos();
            });
            return nc;
        }
    }

    var ec = {
        loadData : function(){
            var x = 0;
            ec.data = [];
            ec.sliderData = [];
            return $.getJSON(ec.dataUrl, function(data){
                for(var i = 0; i < data.length; i++){
                    if(!ec.data[0]){
                        ec.data[0] = {
                            "key" : "Anteriores",
                            "values" : [],
                            "color" : "#01a0db"
                        };
                        ec.data[1] = {
                            "key" : "Nuevos",
                            "values" : [],
                            "color" : "#f6be45"
                        };
                    }

                    ec.data[0].values.push({
                        "series" : 0,
                        "size" : parseInt(data[i].mes_anterior),
                        "x" : i,
                        "y" : parseInt(data[i].mes_anterior),
                        "y0" : 0,
                        "y1" : parseInt(data[i].mes_anterior),
                        "periodo" : data[i].periodo,
                        "mes" : data[i].mes
                    });

                    ec.data[1].values.push({
                        "series" : 1,
                        "size" : 0,
                        "x" : i,
                        "y" : parseInt(data[i].nuevas),
                        "y0" : ec.data[0].values[i].size,
                        "y1" : ec.data[0].values[i].size + parseInt(data[i].nuevas)
                    });
                    x++;
                    ec.sliderData.push(i);
                }
                ec.originalData = [];
                ec.originalData[0] = $.extend({},ec.data[0]);
                ec.originalData[1] = $.extend({},ec.data[1]);
            });
        },
        drawChart : function(){
            nv.addGraph(function(){
                ec.chart = nv.models.multiBarChart()
                    .margin(getMargins())
                    .x(function(d,i) { return i; })
                    .stacked(true)
                    .reduceXTicks(false)
                    .yDomain([0, 210])
                    .tooltipContent(function(k, y, x, graph){
                        var tooltip = '<div><h2>'+formatNumber(x)+'</h2><h4> Productos</h4></div>';
                        if(k == 'Nuevos')
                            tooltip = '<div><h2>'+formatNumber(x)+'</h2><h4> Nuevos</h4></div>';
                        return tooltip;
                    });

                ec.chart.xAxis
                    .tickFormat(function(d, i){
                        return getMes(ec.sliderDesde + d, true);
                    });

                ec.chart.yAxis
                    .axisLabel('Cantidad de Productos')
                    .axisLabelDistance(30)
                    .tickFormat(function(d, i){
                        return formatNumber(d);
                    });

                d3.select('#line-evolucion-crecimiento')
                    .datum(ec.data)
                    .call(ec.chart);

                ec.chart.dispatch.on('stateChange', function(state){
                    ec.state = state;
                    ec.updateChart();
                });

                return ec.chart;
            });
        },
        bindEvents : function(){
            $(window).on('resize', function(){
                if(ec.chart)
                    ec.chart.update();
            });
            ec.slider.slider().on('slideStop', function(e){
                ec.sliderDesde = e.value[0];
                ec.sliderHasta = e.value[1];
                ec.updateChart();
            });
        },
        updateChart: function () {
            ec.data[0].values = [];
            ec.data[1].values = [];
            for(var i = ec.sliderDesde; i <= ec.sliderHasta; i++){
                ec.data[0].values.push(ec.originalData[0].values[i]);
                ec.data[1].values.push(ec.originalData[1].values[i]);
            }
            if(ec.state.disabled[0] == false){
                ec.minYValue = 0;
                ec.maxYValue = getMaxYValue(ec.data[0].values) + 10;
            }else{
                ec.minYValue = 0;
                ec.maxYValue = 15;
            }
            ec.chart.yDomain([ec.minYValue, ec.maxYValue]);
            ec.chart.margin(getMargins());
            ec.chart.update();
        },
        initSlider: function () {
            ec.sliderDesde = 0;
            ec.sliderHasta = ec.sliderData.length - 1;
            ec.slider.slider({
                "min" : ec.sliderDesde,
                "max" : ec.sliderHasta,
                "value" : [ec.sliderDesde, ec.sliderHasta],
                "tooltip" : 'show',
                "formater" : function(i){
                    return ec.originalData[0].values[i].mes + ' de ' + ec.originalData[0].values[i].periodo;
                }
            });
        },
        init : function(){
            ec.chart = null;
            ec.state = {disabled:[]};
            ec.state.disabled[0] = false;
            ec.sliderDesde = 0;
            ec.container = $('.info-evolucion-crecimiento');
            ec.dataUrl = site_url+"estadisticas/loadData/evolucion-crecimiento";
            ec.slider = $('#slider-evolucion-crecimiento');
            $.when(ec.loadData()).then(function(){
                ec.drawChart();
                ec.initSlider();
                ec.bindEvents();
            });
            return this;
        }
    };


    $(function(){
        window.Estadisticas = e.init();
    });
})(jQuery);