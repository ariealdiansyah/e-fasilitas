var url = {
	base: "http://localhost/e-fasilitas/"
}

var resizefunc = [];

function changeKota(elem) {

	var id = elem.value;

	$.ajax({
		type: "GET",
		url: url.base+"/api/getJSON/master/KOT/"+id+"",
	}).done(function(data) {
		data = JSON.parse(data);
		$("#s2id_idKota span.select2-chosen").html('Pilih Kota');
		$("#s2id_idKecamatan span.select2-chosen").html('Pilih Kecamatan');		
		$("#idKota").empty();
		$("#idKecamatan").empty();		
		$("#idKota").append($("<option></option>"));		
		for (var i = 0, l = data.length; i < l; i++) {
			$("#idKota").append($("<option></option>").val(data[i].idData).html(data[i].namaData));
		}
	});

}

function changeKecamatan(elem) {

	var id = elem.value;

	$.ajax({
		type: "GET",
		url: url.base+"/api/getJSON/master/KEC/"+id+"",
	}).done(function(data) {
		data = JSON.parse(data);
		$("#s2id_idKecamatan span.select2-chosen").html('Pilih Kecamatan');		
		$("#idKecamatan").empty();
		$("#idKecamatan").append($("<option></option>"));		
		for (var i = 0, l = data.length; i < l; i++) {
			$("#idKecamatan").append($("<option></option>").val(data[i].idData).html(data[i].namaData));
		}
	});

}


function number(objek) {
	a = objek.value;
	b = a.replace(/[^\d]/g,"");
	c = "";
	panjang = b.length;
	j = 0;
	for (i = panjang; i > 0; i--) {
		j = j + 1;
		if (((j % 3) == 1) && (j != 1)) {
			c = b.substr(i-1,1) + c;
		} else {
			c = b.substr(i-1,1) + c;
		}
	}
	objek.value = c;
}

function nominal(objek) {
	separator = ".";
	a = objek.value;
	b = a.replace(/[^\d]/g,"");
	c = "";
	panjang = b.length;
	j = 0;
	for (i = panjang; i > 0; i--) {
		j = j + 1;
		if (((j % 3) == 1) && (j != 1)) {
			c = b.substr(i-1,1) + separator + c;
		} else {
			c = b.substr(i-1,1) + c;
		}
	}
	objek.value = c;
}

