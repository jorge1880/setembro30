@if ($mensagem = Session::get('sucesso'))
<div id="modal-confirmacao" class="modal" style="width:400px; height:300px;">
  <div class="modal-content center-align" style="height: calc(100% - 64px); overflow-y: auto;">
    <h4 class="green-text text-darken-2" style="margin-top: 0;"><i class="material-icons">check_circle</i> Sucesso</h4>
    <div id="mensagem-confirmacao" style="text-align: left;">{!! $mensagem !!}</div>
  </div>
  <div class="modal-footer" style="height:64px; display: flex; align-items: center; justify-content: right;">
    <a href="#!" class="modal-close waves-effect waves-green btn-flat green white-text">Fechar</a>
  </div>
</div>
@endif

@if ($mensagem = Session::get('error'))
<div id="modal-erro" class="modal" style="width:500px; height:400px;">
  <div class="modal-content center-align" style="height: calc(100% - 64px); overflow-y: auto;">
    <h4 class="red-text text-darken-2" style="margin-top: 0;"><i class="material-icons">error</i> Atenção</h4>
    <div id="mensagem-erro" style="text-align: left; line-height: 1.6;">{!! $mensagem !!}</div>
  </div>
  <div class="modal-footer" style="height:64px; display: flex; align-items: center; justify-content: right;">
    <a href="#!" class="modal-close waves-effect waves-red btn-flat red white-text">Entendi</a>
  </div>
</div>
@endif

@if ($mensagem = Session::get('success'))
<div id="modal-confirmacao" class="modal" style="width:400px; height:300px;">
  <div class="modal-content center-align" style="height: calc(100% - 64px); overflow-y: auto;">
    <h4 class="green-text text-darken-2" style="margin-top: 0;"><i class="material-icons">check_circle</i> Sucesso</h4>
    <div id="mensagem-confirmacao" style="text-align: left;">{!! $mensagem !!}</div>
  </div>
  <div class="modal-footer" style="height:64px; display: flex; align-items: center; justify-content: right;">
    <a href="#!" class="modal-close waves-effect waves-green btn-flat green white-text">Fechar</a>
  </div>
</div>
@endif



