<?php
namespace WebdevProject\Repository;

class Person implements RepositoryInterface
{
    /**
     * @var \PDO
     */
    protected $db;

    /**
     * @param \PDO $db
     */
    public function __construct(\PDO $db)
    {
        $this->db = $db;
    }

    /**
     * Gibt alle Personen der Tabelle zurück
     * @return array
     */
    public function findAll()
    {
        $stmt = $this->db->prepare("SELECT `id`, `firstname`, `lastname` FROM `Person`");
        $stmt->setFetchMode(\PDO::FETCH_OBJ);
        $stmt->execute();

        return $stmt->fetchAll();
    }

    /**
     * Gibt eine Person anhand der ID zurück
     *
     * @param $id
     * @return array|mixed
     * @throws \InvalidArgumentException
     */
    public function findById($id)
    {
        if(!is_int($id))
            throw new \InvalidArgumentException('First argument must be from type integer!');

        $stmt = $this->db->prepare("SELECT `id`, `firstname`, `lastname` FROM `Person` WHERE id = :id LIMIT 1");
        $stmt->setFetchMode(\PDO::FETCH_OBJ);
        $stmt->execute(array(
            ':id' => $id
        ));

        return $stmt->fetch();
    }

    /**
     * Gibt alle Personen der Tabelle zusammen mit
     * dem Wohnort zurück
     *
     * @return array
     */
    public function findAllWithCity()
    {
        $stmt = $this->db->prepare("SELECT p.id, p.firstname, p.lastname, ci.title as city FROM `Person` p JOIN `City` ci ON ci.id = p.city");
        $stmt->setFetchMode(\PDO::FETCH_OBJ);
        $stmt->execute();

        return $stmt->fetchAll();
    }

    /**
     * Löscht eine Person anhand der ID
     *
     * @param $id
     * @return bool
     * @throws \InvalidArgumentException
     */
    public function deleteById($id)
    {
        if(!is_int($id))
            throw new \InvalidArgumentException('First argument must be from type integer!');

        $stmt = $this->db->prepare("DELETE FROM `Person` WHERE `id` = :id LIMIT 1");
        $stmt->execute(array(
            ':id' => $id
        ));

        if($stmt->rowCount() == 1)
            return true;

        return false;
    }

}
