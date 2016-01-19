<?php

/*
 * This file is part of the Lug package.
 *
 * (c) Eric GELOEN <geloen.eric@gmail.com>
 *
 * For the full copyright and license information, please read the LICENSE
 * file that was distributed with this source code.
 */

namespace Lug\Component\Resource\Model;

/**
 * @author GeLo <geloen.eric@gmail.com>
 */
interface ResourceInterface
{
    const DRIVER_DOCTRINE_ORM = 'doctrine/orm';
    const DRIVER_DOCTRINE_MONGODB = 'doctrine/mongodb';

    const DRIVER_MAPPING_FORMAT_ANNOTATION = 'annotation';
    const DRIVER_MAPPING_FORMAT_XML = 'xml';
    const DRIVER_MAPPING_FORMAT_YAML = 'yaml';

    /**
     * @return string
     */
    public function getName();

    /**
     * @return string
     */
    public function getDriver();

    /**
     * @param string $driver
     */
    public function setDriver($driver);

    /**
     * @return string
     */
    public function getDriverMappingPath();

    /**
     * @param string $driverMappingPath
     */
    public function setDriverMappingPath($driverMappingPath);

    /**
     * @return string
     */
    public function getDriverMappingFormat();

    /**
     * @param string $driverMappingFormat
     */
    public function setDriverMappingFormat($driverMappingFormat);

    /**
     * @return string
     */
    public function getDriverManager();

    /**
     * @param string $driverManager
     */
    public function setDriverManager($driverManager);

    /**
     * @return string[]
     */
    public function getInterfaces();

    /**
     * @return string
     */
    public function getModel();

    /**
     * @param string $model
     */
    public function setModel($model);

    /**
     * @return string
     */
    public function getController();

    /**
     * @param string $controller
     */
    public function setController($controller);

    /**
     * @return string
     */
    public function getFactory();

    /**
     * @param string $factory
     */
    public function setFactory($factory);

    /**
     * @return string
     */
    public function getRepository();

    /**
     * @param string $repository
     */
    public function setRepository($repository);

    /**
     * @return string
     */
    public function getDomainManager();

    /**
     * @param string $domainManager
     */
    public function setDomainManager($domainManager);

    /**
     * @return string
     */
    public function getForm();

    /**
     * @param string $form
     */
    public function setForm($form);

    /**
     * @return string
     */
    public function getChoiceForm();

    /**
     * @param string $choiceForm
     */
    public function setChoiceForm($choiceForm);

    /**
     * @return string
     */
    public function getIdPropertyPath();

    /**
     * @param string $idPropertyPath
     */
    public function setIdPropertyPath($idPropertyPath);

    /**
     * @return string
     */
    public function getLabelPropertyPath();

    /**
     * @param string $labelPropertyPath
     */
    public function setLabelPropertyPath($labelPropertyPath);

    /**
     * @return ResourceInterface|null
     */
    public function getTranslation();
}
