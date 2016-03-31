<?php
namespace EdRush\EdrushDependencyTree\Domain\Model;

class Constraint
{
    /**
     * @var Extension
     */
    protected $extension;

    /**
     * @var string
     */
    protected $version = null;

    public function __toString()
    {
        $string = $this->extension->getName() . ' (<i>' . $this->extension->getKey() . '</i>';
        if (!is_null($this->version) && '' != trim($this->version)) {
            $string .= ', ' . trim($this->version);
        }
        $string .= ')';

        return $string;
    }

    /**
     * @return Extension
     */
    public function getExtension()
    {
        return $this->extension;
    }

    /**
     * @param Extension $extension
     * @return Constraint
     */
    public function setExtension($extension)
    {
        $this->extension = $extension;
        return $this;
    }

    /**
     * @return string
     */
    public function getVersion()
    {
        return $this->version;
    }

    /**
     * @param string $version
     * @return Constraint
     */
    public function setVersion($version)
    {
        $this->version = $version;
        return $this;
    }

}
