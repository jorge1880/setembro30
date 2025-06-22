document.addEventListener('DOMContentLoaded', function() {
      // Inicializa menu mobile
      var elems = document.querySelectorAll('.sidenav');
      var instances = M.Sidenav.init(elems);
      
      // Inicializa carrossel principal
      var mainCarousel = document.querySelectorAll('.carousel.carousel-slider');
      var carouselInstances = M.Carousel.init(mainCarousel, {
        fullWidth: true,
        indicators: true
      });

      // Inicializa carrossel da seção sobre
      var sobreCarousel = document.querySelectorAll('.sobre-carousel');
      var sobreCarouselInstances = M.Carousel.init(sobreCarousel, {
        fullWidth: true,
        indicators: true
      });

      // Animações aleatórias para carrossel principal
      setInterval(function(){
        const random = Math.floor(Math.random() * carouselInstances[0].count);
        carouselInstances[0].set(random);
      }, 4000);

      // Animações aleatórias para carrossel sobre
      setInterval(function(){
        const randomSobre = Math.floor(Math.random() * sobreCarouselInstances[0].count);
        sobreCarouselInstances[0].set(randomSobre);
      }, 5000);

      // Inicializa tooltips
      var tooltips = document.querySelectorAll('.tooltipped');
      M.Tooltip.init(tooltips);

      // Efeito de aparecimento nas seções ao rolar
      const observerOptions = {
        root: null,
        rootMargin: '0px',
        threshold: 0.15
      };

      const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
          if (entry.isIntersecting) {
            entry.target.classList.add('visible');
          }
        });
      }, observerOptions);

      const sections = document.querySelectorAll('.animated-section');
      sections.forEach(section => {
        observer.observe(section);
      });

      // EFEITO DE DIGITAÇÃO NO TÍTULO PRINCIPAL
      function typeWriter(element, text, speed = 80) {
        let i = 0;
        element.innerHTML = '';
        function typing() {
          if (i < text.length) {
            element.innerHTML += text.charAt(i);
            i++;
            setTimeout(typing, speed);
          }
        }
        typing();
      }
      const title = document.querySelector('#home h3');
      if (title) {
        typeWriter(title, 'INSTITUTO POLITÉCNICO 30 DE SETEMBRO');
      }

      // ROLAGEM SUAVE PARA SEÇÕES
      function scrollToSection(selector) {
        const section = document.querySelector(selector);
        if (section) {
          section.scrollIntoView({ behavior: 'smooth' });
        }
      }
      document.querySelectorAll('a[href^="#"]').forEach(link => {
        link.addEventListener('click', function(e) {
          const href = this.getAttribute('href');
          if (href.length > 1 && document.querySelector(href)) {
            e.preventDefault();
            scrollToSection(href);
          }
        });
      });

      // EFEITO DE HOVER NOS CARDS DE POSTS E FÓRUNS
      const cardSelector = '.card';
      document.querySelectorAll(cardSelector).forEach(card => {
        card.addEventListener('mouseenter', function() {
          card.style.transform = 'scale(1.04)';
          card.style.boxShadow = '0 8px 24px rgba(0,0,0,0.18)';
        });
        card.addEventListener('mouseleave', function() {
          card.style.transform = '';
          card.style.boxShadow = '';
        });
      });

      // FEEDBACK VISUAL NO FORMULÁRIO DE CONTATO
      const contatoForm = document.querySelector('#contactos form');
      if (contatoForm) {
        contatoForm.addEventListener('submit', function(e) {
          e.preventDefault();
          // Simula envio (pode ser adaptado para AJAX real)
          const nome = contatoForm.querySelector('#nome').value;
          const email = contatoForm.querySelector('#email').value;
          const mensagem = contatoForm.querySelector('#mensagem').value;
          if (nome && email && mensagem) {
            M.toast({html: 'Mensagem enviada com sucesso!', classes: 'green'});
            contatoForm.reset();
          } else {
            M.toast({html: 'Preencha todos os campos!', classes: 'red'});
          }
        });
      }

      // CONTADOR ANIMADO (exemplo: alunos, cursos, professores)
      function animateCounter(element, end, duration = 1200) {
        let start = 0;
        let increment = end / (duration / 20);
        function update() {
          start += increment;
          if (start < end) {
            element.innerText = Math.floor(start);
            setTimeout(update, 20);
          } else {
            element.innerText = end;
          }
        }
        update();
      }
      document.querySelectorAll('.counter-animate').forEach(counter => {
        const end = parseInt(counter.getAttribute('data-count'));
        animateCounter(counter, end);
      });
    });

    