@if(session('message'))
    <div class="alert alert-{{session('error') ? 'danger' : 'success'}}" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">×</span>
        </button>
          {{  session('message')  }}
    </div>
@endif