
<!-- Modal -->
<div class="modal fade" id="modalUser" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
        
        {{-- Modal body --}}
        <div class="modal-body p-0">
            <ul class="list-group text-center">
                <li class="list-group-item p-0">
                    <a class="d-block w-100 h-100 p-2" href="{{ route('uconfig') }}">
                        Configuracion
                    </a>    
                </li>
                <li class="list-group-item p-0">
                    <a class="d-block w-100 h-100 p-2" href="{{ route('image.create') }}">
                        Subir imagen
                    </a>
                </li>
                <li class="list-group-item p-0">
                    <a class="d-block w-100 h-100 p-2" href="{{ route('logout') }}"
                        onclick="event.preventDefault();
                                document.getElementById('logout-form').submit();">
                        {{ __('Cerrar sesion') }}
                    </a>
                </li>
                <li class="list-group-item p-0">
                    <a class="d-block w-100 h-100 p-2 text-danger" data-dismiss="modal" href="{{ route('image.create') }}">
                        Cancelar
                    </a>
                </li>
            </ul>
            
            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    @csrf
            </form> 
      </div>
      {{-- END Modal body --}}
    
    </div>
  </div>
</div>

{{-- <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
    <a class="dropdown-item" href="{{ route('user.perfil', ['nick' => Auth::user()->nick]) }}">
        Mi perfil
    </a>
    
</div> --}}