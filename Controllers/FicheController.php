<?php
class FicheController {
    public function index() {
        include __DIR__ . '/../Config/config.php';
        require_once __DIR__ . '/../Models/FicheModel.php';

        if (!isset($_GET['id'])) {
            die("Aucun prospect sélectionné.");
        }

        $id = intval($_GET['id']);
        $model = new FicheModel($conn);

        $fiche = $model->getFicheById($id);
        if (!$fiche) {
    echo "<pre>Debug: id=$id, base={$db}</pre>";
    $result = $conn->query("SHOW TABLES");
    echo "<pre>Tables disponibles:\n";
    while ($t = $result->fetch_array()) {
        echo "- {$t[0]}\n";
    }
    echo "</pre>";
    die("Fiche introuvable (debug)");
}
        if (!$fiche) {
            die("Fiche introuvable.");
        }

        $notes = $model->getNotes($id);
        $fichiers = $model->getFichiers($id);
        $taches = $model->getTaches($id);

        // Fonctions utilitaires (à déplacer plus tard dans un helper global)
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

        // On charge la vue
        require __DIR__ . '/../Views/fiche.view.php';
    }
}
