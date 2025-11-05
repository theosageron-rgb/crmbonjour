<!DOCTYPE html>
<html>
<body>
  <form action="upload_fichier.php" method="POST" enctype="multipart/form-data">
    <input type="hidden" name="fiche_id" value="1">
    <input type="file" name="fichier">
    <button type="submit">Tester l’upload</button>
  </form>
</body>
</html>
