
<!-- Modal -->
<div class="modal fade" id="modalDelete" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header d-block">
        <i class="fas fa-exclamation-triangle h1 d-block w-100 text-center text-danger"></i>
        <h5 class="modal-title d-block text-center mt-1" id="exampleModalCenterTitle">¿Estas seguro/a?</h5>
      </div>
      <div class="modal-body">
        <p>Si eliminas esta publicacion no prodras recuperarla.</p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
        <a href="{{ route('image.delete',['id'=> $image_id]) }}" class="btn btn-outline-danger">Eliminar</a>
      </div>
    </div>
  </div>
</div>