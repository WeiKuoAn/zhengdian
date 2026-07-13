<!DOCTYPE html>
<html lang="zh-Hant">
<head>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
@php
    $pageSetting = fn (string $key, string $default = '') => (string) ($settings[$key] ?? $default);
@endphp
<title>{{ $pageSetting('meta_title') }}</title>
<meta name="description" content="{{ $pageSetting('meta_description') }}">
<meta name="keywords" content="政府補助顧問,AI 數位轉型,SBIR,SIIR,智慧減碳,企業升級,錚典科技,Zhengdian">
<meta property="og:title" content="{{ $pageSetting('meta_title') }}">
<meta property="og:description" content="{{ $pageSetting('meta_description') }}">
<meta property="og:type" content="website">

<style>
:root {
--brand-900: #0F172A;
--brand-700: #1E3A8A;
--brand-500: #2563EB;
--brand-100: #DBEAFE;
--brand-50: #EFF6FF;
--green-600: #16A34A;
--green-100: #BBF7D0;
--amber-500: #F59E0B;
--amber-50: #FEF3C7;
--gray-50: #F8FAFC;
--gray-100: #F1F5F9;
--gray-200: #E2E8F0;
--gray-500: #64748B;
--gray-700: #334155;
--gray-900: #0F172A;
--text: #1F2937;
--text-secondary: #475569;
--container: 1200px;
--section-py: 80px;
--hero-height: 520px;
--font-zh: "PingFang TC", "Microsoft JhengHei", "Noto Sans TC", sans-serif;
--font-en: "Inter", "Calibri", "Helvetica Neue", Arial, sans-serif;
}

