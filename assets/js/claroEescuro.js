const themeToggle = document.getElementById('switch');

// Verifica se já existe tema salvo
if (!localStorage.getItem('theme')) {
  const horaAtual = new Date().getHours();

  // Se for entre 19h e 5h59, aplica modo escuro automaticamente
  if (horaAtual >= 19 || horaAtual < 6) {
    document.body.classList.add('dark-theme');
    themeToggle.checked = true;
    localStorage.setItem('theme', 'dark');
  } else {
    document.body.classList.remove('dark-theme');
    themeToggle.checked = false;
    localStorage.setItem('theme', 'light');
  }
} else {
  // Aplica o tema salvo
  if (localStorage.getItem('theme') === 'dark') {
    document.body.classList.add('dark-theme');
    themeToggle.checked = true;
  } else {
    document.body.classList.remove('dark-theme');
    themeToggle.checked = false;
  }
}

// Troca de tema manual
themeToggle.addEventListener('change', () => {
  if (themeToggle.checked) {
    document.body.classList.add('dark-theme');
    localStorage.setItem('theme', 'dark');
  } else {
    document.body.classList.remove('dark-theme');
    localStorage.setItem('theme', 'light');
  }
});
