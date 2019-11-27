
	
var items_obj = [];
function agregarItems(){
	var item_codigo = $('#item_codigo').val();
	var nombre_item = $( "#item_codigo option:selected" ).text()
	var eventos_cantidad = $('#eventos-cantidad').val();	
	//var eventos_estado_item = $('#eventos-estado_item').is(":checked") 
	var array_datatable = [];
	var estado = ($('#eventos-estado_item').is(":checked") == true)?'1':'0';
	var encontrado = false;
	items_obj.forEach( function(valor, indice, array) {
        if(valor.item_codigo != '' && valor.item_codigo == $('#item_codigo').val()){
            encontrado = true;
            valor.item_codigo = $('#item_codigo').val();
            valor.cantidad= $('#eventos-cantidad').val();
            valor.estado_item = estado;
        }
    });
    if(encontrado == false){
        item = {
                    item_codigo : $('#item_codigo').val(),
                    nombre_item : nombre_item,
		            eventos_cantidad: $('#eventos-cantidad').val(),
		            eventos_estado_item : estado,
                }

        items_obj.push(item);
    }
    items_obj.forEach( function(valor, indice, array) {
        var btn = (valor.item_codigo != '')?'<a class="btn-editar-item" id="btn-'+valor.item_codigo+'"><span class="glyphicon glyphicon-pencil" title="Editar"></span></a>':''
        data_datatable = [
                            valor.nombre_item,
                            valor.eventos_cantidad,
                            valor.eventos_cantidad,
                            valor.eventos_estado_item,
                            btn
                        ]
        //print datatable                        
        array_datatable.push(data_datatable);
       
    });
    $('#item_codigo').val('');
    $('#eventos-cantidad').val('');
    $('#table_items_data').val(JSON.stringify(items_obj));
    $(document).ready(function() {     
        var table = $('#table_items').DataTable();
        table.destroy();   
        $('#table_items').DataTable( {
            'responsive': true,
            "searching": false,
            "lengthChange": false,
            "ordering": false,
            "lengthMenu": [ 4 ],
            data:  array_datatable,
            columns: [
                        { title: "Nombre" },
                        { title: "Cantidad" },
                        { title: "Stock" },
                        { title: "Estado" },
                        { title: "" },

                    ]
                    
        });
    } )
    //$('#eventos-estado_item').val('');

	



}

function cargarDatatable(){
	$.post($('.item_url').attr('id'), function( data ) {
                data = [data.data];
                items_obj = data;
                var array_datatable = []
                data.forEach( function(valor, indice, array) {
                    var btn = (valor.item_codigo != '')?'<a class="btn-editar-item" id="btn-'+valor.item_evento_codigo+'"><span class="glyphicon glyphicon-pencil" title="Editar"></span></a>':''
                    data_datatable = [
                                        valor.nombre,
			                            valor.cantidad,
			                            valor.stock,
			                            valor.estado,
                                        btn
                                    ]
                    array_datatable.push(data_datatable);
                });

                var table = $('#table_items').DataTable();
                table.destroy();   
                $('#table_items').DataTable( {
			            'responsive': true,
			            "searching": false,
			            "lengthChange": false,
			            "ordering": false,
			            "lengthMenu": [ 4 ],
			            data:  array_datatable,
			            columns: [
			                        { title: "Nombre" },
			                        { title: "Cantidad" },
			                        { title: "Stock" },
			                        { title: "Estado" },
			                        { title: "" },

			                    ]
			    });
    })
}