* { margin: 0; padding: 0; box-sizing: border-box; }
html { scroll-behavior: smooth; }
body { font-family: var(--font-zh); color: var(--text); line-height: 1.7; background: #fff; -webkit-font-smoothing: antialiased; font-size: 16px; }
a { color: inherit; text-decoration: none; transition: color .2s; }
ul { list-style: none; }

.container { max-width: var(--container); margin: 0 auto; padding: 0 24px; }
section { padding: var(--section-py) 0; }

.btn { display: inline-flex; align-items: center; justify-content: center; gap: 8px; padding: 14px 28px; border-radius: 10px; font-weight: 600; font-size: 15px; cursor: pointer; transition: all .25s; border: 2px solid transparent; white-space: nowrap; font-family: inherit; }
.btn-primary { background: var(--brand-700); color: #fff; }
.btn-primary:hover { background: var(--brand-500); transform: translateY(-2px); box-shadow: 0 8px 24px rgba(30,58,138,.25); color: #fff; }
.btn-on-dark { background: #fff; color: var(--brand-700); }
.btn-on-dark:hover { background: var(--brand-100); transform: translateY(-2px); }
.btn-on-dark-outline { background: transparent; color: #fff; border-color: rgba(255,255,255,.5); }
.btn-on-dark-outline:hover { background: rgba(255,255,255,.1); border-color: #fff; color: #fff; }
.btn-line { background: #06C755; color: #fff; }
.btn-line:hover { background: #059142; transform: translateY(-2px); color: #fff; }

.eyebrow { display: inline-block; font-size: 13px; font-weight: 600; letter-spacing: 2px; color: var(--brand-500); text-transform: uppercase; margin-bottom: 12px; }
.section-title { font-size: clamp(26px, 3.5vw, 36px); font-weight: 700; color: var(--brand-900); line-height: 1.3; margin-bottom: 16px; letter-spacing: -0.02em; }
.section-subtitle { font-size: clamp(15px, 1.4vw, 16px); color: var(--text-secondary); max-width: 820px; margin-bottom: 56px; line-height: 1.85; }

.site-header { position: fixed; top: 0; left: 0; right: 0; z-index: 100; background: #fff; border-bottom: 1px solid var(--gray-200); height: 72px; }
.nav { display: flex; justify-content: space-between; align-items: center; height: 100%; }
.logo { display: flex; align-items: center; }
.logo-img { height: 48px; width: auto; display: block; }
.nav-links { display: flex; gap: 26px; align-items: center; }
.nav-links a { font-size: 14.5px; font-weight: 500; color: var(--gray-700); }
.nav-links a:hover { color: var(--brand-700); }
.nav-cta { padding: 10px 18px; font-size: 14px; }
.menu-toggle { display: none; background: none; border: none; cursor: pointer; padding: 8px; flex-direction: column; gap: 5px; }
.menu-toggle span { width: 24px; height: 2px; background: var(--brand-900); border-radius: 2px; transition: .3s; }

.hero { margin-top: 72px; min-height: var(--hero-height); background: linear-gradient(135deg, #0F172A 0%, #1E3A8A 50%, #2563EB 100%); color: #fff; display: flex; align-items: center; position: relative; overflow: hidden; padding: 80px 0; }
.hero::before { content: ""; position: absolute; top: -100px; right: -80px; width: 400px; height: 400px; background: radial-gradient(circle, rgba(37,99,235,.35), transparent 70%); border-radius: 50%; pointer-events: none; }
.hero::after { content: ""; position: absolute; bottom: -120px; left: -100px; width: 360px; height: 360px; background: radial-gradient(circle, rgba(22,163,74,.18), transparent 70%); border-radius: 50%; pointer-events: none; }
.hero-inner { position: relative; z-index: 2; max-width: 920px; }
.hero-eyebrow { display: inline-block; padding: 6px 16px; background: rgba(255,255,255,.12); border: 1px solid rgba(255,255,255,.25); border-radius: 999px; font-size: 13px; letter-spacing: 1px; margin-bottom: 22px; font-weight: 500; }
.hero h1 { font-size: clamp(30px, 4.2vw, 46px); font-weight: 700; line-height: 1.3; margin-bottom: 20px; letter-spacing: -0.02em; }
.hero .tagline { font-size: clamp(18px, 2vw, 22px); color: #BBF7D0; margin-bottom: 18px; font-weight: 500; letter-spacing: 1px; }
.hero p.lead { font-size: clamp(15px, 1.4vw, 17px); color: rgba(255,255,255,.85); margin-bottom: 32px; line-height: 1.85; max-width: 780px; }
.hero-actions { display: flex; gap: 14px; flex-wrap: wrap; }

.stats { background: var(--gray-50); padding: 64px 0; }
.stats-grid { display: grid; grid-template-columns: repeat(4, 1fr); gap: 20px; }
.stat-card { background: #fff; padding: 32px 20px; border-radius: 16px; border: 1px solid var(--gray-200); text-align: center; transition: all .3s; }
.stat-card:hover { transform: translateY(-3px); box-shadow: 0 8px 24px rgba(15,23,42,.08); border-color: var(--brand-500); }
.stat-value { font-family: var(--font-en); font-size: 42px; font-weight: 800; color: var(--brand-700); line-height: 1; margin-bottom: 10px; letter-spacing: -0.03em; }
.stat-value .unit { font-size: 22px; }
.stat-label { font-size: 14px; font-weight: 700; color: var(--brand-900); margin-bottom: 6px; }
.stat-desc { font-size: 12.5px; color: var(--text-secondary); line-height: 1.6; }

.services-grid { display: grid; grid-template-columns: repeat(2, 1fr); gap: 24px; }
.service-card { background: #fff; border: 1px solid var(--gray-200); border-radius: 16px; padding: 32px 28px; transition: all .3s; display: flex; flex-direction: column; }
.service-card:hover { box-shadow: 0 12px 32px rgba(15,23,42,.1); border-color: var(--brand-500); transform: translateY(-4px); }
.service-head { display: flex; align-items: center; gap: 16px; margin-bottom: 20px; }
.service-icon { width: 56px; height: 56px; border-radius: 14px; background: linear-gradient(135deg, var(--brand-700), var(--brand-500)); display: flex; align-items: center; justify-content: center; color: #fff; font-weight: 700; font-size: 18px; font-family: var(--font-en); flex-shrink: 0; }
.service-head h3 { font-size: 20px; font-weight: 700; color: var(--brand-900); line-height: 1.3; }
.service-head .en { font-size: 12px; color: var(--gray-500); font-style: italic; }
.service-list { list-style: none; padding: 0; }
.service-list li { font-size: 14px; color: var(--text-secondary); padding: 7px 0 7px 22px; position: relative; line-height: 1.6; }
.service-list li::before { content: "▸"; position: absolute; left: 0; color: var(--brand-500); font-weight: 700; }

.process-section { background: linear-gradient(180deg, #fff 0%, var(--gray-50) 100%); }
.process-grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: 16px; }
.process-step { background: #fff; border: 1px solid var(--gray-200); border-radius: 14px; padding: 24px; transition: all .3s; position: relative; }
.process-step:hover { transform: translateY(-3px); box-shadow: 0 8px 24px rgba(15,23,42,.08); border-color: var(--brand-500); }
.process-num { display: inline-flex; width: 40px; height: 40px; background: var(--brand-100); color: var(--brand-700); border-radius: 50%; font-family: var(--font-en); font-weight: 800; font-size: 16px; align-items: center; justify-content: center; margin-bottom: 14px; }
.process-step h4 { font-size: 17px; font-weight: 700; color: var(--brand-900); margin-bottom: 8px; }
.process-step p { font-size: 13px; color: var(--text-secondary); line-height: 1.7; }
.process-footer { margin-top: 32px; padding: 16px 20px; background: var(--brand-50); border-left: 4px solid var(--brand-500); border-radius: 0 8px 8px 0; font-size: 14px; color: var(--brand-700); font-weight: 600; text-align: center; }

.themes-grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: 20px; }
.theme-card { background: #fff; border: 1px solid var(--gray-200); border-radius: 14px; padding: 24px; transition: all .3s; }
.theme-card:hover { border-color: var(--brand-500); transform: translateY(-3px); box-shadow: 0 8px 24px rgba(15,23,42,.08); }
.theme-card h4 { font-size: 18px; font-weight: 700; color: var(--brand-900); margin-bottom: 10px; }
.theme-card p { font-size: 13.5px; color: var(--text-secondary); line-height: 1.7; }

.scenario-section { background: var(--gray-50); }
.scenario-grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: 20px; }
.scenario-card { background: #fff; border-radius: 14px; overflow: hidden; border: 1px solid var(--gray-200); transition: all .3s; }
.scenario-card:hover { transform: translateY(-3px); box-shadow: 0 12px 28px rgba(15,23,42,.1); }
.scenario-tag { background: var(--brand-500); color: #fff; padding: 12px 20px; font-size: 14px; font-weight: 700; }
.scenario-body { padding: 20px; font-size: 13.5px; color: var(--text-secondary); line-height: 1.85; }

.cat-section { padding-top: 80px; padding-bottom: 64px; }
.cat-block { background: #fff; border: 1px solid var(--gray-200); border-radius: 16px; padding: 32px; margin-bottom: 24px; }
.cat-header { display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 12px; margin-bottom: 20px; }
.cat-title { display: flex; flex-direction: column; gap: 4px; }
.cat-num { font-family: var(--font-en); font-size: 13px; font-weight: 700; color: var(--brand-500); letter-spacing: 2px; }
.cat-name { font-size: 22px; font-weight: 700; color: var(--brand-900); }
.cat-tags { display: flex; gap: 8px; flex-wrap: wrap; }
.cat-tag { background: var(--brand-100); color: var(--brand-700); font-size: 12px; font-weight: 600; padding: 4px 12px; border-radius: 999px; }
.cat-tag.eco { background: var(--green-100); color: var(--green-600); }
.cat-desc { font-size: 14px; color: var(--text-secondary); line-height: 1.85; margin-bottom: 20px; }
.brand-wall { display: grid; grid-template-columns: repeat(6, 1fr); gap: 10px; }
.brand-card { background: var(--gray-50); border: 1px solid var(--gray-200); border-radius: 8px; min-height: 60px; display: flex; align-items: center; justify-content: center; padding: 8px; text-align: center; transition: all .25s; font-size: 13px; font-weight: 600; color: var(--brand-900); line-height: 1.4; }
.brand-card img { max-height: 42px; max-width: 100%; object-fit: contain; }
.brand-card.has-logo { padding: 12px 8px; }
.brand-card:hover { background: var(--brand-100); border-color: var(--brand-500); transform: translateY(-2px); }
.cat-count { font-size: 13px; color: var(--gray-500); font-weight: 500; }

.academic-section { background: linear-gradient(180deg, #fff 0%, var(--gray-50) 100%); }
.academic-stats { display: grid; grid-template-columns: repeat(4, 1fr); gap: 16px; margin: 32px 0; }
.academic-stat { background: #fff; border: 2px solid var(--brand-100); border-radius: 14px; padding: 24px 16px; text-align: center; }
.academic-stat .num { font-family: var(--font-en); font-size: 36px; font-weight: 800; color: var(--brand-700); line-height: 1; }
.academic-stat .lbl { font-size: 13px; font-weight: 700; color: var(--brand-900); margin-top: 8px; }
.academic-stat .desc { font-size: 11px; color: var(--gray-500); margin-top: 4px; }

.country-chips { display: flex; flex-wrap: wrap; justify-content: center; gap: 8px; max-width: 1000px; margin: 0 auto; padding: 20px; background: var(--brand-50); border-radius: 14px; border: 1px solid var(--brand-100); }
.country-chips span { background: #fff; border: 1px solid var(--brand-100); color: var(--brand-900); padding: 6px 12px; border-radius: 999px; font-size: 12.5px; font-weight: 500; transition: all .25s; }
.country-chips span:hover { background: var(--brand-100); border-color: var(--brand-500); }

.uni-wall { display: grid; grid-template-columns: repeat(6, 1fr); gap: 10px; margin-top: 24px; }
.uni-card { background: #fff; border: 1px solid var(--gray-200); border-radius: 8px; height: 60px; display: flex; align-items: center; justify-content: center; font-size: 12px; font-weight: 600; color: var(--brand-900); padding: 8px; text-align: center; transition: all .25s; line-height: 1.3; }
.uni-card:hover { background: var(--brand-100); border-color: var(--brand-500); }

.why-section { background: #fff; }
.why-grid { display: grid; grid-template-columns: repeat(2, 1fr); gap: 24px; }
.why-card { background: var(--gray-50); border: 1px solid var(--gray-200); border-radius: 14px; padding: 28px; display: flex; gap: 20px; align-items: flex-start; }
.why-num { width: 56px; height: 56px; background: var(--brand-700); color: #fff; border-radius: 50%; font-family: var(--font-en); font-size: 22px; font-weight: 800; display: flex; align-items: center; justify-content: center; flex-shrink: 0; }
.why-content h4 { font-size: 22px; font-weight: 700; color: var(--brand-900); margin-bottom: 6px; }
.why-content .tag { font-size: 12px; color: var(--brand-500); font-weight: 600; margin-bottom: 12px; letter-spacing: 1px; }
.why-content p { font-size: 14px; color: var(--text-secondary); line-height: 1.75; }

.cta-section { background: linear-gradient(135deg, var(--brand-900), var(--brand-700)); color: #fff; text-align: center; position: relative; overflow: hidden; }
.cta-section::before { content: ""; position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); width: 800px; height: 800px; background: radial-gradient(circle, rgba(37,99,235,.25), transparent 60%); border-radius: 50%; pointer-events: none; }
.cta-section .container { position: relative; z-index: 2; }
.cta-section h2 { font-size: clamp(26px, 3.5vw, 36px); font-weight: 700; margin-bottom: 14px; color: #fff; line-height: 1.3; }
.cta-section p { font-size: clamp(14.5px, 1.4vw, 16px); color: rgba(255,255,255,.85); max-width: 720px; margin: 0 auto 32px; line-height: 1.85; }
.cta-actions { display: flex; gap: 14px; justify-content: center; flex-wrap: wrap; }

.site-footer { background: var(--brand-900); color: rgba(255,255,255,.7); padding: 56px 0 28px; }
.footer-grid { display: grid; grid-template-columns: 2fr 1fr 1fr 1.5fr; gap: 40px; margin-bottom: 32px; }
.footer-grid h5 { font-size: 14px; color: #fff; margin-bottom: 14px; font-weight: 700; }
.footer-grid ul li { margin-bottom: 8px; font-size: 13px; }
.footer-grid ul li a { color: rgba(255,255,255,.6); }
.footer-grid ul li a:hover { color: var(--green-100); }
.footer-brand p { font-size: 13px; line-height: 1.85; max-width: 320px; }
.footer-bottom { border-top: 1px solid rgba(255,255,255,.1); padding-top: 22px; display: flex; justify-content: space-between; flex-wrap: wrap; gap: 12px; font-size: 12px; color: rgba(255,255,255,.5); }

@media (max-width: 1024px) {
:root { --section-py: 60px; }
.stats-grid, .academic-stats { grid-template-columns: repeat(2, 1fr); }
.services-grid, .why-grid { grid-template-columns: 1fr; }
.themes-grid, .scenario-grid, .process-grid { grid-template-columns: repeat(2, 1fr); }
.brand-wall, .uni-wall { grid-template-columns: repeat(4, 1fr); }
.footer-grid { grid-template-columns: 1fr 1fr; }
}
@media (max-width: 768px) {
:root { --section-py: 48px; --hero-height: auto; }
.nav-links { position: fixed; top: 72px; left: 0; right: 0; background: #fff; flex-direction: column; gap: 0; padding: 16px 24px; border-bottom: 1px solid var(--gray-200); transform: translateY(-150%); transition: transform .3s; box-shadow: 0 8px 24px rgba(15,23,42,.08); }
.nav-links.open { transform: translateY(0); }
.nav-links a { width: 100%; padding: 14px 0; border-bottom: 1px solid var(--gray-100); }
.menu-toggle { display: flex; }
.menu-toggle.open span:nth-child(1) { transform: translateY(7px) rotate(45deg); }
.menu-toggle.open span:nth-child(2) { opacity: 0; }
.menu-toggle.open span:nth-child(3) { transform: translateY(-7px) rotate(-45deg); }
.hero { padding: 64px 0; }
.stats-grid, .academic-stats { grid-template-columns: repeat(2, 1fr); gap: 12px; }
.themes-grid, .scenario-grid, .process-grid { grid-template-columns: 1fr; }
.brand-wall { grid-template-columns: repeat(3, 1fr); }
.uni-wall { grid-template-columns: repeat(3, 1fr); }
.footer-grid { grid-template-columns: 1fr; }
.hero-actions, .cta-actions { flex-direction: column; align-items: stretch; }
.why-card { flex-direction: column; }
}
@media (max-width: 480px) {
.brand-wall, .uni-wall { grid-template-columns: repeat(2, 1fr); }
.academic-stats { grid-template-columns: 1fr 1fr; }
}
</style>
</head>
<body>

<header class="site-header">
<div class="container nav">
<a href="#hero" class="logo">
<img src="/images/LOGO.png" alt="錚典科技" class="logo-img">
</a>
<nav class="nav-links" id="navLinks">
<a href="#services">服務架構</a>
<a href="#workflow">補助流程</a>
<a href="#cases">產業案例</a>
<a href="#academic">國際資源</a>
<a href="#contact" class="btn btn-primary nav-cta">預約補助健檢</a>
</nav>
<button class="menu-toggle" id="menuToggle" aria-label="選單">
<span></span><span></span><span></span>
</button>
</div>
</header>

<section class="hero" id="hero">
<div class="container hero-inner">
<span class="hero-eyebrow">{{ $pageSetting('hero_eyebrow') }}</span>
<h1>{!! nl2br(e($pageSetting('hero_title'))) !!}</h1>
<div class="tagline">{{ $pageSetting('hero_tagline') }}</div>
<p class="lead">{{ $pageSetting('hero_lead') }}</p>
<div class="hero-actions">
<a href="#contact" class="btn btn-on-dark">{{ $pageSetting('hero_btn_primary') }}</a>
<a href="#cases" class="btn btn-on-dark-outline">{{ $pageSetting('hero_btn_secondary') }}</a>
</div>
</div>
</section>

<section class="stats">
<div class="container">
<div class="stats-grid">
@foreach ($stats as $stat)
<div class="stat-card">
<div class="stat-value">{{ $stat->title }}@if ($stat->extra)<span class="unit">{{ $stat->extra }}</span>@endif</div>
<div class="stat-label">{{ $stat->subtitle }}</div>
<div class="stat-desc">{{ $stat->body }}</div>
</div>
@endforeach
</div>
</div>
</section>

<section id="services">
<div class="container">
<span class="eyebrow">{{ $pageSetting('services_eyebrow') }}</span>
<h2 class="section-title">{{ $pageSetting('services_title') }}</h2>
<p class="section-subtitle">{{ $pageSetting('services_subtitle') }}</p>
<div class="services-grid">
@foreach ($services as $service)
<div class="service-card">
<div class="service-head">
<div class="service-icon">{{ $service->icon }}</div>
<div><h3>{{ $service->title }}</h3><span class="en">{{ $service->subtitle }}</span></div>
</div>
<ul class="service-list">
@foreach ($service->listItems() as $item)
<li>{{ $item }}</li>
@endforeach
</ul>
</div>
@endforeach
</div>
</div>
</section>

<section class="process-section" id="workflow">
<div class="container">
<span class="eyebrow">{{ $pageSetting('workflow_eyebrow') }}</span>
<h2 class="section-title">{{ $pageSetting('workflow_title') }}</h2>
<p class="section-subtitle">{{ $pageSetting('workflow_subtitle') }}</p>
<div class="process-grid">
@foreach ($processes as $index => $process)
<div class="process-step"><div class="process-num">{{ str_pad((string) ($index + 1), 2, '0', STR_PAD_LEFT) }}</div><h4>{{ $process->title }}</h4><p>{{ $process->body }}</p></div>
@endforeach
</div>
<div class="process-footer">{{ $pageSetting('workflow_footer') }}</div>
</div>
</section>

<section>
<div class="container">
<span class="eyebrow">{{ $pageSetting('themes_eyebrow') }}</span>
<h2 class="section-title">{{ $pageSetting('themes_title') }}</h2>
<p class="section-subtitle">{{ $pageSetting('themes_subtitle') }}</p>
<div class="themes-grid">
@foreach ($themes as $theme)
<div class="theme-card"><h4>{{ $theme->title }}</h4><p>{{ $theme->body }}</p></div>
@endforeach
</div>
</div>
</section>

<section class="scenario-section">
<div class="container">
<span class="eyebrow">{{ $pageSetting('scenarios_eyebrow') }}</span>
<h2 class="section-title">{{ $pageSetting('scenarios_title') }}</h2>
<p class="section-subtitle">{{ $pageSetting('scenarios_subtitle') }}</p>
<div class="scenario-grid">
@foreach ($scenarios as $scenario)
<div class="scenario-card">
<div class="scenario-tag">{{ $scenario->title }}</div>
<div class="scenario-body">{{ $scenario->body }}</div>
</div>
@endforeach
</div>
</div>
</section>

<section class="cat-section" id="cases">
<div class="container">
<span class="eyebrow">{{ $pageSetting('cases_eyebrow') }}</span>
<h2 class="section-title">{{ $pageSetting('cases_title') }}</h2>
<p class="section-subtitle">{{ $pageSetting('cases_subtitle') }}</p>

@foreach ($categories as $category)
<div class="cat-block">
<div class="cat-header">
<div class="cat-title">
@if ($category->code)
<div class="cat-num">{{ $category->code }}</div>
@endif
<div class="cat-name">{{ $category->name }}</div>
</div>
<div class="cat-tags">
<span class="cat-count">合作客戶代表：{{ $category->activeBrandClients->count() }} 家</span>
</div>
</div>
@if ($category->description)
<p class="cat-desc">{!! nl2br(e($category->description)) !!}</p>
@endif
<div class="brand-wall" style="grid-template-columns: repeat({{ max(2, (int) $category->grid_columns) }}, 1fr);">
@foreach ($category->activeBrandClients as $brand)
<div class="brand-card{{ $brand->logoUrl() ? ' has-logo' : '' }}">
@if ($brand->logoUrl())
<img src="{{ $brand->logoUrl() }}" alt="{{ $brand->name }}">
@else
{{ $brand->name }}
@endif
</div>
@endforeach
</div>
</div>
@endforeach

<p style="font-size:12px; color:var(--gray-500); text-align:center; margin-top:32px; font-style:italic;">
{{ $pageSetting('cases_disclaimer') }}
</p>
</div>
</section>

<section class="academic-section" id="academic">
<div class="container">
<span class="eyebrow">{{ $pageSetting('academic_eyebrow') }}</span>
<h2 class="section-title">{{ $pageSetting('academic_title') }}</h2>
<p class="section-subtitle">{!! nl2br(e($pageSetting('academic_subtitle'))) !!}</p>

<div class="academic-stats">
@foreach ($academicStats as $item)
<div class="academic-stat">
<div class="num">{{ $item->title }}</div>
<div class="lbl">{{ $item->subtitle }}</div>
<div class="desc">{{ $item->body }}</div>
</div>
@endforeach
</div>

<div style="margin-top:48px; margin-bottom:16px;">
<h3 style="font-size:18px; font-weight:700; color:var(--brand-700); margin-bottom:16px;">🌍 學生來自 21+ 個國家</h3>
</div>
<div class="country-chips">
@foreach ($countries as $country)
<span>{{ $country->title }}</span>
@endforeach
</div>

<div style="margin-top:48px; margin-bottom:16px;">
<h3 style="font-size:18px; font-weight:700; color:var(--brand-700); margin-bottom:16px;">🎓 合作 24+ 所大專院校（代表）</h3>
</div>
<div class="uni-wall">
@foreach ($universities as $uni)
<div class="uni-card">{!! nl2br(e($uni->title)) !!}</div>
@endforeach
</div>

<p style="font-size:12.5px; color:var(--gray-500); text-align:center; margin-top:24px; padding:16px; background:var(--brand-50); border-radius:10px;">
{{ $pageSetting('academic_note') }}
</p>
</div>
</section>

<section class="why-section">
<div class="container">
<span class="eyebrow">{{ $pageSetting('why_eyebrow') }}</span>
<h2 class="section-title">{{ $pageSetting('why_title') }}</h2>
<p class="section-subtitle">{{ $pageSetting('why_subtitle') }}</p>
<div class="why-grid">
@foreach ($whyCards as $index => $why)
<div class="why-card">
<div class="why-num">{{ str_pad((string) ($index + 1), 2, '0', STR_PAD_LEFT) }}</div>
<div class="why-content">
<h4>{{ $why->title }}</h4>
@if ($why->subtitle)<div class="tag">{{ $why->subtitle }}</div>@endif
<p>{{ $why->body }}</p>
</div>
</div>
@endforeach
</div>
</div>
</section>

<section class="cta-section" id="contact">
<div class="container">
<h2>{!! nl2br(e($pageSetting('cta_title'))) !!}</h2>
<p>{!! nl2br(e($pageSetting('cta_text'))) !!}</p>
<div class="cta-actions">
<a href="tel:{{ preg_replace('/\D+/', '', $pageSetting('contact_phone')) }}" class="btn btn-on-dark">📞 {{ $pageSetting('contact_phone') }} 預約諮詢</a>
<a href="mailto:{{ $pageSetting('contact_email') }}" class="btn btn-on-dark-outline">✉ {{ $pageSetting('contact_email') }}</a>
<a href="{{ $pageSetting('contact_line_url', '#') }}" class="btn btn-line">💬 LINE 快速諮詢</a>
</div>

<div style="margin-top:48px; padding:24px 32px; background:rgba(255,255,255,.08); border:1px solid rgba(255,255,255,.2); border-radius:14px; max-width:640px; margin-left:auto; margin-right:auto;">
<div style="font-size:11px; color:rgba(255,255,255,.7); letter-spacing:2px; margin-bottom:8px;">SERVICE WINDOW｜服務窗口</div>
<div style="font-size:24px; color:#fff; font-weight:700; margin-bottom:6px;">{{ $pageSetting('contact_name') }}</div>
<div style="font-size:13px; color:rgba(255,255,255,.85);">{{ $pageSetting('contact_tel') }} ｜ {{ $pageSetting('contact_phone') }} ｜ {{ $pageSetting('contact_email') }}</div>
</div>
</div>
</section>

<footer class="site-footer">
<div class="container">
<div class="footer-grid">
<div class="footer-brand">
<h5>錚典科技國際有限公司</h5>
<p>ZHENG DIAN Technology Co., Ltd.<br><br>
{{ $pageSetting('footer_desc') }}</p>
</div>
<div>
<h5>服務架構</h5>
<ul>
<li><a href="#services">政府補助規劃</a></li>
<li><a href="#services">企業整合顧問</a></li>
<li><a href="#services">AI 數位轉型</a></li>
<li><a href="#services">品牌與行銷升級</a></li>
</ul>
</div>
<div>
<h5>產業案例</h5>
<ul>
@foreach ($categories as $category)
<li><a href="#cases">{{ $category->name }}</a></li>
@endforeach
</ul>
</div>
<div>
<h5>聯絡資訊</h5>
<ul>
<li>服務窗口：{{ $pageSetting('contact_name') }}</li>
<li>電話：{{ $pageSetting('contact_tel') }}</li>
<li>手機：{{ $pageSetting('contact_phone') }}</li>
<li>信箱：{{ $pageSetting('contact_email') }}</li>
<li>服務時段：週一至週五 09:00-18:00</li>
</ul>
</div>
</div>
<div class="footer-bottom">
<span>© 2026 錚典科技國際有限公司. All rights reserved.</span>
<span>政府補助顧問 ｜ AI 數位轉型 ｜ 智慧升級規劃</span>
</div>
</div>
</footer>

<script>
const toggle = document.getElementById('menuToggle');
const navLinks = document.getElementById('navLinks');
toggle.addEventListener('click', () => {
toggle.classList.toggle('open');
navLinks.classList.toggle('open');
});
navLinks.querySelectorAll('a').forEach(a => {
a.addEventListener('click', () => {
if (window.innerWidth <= 768) {
toggle.classList.remove('open');
navLinks.classList.remove('open');
}
});
});
window.addEventListener('resize', () => {
if (window.innerWidth > 768) {
toggle.classList.remove('open');
navLinks.classList.remove('open');
}
});
</script>
</body>
</html>
