(function () {
  'use strict';

  var areaEl = document.getElementById('calc-area');
  if (!areaEl) return;

  var roomEl = document.getElementById('calc-room');
  var ceilingEl = document.getElementById('calc-ceiling');
  var orientationEl = document.getElementById('calc-orientation');
  var peopleEl = document.getElementById('calc-people');
  var routeEl = document.getElementById('calc-route');

  var kwEl = document.getElementById('calc-kw');
  var btuEl = document.getElementById('calc-btu');
  var noteEl = document.getElementById('calc-note');
  var priceEl = document.getElementById('calc-price');
  var priceNoteEl = document.getElementById('calc-price-note');

  // common nominal split-unit sizes on the market, in kW
  var SIZES = [2.0, 2.5, 3.5, 5.0, 7.0, 9.0, 12.0];
  var KW_TO_BTU = 3412;

  // extra heat load per person beyond the baseline 2 already factored into the room rates, in kW
  var PERSON_LOAD_KW = 0.1;

  // orientačné ceny montáže na Slovensku podľa výkonu jednotky (vrátane trasy do ROUTE_INCLUDED_M)
  var PRICES = {
    '2': [650, 850],
    '2.5': [700, 900],
    '3.5': [800, 1050],
    '5': [950, 1250],
    '7': [1300, 1700],
    '9': [1700, 2200],
    '12': [2200, 2800]
  };
  var ROUTE_INCLUDED_M = 3;
  var ROUTE_RATE_EUR = 25;

  function formatEur(n) {
    return Math.round(n).toLocaleString('sk-SK');
  }

  function calc() {
    var area = Math.min(200, Math.max(1, parseFloat(areaEl.value) || 0));
    var base = parseFloat(roomEl.value) || 0.1;
    var ceiling = parseFloat(ceilingEl.value) || 1;
    var orientation = parseFloat(orientationEl.value) || 1;
    var people = Math.min(20, Math.max(0, parseFloat(peopleEl.value) || 0));
    var route = Math.min(60, Math.max(0, parseFloat(routeEl.value) || 0));

    var peopleExtra = Math.max(0, people - 2) * PERSON_LOAD_KW;
    var raw = area * base * ceiling * orientation + peopleExtra;

    var recommended = SIZES[SIZES.length - 1];
    var overMax = raw > recommended;
    for (var i = 0; i < SIZES.length; i++) {
      if (SIZES[i] >= raw) { recommended = SIZES[i]; overMax = false; break; }
    }

    kwEl.textContent = recommended.toFixed(1).replace('.', ',') + ' kW';

    var btu = Math.round((recommended * KW_TO_BTU) / 10) * 10;
    btuEl.textContent = '≈ ' + btu.toLocaleString('sk-SK') + ' BTU/h';

    if (overMax) {
      noteEl.textContent = 'Pri takejto ploche zvyčajne odporúčame viac jednotiek alebo multi-split systém – radi ho navrhneme priamo na mieste.';
    } else {
      noteEl.textContent = 'Orientačný odhad pre miestnosť s plochou ' + area + ' m². Presný výkon a typ jednotky potvrdíme pri bezplatnej obhliadke.';
    }

    var priceKey = String(recommended);
    var priceRange = PRICES[priceKey] || PRICES['12'];
    var extraRoute = Math.max(0, route - ROUTE_INCLUDED_M) * ROUTE_RATE_EUR;
    var priceMin = priceRange[0] + extraRoute;
    var priceMax = priceRange[1] + extraRoute;

    priceEl.textContent = formatEur(priceMin) + ' – ' + formatEur(priceMax) + ' €';
    if (overMax) {
      priceNoteEl.textContent = 'orientačná cena pre jednu jednotku danej veľkosti, pri viacerých jednotkách cenu spočítame na mieste';
    } else if (extraRoute > 0) {
      priceNoteEl.textContent = 'pri trase ' + route + ' m k vonkajšej jednotke (prvé ' + ROUTE_INCLUDED_M + ' m v základnej cene)';
    } else {
      priceNoteEl.textContent = 'vrátane trasy do ' + ROUTE_INCLUDED_M + ' m k vonkajšej jednotke';
    }
  }

  [areaEl, roomEl, ceilingEl, orientationEl, peopleEl, routeEl].forEach(function (el) {
    el.addEventListener('input', calc);
    el.addEventListener('change', calc);
  });

  calc();
})();
