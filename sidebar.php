<?php
  // Utilisé pour marquer le lien actif
  $current = basename($_SERVER['PHP_SELF']);
?>
<aside class="ordex-sidebar" data-state="expanded" aria-label="Navigation principale">
  <div class="sb-brand">
    <a href="dashboard.php" class="brand-link">
      <div class="brand-logo">OX</div>
      <div class="brand-text">
        <strong>Bonjour</strong><span>CRM</span>
      </div>
    </a>
    <button class="sb-toggle" type="button" aria-label="Réduire le menu">
      <i class="bi bi-layout-sidebar-inset"></i>
    </button>
  </div>

  <nav class="sb-nav">
    <!-- Tableau de bord -->
    <a href="dashboard.php" class="sb-link <?= $current==='dashboard.php' ? 'active' : '' ?>">
      <i class="bi bi-speedometer2"></i><span>Tableau de bord</span>
    </a>

    <!-- 🔥 Tâches du jour -->
    <a href="taches.php" class="sb-link <?= $current==='taches.php' ? 'active' : '' ?>">
      <i class="bi bi-list-check"></i><span>Tâches du jour</span>
    </a>

    <!-- Pipeline -->
    <a href="pipeline.php" class="sb-link <?= $current==='pipeline.php' ? 'active' : '' ?>">
      <i class="bi bi-kanban"></i><span>Pipeline / Clients</span>
    </a>

    <!-- Contacts -->
    <a href="contacts.php" class="sb-link <?= $current==='contacts.php' ? 'active' : '' ?>">
      <i class="bi bi-people"></i><span>Contacts</span>
    </a>

    <!-- Agenda -->
    <a href="agenda.php" class="sb-link <?= $current==='agenda.php' ? 'active' : '' ?>">
      <i class="bi bi-calendar3"></i><span>Agenda</span>
    </a>

    <!-- Mails -->
    <a href="mails.php" class="sb-link <?= $current==='mails.php' ? 'active' : '' ?>">
      <i class="bi bi-envelope"></i><span>Mails</span>
    </a>
  </nav>

  <div class="sb-footer">
    <a href="#" class="sb-link sb-mini">
      <i class="bi bi-gear"></i><span>Paramètres</span>
    </a>
    <a href="#" class="sb-link sb-mini">
      <i class="bi bi-box-arrow-right"></i><span>Déconnexion</span>
    </a>
  </div>
</aside>

