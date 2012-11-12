<?php
namespace WebdevProject\Repository;

class City implements RepositoryInterface
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
     * Gibt alle Städte der Tabelle zurück
     *
     * @return array
     */
    public function findAll()
    {
        $stmt = $this->db->prepare("SELECT `id`, `name` FROM `City`");
        $stmt->setFetchMode(\PDO::FETCH_OBJ);
        $stmt->execute();

        return $stmt->fetchAll();
    }

    /**
     * Gibt eine Stadt anhand der ID zurück
     *
     * @param $id
     * @return null|array
     * @throws \InvalidArgumentException
     */
    public function findById($id)
    {
        if(!is_int($id))
            throw new \InvalidArgumentException('First argument must be from type integer!');

        $stmt = $this->db->prepare("SELECT `id`, `name` FROM `City` WHERE `id` = :id LIMIT 1");
        $stmt->setFetchMode(\PDO::FETCH_OBJ);
        $stmt->execute(array(
            ':id' => $id
        ));

        return $stmt->fetch();
    }

    /**
     * Löscht eine Stadt anhand der ID
     *
     * @param $id
     * @return bool
     * @throws \InvalidArgumentException
     */
    public function deleteById($id)
    {
        if(!is_int($id))
            throw new \InvalidArgumentException('First argument must be from type integer!');

        $stmt = $this->db->prepare("DELETE FROM `City` WHERE `id` = :id LIMIT 1");
        $stmt->execute(array(
            ':id' => $id
        ));

        if($stmt->rowCount() == 1)
            return true;

        return false;
    }
}