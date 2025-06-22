@extends('admin.layout')
@section('title', "Dashboard")

@section('conteudo')
   
<div class="row container">
   <section class="info">

   @if (in_array(auth()->user()->nivel, [\App\Models\User::NIVEL_DIRETOR_GERAL, \App\Models\User::NIVEL_DIRETOR_PEDAGOGICO, 'admin']))
       
     <!-- Card Total Usuários -->
     <div class="col s12 m3">
       <a href="{{ route('admin.users') }}" style="text-decoration: none;">
         <article class="bg-gradient-blue card z-depth-4 hoverable">
           <i class="material-icons">groups</i>
           <p>Total Usuários</p>
           <h3>{{$totalUsers}}</h3>            
         </article>
       </a>
     </div>

     <!-- Card Professores -->
     <div class="col s12 m3">
       <a href="{{ route('admin.professores') }}" style="text-decoration: none;">
         <article class="bg-gradient-orange card z-depth-4 hoverable">
           <i class="material-icons">person_search</i>
           <p>Professores</p>
           <h3>{{$totalProfs}}</h3>       
         </article>
       </a>
     </div>

     <!-- Card Alunos -->
     <div class="col s12 m3">
       <a href="{{ route('admin.alunos') }}" style="text-decoration: none;">
         <article class="bg-gradient-green card z-depth-4 hoverable">
           <i class="material-icons">people</i>
           <p>Alunos</p>
           <h3>{{$totalAlunos}}</h3>       
         </article>
       </a>
     </div>

     <!-- Card Admins -->
     <div class="col s12 m3">
       <a href="{{ route('admin.admins') }}" style="text-decoration: none;">
         <article class="bg-gradient-blue card z-depth-4 hoverable">
           <i class="material-icons">manage_accounts</i>
           <p>Admins</p>
           <h3>{{$totalAdmins}}</h3>           
         </article>
       </a>
     </div>

     <!-- Card Anos Lectivos -->
     <div class="col s12 m3">
       <a href="{{ route('admin.anos') }}" style="text-decoration: none;">
         <article class="bg-gradient-orange card z-depth-4 hoverable">
           <i class="material-icons">calendar_month</i>
           <p>Anos Lectivos</p>
           <h3>{{$totalAnos}}</h3>       
         </article>
       </a>
     </div>

     <!-- Card Turmas -->
     <div class="col s12 m3">
       <a href="{{ route('admin.turmas') }}" style="text-decoration: none;">
         <article class="bg-gradient-blue card z-depth-4 hoverable">
           <i class="material-icons">doorbell</i>
           <p>Turmas</p>
           <h3>{{$totalturmas}}</h3>            
         </article>
       </a>
     </div>

   @endif

   <!-- Card Classes -->
   <div class="col s12 m3">
     <a href="{{ route('admin.classes') }}" style="text-decoration: none;">
       <article class="bg-gradient-green card z-depth-4 hoverable">
         <i class="material-icons">school</i>
         <p>Classes</p>
         <h3>{{$totalClasses}}</h3>       
       </article>
     </a>
   </div>

   <!-- Card Cursos -->
   <div class="col s12 m3">
     <a href="{{ route('admin.cursos') }}" style="text-decoration: none;">
       <article class="bg-gradient-blue card z-depth-4 hoverable">
         <i class="material-icons">library_books</i>
         <p>Cursos</p>
         <h3>{{$totalCuros}}</h3>            
       </article>
     </a>
   </div>

   <!-- Card Aulas -->
   <div class="col s12 m3">
     <a href="{{ route('admin.aulas') }}" style="text-decoration: none;">
       <article class="bg-gradient-green card z-depth-4 hoverable">
         <i class="material-icons">auto_stories</i>
         <p>Aulas</p>
         <h3>{{$totalAulas}}</h3>            
       </article>
     </a>
   </div>

   <!-- Card Disciplinas -->
   <div class="col s12 m3">
     <a href="{{ route('admin.disciplinas') }}" style="text-decoration: none;">
       <article class="bg-gradient-green card z-depth-4 hoverable">
         <i class="material-icons">menu_book</i>
         <p>Disciplinas</p>
         <h3>{{$totalDisciplinas}}</h3>            
       </article>
     </a>
   </div>

   <!-- Card Posts -->
   <div class="col s12 m3">
     <a href="{{ route('admin.posts') }}" style="text-decoration: none;">
       <article class="bg-gradient-orange card z-depth-4 hoverable">
         <i class="material-icons">local_post_office</i>
         <p>Posts</p>
         <h3>{{$totalPosts}}</h3>            
       </article>
     </a>
   </div>

   <!-- Card Fóruns -->
   <div class="col s12 m3">
     <a href="{{ route('admin.forums') }}" style="text-decoration: none;">
       <article class="bg-gradient-orange card z-depth-4 hoverable">
         <i class="material-icons">help</i>
         <p>Fóruns</p>
         <h3>{{$totalForums}}</h3>            
       </article>
     </a>
   </div>

   </section>        
 </div>

 @if (in_array(auth()->user()->nivel, [\App\Models\User::NIVEL_DIRETOR_GERAL, \App\Models\User::NIVEL_DIRETOR_PEDAGOGICO, 'admin']))
 
     <div class="row container ">
         <section class="graficos col s12 m6" >            
           <div class="grafico card z-depth-4">
               <h5 class="center"> Aquisição de usuários</h5>
               <canvas id="myChart" width="400" height="200"></canvas>
           </div>           
         </section> 
         
         <section class="graficos col s12 m6">            
             <div class="grafico card z-depth-4">
                 <h5 class="center"> Produtos </h5>
             <canvas id="myChart2" width="400" height="200"></canvas> 
         </div>            
        </section>             
     </div>

 </div>
 @endif
     
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {
    // Gráfico de Usuários
    const userCtx = document.getElementById('myChart');
    if (userCtx) {
        new Chart(userCtx, {
            type: 'doughnut',
            data: @json($userChartData),
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'top',
                    },
                    title: {
                        display: true,
                        text: 'Distribuição de Usuários'
                    }
                }
            }
        });
    }

    // Gráfico de Conteúdo
    const contentCtx = document.getElementById('myChart2');
    if (contentCtx) {
        new Chart(contentCtx, {
            type: 'bar',
            data: @json($contentChartData),
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        display: false
                    },
                    title: {
                        display: true,
                        text: 'Conteúdo Acadêmico'
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    }
});
</script>
@endpush

