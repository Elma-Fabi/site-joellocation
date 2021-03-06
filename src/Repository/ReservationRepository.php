<?php

namespace App\Repository;

use DateTime;
use DateTimeZone;
use App\Entity\Reservation;
use App\Service\DateHelper;
use App\Repository\UserRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Validator\Constraints\Date;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

/**
 * @method Reservation|null find($id, $lockMode = null, $lockVersion = null)
 * @method Reservation|null findOneBy(array $criteria, array $orderBy = null)
 * @method Reservation[]    findAll()
 * @method Reservation[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ReservationRepository extends ServiceEntityRepository
{
    private $userRepo;
    private $dateHelper;
    public function __construct(ManagerRegistry $registry, UserRepository $userRepo, DateHelper $dateHelper)
    {

        $this->userRepo = $userRepo;
        $this->dateHelper = $dateHelper;

        parent::__construct($registry, Reservation::class);
    }

    /**
     * @return Reservation[] Returns an array of Reservation objects
     */
    public function findReservationEffectuers($client, $date)
    {
        return $this->createQueryBuilder('r')
            ->where('r.client = :client AND r.date_fin < :date')
            ->andWhere('r.code_reservation = :code')
            ->setParameter('client', $client)
            ->setParameter('date', $date)
            ->setParameter('code', 'devisTransformÃ©')
            ->orderBy('r.date_fin', 'DESC')
            ->getQuery()
            ->getResult();
    }

    /**
     * @return Reservation[] Returns an array of Reservation objects
     */
    public function findReservationsTermines()
    {
        return $this->createQueryBuilder('r')
            ->andWhere('r.date_fin < :date')
            ->andWhere('r.code_reservation = :code')
            ->setParameter('date', $this->dateHelper->dateNow())
            ->setParameter('code', 'devisTransformÃ©')
            ->orderBy('r.date_fin', 'DESC')
            ->getQuery()
            ->getResult();
    }

    /**
     * @return Reservation[] Returns an array of Reservation objects
     */
    public function findReservationEncours($client, $date)
    {
        return $this->createQueryBuilder('r')
            ->andWhere('r.client = :client AND r.date_fin > :date AND r.date_debut < :date')
            ->andWhere('r.code_reservation = :code')
            ->setParameter('client', $client)
            ->setParameter('date', $date)
            ->setParameter('code', 'devisTransformÃ©')
            ->orderBy('r.date_debut', 'DESC')
            ->getQuery()
            ->getResult();
    }

    /**
     * @return Reservation[] Returns an array of Reservation objects
     */
    public function findReservationEnAttente($client, $date)
    {
        return $this->createQueryBuilder('r')
            ->andWhere('r.client = :client AND r.date_debut > :date')
            ->andWhere('r.code_reservation = :code')
            ->setParameter('client', $client)
            ->setParameter('date', $date)
            ->setParameter('code', 'devisTransformÃ©')
            ->orderBy('r.date_debut', 'DESC')
            ->getQuery()
            ->getResult();
    }

    /**
     * @return Reservation[] Returns an array of Reservation objects
     */
    public function findReservationsAttenteDateDebut($client)
    {

        return $this->createQueryBuilder('r')
            ->andWhere('r.client = :client AND r.date_debut > :date')
            ->andWhere('r.code_reservation = :code')
            ->setParameter('client', $client)
            ->setParameter('date', $this->dateHelper->dateNow())
            ->setParameter('code', 'devisTransformÃ©')
            ->orderBy('r.id', 'DESC')
            ->getQuery()
            ->getResult();
    }

    /**
     * @return Reservation[] Returns an array of Reservation objects
     */
    public function findReservationIncludeDate($date)
    {
        return $this->createQueryBuilder('r')
            ->where(' r.date_fin >= :date')
            ->andWhere('r.date_debut <= :date')
            ->andWhere('r.code_reservation = :code')
            ->setParameter('code', 'devisTransformÃ©')
            ->setParameter('date', $date)
            ->getQuery()
            ->getResult();
    }

    /**
     * @return Reservation[] Returns an array of Reservation objects
     */
    public function findReservationExcludeDate($date)
    {
        return $this->createQueryBuilder('r')
            ->where(' r.date_fin < :date')
            ->orWhere('r.date_debut > :date')
            ->andWhere('r.code_reservation = :code')
            ->setParameter('code', 'devisTransformÃ©')
            ->setParameter('date', $date)
            ->getQuery()
            ->getResult();
    }

    /**
     * @return Reservation[] Returns an array of Reservation objects
     */
    public function findStopSales()
    {
        return $this->createQueryBuilder('r')
            ->andWhere(' r.code_reservation = :code')
            ->setParameter('code', 'stopSale')
            ->getQuery()
            ->getResult();
    }

    /**
     * @return Reservation[] Returns an array of Reservation objects
     */
    public function findReservationsSansStopSales()
    {
        return $this->createQueryBuilder('r')
            ->andWhere(' r.code_reservation != :code AND r.date_fin > :date')
            ->setParameter('code', 'stopSale')
            ->setParameter('date', $this->dateHelper->dateNow())
            ->orderBy('r.date_reservation', 'DESC')
            ->getQuery()
            ->getResult();
    }
    /**
     * @return Reservation[] Returns an array of Reservation objects
     */
    public function findReservationIncludeDates($dateDebut, $dateFin)
    {
        return $this->createQueryBuilder('r')
            ->where(' r.date_debut < :dateDebut AND r.date_fin > :dateDebut AND r.date_debut < :dateFin AND  r.date_fin < :dateFin ')
            ->orWhere(' r.date_debut > :dateDebut AND r.date_fin > :dateDebut AND r.date_debut < :dateFin AND  r.date_fin < :dateFin ')
            ->orWhere(' r.date_debut > :dateDebut AND r.date_fin < :dateDebut AND r.date_debut > :dateFin AND  r.date_fin < :dateFin ')
            ->orWhere(' r.date_debut < :dateDebut AND r.date_fin > :dateDebut AND r.date_debut < :dateFin AND  r.date_fin > :dateFin ')
            // ->andWhere(' r.date_fin > :dateFin AND r.date_debut < :dateFin')
            ->setParameter('dateDebut', $dateDebut)
            ->setParameter('dateFin', $dateFin)
            ->getQuery()
            ->getResult();
    }


    /**
     * @return Reservation[] Returns an array of Reservation objects
     */
    public function findReservationExludeDates($dateDebut, $dateFin)

    {
        return $this->createQueryBuilder('r')
            ->where('   :dateFin < r.date_debut  AND :dateDebut < r.date_debut ')
            ->orWhere('r.date_fin < :dateDebut AND r.date_debut < :dateDebut ')
            ->setParameter('dateDebut', $dateDebut)
            ->setParameter('dateFin', $dateFin)
            ->getQuery()
            ->getResult();
    }


    /**
     * @return Reservation[] Returns an array of Reservation objects
     * 
     */
    public function findLastReservations($vehicule, $date)
    {
        return $this->createQueryBuilder('r')
            ->andWhere(' r.vehicule = :vehicule')
            ->andWhere('r.date_fin < :date')
            ->andWhere(' r.code_reservation != :code')
            ->setParameter('vehicule', $vehicule)
            ->setParameter('code', 'stopSale')
            ->setParameter('date', $date)
            ->getQuery()
            ->getResult();
    }

    /**
     * @return Reservation[] Returns an array of Reservation objects
     * 
     */
    public function findLastReservationsV($vehicule)
    {
        return $this->createQueryBuilder('r')
            ->andWhere(' r.vehicule = :vehicule')
            ->setParameter('vehicule', $vehicule)
            ->getQuery()
            ->getResult();
    }


    /**
     * @return Reservation[] Returns an array of Reservation objects
     */
    public function findNextReservations($vehicule, $date)
    {
        return $this->createQueryBuilder('r')
            ->andWhere(' r.vehicule = :vehicule')
            ->andWhere('r.date_debut > :date')
            ->andWhere(' r.code_reservation != :code')
            ->setParameter('vehicule', $vehicule)
            ->setParameter('code', 'stopSale')
            ->setParameter('date', $date)
            ->getQuery()
            ->getResult();
    }


    /**
     * @return Reservation[] Returns an array of Reservation objects
     */
    public function findByName($keyword)
    {
        return $this->createQueryBuilder('r')
            ->andWhere(' r.client.nom LIKE :keyword')
            ->setParameter('keyword', $keyword)
            ->getQuery()
            ->getResult();
    }


    /**
     * @return Reservation[] Returns an array of Reservation objects
     */
    public function findPlanningJournaliers($date)
    {
        $date = $date->format('Y-m-d');
        return $this->createQueryBuilder('r')
            ->where("DATE_FORMAT(r.date_debut,'%Y-%m-%d') = :date AND r.code_reservation != :code ")
            ->orWhere("DATE_FORMAT(r.date_fin,'%Y-%m-%d') = :date AND r.code_reservation != :code")
            ->setParameter('date', $date)
            ->setParameter('code', 'stopSale')
            ->getQuery()
            ->getResult();
    }

    /**
     * @return Reservation[] Returns an array of Reservation objects
     */
    public function findRechercheIM($vehicule, $date)
    {
        return $this->createQueryBuilder('r')
            ->where(' r.date_fin > :date AND r.date_debut < :date')
            ->andWhere("r.vehicule = :vehicule")
            ->setParameter('date', $date)
            ->setParameter('vehicule', $vehicule)
            ->getQuery()
            ->getResult();
    }


    /**
     * @return Reservation[] Returns an array of Reservation objects
     */
    public function findDateDepartIncludedBetwn($debutPeriode, $finPeriode, $vehicule, $typeTarif)
    {

        $superAdmin = $this->userRepo->findSuperAdmin();

        if ($vehicule == null && $typeTarif == null) {
            return $this->createQueryBuilder('r')
                ->where(' :debutPeriode < r.date_debut AND r.date_debut < :finPeriode AND r.client != :client')
                ->setParameter('debutPeriode', $debutPeriode)
                ->setParameter('finPeriode', $finPeriode)
                ->setParameter('client', $superAdmin)
                ->getQuery()
                ->getResult();
        } else {
            if ($vehicule != null && $typeTarif == null) {
                return $this->createQueryBuilder('r')
                    ->where(' :debutPeriode < r.date_debut AND r.date_debut < :finPeriode AND r.vehicule = :vehicule AND r.client != :client')
                    ->setParameter('debutPeriode', $debutPeriode)
                    ->setParameter('finPeriode', $finPeriode)
                    ->setParameter('vehicule', $vehicule)
                    ->setParameter('client', $superAdmin)
                    ->getQuery()
                    ->getResult();
            }
            if ($vehicule == null && $typeTarif != null) {
                return $this->createQueryBuilder('r')
                    ->where(' :debutPeriode < r.date_debut AND r.date_debut < :finPeriode AND r.reference LIKE :typeTarif AND r.client != :client')
                    ->setParameter('debutPeriode', $debutPeriode)
                    ->setParameter('finPeriode', $finPeriode)
                    ->setParameter('typeTarif', $typeTarif)
                    ->setParameter('client', $superAdmin)
                    ->getQuery()
                    ->getResult();
            }
            if ($vehicule != null && $typeTarif != null) {
                return $this->createQueryBuilder('r')
                    ->where(' :debutPeriode < r.date_debut AND r.date_debut < :finPeriode AND r.reference LIKE :typeTarif AND r.vehicule = :vehicule AND r.client != :client')
                    ->setParameter('debutPeriode', $debutPeriode)
                    ->setParameter('finPeriode', $finPeriode)
                    ->setParameter('typeTarif', $typeTarif)
                    ->setParameter('vehicule', $vehicule)
                    ->setParameter('client', $superAdmin)
                    ->getQuery()
                    ->getResult();
            }
        }
    }


    /**
     * @return Reservation[] Returns an array of Reservation objects
     */
    public function findDateRetourIncludedBetwn($debutPeriode, $finPeriode, $vehicule, $typeTarif)
    {
        $superAdmin = $this->userRepo->findSuperAdmin();

        if ($vehicule == null && $typeTarif == null) {
            return $this->createQueryBuilder('r')
                ->where(' :debutPeriode < r.date_fin AND r.date_fin < :finPeriode AND r.client != :client')
                ->setParameter('debutPeriode', $debutPeriode)
                ->setParameter('finPeriode', $finPeriode)
                ->setParameter('client', $superAdmin)
                ->getQuery()
                ->getResult();
        } else {
            if ($vehicule != null && $typeTarif == null) {
                return $this->createQueryBuilder('r')
                    ->where(' :debutPeriode < r.date_fin AND r.date_fin < :finPeriode AND r.vehicule = :vehicule AND r.client != :client')
                    ->setParameter('debutPeriode', $debutPeriode)
                    ->setParameter('finPeriode', $finPeriode)
                    ->setParameter('vehicule', $vehicule)
                    ->setParameter('client', $superAdmin)
                    ->getQuery()
                    ->getResult();
            }
            if ($vehicule == null && $typeTarif != null) {
                return $this->createQueryBuilder('r')
                    ->where(' :debutPeriode < r.date_fin AND r.date_fin < :finPeriode AND r.reference LIKE :typeTarif AND r.client != :client')
                    ->setParameter('debutPeriode', $debutPeriode)
                    ->setParameter('finPeriode', $finPeriode)
                    ->setParameter('typeTarif', $typeTarif)
                    ->setParameter('client', $superAdmin)
                    ->getQuery()
                    ->getResult();
            }
            if ($vehicule != null && $typeTarif != null) {
                return $this->createQueryBuilder('r')
                    ->where(' :debutPeriode < r.date_fin AND r.date_fin < :finPeriode AND r.reference LIKE :typeTarif AND r.vehicule = :vehicule AND r.client != :client')
                    ->setParameter('debutPeriode', $debutPeriode)
                    ->setParameter('finPeriode', $finPeriode)
                    ->setParameter('typeTarif', $typeTarif)
                    ->setParameter('vehicule', $vehicule)
                    ->setParameter('client', $superAdmin)
                    ->getQuery()
                    ->getResult();
            }
        }
    }


    /**
     * @return Reservation[] Returns an array of Reservation objects
     */
    public function findDateResIncludedBetwn($debutPeriode, $finPeriode, $vehicule, $typeTarif)
    {
        $superAdmin = $this->userRepo->findSuperAdmin();

        if ($typeTarif == 'WEB') {
            $typeTarif = 'WEB%';
        } else {
            $typeTarif = 'CPT%';
        }

        if ($vehicule == null && $typeTarif == null) {
            return $this->createQueryBuilder('r')
                ->where(' :debutPeriode < r.date_reservation AND r.date_reservation < :finPeriode AND r.client != :client')
                ->setParameter('debutPeriode', $debutPeriode)
                ->setParameter('finPeriode', $finPeriode)
                ->setParameter('client', $superAdmin)
                ->getQuery()
                ->getResult();
        } else {
            if ($vehicule != null && $typeTarif == null) {
                return $this->createQueryBuilder('r')
                    ->where(' :debutPeriode < r.date_reservation AND r.date_reservation < :finPeriode AND r.vehicule = :vehicule AND r.client != :client')
                    ->setParameter('debutPeriode', $debutPeriode)
                    ->setParameter('finPeriode', $finPeriode)
                    ->setParameter('vehicule', $vehicule)
                    ->setParameter('client', $superAdmin)
                    ->getQuery()
                    ->getResult();
            }
            if ($vehicule == null && $typeTarif != null) {
                return $this->createQueryBuilder('r')
                    ->where(' :debutPeriode < r.date_reservation AND r.date_reservation < :finPeriode AND r.reference LIKE :typeTarif AND r.client != :client')
                    ->setParameter('debutPeriode', $debutPeriode)
                    ->setParameter('finPeriode', $finPeriode)
                    ->setParameter('typeTarif', $typeTarif)
                    ->setParameter('client', $superAdmin)
                    ->getQuery()
                    ->getResult();
            }
            if ($vehicule != null && $typeTarif != null) {
                return $this->createQueryBuilder('r')
                    ->where(' :debutPeriode < r.date_reservation AND r.date_reservation < :finPeriode AND r.reference LIKE :typeTarif AND r.vehicule = :vehicule AND r.client != :client')
                    ->setParameter('debutPeriode', $debutPeriode)
                    ->setParameter('finPeriode', $finPeriode)
                    ->setParameter('typeTarif', $typeTarif)
                    ->setParameter('vehicule', $vehicule)
                    ->setParameter('client', $superAdmin)
                    ->getQuery()
                    ->getResult();
            }
        }
    }



    // /**
    //  * @return Reservation[] Returns an array of Reservation objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('r')
            ->andWhere('r.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('r.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Reservation
    {
        return $this->createQueryBuilder('r')
            ->andWhere('r.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
