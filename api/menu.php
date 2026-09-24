<?php
/**
 * Menu Caching Proxy for Google Sheets
 * 
 * - Verhindert die direkte Datenübertragung von Besucher-IPs an Google (100% DSGVO-konform)
 * - Versteckt die Google-Sheet-URL vor dem Frontend
 * - Speichert die Speisekarte lokal für eine einstellbare Zeit (Cache)
 * - Garantiert extrem schnelle Ladezeiten und Ausfallsicherheit (Stale-While-Revalidate Fallback)
 */

// ==========================================
// KONFIGURATION
// ==========================================
$GOOGLE_SHEET_CSV_URL = 'https://docs.google.com/spreadsheets/d/e/2PACX-1vQpYn6XJ9WorExPRpP2x2wvL_Qne1Ajj_gubkDY3xa24wUB7mNxnpyJk3vkF5Q-XhGbl43shqp9Vj7Q/pub?output=csv';

// Cache-Einstellungen
$CACHE_DIR = __DIR__ . '/cache';
$CACHE_FILE = $CACHE_DIR . '/menu.csv';
$CACHE_LIFETIME = 900; // Gültigkeit in Sekunden (900 = 15 Minuten)

// Verzeichnis für Cache erstellen, falls noch nicht vorhanden
if (!is_dir($CACHE_DIR)) {
    @mkdir($CACHE_DIR, 0755, true);
}

// HTTP Header setzen
header('Content-Type: text/csv; charset=UTF-8');
header('Cache-Control: public, max-age=300'); // Browser-Cache 5 Minuten
header('Access-Control-Allow-Origin: *');

$cacheExists = file_exists($CACHE_FILE);
$cacheAge = $cacheExists ? (time() - filemtime($CACHE_FILE)) : PHP_INT_MAX;

// 1. Wenn Cache aktuell ist, sofort ausliefern
if ($cacheExists && $cacheAge < $CACHE_LIFETIME) {
    readfile($CACHE_FILE);
    exit;
}

// 2. Frische Daten von Google Sheets abrufen
$freshCSV = fetchFromRemote($GOOGLE_SHEET_CSV_URL);

// Validierung: Prüfen, ob Inhalt empfangen wurde und valide CSV-Spalten enthält
if ($freshCSV !== false && strlen(trim($freshCSV)) > 20 && stripos($freshCSV, 'Kategorie') !== false) {
    @file_put_contents($CACHE_FILE, $freshCSV);
    echo $freshCSV;
    exit;
}

// 3. Fallback: Bei Netzwerkfehler oder Google-Ausfall bestehenden Cache nutzen
if ($cacheExists) {
    readfile($CACHE_FILE);
    exit;
}

// 4. Notfall-Antwort, wenn kein Cache vorhanden ist und Google nicht antwortet
http_response_code(502);
echo "Fehler: Speisekarte konnte nicht geladen werden.";
exit;

/**
 * Hilfsfunktion zum Abrufen von Remote-Inhalten (unterstützt cURL & allow_url_fopen)
 */
function fetchFromRemote($url) {
    if (function_exists('curl_init')) {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($ch, CURLOPT_MAXREDIRS, 5);
        curl_setopt($ch, CURLOPT_TIMEOUT, 10);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true);
        curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/120.0.0.0 Safari/537.36');
        
        $data = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        unset($ch);

        if ($httpCode >= 200 && $httpCode < 300 && !empty($data)) {
            return $data;
        }
    }

    // Fallback falls cURL nicht aktiv ist
    if (ini_get('allow_url_fopen')) {
        $context = stream_context_create([
            'http' => [
                'method' => 'GET',
                'timeout' => 10,
                'follow_location' => 1,
                'header' => "User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64)\r\n"
            ]
        ]);
        $data = @file_get_contents($url, false, $context);
        if (!empty($data)) {
            return $data;
        }
    }

    return false;
}
