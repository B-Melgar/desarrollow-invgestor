document.addEventListener('DOMContentLoaded', function(){
	alert("Hola");
	$('#_Category').on('change', function() {
		var idcategoria = $(this).val();
		if($.trim(idcategoria != '')){
			$.get('invSubCategories', {idcategoria: idcategoria}, function (subCategory){
				$('#_SubCategory').empty();
				$('#_SubCategory').append("<option value=''>Seleccionar</option>");
				$.each(subCategory, function(index,value){
					$('_SubCategory').append("<option value='" + index +"'>"+ value +"</option>");
				})
			});
		}
	});
});