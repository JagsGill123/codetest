<?php


namespace App\Common\Repository;

use App\Common\API\ApiManager;
use App\Common\Entity\AbstractEntity;
use Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\DecodingExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;

/**
 * @method AbstractEntity|null find($id, $lockMode = null, $lockVersion = null)
 * @method AbstractEntity|null findOneBy(array $criteria, array $orderBy = null)
 * @method AbstractEntity[]    findAll()
 * @method AbstractEntity[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
abstract class AbstractAPIRepository extends AbstractRepository
{
    /**
     * @var string
     */
    protected $apiKey = ApiManager::API_COUNTRY;

    /**
     * @var string
     */
    protected $apiPrimaryKey = 'name';

    /**
     * @var array
     */
    protected $apiSearchKeys = [];

    /**
     * @return array
     */
    public function getApiSearchKeys(): array
    {
        return $this->apiSearchKeys;
    }

    /**
     * @param array $data
     * @return array
     * @throws DecodingExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws ServerExceptionInterface
     * @throws TransportExceptionInterface
     * @throws \Doctrine\ORM\ORMException
     */
    protected function findOrFetchAPIData(array $data = [])
    {
        $apiData = [];

        // retrieve data
        foreach ($data as $key => $value) {
            $value = is_array($value) ? $value : [$value];
            foreach ($value as $val){
                $values = $this->fetchAPIDataForField($key, $val);
                foreach ($values as $v) {
                    if (!array_key_exists($v[$this->apiPrimaryKey], $apiData)) {
                        $apiData[$v[$this->apiPrimaryKey]] = $v;
                    }
                }
            }
        }

        return $this->storeEntitiesFromApiData($apiData);
    }


    /**
     * @param $key
     * @param $value
     * @return array
     * @throws DecodingExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws ServerExceptionInterface
     * @throws TransportExceptionInterface
     */
    protected function fetchAPIDataForField($key, $value)
    {
        if (!in_array($key, $this->getApiSearchKeys()) || !$value) {
            return [];
        }

        try {
            $data = ApiManager::getInstance()
                ->getApi($this->apiKey)
                ->fetchData($key, $value);
        } catch (ClientExceptionInterface $e) {
            $data = [];
        }

        return $data;
    }

    /**
     * @param array $data
     * @return array
     * @throws \Doctrine\ORM\ORMException
     */
    abstract protected function storeEntitiesFromApiData($data = []);
}
