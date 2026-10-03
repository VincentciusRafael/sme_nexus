<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'SME Nexus') }}</title>

    <script>document.documentElement.classList.add('js');</script>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Bricolage+Grotesque:opsz,wght@12..96,600;12..96,800&family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        :root {
            --ink: #171A44;
            --indigo: #4B4FE0;
            --indigo-2: #6A5CFF;
            --peri: #7C8CFF;
            --mint: #4FE3C1;
            --sun: #FFB36B;
            color-scheme: light;
            --bg: #EEF0FF;
            --surface: #FFFFFF;
            --surface-2: #F6F7FF;
            --text: #171A44;
            --muted: #666B92;
            --line: #DADDF4;
            --dot: rgba(23, 26, 68, .16);
            --nav-bg: rgba(238, 240, 255, .82);
            --shadow: 0 40px 80px -40px rgba(23, 26, 68, .45);
            --st-baru: #4B4FE0;   --st-baru-bg: rgba(75, 79, 224, .12);
            --st-proses: #8F5C00; --st-proses-bg: rgba(255, 179, 107, .28);
            --st-kirim: #0B7A62;  --st-kirim-bg: rgba(79, 227, 193, .24);
            --font-display: 'Bricolage Grotesque', 'Segoe UI', sans-serif;
            --font-body: 'Plus Jakarta Sans', 'Segoe UI', system-ui, sans-serif;
            --ease: cubic-bezier(.2, .8, .2, 1);
        }

        *, *::before, *::after { box-sizing: border-box; }
        html { scroll-behavior: smooth; scroll-padding-top: 84px; }
        body {
            margin: 0;
            font-family: var(--font-body);
            color: var(--text);
            background: radial-gradient(900px 500px at 10% 0%, #fff 0%, transparent 60%), var(--bg);
            line-height: 1.6;
            -webkit-font-smoothing: antialiased;
            overflow-x: hidden;
        }
        a { color: inherit; text-decoration: none; }
        h1, h2, h3, p, ul, ol { margin: 0; }
        ul, ol { padding: 0; list-style: none; }
        :focus-visible { outline: 3px solid var(--peri); outline-offset: 3px; border-radius: 8px; }

        .nx-wrap { width: min(1200px, 100% - 48px); margin-inline: auto; }

        .nx-btn {
            position: relative;
            display: inline-flex; align-items: center; justify-content: center;
            height: 54px; padding: 0 28px;
            border-radius: 14px;
            font: 600 1rem var(--font-body);
            border: 1.5px solid transparent;
            cursor: pointer;
            overflow: hidden;
            transition: transform .2s, box-shadow .3s, background-position .6s, border-color .2s, color .2s;
        }
        .nx-btn-primary {
            color: #fff;
            background: linear-gradient(120deg, var(--indigo), var(--indigo-2) 55%, var(--indigo));
            background-size: 200% 100%;
            box-shadow: 0 16px 30px -14px rgba(75, 79, 224, .85);
        }
        .nx-btn-primary::after {
            content: ""; position: absolute; top: 0; bottom: 0; left: -60%;
            width: 40%;
            background: linear-gradient(100deg, transparent, rgba(255, 255, 255, .35), transparent);
            transform: skewX(-20deg);
        }
        .nx-btn-primary:hover { background-position: 100% 0; transform: translateY(-2px); box-shadow: 0 22px 36px -14px rgba(75, 79, 224, .95); }
        .nx-btn-primary:hover::after { left: 130%; transition: left .8s ease; }
        .nx-btn-primary:active { transform: translateY(0) scale(.985); }
        .nx-btn-ghost { color: var(--text); background: transparent; border-color: var(--line); }
        .nx-btn-ghost:hover { border-color: var(--indigo); color: var(--indigo); }
        .nx-btn-sm { height: 42px; padding: 0 20px; border-radius: 12px; font-size: .92rem; }
        .nx-btn-white { background: #fff; color: var(--indigo); box-shadow: 0 18px 36px -16px rgba(0, 0, 0, .55); }
        .nx-btn-white:hover { transform: translateY(-2px); }
        .nx-btn-white::after {
            content: ""; position: absolute; top: 0; bottom: 0; left: -60%; width: 40%;
            background: linear-gradient(100deg, transparent, rgba(75, 79, 224, .18), transparent);
            transform: skewX(-20deg);
        }
        .nx-btn-white:hover::after { left: 130%; transition: left .8s ease; }

        .nx-nav {
            position: sticky; top: 0; z-index: 50;
            border-bottom: 1px solid transparent;
            transition: background .3s, border-color .3s, backdrop-filter .3s;
        }
        .nx-nav.is-stuck {
            background: var(--nav-bg);
            border-color: var(--line);
            -webkit-backdrop-filter: blur(14px);
            backdrop-filter: blur(14px);
        }
        .nx-nav-in { display: flex; align-items: center; justify-content: space-between; height: 68px; gap: 20px; }
        .nx-logo { display: flex; align-items: center; gap: 10px; font: 800 1.2rem var(--font-display); letter-spacing: -.01em; }
        .nx-logo-mark {
            width: 36px; height: 36px; border-radius: 11px;
            display: grid; place-items: center;
            color: #fff;
            background: linear-gradient(135deg, var(--indigo), var(--indigo-2));
            box-shadow: 0 10px 20px -8px rgba(75, 79, 224, .8);
            transition: transform .4s cubic-bezier(.3, 1.6, .5, 1);
        }
        .nx-logo:hover .nx-logo-mark { transform: rotate(-12deg) scale(1.08); }
        .nx-logo-mark svg { width: 19px; height: 19px; }
        .nx-links { display: flex; gap: 6px; }
        .nx-links a { padding: 8px 14px; border-radius: 10px; font-weight: 500; font-size: .94rem; color: var(--muted); transition: color .2s, background .2s; }
        .nx-links a:hover { color: var(--text); background: rgba(124, 140, 255, .12); }
        .nx-actions { display: flex; align-items: center; gap: 8px; }
        .nx-login { padding: 8px 16px; font-weight: 600; font-size: .94rem; color: var(--muted); border-radius: 10px; transition: color .2s; }
        .nx-login:hover { color: var(--text); }

        .nx-hero { position: relative; overflow: hidden; }
        .nx-hero::before {
            content: ""; position: absolute; inset: 0;
            background-image: radial-gradient(var(--dot) 1.2px, transparent 1.2px);
            background-size: 28px 28px;
            -webkit-mask-image: radial-gradient(70% 70% at 72% 30%, #000 0%, transparent 75%);
            mask-image: radial-gradient(70% 70% at 72% 30%, #000 0%, transparent 75%);
            pointer-events: none;
        }
        .nx-hero-grid {
            position: relative;
            display: grid; grid-template-columns: 1.02fr .98fr; gap: 56px; align-items: center;
            padding: 64px 0 120px;
        }

        .nx-chip-top {
            display: inline-flex; align-items: center; gap: 10px;
            padding: 8px 16px 8px 12px;
            border-radius: 99px;
            background: var(--surface);
            border: 1px solid var(--line);
            font-size: .85rem; font-weight: 600; color: var(--muted);
            margin-bottom: 28px;
        }
        .nx-live-dot { position: relative; width: 8px; height: 8px; border-radius: 50%; background: var(--mint); }
        .nx-live-dot::after { content: ""; position: absolute; inset: 0; border-radius: 50%; background: var(--mint); animation: nx-ping 1.8s ease-out infinite; }

        .nx-hero h1 {
            font-family: var(--font-display);
            font-weight: 800;
            font-size: clamp(2.7rem, 6vw, 4.7rem);
            line-height: 1.02;
            letter-spacing: -.035em;
            margin-bottom: 24px;
        }
        .nx-hero-lead { font-size: 1.14rem; color: var(--muted); max-width: 33rem; margin-bottom: 36px; }
        .nx-cta-row { display: flex; flex-wrap: wrap; gap: 14px; }

        .nx-w { display: inline-block; overflow: hidden; vertical-align: top; padding-bottom: .12em; margin-bottom: -.12em; }
        .nx-wi { display: inline-block; }
        .js .nx-split { visibility: hidden; }
        .js .nx-split.is-ready { visibility: visible; }
        .js .nx-wi { transform: translateY(112%); animation: nx-word .9s var(--ease) forwards; animation-delay: calc(var(--i) * 75ms + .15s); }

        .nx-rise { animation: nx-rise .8s var(--ease) both; animation-delay: var(--d, 0s); }

        .nx-stage { position: relative; animation: nx-enter 1.1s var(--ease) .45s both; }
        .nx-glow {
            position: absolute; inset: 8% 6% 6% 8%;
            background: radial-gradient(closest-side, rgba(106, 92, 255, .55), transparent);
            filter: blur(40px);
            animation: nx-morph 12s ease-in-out infinite alternate;
            pointer-events: none;
        }
        .nx-tilt {
            position: relative;
            transform: perspective(1400px) rotateX(var(--rx, 0deg)) rotateY(var(--ry, 0deg));
            transition: transform .3s ease-out;
        }
        .nx-dash { background: var(--surface); border: 1px solid var(--line); border-radius: 26px; box-shadow: var(--shadow); overflow: hidden; }
        .nx-dash-bar { display: flex; align-items: center; gap: 7px; padding: 14px 20px; border-bottom: 1px solid var(--line); }
        .nx-dash-bar > i { width: 10px; height: 10px; border-radius: 50%; }
        .nx-dash-bar > i:nth-child(1) { background: var(--peri); }
        .nx-dash-bar > i:nth-child(2) { background: var(--sun); }
        .nx-dash-bar > i:nth-child(3) { background: var(--mint); }
        .nx-dash-title { margin-left: 10px; font-size: .82rem; font-weight: 600; color: var(--muted); }
        .nx-live { margin-left: auto; display: inline-flex; align-items: center; gap: 8px; font-size: .76rem; font-weight: 700; color: var(--st-kirim); }
        .nx-dash-body { padding: 22px 22px 10px; }
        .nx-kpi { display: grid; grid-template-columns: 1.15fr 1fr; gap: 20px; align-items: end; }
        .nx-kpi small { font-size: .8rem; color: var(--muted); font-weight: 500; }
        .nx-kpi-num { margin: 4px 0 10px; font: 800 clamp(1.6rem, 3vw, 2.2rem)/1.1 var(--font-display); letter-spacing: -.02em; font-variant-numeric: tabular-nums; white-space: nowrap; }
        .nx-delta { display: inline-block; padding: 3px 10px; border-radius: 99px; background: var(--st-kirim-bg); color: var(--st-kirim); font-size: .74rem; font-weight: 700; }
        .nx-bars { display: flex; align-items: flex-end; gap: 7px; height: 92px; }
        .nx-bar {
            flex: 1; height: var(--h);
            border-radius: 7px 7px 4px 4px;
            background: var(--line);
            transform-origin: bottom;
            animation: nx-grow .8s var(--ease) both;
            animation-delay: calc(1s + var(--i) * 80ms);
        }
        .nx-bar.today { background: linear-gradient(180deg, var(--peri), var(--indigo)); transition: height .7s var(--ease); }
        .nx-orders-head { display: flex; justify-content: space-between; align-items: baseline; margin: 22px 0 4px; font-size: .84rem; font-weight: 700; }
        .nx-orders-head span { font-weight: 500; color: var(--muted); font-size: .78rem; }
        .nx-orders { height: 186px; overflow: hidden; }
        .nx-order { display: grid; grid-template-columns: 40px 1fr auto; gap: 12px; align-items: center; padding: 10px 0; border-top: 1px solid var(--line); max-height: 70px; }
        .nx-order.is-new { animation: nx-order-in .65s var(--ease); }
        .nx-ava { width: 40px; height: 40px; border-radius: 12px; display: grid; place-items: center; font-size: .78rem; font-weight: 700; color: #fff; background: var(--c, var(--indigo)); }
        .nx-order b { display: block; font-size: .88rem; }
        .nx-order small { display: block; font-size: .75rem; color: var(--muted); white-space: nowrap; overflow: hidden; text-overflow: ellipsis; max-width: 17ch; }
        .nx-order-r { text-align: right; }
        .nx-order-r b { font-variant-numeric: tabular-nums; }
        .nx-st { display: inline-block; margin-top: 3px; padding: 1px 9px; border-radius: 99px; font-size: .68rem; font-weight: 700; font-style: normal; }
        .st-baru { color: var(--st-baru); background: var(--st-baru-bg); }
        .st-proses { color: var(--st-proses); background: var(--st-proses-bg); }
        .st-kirim { color: var(--st-kirim); background: var(--st-kirim-bg); }

        .nx-toast {
            position: absolute; top: -20px; left: -28px; z-index: 3;
            display: flex; align-items: center; gap: 10px;
            padding: 10px 16px 10px 12px;
            border-radius: 14px;
            background: var(--surface);
            border: 1px solid var(--line);
            box-shadow: 0 20px 40px -20px rgba(23, 26, 68, .5);
            font-size: .8rem; font-weight: 600;
            animation: nx-pop .7s cubic-bezier(.3, 1.5, .5, 1) 2.4s both, nx-bob 5s ease-in-out 3.1s infinite;
        }
        .nx-toast i { width: 28px; height: 28px; border-radius: 9px; display: grid; place-items: center; background: var(--st-proses-bg); color: var(--st-proses); font-style: normal; font-weight: 800; }

        .nx-receipt-wrap { position: absolute; right: -26px; bottom: -64px; width: 184px; z-index: 3; transform: rotate(3.5deg); filter: drop-shadow(0 24px 24px rgba(18, 20, 58, .28)); }
        .nx-slot { position: relative; z-index: 2; height: 12px; margin: 0 -8px; border-radius: 99px; background: var(--ink); box-shadow: inset 0 -2px 0 rgba(255, 255, 255, .12); }
        .nx-receipt-clip { overflow: hidden; margin-top: -6px; padding-bottom: 12px; }
        .nx-receipt {
            --s: 12px;
            padding: 20px 14px 22px;
            background: #fff; color: #1B1D3F;
            font: 500 .7rem/1.55 ui-monospace, 'SFMono-Regular', Menlo, Consolas, monospace;
            -webkit-mask: conic-gradient(from -45deg at bottom, #0000, #000 1deg 89deg, #0000 90deg) 50% / var(--s) 100%;
            mask: conic-gradient(from -45deg at bottom, #0000, #000 1deg 89deg, #0000 90deg) 50% / var(--s) 100%;
            animation: nx-print 10s linear 1.6s infinite both;
        }
        .nx-receipt p { margin: 0; text-align: center; }
        .nx-r-head { font-weight: 700; font-size: .78rem; }
        .nx-r-dash { border: 0; border-top: 1.5px dashed #B8BCDD; margin: 9px 0; }
        .nx-r-line, .nx-r-total { display: flex; justify-content: space-between; gap: 8px; }
        .nx-r-total { font-weight: 700; font-size: .8rem; }
        .nx-r-foot { margin-top: 10px !important; color: #6E73A0; }

        .nx-use { padding: 8px 0 72px; }
        .nx-use-label { text-align: center; font-size: .92rem; color: var(--muted); margin-bottom: 20px; }
        .nx-marquee { overflow: hidden; -webkit-mask-image: linear-gradient(90deg, transparent, #000 12%, #000 88%, transparent); mask-image: linear-gradient(90deg, transparent, #000 12%, #000 88%, transparent); }
        .nx-track { display: flex; width: max-content; animation: nx-marquee 42s linear infinite; }
        .nx-marquee:hover .nx-track { animation-play-state: paused; }
        .nx-pill { display: inline-flex; align-items: center; gap: 10px; margin-right: 14px; padding: 12px 22px; border-radius: 99px; background: var(--surface); border: 1px solid var(--line); font-weight: 600; font-size: .95rem; white-space: nowrap; }
        .nx-pill i { width: 8px; height: 8px; border-radius: 50%; background: var(--c); }

        .nx-section { padding: 88px 0; }
        .nx-head { max-width: 40rem; margin-bottom: 48px; }
        .nx-head h2 { font: 800 clamp(2rem, 4.2vw, 3.1rem)/1.06 var(--font-display); letter-spacing: -.03em; margin-bottom: 14px; }
        .nx-head p { font-size: 1.08rem; color: var(--muted); }

        .nx-bento { display: grid; grid-template-columns: repeat(3, 1fr); gap: 20px; }
        .nx-card {
            position: relative; isolation: isolate;
            padding: 28px;
            background: var(--surface);
            border: 1px solid var(--line);
            border-radius: 24px;
            overflow: hidden;
            transition: border-color .3s;
        }
        .nx-card::before {
            content: ""; position: absolute; inset: 0; z-index: -1;
            background: radial-gradient(380px circle at var(--mx, 50%) var(--my, 0%), var(--acc-soft), transparent 65%);
            opacity: 0; transition: opacity .3s;
        }
        .nx-card:hover::before { opacity: 1; }
        .nx-card:hover { border-color: var(--acc); }
        .js .nx-card { opacity: 0; transition: opacity .7s ease var(--dl, 0s), border-color .3s; }
        .js .nx-card.in { opacity: 1; }
        .nx-span-2 { grid-column: span 2; }
        .nx-span-3 { grid-column: 1 / -1; }

        .nx-c-indigo { --acc: #4B4FE0; --acc-soft: rgba(75, 79, 224, .14); --acc-ink: #4B4FE0; }
        .nx-c-mint   { --acc: #4FE3C1; --acc-soft: rgba(79, 227, 193, .22); --acc-ink: #0E8F76; }
        .nx-c-sun    { --acc: #FFB36B; --acc-soft: rgba(255, 179, 107, .26); --acc-ink: #B1620F; }
        .nx-c-peri   { --acc: #7C8CFF; --acc-soft: rgba(124, 140, 255, .2); --acc-ink: #4B58D8; }

        .nx-ico { width: 46px; height: 46px; border-radius: 14px; display: grid; place-items: center; margin-bottom: 18px; color: var(--acc-ink, var(--acc)); background: var(--acc-soft); transition: transform .45s cubic-bezier(.3, 1.6, .5, 1); }
        .nx-card:hover .nx-ico { transform: rotate(-8deg) scale(1.1); }
        .nx-ico svg { width: 23px; height: 23px; }
        .nx-card h3 { font: 700 1.28rem/1.2 var(--font-display); letter-spacing: -.015em; margin-bottom: 8px; }
        .nx-card > p, .nx-card-txt p { color: var(--muted); font-size: .96rem; }
        .nx-viz { margin-top: 26px; }

        .nx-chart { position: relative; }
        .nx-chart svg { display: block; width: 100%; height: auto; overflow: visible; }
        .nx-chart .grid-l { stroke: var(--line); stroke-dasharray: 4 6; }
        .nx-draw { fill: none; stroke: var(--acc); stroke-width: 3.5; stroke-linecap: round; stroke-dasharray: 1; stroke-dashoffset: 0; transition: stroke-dashoffset 2s var(--ease) .3s; }
        .js .nx-card:not(.in) .nx-draw { stroke-dashoffset: 1; }
        .nx-area { transition: opacity 1.2s ease 1.2s; }
        .js .nx-card:not(.in) .nx-area { opacity: 0; }
        .nx-dot { fill: var(--acc); }
        .nx-dot-ring { fill: none; stroke: var(--acc); stroke-width: 2; transform-origin: 538px 24px; animation: nx-ring 2.2s ease-out infinite; }
        .nx-tip { position: absolute; top: -6px; right: 0; padding: 6px 12px; border-radius: 10px; background: var(--ink); color: #fff; font-size: .76rem; font-weight: 600; transition: opacity .5s ease 2s, transform .5s ease 2s; }
        .js .nx-card:not(.in) .nx-tip { opacity: 0; transform: translateY(6px); }

        .nx-stock { display: grid; gap: 16px; }
        .nx-stock-row { display: grid; grid-template-columns: 1fr auto; gap: 7px 12px; font-size: .84rem; font-weight: 600; }
        .nx-stock-row span:last-child { color: var(--muted); font-weight: 500; }
        .nx-bar-track { grid-column: 1 / -1; height: 8px; border-radius: 99px; background: var(--line); overflow: hidden; }
        .nx-fill { display: block; height: 100%; width: var(--w); border-radius: inherit; background: var(--acc); transition: width 1.3s var(--ease) var(--dl, 0s); }
        .js .nx-card:not(.in) .nx-fill { width: 0; }
        .nx-fill.low { background: var(--sun); animation: nx-blink 1.8s ease-in-out infinite; }
        .nx-low { display: inline-block; margin-left: 8px; padding: 1px 8px; border-radius: 99px; background: var(--st-proses-bg); color: var(--st-proses); font-size: .68rem; font-weight: 700; }

        .nx-steps { position: relative; display: flex; justify-content: space-between; }
        .nx-steps::before { content: ""; position: absolute; left: 32px; right: 32px; top: 14px; height: 3px; border-radius: 3px; background: var(--line); }
        .nx-steps-fill { position: absolute; left: 32px; top: 14px; height: 3px; border-radius: 3px; background: var(--acc); width: calc((100% - 64px) * var(--p, 0)); transition: width .9s var(--ease); }
        .nx-node { position: relative; z-index: 1; width: 64px; text-align: center; font-size: .72rem; font-weight: 600; color: var(--muted); transition: color .3s; }
        .nx-node span { display: grid; place-items: center; width: 30px; height: 30px; margin: 0 auto 8px; border-radius: 50%; background: var(--surface); border: 3px solid var(--line); transition: background .35s, border-color .35s, transform .45s cubic-bezier(.3, 1.8, .5, 1); }
        .nx-node svg { width: 13px; height: 13px; stroke: #fff; stroke-width: 3.2; fill: none; stroke-linecap: round; stroke-linejoin: round; opacity: 0; transition: opacity .2s; }
        .nx-node.on { color: var(--text); }
        .nx-node.on span { background: var(--acc); border-color: var(--acc); transform: scale(1.12); }
        .nx-node.on svg { opacity: 1; }

        .nx-av-stack { display: flex; align-items: center; }
        .nx-av { width: 46px; height: 46px; margin-left: -12px; border-radius: 50%; border: 3px solid var(--surface); display: grid; place-items: center; background: var(--c); color: #fff; font-size: .84rem; font-weight: 700; transition: margin .4s cubic-bezier(.3, 1.4, .5, 1), transform .55s cubic-bezier(.3, 1.6, .5, 1) calc(var(--i) * 90ms); }
        .nx-av:first-child { margin-left: 0; }
        .nx-card:hover .nx-av { margin-left: 2px; }
        .js .nx-card:not(.in) .nx-av { transform: scale(0); }
        .nx-av.more { background: var(--acc-soft); color: var(--acc-ink, var(--acc)); }
        .nx-skel { display: grid; gap: 8px; margin-top: 18px; }
        .nx-skel i { display: block; height: 8px; border-radius: 99px; background: var(--line); width: var(--w); }

        .nx-doc { position: relative; display: grid; gap: 10px; padding: 18px 16px 26px; border-radius: 14px; background: var(--surface-2); border: 1px solid var(--line); }
        .nx-doc i { display: block; height: 8px; width: var(--w); border-radius: 99px; background: var(--line); transform-origin: left; transition: transform .9s var(--ease) calc(var(--i) * 130ms + .3s); }
        .nx-doc i.t { height: 11px; background: var(--acc); opacity: .85; }
        .js .nx-card:not(.in) .nx-doc i { transform: scaleX(0); }
        .nx-badge { position: absolute; right: 12px; bottom: -14px; display: inline-flex; align-items: center; gap: 6px; padding: 6px 12px; border-radius: 99px; background: var(--acc); color: #fff; font-size: .72rem; font-weight: 700; box-shadow: 0 10px 20px -8px var(--acc); transition: transform .6s cubic-bezier(.3, 1.7, .5, 1) 1.5s, opacity .3s ease 1.5s; }
        .nx-badge svg { width: 12px; height: 12px; stroke: #fff; stroke-width: 3.2; fill: none; stroke-linecap: round; stroke-linejoin: round; }
        .js .nx-card:not(.in) .nx-badge { transform: scale(.3); opacity: 0; }

        .nx-card.nx-span-3 { display: flex; align-items: center; justify-content: space-between; gap: 36px; flex-wrap: wrap; }
        .nx-card-txt { max-width: 34rem; }
        .nx-secure { display: flex; align-items: center; gap: 28px; flex-wrap: wrap; }
        .nx-lock { position: relative; width: 84px; height: 84px; display: grid; place-items: center; border-radius: 50%; background: var(--acc-soft); color: var(--acc-ink, var(--acc)); flex: none; }
        .nx-lock svg { width: 34px; height: 34px; position: relative; z-index: 1; }
        .nx-lock .pulse { position: absolute; inset: 0; border-radius: 50%; border: 2px solid var(--acc); animation: nx-ring-lock 3.6s ease-out infinite; }
        .nx-lock .pulse:nth-child(2) { animation-delay: 1.2s; }
        .nx-lock .pulse:nth-child(3) { animation-delay: 2.4s; }
        .nx-secure-side { display: grid; gap: 14px; min-width: 240px; }
        .nx-chips { display: flex; gap: 10px; flex-wrap: wrap; }
        .nx-chip { display: inline-flex; align-items: center; gap: 8px; padding: 8px 14px; border-radius: 99px; background: var(--surface-2); border: 1px solid var(--line); font-size: .84rem; font-weight: 600; }
        .nx-chip svg { width: 14px; height: 14px; stroke: var(--acc-ink, var(--acc)); stroke-width: 3; fill: none; stroke-linecap: round; stroke-linejoin: round; }
        .nx-backup { height: 6px; border-radius: 99px; background: var(--line); overflow: hidden; }
        .nx-backup i { display: block; height: 100%; width: 100%; border-radius: inherit; background: linear-gradient(90deg, var(--acc), var(--mint)); transform-origin: left; animation: nx-backup 4.5s ease-in-out infinite; }

        .nx-how { display: grid; grid-template-columns: repeat(3, 1fr); gap: 32px; }
        .nx-how li { position: relative; }
        .nx-num { position: relative; z-index: 1; width: 44px; height: 44px; display: grid; place-items: center; border-radius: 50%; margin-bottom: 20px; font: 800 1.05rem var(--font-display); color: #fff; background: linear-gradient(135deg, var(--indigo), var(--indigo-2)); box-shadow: 0 12px 22px -10px rgba(75, 79, 224, .9); }
        .nx-how li:not(:last-child)::after { content: ""; position: absolute; top: 21px; left: 68px; right: -8px; height: 2px; background: var(--line); }
        .nx-how li:not(:last-child)::before { content: ""; position: absolute; top: 21px; left: 68px; right: -8px; height: 2px; z-index: 1; background: var(--indigo-2); transform-origin: left; transition: transform 1s var(--ease) calc(var(--i) * .5s + .4s); }
        .js .nx-how:not(.in) li::before { transform: scaleX(0); }
        .nx-how h3 { font: 700 1.2rem var(--font-display); margin-bottom: 6px; }
        .nx-how p { color: var(--muted); font-size: .96rem; max-width: 22rem; }

        .nx-cta { padding: 24px 0 96px; }
        .nx-cta-box { position: relative; isolation: isolate; overflow: hidden; padding: 84px 32px; text-align: center; color: #fff; border-radius: 32px; background: linear-gradient(160deg, #2A2EB5 0%, #1B1E63 55%, var(--ink) 100%); }
        .nx-orb { position: absolute; z-index: -1; filter: blur(42px); animation: nx-morph 13s ease-in-out infinite alternate, nx-drift 17s ease-in-out infinite alternate; }
        .nx-orb.a { width: 340px; height: 340px; top: -110px; right: -70px; background: var(--peri); opacity: .7; }
        .nx-orb.b { width: 300px; height: 300px; bottom: -120px; left: -60px; background: var(--mint); opacity: .5; animation-duration: 16s, 21s; animation-delay: -4s; }
        .nx-orb.c { width: 200px; height: 200px; top: 30%; left: 44%; background: var(--sun); opacity: .35; animation-duration: 11s, 14s; animation-delay: -7s; }
        .nx-cta-box h2 { font: 800 clamp(2rem, 4.6vw, 3.4rem)/1.05 var(--font-display); letter-spacing: -.03em; max-width: 18ch; margin: 0 auto 16px; }
        .nx-cta-box p { max-width: 34rem; margin: 0 auto 34px; color: rgba(255, 255, 255, .8); font-size: 1.06rem; }

        .nx-foot { border-top: 1px solid var(--line); padding: 36px 0 44px; }
        .nx-foot-in { display: flex; align-items: center; justify-content: space-between; gap: 20px; flex-wrap: wrap; color: var(--muted); font-size: .9rem; }
        .nx-foot nav { display: flex; gap: 22px; font-weight: 600; }
        .nx-foot nav a:hover { color: var(--indigo); }

        @keyframes nx-word { to { transform: translateY(0); } }
        @keyframes nx-rise { from { opacity: 0; transform: translateY(18px); } to { opacity: 1; transform: none; } }
        @keyframes nx-enter { from { opacity: 0; transform: translateX(56px) scale(.95); } to { opacity: 1; transform: none; } }
        @keyframes nx-grow { from { transform: scaleY(0); } to { transform: scaleY(1); } }
        @keyframes nx-ping { 0% { transform: scale(1); opacity: .7; } 100% { transform: scale(3.2); opacity: 0; } }
        @keyframes nx-pop { from { opacity: 0; transform: scale(.6) translateY(10px); } to { opacity: 1; transform: none; } }
        @keyframes nx-bob { 0%, 100% { translate: 0 0; } 50% { translate: 0 -8px; } }
        @keyframes nx-order-in { from { opacity: 0; transform: translateY(-14px); max-height: 0; padding-block: 0; } to { opacity: 1; transform: none; max-height: 70px; } }
        @keyframes nx-print {
            0%   { transform: translateY(-100%); animation-timing-function: steps(18, end); }
            26%  { transform: translateY(0); }
            90%  { transform: translateY(0); opacity: 1; }
            98%  { transform: translateY(0); opacity: 0; }
            100% { transform: translateY(-100%); opacity: 0; }
        }
        @keyframes nx-marquee { to { transform: translateX(-50%); } }
        @keyframes nx-morph {
            0%   { border-radius: 42% 58% 63% 37% / 45% 41% 59% 55%; }
            50%  { border-radius: 62% 38% 35% 65% / 58% 62% 38% 42%; }
            100% { border-radius: 38% 62% 55% 45% / 36% 55% 45% 64%; }
        }
        @keyframes nx-drift { from { transform: translate(0, 0) rotate(0) scale(1); } to { transform: translate(46px, -52px) rotate(50deg) scale(1.18); } }
        @keyframes nx-ring { 0% { transform: scale(1); opacity: .9; } 100% { transform: scale(3.4); opacity: 0; } }
        @keyframes nx-ring-lock { 0% { transform: scale(1); opacity: .7; } 100% { transform: scale(2.1); opacity: 0; } }
        @keyframes nx-blink { 0%, 100% { opacity: 1; } 50% { opacity: .55; } }
        @keyframes nx-backup { 0% { transform: scaleX(0); } 70%, 100% { transform: scaleX(1); } }

        @media (max-width: 980px) {
            .nx-links { display: none; }
            .nx-hero-grid { grid-template-columns: 1fr; gap: 64px; padding: 40px 0 112px; }
            .nx-stage { max-width: 560px; margin-inline: auto; width: 100%; }
            .nx-bento { grid-template-columns: 1fr 1fr; }
            .nx-span-2, .nx-span-3 { grid-column: 1 / -1; }
        }
        @media (max-width: 680px) {
            .nx-wrap { width: min(1200px, 100% - 32px); }
            .nx-section { padding: 64px 0; }
            .nx-bento { grid-template-columns: 1fr; }
            .nx-card { padding: 24px; }
            .nx-how { grid-template-columns: 1fr; gap: 28px; }
            .nx-how li:not(:last-child)::after, .nx-how li:not(:last-child)::before { display: none; }
            .nx-toast, .nx-receipt-wrap { display: none; }
            .nx-stage { margin-bottom: 0; }
            .nx-hero-grid { padding-bottom: 72px; }
            .nx-kpi { grid-template-columns: 1fr; gap: 14px; }
            .nx-login { display: none; }
            .nx-cta-box { padding: 64px 22px; border-radius: 26px; }
        }

        @media (prefers-reduced-motion: reduce) {
            html { scroll-behavior: auto; }
            *, *::before, *::after { animation-duration: .001ms !important; animation-iteration-count: 1 !important; animation-delay: 0s !important; transition-duration: .001ms !important; transition-delay: 0s !important; }
            .js .nx-wi { transform: none; }
            .nx-track { animation: none; }
            .nx-receipt { animation: none; }
        }
    </style>
</head>
<body>

    <header class="nx-nav" id="nav">
        <div class="nx-wrap nx-nav-in">
            <a href="/" class="nx-logo" aria-label="{{ config('app.name', 'SME Nexus') }}">
                <span class="nx-logo-mark">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                </span>
                SME Nexus
            </a>
            <nav class="nx-links" aria-label="Navigasi utama">
                <a href="#fitur">Fitur</a>
                <a href="#cara-kerja">Cara kerja</a>
            </nav>
            <div class="nx-actions">
                @auth
                    <a href="{{ route('dashboard') }}" class="nx-btn nx-btn-primary nx-btn-sm">Dashboard</a>
                @else
                    <a href="{{ route('login') }}" class="nx-login">Masuk</a>
                    <a href="{{ route('register') }}" class="nx-btn nx-btn-primary nx-btn-sm">Daftar</a>
                @endauth
            </div>
        </div>
    </header>

    <main>
        <section class="nx-hero" id="hero">
            <div class="nx-wrap nx-hero-grid">
                <div>
                    <div class="nx-chip-top nx-rise" style="--d:.05s">
                        <span class="nx-live-dot" aria-hidden="true"></span>
                        Platform Manajemen Bisnis Terintegrasi
                    </div>
                    <h1 class="nx-split">Kelola Bisnis Anda dengan Mudah &amp; Efisien</h1>
                    <p class="nx-hero-lead nx-rise" style="--d:.7s">
                        Platform terintegrasi untuk mengelola usaha kecil dan menengah. Pantau penjualan, kelola inventori, dan kembangkan bisnis Anda dengan tools yang powerful.
                    </p>
                    <div class="nx-cta-row nx-rise" style="--d:.85s">
                        @auth
                            <a href="{{ route('dashboard') }}" class="nx-btn nx-btn-primary">Buka Dashboard</a>
                        @else
                            <a href="{{ route('register') }}" class="nx-btn nx-btn-primary">Mulai Sekarang</a>
                            <a href="{{ route('login') }}" class="nx-btn nx-btn-ghost">Masuk</a>
                        @endauth
                    </div>
                </div>
                <div class="nx-stage" id="stage" role="img" aria-label="Contoh tampilan dashboard SME Nexus berisi penjualan hari ini dan pesanan terbaru">
                    <div class="nx-glow" aria-hidden="true"></div>
                    <div class="nx-tilt" id="tilt" aria-hidden="true">
                        <div class="nx-toast"><i>!</i> Stok gula pasir menipis</div>
                        <div class="nx-dash">
                            <div class="nx-dash-bar">
                                <i></i><i></i><i></i>
                                <span class="nx-dash-title">Ringkasan hari ini</span>
                                <span class="nx-live"><span class="nx-live-dot"></span>Live</span>
                            </div>
                            <div class="nx-dash-body">
                                <div class="nx-kpi">
                                    <div>
                                        <small>Penjualan hari ini</small>
                                        <div class="nx-kpi-num" id="revenue">Rp 4.850.000</div>
                                        <span class="nx-delta">+12,4% dari kemarin</span>
                                    </div>
                                    <div class="nx-bars" id="bars">
                                        <span class="nx-bar" style="--h:38%;--i:0"></span>
                                        <span class="nx-bar" style="--h:52%;--i:1"></span>
                                        <span class="nx-bar" style="--h:45%;--i:2"></span>
                                        <span class="nx-bar" style="--h:68%;--i:3"></span>
                                        <span class="nx-bar" style="--h:58%;--i:4"></span>
                                        <span class="nx-bar" style="--h:76%;--i:5"></span>
                                        <span class="nx-bar today" id="todayBar" style="--h:auto;height:78%;--i:6"></span>
                                    </div>
                                </div>
                                <div class="nx-orders-head">Pesanan terbaru <span id="orderCount">24 pesanan hari ini</span></div>
                                <ul class="nx-orders" id="orders">
                                    <li class="nx-order">
                                        <span class="nx-ava" style="--c:#4B4FE0">BS</span>
                                        <div><b>Bu Sari</b><small>Kopi susu 2, roti bakar</small></div>
                                        <div class="nx-order-r"><b>Rp 54.000</b><em class="nx-st st-proses">Diproses</em></div>
                                    </li>
                                    <li class="nx-order">
                                        <span class="nx-ava" style="--c:#6A5CFF">RP</span>
                                        <div><b>Rina Putri</b><small>Kopi arabika 1 kg</small></div>
                                        <div class="nx-order-r"><b>Rp 185.000</b><em class="nx-st st-kirim">Dikirim</em></div>
                                    </li>
                                    <li class="nx-order">
                                        <span class="nx-ava" style="--c:#171A44">BU</span>
                                        <div><b>Budi Santoso</b><small>Katering 20 kotak</small></div>
                                        <div class="nx-order-r"><b>Rp 640.000</b><em class="nx-st st-baru">Baru</em></div>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div class="nx-receipt-wrap">
                            <div class="nx-slot"></div>
                            <div class="nx-receipt-clip">
                                <div class="nx-receipt">
                                    <p class="nx-r-head">Kedai Maju Jaya</p>
                                    <p>Nota 1043</p>
                                    <hr class="nx-r-dash">
                                    <div class="nx-r-line"><span>Kopi susu x2</span><span>36.000</span></div>
                                    <div class="nx-r-line"><span>Roti bakar x1</span><span>18.000</span></div>
                                    <div class="nx-r-line"><span>Es teh x3</span><span>21.000</span></div>
                                    <hr class="nx-r-dash">
                                    <div class="nx-r-total"><span>Total</span><span>75.000</span></div>
                                    <p class="nx-r-foot">Terima kasih</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section class="nx-use" aria-label="Jenis usaha">
            <div class="nx-wrap">
                <p class="nx-use-label">Dirancang untuk usaha seperti</p>
            </div>
            <div class="nx-marquee" aria-hidden="true">
                <div class="nx-track">
                    @for ($i = 0; $i < 2; $i++)
                        <span class="nx-pill"><i style="--c:#4B4FE0"></i>Toko kelontong</span>
                        <span class="nx-pill"><i style="--c:#4FE3C1"></i>Kedai kopi</span>
                        <span class="nx-pill"><i style="--c:#FFB36B"></i>Kuliner rumahan</span>
                        <span class="nx-pill"><i style="--c:#7C8CFF"></i>Fashion dan butik</span>
                        <span class="nx-pill"><i style="--c:#6A5CFF"></i>Bengkel</span>
                        <span class="nx-pill"><i style="--c:#4FE3C1"></i>Salon dan barbershop</span>
                        <span class="nx-pill"><i style="--c:#FFB36B"></i>Toko online</span>
                        <span class="nx-pill"><i style="--c:#4B4FE0"></i>Katering</span>
                    @endfor
                </div>
            </div>
        </section>

        <section class="nx-section" id="fitur">
            <div class="nx-wrap">
                <div class="nx-head">
                    <h2>Fitur Unggulan</h2>
                    <p>Semua yang Anda butuhkan untuk mengelola bisnis dalam satu platform.</p>
                </div>
                <div class="nx-bento">
                    <article class="nx-card nx-c-indigo nx-span-2 nx-io" style="--dl:0s">
                        <div class="nx-ico"><svg fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/></svg></div>
                        <h3>Dashboard Analytics</h3>
                        <p>Pantau performa bisnis Anda dengan dashboard yang informatif dan real-time.</p>
                        <div class="nx-viz nx-chart" aria-hidden="true">
                            <span class="nx-tip">Hari ini Rp 4,85 jt</span>
                            <svg viewBox="0 0 560 180" preserveAspectRatio="none">
                                <defs>
                                    <linearGradient id="nxArea" x1="0" y1="0" x2="0" y2="1">
                                        <stop offset="0" style="stop-color:var(--acc);stop-opacity:.28"/>
                                        <stop offset="1" style="stop-color:var(--acc);stop-opacity:0"/>
                                    </linearGradient>
                                </defs>
                                <line class="grid-l" x1="0" x2="560" y1="45" y2="45"/>
                                <line class="grid-l" x1="0" x2="560" y1="95" y2="95"/>
                                <line class="grid-l" x1="0" x2="560" y1="145" y2="145"/>
                                <path class="nx-area" fill="url(#nxArea)" d="M0 142 C60 132 90 100 140 108 S220 150 280 112 S380 62 430 80 S500 30 538 24 L538 180 L0 180 Z"/>
                                <path class="nx-draw" pathLength="1" d="M0 142 C60 132 90 100 140 108 S220 150 280 112 S380 62 430 80 S500 30 538 24"/>
                                <circle class="nx-dot-ring" cx="538" cy="24" r="6"/>
                                <circle class="nx-dot" cx="538" cy="24" r="6"/>
                            </svg>
                        </div>
                    </article>
                    <article class="nx-card nx-c-mint nx-io" style="--dl:.12s">
                        <div class="nx-ico"><svg fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg></div>
                        <h3>Manajemen Produk</h3>
                        <p>Kelola inventori produk Anda dengan mudah dan efisien.</p>
                        <div class="nx-viz nx-stock" aria-hidden="true">
                            <div class="nx-stock-row"><span>Kopi arabika 1 kg</span><span>82 sisa</span><span class="nx-bar-track"><span class="nx-fill" style="--w:82%;--dl:.4s"></span></span></div>
                            <div class="nx-stock-row"><span>Susu UHT 1 l</span><span>46 sisa</span><span class="nx-bar-track"><span class="nx-fill" style="--w:46%;--dl:.55s"></span></span></div>
                            <div class="nx-stock-row"><span>Gula pasir<span class="nx-low">Menipis</span></span><span>6 sisa</span><span class="nx-bar-track"><span class="nx-fill low" style="--w:12%;--dl:.7s"></span></span></div>
                        </div>
                    </article>
                    <article class="nx-card nx-c-sun nx-io" style="--dl:.05s">
                        <div class="nx-ico"><svg fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/></svg></div>
                        <h3>Tracking Pesanan</h3>
                        <p>Lacak status pesanan dari awal hingga selesai dengan mudah.</p>
                        <div class="nx-viz nx-steps" id="steps" aria-hidden="true">
                            <span class="nx-steps-fill" id="stepsFill"></span>
                            <div class="nx-node"><span><svg viewBox="0 0 12 12"><path d="M2.2 6.4l2.6 2.6 5-5.2"/></svg></span>Diterima</div>
                            <div class="nx-node"><span><svg viewBox="0 0 12 12"><path d="M2.2 6.4l2.6 2.6 5-5.2"/></svg></span>Diproses</div>
                            <div class="nx-node"><span><svg viewBox="0 0 12 12"><path d="M2.2 6.4l2.6 2.6 5-5.2"/></svg></span>Dikirim</div>
                            <div class="nx-node"><span><svg viewBox="0 0 12 12"><path d="M2.2 6.4l2.6 2.6 5-5.2"/></svg></span>Selesai</div>
                        </div>
                    </article>
                    <article class="nx-card nx-c-peri nx-io" style="--dl:.17s">
                        <div class="nx-ico"><svg fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/></svg></div>
                        <h3>Manajemen Pelanggan</h3>
                        <p>Kelola data pelanggan dan bangun hubungan yang lebih baik.</p>
                        <div class="nx-viz" aria-hidden="true">
                            <div class="nx-av-stack">
                                <span class="nx-av" style="--c:#4B4FE0;--i:0">BS</span>
                                <span class="nx-av" style="--c:#6A5CFF;--i:1">RP</span>
                                <span class="nx-av" style="--c:#171A44;--i:2">DA</span>
                                <span class="nx-av" style="--c:#7C8CFF;--i:3">YN</span>
                                <span class="nx-av more" style="--i:4">+</span>
                            </div>
                            <div class="nx-skel"><i style="--w:78%"></i><i style="--w:54%"></i></div>
                        </div>
                    </article>
                    <article class="nx-card nx-c-indigo nx-io" style="--dl:.29s">
                        <div class="nx-ico"><svg fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg></div>
                        <h3>Laporan Otomatis</h3>
                        <p>Dapatkan laporan penjualan dan keuangan secara otomatis.</p>
                        <div class="nx-viz nx-doc" aria-hidden="true">
                            <i class="t" style="--w:46%;--i:0"></i>
                            <i style="--w:100%;--i:1"></i>
                            <i style="--w:88%;--i:2"></i>
                            <i style="--w:94%;--i:3"></i>
                            <i style="--w:62%;--i:4"></i>
                            <span class="nx-badge"><svg viewBox="0 0 12 12"><path d="M2.2 6.4l2.6 2.6 5-5.2"/></svg>Laporan siap</span>
                        </div>
                    </article>
                    <article class="nx-card nx-c-indigo nx-span-3 nx-io" style="--dl:.1s">
                        <div class="nx-card-txt">
                            <div class="nx-ico"><svg fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg></div>
                            <h3>Keamanan Tinggi</h3>
                            <p>Data Anda aman dengan enkripsi dan backup otomatis.</p>
                        </div>
                        <div class="nx-secure" aria-hidden="true">
                            <div class="nx-lock">
                                <span class="pulse"></span><span class="pulse"></span><span class="pulse"></span>
                                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
                            </div>
                            <div class="nx-secure-side">
                                <div class="nx-chips">
                                    <span class="nx-chip"><svg viewBox="0 0 12 12"><path d="M2.2 6.4l2.6 2.6 5-5.2"/></svg>Enkripsi</span>
                                    <span class="nx-chip"><svg viewBox="0 0 12 12"><path d="M2.2 6.4l2.6 2.6 5-5.2"/></svg>Backup otomatis</span>
                                </div>
                                <div class="nx-backup"><i></i></div>
                            </div>
                        </div>
                    </article>
                </div>
            </div>
        </section>

        <section class="nx-section" id="cara-kerja" style="padding-top:24px">
            <div class="nx-wrap">
                <div class="nx-head">
                    <h2>Mulai dalam tiga langkah</h2>
                    <p>Dari akun baru sampai laporan pertama, tanpa proses yang rumit.</p>
                </div>
                <ol class="nx-how nx-io">
                    <li style="--i:0">
                        <div class="nx-num">1</div>
                        <h3>Buat akun</h3>
                        <p>Daftar dengan email Anda dan langsung masuk ke dashboard.</p>
                    </li>
                    <li style="--i:1">
                        <div class="nx-num">2</div>
                        <h3>Isi data usaha</h3>
                        <p>Tambahkan produk, stok, dan pelanggan Anda.</p>
                    </li>
                    <li style="--i:2">
                        <div class="nx-num">3</div>
                        <h3>Pantau dan kembangkan</h3>
                        <p>Lihat penjualan dan laporan kapan saja dari satu tempat.</p>
                    </li>
                </ol>
            </div>
        </section>

        <section class="nx-cta">
            <div class="nx-wrap">
                <div class="nx-cta-box">
                    <span class="nx-orb a" aria-hidden="true"></span>
                    <span class="nx-orb b" aria-hidden="true"></span>
                    <span class="nx-orb c" aria-hidden="true"></span>
                    <h2>Siap Memulai Perjalanan Bisnis Anda?</h2>
                    <p>Bergabung dengan ribuan pelaku usaha yang telah mempercayakan pengelolaan bisnis mereka kepada SME Nexus.</p>
                    @auth
                        <a href="{{ route('dashboard') }}" class="nx-btn nx-btn-white">Buka Dashboard</a>
                    @else
                        <a href="{{ route('register') }}" class="nx-btn nx-btn-white">Daftar Sekarang</a>
                    @endauth
                </div>
            </div>
        </section>
    </main>

    <footer class="nx-foot">
        <div class="nx-wrap nx-foot-in">
            <a href="/" class="nx-logo" aria-label="SME Nexus">
                <span class="nx-logo-mark" style="width:32px;height:32px;border-radius:10px">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                </span>
                SME Nexus
            </a>
            <p>&copy; {{ date('Y') }} SME Nexus. All rights reserved.</p>
            <nav aria-label="Tautan footer">
                @auth
                    <a href="{{ route('dashboard') }}">Dashboard</a>
                @else
                    <a href="{{ route('login') }}">Masuk</a>
                    <a href="{{ route('register') }}">Daftar</a>
                @endauth
            </nav>
        </div>
    </footer>

<script>
(function () {
    var reduce = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
    function $(s, c) { return (c || document).querySelector(s); }
    function $$(s, c) { return Array.prototype.slice.call((c || document).querySelectorAll(s)); }

    var nav = $('#nav');
    function onScroll() { nav.classList.toggle('is-stuck', window.scrollY > 8); }
    window.addEventListener('scroll', onScroll, { passive: true });
    onScroll();

    $$('.nx-split').forEach(function (h) {
        var text = h.textContent.trim().replace(/\s+/g, ' ');
        h.textContent = '';
        h.setAttribute('aria-label', text);
        var words = text.split(' ');
        words.forEach(function (word, i) {
            var w = document.createElement('span');
            w.className = 'nx-w';
            w.setAttribute('aria-hidden', 'true');
            var inner = document.createElement('span');
            inner.className = 'nx-wi';
            inner.style.setProperty('--i', i);
            inner.textContent = word;
            w.appendChild(inner);
            h.appendChild(w);
            if (i < words.length - 1) h.appendChild(document.createTextNode(' '));
        });
        h.classList.add('is-ready');
    });

    var inView = ('IntersectionObserver' in window) && !reduce
        ? new IntersectionObserver(function (entries) {
            entries.forEach(function (e) {
                if (e.isIntersecting) { e.target.classList.add('in'); inView.unobserve(e.target); }
            });
        }, { threshold: .2 })
        : null;
    $$('.nx-io').forEach(function (el) { inView ? inView.observe(el) : el.classList.add('in'); });

    function whenVisible(el, onShow, onHide) {
        if (!('IntersectionObserver' in window)) { onShow(); return; }
        new IntersectionObserver(function (entries) {
            entries.forEach(function (e) { e.isIntersecting ? onShow() : onHide(); });
        }, { threshold: .2 }).observe(el);
    }

    $$('.nx-card').forEach(function (card) {
        card.addEventListener('pointermove', function (e) {
            var r = card.getBoundingClientRect();
            card.style.setProperty('--mx', (e.clientX - r.left) + 'px');
            card.style.setProperty('--my', (e.clientY - r.top) + 'px');
        });
    });

    var hero = $('#hero'), tilt = $('#tilt');
    if (!reduce && window.matchMedia('(hover: hover) and (min-width: 981px)').matches) {
        hero.addEventListener('pointermove', function (e) {
            var r = tilt.getBoundingClientRect();
            var dx = (e.clientX - (r.left + r.width / 2)) / window.innerWidth;
            var dy = (e.clientY - (r.top + r.height / 2)) / window.innerHeight;
            tilt.style.setProperty('--ry', (dx * 9).toFixed(2) + 'deg');
            tilt.style.setProperty('--rx', (-dy * 7).toFixed(2) + 'deg');
        });
        hero.addEventListener('pointerleave', function () {
            tilt.style.setProperty('--ry', '0deg');
            tilt.style.setProperty('--rx', '0deg');
        });
    }

    var fmt = function (n) { return 'Rp ' + new Intl.NumberFormat('id-ID').format(Math.round(n)); };
    var revenueEl = $('#revenue'), todayBar = $('#todayBar'), ordersEl = $('#orders'), countEl = $('#orderCount');
    var revenue = 4850000, shown = 4850000, orderCount = 24, tweenId = 0, timer = null, introDone = false;
    var BAR_MAX = 6400000;

    function paint(v) {
        revenueEl.textContent = fmt(v);
        todayBar.style.height = Math.min(100, 8 + (v / BAR_MAX) * 92) + '%';
    }
    function tween(to, dur) {
        if (reduce) { shown = to; paint(to); return; }
        var id = ++tweenId, from = shown, t0 = performance.now();
        (function step(t) {
            if (id !== tweenId) return;
            var p = Math.min(1, (t - t0) / dur), e = 1 - Math.pow(1 - p, 3);
            shown = from + (to - from) * e;
            paint(shown);
            if (p < 1) requestAnimationFrame(step);
        })(t0);
    }

    var pool = [
        { n: 'Dewi Anggraini', i: 'Kue lapis 2 loyang', a: 120000, c: '#6A5CFF', s: 'baru' },
        { n: 'Pak Hendra', i: 'Servis motor', a: 175000, c: '#171A44', s: 'proses' },
        { n: 'Yuni Nur', i: 'Gamis 1, hijab 2', a: 389000, c: '#7C8CFF', s: 'baru' },
        { n: 'Toko Berkah', i: 'Beras 25 kg', a: 340000, c: '#4B4FE0', s: 'kirim' },
        { n: 'Agus Salim', i: 'Kopi susu 3', a: 54000, c: '#4B4FE0', s: 'baru' },
        { n: 'Maya Lestari', i: 'Potong rambut, creambath', a: 135000, c: '#7C8CFF', s: 'proses' },
        { n: 'Kantin Sehat', i: 'Telur 10 kg', a: 290000, c: '#4B4FE0', s: 'kirim' }
    ];
    var statusText = { baru: 'Baru', proses: 'Diproses', kirim: 'Dikirim' };
    var poolIdx = 0;

    function initials(name) {
        return name.split(' ').slice(0, 2).map(function (p) { return p.charAt(0); }).join('').toUpperCase();
    }
    function addOrder() {
        if (document.hidden) return;
        var o = pool[poolIdx++ % pool.length];
        var li = document.createElement('li');
        li.className = 'nx-order is-new';
        li.innerHTML =
            '<span class="nx-ava" style="--c:' + o.c + '">' + initials(o.n) + '</span>' +
            '<div><b>' + o.n + '</b><small>' + o.i + '</small></div>' +
            '<div class="nx-order-r"><b>' + fmt(o.a) + '</b><em class="nx-st st-' + o.s + '">' + statusText[o.s] + '</em></div>';
        ordersEl.insertBefore(li, ordersEl.firstChild);
        while (ordersEl.children.length > 4) ordersEl.removeChild(ordersEl.lastChild);

        revenue += o.a;
        orderCount++;
        if (revenue > 6200000) { revenue = 3900000; orderCount = 19; }
        countEl.textContent = orderCount + ' pesanan hari ini';
        tween(revenue, 900);
    }

    if (reduce) {
        paint(revenue);
    } else {
        paint(0);
        whenVisible($('#stage'), function () {
            if (!introDone) {
                introDone = true;
                setTimeout(function () { tween(revenue, 2200); }, 900);
            }
            if (!timer) timer = setInterval(addOrder, 3600);
        }, function () {
            clearInterval(timer);
            timer = null;
        });
    }

    var steps = $('#steps'), nodes = $$('.nx-node', steps), fill = $('#stepsFill'), stepNow = 0, stepTimer = null;
    function setStep(n) {
        nodes.forEach(function (node, i) { node.classList.toggle('on', i <= n); });
        steps.style.setProperty('--p', n / (nodes.length - 1));
    }
    if (reduce) {
        setStep(nodes.length - 1);
    } else {
        setStep(0);
        whenVisible(steps, function () {
            if (stepTimer) return;
            stepTimer = setInterval(function () {
                stepNow = (stepNow + 1) % (nodes.length + 2);
                setStep(Math.min(stepNow, nodes.length - 1));
                if (stepNow >= nodes.length + 1) stepNow = -1;
            }, 1500);
        }, function () {
            clearInterval(stepTimer);
            stepTimer = null;
        });
    }
})();
</script>
</body>
</html>
