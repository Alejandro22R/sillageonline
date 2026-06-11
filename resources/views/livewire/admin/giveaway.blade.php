<div> {{-- Envoltorio raíz único para Livewire --}}
    <div
        x-data="{
            countdown: null,
            countNum: 0,
            revealing: false,
            revealed: false,
            init() {
                $wire.on('winner-found', () => {
                    this.startReveal();
                });
            },
            startReveal() {
                this.countdown = true;
                this.revealed = false;
                this.countNum = 5;
                let tick = setInterval(() => {
                    this.countNum--;
                    if (this.countNum <= 0) {
                        clearInterval(tick);
                        this.countdown = false;
                        this.revealing = true;
                        setTimeout(() => {
                            this.revealing = false;
                            this.revealed = true;
                            this.launchConfetti();
                        }, 900);
                    }
                }, 800);
            },
            launchConfetti() {
                if (typeof confetti !== 'undefined') {
                    confetti({ particleCount: 120, spread: 80, origin: { y: 0.6 }, colors: ['#D4AF37','#fff','#FFD700','#B8960C'] });
                    setTimeout(() => confetti({ particleCount: 80, spread: 60, origin: { y: 0.5, x: 0.2 }, colors: ['#D4AF37','#fff'] }), 300);
                    setTimeout(() => confetti({ particleCount: 80, spread: 60, origin: { y: 0.5, x: 0.8 }, colors: ['#D4AF37','#fff'] }), 500);
                }
            }
        }"
        class="giveaway-root"
    >

        {{-- Fondo animado premium (Esferas y Estelas) --}}
        <canvas id="gold-canvas" aria-hidden="true"></canvas>

        {{-- Overlay de cuenta regresiva (Sin !important en CSS) --}}
        <div
            x-show="countdown"
            x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100"
            x-transition:leave="transition ease-in duration-200"
            x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0"
            class="countdown-overlay"
            style="display:none"
        >
            <div class="countdown-ring">
                <span x-text="countNum" class="countdown-number"></span>
            </div>
            <p class="countdown-label">Seleccionando ganador...</p>
        </div>

        {{-- Overlay de revelación (Sin !important en CSS) --}}
        <div
            x-show="revealing"
            x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0 scale-90"
            x-transition:enter-end="opacity-100 scale-100"
            x-transition:leave="transition ease-in duration-200"
            x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0"
            class="reveal-overlay"
            style="display:none"
        >
            <div class="reveal-burst">✦</div>
        </div>

        {{-- Contenido principal --}}
        <div class="main-card">

            {{-- Header --}}
            <div class="card-header">
                <img src="{{ asset('img/sillage.png') }}" alt="Sillage" class="logo">
                <h1 class="title">Sorteo Exclusivo</h1>
                <p class="subtitle">Selector de Ganadores · Instagram</p>
            </div>

            {{-- Error --}}
            @if($error)
                <div class="error-box">
                    <span>⚠</span> {{ $error }}
                </div>
            @endif

            {{-- Muestra el formulario SOLO si no hay ganador --}}
            @if(!$winner)
                <div class="form-section">
                    <label class="field-label">Enlace de la publicación (Reel o Post)</label>
                    <input
                        wire:model="mediaUrl"
                        type="text"
                        placeholder="https://www.instagram.com/p/XXXXXXX/"
                        class="field-input"
                    >
                    @error('mediaUrl')
                        <span class="field-error">{{ $message }}</span>
                    @enderror
                </div>

                <button
                    wire:click="pickWinner"
                    wire:loading.attr="disabled"
                    @click="if (!$wire.loading) { $el.classList.add('btn-pressed') }"
                    class="pick-btn"
                >
                    <span wire:loading.remove wire:target="pickWinner" class="btn-inner">
                        <span class="btn-icon">✦</span>
                        Elegir Ganador
                    </span>
                    <span wire:loading wire:target="pickWinner" class="btn-inner btn-loading">
                        <span class="btn-spinner"></span>
                        Analizando comentarios...
                    </span>
                </button>
            @endif

            {{-- Resultado del ganador --}}
            @if($winner)
                <div
                    x-show="revealed"
                    x-transition:enter="transition ease-out duration-700"
                    x-transition:enter-start="opacity-0 translate-y-8"
                    x-transition:enter-end="opacity-100 translate-y-0"
                    class="winner-section"
                    style="display:none"
                >
                    <div class="winner-divider">
                        <span class="divider-gem">◆</span>
                    </div>

                    <p class="participants-count">
                        {{ $totalValidParticipants }} participantes con 2+ menciones
                    </p>

                    <div class="winner-card">
                        <div class="winner-card-glow"></div>
                        <div class="winner-crown">👑</div>

                        {{-- Foto de perfil --}}
                        <div class="avatar-wrapper">
                            <div class="avatar-ring"></div>
                            <img
                                src="https://unavatar.io/instagram/{{ $winner['username'] }}"
                                alt="{{ $winner['username'] }}"
                                class="avatar-img"
                                onerror="this.src='https://ui-avatars.com/api/?name={{ urlencode($winner['username']) }}&background=D4AF37&color=000&size=96&bold=true'"
                            >
                        </div>

                        <p class="winner-label">El ganador es</p>
                        <a
                            href="https://instagram.com/{{ $winner['username'] }}"
                            target="_blank"
                            class="winner-username"
                        >
                            {{ '@'.$winner['username'] }}
                        </a>

                        <div class="winner-comment-box">
                            <p class="comment-label">Comentario ganador</p>
                            <p class="comment-text">"{{ $winner['text'] }}"</p>
                        </div>

                        <a
                            href="https://instagram.com/{{ $winner['username'] }}"
                            target="_blank"
                            class="profile-btn"
                        >
                            Ver perfil en Instagram →
                        </a>
                    </div>

                    <button
                        wire:click="pickWinner"
                        wire:loading.attr="disabled"
                        @click="revealed = false; countdown = null;"
                        class="reroll-btn"
                    >
                        ↺ Elegir otro ganador
                    </button>

                    <button
                        wire:click="$set('winner', null)"
                        @click="revealed = false; countdown = null;"
                        class="reroll-btn"
                        style="margin-top: 0.5rem; border-color: transparent; opacity: 0.6;"
                    >
                    </button>
                </div>
            @endif

        </div>
    </div>

    {{-- Canvas particles script --}}
    <script src="https://cdn.jsdelivr.net/npm/canvas-confetti@1.9.2/dist/confetti.browser.min.js"></script>

    <script>
    (function() {
        const canvas = document.getElementById('gold-canvas');
        if (!canvas) return;
        const ctx = canvas.getContext('2d');

        let W, H;
        let orbs = [];
        let streaks = [];

        function resize() {
            W = canvas.width  = window.innerWidth;
            H = canvas.height = window.innerHeight;
        }
        resize();
        window.addEventListener('resize', resize);

        function Orb() {
            this.x = Math.random() * W;
            this.y = Math.random() * H;
            this.r = Math.random() * 5 + 1.5; 
            this.vx = (Math.random() - 0.5) * 0.3; 
            this.vy = (Math.random() - 0.5) * 0.3 - 0.1; 
            this.alpha = Math.random() * 0.5 + 0.1;
            this.twinkle = Math.random() * Math.PI * 2;
            
            const colors = [
                {r: 255, g: 215, b: 0},   
                {r: 212, g: 175, b: 55},  
                {r: 255, g: 245, b: 210}, 
                {r: 184, g: 148, b: 12}   
            ];
            this.color = colors[Math.floor(Math.random() * colors.length)];
        }

        function Streak() {
            this.x = Math.random() * W - W/2; 
            this.y = Math.random() * H + H/2;
            this.length = Math.random() * 250 + 100;
            this.thickness = Math.random() * 2 + 0.5;
            this.speed = Math.random() * 4 + 2;
            this.alpha = Math.random() * 0.15 + 0.05; 
            this.angle = Math.PI / 4; 
        }

        for (let i = 0; i < 120; i++) orbs.push(new Orb());
        for (let i = 0; i < 8; i++) streaks.push(new Streak());

        function draw() {
            ctx.clearRect(0, 0, W, H);

            orbs.forEach(p => {
                p.twinkle += 0.015; 
                const currentAlpha = p.alpha * (0.6 + 0.4 * Math.sin(p.twinkle));

                let grad = ctx.createRadialGradient(p.x, p.y, 0, p.x, p.y, p.r * 2);
                grad.addColorStop(0, `rgba(255, 255, 255, ${currentAlpha})`); 
                grad.addColorStop(0.3, `rgba(${p.color.r}, ${p.color.g}, ${p.color.b}, ${currentAlpha * 0.8})`);
                grad.addColorStop(1, `rgba(${p.color.r}, ${p.color.g}, ${p.color.b}, 0)`); 

                ctx.beginPath();
                ctx.arc(p.x, p.y, p.r * 2, 0, Math.PI * 2);
                ctx.fillStyle = grad;
                ctx.fill();

                p.x += p.vx;
                p.y += p.vy;

                if (p.x < -20) p.x = W + 20;
                if (p.x > W + 20) p.x = -20;
                if (p.y < -20) p.y = H + 20;
                if (p.y > H + 20) p.y = -20;
            });

            ctx.globalCompositeOperation = "screen"; 
            streaks.forEach(s => {
                let endX = s.x + Math.cos(s.angle) * s.length;
                let endY = s.y - Math.sin(s.angle) * s.length;

                let grad = ctx.createLinearGradient(s.x, s.y, endX, endY);
                grad.addColorStop(0, `rgba(212, 175, 55, 0)`);
                grad.addColorStop(0.5, `rgba(255, 245, 210, ${s.alpha})`); 
                grad.addColorStop(1, `rgba(212, 175, 55, 0)`);

                ctx.beginPath();
                ctx.moveTo(s.x, s.y);
                ctx.lineTo(endX, endY);
                ctx.lineWidth = s.thickness;
                ctx.strokeStyle = grad;
                ctx.stroke();

                s.x += Math.cos(s.angle) * s.speed;
                s.y -= Math.sin(s.angle) * s.speed;

                if (s.x > W + 300 || s.y < -300) {
                    s.x = Math.random() * W - W; 
                    s.y = Math.random() * H + H; 
                    s.speed = Math.random() * 4 + 2; 
                }
            });
            ctx.globalCompositeOperation = "source-over"; 

            requestAnimationFrame(draw);
        }
        draw();
    })();
    </script>

    <style>
    /* ── Root & canvas ─────────────────────────────────────── */
    .giveaway-root {
        position: relative;
        min-height: 100vh;
        background: #050505;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 2rem 1rem;
        font-family: 'Inter', sans-serif;
        color: #fff;
        overflow: hidden;
    }
    #gold-canvas {
        position: fixed;
        inset: 0;
        pointer-events: none;
        z-index: 0;
    }

    /* ── Countdown overlay ─────────────────────────────────── */
    .countdown-overlay {
        position: fixed;
        inset: 0;
        z-index: 100;
        background: rgba(5,5,5,0.92);
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        gap: 1.5rem;
    }
    .countdown-ring {
        width: 160px;
        height: 160px;
        border-radius: 50%;
        border: 3px solid #D4AF37;
        box-shadow: 0 0 40px rgba(212,175,55,0.4), inset 0 0 40px rgba(212,175,55,0.05);
        display: flex;
        align-items: center;
        justify-content: center;
        animation: ring-pulse 0.8s ease-in-out infinite;
    }
    @keyframes ring-pulse {
        0%,100% { transform: scale(1);   box-shadow: 0 0 40px rgba(212,175,55,0.4); }
        50%      { transform: scale(1.08); box-shadow: 0 0 70px rgba(212,175,55,0.7); }
    }
    .countdown-number {
        font-size: 5rem;
        font-weight: 800;
        color: #D4AF37;
        line-height: 1;
        animation: num-pop 0.8s ease-in-out infinite;
    }
    @keyframes num-pop {
        0%   { transform: scale(0.7); opacity: 0.5; }
        30%  { transform: scale(1.15); opacity: 1; }
        100% { transform: scale(1);    opacity: 1; }
    }
    .countdown-label {
        color: rgba(255,255,255,0.6);
        font-size: 0.85rem;
        letter-spacing: 0.25em;
        text-transform: uppercase;
    }

    /* ── Reveal overlay ────────────────────────────────────── */
    .reveal-overlay {
        position: fixed;
        inset: 0;
        z-index: 100;
        display: flex;
        align-items: center;
        justify-content: center;
        background: rgba(5,5,5,0.5);
    }
    .reveal-burst {
        font-size: 8rem;
        color: #D4AF37;
        animation: burst-spin 0.9s ease-out forwards;
    }
    @keyframes burst-spin {
        0%   { transform: scale(0) rotate(-180deg); opacity: 0; }
        60%  { transform: scale(1.4) rotate(10deg); opacity: 1; }
        100% { transform: scale(1) rotate(0deg);    opacity: 0; }
    }

    /* ── Main card ─────────────────────────────────────────── */
    .main-card {
        position: relative;
        z-index: 10;
        width: 100%;
        max-width: 560px;
        background: rgba(10,10,10,0.95);
        border: 1px solid rgba(212,175,55,0.25);
        border-radius: 24px;
        padding: 2.5rem 2rem;
        box-shadow: 0 30px 80px rgba(0,0,0,0.8), 0 0 0 1px rgba(212,175,55,0.05);
    }

    /* ── Header ────────────────────────────────────────────── */
    .card-header { text-align: center; margin-bottom: 2rem; }
    .logo { height: 56px; margin: 0 auto 1rem; display: block; object-fit: contain; }
    .title {
        font-size: clamp(1.6rem, 4vw, 2.2rem);
        font-weight: 800;
        letter-spacing: 0.15em;
        text-transform: uppercase;
        background: linear-gradient(135deg, #fff 30%, #D4AF37 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
        margin: 0 0 0.4rem;
    }
    .subtitle {
        font-size: 0.65rem;
        letter-spacing: 0.35em;
        text-transform: uppercase;
        color: #D4AF37;
        font-weight: 600;
    }

    /* ── Error ─────────────────────────────────────────────── */
    .error-box {
        background: rgba(180,30,30,0.15);
        border: 1px solid rgba(220,60,60,0.4);
        color: #fca5a5;
        border-radius: 12px;
        padding: 0.75rem 1rem;
        font-size: 0.85rem;
        margin-bottom: 1.25rem;
        text-align: center;
    }

    /* ── Form ──────────────────────────────────────────────── */
    .form-section { margin-bottom: 1.25rem; }
    .field-label {
        display: block;
        font-size: 0.65rem;
        letter-spacing: 0.2em;
        text-transform: uppercase;
        color: rgba(255,255,255,0.4);
        font-weight: 600;
        margin-bottom: 0.5rem;
    }
    .field-input {
        width: 100%;
        background: rgba(255,255,255,0.04);
        border: 1px solid rgba(255,255,255,0.08);
        border-radius: 12px;
        padding: 0.85rem 1rem;
        color: #fff;
        font-size: 0.9rem;
        outline: none;
        transition: border-color 0.2s, box-shadow 0.2s;
        box-sizing: border-box;
    }
    .field-input:focus {
        border-color: rgba(212,175,55,0.6);
        box-shadow: 0 0 0 3px rgba(212,175,55,0.1);
    }
    .field-input::placeholder { color: rgba(255,255,255,0.2); }
    .field-error { color: #f87171; font-size: 0.75rem; margin-top: 0.3rem; display: block; }

    /* ── Pick button ───────────────────────────────────────── */
    .pick-btn {
        width: 100%;
        background: #D4AF37;
        border: none;
        border-radius: 14px;
        padding: 1.1rem;
        cursor: pointer;
        font-weight: 800;
        font-size: 0.9rem;
        letter-spacing: 0.2em;
        text-transform: uppercase;
        color: #000;
        transition: background 0.2s, transform 0.15s, box-shadow 0.2s;
        box-shadow: 0 0 24px rgba(212,175,55,0.3);
        position: relative;
        overflow: hidden;
    }
    .pick-btn:hover:not(:disabled) {
        background: #fff;
        box-shadow: 0 0 40px rgba(212,175,55,0.5);
        transform: translateY(-1px);
    }
    .pick-btn:active:not(:disabled) { transform: scale(0.98); }
    .pick-btn:disabled { opacity: 0.5; cursor: not-allowed; }
    .btn-inner { display: flex; align-items: center; justify-content: center; gap: 0.5rem; }
    .btn-icon { font-size: 1rem; }
    .btn-spinner {
        width: 16px; height: 16px;
        border: 2px solid rgba(0,0,0,0.3);
        border-top-color: #000;
        border-radius: 50%;
        animation: spin 0.7s linear infinite;
        display: inline-block;
    }
    @keyframes spin { to { transform: rotate(360deg); } }

    /* ── Winner section ────────────────────────────────────── */
    .winner-section { margin-top: 2rem; }
    .winner-divider {
        display: flex;
        align-items: center;
        gap: 1rem;
        margin-bottom: 1rem;
    }
    .winner-divider::before,
    .winner-divider::after {
        content: '';
        flex: 1;
        height: 1px;
        background: linear-gradient(90deg, transparent, rgba(212,175,55,0.4), transparent);
    }
    .divider-gem { color: #D4AF37; font-size: 0.7rem; }
    .participants-count {
        text-align: center;
        font-size: 0.7rem;
        letter-spacing: 0.15em;
        text-transform: uppercase;
        color: rgba(255,255,255,0.3);
        margin-bottom: 1.25rem;
    }

    /* ── Winner card ───────────────────────────────────────── */
    .winner-card {
        position: relative;
        background: rgba(15,15,15,0.9);
        border: 1px solid #D4AF37;
        border-radius: 20px;
        padding: 2rem 1.5rem 1.5rem;
        text-align: center;
        overflow: hidden;
    }
    .winner-card-glow {
        position: absolute;
        inset: 0;
        background: radial-gradient(ellipse at 50% 0%, rgba(212,175,55,0.12) 0%, transparent 70%);
        pointer-events: none;
    }
    .winner-card::before {
        content: '';
        position: absolute;
        top: 0; left: 0; right: 0;
        height: 2px;
        background: linear-gradient(90deg, transparent, #D4AF37, transparent);
    }
    .winner-crown {
        font-size: 2rem;
        margin-bottom: 0.75rem;
        animation: crown-float 2s ease-in-out infinite;
    }
    @keyframes crown-float {
        0%,100% { transform: translateY(0); }
        50%      { transform: translateY(-6px); }
    }

    /* ── Avatar ────────────────────────────────────────────── */
    .avatar-wrapper {
        position: relative;
        width: 96px;
        height: 96px;
        margin: 0 auto 1.25rem;
    }
    .avatar-ring {
        position: absolute;
        inset: -4px;
        border-radius: 50%;
        background: conic-gradient(#D4AF37, #FFD700, #B8960C, #D4AF37);
        animation: ring-rotate 3s linear infinite;
    }
    @keyframes ring-rotate { to { transform: rotate(360deg); } }
    .avatar-img {
        position: relative;
        z-index: 1;
        width: 96px;
        height: 96px;
        border-radius: 50%;
        object-fit: cover;
        border: 3px solid #050505;
    }
    .winner-label {
        font-size: 0.65rem;
        letter-spacing: 0.25em;
        text-transform: uppercase;
        color: rgba(255,255,255,0.4);
        margin: 0 0 0.4rem;
    }
    .winner-username {
        display: block;
        font-size: clamp(1.4rem, 4vw, 1.9rem);
        font-weight: 800;
        color: #fff;
        text-decoration: none;
        letter-spacing: 0.02em;
        margin-bottom: 1.25rem;
        transition: color 0.2s;
    }
    .winner-username:hover { color: #D4AF37; }
    .winner-comment-box {
        background: rgba(0,0,0,0.4);
        border: 1px solid rgba(255,255,255,0.06);
        border-radius: 12px;
        padding: 1rem;
        margin-bottom: 1.25rem;
        text-align: left;
    }
    .comment-label {
        font-size: 0.6rem;
        letter-spacing: 0.2em;
        text-transform: uppercase;
        color: #D4AF37;
        margin: 0 0 0.4rem;
    }
    .comment-text {
        font-size: 0.9rem;
        color: rgba(255,255,255,0.7);
        font-style: italic;
        line-height: 1.5;
        margin: 0;
        word-break: break-word;
    }
    .profile-btn {
        display: inline-block;
        background: rgba(212,175,55,0.1);
        border: 1px solid rgba(212,175,55,0.35);
        color: #D4AF37;
        border-radius: 10px;
        padding: 0.6rem 1.25rem;
        font-size: 0.8rem;
        font-weight: 600;
        text-decoration: none;
        transition: background 0.2s, border-color 0.2s;
    }
    .profile-btn:hover {
        background: rgba(212,175,55,0.2);
        border-color: #D4AF37;
    }

    /* ── Reroll button ─────────────────────────────────────── */
    .reroll-btn {
        display: block;
        width: 100%;
        margin-top: 1rem;
        background: transparent;
        border: 1px solid rgba(255,255,255,0.1);
        color: rgba(255,255,255,0.4);
        border-radius: 12px;
        padding: 0.7rem;
        font-size: 0.8rem;
        letter-spacing: 0.1em;
        cursor: pointer;
        transition: border-color 0.2s, color 0.2s;
    }
    .reroll-btn:hover:not(:disabled) {
        border-color: rgba(255,255,255,0.25);
        color: rgba(255,255,255,0.7);
    }
    </style>

</div>