<!-- Applique un offset propre à droite du menu -->
<style>
  :root{
    --sb-w: 240px;
    --sb-w-collapsed: 84px;
    --sb-bg: linear-gradient(180deg,#0b1020 0%,#0f172a 70%,#0b1020 100%);
    --sb-border: rgba(255,255,255,.08);
    --sb-glass: rgba(255,255,255,.06);
    --txt: #e5e7eb;
    --muted: #94a3b8;
    --brand-grad: linear-gradient(135deg,#1d4ed8,#06b6d4);
    --active: #60a5fa;
    --hover: rgba(255,255,255,.06);
  }

  body{ background: var(--sb-bg); }

  /* === SIDEBAR === */
  .ordex-sidebar{
    position: fixed; inset: 0 auto 0 0;
    width: var(--sb-w);
    background: linear-gradient(180deg, rgba(255,255,255,.06), rgba(255,255,255,.03));
    backdrop-filter: blur(12px);
    border-right: 1px solid var(--sb-border);
    box-shadow: 8px 0 30px rgba(0,0,0,.28);
    color: var(--txt);
    display: grid;
    grid-template-rows: auto 1fr auto;
    gap: 10px;
    padding: 14px 12px;
    z-index: 1000;
    transition: width .25s ease;
  }
  .ordex-sidebar[data-state="collapsed"]{ width: var(--sb-w-collapsed); }

  /* Brand */
  .sb-brand{
    display: flex; align-items: center; justify-content: space-between; gap: 8px;
    padding: 6px 4px 10px;
  }
  .brand-link{ display:flex; align-items:center; gap:12px; text-decoration:none; color:var(--txt); }
  .brand-logo{
    width:42px; height:42px; border-radius:12px; display:grid; place-items:center; font-weight:900;
    background: var(--brand-grad); color:#fff; letter-spacing:1px;
    box-shadow: 0 10px 26px rgba(59,130,246,.35);
  }
  .brand-text strong{ display:block; letter-spacing:.6px; }
  .brand-text span{ display:block; color:var(--muted); font-size:.85rem; margin-top:-2px; }

  .ordex-sidebar[data-state="collapsed"] .brand-text{ display:none; }

  /* Toggle */
  .sb-toggle{
    border:1px solid var(--sb-border); background: transparent; color: var(--txt);
    border-radius:10px; padding:8px 10px; cursor:pointer; transition: background .2s ease, transform .2s ease;
  }
  .sb-toggle:hover{ background: var(--hover); transform: translateY(-1px); }

  /* Nav */
  .sb-nav{ display:flex; flex-direction:column; gap:6px; margin-top:6px; }
  .sb-link{
    display:flex; align-items:center; gap:12px; text-decoration:none; color:var(--txt);
    padding:10px 12px; border-radius:12px; border:1px solid transparent;
    transition: background .2s ease, border-color .2s ease, transform .15s ease;
  }
  .sb-link i{ font-size:1.1rem; width:22px; text-align:center; color:#cbd5e1; }
  .sb-link span{ white-space:nowrap; }
  .sb-link:hover{ background: var(--hover); transform: translateX(2px); }

  .sb-link.active{
    background: rgba(96,165,250,.12);
    border-color: rgba(96,165,250,.35);
    box-shadow: 0 6px 18px rgba(59,130,246,.22) inset, 0 6px 20px rgba(59,130,246,.15);
  }
  .sb-link.active i{ color: var(--active); }

  .ordex-sidebar[data-state="collapsed"] .sb-link span{ display:none; }
  .ordex-sidebar[data-state="collapsed"] .sb-link{ justify-content:center; padding:10px; }

  /* Footer */
  .sb-footer{ margin-top:auto; display:flex; flex-direction:column; gap:6px; padding-top:6px; border-top:1px solid var(--sb-border); }
  .sb-mini{ opacity:.9; }

  /* Main content offset */
  .main-content{
    margin-left: var(--sb-w);
    transition: margin-left .25s ease;
  }
  .ordex-sidebar[data-state="collapsed"] ~ .main-content{
    margin-left: var(--sb-w-collapsed);
  }

  /* Tooltips on collapsed (pure CSS) */
  .ordex-sidebar[data-state="collapsed"] .sb-link{
    position:relative;
  }
  .ordex-sidebar[data-state="collapsed"] .sb-link:hover::after{
    content: attr(data-title);
    position:absolute; left: calc(100% + 10px); top:50%; transform: translateY(-50%);
    background: #111827; color:#e5e7eb; border:1px solid var(--sb-border);
    padding:6px 8px; border-radius:8px; white-space:nowrap; font-size:.85rem;
    box-shadow:0 10px 26px rgba(0,0,0,.35);
  }

  /* Mobile */
  @media (max-width: 992px){
    .ordex-sidebar{ width: var(--sb-w-collapsed); }
    .ordex-sidebar[data-state="expanded"]{ width: var(--sb-w); }
    .main-content{ margin-left: var(--sb-w-collapsed); }
    .ordex-sidebar[data-state="expanded"] ~ .main-content{ margin-left: var(--sb-w); }
  }
</style>

<script>
  // Collapse / expand
  (function(){
    const sb = document.querySelector('.ordex-sidebar');
    const btn = sb.querySelector('.sb-toggle');

    // Ajoute un titre aux liens pour tooltip en mode collapsed
    sb.querySelectorAll('.sb-link').forEach(link=>{
      const label = link.querySelector('span')?.textContent?.trim();
      if(label) link.setAttribute('data-title', label);
    });

    btn.addEventListener('click', ()=>{
      const state = sb.getAttribute('data-state');
      sb.setAttribute('data-state', state === 'collapsed' ? 'expanded' : 'collapsed');
      // Accessibilité
      btn.setAttribute('aria-expanded', sb.getAttribute('data-state') === 'expanded');
    });
  })();
</script>

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">


