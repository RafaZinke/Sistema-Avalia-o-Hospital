// Redirecionamento após a tela de agradecimento
if (document.getElementById('contador')) {
    let contador = 5;
    const interval = setInterval(() => {
        contador--;
        document.getElementById('contador').innerText = contador;
        if (contador <= 0) {
            clearInterval(interval);
            window.location.href = "index.php";
        }
    }, 1000);
}
