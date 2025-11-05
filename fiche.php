<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);
include __DIR__ . '/Config/config.php';
date_default_timezone_set('Europe/Paris');

// --- Vérification ---
if (!isset($_GET['id'])) die("Aucun prospect sélectionné.");
$id = intval($_GET['id']);

// --- Récupération ---
$fiche = $conn->query("SELECT * FROM fiches WHERE id=$id")->fetch_assoc();
if (!$fiche) die("Fiche introuvable.");
$notes    = $conn->query("SELECT * FROM notes    WHERE fiche_id=$id ORDER BY date_creation DESC");
$fichiers = $conn->query("SELECT * FROM fichiers WHERE fiche_id=$id ORDER BY date_upload DESC");
$taches   = $conn->query("SELECT * FROM taches   WHERE fiche_id=$id ORDER BY date_creation DESC");

// --- Helpers ---
function h($v){ return htmlspecialchars((string)$v, ENT_QUOTES, 'UTF-8'); }
function initials($p,$n){ return strtoupper(mb_substr($p,0,1).mb_substr($n,0,1)); }
function statusColor($s){
  return match (strtolower((string)$s)) {
    'prospect' => 'primary',
    'en cours' => 'warning',
    'gagné', 'client' => 'success',
    'perdu' => 'danger',
    default => 'secondary'
  };
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<title><?= h($fiche['prenom'].' '.$fiche['nom']) ?> — Ordex CRM</title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
<style>
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

/* Header sticky */
.appbar{
  position: sticky; top:0; z-index: 50;
  backdrop-filter: blur(10px);
  background: linear-gradient(180deg, rgba(10,16,35,.85), rgba(10,16,35,.65));
  border-bottom: 1px solid rgba(255,255,255,.08);
}
.appbar .container{max-width:1120px}

/* Container */
.container{ max-width:1120px }

/* Carte “glass” optimisée perf (peu de blur) */
.card-glass{
  background: var(--card);
  border: 1px solid var(--card-bd);
  border-radius: 16px;
  box-shadow: var(--shadow);
  transition: transform .18s ease, border-color .18s ease, background .18s ease, box-shadow .18s ease;
}
.card-glass:hover{ transform: translateY(-2px); border-color: rgba(255,255,255,.16); background: #0f1b2b }

/* Typo */
h1,h2,h3,h4{letter-spacing:.2px}
.lead{color:var(--muted)}

/* Avatar */
.avatar{
  width:72px;height:72px;border-radius:50%;
  background: linear-gradient(135deg, var(--brand-1), var(--brand-2));
  display:flex;align-items:center;justify-content:center;
  color:#fff;font-weight:800;font-size:1.35rem;
  box-shadow: 0 8px 24px rgba(59,130,246,.45);
}

/* Badges statut */
.badge-status{
  border-radius: 999px;
  padding:.40rem .9rem;
  font-weight:700;
  letter-spacing:.2px;
}

/* Inputs */
.form-control, .form-select, textarea{
  background: rgba(255,255,255,.06) !important;
  color:#fff !important;
  border:1px solid rgba(255,255,255,.12) !important;
}
.form-control::placeholder, textarea::placeholder{ color:#a3adc0 }
.form-control:focus, .form-select:focus, textarea:focus{
  border-color: var(--brand-1) !important;
  box-shadow: 0 0 0 .2rem var(--ring) !important;
}

/* Boutons */
.btn-ghost{
  color:#e8eefc;border:1px solid rgba(255,255,255,.16);background: transparent;
}
.btn-ghost:hover{ background: rgba(255,255,255,.08) }
.btn-gradient{
  background: linear-gradient(90deg, var(--brand-1), var(--brand-2)); border:none; color:#fff;
  font-weight:700; border-radius:12px;
  transition: transform .15s ease, box-shadow .15s ease;
}
.btn-gradient:hover{ transform: translateY(-1px); box-shadow: 0 8px 22px rgba(59,130,246,.45)}

/* Listes scrollables */
.scroll-zone{ max-height: 320px; overflow-y:auto; padding-right:4px }
.scroll-zone::-webkit-scrollbar{ width:8px }
.scroll-zone::-webkit-scrollbar-thumb{ background: rgba(255,255,255,.16); border-radius: 6px }

/* Items */
.block{
  background: rgba(255,255,255,.04);
  border: 1px solid rgba(255,255,255,.10);
  border-radius: 12px; padding: 12px;
  transition: background .18s ease, transform .18s ease, border-color .18s ease;
}
.block:hover{ background: var(--card-hov); transform: translateY(-1px); border-color: rgba(255,255,255,.18) }

/* Texte & petites infos */
.text-subtle{ color: var(--muted) }
.kbd{
  border:1px solid rgba(255,255,255,.2); border-bottom-width:2px; padding:2px 7px; border-radius:8px; font-weight:700; font-size:.8rem;
}

/* Footer actions flottant (mobile) */
.fab{
  position: fixed; right: 16px; bottom: 16px; z-index: 60;
  display:flex; gap:12px; flex-direction:column;
}
.fab .btn{ border-radius: 999px; padding:.75rem 1rem }

@media (max-width: 768px){
  .avatar{ width:60px; height:60px; font-size:1.1rem }
  .scroll-zone{ max-height: 240px }
}

/* Focus visible sur tout */
:focus-visible{ outline: 2px solid var(--brand-2); outline-offset: 2px }
</style>
</head>
<body>

<!-- APP BAR -->
<div class="appbar">
  <div class="container py-3 d-flex align-items-center justify-content-between">
    <div class="d-flex align-items-center gap-3">
      <a href="pipeline.php" class="btn btn-ghost btn-sm rounded-pill px-3" aria-label="Retour au pipeline">
        <i class="bi bi-arrow-left"></i> <span class="d-none d-sm-inline">Retour</span>
      </a>
      <div class="d-none d-md-flex align-items-center gap-2 text-subtle">
        <span class="kbd">G</span> <span class="small">Retour</span>
      </div>
    </div>
    <div class="d-flex align-items-center gap-2">
      <button class="btn btn-ghost btn-sm rounded-pill px-3" data-bs-toggle="tooltip" data-bs-title="Modifier la fiche">
        <i class="bi bi-pencil-square"></i> <span class="d-none d-sm-inline">Modifier</span>
      </button>
      <button class="btn btn-gradient btn-sm rounded-pill px-3" id="btnQuickNote">
        <i class="bi bi-plus-circle"></i> <span class="d-none d-sm-inline">Nouvelle note</span>
      </button>
      <button class="btn btn-gradient btn-sm rounded-pill px-3 ms-1" id="btnQuickTask">
        <i class="bi bi-check2-circle"></i> <span class="d-none d-sm-inline">Nouvelle tâche</span>
      </button>
    </div>
  </div>
</div>

<!-- HERO / HEADER FICHE -->
<div class="container mt-4">
  <div class="card-glass p-4 p-md-5">
    <div class="d-flex gap-3 align-items-center">
      <div class="avatar"><?= initials($fiche['prenom'] ?? '', $fiche['nom'] ?? '') ?></div>
      <div class="flex-grow-1">
        <h1 class="h3 h2-md fw-bold mb-1"><?= h($fiche['prenom'].' '.$fiche['nom']) ?></h1>
        <div class="text-subtle mb-2"><?= h($fiche['profession'] ?? 'Profil') ?></div>
        <span class="badge badge-status bg-<?= statusColor($fiche['statut'] ?? '') ?>">
          <i class="bi bi-circle-fill me-1"></i><?= h($fiche['statut'] ?? '—') ?>
        </span>
      </div>
      <div class="text-end d-none d-md-block">
        <div class="text-subtle small mb-1"><i class="bi bi-clock-history"></i> Dernière activité</div>
        <div class="fw-semibold"><?= date('d/m/Y H:i') ?></div>
      </div>
    </div>
  </div>
</div>

<!-- GRID -->
<div class="container my-4">
  <div class="row g-4">
    <!-- NOTES -->
    <div class="col-lg-6">
      <section class="card-glass p-4 h-100">
        <div class="d-flex justify-content-between align-items-center mb-3">
          <h2 class="h5 m-0"><i class="bi bi-journal-text me-2"></i>Notes</h2>
          <button class="btn btn-ghost btn-sm rounded-pill px-3" id="btnNoteTop"><i class="bi bi-plus-lg"></i> Ajouter</button>
        </div>

        <div class="scroll-zone">
          <?php if ($notes->num_rows > 0): ?>
            <?php while($n = $notes->fetch_assoc()): ?>
              <article class="block mb-2">
                <p class="mb-1"><?= nl2br(h($n['contenu'])) ?></p>
                <div class="small text-subtle"><i class="bi bi-clock me-1"></i><?= h($n['date_creation']) ?></div>
              </article>
            <?php endwhile; ?>
          <?php else: ?>
            <div class="text-subtle text-center py-4">
              <i class="bi bi-journal-x fs-3 d-block mb-2"></i>
              Aucune note pour ce client.
            </div>
          <?php endif; ?>
        </div>

        <form method="POST" action="ajouter_note.php" class="mt-3" id="formNote">
          <input type="hidden" name="fiche_id" value="<?= $id ?>">
          <textarea name="contenu" rows="3" class="form-control mb-2" placeholder="Saisir une note claire, actionnable et utile…"></textarea>
          <button class="btn btn-gradient w-100"><i class="bi bi-plus-lg"></i> Ajouter une note</button>
        </form>
      </section>
    </div>

    <!-- TÂCHES -->
    <div class="col-lg-6">
      <section class="card-glass p-4 h-100">
        <div class="d-flex justify-content-between align-items-center mb-3">
          <h2 class="h5 m-0"><i class="bi bi-list-check me-2"></i>Tâches</h2>
          <button class="btn btn-ghost btn-sm rounded-pill px-3" id="btnTaskTop"><i class="bi bi-plus-lg"></i> Ajouter</button>
        </div>

        <div class="scroll-zone">
          <?php if ($taches->num_rows > 0): ?>
            <?php while($t = $taches->fetch_assoc()): ?>
              <article class="block mb-2">
                <div class="d-flex justify-content-between align-items-center">
                  <div class="me-3">
                    <div class="fw-semibold mb-1"><?= h($t['titre']) ?></div>
                    <div class="small text-subtle"><?= nl2br(h($t['description'])) ?></div>
                    <div class="small mt-2"><i class="bi bi-calendar-event me-1"></i><?= h($t['date_echeance'] ?: 'Aucune date') ?></div>
                  </div>
                  <span class="badge bg-<?= statusColor($t['statut'] ?? '') ?> badge-status"><?= h($t['statut'] ?? 'En attente') ?></span>
                </div>
              </article>
            <?php endwhile; ?>
          <?php else: ?>
            <div class="text-subtle text-center py-4">
              <i class="bi bi-list-task fs-3 d-block mb-2"></i>
              Aucune tâche associée.
            </div>
          <?php endif; ?>
        </div>

        <form method="POST" action="ajouter_tache.php" class="mt-3" id="formTask">
          <input type="hidden" name="fiche_id" value="<?= $id ?>">
          <input type="text" name="titre" class="form-control mb-2" placeholder="Titre de la tâche (clair et actionnable)" required>
          <textarea name="description" rows="2" class="form-control mb-2" placeholder="Description…"></textarea>
          <input type="date" name="date_echeance" class="form-control mb-2">
          <button class="btn btn-gradient w-100"><i class="bi bi-plus-lg"></i> Ajouter une tâche</button>
        </form>
      </section>
    </div>

    <!-- FICHIERS -->
    <div class="col-12">
      <section class="card-glass p-4">
        <div class="d-flex justify-content-between align-items-center mb-3">
          <h2 class="h5 m-0"><i class="bi bi-folder2-open me-2"></i>Fichiers</h2>
        </div>

        <form action="upload_fichier.php" method="POST" enctype="multipart/form-data" class="mb-3">
          <input type="hidden" name="fiche_id" value="<?= $id ?>">
          <div class="d-flex gap-2 flex-wrap">
            <input type="file" name="fichier" class="form-control flex-grow-1" required>
            <button class="btn btn-success rounded-pill px-4"><i class="bi bi-upload"></i> Uploader</button>
          </div>
        </form>

        <div class="scroll-zone">
          <?php if ($fichiers->num_rows > 0): ?>
            <?php while($f = $fichiers->fetch_assoc()): ?>
              <div class="block d-flex justify-content-between align-items-center mb-2">
                <div class="me-3">
                  <i class="bi bi-paperclip me-2"></i>
                  <a class="link-light text-decoration-none" href="<?= h($f['chemin']) ?>" target="_blank"><?= h($f['nom_fichier']) ?></a>
                </div>
                <small class="text-subtle"><?= h($f['date_upload']) ?></small>
              </div>
            <?php endwhile; ?>
          <?php else: ?>
            <div class="text-subtle text-center py-4">
              <i class="bi bi-folder-x fs-3 d-block mb-2"></i>
              Aucun fichier pour ce client.
            </div>
          <?php endif; ?>
        </div>
      </section>
    </div>
  </div>
</div>

<!-- FAB (mobile) -->
<div class="fab d-md-none">
  <button class="btn btn-gradient" id="btnQuickNote2"><i class="bi bi-plus-circle"></i> Note</button>
  <button class="btn btn-gradient" id="btnQuickTask2"><i class="bi bi-check2-circle"></i> Tâche</button>
</div>

<!-- Toast -->
<div class="position-fixed bottom-0 end-0 p-3" style="z-index:1100">
  <div id="toast" class="toast align-items-center text-bg-dark border-0" role="status" aria-live="polite" aria-atomic="true">
    <div class="d-flex">
      <div class="toast-body" id="toastMsg">Action effectuée</div>
      <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Fermer"></button>
    </div>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script>
(() => {
  // Tooltips
  const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
  tooltipTriggerList.map(el => new bootstrap.Tooltip(el));

  // Raccourcis clavier (G = retour)
  document.addEventListener('keydown', (e)=>{
    if(e.key.toLowerCase()==='g'){
      window.location.href='pipeline.php';
    }
  });

  // Boutons “Nouvelle note/tâche” => scroll vers le formulaire
  const scrollToEl = (el) => el && el.scrollIntoView({behavior:'smooth', block:'center'});
  document.getElementById('btnQuickNote')?.addEventListener('click', ()=>scrollToEl(document.getElementById('formNote')));
  document.getElementById('btnQuickTask')?.addEventListener('click', ()=>scrollToEl(document.getElementById('formTask')));
  document.getElementById('btnNoteTop')?.addEventListener('click', ()=>scrollToEl(document.getElementById('formNote')));
  document.getElementById('btnTaskTop')?.addEventListener('click', ()=>scrollToEl(document.getElementById('formTask')));
  document.getElementById('btnQuickNote2')?.addEventListener('click', ()=>scrollToEl(document.getElementById('formNote')));
  document.getElementById('btnQuickTask2')?.addEventListener('click', ()=>scrollToEl(document.getElementById('formTask')));

  // Feedback de soumission
  const toastEl = document.getElementById('toast');
  const toastMsg = document.getElementById('toastMsg');
  const toast = toastEl ? new bootstrap.Toast(toastEl) : null;

  document.querySelectorAll('form').forEach(f=>{
    f.addEventListener('submit', ()=>{
      const btn = f.querySelector('button[type="submit"], button:not([type])') || f.querySelector('button');
      if(btn){ btn.disabled = true; btn.innerHTML = '<i class="bi bi-hourglass-split"></i> Envoi…'; }
      if(toast){ toastMsg.textContent = 'Envoi en cours…'; toast.show(); }
    });
  });
})();
</script>
</body>
</html>








