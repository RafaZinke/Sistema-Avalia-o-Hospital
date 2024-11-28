document.addEventListener("DOMContentLoaded", () => {
  const radios = document.querySelectorAll("input[type='radio']");
  const notaInput = document.getElementById("nota");

  radios.forEach((radio) => {
    radio.addEventListener("change", (event) => {
      // Obter o valor associado ao emoji selecionado
      const nota = event.target.dataset.nota;

      // Atualizar o campo oculto com a nota selecionada
      notaInput.value = nota;

      // Remover a classe 'selected' de todos os emojis
      radios.forEach((r) => r.parentElement.classList.remove("selected"));

      // Adicionar a classe 'selected' ao emoji atual
      radio.parentElement.classList.add("selected");
    });
  });
});
