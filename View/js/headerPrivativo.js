function confirmLogout(userName) {
    if (confirm(`Olá, ${userName}! Tem certeza que deseja sair?`)) {
        window.location.href = '../Controller/logout.php';
    }
}