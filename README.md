# SQUAD RUSH — Fake-Ad Lane Runner

Ein Crowd-/Squad-Runner im Stil der bekannten "Fake Ads" (Tower War, Army Men Run):
Die Squad läuft automatisch nach vorne, gesteuert wird nur die horizontale Position.
Gates lassen die Truppe wachsen, Barrieren kosten Zeit, alle 5 Level wartet ein Boss.

**Alles steckt in einer einzigen Datei: [`index.html`](index.html).**
Kein Build, keine Dependencies, keine Assets — Canvas 2D + Vanilla JS, alle Grafiken
werden per Code gezeichnet.

## Spielen

```bash
# einfach im Browser öffnen
xdg-open index.html      # bzw. open index.html / Doppelklick
```

Für Touch-Tests genügt ein beliebiger statischer Server, z. B. `python3 -m http.server`.

## Steuerung

| Plattform | Eingabe |
|---|---|
| Desktop | Pfeiltasten ← → bzw. A/D, oder mit der Maus ziehen |
| Mobile | Finger irgendwo auf dem Feld halten und ziehen (relatives Dragging) |

## Spielprinzip

Der Level-Generator legt alles in **drei Spuren**:

* **Spur A (links, sicher)** — Gates: `+2`, `+5`, `×2`
* **Spur Mitte** — Gegnerwellen, die der Squad entgegenlaufen
* **Spur B (rechts, Risiko)** — starke Gates (`×5`, `+20`, 20 s Waffen-Upgrade),
  davor immer eine **Barriere mit HP-Balken**. Wer sie nicht rechtzeitig wegschießt,
  prallt dagegen und verliert laufend Soldaten.

Die Spuren sind nicht starr — die Squad bewegt sich stufenlos über das ganze Feld.

* **Squad:** Start mit 1 Soldat, Formation als Phyllotaxis-Packung um den Mittelpunkt,
  sichtbar bis 60 Soldaten, danach zählt nur noch der Zähler.
  Gesamt-DPS = Soldaten × Waffenschaden × Feuerrate (die Salve wird auf max. 8
  sichtbare Schützen aufgeteilt, der Schaden bleibt exakt).
* **Gegner:** Runner (schnell, wenig HP), Tank (langsam, viel HP),
  Splitter (teilt sich beim Tod in zwei Scherben).
* **Boss** alle 5 Level: eigener HP-Balken, 3 Phasen, zwei Angriffsmuster
  (gefächerter Flächenschuss + Spawnen von Minions), beide werden pro Phase aggressiver.

## Progression

* **XP** aus Kills, durchbrochenen Barrieren, Boss und Level-Abschluss.
  Account-Level-Up → 1 Kartenpack (3 Karten). Bei einer Niederlage bleibt die Hälfte der XP.
* **Karten** in vier Seltenheiten (Common/Rare/Epic/Legendary) und drei Kategorien:
  * *Soldaten*: Start-Soldaten, Soldaten-HP, Bewegungstempo
  * *Waffen*: Schaden, Feuerrate, Durchschuss, Schrot (3 Projektile), Explosionsschaden
  * *Utility*: Gate-Werte +%, Barrieren-Schaden +%, Magnet (Gate-Reichweite)
* **3 gleiche Karten = Merge** auf die nächste Stufe (bis ★4).
* **Max. 5 Karten** gleichzeitig ausgerüstet, verwaltet im Meta-Screen zwischen den Leveln.
* Alles (Level, XP, Kartenbestand, Ausrüstung) liegt in `localStorage` und übersteht einen Reload.

## Balancing

Sämtliche Stellschrauben stehen gebündelt im `CFG`-Block ganz oben im `<script>` von
`index.html` — Schaden, Feuerrate, Laufgeschwindigkeit, Gegner-HP, Barrieren-HP,
Boss-HP, Gate-Werte, XP-Kurve und die Game-Feel-Parameter.

## Game Feel

Screen-Shake bei Boss-Treffern und Anprall, Partikel bei Kills, aufploppende
Schadenszahlen, Hitstop beim Barrieren-Durchbruch, kurz aufskalierender
Soldatenzähler beim Einsammeln, sanftes Kamera-Lerp bei der Seitwärtsbewegung
und ein roter Screen-Flash bei Verlusten.
