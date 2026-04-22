const passwordEl = document.getElementById("password");
const lengthEl = document.getElementById("length");
const lengthValue = document.getElementById("lengthValue");
const uppercaseEl = document.getElementById("uppercase");
const lowercaseEl = document.getElementById("lowercase");
const numbersEl = document.getElementById("numbers");
const symbolsEl = document.getElementById("symbols");
const generateBtn = document.getElementById("generateBtn");
const copyBtn = document.getElementById("copyBtn");
const strengthBar = document.getElementById("strengthBar");
const difficultySelect = document.getElementById("difficulty");

// Presets difficoltà
const difficultyPresets = {
  easy: {
    minLength: 8,
    defaultLength: 10,
    upper: false,
    lower: true,
    numbers: true,
    symbols: false,
    desc: "🟢 Facile - Per account temporanei o poco importanti"
  },
  medium: {
    minLength: 12,
    defaultLength: 12,
    upper: true,
    lower: true,
    numbers: true,
    symbols: false,
    desc: "🟡 Medio - Adatta per social e servizi generici"
  },
  hard: {
    minLength: 16,
    defaultLength: 20,
    upper: true,
    lower: true,
    numbers: true,
    symbols: true,
    desc: "🔴 Difficile - Per email, banking e dati sensibili"
  }
};

// Applica preset difficoltà
function applyDifficulty() {
  const difficulty = difficultySelect.value;
  const preset = difficultyPresets[difficulty];
  
  // Aggiorna descrizione
  document.getElementById("difficultyDesc").textContent = preset.desc;
  
  // Aggiorna slider
  lengthEl.min = preset.minLength;
  lengthEl.value = preset.defaultLength;
  lengthValue.textContent = preset.defaultLength;
  
  // Aggiorna checkbox
  uppercaseEl.checked = preset.upper;
  lowercaseEl.checked = preset.lower;
  numbersEl.checked = preset.numbers;
  symbolsEl.checked = preset.symbols;
}

// aggiorna numero slider
lengthEl.addEventListener("input", () => {
  lengthValue.textContent = lengthEl.value;
});

// genera password
generateBtn.addEventListener("click", () => {
  const length = parseInt(lengthEl.value);

  const password = generatePassword(
    length,
    uppercaseEl.checked,
    lowercaseEl.checked,
    numbersEl.checked,
    symbolsEl.checked
  );

  passwordEl.value = password;
  updateStrength(password);
});

// copia
copyBtn.addEventListener("click", () => {
  if (!passwordEl.value) return;

  navigator.clipboard.writeText(passwordEl.value);
  copyBtn.textContent = "✅";

  setTimeout(() => (copyBtn.textContent = "📋"), 1500);
});

// funzione generatore
function generatePassword(length, upper, lower, number, symbol) {
  let chars = "";

  if (upper) chars += "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
  if (lower) chars += "abcdefghijklmnopqrstuvwxyz";
  if (number) chars += "0123456789";
  if (symbol) chars += "!@#$%^&*()_+[]{}";

  if (chars.length === 0) {
    alert("Seleziona almeno un'opzione!");
    return "";
  }

  let password = "";

  for (let i = 0; i < length; i++) {
    const randomIndex = Math.floor(Math.random() * chars.length);
    password += chars[randomIndex];
  }

  return password;
}

// barra sicurezza
function updateStrength(password) {
  let strength = 0;

  if (password.length >= 12) strength++;
  if (/[A-Z]/.test(password)) strength++;
  if (/[0-9]/.test(password)) strength++;
  if (/[^A-Za-z0-9]/.test(password)) strength++;

  const width = strength * 25;
  strengthBar.style.width = width + "%";

  if (strength <= 1) strengthBar.style.background = "#ff4d4d";
  else if (strength === 2) strengthBar.style.background = "#ffa500";
  else if (strength === 3) strengthBar.style.background = "#ffff66";
  else strengthBar.style.background = "#00ff99";
}

// Inizializza al caricamento
document.addEventListener("DOMContentLoaded", () => {
  applyDifficulty();
});