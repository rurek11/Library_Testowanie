#!/bin/bash

# Utwórz folder reports jeśli nie istnieje
mkdir -p reports

# Nazwa pliku z aktualną datą i godziną
REPORT_NAME="k6_$(date +%Y-%m-%d_%H-%M-%S).json"

# Uruchom test i zapisz wynik do pliku
k6 run --out json=reports/$REPORT_NAME k6_stress_test.js

# Komunikat końcowy
echo "\n✔️ Raport zapisany jako: reports/$REPORT_NAME"
