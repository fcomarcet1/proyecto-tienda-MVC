 function Confirmation() {

      if (confirm('Esta seguro de eliminar el registro?') == true) {
        alert('El registro ha sido eliminado correctamente!!!');
        return true;
      } else {
        //alert('Cancelo la eliminacion');
        return false;
      }
    }