function setUsername(elem){               
	replace = elem.value.replace(/[\\!"?$%^&*_={}; .\:'/@#~,?\<>?|`?\]\[]/g,'');        
	elem.value = replace;
}

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


function checkModule(){
	if ($_GET('module') == null) {
		alert('Silahkan pilih modul terlebih dahulu');
	};
}

function removeURLParameter(url, parameter) {
    //prefer to use l.search if you have a location/link object
    var urlparts= url.split('?');   
    if (urlparts.length>=2) {

    	var prefix= encodeURIComponent(parameter)+'=';
    	var pars= urlparts[1].split(/[&;]/g);

        //reverse iteration as may be destructive
        for (var i= pars.length; i-- > 0;) {    
            //idiom for string.startsWith
            if (pars[i].lastIndexOf(prefix, 0) !== -1) {  
            	pars.splice(i, 1);
            }
        }

        url= urlparts[0]+'?'+pars.join('&');
        return url;
    } else {
    	return url;
    }
}

function minmax(value, min, max) 
{
	if(parseInt(value) < min || isNaN(value)) 
		return 0; 
	else if(parseInt(value) > max) 
		return max; 
	else return value;
}

$(document).ready(function() {

	if(location.hash) {
		$('a[href=' + location.hash + ']').tab('show');
	}
	$(document.body).on("click", "a[data-toggle]", function(event) {
		location.hash = this.getAttribute("href");
	});
	$(window).on('popstate', function() {
		var anchor = location.hash || $("a[data-toggle=tab]").first().attr("href");
		$('a[href=' + anchor + ']').tab('show');
	});

	$('#myTabs a').click(function (e) {
		e.preventDefault();
		$(this).tab('show');
	});

	$('.modify-link').click(function(){
		var urlString = $(".modify-link").prop("href");
		urlString = urlString.toString().substring(0, urlString.indexOf("?"));
		$(".modify-link").prop("href", urlString);
	});

	$.validate({
		modules : 'file,security',
	});

	$(".search-select").select2({
		placeholder : 'Pilih Data...',
		minimumResultsForSearch: 10,
		allowClear: true,
	});
	
	// $('.wysihtml5').wysihtml5();

	$('#datatable').dataTable({
		rowReorder: true,
	});
	$('.datatable').dataTable();

	$('.tip-bottom').tooltip({
		container: 'body',
		placement: 'bottom'
	});
	$('.tip-top').tooltip({
		container: 'body',
		placement: 'top'
	});
	$('.tip-right').tooltip({
		container: 'body',
		placement: 'right'
	});
	$('.tip-left').tooltip({
		container: 'body',
		placement: 'left'
	});


	CKEDITOR.replaceAll('editor');

	$('.icp-auto').iconpicker({
		defaultValue: false
	});

	$('.icp').on('iconpickerSelected', function(e) {
		$('.lead .picker-target').get(0).className = 'picker-target fa-3x ' +
		e.iconpickerInstance.options.iconBaseClass + ' ' +
		e.iconpickerInstance.getValue(e.iconpickerValue);
	});

	$('div.iconpicker-items').click(function() {
		$('.iconPicker').val($('div.iconpicker-selected').attr('title').substring(1));
	});

	$('#chkAll').click(function (e) {

		if ($(this).is(':checked')) {
			$(this).parents('tr').addClass('selected');

			$('#datatable tbody input[type=checkbox]').addClass('checked');

		} else {
			$(this).parents('tr').removeClass('selected');
			$('#datatable tbody input[type=checkbox]').removeClass('checked');
		}
		$('#datatable tbody input[type=checkbox]').prop("checked", this.checked);

	});
    $('.timepicker').timepicker({showMeridian: false});
	$(".datepicker").datepicker({
		format: 'dd-mm-yyyy'
	});
	var t ;
	$( document ).on(
		'DOMMouseScroll mousewheel scroll',
		'.modal', 
		function(){       
			window.clearTimeout( t );
			t = window.setTimeout( function(){            
				$('.datepicker').datepicker('place');
			}, 100 );        
		}
		);
	$(".datepicker").on("changeDate", function () {
		$(this).datepicker('hide');
	});
	var nowTemp = new Date();
	var now = new Date(nowTemp.getFullYear(), nowTemp.getMonth(), nowTemp.getDate(), 0, 0, 0, 0);
	var checkin = $('#startDate').datepicker({
		onRender: function(date) {
		}
	}).on('changeDate', function(ev) {
		var newDate = new Date(ev.date)
		newDate.setDate(newDate.getDate());
		checkout.setValue(newDate);
		checkin.hide();
		$('#expiredDate')[0].focus();
	}).data('datepicker');
	var checkout = $('#expiredDate').datepicker({
		onRender: function(date) {
			return date.valueOf() < checkin.date.valueOf() ? 'disabled' : '';
		}
	}).on('changeDate', function(ev) {
		checkout.hide();
	}).data('datepicker');

	var i=1;
	$("#add_row_menu").click(function(){
		$('#addr'+i).html("<td class='text-center'>"+ (i+1) +"</td><input type='hidden' name='idPAttributeDetail[]' value=''><td><input name='namePAttributeDetail[]' type='text' class='form-control input-md' style='color:#000;' placeholder='Isi Atribut'/></td>");

		$('#tab_logic').append('<tr id="addr'+(i+1)+'"></tr>');
		i++; 
	});
	$("#delete_row_menu").click(function(){
		if(i>1){
			$("#addr"+(i-1)).html('');
			i--;
		}
	});  

});