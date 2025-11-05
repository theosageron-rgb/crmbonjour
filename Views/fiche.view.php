<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<title><?= h($fiche['prenom'].' '.$fiche['nom']) ?> — Ordex CRM</title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
<style>
/* --- ton CSS d'origine --- */
:root{
  --bg: #0b1020;
  --bg-2:#0f172a;
  --fg: #e5e7eb;
  --muted:#9aa4b2;
  --brand-1:#3b82f6;
  --brand-2:#0ea5e9;
  --card:#101928;
  --card-bd:rgba(255,255,255,.10);
  --card-hov:rgba(255,255,255,.12);
  --ring:rgba(59,130,246,.35);
  --shadow: 0 10px 30px rgba(0,0,0,.35);
}
*{box-sizing:border-box}
html,body{height:100%}
body{
  margin:0;
  background: radial-gradient(1200px 600px at 80% 8%, rgba(59,130,246,.25), transparent 60%) , linear-gradient(180deg, var(--bg) 0%, var(--bg-2) 60%, var(--bg) 100%);
  color: var(--fg);
  font-family: Inter, ui-sans-serif, system-ui, "Segoe UI", Roboto, Arial, "Apple Color Emoji", "Segoe UI Emoji";
  -webkit-font-smoothing: antialiased; text-rendering: optimizeLegibility;
}
.appbar{position: sticky; top:0; z-index:50; backdrop-filter: blur(10px); background: linear-gradient(180deg, rgba(10,16,35,.85), rgba(10,16,35,.65)); border-bottom: 1px solid rgba(255,255,255,.08);}
.appbar .container{max-width:1120px}
.container{ max-width:1120px }
.card-glass{ background: var(--card); border: 1px solid var(--card-bd); border-radius: 16px; box-shadow: var(--shadow); transition: transform .18s ease, border-color .18s ease, background .18s ease, box-shadow .18s ease; }
.card-glass:hover{ transform: translateY(-2px); border-color: rgba(255,255,255,.16); background: #0f1b2b }
h1,h2,h3,h4{letter-spacing:.2px}
.lead{color:var(--muted)}
.avatar{ width:72px;height:72px;border-radius:50%;background: linear-gradient(135deg, var(--brand-1), var(--brand-2));display:flex;align-items:center;justify-content:center;color:#fff;font-weight:800;font-size:1.35rem;box-shadow: 0 8px 24px rgba(59,130,246,.45);}
.badge-status{ border-radius:999px; padding:.40rem .9rem; font-weight:700; letter-spacing:.2px;}
.form-control, .form-select, textarea{ background: rgba(255,255,255,.06)!important;color:#fff!important;border:1px solid rgba(255,255,255,.12)!important;}
.form-control::placeholder, textarea::placeholder{ color:#a3adc0 }
.form-control:focus, .form-select:focus, textarea:focus{ border-color: var(--brand-1)!important; box-shadow: 0 0 0 .2rem var(--ring)!important;}
.btn-ghost{ color:#e8eefc;border:1px solid rgba(255,255,255,.16);background:transparent;}
.btn-ghost:hover{ background: rgba(255,255,255,.08) }
.btn-gradient{ background: linear-gradient(90deg, var(--brand-1), var(--brand-2)); border:none; color:#fff; font-weight:700; border-radius:12px; transition: transform .15s ease, box-shadow .15s ease;}
.btn-gradient:hover{ transform: translateY(-1px); box-shadow: 0 8px 22px rgba(59,130,246,.45)}
.scroll-zone{ max-height: 320px; overflow-y:auto; padding-right:4px }
.scroll-zone::-webkit-scrollbar{ width:8px }
.scroll-zone::-webkit-scrollbar-thumb{ background: rgba(255,255,255,.16); border-radius: 6px }
.block{ background: rgba(255,255,255,.04); border: 1px solid rgba(255,255,255,.10); border-radius: 12px; padding: 12px; transition: background .18s ease, transform .18s ease, border-color .18s ease;}
.block:hover{ background: var(--card-hov); transform: translateY(-1px); border-color: rgba(255,255,255,.18) }
.text-subtle{ color: var(--muted) }
.kbd{ border:1px solid rgba(255,255,255,.2); border-bottom-width:2px; padding:2px 7px; border-radius:8px; font-weight:700; font-size:.8rem; }
.fab{ position: fixed; right:16px; bottom:16px; z-index:60; display:flex; gap:12px; flex-direction:column;}
.fab .btn{ border-radius:999px; padding:.75rem 1rem }
@media (max-width:768px){ .avatar{ width:60px; height:60px; font-size:1.1rem } .scroll-zone{ max-height:240px } }
:focus-visible{ outline:2px solid var(--brand-2); outline-offset:2px }
</style>
</head>
<body>

<!-- (le HTML de ton fichier d’origine reste identique ici, aucun changement à faire) -->

<?= /* colle ici le contenu à partir de ton <body> jusqu’à la fin */ '' ?>

</body>
</html>
