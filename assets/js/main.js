(function () {
  "use strict";

  var header = document.querySelector(".header");
  var burger = document.querySelector(".burger");
  var nav = document.getElementById("menu");

  /* Cabeçalho ganha sombra ao rolar */
  function onScroll() {
    if (header) header.classList.toggle("is-stuck", window.scrollY > 8);
  }
  onScroll();
  window.addEventListener("scroll", onScroll, { passive: true });

  /* Menu mobile */
  function setMenu(open) {
    if (!burger || !nav) return;
    burger.setAttribute("aria-expanded", String(open));
    burger.setAttribute("aria-label", open ? "Fechar menu" : "Abrir menu");
    nav.classList.toggle("is-open", open);
  }
  if (burger && nav) {
    burger.addEventListener("click", function () {
      setMenu(burger.getAttribute("aria-expanded") !== "true");
    });
    nav.addEventListener("click", function (e) {
      if (e.target.closest("a")) setMenu(false);
    });
    document.addEventListener("keydown", function (e) {
      if (e.key === "Escape") setMenu(false);
    });
  }

  /* Formulário de agendamento: monta a mensagem e continua no WhatsApp da unidade */
  var form = document.getElementById("agendar");
  if (form && form.dataset.units) {
    var units = {};
    try { units = JSON.parse(form.dataset.units); } catch (err) { units = {}; }
    var hint = form.querySelector(".form__hint");

    /* ?unidade=kids na URL já escolhe a unidade */
    var wanted = new URLSearchParams(window.location.search).get("unidade");
    if (wanted && units[wanted]) form.elements.unidade.value = wanted;

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
      var text = "Olá! Meu nome é " + value + " e gostaria de agendar uma consulta na " + u.name + "." + (msg ? " " + msg : "");
      window.open("https://wa.me/" + u.phone + "?text=" + encodeURIComponent(text), "_blank", "noopener");
    });
    form.elements.nome.addEventListener("input", function () {
      this.removeAttribute("aria-invalid");
      hint.textContent = "";
    });
  }

  /* Galeria de Instalações: ampliar a foto */
  var thumbs = document.querySelectorAll("a[data-lightbox]");
  if (thumbs.length && typeof HTMLDialogElement === "function") {
    var dlg = document.createElement("dialog");
    dlg.className = "lightbox";
    dlg.innerHTML = '<button type="button" aria-label="Fechar">✕</button><img alt=""><p></p>';
    document.body.appendChild(dlg);
    var img = dlg.querySelector("img");
    var cap = dlg.querySelector("p");
    dlg.querySelector("button").addEventListener("click", function () { dlg.close(); });
    dlg.addEventListener("click", function (e) { if (e.target === dlg) dlg.close(); });
    Array.prototype.forEach.call(thumbs, function (a) {
      a.addEventListener("click", function (e) {
        e.preventDefault();
        img.src = a.href;
        img.alt = a.dataset.caption || "";
        cap.textContent = a.dataset.caption || "";
        dlg.showModal();
      });
    });
  }
})();
