(function () {
  "use strict";

  var header = document.querySelector(".header");
  var burger = document.querySelector(".burger");
  var nav = document.getElementById("menu");

  /* Cabeçalho ganha sombra ao rolar */
  function onScroll() {
    header.classList.toggle("is-stuck", window.scrollY > 8);
  }
  onScroll();
  window.addEventListener("scroll", onScroll, { passive: true });

  /* Menu mobile */
  function setMenu(open) {
    burger.setAttribute("aria-expanded", String(open));
    burger.setAttribute("aria-label", open ? "Fechar menu" : "Abrir menu");
    nav.classList.toggle("is-open", open);
  }
  burger.addEventListener("click", function () {
    setMenu(burger.getAttribute("aria-expanded") !== "true");
  });
  nav.addEventListener("click", function (e) {
    if (e.target.closest("a")) setMenu(false);
  });
  document.addEventListener("keydown", function (e) {
    if (e.key === "Escape") setMenu(false);
  });

  /* Item atual do menu conforme a seção visível */
  var links = Array.prototype.slice.call(nav.querySelectorAll('a[href^="#"]'));
  var map = {};
  links.forEach(function (a) { map[a.getAttribute("href")] = a; });
  var targets = links
    .map(function (a) { return document.querySelector(a.getAttribute("href")); })
    .filter(Boolean);
  if ("IntersectionObserver" in window) {
    var io = new IntersectionObserver(function (entries) {
      entries.forEach(function (en) {
        if (!en.isIntersecting) return;
        links.forEach(function (a) { a.classList.remove("is-current"); });
        var id = en.target.id ? "#" + en.target.id : "#topo";
        if (map[id]) map[id].classList.add("is-current");
      });
    }, { rootMargin: "-45% 0px -50% 0px" });
    targets.forEach(function (t) { io.observe(t); });
  }

  /* Formulário: monta a mensagem e continua no WhatsApp */
  var units = {
    odonto: { phone: "5521998105205", name: "Ingá Orthos Odontologia" },
    kids:   { phone: "5521998105209", name: "Icaraí Ortho Kids" },
    choque: { phone: "5521995747704", name: "Terapia de Choque (Ingá Orthos Ortopedia)" }
  };
  var form = document.getElementById("agendar");
  var hint = form.querySelector(".form__hint");
  form.addEventListener("submit", function (e) {
    e.preventDefault();
    var nome = form.elements.nome;
    var value = nome.value.trim();
    if (!value) {
      nome.setAttribute("aria-invalid", "true");
      hint.textContent = "Digite seu nome para continuarmos.";
      nome.focus();
      return;
    }
    nome.removeAttribute("aria-invalid");
    hint.textContent = "";
    var u = units[form.elements.unidade.value];
    var msg = form.elements.msg.value.trim();
    var text = "Olá! Meu nome é " + value + " e gostaria de agendar uma consulta na " + u.name + "." +
      (msg ? " " + msg : "");
    window.open("https://wa.me/" + u.phone + "?text=" + encodeURIComponent(text), "_blank", "noopener");
  });
  form.elements.nome.addEventListener("input", function () {
    this.removeAttribute("aria-invalid");
    hint.textContent = "";
  });

  var ano = document.getElementById("ano");
  if (ano) ano.textContent = new Date().getFullYear();
})();
