
  const toggle = document.getElementById('switch');

  // Aplica o tema salvo se já existir
  if (localStorage.getItem('theme') === 'dark') {
    document.body.classList.add('dark-theme');
    toggle.checked = true;
  }

  // Troca de tema
  toggle.addEventListener('change', () => {
    if (toggle.checked) {
      document.body.classList.add('dark-theme');
      localStorage.setItem('theme', 'dark');
    } else {
      document.body.classList.remove('dark-theme');
      localStorage.setItem('theme', 'light');
    }
  });



