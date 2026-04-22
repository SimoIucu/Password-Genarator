# Progetto PHP - Collezione di Esercizi e Applicazioni Web

Una raccolta di esercizi e applicazioni web sviluppate in PHP, HTML, CSS e JavaScript. Il progetto include form, generatori, convertitori e varie esercitazioni scolastiche.

## 📁 Struttura del Progetto

```
arraydiarray/           # Esercizio array multidimensionali
├── persona.php
convertiGradi/          # Convertitore di temperatura
├── gradi.php
es1verifica/            # Verifica 1: Calcolo importo con servizi
├── calcolaImporto.php
es2verifica/            # Verifica 2: Sistema di messaggistica
├── inviamessaggio.html
├── scrivimessaggio.php
form/                   # Generatore curriculum vitae
├── pagina.php
├── risultato.php
img/                    # Immagini random (in sviluppo)
├── immagine.php
passaggioDatiGet/       # Passaggio dati con metodo GET
├── newsGet.php
├── nuova_newsGet.html
passaggioDatiPost/      # Passaggio dati con metodo POST
├── news.php
├── nuova_news.html
passaggioDatiPostback/  # Passaggio dati con postback
├── newsPostback.php
password_generator/     # Generatore password avanzato
├── index.html
├── p.php
├── script.js
├── style.css
postback/               # Form con validazione e postback
├── formPB.php
scegliAnimale/          # Selezione animali (in sviluppo)
├── animali.php
testctf/                # Upload file CTF challenge
├── index.php
├── flag.php
├── dati/
zoo/                    # Zoo virtuale con gestione animali
├── zoo.php
```

## 🚀 Applicazioni Principali

### 1. **Password Generator** (`password_generator/`)
Generatore di password avanzato con:
- Presets di sicurezza (Debole, Media, Forte, IMPOSSIBILE)
- Slider per lunghezza personalizzabile (8-64 caratteri)
- Selezione caratteri: maiuscole, minuscole, numeri, simboli
- Valutazione forza password in tempo reale
- Bottone copia negli appunti
- Design responsive

**File:**
- [`p.php`](password_generator/p.php) - Backend PHP con logica generazione
- [`index.html`](password_generator/index.html) - Interfaccia HTML
- [`script.js`](password_generator/script.js) - Logica JavaScript
- [`style.css`](password_generator/style.css) - Stili CSS

**Come usare:**
1. Apri `p.php` nel browser
2. Seleziona il livello di sicurezza desiderato
3. Personalizza lunghezza e tipo di caratteri
4. Clicca "Genera Password"

### 2. **Zoo Virtuale** (`zoo/`)
Applicazione interattiva per gestire animali:
- Aggiungere nuovi animali con tipo, nome, colore, età, cibo
- Visualizzazione animali con foto in tabelle organizzate per tipo
- Persistenza dati in sessione (scope: singola sessione)

**File:** [`zoo.php`](zoo/zoo.php)

### 3. **Generatore Curriculum** (`form/`)
Form completo per generare CV:
- Campi: nome, cognome, email, sito, telefono, professione
- Checkbox per hobby multipli
- Radio button per stato civile
- Textarea per descrizione profilo
- Visualizzazione CV formattato con postback

**File:**
- [`pagina.php`](form/pagina.php) - Form input
- [`risultato.php`](form/risultato.php) - Visualizzazione risultati

### 4. **Calcolo Importo con Servizi** (`es1verifica/`)
Calcolatore di importi con:
- Quantità selezionabile (1-5)
- Servizi aggiuntivi: spedizione (+5€), imballaggio (+3€), assicurazione (+7€)
- Sconti: 0%, 5%, 10%, 20%
- Calcolo totale con postback

**File:** [`calcolaImporto.php`](es1verifica/calcolaImporto.php)

### 5. **Sistema Messaggi** (`es2verifica/`)
Applicazione per inviare messaggi:
- Form mittente: cognome, nome, email, password
- Form destinatario: cognome, nome, email
- Visualizzazione messaggio con orario invio

**File:**
- [`inviamessaggio.html`](es2verifica/inviamessaggio.html) - Form
- [`scrivimessaggio.php`](es2verifica/scrivimessaggio.php) - Visualizzazione

### 6. **News Manager** (3 versioni)

#### Passaggio GET (`passaggioDatiGet/`)
- Metodo: GET (parametri in URL)
- Dati: data, titolo, abstract, testo, evidenza, contenuto, autore
- Abstract generato automaticamente da primo 40 caratteri se non fornito

**File:**
- [`nuova_newsGet.html`](passaggioDatiGet/nuova_newsGet.html)
- [`newsGet.php`](passaggioDatiGet/newsGet.php)

