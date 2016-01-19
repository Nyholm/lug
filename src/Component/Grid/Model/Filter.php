<?php

/*
 * This file is part of the Lug package.
 *
 * (c) Eric GELOEN <geloen.eric@gmail.com>
 *
 * For the full copyright and license information, please read the LICENSE
 * file that was distributed with this source code.
 */

namespace Lug\Component\Grid\Model;

use Lug\Component\Grid\Exception\OptionNotFoundException;

/**
 * @author GeLo <geloen.eric@gmail.com>
 */
class Filter implements FilterInterface
{
    /**
     * @var string
     */
    private $name;

    /**
     * @var string
     */
    private $label;

    /**
     * @var string
     */
    private $type;

    /**
     * @var mixed[]
     */
    private $options;

    /**
     * @param string  $name
     * @param string  $label
     * @param string  $type
     * @param mixed[] $options
     */
    public function __construct($name, $label, $type, array $options = [])
    {
        $this->name = $name;
        $this->label = $label;
        $this->type = $type;
        $this->options = $options;
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * {@inheritdoc}
     */
    public function getLabel()
    {
        return $this->label;
    }

    /**
     * {@inheritdoc}
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * {@inheritdoc}
     */
    public function hasOptions()
    {
        return !empty($this->options);
    }

    /**
     * {@inheritdoc}
     */
    public function getOptions()
    {
        return $this->options;
    }

    /**
     * {@inheritdoc}
     */
    public function hasOption($name)
    {
        return isset($this->options[$name]);
    }

    /**
     * {@inheritdoc}
     */
    public function getOption($name)
    {
        if (!$this->hasOption($name)) {
            throw new OptionNotFoundException(sprintf('The filter option "%s" could not be found.', $name));
        }

        return $this->options[$name];
    }
}
