<?php

namespace App\Repository;

use App\Common\Repository\AbstractAPIRepository;
use App\Entity\Country;
use App\Entity\CountryCode;
use App\Entity\Currency;
use App\Entity\DialingCode;
use App\Entity\Language;
use App\Entity\Request\CountrySearchRequest;
use App\Entity\TimeZone;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Query\Parameter;

/**
 * @method Country|null find($id, $lockMode = null, $lockVersion = null)
 * @method Country|null findOneBy(array $criteria, array $orderBy = null)
 * @method Country[]    findAll()
 * @method Country[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CountryRepository extends AbstractAPIRepository
{
    /**
     * @var array
     */
    protected $apiSearchKeys = [
        'name',
        'countryCodes',
        'capital',
        'currency',
        'language',
    ];

    /**
     * @return string
     */
    protected function getEntityClass()
    {
        return Country::class;
    }

    /**
     * @param CountrySearchRequest $countrySearchRequest
     * @return mixed
     * @throws \Doctrine\ORM\ORMException
     * @throws \Symfony\Contracts\HttpClient\Exception\DecodingExceptionInterface
     * @throws \Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface
     * @throws \Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface
     * @throws \Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface
     */
    public function search(CountrySearchRequest $countrySearchRequest)
    {
        $queryBuilder = $this->createQueryBuilder('c')
            ->leftJoin('c.countryCode', 'countryCode')
            ->leftJoin('c.timezone', 'timezone')
            ->leftJoin('c.currencies', 'currencies')
            ->leftJoin('c.languages', 'languages')
            ->orderBy('c.name', 'ASC')
            ->groupBy('c.id');

        $parameters = new ArrayCollection();


        // Country Name
        $name = $countrySearchRequest->name;
        if ($name) {
            $queryBuilder->andWhere('c.name LIKE :param_country_name');
            $parameters->add(
                new Parameter(
                    'param_country_name',
                    '%' . $name . '%',
                    \Doctrine\DBAL\Types\Type::STRING
                )
            );
        }


        //  Country Code (one or more)
        $countryCodes = $countrySearchRequest->getCountryCodesAttribute();
        if ($countryCodes) {
            $whereParts = [];
            for ($i = 0; $i < count($countryCodes); $i++) {
                $whereParts[] = 'countryCode.code = :param_country_code_' . $i;
                $parameters->add(
                    new Parameter(
                        'param_country_code_' . $i,
                        $countryCodes[$i],
                        \Doctrine\DBAL\Types\Type::STRING
                    )
                );
            }
            $queryBuilder->andWhere(implode(' OR ', $whereParts));
        }

        //  Capital City
        $capital = $countrySearchRequest->capital;
        if ($capital) {
            $queryBuilder->orWhere('c.capital = :param_country_capital');
            $parameters->add(
                new Parameter(
                    'param_country_capital',
                    $capital,
                    \Doctrine\DBAL\Types\Type::STRING
                )
            );
        }

        //  Currency Code
        $currencyCodes = $countrySearchRequest->getCurrencyCodesAttribute();
        if ($currencyCodes) {
            $whereParts = [];
            for ($i = 0; $i < count($currencyCodes); $i++) {
                $whereParts[] = 'currencies.code = :param_currency_code_' . $i;

                $parameters->add(
                    new Parameter(
                        'param_currency_code_' . $i,
                        $currencyCodes[$i],
                        \Doctrine\DBAL\Types\Type::STRING
                    )
                );
            }
            $queryBuilder->andWhere(implode(' OR ', $whereParts));

        }

        // Language
        $languages = $countrySearchRequest->getLanguagesAttribute();
        if ($languages) {
            $whereParts = [];
            for ($i = 0; $i < count($languages); $i++) {
                $whereParts[] = 'languages.name = :param_language_' . $i;
                $parameters->add(
                    new Parameter(
                        'param_language_' . $i,
                        $languages[$i],
                        \Doctrine\DBAL\Types\Type::STRING
                    )
                );
            }
            $queryBuilder->andWhere(implode(' OR ', $whereParts));
        }


        //
        $queryBuilder->setParameters($parameters);
        $query = $queryBuilder->getQuery();
        $result = $query->getResult();

        if (!$result) {
            // store results for each parameter separately
            $data = $this->findOrFetchAPIData([
                'name' => $name,
                'countryCodes' => $countryCodes,
                'capital' => $capital,
                'currency' => $currencyCodes,
                'language' => $languages,
            ]);

            // re run search with newly found countries
            if ($data) {
                return $query->getResult();
            }
        }

        return $result;
    }

    /**
     * @param array $data
     * @return array
     * @throws \Doctrine\ORM\ORMException
     */
    protected function storeEntitiesFromApiData($data = [])
    {
        $values = [];
        $entityManager = $this->getEntityManager();
        /** @var CountryCodeRepository $countryCodeRepository */
        $countryCodeRepository = $entityManager->getRepository(CountryCode::class);

        /** @var DialingCodeRepository $dialingCodeRepository */
        $dialingCodeRepository = $entityManager->getRepository(DialingCode::class);

        /** @var CurrencyRepository $currencyRepository */
        $currencyRepository = $entityManager->getRepository(Currency::class);

        /** @var LanguageRepository $languageRepository */
        $languageRepository = $entityManager->getRepository(Language::class);

        /** @var TimeZoneRepository $timeZoneRepository */
        $timeZoneRepository = $entityManager->getRepository(TimeZone::class);

        foreach ($data as $countryApiData) {
            // FIND COUNTRY
            $countryEntity = $this->findOneBy([
                'name' => $countryApiData['name']
            ]);

            // IF COUNTRY NOT FOUND
            if (!$countryEntity) {
                $countryEntity = new Country();

                // Country Details
                $countryEntity->setName($countryApiData['name']);
                $countryEntity->setRegion($countryApiData['region']);
                $countryEntity->setCapital($countryApiData['capital']);
                $countryEntity->setFlag($countryApiData['flag']);

                // Country Relations
                $entity = null;

                // International Dialing Code
                foreach ($countryApiData['callingCodes'] as $val) {
                    // find one
                    $entity = $dialingCodeRepository->findOneBy([
                        'code' => $val
                    ]);

                    // if none create
                    if (!$entity) {
                        $entity = new DialingCode();
                        $entity->setCode($val ?? '');
                        $entityManager->persist($entity);
                        $entityManager->flush();
                    }

                    $countryEntity->addDialingCode($entity);
                }

                // Timezone
                foreach ($countryApiData['timezones'] as $val) {
                    // find one
                    $entity = $timeZoneRepository->findOneBy([
                        'name' => $val
                    ]);

                    // if none create
                    if (!$entity) {
                        $entity = new TimeZone();
                        $entity->setName($val ?? '');
                        $entityManager->persist($entity);
                        $entityManager->flush();
                    }

                    $countryEntity->addTimezone($entity);
                }

                // Currencies
                foreach ($countryApiData['currencies'] as $val) {
                    // find one
                    $entity = $currencyRepository->findOneBy([
                        'code' => $val['code'],
                        'symbol' => $val['name']
                    ]);

                    // if none create
                    if (!$entity) {
                        $entity = new Currency();
                        $entity->setCode($val['code'] ?? '');
                        $entity->setSymbol($val['name'] ?? '');
                        $entityManager->persist($entity);
                        $entityManager->flush();
                    }

                    $countryEntity->addCurrency($entity);
                }

                // Language
                foreach ($countryApiData['languages'] as $val) {
                    // find one
                    $entity = $languageRepository->findOneBy([
                        'code' => $val['iso639_1'] ?? '',
                        'name' => $val['name']
                    ]);

                    // if none create
                    if (!$entity) {
                        $entity = new Language();
                        $entity->setCode($val['iso639_1'] ?? '');
                        $entity->setName($val['name'] ?? '');
                        $entityManager->persist($entity);
                        $entityManager->flush();
                    }

                    $countryEntity->addLanguage($entity);
                }

                // COUNTRY CODES
                $countryCodes = [
                    $countryApiData['alpha2Code'],
                    $countryApiData['alpha3Code'],
                ];

                foreach ($countryCodes as $val) {
                    // find one
                    $entity = $countryCodeRepository->findOneBy([
                        'code' => $val,
                    ]);

                    // if none create
                    if (!$entity) {
                        $entity = new CountryCode();
                        $entity->setCode($val);
                        $entityManager->persist($entity);
                        $entityManager->flush();
                    }

                    $countryEntity->addCountryCode($entity);
                }

                $entityManager->persist($countryEntity);
                $entityManager->flush();
            }

            $values[] = $countryEntity;
        }
        return $values;
    }
}
