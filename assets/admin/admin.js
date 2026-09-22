/* Painel do tema Ingá Orthos: repetidores e seletor de imagens */
(function () {
  "use strict";

  /* ---------- Imagens (biblioteca de mídia do WordPress) ---------- */
  function pickImage(box) {
    if (!window.wp || !wp.media) return;
    var frame = wp.media({ title: "Escolher imagem", button: { text: "Usar esta imagem" }, multiple: false, library: { type: "image" } });
    frame.on("select", function () {
      var a = frame.state().get("selection").first().toJSON();
      var url = a.sizes && a.sizes.medium ? a.sizes.medium.url : a.url;
      box.querySelector("input[type=hidden]").value = a.id;
      box.querySelector(".io-image__preview").innerHTML = '<img src="' + url + '" alt="">';
    });
    frame.open();
  }

  /* ---------- Repetidores ---------- */
  function refreshTitle(row) {
    var key = row.getAttribute("data-title-key");
    var el = key ? row.querySelector('[name$="[' + key + ']"]') : null;
    var out = row.querySelector(".io-row__title");
    if (el && out) {
      var v = (el.value || "").trim();
      out.textContent = v || "Novo item";
    }
  }

  document.addEventListener("click", function (e) {
    var t = e.target;

    var pick = t.closest(".io-image-pick");
    if (pick) {
      e.preventDefault();
      pickImage(pick.closest("[data-io-image]"));
      return;
    }
    var clear = t.closest(".io-image-clear");
    if (clear) {
      e.preventDefault();
      var box = clear.closest("[data-io-image]");
      box.querySelector("input[type=hidden]").value = "";
      box.querySelector(".io-image__preview").innerHTML = "<span>Sem imagem</span>";
      return;
    }

    var add = t.closest(".io-repeater-add");
    if (add) {
      e.preventDefault();
      var rep = add.closest("[data-io-repeater]");
      var tpl = rep.querySelector(".io-repeater__tpl");
      var html = tpl.innerHTML.replace(/__i__/g, "n" + Date.now() + Math.floor(Math.random() * 1000));
      var holder = rep.querySelector(".io-repeater__rows");
      holder.insertAdjacentHTML("beforeend", html);
      var row = holder.lastElementChild;
      row.open = true;
      row.scrollIntoView({ block: "nearest", behavior: "smooth" });
      return;
    }

    var row = t.closest(".io-row");
    if (row && t.closest(".io-row__tools")) {
      e.preventDefault(); /* não deixa o clique abrir/fechar o item */
      if (t.closest(".io-del")) {
        if (window.confirm("Remover este item?")) row.remove();
      } else if (t.closest(".io-up") && row.previousElementSibling) {
        row.parentNode.insertBefore(row, row.previousElementSibling);
      } else if (t.closest(".io-down") && row.nextElementSibling) {
        row.parentNode.insertBefore(row.nextElementSibling, row);
      }
    }
  });

  document.addEventListener("input", function (e) {
    var row = e.target.closest && e.target.closest(".io-row");
    if (row) refreshTitle(row);
  });
})();
