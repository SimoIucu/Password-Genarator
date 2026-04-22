<?php

function generatePassword($length, $useUpper, $useLower, $useNumbers, $useSymbols) {
    $sets = [];

    if ($useUpper) $sets[] = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
    if ($useLower) $sets[] = 'abcdefghijklmnopqrstuvwxyz';
    if ($useNumbers) $sets[] = '0123456789';
    if ($useSymbols) $sets[] = '!@#$%^&*()-_=+[]{}<>?/\\|;:,.';

    if (empty($sets)) {
        $sets[] = 'abcdefghijklmnopqrstuvwxyz';
    }

    if (count($sets) > $length) {
        shuffle($sets);
        $sets = array_slice($sets, 0, $length);
    }

    $all = implode('', $sets);
    $password = [];

    foreach ($sets as $set) {
        $password[] = $set[random_int(0, strlen($set) - 1)];
    }

    for ($i = count($password); $i < $length; $i++) {
        $password[] = $all[random_int(0, strlen($all) - 1)];
    }

    // Fisher-Yates shuffle sicuro
    for ($i = count($password) - 1; $i > 0; $i--) {
        $j = random_int(0, $i);
        $tmp = $password[$i];
        $password[$i] = $password[$j];
        $password[$j] = $tmp;
    }

    return implode('', $password);
}

function evaluateStrength($password) {
    $length = strlen($password);
    $score = 0;
    
    if ($length >= 12) $score++;
    if ($length >= 20) $score++;
    if ($length >= 32) $score++;
    if (preg_match('/[A-Z]/', $password)) $score++;
    if (preg_match('/[a-z]/', $password)) $score++;
    if (preg_match('/[0-9]/', $password)) $score++;
    if (preg_match('/[^a-zA-Z0-9]/', $password)) $score++;

    if ($score <= 3) return ['Debole', 'weak'];
    if ($score <= 5) return ['Media', 'medium'];
    if ($score <= 7) return ['Forte', 'strong'];
    return ['IMPOSSIBILE', 'impossible'];
}

$securityPresets = [
    'weak' => [
        'label' => 'Debole',
        'minLength' => 8,
        'defaultLength' => 10,
        'upper' => false,
        'lower' => true,
        'numbers' => true,
        'symbols' => false,
        'desc' => 'Per account temporanei o poco importanti'
    ],
    'medium' => [
        'label' => 'Media',
        'minLength' => 12,
        'defaultLength' => 14,
        'upper' => true,
        'lower' => true,
        'numbers' => true,
        'symbols' => false,
        'desc' => 'Adatta per la maggior parte dei servizi online'
    ],
    'strong' => [
        'label' => 'Forte',
        'minLength' => 16,
        'defaultLength' => 20,
        'upper' => true,
        'lower' => true,
        'numbers' => true,
        'symbols' => true,
        'desc' => 'Per email, banking e dati sensibili'
    ],
    'impossible' => [
        'label' => 'IMPOSSIBILE',
        'minLength' => 32,
        'defaultLength' => 48,
        'upper' => true,
        'lower' => true,
        'numbers' => true,
        'symbols' => true,
        'desc' => 'Crittografia, chiavi master, wallet crypto - Resiste a attacchi brute-force per secoli'
    ]
];

$password = '';
$strengthLabel = '';
$strengthClass = '';

$selectedSecurity = 'medium';
$defaultLength = $securityPresets['medium']['defaultLength'];
$defaultUpper = $securityPresets['medium']['upper'];
$defaultLower = $securityPresets['medium']['lower'];
$defaultNumbers = $securityPresets['medium']['numbers'];
$defaultSymbols = $securityPresets['medium']['symbols'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $selectedSecurity = $_POST['security'] ?? 'medium';
    $preset = $securityPresets[$selectedSecurity] ?? $securityPresets['medium'];
    
    $length = intval($_POST['length'] ?? $preset['defaultLength']);
    $length = min(64, max($preset['minLength'], $length));
    
    if (isset($_POST['customChars'])) {
        $useUpper = isset($_POST['useUpper']);
        $useLower = isset($_POST['useLower']);
        $useNumbers = isset($_POST['useNumbers']);
        $useSymbols = isset($_POST['useSymbols']);
    } else {
        $useUpper = $preset['upper'];
        $useLower = $preset['lower'];
        $useNumbers = $preset['numbers'];
        $useSymbols = $preset['symbols'];
    }
    
    if (!$useUpper && !$useLower && !$useNumbers && !$useSymbols) {
        $useLower = true;
    }

    $password = generatePassword($length, $useUpper, $useLower, $useNumbers, $useSymbols);
    list($strengthLabel, $strengthClass) = evaluateStrength($password);
    
    $defaultLength = $length;
    $defaultUpper = $useUpper;
    $defaultLower = $useLower;
    $defaultNumbers = $useNumbers;
    $defaultSymbols = $useSymbols;
}
?>

<!DOCTYPE html>
<html lang="it">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Password Generator - Sicurezza Avanzata</title>
<link rel="stylesheet" href="style.css">
</head>
<body>

