<?php
class Creer_contactModel {
    private $conn;

    public function __construct($conn) {
        $this->conn = $conn;
    }

    public function ajouterFiche(array $data) {
        // Sécurité basique
        if (empty($data['nom']) || empty($data['prenom']) || empty($data['email'])) {
            return false;
        }

        $stmt = $this->conn->prepare("
            INSERT INTO fiches (prenom, nom, email, profession, statut, telephone, societe, origine, date_creation)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, NOW())
        ");
        $stmt->bind_param(
            "ssssssss",
            $data['prenom'],
            $data['nom'],
            $data['email'],
            $data['profession'],
            $data['statut'],
            $data['telephone'],
            $data['societe'],
            $data['origine']
        );

        if ($stmt->execute()) {
            $id = $this->conn->insert_id;

            // Notes (optionnelles)
            if (!empty($data['notes'])) {
                $stmtNote = $this->conn->prepare("
                    INSERT INTO notes (fiche_id, contenu, date_creation)
                    VALUES (?, ?, NOW())
                ");
                $stmtNote->bind_param("is", $id, $data['notes']);
                $stmtNote->execute();
                $stmtNote->close();
            }

            return $id;
        }

        return false;
    }
}
