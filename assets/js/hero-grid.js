(function () {
  'use strict';

  var canvases = document.querySelectorAll('.hero-grid-canvas');
  if (!canvases.length) return;

  var reduce = window.matchMedia('(prefers-reduced-motion: reduce)').matches;

  // ---- tuning ----
  var CELL      = 64;    // invisible movement lattice spacing
  var COLORS    = ['#ffffff', '#cfe6ff']; // white + pale ice-blue, mixed per dot
  var SPEED     = 110;   // base px/s, each dot varies around this
  var DOT_SCALE = 1.5;   // base size, each dot varies around this
  var TAIL      = 100;   // base trail length
  var COUNT     = 10;    // number of dots

  function rand(a, b) { return a + Math.random() * (b - a); }

  function hexToRgb(hex) {
    var n = parseInt(hex.slice(1), 16);
    return [(n >> 16) & 255, (n >> 8) & 255, n & 255];
  }

  function initInstance(canvas) {
    if (!canvas.getContext) return;
    var ctx = canvas.getContext('2d');
    var W, H, cols, rows, dpr, dots = [], flashes = [];
    var running = false, rafId = null, last = 0, clock = 0;

    function resize() {
      dpr = Math.min(window.devicePixelRatio || 1, 2);
      var r = canvas.getBoundingClientRect();
      W = r.width; H = r.height;
      if (!W || !H) { stop(); return; }
      canvas.width = Math.round(W * dpr);
      canvas.height = Math.round(H * dpr);
      ctx.setTransform(dpr, 0, 0, dpr, 0, 0);
      cols = Math.ceil(W / CELL);
      rows = Math.ceil(H / CELL);
      build();
      draw(0);
      start();
    }

    function build() {
      dots = [];
      var dirs = ['lr', 'bt', 'rl'];
      for (var i = 0; i < COUNT; i++) {
        var dir = dirs[i % 3];
        var frac = (i + 0.5) / COUNT;
        var jitter = ((i * 53 + 17) % 100) / 100;
        var axis, pos;
        if (dir === 'bt') { axis = Math.round(cols * frac) * CELL; pos = H * jitter; }
        else { axis = Math.round(rows * frac) * CELL; pos = W * jitter; }
        var d = {
          dir: dir, axis: axis, pos: pos,
          speed: SPEED * rand(0.7, 1.35),
          scale: DOT_SCALE * rand(0.75, 1.5),
          tail: TAIL * rand(0.8, 1.3),
          color: COLORS[i % COLORS.length],
          phase: rand(0, Math.PI * 2),
          rotSpeed: rand(-0.6, 0.6)
        };
        seed(d);
        dots.push(d);
      }
    }

    function seed(d) {
      d.next = (d.dir === 'lr') ? Math.ceil(d.pos / CELL) * CELL : Math.floor(d.pos / CELL) * CELL;
    }

    function flash(x, y, color) {
      flashes.push({ x: x, y: y, t: 0, color: color });
      if (flashes.length > 80) flashes.shift();
    }

    function clear() {
      ctx.clearRect(0, 0, W, H);
    }

    function co(d) {
      if (d.dir === 'lr') return { hx: d.pos, hy: d.axis, tx: d.pos - d.tail, ty: d.axis };
      if (d.dir === 'rl') return { hx: d.pos, hy: d.axis, tx: d.pos + d.tail, ty: d.axis };
      return { hx: d.axis, hy: d.pos, tx: d.axis, ty: d.pos + d.tail };
    }

    // 6-armed snowflake glyph, matching the site's snowflake icon motif
    function drawSnowflake(cx, cy, r, rot, color, glow) {
      ctx.save();
      ctx.translate(cx, cy);
      ctx.rotate(rot);
      ctx.shadowColor = color;
      ctx.shadowBlur = glow;
      ctx.strokeStyle = color;
      ctx.lineCap = 'round';
      ctx.lineWidth = Math.max(1, r * 0.2);

      var branchBase = 0.6, branchLen = r * 0.38, branchAngle = Math.PI / 5.2;
      for (var i = 0; i < 6; i++) {
        var a = i * Math.PI / 3;
        var dx = Math.cos(a), dy = Math.sin(a);

        ctx.beginPath();
        ctx.moveTo(0, 0);
        ctx.lineTo(dx * r, dy * r);
        ctx.stroke();

        var bx = dx * r * branchBase, by = dy * r * branchBase;
        for (var s = -1; s <= 1; s += 2) {
          var ang = a + s * branchAngle;
          ctx.beginPath();
          ctx.moveTo(bx, by);
          ctx.lineTo(bx + Math.cos(ang) * branchLen, by + Math.sin(ang) * branchLen);
          ctx.stroke();
        }
      }
      ctx.restore();
    }

    function dot(d) {
      var c = co(d);
      var rgbStr = hexToRgb(d.color).join(',');

      var g = ctx.createLinearGradient(c.tx, c.ty, c.hx, c.hy);
      g.addColorStop(0, 'rgba(' + rgbStr + ',0)');
      g.addColorStop(1, 'rgba(' + rgbStr + ',0.4)');
      ctx.strokeStyle = g;
      ctx.lineWidth = 2 * Math.max(1, d.scale * 0.55);
      ctx.lineCap = 'round';
      ctx.beginPath(); ctx.moveTo(c.tx, c.ty); ctx.lineTo(c.hx, c.hy); ctx.stroke();

      // gentle breathing glow, offset per-dot so they don't pulse in sync
      var breathe = 0.75 + 0.25 * Math.sin(clock * 1.6 + d.phase);

      drawSnowflake(c.hx, c.hy, 4.6 * d.scale, clock * d.rotSpeed + d.phase, d.color, 9 * d.scale * 0.6 * breathe);

      ctx.save();
      ctx.shadowColor = '#ffffff';
      ctx.shadowBlur = 5 * d.scale * 0.6;
      ctx.fillStyle = '#ffffff';
      ctx.beginPath(); ctx.arc(c.hx, c.hy, 1 * d.scale, 0, 7); ctx.fill();
      ctx.restore();
    }

    function step(d, dt) {
      var dist = d.speed * dt;
      if (d.dir === 'lr') {
        d.pos += dist;
        while (d.next <= d.pos) { flash(d.next, d.axis, d.color); d.next += CELL; }
        if (d.pos - d.tail > W) { d.pos = 0; seed(d); }
      } else if (d.dir === 'rl') {
        d.pos -= dist;
        while (d.next >= d.pos) { flash(d.next, d.axis, d.color); d.next -= CELL; }
        if (d.pos + d.tail < 0) { d.pos = W; seed(d); }
      } else {
        d.pos -= dist;
        while (d.next >= d.pos) { flash(d.axis, d.next, d.color); d.next -= CELL; }
        if (d.pos + d.tail < 0) { d.pos = H; seed(d); }
      }
    }

    // two-stage "sonar" pulse: a fast bright ping plus a slower soft ring
    var FDUR = .65;
    function drawFlash(dt) {
      for (var i = flashes.length - 1; i >= 0; i--) {
        var f = flashes[i]; f.t += dt; var k = f.t / FDUR;
        if (k >= 1) { flashes.splice(i, 1); continue; }
        var rgb = hexToRgb(f.color).join(',');
        var a = 1 - k;

        ctx.strokeStyle = 'rgba(' + rgb + ',' + (a * .4).toFixed(3) + ')';
        ctx.lineWidth = 1.2;
        ctx.beginPath(); ctx.arc(f.x, f.y, 3 + k * 16, 0, 7); ctx.stroke();

        var innerK = Math.min(1, k * 2.2);
        var innerA = 1 - innerK;
        if (innerA > 0) {
          ctx.save();
          ctx.shadowColor = f.color;
          ctx.shadowBlur = 9 * innerA;
          ctx.fillStyle = 'rgba(255,255,255,' + (innerA * .85).toFixed(3) + ')';
          ctx.beginPath(); ctx.arc(f.x, f.y, 1.6 + innerK * 3, 0, 7); ctx.fill();
          ctx.restore();
        }
      }
    }

    function draw(dtMs) {
      var dt = dtMs / 1000;
      clock += dt;
      clear();
      for (var i = 0; i < dots.length; i++) step(dots[i], dt);
      drawFlash(dt);
      for (var j = 0; j < dots.length; j++) dot(dots[j]);
    }

    function frame(now) {
      if (!running) return;
      var dt = Math.min((now - last) / 1000, .05);
      last = now;
      draw(dt * 1000);
      rafId = requestAnimationFrame(frame);
    }

    function start() {
      if (running || reduce || !W || !H) return;
      running = true;
      last = performance.now();
      rafId = requestAnimationFrame(frame);
    }

    function stop() {
      running = false;
      if (rafId) cancelAnimationFrame(rafId);
      rafId = null;
    }

    document.addEventListener('visibilitychange', function () {
      if (document.hidden) stop(); else start();
    });

    resize();
    window.addEventListener('resize', resize);
  }

  for (var i = 0; i < canvases.length; i++) initInstance(canvases[i]);
})();
