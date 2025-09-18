
// Em perfil.html
const usuario = JSON.parse(sessionStorage.getItem('usuario'));
if (usuario) {
    document.getElementById('nome').textContent = usuario.nome;
    document.getElementById('cpf').textContent = usuario.cpf;
    document.getElementById('email').textContent = usuario.email;
    document.getElementById('endereco').textContent = usuario.endereco;
    // ... e assim por diante para os outros campos
} else {
    // Redirecionar para a página de login se o usuário não estiver autenticado
    window.location.href = 'cadastro.html';
}