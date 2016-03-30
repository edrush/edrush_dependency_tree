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
    protected $version;

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
