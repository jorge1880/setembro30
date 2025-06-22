@extends('admin.layout')
@section('title','Anos Lectivos')

@section('conteudo')


  <div class="fixed-action-btn">
    <a href="{{route('admin.ano.create')}}" class="btn-floating btn-large bg-gradient-green modal-trigger waves-effects waves-light"> 
     <i class="large material-icons">add</i></a>
 </div>


 <div class="row container ">

        <br>
        <div class="row">
            <a href="{{ route('admin.dashboard') }}" class="btn-floating waves-effect waves-light blue left" style="margin-right: 10px;">
                <i class="material-icons">arrow_back</i>
            </a>
            <h4 class="left"> <i class="material-icons btn-floating center" style="font-size:25pt">calendar_month</i>Anos Lectivos</h4>
           <span class="right chip">{{$anos->count()}} Total de anos lectivos</span>
      </div>

      @include('admin.mensagem.mensagem')
      
       <nav class="bg-gradient-blue">
           <div class="nav-wrapper">
             <form>
               <div class="input-field">
                 <input placeholder="Pesquisar..." id="search" type="search" required>
                 <label class="label-icon" for="search"><i class="material-icons">search</i></label>
                 <i class="material-icons">close</i>
               </div>
             </form>
           </div>
         </nav> 


      <div class="card z-depth-4">
       <table style="margin: 5px" class="striped highlight centered center">

           <thead>
             <tr>
                 <th>ID</th>
                 <th>Ano Lectivo</th>
                 <th>Ações</th>
                 
             </tr>
           </thead>
   
           <tbody>

              @foreach ($anos as $ano)
               
             <tr>
               @include('admin.anoslectivos.delete')
               <td>{{$ano->id}}</td>
               <td>{{$ano->ano}}</td>
  
               <td>
                 
                 <a href="{{route('admin.ano.edit', $ano->id)}}" class="btn-floating modal-trigger  waves-effect waves-light blue"><i class="material-icons">mode_edit</i></a>
                 <a href="#delete-{{$ano->id}}" class="btn-floating modal-trigger waves-effect waves-light red"><i class="material-icons">delete</i></a>
                 
               </td>
               
             </tr>
             
             @endforeach
             
            
             
           </tbody>
         </table>
       </div>
 </div>
  
 <div class="center">
   {{ $anos->links('pagination.pagination') }}
 </div>
@endsection