<?php namespace WebdevProject\Repository;

interface RepositoryInterface
{
    /**
     * Gibt alle Datensätze zurück
     * @return array
     */
    public function findAll();

    /**
     * Gibt einen Datensatz anhand
     * der ID zurück
     *
     * @param $id
     * @return array
     */
    public function findById($id);

    /**
     * Löscht einen Datensatz anhand
     * der ID
     *
     * @param $id
     * @return bool
     */
    public function deleteById($id);
}