 <!-- Modal Structure -->
  
 <!DOCTYPE html>
 <html lang="pt-br">
 <head>
   <meta charset="UTF-8">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Login 30 de Setembro  </title>
   <!-- Importando Materialize CSS -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css">
   <!-- Importando ícones do Material Icons -->
   <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
   <style>
     body {
       display: flex;
       min-height: 100vh;
       flex-direction: column;
       background: linear-gradient(45deg, #1a237e, #0d47a1);
       overflow: hidden;
       position: relative;
     }
     main {
       flex: 1 0 auto;
       display: flex;
       align-items: center;
       justify-content: center;
       position: relative;
       z-index: 10;
     }
     .login-card {
       width: 400px;
       padding: 10px 30px 30px;
       border-radius: 10px;
       box-shadow: 0 15px 25px rgba(0,0,0,0.3);
       opacity: 0;
       transform: translateY(20px);
       animation: fadeUp 0.8s ease-out forwards;
       background-color: rgba(255, 255, 255, 0.95);
     }
     .login-header {
       text-align: center;
       margin-bottom: 30px;
     }
     .login-img {
       width: 100px;
       height: 100px;
       margin: 20px auto;
       display: block;
       background-color: #3F51B5;
       color: white;
       border-radius: 50%;
       text-align: center;
       line-height: 100px;
       font-size: 50px;
       transform: scale(0);
       animation: scaleIn 0.5s ease-out 0.3s forwards;
     }
     .input-field {
       margin-bottom: 20px;
       opacity: 0;
       animation: fadeIn 0.5s ease-out forwards;
     }
     .input-field:nth-child(1) {
       animation-delay: 0.6s;
     }
     .input-field:nth-child(2) {
       animation-delay: 0.8s;
     }
     .btn-login {
       width: 100%;
       height: 50px;
       border-radius: 25px;
       margin-top: 15px;
       opacity: 0;
       animation: fadeIn 0.5s ease-out 1s forwards;
     }
     .remember-forgot {
       display: flex;
       justify-content: space-between;
       margin: 15px 0;
       opacity: 0;
       animation: fadeIn 0.5s ease-out 1.2s forwards;
     }
     .social-login {
       text-align: center;
       margin-top: 30px;
       opacity: 0;
       animation: fadeIn 0.5s ease-out 1.4s forwards;
     }
     .social-icons {
       margin-top: 15px;
     }
     .social-icons a {
       display: inline-block;
       width: 40px;
       height: 40px;
       background-color: #f5f5f5;
       border-radius: 50%;
       margin: 0 5px;
       line-height: 40px;
       color: #333;
       transform: scale(0);
     }
     .social-icons a:nth-child(1) {
       animation: socialIconIn 0.3s ease-out 1.6s forwards;
     }
     .social-icons a:nth-child(2) {
       animation: socialIconIn 0.3s ease-out 1.7s forwards;
     }
     .social-icons a:nth-child(3) {
       animation: socialIconIn 0.3s ease-out 1.8s forwards;
     }
     
     /* Nova animação de fundo: Círculos pulsantes mais visíveis */
     .animated-background {
       position: absolute;
       top: 0;
       left: 0;
       width: 100%;
       height: 100%;
       overflow: hidden;
       z-index: 0;
     }
     
     .circle {
       position: absolute;
       border-radius: 50%;
       background: radial-gradient(circle, rgba(33, 150, 243, 0.8) 0%, rgba(100, 181, 246, 0.4) 50%, rgba(100, 181, 246, 0) 70%);
       animation: pulse-scale 5s infinite ease-in-out;
       opacity: 0.7;
     }
     
     .circle:nth-child(1) {
       width: 400px;
       height: 400px;
       left: -100px;
       top: -100px;
       animation-delay: 0s;
     }
     
     .circle:nth-child(2) {
       width: 600px;
       height: 600px;
       right: -200px;
       bottom: -200px;
       animation-delay: 1s;
       background: radial-gradient(circle, rgba(63, 81, 181, 0.8) 0%, rgba(63, 81, 181, 0.4) 50%, rgba(63, 81, 181, 0) 70%);
     }
     
     .circle:nth-child(3) {
       width: 300px;
       height: 300px;
       right: 10%;
       top: 10%;
       animation-delay: 2s;
       background: radial-gradient(circle, rgba(121, 134, 203, 0.8) 0%, rgba(121, 134, 203, 0.4) 50%, rgba(121, 134, 203, 0) 70%);
     }
     
     .circle:nth-child(4) {
       width: 250px;
       height: 250px;
       left: 20%;
       bottom: 20%;
       animation-delay: 3s;
       background: radial-gradient(circle, rgba(179, 229, 252, 0.8) 0%, rgba(179, 229, 252, 0.4) 50%, rgba(179, 229, 252, 0) 70%);
     }
     
     .circle:nth-child(5) {
       width: 350px;
       height: 350px;
       left: 50%;
       top: 50%;
       transform: translate(-50%, -50%);
       animation-delay: 2.5s;
       background: radial-gradient(circle, rgba(25, 118, 210, 0.8) 0%, rgba(25, 118, 210, 0.4) 50%, rgba(25, 118, 210, 0) 70%);
     }
     
     /* Geometric patterns */
     .geometric {
       position: absolute;
       z-index: 1;
       opacity: 0.3;
       animation: rotate 30s linear infinite;
     }
     
     .geometric-1 {
       width: 800px;
       height: 800px;
       top: -200px;
       left: -200px;
       border: 2px solid rgba(255, 255, 255, 0.2);
       border-radius: 63% 37% 54% 46% / 55% 48% 52% 45%;
     }
     
     .geometric-2 {
       width: 600px;
       height: 600px;
       bottom: -100px;
       right: -100px;
       border: 2px solid rgba(255, 255, 255, 0.15);
       border-radius: 38% 62% 63% 37% / 41% 44% 56% 59%;
       animation-direction: reverse;
     }
     
     .geometric-3 {
       width: 400px;
       height: 400px;
       top: 50%;
       left: 50%;
       transform: translate(-50%, -50%);
       border: 2px solid rgba(255, 255, 255, 0.1);
       border-radius: 59% 41% 38% 62% / 50% 45% 55% 50%;
       animation-duration: 20s;
     }
     
     /* Floating particles */
     .particles {
       position: absolute;
       top: 0;
       left: 0;
       width: 100%;
       height: 100%;
       overflow: hidden;
       z-index: 2;
     }
     
     .particle {
       position: absolute;
       display: block;
       animation: floating 15s infinite ease-in-out;
     }
     
     .particle:nth-child(1) {
       width: 70px;
       height: 70px;
       top: 20%;
       left: 15%;
       background: rgba(3, 169, 244, 0.2);
       border-radius: 14px;
       transform: rotate(15deg);
     }
     
     .particle:nth-child(2) {
       width: 40px;
       height: 40px;
       top: 70%;
       left: 75%;
       background: rgba(156, 39, 176, 0.2);
       border-radius: 50%;
     }
     
     .particle:nth-child(3) {
       width: 30px;
       height: 30px;
       top: 30%;
       left: 80%;
       background: rgba(255, 255, 255, 0.15);
       border-radius: 5px;
       transform: rotate(30deg);
     }
     
     .particle:nth-child(4) {
       width: 60px;
       height: 60px;
       top: 60%;
       left: 20%;
       background: rgba(33, 150, 243, 0.2);
       border-radius: 10px;
       transform: rotate(-20deg);
     }
     
     .particle:nth-child(5) {
       width: 20px;
       height: 20px;
       top: 50%;
       left: 50%;
       background: rgba(255, 255, 255, 0.2);
       border-radius: 3px;
       transform: rotate(45deg);
     }
     
     /* Lightning flashes */
     .lightning {
       position: absolute;
       top: 0;
       left: 0;
       width: 100%;
       height: 100%;
       z-index: 1;
       animation: lightning 10s infinite;
       opacity: 0;
       background: linear-gradient(45deg, rgba(0, 30, 255, 0), rgba(209, 242, 255, 0.1), rgba(0, 30, 255, 0));
     }
     
     @keyframes pulse-scale {
       0% {
         transform: scale(1);
         opacity: 0.7;
       }
       50% {
         transform: scale(1.2);
         opacity: 0.5;
       }
       100% {
         transform: scale(1);
         opacity: 0.7;
       }
     }
     
     @keyframes rotate {
       0% {
         transform: rotate(0deg);
       }
       100% {
         transform: rotate(360deg);
       }
     }
     
     @keyframes floating {
       0% {
         transform: translateY(0) rotate(0deg);
       }
       25% {
         transform: translateY(-20px) rotate(5deg);
       }
       50% {
         transform: translateY(0) rotate(10deg);
       }
       75% {
         transform: translateY(20px) rotate(5deg);
       }
       100% {
         transform: translateY(0) rotate(0deg);
       }
     }
     
     @keyframes lightning {
       0%, 95%, 100% {
         opacity: 0;
       }
       96%, 99% {
         opacity: 1;
       }
     }
     
     @keyframes fadeUp {
       from {
         opacity: 0;
         transform: translateY(20px);
       }
       to {
         opacity: 1;
         transform: translateY(0);
       }
     }
     
     @keyframes scaleIn {
       from {
         transform: scale(0);
       }
       to {
         transform: scale(1);
       }
     }
     
     @keyframes fadeIn {
       from {
         opacity: 0;
       }
       to {
         opacity: 1;
       }
     }
     
     @keyframes socialIconIn {
       from {
         transform: scale(0);
       }
       to {
         transform: scale(1);
       }
     }
   </style>
 </head>
 <body>
   <!-- Animação de fundo mais visível -->
   <div class="animated-background">
     <div class="circle"></div>
     <div class="circle"></div>
     <div class="circle"></div>
     <div class="circle"></div>
     <div class="circle"></div>
   </div>
   
   <!-- Padrões geométricos em movimento -->
   <div class="geometric geometric-1"></div>
   <div class="geometric geometric-2"></div>
   <div class="geometric geometric-3"></div>
   
   <!-- Partículas flutuantes -->
   <div class="particles">
     <div class="particle"></div>
     <div class="particle"></div>
     <div class="particle"></div>
     <div class="particle"></div>
     <div class="particle"></div>
   </div>
   
   <!-- Efeito de relâmpago sutil -->
   <div class="lightning"></div>
   
   <main>
     <div class="card login-card">
       <div class="login-header">
         <div class="login-img">
           <i class="material-icons">person</i>
         </div>
         <h4 class="blue-text text-darken-2">Login</h4>
       </div>
       
       <form action="{{route('login.auth')}}" method="POST">
        @error('error')
               <span class="red-text">{{$message}}</span>
           @enderror

         @csrf

         <div class="input-field">
           <i class="material-icons prefix">email</i>
           <input id="email" type="email" name="email" class="validate">
           <label for="email">Email</label>
           @error('email')
               <span class="red-text">{{$message}}</span>
           @enderror
         </div>
         
         <div class="input-field">
           <i class="material-icons prefix">lock</i>
           <input id="password" type="password" name="password" class="validate">
           <label for="password">Senha</label>
           @error('password')
               <span class="red-text">{{$message}}</span>
           @enderror
         </div>
         
         <div class="remember-forgot">
           <label>
             <input type="checkbox" name="remember">
             <span>Lembrar-me</span>
           </label>
           
           <a href="{{ route('password.request') }}" class="blue-text">Esqueceu a senha?</a>
         </div>
         
         <button  type="submit" class="btn-large waves-effect waves-light blue darken-2 btn-login">
           Entrar
           <i class="material-icons right">send</i>
         </button>
       </form>
       
       <div class="social-login">
         <p>Ou entre com suas redes sociais</p>
         <div class="social-icons">
           <a href="#!" class="z-depth-1 center-align"><i class="material-icons">tiktok</i></a>
           <a href="#!" class="z-depth-1 center-align"><i class="material-icons">facebook</i></a>
           <a href="#!" class="z-depth-1 center-align"><i class="material-icons">X</i></a>
           
         </div>
       </div>
     </div>
   </main>
   
   <!-- Importando jQuery e Materialize JS -->
   <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
   <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>
   <script>
     $(document).ready(function() {
       // Inicialização dos componentes do Materialize
       M.updateTextFields();
       
       // Efeito nos campos quando focados
       $('.input-field input').focus(function() {
         $(this).parent().addClass('pulse');
       }).blur(function() {
         $(this).parent().removeClass('pulse');
       });
       
       // Animação do botão no hover
       $('.btn-login').hover(
         function() {
           $(this).addClass('pulse');
         },
         function() {
           $(this).removeClass('pulse');
         }
       );
     });
   </script>
 </body>
 </html>

 