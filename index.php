<?php
// PHP Error Mode (Entwicklungsumgebung)
error_reporting(E_ALL);
ini_set("display_errors", TRUE);

// Benötigte Klassen importieren
require_once 'repository/RepositoryInterface.php';
require_once 'repository/City.php';
require_once 'repository/Person.php';

// PDO MySQL Verbindung herstellen (Hier ggf. die Zugangsdaten anpassen)
$db = new PDO("mysql:host=localhost;dbname=tut_1", 'root', '', array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));

// PDO Error Mode auf Exception umstellen
$db->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );

// Person Repo erzeugen
$repo_person = new \WebdevProject\Repository\Person($db);
$error = false;

// Repo eine MySQL Abfrage absetzen lassen
// und Ergebnis in $result speichern
try
{
    $result = $repo_person->findAllWithCity();
}catch(\PDOException $e)
{
    $error = true;
}

// HTML Ausgabe (EVA einhalten!)
?>
<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
        <title>Datenbanken aber richtig</title>
    </head>
    <body>
        <?php if($error): ?>
            <p>Leider trat ein Fehler auf!</p>
        <?php else: ?>
            <table border="1">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Stadt</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if(count($result) > 0): ?>
                        <?php foreach($result as $entity): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($entity->id, ENT_QUOTES, 'UTF-8') ?></td>
                                <td><?php echo htmlspecialchars($entity->firstname, ENT_QUOTES, 'UTF-8') ?>&nbsp;<?php echo htmlspecialchars($entity->lastname, ENT_QUOTES, 'UTF-8') ?></td>
                                <td><?php echo htmlspecialchars($entity->city, ENT_QUOTES, 'UTF-8') ?></td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="3">Keine Einträge gefunden!</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        <?php endif; ?>
    </body>
</html>