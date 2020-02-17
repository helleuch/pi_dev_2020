<?php


namespace MagasinBundle\Service;

use Doctrine\ORM\EntityManagerInterface;
use MagasinBundle\Entity\Magasin;
use ProduitBundle\Entity\Produit;
use UserBundle\Entity\User;

class MagasinService
{
    private $em;

    public function __construct( EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    public function refreshMagasin($id)
    {
        $magasin= $this->em->getRepository(Magasin::class)->find($id);
        $magasin->setTailleStock($this->calculateStock($id));
        $this->em->persist($magasin);
        $this->em->flush();

        return ($magasin);
    }

    public function calculateStock($id)
    {
        $inventaire = $this->em->getRepository(Produit::class)->findBy(array("id_magasin"=>$id));
        return sizeof($inventaire);
    }

    public function calculateStockByCategory($id, $category)
    {
        //TODO: Implémenter les catégories correctement
        $inventaire = $this->em->getRepository(Produit::class)->findBy(array("id_magasin"=>$id));
        return sizeof($inventaire);
    }

    public function addManager($id_maggasin, $id_vendeur)
    {
        $magasin= $this->em->getRepository(Magasin::class)->find($id_maggasin);
        if($id_vendeur != null)
        {
            $vendeur =  $this->em->getRepository(User::class)->find($id_vendeur);
            $vendeur->setIdMagasin($magasin);
            $this->em->persist($vendeur);
            $this->em->flush();
        }
    }

    public function value($id)
    {
        //TODO Faire le service value product
        $result = 0;
        $magasin= $this->em->getRepository(Magasin::class)->find($id);
        return $result;
    }

    public function createDefaultMagasin($id_user)
    {
        $mg = new Magasin();
        $mg->setTailleStock(0);
        $mg->setMatriculeFiscal(0);
        return $mg;
    }

}