<div class="card">
    <h1>Password <span>Generator</span></h1>

    <form method="POST" id="passForm">
        
        <!-- LIVELLO DI SICUREZZA -->
        <label for="security">Livello di sicurezza</label>
        <select name="security" id="security" onchange="applyPreset()">
            <?php foreach ($securityPresets as $key => $preset): ?>
                <option value="<?php echo $key; ?>" 
                        <?php echo ($selectedSecurity === $key) ? 'selected' : ''; ?>>
                    <?php echo htmlspecialchars($preset['label']); ?>
                </option>
            <?php endforeach; ?>
        </select>
        <div class="preset-desc" id="presetDesc">
            <?php echo $securityPresets[$selectedSecurity]['desc']; ?>
        </div>

        <!-- LUNGHEZZA -->
        <label for="length">Lunghezza password: <span class="length-value" id="lenValue"><?php echo $defaultLength; ?></span></label>
        <div class="slider-container">
            <input type="range" id="length" name="length" min="8" max="64" value="<?php echo $defaultLength; ?>">
        </div>

        <!-- PERSONALIZZAZIONE CARATTERI -->
        <div class="custom-section">
            <label class="custom-toggle">
                <input type="checkbox" id="customToggle" name="customChars" value="1" 
                       <?php echo isset($_POST['customChars']) ? 'checked' : ''; ?>>
                Personalizza tipi di caratteri (override preset)
            </label>
            
            <div class="checkbox-group" id="charOptions" style="<?php echo !isset($_POST['customChars']) ? 'opacity:0.5;pointer-events:none;' : ''; ?>">
                <label><input type="checkbox" name="useUpper" value="1" <?php echo $defaultUpper ? 'checked' : ''; ?>> Maiuscole</label>
                <label><input type="checkbox" name="useLower" value="1" <?php echo $defaultLower ? 'checked' : ''; ?>> Minuscole</label>
                <label><input type="checkbox" name="useNumbers" value="1" <?php echo $defaultNumbers ? 'checked' : ''; ?>> Numeri</label>
                <label><input type="checkbox" name="useSymbols" value="1" <?php echo $defaultSymbols ? 'checked' : ''; ?>> Simboli</label>
            </div>
        </div>

        <button type="submit">Genera Password</button>
    </form>

    <?php if ($password): ?>
        <div class="strength <?php echo $strengthClass; ?>" id="strengthIndicator">
            Forza: <?php echo $strengthLabel; ?>
        </div>
        
        <div class="strength-info">
            <?php 
            $info = [
                'weak' => 'Usare solo per account temporanei',
                'medium' => 'Adeguata per social e servizi generici',
                'strong' => 'Consigliata per email, banking, dati personali',
                'impossible' => 'Livello militare: resiste a supercomputer per millenni'
            ];
            echo $info[$strengthClass] ?? '';
            ?>
        </div>

        <div class="result" id="passwordResult">
            <?php echo htmlspecialchars($password); ?>
            <button type="button" class="copy-btn" onclick="copyPassword()">Copia</button>
        </div>
    <?php endif; ?>
</div>

<script>
const presetDescs = {
    <?php foreach ($securityPresets as $key => $preset): ?>
    <?php echo json_encode($key); ?>: <?php echo json_encode($preset['desc']); ?>,
    <?php endforeach; ?>
};

const presetLengths = {
    <?php foreach ($securityPresets as $key => $preset): ?>
    '<?php echo $key; ?>': { min: <?php echo $preset['minLength']; ?>, default: <?php echo $preset['defaultLength']; ?> },
    <?php endforeach; ?>
};

function applyPreset() {
    const security = document.getElementById('security').value;
    const preset = presetLengths[security];
    
    document.getElementById('presetDesc').textContent = presetDescs[security];
    
    const slider = document.getElementById('length');
    const lenValue = document.getElementById('lenValue');
    
    slider.min = preset.min;
    if (slider.value < preset.min) {
        slider.value = preset.default;
    }
    lenValue.textContent = slider.value;
    
    if (!document.getElementById('customToggle').checked) {
        updateCheckboxesFromPreset(security);
    }
}

function updateCheckboxesFromPreset(security) {
    const presets = {
        <?php foreach ($securityPresets as $key => $preset): ?>
        '<?php echo $key; ?>': {
            upper: <?php echo $preset['upper'] ? 'true' : 'false'; ?>,
            lower: <?php echo $preset['lower'] ? 'true' : 'false'; ?>,
            numbers: <?php echo $preset['numbers'] ? 'true' : 'false'; ?>,
            symbols: <?php echo $preset['symbols'] ? 'true' : 'false'; ?>
        },
        <?php endforeach; ?>
    };
    
    const p = presets[security];
    document.querySelector('input[name="useUpper"]').checked = p.upper;
    document.querySelector('input[name="useLower"]').checked = p.lower;
    document.querySelector('input[name="useNumbers"]').checked = p.numbers;
    document.querySelector('input[name="useSymbols"]').checked = p.symbols;
}

document.getElementById('customToggle').addEventListener('change', function(e) {
    const charOptions = document.getElementById('charOptions');
    if (e.target.checked) {
        charOptions.style.opacity = '1';
        charOptions.style.pointerEvents = 'auto';
    } else {
        charOptions.style.opacity = '0.5';
        charOptions.style.pointerEvents = 'none';
        applyPreset();
    }
});

document.getElementById('length').addEventListener('input', function(e) {
    document.getElementById('lenValue').textContent = e.target.value;
});

function copyPassword() {
    const password = document.getElementById('passwordResult').firstChild.textContent.trim();
    navigator.clipboard.writeText(password).then(() => {
        const btn = document.querySelector('.copy-btn');
        const originalText = btn.textContent;
        btn.textContent = 'Copiata!';
        btn.classList.add('copied');
        setTimeout(() => {
            btn.textContent = originalText;
            btn.classList.remove('copied');
        }, 2000);
    }).catch(err => {
        console.error('Errore copia:', err);
        alert('Impossibile copiare: seleziona il testo manualmente');
    });
}

document.addEventListener('DOMContentLoaded', function() {
    applyPreset();
});
</script>

</body>
</html>