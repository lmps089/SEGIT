
function Eliminar(codigoC){
	parmetros={ "id":codigoC }
	$.ajax({ 
		data:parmetros,
		url:'listaCitas.php',
		type:'POST',
		beforeSend:function(){},
		success:function(){
			table.ajax.reload();
			Swal.fire(
      			'¡Eliminado!',
      			'La cita fue eliminada.',
     			 'success'
    			)
		}
	});
}

function AlertaEliminar(codigo){
	Swal.fire({
  title: '¿Estás seguro?',
  text: "¡No podrás revertir esto!",
  icon: 'warning',
  showCancelButton: true,
  confirmButtonColor: '#3085d6',
  cancelButtonColor: '#d33',
  confirmButtonText: '¡Si, eliminalo!'
}).then((result) => {
  if (result.value) {
    Eliminar(codigo);
  }
})
}