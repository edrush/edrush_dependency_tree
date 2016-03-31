<?php
namespace EdRush\EdrushDependencyTree\Domain\Model;

class Extension
{
    /**
     * @var string
     */
    protected $key;

    /**
     * @var string
     */
    protected $name;

    /**
     * @var Constraint[]
     */
    protected $dependencies = array();

    /**
     * @var Constraint[]
     */
    protected $conflicts = array();

    /**
     * @var Constraint[]
     */
    protected $suggestions = array();

    /**
     * @return string
     */
    public function getKey()
    {
        return $this->key;
    }

    /**
     * @param string $key
     * @return Extension
     */
    public function setKey($key)
    {
        $this->key = $key;
        return $this;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $name
     * @return Extension
     */
    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return Constraint[]
     */
    public function getDependencies()
    {
        return $this->dependencies;
    }

    /**
     * @param Constraint $constraint
     * @return Extension
     */
    public function addDependency($constraint)
    {
        $this->dependencies[] = $constraint;
        return $this;
    }

    /**
     * @param Constraint[] $dependencies
     * @return Extension
     */
    public function setDependencies($dependencies)
    {
        $this->dependencies = $dependencies;
        return $this;
    }

    /**
     * @return Constraint[]
     */
    public function getConflicts()
    {
        return $this->conflicts;
    }

    /**
     * @param Constraint $constraint
     * @return Extension
     */
    public function addConflict($constraint)
    {
        $this->conflicts[] = $constraint;
        return $this;
    }

    /**
     * @param Constraint[] $conflicts
     * @return Extension
     */
    public function setConflicts($conflicts)
    {
        $this->conflicts = $conflicts;
        return $this;
    }

    /**
     * @return Constraint[]
     */
    public function getSuggestions()
    {
        return $this->suggestions;
    }

    /**
     * @param Constraint $constraint
     * @return Extension
     */
    public function addSuggestion($constraint)
    {
        $this->suggestions[] = $constraint;
        return $this;
    }

    /**
     * @param Constraint[] $suggestions
     * @return Extension
     */
    public function setSuggestions($suggestions)
    {
        $this->suggestions = $suggestions;
        return $this;
    }

}