#### Passaggio POST (`passaggioDatiPost/`)
- Metodo: POST (dati nel body)
- Stessi campi della versione GET

**File:**
- [`nuova_news.html`](passaggioDatiPost/nuova_news.html)
- [`news.php`](passaggioDatiPost/news.php)

#### Postback (`passaggioDatiPostback/`)
- Metodo: POST con postback (form e risultati stesso file)
- Visualizzazione immediata dopo invio

**File:** [`newsPostback.php`](passaggioDatiPostback/newsPostback.php)

### 7. **Convertitore Temperature** (`convertiGradi/`)
Convertitore da/verso Celsius, Fahrenheit, Kelvin
- Input numerico con decimali
- Dropdown selezione unità partenza/arrivo
- Conversione tramite Kelvin (metodo standard)

**File:** [`gradi.php`](convertiGradi/gradi.php)

### 8. **Upload File CTF** (`testctf/`)
Applicazione caricamento file:
- Input file con `enctype="multipart/form-data"`
- Salvataggio in cartella `dati/`
- Generazione link al file caricato
- URL assoluto per visualizzazione

**File:**
- [`index.php`](testctf/index.php) - Handler upload
- [`flag.php`](testctf/flag.php) - Flag nascosta per CTF

### 9. **Form Curriculum con Validazione** (`postback/`)
CV avanzato con:
- Validazione email con `filter_var()`
- Validazione nomi con regex (accenti italiani supportati)
- Prevenzione XSS con `htmlspecialchars()`
- Gestione errori con array
- Trim automatico whitespace

**File:** [`formPB.php`](postback/formPB.php)

### 10. **Array di Array** (`arraydiarray/`)
Esercizio gestione strutture dati complesse:
- Array multidimensionale di persone
- Visualizzazione in tabella HTML
- Cicli foreach annidati

**File:** [`persona.php`](arraydiarray/persona.php)

## 🛠️ Tecnologie Utilizzate

- **Backend:** PHP 7.4+
- **Frontend:** HTML5, CSS3, JavaScript (Vanilla)
- **Server:** XAMPP/Apache
- **Database:** Nessuno (dati in memoria/sessione)

## 📋 Funzionalità Comuni

### Sicurezza
- ✅ Sanitizzazione input con `htmlspecialchars()`
- ✅ Validazione email con `filter_var()`
- ✅ Validazione regex per campi testo
- ✅ Metodo POST per dati sensibili

### Validazione
- ✅ Campi obbligatori con `required`
- ✅ Validazione tipo input HTML5
- ✅ Controlli logici server-side PHP
- ✅ Array errori per feedback utente

### UX/UI
- ✅ Design responsive con clamp() CSS
- ✅ Presets e valori di default
- ✅ Feedback visuale (colori, icone)
- ✅ Slider range per input numerici
- ✅ Copy to clipboard per password

## 🎯 Obiettivi Didattici

- Metodi HTTP: GET, POST, Postback
- Form handling in PHP
- Validazione e sanitizzazione dati
- Array e cicli (foreach, for)
- Funzioni personalizzate
- Sessioni e stato
- Regex patterns
- File upload
- CSS responsive
- JavaScript vanilla

## 🔧 Configurazione

### Requisiti
- PHP >= 7.4
- Apache con mod_rewrite
- Browser moderno

### Installazione
1. Clona/scarica la cartella in `htdocs/`
2. Avvia Apache da XAMPP Control Panel
3. Accedi a `http://localhost/project/`

### Struttura cartelle
```
htdocs/
└── project/
    ├── arraydiarray/
    ├── convertiGradi/
    ├── es1verifica/
    ├── ... (altre cartelle)
    └── README.md
```

## 📝 Note di Sviluppo

### In Sviluppo
- [`scegliAnimale/animali.php`](scegliAnimale/animali.php) - Template vuoto
- [`img/immagine.php`](img/immagine.php) - Array immagini da completare

### Miglioramenti Futuri
- [ ] Database MySQL per persistenza dati
- [ ] Session management
- [ ] Autenticazione utenti
- [ ] API REST
- [ ] Rate limiting upload
- [ ] Criptografia password
- [ ] Logging errori

## 📞 Supporto

Per domande o problemi:
1. Controlla la console browser (F12)
2. Verifica il server PHP è attivo
3. Controlla i permessi cartelle (specialmente `testctf/dati/`)

## 📄 Licenza

Progetto scolastico - Uso libero per scopi educativi.

---

**Ultimo aggiornamento:** 2024
**Versione:** 1.0